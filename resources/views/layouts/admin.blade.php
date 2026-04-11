@extends('layouts.app')

@section('title', 'Admin - Bengkel POS')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white min-h-screen">
        <div class="p-4">
            <div class="flex items-center space-x-2 mb-8">
                <i class="fas fa-wrench text-2xl"></i>
                <span class="font-bold text-xl">Bengkel POS</span>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.transactions.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-receipt"></i>
                    <span>Transaksi</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-box"></i>
                    <span>Sparepart</span>
                </a>
                <a href="{{ route('admin.products.low-stock') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.products.low-stock') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    <span>Stok Menipis</span>
                </a>
<a href="{{ route('admin.services.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.services.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tools"></i>
                    <span>Jasa</span>
                </a>
                <a href="{{ route('admin.mechanics.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.mechanics.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-user-hard-hat"></i>
                    <span>Mekanik</span>
                </a>
                <div class="border-t border-gray-700 my-4"></div>
                <a href="{{ route('admin.reports.sales') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>User Management</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        @yield('admin_content')
    </main>
</div>
@endsection
