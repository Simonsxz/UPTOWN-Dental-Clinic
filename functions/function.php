<?php
include "../functions/db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData = [
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'role' => $_POST['role']
    ];

    echo addUser($userData);
}
function addUser($userData) {
    global $conn;

    // Use the correct keys from $userData
    $firstName = $userData['firstName'];
    $lastName = $userData['lastName'];
    $username = $userData['username'];
    $password = password_hash($userData['password'], PASSWORD_DEFAULT);
    $role = $userData['role'];

    // Check if the username already exists
    $dupCheckQuery = "SELECT COUNT(*) FROM tbl_useraccount WHERE user_userName = ?";
    $dupCheckStmt = mysqli_prepare($conn, $dupCheckQuery);
    mysqli_stmt_bind_param($dupCheckStmt, "s", $username);
    mysqli_stmt_execute($dupCheckStmt);
    mysqli_stmt_bind_result($dupCheckStmt, $count);
    mysqli_stmt_fetch($dupCheckStmt);
    mysqli_stmt_close($dupCheckStmt);

    if ($count > 0) {
        return "The username already exists. Please choose another one.";
    }

    // Check if the first and last name combination already exists
    $nameCheckQuery = "SELECT COUNT(*) FROM tbl_useraccount WHERE user_fName = ? AND user_lName = ?";
    $nameCheckStmt = mysqli_prepare($conn, $nameCheckQuery);
    mysqli_stmt_bind_param($nameCheckStmt, "ss", $firstName, $lastName);
    mysqli_stmt_execute($nameCheckStmt);
    mysqli_stmt_bind_result($nameCheckStmt, $nameCount);
    mysqli_stmt_fetch($nameCheckStmt);
    mysqli_stmt_close($nameCheckStmt);

    if ($nameCount > 0) {
        return "The combination of first name and last name already exists. Please use different names.";
    }

    // Proceed with inserting the new user
    $sql = "INSERT INTO tbl_useraccount (user_fName, user_lName, user_userName, user_password, user_role, user_created)
            VALUES (?, ?, ?, ?, ?, NOW())";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $username, $password, $role);

    if (mysqli_stmt_execute($stmt)) {
        $lastId = mysqli_insert_id($conn);
        $userID = "UP-DC-" . $lastId;

        $updateSQL = "UPDATE tbl_useraccount SET user_ID = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($conn, $updateSQL);
        mysqli_stmt_bind_param($updateStmt, "si", $userID, $lastId);
        mysqli_stmt_execute($updateStmt);

        mysqli_stmt_close($updateStmt);
        mysqli_stmt_close($stmt);

        return "User added successfully with User ID: " . $userID;
    } else {
        $error = "Error: " . mysqli_error($conn);
        mysqli_stmt_close($stmt);
        return $error;
    }
}


function getPatientFullName($patientId) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'db_uptowndc');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT patient_fullName FROM tbl_patientaccount WHERE patient_id = ?");
    $stmt->bind_param("s", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch patient name
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['patient_fullName'];
    } else {
        return "No Name Available"; // Default if not found
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
