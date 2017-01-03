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
	
	echo $nickname;
	if($nickname=="" || checkUser($nickname) || !checkUserSize($nickname)) //controllo il nickname
	{
		echo "ERRORE! l'username  è troppo corto o potrebbe essere già in uso ";
	}
	elseif($email=="" || checkEmail($email) || checkEmailForm($email) )	//controllo la mail
	{
		echo "ERRORE! l'email inserita non è nella forma corretta o potrebbe essere già in uso"	;
	}
	elseif(!checkData($data)) {														//controllo la data
		echo"data non valida";
	}
	else {
		$arrayData = multiexplode(array("-",".","/"),$data);
		$data = $arrayData[2]."/" .$arrayData[1]."/" .$arrayData[0];	//ricostruisco la data con il separatore "/"
	
		if($password=="" || strlen($password)<8) {								//controllo la password
			echo"password troppo corta";
		}
		else {																			//non ci sono errori quindi cripto la password e inserisco i dati
			$ENC_password = hash('sha256', $password);
	
			$insert="INSERT INTO `Utente`(Email, Nome, Cognome, Nickname, Data_Nascita, Password, Residenza) VALUES ('$email','$nome','$cognome','$nickname','$data','$ENC_password', '$residenza')";
			$result=mysqli_multi_query($db, $insert);		
			
			if($result){
				echo "Complimenti ti sei registrato con successo in sto sito di merda!";
			} 
		}	
	}
	
	
/*
	$insert="INSERT INTO `Utente` VALUES ('$email','$nome','$cognome','$nickname','$data','$password', '$residenza')";
	$result=mysqli_multi_query($db, $insert);
	*/	
?>