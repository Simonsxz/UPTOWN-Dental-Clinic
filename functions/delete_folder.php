<?php
// Check if the folder ID is passed in the POST request
if (isset($_POST['folder_id'])) {
    $folder_id = $_POST['folder_id'];

    // Include database connection
    include "../functions/db_conn.php";

    // Prepare and execute the delete query for tbl_familyfolder
    $sql = "DELETE FROM tbl_familyfolder WHERE folder_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $folder_id); // Bind the folder ID as a string
        if (mysqli_stmt_execute($stmt)) {
            echo "Folder deleted successfully.";
        } else {
            echo "Error deleting folder.";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query.";
    }

    mysqli_close($conn);
}
?>
