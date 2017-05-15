<?php
	Require_once('connect.php');
	Require_once('functions.php');
	$errore=false;

	$searchInForm=array("{{Titolo}}","{{Pagina}}","{{nickError}}","{{emailError}}",
	 "{{nomeError}}", "{{cognomeError}}","{{dateError}}", "{{passError}}","{{AggiungiClassi}}");
	$replaceInForm=array("Registrazione","registrazione.php",testNick($errore), testEmail($errore), testNome($errore), testCognome($errore)
					, testDate($errore), testPassword($errore),"strict");

	if(!$errore && isset($_POST['email']) && isset($_POST['nome']) && isset($_POST['cognome'])
		&& isset($_POST['nickname']) && isset($_POST['data']) && isset($_POST['password']))
	{
		$residenza = ($_POST['residenza'])? $_POST['residenza'] : "";

		$ENC_password=password_hash($_POST['password'], PASSWORD_BCRYPT );

		$insert="INSERT INTO `Utente`(Email, Nome, Cognome, Nickname
			, Data_Nascita, Password, Residenza) VALUES ('".$_POST['email']."','".$_POST['nome']."','".$_POST['cognome']."','"
			.$_POST['nickname']."','". GetData($_POST['data']). "','$ENC_password', '".$residenza."')";

		if($db->query($insert)){
			session_start();
			$_SESSION["type"] = "user";
			$_SESSION["id"] = $_POST['email'];
			header('Location: index.php');
			exit;
		}
	}

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Registrati a such wow</title>"
		,"<meta name='description' content='Social network per topi di bibblioteca'/>");

	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("","<span xml:lang='en'><a href='index.php'>Home</a></span>/Iscriviti");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,file_get_contents("../HTML/Template/Breadcrumb.txt"));

	echo str_replace($searchInForm, $replaceInForm , file_get_contents("../HTML/Template/RegForm.txt"));

	echo file_get_contents("../HTML/Template/FileJs.txt");
	echo file_get_contents("../HTML/Template/Footer.txt");
?>
