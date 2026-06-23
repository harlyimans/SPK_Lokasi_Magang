<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$alternatif = mysqli_query($conn, "
SELECT *
FROM alternatif
ORDER BY nama_perusahaan
");

$title = "Tambah Penilaian";
$active = "penilaian";

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";
?>

<div class="main-content">

    <div class="page-heading">
        <h3>Tambah Penilaian</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="../../Functions/Data Penilaian/proses_tambah.php" method="POST">

                <div class="mb-3">
                    <label>Perusahaan</label>

                    <select name="id_alternatif"
                        class="form-select"
                        required>

                        <option value="">-- Pilih Perusahaan --</option>

                        <?php while ($a = mysqli_fetch_assoc($alternatif)) : ?>

                            <option value="<?= $a['id_alternatif']; ?>">
                                <?= $a['kode']; ?> - <?= $a['nama_perusahaan']; ?>
                            </option>

                        <?php endwhile; ?>

                    </select>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Jarak Tempuh</label>
                        <input type="number"
                            name="c1"
                            class="form-control"
                            min="1"
                            max="5"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Kesesuaian Bidang Magang</label>
                        <input type="number"
                            name="c2"
                            class="form-control"
                            min="1"
                            max="5"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Reputasi Perusahaan</label>
                        <input type="number"
                            name="c3"
                            class="form-control"
                            min="1"
                            max="5"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Fasilitas</label>
                        <input type="number"
                            name="c4"
                            class="form-control"
                            min="1"
                            max="5"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Kesempatan Kontrak</label>
                        <input type="number"
                            name="c5"
                            class="form-control"
                            min="1"
                            max="5"
                            required>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>