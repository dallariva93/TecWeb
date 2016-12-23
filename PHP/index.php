<?php

	Require_once('connect.php');
			echo file_get_contents("../HTML/Template/Head.txt");
			
			echo "<title>SUCH WOW</title>","</head>";

			
			echo file_get_contents("../HTML/Template/Menu.txt");

			echo 	"<div class='header centrato'>
						<h1>FACE ON THE BOOK</h1>
						<p>Tieniti informato sui tuoi libri preferiti!</p>
					</div>";


			echo 	"<div class='attacca breadcrumb centrato'>
						<p class='path'>Ti trovi in: <span xml:lang='en'>Home</span>/Autore</p>";
						echo file_get_contents("../HTML/Template/Search.txt");
			echo "</div>";

			echo "
				<div class='centrato content'>
					<div class='elenco'>
						<dl class='leftBig' id='leftTb'>
							<dt>Ultime Recensioni</dt>";
							if($UltimeRec = $db->query("SELECT Libro.ISBN, Libro.Titolo, Libro.Trama, Recensione.Data_Pubblicazione FROM Libro JOIN Recensione ON(Recensione.Id = Libro.ISBN) ORDER BY Recensione.Data_Pubblicazione LIMIT 5")){
								if($UltimeRec->num_rows > 0){
									while($row = $UltimeRec->fetch_array(MYSQLI_ASSOC)){
										echo
										"<dd>
											<a href='libro.php?libro=". $row['ISBN']. "'>
													<img src='../img/cover/". $row['ISBN']. ".jpg' alt=''/>
													<object>
														<h1>". $row['Titolo']. "</h1>					
														<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.
														</p>
												</object>
												
											</a>
										</dd>";
									}
								}
							$UltimeRec->free();	
							}
						echo "</dl>";
					echo "
						<div class='rightSmall'>

								<h1>Ultime uscite</h1>						
								<ul>";
									if($UltimeExt = $db->query("SELECT ISBN, Titolo, Trama FROM Libro ORDER BY Anno_Pubblicazione LIMIT 11")){
										if($UltimeExt->num_rows > 0){
											while($rowE = $UltimeExt->fetch_array(MYSQLI_ASSOC)){
											echo
											"
											<li><a href='libro.php?libro=". $rowE['ISBN']. "'>". $rowE['Titolo']. "</a></li>
											";
											}
										}
									$UltimeExt->free();	
									}
								echo "</ul>";
						echo "</div>";

								

							
							
								
				echo
					"</div>
						</div>";



			echo file_get_contents("../HTML/Template/Footer.txt");
?>