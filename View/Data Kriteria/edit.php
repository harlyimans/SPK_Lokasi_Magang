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
FROM kriteria
WHERE id_kriteria='$id'
");

$data = mysqli_fetch_assoc($query);

$title = "Edit Kriteria";
$active = "kriteria";

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";

?>

<div class="main-content">

    <div class="page-heading">

        <h3>Edit Kriteria</h3>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="../../Functions/Data Kriteria/proses_edit.php" method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?= $data['id_kriteria']; ?>">

                <div class="row">

                    <div class="col-md-3 mb-3">

                        <label>Kode</label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= $data['kode']; ?>"
                            readonly>

                    </div>

                    <div class="col-md-9 mb-3">

                        <label>Nama Kriteria</label>

                        <input
                            type="text"
                            class="form-control"
                            name="nama_kriteria"
                            value="<?= $data['nama_kriteria']; ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Atribut</label>

                        <select
                            name="atribut"
                            class="form-select">

                            <option
                                value="benefit"
                                <?= $data['atribut'] == "benefit" ? "selected" : ""; ?>>

                                Benefit

                            </option>

                            <option
                                value="cost"
                                <?= $data['atribut'] == "cost" ? "selected" : ""; ?>>

                                Cost

                            </option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Bobot</label>

                        <input
                            type="number"
                            step="0.01"
                            class="form-control"
                            name="bobot"
                            value="<?= $data['bobot']; ?>">

                    </div>

                </div>

                <button class="btn btn-primary">

                    Update

                </button>

                <a href="index.php"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

<?php
include "../Template/Footer.php";
?>