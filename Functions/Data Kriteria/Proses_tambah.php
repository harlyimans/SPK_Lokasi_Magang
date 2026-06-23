<?php

session_start();

include "../../Connection/Koneksi.php";

$kode = $_POST['kode'];
$nama = $_POST['nama_kriteria'];
$atribut = $_POST['atribut'];
$bobot = $_POST['bobot'];

$query = mysqli_query($conn, "
INSERT INTO kriteria
(
kode,
nama_kriteria,
atribut,
bobot
)
VALUES
(
'$kode',
'$nama',
'$atribut',
'$bobot'
)
");

if ($query) {

    $_SESSION['success'] = "Data berhasil ditambahkan.";
} else {

    $_SESSION['error'] = "Data gagal ditambahkan.";
}

header("Location: ../../View/Data Kriteria/index.php");
exit;
