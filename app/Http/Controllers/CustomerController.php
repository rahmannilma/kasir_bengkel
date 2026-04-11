<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'vehicle_plate' => 'nullable|string|max:20',
            'vehicle_brand' => 'nullable|string|max:100',
            'vehicle_type' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $customer = Customer::create($request->all());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($customer);
        }

        return redirect()->back()->with('success', 'Pelanggan berhasil ditambahkan');
    }
}
