@extends('layouts.admin')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="px-6 py-4">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Transaksi</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola seluruh transaksi pelanggan</p>
    </div>

    <!-- Statistik -->
    @php
        $pending = $transaksi->where('status_pengiriman','pending')->count();
        $processing = $transaksi->where('status_pengiriman','processing')->count();
        $shipped = $transaksi->where('status_pengiriman','shipped')->count();
        $delivered = $transaksi->where('status_pengiriman','delivered')->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow flex items-center gap-4">
            <div class="bg-yellow-400 text-white p-3 rounded-lg">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-semibold">{{ $pending }}</p>
                <p class="text-gray-600 text-sm">Menunggu ACC</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex items-center gap-4">
            <div class="bg-blue-500 text-white p-3 rounded-lg">
                <i class="fas fa-sync-alt text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-semibold">{{ $processing }}</p>
                <p class="text-gray-600 text-sm">Diproses</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex items-center gap-4">
            <div class="bg-purple-500 text-white p-3 rounded-lg">
                <i class="fas fa-truck text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-semibold">{{ $shipped }}</p>
                <p class="text-gray-600 text-sm">Dikirim</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex items-center gap-4">
            <div class="bg-green-500 text-white p-3 rounded-lg">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-semibold">{{ $delivered }}</p>
                <p class="text-gray-600 text-sm">Selesai</p>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Daftar Transaksi</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b bg-gray-100 text-left">
                        <th class="p-3">No</th>
                        <th class="p-3">No. PO</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Customer</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Status Pengiriman</th>
                        <th class="p-3">Pembayaran</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $i => $row)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $i+1 }}</td>
                        <td class="p-3 font-semibold">{{ $row->no_po }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($row->tanggal_po)->format('d/m/Y') }}</td>
                        <td class="p-3">{{ $row->customer->nama ?? '-' }}</td>
                        <td class="p-3 font-semibold">Rp {{ number_format($row->grand_total,0,',','.') }}</td>

                        <!-- Status Badge -->
                        <td class="p-3">
                            @php
                                $badge = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'processing' => 'bg-blue-100 text-blue-700',
                                    'shipped' => 'bg-purple-100 text-purple-700',
                                    'delivered' => 'bg-green-100 text-green-700',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badge[$row->status_pengiriman] ?? '' }}">
                                {{ ucfirst($row->status_pengiriman) }}
                            </span>
                        </td>

                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                {{ $row->status_pembayaran=='paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $row->status_pembayaran=='paid'?'Lunas':'Belum' }}
                            </span>
                        </td>

                        <td class="p-3">
                            <div class="flex gap-2">
                                <button onclick="lihatDetail({{ $row->id }})"
                                    class="px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                    Detail
                                </button>

                                @if($row->status_pengiriman == 'pending')
                                <form method="POST" action="{{ route('admin.transaksi.acc',$row->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">
                                        ACC
                                    </button>
                                </form>
                                @endif

                                @if($row->status_pengiriman == 'processing')
                                <form method="POST" action="{{ route('admin.transaksi.kirim',$row->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-purple-500 text-white text-xs rounded hover:bg-purple-600">
                                        Kirim
                                    </button>
                                </form>
                                @endif

                                @if($row->status_pengiriman == 'shipped')
                                <form method="POST" action="{{ route('admin.transaksi.selesai',$row->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">
                                        Selesai
                                    </button>
                                </form>
                                @endif

                                @if(in_array($row->status_pengiriman,['pending','processing']))
                                <form method="POST" action="{{ route('admin.transaksi.batal',$row->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">
                                        Batal
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center p-6 text-gray-500">Tidak ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>


<!-- MODAL DETAIL -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
    <div class="bg-white w-full max-w-xl p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Detail Transaksi</h3>

        <div id="detailContent" class="text-sm text-gray-700">
            Memuat...
        </div>

        <div class="text-right mt-4">
            <button onclick="closeModal()"
                class="px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function lihatDetail(id){
    document.getElementById('modalDetail').classList.remove('hidden');
    document.getElementById('detailContent').innerHTML = "Memuat...";

    fetch(`/admin/transaksi/detail/${id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('detailContent').innerHTML = `
                <p><strong>No. PO:</strong> ${data.no_po}</p>
                <p><strong>Tanggal:</strong> ${data.tanggal_po}</p>
                <p><strong>Customer:</strong> ${data.customer.nama}</p>
                <p class="mt-3 font-semibold">Items:</p>
                <ul class="list-disc ml-6">
                    ${data.details.map(i => `<li>${i.produk.nama_produk} (${i.qty})</li>`).join('')}
                </ul>
                <p class="mt-3"><strong>Total:</strong> Rp ${data.grand_total.toLocaleString('id-ID')}</p>
            `;
        });
}

function closeModal(){
    document.getElementById('modalDetail').classList.add('hidden');
}
</script>

@endsection
