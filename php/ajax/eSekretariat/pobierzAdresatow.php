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
		$sql = "SELECT id, nazwa, ulica, numer, kod, miasto FROM adresykontrahentow";
		if($rezultat = @$polaczenie->query($sql)) {
			while($wiersz = $rezultat->fetch_assoc()) { ?>
				<option value='<?php echo $wiersz['id'].';;'.$wiersz['nazwa'].';;'.$wiersz['ulica'].';;'.$wiersz['numer'].';;'.$wiersz['kod'].';;'.$wiersz['miasto']; ?>'><?php echo $wiersz['nazwa']; ?></option>
			<?php }
		}
	}
	$polaczenie->close();
?>