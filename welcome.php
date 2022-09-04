<?php

require_once 'config.php';
require_once 'functions.php';

// Start a session to persist credentials.
session_start();

if(isset($_SESSION['email_authenticated']) && $_SESSION['email_authenticated']){

//	header('Location: '.$_SERVER['host'].'/analytics/main.php');
	header('Location: main.php');
	
}elseif(is_array($_GET) && $_GET){

		$GetParams = array();
		
		foreach($_GET as $key => $value){
		
		 $GetParams[$key] = htmlSpecialChars(rtrim(ltrim($value))) ;
		 
		}
		
		
		if(isset($GetParams['back']) && isset($GetParams['id']) && $GetParams['back'] == 'sendemail' && $GetParams['id'] != '' && GetEmail($ConfigDB,$EmailTokenized)){
		
		
		$GetParams['InputEmail'] = GetEmail($ConfigDB,$GetParams['id']); 
		$GetParams['tok_InputEmail'] = $GetParams['id'];
			
		//send email again
		GenEmailTokenConfirmation($ConfigDB,$GetParams);
		
		
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-default">
<ul  class="nav navbar-nav">
<li class=""><a href="<?php echo 'login.php'; ?>">Sign In<span class="sr-only">(current)</span></a></li>
</ul>
</nav>
	<div class="container">
	 <div class="row">
        <div class="col-sm-12 col-md-12">
		<div class="alert alert-info" role="alert"><span>
		<?php echo "We have sent a confirmation email to your inbox in order to finish you to be registered. <a href='welcome.php?back=sendemail&id=".$GetParams['id']."'><strong>click aqui</strong></a>"; ?>
		</span></div>
		</div>
	  </div>
	</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
<?php	

		}else{
		
	//		header('Location: '.$_SERVER['host'].'/analytics/login.php');
			header('Location: login.php');
			
		}
		

	}elseif(is_array($_POST) && $_POST){
	
		$Params = array(); 
	
		foreach($_POST as $key => $value){
		
		 $Params[$key] = htmlSpecialChars(rtrim(ltrim($value))) ;
		 
		}
		
		foreach($_POST as $key => $value){
		
		 $Params['tok_'.$key] = md5(htmlSpecialChars(rtrim(ltrim($value)))) ;
		 
		}

	if(!isset($Params['InputEmail']) Or strlen($Params['InputEmail']) == 0 ){

		header('Location: '.$_SERVER['host'].'/analytics/register.php?back=bademail');

	}elseif(RegisterCheckEmail($ConfigDB,$Params) == true){
		
//			header('Location: '.$_SERVER['host'].'/analytics/register.php?back=emailexist');
			header('Location: register.php?back=emailexist');
		
	}elseif(!isset($Params['InputPassword']) Or !isset($Params['ConfirmInputPassword']) Or strlen($Params['InputPassword']) == 0 Or ($Params['InputPassword'] != $Params['ConfirmInputPassword'])){

//		header('Location: '.$_SERVER['host'].'/analytics/register.php?back=notequalpass');
		header('Location: register.php?back=notequalpass');

	}else{

		RegisterUser($ConfigDB,$Params);		

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-default">
<ul  class="nav navbar-nav">
<li class=""><a href="<?php echo 'login.php'; ?>"><strong>Sign In</strong><span class="sr-only">(current)</span></a></li>
</ul>
</nav>
	<div class="container">
	 <div class="row">
        <div class="col-sm-12 col-md-12">
		<div class="alert alert-info" role="alert"><span>
		<?php echo "We have sent a confirmation email to your inbox. If you have not received it yet <a href='"."welcome.php?back=sendemail&id=".md5($Params['InputEmail'])."'><strong>click here</strong></a>"; ?>
		</span></div>
		</div>
	  </div>
	</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
<?php	

	}

}else{

//	header('Location: '.$_SERVER['host'].'/analytics/login.php');
	header('Location: login.php');


}

?>