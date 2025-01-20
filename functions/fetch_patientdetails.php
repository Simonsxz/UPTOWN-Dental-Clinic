<?php
session_start();
include "../functions/db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['patient_id'])) {
    $patientId = $_POST['patient_id'];
    $response = [];

    // Query to fetch patient details
    $query = "SELECT * FROM tbl_patientaccount WHERE patient_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response = $result->fetch_assoc();
    } else {
        $response['error'] = 'No patient found with the given ID.';
    }

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>
