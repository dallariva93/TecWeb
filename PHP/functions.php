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
		session_start();
		Require('connect.php');
		echo file_get_contents("../HTML/Template/Menu.txt");
		if(isset($_SESSION['type'])) {
			if($_SESSION['type'] == 'admin')
			echo "<li class='right'><a href='Amministrazione/amministrazione.php'>Amministrazione</a></li>";
			else if($_SESSION['type'] == 'user'){
			$user = $db->query("SELECT * FROM Utente WHERE Email = '".$_SESSION['id']. "'" );
			$utente = $user->fetch_array(MYSQLI_ASSOC);
			echo "<li class='right'><a href='user.php'>". $utente['Nickname']."</a></li>";
			}
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

function paging($currentPage, $totalNumber,$genere = ""){
	$total = floor($totalNumber/5); //numero totale di pagine
	if($totalNumber%5 == 0) //caso in cui il numero è divisibile
							//evita che venga stampata una pagina in più
		$total -= 1;
	echo "<div id='paging'><form method='post' action='recensioni.php'><div>";
	//Se la pagina corrente è minore uguale di 3 stampa l'opzione solo per le
	//prime 5 pagine, altrimenti 5 opzioni di cui quella centrale è la corrente
	//se la quinta opzione è l'ultima pagina mantiene quella come ultima e stampa
	//4 opzioni precedenti
	if( $currentPage > 3 ){
		if (  $total - 1 <= $currentPage ){
			$i = $total-4;
		}
		else {
			$i = $currentPage - 2;
		}
	}
	else {
		$i = 0;
	}
	$max = ( $i + 4 < $total)? $i + 4 : $total;
	for( $i; $i <= $max; $i++){
		if( $i == $currentPage ) //seleziono in modo diverso la pagina corrente
			echo "<button id='PagingCurrentPage' ";
		else
			echo "<button ";
		echo "type='submit' value='".
			$i."-$genere' name='page'>". ($i + 1). "</button>";
	}
	echo "</div></form></div>";
}

function ReadMore($text){
	$string = strip_tags($text);
	$maxLemgth = 200;
	if (strlen($string) > $maxLemgth) {
	    $stringCut = substr($string, 0, $maxLemgth);
		$string = $stringCut;
		$string .= " ...  continua   ...";
	}
	return "<p>". $string. "</p>";
}


function checkEmail($email)
{	include('connect.php');
	$sql= "SELECT nickname FROM Utente WHERE Email = '$email' ";
	$result = mysqli_query($db, $sql);
	if (false == $result || mysqli_num_rows($result) == 0)
		{return false;}
	else
		{return true;}
}

function checkUser($nickname)
{
	include('connect.php');
	$sql= "SELECT nickname FROM Utente WHERE Nickname = '$nickname' ";
	$result = mysqli_query($db, $sql);
	if (false == $result || mysqli_num_rows($result) == 0){return false;}
	else {return true;}
}

function checkUserSize($nickname)
{
	if((strlen($nickname)>4) && (strlen($nickname)<12)) {return true;}
	else {return false;}
}

function checkEmailForm($email)
{
	if (preg_match('/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/', $email)){return true;}
	else {return false;}
}

function multiexplode ($delimiters,$string)
{
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

function checkData($data)
{
	$arrayData = multiexplode(array("-",".","/"),$data);
	if(checkdate($arrayData[1], $arrayData[0], $arrayData[2])) {return true;}
	else {return false;}
}

function sessionLoginControl()
{
	if (array_key_exists('login', $_SESSION) && $_SESSION['login'] == true)
		{return true;}
	else
		{return false;}
}


?>
