<?php
     $username = "";
     $password = "";
     $host = "localhost";
     $database= "";
     $db = new mysqli($host, $username, $password,$database);
      
    if ($db->connect_errno) {
        echo "Connessione fallita: ". $db->connect_error . ".";
        exit();
    }   

#      if (!(mysqli::select_db($database, $db)))
#      {echo'Errore durante la selezione del database';}
?>
