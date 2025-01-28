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

// Directory to store uploaded intra oral photos
$uploadDir = '../uploads/intra_photos/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$imagePaths = [];
if (!empty($_FILES['images']['name'][0])) { // Ensure there's at least one file
    $files = $_FILES['images'];
    $numFiles = count($files['name']); // Total number of files

    for ($i = 0; $i < $numFiles; $i++) {
        if ($files['error'][$i] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_' . basename($files['name'][$i]);
            $targetFilePath = $uploadDir . $fileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($files['tmp_name'][$i], $targetFilePath)) {
                $imagePaths[] = $targetFilePath; // Append the file path to the array
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload file: ' . $files['name'][$i]]);
                exit;
            }
        }
    }
}

// If no images are uploaded, set imagePathsJson to NULL
$imagePathsJson = empty($imagePaths) ? NULL : json_encode($imagePaths);

// Insert the paths into the database
$query = "INSERT INTO tbl_patientintra (patient_id, prescription_id, image_paths, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $patientId, $prescriptionId, $imagePathsJson);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Intra Oral Photos saved successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database insertion failed.']);
}
?>
