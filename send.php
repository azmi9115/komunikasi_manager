<?php
session_start();
date_default_timezone_set("Asia/Jakarta");

// Hanya user role operasional yang bisa kirim
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'operasional') {
    header("Location: login.php");
    exit();
}

include "db.php";

// Cek jika form dikirim lewat POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sumber = $_POST['sumber'];
    $pesan = $_POST['pesan'];
    $status = "Laporan Masuk";

    // Query insert TANPA mengisi waktu
    $stmt = $conn->prepare("INSERT INTO kendala (sumber, pesan, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $sumber, $pesan, $status);

    if ($stmt->execute()) {
        header("Location: dashboard_operasional.php");
        exit();
    } else {
        echo "Gagal menyimpan kendala: " . $conn->error;
    }
} else {
    echo "Akses tidak sah.";
}
?>
