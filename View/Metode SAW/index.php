<?php

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$title = "Metode SAW";
$active = "saw";

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";

/*
|--------------------------------------------------------------------------
| BOBOT KRITERIA
|--------------------------------------------------------------------------
*/

$bobot = [];

$getBobot = mysqli_query($conn, "
SELECT *
FROM kriteria
");

while ($b = mysqli_fetch_assoc($getBobot)) {

    $bobot[$b['id_kriteria']] = $b['bobot'];
}

/*
|--------------------------------------------------------------------------
| NILAI MAX DAN MIN
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| MATRKS KEPUTUSAN
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "
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

$ranking = [];

?>

<div class="main-content">

    <div class="page-heading">

        <h3>Metode SAW</h3>

    </div>

    <!-- Matriks Keputusan -->

    <div class="card">

        <div class="card-header">

            <h5>Matriks Keputusan</h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Kode</th>
                            <th>Perusahaan</th>
                            <th>C1</th>
                            <th>C2</th>
                            <th>C3</th>
                            <th>C4</th>
                            <th>C5</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        mysqli_data_seek($query, 0);

                        while ($row = mysqli_fetch_assoc($query)) :

                        ?>

                            <tr>

                                <td><?= $row['kode']; ?></td>

                                <td><?= $row['nama_perusahaan']; ?></td>

                                <td><?= $row['c1']; ?></td>

                                <td><?= $row['c2']; ?></td>

                                <td><?= $row['c3']; ?></td>

                                <td><?= $row['c4']; ?></td>

                                <td><?= $row['c5']; ?></td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Matriks Normalisasi -->

    <div class="card mt-4">

        <div class="card-header">

            <h5>Matriks Normalisasi</h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Perusahaan</th>
                            <th>R1</th>
                            <th>R2</th>
                            <th>R3</th>
                            <th>R4</th>
                            <th>R5</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        mysqli_data_seek($query, 0);

                        while ($row = mysqli_fetch_assoc($query)) :

                            $r1 = $min_c1 / $row['c1'];

                            $r2 = $row['c2'] / $max_c2;

                            $r3 = $row['c3'] / $max_c3;

                            $r4 = $row['c4'] / $max_c4;

                            $r5 = $row['c5'] / $max_c5;

                            $nilai =
                                ($r1 * $bobot[1]) +
                                ($r2 * $bobot[2]) +
                                ($r3 * $bobot[3]) +
                                ($r4 * $bobot[4]) +
                                ($r5 * $bobot[6]);

                            $ranking[] = [
                                'nama' => $row['nama_perusahaan'],
                                'nilai' => $nilai
                            ];

                        ?>

                            <tr>

                                <td><?= $row['nama_perusahaan']; ?></td>

                                <td><?= round($r1, 4); ?></td>

                                <td><?= round($r2, 4); ?></td>

                                <td><?= round($r3, 4); ?></td>

                                <td><?= round($r4, 4); ?></td>

                                <td><?= round($r5, 4); ?></td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <?php

    usort($ranking, function ($a, $b) {

        return $b['nilai'] <=> $a['nilai'];
    });

    ?>

    <!-- Ranking -->

    <div class="card mt-4">

        <div class="card-header">

            <h5>Ranking SAW</h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Ranking</th>
                            <th>Perusahaan</th>
                            <th>Nilai Akhir</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $no = 1;

                        foreach ($ranking as $r) :

                        ?>

                            <tr>

                                <td><?= $no++; ?></td>

                                <td><?= $r['nama']; ?></td>

                                <td><?= round($r['nilai'], 4); ?></td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php include "../Template/Footer.php"; ?>