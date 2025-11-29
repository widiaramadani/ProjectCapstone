@extends('admin.layout.main')

@section('content')
<style>
</style>

<div class="topbar">
    <div>Laporan User</div>
    <div class="topbar-user">
        <i class="fas fa-user-circle"></i>
        <span>{{ $admin_nama }}</span>
    </div>
</div>

<div class="content">

    <div class="page-header">
        <h1 class="page-title">Laporan & Masukan User</h1>
        <div class="breadcrumb">
            <i class="fas fa-home"></i>
            <a href="{{ route('admin.dashboard') }}">Home</a>
            <span>></span>
            <span>Laporan</span>
        </div>
    </div>

    {{-- Alert --}}
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

    {{-- Statistik --}}
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-icon total"><i class="fas fa-inbox"></i></div>
            <div class="stat-info">
                <h3>{{ $total_laporan }}</h3><p>Total Laporan</p>
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-icon baru"><i class="fas fa-bell"></i></div>
            <div class="stat-info">
                <h3>{{ $laporan_baru }}</h3><p>Laporan Baru</p>
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-icon dibaca"><i class="fas fa-eye"></i></div>
            <div class="stat-info">
                <h3>{{ $laporan_dibaca }}</h3><p>Sudah Dibaca</p>
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-icon dibalas"><i class="fas fa-reply"></i></div>
            <div class="stat-info">
                <h3>{{ $laporan_dibalas }}</h3><p>Sudah Dibalas</p>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-comments"></i> Daftar Laporan</h3>

            <div style="display:flex;gap:15px;flex-wrap:wrap;">

                {{-- Filter --}}
                <div class="filter-group">
                    <a href="?filter=semua" class="filter-btn {{ $filter=='semua'?'active':'' }}">
                        <i class="fas fa-list"></i> Semua
                    </a>

                    <a href="?filter=baru" class="filter-btn {{ $filter=='baru'?'active':'' }}">
                        <i class="fas fa-bell"></i> Baru ({{ $laporan_baru }})
                    </a>

                    <a href="?filter=dibaca" class="filter-btn {{ $filter=='dibaca'?'active':'' }}">
                        <i class="fas fa-check"></i> Dibaca
                    </a>
                </div>

                {{-- Search --}}
                <form method="GET" class="search-box">
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="text" name="search" placeholder="Cari laporan..." value="{{ $search }}">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>

            </div>
        </div>

        <div class="card-body">

            <div class="laporan-list">

                @forelse($laporan as $row)
                <div class="laporan-item {{ $row->status=='baru'?'unread':'' }}">

                    {{-- Header --}}
                    <div class="laporan-header">
                        <div class="laporan-info">
                            <h4>{{ $row->judul }}</h4>
                            <div class="laporan-meta">
                                <span><i class="fas fa-user"></i> {{ $row->user->name ?? 'User' }}</span>
                                <span><i class="fas fa-envelope"></i> {{ $row->user->email ?? '-' }}</span>
                                <span><i class="fas fa-clock"></i> {{ $row->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        <span class="badge badge-{{ $row->status }}">
                            {{ $row->status=='baru' ? 'Baru' : 'Dibaca' }}
                        </span>
                    </div>

                    {{-- Isi laporan --}}
                    <div class="laporan-content">
                        <div class="laporan-isi">
                            {!! nl2br(e($row->isi)) !!}
                        </div>

                        {{-- Balasan --}}
                        @if($row->balasan)
                        <div class="laporan-balasan">
                            <strong>
                                <i class="fas fa-reply"></i>
                                Balasan Admin ({{ $row->admin->nama_lengkap ?? 'Admin' }}):
                            </strong>

                            {!! nl2br(e($row->balasan)) !!}

                            <div style="margin-top:10px;font-size:12px;color:#666;">
                                <i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($row->tanggal_balas)->format('d M Y, H:i') }}
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Action Button --}}
                    <div class="laporan-actions">

                        {{-- Balas --}}
                        @if(!$row->balasan)
                        <button class="btn btn-primary btn-sm"
                            onclick="openBalasModal({{ $row->id }}, '{{ e($row->judul) }}')">
                            <i class="fas fa-reply"></i> Balas
                        </button>
                        @endif

                        {{-- Tandai Dibaca --}}
                        @if($row->status=='baru')
                        <form action="{{ route('admin.laporan.read', $row->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i> Tandai Dibaca
                            </button>
                        </form>
                        @endif

                        {{-- Hapus --}}
                        <form action="{{ route('admin.laporan.delete', $row->id) }}" method="POST"
                              onsubmit="return confirm('Hapus laporan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>

                    </div>
                </div>
                @empty

                {{-- Empty State --}}
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Tidak Ada Laporan</h3>
                    <p>Belum ada laporan yang masuk dari user.</p>
                </div>

                @endforelse

            </div>
        </div>
    </div>
</div>

{{-- Modal Balas --}}
<div id="balasModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Balas Laporan</h3>
            <button class="close" onclick="closeBalasModal()">&times;</button>
        </div>

        <form method="POST" id="balasForm">
            @csrf

            <div class="modal-body">
                <div class="form-group">
                    <label>Balasan</label>
                    <textarea name="balasan" required></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Kirim Balasan</button>
                <button type="button" class="btn btn-danger" onclick="closeBalasModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function openBalasModal(id, judul) {
    document.getElementById('balasModal').classList.add('show');
    document.getElementById('balasForm').action =
        "/admin/laporan/" + id + "/reply";
}

function closeBalasModal() {
    document.getElementById('balasModal').classList.remove('show');
}
</script>

@endsection
