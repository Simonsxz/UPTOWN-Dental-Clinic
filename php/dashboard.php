<?php
session_start();  // Ensure session is started at the very top of the page

include "../functions/db_conn.php";         // Include database connection
include "../functions/module_doctors_validation.php"; // Include the validation function

if (!isset($_SESSION['user_ID'])) {
    header("Location: ../index.php"); // Redirect to login if not authenticated
    exit;
}

$user_ID = $_SESSION['user_ID']; // Fetch user_ID from session
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
    <!-- <link rel="stylesheet" href="\css\modal.css"> -->
    <link rel="stylesheet" href="\css\style.css">
    <link rel="icon" type="image/x-icon" href="\assets\uplogo.png">
    <title>Dashboard</title>
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
		
			<li><a href="dashboard.php" class="active"><i class='bx bxs-dashboard icon' ></i>Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
			<?php if ($user_ID && isAdmin($user_ID, $conn)): ?>
				<li><a href="doctors.php"><i class='bx bxs-user-detail icon'></i> User Account</a></li>
			<?php endif; ?>

			<li><a href="patient.php"><i class='bx bxs-user-circle icon' ></i> Patient </a></li>
            <li><a href="family.php" ><i class='bx bxs-group icon'></i> Family </a></li>
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
			
				<div class="nav-search-container">
				</div>
			</div>

			
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
                <h1 class="title">Dashboard</h1>
                <!-- Page Header -->

                <!-- Breadcrumbs -->
                <ul class="breadcrumbs">
                    <li><p>Main</p></li>
                    <li class="divider">/</li>
                    <li><a href="#" class="active">Dashboard</a></li>
                </ul>
            </div>

			<div class="info-data">
				<div class="card">
					<div class="head">
						<img src="\assets\1.png" alt="Cannot load image data">
						<div>
							<p>Total Doctors</p>
							<h2>15</h2>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="head">
						<img src="\assets\2.png" alt="Cannot load image data">
						<div>
							<p>Total Patients</p>
							<h2>127</h2>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="head">
						<img src="\assets\3.png" alt="Cannot load image data">
						<div>
							<p>New Patients</p>
							<h2>20</h2>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="head">
						<img src="\assets\4.png" alt="Cannot load image data">
						<div>
							<p>Total Notes</p>
							<h2>200</h2>
						</div>
					</div>
				</div>

			</div>

			<div class="data">
				<div class="content-data1">
					<div class="head">
						<h3>Patient History</h3>
					
					</div>
					<div class="chart">
						<div id="chart"></div>
					  </div>
					
				</div>

				<div class="content-data">

				<div class="info-data">
			
					<div class="card">
						<div class="head1">
							<img src="\assets\5.png" alt="Cannot load image data">
							<div>
								<h2>Add New Patient</h2>
								<p>Easily register a new patient at UPTOWN Dental Clinic. Enter their personal and medical details to get started with a personalized care plan.</p>
									<button class="new-patient-button">
										New Patient
										<i class="fas fa-arrow-right"></i> <!-- Arrow icon -->
									</button>
							</div>
						</div>
					</div>
				</div>


				<div class="info-data1">

					<div class="card">
						<div class="head1">
							<img src="\assets\6.png" alt="Cannot load image data">
							<div>
								<h2>Create A Note</h2>
								<p>Quickly document important details or updates for a patient at UPTOWN Dental Clinic. </p>
							</div>
							<button class="new-patient-button">
								<i class="fas fa-arrow-right"></i> <!-- Arrow icon -->
							</button>
							</div>
						</div>
					</div>
			</div>
	
			<div class="main-content-main-container">
                <div class="left-container">
                    <div class="welcome-dashboard-container">
                        <div class="welcome-dashboard-content-container">
							<div class="patient">
								<div>
									<h2>Recent Patient List</h2>
									<p>Show 10 Latest Patient</p>
								</div>
								<button>
									<i class="fas fa-eye"></i>
									View All Patients</button>
							</div>							
                            <table class="table table-hover1">
								<thead>
								  <tr>
									<th scope="col">#</th>
									<th scope="col">First Name</th>
									<th scope="col">Last Name</th>
									<th scope="col">Date</th>
									<th scope="col">Actions</th>
								  </tr>
								</thead>
								<tbody>
								  <tr>
									<th scope="row">1</th>
									<td>Mark</td>
									<td>Otto</td>
									<td>November 18, 2024 | 8:25am</td>
									<td>
										<button class="view-button">
											<i class="fas fa-eye"></i> View
										</button>
									</td>
								  </tr>
								  <tr>
									<th scope="row">2</th>
									<td>Jacob</td>
									<td>Thornton</td>
									<td>November 18, 2024 | 8:25am</td>
									<td>
										<button class="view-button">
											<i class="fas fa-eye"></i> View
										</button>
									</td>
								  </tr>
								  <tr>
									<th scope="row">3</th>
									<td>Larry the Bird</td>
									<td>Feather</td>
									<td>November 18, 2024 | 8:25am</td>
									<td>
										<button class="view-button">
											<i class="fas fa-eye"></i> View
										</button>
									</td>
								  </tr>
								  <tr>
									<th scope="row">4</th>
									<td>Larry the Bird</td>
									<td>Feather</td>
									<td>November 18, 2024 | 8:25am</td>
									<td>
										<button class="view-button">
											<i class="fas fa-eye"></i> View
										</button>
									</td>
								  </tr>
								  <tr>
									<th scope="row">5</th>
									<td>Larry the Bird</td>
									<td>Feather</td>
									<td>November 18, 2024 | 8:25am</td>
									<td>
										<button class="view-button">
											<i class="fas fa-eye"></i> View
										</button>
									</td>
								  </tr>
								  <tr>
									<th scope="row">6</th>
									<td>Larry the Bird</td>
									<td>Feather</td>
									<td>November 18, 2024 | 8:25am</td>
									<td>
										<button class="view-button">
											<i class="fas fa-eye"></i> View
										</button>
									</td>
								  </tr>
								  <tr>
									<th scope="row">7</th>
									<td>Larry the Bird</td>
									<td>Feather</td>
									<td>November 18, 2024 | 8:25am</td>
									<td>
										<button class="view-button">
											<i class="fas fa-eye"></i> View
										</button>
									</td>
								  </tr>
								  <tr>
									<th scope="row">8</th>
									<td>Larry the Bird</td>
									<td>Feather</td>
									<td>November 18, 2024 | 8:25am</td>
									<td>
										<button class="view-button">
											<i class="fas fa-eye"></i> View
										</button>
									</td>
								  </tr>
								  <tr>
									<th scope="row">9</th>
									<td>Larry the Bird</td>
									<td>Feather</td>
									<td>November 18, 2024 | 8:25am</td>
									<td>
										<button class="view-button">
											<i class="fas fa-eye"></i> View
										</button>
									</td>
								</tr>
								  <tr>
									<th scope="row">10</th>
									<td>Larry the Bird</td>
									<td>Feather</td>
									<td>November 18, 2024 | 8:25am</td>
									<td>
										<button class="view-button">
											<i class="fas fa-eye"></i> View
										</button>
									</td>
								  </tr>
								</tbody>
							  </table>
                        </div>
                    </div>
					<div>
                    
			</div>
		</main>
      
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>