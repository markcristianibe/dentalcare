      <?php
      include("../server/db_connection.php");
      include("../templates/modals/manage-accounts-modal.php");
      include("../templates/modals/add-user-modal.php");
      $userID = $_SESSION["adminUser"];
      $sql = "select * from tbl_usr where UserID = '$userID'";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) == 1)
      {
          $row = $result -> fetch_assoc();
      }
      else{
        header("location: index.php");
      }
      ?>

        <div id="sidebar-content" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-info" style="width: 20%; height: 100vh">
          <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img class="bi me-2" width="40" src="../img/icon.png">
            <span class="fs-4">DentalCare</span>
          </a>
          <hr>
          <ul id="sidebar" class="nav nav-pills flex-column mb-auto">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM tbl_userpermissions WHERE Permission = 'dashboard' AND User_ID = '$userID'");
            if(mysqli_num_rows($query) > 0)
            {
              ?>
              <li class="nav-item">
                <a href="homepage.php?page=dashboard" id="homebtn" class="nav-link text-white" aria-current="page">
                  <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                  Dashboard
                </a>
              </li>
              <?php
            }

            $query = mysqli_query($conn, "SELECT * FROM tbl_userpermissions WHERE Permission = 'patients' AND User_ID = '$userID'");
            if(mysqli_num_rows($query) > 0)
            {
              ?>
              <li>
                <a href="homepage.php?page=patients" id="patientsbtn" class="nav-link text-white">
                  <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>
                  Patients List
                </a>
              </li>
              <?php
            }
            
            $query = mysqli_query($conn, "SELECT * FROM tbl_userpermissions WHERE Permission = 'services' AND User_ID = '$userID'");
            if(mysqli_num_rows($query) > 0)
            {
              ?>
              <li>
                <a href="homepage.php?page=services" id="services-btn" class="nav-link text-white">
                  <svg class="bi me-2" width="16" height="16"><use xlink:href="#clipboard2"/></svg>
                  Services
                </a>
              </li>
              <?php
            }
            
            $query = mysqli_query($conn, "SELECT * FROM tbl_userpermissions WHERE Permission = 'appointments' AND User_ID = '$userID'");
            if(mysqli_num_rows($query) > 0)
            {
              ?>
              <li>
                <a href="homepage.php?page=appointments" id="appointments-btn" class="nav-link text-white">
                  <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                  Appointments
                </a>
              </li>
              <?php
            }
            
            $query = mysqli_query($conn, "SELECT * FROM tbl_userpermissions WHERE Permission = 'inventory' AND User_ID = '$userID'");
            if(mysqli_num_rows($query) > 0)
            {
              ?>
              <li>
                <a href="homepage.php?page=inventory" id="inventory-btn" class="nav-link text-white">
                  <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"/></svg>
                  Inventory
                </a>
              </li>
              <?php
            }
            
            $query = mysqli_query($conn, "SELECT * FROM tbl_userpermissions WHERE Permission = 'invoices' AND User_ID = '$userID'");
            if(mysqli_num_rows($query) > 0)
            {
              ?>
              <li>
                <a href="homepage.php?page=invoices" id="invoice-btn" class="nav-link text-white">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#sack-dollar"/></svg>
                  Invoice
                </a>
              </li>
              <?php
            }

            $query = mysqli_query($conn, "SELECT * FROM tbl_userpermissions WHERE Permission = 'prescription' AND User_ID = '$userID'");
            if(mysqli_num_rows($query) > 0)
            {
              ?>
              <li>
                <a href="homepage.php?page=prescription" id="prescription-btn" class="nav-link text-white">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#prescription"/></svg>
                  Prescription
                </a>
              </li>
              <?php
            }

            $query = mysqli_query($conn, "SELECT * FROM tbl_userpermissions WHERE Permission = 'logs' AND User_ID = '$userID'");
            if(mysqli_num_rows($query) > 0)
            {
              ?>
              <li>
                <a href="homepage.php?page=logs" id="logs-btn" class="nav-link text-white">
                  <svg class="bi me-2" width="16" height="16"><use xlink:href="#bell"/></svg>
                  Activity Logs
                </a>
              </li>
              <?php
            }
            ?>
          </ul>
          <hr>
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              <?php
              if($row["Picture"] == "")
              {
                ?>
                <img src="../img/user.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <?php
              }
              else
              {
                ?>
                <img src="<?php echo "data:image/jpeg;base64," . base64_encode($row['Picture']); ?>" alt="" width="32" height="32" class="rounded-circle me-2">
                <?php
              }
              ?>
              <strong><?php echo $row["Firstname"] . " " . $row["Lastname"]; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-light text-small shadow" aria-labelledby="dropdownUser1">
              <?php
              if($_SESSION["adminUser"] == 1)
              {
                ?>
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#manage-accounts-modal">Manage Accounts</a></li>
                <?php
              }
              ?>
              <li><a class="dropdown-item" onclick="editAccount(<?php echo $row['UserID']; ?>)">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="../server/action.php?event=logout">Sign out</a></li>
            </ul>
          </div>
        </div> 

      <div class="modal fade" id="edit-user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div id="modal-content" class="modal-content">
          </div>
        </div>
      </div>
      
      <style>
        .mobile-view {
          display: none;
        }

        @media screen and (max-width: 992px) {
          .web-view {
            display: none;
          }
          .mobile-view {
            display: block;
          }
        }
      </style>

      <script>
        function editAccount(id){
          $.ajax({
            method: 'post',
            url: '../templates/modals/edit-account-modal.php',
            data: {
              userSession: '<?php echo $_SESSION["adminUser"]; ?>',
              userId: id
            },
            datatype: "text",
            success: function(data){
              $("#modal-content").html(data);
            }
          });

          $("#edit-user-modal").modal("show");
        }
      </script>