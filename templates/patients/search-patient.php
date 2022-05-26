<?php
include("../../server/db_connection.php");

$search = mysqli_real_escape_string($conn, $_POST["search"]);
$sql = "SELECT * FROM tbl_patientinfo WHERE CONCAT(Firstname , Lastname) LIKE '%$search%' OR CONCAT('PID-', DATE_FORMAT(Date_Registered, '%y%m'), '-', Patient_ID) LIKE '%$search%'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        $rawDate = date_create($row["Date_Registered"]);
        $dateRegistered = date_format($rawDate, "ym");
        $pid = "PID-" . $dateRegistered . "-" . $row["Patient_ID"];
        ?>
        <tr>
        <th scope='row'><?php echo $pid; ?></th>
        <td><?php echo $row["Firstname"] . " " . $row["Lastname"]; ?></td>
        <td><?php echo $row["Address"]; ?></td>
        <td><?php echo $row["Contact"]; ?></td>
        <td>
            <a href='homepage.php?page=patient-record&id=<?php echo $row["Patient_ID"]; ?>' class='circle btn btn-primary'><i class="fa fa-clipboard"></i></a>
            <a href='homepage.php?page=patient-info&id=<?php echo $row["Patient_ID"]; ?>' class='circle btn btn-success'><i class="fa fa-pen"></i></a>
            <a href='#' class='circle btn btn-danger' data-bs-toggle='modal' data-bs-target='#delete-patient-msgBox' onclick='showDialog(<?php echo $row["Patient_ID"]; ?>, "<?php echo $row["Firstname"] . " " . $row["Lastname"]; ?>")'><i class="fa fa-trash"></i></a>
        </td>
        <?php
    }
}
else{
    echo "No results Found";
} 
?>