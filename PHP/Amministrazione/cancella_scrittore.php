<?php

include('connect.php');

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$codice= $_POST['codice'];

if ($codice=="")
{echo "<br><h1>Inserire il codice dello scrittore</h1>";}
else{
$delete = "DELETE FROM `Scrittore` WHERE Id='$codice' " ;
} 
$result = mysqli_multi_query($db,$delete);
if($result){
	echo("<br><h1>Cancellazione avvenuta correttamente</h1>");
} else{
	echo("<br><h1>Cancellazione non eseguita</h1>");
}
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?>
