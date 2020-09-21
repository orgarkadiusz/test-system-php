<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	include 'php/dane/dane.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	if($polaczenie->connect_errno != 0) {
		echo "Error: ".$polaczenie->connect_errno;
	}
	else {
		$sql = "SELECT
					esekretariat_wychodzace.id AS id,
					adresykontrahentow.id AS idkontrahenta,
					CONCAT(adresykontrahentow.nazwa, ', ', adresykontrahentow.ulica, '  ', adresykontrahentow.numer, ', ', adresykontrahentow.kod, '  ', adresykontrahentow.miasto) AS adresat,
					esekretariat_wychodzace.temat AS temat,
					esekretariat_wychodzace.datawyslania AS datawyslania,
					typynadania.id AS idtypnadania,
					typynadania.typ AS typnadania,
					esekretariat_wychodzace.zalacznik AS zalacznik,
					esekretariat_wychodzace.datawpisu AS datawpisu,
					esekretariat_wychodzace.wpisujacy AS wpisujacy
				FROM
					esekretariat_wychodzace
					JOIN adresykontrahentow ON esekretariat_wychodzace.adresat = adresykontrahentow.id
					JOIN typynadania ON esekretariat_wychodzace.typnadania = typynadania.id
					JOIN uzytkownicy ON esekretariat_wychodzace.wpisujacy = uzytkownicy.id
				ORDER BY
					id DESC"; ?>
		<div class='appnav'>
			<button id='esekretariatDziennikWysylekDodaj' class='btnlg glowny' type='button'>Dodaj wysyłkę</button>
		</div>
		<div class='esekretariatDziennikWysylekDodaj hidden'>
			<div class='formdiv'>
				<div class='naglowekFormularza'>
					<h2>Dodawanie nowej wysyłki</h2>
				</div>
				<hr>
				<div class='cialoFormularza'>
					<input name='adresat' type='hidden' />
					<input name='nazwaadresata' list='adresaci' type='text' placeholder='Adresat' />
					<div><datalist id='adresaci'></datalist></div>
					<input name='ulica' type='text' placeholder='Ulica' />
					<input name='numer' style='width: 50px;' type='text' placeholder='Numer' />
					<input name='kod' class='kodpocztowy' style='width: 50px;' type='text' placeholder='Kod P.' />
					<input name='miasto' type='text' placeholder='Miasto' />
					</br>
					<input name='temat' style='width: calc(50vw - 40px);' type='text' placeholder='Temat' />
					</br>
					<input name='datawprowadzana' data-toggle='datepicker' type='text' value='<?php echo date('Y-m-d'); ?>' placeholder='Data wysłania' />
					<input name='typnadania' list='typynadania' type='text' placeholder='Typ nadania' />
					<div><datalist id='typynadania'></datalist></div>
					</br>
					<input id='zalacznik' name='zalacznik' type='file' class='inputfile zalacznik'>
					<label for='zalacznik'><span>Dołącz plik</span></label>
					<button class='btn info dodajzalacznik'>Dodaj załącznik</button>
				</div>
				<hr>
				<div class='stopkaFormularza'>
					<button class='btn uwaga anulujform'>Anuluj</button>
					<button id='esekretariatDziennikWysylekDodajNowa' class='btn sukces zapiszform'>Zapisz</button>
				</div>
			</div>
		</div>
		<div class='dziennikwysylekedit hidden'>
			<div class='formdiv'>
				<div class='naglowekFormularza'>
					<h2>Edycja wysyłki</h2>
				</div>
				<hr>
				<div class='cialoFormularza'>
					<input name='idedycji' type='hidden' />
					<input name='adresatold' type='hidden' />
					<input name='adresat' type='hidden' />
					<input name='nazwaadresata' list='adresaci' type='text' placeholder='Adresat' />
					<div><datalist id='adresaci'></datalist></div>
					<input name='ulica' type='text' placeholder='Ulica' />
					<input name='numer' style='width: 50px;' type='text' placeholder='Numer' />
					<input name='kod' class='kodpocztowy' style='width: 50px;' type='text' placeholder='Kod P.' />
					<input name='miasto' type='text' placeholder='Miasto' />
					</br>
					<input name='temat' style='width: calc(50vw - 40px);' type='text' placeholder='Temat' />
					</br>
					<input name='datawprowadzana' data-toggle='datepicker' type='text' value='' placeholder='Data wysłania' />
					<input name='typnadania' list='typynadania' type='text' placeholder='Typ nadania' />
					<div><datalist id='typynadania'></datalist></div>
					</br>
					<input id='zalacznik' type='hidden' class='zalacznik'>
					<button class='btn info dodajzalacznik'>Dodaj załącznik</button>
					<input type='hidden' name='zalacznikiold' />
					<input type='hidden' name='skasowanezalaczniki' />
				</div>
				<hr>
				<div class='stopkaFormularza'>
					<button class='btn uwaga anulujform'>Anuluj</button>
					<button id='esekretariatDziennikWysylekEdytuj' class='btn sukces zapiszform'>Zapisz</button>
				</div>
			</div>
		</div>
		<table class='sTabela eSekretariatWysylki'>
			<thead>
				<th style='width: 3%;'>ID</th>
				<th>Adresat</th>
				<th style='width: 30%;'>Temat</th>
				<th style='width: 10%;'>Data wysłania</th>
				<th style='width: 10%;'>Typ nadania</th>
				<th style='width: 7%;'>Załącznik</th>
				<th style='width: 10%;'>Opcje</th>
			</thead>
			<?php if($rezultat = @$polaczenie->query($sql)) {
				while($wiersz = $rezultat->fetch_assoc()) { ?>
					<tbody id='dziennikwysylek<?php echo $wiersz['id']; ?>'>
						<tr>
							<td><?php echo $wiersz['id']; ?></td>
							<td><span class='hidden idkontrahenta'><?php echo $wiersz['idkontrahenta']; ?></span><?php echo $wiersz['adresat']; ?></td>
							<td><?php echo $wiersz['temat']; ?></td>
							<td><?php echo $wiersz['datawyslania']; ?></td>
							<td><span class='hidden idtypnadania'><?php echo $wiersz['idtypnadania']; ?></span><?php echo $wiersz['typnadania']; ?></td>
							<td>
								<?php if(isset($wiersz['zalacznik']) AND $wiersz['zalacznik'] != '') { 
									$pliki = explode(';;', $wiersz['zalacznik']); 
									for($i = 0; $i < count($pliki); $i++) { 
										if(isset($pliki[$i]) AND $pliki[$i] != '') {
											$podzialy = explode('.', $pliki[$i]);
											$rozszerzenie = end($podzialy); ?>
											<a href='<?php echo $pliki[$i]; ?>' target='_blank'><img src='icon/<?php echo $rozszerzenie; ?>.svg' class='ikonka' /></a>
										<?php }
									}
								} ?>
							</td>
							<td>
								<span class='edit' editing='dziennikwysylek<?php echo $wiersz['id']; ?>'>Edytuj</span>
							</td>
						</tr>
					</tbody>
				<?php }
			} ?>
		</table>
	<?php }
?>