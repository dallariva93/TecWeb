<?php
	include('connect.php');
	include('functions.php');
	
	$replaceHead=array("<title>Registrati a such wow</title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	$searchHead=array("{{title}}","{{description}}");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));
	/*echo file_get_contents("../HTML/Template/Menu.txt");
	echo "</ul></div></body>";*/
	
	$errore=false;
	

	echo str_replace("{{nickError}}", testNick() , file_get_contents("../HTML/Template/RegForm.txt"));

	
	
	
	
	
	
	/*echo		"<div class='breadcrumb corpo'>
				<p class='path'>Ti trovi in: <span xml:lang='en'><a href='index.html'>Home</a></span>/Recensioni</p>
				<div class='searchform'>
					<form action='action_page.php'>
						<div>
							<input type='text' name='googlesearch' id='search' />
							<input type='submit' value='Cerca'/>
						</div>
					</form>
				</div> 
			</div>
			<div class='box strict'>
				<h1>Registrazione</h1>
				<form action='../PHP/registrazione.php' method='post'>
					<div>
						<label for='nickname'>Nickname</label><div>",checkNick(), 
						 "</div>
						<input type='text' name='nickname' id='nickname'/>
					</div>
				</form>
			</div>
			<script src='../script.js' type='text/javascript'></script>
		</body>";
		*/

	
?>
