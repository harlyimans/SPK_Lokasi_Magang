<?php
include "../Connection/Koneksi.php";

$bobotC1 = 0.25;
$bobotC2 = 0.35;
$bobotC3 = 0.20;
$bobotC4 = 0.20;

$ranking = [];

// Nilai pembagi normalisasi
$minJarak = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT MIN(nilai) AS min_nilai
    FROM penilaian
    WHERE id_kriteria = 1")
)['min_nilai'];

$maxUangSaku = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT MAX(nilai) AS max_nilai
    FROM penilaian
    WHERE id_kriteria = 2")
)['max_nilai'];

$maxFasilitas = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT MAX(nilai) AS max_nilai
    FROM penilaian
    WHERE id_kriteria = 3")
)['max_nilai'];

$maxPeluang = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT MAX(nilai) AS max_nilai
    FROM penilaian
    WHERE id_kriteria = 4")
)['max_nilai'];

$alternatif = mysqli_query(
    $conn,
    "SELECT * FROM alternatif"
);

while($alt = mysqli_fetch_assoc($alternatif))
{
    $nilai = [];

    $dataNilai = mysqli_query(
        $conn,
        "SELECT *
        FROM penilaian
        WHERE id_alternatif='".$alt['id_alternatif']."'
        ORDER BY id_kriteria"
    );

    while($n = mysqli_fetch_assoc($dataNilai))
    {
        $nilai[] = $n['nilai'];
    }

    $r1 = $minJarak / $nilai[0];
    $r2 = $nilai[1] / $maxUangSaku;
    $r3 = $nilai[2] / $maxFasilitas;
    $r4 = $nilai[3] / $maxPeluang;

    $nilaiAkhir =
        ($r1 * $bobotC1) +
        ($r2 * $bobotC2) +
        ($r3 * $bobotC3) +
        ($r4 * $bobotC4);

    $ranking[] = [
        'nama' => $alt['nama_perusahaan'],
        'nilai' => round($nilaiAkhir,4)
    ];
}

usort($ranking, function($a,$b){
    return $b['nilai'] <=> $a['nilai'];
});

?>
<!DOCTYPE html>
<html>
<head>

<title>Grafik Hasil SAW</title>

<link rel="stylesheet"
href="../Assets/AdminLTE-3.2.0/dist/css/adminlte.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>

<div class="container mt-4">

<h2>Grafik Hasil Ranking SAW</h2>

<canvas id="grafikSAW"></canvas>

<br>

<table class="table table-bordered table-striped">

<thead>
<tr>
    <th>Ranking</th>
    <th>Perusahaan</th>
    <th>Nilai SAW</th>
</tr>
</thead>

<tbody>

<?php
$no=1;
foreach($ranking as $r){
?>

<tr>

<td><?= $no++ ?></td>

<td><?= $r['nama'] ?></td>

<td><?= $r['nilai'] ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<script>

const labels = [
<?php
foreach($ranking as $r){
    echo "'".$r['nama']."',";
}
?>
];

const dataNilai = [
<?php
foreach($ranking as $r){
    echo $r['nilai'].",";
}
?>
];

new Chart(document.getElementById('grafikSAW'), {

type: 'bar',

data: {

labels: labels,

datasets: [{

label: 'Nilai SAW',

data: dataNilai,

borderWidth: 1

}]

},

options: {

responsive: true,

plugins: {

legend: {
display: true
}

},

scales: {

y: {

beginAtZero: true

}

}

}

});

</script>

</body>
</html>
