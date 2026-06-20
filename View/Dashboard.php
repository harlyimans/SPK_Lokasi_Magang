<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: Login.php");
    exit;
}
?>

<h2>Dashboard</h2>

Selamat datang,
<b><?= htmlspecialchars($_SESSION['nama']) ?></b>

<br><br>

<a href="../Functions/logout.php">Logout</a>