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
			echo "<li class='right'><a href='Amministrazione/amministrazione.php'>Amministrazione</a></li>";
		else if(isset($_COOKIE['user'])){
			$user = $db->query("SELECT * FROM Utente WHERE Email = '".$_COOKIE['user']. "'" );
			$utente = $user->fetch_array(MYSQL_ASSOC);
			echo "<li class='right'><a href='user.php'>". $utente['Nickname']."</a></li>";
			}
		else{
			echo "
			<li class='right'><a href='accedi.php'>Accedi</a></li>
			<li class='right'><a href='registrazione.php'>Iscriviti</a></li>";
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
			echo "<li class='right'><a href='../user.php'>". $utente['Nickname']."</a></li>";
			}
		else{
			echo "
			<li class='right'><a href='../accedi.php'>Accedi</a></li>
			<li class='right'><a href='../registrazione.php'>Iscriviti</a></li>";
		}
		
		echo 
		"</ul>
		</div>";
	}
	

function checkEmail($email)
{	include('connect.php');	
	$sql= "SELECT nickname FROM Utente WHERE Email = '$email' ";
	$result = mysqli_query($db, $sql);
	if (false == $result || mysqli_num_rows($result) == 0)
	{
		return false;
	}
	else
	{	 
		return true;
	}
}

function checkUser($nickname)
{	include('connect.php');	
	$sql= "SELECT nickname FROM Utente WHERE Nickname = '$nickname' ";
	$result = mysqli_query($db, $sql);
	if (false == $result || mysqli_num_rows($result) == 0)
	{
		return false;
	}
	else
	{	 
		return true;
	}
}

function checkUserSize($nickname) {
	if((strlen($nickname)>4) && (strlen($nickname)<12)) 
	{
		return true;
	}
	else {return false;}
}

function checkEmailForm($email)
{
	if (!preg_match('/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/', $email))
	{
		return true;
	}
	else {return false;}
}

function multiexplode ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

function checkData($data)
{
	$arrayData = multiexplode(array("-",".","/"),$data);
	if(checkdate($arrayData[1], $arrayData[0], $arrayData[2])) {
		return true;
	}else 
		{return false;}
}
?>