<?php
	include('connect.php');
	include('functions.php');
	$link=mysqli_connect("$host", "$username", "$password", "$database");
	$errore=false;
	
	$replaceHead=array("<title>Registrati a such wow</title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	$searchHead=array("{{title}}","{{description}}");
	$searchInForm=array("{{nickError}}","{{emailError}}", "{{nomeError}}", "{{cognomeError}}","{{dateError}}", "{{passError}}");
	$replaceInForm=array(testNick($errore), testEmail($errore), testNome($errore), testCognome($errore), testDate($errore), testPassword($errore));
	
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));
	
	//QUESTO NON VA BENE, BISOGNA USARE STR_REPLACE
	echo file_get_contents("../HTML/Template/Menu.txt");
	echo "</ul></div>";
	
	function testNick(&$errore)
	{	
		$nickErr;
		if(isset($_POST['nickname']))
		{	
			if(empty($_POST['nickname']))
			{
				$errore=true;
				return $nickErr="Campo obbligatorio";
			}
			elseif(checkUser(($_POST['nickname'])))
			{
				$errore=true;
				return $nickErr="Nickname già in uso";
			}
			elseif(!checkUserSize(($_POST['nickname'])))
			{
				$errore=true;
				return $nickErr="Il nickname deve essere compreso tra i 4 e i 12 caratteri";
			}
		}
	}
	
	function testEmail(&$errore)
	{
		$emailErr;
		if(isset($_POST['email']))
		{
			if(empty($_POST['email']))
			{
				$errore=true;
				return $emailErr="Campo obbligatorio";
			}
			elseif(!checkEmailForm($_POST['email']))
			{
				$errore=true;
				return $emailErr="Mail non corretta";
			}
			elseif(checkEmail($_POST['email']))
			{
				$errore=true;
				return $emailErr="Mail già presente nel sistema";				
			}
		}
	}

	function testDate(&$errore)
	{
		$dateErr;
		if(isset($_POST['data']))
		{
			if(empty($_POST['data'])){}
			elseif(!checkData($_POST['data']))
			{
				$errore=true;
				return $dateErr="Data non corretta";
			}
			else 
			{
				$arrayData = multiexplode(array("-",".","/"),$_POST['data']);
				$data = $arrayData[2]."/" .$arrayData[1]."/" .$arrayData[0];	//ricostruisco la data con il separatore "/"
				echo $data;
			}
			
		}
	}
	
	function testPassword(&$errore)
	{
		$passErr;
		if(isset($_POST['password']))
		{
			if (empty($_POST ["password"]))
			{
				$errore=true;
				return $passErr = "Campo obbligatorio";
			} 
			else if(!preg_match("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,50}$^", $_POST ["password"])) 
			{
				$errore=true;
				return $passErr = "La password deve essere luna almeno 8 caratteri e deve contenere almeno una lettera minuscola, una maiuscola e un numero";
			}
		}
	}
	
	function testNome(&$errore)
	{
		$nomeErr;
		if(isset($_POST['nome']))
		{		
			if (strlen($_POST['nome']) < 3) 
			{
				$errore=true;
				return $nomeErr="Il nome deve contenere almeno 3 caratteri";
			} 
			else if (!preg_match("/^[a-zA-Z ]+$/", $_POST['nome'] )) 
			{
			   $errore=true;
			   return $nomeErr="Il nome puo avere solo lettere e spazi";
			}
		}	
	}
	
	function testCognome(&$errore)
	{
		$cognomeErr;
		if(isset($_POST['cognome']))
		{		
			if (!preg_match("/^[a-zA-Z ]+$/", $_POST['cognome'] )) 
			{
			   $errore=true;
			   return $cognomeErr="Il cognome puo avere solo lettere e spazi";
			}
		}
	}

	
	echo str_replace($searchInForm, $replaceInForm , file_get_contents("../HTML/Template/RegForm.txt"));
	
	if(!$errore && isset($_POST['email']) && isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['nickname']) && isset($_POST['data']) && isset($_POST['password']) && isset($_POST['residenza'])) 
	{
		
		/*$nome=mysqli_escape_string($link, isset($_POST['nome']));
		$cognome=mysqli_escape_string($link, isset($_POST['cognome']));
		$nickname=mysqli_escape_string($link, isset($_POST['nickname']));
		$data=mysqli_escape_string($link, isset($_POST['data']));
		$pass=mysqli_escape_string($link, isset($_POST['password']));
		$residenza=mysqli_escape_string($link, isset($_POST['residenza']));	
		echo "email", "$email", "nome", "$nome", "cogn", "$cognome", "nick", "$nickname", "data", "$data";*/

		$ENC_password=password_hash($_POST['password'], PASSWORD_BCRYPT );
		
		
		$insert="INSERT INTO `Utente`(Email, Nome, Cognome, Nickname, Data_Nascita, Password, Residenza) VALUES ('".$_POST['email']."','".$_POST['nome']."','".$_POST['cognome']."','".$_POST['nickname']."','$data','$ENC_password', '".$_POST['residenza']."')";
	
		$result=mysqli_multi_query($db, $insert);
	}

?>
