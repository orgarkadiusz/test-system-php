<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	include 'php/dane/dane.php';
	include 'php/dane/passwordLib.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	if($polaczenie->connect_errno != 0) {
		echo "Error: ".$polaczenie->connect_errno;
	}
	else {
		if(isset($_SESSION['zalogowany']) AND $_SESSION['zalogowany'] == 'Zalogowano') { ?>
			
		<?php }
		else {
			$flaga = 0;
			$login = '';
			$kod = '';
			$login = htmlspecialchars(base64_decode($_POST['login']));
			$kod = htmlspecialchars(base64_decode($_POST['kod']));
			$sql = "SELECT id FROM rejestracje WHERE login = '$login' AND kod = '$kod'";
			if($rezultat = @$polaczenie->query($sql)) {
				if($rezultat->num_rows == 0) {
					echo 'error;;Nieprawidłowe dane.';
				}
				else if($rezultat->num_rows == 1) {
					$flaga = 1;
					$wiersz = $rezultat->fetch_assoc();
					$rejid = $wiersz['id'];
					echo 'poprawne;;';
				}
			} 
			if($flaga) { ?>
				<div id='zmienhaslo'>
					<h2>Ustawianie nowego hasła</h2>
					</br>
					<input type='hidden' name='login' value='<?php echo $login; ?>' />
					<input type='hidden' name='kod' value='<?php echo $kod; ?>' />
					<div class='tooltip'><input class='haslo' type='password' name='nowehaslo' tooltip='left' tooltiptext='Hasło powinno składać się min. z:</br>- jednej małej litery</br>- jednej dużej litery</br>- jednej cyfry</br>- jednego znaku specjalnego np: !,@,#</br>- 6 znaków</br>Zabronione są polskie znaki' placeholder='Nowe hasło'  /></div>
					<div class='tooltip'><input class='haslo' type='password' name='nowepowthaslo' placeholder='Powtórz hasło'/></div>
					</br>
					<div class='tooltip'><button id='ZmienHaslo' class='btn uwaga' disabled>Zarejestruj się</button></div>
				</div>
			<?php }
		}
	}
	$polaczenie->close();
?>