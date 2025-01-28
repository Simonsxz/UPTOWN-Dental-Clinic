<?php
session_start();

// Include necessary files
include "../functions/db_conn.php"; // Include database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure valid JSON input
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (empty($data['patient_id']) || empty($data['prescription_id']) || empty($data['medical_conditions'])) {
    echo json_encode(['success' => false, 'message' => 'Patient ID, Prescription ID, and Medical Conditions are required.']);
    exit;
}

$patientId = $data['patient_id'];
$prescriptionId = $data['prescription_id'];
$medicalConditions = $data['medical_conditions'];

// Prepare the columns and values for insertion
$columns = ['patient_id', 'prescription_id'];
$values = [$patientId, $prescriptionId];
$placeholders = ['?', '?'];

foreach ($medicalConditions as $conditionName => $conditionValue) {
    // Ensure the condition name maps to a valid column
    $validColumn = str_replace('medical_condition_', '', $conditionName);
    if (preg_match('/^[a-z_]+$/', $validColumn) && in_array($conditionValue, [0, 1])) {
        $columns[] = $validColumn;
        $values[] = $conditionValue;
        $placeholders[] = '?';
    }
}

if (count($columns) == 2) { // Only patient_id and prescription_id present
    echo json_encode(['success' => false, 'message' => 'No medical conditions selected.']);
    exit;
}

$query = "INSERT INTO tbl_medicalhistory (" . implode(", ", $columns) . ", created_at) 
          VALUES (" . implode(", ", $placeholders) . ", NOW())";

// Prepare and execute the query
$stmt = $conn->prepare($query);
$types = str_repeat("s", count($values));
$stmt->bind_param($types, ...$values);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Medical conditions saved successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
}

// Close resources
$stmt->close();
$conn->close();
?>
