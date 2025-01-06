<?php
session_start();
include "../functions/db_conn.php";

if (isset($_POST['checking_members']) && isset($_POST['folder_id'])) {
    $folder_id = $_POST['folder_id'];

    $sql = "SELECT folder_id, folder_name, folder_head, patient_id, patient_fullName 
            FROM tbl_familydata 
            WHERE folder_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, 's', $folder_id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $folder_id, $folder_name, $folder_head, $patient_id, $patient_fullName);

        $members = [];
        while (mysqli_stmt_fetch($stmt)) {
            $members[] = [
                'patient_id' => $patient_id,
                'patient_fullName' => $patient_fullName
            ];
        }

        header('Content-Type: application/json'); // Set the correct content type
        if (!empty($members)) {
            echo json_encode([
                'folder_id' => $folder_id,
                'folder_name' => $folder_name,
                'folder_head' => $folder_head,
                'members' => $members
            ]);
        } else {
            echo json_encode(['error' => 'No members found for this folder']);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Failed to fetch data']);
    }

    mysqli_stmt_close($stmt);
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request']);
}
?>
