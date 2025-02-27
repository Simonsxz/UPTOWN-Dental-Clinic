<?php
include "../functions/db_conn.php"; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];

    $stmt = $conn->prepare("SELECT * FROM tbl_patientaccount WHERE patient_id = ?");
    $stmt->bind_param("s", $patient_id); // Ensure binding is correct
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(["success" => true, "data" => $row]);
    } else {
        echo json_encode(["success" => false, "message" => "No patient found."]);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
