<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#0d6efd,#4e73df);
            height:100vh;
        }

        .card{
            border:none;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,.1);
        }

        .btn-primary{
            border-radius:10px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card">

                <div class="card-body p-4">

                    <h3 class="text-center mb-4">
                        Daftar Akun
                    </h3>

                    <form action="../Functions/register_proses.php" method="POST">

                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>No. Telepon</label>
                            <input type="text" name="no_telp" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="konfirmasi" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">
                            Daftar
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        Sudah punya akun?
                        <a href="login.php">Login</a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>