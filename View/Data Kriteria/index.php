<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$title = "Data Kriteria";
$active = "kriteria";

$query = mysqli_query($conn, "
SELECT *
FROM kriteria
ORDER BY kode ASC
");

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";
?>

<div class="main-content">

    <div class="page-heading d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">
                Data Kriteria
            </h3>

            <p class="text-muted">
                Kelola data kriteria penilaian lokasi magang.
            </p>

        </div>

        <a href="tambah.php" class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>

            Tambah Kriteria

        </a>

    </div>

    <!-- Alert -->

    <?php if (isset($_SESSION['success'])) : ?>

        <div class="alert alert-success alert-dismissible fade show">

            <?= $_SESSION['success']; ?>

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    <?php
        unset($_SESSION['success']);
    endif;
    ?>

    <?php if (isset($_SESSION['error'])) : ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <?= $_SESSION['error']; ?>

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    <?php
        unset($_SESSION['error']);
    endif;
    ?>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <div class="row">

                <div class="col-md-6">

                    <h5 class="mb-0">

                        Daftar Kriteria

                    </h5>

                </div>

                <div class="col-md-6">

                    <input
                        type="text"
                        id="search"
                        class="form-control"
                        placeholder="Cari kriteria...">

                </div>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="tableKriteria">

                    <thead class="table-light">

                        <tr>

                            <th width="5%">No</th>

                            <th width="10%">Kode</th>

                            <th>Nama Kriteria</th>

                            <th width="15%">Atribut</th>

                            <th width="15%">Bobot</th>

                            <th width="18%">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $no = 1;

                        while ($row = mysqli_fetch_assoc($query)) :

                        ?>

                            <tr>

                                <td><?= $no++; ?></td>

                                <td>

                                    <span class="badge bg-primary">

                                        <?= $row['kode']; ?>

                                    </span>

                                </td>

                                <td>

                                    <?= htmlspecialchars($row['nama_kriteria']); ?>

                                </td>

                                <td>

                                    <?php

                                    if ($row['atribut'] == "benefit") {

                                        echo '<span class="badge bg-success">Benefit</span>';
                                    } else {

                                        echo '<span class="badge bg-danger">Cost</span>';
                                    }

                                    ?>

                                </td>

                                <td>

                                    <?= number_format($row['bobot'], 2); ?>

                                </td>

                                <td>

                                    <a href="edit.php?id=<?= $row['id_kriteria']; ?>"
                                        class="btn btn-warning btn-sm">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <a href="hapus.php?id=<?= $row['id_kriteria']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                                        <i class="bi bi-trash"></i>

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

<script>
    document.getElementById("search").addEventListener("keyup", function() {

        let keyword = this.value.toLowerCase();

        let rows = document.querySelectorAll("#tableKriteria tbody tr");

        rows.forEach(function(row) {

            row.style.display = row.innerText.toLowerCase().includes(keyword) ?
                "" :
                "none";

        });

    });
</script>

<?php
include "../Template/Footer.php";
?>