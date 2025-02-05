<?php
include "../functions/db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientData = [
        'fullName' => $_POST['fullName'],
        'doctor' => $_POST['doctor'],
        'address' => $_POST['address'],
        'DOB' => $_POST['DOB'],
        'age' => $_POST['age'],
        'gender' => $_POST['gender'],
        'status' => $_POST['status'],
        'occupation' => $_POST['occupation'],
        'contact' => $_POST['contact'],
        'family' => $_POST['family']
    ];

    echo addPatient($patientData);
}

function addPatient($patientData) {
    global $conn;

    // Extract data from the array
    $fullName = $patientData['fullName'];
    $doctor = $patientData['doctor'];
    $address = $patientData['address'];
    $DOB = $patientData['DOB'];
    $age = $patientData['age'];
    $gender = $patientData['gender'];
    $status = $patientData['status'];
    $occupation = $patientData['occupation'];
    $contact = $patientData['contact'];
    $familyId = $patientData['family'];

    // Fetch the full family details
    $family = 'N/A'; // Default value if no match found
    if ($familyId !== 'N/A') {
        $familyQuery = "SELECT CONCAT(folder_name, ' (', folder_head, ')') AS family_string FROM tbl_familyfolder WHERE id = ?";
        $familyStmt = mysqli_prepare($conn, $familyQuery);
        if ($familyStmt) {
            mysqli_stmt_bind_param($familyStmt, "i", $familyId);
            mysqli_stmt_execute($familyStmt);
            mysqli_stmt_bind_result($familyStmt, $familyString);
            if (mysqli_stmt_fetch($familyStmt)) {
                $family = $familyString; // Use the concatenated value
            }
            mysqli_stmt_close($familyStmt);
        }
    }

    // Check if a patient with the same fullName and family already exists
    $dupCheckQuery = "SELECT COUNT(*) FROM tbl_patientaccount WHERE patient_fullName = ? AND patient_family = ?";
    $dupCheckStmt = mysqli_prepare($conn, $dupCheckQuery);
    mysqli_stmt_bind_param($dupCheckStmt, "ss", $fullName, $family);
    mysqli_stmt_execute($dupCheckStmt);
    mysqli_stmt_bind_result($dupCheckStmt, $count);
    mysqli_stmt_fetch($dupCheckStmt);
    mysqli_stmt_close($dupCheckStmt);

    if ($count > 0) {
        return "A patient with the same name and family already exists.";
    }

    // Insert patient data
    $sql = "INSERT INTO tbl_patientaccount (
                patient_fullName,
                patient_doctor,
                patient_address,
                patient_DOB,
                patient_age,
                patient_gender,
                patient_status,
                patient_occupation,
                patient_contact,
                patient_created,
                patient_family
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return "Preparation failed: " . mysqli_error($conn);
    }

    // Adjusted the number of parameters to match placeholders
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssss", // Adjusted to match number of values being passed
        $fullName,
        $doctor,
        $address,
        $DOB,
        $age,
        $gender,
        $status,
        $occupation,
        $contact,
        $family
    );

    if (mysqli_stmt_execute($stmt)) {
        $lastId = mysqli_insert_id($conn); // Get the last inserted ID
        $patientId = "UPDC-PT-" . str_pad($lastId, 6, "0", STR_PAD_LEFT); // Format the patient ID

        // Update the patient record with the formatted patient ID
        $updateSQL = "UPDATE tbl_patientaccount SET patient_id = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($conn, $updateSQL);
        if ($updateStmt) {
            mysqli_stmt_bind_param($updateStmt, "si", $patientId, $lastId);
            mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);
        }

        mysqli_stmt_close($stmt);
        return "Patient added successfully with Patient ID: " . $patientId;
    } else {
        $error = "Execution failed: " . mysqli_error($conn);
        mysqli_stmt_close($stmt);
        return $error;
    }
}
?>
