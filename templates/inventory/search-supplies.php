<?php
include("../../server/db_connection.php");
$search = mysqli_real_escape_string($conn, $_POST["search"]);
$category = mysqli_real_escape_string($conn, $_POST["category"]);
$sql = "";
if($search != "" && $category == "All")
{
    $sql = "SELECT * FROM tbl_supplies WHERE Product_Name LIKE '%$search%'";
}
else if($search == "" && $category != "All")
{
    $sql = "SELECT * FROM tbl_supplies WHERE Category = '$category'";
}
else if($search != "" && $category != "All")
{
    $sql = "SELECT * FROM tbl_supplies WHERE Product_Name LIKE '%$search%' AND Category = '$category'";
}
else
{
    $sql = "SELECT * FROM tbl_supplies";
}

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0)
{
    $count = 1;
    while ($spl = mysqli_fetch_array($result))
     {
        ?>
        <tr>
        <th scope='row'><?php echo $count++; ?></th>
        <td><?php echo $spl["Product_Name"]; ?></td>
        <td><?php echo number_format($spl["Stocks"]); ?></td>
        <td>
            <a href='#' class='circle btn btn-primary'  data-bs-toggle='modal' data-bs-target='#add-stocks-modal' onclick="addStocks(<?php echo $spl['Product_ID']; ?>)"><i class="fa fa-plus"></i></a>
            <a href='#' class='circle btn btn-success'  data-bs-toggle='modal' data-bs-target='#edit-supplies-modal' onclick="editSupply(<?php echo $spl['Product_ID']; ?>)"><i class="fa fa-pen"></i></a>
            <a href='#' class='circle btn btn-danger' onclick='deleteSupply(<?php echo $spl["Product_ID"]; ?>)'><i class="fa fa-trash"></i></a>
         </td>
        </tr>
        <?php
    }
}
else
{
    echo "<tr>
    <th colspan='5'>No Results Found...</th>
    </tr>";
}
?>