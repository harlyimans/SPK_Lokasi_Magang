<?php
session_start();


/** @var mysqli $conn */
require_once "../Connection/Koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: Login.php");
    exit;
}

include "../Connection/Koneksi.php";

// Proses Simpan Data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simpan'])) {
    $id_alternatif = $_POST['id_alternatif'];
    $id_kriteria = $_POST['id_kriteria'];
    $nilai = $_POST['nilai'];

    // Cek apakah data penilaian sudah ada (opsional, jika ingin menimpa pakai UPDATE)
    $cek_sql = "SELECT * FROM penilaian WHERE id_alternatif = ? AND id_kriteria = ?";
    $stmt_cek = mysqli_prepare($conn, $cek_sql);
    mysqli_stmt_bind_param($stmt_cek, "ii", $id_alternatif, $id_kriteria);
    mysqli_stmt_execute($stmt_cek);
    $result_cek = mysqli_stmt_get_result($stmt_cek);

    if (mysqli_num_rows($result_cek) > 0) {
        // Update jika sudah ada
        $sql = "UPDATE penilaian SET nilai = ? WHERE id_alternatif = ? AND id_kriteria = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "dii", $nilai, $id_alternatif, $id_kriteria);
    } else {
        // Insert jika belum ada
        $sql = "INSERT INTO penilaian (id_alternatif, id_kriteria, nilai) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iid", $id_alternatif, $id_kriteria, $nilai);
    }

    mysqli_stmt_execute($stmt);

    // Redirect agar saat di-refresh tidak ter-submit ulang
    header("Location: Penilaian.php");
    exit;
}

// Fetch Data Dropdown
$alternatif_result = mysqli_query($conn, "SELECT * FROM alternatif");
$kriteria_result = mysqli_query($conn, "SELECT * FROM kriteria");

// Fetch Data Tabel
$table_sql = "SELECT p.id_penilaian, a.nama_perusahaan, k.nama_kriteria, p.nilai 
              FROM penilaian p
              JOIN alternatif a ON p.id_alternatif = a.id_alternatif
              JOIN kriteria k ON p.id_kriteria = k.id_kriteria
              ORDER BY a.nama_perusahaan ASC, k.id_kriteria ASC";
$table_result = mysqli_query($conn, $table_sql);

?>
<?php
$title = "Penilaian Alternatif - SPK Lokasi Magang";
$active_page = "penilaian";
include "layouts/header.php";
?>

<div class="content-wrapper">
    <!-- Judul Halaman -->
    <div class="content-header">
        <div class="container">
            <h1 class="m-0 mb-3 text-dark">Penilaian Alternatif</h1>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <!-- Area Form Input -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Alternatif</label>
                            <!-- Menggunakan class form-control bawaan Bootstrap -->
                            <select class="form-control" name="id_alternatif" required>
                                <option value="">-- Pilih Alternatif (Perusahaan) --</option>
                                <?php while ($row = mysqli_fetch_assoc($alternatif_result)): ?>
                                    <option value="<?= $row['id_alternatif'] ?>"><?= htmlspecialchars($row['nama_perusahaan']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kriteria</label>
                            <select class="form-control" name="id_kriteria" required>
                                <option value="">-- Pilih Kriteria Penilaian --</option>
                                <?php while ($row = mysqli_fetch_assoc($kriteria_result)): ?>
                                    <option value="<?= $row['id_kriteria'] ?>"><?= htmlspecialchars($row['nama_kriteria']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nilai</label>
                            <input type="number" step="0.01" class="form-control" name="nilai" placeholder="Masukkan angka nilai..." required>
                        </div>

                        <!-- Class btn btn-primary menjadikan tombol berwarna biru AdminLTE -->
                        <button type="submit" name="simpan" class="btn btn-primary mt-2">Simpan</button>
                    </form>
                </div>
            </div>

            <!-- Area Menampilkan Tabel Hasil -->
            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive p-0">
                    <!-- Menggunakan class table, table-hover (efek disorot), dan table-bordered -->
                    <table class="table table-hover text-nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px">No</th>
                                <th>Perusahaan</th>
                                <th>Kriteria</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($table_result)):
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                                    <td><?= htmlspecialchars($row['nama_kriteria']) ?></td>
                                    <!-- Menampilkan nilai dengan format 2 angka desimal seperti di screenshot -->
                                    <td><?= number_format($row['nilai'], 2) ?></td>
                                </tr>
                            <?php endwhile; ?>

                            <?php if (mysqli_num_rows($table_result) == 0): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data penilaian</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include "layouts/footer.php"; ?>