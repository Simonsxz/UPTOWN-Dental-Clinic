<?php
include "../functions/db_conn.php";

function addUser($userData) {
    global $conn;

    $firstName = $userData['firstName'];
    $lastName = $userData['lastName'];
    $username = $userData['username'];
    $password = password_hash($userData['password'], PASSWORD_DEFAULT);
    $role = $userData['role'];

    // SQL query to insert data into the table
    $sql = "INSERT INTO db_table (user_fName, user_lName, user_userName, user_password, user_role, user_created)
            VALUES (?, ?, ?, ?, ?, NOW())";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $username, $password, $role);

    if (mysqli_stmt_execute($stmt)) {
        // Retrieve the last inserted ID
        $lastId = mysqli_insert_id($conn);
        
        // Format the userID as UP-SC-(lastId)
        $userID = "UP-SC-" . $lastId;

        // Update the newly inserted record with the userID
        $updateSQL = "UPDATE tbl_useraccount SET user_ID = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($conn, $updateSQL);
        mysqli_stmt_bind_param($updateStmt, "si", $userID, $lastId);
        mysqli_stmt_execute($updateStmt);

        // Close the statement
        mysqli_stmt_close($updateStmt);

        return "User added successfully with User ID: " . $userID;
    } else {
        return "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>