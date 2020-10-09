<?php
$dbname = "socialnetwork";
$tablename = "test";

$con = mysqli_connect("localhost", "root", "", $dbname);

if (mysqli_connect_errno()) {
	echo "Failed to connect: " . mysqli_connect_errno();
}

$query = mysqli_query($con, "INSERT INTO test VALUES(NULL, 'Igor')");

?>



<!DOCTYPE html>
<html>
<head>
	<title>Social Network</title>
</head>
<body>
Hello igor!s
</body>
</html>