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
		echo file_get_contents("../HTML/Template/Menu.txt");
		if(isset($_COOKIE['admin']))
			echo "<li class='right'><a href='amministrazione.php'>Amministrazione</a></li>";
		else if(isset($_COOKIE['user']))
			echo "<li class='right'><a href='user.php'>". $_COOKIE['user']."</a></li>";
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
		echo file_get_contents("../../HTML/Template/Menu.txt");
		if(isset($_COOKIE['admin']))
			echo "<li class='right'><a href='amministrazione.php'>Amministrazione</a></li>";
		else if(isset($_COOKIE['user']))
			echo "<li class='right'><a href='user.php'>". $_COOKIE['user']."</a></li>";
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