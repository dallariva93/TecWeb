<?php
	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Profilo - FaceOnTheBook </title>", "<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));
	
	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("", "<span xml:lang='en'> <a href='index.php'>Home</a></span>/Profilo ");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));
	echo str_replace("{{corpo}}" ,stampaDati($db), file_get_contents("../HTML/Template/profile.txt"));
	
	$errore=false;
	
	//Le varie possibilità in base al pulsante che ho premuto 
	if(isset($_POST['dati']) && ($_POST['dati']==1))
	{
		echo stampaDati($db);
	}
	elseif(isset($_POST['libriVotati']) && $_POST['libriVotati']==2)
		stampaLibri($db);
	elseif(isset($_POST['commenti']) && $_POST['commenti']==3)
	{
		
		stampaCommenti($db);
	}
	elseif(isset($_POST['ModificaPass']) || isset($_POST['ModificaDati']))
	{
		modificaPass($db);
	}
	else
		echo stampaDati($db);
		
	
	
	
	
	function stampaDati($db)
	{
		$user = $db->query("SELECT * FROM Utente WHERE Email = '".$_SESSION['id']. "'" );
		$utente = $user->fetch_array(MYSQLI_ASSOC);
		$searchDati=array("{{nickname}}","{{nome}}","{{cognome}}","{{email}}","{{data}}","{{residenza}}");
		//echo $utente['Data'];
		$replaceDati=array($utente['Nickname'], $utente['Nome'], $utente['Cognome'], $utente['Email'], $utente['Data_Nascita'], $utente['Residenza']);
		return str_replace($searchDati ,$replaceDati, file_get_contents("../HTML/Template/Dati.txt"));
		
		
	}
	
	function stampaLibri($db)
	{
		$lib=$db->query("SELECT Libro FROM VotoLibro WHERE Autore = '".$_SESSION['id']. "'");
		$vot=$db->query("SELECT Valutazione FROM VotoLibro WHERE Autore = '".$_SESSION['id']. "'");		
		$arrayVoti=array();
		$arrayISBN=array();
		$arrayLibri=array();
		$arrayStelle=array();
		$i=$l=0;
		while ($row = mysqli_fetch_array($lib)) 	//riempio l'array 
		{
			array_push($arrayISBN,$row);
		}
		
		while ($row = mysqli_fetch_array($vot)) 	//riempio l'array 
		{
			array_push($arrayVoti,$row);
		}
		
		while($l<count($arrayVoti))
		{
			$arrayStelle[$l]=printStar($arrayVoti[$l][0]);
			$l++;
		}
		
		
		$searchVotiLibro=array("{{ISBN}}", "{{titolo}}", "{{voto}}");
		echo "<div class='content centrato'><ul class='centro'>";
		while($i<count($arrayISBN))
		{
			
			$lib=$db->query("SELECT Titolo FROM `Libro` WHERE ISBN='".$arrayISBN[$i][0]."' ORDER BY Titolo");
			$libro=mysqli_fetch_array($lib);
			array_push($arrayLibri, $libro);
			
			
			$replaceVotiLibro=array($arrayISBN[$i][0], $arrayLibri[$i][0], $arrayStelle[$i]);
			echo str_replace($searchVotiLibro, $replaceVotiLibro, file_get_contents("../HTML/Template/MiniaturaLibroProfilo.txt"));
			$i++;
		}
		echo "</ul></div>";
		
		
		
		
	}
	
	function stampaCommenti($db)
	{
		$com = $db->query("SELECT Data_Pubblicazione, Recensione, Commento FROM Commenti WHERE Autore = '".$_SESSION['id']. "' ORDER BY Data_Pubblicazione DESC" );	
		$arrayCommenti= array();
		
		while ($row = mysqli_fetch_array($com)) 	//riempio l'array con array di date, commenti e libro della recensione 
		{
			array_push($arrayCommenti,$row);
		}
		
		$i=0;
		$searchCommento=array("{{libro}}","{{dataCommento}}","{{testoCommento}}");
		while($i<count($arrayCommenti))
		{
			$lib=$db->query("SELECT Titolo FROM `Libro` WHERE ISBN=(SELECT Libro FROM `Recensione` WHERE Id='".$arrayCommenti[$i][1]."')");
			$libro=mysqli_fetch_array($lib);
			$replaceCommento=array($libro[0], $arrayCommenti[$i][0], $arrayCommenti[$i][2]);
			echo str_replace($searchCommento, $replaceCommento, file_get_contents("../HTML/Template/CommentoProfilo.txt"));
			$i++;
		}	
	}
	
	function modificaPass($db)
	{
		$UserPassQuery="SELECT Password FROM `Utente` WHERE Email='".$_SESSION['id']."'";
		$AdminPassQuery="SELECT Password FROM `Redazione` WHERE Email='".$_SESSION['id']."'";
		$password = $wrongPassword = "";
		//cerco tra gli utenti
		$gruppo = $db->query($UserPassQuery);
		$admin=$user=false;
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
			$password = $Getpassword['Password'];
		}
		if($password != "" && isset($_POST['Vpassword']))
		//Controllo se la password é corretta
		$wrongPassword =  !(password_verify($_POST['Vpassword'],$password));
		$gruppo->free();
		
		$searchInForm=array("{{VpassError}}","{{NpassError}}","{{CpassError}}");
		$replaceInForm=array(testVPassword($errore, $wrongPassword), testPassword($errore), ConfirmPassword($errore));
		echo str_replace($searchInForm, $replaceInForm , file_get_contents("../HTML/Template/ModificaPass.txt"));
		
	}
	
	
	function testVPassword(&$errore, $wrongPassword = false)
{
	$passErr = "";
	if(isset($_POST['Vpassword']) && !($_POST['Vpassword'] == "admin" || $_POST['Vpassword'] == "user"))
	{
		
		if (empty($_POST ["Vpassword"]))
		{
			$errore=true;
			$passErr = "Campo obbligatorio";
		}
		//controllo se la password dehashata coincide con quella data in input
		else if(!preg_match("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,50}$^", $_POST ["Vpassword"]))
		{
			$errore=true;
			$passErr = "La password deve essere lunga almeno 8 caratteri e deve contenere almeno una lettera minuscola, una maiuscola e un numero";
		}
		else if($wrongPassword)
		{
			$errore=true;
			return $passErr = "Password non corretta";
		}
		

	}
	return $passErr;
}

	function ConfirmPassword(&$errore)
	{
		if(isset($_POST['password']) && isset($_POST['Cpassword']) && $_POST['password']!=$_POST['Cpassword'])
		{
			$errore=true;
			return $passErr = "Le due password non coincidono";
		}
	}
	
	if(!$errore && isset($_POST['Vpassword']) && isset($_POST['password']) && isset($_POST['Cpassword']))
	{
		$hashedPass=password_hash($_POST['password'], PASSWORD_BCRYPT );
		$updatePassQuery="UPDATE Utente SET Password = '$hashedPass' WHERE Email='".$_SESSION['id']."'";
		$ok=mysqli_query($db, $updatePassQuery);
		$_POST['dati']== 1;
		
	}
	
?>

