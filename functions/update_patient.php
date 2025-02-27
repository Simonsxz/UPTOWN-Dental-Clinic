<?php
include "../functions/db_conn.php"; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Received Data: " . print_r($_POST, true));

    // Retrieve form data
    $patientId = $_POST['patient_id'];
    $patientFullName = $_POST['patient_fullName'];
    $patientDOB = $_POST['patient_DOB'];
    $patientAge = $_POST['patient_age'];
    $patientGender = $_POST['patient_gender'];
    $patientFamilyID = $_POST['patient_family']; 
    $patientDoctorID = $_POST['patient_doctor']; 
    $patientAddress = $_POST['patient_address'];
    $patientContact = $_POST['patient_contact'];
    $patientStatus = $_POST['patient_status'];
    $patientOccupation = $_POST['patient_occupation'];

    // ✅ Step 1: Fetch the Doctor's Full Name
    $patientDoctor = "N/A";
    if (!empty($patientDoctorID)) {
        $doctorQuery = "SELECT CONCAT('Dr. ', user_fName, ' ', user_lName) AS doctor_name FROM tbl_useraccount WHERE id = ?";
        $stmtDoctor = mysqli_prepare($conn, $doctorQuery);
        if ($stmtDoctor) {
            mysqli_stmt_bind_param($stmtDoctor, "i", $patientDoctorID);
            mysqli_stmt_execute($stmtDoctor);
            $resultDoctor = mysqli_stmt_get_result($stmtDoctor);
            if ($doctorRow = mysqli_fetch_assoc($resultDoctor)) {
                $patientDoctor = $doctorRow['doctor_name'];
            }
            mysqli_stmt_close($stmtDoctor);
        } else {
            error_log("Doctor Query Error: " . mysqli_error($conn));
        }
    }

    // ✅ Step 2: Fetch the Family Name
    $patientFamily = "N/A";
    if (!empty($patientFamilyID)) {
        $familyQuery = "SELECT CONCAT(folder_name, ' (', folder_head, ')') AS family_name FROM tbl_familyfolder WHERE id = ?";
        $stmtFamily = mysqli_prepare($conn, $familyQuery);
        if ($stmtFamily) {
            mysqli_stmt_bind_param($stmtFamily, "i", $patientFamilyID);
            mysqli_stmt_execute($stmtFamily);
            $resultFamily = mysqli_stmt_get_result($stmtFamily);
            if ($familyRow = mysqli_fetch_assoc($resultFamily)) {
                $patientFamily = $familyRow['family_name'];
            }
            mysqli_stmt_close($stmtFamily);
        } else {
            error_log("Family Query Error: " . mysqli_error($conn));
        }
    }

    // ✅ Debugging: Log fetched values
    error_log("Final Doctor Name: " . $patientDoctor);
    error_log("Final Family Name: " . $patientFamily);

    // If doctor or family is still an ID, log an error
    if ($patientDoctorID == $patientDoctor) {
        error_log("ERROR: Doctor name not fetched correctly, still showing ID.");
    }
    if ($patientFamilyID == $patientFamily) {
        error_log("ERROR: Family name not fetched correctly, still showing ID.");
    }

    // ✅ Step 3: Update the Patient Record with Names Instead of IDs
    $query = "UPDATE tbl_patientaccount SET 
                patient_fullName = ?, 
                patient_DOB = ?, 
                patient_age = ?, 
                patient_gender = ?, 
                patient_family = ?,  
                patient_doctor = ?,  
                patient_address = ?, 
                patient_contact = ?, 
                patient_status = ?, 
                patient_occupation = ? 
              WHERE patient_id = ?";

    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssssssss", 
            $patientFullName, $patientDOB, $patientAge, 
            $patientGender, $patientFamily, $patientDoctor, 
            $patientAddress, $patientContact, $patientStatus, 
            $patientOccupation, $patientId);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["success" => "Patient updated successfully."]);
        } else {
            error_log("SQL Update Error: " . mysqli_stmt_error($stmt)); 
            echo json_encode(["error" => "Failed to update patient. Error: " . mysqli_stmt_error($stmt)]);
        }

        mysqli_stmt_close($stmt);
    } else {
        error_log("Update Query Error: " . mysqli_error($conn));
        echo json_encode(["error" => "Database query failed."]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
?>
