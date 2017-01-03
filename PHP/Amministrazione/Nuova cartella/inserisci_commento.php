
<?php

include('connect.php');

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$recensione= $_POST['recensione'];
$commento= $_POST['testo'];
$autore= $_POST['autore'];
$data= $_POST['data'];

if (($recensione=="") or ($autore=="") or ($data=="") or ($commento=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

$insert="INSERT INTO `Commento` VALUES ('$recensione','$autore','$commento','$data',)";


} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>


