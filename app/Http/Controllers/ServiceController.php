<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with('category');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $services = $query->orderBy('name')->paginate(20);
        $categories = Category::service()->orderBy('name')->get();

        $allCategories = Category::where('type', 'service')->orderBy('name')->get();

        return view('admin.services.index', compact('services', 'categories', 'allCategories'));
    }

    public function create()
    {
        $categories = Category::service()->orderBy('name')->get();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'estimated_time' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $service = Service::create($request->all());

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'id' => $service->id,
                'name' => $service->name,
                'price' => $service->price,
                'estimated_time' => $service->estimated_time,
                'description' => $service->description,
            ], 201);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Jasa berhasil ditambahkan');
    }

    public function edit(Service $service)
    {
        $categories = Category::service()->orderBy('name')->get();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'estimated_time' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $service->update($request->all());

        return redirect()->route('admin.services.index')
            ->with('success', 'Jasa berhasil diperbarui');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Jasa berhasil dihapus');
    }
}
