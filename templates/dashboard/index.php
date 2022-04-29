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
                <h1>N/a</h1>
            </div>
        </div>
        <div class="col">
            <div class="box-item bg-warning">
                <h1>N/a</h1>
            </div>
        </div>
    </div>

    <br>

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

