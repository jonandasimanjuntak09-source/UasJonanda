<?php
session_start();
require_once 'config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

$name = $_SESSION['name'] ?? 'Administrator';

$result = mysqli_query($conn, "SELECT e.*, u.name as admin FROM events e LEFT JOIN users u ON e.created_by = u.id ORDER BY e.event_date DESC");
$total = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - Smart Event Campus</title>
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

        .main-content { max-width: 1200px; margin: 0 auto; }

        /* ===== HEADER ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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
            color: #667eea;
            margin-right: 8px;
        }
        .page-header h1 small {
            display: block;
            font-size: 14px;
            font-weight: 400;
            color: #888;
            margin-top: 2px;
        }

        /* ===== CARD ===== */
        .card-panel {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden;
        }
        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f0f0f0;
            background: #fafbff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        .card-header h5 {
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            font-size: 15px;
        }
        .card-header h5 i {
            color: #667eea;
            margin-right: 6px;
        }
        .card-header .badge-count {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            padding: 3px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .card-body {
            padding: 14px 20px 20px;
            overflow-x: auto;
        }

        /* ===== TABLE ===== */
        .table-modern {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .table-modern thead th {
            text-align: left;
            padding: 12px 10px;
            color: #888;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f0f0f0;
        }
        .table-modern tbody td {
            padding: 12px 10px;
            border-bottom: 1px solid #f5f5f5;
            color: #333;
            vertical-align: middle;
        }
        .table-modern tbody tr:hover {
            background: #fafbff;
        }
        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== BADGE KATEGORI ===== */
        .badge-kategori {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            color: #fff;
            display: inline-block;
        }
        .badge-kategori.seminar { background: #4CAF50; }
        .badge-kategori.workshop { background: #FF9800; }
        .badge-kategori.lomba { background: #f44336; }
        .badge-kategori.pelatihan { background: #2196F3; }

        /* ===== STATUS BADGE ===== */
        .badge-status {
            padding: 4px 14px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-status.akan-datang {
            background: #fff3e0;
            color: #e65100;
        }
        .badge-status.selesai {
            background: #ffebee;
            color: #c62828;
        }
        .badge-status.aktif {
            background: #e8f5e9;
            color: #2e7d32;
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            padding: 15px 0 5px;
            color: #bbb;
            font-size: 12px;
            border-top: 1px solid #f0f0f0;
            margin-top: 20px;
        }
        .footer i {
            color: #667eea;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            body { padding: 10px; }
            .page-header { flex-direction: column; align-items: flex-start; }
            .page-header h1 { font-size: 20px; }
            .card-body { padding: 12px 14px 14px; }
            .table-modern { font-size: 12px; }
            .table-modern thead th, .table-modern tbody td { padding: 8px 6px; }
            .badge-kategori { font-size: 9px; padding: 2px 10px; }
            .badge-status { font-size: 9px; padding: 2px 10px; }
        }
        @media (max-width: 480px) {
            .table-modern { font-size: 11px; }
            .table-modern thead th, .table-modern tbody td { padding: 6px 4px; }
        }
    </style>
</head>
<body>

<!-- ========================================== -->
<!-- MAIN CONTENT
<!-- ========================================== -->
<div class="main-content">

    <!-- ===== HEADER ===== -->
    <div class="page-header">
        <div>
            <h1><i class="bi bi-clipboard"></i> Pendaftaran</h1>
            <small>Data pendaftaran event kampus</small>
        </div>
    </div>

    <!-- ===== CARD TABLE ===== -->
    <div class="card-panel">
        <div class="card-header">
            <h5><i class="bi bi-list-ul"></i> Daftar Pendaftaran</h5>
            <span class="badge-count"><?php echo $total; ?> Pendaftaran</span>
        </div>
        <div class="card-body">
            <?php if ($total > 0): ?>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th style="width:40px;">No</th>
                            <th>Event</th>
                            <th style="width:100px;">Kategori</th>
                            <th style="width:110px;">Tanggal</th>
                            <th style="width:150px;">Lokasi</th>
                            <th style="width:70px;">Peserta</th>
                            <th style="width:110px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; while ($row = mysqli_fetch_assoc($result)): 
                            $status = strtotime($row['event_date']) > time() ? 'akan-datang' : (strtotime($row['event_date']) == time() ? 'aktif' : 'selesai');
                            $statusLabel = $status == 'akan-datang' ? 'Akan Datang' : ($status == 'aktif' ? 'Aktif' : 'Selesai');
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                            <td>
                                <span class="badge-kategori <?php echo strtolower($row['category']); ?>">
                                    <?php echo $row['category']; ?>
                                </span>
                            </td>
                            <td><?php echo date('d M Y', strtotime($row['event_date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td><strong><?php echo $row['capacity']; ?></strong></td>
                            <td>
                                <span class="badge-status <?php echo $status; ?>">
                                    <?php echo $statusLabel; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-muted mt-3" style="font-size:13px;">
                <i class="bi bi-info-circle"></i> Menampilkan <?php echo $total; ?> data pendaftaran
            </div>
            <?php else: ?>
            <div class="text-center py-4">
                <i class="bi bi-clipboard" style="font-size:40px;color:#ddd;"></i>
                <h6 class="mt-2">Belum Ada Pendaftaran</h6>
                <p class="text-muted" style="font-size:13px;">Belum ada data pendaftaran event.</p>
            </div>
            <?php endif; ?>
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