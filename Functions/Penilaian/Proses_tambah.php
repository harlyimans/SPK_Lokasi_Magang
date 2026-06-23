<?php

session_start();

include "../../Connection/Koneksi.php";

$id_alternatif = $_POST['id_alternatif'];

$c1 = $_POST['c1'];
$c2 = $_POST['c2'];
$c3 = $_POST['c3'];
$c4 = $_POST['c4'];
$c5 = $_POST['c5'];

mysqli_query($conn, "
INSERT INTO penilaian(id_alternatif,id_kriteria,nilai)
VALUES
('$id_alternatif',1,'$c1'),
('$id_alternatif',2,'$c2'),
('$id_alternatif',3,'$c3'),
('$id_alternatif',4,'$c4'),
('$id_alternatif',6,'$c5')
");

$_SESSION['success'] = "Penilaian berhasil ditambahkan.";

header("Location: ../../View/Data Penilaian/index.php");
exit;
