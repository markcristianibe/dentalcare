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
        $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));

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

    //client signout...
    if(isset($_GET["event"]))
    {
        if($_GET["event"] == "client-signout")
        {
            session_start();
            unset($_SESSION["email"]);
            header("location: ../index.php");
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

        $sql = "UPDATE tbl_appointment SET Status = 'deleted' WHERE ID = '".$_POST["deleteApt"]."'";
        if(mysqli_query($conn, $sql))
        {
            header("location: ../admin/homepage.php?page=appointments");
        }
    }

    //admit appointment...
    if(isset($_POST["admitApt"]))
    {
        $sql = "UPDATE tbl_appointment SET Incharge = '". $_SESSION["adminUser"] ."', Status = 'approved' WHERE ID = '".$_POST["admitApt"]."'";
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

    //add new supply...
    if(isset($_POST["add-supply"]))
    {
        $supplyCategory = mysqli_real_escape_string($conn, $_POST["supply-category"]);
        $productName = mysqli_real_escape_string($conn, $_POST["supply-name"]);
        $stocks = mysqli_real_escape_string($conn, $_POST["stocks"]);
        $psl = mysqli_real_escape_string($conn, $_POST["psl"]);

        $sql = "INSERT INTO tbl_supplies (Category, Product_Name, Stocks, Par_Stock_Level) VALUES ('$supplyCategory', '$productName', '$stocks', '$psl')";
        if(mysqli_query($conn, $sql))
        {
            recordLog($conn, "Added a new item to inventory: " . $productName);
            header("location: ../admin/homepage.php?page=inventory&tab=supplies");
        }
    }

    //add supply stock...
    if(isset($_POST["add-supplies-stock"]))
    {
        $pid = mysqli_real_escape_string($conn, $_GET["id"]);
        $quantity = mysqli_real_escape_string($conn, $_POST["quantity"]);

        $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_supplies WHERE Product_ID = '$pid'"));
        $old = $row["Stocks"];
        $new = $old + $quantity;
        
        $sql = "UPDATE tbl_supplies SET Stocks = '$new' WHERE Product_ID = '$pid'";
        if(mysqli_query($conn, $sql))
        {
            recordLog($conn, "Added supply stock for ". $row["Product_Name"] . ". New stocks is " . $new);
            header("location: ../admin/homepage.php?page=inventory&tab=supplies");
        }
    }

    //edit supply information...
    if(isset($_POST["edit-supply"]))
    {
        $id = mysqli_real_escape_string($conn, $_GET["id"]);
        $supplyCategory = mysqli_real_escape_string($conn, $_POST["supply-category"]);
        $productName = mysqli_real_escape_string($conn, $_POST["supply-name"]);
        $stocks = mysqli_real_escape_string($conn, $_POST["stocks"]);
        $psl = mysqli_real_escape_string($conn, $_POST["psl"]);

        $sql = "UPDATE tbl_supplies SET Category = '$supplyCategory', Product_Name = '$productName', Stocks = '$stocks', Par_Stock_Level = '$psl' WHERE Product_ID = '$id'";
        if(mysqli_query($conn, $sql))
        {
            recordLog($conn, "Changed item information in supplies inventory.");
            header("location: ../admin/homepage.php?page=inventory&tab=supplies");
        }
    }

    //delete item from supplies inventory...
    if(isset($_POST["action"]) && $_POST["action"] == "delete-supply-item")
    {
        $id = mysqli_real_escape_string($conn, $_POST["productId"]);

        $item = mysqli_query($conn, "SELECT * FROM tbl_supplies WHERE Product_ID = '$id'");
        $row = mysqli_fetch_assoc($item);
        recordLog($conn, "Removed item from supplies inventory: " . $row["Product_Name"]);
        $sql = "DELETE FROM tbl_supplies WHERE Product_ID = '$id'";
        mysqli_query($conn, $sql);
    }

    //add new medicine...
    if(isset($_POST["addMedication"]))
    {
        $brand = mysqli_real_escape_string($conn, $_POST["brand"]);
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $dosage = mysqli_real_escape_string($conn, $_POST["dosage"]);
        $price = mysqli_real_escape_string($conn, $_POST["price"]);
        $psl = mysqli_real_escape_string($conn, $_POST["psl"]);
        
        if($brand != "" && $name != "" && $dosage !="" && $price != "" && $psl != "")
        {
            $sql = "INSERT INTO tbl_medications (Brand, Name, Unit, Price, Par_Stock_Level) VALUES ('$brand', '$name', '$dosage', '$price', '$psl')";
            if(mysqli_query($conn, $sql))
            {
                recordLog($conn, "Added new item in medicines inventory.");
                header("location: ../admin/homepage.php?page=inventory&tab=medications");
            }
        }
        else
        {
            header("location: ../admin/homepage.php?page=inventory&tab=medications&error=1");
        }
    }

    //edit medicine info...
    if(isset($_POST["editMedication"]))
    {
        $id = mysqli_real_escape_string($conn, $_GET["id"]);
        $brand = mysqli_real_escape_string($conn, $_POST["brand"]);
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $dosage = mysqli_real_escape_string($conn, $_POST["dosage"]);
        $price = mysqli_real_escape_string($conn, $_POST["price"]);
        $psl = mysqli_real_escape_string($conn, $_POST["psl"]);
        
        if($brand != "" && $name != "" && $dosage !="" && $price != "" && $psl != "")
        {
            $sql = "UPDATE tbl_medications SET Brand = '$brand', Name = '$name', Unit = '$dosage', Price = '$price', Par_Stock_Level = '$psl' WHERE Product_ID = '$id'";
            if(mysqli_query($conn, $sql))
            {
                recordLog($conn, "Changed item info in medicines inventory.");
                header("location: ../admin/homepage.php?page=inventory&tab=medications");
            }
        }
        else
        {
            header("location: ../admin/homepage.php?page=inventory&tab=medications&error=1");
        }
    }

    //add batch...
    if(isset($_POST["addBatch"]))
    {
        $pid = mysqli_real_escape_string($conn, $_POST["id"]);
        $quantity = mysqli_real_escape_string($conn, $_POST["quantity"]);
        $exp = mysqli_real_escape_string($conn, $_POST["expiry"]);

        if($pid != "" && $quantity != "" && $exp != "")
        {
            $sql = "INSERT INTO tbl_batches (Product_ID, Quantity, Expiry_Date) VALUES ('$pid', '$quantity', '$exp')";
            if(mysqli_query($conn, $sql))
            {
                $name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_medications WHERE Product_ID = '$pid'"));
                recordLog($conn, "Added new batches of medicines in inventory: " . $name["Brand"] . " " . $name["Name"] . " " . $name["Unit"]);
                header("location: ../admin/homepage.php?page=inventory&tab=medications");
            }
        }
        else
        {
            header("location: ../admin/homepage.php?page=inventory&tab=medications&error=1");
        }
    }

    //add new user account...
    if(isset($_POST["add-user"]))
    {
        $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
        $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $birthdate = mysqli_real_escape_string($conn, $_POST["birthdate"]);
        $civilStatus = mysqli_real_escape_string($conn, $_POST["civil-status"]);
        $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));
        $imageName = mysqli_real_escape_string($conn, $_FILES["image"]["name"]);
        $imageData = mysqli_real_escape_string($conn, file_get_contents($_FILES["image"]["tmp_name"]));

        $sql = "INSERT INTO tbl_usr (Firstname, Lastname, Address, Birthdate, Civil_Status, Gender, Username, Password, Picture) VALUES ('$firstname', '$lastname', '$address', '$birthdate', '$civilStatus', '$gender', '$username', '$password', '$imageData')";
        if(mysqli_query($conn, $sql))
        {
            if(!empty($_POST['permission'])) {    
                foreach($_POST['permission'] as $value) {
                    $usrID = mysqli_query($conn, "SELECT * FROM tbl_usr WHERE Username = '$username'");
                    $uID = mysqli_fetch_assoc($usrID); 
                    $permissionQuery = "INSERT INTO tbl_userpermissions (User_ID, Permission) VALUES ('". $uID["UserID"] ."', '$value')";
                    mysqli_query($conn, $permissionQuery);
                }
            }
            recordLog($conn, "Added New User Account: " . $firstname . " " . $lastname);

            header("location: ../admin/homepage.php?page=dashboard");
        }
    }

    //delete user account...
    if(isset($_POST["action"]) && $_POST["action"] == "deleteAccount")
    {
        $id = mysqli_real_escape_string($conn, $_POST["userID"]);

        $query = mysqli_query($conn, "SELECT * FROM tbl_usr WHERE UserID = '$id'");
        $result = mysqli_fetch_assoc($query);

        $sql = "DELETE FROM tbl_usr WHERE UserID = '$id'";
        if(mysqli_query($conn, $sql))
        {
            mysqli_query($conn, "DELETE FROM tbl_userpermissions WHERE User_ID = '$id'");
            recordLog($conn, "Remove User Account: " . $result["Firstname"] . " " . $result["Lastname"]);

            $sql = "SELECT * FROM tbl_usr";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_array($result))
            {
                if($row["UserID"] == 1)
                {
                    echo "
                    <tr>
                    <th scope='row'>". $row["Username"] ."</th>
                    <td>". $row["Lastname"] . " " . $row["Firstname"] ."</td>
                    <td>
                    <a href='#' class='circle btn btn-success'><i class='fa fa-pen'></i></a>
                    <a href='#' class='circle btn btn-danger disabled'><i class='fa fa-trash'></i></a>
                    </td>
                    </tr>
                    ";
                }
                    else
                    {
                    echo "
                    <tr>
                    <th scope='row'>". $row["Username"] ."</th>
                    <td>". $row["Lastname"] . " " . $row["Firstname"] ."</td>
                    <td>
                    <a href='#' class='circle btn btn-success'><i class='fa fa-pen'></i></a>
                    <a href='#' class='circle btn btn-danger' onclick='deleteAccount(". $row["UserID"] .")'><i class='fa fa-trash'></i></a>
                    </td>
                    </tr>
                    ";
                }
            }
        }
    }

    //edit user account info...
    if(isset($_POST["edit-user"]))
    {
        $userID = mysqli_real_escape_string($conn, $_GET["id"]);
        $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
        $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $birthdate = mysqli_real_escape_string($conn, $_POST["birthdate"]);
        $civilStatus = mysqli_real_escape_string($conn, $_POST["civil-status"]);
        $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $imageName = mysqli_real_escape_string($conn, $_FILES["image"]["name"]);
        $imageData = mysqli_real_escape_string($conn, file_get_contents($_FILES["image"]["tmp_name"]));
        
        if($_POST["image"] == "")
        {
            $sql = "";
            if(!isset($_POST["password"]) || $_POST["password"] == "")
            {
                $sql = "UPDATE tbl_usr SET Firstname = '$firstname', Lastname = '$lastname', Address = '$address', Birthdate = '$birthdate', Civil_Status = '$civilStatus', Gender = '$gender', Username = '$username' WHERE UserID = '$userID'";
            }
            else
            {
                $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));
                $sql = "UPDATE tbl_usr SET Firstname = '$firstname', Lastname = '$lastname', Address = '$address', Birthdate = '$birthdate', Civil_Status = '$civilStatus', Gender = '$gender', Username = '$username', Password = '$password' WHERE UserID = '$userID'";
            }

            if(mysqli_query($conn, $sql))
            {
                if(!empty($_POST['permission'])) {    
                    foreach($_POST['permission'] as $value) {
                        $usrID = mysqli_query($conn, "SELECT * FROM tbl_usr WHERE Username = '$username'");
                        $uID = mysqli_fetch_assoc($usrID); 
                        $permissionQuery = "INSERT INTO tbl_userpermissions (User_ID, Permission) VALUES ('". $uID["UserID"] ."', '$value')";
                        mysqli_query($conn, $permissionQuery);
                    }
                }
                
                recordLog($conn, "Edited User Account Information: " . $firstname . " " . $lastname);
                header("location: ../admin/homepage.php?page=dashboard");
            }
        }
        else
        {
            $sql = "";
            if(!isset($_POST["password"]) || $_POST["password"] == "")
            {
                $sql = "UPDATE tbl_usr SET Firstname = '$firstname', Lastname = '$lastname', Address = '$address', Birthdate = '$birthdate', Civil_Status = '$civilStatus', Gender = '$gender', Username = '$username', Picture = '$imageData' WHERE UserID = '$userID'";
            }
            else
            {
                $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));
                $sql = "UPDATE tbl_usr SET Firstname = '$firstname', Lastname = '$lastname', Address = '$address', Birthdate = '$birthdate', Civil_Status = '$civilStatus', Gender = '$gender', Username = '$username', Password = '$password', Picture = '$imageData' WHERE UserID = '$userID'";
            }

            if(mysqli_query($conn, $sql))
            {
                if(!empty($_POST['permission'])) {    
                    foreach($_POST['permission'] as $value) {
                        $usrID = mysqli_query($conn, "SELECT * FROM tbl_usr WHERE Username = '$username'");
                        $uID = mysqli_fetch_assoc($usrID); 
                        $permissionQuery = "INSERT INTO tbl_userpermissions (User_ID, Permission) VALUES ('". $uID["UserID"] ."', '$value')";
                        mysqli_query($conn, $permissionQuery);
                    }
                }
                
                recordLog($conn, "Edited User Account Information: " . $firstname . " " . $lastname);
                header("location: ../admin/homepage.php?page=dashboard");
            }
        }
    }

    //create invoice...
    if(isset($_POST["create-invoice"]))
    {
        $invoiceNo = mysqli_real_escape_string($conn, $_POST["invoiceNo"]);
        $tmp_patientId = explode("-", mysqli_real_escape_string($conn, $_POST["patientId"]));
        $patientID = $tmp_patientId[2];
        $amountPaid = mysqli_real_escape_string($conn, $_POST["amountPaid"]);
        $total = mysqli_real_escape_string($conn, $_POST["total"]);
        
        if($amountPaid > $total)
        {
            $amountPaid = $total;
        }

        $sql = "INSERT INTO tbl_invoice (Invoice_No, Patient_ID, Amount_Paid) VALUES ('$invoiceNo', '$patientID', '$amountPaid')";
        if(mysqli_query($conn, $sql))
        {
            if(!empty($_POST['service'])) {    
                foreach($_POST['service'] as $value) {
                    
                    $sql = "INSERT INTO tbl_invoiceservices (Invoice_No, Service_ID) VALUES ('$invoiceNo', '$value')";
                    mysqli_query($conn, $sql);
                }
            }
            header("location: ../templates/invoices/receipt.php?id=". $invoiceNo);
        }
    }

    //set patient appointment...
    if(isset($_POST["event"]) && $_POST["event"] == "setPatientAppointment")
    {
        $id = mysqli_real_escape_string($conn, $_POST["id"]);
        $patientId = mysqli_real_escape_string($conn, $_POST["patientId"]);
        $description = mysqli_real_escape_string($conn, $_POST["description"]);
        $date = mysqli_real_escape_string($conn, $_POST["date"]);
        $start = mysqli_real_escape_string($conn, $_POST["start"]);
        $end = mysqli_real_escape_string($conn, $_POST["end"]);

        $sql = "INSERT INTO tbl_appointment (ID, Patient_ID, Description, Date, Start, End, Status) VALUES ('$id', '$patientId', '$description', '$date', '$start', '$end', 'pending')";
        mysqli_query($conn, $sql);
    }
?>



<?php
//recaptcha....
// Checks if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["clientAuth"])) {
    function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6LctU9MfAAAAAO51Qe5PB0T4FVc3fFIGX8IzcwND',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    // Call the function post_captcha
    $res = post_captcha($_POST['g-recaptcha-response']);

    if (!$res['success']) {
        // What happens when the CAPTCHA wasn't checked
        header("location: ../index.php?recaptcha-error=1");
    } else {
        // If CAPTCHA is successfully completed...
        
        $fromEmail = "Dental Care";
        $toEmail = mysqli_real_escape_string($conn, $_POST["email"]);
        $subjectName = 'Email Verification';
        
        $check = mysqli_query($conn, "SELECT * FROM tbl_patientinfo WHERE Email = '$toEmail'");
        if(mysqli_num_rows($check) > 0)
        {
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $message = '<p>Your verification code is <b>'. $verification_code .'</b></p>';

            $to = $toEmail;
            $subject = $subjectName;
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: '.$fromEmail.'<'.$fromEmail.'>' . "\r\n".'Reply-To: '.$fromEmail."\r\n" . 'X-Mailer: PHP/' . phpversion();
            $message = '<!doctype html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport"
                            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>Document</title>
                    </head>
                    <body>
                    <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">'.$message.'</span>
                        <div class="container">
                        '.$message.'<br/>
                            Regards<br/>
                        '.$fromEmail.'
                        </div>
                    </body>
                    </html>';
            $result = @mail($to, $subject, $message, $headers);

            if($result) 
            {
                mysqli_query($conn, "UPDATE tbl_patientinfo SET OTP = '$verification_code' WHERE Email = '$toEmail'");
                include("../server/index.php");
                $_SESSION["email-temp"] = $toEmail;
                echo "<script>
                    $(document).ready(function(){
                        $('#otp-modal').modal('show');
                    });
                </script>";
            }
        }
        else
        {
            header("location: ../index.php?auth=0");
        }
    }
} else { ?>
    
<!-- FORM GOES HERE -->
<form></form>

<?php } ?>

<?php
//OTP check...
if(isset($_POST["clientAuth-OTP"]))
{
    $email = mysqli_real_escape_string($conn, $_SESSION["email-temp"]);
    $otp = mysqli_real_escape_string($conn, $_POST["otp1"].$_POST["otp2"].$_POST["otp3"].$_POST["otp4"].$_POST["otp5"].$_POST["otp6"]);
    $sql = mysqli_query($conn, "SELECT * FROM tbl_patientinfo WHERE OTP = '$otp' AND Email = '$email'");
    if(mysqli_num_rows($sql) > 0)
    {
        $_SESSION["email"] = $email;
        header("location: ../index.php");
    }
    else
    {
        unset($_SESSION["email"]);
        header("location: ../index.php?auth-verification=0");
    }
}
?>