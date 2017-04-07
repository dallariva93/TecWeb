<?php
Require_once('../connect.php');
if(isset($_COOKIE['admin'])){
		
	
	function testEmail(&$errore)
	{
		$emailErr;
		if(isset($_POST['autoreIns']))
		{
			if(empty($_POST['autoreIns']))
			{
				$errore=true;
				return $emailErr="Campo obbligatorio";
			}
			elseif(!checkEmailForm($_POST['autoreIns']))
			{
				$errore=true;
				return $emailErr="Mail non corretta";
			}
		}
	}

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

	
	if(!$errore && isset($_POST['isbnIns']) && isset($_POST['autoreIns']) && isset($_POST['[testo']) && isset($_POST['dataIns'])&& isset($_POST['valutazione'])) 
	{	
		$insert="INSERT INTO `Recensione`(Libro, Autore, Data_Pubblicazione, Valutazione, Testo) VALUES ('".$_POST['isbnIns']."','".$_POST['autoreIns']."','$data','".$_POST['valutazione']."', '".$_POST['testo']."')";
	
		$result=mysqli_multi_query($db, $insert);
	}

		if(!$db->query($sql)){
			header("Location: ../page_not_found.php");
	}
	
}
header("Location: ../Amministrazione/recensioni.php");
?>