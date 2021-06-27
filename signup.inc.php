<?php
if (isset($_POST['register-submit'])){

require 'dbh.inc.php';

$stname =  $_POST['1stname'];
$ndname =  $_POST['2ndname'];
$rdname =  $_POST['3rdname'];
$username= $_POST['username'];
$email =  $_POST['email'];
$phnno = $_POST['phnno'];
$pswd = $_POST['pswd'];

if(empty($stname) ||empty($ndname) ||empty($rdname) ||empty($username) ||empty($stname) ||empty($phnno) ||empty($pswd)){
	header("location: ../register.php?error=emptyfields&1stname=".$stname."&2ndname=".$ndname."&3rdname=".$rdname."&username=".$username."&email=".$email."&phnno=".$phnno);
	exit();
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && (!preg_match("/^[a-zA-Z0-9]*$/", $username))) {
	header("location: ../register.php?error=invalidemailusername&1stname=".$stname."&2ndname=".$ndname."&3rdname=".$rdname."&phnno=".$phnno);
	exit();
}
else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	header("location: ../register.php?error=invalidemail&1stname=".$stname."&2ndname=".$ndname."&3rdname=".$rdname."&username=".$username."&phnno=".$phnno);
	exit();
}
else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
	header("location: ../register.php?error=invalidusername&1stname=".$stname."&2ndname=".$ndname."&3rdname=".$rdname."&email=".$email."&phnno=".$phnno);
	exit();
}
else {

	$sql = "SELECT username FROM members WHERE username=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../register.php?error=sqlerror");
		exit();
	}
	else {
		mysqli_stmt_bind_param(	$stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$resultcheck = mysqli_stmt_num_rows($stmt);
		if ($resultcheck > 0) {
			header("location: ../register.php?error=usernametaken&1stname=".$stname."&2ndname=".$ndname."&3rdname=".$rdname."&email=".$email."&phnno=".$phnno);
			exit();
		}
		else {
			$sql = " INSERT INTO members (1stname, 2ndname, 3rdname, username, email, phoneno, pswd)
			VALUES (?, ?, ?, ?, ?, ?, ?)";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("location: ../register.php?error=sqlerror");
				exit();
			}
			else {

      $hashedpwd = password_hash($pswd, PASSWORD_DEFAULT);

				mysqli_stmt_bind_param(	$stmt, "sssssss", $stname	,	$ndname, $rdname	, $username,	$email, $phnno,	$hashedpwd);
				mysqli_stmt_execute($stmt);
				header("location: ../register.php?signupsuccess=success");
				exit();
			}

		}
	}
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
}

else {
	header("location: ../register.php");
	exit();
}

/*
$sql =   " INSERT INTO members (1stname, 2ndname, 3rdname, username, email, phoneno, pswd)
VALUES ('$stname', '$ndname', '$rdname', '$username', '$email', '$phnno', '$pswd');   ";
mysqli_query($conn, $sql);

header("location: ../register.php?signup=success");
//holds the link between the front end and saving user data to the database*/


/*$pswd == $password ;
   function checkPassword(string $password) {
$conditions = ["minimumChars" => 8,"specialChars" => 1, "upperCase" => 1];
$error = 0;
    if(strlen($password) < $conditions["minimumChars"]) {
        $error++;
    }
    if(preg_match_all("/[A-Z]/", $password) < $conditions["upperCase"] ) {
        $error++;
    }
    if(preg_match_all('/\X/u', $password) < $conditions["specialChars"]) {
        $error++;
    }

if ($error <= 1) {
    return true;
} else {
    return false;
}
}

?>*/
