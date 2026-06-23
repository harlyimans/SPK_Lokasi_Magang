<?php

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$title = "Metode TOPSIS";
$active = "topsis";

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";

/*
|--------------------------------------------------------------------------
| BOBOT
|--------------------------------------------------------------------------
*/

$bobot = [];

$getBobot = mysqli_query($conn,"
SELECT *
FROM kriteria
");

while($b = mysqli_fetch_assoc($getBobot))
{
    $bobot[$b['id_kriteria']] = $b['bobot'];
}

/*
|--------------------------------------------------------------------------
| DATA PENILAIAN
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn,"
SELECT
    a.id_alternatif,
    a.kode,
    a.nama_perusahaan,

    MAX(CASE WHEN p.id_kriteria = 1 THEN p.nilai END) AS c1,
    MAX(CASE WHEN p.id_kriteria = 2 THEN p.nilai END) AS c2,
    MAX(CASE WHEN p.id_kriteria = 3 THEN p.nilai END) AS c3,
    MAX(CASE WHEN p.id_kriteria = 4 THEN p.nilai END) AS c4,
    MAX(CASE WHEN p.id_kriteria = 6 THEN p.nilai END) AS c5

FROM alternatif a

LEFT JOIN penilaian p
ON a.id_alternatif = p.id_alternatif

GROUP BY a.id_alternatif

ORDER BY a.kode ASC
");

$data = [];

while($row = mysqli_fetch_assoc($query))
{
    $data[] = $row;
}

/*
|--------------------------------------------------------------------------
| PEMBAGI NORMALISASI
|--------------------------------------------------------------------------
*/

$p1 = 0;
$p2 = 0;
$p3 = 0;
$p4 = 0;
$p5 = 0;

foreach($data as $d)
{
    $p1 += pow($d['c1'],2);
    $p2 += pow($d['c2'],2);
    $p3 += pow($d['c3'],2);
    $p4 += pow($d['c4'],2);
    $p5 += pow($d['c5'],2);
}

$p1 = sqrt($p1);
$p2 = sqrt($p2);
$p3 = sqrt($p3);
$p4 = sqrt($p4);
$p5 = sqrt($p5);

/*
|--------------------------------------------------------------------------
| NORMALISASI
|--------------------------------------------------------------------------
*/

$normalisasi = [];

foreach($data as $d)
{
    $normalisasi[] = [

        'kode' => $d['kode'],
        'nama' => $d['nama_perusahaan'],

        'r1' => $d['c1'] / $p1,
        'r2' => $d['c2'] / $p2,
        'r3' => $d['c3'] / $p3,
        'r4' => $d['c4'] / $p4,
        'r5' => $d['c5'] / $p5

    ];
}

/*
|--------------------------------------------------------------------------
| NORMALISASI TERBOBOT
|--------------------------------------------------------------------------
*/

$terbobot = [];

foreach($normalisasi as $n)
{
    $terbobot[] = [

        'kode' => $n['kode'],
        'nama' => $n['nama'],

        'y1' => $n['r1'] * $bobot[1],
        'y2' => $n['r2'] * $bobot[2],
        'y3' => $n['r3'] * $bobot[3],
        'y4' => $n['r4'] * $bobot[4],
        'y5' => $n['r5'] * $bobot[6]

    ];
}

/*
|--------------------------------------------------------------------------
| SOLUSI IDEAL
|--------------------------------------------------------------------------
*/

$Aplus = [

    'y1' => min(array_column($terbobot,'y1')),
    'y2' => max(array_column($terbobot,'y2')),
    'y3' => max(array_column($terbobot,'y3')),
    'y4' => max(array_column($terbobot,'y4')),
    'y5' => max(array_column($terbobot,'y5'))

];

$Amin = [

    'y1' => max(array_column($terbobot,'y1')),
    'y2' => min(array_column($terbobot,'y2')),
    'y3' => min(array_column($terbobot,'y3')),
    'y4' => min(array_column($terbobot,'y4')),
    'y5' => min(array_column($terbobot,'y5'))

];

/*
|--------------------------------------------------------------------------
| PREFERENSI
|--------------------------------------------------------------------------
*/

$ranking = [];

foreach($terbobot as $t)
{
    $dplus = sqrt(

        pow($t['y1'] - $Aplus['y1'],2)+
        pow($t['y2'] - $Aplus['y2'],2)+
        pow($t['y3'] - $Aplus['y3'],2)+
        pow($t['y4'] - $Aplus['y4'],2)+
        pow($t['y5'] - $Aplus['y5'],2)

    );

    $dmin = sqrt(

        pow($t['y1'] - $Amin['y1'],2)+
        pow($t['y2'] - $Amin['y2'],2)+
        pow($t['y3'] - $Amin['y3'],2)+
        pow($t['y4'] - $Amin['y4'],2)+
        pow($t['y5'] - $Amin['y5'],2)

    );

    $nilai = $dmin / ($dplus + $dmin);

    $ranking[] = [

        'nama' => $t['nama'],
        'nilai' => $nilai

    ];
}

usort($ranking,function($a,$b){

    return $b['nilai'] <=> $a['nilai'];

});

?>

<div class="main-content">

    <div class="page-heading">

        <h3>Metode TOPSIS</h3>

    </div>

    <!-- Ranking -->

    <div class="card">

        <div class="card-header">

            <h5>Ranking TOPSIS</h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Ranking</th>
                        <th>Perusahaan</th>
                        <th>Nilai Preferensi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    $no = 1;

                    foreach($ranking as $r) :

                    ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td><?= $r['nama']; ?></td>

                        <td><?= round($r['nilai'],4); ?></td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include "../Template/Footer.php"; ?>