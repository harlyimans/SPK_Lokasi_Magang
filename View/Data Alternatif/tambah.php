<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$title = "Tambah Alternatif";
$active = "alternatif";

// Generate kode otomatis
$query = mysqli_query($conn, "SELECT MAX(kode) AS kode FROM alternatif");
$data = mysqli_fetch_assoc($query);

if ($data['kode']) {
    $angka = (int) substr($data['kode'], 1);
    $angka++;
    $kode = "A" . str_pad($angka, 3, "0", STR_PAD_LEFT);
} else {
    $kode = "A001";
}

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";
?>

<div class="main-content">

    <div class="page-heading mb-4">

        <h3>Tambah Alternatif</h3>

        <p class="text-muted">
            Tambah data perusahaan tempat magang.
        </p>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form action="../../Functions/Data Alternatif/proses_tambah.php" method="POST">

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Kode Alternatif
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="kode"
                            value="<?= $kode ?>"
                            readonly>

                    </div>

                    <div class="col-md-8 mb-3">

                        <label class="form-label">
                            Nama Perusahaan
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="nama_perusahaan"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Kota
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="kota"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea
                            class="form-control"
                            name="alamat"
                            rows="3"
                            required></textarea>

                    </div>

                    <div class="col-12 mb-3">

                        <label class="form-label">
                            Deskripsi
                        </label>

                        <textarea
                            class="form-control"
                            name="deskripsi"
                            rows="5"></textarea>

                    </div>

                </div>

                <div class="mt-4">

                    <button class="btn btn-primary">

                        <i class="bi bi-save"></i>

                        Simpan

                    </button>

                    <a href="index.php" class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        Kembali

                    </a>

                    <button
                        type="reset"
                        class="btn btn-warning">

                        Reset

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php
include "../Template/Footer.php";
?>