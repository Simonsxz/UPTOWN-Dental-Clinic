<?php
session_start();
include "../functions/db_conn.php";

if (isset($_POST['fetch_history']) && isset($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];
    
    // Log to see if patient_id is being received
    error_log('Received patient_id: ' . $patient_id);  // Log to PHP error log

    // Fetch patient details from tbl_patientaccount
    $sql = "SELECT patient_name
            FROM tbl_patientaccount 
            WHERE patient_id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $patient_id);

    $patient_name = "";
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $patient_name);
        mysqli_stmt_fetch($stmt);
    }
    mysqli_stmt_close($stmt);

    // If no patient is found
    if (empty($patient_name)) {
        echo json_encode(['error' => 'Patient not found']);
        exit;
    }

    // Continue with fetching history
    $sql = "SELECT patient_prescription, patient_doctor, patient_payment, prescription_date
            FROM tbl_patienthistory 
            WHERE patient_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $patient_id);

    $patient_prescription = "";
    $patient_doctor = "";
    $patient_payment = "";
    $prescription_date = "";

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $patient_prescription, $patient_doctor, $patient_payment, $prescription_date);
        mysqli_stmt_fetch($stmt);
    }
    mysqli_stmt_close($stmt);

    // Prepare the response with patient details and history
    echo json_encode([
        'patient_name' => $patient_name,
        'patient_id' => $patient_id,
        'patient_prescription' => $patient_prescription,
        'patient_doctor' => $patient_doctor,
        'patient_payment' => $patient_payment,
        'prescription_date' => $prescription_date
    ]);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
