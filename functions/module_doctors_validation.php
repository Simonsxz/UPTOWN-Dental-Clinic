<?php
function isAdmin($user_ID, $conn) {
    $query = "SELECT user_role FROM tbl_useraccount WHERE user_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    return $user && $user['user_role'] === 'admin';
}

?>
