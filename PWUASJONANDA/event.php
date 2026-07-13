<?php
session_start();
require_once 'config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

$result = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date DESC");
$total = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Smart Event Campus</title>
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

        .main-content { max-width: 1300px; margin: 0 auto; }

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
        .page-header h1 small {
            display: block;
            font-size: 14px;
            font-weight: 400;
            color: #888;
            margin-top: 2px;
        }
        .page-header h1 i { color: #667eea; margin-right: 8px; }
        .page-header .btn-add {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            padding: 8px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .page-header .btn-add:hover {
            transform: scale(1.05);
            color: #fff;
        }

        /* ===== CARD ===== */
        .card-table {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden;
        }
        .card-table .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f0f0f0;
            background: #fafbff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        .card-table .card-header h5 {
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            font-size: 15px;
        }
        .card-table .card-header h5 i {
            color: #667eea;
            margin-right: 8px;
        }
        .card-table .card-header .badge-count {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            padding: 3px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .card-table .card-body {
            padding: 14px 20px 20px;
            overflow-x: auto;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        thead th {
            text-align: left;
            padding: 12px 10px;
            color: #888;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f0f0f0;
        }
        tbody td {
            padding: 12px 10px;
            border-bottom: 1px solid #f5f5f5;
            color: #333;
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #fafbff; }

        /* ===== BADGE ===== */
        .badge-kategori {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            color: #fff;
            display: inline-block;
        }
        .badge-kategori.seminar { background: #4CAF50; }
        .badge-kategori.workshop { background: #FF9800; }
        .badge-kategori.lomba { background: #f44336; }
        .badge-kategori.pelatihan { background: #2196F3; }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
        }
        .status-badge.active { background: #e8f5e9; color: #2e7d32; }
        .status-badge.upcoming { background: #fff3e0; color: #e65100; }
        .status-badge.completed { background: #ffebee; color: #c62828; }

        /* ========================================== */
        /* ACTION BUTTON - HORIZONTAL
        /* ========================================== */
        .action-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .btn-action {
            padding: 5px 16px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 11px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-action i {
            font-size: 13px;
        }

        /* Tombol Lihat - Biru */
        .btn-action.view {
            background: #e3f2fd;
            color: #0d47a1;
        }
        .btn-action.view:hover {
            background: #2196F3;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(33,150,243,0.3);
        }

        /* Tombol Edit - Hijau */
        .btn-action.edit {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .btn-action.edit:hover {
            background: #4CAF50;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76,175,80,0.3);
        }

        /* Tombol Hapus - Merah */
        .btn-action.delete {
            background: #ffebee;
            color: #c62828;
        }
        .btn-action.delete:hover {
            background: #f44336;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(244,67,54,0.3);
        }

        /* ===== PAGINATION ===== */
        .pagination-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid #f0f0f0;
            margin-top: 4px;
        }
        .pagination-info .info {
            color: #888;
            font-size: 13px;
        }
        .pagination-info .info i { color: #667eea; margin-right: 4px; }
        .pagination-info .page-numbers {
            display: flex;
            gap: 4px;
        }
        .pagination-info .page-numbers .page {
            padding: 4px 12px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            background: #fff;
            color: #555;
            font-weight: 600;
            font-size: 13px;
            transition: 0.3s;
            cursor: pointer;
        }
        .pagination-info .page-numbers .page:hover {
            background: #667eea;
            color: #fff;
            border-color: #667eea;
        }
        .pagination-info .page-numbers .page.active {
            background: #667eea;
            color: #fff;
            border-color: #667eea;
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
        .footer i { color: #667eea; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            body { padding: 10px; }
            .page-header { flex-direction: column; align-items: flex-start; }
            .page-header .btn-add { width: 100%; justify-content: center; }
            table { font-size: 11px; }
            thead th, tbody td { padding: 8px 5px; }
            .action-group { gap: 4px; flex-wrap: wrap; }
            .btn-action { padding: 4px 10px; font-size: 9px; }
            .btn-action i { font-size: 10px; }
            .badge-kategori { font-size: 8px; padding: 2px 8px; }
            .status-badge { font-size: 8px; padding: 2px 6px; }
            .pagination-info { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<div class="main-content">

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1><i class="bi bi-calendar2-week"></i> Events</h1>
            <small>Kelola semua event kampus dalam satu platform</small>
        </div>
        <a href="tambah_event.php" class="btn-add"><i class="bi bi-plus-circle"></i> Tambah Event</a>
    </div>

    <!-- Table -->
    <div class="card-table">
        <div class="card-header">
            <h5><i class="bi bi-table"></i> Table</h5>
            <span class="badge-count"><?php echo $total; ?> Entries</span>
        </div>
        <div class="card-body">
            <?php if ($total > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th style="width:30px;">No</th>
                        <th>Title</th>
                        <th style="width:100px;">Kategori</th>
                        <th style="width:100px;">Start Date</th>
                        <th style="width:100px;">End Date</th>
                        <th style="width:100px;">Publisher</th>
                        <th style="width:80px;">Status</th>
                        <th style="width:150px;">Updated At</th>
                        <th style="width:200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    while ($row = mysqli_fetch_assoc($result)): 
                        $status = strtotime($row['event_date']) > time() ? 'upcoming' : (strtotime($row['event_date']) == time() ? 'active' : 'completed');
                        $statusLabel = $status == 'upcoming' ? 'Upcoming' : ($status == 'active' ? 'Active' : 'Completed');
                        $publisher = $_SESSION['name'] ?? 'Administrator';
                        $updatedAt = $row['created_at'] ?? date('Y-m-d H:i:s');
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                        <td>
                            <span class="badge-kategori <?php echo strtolower($row['category']); ?>">
                                <?php echo $row['category']; ?>
                            </span>
                        </td>
                        <td><?php echo date('Y-m-d', strtotime($row['event_date'])); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($row['event_date'] . ' +1 day')); ?></td>
                        <td><?php echo htmlspecialchars($publisher); ?></td>
                        <td>
                            <span class="status-badge <?php echo $status; ?>">
                                <?php echo $statusLabel; ?>
                            </span>
                        </td>
                        <td><?php echo date('Y-m-d H:i:s', strtotime($updatedAt)); ?></td>
                        <td>
                            <div class="action-group">
                                <a href="detail_event.php?id=<?php echo $row['id']; ?>" class="btn-action view" title="Lihat Detail">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <a href="edit_event.php?id=<?php echo $row['id']; ?>" class="btn-action edit" title="Edit Event">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="hapus_event.php?id=<?php echo $row['id']; ?>" class="btn-action delete" title="Hapus Event" onclick="return confirm('Yakin ingin menghapus event ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination-info">
                <span class="info">
                    <i class="bi bi-info-circle"></i> Menampilkan 1 hingga <?php echo min(7, $total); ?> dari <?php echo $total; ?> data
                </span>
                <div class="page-numbers">
                    <span class="page active">1</span>
                    <?php if ($total > 7): ?>
                    <span class="page">2</span>
                    <span class="page">3</span>
                    <span class="page">...</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="text-center py-4">
                <i class="bi bi-calendar-x" style="font-size:40px;color:#ddd;"></i>
                <h5 class="mt-2">Belum Ada Event</h5>
                <p class="text-muted">Klik "Tambah Event" untuk menambahkan acara baru.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <i class="bi bi-c-circle"></i> 2026 Smart Event Campus - Universitas Potensi Utama
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>