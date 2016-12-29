
<?php

include('connect.php');

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$nickname= $_POST['nickname'];
$nome= $_POST['nome'];
$cognome= $_POST['cognome'];
$residenza= $_POST['residenza'];
$data= $_POST['data'];
$password= $_POST['password'];
$email= $_POST['email'];

if (($nickname=="") or ($nome=="") or ($cognome=="") or ($residenza=="") or ($data="") or ($password="") or ($email=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
$insert="INSERT INTO `utente` VALUES ('$email','$nome','$cognome','$nickname','$data','$password', '$residenza')";

} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?>


