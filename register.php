<?php

require_once 'config.php';
require_once 'functions.php';

session_start();


if(isset($_SESSION['email_authenticated']) && $_SESSION['email_authenticated']){

//	header('Location: '.$_SERVER['host'].'/analytics/main.php');
	header('Location: main.php');
	
}else{
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-default">
<ul  class="nav navbar-nav pull-right">
<li class=""><a href="<?php echo 'login.php'; ?>"><strong>Sign In</strong><span class="sr-only">(current)</span></a></li>
</ul>
</nav>
	<div class="container">
	 <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
		<?php if(isset($_GET['back']) && $_GET['back'] == 'out'){ ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong></strong>We are sorry, an error has happend. 
		</div>
		<?php } ?>
		<?php if(isset($_GET['back']) && $_GET['back'] == 'error'){ ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong></strong>We are sorry, an error has happend. 
		</div>
		<?php } ?>
		<?php if(isset($_GET['back']) && $_GET['back'] == 'notequalpass'){ ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong></strong>Please conrirm your password  
		</div>
		<?php } ?>
		<?php if(isset($_GET['back']) && $_GET['back'] == 'emailexist'){ ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong></strong>Email already exists
		</div>
		<?php } ?>
		<?php if(isset($_GET['back']) && $_GET['back'] == 'userexist'){ ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong></strong>User already exists 
		</div>
		<?php } ?>
		<?php if(isset($_GET['back']) && $_GET['back'] == 'errorregister'){ ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong></strong>We are sorry, something went wrong
		</div>
		<?php } ?>
		<?php if(isset($_GET['back']) && $_GET['back'] == 'errorcheck'){ ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong></strong>We are sorry, something went wrong
		</div>
		<?php } ?>
		<?php if(isset($_GET['back']) && $_GET['back'] == 'errorconfirm'){ ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong></strong>We are sorry, we couldnt verify your email
		</div>
		<?php } ?>
		<form method="post" action="<?php echo 'welcome.php'; ?>">
		  <div class="form-group">
			<label for="InputEmail">Email</label>
			<input type="Email" name="InputEmail" class="form-control" id="InputEmail" placeholder="Email">
		  </div>
		  <div class="form-group">
			<label for="InputPassword">Password</label>
			<input type="password" name="InputPassword" class="form-control" id="InputPassword" placeholder="Password">
		  </div>
		  <div class="form-group">
			<label for="ConfirmInputPassword">Confirm Password</label>
			<input type="password" name="ConfirmInputPassword" class="form-control" id="ConfirmInputPassword" placeholder="Confirm Password">
		  </div>
		  <button type="submit" class="btn btn-default">Submit</button>
		</form>
		</div>
	  </div>
	</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
<?php
	
}

?>