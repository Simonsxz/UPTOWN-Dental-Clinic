<?php
session_start();
include "../functions/db_conn.php";

// Enable error reporting for debugging
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

// Validate required fields
if (empty($_POST["patient_id"]) || empty($_POST["prescription_id"]) || empty($_POST["notes"])) {
    echo json_encode(["success" => false, "message" => "Patient ID, Prescription ID, and Notes are required."]);
    exit;
}

$patientId = $_POST["patient_id"];
$prescriptionId = $_POST["prescription_id"];
$notes = $_POST["notes"];

// Get the doctor name based on the user_ID from the session
$user_ID = $_SESSION['user_ID'] ?? null; // Get the user_ID from session

if (!$user_ID) {
    echo json_encode(["success" => false, "message" => "User ID not found in the session."]);
    exit;
}

$doctorQuery = "SELECT CONCAT(user_fName, ' ', user_lName) AS patient_doctor FROM tbl_useraccount WHERE user_ID = ?";
$doctorStmt = $conn->prepare($doctorQuery);
$doctorStmt->bind_param("s", $user_ID);
$doctorStmt->execute();
$doctorStmt->bind_result($patientDoctor);
$doctorStmt->fetch();
$doctorStmt->close();

if (empty($patientDoctor)) {
    echo json_encode(["success" => false, "message" => "Doctor details not found."]);
    exit;
}

// Handle file uploads
$imagePaths = [];
if (!empty($_FILES["images"]["name"][0])) {
    $uploadDir = "../uploads/notes_images/";
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

// Convert the array of image paths to a JSON string
$imagePathsString = json_encode($imagePaths);

// Insert data into the database
$query = "INSERT INTO tbl_patientnotes (patient_id, prescription_id, notes, images, patient_doctor, created_at) 
          VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssss", $patientId, $prescriptionId, $notes, $imagePathsString, $patientDoctor);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Notes and images saved successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to save notes and images."]);
}

// Close resources
$stmt->close();
$conn->close();
?>
