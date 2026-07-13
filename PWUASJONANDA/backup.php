<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $msg = '<div class="alert alert-success">✅ Backup data berhasil dibuat!</div>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup Data</title>
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
        .btn-backup { background:linear-gradient(135deg,#5b7cff,#7c4dff); color:#fff; border:none; border-radius:10px; padding:12px 30px; font-weight:700; transition:0.3s; width:100%; }
        .btn-backup:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(91,124,255,0.3); color:#fff; }
        .backup-list { border:1px solid #e5e7eb; border-radius:10px; overflow:hidden; }
        .backup-item { display:flex; justify-content:space-between; align-items:center; padding:12px 16px; border-bottom:1px solid #f0f0f0; }
        .backup-item:last-child { border-bottom:none; }
        .backup-item .info .name { font-weight:600; color:#1a1a2e; font-size:14px; }
        .backup-item .info .date { font-size:12px; color:#888; }
        .btn-download { background:#f0f4ff; color:#5b7cff; border:none; border-radius:6px; padding:4px 14px; font-weight:600; font-size:12px; transition:0.3s; }
        .btn-download:hover { background:#5b7cff; color:#fff; }
        .footer { text-align:center; padding:18px 0 5px; color:#bbb; font-size:13px; border-top:1px solid #f0f0f0; margin-top:25px; }
        @media (max-width:992px) { .settings-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="main-content">
    <div class="page-header">
        <h1><i class="bi bi-database"></i> Backup Data <small>Kelola backup data sistem</small></h1>
    </div>
    <div class="settings-grid">
        <div class="settings-sidebar">
            <div class="sidebar-header"><h6><i class="bi bi-list-ul"></i> Menu</h6></div>
            <a href="pengaturan.php" class="menu-item"><i class="bi bi-person"></i> Profil Akun</a>
            <a href="keamanan.php" class="menu-item"><i class="bi bi-shield-lock"></i> Keamanan Akun</a>
            <a href="tampilan.php" class="menu-item"><i class="bi bi-palette"></i> Tampilan</a>
            <a href="notifikasi.php" class="menu-item"><i class="bi bi-bell"></i> Notifikasi</a>
            <div class="menu-divider"></div>
            <a href="backup.php" class="menu-item active"><i class="bi bi-database"></i> Backup Data</a>
            <a href="logout.php" class="menu-item" style="color:#dc2626;"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
        <div class="settings-card">
            <div class="card-header"><h5><i class="bi bi-database"></i> Backup Data</h5></div>
            <div class="card-body">
                <?php echo $msg; ?>
                <form method="POST"><button type="submit" class="btn-backup"><i class="bi bi-cloud-arrow-down"></i> Buat Backup Sekarang</button></form>
                <hr>
                <h6 style="font-weight:700;color:#1a1a2e;margin-bottom:12px;">Riwayat Backup</h6>
                <div class="backup-list">
                    <div class="backup-item"><div class="info"><div class="name">backup_smart_event_20260712.sql</div><div class="date"><i class="bi bi-clock"></i> 12 Juli 2026, 14:30</div></div><button class="btn-download"><i class="bi bi-download"></i> Download</button></div>
                    <div class="backup-item"><div class="info"><div class="name">backup_smart_event_20260711.sql</div><div class="date"><i class="bi bi-clock"></i> 11 Juli 2026, 10:15</div></div><button class="btn-download"><i class="bi bi-download"></i> Download</button></div>
                    <div class="backup-item"><div class="info"><div class="name">backup_smart_event_20260710.sql</div><div class="date"><i class="bi bi-clock"></i> 10 Juli 2026, 08:45</div></div><button class="btn-download"><i class="bi bi-download"></i> Download</button></div>
                </div>
                <small style="color:#888;font-size:12px;display:block;margin-top:10px;"><i class="bi bi-info-circle"></i> Backup disimpan sebagai file SQL</small>
            </div>
        </div>
    </div>
    <div class="footer"><i class="bi bi-c-circle"></i> 2026 Smart Event Campus</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>