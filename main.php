<?php

// Start a session to persist credentials.
session_start();

//print_r($_SESSION);

if(isset($_SESSION['email_authenticated']) && $_SESSION['email_authenticated']){

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

</head>
<body>
<nav class="navbar navbar-default">
<ul  class="nav navbar-nav pull-right">
<li class=""><a href="<?php echo 'unlog.php'; ?>"><strong></strong>
							<span class="glyphicon glyphicon-off pull-right"></span>
							<span class="sr-only">(current)</span></a></li>

</ul>
</nav>
	
	
	<div class="container">
	 <div class="row">
        <div class="col-sm-12 col-md-12">
		<div class="alert alert-info" role="alert"><span>
		<?php echo "Hello world!"; ?>
		</span></div>
		</div>
	  </div>
	</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>   
</body>
</html>
<?php
	
}else{

//header('Location: '.$_SERVER['host'].'/analytics/login.php');
header('Location: login.php');

}


?>