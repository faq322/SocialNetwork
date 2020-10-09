<?php
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
$error_array = "";	//Hold erro messages

if (isset($_POST['register_button'])){

	//Registration form values

	//First name
	$fname = strip_tags($_POST['reg_fname']); //Remove html tags
	$fname = str_replace(' ', '', $fname);	//Remove spaces
	$fname = ucfirst(strtolower($fname));	//Convert letters to Lowercase and Capitalize only first letter

	//Last name
	$lname = strip_tags($_POST['reg_lname']); //Remove html tags
	$lname = str_replace(' ', '', $lname);	//Remove spaces
	$lname = ucfirst(strtolower($lname));	//Convert letters to Lowercase and Capitalize only first letter

	//Email
	$em = strip_tags($_POST['reg_email']); //Remove html tags
	$em = str_replace(' ', '', $em);	//Remove spaces
	$em = ucfirst(strtolower($em));	//Convert letters to Lowercase and Capitalize only first letter

	//Email 2
	$em2 = strip_tags($_POST['reg_email2']); //Remove html tags
	$em2 = str_replace(' ', '', $em2);	//Remove spaces
	$em2 = ucfirst(strtolower($em2));	//Convert letters to Lowercase and Capitalize only first letter

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
		}else {
			echo "Invalid email format";
		}
	} else {
		echo "Emails dont match";
	}
}



?>



<html>
<head>
	<title>Social Network: Registration</title>
</head>
<body>

	<form action="register.php" method="POST">
		<input type="text" name="reg_fname" placeholder="First Name" required>
		<br>
		<input type="text" name="reg_lname" placeholder="Last Name" required>
		<br>
		<input type="email" name="reg_email" placeholder="E-mail" required>
		<br>
		<input type="email" name="reg_email2" placeholder="Confirm E-mail" required>
		<br>
		<input type="password" name="reg_password" placeholder="Password" required>
		<br>
		<input type="password" name="reg_password" placeholder="Confirm Password" required>
		<br>
		<input type="submit" name="register_button" value="Register">

	</form>

</body>
</html>