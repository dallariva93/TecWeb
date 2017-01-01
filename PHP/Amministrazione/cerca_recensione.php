
<?php

include ('connect.php') ;

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$codice= $_POST['codice'];

if ($codice=="")
{echo ("<br><h1>Inserire il codice</h1") ;} 

else{
$query = "SELECT * FROM `Recensione` WHERE id='$codice'" ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
$i = 0;
if ($num==0){echo "<h1>Recensione non trovata</h1>";}
$codice= mysql_result($risultati, $i, "id");
$libro= mysql_result($risultati, $i, "libro");
$autore= mysql_result($risultati, $i, "autore");
$data= mysql_result($risultati, $i, "Data_Pubblicazione");
$testo= mysql_result($risultati, $i, "testo");
$valutazione= mysql_result($risultati, $i, "valutazione");
 echo "<h2>"$codice;
"</h2>"
 echo "<h2>"$libro;
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
