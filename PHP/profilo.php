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
	echo str_replace("{{corpo}}" ,stampaDati($db), file_get_contents("../HTML/profile.html"));
	
	file_get_contents("../HTML/profile.html");
	
	
	//Le varie possibilità in base al pulsante che ho premuto 
	if(isset($_POST['dati']) && ($_POST['dati']==1))
	{
		echo stampaDati($db);
		if(isset($_POST['modifica']) && ($_POST['dati']==4))
		{
			
		}
	}
	elseif(isset($_POST['libriVotati']) && $_POST['libriVotati']==2)
		stampaLibri($db);
	elseif(isset($_POST['commenti']) && $_POST['commenti']==3)
	{
		
		stampaCommenti($db);
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
		$i=0;
		while ($row = mysqli_fetch_array($lib)) 	//riempio l'array 
		{
			array_push($arrayISBN,$row);
		}
		
		while ($row = mysqli_fetch_array($vot)) 	//riempio l'array 
		{
			array_push($arrayVoti,$row);
		}
		
		$searchVotiLibro=array("{{ISBN}}", "{{titolo}}", "{{voto}}");
		echo "<ul class='centrato'>";
		while($i<count($arrayISBN))
		{
			
			$lib=$db->query("SELECT Titolo FROM `Libro` WHERE ISBN='".$arrayISBN[$i][0]."' ORDER BY Titolo");
			$libro=mysqli_fetch_array($lib);
			array_push($arrayLibri, $libro);
			
			
			$replaceVotiLibro=array($arrayISBN[$i][0], $arrayLibri[$i][0], $arrayVoti[$i][0]);
			echo str_replace($searchVotiLibro, $replaceVotiLibro, file_get_contents("../HTML/Template/MiniaturaLibroProfilo.txt"));
			$i++;
		}
		echo "</ul>";
		
		
		
		
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
	
	
?>

