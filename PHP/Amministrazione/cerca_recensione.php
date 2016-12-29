
<?php

include ('connect.php') ;

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$codice= $_POST['codice'];

if ($codice=="")
{echo ("<br><h1>Inserire il codice</h1") ;} 

$query = "SELECT * FROM `recensione` WHERE id='$codice'" ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
$i = 0;
if ($num==0){echo "<h1>Recensione non trovata</h1>";}
while ($i < $num) {
$codice= mysql_result($risultati, $i, "id");
$libro= mysql_result($risultati, $i, "libro");
$autore= mysql_result($risultati, $i, "autore");
$data= mysql_result($risultati, $i, "Data_Pubblicazione");
$testo= mysql_result($risultati, $i, "testo");
$valutazione= mysql_result($risultati, $i, "valutazione");
?>
<tr>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $codice?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $libro?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $autore?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $data?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $testo?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $valutazione?></font></td>
</tr>
<?php
$i++;
}
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?> 
