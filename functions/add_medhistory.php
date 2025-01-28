<?php
session_start();

include "db_conn.php"; // Database connection

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (empty($data['patient_id']) || empty($data['prescription_id']) || empty($data['medhistory_lastvisit'])) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

$patientId = $data['patient_id'];
$prescriptionId = $data['prescription_id'];
$lastVisit = $data['medhistory_lastvisit'];
$physicianName = $data['medhistory_genphysician'];
$seriousIllness = $data['medhistory_serious'];
$illnessDescription = $data['medhistory_ifyesserious'];
$bloodTransfusion = $data['medhistory_bloodtrans'];
$transfusionDates = $data['medhistory_ifyesdate'];
$pregnant = $data['medhistory_pregnant'];
$birthControl = $data['medhistory_birthcontrol'];
$takingMed = $data['medhistory_takingmed'];
$medicationSpecify = $data['medhistory_ifyesmed'];

// Insert into the database
$stmt = $conn->prepare("INSERT INTO tbl_patientmedhistory (patient_id, prescription_id, medhistory_lastvisit, medhistory_genphysician, medhistory_serious, medhistory_ifyesserious, medhistory_bloodtrans, medhistory_ifyesdate, medhistory_pregnant, medhistory_birthcontrol, medhistory_takingmed, medhistory_ifyesmed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssss", $patientId, $prescriptionId, $lastVisit, $physicianName, $seriousIllness, $illnessDescription, $bloodTransfusion, $transfusionDates, $pregnant, $birthControl, $takingMed, $medicationSpecify);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true, 'message' => 'Medical History saved successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save Medical History.']);
}

$stmt->close();
$conn->close();
?>