<?php
session_start();
include "../functions/db_conn.php";

if (isset($_POST['fetch_history']) && isset($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];

    // Query to fetch patient history
    $sql = "SELECT patient_id, patient_prescription, patient_doctor, patient_payment, prescription_date 
            FROM tbl_patienthistory 
            WHERE patient_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $patient_id);

    $history = [];
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $patient_id, $patient_prescription, $patient_doctor, $patient_payment, $prescription_date);
        while (mysqli_stmt_fetch($stmt)) {
            $history[] = [
                'patient_id' => $patient_id,
                'patient_prescription' => $patient_prescription,
                'patient_doctor' => $patient_doctor,
                'patient_payment' => $patient_payment,
                'prescription_date' => $prescription_date
            ];
        }
    } else {
        error_log("Query Error: " . mysqli_error($conn)); // Debugging
    }
    mysqli_stmt_close($stmt);

    // Send the JSON response
    header('Content-Type: application/json');
    if (!empty($history)) {
        echo json_encode(['history' => $history]);
    } else {
        echo json_encode(['error' => 'No history found for the given patient ID.']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request']);
}
?>