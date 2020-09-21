<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	include 'php/dane/dane.php';
	include 'php/dane/passwordLib.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	if($polaczenie->connect_errno != 0) {
		//echo "Error: ".$polaczenie->connect_errno;
	}
	else {
		$login = htmlspecialchars(base64_decode($_POST['login']));
		$haslo = htmlspecialchars(base64_decode($_POST['haslo']));
		
		$daneoUzytkowniku = "X".$_SERVER['HTTP_USER_AGENT'];
		$system = array('Windows 2000' => 'NT 5.0', 'Windows XP' => 'NT 5.1', 'Windows Vista' => 'NT 6.0', 'Windows 7' => 'NT 6.1', 'Windows 8' => 'NT 6.2', 'Windows 8.1' => 'NT 6.3', 'Windows 10' => 'NT 10.0', 'Linux' => 'Linux');
		$przegladarka = array('Internet Explorer' => 'MSIE', 'Mozilla Firefox' => 'Firefox', 'Opera' => 'Opera', 'Chrome' => 'Chrome', 'Edge' => 'Edge');
		foreach ($system as $nazwa => $id) {
			if(strpos($daneoUzytkowniku, $id)) $system = $nazwa;
		}
		foreach ($przegladarka as $nazwa => $id) {
			if(strpos($daneoUzytkowniku, $id)) $przegladarka = $nazwa;
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		$UserID = '';
		
		$sql = "SELECT haslo FROM uzytkownicy WHERE login = BINARY '$login' AND aktywny = 'T'";
		
		if($rezultat = @$polaczenie->query($sql)) {
			if($rezultat->num_rows == 1) {
				$wiersz = $rezultat->fetch_assoc();
				if(password_verify($haslo, $wiersz['haslo'])) {
					$_SESSION['login'] = $login;
					$_SESSION['zalogowany'] = 'Zalogowano';
					echo base64_encode($_SESSION['zalogowany']);
					$sql = "SELECT 
								uzytkownicy.id AS userID,
								uzytkownicy.email AS email,
								imiona.imie AS imie,
								nazwiska.nazwisko AS nazwisko,
								dzialy.nazwa AS dzial,
								stanowiska.nazwa AS stanowisko,
								aplikacje.nazwa AS aplikacja,
								aplikacje_moduly.nazwa AS modul,
								grupy.nazwa AS grupa
							FROM dostepy
								JOIN aplikacje ON dostepy.aplikacja = aplikacje.id
								JOIN uzytkownicy ON dostepy.uzytkownik = uzytkownicy.id
								JOIN grupy ON dostepy.grupa = grupy.id
								JOIN imiona ON uzytkownicy.imie = imiona.id
								JOIN nazwiska ON uzytkownicy.nazwisko = nazwiska.id
								JOIN dzialy ON uzytkownicy.dzial = dzialy.id
								JOIN stanowiska ON uzytkownicy.stanowisko = stanowiska.id
								JOIN aplikacje_moduly ON dostepy.modul = aplikacje_moduly.id
							WHERE 
								uzytkownicy.aktywny = 'T' 
								AND uzytkownicy.login = '$login'";
					$rezultat = @$polaczenie->query($sql);
					if($rezultat->num_rows > 0) {
						while($wiersz = $rezultat->fetch_assoc()) {
							$_SESSION['userID'] = $wiersz['userID'];
							$UserID = $wiersz['userID'];
							$_SESSION['dostep']['aplikacja'][] = $wiersz['aplikacja'];
							$_SESSION['dostep']['modul'][] = $wiersz['modul'];
							$_SESSION['dostep']['grupa'][] = $wiersz['grupa'];
							$_SESSION['email'] = $wiersz['email'];
							$_SESSION['imie'] = $wiersz['imie'];
							$_SESSION['nazwisko'] = $wiersz['nazwisko'];
							$_SESSION['dzial'] = $wiersz['dzial'];
							$_SESSION['stanowisko'] = $wiersz['stanowisko'];
						}
					}
				}
				else {
					echo base64_encode('NieZalogowano');
				}
			}
			else {
				unset($_SESSION['zalogowany']);
			}
			$sql = "UPDATE uzytkownicy SET adresIPlogin = '$ip', systemoper = '$system', przegladarka = '$przegladarka' WHERE login = '$login'";
			$polaczenie->query($sql);
			
			$sql = "SELECT todolist, informacje, zgloszeniaIT, czat, kalendarz, aplikacje, uzytkownicy, dostepy, zasobyIT, ustawienia, pomoc
					FROM prawemenu
					WHERE uzytkownik = '$UserID'";
			if($rezultat = @$polaczenie->query($sql)) {
				if($rezultat->num_rows == 1) {
					$wiersz = $rezultat->fetch_assoc();
					$_SESSION['prawemenu']['todolist'] = $wiersz['todolist'];
					$_SESSION['prawemenu']['informacje'] = $wiersz['informacje'];
					$_SESSION['prawemenu']['zgloszeniaIT'] = $wiersz['zgloszeniaIT'];
					$_SESSION['prawemenu']['czat'] = $wiersz['czat'];
					$_SESSION['prawemenu']['kalendarz'] = $wiersz['kalendarz'];
					$_SESSION['prawemenu']['aplikacje'] = $wiersz['aplikacje'];
					$_SESSION['prawemenu']['uzytkownicy'] = $wiersz['uzytkownicy'];
					$_SESSION['prawemenu']['dostepy'] = $wiersz['dostepy'];
					$_SESSION['prawemenu']['zasobyIT'] = $wiersz['zasobyIT'];
					$_SESSION['prawemenu']['ustawienia'] = $wiersz['ustawienia'];
					$_SESSION['prawemenu']['pomoc'] = $wiersz['pomoc'];
				}
			}
		}
		$polaczenie->close();
	}
?>