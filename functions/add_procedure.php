<?php
session_start();
include "../functions/db_conn.php";

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ✅ Get JSON data
$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['patient_id']) || empty($data['procedure_id']) || empty($data['procedures'])) {
    echo json_encode(['success' => false, 'message' => 'Patient ID, Procedure ID, and Procedures are required.']);
    exit;
}

$patientId = $data['patient_id'];
$procedureId = $data['procedure_id'];
$createdAt = date("Y-m-d H:i:s");
$updatedAt = $createdAt;
$procedures = $data['procedures'];

// ✅ Combine all procedures into a single string (separated by "|")
$procedureDetailsArray = [];
foreach ($procedures as $procedure) {
    if (!empty($procedure['title']) && !empty($procedure['price'])) {
        $procedureDetailsArray[] = $procedure['title'] . " - ₱" . $procedure['price'];
    }
}
$procedureDetails = implode(" | ", $procedureDetailsArray); // Use " | " as separator

// ✅ Insert single row with all procedures combined
$query = "INSERT INTO tbl_procedure (patient_id, procedure_id, procedure_details, created_at, updated_at) 
          VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssss", $patientId, $procedureId, $procedureDetails, $createdAt, $updatedAt);
$stmt->execute();

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'message' => 'Procedures saved successfully.']);
?>
