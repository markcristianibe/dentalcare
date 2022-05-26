<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    document.getElementById("invoice-btn").classList.add("active");
    
    function tableSearch(){
        let input, filter, table, tr, td, txtValue;

        input = document.getElementById("txtInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tblServices");
        tr = table.getElementsByTagName("tr");

        for(let i = 0; i < tr.length; i++){
            td = tr[i].getElementsByTagName("td")[1];
            if(td){
                txtValue = td.textContent || td.innerText;
                if(txtValue.toUpperCase().indexOf(filter) > -1){
                    tr[i].style.display = "";
                }
                else{
                    tr[i].style.display = "none";
                }
            }
        }
    }

    var total = 0;

    function addService(id) {
        var services = [
            <?php 
            $sql = mysqli_query($conn, "SELECT * FROM tbl_services");
            while($row = mysqli_fetch_array($sql))
            {
                ?>
                {
                    id: "<?php echo $row["Service_ID"]; ?>",
                    serviceDescription: "<?php echo $row["Service_Description"]; ?>",
                    price: "<?php echo $row["Charge"]; ?>"
                },
                <?php
            }
            ?>
        ];

        for(var i = 0; i < services.length; i++) {
            if(services[i]["id"] == id) {
                if(document.getElementById(id).checked == true) {
                    document.getElementById("table-body").innerHTML += "<?php echo '<tr><td>'; ?>" + services[i]["serviceDescription"] + "<?php echo "</td><td>"; ?>" + services[i]["price"] + "<?php echo "</td></tr>"; ?>";
                    total += parseInt(services[i]["price"]);
                }
                else {
                    var tblLength = document.getElementById("table-body").rows.length;
                    for(var j = 0; j < tblLength; j++) {
                        if(document.getElementById("table-body").rows[j].cells[0].innerHTML == services[i]["serviceDescription"]) {
                            document.getElementById("table-body").deleteRow(j);
                            total -= parseInt(services[i]["price"]);
                        }
                    }
                }
            }
        }
        document.getElementById("txt-total").value = total;

        if($('#table-body').find('tr').length > 0) {
                document.getElementById("btn-submit").disabled = false;
            }
            else {
                document.getElementById("btn-submit").disabled = true;
            }
    }
</script>

<div class="container text-dark">
    <form action="../server/action.php" method="POST">
        <div class="row">
            <div class="col">
                <h3 style="color: dodgerblue">Invoices</h3>
            </div>
            <div class="col-md-2">
                <button id="btn-submit" name="create-invoice" type="submit" class="btn btn-success" disabled>Generate Invoice</button>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <small>Patient: </small>
                    <input type="text" id="form-autocomplete" name="patientId" class="form-control" list="patient-list" placeholder="Type Patient Name or Patient ID..." autocomplete="off" required>
                    <datalist id="patient-list">
                        <?php
                            
                        include("../server/db_connection.php");

                        $sql = "select * from tbl_patientinfo";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                $rawDate = date_create($row["Date_Registered"]);
                                $dateRegistered = date_format($rawDate, "ymd");
                                $pid = "PID-" . $dateRegistered . "-" . $row["Patient_ID"];
                                echo "<option value='". $pid ."'>". $row["Firstname"] . " " . $row["Lastname"] ."</option>";
                                
                            }
                        }

                        ?>
                    </datalist>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col">
                            <small>Invoice No: </small>
                            <input id="txtInvoice" name="invoiceNo" type="text" class="form-control" readonly value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <small>Invoice Date: </small>
                            <input type="text" class="form-control" autocomplete="off" disabled value="<?php echo date("M d, Y") ?>">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-8">
                    Find Services:
                    <input type="text" id="txtInput" class="form-control" placeholder="Search Services..." onkeyup="tableSearch()" autocomplete="off">
                    <div class="scroll">
                        <table id="tblServices" class="table">
                            <thead>
                                <th></th>
                                <th scope="col">Service Description</th>
                                <th scope="col">Charge</th>
                            </thead>
                            <tbody>
                                <?php
                                    
                                include("../server/db_connection.php");

                                $sql = "select * from tbl_services";
                                $result = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($result) > 0)
                                {
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        echo "<tr>";
                                            echo "<td><input id='". $row["Service_ID"] ."' type='checkbox' name='service[]' value=". $row["Service_ID"] ." onchange='addService(". $row["Service_ID"] .")'></td>";
                                            echo "<td><label for='". $row["Service_ID"] ."'>". $row["Service_Description"] ."</label></td>";
                                            echo "<td>₱". number_format($row["Charge"]) ."</td>";
                                        echo "</tr>";
                                    }
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    Selected Procedures:
                    <div class="scroll-small">
                        <table id="tblServices" class="table">
                            <thead>
                                <th scope="col">Service Description</th>
                                <th scope="col">Charge</th>
                            </thead>
                            <tbody id="table-body">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-5 text-end">
                            <b>Total:</b> 
                        </div>
                        <div class="col-md-6">
                            <input id="txt-total" name="total" type="text" class="form-control" readonly value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 text-end">
                            <b>Amount Paid:</b> 
                        </div>
                        <div class="col-md-6">
                            <input name="amountPaid" type="number" class="form-control" min="1" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let date = new Date();
    let txtInvoice = document.getElementById("txtInvoice");
    txtInvoice.value = "INV-" + date.getYear() + date.getMonth() + date.getDay() + "-" +  + date.getHours()  + date.getMinutes();

</script>

<style>
    .container{
        margin: 20px 10px;
    }
    .scroll{
        position: relative;
        height: 280px;
        overflow: auto;
        display: block;
    }
    .scroll-small{
        position: relative;
        height: 250px;
        overflow: auto;
        display: block;
    }
</style>