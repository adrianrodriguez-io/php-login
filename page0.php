<?php

// Start a session to persist credentials.
session_start();

//print_r($_SESSION);

if(isset($_SESSION['email_authenticated']) && $_SESSION['email_authenticated'] == true){

$page = $_GET['page'];

if ($page){
    $file = "".$page.".php";
    if (file_exists($file)){
		//echo $file;
        $pagename = $page;
    }else{
        $pagename = "404";
    }
    include("".$pagename.".php");
}else{
    echo 'ADD CONTENT HERE';
}

}else{
	
//	header('Location: '.$_SERVER['host'].'/analytics/login.php');
	header('Location: login.php');

}

?>