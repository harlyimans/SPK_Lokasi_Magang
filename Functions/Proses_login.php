<?php

session_start();
include "../Connection/Koneksi.php";

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {

    $_SESSION['error'] = "Email dan Password wajib diisi.";

    header("Location: ../View/Login.php");
    exit;
}

$email = mysqli_real_escape_string($conn, $email);

$query = mysqli_query($conn, "
SELECT *
FROM users
WHERE email='$email'
");

if (mysqli_num_rows($query) == 1) {

    $data = mysqli_fetch_assoc($query);

    if (password_verify($password, $data['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['email'] = $data['email'];

        header("Location: ../View/Dashboard.php");
        exit;
    }
}

$_SESSION['error'] = "Email atau Password salah.";

header("Location: ../View/Login.php");
exit;
