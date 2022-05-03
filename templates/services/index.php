<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    document.getElementById("services-btn").classList.add("active")

    function btn_onHover()
    {
        document.getElementById("addBtn-txt").innerHTML = "+ Add Service"
        document.getElementById("addBtn").style.width = "300px"
        document.getElementById("addBtn").style.borderRadius = "50px"
    }

    function btn_onLeave()
    {
        document.getElementById("addBtn-txt").innerHTML = "+"
        document.getElementById("addBtn").style.width = "70px"
        document.getElementById("addBtn").style.borderRadius = "50%"
    }

    $(document).ready(function(){
        $("#txt-search").keyup(function(){
            var txt = $(this).val();
            $.ajax({
                method: 'post',
                url: '../templates/services/search-service.php',
                data: {
                    search: txt,
                    category: document.getElementById("dropdownFilter").innerHTML
                },
                datatype: "text",
                success: function(data){
                    $("#table-data").html(data);
                }
            });
        });
    });

    function dropDownCategory(category)
    {
        if(category == "All")
        {
            document.getElementById("dropdownFilter").innerHTML = "Select Service Category...";
        }
        else
        {
            document.getElementById("dropdownFilter").innerHTML = category;
        }

        $.ajax({
            method: 'post',
            url: '../templates/services/filter-service.php',
            data: {
                search: document.getElementById("txt-search").value,
                category: category
            },
            datatype: "text",
            success: function(data){
                $("#table-data").html(data);
            }
        });
    }
</script>

<?php
    include("../server/db_connection.php");
    
    $sql = "select * from tbl_services";
    $result = mysqli_query($conn, $sql);
?>

<div class="container">
    <h3 style="color: dodgerblue">Services</h3>

    <div class="container">
      <div class="row">
        <div class="col-md-7">
            <div class="form"> <i class="fa fa-search fa-icon"></i> <input type="text" id="txt-search" class="form-control form-input" placeholder="Search for Service Description..." autocomplete="off"> <span class="left-pan">Search</span> </div>
        </div>
        <div class="col-md-5">
            <div class="form">  
                <div class="dropdown">
                    <p class="fa fa-icon">&#xf0b0</p>
                    <button class="form-control form-input dropdown-toggle" type="button" id="dropdownFilter" data-bs-toggle="dropdown" aria-expanded="false">Select Service Category...</button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownFilter">
                        <li><a class="dropdown-item" onclick="dropDownCategory('All')">All</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" onclick="dropDownCategory('Cosmetic Dentistry')">Cosmetic Dentistry</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('Prosthodontics (Crowns and Dentures)')">Prosthodontics (Crowns and Dentures)</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('Orthodontics (Braces)')">Orthodontics (Braces)</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('Restoration (Fillings)')">Restoration (Fillings)</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('Dental Implants')">Dental Implants</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('Oral Examination')">Oral Examination</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('Periodontics')">Periodontics</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('Oral Surgery')">Oral Surgery</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('Endodontics (Root Canal Therapy)')">Endodontics (Root Canal Therapy)</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('TMJ Dysfunction')">TMJ Dysfunction</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('Pediatric Dentistry')">Pediatric Dentistry</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('X-Ray Services')">X-Ray Services</a></li>
                        <li><a class="dropdown-item" onclick="dropDownCategory('CBCT Scan')">CBCT Scan</a></li>
                    </ul>
                </div> 
            </div>
        </div>
      </div>
      <hr class="dropdown-divider">
    </div>

    <button id="addBtn" class="btn floating-btn" data-bs-toggle="modal" data-bs-target="#add-service-modal" onmouseover="btn_onHover()" onmouseleave="btn_onLeave()"><h1 id="addBtn-txt">+</h1></button>

    <div id="data" class="container-fluid">
        <table id="tbl-patients" class="table table-striped table-fixed">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Service Description</th>
                <th scope="col">Charge</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="table-data">
            <script>
                function showDialog(id, service)
                {
                    document.getElementById("delete-modal-body").innerHTML = "Are you sure you want to remove <b>" + service + "</b> from database? <br> Note: This action cannot be undone.";
                    document.getElementById("del-btn-yes").href = "../server/action.php?event=del&wa=service&id=" + id;
                }

                function showEditDialog(id)
                {
                    $.ajax({
                        method: 'post',
                        url: '../templates/services/edit.php',
                        data: {
                            serviceId: id
                        },
                        datatype: "text",
                        success: function(data){
                            $("#modalContent").html(data);
                        }
                    });
                }
            </script>
                <?php
                include("../templates/modals/delete-service-confirmation-modal.php");
                include("../templates/modals/edit-service-modal.php");
                if(mysqli_num_rows($result) > 0)
                {
                    $count = 1;
                    while ($service = mysqli_fetch_array($result))
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
                    echo "<tr>
                    <th colspan='5'>No Results Found...</th>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<style>
    .container{
        margin: 20px 10px;
    }
    .box-item{
        background: dodgerblue;
    }
    .floating-btn{
        width: 70px;
        height: 70px;
        background-color: dodgerblue;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.50);
        position: fixed;
        right: 50px;
        bottom: 30px;
        transition: background 0.25s;
        z-index: 1;
    }
    .floating-btn:hover, .floating-btn:active{
        background-color: rgb(22, 118, 214);
        color: white;
    }
    .form {
        position: relative
    }
    .form .fa-icon {
        position: absolute;
        top: 20px;
        left: 5px;
        color: #9ca3af
    }
    .fa{
        color: #fff;
    }
    .circle{
        border-radius: 50%;
    }
    .form span {
        position: absolute;
        right: 17px;
        top: 13px;
        padding: 2px;
        border-left: 1px solid #d1d5db
    }
    .left-pan {
        padding-left: 20px
    }
    .form-control, .form-select {
        margin: 5px 0 5px 0;
    }
    .form-input {
        margin: 5px 0 5px -15px;
        height: 55px;
        text-indent: 33px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.50);
        border-radius: 10px
    } 
    .container-fluid {
        position: relative;
        height: 420px;
        overflow: auto;
        display: block;
    }
    .dropdown-menu {
        height: 300px;
        overflow: auto;
    }
</style>