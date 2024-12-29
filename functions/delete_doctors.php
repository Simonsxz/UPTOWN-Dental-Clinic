<?php
// Check if the user ID is passed in the POST request
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Include database connection
    include "../functions/db_conn.php";

    // Prepare and execute the delete query
    $sql = "DELETE FROM tbl_useraccount WHERE user_ID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $user_id); // Bind the user ID as a string
        if (mysqli_stmt_execute($stmt)) {
            echo "User deleted successfully.";
        } else {
            echo "Error deleting user.";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query.";
    }

    mysqli_close($conn);
}
?>
