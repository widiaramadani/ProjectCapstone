@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>
    <p class="text-gray-600 mb-6">Selamat datang kembali, {{ Auth::user()->name }} 👋</p>

    <!-- GRID KARTU -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Card 1 -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-gray-500 text-sm">Total User</h2>
            <p class="text-3xl font-bold mt-2">{{ $total_user }}</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-gray-500 text-sm">Total Produk</h2>
            <p class="text-3xl font-bold mt-2">{{ $total_produk }}</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-gray-500 text-sm">Total Purchase Order</h2>
            <p class="text-3xl font-bold mt-2">{{ $total_po }}</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-gray-500 text-sm">Total Customer</h2>
            <p class="text-3xl font-bold mt-2">{{ $total_customer }}</p>
        </div>

    </div>

    <!-- Tabel Data -->
    <div class="mt-10 bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Data Terbaru</h2>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border">No</th>
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">Email</th>
                    <th class="p-3 border">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\User::latest()->limit(5)->get() as $user)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border">{{ $loop->iteration }}</td>
                    <td class="p-3 border">{{ $user->name }}</td>
                    <td class="p-3 border">{{ $user->email }}</td>
                    <td class="p-3 border">{{ $user->role ?? 'user' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>
@endsection
