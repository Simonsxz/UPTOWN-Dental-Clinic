<?php

$sname = "localhost";
$uname = "root";
$password = ""; // Or 'root' if you've set that password
$db_name = "db_uptowndc";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>