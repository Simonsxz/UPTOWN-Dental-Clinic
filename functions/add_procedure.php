<?php
session_start();

// Include necessary files
include "../functions/db_conn.php"; // Include database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Validate POST data
if (empty($_POST['patient_id']) || empty($_POST['prescription_id']) || empty($_POST['procedure_details'])) {
    echo json_encode(['success' => false, 'message' => 'Patient ID, Prescription ID, and Procedure Details are required.']);
    exit;
}

$patientId = $_POST['patient_id'];
$prescriptionId = $_POST['prescription_id'];
$procedureDetails = $_POST['procedure_details'];
$createdAt = date("Y-m-d H:i:s");
$updatedAt = $createdAt;

// Handle image upload
$imagePaths = [];
if (!empty($_FILES['images']['name'][0])) {
    $uploadDir = "../uploads/procedures/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES['images']['name'] as $key => $imageName) {
        $tempPath = $_FILES['images']['tmp_name'][$key];
        $imagePath = $uploadDir . uniqid() . "_" . basename($imageName);
        if (move_uploaded_file($tempPath, $imagePath)) {
            $imagePaths[] = $imagePath;
        }
    }
}

// Serialize image paths for storage
$imagePathsSerialized = json_encode($imagePaths);

// Insert into the database
$query = "INSERT INTO tbl_procedure (patient_id, prescription_id, procedure_details, images, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssss", $patientId, $prescriptionId, $procedureDetails, $imagePathsSerialized, $createdAt, $updatedAt);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Procedure details saved successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save Procedure details.']);
}

$stmt->close();
$conn->close();
?>
