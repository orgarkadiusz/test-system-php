<?php
	session_start();
	include 'php/dane/dane.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	$datawprowadzenia = date('Y-m-d H:i:s');
	$uzytkownik = $_SESSION['userID'];
	if(isset($_POST['temat'])) {
		$temat = htmlspecialchars($_POST['temat']);
	}
	if(isset($_POST['opis'])) {
		$opis = htmlspecialchars($_POST['opis']);
	}
	if(isset($_POST['termin'])) {
		$termin = htmlspecialchars($_POST['termin']);
	}
	if(isset($_POST['opisy'])) {
		$opisy = $_POST['opisy'];
	}
	
	$sql = "INSERT INTO todolists (id, uzytkownik, datawprowadzenia, termin, temat, opis, status)
			VALUES (NULL, '$uzytkownik', '$datawprowadzenia', '$termin', '$temat', '$opis', '0')";
	
	if($uzytkownik != '' AND $temat != '' AND $datawprowadzenia != '') {
		if($polaczenie->query($sql)) {
			$idZadanie = $polaczenie->insert_id;
			if(isset($opisy)) {
				dodajSzczegoly($idZadanie, $opisy);
			}
			$sql = "SELECT datawprowadzenia, termin, temat, opis, status FROM todolists WHERE id = '$idZadanie'";
			$wynik = @$polaczenie->query($sql);
			$wierszwynikowy = $wynik->fetch_assoc();
			if($wierszwynikowy['status'] == 0) {
				$status = 'Do zrobienia';
			}
			else if($wierszwynikowy['status'] > 0 AND $wierszwynikowy['status'] < 100) {
				$status = 'W realizacji';
			}
			else {
				$status = 'Wykonane';
			} ?>
			<tbody id='todo<?php echo $idZadanie; ?>'>
					<tr class='RCM' opcjeRCM="Pokaż,Usuń">
						<td><?php echo $wierszwynikowy['datawprowadzenia']; ?></td>
						<td><?php echo $wierszwynikowy['termin']; ?></td>
						<td><?php echo $wierszwynikowy['temat']; ?></td>
						<td><?php echo $wierszwynikowy['opis']; ?></td>
						<td><?php echo $status; ?></td>
					</tr>
				</tbody>
			<?php $polaczenie->close();
		}
	}
	
	function dodajSzczegoly($idZadanie, $opisy) {
		global $polaczenie;
		global $datawprowadzenia;
		for($i = 0; $i < count($opisy); $i++) {
			$opis = htmlspecialchars($opisy[$i]);
			$sql = "INSERT INTO todolists_szczegoly (id, zadanie, opis, wykonanie, datadodania, dataedycji, glowne)
					VALUES (NULL, '$idZadanie', '$opis', '0', '$datawprowadzenia', '$datawprowadzenia', '1')";
			$polaczenie->query($sql);
		}
	}
?>