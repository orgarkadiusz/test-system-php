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
		$set = '';
		$idedycji = htmlspecialchars($_POST['idedycji']);
		$staryadresat = htmlspecialchars($_POST['staryadresat']);
		$adresat = htmlspecialchars($_POST['adresat']);
		$nazwaadresata = htmlspecialchars($_POST['nazwaadresata']);
		$ulica = htmlspecialchars($_POST['ulica']);
		$numer = htmlspecialchars($_POST['numer']);
		$kodpocztowy = htmlspecialchars($_POST['kodpocztowy']);
		$miasto = htmlspecialchars($_POST['miasto']);
		if($staryadresat != $adresat AND (isset($adresat) AND $adresat != '')) {
			if($set == '') {
				$set = $set."adresat = '".$adresat."'";
			}
			else {
				$set = $set.", adresat = '".$adresat."'";
			}
		}
		else if($staryadresat != $adresat AND (!isset($adresat) OR $adresat == '')) {
			$adresat = dodajkontrahenta($nazwaadresata, $ulica, $numer, $kodpocztowy, $miasto);
			if($set == '') {
				$set = $set."adresat = '".$adresat."'";
			}
			else {
				$set = $set.", adresat = '".$adresat."'";
			}
		}
		else if($staryadresat == $adresat) {
			if($set == '') {
				$set = $set."adresat = '".$adresat."'";
			}
			else {
				$set = $set.", adresat = '".$adresat."'";
			}
		}
		$temat = htmlspecialchars($_POST['temat']);
		if($set == '') {
			$set = $set."temat = '".$temat."'";
		}
		else {
			$set = $set.", temat = '".$temat."'";
		}
		$data = htmlspecialchars($_POST['data']);
		if($set == '') {
			$set = $set."datawyslania = '".$data."'";
		}
		else {
			$set = $set.", datawyslania = '".$data."'";
		}
		$typnadania = htmlspecialchars($_POST['typnadania']);
		if($set == '') {
			$set = $set."typnadania = '".$typnadania."'";
		}
		else {
			$set = $set.", typnadania = '".$typnadania."'";
		}
		$typ = htmlspecialchars($_POST['typ']);
		
		$link = htmlspecialchars($_POST['starezalaczniki']);
		$usuniete = htmlspecialchars($_POST['skasowanezalaczniki']);
		$skasowane = explode(',', $usuniete);
		for($i = 0; $i < count($skasowane); $i++) {
			if($skasowane[$i] != '') {
				$usuniety = 'files/eSekretariat/Wychodzace/'.$skasowane[$i];
				$link = str_replace($usuniety, '', $link);
			}
		}	
		$folder = $_SERVER['DOCUMENT_ROOT']."/files/eSekretariat/Wychodzace/";
		$nazwaPliku = '';
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
		if($set == '') {
			$set = $set."zalacznik = '".$link."'";
		}
		else {
			$set = $set.", zalacznik = '".$link."'";
		}
		if($adresat != '' AND $temat != '' AND $data != '' AND $typnadania != '') {
			$datawpisu = date('Y-m-d');
			$wpisujacy = $_SESSION['userID'];
			$sql = "UPDATE esekretariat_wychodzace SET ".$set." WHERE id = '".$idedycji."';";
			if($polaczenie->query($sql)) {
				echo "<span class='hidden idkontrahenta'>".$adresat."</span>".$nazwaadresata.', '.$ulica.'  '.$numer.', '.$kodpocztowy.'  '.$miasto.";;;";
				echo $temat.";;;";
				echo $data.";;;";
				echo "<span class='hidden idtypnadania'>".$typnadania."</span>".$typ.";;;";
				if($link AND $link != '') { 
					$pliki = explode(';;', $link); 
					for($i = 0; $i < count($pliki); $i++) { 
						if(isset($pliki[$i]) AND $pliki[$i] != '') {
							$podzialy = explode('.', $pliki[$i]);
							$rozszerzenie = end($podzialy);
							echo "<a href='".$pliki[$i]."' target='_blank'><img src='icon/".$rozszerzenie.".svg' class='ikonka' /></a>";
						}
					}
				}
			}
		}
		else {
			echo "<span class='hidden idkontrahenta'>".$adresat."</span>".$nazwaadresata.', '.$ulica.'  '.$numer.', '.$kodpocztowy.'  '.$miasto.";;;";
			echo $temat.";;;";
			echo $data.";;;";
			echo "<span class='hidden idtypnadania'>".$typnadania."</span>".$typ.";;;";
			if($link AND $link != '') { 
				$pliki = explode(';;', $link); 
				for($i = 0; $i < count($pliki); $i++) { 
					if(isset($pliki[$i]) AND $pliki[$i] != '') {
						$podzialy = explode('.', $pliki[$i]);
						$rozszerzenie = end($podzialy);
						echo "<a href='".$pliki[$i]."' target='_blank'><img src='icon/".$rozszerzenie.".svg' class='ikonka' /></a>";
					}
				}
			}
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
			$sql = "SELECT id FROM adresykontrahentow WHERE nazwa = '".$nazwaadresata."' AND ulica = '".$ulica."' AND numer = '".$numer."' AND kod = '".$kodpocztowy."' AND miasto = '".$miasto."';";
			if($rezultat = $polaczenie->query($sql) AND $rezultat->num_rows == 1) {
				$wynik = $rezultat->fetch_assoc();
				return $wynik['id'];
			}
			else {
				$sql = "INSERT INTO adresykontrahentow (id, nazwa, ulica, numer, kod, miasto) VALUES (NULL, '$nazwaadresata', '$ulica', '$numer', '$kodpocztowy', '$miasto')";
				if($polaczenie->query($sql)) {
					return $polaczenie->insert_id;
				}
			}
		}
	}
?>