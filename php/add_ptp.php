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
                                    <a href="patient.php" id="cancelLink">
                                        <button type="button" class="cancel">Cancel</button>
                                    </a>
                                    <button type="button" class="save" id="saveButton">Next</button>
                                </div>
							</div>												
                            <div class="table-container">

							<div class="module-container">
                            <div class="horizontal-nav-bar">
                            <a href="add_patientinfo.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="pirLink">
                                <button class="nav-item ">P.I.R</button>
                            </a>

                            <a href="add_medical-history.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="historyLink">
                                <button class="nav-item ">Medical History</button>
                            </a>

                            <a href="add_medicalcondition.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="conditionLink">
                                <button class="nav-item">Medical Condition</button>
                            </a>

                            <a href="add_ptp.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="ptpLink">
                                <button class="nav-item active">PTP</button>
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
    <h2 class="info-title" style="text-align: center; margin-bottom: 5px; font-family: Arial, sans-serif; color: #333;">Proposed Treatment Plans</h2>
    
    <!-- Image upload input -->
    <form class="details-form1" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
        <label for="image-upload" style="font-size: 14px; font-weight: bold; color: #555;">Upload Images (Optional):</label>
        <input id="image-upload" type="file" accept="image/*" multiple style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" onchange="displayImages(event)">
        
        <!-- Editable text area for treatment plans -->
        <textarea id="treatment-plans" name="treatment-plans" class="form-textarea" placeholder="Describe the proposed treatment plans here..." rows="5" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; width: auto; margin-left: 0;" required></textarea>

        <!-- Container to display uploaded images -->
        <div id="uploaded-images-container" style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 15px;">
            <!-- Images uploaded via the form will be displayed here dynamically -->
        </div>
    </form>
</div>

<!-- Modal for viewing large images -->
<div id="image-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center; z-index: 1000; flex-direction: column; padding: 20px; box-sizing: border-box;">
    <img id="modal-image" src="" alt="Large View" style="max-width: 90%; max-height: 80%; border: 5px solid white; margin-bottom: 20px; border-radius: 10px;">
    <a id="download-link" href="" download style="background-color: #007BFF; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 14px; margin-bottom: 10px;">Download</a>
    <button onclick="closeModal()" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 14px; cursor: pointer;">Close</button>
    <button onclick="removeImage()" style="background-color: #28a745; color: white; border: none; margin-top:5px; padding: 10px 20px; border-radius: 5px; font-size: 14px; cursor: pointer;">Remove Image</button>
</div>



<script>
document.getElementById("saveButton").addEventListener("click", function() {
    const medicalConditions = {};

    document.querySelectorAll('input[name^="medical_condition"]').forEach(function(checkbox) {
        medicalConditions[checkbox.name] = checkbox.checked ? 1 : 0;
    });

    const patientId = '<?php echo $_SESSION['patient_id'] ?? ""; ?>';
    const procedureId = '<?php echo $_SESSION['procedure_id'] ?? ""; ?>';
    const treatmentPlans = document.getElementById("treatment-plans").value;

    const imageInput = document.getElementById("image-upload");
    const formData = new FormData();

    formData.append("patient_id", patientId);
    formData.append("procedure_id", procedureId);
    formData.append("treatment_plans", treatmentPlans);

    // Append selected images
    for (let i = 0; i < imageInput.files.length; i++) {
        formData.append("images[]", imageInput.files[i]);
    }

    console.log("Sending Data:", formData);

    fetch('../functions/add_ptp.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(rawData => {
        try {
            const parsedData = JSON.parse(rawData);
            if (parsedData.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved Successfully!',
                    text: 'Treatment Plans have been saved.',
                }).then(() => {
                    window.location.href = `add_procedure.php?patient_id=${patientId}&procedure_id=${procedureId}`;
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: parsedData.message || 'Failed to save Treatment Plans.',
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
            text: 'An error occurred while saving Treatment Plans.',
        });
    });
});


function displayImages(event) {
    const uploadedImagesContainer = document.getElementById('uploaded-images-container');
    const files = Array.from(event.target.files);

    files.forEach((file) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            displayImage(e.target.result, file.name);
        };
        reader.readAsDataURL(file);
    });
}

function displayImage(imageSrc, fileName) {
    const uploadedImagesContainer = document.getElementById('uploaded-images-container');
    const imageWrapper = document.createElement('div');
    imageWrapper.style.width = '120px';
    imageWrapper.style.textAlign = 'center';

    const img = document.createElement('img');
    img.src = imageSrc;
    img.style.width = '100px';
    img.style.height = '100px';
    img.style.cursor = 'pointer';
    img.style.objectFit = 'cover';
    img.style.borderRadius = '5px';
    img.style.border = '1px solid #ddd';
    img.onclick = function () {
        openModal(imageSrc, fileName);
    };

    const title = document.createElement('div');
    title.textContent = fileName;
    title.style.marginTop = '5px';
    title.style.fontSize = '12px';
    title.style.color = '#555';

    imageWrapper.appendChild(img);
    imageWrapper.appendChild(title);
    uploadedImagesContainer.appendChild(imageWrapper);
}

function openModal(imageSrc, fileName) {
    const modal = document.getElementById('image-modal');
    const modalImage = document.getElementById('modal-image');
    const downloadLink = document.getElementById('download-link');

    modalImage.src = imageSrc;
    downloadLink.href = imageSrc;
    downloadLink.download = fileName;
    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('image-modal').style.display = 'none';
}
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