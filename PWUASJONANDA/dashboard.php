<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$name = $_SESSION['name'] ?? 'Administrator';

// Statistik
$totalEvent = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM events"))['c'] ?? 0;
$totalPeserta = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(capacity) as total FROM events"))['total'] ?? 0;
$totalKategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT category) as c FROM events"))['c'] ?? 0;
$totalLokasi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT location) as c FROM events"))['c'] ?? 0;

// Event terbaru
$events = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date DESC LIMIT 5");
$totalEvents = mysqli_num_rows($events);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Smart Event Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* ========================================== */
        /* RESET & GLOBAL
        /* ========================================== */
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        /* ========================================== */
        /* ANIMASI
        /* ========================================== */
        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(20px); }
            to { opacity:1; transform:translateY(0); }
        }
        @keyframes slideInLeft {
            from { opacity:0; transform:translateX(-16px); }
            to { opacity:1; transform:translateX(0); }
        }
        .animate-fade { animation: fadeInUp 0.6s ease forwards; }
        .animate-slide { animation: slideInLeft 0.5s ease forwards; }
        .delay-1 { animation-delay:0.08s; }
        .delay-2 { animation-delay:0.16s; }
        .delay-3 { animation-delay:0.24s; }
        .delay-4 { animation-delay:0.32s; }

        /* ========================================== */
        /* MAIN CONTENT
        /* ========================================== */
        .main-content {
            padding: 24px 20px 40px;
            max-width: 1320px;
            margin: 0 auto;
        }

        /* ========================================== */
        /* HERO CARD
        /* ========================================== */
        .hero-card {
            background: linear-gradient(135deg, #5b7cff, #7c4dff);
            border-radius: 22px;
            padding: 30px 32px;
            color: #fff;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(91,124,255,0.22);
        }
        .hero-card::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -8%;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        .hero-card .hero-content { position: relative; z-index: 1; }
        .hero-card h2 { font-weight: 800; font-size: 26px; margin-bottom: 8px; }
        .hero-card p { opacity: 0.95; font-size: 15px; margin: 0; }
        .hero-icon {
            position: absolute;
            right: 30px;
            bottom: 10px;
            font-size: 86px;
            opacity: 0.14;
            z-index: 0;
        }

        /* ========================================== */
        /* STATISTIK
        /* ========================================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 22px;
        }
        .stat-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 10px 24px rgba(15,23,42,0.04);
            transition: 0.25s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(15,23,42,0.08);
        }
        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }
        .stat-number { font-size: 26px; font-weight: 800; color: #1f2937; line-height: 1.2; }
        .stat-label { font-size: 13px; color: #6b7280; font-weight: 600; margin-top: 2px; }
        .stat-sub { font-size: 12px; color: #9ca3af; margin-top: 2px; }
        .stat-icon {
            width: 46px; height: 46px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: #fff; flex-shrink: 0;
        }
        .stat-icon.purple { background: linear-gradient(135deg, #5b7cff, #7c4dff); }
        .stat-icon.green { background: linear-gradient(135deg, #34c759, #16a34a); }
        .stat-icon.orange { background: linear-gradient(135deg, #ffb347, #ff7f50); }
        .stat-icon.blue { background: linear-gradient(135deg, #38bdf8, #2563eb); }

        /* ========================================== */
        /* CARD PANEL
        /* ========================================== */
        .card-panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(15,23,42,0.04);
            overflow: hidden;
            margin-bottom: 22px;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f2f4f7;
            background: #fcfdff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .card-header h5 {
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            font-size: 16px;
        }
        .card-header h5 i { color: #5b7cff; margin-right: 8px; }
        .card-body { padding: 18px 20px 20px; }

        /* ========================================== */
        /* FORM
        /* ========================================== */
        .form-label {
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            margin-bottom: 4px;
            display: block;
        }
        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid #dbe2ea;
            padding: 10px 12px;
            font-size: 14px;
            transition: 0.2s ease;
            width: 100%;
        }
        .form-control:focus, .form-select:focus {
            border-color: #5b7cff;
            box-shadow: 0 0 0 3px rgba(91,124,255,0.12);
        }
        .btn-simpan {
            background: linear-gradient(135deg, #5b7cff, #7c4dff);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 700;
            transition: 0.2s ease;
            width: 100%;
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 14px;
        }
        .btn-simpan:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(91,124,255,0.2);
            color: #fff;
        }

        /* ========================================== */
        /* TABLE
        /* ========================================== */
        .badge-count {
            background: linear-gradient(135deg, #5b7cff, #7c4dff);
            color: #fff;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }
        .table-modern {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .table-modern thead th {
            text-align: left;
            padding: 12px 10px;
            color: #8b95a6;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eef2f7;
        }
        .table-modern tbody td {
            padding: 12px 10px;
            border-bottom: 1px solid #f4f6f9;
            color: #374151;
            vertical-align: middle;
        }
        .table-modern tbody tr:hover { background: #fbfcff; }

        /* ========================================== */
        /* BADGE
        /* ========================================== */
        .badge-kategori {
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
        }
        .badge-kategori.seminar { background: #34c759; }
        .badge-kategori.workshop { background: #ffb347; }
        .badge-kategori.lomba { background: #ff5d5d; }
        .badge-kategori.pelatihan { background: #38bdf8; }

        /* ========================================== */
        /* ACTION
        /* ========================================== */
        .btn-action {
            padding: 5px 9px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 12px;
            text-decoration: none;
            transition: 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-right: 4px;
        }
        .btn-action.view { background: #e8f0ff; color: #2563eb; }
        .btn-action.view:hover { background: #2563eb; color: #fff; }
        .btn-action.edit { background: #eaf7ee; color: #16a34a; }
        .btn-action.edit:hover { background: #16a34a; color: #fff; }
        .btn-action.delete { background: #fff0f0; color: #dc2626; }
        .btn-action.delete:hover { background: #dc2626; color: #fff; }

        /* ========================================== */
        /* FOOTER
        /* ========================================== */
        .footer {
            text-align: center;
            padding: 12px 0 0;
            color: #9ca3af;
            font-size: 13px;
            border-top: 1px solid #eef2f7;
            margin-top: 10px;
        }
        .footer i { color: #5b7cff; }

        /* ========================================== */
        /* RESPONSIVE
        /* ========================================== */
        @media (max-width: 992px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .main-content { padding: 16px 14px 30px; }
            .hero-card { padding: 22px 20px; }
            .hero-card h2 { font-size: 22px; }
            .hero-icon { display: none; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .card-body { padding: 16px; }
            .table-modern { font-size: 12px; }
            .table-modern th, .table-modern td { padding: 8px 6px; }
            .btn-action { padding: 4px 7px; font-size: 10px; }
            .btn-simpan { min-height: 40px; font-size: 13px; padding: 8px 12px; }
        }
        @media (max-width: 576px) {
            .stats-grid { grid-template-columns: 1fr; }
            .col-sm-6 { flex: 0 0 50%; max-width: 50%; }
            .btn-simpan { min-height: 38px; font-size: 12px; }
        }
        @media (max-width: 480px) {
            .col-sm-6 { flex: 0 0 100%; max-width: 100%; }
            .btn-simpan { min-height: 44px; }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="main-content">

    <!-- ===== HERO ===== -->
    <div class="hero-card animate-fade">
        <div class="hero-content">
            <h2><i class="bi bi-person-circle"></i> Selamat Datang, <?php echo htmlspecialchars($name); ?>!</h2>
            <p>Kelola data event kampus dengan tampilan yang lebih rapi, cepat, dan mudah dipantau.</p>
        </div>
        <div class="hero-icon"><i class="bi bi-calendar-event"></i></div>
    </div>

    <!-- ===== STATISTIK ===== -->
    <div class="stats-grid">
        <div class="stat-card animate-slide delay-1">
            <div class="stat-top">
                <div>
                    <div class="stat-number"><?php echo $totalEvent; ?></div>
                    <div class="stat-label">Total Event</div>
                    <div class="stat-sub">Event aktif dan mendatang</div>
                </div>
                <div class="stat-icon purple"><i class="bi bi-calendar-event"></i></div>
            </div>
        </div>
        <div class="stat-card animate-slide delay-2">
            <div class="stat-top">
                <div>
                    <div class="stat-number"><?php echo number_format($totalPeserta); ?></div>
                    <div class="stat-label">Peserta Terdaftar</div>
                    <div class="stat-sub">Total kapasitas event</div>
                </div>
                <div class="stat-icon green"><i class="bi bi-people"></i></div>
            </div>
        </div>
        <div class="stat-card animate-slide delay-3">
            <div class="stat-top">
                <div>
                    <div class="stat-number"><?php echo $totalKategori; ?></div>
                    <div class="stat-label">Kategori Event</div>
                    <div class="stat-sub">Seminar, Workshop, Lomba, dll</div>
                </div>
                <div class="stat-icon orange"><i class="bi bi-tags"></i></div>
            </div>
        </div>
        <div class="stat-card animate-slide delay-4">
            <div class="stat-top">
                <div>
                    <div class="stat-number"><?php echo $totalLokasi; ?></div>
                    <div class="stat-label">Lokasi Event</div>
                    <div class="stat-sub">Lokasi berbeda tersedia</div>
                </div>
                <div class="stat-icon blue"><i class="bi bi-geo-alt"></i></div>
            </div>
        </div>
    </div>

    <!-- ===== FORM INPUT EVENT ===== -->
    <div class="card-panel animate-fade">
        <div class="card-header">
            <h5><i class="bi bi-plus-circle"></i> Input Data Event</h5>
            <a href="tambah_event.php" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Event
            </a>
        </div>
        <div class="card-body">
            <form action="tambah_event.php" method="POST">
                <div class="row g-3 align-items-end">
                    <!-- Kolom 1: Nama Event -->
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label"><i class="bi bi-pencil"></i> Nama Event</label>
                        <input type="text" name="title" class="form-control" placeholder="Nama Event" required>
                    </div>
                    <!-- Kolom 2: Kategori -->
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label"><i class="bi bi-tags"></i> Kategori</label>
                        <select name="category" class="form-select">
                            <option value="Seminar">Seminar</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Lomba">Lomba</option>
                            <option value="Pelatihan">Pelatihan</option>
                        </select>
                    </div>
                    <!-- Kolom 3: Tanggal -->
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label"><i class="bi bi-calendar3"></i> Tanggal</label>
                        <input type="date" name="event_date" class="form-control" required>
                    </div>
                    <!-- Kolom 4: Tombol Simpan -->
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label" style="visibility:hidden;">&nbsp;</label>
                        <button type="submit" class="btn-simpan w-100">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== TABLE EVENT ===== -->
    <div class="card-panel animate-fade">
        <div class="card-header">
            <h5><i class="bi bi-list-ul"></i> Daftar Event</h5>
            <span class="badge-count"><?php echo $totalEvents; ?> event</span>
        </div>
        <div class="card-body">
            <?php if ($totalEvents > 0): ?>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th style="width:50px;">No</th>
                            <th>Nama Event</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Peserta</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($events)): ?>
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
                            <td><?php echo $row['capacity']; ?></td>
                            <td>
                                <a href="detail_event.php?id=<?php echo $row['id']; ?>" class="btn-action view" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="edit_event.php?id=<?php echo $row['id']; ?>" class="btn-action edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="hapus_event.php?id=<?php echo $row['id']; ?>" class="btn-action delete" title="Hapus" onclick="return confirm('Yakin hapus?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-muted mt-3" style="font-size:13px;">
                <i class="bi bi-info-circle"></i> Menampilkan <?php echo min(5, $totalEvents); ?> dari <?php echo $totalEvents; ?> hasil
            </div>
            <?php else: ?>
            <div class="text-center py-4">
                <i class="bi bi-calendar-x" style="font-size:40px;color:#d1d5db;"></i>
                <h6 class="mt-2">Belum Ada Event</h6>
                <p class="text-muted" style="font-size:13px;">Klik "Tambah Event" untuk menambahkan acara baru.</p>
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