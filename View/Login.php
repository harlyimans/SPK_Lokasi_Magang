<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: Dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SPK Lokasi Magang</title>

    <!-- Custom Layout CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Font Awesome Local -->
    <link rel="stylesheet" href="../assets/css/all.min.css">

    <style>
        body{
            background: linear-gradient(135deg,#0d6efd,#4e73df);
            height:100vh;
        }

        .login-card{
            border:none;
            border-radius:20px;
            box-shadow:0 15px 35px rgba(0,0,0,.2);
        }

        .logo{
            width:80px;
            height:80px;
            border-radius:50%;
            background:#0d6efd;
            color:white;
            display:flex;
            justify-content:center;
            align-items:center;
            margin:auto;
            font-size:35px;
        }

        .btn-login{
            border-radius:10px;
            font-weight:600;
        }

        .input-group-text{
            cursor:pointer;
        }

        a{
            text-decoration:none;
        }
    </style>

</head>

<body>

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card login-card">

                <div class="card-body p-5">

                    <div class="logo mb-3">
                        <i class="fas fa-graduation-cap"></i>
                    </div>

                    <h3 class="text-center fw-bold">
                        SPK Lokasi Magang
                    </h3>

                    <p class="text-center text-muted mb-4">
                        Silakan login untuk melanjutkan
                    </p>

                    <?php if(isset($_SESSION['error'])) : ?>

                        <div class="alert alert-danger">
                            <?= $_SESSION['error']; ?>
                        </div>

                    <?php unset($_SESSION['error']); endif; ?>

                    <form action="../Functions/proses_login.php" method="POST">

                        <div class="mb-3">
                            <label class="form-label">
                                Email / Username
                            </label>

                            <input type="text"
                                name="username"
                                class="form-control"
                                placeholder="Masukkan email atau username"
                                required>
                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Password
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    required>

                                <span class="input-group-text"
                                    onclick="lihatPassword()">

                                    <i class="fas fa-eye" id="icon"></i>

                                </span>

                            </div>

                        </div>

                        <button class="btn btn-primary w-100 btn-login">
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </button>

                    </form>

                    <hr>

                    <div class="text-center">

                        Belum punya akun?

                        <a href="register.php">
                            Daftar Sekarang
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function lihatPassword(){

    let password = document.getElementById("password");
    let icon = document.getElementById("icon");

    if(password.type=="password"){

        password.type="text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");

    }else{

        password.type="password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");

    }

}

</script>

</body>
</html>