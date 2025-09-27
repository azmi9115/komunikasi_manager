<?php
include 'db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && isset($_GET['unit'])) {
    $id = intval($_GET['id']); // Get the ID of the record to update
    $unit = $conn->real_escape_string($_GET['unit']); // Get the selected unit and escape it for safety

    // Update the unit in the database
    $query = "UPDATE kendala SET unit = '$unit' WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        // Redirect back to the dashboard or wherever you want after the update
        header("Location: dashboard_teknik.php"); // Change this to your dashboard page
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
