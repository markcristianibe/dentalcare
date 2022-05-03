      <?php
      include("../server/db_connection.php");
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

      <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-info" style="width: 20%;">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
          <img class="bi me-2" height="50" src="../img/icon.png">
          <span class="fs-4">DentalCare</span>
        </a>
        <hr>
        <ul id="sidebar" class="nav nav-pills flex-column mb-auto">
          <li class="nav-item">
            <a href="homepage.php?page=dashboard" id="homebtn" class="nav-link text-white" aria-current="page">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
              Dashboard
            </a>
          </li>
          <li>
            <a href="homepage.php?page=patients" id="patientsbtn" class="nav-link text-white">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>
              Patients List
            </a>
          </li>
          <li>
            <a href="homepage.php?page=services" id="services-btn" class="nav-link text-white">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#clipboard2"/></svg>
              Services
            </a>
          </li>
          <li>
            <a href="homepage.php?page=appointments" id="appointments-btn" class="nav-link text-white">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
              Appointments
            </a>
          </li>
          <li>
            <a href="homepage.php?page=inventory" id="inventory-btn" class="nav-link text-white">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"/></svg>
              Inventory
            </a>
          </li>
          <li>
            <a href="homepage.php?page=invoices" id="invoice-btn" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#sack-dollar"/></svg>
              Invoice
            </a>
          </li>
          <li>
            <a href="homepage.php?page=logs" id="logs-btn" class="nav-link text-white">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#bell"/></svg>
              Activity Logs
            </a>
          </li>
        </ul>
        <hr>
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../img/user.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong><?php echo $row["Firstname"] . " " . $row["Lastname"]; ?></strong>
          </a>
          <ul class="dropdown-menu dropdown-menu-light text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Manage Accounts</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../server/action.php?event=logout">Sign out</a></li>
          </ul>
        </div>
      </div> 