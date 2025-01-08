<?php
session_start();
include "../functions/db_conn.php";

$user_ID = $_SESSION['user_ID']; 
// Fetch user_ID from session
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
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/x-icon" href="/assets/uplogo.png">
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
		
			<li><a href="dashboard.php"><i class='bx bxs-dashboard icon' ></i>Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
            <li><a href="doctors.php"><i class='bx bxs-user-detail icon' ></i> User Account </a></li>
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
			
	
			</div>
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
                <!-- Page Header -->
                <h1 class="title">Patient</h1>
                <!-- Page Header -->

                <!-- Breadcrumbs -->
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
							<div class="patient with-folder">
								<div>
									<h2>List of Patients</h2>
									<p>Patients List of UPTOWN Dental Clinic</p>
								</div>
								<div class="button-group">
								
									<button type="button" class="save" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">  <i class="fas fa-plus-circle"></i>  Add New Patient</button>
								</div>						
							</div>							
                            <div class="table-container">
								<!-- Controls -->
								<div class="table-controls">
									<!-- Filter Dropdown -->
									<div class="filter-container">
										<label for="rowsPerPage">Filter:</label>
									<select id="rowsPerPage" class="rows-per-page" onchange="updateRowsPerPage1()">
										<option value="patient">Patient</option>
										<option value="folder">Folder</option>
									</select>


									<label for="rowsPerPage">Show:</label>
										<select id="rowsPerPage" class="rows-per-page" onchange="updateRowsPerPage()">
											<option value="3">3</option>
											<option value="5">5</option>
											<option value="10">10</option>
											<option value="all">All</option>
										</select>
									</div>

									
							
									<!-- Search Bar -->
									<div class="search-container">
										<input type="text" id="tableSearch" placeholder="Search..." class="search-bar">
										<button class="search-button">
											<i class="fas fa-search"></i>
										</button>
									</div>									
								</div>
							
								<!-- Table -->
								<table class="table table-hover">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Patient ID</th>
										<th scope="col">Patient Name</th>
										<th scope="col">Family Member</th>
										<th scope="col">Created</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody id="tableBody">
								<?php
									// Fetch and display results for tbl_useraccount
									$sql_admin = "SELECT id, patient_id,  patient_fullName, patient_family, patient_created FROM tbl_patientaccount";
									$stmt_admin = mysqli_prepare($conn, $sql_admin);

									if ($stmt_admin) {
										mysqli_stmt_execute($stmt_admin);

										// Bind the result variables
										mysqli_stmt_bind_result($stmt_admin, $id, $patient_id, $patient_fullName, $patient_family, $patient_created);

										// Fetch and display results
										while (mysqli_stmt_fetch($stmt_admin)) {
									?>
											<tr>
												<td><?php echo $id; ?></td>
												<td><?php echo htmlspecialchars($patient_id); ?></td>
												<td><?php echo htmlspecialchars($patient_fullName); ?></td>
												<td><?php echo htmlspecialchars($patient_family); ?></td>
												<td><?php echo htmlspecialchars($patient_created); ?></td>
												
												<td>
													<!-- View User -->
										
													<a href="#" 
													class="link-dark1 view-link" 
													data-bs-toggle="modal" 
													data-bs-target="#viewPatientHistory" 
													data-user-id="<?php echo htmlspecialchars($row['patient_id']); ?>"> <!-- Pass the patient ID -->
														<button class="action-button view-button1" title="View User Details">
															View
														</button>
													</a>


												<a href="#" 
												class="link-dark1 edit-link" 
												data-bs-toggle="modal" 
												data-bs-target="#StudentEditModal" 
												data-user-id="<?php echo htmlspecialchars($user_ID); ?>"> <!-- Pass user_ID -->
													<button class="action-button edit-button" title="Edit User Details">
														Edit
													</button>
												</a>

												<a href="#" 
													class="link-dark1 delete-link" 
													data-user-id="<?php echo htmlspecialchars($user_ID); ?>" 
													onclick="confirmDelete('<?php echo htmlspecialchars($user_ID); ?>')"> <!-- Pass user_ID -->
													<button class="action-button delete-button" title="Delete User">
														Delete
													</button>
												</a>
											</td>


												</td>
											</tr>
									<?php
										}

										// Close the statement
										mysqli_stmt_close($stmt_admin);
									} else {
										// Handle the error if the statement preparation fails
										echo "<tr><td colspan='7'>Error: " . mysqli_error($conn) . "</td></tr>";
									}
									?>

								</tbody>
							</table>
							
								
								<div class="pagination-container">
									<!-- Left: Pagination -->
									<div class="pagination">
										<button class="page-button" onclick="prevPage()">
											<i class="fas fa-chevron-left"></i>
										</button>
								
										<div id="pageNumbers" class="page-numbers">
											<!-- Page numbers will be dynamically generated -->
										</div>
								
										<button class="page-button" onclick="nextPage()">
											<i class="fas fa-chevron-right"></i>
										</button>
									</div>
								
									<!-- Right: Showing entries text -->
									<div class="entries-info" id="entriesInfo">
										<!-- Text will be dynamically updated -->
									</div>
								</div>
								
								
							</div>

							<!-- Modal for Viewing Patient History -->
							<div class="modal fade" id="viewPatientHistory" tabindex="-1" aria-labelledby="viewPatientHistoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPatientHistoryLabel">Patient Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="patientName">Loading...</h5>
                <p id="patientId">Patient ID: Loading...</p>
                <p id="patientPrescription">Prescription: Loading...</p>
                <p id="patientDoctor">Doctor: Loading...</p>
                <p id="patientPayment">Payment Status: Loading...</p>
                <p id="prescriptionDate">Prescription Date: Loading...</p>
            </div>
        </div>
    </div>
</div>



	
							<!-- Add Modal -->
							<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered modal-lg">
									<div class="modal-content">
										<!-- Modal Header -->
										<div class="modal-header">
											<h5 class="modal-title" id="addUserModalLabel">Add Patient Details</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>

										<!-- Modal Body -->
										<div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
											<form id="addPatientForm" onsubmit="submitAddPatientForm(event)">
												<!-- Personal Information -->
												<div class="mb-3">
													<h6>Personal Information</h6>
													<div class="row g-3">
													<div class="col-md-6">
														<?php
														// Fetch family data from the database
														$queryFamily = "SELECT id, folder_name, folder_head FROM tbl_familyfolder";
														$resultFamily = $conn->query($queryFamily);

														// Initialize an array to hold family data
														$families = [];
														if ($resultFamily && $resultFamily->num_rows > 0) {
															while ($row = $resultFamily->fetch_assoc()) {
																$families[] = $row;
															}
														}
														?>
														<label for="family" class="form-label">Family Member:</label>
														<select id="family" name="family" class="form-control" required>
															<option value="" disabled selected>Search or select a family</option>
															<option value="N/A">N/A</option>
															<?php foreach ($families as $family): ?>
																<option value="<?= $family['id']; ?>">
																	<?= $family['folder_name']; ?> (<?= $family['folder_head']; ?>)
																</option>
															<?php endforeach; ?>
														</select>
													</div>
														<div class="col-md-6">
															<label for="fullName" class="form-label">Patient's Name:</label>
															<input type="text" id="fullName" name="fullName" class="form-control" placeholder="Enter patient name" required>
														</div>
														<div class="col-md-6">
															<label for="DOB" class="form-label">Date of Birth:</label>
															<input type="date" id="DOB" name="DOB" class="form-control" required>
														</div>
														<div class="col-md-6">
															<label for="age" class="form-label">Age:</label>
															<input type="number" id="age" name="age" class="form-control" placeholder="Enter age">
														</div>
														<div class="col-md-6">
															<label for="gender" class="form-label">Gender:</label>
															<select id="gender" name="gender" class="form-select">
																<option value="" disabled selected>Select gender</option>
																<option value="male">Male</option>
																<option value="female">Female</option>
																<option value="other">Other</option>
															</select>
														</div>
														<div class="col-md-6">
														<?php
														// Fetch doctor data from the database
														$queryDoctor = "SELECT id, user_fName, user_lName FROM tbl_useraccount WHERE user_role = 'doctor'";
														$resultDoctor = $conn->query($queryDoctor);

														// Initialize an array to hold doctor data
														$doctors = [];
														if ($resultDoctor && $resultDoctor->num_rows > 0) {
															while ($row = $resultDoctor->fetch_assoc()) {
																$doctors[] = $row;
															}
														}
														?>
														<label for="doctor" class="form-label">Doctor:</label>
														<select id="doctor" name="doctor" class="form-control" required>
															<option value="" disabled selected>Search or select a doctor</option>
															<?php foreach ($doctors as $doctor): ?>
																<option value="<?= $doctor['id']; ?>">
																	Dr. <?= $doctor['user_fName']; ?> <?= $doctor['user_lName']; ?>
																</option>
															<?php endforeach; ?>
														</select>
													</div>

													</div>
												</div>

												<!-- Contact Information -->
												<div class="mb-3">
													<h6>Contact Information</h6>
													<div class="row g-3">
														<div class="col-md-6">
															<label for="address" class="form-label">Address:</label>
															<input type="text" id="address" name="address" class="form-control" placeholder="Enter address">
														</div>
														<div class="col-md-6">
															<label for="contact" class="form-label">Contact Number:</label>
															<input type="tel" id="contact" name="contact" class="form-control" placeholder="Enter contact number">
														</div>
														<div class="col-md-6">
															<label for="facebook" class="form-label">Facebook Account:</label>
															<input type="text" id="facebook" name="facebook" class="form-control" placeholder="Enter Facebook account">
														</div>
														<div class="col-md-6">
															<label for="nationality" class="form-label">Nationality:</label>
															<input type="text" id="nationality" name="nationality" class="form-control" placeholder="Enter nationality">
														</div>
													</div>
												</div>

												<!-- Additional Information -->
												<div class="mb-3">
													<h6>Additional Information</h6>
													<div class="row g-3">
														<div class="col-md-6">
															<label for="height" class="form-label">Height:</label>
															<input type="text" id="height" name="height" class="form-control" placeholder="Enter height">
														</div>
														<div class="col-md-6">
															<label for="weight" class="form-label">Weight:</label>
															<input type="text" id="weight" name="weight" class="form-control" placeholder="Enter weight">
														</div>
														<div class="col-md-6">
															<label for="status" class="form-label">Status:</label>
															<input type="text" id="status" name="status" class="form-control" placeholder="Enter civil status">
														</div>
														<div class="col-md-6">
															<label for="occupation" class="form-label">Occupation:</label>
															<input type="text" id="occupation" name="occupation" class="form-control" placeholder="Enter occupation">
														</div>
														<div class="col-md-6">
															<label for="religion" class="form-label">Religion:</label>
															<input type="text" id="religion" name="religion" class="form-control" placeholder="Enter religion">
														</div>
														<div class="col-md-6">
															<label for="referredBy" class="form-label">Referred By:</label>
															<input type="text" id="referredBy" name="referredBy" class="form-control" placeholder="Enter referred by">
														</div>
													</div>
												</div>

												<!-- Buttons -->
												<div class="d-flex justify-content-end gap-2 mt-3">
													<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="cancelButton">Cancel</button>
													<button type="submit" class="btn btn-primary">Save</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
			
                            
                        </div>
                    </div>
					<div>
                    
			</div>
		</main>
      
</body>


<script>
$(document).ready(function () {
    console.log('View-link listener initialized');

    $(document).on("click", ".view-link", function (event) {
        event.preventDefault();

        // Fetch patient_id from the data attribute
        var patientId = $(this).data('user-id');
        
        // Log the patient_id to check if it's being passed correctly
        console.log('Patient ID:', patientId);  // This should print the correct patient_id

        if (!patientId) {
            console.error('Patient ID is missing');
            return;
        }

        // Continue with your AJAX request
        $.ajax({
            type: "POST",
            url: "../functions/fetch_patient_history.php",
            data: {
                'fetch_history': true,
                'patient_id': patientId
            },
            success: function (response) {
                console.log('Response:', response);
                // Update the modal with patient details
                if (response.error) {
                    alert(response.error);
                } else {
                    // Populate the modal with patient details
                    $('#patientName').text(response.patient_name || "Unknown Patient");
                    $('#patientId').text("Patient ID: " + (response.patient_id || "N/A"));
                    $('#patientPrescription').text("Prescription: " + (response.patient_prescription || "N/A"));
                    $('#patientDoctor').text("Doctor: " + (response.patient_doctor || "N/A"));
                    $('#patientPayment').text("Payment Status: " + (response.patient_payment || "N/A"));
                    $('#prescriptionDate').text("Prescription Date: " + (response.prescription_date || "N/A"));

                    // Show the modal
                    $('#viewPatientHistory').modal('show');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert("An error occurred while fetching the data.");
            }
        });
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
<script src="/js/family.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>