<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

// Cek apakah id ada
if (!isset($_GET['id'])) {

    $_SESSION['error'] = "ID tidak ditemukan.";

    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// Cek apakah data ada
$cek = mysqli_query($conn, "
SELECT *
FROM kriteria
WHERE id_kriteria = '$id'
");

if (mysqli_num_rows($cek) == 0) {

    $_SESSION['error'] = "Data tidak ditemukan.";

    header("Location: index.php");
    exit;
}

// Hapus data
$query = mysqli_query($conn, "
DELETE FROM kriteria
WHERE id_kriteria = '$id'
");

if ($query) {

    $_SESSION['success'] = "Data berhasil dihapus.";
} else {

    $_SESSION['error'] = "Data gagal dihapus.";
}

header("Location: index.php");
exit;
