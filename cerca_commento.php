
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="it" lang="it">
<head>
	<title>Cerca commento</title>
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


$codice= $_POST['codice'];

if ($codice=="")
{echo ("<br><h1>Inserire il codice</h1") ;} 

$query = "SELECT * FROM `recensione` WHERE id='$codice'" ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
?>

<table border="1" cellspacing="2" cellpadding="2" align="center">
<tr>
<th><font face="Arial, Helvetica, sans-serif">Codice</font></th>
<th><font face="Arial, Helvetica, sans-serif">Libro</font></th>
<th><font face="Arial, Helvetica, sans-serif">Autore</font></th>
<th><font face="Arial, Helvetica, sans-serif">Data pubblicazione</font></th>
<th><font face="Arial, Helvetica, sans-serif">Testo</font></th>
<th><font face="Arial, Helvetica, sans-serif">Valutazione</font></th>
</tr>
<?php
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
<td><font face="Arial, Helvetica, sans-serif"><?php echo $codive?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $libro?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $autore?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $data?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $testo?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $valutazione?></font></td>
</tr>
<?php
$i++;
}
?> 
</table>

</body>
</html>
