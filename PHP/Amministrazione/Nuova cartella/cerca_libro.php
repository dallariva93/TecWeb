<?php

include('connect.php');

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$isbn= $_POST['isbn'];

if ($isbn=="")
{echo "<br><h1>Inserire ISBN </h1>";}
else{
$query= "SELECT * FROM `Libro` WHERE ISBN='$isbn' ";

$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);


$i = 0;
if ($num==0){echo "<h1>Libro non trovato</h1>";}
$isbn= mysql_result($risultati, $i, "ISBN");
$titolo= mysql_result($risultati, $i, "Titolo");
$autore= mysql_result($risultati, $i, "Autore");
$genere= mysql_result($risultati, $i, "Genere");
$trama= mysql_result($risultati, $i, "Trama");
$casa= mysql_result($risultati, $i, "Casa_editrice");
$data= mysql_result($risultati, $i, "Anno_pubblicazio e");

echo "<h2>"$isbn;
"</h2>"
echo "<h2>"$titolo;
"</h2>"
echo "<h2>"$autore;
"</h2>"
echo "<h2>"$data; 
"</h2>"
echo "<h2>"$genere;
"</h2>"
echo "<h2>"$trama;
"</h2>"
echo "<h2>"$casa;
"</h2>"
} 
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?>
