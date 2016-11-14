
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="it" lang="it">
<head>
	<title>Cerca libro</title>
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


$isbn= $_POST['isbn'];

if ($isbn=="")
{echo ("<br><h1>Inserire ISBN</h1") ;} 

$query = "SELECT * FROM `libro` WHERE libro='$libro'" ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
?>

<table border="1" cellspacing="2" cellpadding="2" align="center">
<tr>
<th><font face="Arial, Helvetica, sans-serif">Isbn</font></th>
<th><font face="Arial, Helvetica, sans-serif">Titolo</font></th>
<th><font face="Arial, Helvetica, sans-serif">Autore</font></th>
<th><font face="Arial, Helvetica, sans-serif">Genere</font></th>
<th><font face="Arial, Helvetica, sans-serif">Casa editrice</font></th>
<th><font face="Arial, Helvetica, sans-serif">Data pubblicazione</font></th>
<th><font face="Arial, Helvetica, sans-serif">Scrittore</font></th>
</tr>
<?php
$i = 0;
if ($num==0){echo "<h1>Libro non trovato</h1>";}
while ($i < $num) {
$isbn= mysql_result($risultati, $i, "isbn");
$titolo= mysql_result($risultati, $i, "titolo");
$autore= mysql_result($risultati, $i, "autore");
$genere= mysql_result($risultati, $i, "genere");
$scrittore= mysql_result($risultati, $i, "scrittore");
$casa= mysql_result($risultati, $i, "casa");
$data= mysql_result($risultati, $i, "data");
?>
<tr>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $isbn?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $titolo?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $autore?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $genere?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $casa?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $data?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $scrittore?></font></td>
</tr>
<?php
$i++;
}
?> 
</table>

</body>
</html>
