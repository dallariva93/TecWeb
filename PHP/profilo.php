<?php
	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Profilo - FaceOnTheBook </title>", "<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));
	
	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("", "<span xml:lang='en'> <a href='index.php'>Home</a></span> > Profilo ");
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
	
	function stampaLibri($db, $page=0)
	{
		$lib=$db->query("SELECT Libro FROM VotoLibro WHERE Autore = '".$_SESSION['id']. "'");
		$vot=$db->query("SELECT Valutazione FROM VotoLibro WHERE Autore = '".$_SESSION['id']. "'");		
		$arrayVoti=array();
		$arrayISBN=array();
		$arrayLibri=array();
		$arrayStelle=array();
		$i=$l=0;
		$bookPerPage=15;
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
		while($i<count($arrayISBN) )  		//riempio l'array
		{
			
			$lib=$db->query("SELECT Titolo FROM `Libro` WHERE ISBN='".$arrayISBN[$i][0]."' ORDER BY Titolo");
			$libro=mysqli_fetch_array($lib);
			array_push($arrayLibri, $libro);
			$i++;
		}
			
		//stampo le miniature dei libri
		$i=0;
		while($i<$bookPerPage && $i+($page*$bookPerPage)<count($arrayISBN) )
		{
			$replaceVotiLibro=array($arrayISBN[$i+($page*$bookPerPage)][0], $arrayLibri[$i+($page*$bookPerPage)][0], $arrayStelle[$i+($page*$bookPerPage)]);
			echo str_replace($searchVotiLibro, $replaceVotiLibro, file_get_contents("../HTML/Template/MiniaturaLibroProfilo.txt"));
			$i++;
		}
		
		echo "</ul></div>";
		
		if(count($arrayISBN)<=$bookPerPage)			//ho meno elementi di bookPerPage, non stampo i bottoni
		{}		
		elseif(!isset($_GET['books']) || $_GET['books']==0)				//pagina iniziale, non stampo il bottone indietro
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1, "hidden", "");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/BooksButtons.txt"));
		}
		elseif(($_GET['books'])+1>=count($arrayISBN)/$bookPerPage)				//pagina finale, non stampo il bottone avanti
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1,"", "hidden");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/BooksButtons.txt"));
		}
		else 					//pagine intermedie, li stampo entrambi
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1,"", "");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/BooksButtons.txt"));
		}
		
		
	}
	
	function stampaCommenti($db, $page=0)
	{
		//$page do valore da get
		
		$commentsPerPage=10;
		$com = $db->query("SELECT Data_Pubblicazione, Recensione, Commento FROM Commenti 
							WHERE Autore = '".$_SESSION['id']. "' ORDER BY Data_Pubblicazione DESC LIMIT $commentsPerPage OFFSET " .($page*$commentsPerPage) );	
		$totCom = $db->query("SELECT Data_Pubblicazione, Recensione, Commento FROM Commenti WHERE Autore = '".$_SESSION['id']. "'");	
		
		$arrayCommenti= array();
		$arrayTotCommenti = array();
		while ($row = mysqli_fetch_array($com)) 	//riempio l'array con array date, commenti e libro della recensione 
		{
			array_push($arrayCommenti,$row);
		}
		
		$i=0;
		$searchCommento=array("{{libro}}","{{dataCommento}}","{{testoCommento}}");
		$numComm=count($arrayCommenti);
		while($i<count($arrayCommenti))
		{
			$lib=$db->query("SELECT Titolo FROM `Libro` WHERE ISBN=(SELECT Libro FROM `Recensione` WHERE Id='".$arrayCommenti[$i][1]."')");
			$libro=mysqli_fetch_array($lib);
			
			$data=formattaData($arrayCommenti[$i][0]);
			$replaceCommento=array($libro[0], $data, $arrayCommenti[$i][2]);
			echo str_replace($searchCommento, $replaceCommento, file_get_contents("../HTML/Template/CommentoProfilo.txt"));
			$i++;
		}	
		
		while ($row = mysqli_fetch_array($totCom)) 	 
		{
			array_push($arrayTotCommenti,$row);
		}
		
		
		if(!isset($_GET['page']) || $_GET['page']==0)				//pagina iniziale, non stampo il bottone indietro
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1, "hidden", "");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/CommentsButtons.txt"));
		}
		elseif(($_GET['page'])+1>=count($arrayTotCommenti)/$commentsPerPage)				//pagina finale, non stampo il bottone avanti
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1,"", "hidden");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/CommentsButtons.txt"));
		}
		else 					//pagine intermedie, li stampo entrambi
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1,"", "");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/CommentsButtons.txt"));
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
		header('Location: profilo.php');	
	}
	
	echo file_get_contents("../HTML/Template/Footer.txt");

	
?>

