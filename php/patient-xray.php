
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
			<li><a href="xray.html"><i class='bx bxs-barcode icon' ></i> X-ray </a></li>
			<li><a href=""><i class='bx bxs-photo-album icon' ></i> Oral Photos </a></li>
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
					<i class="fas fa-search nav-icon-bar"></i> <!-- Search icon -->
					<input type="text" class="nav-search-input" placeholder="Search..">
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
      
                <!-- <img src="data:image/jpeg;base64,<?php echo $profile_image; ?>" alt="Cannot load image data"> -->
				<img src="\assets\avatar.png" alt="Cannot load image data">
				<ul class="profile-link">
					<li><a href="profile.php"><i class='bx bxs-user-circle icon'></i> Profile</a></li>
					<li><a href="financial_reports.php"><i class='bx bxs-report'></i>Reports</a></li>
					<li><a href="processes/logout.php"><i class='bx bxs-exit'></i> Logout</a></li>
				</ul>
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
									<a href="patient-info.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&patient_prescription=<?php echo urlencode($_SESSION['patient_prescription']); ?>" class="nav-item-link">
										<button class="nav-item">P.I.R</button>
									</a>
									<a href="medical-history.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&patient_prescription=<?php echo urlencode($_SESSION['patient_prescription']); ?>" class="nav-item-link">
										<button class="nav-item ">Medical History</button>
									</a>
									<a href="medical-condition.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&patient_prescription=<?php echo urlencode($_SESSION['patient_prescription']); ?>" class="nav-item-link">
										<button class="nav-item ">Medical Condition</button>
									</a>
									<a href="ptp.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&patient_prescription=<?php echo urlencode($_SESSION['patient_prescription']); ?>" class="nav-item-link">
										<button class="nav-item ">PTP</button>
									</a>
									<a href="procedure.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&patient_prescription=<?php echo urlencode($_SESSION['patient_prescription']); ?>" class="nav-item-link">
										<button class="nav-item ">Procedures</button>
									</a>
									<a href="patient-xray.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&patient_prescription=<?php echo urlencode($_SESSION['patient_prescription']); ?>" class="nav-item-link">
										<button class="nav-item active">Xray</button>
									</a>
									<a href="patient-intra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&patient_prescription=<?php echo urlencode($_SESSION['patient_prescription']); ?>" class="nav-item-link">
										<button class="nav-item">Intra Oral Photos</button>
									</a>
									<a href="patient-extra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&patient_prescription=<?php echo urlencode($_SESSION['patient_prescription']); ?>" class="nav-item-link">
										<button class="nav-item">Extra Oral Photos</button>
									</a>
									<a href="notes.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&patient_prescription=<?php echo urlencode($_SESSION['patient_prescription']); ?>" class="nav-item-link">
										<button class="nav-item">Notes</button>
									</a>
								</div>
							</div>


							<div class="info-container">
    <h2 class="info-title">Patient Xray</h2>
    <form class="details-form1">
        <div class="gallery-container">
            <!-- Add Image Container -->
            <div class="images-display" id="imagesDisplay">
                <div class="add-image-container">
                    <!-- Add Image Button -->
                    <button type="button" class="add-image-button" onclick="triggerImageInput()">
                        <span class="plus-sign">+</span> Add Image
                    </button>
                    <!-- Hidden file input to trigger on button click -->
                    <input type="file" id="imageInput" accept="image/*" style="display: none;" onchange="handleImageUpload(event)" />
                </div>
                <!-- Container for displaying uploaded images (Below the button) -->
                <div id="uploaded-images-container" class="images-container">
                    <!-- Uploaded images will appear here -->
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal for viewing large images -->
<div id="image-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center; z-index: 1000; flex-direction: column; padding: 20px; box-sizing: border-box;">
    <img id="modal-image" src="" alt="Large View" style="max-width: 90%; max-height: 80%; border: 5px solid white; margin-bottom: 20px; border-radius: 10px;">
    <a id="download-link" href="" download style="background-color: #007BFF; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 14px; margin-bottom: 10px;">Download</a>
    <button onclick="closeModal()" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 14px; cursor: pointer;">Close</button>
</div>

<script>
    // Trigger the hidden file input when the button is clicked
    function triggerImageInput() {
        document.getElementById('imageInput').click();
    }

    // Handle the image upload and display it
    function handleImageUpload(event) {
        const uploadedImagesContainer = document.getElementById('uploaded-images-container');
        const files = event.target.files;

        Array.from(files).forEach((file) => {
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
                    img.style.border = '1px solid #ccc';
                    img.onclick = function () {
                        openModal(e.target.result);
                    };

                    imageWrapper.appendChild(img);
                    uploadedImagesContainer.appendChild(imageWrapper);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Open modal to view the image in larger size
    function openModal(imageSrc) {
        const modal = document.getElementById('image-modal');
        const modalImage = document.getElementById('modal-image');
        const downloadLink = document.getElementById('download-link');

        modalImage.src = imageSrc;
        downloadLink.href = imageSrc;
        modal.style.display = 'flex';
    }

    // Close the modal
    function closeModal() {
        const modal = document.getElementById('image-modal');
        modal.style.display = 'none';
    }
</script>

<style>
    /* Fixed position button style */
    .add-image-container {
        position: sticky;
        top: 20px; /* Stick it to the top of the container */
        z-index: 10;
        text-align: center;
        margin-bottom: 20px; /* Add space below the button */
    }

    .add-image-button {
        background-color: #007BFF; /* Blue color */
        color: white;
        font-size: 16px;
        font-weight: bold;
        padding: 12px 24px;
        border-radius: 5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
        transition: background-color 0.3s ease;
    }

    .add-image-button:hover {
        background-color: #0056b3; /* Darker blue when hovered */
    }

    .add-image-button:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5); /* Light blue focus ring */
    }

    .plus-sign {
        font-size: 20px;
    }

    .images-display {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .images-container {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        padding: 10px;
        box-sizing: border-box;
        flex-grow: 1;
    }

    #uploaded-images-container div {
        text-align: center;
        width: 120px;
    }

    #uploaded-images-container img {
        width: 100px;
        height: 100px;
        cursor: pointer;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #ccc;
        transition: transform 0.2s ease;
    }

    #uploaded-images-container img:hover {
        transform: scale(1.1); /* Slightly zoom on hover */
    }
</style>

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