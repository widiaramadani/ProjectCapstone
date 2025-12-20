@extends('admin.layouts.pp')

@section('title','Detail Pembelian')
@section('page-title','Detail Pembelian')

@section('content')

<div class="bg-white/10 backdrop-blur-xl border border-white/10
    rounded-2xl p-6 shadow-xl">

    <h4 class="text-xl font-semibold mb-4 flex items-center gap-2">
        <i class="fa-solid fa-cart-shopping text-indigo-400"></i>
        Detail Pembelian
    </h4>

    {{-- ================= INFORMASI PEMBELI ================= --}}
    <div class="overflow-x-auto mb-6">
        <table class="min-w-full text-sm">
            <tbody>
                <tr class="border-b border-white/5">
                    <td class="py-3 text-gray-300 w-1/4">Nama Pembeli</td>
                    <td class="font-medium">{{ $order->buyer_name }}</td>
                </tr>
                <tr class="border-b border-white/5">
                    <td class="py-3 text-gray-300">No HP</td>
                    <td>{{ $order->phone }}</td>
                </tr>
                <tr class="border-b border-white/5">
                    <td class="py-3 text-gray-300">Alamat Lengkap</td>
                    <td>{{ $order->address }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ================= DETAIL PRODUK ================= --}}
    <h6 class="fw-semibold mb-3">Detail Produk Pesanan</h6>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-300 border-b border-white/10">
                    <th width="5%">No</th>
                    <th>Nama Produk</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Subtotal</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $total = 0;
                    $statusClass = match($order->status) {
                        'acc' => 'success',
                        'pending' => 'warning',
                        'ditolak' => 'danger',
                        default => 'secondary'
                    };
                @endphp

                @foreach ($order->items as $index => $item)
                    @php
                        $subtotal = $item->quantity * $item->price;
                        $total += $subtotal;
                    @endphp
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td>{{ $index + 1 }}</td>
                        <td class="font-medium">{{ $item->product_name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="text-end text-green-400 font-semibold">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <span class="inline-block px-3 py-1 rounded-lg text-xs
                                bg-{{ $statusClass }}/20 text-{{ $statusClass }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ================= TOTAL ================= --}}
    <div class="flex justify-end mt-4 pt-4 border-t border-white/10">
        <div class="text-right">
            <div class="text-gray-300 text-sm">Total Pembayaran</div>
            <div class="text-green-400 text-lg font-semibold">
                Rp {{ number_format($order->total_price ?? $total, 0, ',', '.') }}
            </div>
        </div>
    </div>

    {{-- ================= AKSI ================= --}}
    @if($order->status === 'pending')
    <div class="flex gap-3 mt-6">
        <form action="{{ route('admin.orders.acc', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button class="px-4 py-2 bg-green-500/20 text-green-300
                rounded-lg hover:bg-green-500 hover:text-white transition">
                ACC Pesanan
            </button>
        </form>

        <form action="{{ route('admin.orders.reject', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button class="px-4 py-2 bg-red-500/20 text-red-300
                rounded-lg hover:bg-red-500 hover:text-white transition">
                Tolak Pesanan
            </button>
        </form>
    </div>
    @endif

    {{-- ================= KEMBALI ================= --}}
    <div class="mt-6">
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2
           bg-gray-500/20 text-gray-300 rounded-lg
           hover:bg-gray-500 hover:text-white transition">
            ← Kembali
        </a>
    </div>

</div>

@endsection
