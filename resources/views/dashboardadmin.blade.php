<?php
session_start();
require_once 'config.php';
require_once 'check_auth.php';

checkAuth();

$admin_nama = $_SESSION['admin_nama'] ?? 'Admin';
$admin_username = $_SESSION['admin_username'] ?? 'admin';

// Get statistics
$conn = getConnection();

// Count products
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM produk");
$stmt->execute();
$total_produk = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

// Count PO
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM purchase_order");
$stmt->execute();
$total_po = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

// Count customers
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM customer");
$stmt->execute();
$total_customer = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

// Count admins
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM admin WHERE status = 'active'");
$stmt->execute();
$total_admin = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

// Get products
$stmt = $conn->prepare("SELECT id, kode, nama_produk, harga FROM produk ORDER BY id DESC LIMIT 5");
$stmt->execute();
$produk_list = $stmt->get_result();
$stmt->close();

// Get admins
$stmt = $conn->prepare("SELECT id, username, nama_lengkap FROM admin WHERE status = 'active' ORDER BY id DESC");
$stmt->execute();
$admin_list = $stmt->get_result();
$stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrator Nurrahma Nopia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #fff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            background-color: #a67c52;
            color: white;
            padding: 20px;
            font-size: 20px;
            font-style: italic;
            font-weight: bold;
        }

        .sidebar-profile {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .profile-avatar {
            width: 50px;
            height: 50px;
            background-color: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .profile-name {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        .profile-status {
            font-size: 12px;
            color: #4caf50;
        }

        .profile-status::before {
            content: "●";
            margin-right: 5px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #eee;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .sidebar-menu a:hover {
            background-color: #f5f5f5;
        }

        .sidebar-menu a.active {
            background-color: #a67c52;
            color: white;
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
        }

        .menu-text {
            flex: 1;
        }

        .menu-arrow {
            font-size: 12px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .topbar {
            background-color: #a67c52;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .topbar-left {
            display: flex;
            align-items: center;
        }

        .menu-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            margin-right: 20px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Content Area */
        .content {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }

        .page-subtitle {
            color: #666;
            font-size: 14px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .breadcrumb a {
            color: #a67c52;
            text-decoration: none;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #d4a574 0%, #a67c52 100%);
            color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #5dade2 0%, #3498db 100%);
        }

        .stat-card.green {
            background: linear-gradient(135deg, #58d68d 0%, #27ae60 100%);
        }

        .stat-card.orange {
            background: linear-gradient(135deg, #f8b739 0%, #f39c12 100%);
        }

        .stat-card.red {
            background: linear-gradient(135deg, #ec7063 0%, #e74c3c 100%);
        }

        .stat-card::before {
            content: "";
            position: absolute;
            right: -30px;
            top: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .stat-number {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .stat-link {
            display: inline-flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-size: 14px;
            opacity: 0.9;
            transition: opacity 0.3s;
        }

        .stat-link:hover {
            opacity: 1;
        }

        .stat-link i {
            margin-left: 5px;
        }

        /* Data Tables */
        .data-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .data-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .data-card-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .data-card-header i {
            color: #a67c52;
        }

        .data-card-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background-color: #f5f5f5;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #666;
        }

        .data-table tr:hover {
            background-color: #fafafa;
        }

        .data-table a {
            color: #3498db;
            text-decoration: none;
        }

        .data-table a:hover {
            text-decoration: underline;
        }

        .btn-menu-admin {
            background-color: #00bcd4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 20px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-menu-admin:hover {
            background-color: #0097a7;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        @media (max-width: 1024px) {
            .data-section {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            Administrator
        </div>
        
        <div class="sidebar-profile">
            <div class="profile-avatar">
                hb
            </div>
            <div class="profile-name">Selamat Datang,<br><?php echo htmlspecialchars($admin_nama); ?></div>
            <div class="profile-status">Online</div>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php" class="active">
                    <span><i class="fas fa-chart-line"></i><span class="menu-text">Dashboard</span></span>
                </a>
            </li>
            <li>
                <a href="produk-makanan.php">
                    <span><i class="fas fa-utensils"></i><span class="menu-text">Produk Makanan</span></span>
                    <i class="fas fa-chevron-left menu-arrow"></i>
                </a>
            </li>
            <li>
                <a href="transaksi.php">
                    <span><i class="fas fa-dollar-sign"></i><span class="menu-text">Transaksi</span></span>
                    <i class="fas fa-chevron-left menu-arrow"></i>
                </a>
            </li>
            <li>
                <a href="admin.php">
                    <span><i class="fas fa-user-shield"></i><span class="menu-text">Admin</span></span>
                    <i class="fas fa-chevron-left menu-arrow"></i>
                </a>
            </li>
            <li>
                <a href="laporan.php">
                    <span><i class="fas fa-file-alt"></i><span class="menu-text">Laporan</span></span>
                    <i class="fas fa-chevron-left menu-arrow"></i>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="topbar-right">
                <div class="topbar-user">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo htmlspecialchars($admin_nama); ?></span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="page-header">
                <h1 class="page-title">Dashboard <span class="page-subtitle">Administrator</span></h1>
                <div class="breadcrumb">
                    <i class="fas fa-home"></i>
                    <a href="dashboard.php">Home</a>
                    <span>></span>
                    <span>Dashboard</span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-number"><?php echo $total_produk; ?></div>
                    <div class="stat-label">Jumlah Produk</div>
                    <a href="produk-makanan.php" class="stat-link">
                        Lihat Detail Produk <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="stat-card green">
                    <div class="stat-number"><?php echo $total_po; ?></div>
                    <div class="stat-label">PO (Purchase Order)</div>
                    <a href="purchase-order.php" class="stat-link">
                        Lihat Detail PO <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="stat-card orange">
                    <div class="stat-number"><?php echo $total_customer; ?></div>
                    <div class="stat-label">Customer</div>
                    <a href="customer.php" class="stat-link">
                        Lihat Detail Customer <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="stat-card red">
                    <div class="stat-number"><?php echo $total_admin; ?></div>
                    <div class="stat-label">Admin</div>
                    <a href="admin.php" class="stat-link">
                        Lihat Detail Admin <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Data Tables -->
            <div class="data-section">
                <div class="data-card">
                    <div class="data-card-header">
                        <i class="fas fa-box"></i>
                        <h3 class="data-card-title">Data Produk</h3>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Produk</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if ($produk_list->num_rows > 0):
                                while($row = $produk_list->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($row['kode']); ?></td>
                                <td>
                                    <a href="detail-produk.php?id=<?php echo $row['id']; ?>">
                                        <i class="fas fa-user"></i> <?php echo htmlspecialchars($row['nama_produk']); ?>
                                    </a>
                                </td>
                                <td>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php 
                                endwhile;
                            else:
                            ?>
                            <tr>
                                <td colspan="4" class="empty-state">Tidak ada data produk</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="data-card">
                    <div class="data-car