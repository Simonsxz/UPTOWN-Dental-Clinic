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
if (isset($_GET['patient_id']) && isset($_GET['prescription_id'])) {
    $_SESSION['patient_id'] = $_GET['patient_id']; // Store patient_id in session
    $_SESSION['prescription_id'] = $_GET['prescription_id']; // Store prescription_id in session
}

$patientId = $_SESSION['patient_id'] ?? null;
$prescriptionId = $_SESSION['prescription_id'] ?? null;

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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/x-icon" href="/assets/uplogo.png">
    <title>Patient Information</title>
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
		
			<li><a href="dashboard.php"><i class='bx bxs-dashboard icon' ></i>Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
			<?php if ($user_ID && isAdmin($user_ID, $conn)): ?>
				<li><a href="doctors.php"><i class='bx bxs-user-detail icon'></i> User Account</a></li>
			<?php endif; ?>

			<li><a href="patient.php"  class="active"><i class='bx bxs-user-circle icon' ></i> Patient </a></li>
            <li><a href="family.php" ><i class='bx bxs-group icon'></i> Family </a></li>
			<li><a href=""><i class='bx bxs-report icon'></i> Reports </a></li>


			<!-- help -->
			<li class="divider" data-text="Settings">Settings</li>
            <li><a href="settings.html"><i class='bx bxs-cog icon'></i>Settings</i></a></li>
            <li><a href="#"><i class='bx bxs-left-arrow-circle icon'></i>Logout</i></a></li>
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

			<!-- Profile -->
			<div class="profile">
			<h2><?php echo htmlspecialchars($user_ID); ?></h2> <!-- Display sanitized user_ID -->
			</div>
		</nav>
		<!-- Navigation Bar -->

		<!-- Main -->
		<main>
            <div class="dash-header">
                <h1 class="title">Patient Information</h1>
                <ul class="breadcrumbs">
                    <li><p>Main</p></li>
                    <li class="divider">/</li>
                    <li><a href="#" class="active">Patient</a></li>
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
								<a href="patient-info.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item active">P.I.R</button>
								</a>
								<a href="medical-history.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Medical History</button>
								</a>
								<a href="medical-condition.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Medical Condition</button>
								</a>
								<a href="prescription.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Prescription</button>
								</a>
								<a href="ptp.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">PTP</button>
								</a>
								<a href="procedure.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Procedures</button>
								</a>
								<a href="patient-xray.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Xray</button>
								</a>
								<a href="patient-intra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Intra Oral Photos</button>
								</a>
								<a href="patient-extra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Extra Oral Photos</button>
								</a>
								<a href="notes.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Notes</button>
								</a>
							</div>

						</div>



			<div class="info-container">
				<h2 class="info-title">Patient Details</h2>
				<form class="details-form">
					<div class="form-group patient-name-group">
						<label for="patient-name">Family Member:</label>
						<input type="text" id="family" name="family" class="form-input patient-name">
					</div>
					<div class="form-group patient-name-group">
						<label for="patient-name">Patient's Name:</label>
						<input type="text" id="patient-name" name="patient-name" class="form-input patient-name">
					</div>
					<!-- Other form fields remain unchanged -->
					<div class="form-group">
						<label for="checkup-done-by">Check-Up Done By:</label>
						<input type="text" id="checkup-done-by" name="checkup-done-by" class="form-input">
					</div>
					<div class="form-group">
						<label for="address">Address:</label>
						<input type="text" id="address" name="address" class="form-input">
					</div>
					<div class="form-group">
						<label for="dob">Date of Birth:</label>
						<input type="date" id="dob" name="dob" class="form-input">
					</div>
					<div class="form-group">
						<label for="age">Age:</label>
						<input type="number" id="age" name="age" class="form-input">
					</div>
					<div class="form-group">
						<label for="gender">Gender:</label>
						<select id="gender" name="gender" class="form-input">
							<option value="male">Male</option>
							<option value="female">Female</option>
							<option value="other">Other</option>
						</select>
					</div>
					<div class="form-group">
						<label for="height">Height:</label>
						<input type="text" id="height" name="height" class="form-input">
					</div>
					<div class="form-group">
						<label for="weight">Weight:</label>
						<input type="text" id="weight" name="weight" class="form-input">
					</div>
					<div class="form-group">
						<label for="civil-status">Civil Status:</label>
						<input type="text" id="civil-status" name="civil-status" class="form-input">
					</div>
					<div class="form-group">
						<label for="occupation">Occupation:</label>
						<input type="text" id="occupation" name="occupation" class="form-input">
					</div>
					<div class="form-group">
						<label for="religion">Religion:</label>
						<input type="text" id="religion" name="religion" class="form-input">
					</div>
					<div class="form-group">
						<label for="contact-number">Contact Number:</label>
						<input type="tel" id="contact-number" name="contact-number" class="form-input">
					</div>
					<div class="form-group">
						<label for="facebook-account">Facebook Account:</label>
						<input type="text" id="facebook-account" name="facebook-account" class="form-input">
					</div>
					<div class="form-group">
						<label for="nationality">Nationality:</label>
						<input type="text" id="nationality" name="nationality" class="form-input">
					</div>
					<div class="form-group patient-name-group">
						<label for="referred-by">Referred By:</label>
						<input type="text" id="referred-by" name="referred-by" class="form-input">
					</div>
				</form>
			</div>
			
        </main>
      
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
$(document).ready(function () {
    // Trigger the data fetching on page load or based on a specific event
    const patientId = getParameterByName('patient_id'); // Function to get query params
    if (patientId) {
        fetchPatientDetails(patientId);
    }

    function fetchPatientDetails(patientId) {
        $.ajax({
            type: "POST",
            url: "../functions/fetch_patientdetails.php",
            data: { patient_id: patientId },
            success: function (response) {
                const data = JSON.parse(response);

                if (data.error) {
                    console.error(data.error);
                } else {
                    // Populate form fields with data
                    $('#family').val(data.patient_family || '');
                    $('#patient-name').val(data.patient_fullName || '');
                    $('#checkup-done-by').val(data.patient_doctor || '');
                    $('#address').val(data.patient_address || '');
                    $('#dob').val(data.patient_DOB || '');
                    $('#age').val(data.patient_age || '');
                    $('#gender').val(data.patient_gender || '').change();
                    $('#height').val(data.patient_height || '');
                    $('#weight').val(data.patient_weight || '');
                    $('#civil-status').val(data.patient_status || '');
                    $('#occupation').val(data.patient_occupation || '');
                    $('#religion').val(data.patient_religion || '');
                    $('#contact-number').val(data.patient_contact || '');
                    $('#facebook-account').val(data.patient_facebook || '');
                    $('#nationality').val(data.patient_nationality || '');
                    $('#referred-by').val(data.patient_referrredby || '');

					  // Update the <h2> within .patient.with-save-cancel
					  $('.patient.with-save-cancel h2').text(data.patient_fullName || 'No Name Available');
    
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching patient details:', error);
            }
        });
    }

    function getParameterByName(name) {
        const url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
        const results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
});

$(document).ready(function () {
    const storageKey = 'infoContainerData';

    // Save data to sessionStorage before navigating to another module
    function saveDataToSession() {
        const formData = {
            family: $('#family').val(),
            patientName: $('#patient-name').val(),
            firstVisit: $('#first-visit').val(),
            checkupDoneBy: $('#checkup-done-by').val(),
            address: $('#address').val(),
            dob: $('#dob').val(),
            age: $('#age').val(),
            gender: $('#gender').val(),
            height: $('#height').val(),
            weight: $('#weight').val(),
            civilStatus: $('#civil-status').val(),
            occupation: $('#occupation').val(),
            religion: $('#religion').val(),
            contactNumber: $('#contact-number').val(),
            facebookAccount: $('#facebook-account').val(),
            nationality: $('#nationality').val(),
            referredBy: $('#referred-by').val(),
        };
        sessionStorage.setItem(storageKey, JSON.stringify(formData));
    }

    // Load data from sessionStorage when the page loads
    function loadDataFromSession() {
        const cachedData = sessionStorage.getItem(storageKey);
        if (cachedData) {
            const formData = JSON.parse(cachedData);
            $('#family').val(formData.family || '');
            $('#patient-name').val(formData.patientName || '');
            $('#first-visit').val(formData.firstVisit || '');
            $('#checkup-done-by').val(formData.checkupDoneBy || '');
            $('#address').val(formData.address || '');
            $('#dob').val(formData.dob || '');
            $('#age').val(formData.age || '');
            $('#gender').val(formData.gender || '').change();
            $('#height').val(formData.height || '');
            $('#weight').val(formData.weight || '');
            $('#civil-status').val(formData.civilStatus || '');
            $('#occupation').val(formData.occupation || '');
            $('#religion').val(formData.religion || '');
            $('#contact-number').val(formData.contactNumber || '');
            $('#facebook-account').val(formData.facebookAccount || '');
            $('#nationality').val(formData.nationality || '');
            $('#referred-by').val(formData.referredBy || '');
        }
    }

    // Save data to sessionStorage when navigating to another module
    $('a.nav-item-link').on('click', function () {
        saveDataToSession();
    });

    // Load data from sessionStorage on page load
    loadDataFromSession();
});

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
<script src="/js/patient-info.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>