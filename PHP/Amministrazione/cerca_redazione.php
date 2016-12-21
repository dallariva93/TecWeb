


<?php

include ('connect.php') ;

echo file_get_contents("cerca_redazione_inizio.txt");

$email= $_POST['email'];

if ($email=="")
{echo ("<br><h1>Inserire l'email</h1") ;} 

$query = "SELECT * FROM `redazione` WHERE email='$email'" ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
$i = 0;
if ($num==0){echo "<h1>Redazione non trovata</h1>";}
while ($i < $num) {
$email= mysql_result($risultati, $i, "email");
$nome= mysql_result($risultati, $i, "nome");
$cognome= mysql_result($risultati, $i, "cognome");
?>
<tr>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $email?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $nome?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $cognome?></font></td>
</tr>
<?php
$i++;
}
echo file_get_contents("cerca_redazione_fine.txt");
?> 