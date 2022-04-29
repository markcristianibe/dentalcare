<script>
    document.getElementById("patientsbtn").classList.add("active");

    
    function uploadImg()
    {
        $('#browseImage').modal('hide');
        document.getElementById("user-profile").src = document.getElementById("image").value;
    }

    function defaultImg()
    {
        document.getElementById("user-profile").src = "../img/user-1.png";
    }
</script>
<?php
if(!isset($_GET["id"]))
{
    header("location: homepage.php?page=patients");
}

$id = mysqli_real_escape_string($conn, $_GET["id"]);

$sql = "select * from tbl_patientinfo where Patient_ID = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$rawDate = date_create($row["Date_Registered"]);
$dateRegistered = date_format($rawDate, "ym");
$pid = "PID-" . $dateRegistered . "-" . $row["Patient_ID"];
?>

<div class="container">
    <div class="row">
        <div class="col">
            <h3 style="color: dodgerblue"><?php echo $pid; ?></h3>
        </div>
        <div class="col">
            <a id="back-btn" href="homepage.php?page=patients">Back <i class="fa fa-solid fa-share"></i></a>
        </div>
    </div>
    <hr class="dropdown-divider">

    <form action="../server/action.php" method="POST" enctype="multipart/form-data">
        <input type="text" value="<?php echo $row["Patient_ID"]; ?>" class="visually-hidden" name="patient-id">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col">
                        <small>First Name</small>
                        <input type="text" class="form-control" name="firstname" placeholder="First Name" value="<?php echo $row["Firstname"]; ?>" autocomplete="off" required>
                    </div>
                    <div class="col">
                        <small>Last Name</small>
                        <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="<?php echo $row["Lastname"]; ?>" autocomplete="off" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Address</small>
                        <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $row["Address"]; ?>" autocomplete="off" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Email</small>
                        <input type="email" class="form-control" name="email" placeholder="Email"  value="<?php echo $row["Email"]; ?>" autocomplete="off" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Contact No.</small>
                        <input type="text" class="form-control" name="contact_no" placeholder="Contact No." value="<?php echo $row["Contact"]; ?>" autocomplete="off" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Birthdate</small>
                        <input type="date" class="form-control" name="birthdate" placeholder="Birth Date" value="<?php echo $row["Birthdate"]; ?>" required>
                    </div>
                    <div class="col">
                        <small>Gender</small>
                        <select class="form-control" name="gender" value="<?php echo $row["Sex"]; ?>" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Civil Status</small>
                        <input type="text" class="form-control" name="civil_status" placeholder="Civil Status" value="<?php echo $row["Civil_Status"]; ?>" autocomplete="off" required>
                    </div>
                    <div class="col">
                        <small>Occupation</small>
                        <input type="text" class="form-control" name="occupation" placeholder="Occupation" value="<?php echo $row["Occupation"]; ?>" autocomplete="off" required>
                    </div>
                    <div class="col">
                        <div class="actions-btn">
                            <a href="homepage.php?page=patients" class="btn btn-outline-secondary">Discard</a>
                            <a data-bs-toggle="modal" data-bs-target="#saveConfirmation" class="btn btn-primary">Save Changes</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
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
                        <img id="user-profile" class="rounded float-end" src="../img/user-1.png" width="100%">
                        <?php
                    }
                ?>
                <a id="edit-btn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#browseImage"><i class="fa fa-pen"></i> Change Photo</a>
            </div>

            <div class="modal fade" id="browseImage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" style="color: black">Select Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input id="img-btn" type="file" name="image" id="image" class="form-control btn-secondary" accept=".png, .jpg, .jpeg">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="defaultImg()">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="uploadImg()">Upload</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="saveConfirmation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" style="color: black">Save Changes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="color: black">
                            Are you sure you want to save changes? <br> Note: This action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="submit" name="update-patient-info" class="btn btn-primary">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    small{
        color: black;
    }
    .container{
        margin: 20px 10px;
    }
    .form-control{
        margin: 5px 0 5px 0;
        padding: 10px 5px 10px 5px;
    }
    #edit-btn{
        position: absolute;
    }
    #back-btn{
        float: right;
        text-decoration: none;
        margin-right: 10px;
    }
    .actions-btn{
        float: right;
        margin-top: 33px;
    }
</style>
