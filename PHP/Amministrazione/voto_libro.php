
<?php

include('connect.php');

echo file_get_contents("voto_libro_inizio.txt");


$libro= $_POST['libro'];
$autore= $_POST['autore'];
$valutazione= $_POST['valutazione'];

if (($libro=="") or ($autore=="") or ($valutazione="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
if (!(mysqli_stmt_num_rows(mysqli_multi_query($db,"SELECT * FROM `libro` WHERE isbn='$libro'"))))
{echo '<br><h1>Libro non presente';}
else{
$insert="INSERT INTO `VotoLibro` VALUES ('$libro','$autore',''$valutazione')";

} 
} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("voto_libro_fine.txt");

?>


