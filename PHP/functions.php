<?php

Require_once('connect.php');

function Data($value,$time = false){
	$risultato = "";
	if( $value != ""){
		$data = multiexplode(array(":", " ", "-"), $value);
		$risultato = $data[2]. "/". $data[1]. "/". $data[0];
		if( $time )
			$risultato .= " ". $data[3]. ":" .$data[4];
	}
	return $risultato;
}
function GetData($data){
	$correctData = "";
	if ($data != ""){
		$arrayData = multiexplode(array("-",".","/"),$data);
		$correctData = $arrayData[2]."/" .$arrayData[1]."/" .$arrayData[0];	//ricostruisco la data con il separatore "/"
	}
	return $correctData;
}

function menu(){
		if(!isset($_SESSION))
        	session_start();

        if (isset($_SESSION['ultimaAttivita']) && (time() - $_SESSION['ultimaAttivita'] > 1800)) //dopo 30 minuti di inattività distrugge la sessione
        {
			session_unset();
			session_destroy();
			header('Location: index.php');
		}
		$_SESSION['ultimaAttivita'] = time();

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
			echo file_get_contents("../HTML/Template/MenuNonLogin.txt");
		}
		echo
		"</ul></div>";
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
		echo "type='submit' value=\"".
			$i."-$genere\" name='page'>". ($i + 1). "</button>";
	}
	echo "</div></form></div>";
}
function pagingNews($currentPage, $totalNumber){
	$total = floor($totalNumber/5);
	if($totalNumber%5 == 0)
		$total -= 1;

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

function pagingClassifica($currentPage, $totalNumber,$tipoClassifica = "",$ordine = "",$genere = ""){
	$total = floor($totalNumber/10);
	if($totalNumber%10 == 0)
		$total -= 1;
	echo "<div id='paging'><form method='post' action='classifica.php'><div>";
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
		echo "type='submit' value=\"".
			$i."-$tipoClassifica-$ordine-$genere\" name='page'>". ($i + 1). "</button>";
	}
	echo "</div></form></div>";
}


function ReadMore($text){

	$string = strip_tags($text);
	$numeroMassimo = 35;


	$parole = explode(" ", $string);
	$risultato = implode(" ", array_splice($parole, 0, $numeroMassimo));


	return "<p>". $risultato. "&#8230;</p>";
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

function testImage(&$flag)
{
	$Errore = "";
		if (isset($_FILES['img']) && file_exists($_FILES['img']['tmp_name']) &&
			is_uploaded_file($_FILES['img']['tmp_name'])){
			$imageFileType = pathinfo($_FILES["img"]["name"],PATHINFO_EXTENSION);
			if($imageFileType != "jpg" && $imageFileType != "png" &&
				$imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$flag = true;
				$Errore = "Formato non corretto";
			}
			else if($_FILES["img"]["size"] > 1000000) {
				$flag = true;
				$Errore = "Dimensione troppo grande";
			}
		}
		else if (isset($_FILES['img']) && (!file_exists($_FILES['img']['tmp_name']) ||
			!is_uploaded_file($_FILES['img']['tmp_name']))){
			$flag = true;
			$Errore = "Nessun file selezionato";
		}
	return $Errore;
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

function deleteProfile($db)
	{
		echo $_SESSION['id'];
		$query="DELETE FROM `Utente` WHERE `Email` = '".$_SESSION['id']."'";
		mysqli_query($db, $query);
		session_unset();
		session_destroy();
		header('Location: index.php');
	}



	function stampaDati($db)
	{
		$user = $db->query("SELECT * FROM Utente WHERE Email = '".$_SESSION['id']. "'" );
		$utente = $user->fetch_array(MYSQLI_ASSOC);
		$searchDati=array("{{nickname}}","{{nome}}","{{cognome}}","{{email}}");
		$replaceDati=array($utente['Nickname'], $utente['Nome'], $utente['Cognome'], $utente['Email']);
		return str_replace($searchDati ,$replaceDati, file_get_contents("../HTML/Template/Dati.txt"));


	}

	function stampaLibri($db, $page=0)
	{
		$lib=$db->query("SELECT Libro FROM VotoLibro WHERE Autore = '".$_SESSION['id']. "'");
		$vot=$db->query("SELECT Valutazione FROM VotoLibro WHERE Autore = '".$_SESSION['id']. "'");
		$arrayVoti=array();
		$arrayISBN=array();
		$arrayLibri=array();
		$arrayStelle=array();
		$i=$l=0;
		$bookPerPage=15;
		while ($row = mysqli_fetch_array($lib)) 	//riempio l'array
		{
			array_push($arrayISBN,$row);
		}

		while ($row = mysqli_fetch_array($vot)) 	//riempio l'array
		{
			array_push($arrayVoti,$row);
		}

		while($l<count($arrayVoti))
		{
			$arrayStelle[$l]=printStar($arrayVoti[$l][0]);
			$l++;
		}


		$searchVotiLibro=array("{{ISBN}}", "{{titolo}}", "{{voto}}");
		echo "<div class='contentProf centrato'>";
		if(count($arrayISBN)>0)
			echo "<ul>";
		while($i<count($arrayISBN) )  		//riempio l'array
		{

			$lib=$db->query("SELECT Titolo FROM `Libro` WHERE ISBN='".$arrayISBN[$i][0]."' ORDER BY Titolo");
			$libro=mysqli_fetch_array($lib);
			array_push($arrayLibri, $libro);
			$i++;
		}

		//stampo le miniature dei libri
		$i=0;
		if(count($arrayISBN)==0)
				echo "<div class='Errore'>Non hai votato nessun libro!</div>";
		if(count($arrayISBN)>0)
		{	while($i<$bookPerPage && $i+($page*$bookPerPage)<count($arrayISBN) )
			{
				$replaceVotiLibro=array($arrayISBN[$i+($page*$bookPerPage)][0], $arrayLibri[$i+($page*$bookPerPage)][0], $arrayStelle[$i+($page*$bookPerPage)]);
				echo str_replace($searchVotiLibro, $replaceVotiLibro, file_get_contents("../HTML/Template/MiniaturaLibroProfilo.txt"));
				$i++;
			}
			echo "</ul>";
		}

		echo "</div>";

		if(count($arrayISBN)<=$bookPerPage)			//ho meno elementi di bookPerPage, non stampo i bottoni
		{}
		elseif(!isset($_GET['books']) || $_GET['books']==0)				//pagina iniziale, non stampo il bottone indietro
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1, "hidden", "");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/BooksButtons.txt"));
		}
		elseif(($_GET['books'])+1>=count($arrayISBN)/$bookPerPage)				//pagina finale, non stampo il bottone avanti
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1,"", "hidden");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/BooksButtons.txt"));
		}
		else 					//pagine intermedie, li stampo entrambi
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1,"", "");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/BooksButtons.txt"));
		}
	}

	function stampaCommenti($db, $page=0)
	{
		//$page do valore da get

		$commentsPerPage=10;
		$com = $db->query("SELECT Data_Pubblicazione, News, Commento FROM CommentiNews WHERE Autore = 'user' 
						UNION 
						SELECT Data_Pubblicazione, Libro, Commento FROM Commenti WHERE Autore = 'user' 
						ORDER BY Data_Pubblicazione DESC LIMIT $commentsPerPage OFFSET " .($page*$commentsPerPage) );
		$totCom = $db->query("SELECT Data_Pubblicazione, Libro, Commento FROM Commenti WHERE Autore = '".$_SESSION['id']. "'");

		$arrayCommenti= array();
		$arrayTotCommenti = array();
		while ($row = mysqli_fetch_array($com)) 	//riempio l'array con array date, commenti e libro della recensione
		{
			array_push($arrayCommenti,$row);
		}

		$i=0;
		$searchCommento=array("{{libro}}","{{dataCommento}}","{{testoCommento}}");
		$numComm=count($arrayCommenti);
		while ($row = mysqli_fetch_array($totCom))
		{
			array_push($arrayTotCommenti,$row);
		}

		echo "<div class='contentProf centrato'>";
		if(count($arrayTotCommenti)==0)
			echo "<div class='Errore'>Non hai nessun commento!</div>";
		while($i<count($arrayCommenti))
		{
			
			($arrayCommenti[$i][1]>9779999999999) ? $lib=$db->query("SELECT Titolo FROM `Libro` WHERE ISBN='".$arrayCommenti[$i][1]."'") : $lib=$db->query("SELECT Titolo FROM `Notizie` WHERE Id='".$arrayCommenti[$i][1]."'");
			$libro=mysqli_fetch_array($lib);
			$data=Data($arrayCommenti[$i][0],true);
			$replaceCommento=array($libro[0], $data, $arrayCommenti[$i][2]);
			echo str_replace($searchCommento, $replaceCommento, file_get_contents("../HTML/Template/CommentoProfilo.txt"));
			$i++;

		}
		echo"</div>";



		if(count($arrayTotCommenti)<=$commentsPerPage || count($arrayTotCommenti)==0)											//ho meno di $commentsPerPage elementi non stampo ne avanti ne indietro
		{}
		elseif(!isset($_GET['page']) || $_GET['page']==0)				//pagina iniziale, non stampo il bottone indietro
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1, "hidden", "");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/CommentsButtons.txt"));
		}
		elseif(($_GET['page'])+1>=count($arrayTotCommenti)/$commentsPerPage)				//pagina finale, non stampo il bottone avanti
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1,"", "hidden");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/CommentsButtons.txt"));
		}
		else 					//pagine intermedie, li stampo entrambi
		{
			$arrayButtonSearch=array("{{vals}}", "{{valp}}", "{{classeIndietro}}", "{{classeAvanti}}");
			$arrayButtonReplace=array($page+1, $page-1,"", "");
			echo str_replace($arrayButtonSearch,$arrayButtonReplace , file_get_contents("../HTML/Template/CommentsButtons.txt"));
		}

}

	function modificaPass($db)
	{
		$UserPassQuery="SELECT Password FROM `Utente` WHERE Email='".$_SESSION['id']."'";
		$AdminPassQuery="SELECT Password FROM `Redazione` WHERE Email='".$_SESSION['id']."'";
		$password = $wrongPassword = "";
		//cerco tra gli utenti
		$gruppo = $db->query($UserPassQuery);
		$admin=$user=false;
		if ( $gruppo->num_rows > 0){ //é un utente
			$user = true;
		}
		else{
			$gruppo = $db->query($AdminPassQuery);
			if ( $gruppo->num_rows > 0){ //é un admin
				$admin = true;
			}
		}
		if( $admin || $user ){
			$Getpassword = $gruppo->fetch_array(MYSQLI_ASSOC);
			$password = $Getpassword['Password'];
		}
		if($password != "" && isset($_POST['Vpassword']))
		//Controllo se la password é corretta
		$wrongPassword =  !(password_verify($_POST['Vpassword'],$password));
		$gruppo->free();

		$searchInForm=array("{{VpassError}}","{{NpassError}}","{{CpassError}}");
		$replaceInForm=array(testVPassword($errore, $wrongPassword), testPassword($errore), ConfirmPassword($errore));
		echo str_replace($searchInForm, $replaceInForm , file_get_contents("../HTML/Template/ModificaPass.txt"));

	}



	function testVPassword(&$errore, $wrongPassword = false)
{
	$passErr = "";
	if(isset($_POST['Vpassword']) && !($_POST['Vpassword'] == "admin" || $_POST['Vpassword'] == "user"))
	{

		if (empty($_POST ["Vpassword"]))
		{
			$errore=true;
			$passErr = "Campo obbligatorio";
		}
		//controllo se la password dehashata coincide con quella data in input
		else if(!preg_match("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,50}$^", $_POST ["Vpassword"]))
		{
			$errore=true;
			$passErr = "La password deve essere lunga almeno 8 caratteri e deve contenere almeno una lettera minuscola, una maiuscola e un numero";
		}
		else if($wrongPassword)
		{
			$errore=true;
			return $passErr = "Password non corretta";
		}

	}
	return $passErr;
}

	function ConfirmPassword(&$errore)
	{
		if(isset($_POST['password']) && isset($_POST['Cpassword']) && $_POST['password']!=$_POST['Cpassword'])
		{
			$errore=true;
			return $passErr = "Le due password non coincidono";
		}
	}

?>
