<?php
    include("../server/db_connection.php");
    session_start();

    //record log activities...
    function recordLog($conn, $msg) 
    {
        mysqli_query($conn, "INSERT INTO tbl_activitylog (Username, Description, Status) VALUES ('".$_SESSION["adminUser"]."', '$msg', 'unread')");
    }
    
    //admin user signin...
    if(isset($_POST["login"]))
    {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $sql = "select * from tbl_usr where username = '$username' and password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1)
        {
            $row = $result -> fetch_assoc();
            $_SESSION["adminUser"] = $row["UserID"];
            
            recordLog($conn, "Signed In: " . $row["Username"]);
            header("location: ../admin/homepage.php"); 
        }
        else
        {
            $_SESSION['login_error'] = "Login Failed: Please check your email and password";
            header("location: ../admin/index.php"); 
        }
        mysqli_close();
    }

    //admin user signout...
    if(isset($_GET["event"]))
    {
        if($_GET["event"] == "logout")
        {
            $usr = mysqli_query($conn, "SELECT * FROM tbl_usr WHERE UserID = '".$_SESSION["adminUser"]."'");
            $row = mysqli_fetch_assoc($usr);
            recordLog($conn, "Signed Out: " . $row["Username"]);
            unset($_SESSION["adminUser"]);
            header("location: ../admin/index.php");
        }
    }

    //add new patient...
    if(isset($_POST["add-patient"]))
    {
        $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
        $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $contact_no = mysqli_real_escape_string($conn, $_POST["contact_no"]);
        $birthdate = mysqli_real_escape_string($conn, $_POST["birthdate"]);
        $occupation = mysqli_real_escape_string($conn, $_POST["occupation"]);
        $civil_status = mysqli_real_escape_string($conn, $_POST["civil_status"]);
        $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
        $imageName = mysqli_real_escape_string($conn, $_FILES["image"]["name"]);
        $imageData = mysqli_real_escape_string($conn, file_get_contents($_FILES["image"]["tmp_name"]));

        $sql = "INSERT INTO tbl_patientinfo (Firstname, Lastname, Address, Email, Contact, Birthdate, Occupation, Civil_Status, Sex, Picture) VALUES ('$firstname', '$lastname', '$address', '$email', '$contact_no', '$birthdate', '$occupation', '$civil_status', '$gender', '$imageData')";
        if(mysqli_query($conn, $sql))
        {
            recordLog($conn, "Added a new patient: " . $firstname . " " . $lastname);
            header("location: ../admin/homepage.php?page=patients");;
        }
    }

    //update patient info...
    if(isset($_POST["update-patient-info"]))
    {
        $patientID = mysqli_real_escape_string($conn, $_POST["patient-id"]);
        $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
        $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $contact_no = mysqli_real_escape_string($conn, $_POST["contact_no"]);
        $birthdate = mysqli_real_escape_string($conn, $_POST["birthdate"]);
        $occupation = mysqli_real_escape_string($conn, $_POST["occupation"]);
        $civil_status = mysqli_real_escape_string($conn, $_POST["civil_status"]);
        $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
        $imageName = mysqli_real_escape_string($conn, $_FILES["image"]["name"]);
        $imageData = mysqli_real_escape_string($conn, file_get_contents($_FILES["image"]["tmp_name"]));

        $sql = "UPDATE tbl_patientinfo SET Firstname = '$firstname', Lastname = '$lastname', Address = '$address', Email = '$email', Contact = '$contact_no', Birthdate = '$birthdate', Occupation = '$occupation', Civil_Status = '$civil_status', Sex = '$gender', Picture = '$imageData' WHERE Patient_ID = '$patientID'";
        if(mysqli_query($conn, $sql))
        {
            recordLog($conn, "Changed patient information: " . $firstname . " " . $lastname);
            header("location: ../admin/homepage.php?page=patients");
        }
    }

    //remove patient data...
    if(isset($_GET["event"]))
    {
        if($_GET["event"] == "del" && isset($_GET["id"]))
        {
            $patientId = mysqli_real_escape_string($conn, $_GET["id"]);

            $patientName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_patientinfo WHERE Patient_ID = '$patientId'"));
            recordLog($conn, "Remove patient information from Patient list: " . $patientName["Firstname"] . " " . $patientName["Lastname"]);

            $sql = "DELETE FROM tbl_patientinfo WHERE Patient_ID = '$patientId'";
            if(mysqli_query($conn, $sql))
            {
                header("location: ../admin/homepage.php?page=patients");
            }
        }
    }

    //add new service...
    if(isset($_POST["add-service"]))
    {
        $serviceCategory = mysqli_real_escape_string($conn, $_POST["service-category"]);
        $serviceDescription = mysqli_real_escape_string($conn, $_POST["service-description"]);
        $charge = mysqli_real_escape_string($conn, $_POST["charge"]);

        $sql = "INSERT INTO tbl_services (Category, Service_Description, Charge) VALUES ('$serviceCategory', '$serviceDescription', '$charge')";
        if(mysqli_query($conn, $sql))
        {
            recordLog($conn, "Added a new service: " . $serviceDescription);
            header("location: ../admin/homepage.php?page=services");
        }
    }

    //edit service info...
    if(isset($_POST["edit-service"]))
    {
        $serviceId = mysqli_real_escape_string($conn, $_POST["service-id"]);
        $serviceCategory = mysqli_real_escape_string($conn, $_POST["service-category"]);
        $serviceDescription = mysqli_real_escape_string($conn, $_POST["service-description"]);
        $charge = mysqli_real_escape_string($conn, $_POST["charge"]);

        $sql = "UPDATE tbl_services SET Category = '$serviceCategory', Service_Description = '$serviceDescription', Charge = '$charge' WHERE Service_ID = '$serviceId'";
        if(mysqli_query($conn, $sql))
        {
            recordLog($conn, "Changed service information: " . $serviceDescription);
            header("location: ../admin/homepage.php?page=services");
        }
    }

    //remove service...
    if(isset($_GET["event"]) && isset($_GET["wa"]))
    {
        if($_GET["event"] == "del" && $_GET["wa"] == "service" && isset($_GET["id"]))
        {
            $serviceId = mysqli_real_escape_string($conn, $_GET["id"]);

            $sevice = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_services WHERE Service_ID = '$serviceId'"));
            recordLog($conn, "Remove service information from Services: " . $service["Service_Description"]);

            $sql = "DELETE FROM tbl_services WHERE Service_ID = '$serviceId'";
            if(mysqli_query($conn, $sql))
            {
                header("location: ../admin/homepage.php?page=services");
            }
        }
    }

    //set new appointment...
    if(isset($_POST["set-appointment"]))
    {
        $date = mysqli_real_escape_string($conn, $_POST["txt-date"]);
        $start = mysqli_real_escape_string($conn, $_POST["start"]);
        $end = mysqli_real_escape_string($conn, $_POST["end"]);
        $tmp_patientId = explode("-", mysqli_real_escape_string($conn, $_POST["id"]));
        $patientId = $tmp_patientId[2];

        $rawDate = date_create($date);
        $dateRegistered = date_format($rawDate, "ymd");
        $aptid = mysqli_real_escape_string($conn, $dateRegistered . $patientId);

        $query = mysqli_query($conn, "SELECT * FROM tbl_appointment WHERE Date = '$date' AND Start = '$start'");
        if(mysqli_num_rows($query) > 0)
        {
            header("location: ../admin/homepage.php?page=appointments&return=1");
        }
        else
        {
            $sql = "INSERT INTO tbl_appointment (ID, Patient_ID, Date, Start, End, Status) VALUES ('$aptid', '$patientId', '$date', '$start', '$end', 'pending')";
            if(mysqli_query($conn, $sql))
            {
                if(!empty($_POST['service'])) {    
                    foreach($_POST['service'] as $value) {
                        $aptserviceQuery = "INSERT INTO tbl_appointmentservice (Appointment_ID, Service_ID) VALUES ('$aptid', '$value')";
                        mysqli_query($conn, $aptserviceQuery);
                    }
                }
                $patientName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_patientinfo WHERE Patient_ID = '$patientId'"));
                recordLog($conn, "Set a new Appointment: " . $patientName["Firstname"] . " " . $patientName["Lastname"]);

                header("location: ../admin/homepage.php?page=appointments");
            }
            else
            {
                header("location: ../admin/homepage.php?page=appointments&return=0");
            }
        }
    }

    //reschedule appoinment...
    if(isset($_POST["action"]) && $_POST["action"] == 'resched-appointment')
    {
        $aid = mysqli_real_escape_string($conn, $_POST["aid"]);
        $date = mysqli_real_escape_string($conn, $_POST["date"]);
        $start = mysqli_real_escape_string($conn, $_POST["start"]);
        $end = mysqli_real_escape_string($conn, $_POST["end"]);

        $sql = "UPDATE tbl_appointment SET Date = '$date', Start = '$start', End = '$end' WHERE ID = '$aid'";
        if(mysqli_query($conn, $sql))
        {
            $patientName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tbl_patientinfo.Firstname, tbl_patientinfo.Lastname from tbl_patientinfo, tbl_appointment WHERE tbl_appointment.ID = '$aid' AND tbl_appointment.Patient_ID = tbl_patientinfo.Patient_ID"));
            recordLog($conn, "Rescheduled Appointment: " . $patientName["Firstname"] . " " . $patientName["Lastname"]);

            header("location: ../admin/homepage.php?page=appointments");
        }
    }

    //delete appointment...
    if(isset($_POST["deleteApt"]))
    {
        $patientName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tbl_patientinfo.Firstname, tbl_patientinfo.Lastname from tbl_patientinfo, tbl_appointment WHERE tbl_appointment.ID = '". $_POST["deleteApt"] ."' AND tbl_appointment.Patient_ID = tbl_patientinfo.Patient_ID"));
        recordLog($conn, "Deleted Appointment: " . $patientName["Firstname"] . " " . $patientName["Lastname"]);

        $sql = "DELETE FROM tbl_appointment WHERE ID = '".$_POST["deleteApt"]."'";
        if(mysqli_query($conn, $sql))
        {
            header("location: ../admin/homepage.php?page=appointments");
        }
    }

    //admit appointment...
    if(isset($_POST["admitApt"]))
    {
        $sql = "UPDATE tbl_appointment SET Status = 'approved' WHERE ID = '".$_POST["admitApt"]."'";
        if(mysqli_query($conn, $sql))
        {
            $patientName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tbl_patientinfo.Firstname, tbl_patientinfo.Lastname from tbl_patientinfo, tbl_appointment WHERE tbl_appointment.ID = '". $_POST["admitApt"] ."' AND tbl_appointment.Patient_ID = tbl_patientinfo.Patient_ID"));
            recordLog($conn, "Admitted Appointment: " . $patientName["Firstname"] . " " . $patientName["Lastname"]);
    
            header("location: ../admin/homepage.php?page=appointments");
        }
    }

    //clear activity logs...
    if(isset($_POST["action"]) && $_POST["action"] == "clear-logs")
    {
        $sql = "DELETE FROM tbl_activitylog";
        if(mysqli_query($conn, $sql))
        {
        }
    }
?>