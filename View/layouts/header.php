<?php
if (!isset($title)) {
    $title = "SPK Lokasi Magang";
}
if (!isset($active_page)) {
    $active_page = "";
}

$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/SPK_Lokasi_Magang";
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <!-- Custom Layout CSS & FontAwesome Local -->
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/all.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar Header -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
            <div class="container">
                <a href="<?= $base_url ?>/View/Dashboard.php" class="navbar-brand">
                    <span class="brand-text font-weight-light">SPK Lokasi Magang</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link <?= ($active_page == 'dashboard') ? 'active' : '' ?>" href="<?= $base_url ?>/View/Dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link <?= ($active_page == 'user') ? 'active' : '' ?>" href="<?= $base_url ?>/View/User/index.php"><i class="fas fa-users"></i> User</a></li>
                        <li class="nav-item"><a class="nav-link <?= ($active_page == 'alternatif') ? 'active' : '' ?>" href="<?= $base_url ?>/View/Data Alternatif/index.php"><i class="fas fa-building"></i> Alternatif</a></li>
                        <li class="nav-item"><a class="nav-link <?= ($active_page == 'kriteria') ? 'active' : '' ?>" href="<?= $base_url ?>/View/Data Kriteria/index.php"><i class="fas fa-list"></i> Kriteria</a></li>
                        <li class="nav-item"><a class="nav-link <?= ($active_page == 'penilaian') ? 'active' : '' ?>" href="<?= $base_url ?>/View/Penilaian.php"><i class="fas fa-edit"></i> Penilaian</a></li>

                        <!-- Dropdown Metode -->
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle <?= in_array($active_page, ['saw', 'ahp', 'topsis']) ? 'active' : '' ?>"><i class="fas fa-calculator"></i> Metode</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="<?= $base_url ?>/View/SAW.php" class="dropdown-item">Metode SAW</a></li>
                                <li><a href="<?= $base_url ?>/View/AHP.php" class="dropdown-item">Metode AHP</a></li>
                                <li><a href="<?= $base_url ?>/View/Topsis.php" class="dropdown-item">Metode TOPSIS</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link <?= ($active_page == 'grafik') ? 'active' : '' ?>" href="<?= $base_url ?>/View/Grafik.php"><i class="fas fa-chart-bar"></i> Grafik</a></li>
                        <li class="nav-item"><a class="nav-link <?= ($active_page == 'pdf') ? 'active' : '' ?>" href="<?= $base_url ?>/View/Pdf.php"><i class="fas fa-file-pdf"></i> PDF</a></li>
                        <li class="nav-item"><a class="nav-link text-warning" href="<?= $base_url ?>/Functions/Logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>