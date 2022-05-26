<?php
include("../../server/db_connection.php");

$name = $_POST["name"];

$sql = "SELECT * FROM tbl_usr WHERE CONCAT(Firstname, ' ', Lastname) LIKE '%$name%' OR Username LIKE '%$name%'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_array($result))
    {
        if($row["UserID"] == 1)
        {
            echo "
            <tr>
                <th scope='row'>". $row["Username"] ."</th>
                <td>". $row["Lastname"] . " " . $row["Firstname"] ."</td>
                <td>
                <a href='#' class='circle btn btn-success'><i class='fa fa-pen'></i></a>
                <a href='#' class='circle btn btn-danger disabled'><i class='fa fa-trash'></i></a>
                </td>
            </tr>
            ";
        }
        else
        {
            echo "
            <tr>
                <th scope='row'>". $row["Username"] ."</th>
                <td>". $row["Lastname"] . " " . $row["Firstname"] ."</td>
                <td>
                <a href='#' class='circle btn btn-success'><i class='fa fa-pen'></i></a>
                <a href='#' class='circle btn btn-danger' onclick='deleteAccount(". $row["UserID"] .")'><i class='fa fa-trash'></i></a>
                </td>
            </tr>
            ";
        }
    }
}
else
{
    echo "
    <tr>
        <th scope='row' colspan='3'>No Results Found</th>
    </tr>
    ";
}
?>