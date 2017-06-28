<?php
     $username = "root";
     $password = "";
     $host = "localhost";
     $database= "gdallari";
     $db = new mysqli($host, $username, $password,$database);

    if ($db->connect_errno) {
        header("Location: page_not_found.php");
        exit();
    }
?>
