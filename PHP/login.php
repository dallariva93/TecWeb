<?php
	Require_once('connect.php');
	Require_once('functions.php');

	//stampo l'head dell'html
	$replaceHead=array("<title>Accedi a such wow</title>"
		,"<meta name='description' content='Social network per topi di bibblioteca'/>");
	$searchHead=array("{{title}}","{{description}}");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	$errore = false;
	$wrongPassword = false;
	$user = false;
	$admin = false;

	if(isset($_POST['email']))
	//Controllo se l'utete é un amministratore o un utente e verifico la sua password
	{
		$UserPassQuery="SELECT Password FROM `Utente` WHERE Email='".$_POST['email']."'";
		$AdminPassQuery="SELECT Password FROM `Redazione` WHERE Email='".$_POST['email']."'";
		$password = "";
		//cerco tra gli utenti
		$gruppo = $db->query($UserPassQuery);
		if ( $gruppo->num_rows > 0){ //é un utente
			$user = true;	
		}
		else{
			$gruppo = $db->query($AdminPassQuery);
			if ( $gruppo->num_rows > 0){ //é un admin
				$admin = true;
			}
		}
		if( $admin || $user ){
			$Getpassword = $gruppo->fetch_array(MYSQLI_ASSOC);
			$pasword = $Getpassword['Password'];
		}
		if($password != "" )
		//Controllo se la password é corretta		
			$wrongPassword =  !(password_verify($_POST['password'],$password));
		
		$gruppo->free();
	}

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("",
		"<span xml:lang='en'> <a href='index.php'>Home</a></span>/Accedi");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
		file_get_contents("../HTML/Template/Breadcrumb.txt"));


	//stampo il form del login
	$searchInForm=array("{{emailError}}","{{passError}}");
	$replaceInForm=array(testEmail($errore,true), testPassword($errore,$wrongPassword));
	echo str_replace($searchInForm, $replaceInForm ,
		 file_get_contents("../HTML/Template/login.txt"));	

	if(!$errore && ($admin || $user ) && isset($_POST['password']) && isset($_POST['email']) )
	//se non ci sono errori avvio la sessione
	{
		session_start();
		
		//se la password in input è utente
		if( $user )	
			$_SESSION['type'] = 'user';
		//se la password in input è admin
		else if( $admin )
			$_SESSION['type'] = 'admin';
				
		$_SESSION['id'] = $_POST['email'];
		header('Location: index.php');

	}


	echo file_get_contents("../HTML/Template/Footer.txt");
?>
