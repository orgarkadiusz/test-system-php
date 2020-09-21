<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_SESSION['zalogowany']) AND $_SESSION['zalogowany'] == 'Zalogowano') {
		include 'php/dane/dane.php';
		$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		$sql = "SELECT id, nazwa FROM aplikacje";
		$wynik = @$polaczenie->query($sql);
		if($wynik->num_rows > 0) { 
			while($wiersz = $wynik->fetch_assoc()) { ?>
				<p><?php echo $wiersz['id'].' '.$wiersz['nazwa']; ?></p>
			<?php } 
		} ?>
		<form action='php/skrypty/dodajAplikacje.php' method='POST'>
			<input name='nazwaAplikacji' />
			<button type='submit'>DODAJ</button>
		</form>
	<?php }
?>