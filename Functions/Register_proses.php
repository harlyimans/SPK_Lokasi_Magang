<?php

session_start();
include "../Connection/Koneksi.php";

$nama       = trim($_POST['nama'] ?? '');
$no_telp    = trim($_POST['no_telp'] ?? '');
$email      = trim($_POST['email'] ?? '');
$password   = $_POST['password'] ?? '';
$konfirmasi = $_POST['konfirmasi'] ?? '';

if (
    empty($nama) ||
    empty($no_telp) ||
    empty($email) ||
    empty($password) ||
    empty($konfirmasi)
) {
    $_SESSION['error'] = "Semua field wajib diisi.";
    header("Location: ../View/Register.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Format email tidak valid.";
    header("Location: ../View/Register.php");
    exit;
}

if (strlen($password) < 8) {
    $_SESSION['error'] = "Password minimal 8 karakter.";
    header("Location: ../View/Register.php");
    exit;
}

if ($password != $konfirmasi) {
    $_SESSION['error'] = "Konfirmasi password tidak sesuai.";
    header("Location: ../View/Register.php");
    exit;
}

$nama     = mysqli_real_escape_string($conn, $nama);
$no_telp  = mysqli_real_escape_string($conn, $no_telp);
$email    = mysqli_real_escape_string($conn, $email);

$cek = mysqli_query($conn, "
SELECT id_user
FROM users
WHERE email='$email'
");

if (mysqli_num_rows($cek) > 0) {

    $_SESSION['error'] = "Email sudah digunakan.";

    header("Location: ../View/Register.php");
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$query = mysqli_query($conn, "
INSERT INTO users
(
nama,
no_telp,
email,
password
)
VALUES
(
'$nama',
'$no_telp',
'$email',
'$passwordHash'
)
");

if ($query) {

    $_SESSION['success'] = "Registrasi berhasil.";

    header("Location: ../View/Login.php");
    exit;
} else {

    die(mysqli_error($conn));
}
