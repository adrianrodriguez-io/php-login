<?php

require_once 'config.php';
require_once 'functions.php';

session_start();

//print_r($_SESSION);


if(isset($_SESSION['email_authenticated']) && $_SESSION['email_authenticated'] == true){

//	header('Location: '.$_SERVER['host'].'/analytics/main.php');
	header('Location: main.php');
	
}else{

	$Params = array(); 

	if(is_array($_POST)){
		
		foreach($_POST as $key => $value){
			
			 $Params[$key] = htmlSpecialChars(rtrim(ltrim($value))) ;
				
		}
		
	}

	//print_r($Params);

	LoginCheckUser($ConfigDB,$Params);

}

?>