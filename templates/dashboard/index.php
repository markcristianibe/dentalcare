<script>
    document.getElementById("homebtn").classList.add("active")
</script>

<?php
    include("../server/db_connection.php");
    
    $sql = "select * from tbl_patientinfo";
    $result = mysqli_query($conn, $sql);
?>

<div class="container">

    <h3 style="color: dodgerblue">Dashboard</h3>

    <div class="row">
        <div class="col">
            <h5>TOTAL NO. OF PATIENTS</h5>
        </div>
        <div class="col">
            <h5>ITEMS ON INVENTORY</h5>
        </div>
        <div class="col">
            <h5>CRITICAL ITEMS IN INVENTORY</h5>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="box-item bg-primary">
                <h1><?php echo mysqli_num_rows($result); ?></h1>
            </div>
        </div>
        <div class="col">
            <div class="box-item bg-success">
                <?php
                $med = mysqli_query($conn, "SELECT * FROM tbl_medications");
                $spl = mysqli_query($conn, "SELECT * FROM tbl_supplies");
                $total = mysqli_num_rows($med) + mysqli_num_rows($spl);
                ?>
                <h1><?php echo $total; ?></h1>
            </div>
        </div>
        <div class="col">
            <div class="box-item bg-warning">
                <?php
                $crit = 0;
                $med = mysqli_query($conn, "SELECT tbl_medications.Product_ID, SUM(tbl_batches.Quantity) AS Total FROM tbl_batches, tbl_medications WHERE tbl_batches.Product_ID = tbl_medications.Product_ID");
                while($row = mysqli_fetch_array($med))
                {
                    $query = mysqli_query($conn, "SELECT * FROM tbl_medications WHERE Product_ID = '". $row["Product_ID"] ."'");
                    $psl = mysqli_fetch_assoc($query);
                    if($row["Total"] <= $psl["Par_Stock_Level"])
                    {
                        $crit++;
                    }
                }

                $spl = mysqli_query($conn, "SELECT * FROM tbl_supplies WHERE Stocks <= Par_Stock_Level");
                $total = $crit + mysqli_num_rows($spl);
                ?>
                <h1><?php echo $total; ?></h1>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col">
            <h4 style="color: black; margin-top: 30px;"><small>Appointed Patients Today</small></h4>
            <br>
            <ul class="list-group">
                <?php
                $apt = mysqli_query($conn, "SELECT tbl_appointment.ID, tbl_patientinfo.Lastname, tbl_patientinfo.Firstname, tbl_patientinfo.Picture, tbl_appointment.Date, tbl_appointment.Start, tbl_appointment.End FROM tbl_appointment, tbl_patientinfo WHERE tbl_appointment.Status = 'pending' AND DATE = '". date("Y-m-d") ."' AND tbl_appointment.Patient_ID = tbl_patientinfo.Patient_ID");
                if(mysqli_num_rows($apt) > 0)
                {
                    while($row = mysqli_fetch_array($apt))
                    {
                        if($row["Picture"] == "")
                        {
                            $start = date_format(date_create($row["Start"]), "h:i A");
                            $end = date_format(date_create($row["End"]), "h:i A");
                            ?>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-1 align-self-center">
                                        <img src="../img/user.png" width="42px" height="42px">
                                    </div>
                                    <div class="col align-self-center">
                                        <b><?php echo $row["Firstname"] . " " . $row["Lastname"]; ?></b>
                                    </div>
                                    <div class="col align-self-center">
                                        <small>
                                            <p class="text-end"><?php echo $start. " - " .$end; ?></p>
                                        </small>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                        else
                        {
                            ?>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-1 align-self-center">
                                        <img src="<?php echo "data:image/jpeg;base64," . base64_encode($row['Picture']); ?>" width="42px" height="42px">
                                    </div>
                                    <div class="col align-self-center">
                                        <b><?php echo $row["Firstname"] . " " . $row["Lastname"]; ?></b>
                                    </div>
                                    <div class="col align-self-center">
                                        <small>
                                            <p class="text-end"><?php echo $row["Start"] . " - " . $row["End"]; ?></p>
                                        </small>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                    }
                }
                else
                {
                    ?>
                    <li class="list-group-item align-self-center">
                        No Appointments Today
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>

    <br><hr class="dropdown-divider"><br>

    <div class="row">
        <div class="col-md-3">
            <h4 style="color: black; margin-top: 30px; text-align: right">Monthly Visits</h4>
        </div>
        <div class="col-md-8" style="background-color: #fff; border: 1px solid #ccc; border-radius: 20px; box-shadow: 3px 4px 4px #ccc;">
            <canvas id="myChart"></canvas>
            <script>
            var xValues = ["Dec 2021","Jan 2022","Feb 2022","Mar 2022","Apr 2022","May 2022","Jun 2022","Jul 2022"];
            var yValues = [7,8,8,9,9,9,10, 13];

            new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(0,0,255,1.0)",
                borderColor: "rgba(0,0,255,0.1)",
                data: yValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                yAxes: [{ticks: {min: 6, max:16}}],
                }
            }
            });
            </script>
        </div>
        <br>
    </div>
</div>

<style>
    
    canvas{
        width:100%; 
        max-width:600px; 
        position: block;
        margin: auto;
        border:1px solid black; 
        margin-top: 20px;
        margin-bottom: 20px;
    }
    h1{
        text-align: center;
        margin-top: 45px;
    }
    h5{
        color: dimgray;
        text-align: center;
    }
    .container{
        margin: 10px 10px;
    }
    .box-item{
        width: 150px;
        height: 150px;
        position: block;
        margin: auto;
        padding-top: 5px;
        border-radius: 50%;
    }
</style>

