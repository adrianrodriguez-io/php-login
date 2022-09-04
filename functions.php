<?php



//LoginCheckUser: bla bla 
function LoginCheckUser($ConfigDB,$Params){
	
	$conn = new mysqli( $ConfigDB['host'], $ConfigDB['user'], $ConfigDB['password'], $ConfigDB['database'] );
	if ($conn->connect_errno) {

//	 	header('Location: '.$_SERVER['host'].'/analytics/login.php?back=error');
	 	header('Location: login.php?back=error');


	}

	$SqlCheckUser =  " SELECT Email, CASE WHEN Email IN (SELECT Email FROM emailtokenconfirmations WHERE Verified = 1) THEN true ELSE false END AS Authenticated "
					." FROM users "
					." WHERE Email = '".$Params['InputEmail']."' AND Password = '".md5($Params['InputPassword'])."' ;";
						
	$rs = $conn->query($SqlCheckUser);
    
	$row = array();
	
	if(isset($rs) && $rs->num_rows != 0){
		$row = $rs->fetch_array(MYSQLI_ASSOC);		
		}
		
		if (!isset($rs) Or $rs->num_rows == 0 ) {
		
			if(isset($conn)){
				$conn->close();
				}
		
		//header('Location: '.$_SERVER['host'].'/analytics/login.php?back=wrong');
		header('Location: login.php?back=wrong');
		
		}elseif(isset($rs) && $row['Authenticated'] == false){
		
			if(isset($conn)){
				$conn->close();
				}
					
			//header('Location: '.$_SERVER['host'].'/analytics/welcome.php?back=sendemail&id='.md5($row['Email']));
			header('Location: welcome.php?back=sendemail&id='.md5($row['Email']));
		
		}elseif(isset($rs) && $row['Authenticated'] == true){
			
			$_SESSION['email_authenticated'] = $row['Authenticated'];
			$_SESSION['email'] = $row['Email'];
			
			if(isset($conn)){
				$conn->close();
				}
			
			if(!isset($_SESSION['email_authenticated']) Or $_SESSION['email_authenticated'] == false ){
			
				//header('Location: '.$_SERVER['host'].'/analytics/login.php?back=noauth');
				header('Location: login.php?back=noauth');
			
			}else{
			
				//header('Location: '.$_SERVER['host'].'/analytics/main.php');
				header('Location: main.php');
			
			}
			
		}
	
}

//RegisterCheckEmail: bla bla 
function RegisterCheckEmail($ConfigDB,$Params){
	
	$conn = new mysqli( $ConfigDB['host'], $ConfigDB['user'], $ConfigDB['password'], $ConfigDB['database'] );
	if ($conn->connect_errno) {

	// 	header('Location: '.$_SERVER['host'].'/analytics/register.php?back=out');
	 	header('Location: register.php?back=out');

	}

	$SqlCheckEmail = " SELECT true AS Checked"
					." FROM users "
					." WHERE  Email = '".$Params['InputEmail']."' LIMIT 1;"; // AND PassWord = '".md5($Params['InputPassword'])."';";
		
	$rs = $conn->query($SqlCheckEmail);
	
		if(isset($conn)){
		$conn->close();
		}

	$row = $rs->fetch_array(MYSQLI_ASSOC);
		
	if (isset($row['Checked']) && $row['Checked'] == true ) {
	
		return true;
		
	}else{
	
		return false;
		
	}
	
}

//RegisterUser: bla bla 
function RegisterUser($ConfigDB,$Params){

	
	$conn = new mysqli( $ConfigDB['host'], $ConfigDB['user'], $ConfigDB['password'], $ConfigDB['database'] );
	if ($conn->connect_errno) {

	//	header('Location: '.$_SERVER['host'].'/analytics/register.php?back=errorregister');
	 	header('Location: register.php?back=errorregister');

	}

	$SqlRegisterUser = " INSERT INTO users ( Email, Password ) " 
					." SELECT '".$Params['InputEmail']."' , '".$Params['tok_InputPassword']."' "
					. " FROM dual "
					." WHERE '".$Params['InputEmail']."' NOT IN (SELECT Email FROM users); "; 
						
	$rs = $conn->query($SqlRegisterUser);
		
	if(isset($conn)){
				$conn->close();
				}
	
	if (isset($rs) && $rs == 0 ) {
		
//			header('Location: '.$_SERVER['host'].'/analytics/register.php?back=emailexist');
			header('Location: register.php?back=emailexist');

		
	}elseif(isset($rs) && $rs != 0){
	
		GenEmailTokenConfirmation($ConfigDB,$Params);
	
	}
	
}

//GenEmailTokenConfirmation: 		
function GenEmailTokenConfirmation($ConfigDB,$Params){
		
				$conn = new mysqli( $ConfigDB['host'], $ConfigDB['user'], $ConfigDB['password'], $ConfigDB['database'] );
				if ($conn->connect_errno) {

//					header('Location: '.$_SERVER['host'].'/analytics/register.php?back=error');
					header('Location: register.php?back=error');

				}
					
				
					$GenToken = md5($Params['InputEmail'].time());
				
					$SqlGenTokenEmailConfirmation = " INSERT INTO emailtokenconfirmations ( Email, Token ) "
													." SELECT '".$Params['InputEmail']."' , '".$GenToken."'"
													. " FROM dual"
													." WHERE '".$Params['InputEmail']."' IN (SELECT Email FROM users);";
													
					$rs = $conn->query($SqlGenTokenEmailConfirmation);	
					
					if (isset($rs) && $rs == 0 ) {
		
//						header('Location: '.$_SERVER['host'].'/analytics/welcome.php?back=sendemail&id='.$Params['tok_InputEmail']);
						header('Location: welcome.php?back=sendemail&id='.$Params['tok_InputEmail']);
					
					}elseif(isset($rs) && $rs != 0){
						
//						$Link = $_SERVER['host'].'/analytics/confirm.php?token='.$GenToken.'&id='.$Params['tok_InputEmail'];
						$Link = 'confirm.php?token='.$GenToken.'&id='.$Params['tok_InputEmail'];

					
						SendEmailVerification($ConfigDB,$Params,$Link);
					
					}

				
				if(isset($conn)){
				$conn->close();
				}				
		
		}
		
//SendEmailVerification:
function SendEmailVerification($ConfigDB,$Params,$Link){


$para      = $Params['InputEmail'];
$titulo    = 'Confirmacion Verificacion Email';
$mensaje   = "Congratulations,<br>"
		."<br>"
		//."Por favor veririca tu cuenta haciendo click en el siguiente enlace para confirmar tu email y completar el registro.<br>"
		."Please verify your email by clicking in the following link to confirm your email.<br>"
		."<br>"
		."<br>".$Link;

$cabeceras = 'From: info@domain.com' . "\r\n" . //adjust email domain
    'Reply-To: no-reply@domain.com' . "\r\n" . //adjust email domain 
    'X-Mailer: PHP/' . phpversion();

mail($para, $titulo, $mensaje, $cabeceras);

}	


//ConfirmTokenEmailVerification : bla bla bla
function ConfirmTokenEmailVerification($ConfigDB,$Params){

	if(isset($Params) && isset($Params['token']) && strlen($Params['token']) > 0  && isset($Params['id']) && strlen(isset($Params['id'])) > 0 ){

			$conn = new mysqli( $ConfigDB['host'], $ConfigDB['user'], $ConfigDB['password'], $ConfigDB['database'] );

			if ($conn->connect_errno) {

//				header('Location: '.$_SERVER['host'].'/analytics/register.php?back=errorconfirm');
				header('Location: register.php?back=errorconfirm');

			}
			
				$Token = $Params['token'];
				$EmailTokenized = $Params['id'];
			
				$SqlConfirmTokenEmailVerification = " UPDATE emailtokenconfirmations "
												." SET Verified = 1 , VerifiedTime = now() "
												." WHERE Token = '".$Token."' AND md5(Email)  = '".$EmailTokenized."' AND Verified = 0 ;";
												
				$rs = $conn->query($SqlConfirmTokenEmailVerification);		

					if(isset($conn)){
					$conn->close();
					unset($conn);
					}

				if (!isset($rs) Or $rs == 0 ) {
				
				//	SendEmailVerification($ConfigDB,$Params);
	
	//				header('Location: '.$_SERVER['host'].'/analytics/welcome.php?back=sendemail&id='.$EmailTokenized);
					header('Location: welcome.php?back=sendemail&id='.$EmailTokenized);
						
				}elseif(isset($rs) && $rs != 0 ){
					
//					header('Location: '.$_SERVER['host'].'/analytics/login.php?back=emailconfirmed');
					header('Location: login.php?back=emailconfirmed');
									
				}
	
	}else{
	
//		header('Location: '.$_SERVER['host'].'/analytics/login.php?back=error');
		header('Location: login.php?back=error');
	
	}

}	

//GetEmail : 
function GetEmail($ConfigDB,$EmailTokenized){
		
				$conn = new mysqli( $ConfigDB['host'], $ConfigDB['user'], $ConfigDB['password'], $ConfigDB['database'] );
				if ($conn->connect_errno) {

//					header('Location: '.$_SERVER['host'].'/analytics/welcome.php?back=errorgetemail');
					header('Location: welcome.php?back=errorgetemail');

				}
				
				$SqlGetEmail = "SELECT Email FROM users WHERE md5(Email) = '".$EmailTokenized."' LIMIT 1;";
				
				$rs = $conn->query($SqlGetEmail);
				
				if(!isset($rs) Or $rs->num_rows == 0){

					return false;	
						
				}else{
					
					$row = $rs->fetch_array(MYSQLI_ASSOC);
					
					$Email = $row['Email'];
					
					if(isset($conn)){
					$conn->close();
					}
					
					return $Email;
						
				}
		}
		
//CheckTokenEmailVerified : 
function CheckTokenEmailVerified($ConfigDB,$Token){
		
				$conn = new mysqli( $ConfigDB['host'], $ConfigDB['user'], $ConfigDB['password'], $ConfigDB['database'] );
				if ($conn->connect_errno) {

//					header('Location: '.$_SERVER['host'].'/analytics/welcome.php?back=errorgetemail');
					header('Location: welcome.php?back=errorgetemail');

				}
				
				$SqlGetTokenEmailVerification = "SELECT CASE WHEN Verified = 1 THEN true ELSE false END AS Verified FROM emailtokenconfirmations WHERE Token = '".$Token."' LIMIT 1;";
				
				$rs = $conn->query($SqlGetTokenEmailVerification);

				
				if(isset($conn)){
				$conn->close();
				}
									
				$row = array();
	
				if(isset($rs) && $rs->num_rows != 0 ){
				
					$row = $rs->fetch_array(MYSQLI_ASSOC);
					
					return $row['Verified'];

				}else{
				
					return false;
					
				}
				
		}		

?>