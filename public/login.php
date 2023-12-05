
<?php

		//session_start();
		// Checks session to see if a username is defined
		if(isset($_SESSION['username'])) {
			echo "Logged in as ". $_SESSION['username'];
		} else {
			// Database connection hosted outside the publicly avaialable directory.
			require('../config/db_connect.php');
			// If there is a POST, then we will try to login.
			if($_SERVER["REQUEST_METHOD"]=="POST") {
				$username = $_POST['username'];
				$password = $_POST['password'];
				if(empty($username) || empty($password)) {
					echo "Neither the username nor the password field can be left blank.";
				} else {
					// Query the db for the username, $row = the row of the database containing that username
					$row = query_db('username', $username, $db);
					// If the entered username matches the stored username in the database, continue.
					if(!empty($row)) {
						// Check passwords match
						$stored_password = $row[0]['password'];

						//if the entered $password matches the $stored_password, continue.
						if(password_verify($password,$stored_password)) {
							// set session username to stored username to tell the browser we are logged in.
							// Should maybe refresh or redirect the webpage.
							$_SESSION['username'] = $username;
							$_SESSION['role'] = $row[0]['role'];
							$_SESSION['user_id'] = $row[0]['userID'];
							header('location:index.php?=home');
						} else {
							echo '<script>alert("Passwords do not match.");</script>';
						}
					}
				}
			} else {
			?>
			<div class="container mt-3" id="log">
				<form action="index.php?page=login" class="was-validated" method="post">
				<fieldset style="border: 1px solid black;border-radius:10px;background-color:bisque;">
					<h2 style="margin:15px;text-align:center;">Login</h2>
					  <div class="mb-3 mt-3" style="margin:15px;width:75%;">
						<label for="username" class="form-label">Username:</label>
						<input type="text" class="form-control" id="username" style="border:2px solid black;border-radius:3px;" placeholder="Enter username" name="username" required>
						<div class="invalid-feedback">Please fill out this field.</div>
					  </div>
				  <div class="mb-3" style="margin:15px;width:75%;">
					<label for="password" class="form-label">Password:</label>
					<input type="password" class="form-control" id="password" style="border:2px solid black;border-radius:3px;" placeholder="Enter password" name="password" required>
					<div class="invalid-feedback">Please fill out this field.</div>
				</div>
				<a href="index.php?page=createanaccount" style="margin:15px;">Create an Account</a><br><br>
				  <button type="submit" class="btn btn-primary text-white" href="index.php?page=home" style="margin:15px;background:#d52349;width:18%;font-size:1.0em;">Login</button>
			</fieldset>
			</form>
		</div>
			<?php
			}
			// Close Database Connection.
			$db=null;
		}
		// Query the database for column, value of that column, and the database connection.
		function query_db($column, $variable, $db) {
			$sql = "SELECT * FROM users WHERE $column = :variable";
			$sql_statement = $db->prepare($sql);
			$sql_statement->bindParam(':variable', $variable);

			// Execute the prepared statement
			$sql_statement->execute();

			// Fetch the rows into an array
			$rows = $sql_statement->fetchAll(PDO::FETCH_ASSOC);
			$row_count = count($rows);

			if ($row_count > 0) {
				return $rows;
			} else {
				return [];
			}
		}
	?>