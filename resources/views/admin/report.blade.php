@extends('admin.layouts.pp')

@section('title','Laporan')
@section('page-title','Laporan Penjualan')

@section('content')

<div class="bg-white/10 backdrop-blur-xl border border-white/10
    rounded-2xl p-6 shadow-xl">

    <h4 class="text-xl font-semibold mb-4 flex items-center gap-2">
        <i class="fa-solid fa-chart-line text-indigo-400"></i>
        Ringkasan Laporan Penjualan
    </h4>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-300 border-b border-white/10">
                    <th class="py-3">Tanggal</th>
                    <th>Total Pesanan</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                    <td class="py-3 font-medium">
                        {{ $report->date }}
                    </td>
                    <td>
                        {{ $report->total_orders }}
                    </td>
                    <td class="text-green-400 font-semibold">
                        Rp {{ number_format($report->total_revenue) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
