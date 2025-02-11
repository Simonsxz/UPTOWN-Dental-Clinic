<?php
session_start();
include "../functions/db_conn.php";

// Check if 'fetch_history' and 'patient_id' are set in the POST request
if (isset($_POST['fetch_history']) && isset($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];

    // Query to fetch patient history using patient_id
    $sql = "SELECT patient_id, procedure_id, procedure_details, created_at 
            FROM patient_procedure_details 
            WHERE patient_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $patient_id); // Bind only patient_id

    $history = [];
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $patient_id, $procedure_id, $procedure_details, $created_at);
        while (mysqli_stmt_fetch($stmt)) {
            $history[] = [
                'patient_id' => $patient_id,
                'procedure_id' => $procedure_id,
                'procedure_details' => $procedure_details,
                'created_at' => $created_at
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
    echo json_encode(['error' => 'Invalid request. Missing patient_id']);
}
?>
