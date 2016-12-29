
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

 echo $email;
 echo $nome;
 echo $cognome;
 echo $nickname;
 echo $residenza;
 echo $data;
$i++;
}
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?> 
