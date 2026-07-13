<?php
session_start();
require_once 'config/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
$id = (int)$_GET['id'];
mysqli_query($conn, "DELETE FROM events WHERE id=$id");
header("Location: dashboard.php");
exit();
?>