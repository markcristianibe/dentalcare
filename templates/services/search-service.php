
<?php
include("../../server/db_connection.php");

$search = mysqli_real_escape_string($conn, $_POST["search"]);
$category = mysqli_real_escape_string($conn, $_POST["category"]);

if($category == "Select Service Category...")
{
    $sql = "SELECT * FROM tbl_services WHERE Service_Description LIKE '%$search%'";
}
else
{
    $sql = "SELECT * FROM tbl_services WHERE Service_Description LIKE '%$search%' AND Category = '$category'";
}
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0)
{
    $count = 1;
    while ($service = mysqli_fetch_assoc($result))
    {
        ?>
        <tr>
        <th scope='row'><?php echo $count++; ?></th>
        <td><?php echo $service["Service_Description"]; ?></td>
        <td>₱<?php echo number_format($service["Charge"]); ?></td>
        <td>
            <a href='#' class='circle btn btn-success'  data-bs-toggle='modal' data-bs-target='#edit-service-modal' onclick='showEditDialog(<?php echo $service["Service_ID"]; ?>)'><i class="fa fa-pen"></i></a>
            <a href='#' class='circle btn btn-danger' data-bs-toggle='modal' data-bs-target='#delete-service-msgBox' onclick='showDialog(<?php echo $service["Service_ID"]; ?>, "<?php echo $service["Service_Description"]; ?>")'><i class="fa fa-trash"></i></a>
        </td>
        </tr>
        <?php
    }
}
else
{
    echo "No results Found";
} 
?>