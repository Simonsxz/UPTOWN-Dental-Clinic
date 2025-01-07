<?php
session_start();
include "../functions/db_conn.php"; // Ensure the connection is correct

// Check if the folder ID is passed in the POST request
if (isset($_POST['folder_id'])) {
    $folder_id = $_POST['folder_id'];

    // Check if there are any records in tbl_familydata with the same folder_id
    $check_association_query = "SELECT * FROM tbl_familydata WHERE folder_id = '$folder_id'";
    $result = mysqli_query($conn, $check_association_query);

    if (mysqli_num_rows($result) > 0) {
        // If there are users associated with this folder_id
        echo 'USER_EXISTS'; // Flag to indicate there are users associated with this folder
    } else {
        // If no users are associated with the folder_id
        echo 'NO_USER';
    }

    mysqli_close($conn);
}
?>
