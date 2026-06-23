<?php

session_start();

include "../../Connection/Koneksi.php";

$id = $_POST['id'];
$nama = $_POST['nama_kriteria'];
$atribut = $_POST['atribut'];
$bobot = $_POST['bobot'];

$query = mysqli_query($conn, "
UPDATE kriteria
SET
nama_kriteria='$nama',
atribut='$atribut',
bobot='$bobot'
WHERE id_kriteria='$id'
");

if ($query) {

    $_SESSION['success'] = "Data berhasil diubah.";
} else {

    $_SESSION['error'] = "Data gagal diubah.";
}

header("Location: ../../View/Data Kriteria/index.php");
exit;
