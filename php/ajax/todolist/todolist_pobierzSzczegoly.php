<?php
	session_start();
	include 'php/dane/dane.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$datawprowadzenia = date('Y-m-d H:i:s');
	
	$idZadania = $_POST['zadanie'];
	
	$sql = "SELECT id, opis, wykonanie, datadodania, dataedycji FROM todolists_szczegoly WHERE zadanie = '".$idZadania."' ORDER BY id";
	$listaszczegolowa = @$polaczenie->query($sql); ?>
	<tr class='szczegol'>
		<td></td>
		<td colspan='4'>
			<div>
				<table>
					<tbody>
						<tr>
							<td style='width: 15%;'>Data dodania</td>
							<td style='width: 15%;'>Data ostatniej edycji</td>
							<td info='Podwójne kliknięcie pozwala edytować' style='width: 60%;'>Treść podzadania</td>
							<td info='Podwójne kliknięcie pozwala edytować' style='width: 10%;'>Status</td>
						</tr>
					</tbody>
					<?php if($listaszczegolowa->num_rows > 0) {
						while($wiersz = $listaszczegolowa->fetch_assoc()) {
							if($wiersz['wykonanie'] == 0) $status = 'Do zrobienia'; 
							else if($wiersz['wykonanie'] > 0 AND $wiersz['wykonanie'] < 100) $status = 'W realizacji</br>'.$wiersz['wykonanie'].' %';
							else $status = 'Wykonane'; ?>
							<tbody>
								<tr>
									<td style='width: 15%;'><?php echo $wiersz['datadodania']; ?></td>
									<td style='width: 15%;'><?php echo $wiersz['dataedycji']; ?></td>
									<td style='width: 60%;' idedit='<?php echo $wiersz['id']; ?>' indeks='opis' class='dblEdit'><?php echo $wiersz['opis']; ?></td>
									<td style='width: 10%;' idedit='<?php echo $wiersz['id']; ?>' indeks='wykonanie' class='dblEdit' value='<?php echo $wiersz['wykonanie']; ?>'><?php echo $status; ?></td>
								</tr>
							</tbody>
						<?php }
					} ?>
					<tbody>
						<tr>
							<td colspan='4'>
								<div>
									<input type='text' name='podzadanietmp' />
									<button idzadanie='<?php echo $idZadania; ?>' class='btn info dodajSzczegol'>Dodaj podzadanie</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</td>
	</tr>
	<?php $polaczenie->close();
?>