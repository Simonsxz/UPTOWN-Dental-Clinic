<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
include 'db_conn.php';

if (!isset($_GET['patient_id'])) {
    echo json_encode(["success" => false, "message" => "No patient ID received"]);
    exit;
}

$patient_id = $_GET['patient_id'];

// Debug log
error_log("Received patient ID: " . $patient_id);

$query = "SELECT procedure_id FROM tbl_patientmedhistory WHERE patient_id = ? ORDER BY procedure_id DESC LIMIT 1";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    exit;
}

$stmt->bind_param("s", $patient_id); // Patient ID is a string
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo json_encode(["success" => false, "message" => "Query execution failed: " . $stmt->error]);
    exit;
}

$row = $result->fetch_assoc();

// If there is an existing procedure_id, increment it; otherwise, start at 1
if ($row) {
    preg_match('/(\d+)$/', $row['procedure_id'], $matches);
    $nextNumber = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
} else {
    $nextNumber = 1;
}

// Generate formatted procedure ID
$nextProcedureId = "procedure_" . str_pad($nextNumber, 6, "0", STR_PAD_LEFT);

// Debug log
error_log("Generated procedure ID: " . $nextProcedureId);

echo json_encode(["success" => true, "procedure_id" => $nextProcedureId]);
?>
