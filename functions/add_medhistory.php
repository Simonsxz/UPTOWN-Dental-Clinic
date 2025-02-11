<?php
session_start();
include "db_conn.php"; // Database connection

header('Content-Type: application/json'); // ✅ Set JSON response type

// Debugging: Log incoming data
error_log("Received Data: " . file_get_contents('php://input'));

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['patient_id']) || empty($data['procedure_id'])) {
    echo json_encode(['success' => false, 'message' => 'Patient ID and Procedure ID are required.']);
    exit;
}


// Assign variables
$patientId = $data['patient_id'];
$procedureId = $data['procedure_id'];
$lastVisit = $data['medhistory_lastvisit'];
$physicianName = $data['medhistory_genphysician'];
$seriousIllness = $data['medhistory_serious'];
$illnessDescription = $data['medhistory_ifyesserious'];
$bloodTransfusion = $data['medhistory_bloodtrans'];
$transfusionDates = $data['medhistory_ifyesdate'];
$pregnant = $data['medhistory_pregnant'];
$takingMed = $data['medhistory_takingmed'];
$medicationSpecify = $data['medhistory_ifyesmed'];

// ✅ Fix: Removed `medhistory_birthcontrol`
$stmt = $conn->prepare("INSERT INTO tbl_patientmedhistory (patient_id, procedure_id, medhistory_lastvisit, medhistory_genphysician, medhistory_serious, medhistory_ifyesserious, medhistory_bloodtrans, medhistory_ifyesdate, medhistory_pregnant, medhistory_takingmed, medhistory_ifyesmed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssss", $patientId, $procedureId, $lastVisit, $physicianName, $seriousIllness, $illnessDescription, $bloodTransfusion, $transfusionDates, $pregnant, $takingMed, $medicationSpecify);

// ✅ Fix: Only execute once
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Medical History saved successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>
