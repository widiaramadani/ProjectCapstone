@extends('admin.layouts.pp')

@section('title','Data Pembelian')
@section('page-title','Data Pembelian')

@section('content')

<div class="bg-white/10 backdrop-blur-xl border border-white/10
    rounded-2xl p-6 shadow-xl">

    <h4 class="text-xl font-semibold mb-4 flex items-center gap-2">
        <i class="fa-solid fa-cart-shopping text-indigo-400"></i>
        Daftar Pembelian
    </h4>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-300 border-b border-white/10">
                    <th class="py-3">Nama Pembeli</th>
                    <th>No HP</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
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
                    <td class="text-center">
                        <a href="{{ route('admin.orders.show', $order->id) }}"
                           class="inline-flex items-center gap-2 px-3 py-2
                           bg-indigo-500/20 text-indigo-300 rounded-lg
                           hover:bg-indigo-500 hover:text-white transition">
                            <i class="fa-solid fa-eye"></i>
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
