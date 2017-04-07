<?php
Require_once('../connect.php');
if(isset($_COOKIE['admin'])){
		function testNick(&$errore)
	{	
		$nickErr;
		if(isset($_POST['nicknameIns']))
		{	
			if(empty($_POST['nicknameIns']))
			{
				$errore=true;
				return $nickErr="Campo obbligatorio";
			}
			elseif(checkUser(($_POST['nicknameIns'])))
			{
				$errore=true;
				return $nickErr="Nickname già in uso";
			}
			elseif(!checkUserSize(($_POST['nicknameIns'])))
			{
				$errore=true;
				return $nickErr="Il nickname deve essere compreso tra i 4 e i 12 caratteri";
			}
		}
	}
	
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

	function testDate(&$errore)
	{
		$dateErr;
		if(isset($_POST['dataIns']))
		{
			if(empty($_POST['dataIns'])){}
			elseif(!checkData($_POST['dataIns']))
			{
				$errore=true;
				return $dateErr="Data non corretta";
			}
			else 
			{
				$arrayData = multiexplode(array("-",".","/"),$_POST['data ins']);
				$data = $arrayData[2]."/" .$arrayData[1]."/" .$arrayData[0];	//ricostruisco la data con il separatore "/"
				echo $data;
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

	if(!$errore && isset($_POST['emailIns']) && isset($_POST['nomeIns']) && isset($_POST['cognomeIns']) && isset($_POST['nicknameIns']) && isset($_POST['dataIns']) && isset($_POST['passwordIns']) && isset($_POST['residenzaIns'])) 
	{	$ENC_password=password_hash($_POST['passwordIns'], PASSWORD_BCRYPT );
		
		$insert="INSERT INTO `Utente`(Email, Nome, Cognome, Nickname, Data_Nascita, Password, Residenza) VALUES ('".$_POST['emailIns']."','".$_POST['nomeIns']."','".$_POST['cognomeIns']."','".$_POST['nicknameIns']."','$data','$ENC_passwordIns', '".$_POST['residenzaIns']."')";
	
		$result=mysqli_multi_query($db, $insert);
	}

		if(!$db->query($sql)){
			header("Location: ../page_not_found.php");
	}
	
}
header("Location: ../Amministrazione/utenti.php");
?>