<?php
session_start();  // Ensure session is started at the very top of the page

include "../functions/db_conn.php";         // Include database connection
include "../functions/function.php"; 
include "../functions/module_doctors_validation.php"; // Include the validation function

if (!isset($_SESSION['user_ID'])) {
    header("Location: ../index.php"); // Redirect to login if not authenticated
    exit;
}

$user_ID = $_SESSION['user_ID']; // Fetch user_ID from session

// Check if both patient_id and prescription_id are set in the URL parameters
if (isset($_GET['patient_id']) && isset($_GET['procedure_id'])) {
    $_SESSION['patient_id'] = $_GET['patient_id']; // Store patient_id in session
    $_SESSION['procedure_id'] = $_GET['procedure_id']; // Store prescription_id in session
}

$patientId = $_SESSION['patient_id'] ?? null;
$procedure_id = $_SESSION['procedure_id'] ?? null;

if ($patientId) {
    // Fetch the patient name from the database using the patient_id
    $patientFullName = getPatientFullName($patientId); // Implement this function to fetch the name from DB
} else {
    $patientFullName = "No Name Available"; // Fallback in case no patient_id is found
}

// You can now use $patientId and $prescriptionId wherever needed
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="\css\style.css">
    <link rel="icon" type="image/x-icon" href="/assets/uplogo.png">
    <title>Medical History</title>
</head>
<body>
  
    <div id="imageModalClient" class="modal chat-image-modal-client">
		<div class="modal-image-client-container">
			<div>
				<span class="close-image-client-button"><i class='bx bxs-x-square'></i></span>
			</div>
			<img class="modal-content-chat" id="modalImage">
		</div>
	</div>
    <!-- Side Bar -->
	<section id="sidebar">
		
		<ul class="side-menu">
			<!-- Main -->
            <li><a href="dashboard.php" ><i class='bx bxs-dashboard icon' ></i>Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
			<?php if ($user_ID && isAdmin($user_ID, $conn)): ?>
				<li><a href="doctors.php" ><i class='bx bxs-user-detail icon'></i> User Account</a></li>
			<?php endif; ?>

			<li><a href="patient.php"  class="active"><i class='bx bxs-user-circle icon' ></i> Patient </a></li>
            <li><a href="family.php"><i class='bx bxs-group icon'></i> Family </a></li>
			<li><a href=""><i class='bx bxs-report icon'></i> Reports </a></li>


			<!-- help -->
			<li class="divider" data-text="Settings">Settings</li>
            <li><a href="settings.php"><i class='bx bxs-cog icon'></i>Settings</i></a></li>
            <li><a href="logout.php"><i class='bx bxs-left-arrow-circle icon'></i>Logout</i></a></li>
		</ul>
	</section>
	<!-- Side Bar -->

    <!-- Main Content -->
	<section id="content">
		<!-- Navigation Bar -->
		<nav>
			<div class="nav-logo">
				<a href="#"><img src="/assets/uplogo.png" alt="App Icon" id="app-logo"></a>
				<i class='bx bx-menu toggle-sidebar' style="margin-left: 30px;"></i>
			
				<div class="nav-search-container">
				</div>
			</div>
			<!-- Space -->
			<!-- Profile -->
			<div class="profile">
			<h2><?php echo htmlspecialchars($user_ID); ?></h2> <!-- Display sanitized user_ID -->
      
			</div>
		</nav>
		<!-- Navigation Bar -->

		<!-- Main -->
		<main>
            <div class="dash-header">
                <h1 class="title">Medical History</h1>
                <ul class="breadcrumbs">
                    <li><p>Main</p></li>
                    <li class="divider">/</li>
                    <li><a href="#" class="active">Medical History</a></li>
                </ul>
            </div>

            <div class="main-content-main-container">
                <div class="left-container1">
                    <div class="welcome-dashboard-container">
                        <div class="welcome-dashboard-content-container">
							<div class="patient with-save-cancel">
							<div>
								<h2><?php echo htmlspecialchars($patientFullName); ?></h2>
								<p>All the details of the patient of UPTOWN Dental Clinic</p>
							</div>
								<div class="button-group">
								<a href="patient.php" >
									<button class="cancel">Go Back</button>
								</a>

								</div>
							</div>												
                            <div class="table-container">

							<div class="module-container">
							<div class="horizontal-nav-bar">
                            <a href="patient-info.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link">
									<button class="nav-item ">P.I.R</button>
								</a>
								<a href="medical-history.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link">
									<button class="nav-item active">Medical History</button>
								</a>
								<a href="medical-condition.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link">
									<button class="nav-item">Medical Condition</button>
								</a>
								<a href="ptp.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link">
									<button class="nav-item">PTP</button>
								</a>
								<a href="procedure.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link">
									<button class="nav-item">Procedures</button>
								</a>
								<a href="patient-xray.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link">
									<button class="nav-item">Xray</button>
								</a>
								<a href="patient-intra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link">
									<button class="nav-item">Intra Oral Photos</button>
								</a>
								<a href="patient-extra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link">
									<button class="nav-item">Extra Oral Photos</button>
								</a>
								<a href="notes.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link">
									<button class="nav-item">Notes</button>
								</a>
							</div>


						</div>

						<?php

$patientId = $_SESSION['patient_id'] ?? null;
$prescriptionId = $_SESSION['procedure_id'] ?? null; // Changed to prescription_id

if ($patientId && $prescriptionId) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'db_uptowndc');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from tbl_patientmedhistory
    $stmt = $conn->prepare("SELECT 
        medhistory_lastvisit,
        medhistory_genphysician,
        medhistory_serious,
        medhistory_ifyesserious,
        medhistory_bloodtrans,
        medhistory_ifyesdate,
        medhistory_pregnant,
        medhistory_birthcontrol,
        medhistory_takingmed,
        medhistory_ifyesmed 
    FROM tbl_patientmedhistory 
    WHERE patient_id = ? AND procedure_id = ?"); // Changed patient_prescription to prescription_id

    $stmt->bind_param("ss", $patientId, $procedure_id); // Use prescription_id instead
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if data exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('No medical history found for this patient.');</script>";
        $row = [];
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Patient ID or prescription not set.');</script>";
    $row = [];
}

?>

<div class="info-container">
    <h2 class="info-title">Medical History</h2>
    <form class="details-form">
        <div class="form-group">
            <label for="last-visit">Date of Last Visit:</label>
            <input type="date" id="last-visit" name="last-visit" class="form-input" value="<?php echo $row['medhistory_lastvisit'] ?? ''; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="physician-name">General Physician's Name:</label>
            <input type="text" id="physician-name" name="physician-name" class="form-input" value="<?php echo $row['medhistory_genphysician'] ?? ''; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Have you had any serious illness or operation?</label>
            <textarea id="serious-illness" name="serious-illness" class="form-input" rows="3" readonly><?php echo $row['medhistory_serious'] ?? ''; ?></textarea>
        </div>
        <div class="form-group">
            <label>If Yes, describe:</label>
            <textarea id="illness-description" name="illness-description" class="form-input" rows="3" readonly><?php echo $row['medhistory_ifyesserious'] ?? ''; ?></textarea>
        </div>
        <div class="form-group">
            <label>Have you ever had a blood transfusion?</label>
            <div>
            <label><input type="radio" name="blood-transfusion" value="yes" <?php echo (isset($row['medhistory_bloodtrans']) && strcasecmp($row['medhistory_bloodtrans'], 'Yes') == 0) ? 'checked' : ''; ?> disabled> Yes</label>
            <label><input type="radio" name="blood-transfusion" value="no" <?php echo (isset($row['medhistory_bloodtrans']) && strcasecmp($row['medhistory_bloodtrans'], 'No') == 0) ? 'checked' : ''; ?> disabled> No</label>
  </div>
        </div>
        <div class="form-group">
            <label>If Yes, give approximate dates:</label>
            <input type="text" id="transfusion-dates" name="transfusion-dates" class="form-input" value="<?php echo $row['medhistory_ifyesdate'] ?? ''; ?>" readonly>
        </div>
        <div class="form-group">
    <label>(For Women only) Are you pregnant?</label>
    <div>
        <label><input type="radio" name="pregnant" value="yes" <?php echo (isset($row['medhistory_pregnant']) && strcasecmp($row['medhistory_pregnant'], 'Yes') == 0) ? 'checked' : ''; ?> disabled> Yes</label>
        <label><input type="radio" name="pregnant" value="no" <?php echo (isset($row['medhistory_pregnant']) && strcasecmp($row['medhistory_pregnant'], 'No') == 0) ? 'checked' : ''; ?> disabled> No</label>
    </div>
</div>

<div class="form-group">
    <label>Are you taking birth control pills?</label>
    <div>
        <label><input type="radio" name="birth-control" value="yes" <?php echo (isset($row['medhistory_birthcontrol']) && strcasecmp($row['medhistory_birthcontrol'], 'Yes') == 0) ? 'checked' : ''; ?> disabled> Yes</label>
        <label><input type="radio" name="birth-control" value="no" <?php echo (isset($row['medhistory_birthcontrol']) && strcasecmp($row['medhistory_birthcontrol'], 'No') == 0) ? 'checked' : ''; ?> disabled> No</label>
    </div>
</div>

<div class="form-group">
    <label>Are you taking any medication?</label>
    <div>
        <label><input type="radio" name="medication" value="yes" <?php echo (isset($row['medhistory_takingmed']) && strcasecmp($row['medhistory_takingmed'], 'Yes') == 0) ? 'checked' : ''; ?> disabled> Yes</label>
        <label><input type="radio" name="medication" value="no" <?php echo (isset($row['medhistory_takingmed']) && strcasecmp($row['medhistory_takingmed'], 'No') == 0) ? 'checked' : ''; ?> disabled> No</label>
    </div>
</div>

        <div class="form-group">
            <label>If Yes, please specify:</label>
            <textarea id="medication-specify" name="medication-specify" class="form-input" rows="3" readonly><?php echo $row['medhistory_ifyesmed'] ?? ''; ?></textarea>
        </div>
    </form>
</div>

			
        </main>
      
</body>

<script>
		$.ajax({
    url: '../functions/fetch_patientdetails.php', // Replace with your API or PHP endpoint
    method: 'GET',
    data: { patient_id: 'UPDC-PT-000004' }, // Pass the patient ID dynamically
    success: function(data) {
        // Assuming the response is JSON and contains `patient_fullName`
        $('.patient.with-save-cancel h2').text(data.patient_fullName || 'No Name Available');
    },
    error: function(xhr, status, error) {
        console.error('Failed to fetch patient data:', error);
        $('.patient.with-save-cancel h2').text('No Name Available'); // Fallback on error
    }
});

</script>


</script>
 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="/js/medical-history.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>