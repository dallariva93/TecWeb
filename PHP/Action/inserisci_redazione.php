<?php
Require_once('../connect.php');
if(isset($_COOKIE['admin'])){
	
	
	function testEmail(&$errore)
	{
		$emailErr;
		if(isset($_POST['emailIns']))
		{
			if(empty($_POST['emailIns']))
			{
				$errore=true;
				return $emailErr="Campo obbligatorio";
			}
			elseif(!checkEmailForm($_POST['emailIns']))
			{
				$errore=true;
				return $emailErr="Mail non corretta";
			}
			elseif(checkEmail($_POST['emailIns']))
			{
				$errore=true;
				return $emailErr="Mail già presente nel sistema";				
			}
		}
	}


	function testPassword(&$errore)
	{
		$passErr;
		if(isset($_POST['passwordIns']))
		{
			if (empty($_POST ["passwordIns"]))
			{
				$errore=true;
				return $passErr = "Campo obbligatorio";
			} 
			else if(!preg_match("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,50}$^", $_POST ["passwordIns"])) 
			{
				$errore=true;
				return $passErr = "La password deve essere luna almeno 8 caratteri e deve contenere almeno una lettera minuscola, una maiuscola e un numero";
			}
		}
	}
	
	function testNome(&$errore)
	{
		$nomeErr;
		if(isset($_POST['nomeIns']))
		{		
			if (strlen($_POST['nomeIns']) < 3) 
			{
				$errore=true;
				return $nomeErr="Il nome deve contenere almeno 3 caratteri";
			} 
			else if (!preg_match("/^[a-zA-Z ]+$/", $_POST['nomeIns'] )) 
			{
			   $errore=true;
			   return $nomeErr="Il nome puo avere solo lettere e spazi";
			}
		}	
	}
	
	function testCognome(&$errore)
	{
		$cognomeErr;
		if(isset($_POST['cognomeIns']))
		{		
			if (!preg_match("/^[a-zA-Z ]+$/", $_POST['cognomeIns'] )) 
			{
			   $errore=true;
			   return $cognomeErr="Il cognome puo avere solo lettere e spazi";
			}
		}
	}

	if(!$errore && isset($_POST['emailIns']) && isset($_POST['nomeIns']) && isset($_POST['cognomeIns']) &&  isset($_POST['passwordIns'])) 
	{	$ENC_password=password_hash($_POST['passwordIns'], PASSWORD_BCRYPT );
		
		$insert="INSERT INTO `Redazione`(Email, Password,Nome, Cognome) VALUES ('".$_POST['emailIns']."','$ENC_passwordIns', '".$_POST['nomeIns']."','".$_POST['cognomeIns']."')";
	
		$result=mysqli_multi_query($db, $insert);
	}

		if(!$db->query($sql)){
			header("Location: ../page_not_found.php");
	}
	
}
header("Location: ../Amministrazione/redazioni.php");
?>