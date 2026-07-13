<?php
session_start();
require_once 'config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $loc = mysqli_real_escape_string($conn, $_POST['location']);
    $cat = mysqli_real_escape_string($conn, $_POST['category']);
    $cap = (int)$_POST['capacity'];
    $speaker = mysqli_real_escape_string($conn, $_POST['speaker']);
    $query = "INSERT INTO events (title, description, event_date, location, category, capacity, speaker, created_by) 
              VALUES ('$title', '$desc', '$date', '$loc', '$cat', $cap, '$speaker', ".$_SESSION['user_id'].")";
    if (mysqli_query($conn, $query)) { 
        $msg = '<div class="alert alert-success">✅ Event berhasil ditambahkan!</div>';
        header("Location: dashboard.php?msg=success");
        exit();
    } else {
        $msg = '<div class="alert alert-danger">❌ Gagal menambahkan event!</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4" style="max-width:700px;">
    <h3><i class="bi bi-plus-circle" style="color:#667eea;"></i> Tambah Event</h3>
    <?php echo $msg; ?>
    <div class="card p-4">
        <form method="POST">
            <div class="mb-3"><label class="form-label fw-bold">Nama Event</label><input type="text" name="title" class="form-control" required placeholder="Masukkan nama event"></div>
            <div class="mb-3"><label class="form-label fw-bold">Deskripsi</label><textarea name="description" class="form-control" rows="3"></textarea></div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Kategori</label>
                    <select name="category" class="form-select"><option>Seminar</option><option>Workshop</option><option>Lomba</option><option>Pelatihan</option></select>
                </div>
                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Tanggal</label><input type="date" name="event_date" class="form-control" required></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Lokasi</label><input type="text" name="location" class="form-control" required placeholder="Masukkan lokasi"></div>
                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Peserta</label><input type="number" name="capacity" class="form-control" placeholder="Jumlah peserta"></div>
            </div>
            <div class="mb-3"><label class="form-label fw-bold">Pembicara</label><input type="text" name="speaker" class="form-control" placeholder="Nama pembicara"></div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Event</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>