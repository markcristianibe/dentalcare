<div class="modal fade" id="add-user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">ADD NEW USER ACCOUNT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../server/action.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" name="firstname" placeholder="First Name" autocomplete="off" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="lastname" placeholder="Last Name" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" name="address" placeholder="Address" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <small>Birthdate</small>
                                    <input type="date" class="form-control" name="birthdate" placeholder="Birth Date" required>
                                </div>
                                <div class="col">
                                    <small>Civil Status</small>
                                    <select class="form-select" name="civil-status" required>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                </div>
                                <div class="col"> 
                                    <small>Gender</small>
                                    <select class="form-select" name="gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <input id="txt-username" type="text" class="form-control" name="username" placeholder="Username" required>
                                    <div id="alert" class="alert alert-danger alert-dismissible visually-hidden" role="alert">
                                        <svg class="bi flex-shrink-0 me-2 text-danger" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                        Username already exist!
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <center>
                                <img id="user-profile" class="rounded text-center" src="../img/user-1.png" width="130px" height="130px">
                            </center>      
                            <div class="col">
                                <input id="img-btn" type="file" name="image" id="image" class="form-control btn-secondary" accept=".png, .jpg, .jpeg" onchange="retriveImg(event)">
                            </div>    
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
                                            <input class="form-check-input" type="checkbox" name="permission[]" value="invoice" id="invoice">
                                            <label class="form-check-label" for="invoices">
                                                Invoice
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="defaultImg()">Cancel</button>
                <button type="submit" id="add-user-btn" name="add-user" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
            $sql = mysqli_query($conn, "SELECT * FROM tbl_usr");
            echo "var users = [";
                while($row = mysqli_fetch_array($sql))
                {
                    echo "'". $row["Username"] ."',";
                }
            echo "];";
            ?>
            if(users.includes(txt)) {
                document.getElementById("alert").classList.remove("visually-hidden");
                document.getElementById("add-user-btn").classList.add("disabled");
            }
            else{
                document.getElementById("alert").classList.add("visually-hidden");
                document.getElementById("add-user-btn").classList.remove("disabled");
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