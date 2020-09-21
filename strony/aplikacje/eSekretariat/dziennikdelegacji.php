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
					esekretariat_przychodzace.id AS id,
					adresykontrahentow.id AS idkontrahenta,
					CONCAT(adresykontrahentow.nazwa, ', ', adresykontrahentow.ulica, '  ', adresykontrahentow.numer, ', ', adresykontrahentow.kod, '  ', adresykontrahentow.miasto) AS nadawca,
					esekretariat_przychodzace.temat AS temat,
					esekretariat_przychodzace.opisdodatkowy AS opis,
					esekretariat_przychodzace.datawplywu AS datawplywu,
					esekretariat_przychodzace.powiadomiono AS powiadomiono,
					esekretariat_przychodzace.zalacznik AS zalacznik,
					esekretariat_przychodzace.datawystawienia AS datawystawienia,
					esekretariat_przychodzace.czypobrano AS czypobrano,
					esekretariat_przychodzace.ktopobral AS ktopobral,
					dzialy.id AS iddzial,
					dzialy.skrot AS dzial,
					esekretariat_przychodzace.datapobrania AS datapobrania,
					esekretariat_przychodzace.datawpisu AS datawpisu,
					esekretariat_przychodzace.wpisujacy AS wpisujacy
				FROM
					esekretariat_przychodzace
					JOIN adresykontrahentow ON esekretariat_przychodzace.nadawca = adresykontrahentow.id
					JOIN uzytkownicy ON esekretariat_przychodzace.wpisujacy = uzytkownicy.id
					JOIN dzialy ON esekretariat_przychodzace.dzial = dzialy.id
				ORDER BY
					id DESC"; ?>
		<div class='appnav'>
			<button id='esekretariatDziennikPrzyjecDodaj' class='btnlg glowny' type='button'>Dodaj przyjęcie</button>
		</div>
		<div class='esekretariatDziennikPrzyjecDodaj hidden'>
			<div class='formdiv'>
				<div class='naglowekFormularza'>
					<h2>Dodawanie nowego przyjęcia</h2>
				</div>
				<hr>
				<div class='cialoFormularza'>
					<input name='nadawca' type='hidden' />
					<input name='nazwanadawcy' list='nadawcy' type='text' placeholder='Nadawca' />
					<div><datalist id='nadawcy'></datalist></div>
					<input name='ulica' type='text' placeholder='Ulica' />
					<input name='numer' style='width: 50px;' type='text' placeholder='Numer' />
					<input name='kod' class='kodpocztowy' style='width: 50px;' type='text' placeholder='Kod P.' />
					<input name='miasto' type='text' placeholder='Miasto' />
					</br>
					<input name='temat' style='width: calc(50vw - 40px);' type='text' placeholder='Temat' />
					<input name='opis' style='width: calc(50vw - 40px);' type='text' placeholder='Opis (opcjonalnie)' />
					</br>
					<input name='datawprowadzana' data-toggle='datepicker' type='text' value='<?php echo date('Y-m-d'); ?>' placeholder='Data przyjęcia' />
					<input name='dzial' list='dzialy' type='text' placeholder='Dział adresata' />
					<div><datalist id='dzialy'></datalist></div>
					</br>
					<input id='zalacznik' name='zalacznik' type='file' class='inputfile zalacznik'>
					<label for='zalacznik'><span>Dołącz plik</span></label>
					<button class='btn info dodajzalacznik'>Dodaj załącznik</button>
				</div>
				<hr>
				<div class='stopkaFormularza'>
					<button class='btn uwaga anulujform'>Anuluj</button>
					<button id='esekretariatDziennikPrzyjecDodajNowa' class='btn sukces zapiszform'>Zapisz</button>
				</div>
			</div>
		</div>
		<div class='dziennikprzyjecedit hidden'>
			<div class='formdiv'>
				<div class='naglowekFormularza'>
					<h2>Edycja przyjecia</h2>
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
					<button id='esekretariatDziennikPrzyjecEdytuj' class='btn sukces zapiszform'>Edytuj</button>
				</div>
			</div>
		</div>
		<div class='esekretariatDziennikPrzyjecPowiadom hidden'>
			<div class='formdiv'>
				<div class='naglowekFormularza'>
					<h2>Powiadom o przesyłce</h2>
				</div>
				<hr>
				<div class='cialoFormularza'>
					<input name='idprzyjecia' type='hidden' />
					<input name='tematpowiadomienia' type='hidden' />
					<input name='nadawca' type='hidden' />
					<input name='datapowiadomienia' type='hidden' />
					<input name='adresat' type='text' placeholder='Adresat (imie nazwisko)' />
					<input name='emailadresata' list='uzytkownicy' type='text' placeholder='e-mail' style='width: 20vw;' />
					<div><datalist id='uzytkownicy'><datalist></div>
					</br>
					<label class='nl'>Wybierz załączniki do wysłania:</label>
				</div>
				<hr>
				<div class='stopkaFormularza'>
					<button class='btn uwaga anulujform'>Anuluj</button>
					<button id='esekretariatDziennikPrzyjecPowiadom' class='btn sukces zapiszform'>Powiadom</button>
				</div>
			</div>
		</div>
		<div class='esekretariatPobrano hidden'>
			<div class='formdiv'>
				<div class='naglowekFormularza'>
					<h2>Pobrano przesyłkę</h2>
				</div>
				<hr>
				<div class='cialoFormularza'>
					<input name='idprzyjecia' type='hidden' />
					<input name='pobierajacy' list='pobierajacy' type='text' placeholder='Pobierający (imie nazwisko)' />
					<div><datalist id='pobierajacy'><datalist></div>
				</div>
				<hr>
				<div class='stopkaFormularza'>
					<button class='btn uwaga anulujform'>Anuluj</button>
					<button id='esekretariatPobrano' class='btn sukces zapiszform'>Zapisz</button>
				</div>
			</div>
		</div>
		<table class='sTabela eSekretariatPrzyjecia'>
			<thead>
				<th style='width: 3%;'>ID</th>
				<th>Nadawca</th>
				<th style='width: 15%;'>Temat</th>
				<th style='width: 15%;'>Opis</th>
				<th style='width: 8%;'>Data wpływu</th>
				<th style='width: 7%;'>Załącznik</th>
				<th style='width: 20%;'>Powiadomiono</th>
				<th style='width: 7%;'>Pobrano Oryginał</th>
				<th style='width: 5%;'>Dział</th>
				<th style='width: 5%;'>Opcje</th>
			</thead>
			<?php if($rezultat = @$polaczenie->query($sql)) {
				while($wiersz = $rezultat->fetch_assoc()) { ?>
					<tbody id='dziennikprzyjec<?php echo $wiersz['id']; ?>'>
						<tr>
							<td><?php echo $wiersz['id']; ?></td>
							<td><span class='hidden idkontrahenta'><?php echo $wiersz['idkontrahenta']; ?></span><?php echo $wiersz['nadawca']; ?></td>
							<td><?php echo $wiersz['temat']; ?></td>
							<td><?php echo $wiersz['opis']; ?></td>
							<td><?php echo $wiersz['datawplywu']; ?></td>
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
								<?php if($wiersz['powiadomiono'] == '') { ?>
									<button id='powiadom<?php echo $wiersz['id']; ?>' class='powiadom btn sukces'>Powiadom</button>
								<?php }
								else { ?>
									<button id='powiadom<?php echo $wiersz['id']; ?>' class='powiadom powiadomiono btn sukces'>Powiadom</button>
									<p>Wysłano powiadomienie:</p>
									<?php echo $wiersz['powiadomiono']; ?>
								<?php } ?>
							</td>
							<td>
								<?php if($wiersz['ktopobral'] == '') { ?>
									<button id='pobrano<?php echo $wiersz['id']; ?>' class='pobrano btn uwaga'>Pobrano</button>
								<?php }
								else { ?>
									<?php echo $wiersz['datapobrania']; ?></br><?php echo $wiersz['ktopobral']; ?>
								<?php } ?>
							</td>
							<td><span class='hidden iddzial'><?php echo $wiersz['iddzial']; ?></span><?php echo $wiersz['dzial']; ?></td>
							<td>
								<span class='edit' editing='dziennikprzyjec<?php echo $wiersz['id']; ?>'>Edytuj</span>
							</td>
						</tr>
					</tbody>
				<?php }
			} ?>
		</table>
	<?php }
?>