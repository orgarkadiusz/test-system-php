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
		$id = htmlspecialchars($_POST['id']);
		$pobierajacy = htmlspecialchars($_POST['pobierajacy']);
		
		$datapobrania = date('Y-m-d');
		$sql = "UPDATE esekretariat_przychodzace SET czypobrano = '1', ktopobral = '$pobierajacy', datapobrania = '$datapobrania' WHERE id = '$id';";
		if($polaczenie->query($sql)) {
			echo $datapobrania.'</br>'.$pobierajacy;
		}
		$polaczenie->close();
	}
?>