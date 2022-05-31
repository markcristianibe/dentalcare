<?php

$hostname = "localhost";
$db_usrname = "id18995739_db_dentalclinicadmin";
$db_pswd = "SRjzZeD\9/#3g*~!";
$db_name = "id18995739_db_dentalclinic";

$conn = mysqli_connect($hostname, $db_usrname, $db_pswd, $db_name);
if ($conn->connect_errno > 0) 
{
	die("UNABLE TO CONNECT SERVER: [".$conn->connect_error."]");
}
?>