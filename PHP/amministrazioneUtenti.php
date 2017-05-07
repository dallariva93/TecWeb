<?php
	if(true || isset($_SESSION) && $_SESSION['type'] == "admin"){ //true da togliere!!!!!!!!!!(messo per test)
		Require_once('connect.php');
		Require_once('functions.php');

		if(isset($_POST['delete'])){
			$delete = "DELETE FROM `Utente` WHERE `Email` = '". $_POST['delete']. "'";
			$db->query($delete);
		}

		$errore=false;

		$searchInForm=array("{{Titolo}}","{{Pagina}}","{{nickError}}","{{emailError}}",
		 "{{nomeError}}", "{{cognomeError}}","{{dateError}}", "{{passError}}","{{AggiungiClassi}}");
		$replaceInForm=array("Inserisci utente","amministrazioneUtenti.php",testNick($errore), testEmail($errore), testNome($errore), testCognome($errore)
						, testDate($errore), testPassword($errore),"");

		if(!$errore && isset($_POST['email']) && isset($_POST['nome']) && isset($_POST['cognome'])
			&& isset($_POST['nickname']) && isset($_POST['data']) && isset($_POST['password']))
		{
			$residenza = ($_POST['residenza'])? $_POST['residenza'] : "";

			$ENC_password=password_hash($_POST['password'], PASSWORD_BCRYPT );

			$insert="INSERT INTO `Utente`(Email, Nome, Cognome, Nickname
				, Data_Nascita, Password, Residenza) VALUES ('".$_POST['email']."','".$_POST['nome']."','".$_POST['cognome']."','"
				.$_POST['nickname']."','". GetData($_POST['data']). "','$ENC_password', '".$residenza."')";
			$db->query($insert);
		}

		$searchHead=array("{{title}}","{{description}}");
		$replaceHead=array("<title>Amministrazione Utenti - FaceOnTheBook </title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
		echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

		echo menu();

		$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
		$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a></span>/<span> <a href='amministrazione.php'>Amministrazione</a></span>/Utenti");
		echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));

		echo "<div class='centrato content'>";
		echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuovo Utente</a>";

		if($Utenti = $db->query("SELECT * FROM Utente ORDER BY Cognome")){
			echo file_get_contents("../HTML/Template/InizioTabellaUtente.txt");
			while ($Utente = $Utenti->fetch_array(MYSQLI_ASSOC)){

				$search=array("{{Email}}","{{Cognome}}","{{Nome}}","{{Nickname}}","{{Data}}","{{Residenza}}");
				$replace=array($Utente['Email'],$Utente['Cognome'],$Utente['Nome'],$Utente['Nickname'],Data($Utente['Data_Nascita']),$Utente['Residenza']);
				echo str_replace($search ,$replace, file_get_contents("../HTML/Template/TabellaUtente.txt"));
			}
			$Utenti->free();
		}
		echo "</tbody></table></div>";

		//Form inserimento
		echo "<a name = 'insert'></a>";

		echo str_replace($searchInForm, $replaceInForm , file_get_contents("../HTML/Template/RegForm.txt"));

		$db->close();

		echo "</div>";//Fine content

		echo file_get_contents("../HTML/Template/Footer.txt");
	}
	else{
		header("Location: page_not_found.php");
		exit();
	}
?>
