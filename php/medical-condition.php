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
								<a href="patient.php" >
									<button class="cancel">Go Back</button>
								</a>

								</div>
							</div>												
                            <div class="table-container">

							<div class="module-container">
							<div class="horizontal-nav-bar">
								<a href="patient-info.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item ">P.I.R</button>
								</a>
								<a href="medical-history.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Medical History</button>
								</a>
								<a href="medical-condition.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item active">Medical Condition</button>
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



						<?php
$patientId = $_SESSION['patient_id'] ?? null;
$prescriptionId = $_SESSION['prescription_id'] ?? null;

if ($patientId && $prescriptionId) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'db_uptowndc');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from tbl_medicalhistory
    $stmt = $conn->prepare("SELECT 
        aids, arthritis, rheumatism, artificial_heart, valves, asthma, fainting, 
        blood_disease, cancer, chemical_dependency, circulatory_problems, cortisone_treatment, 
        persistent_cough, cough_blood, diabetes, epilepsy, mitral_valve_prolapse, headaches, 
        heart_murmur, heart_problems, hemophilia, high_blood_pressure, hepatitis, hiv_positive, 
        jaw_pain, kidney_disease, liver_disease, back_problem, pacemaker, psychiatric_care, 
        radiation_treatment, respiratory_disease, rheumatic_fever, anemia, skin_rash, stroke, 
        swelling_feet_ankle, thyroid_problems, nervous_problem, tobacco_habit, tonsilitis, ulcer, 
        chemotherapy, scarlet_fever 
    FROM tbl_medicalhistory 
    WHERE patient_id = ? AND prescription_id = ?");
    $stmt->bind_param("ss", $patientId, $prescriptionId);

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
    <h2 class="info-title">Medical Condition</h2>
    <form class="details-form1">
        <div class="form-group">
            <label>Select any medical conditions you have:</label>
            <div class="checkbox-group medical-condition-group">
                <label><input type="checkbox" name="medical-condition[aids]" value="aids" <?php echo isset($row['aids']) && $row['aids'] ? 'checked' : ''; ?> disabled> Aids</label>
                <label><input type="checkbox" name="medical-condition[arthritis]" value="arthritis" <?php echo isset($row['arthritis']) && $row['arthritis'] ? 'checked' : ''; ?> disabled> Arthritis</label>
                <label><input type="checkbox" name="medical-condition[rheumatism]" value="rheumatism" <?php echo isset($row['rheumatism']) && $row['rheumatism'] ? 'checked' : ''; ?> disabled> Rheumatism</label>
                <label><input type="checkbox" name="medical-condition[artificial-heart]" value="artificial-heart" <?php echo isset($row['artificial_heart']) && $row['artificial_heart'] ? 'checked' : ''; ?> disabled> Artificial Heart</label>
                <label><input type="checkbox" name="medical-condition[valves]" value="valves" <?php echo isset($row['valves']) && $row['valves'] ? 'checked' : ''; ?> disabled> Valves</label>
                <label><input type="checkbox" name="medical-condition[asthma]" value="asthma" <?php echo isset($row['asthma']) && $row['asthma'] ? 'checked' : ''; ?> disabled> Asthma</label>
                <label><input type="checkbox" name="medical-condition[fainting]" value="fainting" <?php echo isset($row['fainting']) && $row['fainting'] ? 'checked' : ''; ?> disabled> Fainting</label>
                <label><input type="checkbox" name="medical-condition[blood-disease]" value="blood-disease" <?php echo isset($row['blood_disease']) && $row['blood_disease'] ? 'checked' : ''; ?> disabled> Blood Disease</label>
                <label><input type="checkbox" name="medical-condition[cancer]" value="cancer" <?php echo isset($row['cancer']) && $row['cancer'] ? 'checked' : ''; ?> disabled> Cancer</label>
                <label><input type="checkbox" name="medical-condition[chemical-dependency]" value="chemical-dependency" <?php echo isset($row['chemical_dependency']) && $row['chemical_dependency'] ? 'checked' : ''; ?> disabled> Chemical Dependency</label>
                <label><input type="checkbox" name="medical-condition[circulatory-problems]" value="circulatory-problems" <?php echo isset($row['circulatory_problems']) && $row['circulatory_problems'] ? 'checked' : ''; ?> disabled> Circulatory Problems</label>
                <label><input type="checkbox" name="medical-condition[cortisone-treatment]" value="cortisone-treatment" <?php echo isset($row['cortisone_treatment']) && $row['cortisone_treatment'] ? 'checked' : ''; ?> disabled> Cortisone Treatment</label>
                <label><input type="checkbox" name="medical-condition[persistent-cough]" value="persistent-cough" <?php echo isset($row['persistent_cough']) && $row['persistent_cough'] ? 'checked' : ''; ?> disabled> Cough (Persistent)</label>
                <label><input type="checkbox" name="medical-condition[cough-blood]" value="cough-blood" <?php echo isset($row['cough_blood']) && $row['cough_blood'] ? 'checked' : ''; ?> disabled> Cough (Blood)</label>
                <label><input type="checkbox" name="medical-condition[diabetes]" value="diabetes" <?php echo isset($row['diabetes']) && $row['diabetes'] ? 'checked' : ''; ?> disabled> Diabetes</label>
                <label><input type="checkbox" name="medical-condition[epilepsy]" value="epilepsy" <?php echo isset($row['epilepsy']) && $row['epilepsy'] ? 'checked' : ''; ?> disabled> Epilepsy</label>
                <label><input type="checkbox" name="medical-condition[mitral-valve-prolapse]" value="mitral-valve-prolapse" <?php echo isset($row['mitral_valve_prolapse']) && $row['mitral_valve_prolapse'] ? 'checked' : ''; ?> disabled> Mitral Valve Prolapse</label>
                <label><input type="checkbox" name="medical-condition[headaches]" value="headaches" <?php echo isset($row['headaches']) && $row['headaches'] ? 'checked' : ''; ?> disabled> Headaches</label>
                <label><input type="checkbox" name="medical-condition[heart-murmur]" value="heart-murmur" <?php echo isset($row['heart_murmur']) && $row['heart_murmur'] ? 'checked' : ''; ?> disabled> Heart Murmur</label>
                <label><input type="checkbox" name="medical-condition[heart-problems]" value="heart-problems" <?php echo isset($row['heart_problems']) && $row['heart_problems'] ? 'checked' : ''; ?> disabled> Heart Problems</label>
                <label><input type="checkbox" name="medical-condition[hemophilia]" value="hemophilia" <?php echo isset($row['hemophilia']) && $row['hemophilia'] ? 'checked' : ''; ?> disabled> Hemophilia</label>
                <label><input type="checkbox" name="medical-condition[high-blood-pressure]" value="high-blood-pressure" <?php echo isset($row['high_blood_pressure']) && $row['high_blood_pressure'] ? 'checked' : ''; ?> disabled> High Blood Pressure</label>
                <label><input type="checkbox" name="medical-condition[hepatitis]" value="hepatitis" <?php echo isset($row['hepatitis']) && $row['hepatitis'] ? 'checked' : ''; ?> disabled> Hepatitis</label>
                <label><input type="checkbox" name="medical-condition[hiv-positive]" value="hiv-positive" <?php echo isset($row['hiv_positive']) && $row['hiv_positive'] ? 'checked' : ''; ?> disabled> HIV Positive</label>
                <label><input type="checkbox" name="medical-condition[jaw-pain]" value="jaw-pain" <?php echo isset($row['jaw_pain']) && $row['jaw_pain'] ? 'checked' : ''; ?> disabled> Jaw Pain</label>
                <label><input type="checkbox" name="medical-condition[kidney-disease]" value="kidney-disease" <?php echo isset($row['kidney_disease']) && $row['kidney_disease'] ? 'checked' : ''; ?> disabled> Kidney Disease</label>
                <label><input type="checkbox" name="medical-condition[liver-disease]" value="liver-disease" <?php echo isset($row['liver_disease']) && $row['liver_disease'] ? 'checked' : ''; ?> disabled> Liver Disease</label>
                <label><input type="checkbox" name="medical-condition[back-problem]" value="back-problem" <?php echo isset($row['back_problem']) && $row['back_problem'] ? 'checked' : ''; ?> disabled> Back Problem</label>
                <label><input type="checkbox" name="medical-condition[pacemaker]" value="pacemaker" <?php echo isset($row['pacemaker']) && $row['pacemaker'] ? 'checked' : ''; ?> disabled> Pacemaker</label>
                <label><input type="checkbox" name="medical-condition[psychiatric-care]" value="psychiatric-care" <?php echo isset($row['psychiatric_care']) && $row['psychiatric_care'] ? 'checked' : ''; ?> disabled> Psychiatric Care</label>
                <label><input type="checkbox" name="medical-condition[radiation-treatment]" value="radiation-treatment" <?php echo isset($row['radiation_treatment']) && $row['radiation_treatment'] ? 'checked' : ''; ?> disabled> Radiation Treatment</label>
                <label><input type="checkbox" name="medical-condition[respiratory-disease]" value="respiratory-disease" <?php echo isset($row['respiratory_disease']) && $row['respiratory_disease'] ? 'checked' : ''; ?> disabled> Respiratory Disease</label>
                <label><input type="checkbox" name="medical-condition[rheumatic-fever]" value="rheumatic-fever" <?php echo isset($row['rheumatic_fever']) && $row['rheumatic_fever'] ? 'checked' : ''; ?> disabled> Rheumatic Fever</label>
                <label><input type="checkbox" name="medical-condition[anemia]" value="anemia" <?php echo isset($row['anemia']) && $row['anemia'] ? 'checked' : ''; ?> disabled> Anemia</label>
                <label><input type="checkbox" name="medical-condition[skin-rash]" value="skin-rash" <?php echo isset($row['skin_rash']) && $row['skin_rash'] ? 'checked' : ''; ?> disabled> Skin Rash</label>
                <label><input type="checkbox" name="medical-condition[stroke]" value="stroke" <?php echo isset($row['stroke']) && $row['stroke'] ? 'checked' : ''; ?> disabled> Stroke</label>
                <label><input type="checkbox" name="medical-condition[swelling-feet-ankle]" value="swelling-feet-ankle" <?php echo isset($row['swelling_feet_ankle']) && $row['swelling_feet_ankle'] ? 'checked' : ''; ?> disabled> Swelling of Feet/Ankle</label>
                <label><input type="checkbox" name="medical-condition[thyroid-problems]" value="thyroid-problems" <?php echo isset($row['thyroid_problems']) && $row['thyroid_problems'] ? 'checked' : ''; ?> disabled> Thyroid Problems</label>
                <label><input type="checkbox" name="medical-condition[nervous-problem]" value="nervous-problem" <?php echo isset($row['nervous_problem']) && $row['nervous_problem'] ? 'checked' : ''; ?> disabled> Nervous Problem</label>
                <label><input type="checkbox" name="medical-condition[tobacco-habit]" value="tobacco-habit" <?php echo isset($row['tobacco_habit']) && $row['tobacco_habit'] ? 'checked' : ''; ?> disabled> Tobacco Habit</label>
                <label><input type="checkbox" name="medical-condition[tonsilitis]" value="tonsilitis" <?php echo isset($row['tonsilitis']) && $row['tonsilitis'] ? 'checked' : ''; ?> disabled> Tonsilitis</label>
                <label><input type="checkbox" name="medical-condition[ulcer]" value="ulcer" <?php echo isset($row['ulcer']) && $row['ulcer'] ? 'checked' : ''; ?> disabled> Ulcer</label>
                <label><input type="checkbox" name="medical-condition[chemotherapy]" value="chemotherapy" <?php echo isset($row['chemotherapy']) && $row['chemotherapy'] ? 'checked' : ''; ?> disabled> Chemotherapy</label>
                <label><input type="checkbox" name="medical-condition[scarlet-fever]" value="scarlet-fever" <?php echo isset($row['scarlet_fever']) && $row['scarlet_fever'] ? 'checked' : ''; ?> disabled> Scarlet Fever</label>
            </div>
        </div>
    </form>
</div>


            
			
        </main>
      
</body>
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