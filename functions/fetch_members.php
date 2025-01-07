<?php
session_start();
include "../functions/db_conn.php";

if (isset($_POST['checking_members']) && isset($_POST['folder_id'])) {
    $folder_id = $_POST['folder_id'];

    // Query to fetch folder details and member data
    $sql = "SELECT folder_name, folder_head 
            FROM tbl_familydata 
            WHERE folder_id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $folder_id);

    $folder_name = "";
    $folder_head = "";

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $folder_name, $folder_head);
        mysqli_stmt_fetch($stmt); // Fetch folder details
    }
    mysqli_stmt_close($stmt);

    // Check if folder exists
    if (empty($folder_name) && empty($folder_head)) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Folder not found']);
        exit;
    }

    // Query to fetch members
    $sql = "SELECT patient_id, patient_fullName 
            FROM tbl_familydata 
            WHERE folder_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $folder_id);

    $members = [];
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $patient_id, $patient_fullName);
        while (mysqli_stmt_fetch($stmt)) {
            $members[] = [
                'patient_id' => $patient_id,
                'patient_fullName' => $patient_fullName
            ];
        }
    }
    mysqli_stmt_close($stmt);

    // Prepare the response
    header('Content-Type: application/json');
    echo json_encode([
        'folder_id' => $folder_id,
        'folder_name' => $folder_name,
        'folder_head' => $folder_head,
        'members' => $members
    ]);
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request']);
}
?>
