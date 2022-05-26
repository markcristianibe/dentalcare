<?php
include("../../server/db_connection.php");
$search = mysqli_real_escape_string($conn, $_POST["search"]);
$sql = "SELECT Product_ID, CONCAT(Brand, ' ', Name, ' ', Unit) AS Product_Name FROM tbl_medications WHERE CONCAT(Brand, ' ', Name, ' ', Unit) LIKE '%$search%'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0)
{
    $count = 1;
    while ($med = mysqli_fetch_array($result))
     {
        ?>
        <tr>
        <th scope='row'><?php echo $count++; ?></th>
        <td><?php echo $med["Product_Name"]; ?></td>
        <?php
            $stocks = 0;
            $id = $med["Product_ID"];
            $query = mysqli_query($conn, "SELECT * FROM tbl_batches WHERE Product_ID = '".$med["Product_ID"]."'");
            while($row = mysqli_fetch_array($query))
            {
                $stocks += $row["Quantity"];
            }
            ?>

            <td><?php echo $stocks; ?></td>

            <td>
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