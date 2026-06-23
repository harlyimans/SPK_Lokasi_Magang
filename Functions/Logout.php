<?php
session_start();

// Hapus semua session
$_SESSION = [];

// Hapus session
session_destroy();

// Redirect ke halaman login
header("Location: ../View/Login.php");
exit;