<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teknik') {
    header("Location: login.php");
    exit();
}

include "db.php";

$id = $_GET['id'];
$status = $_GET['status'];

// kalau status sudah diperbaiki, isi waktu_selesai
if ($status === "Sudah Diperbaiki") {
    $sql = "UPDATE kendala SET status='$status', waktu_selesai=NOW() WHERE id='$id'";
} else {
    $sql = "UPDATE kendala SET status='$status' WHERE id='$id'";
}

$conn->query($sql);

header("Location: dashboard_teknik.php");
?>
