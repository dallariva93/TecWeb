<?php
	include('connect.php');
	include('functions.php');
	
	$nickname=$_POST['nickname'];
	$nome=$_POST['nome'];
	$cognome=$_POST['cognome'];
	$email=$_POST['email'];
	$residenza=$_POST['residenza'];
	$data=$_POST['data'];
	$password=$_POST['password'];
	

	if($nickname=="" || checkUser($nickname) || !checkUserSize($nickname)) //controllo il nickname
	{
		echo file_get_contents("../HTML/Template/Head.txt");
		echo file_get_contents("../HTML/Template/Menu.txt");
		echo "</ul></div>";
		echo "<div class='box errore'> ERRORE!"." l'username  è troppo corto o potrebbe essere già in uso 
				<a class='btnLong' href='../HTML/registrazione.html'>Torna indietro</a>
				</div>";
			
	}
	elseif($email=="" || checkEmail($email) || checkEmailForm($email) )	//controllo la mail
	{
		echo file_get_contents("../HTML/Template/Head.txt");
		echo file_get_contents("../HTML/Template/Menu.txt");
		echo "</ul></div>";
		echo "<div class='box errore'> ERRORE! l'email inserita non è nella forma corretta o potrebbe essere già in uso
				<a class='btnLong' href='../HTML/registrazione.html'>Torna indietro</a>
				</div>";
	}

	if($data!="" && !checkData($data)) {														//controllo la data
		echo file_get_contents("../HTML/Template/Head.txt");
		echo file_get_contents("../HTML/Template/Menu.txt");
		echo "</ul></div>";
		echo "<div class='box errore'> Data non valida
				<a class='btnLong' href='../HTML/registrazione.html'>Torna indietro</a>
				</div>";
		
	}
	else {if($data!="") {
				$arrayData = multiexplode(array("-",".","/"),$data);
				$data = $arrayData[2]."/" .$arrayData[1]."/" .$arrayData[0];	//ricostruisco la data con il separatore "/"
			}


		if($password=="" || (!preg_match("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,50}$^", $password))) {		//controllo la password
			echo file_get_contents("../HTML/Template/Head.txt");
			echo file_get_contents("../HTML/Template/Menu.txt");
			echo "</ul></div>";
			echo "<div class='box errore'> La password deve essere lunga almeno 8 caratteri e deve contenere almeno una lettera minuscola, una maiuscola e un numero
					<a class='btnLong' href='../HTML/registrazione.html'>Torna indietro</a>
					</div>";
		}
		else {																			//non ci sono errori quindi cripto la password e inserisco i dati
			$ENC_password = hash('sha256', $password);
	
			$insert="INSERT INTO `Utente`(Email, Nome, Cognome, Nickname, Data_Nascita, Password, Residenza) VALUES ('$email','$nome','$cognome','$nickname','$data','$ENC_password', '$residenza')";
			$result=mysqli_multi_query($db, $insert);		
			
			if($result){
			echo file_get_contents("../HTML/Template/Head.txt");
			echo file_get_contents("../HTML/Template/Menu.txt");
			echo "</ul></div>";
			echo "<div class='box errore'> Complimenti! Ti sei registrato con successo su sto sito di merda!
					</div>";
		}
			} 
		}	
	
	
	

?>