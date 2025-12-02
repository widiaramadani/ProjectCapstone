@extends('app')

@section('title', 'Produk Makanan')

@section('content')
<div class="content">
    <div class="page-header">
        <h1 class="page-title">Produk Makanan</h1>
        <div class="breadcrumb">
            <i class="fas fa-home"></i>
            <a href="{{ route('admin.dashboardadmin') }}">Home</a>
            <span>></span>
            <span>Produk Makanan</span>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-box"></i> Daftar Produk</h3>
            <button class="btn btn-primary" onclick="openModal('tambahModal')">
                <i class="fas fa-plus"></i> Tambah Produk
            </button>
        </div>

        <div class="card-body">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $index => $row)
                        @php
                            $stok_status = $row->stok > 10 ? 'success' : ($row->stok > 0 ? 'warning' : 'danger');
                            $stok_text = $row->stok > 10 ? 'Tersedia' : ($row->stok > 0 ? 'Terbatas' : 'Habis');
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->kode }}</td>
                            <td>{{ $row->nama_produk }}</td>
                            <td>{{ $row->nama_kategori ?? '-' }}</td>
                            <td>Rp {{ number_format($row->harga, 0, ',', '.') }}</td>
                            <td>{{ $row->stok }} {{ $row->satuan }}</td>
                            <td><span class="badge badge-{{ $stok_status }}">{{ $stok_text }}</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-success btn-sm" onclick="openRestockModal({{ $row->id }}, '{{ addslashes($row->nama_produk) }}', {{ $row->stok }})">
                                        <i class="fas fa-plus"></i> Restock
                                    </button>

                                    <button class="btn btn-warning btn-sm" onclick='openEditModal(@json($row))'>
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('admin.produk.delete', $row->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:40px;">Tidak ada data produk</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div id="tambahModal" class="modal">
    <div class="modal-content">
        <div class="modal-header"><h3 class="modal-title">Tambah Produk Baru</h3>
            <button class="close" onclick="closeModal('tambahModal')">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Produk *</label>
                    <input type="text" name="kode" required placeholder="Contoh: PRD001">
                </div>
                <div class="form-group">
                    <label>Nama Produk *</label>
                    <input type="text" name="nama_produk" required placeholder="Contoh: Nopia Coklat">
                </div>
                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga (Rp) *</label>
                    <input type="number" name="harga" step="100" required placeholder="15000">
                </div>
                <div class="form-group">
                    <label>Stok Awal *</label>
                    <input type="number" name="stok" required placeholder="100">
                </div>
                <div class="form-group">
                    <label>Satuan *</label>
                    <select name="satuan" required>
                        <option value="pcs">Pcs</option>
                        <option value="porsi">Porsi</option>
                        <option value="kg">Kg</option>
                        <option value="box">Box</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Gambar Produk</label>
                    <input type="file" name="gambar" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" placeholder="Deskripsi produk..."></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="closeModal('tambahModal')">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header"><h3 class="modal-title">Edit Produk</h3>
            <button class="close" onclick="closeModal('editModal')">&times;</button>
        </div>

        <form method="POST" id="editForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label>Nama Produk *</label>
                    <input type="text" name="nama_produk" id="edit_nama" required>
                </div>
                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="kategori_id" id="edit_kategori" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga (Rp) *</label>
                    <input type="number" name="harga" id="edit_harga" step="100" required>
                </div>
                <div class="form-group">
                    <label>Stok *</label>
                    <input type="number" name="stok" id="edit_stok" required>
                </div>
                <div class="form-group">
                    <label>Satuan *</label>
                    <select name="satuan" id="edit_satuan" required>
                        <option value="pcs">Pcs</option>
                        <option value="porsi">Porsi</option>
                        <option value="kg">Kg</option>
                        <option value="box">Box</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Gambar Produk (jika ingin ganti)</label>
                    <input type="file" name="gambar" accept="image/*">
                    <div id="current_image" style="margin-top:10px;"></div>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Restock -->
<div id="restockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header"><h3 class="modal-title">Restock Produk</h3>
            <button class="close" onclick="closeModal('restockModal')">&times;</button>
        </div>

        <form method="POST" id="restockForm">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" id="restock_id">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" id="restock_nama" readonly style="background-color:#f5f5f5">
                </div>
                <div class="form-group">
                    <label>Stok Saat Ini</label>
                    <input type="text" id="restock_stok_current" readonly style="background-color:#f5f5f5">
                </div>
                <div class="form-group">
                    <label>Tambah Stok *</label>
                    <input type="number" name="tambah_stok" id="restock_tambah" required min="1">
                </div>
                <div class="form-group">
                    <label>Stok Setelah Restock</label>
                    <input type="text" id="restock_stok_new" readonly style="background-color:#e8f5e9; font-weight:bold;">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="closeModal('restockModal')">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.add('show');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('show');
}

/* Edit modal - set form action & populate fields */
function openEditModal(row) {
    openModal('editModal');

    const form = document.getElementById('editForm');
    form.action = "/admin/produk-makanan/" + row.id + "/update";

    document.getElementById('edit_id').value = row.id;
    document.getElementById('edit_nama').value = row.nama_produk;
    document.getElementById('edit_kategori').value = row.kategori_id ?? '';
    document.getElementById('edit_harga').value = row.harga;
    document.getElementById('edit_stok').value = row.stok;
    document.getElementById('edit_satuan').value = row.satuan;
    document.getElementById('edit_deskripsi').value = row.deskripsi ?? '';

    if (row.gambar) {
        document.getElementById('current_image').innerHTML = '<img src="{{ asset("storage/uploads/produk") }}/'+row.gambar+'" width="90">';
    } else {
        document.getElementById('current_image').innerHTML = '';
    }
}

/* Restock modal */
function openRestockModal(id, nama, stok) {
    openModal('restockModal');
    document.getElementById('restockForm').action = "/admin/produk-makanan/" + id + "/restock";
    document.getElementById('restock_id').value = id;
    document.getElementById('restock_nama').value = nama;
    document.getElementById('restock_stok_current').value = stok;
    document.getElementById('restock_tambah').value = '';
    document.getElementById('restock_stok_new').value = '';
}

document.getElementById('restock_tambah')?.addEventListener('input', function(){
    const cur = parseInt(document.getElementById('restock_stok_current').value) || 0;
    const add = parseInt(this.value) || 0;
    document.getElementById('restock_stok_new').value = cur + add;
});
</script>
@endsection
