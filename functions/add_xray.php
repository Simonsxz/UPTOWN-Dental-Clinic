<?php
session_start();
include "../functions/db_conn.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

$response = [];

if (empty($_POST['patient_id']) || empty($_POST['procedure_id'])) {
    $response = ['success' => false, 'message' => 'Patient ID and Procedure ID are required.'];
    echo json_encode($response);
    exit;
}

$patientId = $_POST['patient_id'];
$procedureId = $_POST['procedure_id'];

$uploadDir = '../uploads/xrays/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$imagePaths = [];

foreach ($_FILES as $key => $file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = uniqid() . '_' . basename($file['name']);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            $imagePaths[] = $targetFilePath;
        } else {
            error_log("Failed to upload: " . $file['name']);
        }
    }
}

$imagePathsJson = json_encode($imagePaths, JSON_UNESCAPED_SLASHES);

$query = "INSERT INTO tbl_patientxray (patient_id, procedure_id, image_paths, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $patientId, $procedureId, $imagePathsJson);

if ($stmt->execute()) {
    $response = ['success' => true, 'message' => 'X-rays saved successfully.'];
} else {
    $response = ['success' => false, 'message' => 'Database insertion failed.'];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>