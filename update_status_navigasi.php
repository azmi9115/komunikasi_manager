<?php
session_start();
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

header("Location: dashboard_navigasi.php");
exit();
?>
