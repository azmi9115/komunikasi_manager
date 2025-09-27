<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $tanggapan = $_POST['tanggapan'];

    $stmt = $conn->prepare("UPDATE kendala SET tanggapan_teknik = ? WHERE id = ?");
    $stmt->bind_param("si", $tanggapan, $id);
    $stmt->execute();
}

header("Location: dashboard_bangunan.php");
exit();
?>
