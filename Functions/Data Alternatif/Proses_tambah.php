<?php

session_start();

include "../../Connection/Koneksi.php";

$kode = $_POST['kode'];
$nama = $_POST['nama_perusahaan'];
$alamat = $_POST['alamat'];
$kota = $_POST['kota'];
$deskripsi = $_POST['deskripsi'];

$query = mysqli_query($conn, "
INSERT INTO alternatif
(
kode,
nama_perusahaan,
alamat,
kota,
deskripsi
)
VALUES
(
'$kode',
'$nama',
'$alamat',
'$kota',
'$deskripsi'
)
");

if ($query) {

    $_SESSION['success'] = "Data berhasil ditambahkan.";
} else {

    $_SESSION['error'] = "Data gagal ditambahkan.";
}

header("Location: ../../View/Data%20Alternatif/index.php");
exit;
