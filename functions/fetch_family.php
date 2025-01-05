<?php
session_start();
include "../functions/db_conn.php";

if (isset($_POST['checking_view']) && isset($_POST['folder_id'])) {
    $folder_id = $_POST['folder_id'];

    // Prepare the SQL query to fetch details based on folder_id
    $sql = "SELECT folder_id, folder_name, folder_head, folder_created FROM tbl_familyfolder WHERE folder_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the folder_id parameter
    mysqli_stmt_bind_param($stmt, 's', $folder_id); // Assuming folder_id is a string

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $folder_id, $folder_name, $folder_head, $folder_created);

        if (mysqli_stmt_fetch($stmt)) {
            // Return the fetched data as JSON
            echo json_encode([
                'folder_id' => $folder_id,
                'folder_name' => $folder_name,
                'folder_head' => $folder_head,
                'folder_created' => $folder_created
            ]);
        } else {
            // No record found, return error
            echo json_encode(['error' => 'No record found']);
        }
    } else {
        // SQL query failed
        echo json_encode(['error' => 'Failed to fetch data']);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
