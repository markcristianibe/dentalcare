<?php

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img/icon.png">
    <link rel="stylesheet" type="text/css" href="includes/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <script src="includes/bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
    <style>
        .disclaimer{
            display: none;
        }
    </style>
    <title>Dental Care</title>
</head>
<body>
    <?php
    if(isset($_GET["recaptcha-error"]))
    {
        echo '<script>
        alert("Recaptcha Failed!");
        window.location.href = "index.php";
    </script>';
    }

    if(isset($_GET["auth"]))
    {
        echo '<script>
        alert("Your Email is not found from the server");
        window.location.href = "index.php";
    </script>';
    }

    
    if(isset($_GET["auth-verification"]))
    {
        echo '<script>
        alert("You entered wrong code");
        window.location.href = "index.php";
    </script>';
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #2DAADD">
        <div class="container-fluid">
            <img src="img/icon.png" alt="" width="45" height="36">
            <a class="navbar-brand" href="#home"  onclick="showCOntent()">DENTALCARE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav" style="width: 100%">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#about" onclick="showCOntent()">ABOUT US</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#services" onclick="showCOntent()">CLINIC SERVICES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#appointment" onclick="showCOntent()">BOOK APPOINTMENT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#contact" onclick="showCOntent()">CONTACT US</a>
                </li>
                <?php
                if(isset($_SESSION["email"]))
                {
                    include("server/db_connection.php");
                    $sql = mysqli_query($conn, "SELECT * FROM tbl_patientinfo WHERE Email = '". $_SESSION["email"] ."'");
                    $row = mysqli_fetch_assoc($sql);
                    ?>
                    <li class="nav-item" style="width: 50%">
                        <div class="dropdown" style="float: right">
                            <a class="nav-link text-light d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" href="#">
                                <?php echo $row["Firstname"] . " " . $row["Lastname"]; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-light text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#records" onclick="viewRecord()">My Records</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="server/action.php?event=client-signout">Sign out</a></li>
                            </ul>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
            </div>
        </div>
    </nav>
    
    <span id="content">
        <section id="home">
            <br><br>
            <div class="row">	
                <div class="col-md-5">
                    <div class="container">
                        <h1 class="thin-font">Dental Consultation</h1>
                        <p class="text-light"> Provides care to your teeth,<br>Enhance your tooth<br>health</p>
                        <?php
                        if(!isset($_SESSION["email"]))
                        {
                            ?>
                            <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#signin-modal">
                                <img src="img/gmail-icon.png" width="32px">
                                SIGN IN WITH EMAIL
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="img/img1.png" width="100%" style="padding: 20px 20px">
                </div>
            </div>
                <br><br>
        </section>
        <section id="about">
            <br><br><br>
            <h1 class="text-center text-light">About Us</h1>
            <hr>
            <div class="row">
                <div class="col-md-7">
                    <div class="container bg-white" style="margin-left: 0; padding: 40px 50px">
                        <div class="row">
                            <div class="col-md-9">
                                <h1>We Are Leader in <br> Dental clinic <br> Services</h1>
                                <h4 class="text-secondary">Make each patient's dental experience as <br> comfortable and stress-free as possible.</h4>
                            </div>
                            <div class="col-md-3">
                                <br><br><br><br>
                                <img src="img/icon1.png" width="180px">
                            </div>
                        </div>
                    </div>
                    <br>
                    <center>
                        <a class="btn btn-outline-dark btn-primary text-light" style="padding: 20px 40px; border-radius: 40px; font-size: 24px" href="#appointment">Book Appointment <i class="fa fa-solid fa-calendar"></i></a>
                    </center>
                </div>
                <div class="col-md-5">
                    <br><br><br><br><br>
                    <div class="container bg-info" style="padding: 20px 20px; border-radius: 20px;">
                        <img src="img/image1.jpg" width="95%" style="border-radius: 20px">
                    </div>
                </div>
            </div>
        </section>

        <section id="services">
            <br><br><br>
            <h1 class="text-center text-light">Our Services</h1>
            <hr>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <center>
                            <div class="row row-cols-1 row-cols-md-3 mb-3 text-center" style="width: 90%">
                                <div class="col">
                                    <div class="card mb-4 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h5 class="my-0 fw-normal">Cosmetic Dentistry</h5>
                                        </div>
                                        <div class="card-body">
                                        <small class="text-muted fw-light">As low as</small>
                                            <?php
                                            include("server/db_connection.php");

                                            $sql = "SELECT * FROM tbl_services WHERE Category = 'Cosmetic Dentistry' ORDER BY Charge ASC LIMIT 1";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h1 class="card-title pricing-card-title">PHP <?php echo number_format($row["Charge"], 2);?></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                <?php
                                                $sql = "SELECT * FROM tbl_services WHERE Category = 'Cosmetic Dentistry' LIMIT 4";
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    ?>
                                                    <li><?php echo $row["Service_Description"];?></li>
                                                    <?php
                                                }
                                                ?>
                                                
                                            </ul>
                                            <a class="w-100 btn btn-lg btn-outline-primary" href="#appointment">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card mb-4 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h5 class="my-0 fw-normal">Prosthodontics (Crowns and Dentures)</h5>
                                        </div>
                                        <div class="card-body">
                                        <small class="text-muted fw-light">As low as</small>
                                            <?php
                                            include("server/db_connection.php");

                                            $sql = "SELECT * FROM tbl_services WHERE Category = 'Prosthodontics (Crowns and Dentures)' ORDER BY Charge ASC LIMIT 1";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h1 class="card-title pricing-card-title">PHP <?php echo number_format($row["Charge"], 2);?></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                <?php
                                                $sql = "SELECT * FROM tbl_services WHERE Category = 'Prosthodontics (Crowns and Dentures)' LIMIT 4";
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    ?>
                                                    <li><?php echo $row["Service_Description"];?></li>
                                                    <?php
                                                }
                                                ?>
                                                <br>
                                            </ul>
                                            <a class="w-100 btn btn-lg btn-outline-primary" href="#appointment">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card mb-4 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h5 class="my-0 fw-normal">Orthodontics (Braces)</h5>
                                        </div>
                                        <div class="card-body">
                                        <small class="text-muted fw-light">As low as</small>
                                            <?php
                                            include("server/db_connection.php");

                                            $sql = "SELECT * FROM tbl_services WHERE Category = 'Orthodontics (Braces)' ORDER BY Charge ASC LIMIT 1";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h1 class="card-title pricing-card-title">PHP <?php echo number_format($row["Charge"], 2);?></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                <?php
                                                $sql = "SELECT * FROM tbl_services WHERE Category = 'Orthodontics (Braces)' LIMIT 4";
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    ?>
                                                    <li><?php echo $row["Service_Description"];?></li>
                                                    <?php
                                                }
                                                ?>
                                                <br>
                                            </ul>
                                            <a class="w-100 btn btn-lg btn-outline-primary" href="#appointment">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="carousel-item">
                        <center>
                            <div class="row row-cols-1 row-cols-md-3 mb-3 text-center" style="width: 90%">
                                <div class="col">
                                    <div class="card mb-4 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h5 class="my-0 fw-normal">Restoration (Fillings)</h5>
                                        </div>
                                        <div class="card-body">
                                        <small class="text-muted fw-light">As low as</small>
                                            <?php
                                            include("server/db_connection.php");

                                            $sql = "SELECT * FROM tbl_services WHERE Category = 'Restoration (Fillings)' ORDER BY Charge ASC LIMIT 1";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h1 class="card-title pricing-card-title">PHP <?php echo number_format($row["Charge"], 2);?></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                <?php
                                                $sql = "SELECT * FROM tbl_services WHERE Category = 'Restoration (Fillings)' LIMIT 4";
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    ?>
                                                    <li><?php echo $row["Service_Description"];?></li>
                                                    <?php
                                                }
                                                ?>
                                                <br><br>
                                            </ul>
                                            <a class="w-100 btn btn-lg btn-outline-primary" href="#appointment">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card mb-4 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h5 class="my-0 fw-normal">Dental Implants</h5>
                                        </div>
                                        <div class="card-body">
                                        <small class="text-muted fw-light">As low as</small>
                                            <?php
                                            include("server/db_connection.php");

                                            $sql = "SELECT * FROM tbl_services WHERE Category = 'Dental Implants' ORDER BY Charge ASC LIMIT 1";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h1 class="card-title pricing-card-title">PHP <?php echo number_format($row["Charge"], 2);?></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                <?php
                                                $sql = "SELECT * FROM tbl_services WHERE Category = 'Dental Implants' LIMIT 4";
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    ?>
                                                    <li><?php echo $row["Service_Description"];?></li>
                                                    <?php
                                                }
                                                ?>
                                                <br><br>
                                            </ul>
                                            <a class="w-100 btn btn-lg btn-outline-primary" href="#appointment">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card mb-4 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h5 class="my-0 fw-normal">Oral Examination</h5>
                                        </div>
                                        <div class="card-body">
                                        <small class="text-muted fw-light">As low as</small>
                                            <?php
                                            include("server/db_connection.php");

                                            $sql = "SELECT * FROM tbl_services WHERE Category = 'Oral Examination' ORDER BY Charge ASC LIMIT 1";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h1 class="card-title pricing-card-title">PHP <?php echo number_format($row["Charge"], 2);?></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                <?php
                                                $sql = "SELECT * FROM tbl_services WHERE Category = 'Oral Examination' LIMIT 4";
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    ?>
                                                    <li><?php echo $row["Service_Description"];?></li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                            <a class="w-100 btn btn-lg btn-outline-primary" href="#appointment">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="carousel-item">
                        <center>
                            <div class="row row-cols-1 row-cols-md-3 mb-3 text-center" style="width: 90%">
                                <div class="col">
                                    <div class="card mb-4 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h5 class="my-0 fw-normal">Periodontics</h5>
                                        </div>
                                        <div class="card-body">
                                        <small class="text-muted fw-light">As low as</small>
                                            <?php
                                            include("server/db_connection.php");

                                            $sql = "SELECT * FROM tbl_services WHERE Category = 'Periodontics' ORDER BY Charge ASC LIMIT 1";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h1 class="card-title pricing-card-title">PHP <?php echo number_format($row["Charge"], 2);?></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                <?php
                                                $sql = "SELECT * FROM tbl_services WHERE Category = 'Periodontics' LIMIT 4";
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    ?>
                                                    <li><?php echo $row["Service_Description"];?></li>
                                                    <?php
                                                }
                                                ?>
                                                <br><br>
                                            </ul>
                                            <a class="w-100 btn btn-lg btn-outline-primary" href="#appointment">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card mb-4 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h5 class="my-0 fw-normal">Oral Surgery</h5>
                                        </div>
                                        <div class="card-body">
                                        <small class="text-muted fw-light">As low as</small>
                                            <?php
                                            include("server/db_connection.php");

                                            $sql = "SELECT * FROM tbl_services WHERE Category = 'Oral Surgery' ORDER BY Charge ASC LIMIT 1";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h1 class="card-title pricing-card-title">PHP <?php echo number_format($row["Charge"], 2);?></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                <?php
                                                $sql = "SELECT * FROM tbl_services WHERE Category = 'Oral Surgery' LIMIT 4";
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    ?>
                                                    <li><?php echo $row["Service_Description"];?></li>
                                                    <?php
                                                }
                                                ?>
                                                <br><br>
                                            </ul>
                                            <a class="w-100 btn btn-lg btn-outline-primary" href="#appointment">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card mb-4 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h5 class="my-0 fw-normal">Endodontics (Root Canal Therapy)</h5>
                                        </div>
                                        <div class="card-body">
                                        <small class="text-muted fw-light">As low as</small>
                                            <?php
                                            include("server/db_connection.php");

                                            $sql = "SELECT * FROM tbl_services WHERE Category = 'Endodontics (Root Canal Therapy)' ORDER BY Charge ASC LIMIT 1";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h1 class="card-title pricing-card-title">PHP <?php echo number_format($row["Charge"], 2);?></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                <?php
                                                $sql = "SELECT * FROM tbl_services WHERE Category = 'Endodontics (Root Canal Therapy)' LIMIT 4";
                                                $result = mysqli_query($conn, $sql);
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    ?>
                                                    <li><?php echo $row["Service_Description"];?></li>
                                                    <?php
                                                }
                                                ?>
                                                <br><br>
                                            </ul>
                                            <a class="w-100 btn btn-lg btn-outline-primary" href="#appointment">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <section id="appointment">
            <br><br><br>
            <h1 class="text-center text-light">Appointments <i class="fa fa-solid fa-calendar"></i></h1>
            <div class="container" style="border-radius: 20px; padding: 20px">
                <center>
                    <table class="table" style="width: 80%;">
                        <tr>
                            <th class="text-light bg-dark"><h3 class="text-center"> </th>
                            <th class="text-light bg-dark"><h3 class="text-center"><b><?php echo date("M d, Y"); ?></b></h3></th>
                        </tr>
                        <tr>
                            <th class="text-light bg-dark"><h3 class="text-center">Monday</h3></th>
                            <th class="text-light bg-dark"><h3 class="text-center">Status</h3></th>
                        </tr>
                        <tr class="bg-light">
                            <th><h6 class="text-center">8:00 AM - 9:00 AM</h6></th>
                            <?php
                            $sql = "SELECT * FROM tbl_appointment WHERE Date = '". date("Y-m-d") ."'";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0)
                            {
                                $isOccupied = false;

                                while($row = mysqli_fetch_array($result))
                                {
                                    $start = date_create($row["Start"]);

                                    if($start >= date_create("08:00:00") && $start <= date_create("09:00:00"))
                                    {
                                        $isOccupied = true;
                                    }
                                }

                                if($isOccupied)
                                {
                                    ?>
                                    <th><h6 class="text-center text-danger">OCCUPIED</h6></th>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <th>
                                        <center>
                                            <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('08:00:00', '09:00:00')">
                                                VACANT
                                            </button>
                                        </center>
                                    </th>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <th>
                                    <center>
                                        <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('08:00:00', '09:00:00')">
                                            VACANT
                                        </button>
                                    </center>
                                </th>
                                <?php
                            }
                            ?>
                        </tr>
                        <tr class="bg-light">
                            <th><h6 class="text-center">9:30 AM - 10:30 AM</h6></th>
                            <?php
                            $sql = "SELECT * FROM tbl_appointment WHERE Date = '". date("Y-m-d") ."'";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0)
                            {
                                $isOccupied = false;

                                while($row = mysqli_fetch_array($result))
                                {
                                    $start = date_create($row["Start"]);

                                    if($start >= date_create("09:30:00") && $start <= date_create("10:30:00"))
                                    {
                                        $isOccupied = true;
                                    }
                                }

                                if($isOccupied)
                                {
                                    ?>
                                    <th><h6 class="text-center text-danger">OCCUPIED</h6></th>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <th>
                                        <center>
                                            <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('09:30:00', '10:30:00')">
                                                VACANT
                                            </button>
                                        </center>
                                    </th>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <th>
                                    <center>
                                        <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('09:30:00', '10:30:00')">
                                            VACANT
                                        </button>
                                    </center>
                                </th>
                                <?php
                            }
                            ?>
                        </tr>
                        <tr class="bg-light">
                            <th><h6 class="text-center">11:00 AM - 12:00 AM</h6></th>
                            <?php
                            $sql = "SELECT * FROM tbl_appointment WHERE Date = '". date("Y-m-d") ."'";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0)
                            {
                                $isOccupied = false;

                                while($row = mysqli_fetch_array($result))
                                {
                                    $start = date_create($row["Start"]);

                                    if($start >= date_create("11:00:00") && $start <= date_create("12:00:00"))
                                    {
                                        $isOccupied = true;
                                    }
                                }

                                if($isOccupied)
                                {
                                    ?>
                                    <th><h6 class="text-center text-danger">OCCUPIED</h6></th>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <th>
                                        <center>
                                            <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('11:00:00', '12:00:00')">
                                                VACANT
                                            </button>
                                        </center>
                                    </th>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <th>
                                    <center>
                                        <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('11:00:00', '12:00:00')">
                                            VACANT
                                        </button>
                                    </center>
                                </th>
                                <?php
                            }
                            ?>
                        </tr>
                        <tr class="bg-light">
                            <th colspan="2"><h6 class="text-center">Lunch Break</h6></th>
                        </tr>
                        <tr class="bg-light">
                            <th><h6 class="text-center">01:00 PM - 02:00 PM</h6></th>
                            <?php
                            $sql = "SELECT * FROM tbl_appointment WHERE Date = '". date("Y-m-d") ."'";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0)
                            {
                                $isOccupied = false;

                                while($row = mysqli_fetch_array($result))
                                {
                                    $start = date_create($row["Start"]);

                                    if($start >= date_create("13:00:00") && $start <= date_create("14:00:00"))
                                    {
                                        $isOccupied = true;
                                    }
                                }

                                if($isOccupied)
                                {
                                    ?>
                                    <th><h6 class="text-center text-danger">OCCUPIED</h6></th>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <th>
                                        <center>
                                            <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('13:00:00', '14:00:00')">
                                                VACANT
                                            </button>
                                        </center>
                                    </th>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <th>
                                    <center>
                                        <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('13:00:00', '14:00:00')">
                                            VACANT
                                        </button>
                                    </center>
                                </th>
                                <?php
                            }
                            ?>
                        </tr>
                        <tr class="bg-light">
                            <th><h6 class="text-center">02:30 PM - 03:30 PM</h6></th>
                            <?php
                            $sql = "SELECT * FROM tbl_appointment WHERE Date = '". date("Y-m-d") ."'";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0)
                            {
                                $isOccupied = false;

                                while($row = mysqli_fetch_array($result))
                                {
                                    $start = date_create($row["Start"]);

                                    if($start >= date_create("14:30:00") && $start <= date_create("15:30:00"))
                                    {
                                        $isOccupied = true;
                                    }
                                }

                                if($isOccupied)
                                {
                                    ?>
                                    <th><h6 class="text-center text-danger">OCCUPIED</h6></th>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <th>
                                        <center>
                                            <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('14:30:00', '15:30:00')">
                                                VACANT
                                            </button>
                                        </center>
                                    </th>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <th>
                                    <center>
                                        <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('14:30:00', '15:30:00')">
                                            VACANT
                                        </button>
                                    </center>
                                </th>
                                <?php
                            }
                            ?>
                        </tr>
                        <tr class="bg-light">
                            <th><h6 class="text-center">04:00 PM - 05:00 PM</h6></th>
                            <?php
                            $sql = "SELECT * FROM tbl_appointment WHERE Date = '". date("Y-m-d") ."'";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0)
                            {
                                $isOccupied = false;

                                while($row = mysqli_fetch_array($result))
                                {
                                    $start = date_create($row["Start"]);

                                    if($start >= date_create("16:00:00") && $start <= date_create("17:00:00"))
                                    {
                                        $isOccupied = true;
                                    }
                                }

                                if($isOccupied)
                                {
                                    ?>
                                    <th><h6 class="text-center text-danger">OCCUPIED</h6></th>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <th>
                                        <center>
                                            <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('16:00:00', '17:00:00')">
                                                VACANT
                                            </button>
                                        </center>
                                    </th>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <th>
                                    <center>
                                        <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('16:00:00', '17:00:00')">
                                            VACANT
                                        </button>
                                    </center>
                                </th>
                                <?php
                            }
                            ?>
                        </tr>
                        <tr class="bg-light">
                            <th><h6 class="text-center">05:30 PM - 06:30 PM</h6></th>
                            <?php
                            $sql = "SELECT * FROM tbl_appointment WHERE Date = '". date("Y-m-d") ."'";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) > 0)
                            {
                                $isOccupied = false;

                                while($row = mysqli_fetch_array($result))
                                {
                                    $start = date_create($row["Start"]);

                                    if($start >= date_create("17:30:00") && $start <= date_create("18:30:00"))
                                    {
                                        $isOccupied = true;
                                    }
                                }

                                if($isOccupied)
                                {
                                    ?>
                                    <th><h6 class="text-center text-danger">OCCUPIED</h6></th>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <th>
                                        <center>
                                            <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('17:30:00', '18:30:00')">
                                                VACANT
                                            </button>
                                        </center>
                                    </th>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <th>
                                    <center>
                                        <button class="btn btn-sm btn-outline-success" onclick="bookAppointment('17:30:00', '18:30:00')">
                                            VACANT
                                        </button>
                                    </center>
                                </th>
                                <?php
                            }
                            ?>
                        </tr>
                    </table>
                </center>
            </div>
        </section>

        <section id="contact">
            <br><br><br>
            <h1 class="text-center text-light">Contact Us</h1>
            <hr>
            <div class="row bg-light">
                <div class="col" style="margin: 40px 20px;">
                    <div class="container-fluid bg-primary text-light text-center" style="border-radius: 20px; padding: 50px 20px">
                        <h1>Dental Care Clinic Management</h1>
                        <h3>979 KUNDIMAN STREET, SAMPALOC 1009 MANILA</h3>
                        <br>
                        <h3>TEL: 666-77-22321</h3>
                        <h3>Cntact: 0922-356-8901</h3>
                    </div>
                </div>
                <div class="col">
                    <center>
                        <img src="img/icon2.png" width="350px" style="margin-top: 30px">
                    </center>
                </div>
            </div>
        </section>
    </span>

    <span id="recordpage" class="visually-hidden">
        <?php
        if(isset($_SESSION["email"]))
        {
            $sql = mysqli_query($conn, "SELECT * FROM tbl_patientinfo WHERE Email = '". $_SESSION["email"] ."'");
        $result = mysqli_fetch_assoc($sql);

        $id = mysqli_real_escape_string($conn, $result["Patient_ID"]);

        $sql = "select * from tbl_patientinfo where Patient_ID = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $rawDate = date_create($row["Date_Registered"]);
        $dateRegistered = date_format($rawDate, "ym");
        $pid = "PID-" . $dateRegistered . "-" . $row["Patient_ID"];
        ?>
        <section id="records">
            <div class="container text-dark bg-light">
                <div class="row">
                    <div class="col">
                        <h3 style="color: dodgerblue">Patient Records</h3>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3">
                                <b>Patient ID: </b>
                            </div>
                            <div class="col-md-8">
                                <p><?php echo $pid; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <b>Patient Name: </b>
                            </div>
                            <div class="col-md-8">
                                <p><?php echo $row["Firstname"] . " " . $row["Lastname"]; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <b>Address: </b>
                            </div>
                            <div class="col-md-8">
                                <p><?php echo $row["Address"]; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <b>Email: </b>
                            </div>
                            <div class="col-md-8">
                                <p><?php echo $row["Email"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
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
                                <img id="user-profile" class="rounded text-end" src="../img/user-1.png" width="150px" heigth="150px">
                                <?php
                            }
                            ?>
                    </div>
                </div>
                <hr>

                <?php
                $totalCharges = 0;
                $totalPayment = 0;
                $totalBalance = 0;

                $sql = "SELECT tbl_invoice.Invoice_No, tbl_patientinfo.Patient_ID, tbl_patientinfo.Date_Registered, tbl_patientinfo.Lastname, tbl_patientinfo.Firstname, tbl_invoice.Amount_Paid, tbl_invoice.Date FROM tbl_patientinfo, tbl_invoice WHERE tbl_invoice.Patient_ID = tbl_patientinfo.Patient_ID AND tbl_patientinfo.Patient_ID = '". $row["Patient_ID"] ."'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) 
                {
                    ?>
                    <div class="containers text-dark">
                            
                    <table id="tbl-services" class="table table-bordered border-dark">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Service Description</th>
                                <th>Charges</th>
                                    <th>Payments</th>
                                <th>Patient Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $services = mysqli_query($conn, "SELECT tbl_services.Service_Description, tbl_services.Charge FROM tbl_services, tbl_invoiceservices WHERE tbl_services.Service_ID = tbl_invoiceservices.Service_ID AND tbl_invoiceservices.Invoice_No = '". $row["Invoice_No"] ."'");
                        $isset = false;
                        $balance = 0;
                        $totalCharge = 0;
                        while($service = mysqli_fetch_array($services))
                        {
                            $total = mysqli_query($conn, "SELECT SUM(tbl_services.Charge) AS Total_Charge FROM tbl_services, tbl_invoiceservices WHERE tbl_services.Service_ID =  tbl_invoiceservices.Service_ID AND tbl_invoiceservices.Invoice_No = '". $row["Invoice_No"] ."'");
                            $totalResult = mysqli_fetch_assoc($total);
                            $totalCharge = $totalResult["Total_Charge"];
                            if($row["Amount_Paid"] < $totalResult["Total_Charge"])
                            {
                                $balance = $totalResult["Total_Charge"] - $row["Amount_Paid"];
                            }
                            
                            ?>
                            <tr>
                                <?php
                                if(!$isset)
                                {
                                    $date = date_create($row["Date"]);
                                    ?>
                                        <td rowspan="<?php echo mysqli_num_rows($services); ?>"><?php echo date_format($date, "m/d/Y"); ?></td>
                                    <?php
                                }
                                ?>
                                <td class="text-start"><?php echo $service["Service_Description"]; ?></td>
                                <td>PHP<?php echo number_format($service["Charge"], 2); ?></td>
                            
                                <?php
                                if(!$isset)
                                {
                                    ?>
                                    <td rowspan="<?php echo mysqli_num_rows($services); ?>">-PHP<?php echo number_format($row["Amount_Paid"], 2); ?></td>
                                    <td rowspan="<?php echo mysqli_num_rows($services); ?>">PHP<?php echo number_format($balance, 2); ?></td>
                                    <?php
                                    $isset = true;
                                }
                                ?>
                            </tr>
                            <?php
                        } 
                        
                        $totalCharges += $totalCharge;
                        $totalPayment += $row["Amount_Paid"];
                        $totalBalance += $balance;  
                    }
                    ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="container-fluid bg-secondary text-light"><b>STATEMENT SUMMARY</b></div>
                            <table class="table table-bordered border-dark">
                                <tr>
                                    <td><small>Total Charges:</small></td>
                                    <td>PHP <?php echo number_format($totalCharges, 2); ?></td>
                                </tr>    
                                <tr>
                                    <td><small>Payment Adjustments:</small></td>
                                    <td>PHP <?php echo number_format($totalPayment, 2); ?></td>
                                </tr>    
                                <tr>
                                    <td><b>Amount Due:</b></td>
                                    <td><b>PHP <?php echo number_format($totalBalance, 2); ?></b></td>
                                </tr>    
                            </table>
                        </div>
                    </div>
                    <?php
                }
            }
                ?>
            </div>
        </section>
    </span>

    <br><br><br><br>

    <div class="modal fade" id="signin-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="server/action.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SIGN IN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <small>Email</small>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email..." required>
                    <br>
                    <center>
                        <div class="g-recaptcha" data-sitekey="6LctU9MfAAAAAPcAza63r79cnTdfo9-aLJeumO7w"></div>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input class="btn btn-primary" name="clientAuth" type="submit" value="Sign In">
                </div>
            </form>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="bookAppointmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Book An Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <?php
                        include("server/db_connection.php");
                        $sql = mysqli_query($conn, "SELECT * FROM tbl_patientinfo WHERE Email = '". $_SESSION["email"] ."'");
                        $row = mysqli_fetch_assoc($sql);
                        ?>
                        <small>Patient Name:</small>
                        <div class="form-control"><?php echo $row["Firstname"] . " " . $row["Lastname"]; ?></div>
                    </div>
                    <div class="col">
                        <small>Date Today:</small>
                        <div class="form-control"><?php echo date("M d, Y"); ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <small>Start of Appointment:</small>
                        <div class="form-control" id="txtStart"></div>
                    </div>
                    <div class="col">
                        <small>End of Appointment:</small>
                        <div class="form-control" id="txtEnd"></div>
                    </div>
                </div>
                <hr>
                <p class="text-center">Reason of Appointment</p>
                <textarea class="form-control" id="txtDescription" style="height: 150px"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="setAppointment()" class="btn btn-primary">Save</button>
            </div>
            </div>
        </div>
    </div>

    <script>
        function bookAppointment(start, end) {
            <?php
            if(isset($_SESSION["email"]))
            {
                ?>
                document.getElementById("txtStart").innerHTML = start;
                document.getElementById("txtEnd").innerHTML = end;

                $("#bookAppointmentModal").modal("show");
                <?php
            }   
            else
            {
                ?>
                $("#signin-modal").modal("show");
                <?php
            } 
            ?>
        }

        function viewRecord(){
            document.getElementById("content").classList.add("visually-hidden");
            document.getElementById("recordpage").classList.remove("visually-hidden");
        }

        function showCOntent(){
            document.getElementById("content").classList.remove("visually-hidden");
            document.getElementById("recordpage").classList.add("visually-hidden");
        }

        function setAppointment() {
            <?php
            if(isset($_SESSION["email"]))
            {
                
                $sql = mysqli_query($conn, "SELECT * FROM tbl_patientinfo WHERE Email = '". $_SESSION["email"] ."'");
                $result = mysqli_fetch_assoc($sql);    
                ?>
                var id = <?php echo date("ymdhms") . $result["Patient_ID"]; ?>;
                var patientId = "<?php echo $result["Patient_ID"]; ?>";
                var description = document.getElementById("txtDescription").value;
                var date = "<?php echo date("Y-m-d"); ?>";
                var start = document.getElementById("txtStart").innerHTML;
                var end = document.getElementById("txtEnd").innerHTML;

                $.ajax({
                    method: 'post',
                    url: 'server/action.php',
                    data: {
                        id: id,
                        patientId: patientId,
                        description: description,
                        date: date,
                        start: start,
                        end: end,
                        event: "setPatientAppointment"
                    },
                    datatype: "text",
                    success: function(data){
                        alert("Appointment has been set successfully!");
                        window.location.href = "index.php";
                    }
                });
            <?php
            }
            ?>  
        }
    </script>
</body>
</html>