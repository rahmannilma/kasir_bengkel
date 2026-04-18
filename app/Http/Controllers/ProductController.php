<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('code', 'like', '%'.$request->search.'%')
                    ->orWhere('brand', 'like', '%'.$request->search.'%')
                    ->orWhere('part_number', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->jenis) {
            if ($request->jenis === 'Sparepart') {
                $query->whereNotIn('jenis', ['Aki', 'Ban Luar', 'Ban Dalam', 'Oli']);
            } else {
                $query->where('jenis', $request->jenis);
            }
        }

        if ($request->stock_filter === 'low') {
            $query->lowStock();
        } elseif ($request->stock_filter === 'out') {
            $query->where('stock', 0);
        }

        $products = $query->orderBy('name')->paginate(40);
        $allJenis = Product::distinct()->pluck('jenis')->filter()->sort();
        $allBrands = Product::distinct()->pluck('brand')->filter()->sort();

        $lowStockCount = Product::lowStock()->count();
        $outOfStockCount = Product::where('stock', 0)->count();

        return view('admin.products.index', compact('products', 'allJenis', 'allBrands', 'lowStockCount', 'outOfStockCount'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required|string|max:255',
            'jenis' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'part_number' => 'nullable|string|max:100',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if (! in_array($extension, ['xlsx', 'xls'])) {
            return back()->with('error', 'File harus format Excel (.xlsx atau .xls)');
        }

        require_once base_path('vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php');

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (count($rows) < 2) {
                return back()->with('error', 'File Excel kosong');
            }

            $header = array_map('strtolower', array_map('trim', $rows[0]));

            $codeIdx = array_search('kode', $header);
            $nameIdx = array_search('nama', $header);
            $jenisIdx = array_search('jenis', $header);
            $brandIdx = array_search('merek', $header);
            $partIdx = array_search('part_number', $header);
            $purchaseIdx = array_search('harga_beli', $header);
            $sellingIdx = array_search('harga_jual', $header);
            $stockIdx = array_search('stok', $header);
            $minStockIdx = array_search('stok_minimum', $header);
            $descIdx = array_search('deskripsi', $header);

            if ($codeIdx === false || $nameIdx === false || $purchaseIdx === false || $sellingIdx === false || $stockIdx === false || $minStockIdx === false) {
                return back()->with('error', 'Kolom wajib tidak ada. Header: '.implode(', ', $header));
            }

            $existingCodes = Product::pluck('code')->toArray();

            $created = 0;
            $updated = 0;
            $skipped = 0;

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $code = isset($row[$codeIdx]) ? trim($row[$codeIdx]) : '';
                $name = isset($row[$nameIdx]) ? trim($row[$nameIdx]) : '';

                if (empty($code) || empty($name)) {
                    $skipped++;

                    continue;
                }

                $data = [
                    'code' => $code,
                    'name' => $name,
                    'jenis' => ($jenisIdx !== false && isset($row[$jenisIdx]) && ! empty(trim($row[$jenisIdx]))) ? trim($row[$jenisIdx]) : null,
                    'brand' => ($brandIdx !== false && isset($row[$brandIdx])) ? trim($row[$brandIdx]) : null,
                    'part_number' => ($partIdx !== false && isset($row[$partIdx])) ? trim($row[$partIdx]) : null,
                    'purchase_price' => ($purchaseIdx !== false && isset($row[$purchaseIdx])) ? floatval($row[$purchaseIdx]) : 0,
                    'selling_price' => ($sellingIdx !== false && isset($row[$sellingIdx])) ? floatval($row[$sellingIdx]) : 0,
                    'stock' => ($stockIdx !== false && isset($row[$stockIdx])) ? intval($row[$stockIdx]) : 0,
                    'min_stock' => ($minStockIdx !== false && isset($row[$minStockIdx])) ? intval($row[$minStockIdx]) : 0,
                    'description' => ($descIdx !== false && isset($row[$descIdx])) ? trim($row[$descIdx]) : null,
                ];

                if (in_array($code, $existingCodes)) {
                    Product::where('code', $code)->update(array_filter($data, fn ($v) => $v !== null));
                    $updated++;
                } else {
                    Product::create($data);
                    $existingCodes[] = $code;
                    $created++;
                }
            }

            return back()->with('success', "Berhasil: $created produk baru, $updated diperbarui, $skipped dilewati");
        } catch (\Exception $e) {
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code' => 'required|unique:products,code,'.$product->id,
            'name' => 'required|string|max:255',
            'jenis' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'part_number' => 'nullable|string|max:100',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    public function lowStock(Request $request)
    {
        $query = Product::lowStock();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('code', 'like', '%'.$request->search.'%');
            });
        }

        $products = $query->orderBy('stock')->paginate(20);

        return view('admin.products.low-stock', compact('products'));
    }

    public function stockAdjustment(Request $request, Product $product)
    {
        $request->validate([
            'type' => 'required|in:add,reduce',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        if ($request->type === 'add') {
            $product->increment('stock', $request->quantity);
        } else {
            if ($product->stock < $request->quantity) {
                return back()->with('error', 'Stok tidak mencukupi');
            }
            $product->decrement('stock', $request->quantity);
        }

        return back()->with('success', 'Stok berhasil disesuaikan');
    }
}
