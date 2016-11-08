<?php

include ('connect.php') ;


$nickname= $_POST['nickname'];

if ($nickname=="")
{echo ("<br><h1>Inserire il nickname</h1") ;} 

$query = "SELECT * FROM `utente` WHERE nickname='$nickname'" ;
$risultati = mysqli_multi_query($db,$query);
$num = mysqli_stmt_num_rows($risultati);
?>
