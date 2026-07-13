<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    header('Location: index.php?error=1');
    exit;
}

if (!isset($conn) || !$conn) {
    header('Location: index.php?error=1');
    exit;
}

$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

$result = mysqli_query($conn, "SELECT id, name, username FROM users WHERE username='$username' AND password=MD5('$password') LIMIT 1");

if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['username'] = $user['username'];
    header('Location: dashboard.php');
} else {
    header('Location: index.php?error=1');
}

exit;
?>