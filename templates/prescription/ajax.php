<?php

include("../../server/db_connection.php");

if(isset($_POST["action"]) && $_POST["action"] == "searchItem")
{
    $itemId = mysqli_real_escape_string($conn, $_POST["id"]);

    $sql = mysqli_query($conn, "SELECT * FROM tbl_medications WHERE Product_ID = '$itemId'");
    $rows = mysqli_fetch_assoc($sql);
    ?>
    <div class="col-md-5">
        <small>Item Name / Code:</small>
        <input id="itemId" class="form-control" list="items-list" placeholder="Type Item Name or Item Code..." autocomplete="off"value="<?php echo $rows["Product_ID"]; ?>" onchange="searchItem()">
        <datalist id="items-list">
        <?php
        $sql = "select * from tbl_medications";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                echo "<option value='". $row["Product_ID"] ."'>". $row["Brand"] . " " . $row["Name"] ."</option>";
                
            }
        }

        ?>
        </datalist>
    </div>
    <div class="col-md-2">
        <small>Price: (PHP)</small>
        <input id="price" class="form-control" value="<?php echo number_format($rows["Price"], 2); ?>" disabled>
    </div>
    <div class="col-md-2">
        <small>Qty:</small>
        <input id="qty" class="form-control" type="number" min="1" required>
    </div>
    <div class="col-md-2">
        <small>Discount: (%)</small>
        <input id="disc" class="form-control" type="number" min="0" max="99" required>
    </div>
    <div class="col-md-1">
        <small class="text-light">.</small>
        <a class="btn btn-success mt-1" style="float: right" onclick="addItem()">+</a>
    </div>
    <?php
}

if(isset($_POST["action"]) && $_POST["action"] == "insertItem")
{
    $itemId = mysqli_real_escape_string($conn, $_POST["id"]);
    $qty = mysqli_real_escape_string($conn, $_POST["qty"]);
    $disc = mysqli_real_escape_string($conn, $_POST["discount"]);
    $prescNo = mysqli_real_escape_string($conn, $_POST["prescNo"]);

    if(mysqli_query($conn, "INSERT INTO tbl_prescription (Prescription_Code, Product_ID, Quantity, Discount, Status) VALUES ('$prescNo', '$itemId', '$qty', '$disc', 'partial')"))
    {
        $sql = mysqli_query($conn, "SELECT tbl_prescription.Prescription_ID, tbl_medications.Brand, tbl_medications.Name, tbl_medications.Price, tbl_prescription.Quantity, tbl_prescription.Discount FROM tbl_medications, tbl_prescription WHERE tbl_prescription.Product_ID = tbl_medications.Product_ID AND tbl_prescription.Prescription_Code = '$prescNo'");
        while($row = mysqli_fetch_array($sql))
        {
            ?>
            <tr>
                <td><?php echo $row["Brand"]. " " .$row["Name"]; ?></td>
                <td>PHP <?php echo number_format($row["Price"],2); ?></td>
                <td><?php echo $row["Quantity"]; ?></td>
                <td><?php echo $row["Discount"]; ?>%</td>
                <?php
                $discount = $row["Price"] * ($row["Discount"]/100);
                $total = ($row["Price"] - $discount) * $row["Quantity"];
                ?>
                <td>PHP <?php echo number_format($total, 2); ?></td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="removeItem(<?php echo $row['Prescription_ID']; ?>, <?php echo $row['Price']; ?>, <?php echo $row['Quantity']; ?>, <?php echo $row['Discount']; ?>)">-</button>
                </td>
            </tr>
            <?php
        }
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "removeItem")
{
    $id = mysqli_real_escape_string($conn, $_POST["id"]);

    $sql = mysqli_query($conn, "SELECT * FROM tbl_prescription WHERE Prescription_ID = '$id'");
    $row = mysqli_fetch_assoc($sql);

    if(mysqli_query($conn, "DELETE FROM tbl_prescription WHERE Prescription_ID = '$id'"))
    {
        $sql = mysqli_query($conn, "SELECT tbl_prescription.Prescription_ID, tbl_medications.Brand, tbl_medications.Name, tbl_medications.Price, tbl_prescription.Quantity, tbl_prescription.Discount FROM tbl_medications, tbl_prescription WHERE tbl_prescription.Product_ID = tbl_medications.Product_ID AND tbl_prescription.Prescription_Code = '".$row["Prescription_Code"]."'");
        while($row = mysqli_fetch_array($sql))
        {
            ?>
            <tr>
                <td><?php echo $row["Brand"]. " " .$row["Name"]; ?></td>
                <td>PHP <?php echo number_format($row["Price"],2); ?></td>
                <td><?php echo $row["Quantity"]; ?></td>
                <td><?php echo $row["Discount"]; ?>%</td>
                <?php
                $discount = $row["Price"] * ($row["Discount"]/100);
                $total = ($row["Price"] - $discount) * $row["Quantity"];
                ?>
                <td>PHP <?php echo number_format($total, 2); ?></td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="removeItem(<?php echo $row['Prescription_ID']; ?>)">-</button>
                </td>
            </tr>
            <?php
        }
    }
}

if(isset($_POST["action"]) && $_POST["action"] == "createPrescription")
{
    $prescNo = mysqli_real_escape_string($conn, $_POST["prescNo"]);
    $tmp_patientId = explode("-", mysqli_real_escape_string($conn, $_POST["patientId"]));
    $patientId = $tmp_patientId[2];

    mysqli_query($conn, "INSERT INTO tbl_patientprescription (Prescription_Code, Patient_ID) VALUES ('$prescNo', '$patientId')");
    
    $sql = mysqli_query($conn, "SELECT * FROM tbl_prescription WHERE Prescription_Code = '$prescNo'");
    while($row1 = mysqli_fetch_array($sql))
    {
        mysqli_query($conn, "UPDATE tbl_prescription SET Status = 'done' WHERE Prescription_Code = '$prescNo'");
        


        $needed = $row1["Quantity"];

        $med = mysqli_query($conn, "SELECT * FROM tbl_batches WHERE Product_ID = '".$row1["Product_ID"]."'");
        while($row2 = mysqli_fetch_array($med))
        {
            if($needed != 0)
            {
                if($row2["Quantity"] <= $needed)
                {
                    $needed -= $row2["Quantity"];
                    mysqli_query($conn, "DELETE FROM tbl_batches WHERE Batch_No = '".$row2["Batch_No"]."'");
                }
                else
                {
                    mysqli_query($conn, "UPDATE tbl_batches SET Quantity = Quantity - '$needed' WHERE Batch_No = '".$row2["Batch_No"]."'");
                    $needed = 0;
                }
            }
        }
    }

}
?>