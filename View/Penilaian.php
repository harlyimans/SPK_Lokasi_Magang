<?php
include "../Connection/Koneksi.php";

$alternatif = mysqli_query(
    $conn,
    "SELECT * FROM alternatif"
);

$kriteria = mysqli_query(
    $conn,
    "SELECT * FROM kriteria"
);

if(isset($_POST['simpan']))
{
    $id_alternatif = $_POST['id_alternatif'];
    $id_kriteria = $_POST['id_kriteria'];
    $nilai = $_POST['nilai'];

    mysqli_query(
        $conn,
        "INSERT INTO penilaian
        (id_alternatif,id_kriteria,nilai)
        VALUES
        ('$id_alternatif','$id_kriteria','$nilai')"
    );

    echo "
    <script>
        alert('Data berhasil disimpan');
        window.location='Penilaian.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Penilaian</title>

<link rel="stylesheet"
href="../Assets/AdminLTE-3.2.0/dist/css/adminlte.min.css">

</head>

<body>

<div class="container mt-4">

<h2>Penilaian Alternatif</h2>

<form method="POST">

<div class="form-group">

<label>Alternatif</label>

<select name="id_alternatif"
        class="form-control">

<?php
$dataAlt = mysqli_query(
    $conn,
    "SELECT * FROM alternatif"
);

while($alt=mysqli_fetch_assoc($dataAlt))
{
?>

<option value="<?= $alt['id_alternatif']; ?>">

<?= $alt['nama_perusahaan']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Kriteria</label>

<select name="id_kriteria"
        class="form-control">

<?php
$dataKriteria = mysqli_query(
    $conn,
    "SELECT * FROM kriteria"
);

while($k=mysqli_fetch_assoc($dataKriteria))
{
?>

<option value="<?= $k['id_kriteria']; ?>">

<?= $k['nama_kriteria']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Nilai</label>

<input type="number"
       name="nilai"
       class="form-control"
       required>

</div>

<br>

<button type="submit"
        name="simpan"
        class="btn btn-primary">

Simpan

</button>

</form>

<hr>

<table class="table table-bordered">

<tr>

<th>No</th>
<th>Perusahaan</th>
<th>Kriteria</th>
<th>Nilai</th>

</tr>

<?php

$no = 1;

$data = mysqli_query(
    $conn,
    "SELECT
    penilaian.*,
    alternatif.nama_perusahaan,
    kriteria.nama_kriteria

    FROM penilaian

    JOIN alternatif
    ON alternatif.id_alternatif =
    penilaian.id_alternatif

    JOIN kriteria
    ON kriteria.id_kriteria =
    penilaian.id_kriteria"
);

while($row=mysqli_fetch_assoc($data))
{
?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama_perusahaan']; ?></td>

<td><?= $row['nama_kriteria']; ?></td>

<td><?= $row['nilai']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>
