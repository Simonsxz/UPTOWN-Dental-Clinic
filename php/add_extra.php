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
    <link rel="stylesheet" href="/css/style.css">
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
	
			<!-- <input type="text" placeholder="Search...">
			<i class='bx bx-search icon' ></i> -->
			<!-- <p class="nav-link"></p>
			<p class="nav-link"></p> -->
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
                                <button class="nav-item active">Extra Oral Photos</button>
                            </a>

                            <a href="add_notes.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&procedure_id=<?php echo urlencode($_SESSION['procedure_id']); ?>" class="nav-item-link" id="notesLink">
                                <button class="nav-item">Notes</button>
                            </a>
                            </div>
							</div>


                      
                   
                            <div class="info-container">
    <h2 class="info-title" style="text-align: center; margin-bottom: 5px; font-family: Arial, sans-serif; color: #333;">Extra Oral Photos</h2>
    
    <!-- Image upload input for Extra Oral Photos -->
    <form class="details-form-extra" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
        <label for="extra-image-upload" style="font-size: 14px; font-weight: bold; color: #555;">Upload Extra Oral Images (Optional):</label>
        <input id="extra-image-upload" name="extra_images" type="file" accept="image/*" multiple style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" onchange="displayExtraImages(event)">

        <!-- Container to display uploaded images -->
        <div id="extra-uploaded-images-container" style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 15px;">
            <!-- Images uploaded via the form will be displayed here dynamically -->
        </div>
    </form>
</div>

<!-- Modal for viewing large images -->
<div id="extra-image-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center; z-index: 1000; flex-direction: column; padding: 20px; box-sizing: border-box;">
    <img id="extra-modal-image" src="" alt="Large View" style="max-width: 90%; max-height: 80%; border: 5px solid white; margin-bottom: 20px; border-radius: 10px;">
    <a id="extra-download-link" href="" download style="background-color: #007BFF; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 14px; margin-bottom: 10px;">Download</a>
    <button onclick="closeExtraModal()" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 14px; cursor: pointer;">Close</button>
    <button onclick="removeExtraImage()" style="background-color: #28a745; color: white; border: none; margin-top:5px; padding: 10px 20px; border-radius: 5px; font-size: 14px; cursor: pointer;">Remove Image</button>
</div>

<script>
    // Initialize an empty array for extra oral photos (no caching)
    let extraOralSelectedFiles = [];

    // Function to display uploaded images for extra oral photos
    function displayExtraImages(event) {
        const extraUploadedImagesContainer = document.getElementById('extra-uploaded-images-container');
        const files = Array.from(event.target.files); // Get newly selected files
        const currentDate = new Date().toLocaleDateString();

        // Add new files to the extraOralSelectedFiles array
        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imageData = e.target.result; // Base64 encoded image

                // Save new image in the extraOralSelectedFiles array
                extraOralSelectedFiles.push({
                    dataUrl: imageData,
                    name: file.name,
                    date: currentDate
                });

                // Update the displayed images
                displayStoredExtraImages();
            };
            reader.readAsDataURL(file); // Read the image file as data URL
        });
    }

    // Function to display all stored images
    function displayStoredExtraImages() {
        const extraUploadedImagesContainer = document.getElementById('extra-uploaded-images-container');
        extraUploadedImagesContainer.innerHTML = ""; // Clear current images

        extraOralSelectedFiles.forEach((image, index) => {
            const imageWrapper = document.createElement('div');
            imageWrapper.style.width = '120px';
            imageWrapper.style.textAlign = 'center';

            const img = document.createElement('img');
            img.src = image.dataUrl;
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.cursor = 'pointer';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '5px';
            img.style.border = '1px solid #ddd';
            img.onclick = function () {
                openExtraModal(image.dataUrl, image.name);
            };

            const title = document.createElement('div');
            title.textContent = image.name;
            title.style.marginTop = '5px';
            title.style.fontSize = '12px';
            title.style.color = '#555';

            const date = document.createElement('div');
            date.textContent = `Uploaded: ${image.date}`;
            date.style.fontSize = '10px';
            date.style.color = '#777';

            imageWrapper.appendChild(img);
            imageWrapper.appendChild(title);
            imageWrapper.appendChild(date);

            extraUploadedImagesContainer.appendChild(imageWrapper);
        });
    }

    // Function to open the modal with a large image for extra oral photos
    function openExtraModal(imageSrc, fileName) {
        const modal = document.getElementById('extra-image-modal');
        const modalImage = document.getElementById('extra-modal-image');
        const downloadLink = document.getElementById('extra-download-link');

        modalImage.src = imageSrc;
        downloadLink.href = imageSrc;
        downloadLink.download = fileName;
        modal.style.display = 'flex';
    }

    // Close the extra oral modal
    function closeExtraModal() {
        const modal = document.getElementById('extra-image-modal');
        modal.style.display = 'none';
    }

    // Remove the selected image from the container
    function removeExtraImage() {
        const modalImage = document.getElementById('extra-modal-image');
        const extraUploadedImagesContainer = document.getElementById('extra-uploaded-images-container');

        // Find the image to remove based on its dataUrl (src)
        const imageContainers = extraUploadedImagesContainer.children;
        for (let i = 0; i < imageContainers.length; i++) {
            const imgElement = imageContainers[i].querySelector('img');
            if (imgElement && imgElement.src === modalImage.src) {
                extraUploadedImagesContainer.removeChild(imageContainers[i]);
                extraOralSelectedFiles.splice(i, 1); // Remove image from the array
                break;
            }
        }

        // Close the modal
        closeExtraModal();
    }

    // Save button logic for extra oral photos
    document.getElementById("saveExtraButton").addEventListener("click", function () {
        const formData = new FormData();
        const patientId = '<?php echo $_SESSION['patient_id'] ?? ""; ?>';
        const prescriptionId = '<?php echo $_SESSION['prescription_id'] ?? ""; ?>';

        formData.append('patient_id', patientId);
        formData.append('prescription_id', prescriptionId);

        extraOralSelectedFiles.forEach((image, index) => {
            // Convert base64 data back to file
            const dataUrl = image.dataUrl;
            const fileName = image.name;
            const fileBlob = dataURLtoBlob(dataUrl); // Convert base64 to Blob
            const file = new File([fileBlob], fileName, { type: "image/jpeg" });
            formData.append('extra_images[]', file); // Append image to the form data
        });

        Swal.fire({
            title: 'Do you want to save the Extra Oral Photos?',
            text: 'Please confirm if you want to proceed with saving the photos.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Save it',
            cancelButtonText: 'No, Edit the Data',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../functions/add_extra.php', {
                    method: 'POST',
                    body: formData,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Extra Oral Photos saved successfully.',
                            }).then(() => {
                                window.location.href = `add_notes.php?patient_id=${patientId}&prescription_id=${prescriptionId}`;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message || 'Failed to save Extra Oral Photos.',
                            });
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while saving the photos.',
                        });
                    });
            }
        });
    });

    // Convert base64 data to Blob for uploading
    function dataURLtoBlob(dataUrl) {
        const [header, base64Data] = dataUrl.split(',');
        const mime = header.match(/:(.*?);/)[1];
        const binaryString = atob(base64Data);
        const byteArray = new Uint8Array(binaryString.length);

        for (let i = 0; i < binaryString.length; i++) {
            byteArray[i] = binaryString.charCodeAt(i);
        }

        return new Blob([byteArray], { type: mime });
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
<script src="/js/patient-xray.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>