<?php
session_start();
require_once 'config.php';
require_once 'check_auth.php';

checkAuth();

$admin_nama = $_SESSION['admin_nama'] ?? 'Admin';
$conn = getConnection();

$success = '';
$error = '';

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'balas') {
            $laporan_id = $_POST['laporan_id'];
            $balasan = trim($_POST['balasan']);
            
            $stmt = $conn->prepare("UPDATE laporan SET balasan=?, status='dibaca', dibalas_oleh=?, tanggal_balas=NOW() WHERE id=?");
            $stmt->bind_param("sii", $balasan, $_SESSION['admin_id'], $laporan_id);
            
            if ($stmt->execute()) {
                $success = "Balasan berhasil dikirim!";
            } else {
                $error = "Gagal mengirim balasan!";
            }
            $stmt->close();
        }
        
        if ($_POST['action'] === 'tandai_dibaca') {
            $laporan_id = $_POST['laporan_id'];
            
            $stmt = $conn->prepare("UPDATE laporan SET status='dibaca' WHERE id=?");
            $stmt->bind_param("i", $laporan_id);
            
            if ($stmt->execute()) {
                $success = "Laporan ditandai sebagai dibaca!";
            } else {
                $error = "Gagal mengupdate status!";
            }
            $stmt->close();
        }
        
        if ($_POST['action'] === 'hapus') {
            $laporan_id = $_POST['laporan_id'];
            
            $stmt = $conn->prepare("DELETE FROM laporan WHERE id=?");
            $stmt->bind_param("i", $laporan_id);
            
            if ($stmt->execute()) {
                $success = "Laporan berhasil dihapus!";
            } else {
                $error = "Gagal menghapus laporan!";
            }
            $stmt->close();
        }
    }
}

// Get filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query
$query = "SELECT l.*, u.nama as nama_user, u.email as email_user, a.nama_lengkap as dibalas_oleh_nama
          FROM laporan l
          LEFT JOIN users u ON l.user_id = u.id
          LEFT JOIN admin a ON l.dibalas_oleh = a.id
          WHERE 1=1";

if ($filter == 'baru') {
    $query .= " AND l.status = 'baru'";
} elseif ($filter == 'dibaca') {
    $query .= " AND l.status = 'dibaca'";
}

if (!empty($search)) {
    $query .= " AND (l.judul LIKE '%$search%' OR l.isi LIKE '%$search%' OR u.nama LIKE '%$search%')";
}

$query .= " ORDER BY l.created_at DESC";
$result = $conn->query($query);

// Get statistics
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM laporan");
$stmt->execute();
$total_laporan = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM laporan WHERE status='baru'");
$stmt->execute();
$laporan_baru = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM laporan WHERE status='dibaca'");
$stmt->execute();
$laporan_dibaca = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM laporan WHERE balasan IS NOT NULL");
$stmt->execute();
$laporan_dibalas = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan User - Nurrahma Nopia</title>
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

        .stat-icon.total {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .stat-icon.baru {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }

        .stat-icon.dibaca {
            background: linear-gradient(135deg, #27ae60, #229954);
        }

        .stat-icon.dibalas {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
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
            flex-wrap: wrap;
            gap: 15px;
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

        .filter-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
        }

        .filter-btn:hover {
            background-color: #f5f5f5;
        }

        .filter-btn.active {
            background-color: #a67c52;
            color: white;
            border-color: #a67c52;
        }

        .search-box {
            display: flex;
            gap: 10px;
        }

        .search-box input {
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            width: 250px;
        }

        .search-box button {
            padding: 8px 16px;
            background-color: #a67c52;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .card-body {
            padding: 20px;
        }

        .laporan-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .laporan-item {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            background-color: #fafafa;
            transition: all 0.3s;
        }

        .laporan-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .laporan-item.unread {
            background-color: #fff3cd;
            border-left: 4px solid #f39c12;
        }

        .laporan-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .laporan-info h4 {
            color: #333;
            margin-bottom: 8px;
            font-size: 18px;
        }

        .laporan-meta {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #666;
        }

        .laporan-meta i {
            margin-right: 5px;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .badge-baru {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-dibaca {
            background-color: #d4edda;
            color: #155724;
        }

        .laporan-content {
            margin-bottom: 15px;
        }

        .laporan-isi {
            color: #555;
            line-height: 1.6;
            padding: 15px;
            background-color: white;
            border-radius: 4px;
            border-left: 3px solid #a67c52;
        }

        .laporan-balasan {
            margin-top: 15px;
            padding: 15px;
            background-color: #e8f5e9;
            border-radius: 4px;
            border-left: 3px solid #27ae60;
        }

        .laporan-balasan strong {
            color: #27ae60;
            display: block;
            margin-bottom: 8px;
        }

        .laporan-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
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
            max-width: 600px;
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #a67c52;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            color: #ddd;
        }

        .empty-state h3 {
            color: #666;
            margin-bottom: 10px;
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

            .search-box input {
                width: 100%;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
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
                <a href="transaksi.php">
                    <span><i class="fas fa-shopping-cart"></i><span class="menu-text">Transaksi</span></span>
                </a>
            </li>
            <li>
                <a href="admin.php">
                    <span><i class="fas fa-user-shield"></i><span class="menu-text">Admin</span></span>
                </a>
            </li>
            <li>
                <a href="laporan.php" class="active">
                    <span><i class="fas fa-file-alt"></i><span class="menu-text">Laporan</span></span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div>Laporan User</div>
            <div class="topbar-user">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($admin_nama); ?></span>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="page-header">
                <h1 class="page-title">Laporan & Masukan User</h1>
                <div class="breadcrumb">
                    <i class="fas fa-home"></i>
                    <a href="dashboard.php">Home</a>
                    <span>></span>
                    <span>Laporan</span>
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
                <div class="stat-box">
                    <div class="stat-icon total">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $total_laporan; ?></h3>
                        <p>Total Laporan</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon baru">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $laporan_baru; ?></h3>
                        <p>Laporan Baru</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon dibaca">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $laporan_dibaca; ?></h3>
                        <p>Sudah Dibaca</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon dibalas">
                        <i class="fas fa-reply"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $laporan_dibalas; ?></h3>
                        <p>Sudah Dibalas</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-comments"></i>
                        Daftar Laporan
                    </h3>
                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <div class="filter-group">
                            <a href="?filter=semua" class="filter-btn <?php echo $filter == 'semua' ? 'active' : ''; ?>">
                                <i class="fas fa-list"></i> Semua
                            </a>
                            <a href="?filter=baru" class="filter-btn <?php echo $filter == 'baru' ? 'active' : ''; ?>">
                                <i class="fas fa-bell"></i> Baru (<?php echo $laporan_baru; ?>)
                            </a>
                            <a href="?filter=dibaca" class="filter-btn <?php echo $filter == 'dibaca' ? 'active' : ''; ?>">
                                <i class="fas fa-check"></i> Dibaca
                            </a>
                        </div>
                        <form method="GET" class="search-box">
                            <input type="hidden" name="filter" value="<?php echo $filter; ?>">
                            <input type="text" name="search" placeholder="Cari laporan..." value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="laporan-list">
                        <?php 
                        if ($result->num_rows > 0):
                            while($row = $result->fetch_assoc()): 
                                $is_unread = $row['status'] == 'baru';
                        ?>
                        <div class="laporan-item <?php echo $is_unread ? 'unread' : ''; ?>">
                            <div class="laporan-header">
                                <div class="laporan-info">
                                    <h4><?php echo htmlspecialchars($row['judul']); ?></h4>
                                    <div class="laporan-meta">
                                        <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($row['nama_user'] ?? 'User'); ?></span>
                                        <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($row['email_user'] ?? '-'); ?></span>
                                        <span><i class="fas fa-clock"></i> <?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></span>
                                    </div>
                                </div>
                                <span class="badge badge-<?php echo $row['status']; ?>">
                                    <?php echo $row['status'] == 'baru' ? 'Baru' : 'Dibaca'; ?>
                                </span>
                            </div>
                            
                            <div class="laporan-content">
                                <div class="laporan-isi">
                                    <?php echo nl2br(htmlspecialchars($row['isi'])); ?>
                                </div>
                                
                                <?php if ($row['balasan']): ?>
                                <div class="laporan-balasan">
                                    <strong><i class="fas fa-reply"></i> Balasan Admin (<?php echo htmlspecialchars($row['dibalas_oleh_nama'] ?? 'Admin'); ?>):</strong>
                                    <?php echo nl2br(htmlspecialchars($row['balasan'])); ?>
                                    <div style="margin-top: 10px; font-size: 12px; color: #666;">
                                        <i class="fas fa-clock"></i> <?php echo date('d M Y, H:i', strtotime($row['tanggal_balas'])); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="laporan-actions">
                                <?php if (!$row['balasan']): ?>
                                <button class="btn btn-primary btn-sm" onclick="openBalasModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['judul']); ?>')">
                                    <i class="fas fa-reply"></i> Balas
                                </button>
                                <?php endif; ?>
                                
                                <?php if ($row['status'] == 'baru'): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="tandai_dibaca">
                                    <input type="hidden" name="laporan_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Tandai Dibaca
                                    </button>
                                </form>
                                <?php endif; ?>
                                
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="hapus">
                                    <input type="hidden" name="laporan_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus laporan ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php 
                            endwhile;
                        else:
                        ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h3>Tidak Ada Laporan</h3>
                            <p>Belum ada laporan yang masuk dari user</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Balas Laporan -->
    <div id="balasModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Balas Laporan</h3>
                <button class="close" onclick="close