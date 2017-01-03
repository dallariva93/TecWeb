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
				while ($Utente = $Utenti->fetch_array(MYSQL_ASSOC)){
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

			}
			echo "</tbody></table></div>";
			

			echo "<a name = 'insert'></a>
			<div class='box'>
				<h1>Inserisci utente</h1>
				<form action='../Action/inserisci_utente.php' method='post'>
					<div>
						<label for='cognome'>Cognome</label>
						<input type='text' name='cognome' id='cognome'/>
						<label for='nome'>Nome</label>
						<input type='text' name='nome' id='nome'/>
						<label for='email'>Email</label>
						<input type='text' name='email' id='email'/>
						<label for='nickname'>Nickname</label>
						<input type='text' name='nickname' id='nickname'/>
						<label for='data'>Data di nascita</label> 
						<input type='text' name='data' id='data'/>
						<label for='residenza'>Residenza</label>
						<input type='text' name='residenza' id='residenza'/>
						<label for='password'>Password</label> 
						<input type='password' name='password' id='password'/>
						<input type='submit' value='Inserisci' class='btnLong'/>
					</div>
				</form>
			</div>";



			echo "</div>";

		echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>