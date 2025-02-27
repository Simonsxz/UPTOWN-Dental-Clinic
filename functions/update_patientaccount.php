<?php
include "../functions/db_conn.php"; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['patient_id'], $_POST['patient_fullName'], $_POST['patient_family'], $_POST['patient_address'])) {
        $patient_id = trim($_POST['patient_id']); // Trim whitespace
        $fullName = trim($_POST['patient_fullName']);
        $family = trim($_POST['patient_family']);
        $address = trim($_POST['patient_address']);

        // Debugging: Log received values
        error_log("Updating patient_id: " . $patient_id);

        if (empty($patient_id)) {
            echo json_encode(["success" => false, "message" => "Invalid patient ID."]);
            exit();
        }

        // Prepared statement to update only the selected row
        $stmt = $conn->prepare("UPDATE tbl_patientaccount SET patient_fullName = ?, patient_family = ?, patient_address = ? WHERE patient_id = ?");
        $stmt->bind_param("ssss", $fullName, $family, $address, $patient_id); // Change "sssi" to "ssss"


        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Patient details updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update patient details."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Missing required fields."]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
