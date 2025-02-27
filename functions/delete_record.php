<?php
require '../functions/db_conn.php'; // Ensure the database connection is included

// Enable error reporting for debugging (REMOVE in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure response is always JSON
header("Content-Type: application/json");

// Check if database connection is valid
if (!isset($conn)) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);
$patient_id = isset($data['patient_id']) ? trim($data['patient_id']) : null;
$procedure_id = isset($data['procedure_id']) ? trim($data['procedure_id']) : null;

// Debug: Check if we received valid data
if (!$patient_id || !$procedure_id) {
    echo json_encode(["success" => false, "message" => "Invalid input. Patient ID or Procedure ID is missing."]);
    exit;
}

try {
    $tables = [
        "tbl_medicalhistory",
        "tbl_patientextra",
        "tbl_patientintra",
        "tbl_patientmedhistory",
        "tbl_patientnotes",
        "tbl_patientxray",
        "tbl_procedure",
        "tbl_ptp"
    ];

    // Start transaction
    mysqli_begin_transaction($conn);

    foreach ($tables as $table) {
        $sql = "DELETE FROM $table WHERE patient_id = ? AND procedure_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            throw new Exception("SQL Prepare failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "ss", $patient_id, $procedure_id); // Expect strings
        mysqli_stmt_execute($stmt);

        // Debug: Check if the row was actually deleted
        if (mysqli_stmt_affected_rows($stmt) === 0) {
            // No rows deleted for this table
            error_log("No records deleted in $table for patient_id: $patient_id and procedure_id: $procedure_id");
        }

        mysqli_stmt_close($stmt);
    }

    // Commit transaction
    mysqli_commit($conn);
    echo json_encode(["success" => true, "message" => "Record deleted successfully."]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

// Close connection (optional)
mysqli_close($conn);
?>
