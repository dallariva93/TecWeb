<?php
	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("Profilo personale ", "Dati utente, cambia password, libri votati, messaggi utente");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));
	
	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("", "<span xml:lang='en'> <a href='index.php'>Home</a></span> > Profilo ");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));
	echo str_replace("{{corpo}}" ,stampaDati($db), file_get_contents("../HTML/Template/profile.txt"));
	
	$errore=false;
	
	//Le varie possibilità in base al pulsante che ho premuto 
	if(isset($_POST['dati']) )
	{
		echo stampaDati($db);
	}
	elseif(isset($_POST['libriVotati']) )
		stampaLibri($db);
	elseif(isset($_POST['commenti']) )
	{
		stampaCommenti($db);
	}
	elseif(isset($_POST['ModificaPass']) || isset($_POST['ModificaDati']))
	{
		modificaPass($db);
	}
	elseif(isset($_GET['page']))
	{
		stampaCommenti($db, $_GET['page']);
		
	}
	elseif(isset($_GET['books']))
	{
		stampaLibri($db, $_GET['books']);
	}
	elseif(isset($_POST['EliminaAccount']))
	{
		deleteProfile($db);
	}
	else
		echo stampaDati($db);
		
	
	
	
	if(!$errore && isset($_POST['Vpassword']) && isset($_POST['password']) && isset($_POST['Cpassword']))
	{
		$hashedPass=password_hash($_POST['password'], PASSWORD_BCRYPT );
		$updatePassQuery="UPDATE Utente SET Password = '$hashedPass' WHERE Email='".$_SESSION['id']."'";
		$ok=mysqli_query($db, $updatePassQuery);
		$_POST['dati']== 1;
		header('Location: profilo.php');	
	}
	
	echo file_get_contents("../HTML/Template/Footer.txt");

	
?>

