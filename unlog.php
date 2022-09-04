<?php

// Start a session to persist credentials.
session_start();

if(isset($_SESSION['email_authenticated']) && $_SESSION['email_authenticated']){

	session_destroy();

//	header('Location: '.$_SERVER['host'].'/analytics/login.php');
	header('Location: login.php');
	
}else{

//	header('Location: '.$_SERVER['host'].'/analytics/login.php');
	header('Location: login.php');

}


?>