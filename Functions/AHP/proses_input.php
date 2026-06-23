<?php

session_start();

include "../../Connection/Koneksi.php";

mysqli_query($conn, "
TRUNCATE TABLE perbandingan_kriteria
");

$k1 = $_POST['k1'];
$k2 = $_POST['k2'];
$nilai = $_POST['nilai'];

$kriteria = mysqli_query($conn, "
SELECT id_kriteria
FROM kriteria
");

while ($k = mysqli_fetch_assoc($kriteria)) {
    $id = $k['id_kriteria'];

    mysqli_query($conn, "
    INSERT INTO perbandingan_kriteria
    (kriteria_1,kriteria_2,nilai)
    VALUES
    ('$id','$id','1')
    ");
}

for ($i = 0; $i < count($nilai); $i++) {
    $a = $k1[$i];
    $b = $k2[$i];
    $n = $nilai[$i];

    mysqli_query($conn, "
    INSERT INTO perbandingan_kriteria
    (kriteria_1,kriteria_2,nilai)
    VALUES
    ('$a','$b','$n')
    ");

    $balik = 1 / $n;

    mysqli_query($conn, "
    INSERT INTO perbandingan_kriteria
    (kriteria_1,kriteria_2,nilai)
    VALUES
    ('$b','$a','$balik')
    ");
}

$_SESSION['success'] =
    "Perbandingan kriteria berhasil disimpan.";

header("Location: ../../View/Metode AHP/index.php");
exit;
