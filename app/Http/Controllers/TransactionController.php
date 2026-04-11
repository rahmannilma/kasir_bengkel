<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Mechanic;
use App\Models\MechanicSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['customer', 'user']);

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->latest()->paginate(20);

        // Load mechanics for each transaction
        foreach ($transactions as $transaction) {
            $transaction->setRelation('mechanics', $transaction->mechanics);
        }

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'user', 'mechanic', 'items']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function store(Request $request)
    {
        // Sanitize input: convert empty strings to null and strip thousand separators
        $input = $request->all();
        foreach (['customer_id', 'mechanic_id', 'cash_received', 'discount'] as $field) {
            if (isset($input[$field])) {
                if ($input[$field] === '') {
                    $input[$field] = null;
                } elseif ($field === 'cash_received' || $field === 'discount') {
                    $input[$field] = str_replace('.', '', $input[$field]);
                }
            }
        }
        $request->merge($input);

        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_plate' => 'nullable|string|max:20',
            'customer_id' => 'nullable|exists:customers,id',
            'mechanic_ids' => 'nullable|array',
            'mechanic_ids.*' => 'exists:mechanics,id',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|in:product,service',
            'items.*.id' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer,debit,qris',
            'cash_received' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $items = $request->items;
            $subtotal = 0;

            // Validate stock and calculate subtotal
            foreach ($items as $item) {
                if ($item['type'] === 'product') {
                    $product = Product::find($item['id']);
                    if (!$product || $product->stock < $item['quantity']) {
                        DB::rollBack();
                        return back()->with('error', 'Stok produk "' . ($product->name ?? 'Unknown') . '" tidak mencukupi');
                    }
                    // Use custom price if provided, otherwise use database price
                    $price = isset($item['price']) && $item['price'] > 0 ? $item['price'] : $product->selling_price;
                    $itemName = $product->name;
                } else {
                    // Check if manual service (ID starts with manual_)
                    if (str_starts_with($item['id'], 'manual_')) {
                        // Manual service - get price from the item data
                        $price = $item['price'] ?? 0;
                        $itemName = $item['name'] ?? 'Jasa Manual';
                        $itemId = null; // No database record
                    } else {
                        $service = Service::find($item['id']);
                        if (!$service) {
                            DB::rollBack();
                            return back()->with('error', 'Jasa tidak ditemukan');
                        }
                        // Use custom price if provided, otherwise use database price
                        $price = isset($item['price']) && $item['price'] > 0 ? $item['price'] : $service->price;
                        $itemName = $service->name;
                        $itemId = $service->id;
                    }
                }
                $subtotal += $price * $item['quantity'];
            }

            $discount = $request->discount ?? 0;
            $tax = 0;
            $total = $subtotal - $discount + $tax;

            // Calculate change for cash payments
            $change = 0;
            $cashReceived = $request->cash_received ? (float) $request->cash_received : null;
            if ($request->payment_method === 'cash' && $cashReceived) {
                if ($cashReceived < $total) {
                    DB::rollBack();
                    return back()->with('error', 'Jumlah pembayaran kurang dari total');
                }
                $change = $cashReceived - $total;
            }

            // Create or find customer
            $customerId = $request->customer_id ?: null;
            
            if ($request->customer_name || $request->customer_plate) {
                $customer = Customer::create([
                    'name' => $request->customer_name ?: 'Pelanggan Baru',
                    'vehicle_plate' => $request->customer_plate ?: null,
                ]);
                $customerId = $customer->id;
            }
            
            // Create transaction
            $mechanicIds = $request->filled('mechanic_ids') && is_array($request->mechanic_ids) 
                ? array_map('intval', $request->mechanic_ids) 
                : [];
                
            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'customer_id' => $customerId,
                'mechanic_ids' => $mechanicIds,
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'cash_received' => $cashReceived,
                'change' => $change,
                'status' => 'completed',
                'notes' => $request->notes,
            ]);

            // Create transaction items and update stock
            foreach ($items as $item) {
                if ($item['type'] === 'product') {
                    $product = Product::find($item['id']);
                    // Use custom price if provided, otherwise use database price
                    $price = isset($item['price']) && $item['price'] > 0 ? $item['price'] : $product->selling_price;
                    $itemName = $product->name;
                    $itemId = $product->id;
                    $product->decrement('stock', $item['quantity']);
                } else {
                    // Check if manual service
                    if (str_starts_with($item['id'], 'manual_')) {
                        $price = $item['price'] ?? 0;
                        $itemName = $item['name'] ?? 'Jasa Manual';
                        $itemId = null;
                    } else {
                        $service = Service::find($item['id']);
                        // Use custom price if provided, otherwise use database price
                        $price = isset($item['price']) && $item['price'] > 0 ? $item['price'] : $service->price;
                        $itemName = $service->name;
                        $itemId = $service->id;
                    }
                }

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'item_type' => $item['type'],
                    'item_id' => $itemId,
                    'item_name' => $itemName,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $price * $item['quantity'],
                ]);
            }

            DB::commit();

            // Record mechanic salaries automatically
            if (!empty($mechanicIds) && $transaction->items->where('item_type', 'service')->isNotEmpty()) {
                $serviceAmount = $transaction->items->where('item_type', 'service')->sum('subtotal');
                $mechanicCount = count($mechanicIds);
                $servicePerMechanic = $serviceAmount / $mechanicCount;
                
                foreach ($mechanicIds as $mechanicId) {
                    $mechanic = Mechanic::find($mechanicId);
                    if ($mechanic) {
                        $commissionRate = $mechanic->commission_rate ?? 10;
                        $commissionAmount = $servicePerMechanic * ($commissionRate / 100);
                        
                        MechanicSalary::create([
                            'mechanic_id' => $mechanicId,
                            'transaction_id' => $transaction->id,
                            'service_amount' => $servicePerMechanic,
                            'commission_rate' => $commissionRate,
                            'commission_amount' => $commissionAmount,
                            'period_start' => now()->startOfMonth(),
                            'period_end' => now()->endOfMonth(),
                            'status' => 'pending',
                        ]);
                    }
                }
            }

            // Load relationships and return receipt view
            $transaction->load(['customer', 'user', 'mechanic', 'items']);
            return view('kasir.receipt', compact('transaction'))->with('success', 'Transaksi berhasil');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function printReceipt(Transaction $transaction)
    {
        $transaction->load(['customer', 'user', 'mechanic', 'items']);
        return view('kasir.receipt', compact('transaction'));
    }

    public function void(Transaction $transaction)
    {
        if ($transaction->status === 'cancelled') {
            return back()->with('error', 'Transaksi sudah dibatalkan');
        }

        DB::beginTransaction();
        try {
            // Restore stock
            foreach ($transaction->items as $item) {
                if ($item->item_type === 'product') {
                    Product::find($item->item_id)?->increment('stock', $item->quantity);
                }
            }

            $transaction->update(['status' => 'cancelled']);
            DB::commit();

            return back()->with('success', 'Transaksi berhasil dibatalkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan');
        }
    }
}
