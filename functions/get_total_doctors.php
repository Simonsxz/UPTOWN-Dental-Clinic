<?php
$sname = "localhost";
$uname = "u878538360_uptowndc";
$password = "House015!"; // Or 'root' if you've set that password
$db_name = "u878538360_uptowndc";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch count where user_role is 'Doctor'
$sql = "SELECT COUNT(*) AS total FROM tbl_useraccount WHERE user_role = 'Doctor'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row["total"];
} else {
    echo 0;
}

$conn->close();
?>
