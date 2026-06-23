<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "
SELECT *
FROM alternatif
WHERE id_alternatif='$id'
");

$data = mysqli_fetch_assoc($query);

$title = "Edit Alternatif";
$active = "alternatif";

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";

?>

<div class="main-content">

    <div class="page-heading mb-4">

        <h3>Edit Alternatif</h3>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="../../Functions/Data Alternatif/proses_edit.php" method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?= $data['id_alternatif']; ?>">

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label>Kode</label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= $data['kode']; ?>"
                            readonly>

                    </div>

                    <div class="col-md-8 mb-3">

                        <label>Nama Perusahaan</label>

                        <input
                            type="text"
                            class="form-control"
                            name="nama_perusahaan"
                            value="<?= $data['nama_perusahaan']; ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Kota</label>

                        <input
                            type="text"
                            class="form-control"
                            name="kota"
                            value="<?= $data['kota']; ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Alamat</label>

                        <textarea
                            class="form-control"
                            name="alamat"
                            rows="3"><?= $data['alamat']; ?></textarea>

                    </div>

                    <div class="col-12 mb-3">

                        <label>Deskripsi</label>

                        <textarea
                            class="form-control"
                            name="deskripsi"
                            rows="5"><?= $data['deskripsi']; ?></textarea>

                    </div>

                </div>

                <button class="btn btn-primary">

                    Update

                </button>

                <a href="index.php" class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

<?php
include "../Template/Footer.php";
?>