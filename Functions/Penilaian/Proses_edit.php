<?php

session_start();

include "../../Connection/Koneksi.php";

$id = $_POST['id'];

$c1 = $_POST['c1'];
$c2 = $_POST['c2'];
$c3 = $_POST['c3'];
$c4 = $_POST['c4'];
$c5 = $_POST['c5'];

mysqli_query($conn, "
INSERT INTO penilaian(id_alternatif,id_kriteria,nilai)
VALUES('$id','1','$c1')
");

mysqli_query($conn, "
INSERT INTO penilaian(id_alternatif,id_kriteria,nilai)
VALUES('$id','2','$c2')
");

mysqli_query($conn, "
INSERT INTO penilaian(id_alternatif,id_kriteria,nilai)
VALUES('$id','3','$c3')
");

mysqli_query($conn, "
INSERT INTO penilaian(id_alternatif,id_kriteria,nilai)
VALUES('$id','4','$c4')
");

mysqli_query($conn, "
INSERT INTO penilaian(id_alternatif,id_kriteria,nilai)
VALUES('$id','6','$c5')
");

$_SESSION['success'] = "Data penilaian berhasil disimpan";

header("Location: ../../View/Penilaian/index.php");
exit;
