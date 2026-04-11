<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%')
                  ->orWhere('part_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->stock_filter === 'low') {
            $query->lowStock();
        } elseif ($request->stock_filter === 'out') {
            $query->where('stock', 0);
        }

        $products = $query->orderBy('name')->paginate(20);
        $categories = Category::product()->orderBy('name')->get();
        $allCategories = Category::where('type', 'product')->orderBy('name')->get();

        $lowStockCount = Product::lowStock()->count();
        $outOfStockCount = Product::where('stock', 0)->count();

        return view('admin.products.index', compact('products', 'categories', 'allCategories', 'lowStockCount', 'outOfStockCount'));
    }

    public function create()
    {
        $categories = Category::product()->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
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

    public function edit(Product $product)
    {
        $categories = Category::product()->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code' => 'required|unique:products,code,' . $product->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
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
        $query = Product::with('category.distributor')->lowStock();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('stock')->paginate(20);
        $categories = Category::product()->orderBy('name')->get();

        return view('admin.products.low-stock', compact('products', 'categories'));
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