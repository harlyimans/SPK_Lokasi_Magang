<?php

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "
SELECT
    a.id_alternatif,
    a.nama_perusahaan,

    MAX(CASE WHEN p.id_kriteria = 1 THEN p.nilai END) AS c1,
    MAX(CASE WHEN p.id_kriteria = 2 THEN p.nilai END) AS c2,
    MAX(CASE WHEN p.id_kriteria = 3 THEN p.nilai END) AS c3,
    MAX(CASE WHEN p.id_kriteria = 4 THEN p.nilai END) AS c4,
    MAX(CASE WHEN p.id_kriteria = 6 THEN p.nilai END) AS c5

FROM alternatif a

LEFT JOIN penilaian p
ON a.id_alternatif = p.id_alternatif

WHERE a.id_alternatif='$id'

GROUP BY a.id_alternatif
");

$data = mysqli_fetch_assoc($query);

$title = "Edit Penilaian";
$active = "penilaian";

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";

?>

<div class="main-content">

    <div class="page-heading">

        <h3>Edit Penilaian</h3>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="../../Functions/Penilaian/proses_edit.php" method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?= $data['id_alternatif']; ?>">

                <div class="mb-3">

                    <label>Perusahaan</label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?= $data['nama_perusahaan']; ?>"
                        readonly>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Jarak Tempuh</label>

                        <input
                            type="number"
                            min="1"
                            max="5"
                            name="c1"
                            class="form-control"
                            value="<?= $data['c1']; ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Kesesuaian Bidang Magang</label>

                        <input
                            type="number"
                            min="1"
                            max="5"
                            name="c2"
                            class="form-control"
                            value="<?= $data['c2']; ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Reputasi Perusahaan</label>

                        <input
                            type="number"
                            min="1"
                            max="5"
                            name="c3"
                            class="form-control"
                            value="<?= $data['c3']; ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Fasilitas</label>

                        <input
                            type="number"
                            min="1"
                            max="5"
                            name="c4"
                            class="form-control"
                            value="<?= $data['c4']; ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Kesempatan Kontrak</label>

                        <input
                            type="number"
                            min="1"
                            max="5"
                            name="c5"
                            class="form-control"
                            value="<?= $data['c5']; ?>"
                            required>

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Update

                </button>

                <a
                    href="index.php"
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