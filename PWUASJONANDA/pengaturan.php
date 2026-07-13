<?php
session_start();
require_once 'config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

$name = $_SESSION['name'] ?? 'Administrator';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newName = mysqli_real_escape_string($conn, $_POST['name']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $newPhone = mysqli_real_escape_string($conn, $_POST['phone']);
    $userId = $_SESSION['user_id'];
    
    mysqli_query($conn, "UPDATE users SET name='$newName', email='$newEmail' WHERE id=$userId");
    $_SESSION['name'] = $newName;
    $msg = '<div class="alert alert-success">✅ Profil berhasil diupdate!</div>';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Smart Event Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4f8;
            padding: 20px;
        }

        .main-content { max-width: 1100px; margin: 0 auto; }

        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(20px); }
            to { opacity:1; transform:translateY(0); }
        }
        .animate-fade { animation: fadeInUp 0.6s ease forwards; }

        /* ===== HEADER ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .page-header h1 {
            font-size: 24px;
            font-weight: 800;
            color: #1a1a2e;
            margin: 0;
        }
        .page-header h1 i {
            color: #5b7cff;
            margin-right: 10px;
        }
        .page-header h1 small {
            display: block;
            font-size: 14px;
            font-weight: 400;
            color: #888;
            margin-top: 2px;
        }
        .page-header .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        .page-header .breadcrumb-item a {
            color: #5b7cff;
            text-decoration: none;
        }
        .page-header .breadcrumb-item.active {
            color: #888;
        }

        /* ===== GRID ===== */
        .settings-grid {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 24px;
        }

        /* ===== SIDEBAR ===== */
        .settings-sidebar {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            height: fit-content;
        }
        .settings-sidebar .sidebar-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
            background: #fafbff;
        }
        .settings-sidebar .sidebar-header h6 {
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            font-size: 13px;
        }
        .settings-sidebar .sidebar-header h6 i {
            color: #5b7cff;
            margin-right: 8px;
        }
        .settings-sidebar .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
            border-left: 3px solid transparent;
        }
        .settings-sidebar .menu-item:hover {
            background: #f8faff;
            color: #1a1a2e;
        }
        .settings-sidebar .menu-item.active {
            background: #f0f4ff;
            color: #5b7cff;
            border-left-color: #5b7cff;
        }
        .settings-sidebar .menu-item i {
            font-size: 16px;
            width: 20px;
        }
        .settings-sidebar .menu-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 4px 16px;
        }

        /* ===== CARD ===== */
        .settings-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            overflow: hidden;
            margin-bottom: 20px;
        }
        .settings-card .card-header {
            padding: 16px 24px;
            border-bottom: 1px solid #f0f0f0;
            background: #fafbff;
        }
        .settings-card .card-header h5 {
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            font-size: 16px;
        }
        .settings-card .card-header h5 i {
            color: #5b7cff;
            margin-right: 8px;
        }
        .settings-card .card-header .sub {
            font-size: 13px;
            color: #888;
            font-weight: 400;
        }
        .settings-card .card-body {
            padding: 24px;
        }

        /* ===== FORM ===== */
        .form-group { margin-bottom: 18px; }
        .form-group label {
            font-weight: 600;
            color: #374151;
            font-size: 13px;
            display: block;
            margin-bottom: 4px;
        }
        .form-group label i {
            color: #5b7cff;
            margin-right: 6px;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #dbe2ea;
            padding: 10px 14px;
            font-size: 14px;
            transition: 0.2s ease;
        }
        .form-control:focus {
            border-color: #5b7cff;
            box-shadow: 0 0 0 3px rgba(91,124,255,0.12);
        }
        .form-control:disabled {
            background: #f9fafb;
            color: #6b7280;
        }

        .btn-save {
            background: linear-gradient(135deg, #5b7cff, #7c4dff);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 30px;
            font-weight: 700;
            transition: 0.3s;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(91,124,255,0.3);
            color: #fff;
        }

        /* ===== FOTO PROFIL ===== */
        .photo-upload {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .photo-upload .avatar-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5b7cff, #7c4dff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .photo-upload .file-info {
            font-size: 13px;
            color: #888;
        }
        .photo-upload .file-info i {
            color: #5b7cff;
        }

        /* ===== INFO AKUN ===== */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .info-item {
            background: #f8faff;
            border-radius: 12px;
            padding: 14px 18px;
            border: 1px solid rgba(0,0,0,0.03);
        }
        .info-item .label {
            font-size: 11px;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-item .value {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
            margin-top: 4px;
        }
        .info-item .value i {
            color: #5b7cff;
            margin-right: 6px;
        }

        /* ===== ZONA BERBAHAYA ===== */
        .danger-zone {
            border: 1px solid #fee2e2;
            background: #fff5f5;
            border-radius: 12px;
            padding: 20px;
        }
        .danger-zone h6 {
            color: #dc2626;
            font-weight: 700;
        }
        .danger-zone p {
            color: #6b7280;
            font-size: 13px;
        }
        .btn-danger-zone {
            background: #dc2626;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 24px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-danger-zone:hover {
            background: #b91c1c;
            color: #fff;
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            padding: 18px 0 5px;
            color: #bbb;
            font-size: 13px;
            border-top: 1px solid #f0f0f0;
            margin-top: 25px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .settings-grid { grid-template-columns: 1fr; }
            .settings-sidebar { display: flex; flex-wrap: wrap; padding: 6px 0; }
            .settings-sidebar .sidebar-header { display: none; }
            .settings-sidebar .menu-item { padding: 6px 14px; border-left: none; border-bottom: 2px solid transparent; }
            .settings-sidebar .menu-item.active { border-bottom-color: #5b7cff; border-left: none; }
            .settings-sidebar .menu-divider { display: none; }
        }
        @media (max-width: 768px) {
            body { padding: 12px; }
            .info-grid { grid-template-columns: 1fr; }
            .page-header { flex-direction: column; align-items: flex-start; }
            .settings-card .card-body { padding: 16px; }
            .photo-upload { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<!-- ========================================== -->
<!-- MAIN CONTENT
<!-- ========================================== -->
<div class="main-content">

    <!-- ===== HEADER ===== -->
    <div class="page-header animate-fade">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="pengaturan.php">Pengaturan</a></li>
                    <li class="breadcrumb-item active">Profil Akun</li>
                </ol>
            </nav>
            <h1><i class="bi bi-gear"></i> Pengaturan Akun</h1>
            <small>Kelola pengaturan akun dan sistem</small>
        </div>
    </div>

    <!-- ===== SETTINGS GRID ===== -->
    <div class="settings-grid animate-fade">

        <!-- ===== SIDEBAR ===== -->
        <div class="settings-sidebar">
            <div class="sidebar-header">
                <h6><i class="bi bi-list-ul"></i> MENU</h6>
            </div>
            <a href="pengaturan.php" class="menu-item active">
                <i class="bi bi-person"></i> Profil Akun
            </a>
            <a href="#" class="menu-item">
                <i class="bi bi-shield-lock"></i> Keamanan Akun
            </a>
            <div class="menu-divider"></div>
            <a href="#" class="menu-item">
                <i class="bi bi-palette"></i> Tampilan
            </a>
            <a href="#" class="menu-item">
                <i class="bi bi-bell"></i> Notifikasi
            </a>
            <div class="menu-divider"></div>
            <a href="#" class="menu-item">
                <i class="bi bi-database"></i> Backup Data
            </a>
            <a href="logout.php" class="menu-item" style="color:#dc2626;">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

        <!-- ===== CARD KANAN ===== -->
        <div>

            <!-- ===== PROFIL AKUN ===== -->
            <div class="settings-card">
                <div class="card-header">
                    <div>
                        <h5><i class="bi bi-person"></i> Profil Akun</h5>
                        <span class="sub">Keamanan Akun</span>
                    </div>
                </div>
                <div class="card-body">
                    <?php echo $msg; ?>

                    <form method="POST">
                        <div class="form-group">
                            <label><i class="bi bi-person"></i> Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>">
                        </div>
                        <div class="form-group">
                            <label><i class="bi bi-person-badge"></i> Username</label>
                            <input type="text" class="form-control" value="admin" disabled>
                        </div>
                        <div class="form-group">
                            <label><i class="bi bi-envelope"></i> Email</label>
                            <input type="email" name="email" class="form-control" value="admin@smarteventcampus.ac.id">
                        </div>
                        <div class="form-group">
                            <label><i class="bi bi-telephone"></i> No. Telepon</label>
                            <input type="text" name="phone" class="form-control" value="0812-3456-7890">
                        </div>
                        <div class="form-group">
                            <label><i class="bi bi-shield-check"></i> Role</label>
                            <input type="text" class="form-control" value="Administrator" disabled>
                        </div>
                        <button type="submit" class="btn-save"><i class="bi bi-save"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <!-- ===== FOTO PROFIL ===== -->
            <div class="settings-card">
                <div class="card-header">
                    <h5><i class="bi bi-image"></i> Foto Profil</h5>
                </div>
                <div class="card-body">
                    <div class="photo-upload">
                        <div class="avatar-preview">
                            <?php echo strtoupper(substr($name, 0, 1)); ?>
                        </div>
                        <div>
                            <p style="margin:0;font-size:13px;color:#888;">
                                <i class="bi bi-info-circle"></i> JPG, PNG atau GIF. Maksimal 2MB.
                            </p>
                            <div class="mt-2">
                                <input type="file" style="display:none;" id="photoInput">
                                <button class="btn btn-outline-primary btn-sm" onclick="document.getElementById('photoInput').click();">
                                    <i class="bi bi-upload"></i> Choose File
                                </button>
                                <span class="file-info ms-2"><i class="bi bi-file"></i> No file chosen</span>
                            </div>
                            <button class="btn btn-primary btn-sm mt-2">
                                <i class="bi bi-save"></i> Simpan Foto Profil
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== INFORMASI AKUN ===== -->
            <div class="settings-card">
                <div class="card-header">
                    <h5><i class="bi bi-info-circle"></i> Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="label"><i class="bi bi-calendar3"></i> Bergabung Sejak</div>
                            <div class="value">01 Januari 2026</div>
                        </div>
                        <div class="info-item">
                            <div class="label"><i class="bi bi-clock"></i> Terakhir Login</div>
                            <div class="value"><?php echo date('d M Y H:i:s'); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="label"><i class="bi bi-laptop"></i> Perangkat</div>
                            <div class="value"><i class="bi bi-windows"></i> Windows / Chrome</div>
                        </div>
                        <div class="info-item">
                            <div class="label"><i class="bi bi-shield"></i> Zona Berbahaya</div>
                            <div class="value" style="color:#dc2626;">
                                <i class="bi bi-exclamation-triangle"></i> Hapus Akun Saya
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== ZONA BERBAHAYA ===== -->
            <div class="settings-card">
                <div class="card-body">
                    <div class="danger-zone">
                        <h6><i class="bi bi-exclamation-triangle"></i> Zona Berbahaya</h6>
                        <p>Tindakan ini tidak dapat dibatalkan. Semua data akun Anda akan dihapus permanen.</p>
                        <button class="btn-danger-zone" onclick="if(confirm('Yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan!')){alert('Akun berhasil dihapus!');}">
                            <i class="bi bi-trash"></i> Hapus Akun Saya
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ===== FOOTER ===== -->
    <div class="footer">
        <i class="bi bi-c-circle"></i> 2026 Smart Event Campus - Universitas Potensi Utama
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>