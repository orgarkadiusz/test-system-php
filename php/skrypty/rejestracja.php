<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	include 'php/dane/dane.php';
	include 'php/dane/passwordLib.php';

	require 'moduly/PHPMailer/Exception.php';
	require 'moduly/PHPMailer/PHPMailer.php';
	require 'moduly/PHPMailer/SMTP.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$conn = odbc_connect($odbchost, $odbcuser, $odbcpass);
	if(!$conn) {
		exit("Connection Failed: ".$conn);
	}
	if($polaczenie->connect_errno != 0) {
		echo "Error: ".$polaczenie->connect_errno;
	}
	else {
		$imie = htmlspecialchars($_POST['imie']);
		$nazwisko = htmlspecialchars($_POST['nazwisko']);
		$login = htmlspecialchars(base64_decode($_POST['login']));
		$email = htmlspecialchars($_POST['email']);
		$dzialpracownika = '';
		$opisdzialu = '';
		$sql = "SELECT id FROM imiona WHERE imie = '$imie'";
		if($rezultat = @$polaczenie->query($sql)) {
			if($rezultat->num_rows == 1) {
				$wiersz = $rezultat->fetch_assoc();
				$imieid = $wiersz['id'];
			}
			else if($rezultat->num_rows == 0) {
				$sql = "INSERT INTO imiona (id, imie) VALUES ('NULL', '$imie')";
				if($polaczenie->query($sql)) {
					$imieid = $polaczenie->insert_id;
				}
			}
		}
		$sql = "SELECT id FROM nazwiska WHERE nazwisko = '$nazwisko'";
		if($rezultat = @$polaczenie->query($sql)) {
			if($rezultat->num_rows == 1) {
				$wiersz = $rezultat->fetch_assoc();
				$nazwiskoid = $wiersz['id'];
			}
			else if($rezultat->num_rows == 0) {
				$sql = "INSERT INTO nazwiska (id, nazwisko) VALUES ('NULL', '$nazwisko')";
				if($polaczenie->query($sql)) {
					$nazwiskoid = $polaczenie->insert_id;
				}
			}
		}
		
		$flaga = '';
		$sql = "SELECT login, email FROM uzytkownicy WHERE login = '$login' OR email = '$email'";
		if($rezultat = @$polaczenie->query($sql)) {
			if($rezultat->num_rows > 0) {
				$flaga = 'error;Istnieje użytkownik o takim loginie lub email w bazie';
			}
		}
		if($flaga == '') {
			$sql = "SELECT login, email FROM rejestracje WHERE login = '$login' OR email = '$email'";
			if($rezultat = @$polaczenie->query($sql)) {
				if($rezultat->num_rows > 0) {
					$flaga = 'error;Zarejestrowano już taki login lub email';
				}
			}
			if($flaga == '') {
				//Sprawdzenie czy rejestrujący się jest pracownikiem
				$imieerp = mb_convert_case($imie, MB_CASE_UPPER, "UTF-8");
				$nazwiskoerp = mb_convert_case($nazwisko, MB_CASE_UPPER, "UTF-8");
				$pobierzerp = "SELECT UD_SKL.SYMBOL AS 'Dzial', UD_SKL.OPIS AS 'Opisdzialu'
								FROM P JOIN OSOBA USING(P.OSOBA, OSOBA.REFERENCE) JOIN UD_SKL USING(P.WYDZIAL, UD_SKL.REFERENCE) JOIN CP USING(P.CP, CP.REFERENCE)
								WHERE P.ZA = 'T' AND CP.R = 'UMY' AND OSOBA.PIERWSZE = '$imieerp' AND OSOBA.NAZWISKO = '$nazwiskoerp'";
				$wynik = odbc_exec($conn, $pobierzerp);
				if(odbc_fetch_row($wynik)) {
					$dzialpracownika = odbc_result($wynik, 1);
					$opisdzialu = odbc_result($wynik, 2);
				}
				$emailwzor = strtolower(strtr($imie, $pltoen)).'.'.strtolower(strtr($nazwisko, $pltoen)).'@test.pl';
				if(isset($dzialpracownika) AND $email == $emailwzor) {
					$pracownik = 1;
					$sql = "SELECT id FROM dzialy WHERE skrot = '$dzialpracownika'";
					if($rezultat = @$polaczenie->query($sql)) {
						if($rezultat->num_rows == 0) {
							$sql = "INSERT INTO dzialy (id, nazwa, skrot) VALUES ('NULL', '$opisdzialu', '$dzialpracownika')";
							if($polaczenie->query($sql)) {
								$dzial = $polaczenie->insert_id;
							}
						}
						else {
							$wiersz = $rezultat->fetch_assoc();
							$dzial = $wiersz['id'];
						}
					}
				}
				else {
					$pracownik = 0;
					$dzial = '2';
				}
				$datarejestracji = date('Y-m-d H:i:s');
				$kod = htmlspecialchars($login.substr($imie, 0, 3).substr($nazwisko, 0, 3));
				$kod = base64_encode($kod);
				$sql = "INSERT INTO rejestracje (id, login, email, imie, nazwisko, kod, potwierdzone, datarejestracji, datapotwierdzenia, pracownik, dzial, zaakceptowany)
						VALUES ('NULL', '$login', '$email', '$imieid', '$nazwiskoid', '$kod', '0', '$datarejestracji', 'NULL', '$pracownik', '$dzial', '$pracownik')";
				if($polaczenie->query($sql)) {
					if($pracownik) {
						$flaga = 'zarejestrowano;Wysłano wiadomość email z kodem rejestracji';
						echo $flaga;
						wyslijEmail($imie, $nazwisko, $login, $email, $kod);
					}
					else {
						$flaga = 'zarejestrowano;Rejestracja oczekuje na potwierdzenie';
						echo $flaga;
					}
				}
			}
			else {
				echo $flaga;
			}
		}
		else {
			echo $flaga;
		}
		$polaczenie->close();
	}
	
	function wyslijEmail($imie, $nazwisko, $login, $email, $kod) {
		include 'php/dane/dane.php';
		try {
			$tytul = 'Rejestracja w systemie - system testowy';
			$wiadomosc = 'Dzień dobry '.$login.',</br>Wysyłamy Ci kod weryfikacyjny w celu zakończenia rejestracji w naszej aplikacji.</br></br>'.$kod.'</br></br>Jeśli to nie jest wiadomość do Ciebie to znaczy, że ktoś użył Twojego adresu e-mail bez Twojej wiedzy. Prosze o zgłoszenie tego na adres: '.$userem.'.
			</br><hr></br>
			<font size=1>Otrzymana przez Państwa wiadomość i wszystkie załączniki są poufne. Bezprawne wykorzystywanie, ujawnianie lub dystrybucja wiadomości jest zabroniona. Jeśli uważacie Państwo, że ta wiadomość została wysłana do Państwa przez pomyłkę, prosimy o poinformowanie nadawcy i usunięcie wiadomości wraz z załącznikami.</font></br></br>
			<font size=1>This message and all attachments are confidential. Any unauthorized review, use, disclosure, or distribution is prohibited. If you believe this message has been sent to you by mistake, please notify the sender by replying to this transmission, and delete the message and its attachments without disclosing them.</font>';
			//$wiadomoscbezhtml = '';
			$mail = new PHPMailer(true);
			
			// Serwer home.pl
			$mail->CharSet = 'UTF-8';
			$mail->SMTPDebug = 0;
			$mail->isSMTP();
			$mail->Host = $hostem;
			$mail->SMTPAuth = true;
			$mail->Username = $userem;
			$mail->Password = $passem;
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);
			
			// Odbiorcy
			$mail->setFrom('', 'system - testowy');
			$mail->addAddress($email, $imie.' '.$nazwisko);
			
			// Załączniki
			
			// Zawartość
			$mail->isHTML(true);
			$mail->Subject = $tytul;
			$mail->Body = $wiadomosc;
			//$mail->AltBody = $wiadomoscbezhtml;
			
			// Wysłanie
			if($mail->send()) {}
		}
		catch(Exception $e) {
			echo 'Błąd przy wysyłaniu '.$mail->ErrorInfo;
		}
	}
?>