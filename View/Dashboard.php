<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: Login.php");
    exit;
}

include "../Connection/Koneksi.php";

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

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard SPK Lokasi Magang</title>

    <link rel="stylesheet"
        href="../Assets/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet"
        href="../Assets/AdminLTE-3.2.0/dist/css/adminlte.min.css">
</head>

<body class="hold-transition layout-top-nav">

<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
        <div class="container">

            <a href="Dashboard.php" class="navbar-brand">
                <span class="brand-text font-weight-light">
                    SPK Lokasi Magang
                </span>
            </a>

            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="Dashboard.php">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Data Alternatif/index.php">
                        <i class="fas fa-building"></i> Alternatif
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Data Kriteria/index.php">
                        <i class="fas fa-list"></i> Kriteria
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Penilaian.php">
                        <i class="fas fa-edit"></i> Penilaian
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="SAW.php">
                        <i class="fas fa-calculator"></i> SAW
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Grafik.php">
                        <i class="fas fa-chart-bar"></i> Grafik
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Pdf.php">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                </li>

            </ul>

        </div>
    </nav>

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

                <a href="../Functions/Logout.php"
                   class="btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>

            </div>

        </div>

    </div>

</div>

<script src="../Assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>

<script src="../Assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="../Assets/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>

</body>
</html>
