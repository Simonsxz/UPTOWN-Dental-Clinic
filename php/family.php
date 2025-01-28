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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/x-icon" href="/assets/uplogo.png">
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
			<li><a href="patient.php"><i class='bx bxs-user-circle icon' ></i> Patient </a></li>
            <li><a href="family.php" class="active"><i class='bx bxs-group icon'></i> Family </a></li>
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
                <h1 class="title">Family Folder</h1>
                <!-- Page Header -->

                <!-- Breadcrumbs -->
                <ul class="breadcrumbs">
                    <li><p>Main</p></li>
                    <li class="divider">/</li>
                    <li><a href="#" class="active">Family</a></li>
                </ul>
            </div>
	
			<div class="main-content-main-container">
                <div class="left-container1">
                    <div class="welcome-dashboard-container">
                        <div class="welcome-dashboard-content-container">
							<div class="patient with-folder">
								<div>
									<h2>List of Family</h2>
									<p>Family List of UPTOWN Dental Clinic</p>
								</div>
								<div class="button-group">
									<button type="button" class="save" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFamilyModal">  <i class="fas fa-plus-circle"></i>  Add New Family</button>
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
										<th scope="col">Family ID</th>
										<th scope="col">Folder Name</th>
										<th scope="col">Family Head</th>
										<th scope="col">Created</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody id="tableBody">
								<?php
									// Fetch and display results for tbl_useraccount
									$sql_admin = "SELECT id, folder_id,  folder_name, folder_head, folder_created FROM tbl_familyfolder";
									$stmt_admin = mysqli_prepare($conn, $sql_admin);

									if ($stmt_admin) {
										mysqli_stmt_execute($stmt_admin);

										// Bind the result variables
										mysqli_stmt_bind_result($stmt_admin, $id, $folder_id, $folder_name, $folder_head, $folder_created);

										// Fetch and display results
										while (mysqli_stmt_fetch($stmt_admin)) {
									?>
											<tr>
												<td><?php echo $id; ?></td>
												<td><?php echo htmlspecialchars($folder_id); ?></td>
												<td><?php echo htmlspecialchars($folder_name); ?></td>
												<td><?php echo htmlspecialchars($folder_head); ?></td>
												<td><?php echo htmlspecialchars($folder_created); ?></td>
												
												<td>
													 <!-- View Folder Button -->
													<a href="#"
													class="link-dark1 view-link"
													data-bs-toggle="modal"
													data-bs-target="#folderModal"
													data-folder-id="<?php echo htmlspecialchars($folder_id); ?>"> 
														<button class="action-button view-button1" title="View Folder Details">View</button>
													</a>

												<!-- Members Button -->
												<a href="#"
													class="link-dark1"
													data-bs-toggle="modal"
													data-bs-target="#memberModal">
													<button class="action-button member-button" 
															title="View Members" 
															data-folder-id="<?php echo htmlspecialchars($folder_id); ?>">
														Members
													</button>
													</a>



													<a href="#" 
														class="link-dark1 edit-link" 
														data-bs-toggle="modal" 
														data-bs-target="#FolderEditModal" 
														data-folder-id="<?php echo htmlspecialchars($folder_id); ?>"> <!-- Pass folder ID -->
														<button class="action-button edit-button" title="Edit Folder Details">Edit</button>
													</a>


													<a href="#" 
													class="link-dark1 delete-link" 
													data-folder-id="<?php echo htmlspecialchars($folder_id); ?>" 
													onclick="confirmDelete('<?php echo htmlspecialchars($folder_id); ?>')">
														<!-- Pass folder_ID -->
														<button class="action-button delete-button" title="Delete Folder">
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

							<div class="modal fade" id="FolderEditModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="editModalLabel">Edit Folder Details</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<form id="editFolderForm">
											<div class="mb-3">
												<label for="editFolderID" class="form-label">Folder ID</label>
												<input type="text" class="form-control" id="editFolderID" readonly>
											</div>
											<div class="mb-3">
												<label for="editFolderName" class="form-label">Folder Name</label>
												<input type="text" class="form-control" id="editFolderName">
											</div>
											<div class="mb-3">
												<label for="editFolderHead" class="form-label">Folder Head</label>
												<input type="text" class="form-control" id="editFolderHead">
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" id="saveFolderEditButton">Save Changes</button>
									</div>
								</div>
							</div>
						</div>



							<div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="folderModalLabel">Folder Details</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<!-- Display folder name and head -->
										<h5 id="folderName"></h5>
										<p id="folderHead"></p>

										<!-- Table to display patients -->
										<table class="table">
											<thead>
												<tr>
													<th>Patient ID</th>
													<th>Patient Name</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody id="patientTableBody">
												<!-- Patient data will be dynamically inserted here -->
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
	
							<!-- Add Modal -->
						<div class="modal fade" id="addFamilyModal" tabindex="-1" aria-labelledby="addFamilyModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered modal-lg">
								<div class="modal-content" style="background-color: #ffffff;">
									<!-- Modal Header -->
									<div class="modal-header">
										<h5 class="modal-title" id="addFamilyModalLabel">Add Family Details</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>

									<!-- Modal Body -->
									<div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
										<!-- Family Details Form -->
										<form id="addFamilyForm" onsubmit="submitAddFamilyForm(event)">
											<div class="row">
												<div class="col-md-6 mb-2">
													<label for="folder_name" class="form-label">Family Name:</label>
													<input type="text" id="folder_name" name="folder_name" class="form-input form-control" required>
												</div>
												<div class="col-md-6 mb-2">
													<label for="folder_head" class="form-label">Family Head:</label>
													<input type="text" id="folder_head" name="folder_head" class="form-input form-control" required>
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

						<!-- Folder Details Modal -->
						<div class="modal fade" id="folderModal" tabindex="-1" aria-labelledby="folderDetailsLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="folderDetailsLabel">Folder Details:</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<form>
											<div class="mb-3">
												<label for="folderIdView" class="form-label">Folder ID</label>
												<input type="text" class="form-control" id="folderIdView" readonly>
											</div>
											<div class="mb-3">
												<label for="folderNameView" class="form-label">Folder Name</label>
												<input type="text" class="form-control" id="folderNameView" readonly>
											</div>
											<div class="mb-3">
												<label for="folderHeadView" class="form-label">Folder Head</label>
												<input type="text" class="form-control" id="folderHeadView" readonly>
											</div>
											<div class="mb-3">
												<label for="folderCreatedView" class="form-label">Created Date</label>
												<input type="text" class="form-control" id="folderCreatedView" readonly>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    // When the "View" button is clicked (only view modal will open)
    $(document).on("click", ".view-link", function (event) {
        event.preventDefault();  // Prevent default action
        
        var folder_id = $(this).data('folder-id'); // Get folder ID from the data attribute
        console.log('Clicked View for Folder ID: ' + folder_id); // Debugging line

        $.ajax({
            type: "POST",
            url: "../functions/fetch_family.php", // PHP script to fetch details
            data: {
                'checking_view': true,
                'folder_id': folder_id, // Send the folder ID
            },
            success: function (response) {
                try {
                    var data = JSON.parse(response);

                    if (data.error) {
                        alert(data.error);
                    } else {
                        // Populate the modal fields with the fetched data
                        $('#folderIdView').val(data.folder_id); 
                        $('#folderNameView').val(data.folder_name);
                        $('#folderHeadView').val(data.folder_head);
                        $('#folderCreatedView').val(data.folder_created); 

                        // Show only the folder modal
                        $('#folderModal').modal('show');
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    alert("There was an error retrieving the folder details.");
                }
            },
            error: function () {
                alert("An error occurred while fetching the data.");
            }
        });
    });
});

$(document).ready(function () {
    $(document).on("click", ".member-button", function (event) {
        event.preventDefault();

        var folderId = $(this).data('folder-id');
        console.log('Clicked Members for Folder ID:', folderId);

        if (!folderId) {
            console.error('Folder ID is missing');
            return;
        }

        $.ajax({
            type: "POST",
            url: "../functions/fetch_members.php",
            data: {
                'checking_members': true,
                'folder_id': folderId
            },
            success: function (response) {
                console.log('Raw Response:', response);

                // Clear the table body and the message area
                var tableBody = $('#patientTableBody');
                var noDataMessage = $('#noDataMessage');
                tableBody.empty();
                noDataMessage.text(''); // Clear any previous message

                // Update folder name and head
                $('#folderName').text(response.folder_name || "Unknown Folder");
                $('#folderHead').text("Head: " + (response.folder_head || "Unknown"));

                if (response.error || (response.members && response.members.length === 0)) {
                    // Display "No data found" message below the table
                    noDataMessage.text("No members found for this folder.");
                } else {
                    // Populate the table with member data
                    response.members.forEach(function (member) {
                        var row = $('<tr>');
                        row.append('<td>' + member.patient_id + '</td>');
                        row.append('<td>' + member.patient_fullName + '</td>');

                        // Add "Actions" column with a "View" button
                        var actionButton = `
                            <td>
                                <a href="#" 
                                   class="link-dark1 view-link" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#folderModal" 
                                   data-folder-id="${folderId}" 
                                   data-member-id="${member.patient_id}">
                                    <button class="action-button view-button1" 
                                            title="View Details">View</button>
                                </a>
                            </td>`;
                        row.append(actionButton);

                        tableBody.append(row);
                    });
                }

                // Show the modal after processing the data
                $('#memberModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
                $('#noDataMessage').text("An error occurred while fetching the data. Please try again later.");
            }
        });
    });
});
$(document).ready(function () {
    // When the "Edit" button is clicked
    $(document).on("click", ".edit-link", function (event) {
        event.preventDefault(); // Prevent default action

        var folder_id = $(this).data('folder-id'); // Get folder ID from the data attribute
        console.log('Clicked Edit for Folder ID: ' + folder_id); // Debugging line

        // Step 1: Fetch the folder details
        $.ajax({
            type: "POST",
            url: "../functions/fetch_family.php", // PHP script to fetch details
            data: {
                'checking_view': true,
                'folder_id': folder_id, // Send the folder ID
            },
            success: function (response) {
                try {
                    var data = JSON.parse(response);

                    if (data.error) {
                        alert(data.error);
                    } else {
                        // Populate the Edit modal fields with the fetched data
                        $('#editFolderID').val(data.folder_id); 
                        $('#editFolderName').val(data.folder_name);
                        $('#editFolderHead').val(data.folder_head);
                        $('#editFolderCreated').val(data.folder_created); 

                        // Show only the Edit modal
                        $('#FolderEditModal').modal('show');
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    alert("There was an error retrieving the folder details.");
                }
            },
            error: function () {
                alert("An error occurred while fetching the data.");
            }
        });
    });

    // Save changes when clicking "Save Changes" in the Edit modal
    $('#saveFolderEditButton').on('click', function () {
        var folder_id = $('#editFolderID').val(); // Get folder ID from the modal

        // First, check if there are any users associated with the folder
        $.ajax({
            type: "POST",
            url: "../functions/edit_folder_details.php", // PHP script to check if the folder has users
            data: { folder_id: folder_id },
            success: function (response) {
                if (response === 'EXISTING_USER') {
                    // If there is an existing user, show a SweetAlert
                    Swal.fire(
                        'Not Allowed!',
                        'You cannot update this folder because it already has an associated user. Please remove the user first.',
                        'warning'
                    );
                } else {
                    // If no user is associated, proceed with the update
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
                            var data = {
                                update: true, // Action identifier
                                folder_id: folder_id,
                                folder_name: $('#editFolderName').val(),
                                folder_head: $('#editFolderHead').val(),
                                folder_created: $('#editFolderCreated').val()
                            };

                            $.ajax({
                                type: "POST",
                                url: "../functions/edit_folder_details.php", // Update path if necessary
                                data: data,
                                success: function (response) {
                                    console.log("Server response:", response); // Debug response
                                    if (response.includes("Data Updated")) {
                                        Swal.fire(
                                            'Updated!',
                                            'Folder details have been updated successfully.',
                                            'success'
                                        ).then(() => {
                                            location.reload(); // Reload the page
                                        });
                                    } else {
										Swal.fire(
											'Not Allowed!',
											'You cannot update this folder because it already has an associated user. Please remove the user first.',
											'warning'
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
                            Swal.fire(
                                'Cancelled',
                                'No changes were made.',
                                'info'
                            );
                        }
                    });
                }
            },
            error: function () {
                Swal.fire(
                    'Error!',
                    'There was an error with the AJAX request while checking the user.',
                    'error'
                );
            }
        });
    });
});


// Function to confirm deletion
function confirmDelete(folderID) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You will not be able to recover this folder!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes, delete it!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed to delete the folder if confirmed
            deleteFolder(folderID);
        } else {
            Swal.fire(
                'Cancelled',
                'The folder was not deleted.',
                'info'
            );
        }
    });
}

// Function to confirm deletion and check for associated users in tbl_familydata
function confirmDelete(folderID) {
    // First, check if there are users associated with the folder in tbl_familydata
    $.ajax({
        type: "POST",
        url: "../functions/check_folder_member.php", // PHP script to check if the folder has users
        data: { folder_id: folderID },
        success: function(response) {
            if (response === 'USER_EXISTS') {
                // If the folder has an associated user, show the SweetAlert
                Swal.fire(
                    'Cannot Delete!',
                    'This folder has users associated with it. Please remove the users first before deleting the folder.',
                    'warning'
                );
            } else {
                // If no users are associated, proceed with the deletion confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will not be able to recover this folder!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed to delete the folder if confirmed
                        deleteFolder(folderID);
                    } else {
                        Swal.fire(
                            'Cancelled',
                            'The folder was not deleted.',
                            'info'
                        );
                    }
                });
            }
        },
        error: function() {
            Swal.fire(
                'Error!',
                'There was an issue checking the folder association.',
                'error'
            );
        }
    });
}

// Function to delete the folder
function deleteFolder(folderID) {
    // Create an XMLHttpRequest to send a POST request to the PHP script
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../functions/delete_folder.php", true); // Update the path if necessary
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define the behavior when the request is completed
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // If the folder is successfully deleted, reload the page or update the table dynamically
            Swal.fire(
                'Deleted!',
                'Folder has been deleted.',
                'success'
            ).then(() => {
                location.reload(); // Reload the page to reflect changes
            });
        } else if (xhr.readyState === 4) {
            // If there was an error
            Swal.fire(
                'Error!',
                'There was an issue deleting the folder.',
                'error'
            );
        }
    };

    // Send the folder ID to the delete_folder.php script to delete the folder
    xhr.send("folder_id=" + folderID); 
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
<script src="/js/family.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>