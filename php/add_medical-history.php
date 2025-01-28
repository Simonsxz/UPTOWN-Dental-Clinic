
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

if (isset($_GET['patient_id'])) {
    $_SESSION['patient_id'] = $_GET['patient_id'];
}

$patientId = $_SESSION['patient_id'] ?? null;

if ($patientId) {
    // Fetch the patient name from the database using the patient_id
    // Example function call (make sure to replace with your actual function)
    $patientFullName = getPatientFullName($patientId); // Implement this function to fetch the name from DB
} else {
    $patientFullName = "No Name Available"; // Fallback in case no patient_id is found
}
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
    <link rel="icon" type="image/x-icon" href="\assets\uplogo.png">
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
		
			<li><a href="dashboard.php" ><i class='bx bxs-dashboard icon' ></i>Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
			<?php if ($user_ID && isAdmin($user_ID, $conn)): ?>
				<li><a href="doctors.php"><i class='bx bxs-user-detail icon'></i> User Account</a></li>
			<?php endif; ?>

			<li><a href="patient.php" class="active"><i class='bx bxs-user-circle icon' ></i> Patient </a></li>
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
                                    <a href="patient.php" id="cancelLink">
                                        <button type="button" class="cancel">Cancel</button>
                                    </a>
                                    <button type="button" class="save" id="saveButton">Next</button>
                                </div>
								</div>
							</div>												
                            <div class="table-container">

							<div class="module-container">
                            <div class="horizontal-nav-bar">
                                <a href="add_patientinfo.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item " disabled style="cursor: not-allowed;">P.I.R</button>
                                </a>
                                <a href="add_prescription.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item " disabled style="cursor: not-allowed;">Prescription</button>
                                </a>
                                <a href="add_medical-history.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item active" disabled style="cursor: not-allowed;">Medical History</button>
                                </a>
                                <a href="medical-condition.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item" disabled style="cursor: not-allowed;">Medical Condition</button>
                                </a>
                                <a href="ptp.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item" disabled style="cursor: not-allowed;">PTP</button>
                                </a>
                                <a href="procedure.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item" disabled style="cursor: not-allowed;">Procedures</button>
                                </a>
                                <a href="patient-xray.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item" disabled style="cursor: not-allowed;">Xray</button>
                                </a>
                                <a href="patient-intra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item" disabled style="cursor: not-allowed;">Intra Oral Photos</button>
                                </a>
                                <a href="patient-extra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item" disabled style="cursor: not-allowed;">Extra Oral Photos</button>
                                </a>
                                <a href="notes.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item" disabled style="cursor: not-allowed;">Notes</button>
                                </a>
                            </div>

						</div>


                        <div class="info-container">
            <h2 class="info-title">Medical History</h2>
            <form class="details-form" id="medicalHistoryForm">
    <div class="form-group">
        <label for="last-visit">Date of Last Visit:</label>
        <input type="date" id="last-visit" name="last-visit" class="form-input" required>
    </div>
    <div class="form-group">
        <label for="physician-name">General Physician's Name:</label>
        <input type="text" id="physician-name" name="physician-name" class="form-input" required>
    </div>
    <div class="form-group">
        <label>Have you had any serious illness or operation?</label>
        <textarea id="serious-illness" name="serious-illness" class="form-input" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label>If Yes, describe:</label>
        <textarea id="illness-description" name="illness-description" class="form-input" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label>Have you ever had a blood transfusion?</label>
        <div>
            <label><input type="radio" name="blood-transfusion" value="yes" required> Yes</label>
            <label><input type="radio" name="blood-transfusion" value="no" required> No</label>
        </div>
    </div>
    <div class="form-group">
        <label>If Yes, give approximate dates:</label>
        <input type="text" id="transfusion-dates" name="transfusion-dates" class="form-input" required>
    </div>
    <div class="form-group">
        <label>(For Women only) Are you pregnant?</label>
        <div>
            <label><input type="radio" name="pregnant" value="yes" required> Yes</label>
            <label><input type="radio" name="pregnant" value="no" required> No</label>
        </div>
    </div>
    <div class="form-group">
        <label>Are you taking birth control pills?</label>
        <div>
            <label><input type="radio" name="birth-control" value="yes" required> Yes</label>
            <label><input type="radio" name="birth-control" value="no" required> No</label>
        </div>
    </div>
    <div class="form-group">
        <label>Are you taking any medication?</label>
        <div>
            <label><input type="radio" name="medication" value="yes" required> Yes</label>
            <label><input type="radio" name="medication" value="no" required> No</label>
        </div>
    </div>
    <div class="form-group">
        <label>If Yes, please specify:</label>
        <textarea id="medication-specify" name="medication-specify" class="form-input" rows="3" required></textarea>
    </div>
</form>

        </div>

        </main>
      
</body>

<script>
document.getElementById('cancelLink').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action (navigation)
        
        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'The data will not be saved!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel',
            cancelButtonText: 'No, stay'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, redirect to patient.php
                window.location.href = this.href;
            } else {
                // If the user clicks "No", nothing happens
                Swal.fire('Cancelled', 'You can continue with your work.', 'info');
            }
        });
    }); 


 document.getElementById("saveButton").addEventListener("click", function() {
    // Collect all form data
    const lastVisit = document.getElementById("last-visit").value;
    const physicianName = document.getElementById("physician-name").value;
    const seriousIllness = document.getElementById("serious-illness").value;
    const illnessDescription = document.getElementById("illness-description").value;
    const bloodTransfusion = document.querySelector('input[name="blood-transfusion"]:checked')?.value;
    const transfusionDates = document.getElementById("transfusion-dates").value;
    const pregnant = document.querySelector('input[name="pregnant"]:checked')?.value;
    const birthControl = document.querySelector('input[name="birth-control"]:checked')?.value;
    const takingMed = document.querySelector('input[name="medication"]:checked')?.value;
    const medicationSpecify = document.getElementById("medication-specify").value;

    // Get patient_id from session or URL and prescription_id
    const patientId = '<?php echo $_SESSION['patient_id'] ?? ""; ?>';  // Get patient ID from session or URL
    const prescriptionId = '<?php echo $_SESSION['prescription_id'] ?? ""; ?>'; // Make sure prescription_id is also set correctly

    // Validate required fields
    if (!lastVisit || !physicianName || !seriousIllness || !illnessDescription || !bloodTransfusion || !transfusionDates || !pregnant || !birthControl || !takingMed || !medicationSpecify) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill out all fields.'
        });
        return;
    }

    // Ask the user whether to save or edit the data
    Swal.fire({
        title: 'Do you want to save the data?',
        text: 'Please confirm if you want to proceed with saving your Medical History.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save it',
        cancelButtonText: 'No, Edit the Data'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with saving the data if the user clicks "Yes"
            const data = {
                patient_id: patientId,  // Use actual patient ID
                prescription_id: prescriptionId,  // Use actual prescription ID
                medhistory_lastvisit: lastVisit,
                medhistory_genphysician: physicianName,
                medhistory_serious: seriousIllness,
                medhistory_ifyesserious: illnessDescription,
                medhistory_bloodtrans: bloodTransfusion,
                medhistory_ifyesdate: transfusionDates,
                medhistory_pregnant: pregnant,
                medhistory_birthcontrol: birthControl,
                medhistory_takingmed: takingMed,
                medhistory_ifyesmed: medicationSpecify
            };

            // Send data to the PHP server using AJAX
            fetch('../functions/add_medhistory.php', {  // Replace with the correct PHP script path
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Medical History saved successfully.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Redirect after 1.5 seconds
                        window.location.href = `add_medicalcondition.php?patient_id=${patientId}&prescription_id=${prescriptionId}`;
                    });
                } else {
                    // Show SweetAlert for failure
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: 'Failed to save Medical History.'
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while saving Medical History.'
                });
            });
        } else {
            // If the user clicks "No, Edit the Data", show a message and stay on the form
            Swal.fire({
                icon: 'info',
                title: 'You can edit the data.',
                text: 'Please make changes and try saving again.'
            });
        }
    });
});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="/js/medical-history.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>