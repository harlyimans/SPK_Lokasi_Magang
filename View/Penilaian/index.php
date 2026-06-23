<?php

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$title = "Data Penilaian";
$active = "penilaian";

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";

$query = mysqli_query($conn, "
SELECT
    a.id_alternatif,
    a.kode,
    a.nama_perusahaan,

    MAX(CASE WHEN p.id_kriteria = 1 THEN p.nilai END) AS jarak,
    MAX(CASE WHEN p.id_kriteria = 2 THEN p.nilai END) AS bidang,
    MAX(CASE WHEN p.id_kriteria = 3 THEN p.nilai END) AS reputasi,
    MAX(CASE WHEN p.id_kriteria = 4 THEN p.nilai END) AS fasilitas,
    MAX(CASE WHEN p.id_kriteria = 6 THEN p.nilai END) AS kontrak

FROM alternatif a

LEFT JOIN penilaian p
ON a.id_alternatif = p.id_alternatif

GROUP BY a.id_alternatif

ORDER BY a.kode ASC
");

?>

<div class="main-content">

    <div class="page-heading">

        <div class="d-flex justify-content-between align-items-center">

            <h3>Data Penilaian</h3>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Perusahaan</th>
                            <th>Jarak</th>
                            <th>Bidang</th>
                            <th>Reputasi</th>
                            <th>Fasilitas</th>
                            <th>Kontrak</th>
                            <th width="150">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $no = 1;

                        while ($row = mysqli_fetch_assoc($query)) :
                        ?>

                            <tr>

                                <td><?= $no++; ?></td>
                                <td><?= $row['nama_perusahaan']; ?></td>
                                <td><?= $row['jarak']; ?></td>
                                <td><?= $row['bidang']; ?></td>
                                <td><?= $row['reputasi']; ?></td>
                                <td><?= $row['fasilitas']; ?></td>
                                <td><?= $row['kontrak']; ?></td>
                                <td>

                                    <a href="edit.php?id=<?= $row['id_alternatif']; ?>"
                                        class="btn btn-warning btn-sm">
                                        Isi Nilai
                                    </a>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php include "../Template/Footer.php"; ?>