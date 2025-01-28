
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

if (isset($_GET['patient_id']) && isset($_GET['patient_prescription'])) {
    $_SESSION['patient_id'] = $_GET['patient_id'];
    $_SESSION['patient_prescription'] = $_GET['patient_prescription'];
}

$patientId = $_SESSION['patient_id'] ?? null;
$patientPrescription = $_SESSION['patient_prescription'] ?? null;

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
                                <a href="add_patientinfo.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item " disabled style="cursor: not-allowed;">P.I.R</button>
                                </a>
                                <a href="add_prescription.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item " disabled style="cursor: not-allowed;">Prescription</button>
                                </a>
                                <a href="add_medical-history.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item " disabled style="cursor: not-allowed;">Medical History</button>
                                </a>
                                <a href="medical-condition.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item " disabled style="cursor: not-allowed;">Medical Condition</button>
                                </a>
                                <a href="ptp.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item " disabled style="cursor: not-allowed;">PTP</button>
                                </a>
                                <a href="procedure.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item " disabled style="cursor: not-allowed;">Procedures</button>
                                </a>
                                <a href="patient-xray.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item " disabled style="cursor: not-allowed;">Xray</button>
                                </a>
                                <a href="patient-intra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item active" disabled style="cursor: not-allowed;">Intra Oral Photos</button>
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
    <h2 class="info-title" style="text-align: center; margin-bottom: 5px; font-family: Arial, sans-serif; color: #333;">Extra Oral Photos</h2>
    
    <!-- Image upload input -->
    <form class="details-form1" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
        <label for="image-upload" style="font-size: 14px; font-weight: bold; color: #555;">Upload Images (Optional):</label>
        <input id="image-upload" type="file" accept="image/*" multiple style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;" onchange="displayImages(event)">

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
    const selectedFiles = []; // Array to store all selected files

    // Function to display uploaded images
    function displayImages(event) {
        const uploadedImagesContainer = document.getElementById('uploaded-images-container');
        const files = Array.from(event.target.files); // Get newly selected files
        const currentDate = new Date().toLocaleDateString();

        // Add new files to the selectedFiles array
        selectedFiles.push(...files);

        console.log("Selected Files:", selectedFiles); // Log all selected files

        // Display files in the container
        uploadedImagesContainer.innerHTML = ""; // Clear container to avoid duplicates
        selectedFiles.forEach((file, index) => {
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imageWrapper = document.createElement('div');
                    imageWrapper.style.width = '120px';
                    imageWrapper.style.textAlign = 'center';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.cursor = 'pointer';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '5px';
                    img.style.border = '1px solid #ddd';
                    img.onclick = function () {
                        openModal(e.target.result, file.name);
                    };

                    const title = document.createElement('div');
                    title.textContent = file.name;
                    title.style.marginTop = '5px';
                    title.style.fontSize = '12px';
                    title.style.color = '#555';

                    const date = document.createElement('div');
                    date.textContent = `Uploaded: ${currentDate}`;
                    date.style.fontSize = '10px';
                    date.style.color = '#777';

                    imageWrapper.appendChild(img);
                    imageWrapper.appendChild(title);
                    imageWrapper.appendChild(date);

                    uploadedImagesContainer.appendChild(imageWrapper);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Function to open modal with a large image
    function openModal(imageSrc, fileName) {
        const modal = document.getElementById('image-modal');
        const modalImage = document.getElementById('modal-image');
        const downloadLink = document.getElementById('download-link');

        modalImage.src = imageSrc;
        downloadLink.href = imageSrc;
        downloadLink.download = fileName;
        modal.style.display = 'flex';
    }

    // Close the modal
    function closeModal() {
        const modal = document.getElementById('image-modal');
        modal.style.display = 'none';
    }

    // Remove the image from the container
    function removeImage() {
        const modalImage = document.getElementById('modal-image');
        const uploadedImagesContainer = document.getElementById('uploaded-images-container');

        // Find the image container to remove
        const imageContainers = uploadedImagesContainer.children;
        for (let i = 0; i < imageContainers.length; i++) {
            const imgElement = imageContainers[i].querySelector('img');
            if (imgElement && imgElement.src === modalImage.src) {
                uploadedImagesContainer.removeChild(imageContainers[i]);
                selectedFiles.splice(i, 1); // Remove the file from the selectedFiles array
                break;
            }
        }

        // Close the modal after removal
        closeModal();
    }

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

    // Save button logic
    document.getElementById("saveButton").addEventListener("click", function () {
        const formData = new FormData();
        const patientId = '<?php echo $_SESSION['patient_id'] ?? ""; ?>';
        const prescriptionId = '<?php echo $_SESSION['prescription_id'] ?? ""; ?>';

        formData.append('patient_id', patientId);
        formData.append('prescription_id', prescriptionId);

        selectedFiles.forEach((file, index) => {
            formData.append('images[]', file); // Append each file to 'images[]'
            console.log(`Appended File ${index + 1}:`, file.name); // Log each appended file
        });

        for (let pair of formData.entries()) {
            console.log(pair[0], pair[1]); // Log the key and value for verification
        }

        Swal.fire({
            title: 'Do you want to save the Intra Oral Photos?',
            text: 'Please confirm if you want to proceed with saving the photos.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Save it',
            cancelButtonText: 'No, Edit the Data',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../functions/add_intra.php', {
                    method: 'POST',
                    body: formData,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Intra Oral Photos saved successfully.',
                            }).then(() => {
                                window.location.href = `add_extra.php?patient_id=${patientId}&prescription_id=${prescriptionId}`;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message || 'Failed to save Intra Oral Photos.',
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