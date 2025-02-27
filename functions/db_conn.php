<?php
$sname = "localhost";
$uname = "root";
$password = ""; // Or 'root' if your MySQL has a password
$db_name = "db_uptowndc";

// Create connection
$conn = mysqli_connect($sname, $uname, $password, $db_name);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
