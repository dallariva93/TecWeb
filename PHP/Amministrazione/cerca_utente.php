
<?php

include ('connect.php') ;

echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

echo file_get_contents("../../HTML/Template/MenuAdmin.txt");

echo file_get_contents("../../HTML/Template/SearchAdmin.txt");


$email= $_POST['email'];

if ($email=="")
{echo ("<br><h1>Inserire l'email</h1") ;} 

else{
$query = "SELECT * FROM `Utente` WHERE Email='$email' " ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
$i = 0;
if ($num==0){echo "<h1>Utente non trovato</h1>";}
$email= mysql_result($risultati, $i, "email");
$nome= mysql_result($risultati, $i, "nome");
$cognome= mysql_result($risultati, $i, "cognome");
$nickname= mysql_result($risultati, $i, "nickname");
$residenza= mysql_result($risultati, $i, "residenza");
$data= mysql_result($risultati, $i, "Data_Nascita");

 echo "<h2>"$email;
"</h2>"
 echo "<h2>"$nome;
"</h2>"
 echo "<h2>"$cognome;
"</h2>"
 echo "<h2>"$nickname;
"</h2>"
 echo "<h2>"$residenza;
"</h2>"
 echo "<h2>"$data;
"</h2>"
}
echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?> 
