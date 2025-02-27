<?php
include "../functions/db_conn.php"; // Database connection

$query = "SELECT id, folder_name, folder_head FROM tbl_familyfolder";
$result = $conn->query($query);

$families = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $families[] = $row;
    }
}

echo json_encode(["success" => true, "families" => $families]);
$conn->close();
?>
