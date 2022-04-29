<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    document.getElementById("patientsbtn").classList.add("active")

    function btn_onHover()
    {
        document.getElementById("addBtn-txt").innerHTML = "+ Add Patient"
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
                url: '../templates/patients/search-patient.php',
                data: {search: txt},
                datatype: "text",
                success: function(data){
                    $("#table-data").html(data);
                }
            });
        });
    });
</script>

<?php
    include("../server/db_connection.php");
    
    $sql = "select * from tbl_patientinfo";
    $result = mysqli_query($conn, $sql);
?>

<div class="container">
    <h3 style="color: dodgerblue">Patients List</h3>

    <div class="container">
      <div class="form"> <i class="fa fa-search"></i> <input type="text" id="txt-search" class="form-control form-input" placeholder="Search Patient ID or Name..."> <span class="left-pan"></span> </div>
      <hr class="dropdown-divider">
    </div>

    <button id="addBtn" class="btn floating-btn" data-bs-toggle="modal" data-bs-target="#add-patient-modal" onmouseover="btn_onHover()" onmouseleave="btn_onLeave()"><h1 id="addBtn-txt">+</h1></button>

    <div id="data" class="container-fluid">
        <table id="tbl-patients" class="table table-striped table-fixed">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Fullname</th>
                <th scope="col">Address</th>
                <th scope="col">Contact No.</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="table-data">
            <script>
                function showDialog(id, fullname)
                {
                    document.getElementById("delete-modal-body").innerHTML = "Are you sure you want to remove <b>" + fullname + "</b> records? <br> Note: This action cannot be undone.";
                    document.getElementById("del-btn-yes").href = "../server/action.php?event=del&id=" + id;
                }
            </script>
                <?php
                include("../templates/modals/delete-patient-confirmation-modal.php");
                if(mysqli_num_rows($result) > 0)
                {
                    while ($patient = mysqli_fetch_array($result))
                    {
                        $rawDate = date_create($patient["Date_Registered"]);
                        $dateRegistered = date_format($rawDate, "ym");
                        $pid = "PID-" . $dateRegistered . "-" . $patient["Patient_ID"];
                        ?>
                        <tr>
                        <th scope='row'><?php echo $pid; ?></th>
                        <td><?php echo $patient["Firstname"] . " " . $patient["Lastname"]; ?></td>
                        <td><?php echo $patient["Address"]; ?></td>
                        <td><?php echo $patient["Contact"]; ?></td>
                        <td>
                            <a href='homepage.php?page=patient-info&id=<?php echo $patient["Patient_ID"]; ?>' class='circle btn btn-success'><i class="fa fa-pen"></i></a>
                            <a href='#' class='circle btn btn-danger' data-bs-toggle='modal' data-bs-target='#delete-patient-msgBox' onclick='showDialog(<?php echo $patient["Patient_ID"]; ?>, "<?php echo $patient["Firstname"] . " " . $patient["Lastname"]; ?>")'><i class="fa fa-trash"></i></a>
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
    .form .fa-search {
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
    .form-control, .form-select{
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
        width: 100%;
        height: 440px;
        overflow: auto;
        display: block;
    }

</style>