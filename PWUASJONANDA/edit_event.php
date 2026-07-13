<?php
session_start();
require_once 'config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM events WHERE id=$id");
$event = mysqli_fetch_assoc($result);
if (!$event) { header("Location: dashboard.php"); exit(); }
$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $loc = mysqli_real_escape_string($conn, $_POST['location']);
    $cat = mysqli_real_escape_string($conn, $_POST['category']);
    $cap = (int)$_POST['capacity'];
    $speaker = mysqli_real_escape_string($conn, $_POST['speaker']);
    $update = "UPDATE events SET title='$title', description='$desc', event_date='$date', location='$loc', category='$cat', capacity=$cap, speaker='$speaker' WHERE id=$id";
    if (mysqli_query($conn, $update)) { 
        $msg = '<div class="alert alert-success">✅ Event berhasil diupdate!</div>';
        $event = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM events WHERE id=$id"));
    } else {
        $msg = '<div class="alert alert-danger">❌ Gagal mengupdate event!</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4" style="max-width:700px;">
    <h3><i class="bi bi-pencil" style="color:#667eea;"></i> Edit Event</h3>
    <?php echo $msg; ?>
    <div class="card p-4">
        <form method="POST">
            <div class="mb-3"><label class="form-label fw-bold">Nama Event</label><input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($event['title']); ?>" required></div>
            <div class="mb-3"><label class="form-label fw-bold">Deskripsi</label><textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($event['description']); ?></textarea></div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Kategori</label>
                    <select name="category" class="form-select">
                        <option <?php echo $event['category']=='Seminar'?'selected':''; ?>>Seminar</option>
                        <option <?php echo $event['category']=='Workshop'?'selected':''; ?>>Workshop</option>
                        <option <?php echo $event['category']=='Lomba'?'selected':''; ?>>Lomba</option>
                        <option <?php echo $event['category']=='Pelatihan'?'selected':''; ?>>Pelatihan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Tanggal</label><input type="date" name="event_date" class="form-control" value="<?php echo $event['event_date']; ?>" required></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Lokasi</label><input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($event['location']); ?>" required></div>
                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Peserta</label><input type="number" name="capacity" class="form-control" value="<?php echo $event['capacity']; ?>"></div>
            </div>
            <div class="mb-3"><label class="form-label fw-bold">Pembicara</label><input type="text" name="speaker" class="form-control" value="<?php echo htmlspecialchars($event['speaker']); ?>"></div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>