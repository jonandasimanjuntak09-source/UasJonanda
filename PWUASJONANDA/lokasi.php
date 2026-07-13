<?php
session_start();
require_once 'config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

$result = mysqli_query($conn, "SELECT location, COUNT(*) as total FROM events GROUP BY location ORDER BY total DESC");
$total = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi - Smart Event Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif; background:#f0f4f8; padding:20px; }
        .main-content { max-width:900px; margin:0 auto; }
        .page-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px; padding: 18px 24px; color: #fff; margin-bottom:20px;
        }
        .page-header h1 { font-size:22px; font-weight:800; margin:0; }
        .page-header p { opacity:0.85; font-size:14px; margin:2px 0 0; }
        .card { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.04); border:1px solid rgba(0,0,0,0.03); overflow:hidden; }
        .card-header { padding:12px 20px; border-bottom:1px solid #f0f0f0; background:#fafbff; display:flex; justify-content:space-between; align-items:center; }
        .card-header h5 { font-weight:700; color:#1a1a2e; margin:0; font-size:15px; }
        .card-header h5 i { color:#667eea; margin-right:6px; }
        .card-header .badge-count { background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; padding:2px 14px; border-radius:20px; font-size:12px; font-weight:600; }
        .card-body { padding:12px 18px 18px; overflow-x:auto; }
        table { width:100%; border-collapse:collapse; font-size:13px; }
        th { text-align:left; padding:10px 8px; color:#888; font-weight:600; font-size:10px; text-transform:uppercase; border-bottom:2px solid #f0f0f0; }
        td { padding:10px 8px; border-bottom:1px solid #f5f5f5; color:#333; vertical-align:middle; }
        tr:hover { background:#fafbff; }
        .btn-action { padding:3px 8px; border:none; border-radius:5px; font-weight:600; font-size:10px; text-decoration:none; display:inline-flex; align-items:center; gap:2px; transition:0.3s; }
        .btn-action.view { background:#e3f2fd; color:#0d47a1; }
        .btn-action.view:hover { background:#2196F3; color:#fff; }
        .footer { text-align:center; padding:15px 0 5px; color:#bbb; font-size:12px; border-top:1px solid #f0f0f0; margin-top:20px; }
        @media (max-width:768px) { body { padding:10px; } .page-header { flex-direction:column; align-items:flex-start; } }
    </style>
</head>
<body>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1><i class="bi bi-geo-alt"></i> Lokasi Event</h1>
            <p>Daftar lokasi event yang tersedia</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><i class="bi bi-list-ul"></i> Daftar Lokasi</h5>
            <span class="badge-count"><?php echo $total; ?> Lokasi</span>
        </div>
        <div class="card-body">
            <?php if ($total > 0): ?>
            <table>
                <thead><tr><th>No</th><th>Lokasi</th><th>Jumlah Event</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php $no=1; while($row=mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><i class="bi bi-geo-alt"></i> <?php echo $row['location']; ?></td>
                        <td><?php echo $row['total']; ?> event</td>
                        <td><a href="event.php?location=<?php echo urlencode($row['location']); ?>" class="btn-action view"><i class="bi bi-eye"></i> Lihat</a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="text-center py-3"><i class="bi bi-geo-alt" style="font-size:32px;color:#ddd;"></i><h5 class="mt-2">Belum Ada Lokasi</h5></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer"><i class="bi bi-c-circle"></i> 2026 Smart Event Campus</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>