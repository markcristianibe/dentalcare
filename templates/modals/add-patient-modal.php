<div class="modal fade" id="add-patient-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">ADD NEW PATIENT</h5>
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
                                    <input type="text" class="form-control" name="contact_no" placeholder="Contact No." autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <center>
                                <img id="user-profile" class="rounded text-center" src="../img/user-1.png" width="130px" height="130px">
                            </center>          
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="date" class="form-control" name="birthdate" placeholder="Birth Date" required>
                        </div>
                        <div class="col">
                            <select class="form-select" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col">
                            <input id="img-btn" type="file" name="image" id="image" class="form-control btn-secondary" accept=".png, .jpg, .jpeg" onchange="retriveImg(event)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" name="civil_status" placeholder="Civil Status" autocomplete="off" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="occupation" placeholder="Occupation" autocomplete="off" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="defaultImg()">Cancel</button>
                <button type="submit" id="add-patient-btn" name="add-patient" class="btn btn-primary">Save</button>
                
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
</script>