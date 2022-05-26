<?php
include("../../server/db_connection.php");

if(isset($_POST["userId"]))
{
    $userSession = mysqli_real_escape_string($conn, $_POST["userSession"]);
    $userID = mysqli_real_escape_string($conn, $_POST["userId"]);
    $sql = "SELECT * FROM tbl_usr WHERE UserId = '$userID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

?>           

<script src="../includes/bootstrap-5.1.3-dist/js/md5.js"></script>
<script>
    var permissions = document.getElementsByTagName("input");
    
    for(var i = 0; i < permissions.length; i++) {

        <?php
        $query = mysqli_query($conn, "SELECT * FROM tbl_userpermissions WHERE User_ID = '$userID'");
        while($access = mysqli_fetch_array($query))
        {
            ?>
            if(permissions[i].value == '<?php echo $access["Permission"]; ?>')
            {
                permissions[i].checked = true;
            }
            <?php
        }
        ?>
    }

    <?php
    if($userID == 1)
    {
        ?>
        var check = document.getElementsByClassName("form-check-input");
        for(var i = 0; i < check.length; i++) {
            check[i].disabled = true;
            console.log(check[i].value);
        }
        <?php
    }
    ?>

    document.getElementById("select-status").value = "<?php echo $row["Civil_Status"]; ?>";
    document.getElementById("select-gender").value = "<?php echo $row["Gender"]; ?>";

    $(document).ready(function() {
        $("#txt-psw").keyup(function(){
            var txt = $(this).val();
            console.log(txt)
            
            if(calcMD5(txt) != '<?php echo $row["Password"]; ?>') {
                document.getElementById("alert-psw").classList.remove("visually-hidden");
                document.getElementById("new-psw").value = "";
                document.getElementById("new-psw").disabled = true;
            }
            else{
                document.getElementById("alert-psw").classList.add("visually-hidden");
                document.getElementById("new-psw").disabled = false;
            }
        });
    });
</script>
        <form method="POST" action="../server/action.php?id=<?php echo $userID; ?>" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">EDIT ACCOUNT INFORMATION</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" name="firstname" placeholder="First Name" value="<?php echo $row["Firstname"]; ?>" autocomplete="off" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="<?php echo $row["Lastname"]; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $row["Address"]; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <small>Birthdate</small>
                                    <input type="date" class="form-control" name="birthdate" placeholder="Birth Date" value="<?php echo $row["Birthdate"]; ?>" required>
                                </div>
                                <div class="col">
                                    <small>Civil Status</small>
                                    <select id="select-status" class="form-select" name="civil-status" required>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                </div>
                                <div class="col"> 
                                    <small>Gender</small>
                                    <select id="select-gender" class="form-select" name="gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <input id="txt-username" type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $row["Username"]; ?>" required>
                                    <div id="alert" class="alert alert-danger alert-dismissible visually-hidden" role="alert">
                                        <svg class="bi flex-shrink-0 me-2 text-danger" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                        Username already exist!
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a class="btn btn-secondary" data-bs-toggle="collapse" href="#change-password" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        Change Password
                                    </a>
                                    <div id="change-password" class="collapse">
                                        <br>
                                        <input id="txt-psw" type="password" class="form-control" placeholder="Type your old password...">
                                        <div id="alert-psw" class="alert alert-danger alert-dismissible visually-hidden" role="alert">
                                            <svg class="bi flex-shrink-0 me-2 text-danger" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                            Incorrect Password!
                                        </div>
                                        <input id="new-psw" type="password" class="form-control" disabled name="password" placeholder="Type your new password...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <center>
                                <?php
                                if($row["Picture"] == "")
                                {
                                    ?>
                                    <img id="user-profile" class="rounded text-center" src="../img/user-1.png" width="130px" height="130px">
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <img id="user-profile" class="rounded text-center" src="<?php echo "data:image/jpeg;base64," . base64_encode($row['Picture']); ?>" width="130px" height="130px">
                                    <?php
                                }
                                ?>
                            </center>      
                            <div class="col">
                                <input id="img-btn" type="file" name="image" id="image" class="form-control btn-secondary" accept=".png, .jpg, .jpeg" onchange="retriveImg(event)">
                            </div>    
                            <?php
                            if($userSession == '1')
                            {
                                ?>
                                <div class="row scrollable">
                                    <div class="col">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <input class="form-check-input" type="checkbox" name="permission[]" value="dashboard" id="dashboard">
                                                <label class="form-check-label" for="dashboard">
                                                    Dashboard
                                                </label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input" type="checkbox" name="permission[]" value="patients" id="patients">
                                                <label class="form-check-label" for="patients">
                                                    Patients List
                                                </label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input" type="checkbox" name="permission[]" value="services" id="services">
                                                <label class="form-check-label" for="services">
                                                    Services
                                                </label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input" type="checkbox" name="permission[]" value="appointments" id="appointments">
                                                <label class="form-check-label" for="appointments">
                                                    Appointments
                                                </label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input" type="checkbox" name="permission[]" value="inventory" id="inventory">
                                                <label class="form-check-label" for="inventory">
                                                    Inventory
                                                </label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input" type="checkbox" name="permission[]" value="prescription" id="prescription">
                                                <label class="form-check-label" for="prescription">
                                                    Prescription
                                                </label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="form-check-input" type="checkbox" name="permission[]" value="invoices" id="invoice">
                                                <label class="form-check-label" for="invoices">
                                                    Invoice
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="defaultImg()">Cancel</button>
                <button type="submit" id="edit-user-btn" name="edit-user" class="btn btn-primary">Save</button>  
            </div>
        </form>
<script>
  var retriveImg = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('user-profile');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };

    function defaultImg()
    {
      document.getElementById("user-profile").src = "../img/user-1.png";
    }

    function countChecked(){
        var form = document.forms["main"];
        var count = form.querySelectorAll('input[type="checkbox"]:checked');
        document.getElementById("count").innerHTML = count.length;
    }

    $(document).ready(function(){
        $("#txt-username").keyup(function(){
            var txt = $(this).val();
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM tbl_usr WHERE Username != '". $row["Username"] ."'");
            echo "var users = [";
                while($row = mysqli_fetch_array($sql))
                {
                    echo "'". $row["Username"] ."',";
                }
            echo "];";
            ?>
            if(users.includes(txt)) {
                document.getElementById("alert").classList.remove("visually-hidden");
                document.getElementById("edit-user-btn").classList.add("disabled");
            }
            else{
                document.getElementById("alert").classList.add("visually-hidden");
                document.getElementById("edit-user-btn").classList.remove("disabled");
            }
        });
    });

    

</script>

<style>
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
    .scrollable {
        position: relative;
        width: auto;
        height: 125px;
        overflow: auto;
        display: block;
    }
</style>