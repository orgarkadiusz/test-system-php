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
		$nadawca = htmlspecialchars($_POST['nadawca']);
		$nazwanadawcy = htmlspecialchars($_POST['nazwanadawcy']);
		$ulica = htmlspecialchars($_POST['ulica']);
		$numer = htmlspecialchars($_POST['numer']);
		$kodpocztowy = htmlspecialchars($_POST['kodpocztowy']);
		$miasto = htmlspecialchars($_POST['miasto']);
		if(!isset($nadawca) OR $nadawca == '') {
			$nadawca = dodajkontrahenta($nazwanadawcy, $ulica, $numer, $kodpocztowy, $miasto);
		}
		$temat = htmlspecialchars($_POST['temat']);
		$opis = htmlspecialchars($_POST['opis']);
		$data = htmlspecialchars($_POST['data']);
		$iddzial = htmlspecialchars($_POST['iddzial']);
		$dzial = htmlspecialchars($_POST['dzial']);
		$folder = $_SERVER['DOCUMENT_ROOT']."/files/eSekretariat/Przyjecia/";
		$nazwaPliku = '';
		$link = '';
		// plik konfiguracyjny php.ini zawiera stala max_file_uploads zawierajaca maksymalna ilosc plikow wysylanych
		// zmienna upload_max_filesize zawiera maksymalny rozmiar jednego pliku
		if(isset($_FILES['zalacznik']['name'])) {
			for($i = 0; $i < count($_FILES['zalacznik']['name']); $i++) {
				$nazwaPliku = $folder.$_FILES['zalacznik']['name'][$i];
				if($_FILES['zalacznik']['name'][$i] != '') {
					$link = $link.'files/eSekretariat/Przyjecia/'.$_FILES['zalacznik']['name'][$i].';;';
				}
				$znacznik = 1;
				$typPliku = strtolower(pathinfo($nazwaPliku, PATHINFO_EXTENSION));
				if(file_exists($nazwaPliku)) {
					$znacznik = 0;
				}
				/*if(!($typPliku != 'pdf' OR $typPliku != 'jpg' OR $typPliku != 'png')) {
					$znacznik = 0;
				}*/
				if($znacznik) {
					move_uploaded_file($_FILES['zalacznik']['tmp_name'][$i], $nazwaPliku);
				}
			}
		}
		if($nadawca != '' AND $temat != '' AND $data != '' AND $iddzial != '') {
			$datawpisu = date('Y-m-d');
			$wpisujacy = $_SESSION['userID'];
			$sql = "INSERT INTO esekretariat_przychodzace (id, nadawca, temat, opisdodatkowy, datawplywu, powiadomiono, zalacznik, datawystawienia, czypobrano, ktopobral, dzial, datapobrania, datawpisu, wpisujacy)
					VALUES (NULL, '$nadawca', '$temat', '$opis', '$data', '', '$link', NULL, '0', '', '$iddzial', NULL, '$datawpisu', '$wpisujacy')";
			if($polaczenie->query($sql)) {
				$idprzyjecia = $polaczenie->insert_id; ?>
				<tbody id='dziennikprzyjec<?php echo $idprzyjecia; ?>'>
					<tr>
						<td><?php echo $idprzyjecia; ?></td>
						<td><span class='hidden idkontrahenta'><?php echo $nadawca; ?></span><?php echo $nazwanadawcy.', '.$ulica.'  '.$numer.', '.$kodpocztowy.'  '.$miasto; ?></td>
						<td><?php echo $temat; ?></td>
						<td><?php echo $opis; ?></td>
						<td><?php echo $data; ?></td>
						<td>
							<?php if($link AND $link != '') { 
								$pliki = explode(';;', $link); 
								for($i = 0; $i < count($pliki); $i++) { 
									if(isset($pliki[$i]) AND $pliki[$i] != '') {
										$podzialy = explode('.', $pliki[$i]);
										$rozszerzenie = end($podzialy); ?>
										<a href='<?php echo $pliki[$i]; ?>' target='_blank'><img src='icon/<?php echo $rozszerzenie; ?>.svg' class='ikonka' /></a>
									<?php }
								}
							} ?>
						</td>
						<td><button id='powiadom<?php echo $idprzyjecia; ?>' class='powiadom btn sukces'>Powiadom</button></td>
						<td><button id='pobrano<?php echo $idprzyjecia; ?>' class='pobrano btn uwaga'>Pobrano</button></td>
						<td><span class='hidden iddzial'><?php echo $iddzial; ?></span><?php echo $dzial; ?></td>
						<td>
							<span class='edit' editing='dziennikprzyjec<?php echo $idprzyjecia; ?>'>Edytuj</span>
						</td>
					</tr>
				</tbody>
			<?php }
		}
	}
	
	function dodajkontrahenta($nazwanadawcy, $ulica, $numer, $kodpocztowy, $miasto) {
		include 'php/dane/dane.php';
		$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		if($polaczenie->connect_errno != 0) {
			echo "Error: ".$polaczenie->connect_errno;
		}
		else {
			$sql = "INSERT INTO adresykontrahentow (id, nazwa, ulica, numer, kod, miasto) VALUES (NULL, '$nazwanadawcy', '$ulica', '$numer', '$kodpocztowy', '$miasto')";
			if($polaczenie->query($sql)) {
				return $polaczenie->insert_id;
			}
		}
	}
?>