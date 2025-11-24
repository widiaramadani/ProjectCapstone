@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="content">
    <div class="page-header">
        <h1 class="page-title">Dashboard <span class="page-subtitle">Administrator</span></h1>

        <div class="breadcrumb">
            <i class="fas fa-home"></i>
            <a href="{{ route('admin.dashboard') }}">Home</a>
            <span>></span>
            <span>Dashboard</span>
        </div>
    </div>

    <!-- STATISTIK CARD -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-number">{{ $stats['total_produk'] }}</div>
            <div class="stat-label">Jumlah Produk</div>
            <a href="{{ route('admin.produk') }}" class="stat-link">
                Lihat Detail Produk <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="stat-card green">
            <div class="stat-number">{{ $stats['total_po'] }}</div>
            <div class="stat-label">Total Purchase Order</div>
            <a href="#" class="stat-link">
                Lihat Detail PO <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="stat-card orange">
            <div class="stat-number">{{ $stats['total_customer'] }}</div>
            <div class="stat-label">Customer Terdaftar</div>
            <a href="#" class="stat-link">
                Lihat Customer <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="stat-card red">
            <div class="stat-number">{{ $stats['total_admin'] }}</div>
            <div class="stat-label">Admin Aktif</div>
            <a href="{{ route('admin.list') }}" class="stat-link">
                Detail Admin <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- DATA SECTION -->
    <div class="data-section">

        <!-- PRODUK -->
        <div class="data-card">
            <div class="data-card-header">
                <i class="fas fa-box"></i>
                <h3 class="data-card-title">Data Produk Terbaru</h3>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk_list as $index => $produk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $produk->kode }}</td>
                        <td>
                            <a href="#">
                                <i class="fas fa-box"></i> {{ $produk->nama_produk }}
                            </a>
                        </td>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">Tidak ada data produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ADMIN -->
        <div class="data-card">
            <div class="data-card-header">
                <i class="fas fa-user-shield"></i>
                <h3 class="data-card-title">Admin Aktif</h3>
            </div>

            <a href="{{ route('admin.list') }}" class="btn-menu-admin">
                <i class="fas fa-plus"></i> Kelola Admin
            </a>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admin_list as $index => $admin)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $admin->username }}</td>
                        <td>
                            <i class="fas fa-user"></i> {{ $admin->nama_lengkap }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="empty-state">Tidak ada data admin.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
