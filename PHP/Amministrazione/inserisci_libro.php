
<?php

include('connect.php');

echo file_get_contents("inserisci_libro_inizio.txt");
$isbn= $_POST['isbn'];
$titolo= $_POST['titolo'];
$autore= $_POST['autore'];
$genere= $_POST['genere'];
$data= $_POST['data'];
$casa= $_POST['casa'];
$scrittore= $_POST['scrittore'];

if (($isbn=="") or ($titolo=="") or ($genere=="") or ($data=="") or ($autore="") or ($casa="") or ($scrittore=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
if (!(mysqli_stmt_num_rows(mysqli_multi_query($db,"SELECT * FROM `scrittore` WHERE codice='$scrittore'"))))
{echo '<br><h1>Codice scrittore non presente';}
else{
$insert="INSERT INTO `libro` VALUES ('$isbn','$titolo','$autore','$data','$casa','$genere', '$scrittore')";

} 
} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("inserisci_libro_fine.txt");
?>


