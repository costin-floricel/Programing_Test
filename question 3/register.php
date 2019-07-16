<?php
$page_title = 'Register';

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('db_connect.php'); // Connect to the db.

	$errors = []; // Initialize an error array.

	// Check for the full name field:
	if (empty($_POST['fullname'])) {
		$errors[] = 'You forgot to enter your to enter your Full Name.';
	} else {
		$fn = $mysqli->real_escape_string(trim($_POST['fullname']));
    }
    
	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = $mysqli->real_escape_string(trim($_POST['email']));
	}

	// Check for a password and match against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$p = password_hash(trim($_POST['pass1']), PASSWORD_DEFAULT);
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
	}

	if (empty($errors)) { // If everything's OK.

		// Register the user in the database...

		// Make the query:
		$q = "INSERT INTO user (fullname, email, password) VALUES ('$fn', '$e', '$p')";
		$r = @$mysqli->query($q); // Run the query.
		if ($mysqli->affected_rows == 1) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
        <p>You are now registered.</p>';
        echo $fn;

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

			// Debugging message:
			echo '<p>' . $mysqli->error . '<br><br>Query: ' . $q . '</p>';

		} 
		$mysqli->close(); // Close the database connection.
		unset($mysqli);

		
	} else { // Report the errors.

		echo '<div class="container"><h1>Error!</h1>
		<p>The following error(s) occurred:<br></div>';
		foreach ($errors as $msg) { // Print each error.
			echo '<div class="container">'; 
			echo "- $msg<br>\n";
			echo '</div>';
		}
		echo '<div class="container"></p><p>Please try again.</p><p><br></p></div>';

	} // End of if (empty($errors)) IF.

		$mysqli->close(); // Close the database connection.
		unset($mysqli);

} // End of the main Submit conditional.
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Question 3</title>
	<style>
		body { margin: 0; padding: 20px 0; font-family: sans-serif; }
		.container { box-sizing: border-box; width: 750px; margin: 0 auto; padding: 0 15px; }
		@media (max-width: 767px) {
			.container { width: 100%; }
		}
	</style>
</head>
<body>
	<main class="container">
		<hr />
        <h1>Register</h1>
<form action="register.php" method="post">
	<p>Full Name: <input type="text" name="fullname" size="20" maxlength="20" value="<?php if (isset($_POST['fullname'])) echo $_POST['fullname']; ?>"></p>
	<p>Email Address: <input type="email" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" > </p>
	<p>Password: <input type="password" name="pass1" size="20" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" ></p>
	<p>Confirm Password: <input type="password" name="pass2" size="20" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" ></p>
	<p><input type="submit" name="submit" value="Register"></p>
</form>
<hr />		
	</main>
</body>
</html>
