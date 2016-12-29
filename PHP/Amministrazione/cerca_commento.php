
<?php

include ('connect.php') ;


echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$codice= $_POST['id'];
$autore= $_POST['autore'];
$data= $_POST['data'];


if (($codice=="") or ($autore=="") or ($data=="") or ($commento=="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 

$query = "SELECT * FROM `commento` WHERE recensione='$codice' AND autore='$autore' AND Data_Pubblicazione='$data' ''";
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);

$i = 0;
if ($num==0){echo "<h1>Commento non trovato</h1>";}
while ($i < $num) {
$codice= mysql_result($risultati, $i, "id");
$autore= mysql_result($risultati, $i, "libro");
$data= mysql_result($risultati, $i, "Data_Pubblicazione");
$commento= mysql_result($risultati, $i, "commento");
?>
<tr>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $codice?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $commento?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $autore?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $data?></font></td>
<?php
$i++;
}
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");
?> 
