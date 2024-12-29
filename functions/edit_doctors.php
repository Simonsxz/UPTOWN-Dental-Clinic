<?php
include '../functions/db_conn.php';  // Correct the file path here

if (isset($_POST['update'])) {
    // Collect POST data
    $user_id = $_POST['user_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $role = $_POST['role'];

    // Sanitize input to prevent SQL injection
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $fname = mysqli_real_escape_string($conn, $fname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $role = mysqli_real_escape_string($conn, $role);

    // Update query
    $query = "UPDATE tbl_useraccount SET user_fName='$fname', user_lName='$lname', user_role='$role' WHERE user_ID='$user_id'";
    $query_run = mysqli_query($conn, $query);

    // Check if the update was successful
    if ($query_run) {
        echo 'Data Updated';  // Success message
    } else {
        echo 'Data Not Updated';  // Failure message
    }
}
?>
