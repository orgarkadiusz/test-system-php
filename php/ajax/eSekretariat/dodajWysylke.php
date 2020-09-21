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
		$adresat = htmlspecialchars($_POST['adresat']);
		$nazwaadresata = htmlspecialchars($_POST['nazwaadresata']);
		$ulica = htmlspecialchars($_POST['ulica']);
		$numer = htmlspecialchars($_POST['numer']);
		$kodpocztowy = htmlspecialchars($_POST['kodpocztowy']);
		$miasto = htmlspecialchars($_POST['miasto']);
		if(!isset($adresat) OR $adresat == '') {
			$adresat = dodajkontrahenta($nazwaadresata, $ulica, $numer, $kodpocztowy, $miasto);
		}
		$temat = htmlspecialchars($_POST['temat']);
		$data = htmlspecialchars($_POST['data']);
		$typnadania = htmlspecialchars($_POST['typnadania']);
		$typ = htmlspecialchars($_POST['typ']);
		$folder = $_SERVER['DOCUMENT_ROOT']."/files/eSekretariat/Wychodzace/";
		$nazwaPliku = '';
		$link = '';
		// plik konfiguracyjny php.ini zawiera stala max_file_uploads zawierajaca maksymalna ilosc plikow wysylanych
		// zmienna upload_max_filesize zawiera maksymalny rozmiar jednego pliku
		if(isset($_FILES['zalacznik']['name'])) {
			for($i = 0; $i < count($_FILES['zalacznik']['name']); $i++) {
				$nazwaPliku = $folder.$_FILES['zalacznik']['name'][$i];
				if($_FILES['zalacznik']['name'][$i] != '') {
					$link = $link.'files/eSekretariat/Wychodzace/'.$_FILES['zalacznik']['name'][$i].';;';
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
		if($adresat != '' AND $temat != '' AND $data != '' AND $typnadania != '') {
			$datawpisu = date('Y-m-d');
			$wpisujacy = $_SESSION['userID'];
			$sql = "INSERT INTO esekretariat_wychodzace (id, adresat, temat, datawyslania, typnadania, zalacznik, datawpisu, wpisujacy)
					VALUES (NULL, '$adresat', '$temat', '$data', '$typnadania', '$link', '$datawpisu', '$wpisujacy')";
			if($polaczenie->query($sql)) {
				$idwysylki = $polaczenie->insert_id; ?>
				<tbody id='dziennikwysylek<?php echo $idwysylki; ?>'>
					<tr>
						<td><?php echo $idwysylki; ?></td>
						<td><span class='hidden idkontrahenta'><?php echo $adresat; ?></span><?php echo $nazwaadresata.', '.$ulica.'  '.$numer.', '.$kodpocztowy.'  '.$miasto; ?></td>
						<td><?php echo $temat; ?></td>
						<td><?php echo $data; ?></td>
						<td><span class='hidden idtypnadania'><?php echo $typnadania; ?></span><?php echo $typ; ?></td>
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
						<td>
							<span class='edit' editing='dziennikwysylek<?php echo $idwysylki; ?>'>Edytuj</span>
						</td>
					</tr>
				</tbody>
			<?php }
		}
	}
	
	function dodajkontrahenta($nazwaadresata, $ulica, $numer, $kodpocztowy, $miasto) {
		include 'php/dane/dane.php';
		$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		if($polaczenie->connect_errno != 0) {
			echo "Error: ".$polaczenie->connect_errno;
		}
		else {
			$sql = "INSERT INTO adresykontrahentow (id, nazwa, ulica, numer, kod, miasto) VALUES (NULL, '$nazwaadresata', '$ulica', '$numer', '$kodpocztowy', '$miasto')";
			if($polaczenie->query($sql)) {
				return $polaczenie->insert_id;
			}
		}
	}
?>