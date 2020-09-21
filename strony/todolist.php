<div id='noweZadanie' class='Formularz'>
	<div class='NaglowekFormularza'>
		<label>Dodaj zadanie:</label></br>
		<input type='text' name='temat' placeholder='Temat' info='Temat zadania do wykonania' style='width: 450px;' />
		<input type='text' name='termin' data-toggle='datepicker' placeholder='Termin' style='width: 90px;' /></br>
		<input type='text' name='opis' placeholder='Opis' style='width: 556px;' /></br>
	</div>
	<div class='CialoFormularza'>
		<div id='szczegoltemplate' class='hidden wiersz' style='width: 100%;'>
			<button class='btn uwaga usunWiersz akapit' style='width: 28px; height: 30px; padding: 0;'>-</button>
			<input type='text' name='opistmp' class='polaFormularza' placeholder='Podzadanie do wykonania' style='width: calc(100% - 88px);' />
		</div>
	</div>
	<div class='StopkaFormularza'>
		<button id='dodajSzczegol' class='btn info'>Dodaj podzadanie</button>
		<button id='zapiszZadanie' class='btn sukces' style='float: right'>Zapisz</button>
	</div>
</div>
<hr>
Lista zadań:
<table class='sTabela todolist'>
	<thead>
		<th info='Pełna data i godzina wprowadzenia zadania' style='width: 10%;'>Data wprowadzenia</th>
		<th info='Założony termin wykonania zadania' style='width: 10%;'>Termin</th>
		<th info='Temat zadania' style='width: 30%;'>Temat</th>
		<th info='Opis zadania' style='width: 40%;'>Opis</th>
		<th info='Status wykonania zadania' style='width: 10%;'>Status</th>
	</thead>
<?php
	session_start();
	include 'php/dane/dane.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$sql = "SELECT id, datawprowadzenia, termin, temat, opis, status FROM todolists WHERE uzytkownik = '".$_SESSION['userID']."' ORDER BY id DESC";
	$listaglowna = @$polaczenie->query($sql);
	if($listaglowna->num_rows > 0) {
		while($wiersz = $listaglowna->fetch_assoc()) { ?>
			<tbody id='todo<?php echo $wiersz['id']; ?>'>
				<tr class='RCM' opcjeRCM='Pokaż,Usuń'>
					<td><?php echo $wiersz['datawprowadzenia']; ?></td>
					<td><?php echo $wiersz['termin']; ?></td>
					<td><?php echo $wiersz['temat']; ?></td>
					<td><?php echo $wiersz['opis']; ?></td>
					<td><?php if($wiersz['status'] == 0) echo 'Do zrobienia'; else if($wiersz['status'] > 0 AND $wiersz['status'] < 100) echo 'W realizacji</br>'.$wiersz['status'].' %'; else echo 'Wykonane'; ?></td>
				</tr>
			</tbody>
		<?php }
	}
?>
</table>