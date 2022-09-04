<?php

// Start a session to persist credentials.
session_start();

//print_r($_SESSION);

if( (isset($_SESSION['email_authenticated']) && $_SESSION['email_authenticated'] ) == false){
header('Location: login.php'); //'.$_SERVER['host']./analytics/

}

?>
<html>
<head>
</head>
<body>
<a href='unlog.php'>Unlog</a>
</body>
</html>