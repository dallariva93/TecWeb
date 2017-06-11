<?php
	Require_once('connect.php');
	Require_once('functions.php');
	$errore=false;

	$searchInForm=array("{{Titolo}}","{{Pagina}}","{{nickError}}","{{emailError}}",
	 "{{nomeError}}", "{{cognomeError}}", "{{passError}}","{{AggiungiClassi}}");
	$replaceInForm=array("Registrazione","registrazione.php",testNick($errore), testEmail($errore), testNome($errore), testCognome($errore), testPassword($errore),"strict");

	if(!$errore && isset($_POST['email']) && isset($_POST['nome']) && isset($_POST['cognome'])
		&& isset($_POST['nickname']) && isset($_POST['password']))
	{

		$ENC_password=password_hash($_POST['password'], PASSWORD_BCRYPT );


		$insert="INSERT INTO `Utente`(Email, Nome, Cognome, Nickname, Password) VALUES ('".$_POST['email']."','".$_POST['nome']."','".$_POST['cognome']."','"
			.mysqli_real_escape_string($db,$_POST['nickname'])."','$ENC_password')";

		if($db->query($insert)){
			session_start();
			$_SESSION["type"] = "user";
			$_SESSION["id"] = $_POST['email'];
			//header('Location: index.php');
			//exit;
		}
	}

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("Registrati su "
		,"Registrazione utente");
  
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("","<span xml:lang='en'><a href='index.php'>Home</a></span>/Iscriviti");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,file_get_contents("../HTML/Template/Breadcrumb.txt"));

	echo str_replace($searchInForm, $replaceInForm , file_get_contents("../HTML/Template/RegForm.txt"));

	echo file_get_contents("../HTML/Template/FileJs.txt");
	echo file_get_contents("../HTML/Template/Footer.txt");
?>
