<?php
session_start();
require_once 'config.php';
require_once 'check_auth.php';

checkAuth();

$admin_nama = $_SESSION['admin_nama'] ?? 'Admin';
$conn = getConnection();

// Handle tambah/edit produk
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'tambah') {
            $kode = trim($_POST['kode']);
            $nama = trim($_POST['nama_produk']);
            $kategori_id = $_POST['kategori_id'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $satuan = $_POST['satuan'];
            $deskripsi = trim($_POST['deskripsi']);
            
            $stmt = $conn->prepare("INSERT INTO produk (kode, nama_produk, kategori_id, harga, stok, satuan, deskripsi, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')");
            $stmt->bind_param("ssiidss", $kode, $nama, $kategori_id, $harga, $stok, $satuan, $deskripsi);
            
            if ($stmt->execute()) {
                $success = "Produk berhasil ditambahkan!";
            } else {
                $error = "Gagal menambahkan produk: " . $stmt->error;
            }
            $stmt->close();
        }
        
        if ($_POST['action'] === 'edit') {
            $id = $_POST['id'];
            $nama = trim($_POST['nama_produk']);
            $kategori_id = $_POST['kategori_id'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $satuan = $_POST['satuan'];
            $deskripsi = trim($_POST['deskripsi']);
            
            $stmt = $conn->prepare("UPDATE produk SET nama_produk=?, kategori_id=?, harga=?, stok=?, satuan=?, deskripsi=? WHERE id=?");
            $stmt->bind_param("siidssi", $nama, $kategori_id, $harga, $stok, $satuan, $deskripsi, $id);
            
            if ($stmt->execute()) {
                $success = "Produk berhasil diupdate!";
            } else {
                $error = "Gagal mengupdate produk!";
            }
            $stmt->close();
        }
        
        if ($_POST['action'] === 'hapus') {
            $id = $_POST['id'];
            $stmt = $conn->prepare("UPDATE produk SET status='inactive' WHERE id=?");
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $success = "Produk berhasil dihapus!";
            } else {
                $error = "Gagal menghapus produk!";
            }
            $stmt->close();
        }
        
        if ($_POST['action'] === 'restock') {
            $id = $_POST['id'];
            $tambah_stok = $_POST['tambah_stok'];
            
            $stmt = $conn->prepare("SELECT stok FROM produk WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stok_lama = $row['stok'];
            $stmt->close();
            
            $stok_baru = $stok_lama + $tambah_stok;
            
            $stmt = $conn->prepare("UPDATE produk SET stok=? WHERE id=?");
            $stmt->bind_param("ii", $stok_baru, $id);
            
            if ($stmt->execute()) {
                // Insert ke stok history
                $stmt2 = $conn->prepare("INSERT INTO stok_history (produk_id, tipe, qty, stok_sebelum, stok_sesudah, keterangan, created_by) VALUES (?, 'masuk', ?, ?, ?, 'Restock', ?)");
                $stmt2->bind_param("iiiii", $id, $tambah_stok, $stok_lama, $stok_baru, $_SESSION['admin_id']);
                $stmt2->execute();
                $stmt2->close();
                
                $success = "Stok berhasil ditambahkan! Stok baru: " . $stok_baru;
            } else {
                $error = "Gagal menambah stok!";
            }
            $stmt->close();
        }
    }
}

// Get all products
$query = "SELECT p.*, k.nama_kategori 
          FROM produk p 
          LEFT JOIN kategori k ON p.kategori_id = k.id 
          WHERE p.status = 'active' 
          ORDER BY p.id DESC";
$result = $conn->query($query);

// Get categories
$kategori_result = $conn->query("SELECT * FROM kategori ORDER BY nama_kategori");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Makanan - Nurrahma Nopia</title>
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

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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

        .btn-warning {
            background-color: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e67e22;
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
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
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

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #a67c52;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
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
                <a href="produk-makanan.php" class="active">
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
            <div>Produk Makanan</div>
            <div class="topbar-user">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($admin_nama); ?></span>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="page-header">
                <h1 class="page-title">Produk Makanan</h1>
                <div class="breadcrumb">
                    <i class="fas fa-home"></i>
                    <a href="dashboard.php">Home</a>
                    <span>></span>
                    <span>Produk Makanan</span>
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

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-box"></i>
                        Daftar Produk
                    </h3>
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
                                <?php 
                                $no = 1;
                                if ($result->num_rows > 0):
                                    while($row = $result->fetch_assoc()): 
                                        $stok_status = $row['stok'] > 10 ? 'success' : ($row['stok'] > 0 ? 'warning' : 'danger');
                                        $stok_text = $row['stok'] > 10 ? 'Tersedia' : ($row['stok'] > 0 ? 'Terbatas' : 'Habis');
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['kode']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_kategori'] ?? '-'); ?></td>
                                    <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td><?php echo $row['stok']; ?> <?php echo $row['satuan']; ?></td>
                                    <td><span class="badge badge-<?php echo $stok_status; ?>"><?php echo $stok_text; ?></span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-success btn-sm" onclick="openRestockModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['nama_produk']); ?>', <?php echo $row['stok']; ?>)">
                                                <i class="fas fa-plus"></i> Restock
                                            </button>
                                            <button class="btn btn-warning btn-sm" onclick='openEditModal(<?php echo json_encode($row); ?>)'>
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="hapusProduk(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['nama_produk']); ?>')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile;
                                else:
                                ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 40px;">Tidak ada data produk</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Tambah Produk -->
    <div id="tambahModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Produk Baru</h3>
                <button class="close" onclick="closeModal('tambahModal')">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="tambah">
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
                            <?php 
                            $kategori_result->data_seek(0);
                            while($kat = $kategori_result->fetch_assoc()): 
                            ?>
                            <option value="<?php echo $kat['id']; ?>"><?php echo htmlspecialchars($kat['nama_kategori']); ?></option>
                            <?php endwhile; ?>
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

    <!-- Modal Edit Produk -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Produk</h3>
                <button class="close" onclick="closeModal('editModal')">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Produk *</label>
                        <input type="text" name="nama_produk" id="edit_nama" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="kategori_id" id="edit_kategori" required>
                            <option value="">Pilih Kategori</option>
                            <?php 
                            $kategori_result->data_seek(0);
                            while($kat = $kategori_result->fetch_assoc()): 
                            ?>
                            <option value="<?php echo $kat['id']; ?>"><?php echo htmlspecialchars($kat['nama_kategori']); ?></option>
                            <?php endwhile; ?>
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
            <div class="modal-header">
                <h3 class="modal-title">Restock Produk</h3>
                <button class="close" onclick="closeModal('restockModal')">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="restock">
                <input type="hidden" name="id" id="restock_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" id="restock_nama" readonly style="background-color: #f5f5f5;">
                    </div>
                    <div class="form-group">
                        <label>Stok Saat Ini</label>
                        <input type="text" id="restock_stok_current" readonly style="background-color: #f5f5f5;">
                    </div>
                    <div class="form-group">
                        <label>Tambah Stok *</label>
                        <input type="number" name="tambah_stok" id="restock_tambah" required min="1" placeholder="Masukkan jumlah stok yang ditambahkan">
                    </div>
                    <div class="form-group">
                        <label>Stok Setelah Restock</label>
                        <input type="text" id="restock_stok_new" readonly style="background-color: #e8f5e9; font-weight: bold; font-size: 16px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn