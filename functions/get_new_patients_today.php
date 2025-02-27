<?php
$sname = "localhost";
$uname = "u878538360_uptowndc";
$password = "House015!"; // Or 'root' if you've set that password
$db_name = "u878538360_uptowndc";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Get today's date in Manila time
$today = date('Y-m-d');

// Fetch count of new patients registered today
$sql = "SELECT COUNT(*) AS total FROM tbl_patientaccount WHERE DATE(created_at) = '$today'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row["total"];
} else {
    echo 0;
}

$conn->close();
?>
