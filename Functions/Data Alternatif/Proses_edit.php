<?php

session_start();

include "../../Connection/Koneksi.php";

$id = $_POST['id'];
$nama = $_POST['nama_perusahaan'];
$alamat = $_POST['alamat'];
$kota = $_POST['kota'];
$deskripsi = $_POST['deskripsi'];

$query = mysqli_query($conn,"
UPDATE alternatif
SET
nama_perusahaan='$nama',
alamat='$alamat',
kota='$kota',
deskripsi='$deskripsi'
WHERE id_alternatif='$id'
");

if($query){

    $_SESSION['success']="Data berhasil diubah.";

}else{

    $_SESSION['error']="Data gagal diubah.";

}

header("Location: ../../View/Data%20Alternatif/index.php");
exit;