<?php

include('connect.php');

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$codice= $_POST['codice'];

if ($codice=="")
{echo "<br><h1>Inserire codice</h1>";}
else{
$query= "SELECT * FROM `Notizie` WHERE id='$codice' ";

$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);


$i = 0;
if ($num==0){echo "<h1>Notizie non trovate</h1>";}
$codice= mysql_result($risultati, $i, "Id");
$titolo= mysql_result($risultati, $i, "Titolo");
$autore= mysql_result($risultati, $i, "Autore");
$data= mysql_result($risultati, $i, "Data");
$testo= mysql_result($risultati, $i, "Testo");

echo "<h2>"$codice;
"</h2>"
echo "<h2>"$titolo;
"</h2>"
echo "<h2>"$autore;
"</h2>"
echo "<h2>"$data; 
"</h2>"
echo "<h2>"$testo;
"</h2>"
} 
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?>
