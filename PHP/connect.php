<?php
     $username = "root";
     $password = "";
     $host = "localhost";
     $database= "TW";
     $db = new mysqli($host, $username, $password,$database);
      
    if ($db->connect_errno) {
        echo "Connessione fallita: ". $connessione->connect_error . ".";
        exit();
    }   

#      if (!(mysqli::select_db($database, $db)))
#      {echo'Errore durante la selezione del database';}
?>
