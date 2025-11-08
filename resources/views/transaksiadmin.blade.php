<?php
session_start();
require_once 'config.php';
require_once 'check_auth.php';

checkAuth();

$admin_nama = $_SESSION['admin_nama'] ?? 'Admin';
$conn = getConnection();

$success = '';
$error = '';

// Handle ACC Transaksi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'acc') {
            $po_id = $_POST['po_id'];
            
            $stmt = $conn->prepare("UPDATE purchase_order SET status_pengiriman='processing' WHERE id=?");
            $stmt->bind_param("i", $po_id);
            
            if ($stmt->execute()) {
                $success = "Transaksi berhasil di-ACC! Produk siap dikirim.";
            } else {
                $error = "Gagal ACC transaksi!";
            }
            $stmt->close();
        }
        
        if ($_POST['action'] === 'kirim') {
            $po_id = $_POST['po_id'];
            
            $stmt = $conn->prepare("UPDATE purchase_order SET status_pengiriman='shipped' WHERE id=?");
            $stmt->bind_param("i", $po_id);
            
            if ($stmt->execute()) {
                $success = "Status berhasil diubah menjadi Dikirim!";
            } else {
                $error = "Gagal mengubah status!";
            }
            $stmt->close();
        }
        
        if ($_POST['action'] === 'selesai') {
            $po_id = $_POST['po_id'];
            
            $stmt = $conn->prepare("UPDATE purchase_order SET status_pengiriman='delivered', status_pembayaran='paid' WHERE id=?");
            $stmt->bind_param("i", $po_id);
            
            if ($stmt->execute()) {
                $success = "Transaksi selesai!";
            } else {
                $error = "Gagal menyelesaikan transaksi!";
            }
            $stmt->close();
        }
        
        if ($_POST['action'] === 'batal') {
            $po_id = $_POST['po_id'];
            
            $stmt = $conn->prepare("UPDATE purchase_order SET status_pengiriman='cancelled' WHERE id=?");
            $stmt->bind_param("i", $po_id);
            
            if ($stmt->execute()) {
                $success = "Transaksi dibatalkan!";
            } else {
                $error = "Gagal membatalkan transaksi!";
            }
            $stmt->close();
        }
    }
}

// Get all transactions
$query = "SELECT po.*, c.nama as nama_customer, c.telepon, c.alamat, a.nama_lengkap as created_by_nama
          FROM purchase_order po
          LEFT JOIN customer c ON po.customer_id = c.id
          LEFT JOIN admin a ON po.created_by = a.id
          ORDER BY po.tanggal_po DESC, po.id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - Nurrahma Nopia</title>
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

        .main-content {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: #a67c52;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .content {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #666;
        }

        .breadcrumb a {
            color: #a67c52;
            text-decoration: none;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.pending {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }

        .stat-icon.processing {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .stat-icon.shipped {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
        }

        .stat-icon.delivered {
            background: linear-gradient(135deg, #27ae60, #229954);
        }

        .stat-info h3 {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-info p {
            font-size: 14px;
            color: #666;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: #a67c52;
        }

        .card-body {
            padding: 20px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background-color: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            color: #666;
        }

        table tr:hover {
            background-color: #fafafa;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-processing {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .badge-shipped {
            background-color: #e2d5f1;
            color: #6c3483;
        }

        .badge-delivered {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-paid {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-unpaid {
            background-color: #f8d7da;
            color: #721c24;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #a67c52;
            color: white;
        }

        .btn-primary:hover {
            background-color: #8d6a44;
        }

        .btn-success {
            background-color: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background-color: #229954;
        }

        .btn-info {
            background-color: #3498db;
            color: white;
        }

        .btn-info:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .close {
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
            border: none;
            background: none;
        }

        .close:hover {
            color: #000;
        }

        .modal-body {
            padding: 20px;
        }

        .detail-group {
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #666;
            padding: 8px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .detail-table {
            width: 100%;
            margin-top: 15px;
        }

        .detail-table th {
            background-color: #a67c52;
            color: white;
            padding: 10px;
        }

        .detail-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
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
                <?php echo strtoupper(substr($admin_nama, 0, 2)); ?>
            </div>
            <div class="profile-name">Selamat Datang,<br><?php echo htmlspecialchars($admin_nama); ?></div>
            <div class="profile-status">Online</div>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php">
                    <span><i class="fas fa-chart-line"></i><span class="menu-text">Dashboard</span></span>
                </a>
            </li>
            <li>
                <a href="produk-makanan.php">
                    <span><i class="fas fa-utensils"></i><span class="menu-text">Produk Makanan</span></span>
                </a>
            </li>
            <li>
                <a href="transaksi.php" class="active">
                    <span><i class="fas fa-shopping-cart"></i><span class="menu-text">Transaksi</span></span>
                </a>
            </li>
            <li>
                <a href="admin.php">
                    <span><i class="fas fa-user-shield"></i><span class="menu-text">Admin</span></span>
                </a>
            </li>
            <li>
                <a href="laporan.php">
                    <span><i class="fas fa-file-alt"></i><span class="menu-text">Laporan</span></span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div>Transaksi</div>
            <div class="topbar-user">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($admin_nama); ?></span>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="page-header">
                <h1 class="page-title">Kelola Transaksi</h1>
                <div class="breadcrumb">
                    <i class="fas fa-home"></i>
                    <a href="dashboard.php">Home</a>
                    <span>></span>
                    <span>Transaksi</span>
                </div>
            </div>

            <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($success); ?>
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <!-- Statistics -->
            <div class="stats-grid">
                <?php
                $stmt = $conn->prepare("SELECT COUNT(*) as total FROM purchase_order WHERE status_pengiriman='pending'");
                $stmt->execute();
                $pending = $stmt->get_result()->fetch_assoc()['total'];
                $stmt->close();

                $stmt = $conn->prepare("SELECT COUNT(*) as total FROM purchase_order WHERE status_pengiriman='processing'");
                $stmt->execute();
                $processing = $stmt->get_result()->fetch_assoc()['total'];
                $stmt->close();

                $stmt = $conn->prepare("SELECT COUNT(*) as total FROM purchase_order WHERE status_pengiriman='shipped'");
                $stmt->execute();
                $shipped = $stmt->get_result()->fetch_assoc()['total'];
                $stmt->close();

                $stmt = $conn->prepare("SELECT COUNT(*) as total FROM purchase_order WHERE status_pengiriman='delivered'");
                $stmt->execute();
                $delivered = $stmt->get_result()->fetch_assoc()['total'];
                $stmt->close();
                ?>
                <div class="stat-box">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $pending; ?></h3>
                        <p>Menunggu ACC</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon processing">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $processing; ?></h3>
                        <p>Diproses</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon shipped">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $shipped; ?></h3>
                        <p>Dikirim</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon delivered">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $delivered; ?></h3>
                        <p>Selesai</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-cart"></i>
                        Daftar Transaksi
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. PO</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status Pengiriman</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                if ($result->num_rows > 0):
                                    while($row = $result->fetch_assoc()): 
                                        $status_class = '';
                                        $status_text = '';
                                        switch($row['status_pengiriman']) {
                                            case 'pending':
                                                $status_class = 'badge-pending';
                                                $status_text = 'Menunggu ACC';
                                                break;
                                            case 'processing':
                                                $status_class = 'badge-processing';
                                                $status_text = 'Diproses';
                                                break;
                                            case 'shipped':
                                                $status_class = 'badge-shipped';
                                                $status_text = 'Dikirim';
                                                break;
                                            case 'delivered':
                                                $status_class = 'badge-delivered';
                                                $status_text = 'Selesai';
                                                break;
                                            case 'cancelled':
                                                $status_class = 'badge-cancelled';
                                                $status_text = 'Dibatalkan';
                                                break;
                                        }
                                        
                                        $payment_class = $row['status_pembayaran'] == 'paid' ? 'badge-paid' : 'badge-unpaid';
                                        $payment_text = $row['status_pembayaran'] == 'paid' ? 'Lunas' : 'Belum Lunas';
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['no_po']); ?></strong></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['tanggal_po'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_customer'] ?? 'Customer'); ?></td>
                                    <td><strong>Rp <?php echo number_format($row['grand_total'], 0, ',', '.'); ?></strong></td>
                                    <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                    <td><span class="badge <?php echo $payment_class; ?>"><?php echo $payment_text; ?></span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-info btn-sm" onclick='lihatDetail(<?php echo json_encode($row); ?>)'>
                                                <i class="fas fa-eye"></i> Detail
                                            </button>
                                            
                                            <?php if ($row['status_pengiriman'] == 'pending'): ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="acc">
                                                <input type="hidden" name="po_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('ACC transaksi ini?')">
                                                    <i class="fas fa-check"></i> ACC
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if ($row['status_pengiriman'] == 'processing'): ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="kirim">
                                                <input type="hidden" name="po_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-shipping-fast"></i> Kirim
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if ($row['status_pengiriman'] == 'shipped'): ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="selesai">
                                                <input type="hidden" name="po_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check-double"></i> Selesai
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if ($row['status_pengiriman'] == 'pending' || $row['status_pengiriman'] == 'processing'): ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="batal">
                                                <input type="hidden" name="po_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Batalkan transaksi ini?')">
                                                    <i class="fas fa-times"></i> Batal
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile;
                                else:
                                ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 40px;">Tidak ada data transaksi</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Detail Transaksi -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Transaksi</h3>
                <button class="close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be filled by JavaScript -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function lihatDetail(data) {
            const modal = document.getElementById('detailModal');
            const modalBody = document.getElementById('modalBody');
            
            // Get detail items
            fetch('get_detail_po.php?po_id=' + data.id)
                .then(response => response.json())
                .then(details => {
                    let detailHTML = `
                        <div class="detail-group">
                            <div class="detail-label">No. Purchase Order</div>
                            <div class="detail-value"><strong>${data.no_po}</strong></div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Tanggal</div>
                            <div class="detail-value">${new Date(data.tanggal_po).toLocaleDateString('id-ID')}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Customer</div>
                            <div class="detail-value">${data.nama_customer || 'Customer'}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Telepon</div>
                            <div class="detail-value">${data.telepon || '-'}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Alamat Pengiriman</div>
                            <div class="detail-value">${data.alamat || '-'}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Status Pengiriman</div>
                            <div class="detail-value"><span class="badge badge-${get