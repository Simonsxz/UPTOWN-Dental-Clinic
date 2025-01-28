<?php
session_start();

// Include database connection
include "../functions/db_conn.php";

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = [];

// Validate required fields
if (empty($_POST['patient_id']) || empty($_POST['prescription_id'])) {
    $response = ['success' => false, 'message' => 'Patient ID and Prescription ID are required.'];
    echo json_encode($response);
    exit;
}

$patientId = $_POST['patient_id'];
$prescriptionId = $_POST['prescription_id'];

// Directory to store uploaded images
$uploadDir = '../uploads/xrays/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$imagePaths = [];

// Save uploaded images, if any
if (!empty($_FILES)) {
    foreach ($_FILES as $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_' . basename($file['name']);
            $targetFilePath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                $imagePaths[] = $targetFilePath;
            } else {
                $response = ['success' => false, 'message' => 'Failed to upload images.'];
                echo json_encode($response);
                exit;
            }
        }
    }
}

// If no images were uploaded, set $imagePathsJson to NULL
$imagePathsJson = empty($imagePaths) ? NULL : json_encode($imagePaths);

// Insert data into the database     
$query = "INSERT INTO tbl_patientxray (patient_id, prescription_id, image_paths, created_at) VALUES (?, ?, ?, NOW())";

$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $patientId, $prescriptionId, $imagePathsJson);

if ($stmt->execute()) {
    $response = ['success' => true, 'message' => 'X-rays saved successfully.'];
} else {
    $response = ['success' => false, 'message' => 'Database insertion failed.'];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
