<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	include 'php/dane/dane.php';
	include 'php/dane/passwordLib.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	if($polaczenie->connect_errno != 0) {
		echo "Error: ".$polaczenie->connect_errno;
	}
	else {
		$login = htmlspecialchars(base64_decode($_POST['login']));
		$haslo = htmlspecialchars(base64_decode($_POST['haslo']));
		$kod = htmlspecialchars($_POST['kod']);
		$haslo = password_hash($haslo, PASSWORD_BCRYPT);
		
		// Pobranie danych z rejestracji
		$sql = "SELECT id, email, imie, nazwisko, potwierdzone, pracownik, dzial, zaakceptowany
				FROM rejestracje
				WHERE login = '$login' AND kod = '$kod'";
		if($rezultat = @$polaczenie->query($sql)) {
			if($rezultat->num_rows == 1) {
				$wiersz = $rezultat->fetch_assoc();
				$idrej = $wiersz['id']; // Id wiersza z rejestracji do wpisania danych zwrotnych
				$email = $wiersz['email']; // Pobranie emaila z rejestracji
				$imie = $wiersz['imie']; // Pobranie id imienia z rejestracji
				$nazwisko = $wiersz['nazwisko']; // Pobranie id nazwiska z rejestracji
				$potwierdzone = $wiersz['potwierdzone']; // Sprawdzenie czy rejestracja była potwierdzona
				$pracownik = $wiersz['pracownik']; // sprawdzenie czy rejestrujący jest pracownikiem
				$dzial = $wiersz['dzial']; // pobranie id działu pracownika jeśli jest
				$zaakceptowany = $wiersz['zaakceptowany']; // pobranie znacznika zaakceptowanego
			}
		}
		$potwierdzonarejestracja = 0;
		$dodaneprawemenu = 0;
		$dodanedostepy = 0;
		if($potwierdzone == 0 AND $zaakceptowany == 1) {
			$sql = "INSERT INTO uzytkownicy (id, login, haslo, email, imie, nazwisko, dzial, stanowisko, adresIPlogin, systemoper, przegladarka, aktywny)
					VALUES ('NULL', '$login', '$haslo', '$email', '$imie', '$nazwisko', '$dzial', '2', 'NULL', 'NULL', 'NULL', 'T')";
			if($polaczenie->query($sql)) {
				$userid = $polaczenie->insert_id;
				$datarejestracji = date('Y-m-d H:i:s');
				$sql = "UPDATE rejestracje SET potwierdzone = '1', datapotwierdzenia = '$datarejestracji' WHERE id = '$idrej'";
				if($polaczenie->query($sql)) {
					$potwierdzonarejestracja = 1;
				}
				$sql = "INSERT INTO prawemenu (id, uzytkownik, todolist, informacje, zgloszeniaIT, czat, kalendarz, aplikacje, uzytkownicy, dostepy, zasobyIT, ustawienia, pomoc)
						VALUES ('$userid', '$userid', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1')";
				if($polaczenie->query($sql)) {
					$dodaneprawemenu = 1;
				}
				$sqldostepy = "INSERT INTO dostepy (id, uzytkownik, aplikacja, modul, grupa) VALUES ";
				$sql = "SELECT id, aplikacja FROM aplikacje_moduly";
				if($rezultat = @$polaczenie->query($sql)) {
					if($rezultat->num_rows > 0) {
						while($wiersz = $rezultat->fetch_assoc()) {
							$sqldostepy = $sqldostepy."('NULL', '$userid', '".$wiersz['aplikacja']."', '".$wiersz['id']."', '5'), ";
						}
					}
				}
				$sqldostepy = substr($sqldostepy, 0, -2);
				$sqldostepy = $sqldostepy.';';
				if($polaczenie->query($sqldostepy)) {
					$dodanedostepy = 1;
				}
				if($potwierdzonarejestracja AND $dodaneprawemenu AND $dodanedostepy) {
					echo "poprawne;;Wszystko poszło świetnie!</br>Możesz teraz zalogować się do serwisu.";
				}
				else {
					echo "error;;Wybacz, coś poszło nie tak.</br>Zgłoś się do nas na email: ".$userem;
				}
			}
		}
	}
	$polaczenie->close();
?>
	