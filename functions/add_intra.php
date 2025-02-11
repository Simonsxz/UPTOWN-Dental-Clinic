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
if (empty($_POST['patient_id']) || empty($_POST['procedure_id'])) {
    $response = ['success' => false, 'message' => 'Patient ID and Procedure ID are required.'];
    echo json_encode($response);
    exit;
}

$patientId = $_POST['patient_id'];
$procedureId = $_POST['procedure_id']; // Change prescription_id to procedure_id

// Directory to store uploaded intra oral photos
$uploadDir = '../uploads/intra_photos/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$imagePaths = [];
if (!empty($_FILES)) { // Ensure there's at least one file
    foreach ($_FILES as $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_' . basename($file['name']);
            $targetFilePath = $uploadDir . $fileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                $imagePaths[] = $targetFilePath; // Append the file path to the array
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload file: ' . $file['name']]);
                exit;
            }
        }
    }
}

// If no images are uploaded, set imagePathsJson to NULL
$imagePathsJson = empty($imagePaths) ? NULL : json_encode($imagePaths, JSON_UNESCAPED_SLASHES);

// Insert the paths into the database
$query = "INSERT INTO tbl_patientintra (patient_id, procedure_id, image_paths, created_at) VALUES (?, ?, ?, NOW())"; 
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $patientId, $procedureId, $imagePathsJson); 

if ($stmt->execute()) {
    $response = ['success' => true, 'message' => 'Intra Oral Photos saved successfully.'];
} else {
    $response = ['success' => false, 'message' => 'Database insertion failed.'];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
