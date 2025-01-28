<?php
header('Content-Type: application/json');
session_start();

include "db_conn.php"; // Include your database connection

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (empty($data['patient_id']) || empty($data['description']) || empty($data['patient_prescription'])) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

$patientId = $data['patient_id'];
$patientPrescription = $data['patient_prescription'];  // The title entered by the user
$description = $data['description'];  // Notes entered by the user

// Initialize prescription_id variable
$newPrescriptionId = 'prescription_0001'; // Default starting value

// Check if data already exists for this patient and prescription title
$stmt = $conn->prepare("SELECT id FROM tbl_patientprescription WHERE patient_id = ? AND patient_prescription = ?");
$stmt->bind_param("ss", $patientId, $data['patient_prescription']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing data
    $stmt = $conn->prepare("UPDATE tbl_patientprescription SET description = ?, updated_at = NOW() WHERE patient_id = ? AND patient_prescription = ?");
    $stmt->bind_param("sss", $description, $patientId, $data['patient_prescription']);
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Data updated successfully.']);
} else {
    // Fetch the latest prescription_id and increment it
    $latestIdQuery = "SELECT MAX(CAST(SUBSTRING_INDEX(prescription_id, '_', -1) AS UNSIGNED)) AS latest_id FROM tbl_patientprescription WHERE patient_id = ?";
    $stmt = $conn->prepare($latestIdQuery);
    $stmt->bind_param("s", $patientId);
    $stmt->execute();
    $idResult = $stmt->get_result();
    
    if ($idResult->num_rows > 0) {
        $row = $idResult->fetch_assoc();
        $latestId = $row['latest_id'] ?? 0;
        $newPrescriptionId = 'prescription_' . str_pad($latestId + 1, 4, '0', STR_PAD_LEFT);  // Increment prescription id
    }

    // Insert new data with the prescription_id generated and patient_prescription as the title
    $stmt = $conn->prepare("INSERT INTO tbl_patientprescription (patient_id, prescription_id, patient_prescription, description, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $patientId, $newPrescriptionId, $patientPrescription, $description);
    $stmt->execute();

    // Send back the success response with the newly generated prescription_id
    echo json_encode(['success' => true, 'message' => 'Data inserted successfully with Prescription ID: ' . $newPrescriptionId, 'prescription_id' => $newPrescriptionId]);
}

$stmt->close();
$conn->close();
?>
