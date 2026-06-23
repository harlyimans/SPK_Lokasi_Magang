<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$title = "Tambah Kriteria";
$active = "kriteria";

// Generate kode otomatis
$query = mysqli_query($conn, "SELECT MAX(kode) AS kode FROM kriteria");
$data = mysqli_fetch_assoc($query);

if ($data['kode']) {

    $angka = (int) substr($data['kode'], 1);
    $angka++;

    $kode = "K" . str_pad($angka, 3, "0", STR_PAD_LEFT);
} else {

    $kode = "K001";
}

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";
?>

<div class="main-content">

    <div class="page-heading">

        <h3>Tambah Kriteria</h3>

        <p class="text-muted">
            Tambah data kriteria penilaian.
        </p>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form action="../../Functions/Data Kriteria/proses_tambah.php" method="POST">

                <div class="row">

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Kode
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="kode"
                            value="<?= $kode ?>"
                            readonly>

                    </div>

                    <div class="col-md-9 mb-3">

                        <label class="form-label">
                            Nama Kriteria
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="nama_kriteria"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Atribut
                        </label>

                        <select
                            name="atribut"
                            class="form-select"
                            required>

                            <option value="">-- Pilih --</option>

                            <option value="benefit">

                                Benefit

                            </option>

                            <option value="cost">

                                Cost

                            </option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Bobot
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            max="1"
                            class="form-control"
                            name="bobot"
                            placeholder="Contoh : 0.30"
                            required>

                        <small class="text-muted">

                            Masukkan bobot antara 0 - 1

                        </small>

                    </div>

                </div>

                <button class="btn btn-primary">

                    <i class="bi bi-save"></i>

                    Simpan

                </button>

                <a href="index.php"
                    class="btn btn-secondary">

                    Kembali

                </a>

                <button
                    type="reset"
                    class="btn btn-warning">

                    Reset

                </button>

            </form>

        </div>

    </div>

</div>

<?php
include "../Template/Footer.php";
?>