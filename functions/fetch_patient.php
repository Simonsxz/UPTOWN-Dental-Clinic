<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../functions/db_conn.php"; // Ensure this file is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['patient_id'])) {
    $patientId = $_POST['patient_id'];

    error_log("Fetching patient with ID: " . $patientId); // Debugging

    // Fetch directly from tbl_patientaccount (no joins needed)
    $query = "SELECT 
    patient_id,
    patient_fullName,
    patient_DOB,
    patient_age,
    patient_gender,
    patient_address,
    patient_contact,
    patient_status,
    patient_occupation,
    patient_doctor,  -- Ensure this is the doctor ID
    patient_family   -- Ensure this is the family ID
  FROM tbl_patientaccount
  WHERE patient_id = ?";



    $stmt = mysqli_prepare($conn, $query);
    
    if (!$stmt) {
        echo json_encode(["error" => "SQL Error: " . mysqli_error($conn)]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "s", $patientId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $response = [
            "patient_id" => $row['patient_id'],
            "patient_fullName" => $row['patient_fullName'],
            "patient_DOB" => $row['patient_DOB'],
            "patient_age" => $row['patient_age'],
            "patient_gender" => $row['patient_gender'],
            "patient_address" => $row['patient_address'],
            "patient_contact" => $row['patient_contact'],
            "patient_status" => $row['patient_status'],
            "patient_occupation" => $row['patient_occupation'],
            "patient_doctor" => $row['patient_doctor'],
            "patient_family" => isset($row['patient_family']) && $row['patient_family'] !== "" ? $row['patient_family'] : "N/A" // Set "N/A" only if NULL or empty
        ];
        
        echo json_encode($response);
        
    } else {
        echo json_encode(["error" => "Patient not found"]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
