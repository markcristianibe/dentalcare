<?php
include("db_connection.php");

$sql = "SELECT * FROM tbl_patientinfo WHERE CONCAT(Firstname , Lastname) LIKE '%$request%' OR CONCAT('PID-', DATE_FORMAT(Date_Registered, '%y%m'), '-', Patient_ID) LIKE '%$request%'";

$result = mysqli_query($connect, $query);

$data = array();

if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_assoc($result))
 {
  $data[] = $row["name"];
 }
 echo json_encode($data);
}
?>