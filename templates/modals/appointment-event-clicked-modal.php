
<?php
      include("../../server/db_connection.php");
      $id = mysqli_real_escape_string($conn, $_POST["id"]);
      $sql = "SELECT tbl_appointment.ID, CONCAT(tbl_patientinfo.Firstname, ' ', tbl_patientinfo.Lastname) AS 'Fullname', tbl_patientinfo.Picture FROM tbl_appointment, tbl_patientinfo WHERE tbl_appointment.ID = '$id' AND tbl_appointment.Patient_ID = tbl_patientinfo.Patient_ID";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      ?>
      <div class="modal-header">
        <?php
            if($row["Picture"] != "")
            {
                ?>     
                <img id="user-profile" src="<?php echo "data:image/jpeg;base64," . base64_encode($row['Picture']); ?>" width="32px" height="32px" style="margin-right: 10px; border-radius: 50%">
                <?php
            }
            else
            {
                ?>     
                <img id="user-profile" src="../img/user-1.png" width="32px" height="32px" style="margin-right: 10px; border-radius: 50%">
                <?php
            }
        ?>
        <h5 class="modal-title" id="appointment-modal-title"> APT-<?php echo $row["ID"]; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <label>Patient Name:</label>
          </div>
          <div class="col-md-8">
            <div class="container" style="border: 1px solid black; margin: 0; padding: 5px 15px; border-radius: 10px;">
              <?php
              echo $row["Fullname"];
              ?>
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-4">
            <label>Appointed Procedure/s:</label>
          </div>
          <div class="col-md-8">
            <div id="services" class="container" style="border: 1px solid black; margin: 0; padding: 5px 15px; border-radius: 10px; height: 100px">
              <ul> 
                <?php
                  $query = "SELECT tbl_services.Service_Description FROM tbl_services, tbl_appointmentservice WHERE Appointment_ID = '$id' AND tbl_services.Service_ID = tbl_appointmentservice.Service_ID";
                  $output = mysqli_query($conn, $query);
                  if(mysqli_num_rows($output) > 0)
                  {
                    while($row1 = mysqli_fetch_array($output))
                    {
                      echo '<li>'. $row1["Service_Description"] .'</li>';
                    }
                  }
                  else
                  {
                    $query = "SELECT * FROM tbl_appointment WHERE ID = '$id'";
                    $output = mysqli_query($conn, $query);
                    while($row1 = mysqli_fetch_array($output))
                    {
                      echo '<li>'. $row1["Apt_Description"] .'</li>';
                    }
                  }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="deletebtn()">Delete</button>
        <button type="button" class="btn btn-primary"onclick="admitbtn()">Admit</button>
      </div>
      
      <script>
        function deletebtn() {
          if(confirm("Are you sure you want to delete this appointment?")) {
            $.ajax({
                method: 'post',
                url: '../server/action.php',
                data: {deleteApt: <?php echo $id;?>},
                datatype: "text"
            });

            window.location.href="../admin/homepage.php?page=appointments";
          } 
        }

        function admitbtn() {
          $.ajax({
              method: 'post',
              url: '../server/action.php',
              data: {admitApt: <?php echo $id;?>},
              datatype: "text"
          });
          
          $("#appointment-event-clicked").modal("hide");
          alert("APT-" + <?php echo $id;?> + " was admitted successfully!");
          window.location.href="../admin/homepage.php?page=appointments";
        }
      </script>
      <style>
        #services {
          position: relative;
          overflow: auto;
          display: block;
        }
      </style>