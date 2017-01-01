
<?php

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

include('connect.php');

$codice= $_POST['codice'];
$autore= $_POST['autore'];
$valutazione= $_POST['valutazione'];

if (($codice=="") or ($autore=="") or ($valutazione=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
$insert="INSERT INTO `VotoRecensione` VALUES ('$codice','$autore',''$valutazione')";

} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>


