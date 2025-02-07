<?php
session_start(); // Start session

include "../functions/db_conn.php"; // Database connection
include "../functions/function.php"; 
include "../functions/module_doctors_validation.php"; // Validation function

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['user_ID'])) {
    header("Location: ../index.php");
    exit;
}

$user_ID = $_SESSION['user_ID']; 

// Store patient_id and procedure_id in session (only if provided)
if (isset($_GET['patient_id'])) {
    $_SESSION['patient_id'] = $_GET['patient_id'];
}
if (isset($_GET['procedure_id'])) {
    $_SESSION['procedure_id'] = $_GET['procedure_id'];
}

// Retrieve patient_id and procedure_id from session (use fallback to avoid errors)
$patient_id = $_SESSION['patient_id'] ?? null;
$procedure_id = $_SESSION['procedure_id'] ?? null;

// Fetch patient name if patient_id exists
$patientFullName = (!empty($patient_id)) ? getPatientFullName($patient_id) : "No Name Available";

// Get the current script name
$current_page = basename($_SERVER['PHP_SELF']);

// Remove session cache completely
unset($_SESSION['cached_data']);
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
                            <a href="add_patientinfo.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="pirLink">
                                <button class="nav-item ">P.I.R</button>
                            </a>

                            <a href="add_medical-history.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="historyLink">
                                <button class="nav-item active">Medical History</button>
                            </a>

                            <a href="add_medicalcondition.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="conditionLink">
                                <button class="nav-item">Medical Condition</button>
                            </a>

                            <a href="add_ptp.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="ptpLink">
                                <button class="nav-item">PTP</button>
                            </a>

                            <a href="add_procedure.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="procedureLink">
                                <button class="nav-item">Procedures</button>
                            </a>

                            <a href="add_xray.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="xrayLink">
                                <button class="nav-item">Xray</button>
                            </a>

                            <a href="add_intra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="intraLink">
                                <button class="nav-item">Intra Oral Photos</button>
                            </a>

                            <a href="add_extra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="extraLink">
                                <button class="nav-item ">Extra Oral Photos</button>
                            </a>

                            <a href="add_notes.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="notesLink">
                                <button class="nav-item">Notes</button>
                            </a>
                            </div>

						</div>


                        <div class="info-container">
            <h2 class="info-title">Medical History</h2>
            <form class="details-form" id="medicalHistoryForm" method="POST">
    <div class="form-group">
        <label for="last-visit">Date of Last Visit:</label>
        <input type="date" id="last-visit" name="last-visit" class="form-input" required 
            value="<?php echo $_SESSION['cached_data']['medical_history']['last-visit'] ?? ''; ?>">
    </div>

    <div class="form-group">
        <label for="physician-name">General Physician's Name:</label>
        <input type="text" id="physician-name" name="physician-name" class="form-input" required
            value="<?php echo $_SESSION['cached_data']['medical_history']['physician-name'] ?? ''; ?>">
    </div>

    <div class="form-group">
        <label>Have you had any serious illness or operation?</label>
        <textarea id="serious-illness" name="serious-illness" class="form-input" rows="3" required><?php echo $_SESSION['cached_data']['medical_history']['serious-illness'] ?? ''; ?></textarea>
    </div>

    <div class="form-group">
        <label>If Yes, describe:</label>
        <textarea id="illness-description" name="illness-description" class="form-input" rows="3" required><?php echo $_SESSION['cached_data']['medical_history']['illness-description'] ?? ''; ?></textarea>
    </div>

    <div class="form-group">
    <label>Have you ever had a blood transfusion?</label>
    <div>
        <label><input type="radio" name="blood-transfusion" value="yes" 
            <?php echo (isset($_SESSION['cached_data']['medical_history']['blood-transfusion']) && $_SESSION['cached_data']['medical_history']['blood-transfusion'] === 'yes') ? 'checked' : ''; ?>>
            Yes</label>
        <label><input type="radio" name="blood-transfusion" value="no" 
            <?php echo (isset($_SESSION['cached_data']['medical_history']['blood-transfusion']) && $_SESSION['cached_data']['medical_history']['blood-transfusion'] === 'no') ? 'checked' : ''; ?>>
            No</label>
    </div>
</div>

    <div class="form-group">
        <label>If Yes, give approximate dates:</label>
        <input type="text" id="transfusion-dates" name="transfusion-dates" class="form-input" required
            value="<?php echo $_SESSION['cached_data']['medical_history']['transfusion-dates'] ?? ''; ?>">
    </div>

    <div class="form-group">
    <label>(For Women only) Are you pregnant?</label>
    <div>
        <label><input type="radio" name="pregnant" value="yes" 
            <?php echo (isset($_SESSION['cached_data']['medical_history']['pregnant']) && $_SESSION['cached_data']['medical_history']['pregnant'] === 'yes') ? 'checked' : ''; ?>>
            Yes</label>
        <label><input type="radio" name="pregnant" value="no" 
            <?php echo (isset($_SESSION['cached_data']['medical_history']['pregnant']) && $_SESSION['cached_data']['medical_history']['pregnant'] === 'no') ? 'checked' : ''; ?>>
            No</label>
    </div>
</div>

    <div class="form-group">
        <label>Are you taking any medication?</label>
        <div>
            <label><input type="radio" name="medication" value="yes" 
                <?php echo (isset($_SESSION['cached_data']['medical_history']['medication']) && $_SESSION['cached_data']['medical_history']['medication'] == 'yes') ? 'checked' : ''; ?>> Yes</label>
            <label><input type="radio" name="medication" value="no" 
                <?php echo (isset($_SESSION['cached_data']['medical_history']['medication']) && $_SESSION['cached_data']['medical_history']['medication'] == 'no') ? 'checked' : ''; ?>> No</label>
        </div>
    </div>

    <div class="form-group">
        <label>If Yes, please specify:</label>
        <textarea id="medication-specify" name="medication-specify" class="form-input" rows="3" required><?php echo $_SESSION['cached_data']['medical_history']['medication-specify'] ?? ''; ?></textarea>
    </div>
</form>


        </div>

        </main>
      
</body>

<script>
document.getElementById("saveButton").addEventListener("click", function() {
    const patientId = '<?php echo $_SESSION['patient_id'] ?? ""; ?>';
    const procedureId = '<?php echo $_SESSION['procedure_id'] ?? ""; ?>'; 

    if (!patientId || !procedureId) {
        console.error("Error: Missing Patient ID or Procedure ID");
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Missing Patient ID or Procedure ID!",
        });
        return;
    }

    const data = {
        patient_id: patientId,
        procedure_id: procedureId,
        medhistory_lastvisit: document.getElementById("last-visit").value,
        medhistory_genphysician: document.getElementById("physician-name").value,
        medhistory_serious: document.getElementById("serious-illness").value,
        medhistory_ifyesserious: document.getElementById("illness-description").value,
        medhistory_bloodtrans: document.querySelector('input[name="blood-transfusion"]:checked')?.value || "",
        medhistory_ifyesdate: document.getElementById("transfusion-dates").value,
        medhistory_pregnant: document.querySelector('input[name="pregnant"]:checked')?.value || "",
        medhistory_takingmed: document.querySelector('input[name="medication"]:checked')?.value || "",
        medhistory_ifyesmed: document.getElementById("medication-specify").value
    };

    console.log("Sending Data:", JSON.stringify(data, null, 2));  

    fetch('../functions/add_medhistory.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(parsedData => {
        console.log("Response from Server:", parsedData);
        if (parsedData.success) {
            Swal.fire({
                icon: "success",
                title: "Success!",
                text: "Medical history saved successfully!",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = `add_medicalcondition.php?patient_id=${patientId}&procedure_id=${procedureId}`;
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Failed to save medical history: " + parsedData.message,
            });
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "An error occurred while saving. Please try again.",
        });
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