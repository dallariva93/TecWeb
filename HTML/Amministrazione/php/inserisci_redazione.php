
<?php

include('connect.php');

echo file_get_contents("inserisci_redazione_inizio.txt");
$email= $_POST['email'];
$nome= $_POST['nome'];
$cognome= $_POST['cognome'];

if (($email=="") or ($nome=="") or ($cognome==")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
$insert="INSERT INTO `redazione` VALUES ('$email','$nome','$cognome')";

} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
echo file_get_contents("inserisci_redazione_fine.txt");
?>


