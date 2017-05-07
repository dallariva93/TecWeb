<?php
	if(true || isset($_SESSION) && $_SESSION['type'] == "admin"){ //true da togliere!!!!!!!!!!(messo per test)
		Require_once('connect.php');
		Require_once('functions.php');

		if(isset($_POST['delete'])){
			$delete = "DELETE FROM `Redazione` WHERE `Email` = '". $_POST['delete']. "'";
			$db->query($delete);
		}


		$errore=false;

		$searchInForm=array("{{EmailError}}","{{PasswordError}}","{{NomeError}}",
					"{{CognomeError}}");
		$replaceInForm=array(testEmail($errore),testPassword($errore),
		 						testNome($errore), testCognome($errore));

		if(!$errore && isset($_POST['email']) && isset($_POST['nome']) && isset($_POST['cognome'])
			&& isset($_POST['password']))
		{
			$ENC_password=password_hash($_POST['password'], PASSWORD_BCRYPT );
			$insert="INSERT INTO `Redazione`(Email, Nome, Cognome, Password)
				VALUES ('" .$_POST['email']. "','" .$_POST['nome']. "','"
						.$_POST['cognome']. "','". $ENC_password. "')";
			$db->query($insert);
		}

		$searchHead=array("{{title}}","{{description}}");
		$replaceHead=array("<title>Amministrazione Redazione - FaceOnTheBook </title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
		echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

		echo menu();

		$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
		$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a></span>/<span> <a href='amministrazione.php'>Amministrazione</a></span>/Redazione");
		echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));

		echo "<div class='centrato content'>";
		echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuovo Amministratore</a>";

		if($Amministratori = $db->query("SELECT * FROM Redazione ORDER BY Cognome")){
			echo file_get_contents("../HTML/Template/InizioTabellaRedazione.txt");
			while ($Admin = $Amministratori->fetch_array(MYSQLI_ASSOC)){
				$search=array("{{Email}}","{{Nome}}","{{Cognome}}");
				$replace=array($Admin['Email'],$Admin['Nome'],$Admin['Cognome']);
				echo str_replace($search,$replace, file_get_contents("../HTML/Template/TabellaRedazione.txt"));
			}
			$Amministratori->free();
		}
		echo "</tbody></table></div>";

		//Form inserimento in redazione
		echo str_replace($searchInForm, $replaceInForm ,
		 		file_get_contents("../HTML/Template/FormInserimentoRedazione.txt"));

		$db->close();

		echo "</div>";//Fine content

		echo file_get_contents("../HTML/Template/Footer.txt");
	}
	else{
		header("Location: page_not_found.php");
		exit();
	}
?>
