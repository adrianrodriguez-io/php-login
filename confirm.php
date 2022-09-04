<?php

require_once 'config.php';
require_once 'functions.php';

session_start();

if(isset($_SESSION['email_authenticated']) && $_SESSION['email_authenticated']){

//	header('Location: '.$_SERVER['host'].'/analytics/main.php');
	header('Location: main.php');

	
}else{

	$Params = array(); 

	if(isset($_GET) && is_array($_GET)){
		
		foreach($_GET as $key => $value){
			
			 $Params[$key] = htmlSpecialChars(rtrim(ltrim($value))) ;
				
		}
		
		if(isset($Params['token']) && isset($Params['id']) && $Params['token'] != '' && $Params['id'] != '' ){
		
			if(CheckTokenEmailVerified($ConfigDB,$Params['token']) == true){
				
				//header('Location: '.$_SERVER['host'].'/analytics/login.php?back=emailconfirmed');
				header('Location: login.php?back=emailconfirmed');

			}else{
				
				ConfirmTokenEmailVerification($ConfigDB,$Params);
			
			}
		
		}else{
	
//			header('Location: '.$_SERVER['host'].'/analytics/login.php?back=error');
			header('Location: login.php?back=error');
	
		}
	
	}else{
	
//		header('Location: '.$_SERVER['host'].'/analytics/login.php');
		header('Location: login.php');
	
	}
	
}

?>