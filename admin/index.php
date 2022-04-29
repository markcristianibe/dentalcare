<?php
session_start();
if(isset($_SESSION["adminUser"]))
{
  header("location: homepage.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <link href="../includes/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
	<link rel="icon" href="../img/icon.png">
    
	<script type="text/javascript">
		var visible = false;

		function ShowPassword(){
			if(visible)
			{
				document.getElementById("password").setAttribute("type", "password");
				visible = false;
			}
			else
			{
				document.getElementById("password").setAttribute("type", "text");
				visible = true;
			}
		}
	</script>
</head>
<body>
	<div class="content">
		<img class="user-profile-image" src="../img/user.png">
		<h3>SIGN IN TO YOUR ACCOUNT</h3>
		<?php
		include("../img/icons.php");
		if(isset($_SESSION['login_error']))
		{
			?>
			<div class="alert alert-danger" role="alert">
				<small>
					<svg class="bi me-2" width="16" height="16"><use xlink:href="#warning"/></svg>
					<?php echo $_SESSION["login_error"]; ?>
				</small>
			</div>
			<?php
			unset($_SESSION["login_error"]);
		}
		?>
		<form action="../server/action.php" method="POST">
			<input class="input-control" type="text" name="username" placeholder="&#xf007; Username...">
			<input class="input-control" id="password" type="password" name="password" placeholder="&#xf023; Password...">
			<a id="show-psw-btn" onclick="ShowPassword()"><i class="fontawesome fa-solid fa-eye"> </i></a>
			
			<div class="cols">
				<input type="checkbox" name="keep_signed_in" id="checkbox">
				<label for="checkbox">Keep me signed in</label>
			</div>
			<input type="submit" name="login" class="button" value="SIGN IN">
			<a class="hyperlink" href="#">Forgot your password?</a>
		</form>
		
		<br>
	</div>
</body>
</html>