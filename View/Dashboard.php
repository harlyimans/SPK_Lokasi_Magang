<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: Login.php");
    exit;
}

include "../Connection/Koneksi.php";

$totalAlternatif = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM alternatif"));
$totalKriteria   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kriteria"));
$totalPenilaian  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM penilaian"));
$totalUser       = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));

$title = "Dashboard";
$active = "dashboard";

include "Template/Header.php";
include "Template/Navbar.php";
include "Template/Sidebar.php";
?>

<div class="main-content">

    <div class="page-heading">

        <h3 class="fw-bold">Dashboard</h3>

        <p class="text-muted">
            Selamat Datang,
            <b><?= htmlspecialchars($_SESSION['nama']); ?></b>
        </p>

    </div>

    <div class="page-content">

        <div class="row">

            <div class="col-lg-3 col-md-6">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-secondary mb-1">
                                    Alternatif
                                </p>

                                <h2><?= $totalAlternatif ?></h2>

                            </div>

                            <div class="fs-1 text-primary">

                                <i class="bi bi-building"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-secondary mb-1">
                                    Kriteria
                                </p>

                                <h2><?= $totalKriteria ?></h2>

                            </div>

                            <div class="fs-1 text-success">

                                <i class="bi bi-list-check"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-secondary mb-1">
                                    Penilaian
                                </p>

                                <h2><?= $totalPenilaian ?></h2>

                            </div>

                            <div class="fs-1 text-warning">

                                <i class="bi bi-pencil-square"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-secondary mb-1">
                                    User
                                </p>

                                <h2><?= $totalUser ?></h2>

                            </div>

                            <div class="fs-1 text-danger">

                                <i class="bi bi-people"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="row mt-4">

            <div class="col-lg-8">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Informasi Sistem
                        </h5>

                    </div>

                    <div class="card-body">

                        <p>
                            Sistem Pendukung Keputusan Pemilihan Lokasi Magang menggunakan metode SAW.
                            Silakan gunakan menu di sebelah kiri untuk mengelola data dan melakukan proses perhitungan.
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Menu Cepat
                        </h5>

                    </div>

                    <div class="list-group list-group-flush">

                        <a href="Data Alternatif/index.php" class="list-group-item">
                            Alternatif
                        </a>

                        <a href="Data Kriteria/index.php" class="list-group-item">
                            Kriteria
                        </a>

                        <a href="Penilaian.php" class="list-group-item">
                            Penilaian
                        </a>

                        <a href="SAW.php" class="list-group-item">
                            Perhitungan SAW
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
include "Template/Footer.php";
?>