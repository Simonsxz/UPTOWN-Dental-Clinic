<?php include "../functions/function.php"; ?>


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
		
			<li><a href="dashboard.html"><i class='bx bxs-dashboard icon' ></i>Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
            <li><a href="doctors.html" class="active"><i class='bx bxs-user-detail icon' ></i> User Account </a></li>
			<li><a href="patient.html"><i class='bx bxs-user-circle icon' ></i> Patient </a></li>
			<li><a href="xray.html"><i class='bx bxs-barcode icon' ></i> X-ray </a></li>
			<li><a href=""><i class='bx bxs-photo-album icon' ></i> Oral Photos </a></li>

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
	
			<!-- Profile -->
			<div class="profile">
				<h2 >UP-SC-001</h2>
		
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
											<th scope="col">First Name</th>
											<th scope="col">Last Name</th>
											<th scope="col">Role</th>
											<th scope="col">Created</th>
											<th scope="col">Actions</th>
										</tr>
									</thead>
									<tbody id="tableBody">
										<!-- Data will be populated by JavaScript -->
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
							
                            
                        </div>
                    </div>
					<div>
                    
			</div>
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
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" onclick="addUser()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

  

			
		</main>

		
      
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="/js/doctors.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>