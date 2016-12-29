
<?php

include ('connect.php') ;

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$isbn= $_POST['isbn'];

if ($isbn=="")
{echo ("<br><h1>Inserire ISBN</h1") ;} 

$query = "SELECT * FROM `libro` WHERE libro='$libro'" ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);

$i = 0;
if ($num==0){echo "<h1>Libro non trovato</h1>";}
while ($i < $num) {
$isbn= mysql_result($risultati, $i, "isbn");
$titolo= mysql_result($risultati, $i, "titolo");
$autore= mysql_result($risultati, $i, "autore");
$genere= mysql_result($risultati, $i, "genere");
$scrittore= mysql_result($risultati, $i, "scrittore");
$casa= mysql_result($risultati, $i, "casa");
$data= mysql_result($risultati, $i, "data");

 echo $isbn;
 echo $titolo;
 echo $autore;
 echo $genere;
 echo $casa;
 echo $data;
 echo $scrittore;
$i++;
}
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?> 
