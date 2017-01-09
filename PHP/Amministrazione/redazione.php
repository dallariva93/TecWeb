<?php

	Require_once('../connect.php');
	Require_once('../functions.php');

	echo file_get_contents("../../HTML/Template/HeadAdmin.txt");
			
	echo "<title>Recensioni - SUCH WOW </title>","</head>";

	echo menuAdmin();

	echo "<div class='breadcrumb centrato'>
	<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../index.php'>Home</a></span>/<span><a href = 'amministrazione.php'>Amministrazione</a></span>/Amministratori</p>";
	echo file_get_contents("../../HTML/Template/SearchAdmin.txt");
	echo "</div>";

	echo "<div class='centrato content'>";
	echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuovo Amministratore</a>";
	
	if($Amministratori = $db->query("SELECT * FROM Redazione ORDER BY Cognome")){
		echo "<div class='Table'><table summary = 'Elenco di tutti gli amministratori del sito'> 
		<thead>
			<tr>
				<th scope='col'>E-mail</th>
				<th scope='col'>Nome</th>
				<th scope='col'>Cognome</th>
			</tr>
		</thead>
		<tbody>
		";
		while ($Admin = $Amministratori->fetch_array(MYSQL_ASSOC)){
			echo "
			<tr>
				<td scope='row'>".$Admin['Email']."</td>
				<td scope='row'>".$Admin['Nome']."</td>
				<td scope='row'>".$Admin['Cognome']."</td>
				<td>
					<form action='../Action/deleteAdmin.php' method='post' onclick='return confirm(\"Confermi di eliminare?\")' >
						<div >
							<input type = 'hidden' name = 'id' value = '". $Admin['Email']. "' />
							<input type ='submit' value='&#x2718;' class='btnDelete' />
		   	    		</div>
					</form>
				</td>
			</tr>";

		}
		echo "</tbody></table></div>";
		$Amministratori->free();
	}
	
	//Form inserimento in redazione

	echo "<a name = 'insert'></a>
	<div class='box'>
		<h1>Inserisci nuovo amministratore</h1>
		<form action='../Action/inserisci_redazione.php' method='post' onsubmit='return check()'>
			<div>
				<label for='email'>Email</label>
				<label for='email' id='emailErr' class='formError'></label>
				<input type='text' name='emailIns' id='email'/>
				
				<label for='password'>Password</label>
				<label for='password' id='passwordErr' class='formError'></label>
				<input type='password' name='passwordIns' id='password'/>
				
				<label for='nome'>Nome</label>
				<label for='nome' id='nomeErr' class='formError'></label>
				<input type='text' name='nomeIns' id='nome'/>
				
				<label for='cognome'>Cognome</label>
				<label for='cognome' id='cognomeErr' class='formError'></label>
				<input type='text' name='cognomeIns' id='cognome'/>
				
				<input type='submit' value='Aggiungi' class='btnLong'/>
			</div>
		</form>
	</div>";

	$db->close();

	echo "</div>";//Fine content

echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>