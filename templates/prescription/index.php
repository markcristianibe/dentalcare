<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    document.getElementById("prescription-btn").classList.add("active");
</script>

<div class="container text-dark">
    <div class="row">
        <div class="col">
            <h3 style="color: dodgerblue">Create Prescription</h3>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <form>
                    <div class="row" id="itemDescription">
                        <div class="col-md-5">
                            <small>Item Name / Code:</small>
                            <input id="itemId" class="form-control" list="items-list" placeholder="Type Item Name or Item Code..." autocomplete="off" onchange="searchItem()">
                            <datalist id="items-list">
                            <?php
                                
                            include("../server/db_connection.php");

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
                            <small>Price:</small>
                            <input id="price" class="form-control" disabled>
                        </div>
                        <div class="col-md-2">
                            <small>Qty:</small>
                            <input id="qty" class="form-control" type="number">
                        </div>
                        <div class="col-md-2">
                            <small>Discount: (%)</small>
                            <input id="disc" class="form-control" type="number" value="0">
                        </div>
                        <div class="col-md-1">
                            <small class="text-light">.</small>
                            <a class="btn btn-success mt-1" style="float: right" onclick="addItem()">+</a>
                        </div>
                    </div>
                </form>
                <div class="container-fluid " style="height: 350px; overflow: auto; background: #f5f5f5">
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th>Medicine Name</th>
                                <th>S.Price</th>
                                <th>QTY</th>
                                <th>Discount</th>
                                <th>Total Amount</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody id="prescriptionData">
                            
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <small>Total Item:</small>
                        <input id="txtTotalItem" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <small>Customer Name / Customer ID:</small>
                        <input type="text" id="txtpatientId" name="patientId" class="form-control" list="patient-list" placeholder="Type Patient Name or Patient ID..." autocomplete="off" required>
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
                    <div class="col-md-2">
                        <small class="text-light">,</small>
                        <button class="btn btn-danger form-control" onclick="window.location.href = '../admin/homepage.php?page=prescription'">Clear</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <br>
                <div class="container-fluid bg-success p-2">
                    <h4 class="text-center text-light">Total Bill</h4>
                </div>
                <div class="container-fluid bg-light p-2">
                    <div class="row">
                        <div class="col">
                            Total Amount:
                        </div>
                        <div class="col">
                            <div id="txtTotalAmount" class="form-control">PHP 0.00</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Total Discount:
                        </div>
                        <div class="col">
                            <div id="txtTotalDiscount" class="form-control">PHP 0.00</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Net Price:
                        </div>
                        <div class="col">
                            <div id="txtNetPrice" class="form-control">PHP 0.00</div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid bg-success p-2">
                    <p class="text-center text-light"></p>
                </div>
                <br>
                <button class="btn btn-lg btn-success form-control" onclick="createPrescription()">Done</button>
            </div>
        </div>
    </div>
</div>


<script>
    
    let date = new Date();
    let prescNo = date.getYear() + date.getMonth() + date.getDay() + "-" +  + date.getHours()  + date.getMinutes() + date.getSeconds();

    function searchItem(){
        var id = $("#itemId").val();

        $.ajax({
            method: 'post',
            url: '../templates/prescription/ajax.php',
            data: {
                action: 'searchItem',
                id: id,
            },
            datatype: "text",
            success: function(data) {
                $("#itemDescription").html(data);
            }
        })
    }

    var totalItems = 0;
    var totalAmount = 0;
    var totalDiscount = 0;

    function addItem() {
        var id = $("#itemId").val();
        var qty = $("#qty").val();
        var disc = $("#disc").val();

        if(qty > 0 && disc != "")
        {
            $.ajax({
                method: 'post',
                url: '../templates/prescription/ajax.php',
                data: {
                    action: 'insertItem',
                    id: id,
                    qty: qty,
                    discount: disc,
                    prescNo: prescNo
                },
                datatype: "text",
                success: function(data) {
                    $("#prescriptionData").html(data);

                    totalAmount += document.getElementById("price").value * qty;
                    document.getElementById("txtTotalAmount").innerHTML = "PHP " + totalAmount.toFixed(2);

                    totalDiscount += document.getElementById("price").value * qty * (document.getElementById("disc").value / 100);
                    document.getElementById("txtTotalDiscount").innerHTML = "PHP " + totalDiscount.toFixed(2);

                    var netPrice = totalAmount - totalDiscount;
                    document.getElementById("txtNetPrice").innerHTML = "PHP " + netPrice.toFixed(2);

                    document.getElementById("itemId").value = "";
                    document.getElementById("price").value = "";
                    document.getElementById("qty").value = "";
                    document.getElementById("disc").value = "";
                    totalItems++;
                    document.getElementById("txtTotalItem").value =  totalItems;
                }
            })
        }
        else {
            alert("Please input required fields");
        }

    }

    function removeItem(id, price, qty,disc) {
        $.ajax({
            method: 'post',
            url: '../templates/prescription/ajax.php',
            data: {
                action: 'removeItem',
                id: id
            },
            datatype: "text",
            success: function(data) {
                $("#prescriptionData").html(data);
                totalItems--;
                document.getElementById("txtTotalItem").value = totalItems;

                totalDiscount -= price * qty * (disc / 100);
                document.getElementById("txtTotalDiscount").innerHTML = "PHP " + totalDiscount.toFixed(2);

                totalAmount -= price * qty;
                document.getElementById("txtTotalAmount").innerHTML = "PHP " + totalAmount.toFixed(2);
                
                var netPrice = totalAmount - totalDiscount;
                document.getElementById("txtNetPrice").innerHTML = "PHP " + netPrice.toFixed(2);
                
                if(totalItems == 0) {
                    document.getElementById("txtTotalDiscount").innerHTML = "PHP 0.00";
                    document.getElementById("txtTotalAmount").innerHTML = "PHP 0.00";
                    document.getElementById("txtNetPrice").innerHTML = "PHP 0.00";
                }

            }
        })
        
    }

    function createPrescription() {
        var patientId = document.getElementById("txtpatientId").value;

        if(patientId != "")
        {
            $.ajax({
                method: 'post',
                url: '../templates/prescription/ajax.php',
                data: {
                    action: "createPrescription",
                    prescNo: prescNo,
                    patientId: patientId
                },
                datatype: "text",
                success: function(data){
                    alert("Prescription Added to Patient");
                    window.location.href = '../admin/homepage.php?page=prescription';
                }
            })
        }
        else
        {
            alert("Please Select a Customer");
        }
    }

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