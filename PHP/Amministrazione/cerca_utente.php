
<?php

include ('connect.php') ;

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");


$email= $_POST['email'];

if ($email=="")
{echo ("<br><h1>Inserire l'email</h1") ;} 

$query = "SELECT * FROM `email` WHERE email='$email''" ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
$i = 0;
if ($num==0){echo "<h1>Utente non trovato</h1>";}
while ($i < $num) {
$email= mysql_result($risultati, $i, "email");
$nome= mysql_result($risultati, $i, "nome");
$cognome= mysql_result($risultati, $i, "cognome");
$nickname= mysql_result($risultati, $i, "nickname");
$residenza= mysql_result($risultati, $i, "residenza");
$data= mysql_result($risultati, $i, "Data_Nascita");
?>
<tr>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $email?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $nome?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $cognome?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $nickname?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $residenza?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $data?></font></td>
</tr>
<?php
$i++;
}
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?> 
