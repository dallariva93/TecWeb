<?php

	function data ($value){
		$risultato = "";
		$giorno = substr($value, 8, 2);
		$mese   = substr($value, 5, 2);
		$anno   = substr($value, 0, 4);
		$risultato = $giorno. "/". $mese. "/". $anno;
		return $risultato;
	}

	function menu(){
		Require('connect.php');
		echo file_get_contents("../HTML/Template/Menu.txt");
		if(isset($_COOKIE['admin']))
			echo "<li class='right'><a href='amministrazione.php'>Amministrazione</a></li>";
		else if(isset($_COOKIE['user'])){
			$user = $db->query("SELECT * FROM Utente WHERE Email = '".$_COOKIE['user']. "'" );
			$utente = $user->fetch_array(MYSQL_ASSOC);
			echo "<li class='right'><a href='user.php'>". $utente['Nickname']."</a></li>";
			}
		else{
			echo "
			<li class='right'><a href='accedi.html'>Accedi</a></li>
			<li class='right'><a href='registrazione.html'>Iscriviti</a></li>";
		}
		
		echo 
		"</ul>
		</div>";
	}
	function menuAdmin(){
		Require('connect.php');
		echo file_get_contents("../../HTML/Template/MenuAdmin.txt");
		if(isset($_COOKIE['admin']))
			echo "<li class='right'><a href='amministrazione.php'>Amministrazione</a></li>";
		else if(isset($_COOKIE['user'])){
			$user = $db->query("SELECT * FROM Utente WHERE Email = '".$_COOKIE['user']. "'" );
			$utente = $user->fetch_array(MYSQL_ASSOC);
			echo "<li class='right'><a href='user.php'>". $utente['Nickname']."</a></li>";
			}
		else{
			echo "
			<li class='right'><a href='accedi.html'>Accedi</a></li>
			<li class='right'><a href='registrazione.html'>Iscriviti</a></li>";
		}
		
		echo 
		"</ul>
		</div>";
	}

?>