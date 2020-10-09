<?php
session_start();
$dbname = "socialnetwork";
$tablename = "test";

$con = mysqli_connect("localhost", "root", "", $dbname);

if (mysqli_connect_errno()) {
	echo "Failed to connect: " . mysqli_connect_errno();
}

//Declaring variables to prevent errors
$fname = "";	//First Name
$lname = "";	//Last Name
$em = "";		//Email
$em2 = "";		//Email2
$password = "";	//Password
$password2 = "";//Password2
$date = "";		//Sing up Date
$error_array = array();	//Hold erro messages

if (isset($_POST['register_button'])){

	//Registration form values

	//First name
	$fname = strip_tags($_POST['reg_fname']); //Remove html tags
	$fname = str_replace(' ', '', $fname);	//Remove spaces
	$fname = ucfirst(strtolower($fname));	//Convert letters to Lowercase and Capitalize only first letter
	$_SESSION['reg_fname'] = $fname; //Stores variable in session variable

	//Last name
	$lname = strip_tags($_POST['reg_lname']); //Remove html tags
	$lname = str_replace(' ', '', $lname);	//Remove spaces
	$lname = ucfirst(strtolower($lname));	//Convert letters to Lowercase and Capitalize only first letter
	$_SESSION['reg_lname'] = $lname; //Stores variable in session variable

	//Email
	$em = strip_tags($_POST['reg_email']); //Remove html tags
	$em = str_replace(' ', '', $em);	//Remove spaces
	$em = ucfirst(strtolower($em));	//Convert letters to Lowercase and Capitalize only first letter
	$_SESSION['reg_email'] = $em; //Stores variable in session variable

	//Email 2
	$em2 = strip_tags($_POST['reg_email2']); //Remove html tags
	$em2 = str_replace(' ', '', $em2);	//Remove spaces
	$em2 = ucfirst(strtolower($em2));	//Convert letters to Lowercase and Capitalize only first letter
	$_SESSION['reg_email2'] = $em2; //Stores variable in session variable

	//Password
	$password = strip_tags($_POST['reg_password']); //Remove html tags
	$password2 = strip_tags($_POST['reg_password2']); //Remove html tags

	//Date
	$date = date("Y-m-d"); //Current date

	if ($em == $em2) {
		//check if email is in valid format
		if(filter_var($em, FILTER_VALIDATE_EMAIL)){
			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			//Check if email already exists
			$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

			//Count number of rows returned
			$num_rows = mysqli_num_rows($e_check); 

			if ($num_rows > 0){
				array_push($error_array, "Email is already in use<br>");
			} 
		}else {
			array_push($error_array, "Invalid email format<br>");
		}
	} else {
		array_push($error_array, "Emails dont match<br>");
	}


	if(strlen($fname) > 25 || strlen($fname) < 2){
		array_push($error_array, "Your first name must be between 2 and 25 chars<br>");
	}

	if(strlen($lname) > 25 || strlen($fname) < 2){
		array_push($error_array, "Your last name must be between 2 and 25 chars<br>");
	}

	if($password != $password2){
		array_push($error_array, "Your passwords doesnt match<br>");
	}else {
		if (preg_match('/[^A-Za-z0-9]/', $password)) {
			array_push($error_array, "Your password can only contain English chars or nums<br>");
		}
	}

	if(strlen($password) > 30 || strlen($password) < 5) {
		array_push($error_array, "Your password must be between 5 and 30 chars<br>");
	}

	if(empty($error_array)){
		$password = md5($password); //Encrypts password

		//Generate username by concatenating first name and last name
		$username = strtolower($fname . "_" . $lname);
		$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

		$i = 0;
		//if username exists add number to username
		while(mysqli_num_rows($check_username_query) != 0) {
			$i++;
			$username = $username . "+" . $i;
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
		}

		//Profile picture assignment
		$rand = rand(1, 2);

		if ($rand == 1)
			$profile_pic = "assets/images/profile_pics/defaults/head_red.png";
		else if ($rand == 2)
			$profile_pic = "assets/images/profile_pics/defaults/head_green_sea.png";



	}



}



?>



<html>
<head>
	<title>Social Network: Registration</title>
</head>
<body>

	<form action="register.php" method="POST">
		<input type="text" name="reg_fname" placeholder="First Name" value="<?php 
			if(isset($_SESSION['reg_fname'])) {
				echo $_SESSION['reg_fname'];
			}
		?>"required>
		<br>
		<?php if(in_array("Your first name must be between 2 and 25 chars<br>", $error_array)) echo "Your first name must be between 2 and 25 chars<br>"; ?>

		<input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
			if(isset($_SESSION['reg_lname'])) {
				echo $_SESSION['reg_lname'];
			}
		?>"required>
		<br>
		<?php if(in_array("Your last name must be between 2 and 25 chars<br>", $error_array)) echo "Your last name must be between 2 and 25 chars<br>"; ?>

		<input type="email" name="reg_email" placeholder="E-mail" value="<?php 
			if(isset($_SESSION['reg_email'])) {
				echo $_SESSION['reg_email'];
			}
		?>"required>
		<br>

		<input type="email" name="reg_email2" placeholder="Confirm E-mail" value="<?php 
			if(isset($_SESSION['reg_email'])) {
				echo $_SESSION['reg_email2'];
			}
		?>"required>
		<br>
		<?php if(in_array("Email is already in use<br>", $error_array)) echo "Email is already in use<br>"; 
		else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
		else if(in_array("Emails dont match<br>", $error_array)) echo "Emails dont match<br>"; ?>

		<input type="password" name="reg_password" placeholder="Password" required>
		<br>
		<input type="password" name="reg_password2" placeholder="Confirm Password" required>
		<br>
		<?php if(in_array("Your passwords doesnt match<br>", $error_array)) echo "Your passwords doesnt match<br>"; 
		else if(in_array("Your password must be between 5 and 30 chars<br>", $error_array)) echo "Your password must be between 5 and 30 chars<br>";
		else if(in_array("Your password can only contain English chars or nums<br>", $error_array)) echo "Your password can only contain English chars or nums<br>"; ?>

		<input type="submit" name="register_button" value="Register">

	</form>

</body>
</html>