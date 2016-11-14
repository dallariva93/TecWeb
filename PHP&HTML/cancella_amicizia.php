<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="it" lang="it">
<head>
	<title>Cancella amicizia</title>
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

include('connect.php');

$email_a= $_POST['email_a'];
$email_b= $_POST['email_b'];

if (($email_a=="") or ($email_b=="")) 
{echo "<br><h1>Inserire le email </h1>";}
else{
$delete = "DELETE FROM `amicizia` WHERE persona1='$email_a' AND persona2='$email_b' ''";
} 
$result = mysqli_multi_query($db,$delete);
if($result){
	echo("<br><h1>Cancellazione avvenuta correttamente</h1>");
} else{
	echo("<br><h1>Cancellazione non eseguita</h1>");
}
?>
</body>
</html>
