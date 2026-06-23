<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: View/Dashboard.php");
    exit;
} else {
    header("Location: View/Login.php");
    exit;
}
