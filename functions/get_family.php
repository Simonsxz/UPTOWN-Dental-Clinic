<?php
// Include your database connection
include "../functions/db_conn.php";

// Fetch family data from the database
$query = "SELECT id, folder_name, folder_head FROM tbl_familyfolder";
$result = $conn->query($query);

// Initialize an array to hold family data
$families = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $families[] = $row;
    }
}

// Close the connection
$conn->close();
?>
