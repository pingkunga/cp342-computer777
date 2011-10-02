<?php
// Login
$dbuser="project";
$dbpass="202533";
$db="localhost/XE";
// extract all the form fields and store them in variables
$username=$_POST['username'];
$password=$_POST['password'];
$remember=$_POST['remember'];
//Connect to DB
$connect = OCILogon($dbuser,$dbpass,$db);
if (!$connect) {
echo "An error has occured connecting to the database";
exit();
} else {
echo "It's work";
}
?>