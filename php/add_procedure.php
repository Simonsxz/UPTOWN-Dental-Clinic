
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
                                <button type="button" class="save" onclick="savePrescription()">Next</button>
								</div>
							</div>	
							</div>												
                            <div class="table-container">

							<div class="module-container">
                            <div class="horizontal-nav-bar">
                                <a href="add_patientinfo.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item " disabled style="cursor: not-allowed;">P.I.R</button>
                                </a>
                                <a href="add_medical-history.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item" disabled style="cursor: not-allowed;">Medical History</button>
                                </a>
                                <a href="medical-condition.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item" disabled style="cursor: not-allowed;">Medical Condition</button>
                                </a>
                                <a href="ptp.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item" disabled style="cursor: not-allowed;">PTP</button>
                                </a>
                                <a href="procedure.php?patient_id=<?php echo urlencode($_SESSION['patient_id']); ?>" class="nav-item-link" onclick="return false;">
                                    <button class="nav-item active" disabled style="cursor: not-allowed;">Procedures</button>
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

              <div class="info-container" style="padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <h2 class="info-title" style="font-size: 20px; font-weight: 600; margin-bottom: 15px; color: #333;">Patient Procedure</h2>
    <form class="details-form1" id="procedureForm" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <!-- Procedure Title Input -->
        <input 
            type="text" 
            id="procedure-title" 
            name="procedure-title" 
            class="form-input" 
            placeholder="Enter procedure title..." 
            style="flex: 2; min-width: 200px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; color: #333;" 
            required
        />
        
        <!-- Price Input -->
        <input 
            type="number" 
            id="procedure-price" 
            name="procedure-price" 
            class="form-input" 
            placeholder="₱ Price..." 
            style="flex: 1; min-width: 100px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; color: #333;" 
            required
        />
        
        <!-- Add Button -->
        <button type="button" id="addProcedure" style="padding: 10px 15px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Add</button>
    </form>
    
    <!-- List of Added Procedures -->
    <h3 style="margin-top: 20px; font-size: 18px; font-weight: 600; color: #333;">Added Procedures</h3>
    <div id="procedureListContainer" style="display: flex; gap: 10px; overflow-x: auto; white-space: nowrap; padding: 10px; background: #fff; border-radius: 5px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); max-width: 100%;"></div>
    
    <!-- Patient Notes -->
    <label for="treatment-plans">Procedure Notes:</label>
    <textarea 
        id="treatment-plans" 
        name="treatment-plans" 
        class="form-textarea" 
        placeholder="Enter notes for this patient..." 
        rows="6" 
        style="width: 100%; padding: 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; resize: vertical; background-color: #fff; color: #333; text-align: left;" 
        required>
    </textarea>
</div>

        </main>
      
</body>
<script>
   document.getElementById('addProcedure').addEventListener('click', function() {
        const procedureTitle = document.getElementById('procedure-title').value.trim();
        const procedurePrice = document.getElementById('procedure-price').value.trim();
        const procedureListContainer = document.getElementById('procedureListContainer');
        
        if (procedureTitle !== "" && procedurePrice !== "") {
            const listItem = document.createElement('div');
            listItem.style.display = "flex";
            listItem.style.alignItems = "center";
            listItem.style.justifyContent = "space-between";
            listItem.style.padding = "10px";
            listItem.style.marginRight = "10px";
            listItem.style.background = "#f8f9fa";
            listItem.style.borderRadius = "5px";
            listItem.style.border = "1px solid #ddd";
            listItem.style.whiteSpace = "nowrap";
            listItem.style.flex = "0 0 auto";
            
            listItem.innerHTML = `<span style="margin-right: 10px; font-weight: bold;">${procedureTitle}</span>
                                  <span style="margin-right: 10px;">₱${procedurePrice}</span>
                                  <button class="delete-btn" style="padding: 5px 10px; background-color: #dc3545; color: #fff; border: none; border-radius: 5px; cursor: pointer;">✖</button>`;
            
            procedureListContainer.appendChild(listItem);
            
            listItem.querySelector('.delete-btn').addEventListener('click', function() {
                procedureListContainer.removeChild(listItem);
            });
            
            // Clear input fields
            document.getElementById('procedure-title').value = "";
            document.getElementById('procedure-price').value = "";
        } else {
            alert("Please enter both procedure title and price.");
        }
    });

function savePrescription() {
  const title = document.getElementById('note-title').value.trim();
  const notes = document.getElementById('treatment-plans').value.trim();
  const patientId = '<?php echo $_SESSION['patient_id']; ?>'; // Assuming it's set in the session

  // Check if all fields are filled
  if (!title || !notes) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Please fill out all fields.'
    });
    return;
  }

  // Ask the user whether they want to save or edit the data
  Swal.fire({
    title: 'Do you want to save the prescription?',
    text: 'Please confirm if you want to proceed with saving this prescription.',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, Save it',
    cancelButtonText: 'No, Edit the Data'
  }).then((result) => {
    if (result.isConfirmed) {
      // Proceed with saving the data if the user clicks "Yes"
      const data = {
        patient_id: patientId,
        patient_prescription: title,
        description: notes
      };

      // Send data to the server using fetch
      fetch('../functions/add_prescription.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => {
        console.log(data); // Log the response data to check if prescription_id is returned
        if (data.success) {
          const prescriptionId = data.prescription_id; // Get prescription_id from the response

          // Check if prescription_id is returned
          if (prescriptionId) {
            // Show a success SweetAlert
            Swal.fire({
              icon: 'success',
              title: 'Successfully Saved!',
              text: 'Prescription has been saved successfully.',
              showConfirmButton: false,
              timer: 1500  // Display the message for 1.5 seconds
            }).then(() => {
              // Redirect to the next page with patient_id and prescription_id
              window.location.href = `add_medical-history.php?patient_id=${encodeURIComponent(patientId)}&prescription_id=${encodeURIComponent(prescriptionId)}`;
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Prescription ID not found in response.'
            });
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Error saving prescription: ' + data.message
          });
        }
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'An error occurred while saving the prescription.'
        });
      });
    } else {
      // User clicked "No, Edit the Data", show a message and allow them to stay on the form
      Swal.fire({
        icon: 'info',
        title: 'You can edit the data.',
        text: 'Please make changes and try saving again.'
      });
    }
  });
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
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="/js/patient-info.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>