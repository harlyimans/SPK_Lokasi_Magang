<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../Login.php");
    exit;
}

include "../../Connection/Koneksi.php";

$title = "Input Perbandingan Kriteria";
$active = "ahp";

include "../Template/Header.php";
include "../Template/Navbar.php";
include "../Template/Sidebar.php";

$kriteria = mysqli_query($conn, "
SELECT *
FROM kriteria
ORDER BY id_kriteria ASC
");

$data = [];

while ($row = mysqli_fetch_assoc($kriteria)) {
    $data[] = $row;
}

?>

<div class="main-content">

    <div class="page-heading">

        <h3>Input Perbandingan Kriteria</h3>

    </div>

    <div class="card">

        <div class="card-body">

            <form action="../../Functions/AHP/proses_input.php" method="POST">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Kriteria 1</th>
                            <th>Kriteria 2</th>
                            <th>Nilai</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        for ($i = 0; $i < count($data); $i++):

                            for ($j = $i + 1; $j < count($data); $j++):

                        ?>

                                <tr>

                                    <td>

                                        <?= $data[$i]['nama_kriteria']; ?>

                                        <input
                                            type="hidden"
                                            name="k1[]"
                                            value="<?= $data[$i]['id_kriteria']; ?>">

                                    </td>

                                    <td>

                                        <?= $data[$j]['nama_kriteria']; ?>

                                        <input
                                            type="hidden"
                                            name="k2[]"
                                            value="<?= $data[$j]['id_kriteria']; ?>">

                                    </td>

                                    <td>

                                        <select
                                            name="nilai[]"
                                            class="form-select"
                                            required>

                                            <option value="">-- Pilih --</option>

                                            <option value="0.1111">1/9</option>
                                            <option value="0.1250">1/8</option>
                                            <option value="0.1429">1/7</option>
                                            <option value="0.1667">1/6</option>
                                            <option value="0.2000">1/5</option>
                                            <option value="0.2500">1/4</option>
                                            <option value="0.3333">1/3</option>
                                            <option value="0.5000">1/2</option>

                                            <option value="1">1</option>

                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>

                                        </select>

                                    </td>

                                </tr>

                        <?php

                            endfor;

                        endfor;

                        ?>

                    </tbody>

                </table>

                <button
                    type="submit"
                    class="btn btn-success">

                    Simpan

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

<?php include "../Template/Footer.php"; ?>