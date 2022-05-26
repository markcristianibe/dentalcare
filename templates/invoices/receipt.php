<html>
    <head>
        <title>Receipt</title>
        <link href="../../includes/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../invoices/print.css" media="print">
    </head>

    <?php
    include("../../server/db_connection.php");

    if(isset($_GET["id"]))
    {
        $invoiceNo = mysqli_real_escape_string($conn, $_GET["id"]);
        $sql = "SELECT tbl_invoice.Invoice_No, tbl_patientinfo.Patient_ID, tbl_patientinfo.Date_Registered, tbl_patientinfo.Lastname, tbl_patientinfo.Firstname, tbl_invoice.Amount_Paid FROM tbl_patientinfo, tbl_invoice WHERE tbl_invoice.Patient_ID = tbl_patientinfo.Patient_ID AND tbl_invoice.Invoice_No = '$invoiceNo'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);

            $rawDate = date_create($row["Date_Registered"]);
            $dateRegistered = date_format($rawDate, "ym");
            $pid = "PID-" . $dateRegistered . "-" . $row["Patient_ID"];
            ?>
            <body>
                <div class="containers text-dark">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="../../img/logo.png" width="200px">
                        </div>
                        <div class="col-md-5">
                            <table class="table table-bordered border-dark">
                                <tr>
                                    <th>979 Kundiman Street, Sampaloc 1009 Manila</th>
                                </tr> 
                                <tr>
                                    <td>Please contact us to make a payment. <br> For  Billing Inquiries: 504-833-3200</td>
                                </tr> 
                                <tr>
                                    <th>mci-dentalcare.com</th>
                                 </tr>    
                            </table>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-md-3">
                            <h3 class="text-start">Invoice No:</h3>
                             <table class="table table-bordered border-dark">
                                <tr>
                                    <th><?php echo $row["Invoice_No"]; ?></th>
                                </tr> 
                            </table>
                            <a id="btn-print" class="btn btn-secondary" href="../../admin/homepage.php">Close</a>
                            <button id="btn-print" class="btn btn-primary" onclick="window.print();">Print</button>
                         </div>
                    </div>
                    <hr style="border: 1px dashed black">
                    <table class="table table-bordered border-dark">
                        <thead>
                             <tr>
                                <th>Account Number</th>
                                <th>Account Name</th>
                                <th>Statement Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $pid; ?></td>
                                <td><?php echo $row["Lastname"] . ", " . $row["Firstname"]; ?></td>
                                <td><?php echo date("m/d/Y"); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table id="tbl-services" class="table table-bordered border-dark">
                        <thead>
                            <tr>
                                <th>Service Description</th>
                                <th>Charges</th>
                                 <th>Payments</th>
                                <th>Patient Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
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
                            ?>
                         </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="container-fluid bg-secondary text-light"><b>STATEMENT SUMMARY</b></div>
                             <table class="table table-bordered border-dark">
                                <tr>
                                    <td><small>Total Charges:</small></td>
                                    <td>PHP <?php echo number_format($totalCharge, 2); ?></td>
                                </tr>    
                                <tr>
                                    <td><small>Payment Adjustments:</small></td>
                                    <td>PHP <?php echo number_format($row["Amount_Paid"], 2); ?></td>
                                </tr>    
                                <tr>
                                    <td><b>Amount Due:</b></td>
                                     <td><b>PHP <?php echo number_format($balance, 2); ?></b></td>
                                </tr>    
                            <table>
                        </div>
                    </div>
                </div>
            </body>
            <?php
        }
        else
        {
            header("location: ../../admin/homepage.php");
        }
    }

    ?>
</html>

<style>
    .containers {
        margin: 30px 20px;
    }
    .container-fluid {
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 5px;
    }
    .table {
        width: 100%;
        text-align: center;
        font-family: 'Nunito', sans-serif;
        text-transform: uppercase;
    }
</style>