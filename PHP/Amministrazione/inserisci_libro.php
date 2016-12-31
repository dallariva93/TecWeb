<?php

include('connect.php');

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$isbn= $_POST['isbn'];
$titolo= $_POST['titolo'];
$autore= $_POST['autore'];
$genere= $_POST['genere'];
$data= $_POST['anno'];
$casa= $_POST['casa'];
$trama= $_POST['trama'];

if (($isbn=="") or ($titolo=="") or ($genere=="") or ($data=="") or ($autore=="") or ($casa=="") or ($trama=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{

$insert="INSERT INTO `Libro` VALUES ('$isbn','$titolo','$autore','$data','$casa','$genere', '$trama')";


} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?>


