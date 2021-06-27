<?php
//holds data base credentials
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "assignmentwebsite";

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

//this checks if the connection works if it does not it will give this report
if (!$conn){
	die("connection failed: ".mysqli_connect_error());
}
