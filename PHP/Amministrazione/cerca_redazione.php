<?php

include ('connect.php') ;

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");

$email= $_POST['email'];

if ($email=="")
{echo ("<br><h1>Inserire l'email</h1") ;} 

$query = "SELECT * FROM `Redazione` WHERE email='$email' " ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
$i = 0;
if ($num==0){echo "<h1>Redazione non trovata</h1>";}
while ($i < $num) {
$email= mysql_result($risultati, $i, "email");
$nome= mysql_result($risultati, $i, "nome");
$cognome= mysql_result($risultati, $i, "cognome");

 echo $email;
 echo $nome;
 echo $cognome;
$i++;
}
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?> 