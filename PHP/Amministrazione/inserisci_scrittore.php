
<?php

include('connect.php');

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$codice= $_POST['codice'];
$nome= $_POST['nome'];
$cognome= $_POST['cognome'];
$nazionalita= $_POST['nazionalita'];
$data= $_POST['data'];

if (($codice=="") or ($nome=="") or ($cognome=="") or ($nazionalita=="") or ($data="") ) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
$insert="INSERT INTO `scrittore` VALUES ('$codice','$nome','$cognome','$data', '$nazionalita')";

} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?>


