<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $msg = '<div class="alert alert-success">✅ Tema berhasil diubah!</div>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif; background:#f0f4f8; padding:20px; }
        .main-content { max-width:1100px; margin:0 auto; }
        .page-header { margin-bottom:25px; }
        .page-header h1 { font-size:24px; font-weight:800; color:#1a1a2e; }
        .page-header h1 i { color:#5b7cff; margin-right:10px; }
        .page-header h1 small { display:block; font-size:14px; font-weight:400; color:#888; margin-top:2px; }
        .settings-grid { display:grid; grid-template-columns:220px 1fr; gap:24px; }
        .settings-sidebar { background:#fff; border-radius:16px; border:1px solid #e5e7eb; overflow:hidden; }
        .settings-sidebar .sidebar-header { padding:14px 18px; border-bottom:1px solid #f0f0f0; background:#fafbff; }
        .settings-sidebar .sidebar-header h6 { font-weight:700; color:#1a1a2e; margin:0; font-size:12px; text-transform:uppercase; }
        .settings-sidebar .menu-item { display:flex; align-items:center; gap:10px; padding:10px 18px; color:#6b7280; text-decoration:none; font-size:13px; font-weight:500; transition:0.3s; border-left:3px solid transparent; }
        .settings-sidebar .menu-item:hover { background:#f8faff; color:#1a1a2e; }
        .settings-sidebar .menu-item.active { background:#f0f4ff; color:#5b7cff; border-left-color:#5b7cff; }
        .settings-sidebar .menu-item i { font-size:16px; width:18px; }
        .settings-sidebar .menu-divider { height:1px; background:#f0f0f0; margin:4px 14px; }
        .settings-card { background:#fff; border-radius:16px; border:1px solid #e5e7eb; overflow:hidden; }
        .settings-card .card-header { padding:16px 24px; border-bottom:1px solid #f0f0f0; background:#fafbff; }
        .settings-card .card-header h5 { font-weight:700; color:#1a1a2e; margin:0; font-size:16px; }
        .settings-card .card-body { padding:24px; }
        .form-group { margin-bottom:18px; }
        .form-group label { font-weight:600; color:#374151; font-size:13px; display:block; margin-bottom:4px; }
        .form-control, .form-select { border-radius:10px; border:1px solid #dbe2ea; padding:10px 14px; font-size:14px; width:100%; }
        .btn-save { background:linear-gradient(135deg,#5b7cff,#7c4dff); color:#fff; border:none; border-radius:10px; padding:10px 30px; font-weight:700; transition:0.3s; }
        .btn-save:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(91,124,255,0.3); color:#fff; }
        .theme-option { display:flex; align-items:center; gap:12px; padding:12px 16px; border:2px solid #e5e7eb; border-radius:10px; cursor:pointer; transition:0.3s; }
        .theme-option:hover { border-color:#5b7cff; background:#f8faff; }
        .theme-option input[type="radio"] { accent-color:#5b7cff; }
        .footer { text-align:center; padding:18px 0 5px; color:#bbb; font-size:13px; border-top:1px solid #f0f0f0; margin-top:25px; }
        @media (max-width:992px) { .settings-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="main-content">
    <div class="page-header">
        <h1><i class="bi bi-palette"></i> Tampilan <small>Kelola tampilan dan tema aplikasi</small></h1>
    </div>
    <div class="settings-grid">
        <div class="settings-sidebar">
            <div class="sidebar-header"><h6><i class="bi bi-list-ul"></i> Menu</h6></div>
            <a href="pengaturan.php" class="menu-item"><i class="bi bi-person"></i> Profil Akun</a>
            <a href="keamanan.php" class="menu-item"><i class="bi bi-shield-lock"></i> Keamanan Akun</a>
            <a href="tampilan.php" class="menu-item active"><i class="bi bi-palette"></i> Tampilan</a>
            <a href="notifikasi.php" class="menu-item"><i class="bi bi-bell"></i> Notifikasi</a>
            <div class="menu-divider"></div>
            <a href="backup.php" class="menu-item"><i class="bi bi-database"></i> Backup Data</a>
            <a href="logout.php" class="menu-item" style="color:#dc2626;"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
        <div class="settings-card">
            <div class="card-header"><h5><i class="bi bi-palette"></i> Tampilan</h5></div>
            <div class="card-body">
                <?php echo $msg; ?>
                <form method="POST">
                    <div class="form-group">
                        <label><i class="bi bi-moon"></i> Pilih Tema</label>
                        <div class="d-flex gap-3 flex-wrap">
                            <label class="theme-option flex-1"><input type="radio" name="theme" value="light" checked> <i class="bi bi-sun" style="color:#f59e0b;"></i> Terang</label>
                            <label class="theme-option flex-1"><input type="radio"name="theme" value="dark"> <i class="bi bi-moon" style="color:#1a1a2e;"></i> Gelap</label>
                            <label class="theme-option flex-1"><input type="radio" name="theme" value="system"> <i class="bi bi-desktop"></i> Sistem</label>
                        </div>
                    </div>
                    <button type="submit" class="btn-save"><i class="bi bi-save"></i> Simpan Tema</button>
                </form>
            </div>
        </div>
    </div>
    <div class="footer"><i class="bi bi-c-circle"></i> 2026 Smart Event Campus</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>