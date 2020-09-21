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
					uzytkownicy.email AS email,
					imiona.imie AS imie,
					nazwiska.nazwisko AS nazwisko
				FROM
					uzytkownicy
					JOIN imiona ON uzytkownicy.imie = imiona.id
					JOIN nazwiska ON uzytkownicy.nazwisko = nazwiska.id
				WHERE
					uzytkownicy.id > 1";
		if($rezultat = @$polaczenie->query($sql)) {
			while($wiersz = $rezultat->fetch_assoc()) { ?>
				<option value='<?php echo $wiersz['imie'].' '.$wiersz['nazwisko'].';;'.$wiersz['email']; ?>'><?php echo $wiersz['email']; ?></option>
			<?php }
		}
	}
	$polaczenie->close();
?>