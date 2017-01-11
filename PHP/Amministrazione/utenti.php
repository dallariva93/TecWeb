<?php

	Require_once('../connect.php');
	Require_once('../functions.php');

	echo file_get_contents("../../HTML/Template/HeadAdmin.txt");

	echo "<title>Amministrazione - SUCH WOW </title>","</head>";

	echo menuAdmin();

	echo 	"<div class='breadcrumb centrato'>
				<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../index.php'>Home</a></span>/<span><a href = 'amministrazione.php'>Amministrazione</a></span>/Utenti</p>";
				echo file_get_contents("../../HTML/Template/SearchAdmin.txt");
	echo "</div>";

	echo "<div class='centrato content'>";
	echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuovo Utente</a>";

	if($Utenti = $db->query("SELECT * FROM Utente ORDER BY Cognome")){
		echo "<div class='Table'><table summary = 'Elenco di tutti gli utenti presenti nel sito'>
		<thead>
			<tr>
				<th scope='col'>Cognome</th>
				<th scope='col'>Nome</th>
				<th scope='col'>E-Mail</th>
				<th scope='col'>Username</th>
				<th scope='col'>Data di nascita</th>
				<th scope='col'>Residenza</th>
			</tr>
		</thead>
		<tbody>
		";
		while ($Utente = $Utenti->fetch_array(MYSQLI_ASSOC)){
			echo "
			<tr>
				<td scope='row'>".$Utente['Cognome']."</td>
				<td>".$Utente['Nome']. "</td>
				<td>".$Utente['Email']."</td>
				<td>".$Utente['Nickname']."</td>
				<td>".Data($Utente['Data_Nascita']). "</td>
				<td>".$Utente['Residenza']."</td>
				<td>
					<form action='../Action/deleteUser.php' onclick='return confirm(\"Confermi di eliminare?\")' method='post'>
						<div >
							<input type = 'hidden' name = 'email' value = '". $Utente['Email']. "' />
							<input type ='submit' value='&#x2718;' class='btnDelete' />
		   	    		</div>
					</form>
				</td>
			</tr>";

		}
		$Utenti->free();
		echo "</tbody></table></div>";

	}

	//Form inserimento

	echo "<a name = 'insert'></a>
	<div class='box'>
		<h1>Inserisci utente</h1>
		<form action='../Action/inserisci_utente.php' method='post' onsubmit='return check()'>
			<div>
				<label for='cognome'>Cognome</label>
				<label for='cognome' id='cognomeErr' class='formError'></label>
				<input type='text' name='cognomeIns' id='cognome'/>

				<label for='nome'>Nome</label>
				<label for='nome' id='nomeErr' class='formError'></label>
				<input type='text' name='nomeIns' id='nome'/>

				<label for='email'>Email</label>
				<label for='email' id='emailErr' class='formError'></label>
				<input type='text' name='emailIns' id='email'/>

				<label for='nickname'>Nickname</label>
				<label for='nickname' id='nicknameErr' class='formError'></label>
				<input type='text' name='nicknameIns' id='nickname'/>

				<label for='data'>Data di nascita</label>
				<label for='data' id='dataErr' class='formError'></label>
				<input type='text' name='dataIns' id='data'/>

				<label for='residenza'>Residenza</label>
				<label for='residenza' id='residenzaErr' class='formError'></label>
				<input type='text' name='residenzaIns' id='residenza'/>

				<label for='password'>Password</label>
				<label for='password' id='passwordErr' class='formError'></label>
				<input type='password' name='passwordIns' id='password'/>

				<input type='submit' value='Inserisci' class='btnLong'/>
			</div>
		</form>
	</div>";

	$db->close();

	echo "</div>";//Fine content

	echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>
