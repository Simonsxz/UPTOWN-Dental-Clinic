<?php
include "../functions/db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gather family details
    $familyData = [
        'folder_name' => $_POST['folder_name'],
        'folder_head' => $_POST['folder_head']
    ];

    echo addFamily($familyData);
}

function addFamily($familyData) {
    global $conn;

    // Extract data from the array
    $folderName = $familyData['folder_name'];
    $folderHead = $familyData['folder_head'];

    // Check if the family folder already exists
    $checkSQL = "SELECT COUNT(*) FROM tbl_familyfolder WHERE folder_name = ? AND folder_head = ?";
    $checkStmt = mysqli_prepare($conn, $checkSQL);
    mysqli_stmt_bind_param($checkStmt, "ss", $folderName, $folderHead);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_bind_result($checkStmt, $count);
    mysqli_stmt_fetch($checkStmt);
    mysqli_stmt_close($checkStmt);

    if ($count > 0) {
        return "Error: A family with this name and head already exists.";
    }

    // Insert family data into the family table
    $sql = "INSERT INTO tbl_familyfolder (folder_name, folder_head, folder_created) VALUES (?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $folderName, $folderHead);

    if (mysqli_stmt_execute($stmt)) {
        $lastId = mysqli_insert_id($conn);  // Get the last inserted ID
        $folderId = "UPDC-FAMILY-" . str_pad($lastId, 6, "0", STR_PAD_LEFT);  // Format the folder ID

        // Update the family record with the generated folder_id
        $updateSQL = "UPDATE tbl_familyfolder SET folder_id = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($conn, $updateSQL);
        mysqli_stmt_bind_param($updateStmt, "si", $folderId, $lastId);
        mysqli_stmt_execute($updateStmt);

        mysqli_stmt_close($updateStmt);
        mysqli_stmt_close($stmt);

        return "Family added successfully with Folder ID: " . $folderId;
    } else {
        $error = "Error: " . mysqli_error($conn);
        mysqli_stmt_close($stmt);
        return $error;
    }
}
?>
