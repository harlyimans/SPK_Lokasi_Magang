<?php
session_start();
require_once "../Connection/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['username']); // Input login tetap bernama username
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Query Error : " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {

        if (password_verify($password, $user['password'])) {

            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];

            header("Location: ../View/Dashboard.php");
            exit;
        }
    }

    $_SESSION['error'] = "Email atau Password salah!";
    header("Location: ../View/Login.php");
    exit;
}