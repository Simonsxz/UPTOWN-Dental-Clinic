<?php
session_start();
include "../functions/db_conn.php"; // Make sure the connection is correct

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

    // Update query for tbl_familyfolder
    $query = "UPDATE tbl_familyfolder 
              SET folder_name='$folder_name', folder_head='$folder_head', folder_created='$folder_created' 
              WHERE folder_id='$folder_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        // After updating tbl_familyfolder, update the connected tbl_patientaccount records
        $update_patient_query = "UPDATE tbl_patientaccount 
                                 SET patient_family='$folder_name'  -- Assuming you want to update the patient_family with the folder name
                                 WHERE patient_family='$folder_id'";  // Where the patient_family field is the same as the folder_id

        $patient_query_run = mysqli_query($conn, $update_patient_query);

        if ($patient_query_run) {
            echo 'Data Updated';  // Success message for both
        } else {
            echo 'Error updating tbl_patientaccount: ' . mysqli_error($conn);  // Error with updating patient accounts
        }
    } else {
        echo 'Error: ' . mysqli_error($conn);  // Error with updating the family folder
    }
}
?>
