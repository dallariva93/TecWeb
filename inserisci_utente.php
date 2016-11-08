<?php

include('connect.php');

$nickname= $_POST['nickname'];
$nome= $_POST['nome'];
$cognome= $_POST['cognome'];
$residenza= $_POST['residenza'];
$datanascita= $_POST['datanascita'];
$password= $_POST['password'];
$email= $_POST['email'];

if (($nickname=="") or ($nome=="") or ($cognome=="") or ($residenza=="") or ($datanascita="") or ($password="") or ($email=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
$insert="INSERT INTO `utente` VALUES ('$email','$nome','$cognome','$nickname','$datanascita','$password', '$residenza')";

} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
?>


