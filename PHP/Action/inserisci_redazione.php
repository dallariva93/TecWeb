<?php

include('connect.php');

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$email= $_POST['email'];
$nome= $_POST['nome'];
$cognome= $_POST['cognome'];
$password=$_POST['password'];

if (($email=="") or ($nome=="") or ($cognome=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
$insert="INSERT INTO `Redazione` VALUES ('$email','$password', '$nome','$cognome')";

} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?>


