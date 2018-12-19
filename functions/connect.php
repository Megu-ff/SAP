<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'forumdb';
$con = mysqli_connect($server, $username, $password, $database);
if(!$con){
    exit('Error: could not establish database connection.');
}
if(!mysqli_select_db($con, $database)){
    exit('Error: could not select the database');
}
?>