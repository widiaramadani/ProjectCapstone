@extends('admin.layouts.pp')

@section('title','Dashboard Admin')
@section('page-title','Dashboard Penjualan')

@section('content')

<!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- Total Pesanan -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/10
                rounded-2xl p-6 shadow-xl transition hover:scale-[1.02]">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 flex items-center justify-center
                        rounded-xl bg-indigo-500/20 text-indigo-400 text-2xl">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div>
                <p class="text-sm text-gray-300 mb-1">Total Pesanan</p>
                <h3 class="text-3xl font-bold text-white">
                    {{ $totalOrders }}
                </h3>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/10
                rounded-2xl p-6 shadow-xl transition hover:scale-[1.02]">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 flex items-center justify-center
                        rounded-xl bg-green-500/20 text-green-400 text-2xl">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <p class="text-sm text-gray-300 mb-1">Total Pendapatan</p>
                <h3 class="text-3xl font-bold text-white">
                    Rp {{ number_format($totalRevenue) }}
                </h3>
            </div>
        </div>
    </div>

</div>


<!-- Pesanan Terbaru -->
<div class="bg-white/10 backdrop-blur-xl border border-white/10
            rounded-2xl p-6 shadow-xl">

    <h4 class="text-xl font-semibold mb-4 flex items-center gap-2">
        <i class="fa-solid fa-clock-rotate-left text-indigo-400"></i>
        Pesanan Terbaru
    </h4>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-300 border-b border-white/10">
                    <th class="py-3">Nama</th>
                    <th>No HP</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestOrders as $order)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-3 font-medium">
                            {{ $order->buyer_name }}
                        </td>
                        <td>
                            {{ $order->phone }}
                        </td>
                        <td class="text-green-400 font-semibold">
                            Rp {{ number_format($order->total_price) }}
                        </td>
                        <td class="text-gray-300">
                            {{ $order->created_at->format('d-m-Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
