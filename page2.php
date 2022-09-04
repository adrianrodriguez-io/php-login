<?php
// Start a session to persist credentials.
//session_start();

//print_r($_SESSION);

if(isset($_SESSION['email_authenticated']) && $_SESSION['email_authenticated'] == true){

echo 'page 2';

}else{
	
//	header('Location: '.$_SERVER['host'].'/analytics/login.php');
	header('Location: login.php');

}


?>