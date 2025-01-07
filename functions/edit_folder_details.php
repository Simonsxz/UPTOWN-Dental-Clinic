<?php
session_start();
include "../functions/db_conn.php"; // Ensure the connection is correct

if (isset($_POST['update'])) {
    $folder_id = mysqli_real_escape_string($conn, $_POST['folder_id']);
    $folder_name = mysqli_real_escape_string($conn, $_POST['folder_name']);
    $folder_head = mysqli_real_escape_string($conn, $_POST['folder_head']);
    $folder_created = mysqli_real_escape_string($conn, $_POST['folder_created']);

    // Check if all necessary data is provided
    if (empty($folder_id) || empty($folder_name) || empty($folder_head)) {
        echo 'Missing required fields';  // Debugging message
        exit;
    }

    // Step 1: Check if there is a matching folder_id in tbl_familydata
    $check_family_data_query = "SELECT * FROM tbl_familydata WHERE folder_id='$folder_id'";
    $result = mysqli_query($conn, $check_family_data_query);

    if (mysqli_num_rows($result) > 0) {
        // If data is found with the same folder_id in tbl_familydata, return 'EXISTING_USER'
        echo 'EXISTING_USER'; // Flag to indicate there is a user with the same folder_id
        exit;
    }

    // Step 2: If no matching data is found, proceed to update tbl_familyfolder
    $query = "UPDATE tbl_familyfolder 
              SET folder_name='$folder_name', folder_head='$folder_head', folder_created='$folder_created' 
              WHERE folder_id='$folder_id'";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo 'Data Updated';  // Success message for family folder update
    } else {
        echo 'Error updating tbl_familyfolder: ' . mysqli_error($conn);  // Error with updating the family folder
    }
}
?>
