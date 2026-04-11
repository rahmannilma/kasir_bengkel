<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function index(Request $request)
    {
        $query = Mechanic::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('specialization', 'like', '%' . $request->search . '%');
            });
        }

        if (request('status') === 'active') {
            $query->where('is_active', true);
        } elseif (request('status') === 'inactive') {
            $query->where('is_active', false);
        }

        $mechanics = $query->with('salaries')->orderBy('name')->paginate(20);

        return view('admin.mechanics.index', compact('mechanics'));
    }

    public function create()
    {
        return view('admin.mechanics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
        ]);

        Mechanic::create($request->all());

        return redirect()->route('admin.mechanics.index')
            ->with('success', 'Mekanik berhasil ditambahkan');
    }

    public function edit(Mechanic $mechanic)
    {
        return view('admin.mechanics.edit', compact('mechanic'));
    }

    public function update(Request $request, Mechanic $mechanic)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $mechanic->update($request->all());

        return redirect()->route('admin.mechanics.index')
            ->with('success', 'Mekanik berhasil diperbarui');
    }

    public function destroy(Mechanic $mechanic)
    {
        $mechanic->delete();

        return redirect()->route('admin.mechanics.index')
            ->with('success', 'Mekanik berhasil dihapus');
    }
}
