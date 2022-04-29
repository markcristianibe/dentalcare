<?php

$hostname = "localhost";
$db_usrname = "root";
$db_pswd = "";
$db_name = "db_dentalclinic";

$conn = mysqli_connect($hostname, $db_usrname, $db_pswd, $db_name);
if ($conn->connect_errno > 0) 
{
	die("UNABLE TO CONNECT SERVER: [".$conn->connect_error."]");
}
?>