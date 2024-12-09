<?php include "functions/db_conn.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/login_style.css">
	<link rel="icon" type="image/x-icon" href="\assets\uptownlogo.png">
	<title>Login</title>
</head>
<body>
	<div class="main-container">
		<div class="container">
			<form action="index.php" method="POST" autocomplete="">
				<img src="\assets\uptownlogo.png" class="uplogo" alt="Aladin's Aviary">
				<h1 class="login-header">Welcome!</h1>
				<p class="login-description">Please enter your user credentials!</p>

				<input type="username" placeholder="Username" name="email" autocomplete="off" required>
				<input type="password" placeholder="Password" name="password" id="password" autocomplete="off" required>
				<span class="checkbox-container">
                    <div class="remember-me-container">
					    <input type="checkbox" id="show-password-cb" name="show-password-cb" class="show-password-cb" onchange="showPassword()"/>
					    <label for="show-password-cb" class="account-default-label">Show Password</label>
                    </div>
                    <br>
                    <a href="forgot-password.php" class="forgot-pass-btn">Forgot Password?</a>
                </span>
				<!-- Make the submit button a link to splashscreen.html -->
				<a href="/php/splashscreen.html" class="btn btn-login" role="button">Submit</a>
                <div class="main-separator-container">
                  
		</div>
	</div>
</body>
<script src="/js/login-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</html>
