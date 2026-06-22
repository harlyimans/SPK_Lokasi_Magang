<?php
include "../Connection/Koneksi.php";
?>

<?php

$ranking = [];

$kriteria = [];

$qHeaderKriteria = mysqli_query(
    $conn,
    "SELECT * FROM kriteria ORDER BY id_kriteria"
);

while($k = mysqli_fetch_assoc($qHeaderKriteria))
{
    $kriteria[$k['id_kriteria']] = [
        'nama' => $k['nama_kriteria'],
        'atribut' => $k['atribut'],
        'bobot' => $k['bobot'] / 100
    ];
}

$normalisasiDasar = [];

foreach($kriteria as $id => $k)
{
    if($k['atribut'] == 'benefit')
    {
        $hasil = mysqli_fetch_assoc(
            mysqli_query(
                $conn,
                "SELECT MAX(nilai) AS nilai
                 FROM penilaian
                 WHERE id_kriteria='$id'"
            )
        );

        $normalisasiDasar[$id] = $hasil['nilai'];
    }
    else
    {
        $hasil = mysqli_fetch_assoc(
            mysqli_query(
                $conn,
                "SELECT MIN(nilai) AS nilai
                 FROM penilaian
                 WHERE id_kriteria='$id'"
            )
        );

        $normalisasiDasar[$id] = $hasil['nilai'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Metode SAW</title>

    <link rel="stylesheet"
    href="../Assets/AdminLTE-3.2.0/dist/css/adminlte.min.css">

</head>
<body>

<div class="container mt-4">

    <h2>Matriks Keputusan SAW</h2>

    <table class="table table-bordered table-striped">

        <thead>

            <tr>

                <th>Perusahaan</th>

                <?php

               $dataKriteria = [];

$qKriteria = mysqli_query(
    $conn,
    "SELECT * FROM kriteria"
);

while($k = mysqli_fetch_assoc($qKriteria))
{
    $dataKriteria[$k['id_kriteria']] = [
        'nama_kriteria' => $k['nama_kriteria'],
        'atribut'       => $k['atribut'],
        'bobot'         => $k['bobot'] / 100
    ];
}

               foreach($kriteria as $k)
{
    echo "<th>".$k['nama']."</th>";
}

                ?>

            </tr>

        </thead>

        <tbody>

        <?php

        $alternatif = mysqli_query(
            $conn,
            "SELECT * FROM alternatif ORDER BY id_alternatif"
        );

        while($alt = mysqli_fetch_assoc($alternatif))
        {

        ?>

            <tr>

                <td>
                    <?= $alt['nama_perusahaan']; ?>
                </td>

                <?php

                $nilai = mysqli_query(
                    $conn,
                    "SELECT *
                    FROM penilaian
                    WHERE id_alternatif='".$alt['id_alternatif']."'
                    ORDER BY id_kriteria"
                );

                while($n = mysqli_fetch_assoc($nilai))
                {

                ?>

                    <td>
                        <?= $n['nilai']; ?>
                    </td>

                <?php } ?>

            </tr>

        <?php } ?>

        </tbody>

    </table>
    <hr>

</div>
<div class="container mt-4">

<h2>Matriks Normalisasi</h2>

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Perusahaan</th>

<?php
foreach($kriteria as $k)
{
    echo "<th>".$k['nama']."</th>";
}
?>

</tr>

</thead>

<tbody>
    <?php

$alternatif = mysqli_query(
    $conn,
    "SELECT * FROM alternatif"
);

while($alt = mysqli_fetch_assoc($alternatif))
{
    $nilaiAkhir = 0;
$hasilNormalisasi = [];

$dataNilai = mysqli_query(
    $conn,
    "SELECT *
     FROM penilaian
     WHERE id_alternatif='".$alt['id_alternatif']."'
     ORDER BY id_kriteria"
);

while($n = mysqli_fetch_assoc($dataNilai))
{
    $idKriteria = $n['id_kriteria'];
    $nilai = $n['nilai'];

    if($kriteria[$idKriteria]['atribut'] == 'benefit')
    {
        $r = $nilai / $normalisasiDasar[$idKriteria];
    }
    else
    {
        $r = $normalisasiDasar[$idKriteria] / $nilai;
    }

    $hasilNormalisasi[] = $r;

    $nilaiAkhir +=
        $r *
        $kriteria[$idKriteria]['bobot'];
}

$ranking[] = [
    'nama' => $alt['nama_perusahaan'],
    'nilai' => $nilaiAkhir
];
?>
<tr>

<td><?= $alt['nama_perusahaan']; ?></td>

<?php
foreach($hasilNormalisasi as $h)
{
?>
    <td><?= round($h,4); ?></td>
<?php
}
?>

</tr>
<?php
}
?>

</tbody>
<?php

usort($ranking, function($a, $b){
    return $b['nilai'] <=> $a['nilai'];
});

?>
</table>

<hr>

<div class="container mt-4">

<h2>Ranking SAW</h2>

<table class="table table-bordered table-striped">

<thead>
<tr>
    <th>Ranking</th>
    <th>Perusahaan</th>
    <th>Nilai SAW</th>
    <th>Rekomendasi</th>
</tr>
</thead>

<tbody>

<?php

$no = 1;

foreach($ranking as $r)
{
    $rekomendasi = '';

if($no == 1)
{
    $rekomendasi = '⭐ Sangat Direkomendasikan';
}
elseif($no <= 3)
{
    $rekomendasi = '👍 Direkomendasikan';
}
elseif($no <= 5)
{
    $rekomendasi = '⚠ Dipertimbangkan';
}
else
{
    $rekomendasi = '❌ Kurang Direkomendasikan';
}
?>

<tr>

<td>
<?php
if($no == 1){
    echo "🥇";
}elseif($no == 2){
    echo "🥈";
}elseif($no == 3){
    echo "🥉";
}else{
    echo $no;
}
?>
</td>

<td><?= $r['nama']; ?></td>

<td><?= round($r['nilai'],4); ?></td>

<td><?= $rekomendasi; ?></td>

</tr>
<?php $no++; ?>

<?php } ?>
</tbody>
</table>
</div>
</body>
</html>
