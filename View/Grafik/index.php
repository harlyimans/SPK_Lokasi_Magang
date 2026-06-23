<?php

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$title = "Grafik";
$active = "grafik";

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";

/*
|--------------------------------------------------------------------------
| BOBOT KRITERIA
|--------------------------------------------------------------------------
*/

$bobotLabel = [];
$bobotValue = [];

$getBobot = mysqli_query($conn, "
SELECT *
FROM kriteria
ORDER BY id_kriteria
");

while ($b = mysqli_fetch_assoc($getBobot)) {
    $bobotLabel[] = $b['nama_kriteria'];
    $bobotValue[] = $b['bobot'];
}

/*
|--------------------------------------------------------------------------
| DATA SAW
|--------------------------------------------------------------------------
*/

$bobot = [];

$get = mysqli_query($conn, "
SELECT *
FROM kriteria
");

while ($r = mysqli_fetch_assoc($get)) {
    $bobot[$r['id_kriteria']] = $r['bobot'];
}

$min_c1 = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT MIN(nilai) nilai FROM penilaian WHERE id_kriteria='1'"
))['nilai'];

$max_c2 = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT MAX(nilai) nilai FROM penilaian WHERE id_kriteria='2'"
))['nilai'];

$max_c3 = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT MAX(nilai) nilai FROM penilaian WHERE id_kriteria='3'"
))['nilai'];

$max_c4 = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT MAX(nilai) nilai FROM penilaian WHERE id_kriteria='4'"
))['nilai'];

$max_c5 = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT MAX(nilai) nilai FROM penilaian WHERE id_kriteria='6'"
))['nilai'];

$qSaw = mysqli_query($conn, "
SELECT
a.nama_perusahaan,

MAX(CASE WHEN p.id_kriteria=1 THEN p.nilai END) c1,
MAX(CASE WHEN p.id_kriteria=2 THEN p.nilai END) c2,
MAX(CASE WHEN p.id_kriteria=3 THEN p.nilai END) c3,
MAX(CASE WHEN p.id_kriteria=4 THEN p.nilai END) c4,
MAX(CASE WHEN p.id_kriteria=6 THEN p.nilai END) c5

FROM alternatif a

LEFT JOIN penilaian p
ON a.id_alternatif=p.id_alternatif

GROUP BY a.id_alternatif
");

$sawNama = [];
$sawNilai = [];

while ($d = mysqli_fetch_assoc($qSaw)) {
    $r1 = $min_c1 / $d['c1'];
    $r2 = $d['c2'] / $max_c2;
    $r3 = $d['c3'] / $max_c3;
    $r4 = $d['c4'] / $max_c4;
    $r5 = $d['c5'] / $max_c5;

    $nilai =
        ($r1 * $bobot[1]) +
        ($r2 * $bobot[2]) +
        ($r3 * $bobot[3]) +
        ($r4 * $bobot[4]) +
        ($r5 * $bobot[6]);

    $sawNama[] = $d['nama_perusahaan'];
    $sawNilai[] = round($nilai, 4);
}

/*
|--------------------------------------------------------------------------
| DATA TOPSIS
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "
SELECT
a.nama_perusahaan,

MAX(CASE WHEN p.id_kriteria=1 THEN p.nilai END) c1,
MAX(CASE WHEN p.id_kriteria=2 THEN p.nilai END) c2,
MAX(CASE WHEN p.id_kriteria=3 THEN p.nilai END) c3,
MAX(CASE WHEN p.id_kriteria=4 THEN p.nilai END) c4,
MAX(CASE WHEN p.id_kriteria=6 THEN p.nilai END) c5

FROM alternatif a

LEFT JOIN penilaian p
ON a.id_alternatif=p.id_alternatif

GROUP BY a.id_alternatif
");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

$p1 = $p2 = $p3 = $p4 = $p5 = 0;

foreach ($data as $d) {
    $p1 += pow($d['c1'], 2);
    $p2 += pow($d['c2'], 2);
    $p3 += pow($d['c3'], 2);
    $p4 += pow($d['c4'], 2);
    $p5 += pow($d['c5'], 2);
}

$p1 = sqrt($p1);
$p2 = sqrt($p2);
$p3 = sqrt($p3);
$p4 = sqrt($p4);
$p5 = sqrt($p5);

$topsisNama = [];
$topsisNilai = [];

foreach ($data as $d) {
    $y1 = ($d['c1'] / $p1) * $bobot[1];
    $y2 = ($d['c2'] / $p2) * $bobot[2];
    $y3 = ($d['c3'] / $p3) * $bobot[3];
    $y4 = ($d['c4'] / $p4) * $bobot[4];
    $y5 = ($d['c5'] / $p5) * $bobot[6];

    $topsisNama[] = $d['nama_perusahaan'];

    $topsisNilai[] =
        round($y1 + $y2 + $y3 + $y4 + $y5, 4);
}

?>

<div class="main-content">

    <div class="page-heading">
        <h3>Grafik Hasil Perhitungan</h3>
    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    Bobot Kriteria AHP
                </div>

                <div class="card-body">
                    <canvas id="grafikAHP"></canvas>
                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    Ranking SAW
                </div>

                <div class="card-body">
                    <canvas id="grafikSAW"></canvas>
                </div>

            </div>

        </div>

    </div>

    <div class="card mt-4">

        <div class="card-header">
            Ranking TOPSIS
        </div>

        <div class="card-body">

            <canvas id="grafikTOPSIS"></canvas>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Chart(document.getElementById('grafikAHP'), {

        type: 'pie',

        data: {
            labels: <?= json_encode($bobotLabel); ?>,
            datasets: [{
                data: <?= json_encode($bobotValue); ?>
            }]
        }
    });

    new Chart(document.getElementById('grafikSAW'), {

        type: 'bar',

        data: {
            labels: <?= json_encode($sawNama); ?>,
            datasets: [{
                label: 'Nilai SAW',
                data: <?= json_encode($sawNilai); ?>
            }]
        }
    });

    new Chart(document.getElementById('grafikTOPSIS'), {

        type: 'bar',

        data: {
            labels: <?= json_encode($topsisNama); ?>,
            datasets: [{
                label: 'Nilai TOPSIS',
                data: <?= json_encode($topsisNilai); ?>
            }]
        }
    });
</script>

<?php include "../Template/Footer.php"; ?>