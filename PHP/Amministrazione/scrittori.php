<?php

	Require_once('../connect.php');
	Require_once('../functions.php');

	echo file_get_contents("../../HTML/Template/HeadAdmin.txt");
			
			echo "<title>Scrittori - SUCH WOW </title>","</head>";

			echo menuAdmin();

			echo 	"<div class='breadcrumb centrato'>
						<p class='path'>Ti trovi in: <span xml:lang='en'> <a href='../index.php'>Home</a></span>/<span><a href = 'amministrazione.php'>Amministrazione</a></span>/Scrittori</p>";
						echo file_get_contents("../../HTML/Template/SearchAdmin.txt");
			echo "</div>";
			echo "<div class='centrato content'>";
			echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuovo Scrittore</a>";
			if($Scrittori = $db->query("SELECT * FROM Scrittore ORDER BY Cognome")){
				echo "<div class='Table'><table summary = 'Elenco di tutti gli scrittori presenti nel sito'> 
				<thead>
					<tr>
						<th scope='col'>Cognome</th>
						<th scope='col'>Nome</th>
						<th scope='col'>Data di nascita</th>
						<th scope='col'>Nazionalit&agrave;</th>
						<th scope='col'>Id</th>
					</tr>
				</thead>
				<tbody>
				";
				while ($Scrittore = $Scrittori->fetch_array(MYSQL_ASSOC)){
					echo "
					<tr>
						<td scope='row'>".$Scrittore['Cognome']."</td>
						<td>".$Scrittore['Nome']. "</td>
						<td>".Data($Scrittore['Data_Nascita']). "</td>
						<td>".$Scrittore['Nazionalita']."</td>
						<td>".$Scrittore['Id']."</td>
						<td>
							<form action='../Action/deleteWriter.php' onclick='return confirm(\"Confermi di eliminare?\")' method='post'>
								<div >
									<input type = 'hidden' name = 'id' value = '". $Scrittore['Id']. "' />
									<input type ='submit' value='&#x2718;' class='btnDelete' />
				   	    		</div>
							</form>
						</td>
					</tr>";

				}

				$Scrittori->free();
			}
			echo "</tbody></table></div>";
			
			echo "<a name = 'insert'></a>
			<div class='box'>
			<h1>Inserisci scrittore</h1>
			<form method='post' action='inserisci_scittore.php' onsubmit='return check()'>
				<div>
					<label for='id'>Id</label>
					<label for='id' id='codeErr' class='formError'></label>
					<input type='text' name='idIns' id='id'/>
					
					<label for='nome'>Nome</label>
					<label for='nome' id='nomeErr' class='formError'></label>
					<input type='text' name='nomeIns' id='nome'/>
					
					<label for='cognome'>Cognome</label>
					<label for='cognome' id='cognomeErr' class='formError'></label>
					<input type='text' name='cognomeIns' id='cognome'/>
					
					<label for='nazionalita'>Nazionalit&agrave;</label>
					<input type='text' name='nazionalita' id='nazionalita'/>
					
					<label for='data'>Data di nascita</label>
					<label for='data' id='dataErr' class='formError'></label>
					<input type='text' name='dataIns' id='data'/>
					
					<input type='submit' value='Inserisci' class='btnLong'/>
				</div>
			</form>
		</div>";



			echo "</div>";

		echo file_get_contents("../../HTML/Template/FooterAdmin.txt");

?>