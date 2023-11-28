
<?php
		if(isset($_SESSION['username'])) {
			echo "Logged in as ". $_SESSION['username'];
		} else {
		// Check if POST then handle the posted information.
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Database connection hosted outside the publicly avaialable directory.
			require('../config/db_connect.php');
			// username and email to check if there are accounts already attached to them.
			$username = $_POST['username'];
			$email = $_POST['email'];
			// If the query_db returns more than 0 rows for the queried username, pass our error alert.
			if(count(query_db('username', $username, $db)) > 0) {
				echo"<script>alert(\"The username: $username has already been taken.\")</script>";
			} else {
				// If the query_db returns more than 0 rows for the queried email, pass our error alert.
				if(count(query_db('email', $email, $db)) > 0) {
				echo "<script>alert(\"The username: $email has already been taken.\")</script>";
				}
				// Create account if neither username or email exist.
				else {
				create_account($db);
				}
			}
			// Close database connection.
			$db=null;
		} else ?>
<div class="container mt-3" id="create">
  	<form action="index.php?page=createanaccount" method="post">
		<fieldset style="border: 1px solid black;border-radius:10px;background-color:bisque;">
	  		<h2 style="margin:10px;text-align:center;">Create Account</h2>
    			<div class="mb-3 mt-3" style="margin:10px;width:75%;">
      				<label for="firstName">First Name:</label>
      				<input type="text" class="form-control" id="firstName" style="border:2px solid black;border-radius:3px;" placeholder="Enter First Name" name="firstName" required>
    			</div>
    			<div class="mb-3 mt-3" style="margin:10px;width:75%;">
      				<label for="lastName">Last Name:</label>
      				<input type="text" class="form-control" id="lastName" style="border:2px solid black;border-radius:3px;" placeholder="Enter Last Name" name="lastName" required>
    			</div>
        		<div class="mb-3" style="margin:10px;width:75%;">
      				<label for="email">Email:</label>
      				<input type="email" class="form-control" id="email" style="border:2px solid black;border-radius:3px;" placeholder="Enter Email" name="email" required>
    			</div>
				<div class="mb-3" style="margin:10px;width:75%;">
      				<label for="username">Username:</label>
      				<input type="text" class="form-control" id="username" style="border:2px solid black;border-radius:3px;" placeholder="Enter Username" name="username" required>
    			</div>
        		<div class="mb-3" style="margin:10px;width:75%;">
      				<label for="password">Password:</label>
      				<input type="password" class="form-control" id="password" style="border:2px solid black;border-radius:3px;" placeholder="Enter Password" name="password" required>
    			</div>
    		<!--<button type="submit" class="btn btn-danger text-white" href="index.php?page=login" style="margin:15px;width:18%;font-size:0.9em;">Login</button-->
			<input type="submit" style="margin:15px;width:18%;font-size:1.0em;" value="Register">
		</fieldset>
	</form>
	<?php
	}
		// Method to insert the newly registered account into the database.
		function create_account($db) {
			// Set all the variables from the server POST.
			$username = $_POST['username'];
			$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$email = $_POST['email'];

			//Define the SQL statement and format the values, suppose to help protect against SQL Injection.
			$sql = "INSERT INTO users (username, password, firstName, lastName, email) VALUES (:username, :password, :firstName, :lastName, :email)";
			$sql_statement = $db->prepare($sql);
			$sql_statement->bindParam(':username', $username);
			$sql_statement->bindParam(':password', $password);
			$sql_statement->bindParam(':firstName', $firstName);
			$sql_statement->bindParam(':lastName', $lastName);
			$sql_statement->bindParam(':email', $email);

			// Error handling
			try {
				if ($sql_statement->execute()) {
					echo "Account creation successful!";
					// Should send the credentials through post to the login page.
				} else {
					echo "Data insertion failed. Error: " . implode(", ", $sql_statement->errorInfo());
				}
			} catch (PDOException $e) {
				$error_info = $sql_statement->errorInfo();
				$error_code = $error_info[0];
				// It should never make it this far as our required fields are checked before calling this method.
				switch ($error_code) {
					case '23000':
							echo '<script>alert("The username or email address is already taken")</script>';
						break;
					default:
						echo "ERROR CODE:".$error_code;
						break;
				}
				echo "An error occurred: " . $e->getMessage();
			}
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
</div>