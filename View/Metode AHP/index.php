<?php

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$title = "Metode AHP";
$active = "ahp";

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";

/*
|--------------------------------------------------------------------------
| DATA KRITERIA
|--------------------------------------------------------------------------
*/

$kriteria = [];

$qKriteria = mysqli_query($conn, "
SELECT *
FROM kriteria
ORDER BY id_kriteria ASC
");

while ($k = mysqli_fetch_assoc($qKriteria)) {
    $kriteria[] = $k;
}

$n = count($kriteria);

/*
|--------------------------------------------------------------------------
| BENTUK MATRIKS PERBANDINGAN
|--------------------------------------------------------------------------
*/

$matrix = [];

foreach ($kriteria as $baris) {
    foreach ($kriteria as $kolom) {
        $id1 = $baris['id_kriteria'];
        $id2 = $kolom['id_kriteria'];

        $cek = mysqli_query($conn, "
        SELECT nilai
        FROM perbandingan_kriteria
        WHERE kriteria_1='$id1'
        AND kriteria_2='$id2'
        ");

        if (mysqli_num_rows($cek) > 0) {
            $nilai = mysqli_fetch_assoc($cek)['nilai'];
        } else {
            $nilai = 0;
        }

        $matrix[$id1][$id2] = $nilai;
    }
}

/*
|--------------------------------------------------------------------------
| JUMLAH KOLOM
|--------------------------------------------------------------------------
*/

$jumlahKolom = [];

foreach ($kriteria as $kolom) {
    $idKolom = $kolom['id_kriteria'];

    $total = 0;

    foreach ($kriteria as $baris) {
        $idBaris = $baris['id_kriteria'];

        $total += $matrix[$idBaris][$idKolom];
    }

    $jumlahKolom[$idKolom] = $total;
}

/*
|--------------------------------------------------------------------------
| NORMALISASI
|--------------------------------------------------------------------------
*/

$normalisasi = [];

foreach ($kriteria as $baris) {
    $idBaris = $baris['id_kriteria'];

    foreach ($kriteria as $kolom) {
        $idKolom = $kolom['id_kriteria'];

        if ($jumlahKolom[$idKolom] != 0) {
            $normalisasi[$idBaris][$idKolom] =
                $matrix[$idBaris][$idKolom] /
                $jumlahKolom[$idKolom];
        } else {
            $normalisasi[$idBaris][$idKolom] = 0;
        }
    }
}

/*
|--------------------------------------------------------------------------
| PRIORITY VECTOR
|--------------------------------------------------------------------------
*/

$priority = [];

foreach ($kriteria as $baris) {
    $idBaris = $baris['id_kriteria'];

    $total = 0;

    foreach ($kriteria as $kolom) {
        $idKolom = $kolom['id_kriteria'];

        $total += $normalisasi[$idBaris][$idKolom];
    }

    $priority[$idBaris] = $total / $n;
}

/*
|--------------------------------------------------------------------------
| HITUNG LAMBDA MAX
|--------------------------------------------------------------------------
*/

$lambda = 0;

foreach ($kriteria as $kolom) {
    $idKolom = $kolom['id_kriteria'];

    $lambda +=
        $jumlahKolom[$idKolom] *
        $priority[$idKolom];
}

$ci = ($lambda - $n) / ($n - 1);

/*
|--------------------------------------------------------------------------
| RANDOM INDEX
|--------------------------------------------------------------------------
*/

$riList = [
    1 => 0,
    2 => 0,
    3 => 0.58,
    4 => 0.90,
    5 => 1.12,
    6 => 1.24,
    7 => 1.32,
    8 => 1.41,
    9 => 1.45,
    10 => 1.49
];

$ri = $riList[$n];

$cr = ($ri == 0) ? 0 : ($ci / $ri);

?>

<div class="main-content">

    <div class="page-heading">

        <h3>Metode AHP</h3>

    </div>

    <!-- Matriks Perbandingan -->

    <div class="card">

        <div class="card-header">

            <h5>Matriks Perbandingan Kriteria</h5>

        </div>

        <div class="card-body">
            <a href="input.php" class="btn btn-primary mb-3">
                Input Perbandingan Kriteria
            </a>

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Kriteria</th>

                            <?php foreach ($kriteria as $k): ?>

                                <th><?= $k['kode']; ?></th>

                            <?php endforeach; ?>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($kriteria as $baris): ?>

                            <tr>

                                <th><?= $baris['kode']; ?></th>

                                <?php foreach ($kriteria as $kolom): ?>

                                    <td>

                                        <?= round(
                                            $matrix[$baris['id_kriteria']][$kolom['id_kriteria']],
                                            4
                                        ); ?>

                                    </td>

                                <?php endforeach; ?>

                            </tr>

                        <?php endforeach; ?>

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

                            <th>Kriteria</th>

                            <?php foreach ($kriteria as $k): ?>

                                <th><?= $k['kode']; ?></th>

                            <?php endforeach; ?>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($kriteria as $baris): ?>

                            <tr>

                                <th><?= $baris['kode']; ?></th>

                                <?php foreach ($kriteria as $kolom): ?>

                                    <td>

                                        <?= round(
                                            $normalisasi[$baris['id_kriteria']][$kolom['id_kriteria']],
                                            4
                                        ); ?>

                                    </td>

                                <?php endforeach; ?>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Priority Vector -->

    <div class="card mt-4">

        <div class="card-header">

            <h5>Priority Vector (Bobot AHP)</h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Kode</th>
                        <th>Kriteria</th>
                        <th>Bobot</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($kriteria as $k): ?>

                        <tr>

                            <td><?= $k['kode']; ?></td>

                            <td><?= $k['nama_kriteria']; ?></td>

                            <td>

                                <?= round(
                                    $priority[$k['id_kriteria']],
                                    4
                                ); ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- Konsistensi -->

    <div class="card mt-4">

        <div class="card-header">

            <h5>Uji Konsistensi</h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>Lambda Max</th>
                    <td><?= round($lambda, 4); ?></td>
                </tr>

                <tr>
                    <th>CI</th>
                    <td><?= round($ci, 4); ?></td>
                </tr>

                <tr>
                    <th>CR</th>
                    <td><?= round($cr, 4); ?></td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>

                        <?php if ($cr < 0.1): ?>

                            <span class="badge bg-success">

                                Konsisten

                            </span>

                        <?php else: ?>

                            <span class="badge bg-danger">

                                Tidak Konsisten

                            </span>

                        <?php endif; ?>

                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>

<?php include "../Template/Footer.php"; ?>