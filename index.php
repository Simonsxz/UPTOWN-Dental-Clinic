<?php
include ("../UPTOWN-Dental-Clinic/functions/db_conn.php");
session_start();
if (isset($_SESSION['user_ID'])) {
    // Unset session and redirect to dashboard if already logged in
    session_unset();
    session_destroy();
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/login_style.css">
	<link rel="icon" type="image/x-icon" href="/assets/uptownlogo.png">
	<title>Login</title>
</head>
<body>
	<div class="main-container">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<div class="container">
		<form action="index.php" method="POST" autocomplete="off">
			<img src="/assets/uptownlogo.png" class="uplogo" alt="Aladin's Aviary">
			<h1 class="login-header">Welcome!</h1>
			<p class="login-description">Please enter your user credentials!</p>

			<input type="text" placeholder="Username" name="username" autocomplete="off" required>
			<input type="password" placeholder="Password" name="password" id="password" autocomplete="off" required>
			<div class="checkbox-container">
			<?php
				// Check if the form is submitted
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					$username = $_POST['username'];
					$password = $_POST['password'];

					// Prepare SQL query to check username
					$sql = "SELECT user_ID, user_userName, user_password, user_role FROM tbl_useraccount WHERE user_userName = ?";
					$stmt = mysqli_prepare($conn, $sql);
					mysqli_stmt_bind_param($stmt, "s", $username);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);

					if (mysqli_stmt_num_rows($stmt) > 0) {
						// Fetch the result
						mysqli_stmt_bind_result($stmt, $userID, $dbUsername, $dbPassword, $userRole);
						mysqli_stmt_fetch($stmt);

						// Verify the password
						if (password_verify($password, $dbPassword)) {
							session_start();  // Start the session here
							$_SESSION['user_ID'] = $userID;  // Store user ID in session
							$_SESSION['username'] = $dbUsername;
							$_SESSION['role'] = $userRole;

							// Redirect to dashboard or home page
							header("Location: php/splashscreen.html");
							exit();
						} else {
							// Incorrect password, show an error
							echo "<script>
								Swal.fire({
									icon: 'error',
									title: 'Incorrect Password!',
									text: 'Please try again.',
									confirmButtonText: 'OK'
								}).then(() => {
									window.history.back();
								});
							</script>";
						}
					} else {
						// User not found, show a warning
						echo "<script>
							Swal.fire({
								icon: 'warning',
								title: 'User Not Found!',
								text: 'Please check your credentials.',
								confirmButtonText: 'OK'
							}).then(() => {
								window.history.back();
							});
						</script>";
					}

					mysqli_stmt_close($stmt);
				}


				?>



				<div class="remember-me-container">
					<input type="checkbox" id="show-password-cb" name="show-password-cb" class="show-password-cb" onchange="showPassword()"/>
					<label for="show-password-cb" class="account-default-label">Show Password</label>
				</div>
				<br>
				<a href="php/forgot.php" class="forgot-pass-btn">Forgot Password?</a>
			</div>
			<button type="submit" class="btn btn-login">Submit</button>
		</form>
                <div class="main-separator-container">
                  
		</div>
	</div>
</body>
<script src="/js/login-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
