<?php
	include('connect.php');
	include('functions.php');
	
	$link=mysqli_connect("$host", "$username", "$password", "$database");
	
	$replaceHead=array("<title>Accedi a such wow</title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	$searchHead=array("{{title}}","{{description}}");
	$searchInForm=array("{{emailError}}","{{passError}}");
	$replaceInForm=array(testEmail($errore), testPassword($errore));
	
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));	//stampo l'head dell'html
	$errore=false;
	

		function testEmail(&$errore)						//cerco errori nell'email data in input
	{
		
		//test per sql injection o basta checkemailform?
		
		$emailErr;
		if(isset($_POST['email']))
		{
			if(empty($_POST['email']))
			{
				$errore=true;
				return $emailErr="Immetti l'indirizzo email";
			}
			elseif(!checkEmailForm($_POST['email']))
			{
				$errore=true;
				return $emailErr="Email non corretta";
			}
			elseif(!checkEmail($_POST['email']))
			{
				$errore=true;
				return $emailErr="Email non presente nel sistema";				
			}
		}
	}

	if(isset($_POST['password']))				//prelevo la password hashata dal db, quella di un user o quella di un admin (da correggere)
	{
		$UserPassQuery="SELECT Password FROM `Utente` WHERE Email='".$_POST['password']."'";
		$AdminPassQuery="SELECT Password FROM `Redazione` WHERE Email='".$_POST['password']."'";
	}
	
	function testPassword(&$errore)				//controllo la password data in input
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
			//controllo se la password dehashata coincide con quella data in input
			else if(!(password_verify(($_POST['password']), mysqli_query($db, $UserPassQuery))) || !(password_verify(($_POST['password']), mysqli_query($db, $AdminPassQuery))))
			{
				$errore=true;
				return $passErr = "Password non corretta";
			}
		}
	}
	
	echo str_replace($searchInForm, $replaceInForm , file_get_contents("../HTML/Template/login.txt"));	//stampo il form del login

	if(!$errore && isset($_POST['password']))//se non ci sono errori avvio la sessione
	{
		$hashedPass=mysqli_query($db, $UserPassQuery);
		session_start();
		if(password_verify(($_POST['password']), $hashedPass))		//se la password in input è utente
		{
			$_SESSION['type'] = 'user';
			header('Location: index.php');
			echo $hashedPass;
			echo "user";

		}
		else
		{
			$_SESSION['type'] = 'admin';					//se la password in input è admin
			echo $hashedPass;
		}
		
		
	}



	//QUESTO NON VA BENE, BISOGNA USARE STR_REPLACE
/*	echo file_get_contents("../HTML/Template/Menu.txt");
	echo "</ul></div>";*/
	



?>
