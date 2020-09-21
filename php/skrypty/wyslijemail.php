<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require $_SERVER['DOCUMENT_ROOT'].'libs/PHPMailer/Exception.php';
	require $_SERVER['DOCUMENT_ROOT'].'libs/PHPMailer/PHPMailer.php';
	require $_SERVER['DOCUMENT_ROOT'].'libs/PHPMailer/SMTP.php';
	require $_SERVER['DOCUMENT_ROOT'].'libs/PHPMailer/SMTPC.php';
	
	$tytul = 'Wiadomość testowa';
	$wiadomosc = htmlspecialchars($_POST['wiadomosc']);
	$wiadomoscbezhtml = htmlspecialchars($_POST['wiadomosc']);
	
	$mail = new PHPMailer(true);
	try {
		// Serwer home.pl
		$mail->CharSet = 'UTF-8';
		$mail->SMTPDebug = 2;
		$mail->isSMTP();
		$mail->Host = $hostem;
		$mail->SMTPAuth = true;
		$mail->Username = $userem;
		$mail->Password = $passem;
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		
		// Odbiorcy
		$mail->setFrom('test@test.pl', 'System testowy');
		$mail->addAddress('test@test.pl', 'System testowy');
		
		// Załączniki
		
		// Zawartość
		$mail->isHTML(true);
		$mail->Subject = $tytul;
		$mail->Body = $wiadomosc;
		$mail->AltBody = $wiadomoscbezhtml;
		
		// Wysłanie
		header('Location: '.$_SERVER['HTTP_REFERER']);
		$mail->send();
	}
	catch(Exception $e) {
		echo 'Błąd przy wysyłaniu '.$mail->ErrorInfo;
	}
?>