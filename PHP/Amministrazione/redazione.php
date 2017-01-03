<?php

	Require_once('../connect.php');
	Require_once('../functions.php');

	echo file_get_contents("../../HTML/Template/HeadAdmin.txt");
			
			echo "<title>Recensioni - SUCH WOW </title>","</head>";

			echo menuAdmin();

			echo 	"<div class='breadcrumb centrato'>
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

				$Amministratori->free();
			}
			echo "</tbody></table></div>";
			

			echo "<a name = 'insert'></a>
			<div class='box'>
				<h1>Inserisci nuovo amministratore</h1>
				<form method='post' action='inserisci_redazione.php'>
					<div>
						<label for='email'>Email</label>
						<input type='text' name='email' id='email'/>
						<label for='password'>Password</label>
						<input type='password' name='password' id='password'/>
						<label for='nome'>Nome</label>
						<input type='text' name='nome' id='nome'/>
						<label for='cognome'>Cognome</label>
						<input type='text' name='cognome' id='cognome'/>
						<input type='submit' value='Aggiungi' class='btnLong'/>
					</div>
				</form>
			</div>";



			echo "</div>";

		echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>