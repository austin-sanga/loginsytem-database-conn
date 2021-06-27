<?php

if (isset($_POST['login-submit'])){

	require 'dbh.inc.php';

	$emailid = $_POST['mailuid'];
	$password = $_POST['pswd'];

	if (empty($emailid) || empty($password)) {
		header("location: ../index.php?error=emptyfields");
		exit();
	}
	else {
		$sql = "SELECT * FROM members WHERE username=? OR email=?;";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("location: ../index.php?error=sqlerror");
			exit();
		}
		else {

			mysqli_stmt_bind_param($stmt, "ss",$emailid, $emailid );
			mysqli_stmt_execute($stmt);
			$results = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($results)) {
    	$pwdcheck = password_verify($password, $row['pswd']);
			if ($pwdcheck == false) {
				header("location: ../index.php?error=wrongpassword");
				exit();
			}
			else if ($pwdcheck == true) {
     session_start();
			$_SESSION['userid'] = $row['user_count'];
				$_SESSION['username'] = $row['username'];

				header("location: ../index.php?login=success");
				exit();
			}
			else {
				header("location: ../index.php?error=wrongpassword");
				exit();
			}
    }
		else {
			header("location: ../index.php?error=nouser");
			exit();
		}

		}
	}

}
else {
		header("location: ../index.php");
		exit();
}
