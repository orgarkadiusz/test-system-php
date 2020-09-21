<?php
	session_start();
	include 'php/dane/dane.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	$datawprowadzenia = date('Y-m-d H:i:s');
	$opis = htmlspecialchars($_POST['wartosc']);
	$idZadanie = htmlspecialchars($_POST['idzadanie']);
	
	$sql = "INSERT INTO todolists_szczegoly (id, zadanie, opis, wykonanie, datadodania, dataedycji, glowne)
			VALUES (NULL, '$idZadanie', '$opis', '0', '$datawprowadzenia', '$datawprowadzenia', '0')";
	$polaczenie->query($sql);
	$idSzczegolu = $polaczenie->insert_id; ?>
	
	<tbody>
		<tr>
			<td style='width: 15%;'><?php echo $datawprowadzenia; ?></td>
			<td style='width: 15%;'><?php echo $datawprowadzenia; ?></td>
			<td style='width: 60%;' idedit='<?php echo $idSzczegolu; ?>' indeks='opis' class='dblEdit'><?php echo $opis; ?></td>
			<td style='width: 10%;' idedit='<?php echo $idSzczegolu; ?>' indeks='wykonanie' class='dblEdit' value='0'>Do zrobienia</td>
		</tr>
	</tbody>
	
	<?php $polaczenie->close();
?>