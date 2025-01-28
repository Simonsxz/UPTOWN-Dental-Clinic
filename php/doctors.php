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
    <title>User Account</title>
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
            <li><a href="doctors.php" class="active"><i class='bx bxs-user-detail icon' ></i> User Account </a></li>
			<li><a href="patient.php"><i class='bx bxs-user-circle icon' ></i> Patient </a></li>
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
                <h1 class="title">Users Account</h1>
                <!-- Page Header -->

                <!-- Breadcrumbs -->
                <ul class="breadcrumbs">
                    <li><p>Main</p></li>
                    <li class="divider">/</li>
                    <li><a href="#" class="active">User Account</a></li>
                </ul>
            </div>
	
			<div class="main-content-main-container">
                <div class="left-container1">
                    <div class="welcome-dashboard-container">
                        <div class="welcome-dashboard-content-container">
							<div class="patient with-folder">
								<div>
									<h2>List of Users</h2>
									<p>Users List of UPTOWN Dental Clinic</p>
								</div>
								<button type="button" class="save" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
									<i class="fas fa-plus-circle"></i>
									Add New User
								  </button>
								  
							</div>							
                            <div class="table-container">
								<!-- Controls -->
								<div class="table-controls">
									<!-- Filter Dropdown -->
									<div class="filter-container">
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
										<th scope="col">User ID</th>
										<th scope="col">First Name</th>
										<th scope="col">Last Name</th>
										<th scope="col">Role</th>
										<th scope="col">Created</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody id="tableBody">
								<?php
									// Fetch and display results for tbl_useraccount
									$sql_admin = "SELECT id, user_ID, user_fName, user_lName, user_role, user_created FROM tbl_useraccount";
									$stmt_admin = mysqli_prepare($conn, $sql_admin);

									if ($stmt_admin) {
										mysqli_stmt_execute($stmt_admin);

										// Bind the result variables
										mysqli_stmt_bind_result($stmt_admin, $id, $user_ID, $first_name, $last_name, $role, $created);

										// Fetch and display results
										while (mysqli_stmt_fetch($stmt_admin)) {
									?>
											<tr>
												<td><?php echo $id; ?></td>
												<td><?php echo htmlspecialchars($user_ID); ?></td>
												<td><?php echo htmlspecialchars($first_name); ?></td>
												<td><?php echo htmlspecialchars($last_name); ?></td>
												<td><?php echo htmlspecialchars($role); ?></td>
												<td><?php echo htmlspecialchars($created); ?></td>
												
												<td>
													<!-- View User -->
										
												<a href="#" 
												class="link-dark1 view-link" 
												data-bs-toggle="modal" 
												data-bs-target="#StudentViewModal" 
												data-user-id="<?php echo htmlspecialchars($user_ID); ?>"> <!-- Pass user_ID -->
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
											<!-- Page numbers will be dynamically generated here -->
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
							
                            
                        </div>
                    </div>
					<div>
                    
			</div>

			<!-- View Modal -->
			<div class="modal fade" id="StudentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">User Details:</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form>
								<div class="mb-3">
									<label for="idView" class="form-label">User ID</label>
									<input type="text" class="form-control" id="idView" readonly>
								</div>
								<div class="mb-3">
									<label for="fnameView" class="form-label">First Name</label>
									<input type="text" class="form-control" id="fnameView" readonly>
								</div>
								<div class="mb-3">
									<label for="lnameView" class="form-label">Last Name</label>
									<input type="text" class="form-control" id="lnameView" readonly>
								</div>
								<div class="mb-3">
									<label for="roleView" class="form-label">Role</label>
									<input type="text" class="form-control" id="roleView" readonly>
								</div>
								<div class="mb-3">
									<label for="createdView" class="form-label">Created Date</label>
									<input type="text" class="form-control" id="createdView" readonly>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>


					<!-- Edit Modal -->
			<div class="modal fade" id="StudentEditModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="editModalLabel">Edit User Details</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form id="editForm">
								<input type="hidden" id="editUserID" name="editUserID"> <!-- Hidden field for User ID -->
								<div class="mb-3">
									<label for="editFName" class="form-label">First Name</label>
									<input type="text" class="form-control" id="editFName" name="editFName" required>
								</div>
								<div class="mb-3">
									<label for="editLName" class="form-label">Last Name</label>
									<input type="text" class="form-control" id="editLName" name="editLName" required>
								</div>
								<div class="mb-3">
									<label for="editRole" class="form-label">Role</label>
									<select class="form-select" id="editRole" name="editRole" required>
										<option value="admin">Admin</option>
										<option value="doctor">Doctor</option>
										<option value="receptionist">Receptionist</option>
									</select>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="saveEditButton">Save Changes</button>
						</div>
					</div>
				</div>
			</div>


			<!-- Add Modal -->
			<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content" style="background-color: #ffffff;">
						<!-- Modal Header -->
						<div class="modal-header">
							<h5 class="modal-title" id="addUserModalLabel">Add User Details</h5>
						</div>

						<!-- Modal Body -->
						<div class="modal-body">
							<!-- Form -->
							<form id="addUserForm" action="doctors.php" method="POST">
								<div class="row">
									<!-- First Name -->
									<div class="col-6 mb-2">
										<label for="firstName" class="form-label">First Name</label>
										<input type="text" class="form-control" id="firstName" name="firstName" required>
									</div>

									<!-- Last Name -->
									<div class="col-6 mb-2">
										<label for="lastName" class="form-label">Last Name</label>
										<input type="text" class="form-control" id="lastName" name="lastName" required>
									</div>

									<!-- Username -->
									<div class="col-12 mb-2">
										<label for="username" class="form-label">Username</label>
										<input type="text" class="form-control" id="username" name="username" required>
									</div>

									<!-- Password -->
									<div class="col-12 mb-2 position-relative">
										<label for="password" class="form-label">Password</label>
										<div class="input-group position-relative">
											<input type="password" class="form-control pe-5" id="password" name="password" style="border-radius: 0.375rem;" required>
											<span class="position-absolute top-50 end-0 translate-middle-y me-2" id="togglePassword" style="cursor: pointer;">
												<i class="bi bi-eye" id="eyeIcon"></i>
											</span>
										</div>
									</div>

									<!-- Role -->
									<div class="col-12 mb-2">
										<label for="role" class="form-label">Role</label>
										<select class="form-select" id="role" name="role" required>
											<option value="" disabled selected>Select a role</option>
											<option value="admin">Admin</option>
											<option value="doctor">Doctor</option>
											<option value="receptionist">Receptionist</option>
										</select>
									</div>
								</div>

								<!-- Buttons -->
								<div class="d-flex justify-content-end gap-2 mt-3">
								<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="cancelButton">Cancel</button>
									<button type="button" class="btn btn-primary" onclick="submitAddUserForm()">Save</button>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			
		</main>
		
      
</body>

 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

	<script>
  $(document).ready(function () {
    // Fetch data when clicking the "View" button
    $(document).on("click", ".view-link", function () {
        var user_id = $(this).data('user-id'); // Get user ID from the data attribute
        
        $.ajax({
            type: "POST",
            url: "../functions/view_doctors.php", // Change the PHP file if needed
            data: {
                'checking_view': true,
                'user_id': user_id, // Send the user ID
            },
            success: function (response) {
                if (response.length > 0) {
                    // Populate the input fields with the data
                    $.each(response, function (key, user) {
                        $('#idView').val(user.user_ID); // Fill user ID
                        $('#fnameView').val(user.user_fName); // Fill first name
                        $('#lnameView').val(user.user_lName); // Fill last name
                        $('#roleView').val(user.user_role); // Fill role
                        $('#createdView').val(user.user_created); // Fill creation date
                    });
                    $('#StudentViewModal').modal('show'); // Show the modal
                } else {
                    alert("No record found!");
                }
            }
        });
    });
});

$(document).ready(function () {
    // Fetch data when clicking the "Edit" button
    $(document).on("click", ".edit-link", function () {
        var user_id = $(this).data('user-id'); // Get user ID from the data attribute
        
        $.ajax({
            type: "POST",
            url: "../functions/view_doctors.php", // Update as needed
            data: {
                'checking_view': true,
                'user_id': user_id, // Send the user ID
            },
			success: function (response) {
    console.log(response); // Debug fetched data
    if (response.length > 0) {
        $.each(response, function (key, user) {
            $('#editUserID').val(user.user_ID);
            $('#editFName').val(user.user_fName);
            $('#editLName').val(user.user_lName);
            $('#editRole').val(user.user_role);
        });
        $('#StudentEditModal').modal('show');
    } else {
        alert("No record found!");
    }
}

        });
    });

    // Save changes when clicking "Save Changes"
	$('#saveEditButton').on('click', function () {
    // SweetAlert2 confirmation before making the AJAX request
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to save the changes?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, save changes!',
        cancelButtonText: 'No, cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with AJAX request to save changes
            var data = {
                update: true, // Action identifier
                user_id: $('#editUserID').val(),
                fname: $('#editFName').val(),
                lname: $('#editLName').val(),
                role: $('#editRole').val(),
            };

            $.ajax({
                type: "POST",
                url: "../functions/edit_doctors.php", // Update path if necessary
                data: data,
                success: function (response) {
                    console.log("Server response:", response); // Debug response
                    if (response.includes("Data Updated")) {
                        // Show success message
                        Swal.fire(
                            'Updated!',
                            'User details have been updated successfully.',
                            'success'
                        ).then(() => {
                            // Reload the page after showing the success message for a while
                            location.reload(); // Reload the page after success message
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            'There was an error updating the user.',
                            'error'
                        );
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'There was an error with the AJAX request.',
                        'error'
                    );
                }
            });
        } else {
            // If the user cancels
            Swal.fire(
                'Cancelled',
                'No changes were made.',
                'info'
            );
        }
    });
});


});

function confirmDelete(userID) {
    // Show a confirmation dialog using SweetAlert
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            // Call deleteUser function if confirmed
            deleteUser(userID);
        }
    });
}

// Function to delete the user
function deleteUser(userID) {
    // You can send an AJAX request to your server to delete the user from the database
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../functions/delete_doctors.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // If the user is successfully deleted, reload the page or update the table dynamically
            Swal.fire(
                'Deleted!',
                'User has been deleted.',
                'success'
            ).then(() => {
                location.reload(); // Reload the page to reflect changes
            });
        } else if (xhr.readyState === 4) {
            Swal.fire(
                'Error!',
                'There was an issue deleting the user.',
                'error'
            );
        }
    };

    xhr.send("user_id=" + userID); // Sending the user ID to delete_user.php
}



</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="/js/doctors.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>