<?php

include "../Connection/koneksi.php";

$nama      = $_POST['nama'];
$no_telp   = $_POST['no_telp'];
$email     = $_POST['email'];
$password  = $_POST['password'];
$konfirmasi= $_POST['konfirmasi'];

if($password != $konfirmasi){
    echo "<script>
            alert('Konfirmasi password tidak sesuai!');
            window.history.back();
          </script>";
    exit;
}

// cek email
$cek = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($cek)>0){

    echo "<script>
            alert('Email sudah digunakan');
            window.history.back();
          </script>";
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$query = mysqli_query($conn, "INSERT INTO users(nama,no_telp,email,password)
VALUES('$nama','$no_telp','$email','$password_hash')");

if($query){
    echo "Data berhasil disimpan";
}else{
    die("Error Database: " . mysqli_error($conn));
}

echo "<script>
        alert('Registrasi berhasil');
        window.location='../View/login.php';
      </script>";

?>