<?php
     $username = "andrea";
     $password = "andrea";
     $host = "localhost";
     $database= "libri";
     if (!( $db = new mysqli($host, $username, $password,$database))) 
         {echo 'Errore durante la connessione al database';} 

if ($mysqli->connect_errno) {
        echo "Il sito ha dei problemi di funzionamento.";
  
	    echo "Errore: Connessione fallita : \n";
	        echo "Errno: " . $mysqli->connect_errno . "\n";
		    echo "Error: " . $mysqli->connect_error . "\n";

        exit;
	}

#      if (!(mysqli::select_db($database, $db)))
#      {echo'Errore durante la selezione del database';}
?>
