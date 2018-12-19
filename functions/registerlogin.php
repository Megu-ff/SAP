<?php
session_start();

//initialise variables
$username="";
$email="";
$errors=array();

$db=mysqli_connect('localhost', 'root', '', 'forumdb');

//register user
if (isset($_POST['registeruser'])){
    //receive input values from form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email=mysqli_real_escape_string($db, $_POST['email']);
    $pass1=mysqli_real_escape_string($db, $_POST['pass1']);
    $pass2=mysqli_real_escape_string($db, $_POST['pass2']);

    //form validation, push errors into $errors array
    if (empty($username)){
        array_push($errors, "Username is required.");
    }
    if (empty($email)){
        array_push($errors, "Email is required.");
    }
    if (empty($pass1)){
        array_push($errors, "Password is required.");
    }
    if(strlen($pass1)<8){
        array_push($errors, "Password must be at least 8 characters long.");
    }
    if ($pass1!=$pass2){
        array_push($errors, "The two passwords must match.");
    }


    //check for existing username or email
    /*
    $user_check_query="SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user=mysqli_fetch_assoc($result);
    */

    $stmt=$db->prepare("SELECT * FROM users WHERE username = ? OR email =? LIMIT 1");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user=$result->fetch_assoc();
    $stmt->close();

    //If either already exists
    if ($user){
        if ($user['username'] === $username){
            array_push($errors, "Username already exists.");
        }
        if($user['email'] === $email){
            array_push($errors, "Email already exists.");
        }
    }
    //If neither already exist, register user
    if (count($errors) == 0){
        $password=password_hash($pass1, PASSWORD_BCRYPT);
        /*
        $query="INSERT INTO users (username, email, password, user_level)
        VALUES('$username', '$email', '$password', '0')";
        mysqli_query($db, $query);
        */

        $stmt=$db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();
        $stmt->close();
        $stmt=$db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();
        $stmt->close();
        $_SESSION['user_id']=$row['user_id'];
        $_SESSION['username']=$row['username'];
        $_SESSION['user_level']=$row['user_level'];
        $_SESSION['success']="You are now logged in.";
        header('location: index.php');
    }
}

//login
if (isset($_POST['loginuser'])){
    $username=mysqli_real_escape_string($db, $_POST['username']);
    $password=mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)){
        array_push($errors, "Username is required.");
    }
    if (empty($password)){
        array_push($errors, "Password is required.");
    }

    if (count($errors)==0){
        $stmt=$db->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result=$stmt->get_result();
        /*
        $query="SELECT * FROM users WHERE username='$username'";
        $result=mysqli_query($db, $query);
        */
        if (mysqli_num_rows($result)==1){
            //$row=mysqli_fetch_assoc($result);
            $row=$result->fetch_assoc();
            if (password_verify($password, $row['password'])){
                $_SESSION['user_id']=$row['user_id'];
                $_SESSION['username']=$row['username'];
                $_SESSION['user_level']=$row['user_level'];
                $_SESSION['success']="You are now logged in.";
                header('location: index.php');
            } else{
                array_push($errors, "Username and/or password incorrect.");
            }
        } else{
            array_push($errors, "Username and/or password incorrect.");
        }
    }
}

?>