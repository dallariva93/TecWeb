<?php

function data ($value){
	$risultato = "";
	$giorno = substr($value, 8, 2);
	$mese   = substr($value, 5, 2);
	$anno   = substr($value, 0, 4);
	$risultato = $giorno. "/". $mese. "/". $anno;
	return $risultato;
}
function longData ($value){
	$risultato = "";
	$ora   = substr($value, 11, 2);
	$minuti   = substr($value, 14, 2);
	$risultato = data($value). " ". $ora. ":". $minuti;
	return $risultato;
}

function formattaData($data)
{
	$ris=multiexplode(array(":", " ", "-"), $data);
	$dataFormattata=$ris[2]. "/". $ris[1]. "/". $ris[0]. " ". $ris[3].":".$ris[4];
	return $dataFormattata;

}

function menu(){
		if(!isset($_SESSION))
        	session_start();

		Require('connect.php');
		echo file_get_contents("../HTML/Template/Menu.txt");
		if(isset($_SESSION['type'])) {
			echo "<li class='right'><a href='logout.php' tabindex='3'>Esci</a></li>";
			if($_SESSION['type'] == 'admin')
				echo "<li class='right'><a href='amministrazione.php' tabindex='2'>Amministrazione</a></li>";
			else if($_SESSION['type'] == 'user'){
				$user = $db->query("SELECT * FROM Utente WHERE Email = '".$_SESSION['id']. "'" );
				$utente = $user->fetch_array(MYSQLI_ASSOC);
				echo "<li class='right'><a href='profilo.php' tabindex='2'>". $utente['Nickname']."</a></li>";
			}

		}
		else{
			echo "
			<li class='right'><a href='login.php' tabindex='3'>Accedi</a></li>
			<li class='right'><a href='registrazione.php' tabindex='2'>Iscriviti</a></li>";
		}
		echo
		"</ul>
		</div>";
	}

	
function pagingNews($currentPage, $totalNumber){
	$total = floor($totalNumber/5);
	echo "<div id='paging'><form method='post' action='news.php'><div>";
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
		if( $i == $currentPage )
			echo "<button id='PagingCurrentPage' ";
		else
			echo "<button ";
		echo "type='submit' value='".
			$i."' name='page'>". ($i + 1). "</button>";
	}
	echo "</div></form></div>";
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
	$maxLemgth = 250;
	if (strlen($string) > $maxLemgth) {
	    $stringCut = substr($string, 0, $maxLemgth);
		$string = $stringCut;
		$string .= "...  continua...";
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

function multiexplode($separatori,$stringa)
{
    $a = str_replace($separatori, $separatori[0], $stringa);
    $b = explode($separatori[0], $a);
    return  $b;
}

function checkData($data)
{
	$arrayData = multiexplode(array("-",".","/"),$data);
	if(count($arrayData) == 3 && checkdate((int)$arrayData[1], (int)$arrayData[0], (int)$arrayData[2]))
		return true;
	else
		return false;
}

function sessionLoginControl()
{
	if (array_key_exists('login', $_SESSION) && $_SESSION['login'] == true)
		{return true;}
	else
		{return false;}
}
function testNick(&$errore)
{
	$nickErr = "";
	if(isset($_POST['nickname']))
	{
		if(empty($_POST['nickname']))
		{
			$errore=true;
			$nickErr="Campo obbligatorio";
		}
		elseif(checkUser(($_POST['nickname'])))
		{
			$errore=true;
			$nickErr="Nickname già in uso";
		}
		/*elseif(!checkUserSize(($_POST['nickname'])))
		{
			$errore=true;
			$nickErr="Il nickname deve essere compreso tra i 4 e i 12 caratteri";
		}*/
	}
	return $nickErr;
}

function testEmail(&$errore, $login = false)
{
	$emailErr = "";
	if(isset($_POST['email']) && !($_POST['email'] == "admin" || $_POST['email'] == "user"))
	{
		if(empty($_POST['email']))
		{
			$errore=true;
			$emailErr="Campo obbligatorio";
		}
		else if(!checkEmailForm($_POST['email']))
		{
			$errore=true;
			$emailErr="Mail non corretta";
		}
		else if( !$login && checkEmail($_POST['email']))
		{
			$errore=true;
			$emailErr="Mail già presente nel sistema";
		}
		else if($login && !checkEmail($_POST['email']))
		{
			$errore=true;
			return $emailErr="Email non presente nel sistema";
		}
	}
	return $emailErr;
}

function testDate(&$errore)
{
	$dateErr = "";
	if(isset($_POST['data']))
	{
		if(!checkData($_POST['data']))
		{
			$errore=true;
			$dateErr="Data non corretta";
		}
	}
	return $dateErr;
}

function GetData($data){
	$correctData = "";
	if ($data != ""){
		$arrayData = multiexplode(array("-",".","/"),$data);
		$correctData = $arrayData[2]."/" .$arrayData[1]."/" .$arrayData[0];	//ricostruisco la data con il separatore "/"
	}
	return $correctData;
}

function testPassword(&$errore, $wrongPassword = false)
{
	$passErr = "";
	if(isset($_POST['password']) && !($_POST['password'] == "admin" || $_POST['password'] == "user"))
	{
		if (empty($_POST ["password"]))
		{
			$errore=true;
			$passErr = "Campo obbligatorio";
		}
		//controllo se la password dehashata coincide con quella data in input
		else if($wrongPassword)
		{
			$errore=true;
			return $passErr = "Password non corretta";
		}
		else if(!preg_match("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,50}$^", $_POST ["password"]))
		{
			$errore=true;
			$passErr = "La password deve essere lunga almeno 8 caratteri e deve contenere almeno una lettera minuscola, una maiuscola e un numero";
		}

	}
	return $passErr;
}

function testNome(&$errore)
{
	$nomeErr = "";
	if(isset($_POST['nome']))
	{
		if (strlen($_POST['nome']) < 3)
		{
			$errore=true;
			$nomeErr="Il nome deve contenere almeno 3 caratteri";
		}
		else if (!preg_match("/^[a-zA-Z ]+$/", $_POST['nome'] ))
		{
		   $errore=true;
		   $nomeErr="Il nome puo avere solo lettere e spazi";
		}
	}
	return $nomeErr;
}

function testCognome(&$errore)
{
	$cognomeErr = "";
	if(isset($_POST['cognome']))
	{
		if (!preg_match("/^[a-zA-Z ]+$/", $_POST['cognome'] ))
		{
		   $errore=true;
		   $cognomeErr="Il cognome puo avere solo lettere e spazi";
		}
	}
	return $cognomeErr;
}

function testISBN(&$errore)
{
	$IsbnErr = "";
	if(isset($_POST['isbn']))
	{
		if (empty($_POST ["isbn"]))
		{
			$errore=true;
			$IsbnErr = "Campo obbligatorio";
		}
		else if(!preg_match("/[0-9]{13}/", $_POST ["isbn"]))
		{
			$errore=true;
			$IsbnErr = "Il campo deve contenere 13 caratteri numerici";
		}
	}
	return $IsbnErr;
}

function campoNonVuoto(&$errore,$campo)
{
	$Err = "";
	if(empty($campo))
	{
	   $errore=true;
	   $Err="Il campo non puó essere vuoto";
	}
	return $Err;
}

function printStar($num)
{
	$nStelle="<span class='Nascondi'>". floor($num). " su 5</span>";
	while($num>0.5)
	{
		$nStelle=$nStelle."<img class='star' src='../img/icon/Full_Star.png' alt=''/>";
		$num--;
	}
	if($num==0.5)
	{
		$nStelle=$nStelle."<img class='star' src='../img/icon/Half_Star.png' alt=''/>";
	}
	for($i=0; $i<(substr_count( $nStelle, "<img ")%5); ++$i)
		$nStelle=$nStelle."<img class='star' src='../img/icon/Empty_Star.png' alt=''/>";

	return $nStelle;
}


?>
