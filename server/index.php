<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img/icon.png">
    <link rel="stylesheet" type="text/css" href="../includes/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <script src="../includes/bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <title>Dental Care</title>
    <style>
        .disclaimer{
            display: none;
        }
    </style>
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
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <img src="../img/icon.png" alt="" width="45" height="36">
            <a class="navbar-brand" href="#">DENTALCARE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">ABOUT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">CLINIC SERVICES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">APPOINTMENTS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">CONTACT US</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <div class="row">	
		<div class="col-md-5">
			<div class="container">
                <h1 class="thin-font">Dental Consultation</h1>
                <p class="text-light"> Provides care to your teeth,<br>Enhance your tooth<br>health</p>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#signin-modal">
                    <img src="../img/gmail-icon.png" width="32px">
                    SIGN IN WITH EMAIL
                </button>
            </div>
		</div>
		<div class="col-md-6">
			<img src="../img/img1.png" width="100%" style="padding: 20px 20px">
		</div>
	</div>

    <div class="modal fade" id="otp-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="action.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enter Verification Code</h5>
                </div>
                <div class="modal-body">
                    <small>Please check your email for verification code.</small>
                    <div class="row">
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="otp1" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="otp2" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="otp3" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="otp4" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="otp5" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="otp6" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input class="btn btn-primary" name="clientAuth-OTP" type="submit" value="Sign In">
                </div>
            </form>
                
            </div>
        </div>
    </div>
</body>
</html>

<style>
    .form-control {
        text-align: center;
        font-size: 32px;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
</style>