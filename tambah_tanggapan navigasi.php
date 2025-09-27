<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $tanggapan = $_POST['tanggapan_teknik'];

    $stmt = $conn->prepare("UPDATE kendala SET tanggapan_teknik = ? WHERE id = ?");
    $stmt->bind_param("si", $tanggapan, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard_navigasi.php");
    exit();
}
?>
