
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="it" lang="it">
<head>
	<title>Cerca utente</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="description" content="Social network per topi di bibblioteca"/>
	<meta name="autor" content="Gruppo TW"/>
	<meta name="keywords" content="Libri,Social,Network"/>
	<meta name="robots" content="index"/>
	<meta name="viewport" content="width=device-width"/>
	<link rel="stylesheet" media="screen" href="screen.css" type="text/css" />
	<link rel="stylesheet" media="print" href="print.css" type="text/css" />
	<link rel="stylesheet" media="aural" href="screenreader.css" type="text/css" />
	<link rel="stylesheet" media="handheld, screen and (max-width:480px), only screen and (max-device-width:480px)" href="phone.css" type="text/css" />
	<link rel="stylesheet" media="handheld, screen and (min-width:480px) and (max-width:1024px), only screen and (min-width:480px) and (max-device-width:1024px)" href="tablet.css" type="text/css" />
</head>
<body>

<?php

include ('connect.php') ;


$email= $_POST['email'];

if ($email=="")
{echo ("<br><h1>Inserire l'email</h1") ;} 

$query = "SELECT * FROM `email` WHERE email='$email''" ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
?>
<table border="1" cellspacing="2" cellpadding="2" align="center">
<tr>
<th><font face="Arial, Helvetica, sans-serif">Email</font></th>
<th><font face="Arial, Helvetica, sans-serif">Nome</font></th>
<th><font face="Arial, Helvetica, sans-serif">Cognome</font></th>
<th><font face="Arial, Helvetica, sans-serif">Nickname</font></th>
<th><font face="Arial, Helvetica, sans-serif">Residenza</font></th>
<th><font face="Arial, Helvetica, sans-serif">Data di nascita</font></th>
</tr>
<?php
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
?> 
</table>
</body>
</html>
