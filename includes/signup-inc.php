<?php

if (isset($_POST['submit'])){
	
	include_once 'dbh-inc.php';
	
	
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	
	/*
	$username = $_POST['username'];
	$email = $_POST['email'];
	$pwd = $_POST['pwd'];
	*/

	
	if(empty($username) || empty($email) || empty($pwd)){
		header("Location: ../signup.php?signup=empty");
		exit();
	}
	else{
		//check if input characters are valid
		if(!ctype_alnum($username)){
			header("Location: ../signup.php?signup=invalid username");
			exit();
		}
		//check if email is valid
		else{
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				header("Location: ../signup.php?signup=invalid email");
				exit();
			}
			else{
				$sql = "SELECT * FROM users WHERE user_name='$username'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				
				if ($resultCheck > 0){
					header("Location: ../signup.php?signup=username taken");
					exit();
				}
				else{
/*
					//HASHING
					$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          echo $hashedPwd;
          exit();
*/
					//INSERT 
					$query = "INSERT INTO users (user_name, user_email, user_password) VALUES ('$username', '$email', '$pwd');";
					
					mysqli_query($conn, $query);
					header("Location: ../login.php?signup=success");
					exit(); 
				}
			}
		}
	}
}

else{
	header("Location: ../index.php");
	exit();
}
?>