<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'shop_name' => Setting::get('shop_name', 'BENGKEL MOBIL'),
            'shop_address' => Setting::get('shop_address', 'Jl. Raya Bengkel No. 123'),
            'shop_phone' => Setting::get('shop_phone', '0812-3456-7890'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'required|string|max:500',
            'shop_phone' => 'required|string|max:50',
        ]);

        Setting::set('shop_name', $request->shop_name);
        Setting::set('shop_address', $request->shop_address);
        Setting::set('shop_phone', $request->shop_phone);

        return back()->with('success', 'Pengaturan berhasil disimpan');
    }
}
