<?php
include "../functions/function.php"; // Include your database connection

// Check the connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Query to fetch data from the table
$query = "SELECT id, user_ID, user_fName, user_lName, user_role, user_created FROM tbl_useraccount";
$result = $conn->query($query);

// Check if data exists
if ($result->num_rows > 0) {
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users); // Return the data as JSON
} else {
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>
