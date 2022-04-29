<?php
	#include("server/db_connection.php");
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>DentalCare - Home</title>
	<link rel="icon" href="img/icon.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
		<div class="container">
		  <a class="navbar-brand" href="">
        	<img src="img/icon.png" width="40px">
        	DentalCare
      	  </a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav ml-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="https://devmarkportfolio.000webhostapp.com">Contact Developer</a>
		      </li>
		      <li class="nav-item active">
		        <a class="nav-link" href="home.php">About Us</a>
		      </li>
		      <li class="nav-item active">
		        <a class="nav-link" href="#">Our Services</a>
		      </li>
		      <li class="nav-item active">
		        <a class="nav-link" data-toggle="modal" data-target="#sign-in_modal">Sign In</a>
		      </li>
		    </ul>
		  </div>
		</div>
	</nav>

	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	  <ol class="carousel-indicators">
	    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	  </ol>
	  <div class="carousel-inner">
	    <div class="carousel-item active">
	      <img src="img/slide-1.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-md-block">
	        <h5 class="animate__animated animate__bounceIn" style="animation-delay: 1s">A better life starts with a beautiful smile</h5>
	        <p class="animate__animated animate__bounceInLeft" style="animation-delay: 2s"><b>DENTALCARE</b> IS HAPPY TO SERVE</p>
	        <button class="btn btn-primary" data-toggle="modal" data-target="#signup_modal">SET APPOINTMENT NOW</button>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="img/slide-2.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-md-block">
	        <h5 class="animate__animated animate__bounceInDown" style="animation-delay: 1s">Caring for all your family’s dental needs</h5>
	        <p class="animate__animated animate__backInDown" style="animation-delay: 2s"><b>DENTALCARE</b> IS HAPPY TO SERVE</p>
	        <button class="btn btn-primary" data-toggle="modal" data-target="#signup_modal">SET APPOINTMENT NOW</button>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="img/slide-3.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-md-block">
	        <h5 class="animate__animated animate__jello" style="animation-delay: 1s">Changing lives one smile at a time</h5>
	        <p class="animate__animated animate__bounceInRight" style="animation-delay: 2s"><b>DENTALCARE</b> IS HAPPY TO SERVE</p>
	        <button class="btn btn-primary" data-toggle="modal" data-target="#signup_modal">SET APPOINTMENT NOW</button>
	      </div>
	    </div>
	  </div>  

	<!-------------------------------------- Sign-in Modal ----------------------------------------->
	<div class="modal fade" id="sign-in_modal" tabindex="-1" role="dialog">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Sign In to DentalCare</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form method="POST" action="action.php">
	      	<div class="modal-body">
		        <div class="row" style="padding: 5px 50px;">
		        	<label for="#txt_email">Email</label>
		        	<input type="text" id="txt_email" class="form-control" name="email" placeholder="Enter Email..." required>
		        </div>
		        <div class="row" style="padding: 5px 50px;">
		        	<label for="#txt_psw">Password</label>
		        	<input type="password" id="txt_psw" class="form-control" name="password" placeholder="Enter Password..." required>
		        </div>
		        <div class="row" style="padding: 5px 50px;">
		        	<input type="submit" name="login" value="Continue" class="btn-primary form-control" style="color: white; border: 1px solid white;">
		        </div>
		    </div>
		    <div class="modal-footer">
		      	<p>Not a member yet?</p>
		        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signup_modal" data-dismiss="modal" aria-label="Close">Join Now</button>
		    </div>
	      </form>
	    </div>
	  </div>
	</div>

	<!-------------------------------------- Signup Modal ----------------------------------------->
	<div class="modal fade" id="signup_modal" tabindex="-1" role="dialog">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Create Account</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form method="POST" action="action.php">
	      	<div class="modal-body">
	      		<div class="row" style="padding: 5px 50px;">
		        	<label for="#txt_email">Account Type</label>
		        	<select name="account-type" class="form-control" required>
		        		<option value="freelancer">Dentist</option>
		        		<option value="client">Client</option>
		        	</select>
		        </div>
		        <div class="row" style="padding: 5px 50px;">
		        	<label for="#txt_email">Email</label>
		        	<input type="text" id="txt_email" class="form-control" name="email" placeholder="Enter Email..." required>
		        </div>
		        <div class="row" style="padding: 5px 50px;">
		        	<input type="submit" name="signup" value="Continue" class="btn-primary form-control" style="color: white; border: 1px solid white;">
		        	<small>By joining, you are agree to receive emails from DentalCare.</small>
		        </div>
		    </div>
		    <div class="modal-footer">
		      	<p>Already a member?</p>
		        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sign-in_modal" data-dismiss="modal" aria-label="Close">Sign In</button>
		    </div>
	      </form>
	    </div>
	  </div>
	</div>
</body>
</html>

<?php
if(isset($_SESSION['email-validation']))
{
	if ($_SESSION['email-validation'] == "error") 
	{
		?>
		<script>alert("Sorry, your email can't be registered. Let's try another one");</script>
		<?php
		unset($_SESSION['email-validation']);
	}
}
?>
