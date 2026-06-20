<?php
// Konfigurasi Database
$host     = "localhost";
$username = "root";
$password = "";
$database = "spk_lokasi_magang";

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Mengatur charset UTF-8
mysqli_set_charset($conn, "utf8");
?>