<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Distributor;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with('distributor');

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('type')->orderBy('name')->paginate(20);
        $distributors = Distributor::orderBy('name')->get();

        return view('admin.categories.index', compact('categories', 'distributors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:product,service',
            'distributor_id' => 'nullable|exists:distributors,id',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:product,service',
            'distributor_id' => 'nullable|exists:distributors,id',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0 || $category->services()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk/jasa');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
