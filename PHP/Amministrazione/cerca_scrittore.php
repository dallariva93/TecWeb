
<?php

include ('connect.php') ;

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$codice= $_POST['codice'];

if ($codice=="")
{echo ("<br><h1>Inserire il codice</h1") ;} 

$query = "SELECT * FROM `scrittore` WHERE id='$codice'" ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
$i = 0;
if ($num==0){echo "<h1>Scrittore non trovato</h1>";}
while ($i < $num) {
$codice= mysql_result($risultati, $i, "id");
$nome= mysql_result($risultati, $i, "nome");
$cognome= mysql_result($risultati, $i, "cognome");
$nazionalita= mysql_result($risultati, $i, "nazionalita");
$data= mysql_result($risultati, $i, "Data_Nascita");
?>
<tr>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $codice?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $nome?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $cognome?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $nazionalita?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $data?></font></td>
</tr>
<?php
$i++;
}
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?> 
