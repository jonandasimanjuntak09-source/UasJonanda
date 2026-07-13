<?php
session_start();
require_once 'config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM events WHERE id=$id");
$event = mysqli_fetch_assoc($result);
if (!$event) { header("Location: dashboard.php"); exit(); }
$status = strtotime($event['event_date']) > time() ? 'Akan Datang' : 'Selesai';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4" style="max-width:800px;">
    <h3><i class="bi bi-info-circle" style="color:#667eea;"></i> Detail Event</h3>
    <div class="card">
        <div class="card-header bg-light fw-bold"><?php echo htmlspecialchars($event['title']); ?></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><strong>Kategori:</strong> <span class="badge bg-primary"><?php echo $event['category']; ?></span></div>
                <div class="col-md-6"><strong>Tanggal:</strong> <?php echo date('d F Y', strtotime($event['event_date'])); ?></div>
                <div class="col-md-6 mt-2"><strong>Lokasi:</strong> <?php echo htmlspecialchars($event['location']); ?></div>
                <div class="col-md-6 mt-2"><strong>Peserta:</strong> <?php echo $event['capacity']; ?> orang</div>
                <div class="col-md-6 mt-2"><strong>Pembicara:</strong> <?php echo $event['speaker'] ? htmlspecialchars($event['speaker']) : '-'; ?></div>
                <div class="col-md-6 mt-2"><strong>Status:</strong> <span class="badge bg-warning text-dark"><?php echo $status; ?></span></div>
                <div class="col-12 mt-3"><strong>Deskripsi:</strong><br><?php echo $event['description'] ? nl2br(htmlspecialchars($event['description'])) : 'Tidak ada deskripsi.'; ?></div>
            </div>
            <div class="mt-4">
                <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-primary">Edit</a>
                <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>