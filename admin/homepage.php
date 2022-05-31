<?php
session_start();
if(!isset($_SESSION["adminUser"]))
{
  header("location: index.php");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Title -->
    <title>DentalCare</title>

    <!-- Page Icon -->
	  <link rel="icon" href="../img/icon.png">

    <!-- Bootstrap CSS -->
    <link href="../includes/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

    <!-- Fontawesome icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    
    <link href="../templates/sidebar/sidebars.css" rel="stylesheet">
    
    <!-- Fullcalendar.io CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.js"></script>

    <!-- Jquery and AJAX CDN -->
  	<script type="text/javascript" src="../includes/bootstrap-5.1.3-dist/js/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <!-- Internal CSS -->
    <style>
      #content{
        overflow-x: hidden;
        
      }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      
      .disclaimer{
        display: none;
      }
    </style>
    
  </head>
  <body>
    
    <main>
    <?php
      include("../img/icons.php");
      include("../templates/sidebar/index.php");
      include("../templates/modals/add-patient-modal.php");
      include("../templates/modals/add-service-modal.php");
      include("../templates/modals/add-supplies-modal.php");
    ?>

        <div id="content" class="d-flex flex-column flex-shrink-0 text-white" style=" background-color: #ffff; width: 80%">
          <?php
          if(isset($_GET["page"]))
          {
            $page = $_GET['page'];
            $loc = "../templates/" . $page . "/index.php";
            include($loc);
          }
          else
          {
            include("../server/db_connection.php");
            $sql = mysqli_query($conn, "SELECT * FROM tbl_userpermissions WHERE User_ID = '".$_SESSION["adminUser"]."' ORDER BY ID");
            $result = mysqli_fetch_assoc($sql);

            $_GET["page"] = $result["Permission"];
            $page = $_GET['page'];
            $loc = "../templates/" . $page . "/index.php";
            include($loc);
          }
          ?>
        </div>
      
    </main>

    <script src="../includes/bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../templates/sidebar/sidebars.js"></script>
  </body>
</html>
