<script>
    document.getElementById("patientsbtn").classList.add("active");
</script>

<?php
if(!isset($_GET["id"]))
{
    header("location: ../admin/homepage.php?page=patients");
}

$id = mysqli_real_escape_string($conn, $_GET["id"]);

$sql = "select * from tbl_patientinfo where Patient_ID = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$rawDate = date_create($row["Date_Registered"]);
$dateRegistered = date_format($rawDate, "ym");
$pid = "PID-" . $dateRegistered . "-" . $row["Patient_ID"];
?>

<div class="container text-dark">
    <div class="row">
        <div class="col">
            <h3 style="color: dodgerblue">Patient Records</h3>
        </div>
        <div class="col">
            <a id="back-btn" href="homepage.php?page=patients">Back <i class="fa fa-solid fa-share"></i></a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-3">
                    <b>Patient ID: </b>
                </div>
                <div class="col-md-8">
                    <p><?php echo $pid; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <b>Patient Name: </b>
                </div>
                <div class="col-md-8">
                    <p><?php echo $row["Firstname"] . " " . $row["Lastname"]; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <b>Address: </b>
                </div>
                <div class="col-md-8">
                    <p><?php echo $row["Address"]; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <b>Email: </b>
                </div>
                <div class="col-md-8">
                    <p><?php echo $row["Email"]; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <?php
                if($row["Picture"] != "")
                {
                    ?>     
                    <img id="user-profile" class="rounded float-end" src="<?php echo "data:image/jpeg;base64," . base64_encode($row['Picture']); ?>" width="100%">
                    <?php
                }
                else
                {
                    ?>     
                    <img id="user-profile" class="rounded text-end" src="../img/user-1.png" width="150px" heigth="150px">
                    <?php
                }
                ?>
        </div>
    </div>
    <hr>

    <?php
    $totalCharges = 0;
    $totalPayment = 0;
    $totalBalance = 0;

    $invoiceNo = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "SELECT tbl_invoice.Invoice_No, tbl_patientinfo.Patient_ID, tbl_patientinfo.Date_Registered, tbl_patientinfo.Lastname, tbl_patientinfo.Firstname, tbl_invoice.Amount_Paid, tbl_invoice.Date FROM tbl_patientinfo, tbl_invoice WHERE tbl_invoice.Patient_ID = tbl_patientinfo.Patient_ID AND tbl_patientinfo.Patient_ID = '". $row["Patient_ID"] ."'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) 
    {
        ?>
        <div class="containers text-dark">
                
        <table id="tbl-services" class="table table-bordered border-dark">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Service Description</th>
                    <th>Charges</th>
                        <th>Payments</th>
                    <th>Patient Balance</th>
                </tr>
            </thead>
            <tbody>
        <?php
        
        while($row = mysqli_fetch_assoc($result))
        {
            $services = mysqli_query($conn, "SELECT tbl_services.Service_Description, tbl_services.Charge FROM tbl_services, tbl_invoiceservices WHERE tbl_services.Service_ID = tbl_invoiceservices.Service_ID AND tbl_invoiceservices.Invoice_No = '". $row["Invoice_No"] ."'");
            $isset = false;
            $balance = 0;
            $totalCharge = 0;
            while($service = mysqli_fetch_array($services))
             {
                $total = mysqli_query($conn, "SELECT SUM(tbl_services.Charge) AS Total_Charge FROM tbl_services, tbl_invoiceservices WHERE tbl_services.Service_ID =  tbl_invoiceservices.Service_ID AND tbl_invoiceservices.Invoice_No = '". $row["Invoice_No"] ."'");
                $totalResult = mysqli_fetch_assoc($total);
                $totalCharge = $totalResult["Total_Charge"];
                if($row["Amount_Paid"] < $totalResult["Total_Charge"])
                {
                    $balance = $totalResult["Total_Charge"] - $row["Amount_Paid"];
                }
                
                ?>
                 <tr>
                    <?php
                    if(!$isset)
                    {
                        $date = date_create($row["Date"]);
                        ?>
                            <td rowspan="<?php echo mysqli_num_rows($services); ?>"><?php echo date_format($date, "m/d/Y"); ?></td>
                        <?php
                    }
                    ?>
                    <td class="text-start"><?php echo $service["Service_Description"]; ?></td>
                    <td>PHP<?php echo number_format($service["Charge"], 2); ?></td>
                
                    <?php
                    if(!$isset)
                    {
                        ?>
                        <td rowspan="<?php echo mysqli_num_rows($services); ?>">-PHP<?php echo number_format($row["Amount_Paid"], 2); ?></td>
                        <td rowspan="<?php echo mysqli_num_rows($services); ?>">PHP<?php echo number_format($balance, 2); ?></td>
                        <?php
                        $isset = true;
                    }
                    ?>
                </tr>
                <?php
            } 
            
            $totalCharges += $totalCharge;
            $totalPayment += $row["Amount_Paid"];
            $totalBalance += $balance;  
        }
        ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <div class="container-fluid bg-secondary text-light"><b>STATEMENT SUMMARY</b></div>
                 <table class="table table-bordered border-dark">
                    <tr>
                        <td><small>Total Charges:</small></td>
                        <td>PHP <?php echo number_format($totalCharges, 2); ?></td>
                    </tr>    
                    <tr>
                        <td><small>Payment Adjustments:</small></td>
                         <td>PHP <?php echo number_format($totalPayment, 2); ?></td>
                    </tr>    
                    <tr>
                        <td><b>Amount Due:</b></td>
                         <td><b>PHP <?php echo number_format($totalBalance, 2); ?></b></td>
                    </tr>    
                </table>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<style>
    .container{
        margin: 20px 10px;
    }
    #back-btn{
        float: right;
        text-decoration: none;
        margin-right: 10px;
    }
</style>