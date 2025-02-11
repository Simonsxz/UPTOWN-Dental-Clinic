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
                                    <a href="patient.php" id="cancelLink">
                                        <button type="button" class="cancel">Cancel</button>
                                    </a>
                                    <button type="button" class="save" id="saveButton">Next</button>
                                </div>
							</div>												
                            <div class="table-container">

							<div class="module-container">
                            <div class="horizontal-nav-bar">
                            <a href="add_patientinfo.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="pirLink" style="pointer-events: none; color: #ccc;">
                                <button class="nav-item" disabled>P.I.R</button>
                            </a>

                            <a href="add_medical-history.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="historyLink" style="pointer-events: none; color: #ccc;">
                                <button class="nav-item " disabled>Medical History</button>
                            </a>

                            <a href="add_medicalcondition.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="conditionLink" style="pointer-events: none; color: #ccc;">
                                <button class="nav-item active" disabled>Medical Condition</button>
                            </a>

                            <a href="add_ptp.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="ptpLink" style="pointer-events: none; color: #ccc;">
                                <button class="nav-item" disabled>PTP</button>
                            </a>

                            <a href="add_procedure.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="procedureLink" style="pointer-events: none; color: #ccc;">
                                <button class="nav-item" disabled>Procedures</button>
                            </a>

                            <a href="add_xray.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="xrayLink" style="pointer-events: none; color: #ccc;">
                                <button class="nav-item" disabled>Xray</button>
                            </a>

                            <a href="add_intra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="intraLink" style="pointer-events: none; color: #ccc;">
                                <button class="nav-item " disabled>Intra Oral Photos</button>
                            </a>

                            <a href="add_extra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="extraLink" style="pointer-events: none; color: #ccc;">
                                <button class="nav-item " disabled>Extra Oral Photos</button>
                            </a>

                            <a href="add_notes.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="notesLink" style="pointer-events: none; color: #ccc;">
                                <button class="nav-item" disabled>Notes</button>
                            </a>
                            </div>
						</div>

						<div class="info-container">
    <h2 class="info-title">Medical Condition</h2>
    <form class="details-form1">
        <div class="form-group">
            <label>Select any medical conditions you have:</label>
            <div class="checkbox-group medical-condition-group">
            <label><input type="checkbox" name="medical_condition_aids" value="1"> Aids</label>
            <label><input type="checkbox" name="medical_condition_arthritis" value="1"> Arthritis</label>
            <label><input type="checkbox" name="medical_condition_rheumatism" value="1"> Rheumatism</label>
            <label><input type="checkbox" name="medical_condition_artificial_heart" value="1"> Artificial Heart</label>
            <label><input type="checkbox" name="medical_condition_valves" value="1"> Valves</label>
            <label><input type="checkbox" name="medical_condition_asthma" value="1"> Asthma</label>
            <label><input type="checkbox" name="medical_condition_fainting" value="1"> Fainting</label>
            <label><input type="checkbox" name="medical_condition_blood_disease" value="1"> Blood Disease</label>
            <label><input type="checkbox" name="medical_condition_cancer" value="1"> Cancer</label>
            <label><input type="checkbox" name="medical_condition_chemical_dependency" value="1"> Chemical Dependency</label>
            <label><input type="checkbox" name="medical_condition_circulatory_problems" value="1"> Circulatory Problems</label>
            <label><input type="checkbox" name="medical_condition_cortisone_treatment" value="1"> Cortisone Treatment</label>
            <label><input type="checkbox" name="medical_condition_persistent_cough" value="1"> Cough (Persistent)</label>
            <label><input type="checkbox" name="medical_condition_cough_blood" value="1"> Cough (Blood)</label>
            <label><input type="checkbox" name="medical_condition_diabetes" value="1"> Diabetes</label>
            <label><input type="checkbox" name="medical_condition_epilepsy" value="1"> Epilepsy</label>
            <label><input type="checkbox" name="medical_condition_mitral_valve_prolapse" value="1"> Mitral Valve Prolapse</label>
            <label><input type="checkbox" name="medical_condition_headaches" value="1"> Headaches</label>
            <label><input type="checkbox" name="medical_condition_heart_murmur" value="1"> Heart Murmur</label>
            <label><input type="checkbox" name="medical_condition_heart_problems" value="1"> Heart Problems</label>
            <label><input type="checkbox" name="medical_condition_hemophilia" value="1"> Hemophilia</label>
            <label><input type="checkbox" name="medical_condition_high_blood_pressure" value="1"> High Blood Pressure</label>
            <label><input type="checkbox" name="medical_condition_hepatitis" value="1"> Hepatitis</label>
            <label><input type="checkbox" name="medical_condition_hiv_positive" value="1"> HIV Positive</label>
            <label><input type="checkbox" name="medical_condition_jaw_pain" value="1"> Jaw Pain</label>
            <label><input type="checkbox" name="medical_condition_kidney_disease" value="1"> Kidney Disease</label>
            <label><input type="checkbox" name="medical_condition_liver_disease" value="1"> Liver Disease</label>
            <label><input type="checkbox" name="medical_condition_back_problem" value="1"> Back Problem</label>
            <label><input type="checkbox" name="medical_condition_pacemaker" value="1"> Pacemaker</label>
            <label><input type="checkbox" name="medical_condition_psychiatric_care" value="1"> Psychiatric Care</label>
            <label><input type="checkbox" name="medical_condition_radiation_treatment" value="1"> Radiation Treatment</label>
            <label><input type="checkbox" name="medical_condition_respiratory_disease" value="1"> Respiratory Disease</label>
            <label><input type="checkbox" name="medical_condition_rheumatic_fever" value="1"> Rheumatic Fever</label>
            <label><input type="checkbox" name="medical_condition_anemia" value="1"> Anemia</label>
            <label><input type="checkbox" name="medical_condition_skin_rash" value="1"> Skin Rash</label>
            <label><input type="checkbox" name="medical_condition_stroke" value="1"> Stroke</label>
            <label><input type="checkbox" name="medical_condition_swelling_feet_ankle" value="1"> Swelling of Feet/Ankle</label>
            <label><input type="checkbox" name="medical_condition_thyroid_problems" value="1"> Thyroid Problems</label>
            <label><input type="checkbox" name="medical_condition_nervous_problem" value="1"> Nervous Problem</label>
            <label><input type="checkbox" name="medical_condition_tobacco_habit" value="1"> Tobacco Habit</label>
            <label><input type="checkbox" name="medical_condition_tonsilitis" value="1"> Tonsilitis</label>
            <label><input type="checkbox" name="medical_condition_ulcer" value="1"> Ulcer</label>
            <label><input type="checkbox" name="medical_condition_chemotherapy" value="1"> Chemotherapy</label>
            <label><input type="checkbox" name="medical_condition_scarlet_fever" value="1"> Scarlet Fever</label>

            </div>
        </div>
    </form>
</div>

        </main>
      
</body>

<script>
document.getElementById("saveButton").addEventListener("click", function() {
    const medicalConditions = {};

    document.querySelectorAll('input[name^="medical_condition"]').forEach(function(checkbox) {
        medicalConditions[checkbox.name] = checkbox.checked ? 1 : 0;
    });

    const patientId = '<?php echo $_SESSION['patient_id'] ?? ""; ?>';
    const procedureId = '<?php echo $_SESSION['procedure_id'] ?? ""; ?>';

    console.log('Medical Conditions:', medicalConditions);
    console.log('Patient ID:', patientId);
    console.log('Procedure ID:', procedureId);

    const data = {
        patient_id: patientId,
        procedure_id: procedureId,
        medical_conditions: medicalConditions,
    };

    console.log('Sending Data:', data);

    fetch('../functions/add_medcondition.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.text())
    .then(rawData => {
        try {
            const parsedData = JSON.parse(rawData);
            if (parsedData.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved Successfully!',
                    text: 'Medical Conditions have been saved.',
                }).then(() => {
                    window.location.href = `add_ptp.php?patient_id=${patientId}&procedure_id=${procedureId}`;
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: parsedData.message || 'Failed to save Medical Conditions.',
                });
            }
        } catch (e) {
            console.error('Error parsing response as JSON:', rawData);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Unexpected server response. Please check the console for more details.',
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred while saving Medical Conditions.',
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