<?php
Require_once('../connect.php');
if(isset($_COOKIE['admin'])){
	
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

	if(!$errore && isset($_POST['nomeIns']) && isset($_POST['cognomeIns']) && isset($_POST['nazionalita']) && isset($_POST['dataIns']))
	{
		
		$insert="INSERT INTO `Scrittore`(Nome, Cognome, Data_Nascita, Nazionalita) VALUES ('".$_POST['nomeIns']."','".$_POST['cognomeIns']."','".$_POST['nazionalitaIns']."','$datains','".$_POST['nazionalitaIns']."')";
	
		$result=mysqli_multi_query($db, $insert);
	}

		if(!$db->query($sql)){
			header("Location: ../page_not_found.php");
	}
	
}
header("Location: ../Amministrazione/scrittori. php");
?>