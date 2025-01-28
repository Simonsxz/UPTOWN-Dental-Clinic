<?php
session_start();
include "../functions/db_conn.php";

// Enable error reporting for debugging
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

// Validate required fields
if (empty($_POST["patient_id"]) || empty($_POST["prescription_id"]) || empty($_POST["treatment_plans"])) {
    echo json_encode(["success" => false, "message" => "Patient ID, Prescription ID, and Treatment Plans are required."]);
    exit;
}

$patientId = $_POST["patient_id"];
$prescriptionId = $_POST["prescription_id"];
$treatmentPlans = $_POST["treatment_plans"];

// Handle file uploads
$imagePaths = [];
if (!empty($_FILES["images"]["name"][0])) {
    $uploadDir = "../uploads/ptp_images/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
    }

    foreach ($_FILES["images"]["tmp_name"] as $key => $tmpName) {
        $fileName = basename($_FILES["images"]["name"][$key]);
        $filePath = $uploadDir . uniqid() . "_" . $fileName;

        if (move_uploaded_file($tmpName, $filePath)) {
            $imagePaths[] = str_replace("../", "", $filePath); // Store relative paths
        } else {
            echo json_encode(["success" => false, "message" => "Error uploading images."]);
            exit;
        }
    }
}

// Insert data into the database
$imagePathsString = json_encode($imagePaths);
$query = "INSERT INTO tbl_ptp (patient_id, prescription_id, treatment_plans, images, created_at, updated_at) 
          VALUES (?, ?, ?, ?, NOW(), NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $patientId, $prescriptionId, $treatmentPlans, $imagePathsString);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Treatment plans saved successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to save treatment plans."]);
}

// Close resources
$stmt->close();
$conn->close();
?>
