<?php 
$conn = mysqli_connect("localhost","root","","db_uptowndc");

if(isset($_POST['checking_view'])) {
    $user_id = $_POST['user_id']; // Get the user_id from the POST request
    $result_array = [];

    $query = "SELECT id, user_ID, user_fName, user_lName, user_role, user_created FROM tbl_useraccount WHERE user_ID='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        // Fetch and store the results in an array
        foreach($query_run as $row) {
            array_push($result_array, $row);
        }
        // Send the data back as JSON
        header('Content-type: application/json');
        echo json_encode($result_array);
    } else {
        // If no record found
        echo json_encode([]);
    }
}
?>
