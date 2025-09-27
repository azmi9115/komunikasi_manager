<?php
session_start();
include "db.php";

$username = $_POST['username'];
$password = $_POST['password']; // tidak pakai md5 karena di DB plain text

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if (isset($_SESSION['role'])) {
    switch($_SESSION['role']) {
        case 'teknik':
            header("Location: dashboard_teknik.php"); exit();
        case 'operasional':
            header("Location: dashboard_operasional.php"); exit();
        case 'radkom':
            header("Location: dashboard_radkom.php"); exit();
        case 'radtel':
            header("Location: dashboard_SRSJ.php"); exit();
        case 'surveillance':
            header("Location: dashboard_surveillance.php"); exit();
        case 'navigasi':
            header("Location: dashboard_navigasi.php"); exit();
        case 'amss':
            header("Location: dashboard_amss.php"); exit();
        case 'rdps':
            header("Location: dashboard_rdps.php"); exit();
        case 'listrik':
            header("Location: dashboard_listrik.php"); exit();
        case 'bangunan':
            header("Location: dashboard_bangunan.php"); exit();
        default:
            // Role tidak dikenali, logout
            session_destroy();
            header("Location: login.php"); exit();
    }
}
    exit();
} else {
    echo "Login gagal. <a href='login.php'>Coba lagi</a>";
}
?>
