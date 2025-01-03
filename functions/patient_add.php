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
        'height' => $_POST['height'],
        'weight' => $_POST['weight'],
        'status' => $_POST['status'],
        'occupation' => $_POST['occupation'],
        'religion' => $_POST['religion'],
        'contact' => $_POST['contact'],
        'facebook' => $_POST['facebook'],
        'nationality' => $_POST['nationality'],
        'referredBy' => $_POST['referredBy'],
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
    $height = $patientData['height'];
    $weight = $patientData['weight'];
    $status = $patientData['status'];
    $occupation = $patientData['occupation'];
    $religion = $patientData['religion'];
    $contact = $patientData['contact'];
    $facebook = $patientData['facebook'];
    $nationality = $patientData['nationality'];
    $referredBy = $patientData['referredBy'];
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

    $sql = "INSERT INTO tbl_patientaccount (
                patient_fullName,
                patient_doctor,
                patient_address,
                patient_DOB,
                patient_age,
                patient_gender,
                patient_height,
                patient_weight,
                patient_status,
                patient_occupation,
                patient_religion,
                patient_contact,
                patient_facebook,
                patient_nationality,
                patient_referrredby,
                patient_created,
                patient_family
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return "Preparation failed: " . mysqli_error($conn);
    }

    // Adjusted the number of parameters to match placeholders
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssssssss", 
        $fullName,
        $doctor,
        $address,
        $DOB,
        $age,
        $gender,
        $height,
        $weight,
        $status,
        $occupation,
        $religion,
        $contact,
        $facebook,
        $nationality,
        $referredBy,
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
