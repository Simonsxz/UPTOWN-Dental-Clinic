<?php 

if (!isset($_SESSION['student_email'])) {
    // Redirect to login page if student_email is not set
    header("Location: login.php");
    exit;
}

// Now you can use $_SESSION['student_email'] as needed in your code
// ...

?>
