<?php
session_start();
include "../functions/db_conn.php";         // Include database connection
include "../functions/function.php"; 
include "../functions/module_doctors_validation.php"; // Include the validation function

$user_ID = $_SESSION['user_ID'];

if (!isset($_SESSION['user_ID'])) {
    header("Location: ../index.php"); // Redirect to login if not authenticated
    exit;
}

if (isset($_POST['fetch_history']) && isset($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];
    $sql = "SELECT ptn.patient_id, ptn.procedure_id, pr.procedure_details, ptn.patient_doctor, ptn.created_at AS prescription_date, pa.payment 
            FROM tbl_patientnotes ptn
            JOIN tbl_procedure pr ON ptn.procedure_id = pr.procedure_id
            JOIN tbl_patientaccount pa ON ptn.patient_id = pa.patient_id
            WHERE ptn.patient_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $history = [];
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
        
        echo json_encode(['history' => $history]);
    } else {
        echo json_encode(['error' => 'Failed to execute query.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
		
			<li><a href="dashboard.php" ><i class='bx bxs-dashboard icon' ></i>Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
			<?php if ($user_ID && isAdmin($user_ID, $conn)): ?>
				<li><a href="doctors.php" ><i class='bx bxs-user-detail icon'></i> User Account</a></li>
			<?php endif; ?>

			<li><a href="patient.php"  class="active"><i class='bx bxs-user-circle icon' ></i> Patient </a></li>
            <li><a href="family.php"><i class='bx bxs-group icon'></i> Family </a></li>
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


									<label for="rowsPerPage">Show:</label>
										<select id="rowsPerPage" class="rows-per-page" onchange="updateRowsPerPage()">
											<option value="20">20</option>
											<option value="50">50</option>
											<option value="100">100</option>
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
										// Fetch and display results for tbl_patientaccount, sorted by ID in descending order
										$sql_admin = "SELECT id, patient_id, patient_fullName, patient_family, patient_created FROM tbl_patientaccount ORDER BY id DESC";
										$stmt_admin = mysqli_prepare($conn, $sql_admin);

										if ($stmt_admin) {
											mysqli_stmt_execute($stmt_admin);

											// Bind the result variables
											mysqli_stmt_bind_result($stmt_admin, $id, $patient_id, $patient_fullName, $patient_family, $patient_created);

											// Initialize row number counter
											$rowIndex = 1;

											// Fetch and display results
											while (mysqli_stmt_fetch($stmt_admin)) {
										?>
												<tr>
													<td><?php echo $rowIndex++; ?></td> <!-- Sequential numbering -->
													<td><?php echo htmlspecialchars($patient_id); ?></td>
													<td><?php echo htmlspecialchars($patient_fullName); ?></td>
													<td><?php echo htmlspecialchars($patient_family); ?></td>
													<td><?php echo htmlspecialchars($patient_created); ?></td>
													
													<td>
														<!-- View User -->
														<a href="#"
															class="link-dark1 view-link"
															data-bs-toggle="modal"
															data-bs-target="#memberModal"
															data-member-id="<?php echo htmlspecialchars($patient_id); ?>"> 
															<button class="action-button view-button1" title="View Patient Details">View</button>
														</a>

														<a href="#" 
															class="link-dark1 edit-link" 
															data-bs-toggle="modal" 
															data-bs-target="#StudentEditModal" 
															data-user-id="<?php echo htmlspecialchars($patient_id); ?>"> 
															<button class="action-button edit-button" title="Edit User Details">
																Edit
															</button>
														</a>

														<a href="#" 
															class="link-dark1 delete-link" 
															data-user-id="<?php echo htmlspecialchars($patient_id); ?>" 
															onclick="confirmDelete('<?php echo htmlspecialchars($patient_id); ?>')"> 
															<button class="action-button delete-button" title="Delete User">
																Delete
															</button>
														</a>
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

					<!-- Modal to Display Patient History Details -->
<div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="folderModalLabel">Patient History Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- New Record Button -->
				<div class="mb-3">
                    <button id="addNewRecord" class="btn btn-primary" onclick="redirectToAddRecord()">
                        <i class="bi bi-plus-circle"></i> Add New Record
                    </button>
                </div>

                <script>
                let selectedPatientId = null;
                let selectedProcedureId = null;

                // Capture the patient_id and procedure_id when the modal opens
                document.querySelectorAll('.view-link').forEach(link => {
                    link.addEventListener('click', function () {
                        selectedPatientId = this.getAttribute('data-member-id');
							console.log("Selected Patient ID:", selectedPatientId); // Debugging purpose
						});
					});

					async function redirectToAddRecord() {
    if (!selectedPatientId) {
        alert("No patient ID selected.");
        return;
    }

    try {
                        console.log("Fetching patient history for patient:", selectedPatientId, "and procedure:", selectedProcedureId);

        const response = await fetch(`../functions/get_next_procedure.php?patient_id=${encodeURIComponent(selectedPatientId)}`);
        const text = await response.text(); // Read response as text
        console.log("Raw Response:", text); // Log full response before parsing

        // Try parsing as JSON
        const data = JSON.parse(text);
        console.log("Parsed JSON Response:", data);

        if (data.success) {
            const nextProcedureId = data.procedure_id;
            console.log("Next Procedure ID:", nextProcedureId);
            const url = `add_patientinfo.php?patient_id=${encodeURIComponent(selectedPatientId)}&procedure_id=${encodeURIComponent(nextProcedureId)}`;
            window.location.href = url;
        } else {
            console.error("Error from server:", data.message);
            alert("Failed to generate procedure ID: " + data.message);
        }
    } catch (error) {
        console.error("Fetch error:", error);
                        alert("An error occurred while fetching patient history.");
                    }
                }
                </script>

                <!-- Table to Display Patient History -->
                <table class="table table-bordered table-hover" id="patientHistoryTable">
                    <thead class="table-light">
                        <tr>
                            <th>Patient ID</th>
                            <th>Procedure ID</th>
                            <th>Procedure Details</th>
                            <th>Date</th>
                            <th style="width: 150px; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="patientHistoryTableBody">
                        <!-- Patient history data will be dynamically inserted here -->
                    </tbody>
                </table>

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
													</div>
												</div>

												<!-- Additional Information -->
												<div class="mb-3">
													<h6>Additional Information</h6>
													<div class="row g-3">
														<div class="col-md-6">
															<label for="status" class="form-label">Status:</label>
															<input type="text" id="status" name="status" class="form-control" placeholder="Enter civil status">
														</div>
														<div class="col-md-6">
															<label for="occupation" class="form-label">Occupation:</label>
															<input type="text" id="occupation" name="occupation" class="form-control" placeholder="Enter occupation">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
	#pageNumbers {
    display: flex;
    gap: 5px;
    justify-content: center;
    flex-wrap: wrap;
}

#pageNumbers button {
    padding: 5px 10px;
    border: 1px solid #ccc;
    background: white;
    cursor: pointer;
    transition: 0.3s;
}

#pageNumbers button.active {
    background: #007bff;
    color: white;
    font-weight: bold;
}

#pageNumbers button:hover {
    background: #0056b3;
    color: white;
}

#pageNumbers span {
    padding: 5px 10px;
    font-weight: bold;
}

</style>

<script>
$(document).ready(function () {
    $(document).on("click", ".view-link", function (event) {
        event.preventDefault();

        var patientId = $(this).data('member-id');
        console.log('Fetching history for Patient ID:', patientId);

        if (!patientId) {
            console.error('Patient ID is missing');
            return;
        }

        $.ajax({
            type: "POST",
            url: "../functions/fetch_patienthistory.php",
            data: { 'fetch_history': true, 'patient_id': patientId },
            success: function (response) {
                console.log('Response:', response);

                var tableBody = $('#patientHistoryTableBody');
                tableBody.empty();  // Clear any old rows

                if (response.error || (response.history && response.history.length === 0)) {
                    tableBody.append('<tr><td colspan="6">No history found for this patient.</td></tr>');
                } else if (response.history) {
                    // Loop through history and populate the table
                    response.history.forEach(function (entry) {
                        var row = $('<tr>');
                        row.append('<td>' + entry.patient_id + '</td>');
                        row.append('<td>' + entry.procedure_id + '</td>');
                        row.append('<td>' + entry.procedure_details + '</td>');
                        row.append('<td>' + entry.created_at + '</td>');

                        var actionButtons = `
                            <td>
                                <button class="btn btn-sm btn-info view-action" data-patient-id="${entry.patient_id}" data-procedure-id="${entry.procedure_id}">View</button>
                                <button class="btn btn-sm btn-warning edit-action" data-patient-id="${entry.patient_id}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-action" data-patient-id="${entry.patient_id}">Delete</button>
                            </td>
                        `;
                        row.append(actionButtons);

                        tableBody.append(row);
                    });
                }

                // Show the modal
                $('#memberModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
                $('#patientHistoryTableBody').append('<tr><td colspan="6">An error occurred while fetching data.</td></tr>');
            }
        });
    });
});


$(document).ready(function () {
    // Attach click event listener for dynamically added ".view-action" buttons
    $(document).on('click', '.view-action', function () {
        // Retrieve data from button attributes
        const patientId = $(this).data('patient-id');
        const procedureId = $(this).data('procedure-id');

        console.log('Redirecting with Patient ID:', patientId, 'and Prescription:', procedureId);

        // Redirect with query parameters
        if (patientId) {
            const url = `../php/patient-info.php?patient_id=${encodeURIComponent(patientId)}&procedure_id=${encodeURIComponent(procedureId)}`;
            window.location.href = url;
        } else {
            console.error('Patient ID is missing.');
        }
    });
});


</script>


<style>
	/* Adjust the width of the modal */
.modal-dialog {
    max-width: 90%;   /* Adjust the percentage as needed */
    width: auto;      /* Ensure the modal doesn't stretch too wide */
}

/* Optionally, you can set a minimum width if needed */
.modal-dialog {
    min-width: 700px; /* Adjust as per the desired minimum width */
}

/* Set the table layout to auto to allow columns to adjust based on content */
.table {
    table-layout: auto;   /* Allow the columns to adjust based on content */
    width: 100%;           /* Ensure the table takes the full width available */
}

/* Adjust individual column width if necessary */
.table th, .table td {
    white-space: nowrap;   /* Prevent the content from wrapping */
    padding: 10px;         /* Add padding for better readability */
}

/* Optional: Adjust the column widths based on content */
.table th:nth-child(1), .table td:nth-child(1) {
    width: 10%;  /* Adjust the width of the first column */
}

.table th:nth-child(2), .table td:nth-child(2) {
    width: 25%;  /* Adjust the width of the second column */
}

.table th:nth-child(3), .table td:nth-child(3) {
    width: 30%;  /* Adjust the width of the third column */
}

.table th:nth-child(4), .table td:nth-child(4) {
    width: 15%;  /* Adjust the width of the fourth column */
}

.table th:nth-child(5), .table td:nth-child(5) {
    width: 15%;  /* Adjust the width of the fifth column */
}

.table th:nth-child(6), .table td:nth-child(6) {
    width: 5%;   /* Adjust the width of the sixth column (Actions) */
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
<script src="/js/patient.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>