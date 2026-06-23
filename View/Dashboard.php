<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: Login.php");
    exit;
}

include __DIR__ . "/../Connection/Koneksi.php";

/** @var mysqli $conn */
$totalAlternatif = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM alternatif")
);

$totalKriteria = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM kriteria")
);

$totalPenilaian = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM penilaian")
);

$totalUser = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM users")
);

?>

<?php
$title = "Dashboard SPK Lokasi Magang";
$active_page = "dashboard";
include "layouts/header.php";
?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container">

            <h1 class="m-0">
                Dashboard SPK Lokasi Magang
            </h1>

            <br>

            <div class="alert alert-success">
                Selamat Datang,
                <b><?= htmlspecialchars($_SESSION['nama']) ?></b>
            </div>

        </div>
    </div>

    <div class="content">

        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $totalAlternatif ?></h3>
                            <p>Alternatif</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>

                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $totalKriteria ?></h3>
                            <p>Kriteria</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-list"></i>
                        </div>
                    </div>

                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $totalPenilaian ?></h3>
                            <p>Penilaian</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>

                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $totalUser ?></h3>
                            <p>User</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>

                </div>

            </div>

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Informasi Sistem
                    </h3>
                </div>

                <div class="card-body">

                    <p>
                        Sistem Pendukung Keputusan Penentuan Lokasi Magang
                        menggunakan metode SAW (Simple Additive Weighting).
                    </p>

                    <ul>
                        <li>Kelola Data Alternatif</li>
                        <li>Kelola Data Kriteria</li>
                        <li>Input Penilaian</li>
                        <li>Perhitungan Metode SAW</li>
                        <li>Grafik Hasil</li>
                        <li>Export PDF</li>
                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "layouts/footer.php"; ?>
