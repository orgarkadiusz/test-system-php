<?php
	session_start();
	include 'php/dane/dane.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	$datawprowadzenia = date('Y-m-d H:i:s');
	
	$idszczegolu = htmlspecialchars($_POST['id']);
	$indeks = htmlspecialchars($_POST['indeks']);
	$wartosc = htmlspecialchars($_POST['wartosc']);
	
	$sql = "UPDATE todolists_szczegoly SET $indeks = '$wartosc', dataedycji = '$datawprowadzenia' WHERE id = $idszczegolu";
	$polaczenie->query($sql);
	
	$sql = "SELECT zadanie FROM todolists_szczegoly WHERE id = $idszczegolu";
	$wynik = @$polaczenie->query($sql);
	$wynik = $wynik->fetch_row();
	
	$zadanie = $wynik[0];
	$sql = "SELECT wykonanie FROM todolists_szczegoly WHERE zadanie = $zadanie";
	$licznik = 0;
	$suma = 0;
	$wynik2 = @$polaczenie->query($sql);
	while($wiersz = $wynik2->fetch_assoc()) {
		$licznik++;
		$suma += $wiersz['wykonanie'];
	}
	$procent = (int)($suma / $licznik);
	if($procent == 0) $wartoscZadania = 'Do zrobienia'; 
	else if($procent > 0 AND $procent < 100) $wartoscZadania = "W realizacji</br>".$procent.' %';
	else $wartoscZadania = 'Wykonane';
	
	$sql = "UPDATE todolists SET status = $procent WHERE id = $zadanie";
	$polaczenie->query($sql);
	
	if($indeks == 'wykonanie') {
		if($wartosc == 0) echo $datawprowadzenia.',Do zrobienia,'.$wartosc.','.$wartoscZadania; 
		else if($wartosc > 0 AND $wartosc < 100) echo $datawprowadzenia.",W realizacji</br>".$wartosc.' %,'.$wartosc.','.$wartoscZadania;
		else echo $datawprowadzenia.',Wykonane,'.$wartosc.','.$wartoscZadania;
	}
	else {
		echo $datawprowadzenia.','.$wartosc.','.$wartosc;
	}
	
	$polaczenie->close();
?>