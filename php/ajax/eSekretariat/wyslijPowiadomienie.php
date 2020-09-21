<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	include 'php/dane/dane.php';
	require 'moduly/PHPMailer/Exception.php';
	require 'moduly/PHPMailer/PHPMailer.php';
	require 'moduly/PHPMailer/SMTP.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	if($polaczenie->connect_errno != 0) {
		echo "Error: ".$polaczenie->connect_errno;
	}
	else {
		set_time_limit(0);
		$id = htmlspecialchars($_POST['id']);
		$adresat = htmlspecialchars($_POST['adresat']);
		$data = htmlspecialchars($_POST['data']);
		$nadawca = htmlspecialchars($_POST['nadawca']);
		$email = htmlspecialchars($_POST['email']);
		$temat = htmlspecialchars($_POST['temat']);
		$zalaczniki = htmlspecialchars($_POST['zalaczniki']);
		$folder = $_SERVER['DOCUMENT_ROOT'].'/';
		
		$wyslano = powiadom($adresat, $email, $data, $nadawca, $temat, $folder, $zalaczniki);
		$wyslano = explode(';;', $wyslano);
		if($wyslano[0] == 'powodzenie' AND $wyslano[1] == 'wysłano') {
			echo $wyslano[0].';;';
			$sql = "SELECT powiadomiono FROM esekretariat_przychodzace WHERE id = '$id';";
			if($rezultat = $polaczenie->query($sql)) {
				$wiersz = $rezultat->fetch_assoc();
				$datawystawienia = date('Y-m-d');
				if($wiersz['powiadomiono'] != '') {
					$wpis = $wiersz['powiadomiono'].'<p>'.$datawystawienia.': '.$email.'</p>';
					$sql = "UPDATE esekretariat_przychodzace SET powiadomiono = '$wpis' WHERE id = '$id';";
					if($polaczenie->query($sql)) {
						echo "<button id='powiadom".$id."' class='powiadom powiadomiono btn sukces'>Powiadom</button><p>Wysłano powiadomienie:</p>".$wpis."";
					}
				}
				else {
					$sql = "UPDATE esekretariat_przychodzace SET datawystawienia = '$datawystawienia', powiadomiono = '<p>$datawystawienia: $email</p>' WHERE id = '$id';";
					if($polaczenie->query($sql)) {
						echo "<button id='powiadom".$id."' class='powiadom powiadomiono btn sukces'>Powiadom</button><p>Wysłano powiadomienie:</p><p>".$datawystawienia.": ".$email."</p>";
					}
				}
			}
		}
		else if($wyslano[0] == 'error') {
			echo $wyslano[0].';;'.$wyslano[1];
		}
		$polaczenie->close();
	}
	
	function powiadom($adresat, $email, $data, $nadawca, $temat, $folder, $zalaczniki) {
		include 'php/dane/dane.php';
		$data = explode('-', $data);
		try {
			$wiadomosc = '<p>Uprzejmie informujemy, że w dniu '.$data[2].'.'.$data[1].'.'.$data[0].' została dostarczona przesyłka od '.$nadawca.' o treści '.$temat.'.</p></br>
			<p>W załączeniu skan pisma.</p></br></br>
			<font size=1>Jeśli uważacie Państwo, że ta wiadomość została wysłana do Państwa przez pomyłkę, prosimy o poinformowanie nadawcy i usunięcie wiadomości wraz z załącznikami.</font>';
			$wiadomoscbezhtml = 'Test';
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
			$mail->setFrom('test@test.pl', 'System testowy');
			$mail->addAddress($email, $adresat);
			
			// Załączniki
			$zalaczniki = explode(';;', $zalaczniki);
			for($i = 0; $i < count($zalaczniki); $i++) {
				if($zalaczniki[$i] != '') {
					$sciezka = $folder.$zalaczniki[$i];
					$nazwa = str_replace('files/eSekretariat/Przyjecia/', '', $zalaczniki[$i]);
					$mail->addAttachment($sciezka, $nazwa);
				}
			}
			
			// Zawartość
			$mail->isHTML(true);
			$mail->Subject = $temat;
			$mail->Body = $wiadomosc;
			$mail->AltBody = $wiadomoscbezhtml;
			
			// Wysłanie
			if($mail->Send()) {
				return 'powodzenie;;wysłano';
			}
			else {
				return 'error;;'.$mail->ErrorInfo;
			}
		}
		catch(Exception $e) {
			return 'error;;'.$mail->ErrorInfo;
		}
	}
?>