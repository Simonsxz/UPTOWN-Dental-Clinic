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
									<button class="nav-item ">Medical Condition</button>
								</a>
								<a href="ptp.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">PTP</button>
								</a>
								<a href="procedure.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item ">Procedures</button>
								</a>
								<a href="patient-xray.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item ">Xray</button>
								</a>
								<a href="patient-intra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item active">Intra Oral Photos</button>
								</a>
								<a href="patient-extra.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Extra Oral Photos</button>
								</a>
								<a href="notes.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>&prescription_id=<?php echo urlencode($_SESSION['prescription_id']); ?>" class="nav-item-link">
									<button class="nav-item">Notes</button>
								</a>
							</div>
							</div>

								</div>


                                <?php
$patientId = $_SESSION['patient_id'] ?? null;
$prescriptionId = $_SESSION['prescription_id'] ?? null; // Changed from patient_prescription to prescription_id

if ($patientId && $prescriptionId) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'db_uptowndc');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch image paths from tbl_patientintra
    $stmt = $conn->prepare("SELECT image_paths FROM tbl_patientintra WHERE patient_id = ? AND prescription_id = ?"); // Updated from patient_prescription to prescription_id
    $stmt->bind_param("ss", $patientId, $prescriptionId); // Changed patient_prescription to prescription_id
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if data exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePaths = json_decode($row['image_paths'], true); // Decoding JSON array of image paths
    } else {
        echo "<script>alert('No intra-oral images found for this patient.');</script>";
        $imagePaths = [];
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Patient ID or prescription not set.');</script>";
    $imagePaths = [];
}
?>


<div class="info-container">
    <h2 class="info-title" style="margin-bottom: 10px; margin-left:20px; margin-top:-20px;">Patient Intra-Oral Images</h2>
    <form class="details-form1">
        <!-- Uploaded Images Container -->
        <div id="uploaded-images-container" class="images-container">
            <?php
            if (!empty($imagePaths)) {
                foreach ($imagePaths as $imagePath) {
                    echo '<div style="width: 120px; text-align: center; margin-bottom: 10px;">';
                    echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Patient Intra Image" style="width: 100px; height: 100px; cursor: pointer; object-fit: cover;" onclick="openModal(\'' . htmlspecialchars($imagePath) . '\')">';
                    echo '</div>';
                }
            } else {
                echo '<p>No images available for this patient.</p>';
            }
            ?>
        </div>
    </form>
	</div>


<!-- Modal for viewing large images -->
<div id="image-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center; z-index: 1000; flex-direction: column; padding: 20px; box-sizing: border-box;">
    <img id="modal-image" src="" alt="Large View" style="max-width: 90%; max-height: 80%; border: 5px solid white; margin-bottom: 20px; border-radius: 10px;">
    <a id="download-link" href="" download style="background-color: #007BFF; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 14px; margin-bottom: 10px;">Download</a>
    <button onclick="closeModal()" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 14px; cursor: pointer;">Close</button>
</div>
	
        </main>
</body>

<script>
    function triggerImageInput() {
        document.getElementById('imageInput').click();
    }

    function handleImageUpload(event) {
        const uploadedImagesContainer = document.getElementById('uploaded-images-container');
        const files = event.target.files;

        Array.from(files).forEach((file) => {
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Create the wrapper for the image and details
                    const imageWrapper = document.createElement('div');
                    imageWrapper.className = 'image-wrapper';

                    // Create the image element
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;
                    img.onclick = function () {
                        openModal(e.target.result);
                    };

                    // Create the details container
                    const details = document.createElement('div');
                    details.className = 'image-details';

                    // Add the file name
                    const fileName = document.createElement('div');
                    fileName.className = 'file-name';
                    fileName.textContent = file.name;

                    // Add the upload date
                    const uploadDate = document.createElement('div');
                    uploadDate.className = 'upload-date';
                    const date = new Date();
                    uploadDate.textContent = date.toLocaleDateString();

                    // Append details to the wrapper
                    details.appendChild(fileName);
                    details.appendChild(uploadDate);
                    imageWrapper.appendChild(img);
                    imageWrapper.appendChild(details);

                    // Append wrapper to the container
                    uploadedImagesContainer.appendChild(imageWrapper);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    function openModal(imageSrc) {
        const modal = document.getElementById('image-modal');
        const modalImage = document.getElementById('modal-image');
        const downloadLink = document.getElementById('download-link');

        modalImage.src = imageSrc;
        downloadLink.href = imageSrc;
        modal.style.display = 'flex';
    }

    function closeModal() {
        const modal = document.getElementById('image-modal');
        modal.style.display = 'none';
    }
</script>

<style>
    .info-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
        box-sizing: border-box;
    }

    .info-title {
        text-align: left;
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    .add-image-container {
        text-align: left;
        margin-bottom: 20px;
    }

    .add-image-button {
        background-color: #007BFF;
        color: white;
        font-size: 16px;
        font-weight: bold;
        padding: 12px 24px;
        border-radius: 5px;
        cursor: pointer;
        border: none;
        transition: background-color 0.3s ease;
    }

    .add-image-button:hover {
        background-color: #0056b3;
    }

    .images-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: flex-start;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .image-wrapper {
        width: 140px;
        text-align: center;
        overflow: hidden;
        word-wrap: break-word;
    }

    .image-wrapper img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #ccc;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .image-wrapper img:hover {
        transform: scale(1.1);
    }

    .image-details {
        margin-top: 5px;
        font-size: 12px;
        color: #555;
        text-align: center;
    }

    .file-name {
        font-weight: bold;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        width: 100%;
    }

    .upload-date {
        font-style: italic;
    }

    #image-modal img {
        border: 2px solid white;
        border-radius: 10px;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="/js/intra.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>