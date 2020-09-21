<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(!isset($_SESSION['zalogowany'])) { ?>
		<div id='mainlogo'>
			<img src='img/logo.svg' /></br>
			<b>System testowy</b>
		</div>
		<div id='Zarejestruj'>
			Nie masz jeszcze konta?&nbsp;<button id='ZarejestrujSie' class='btn glowny' value='rejestracjaUzytkownika'>Zarejestruj się</button>
		</div>
	<?php }
	else if($_SESSION['zalogowany'] == 'Zalogowano') {
		$ileDostepow = count($_SESSION['dostep']['aplikacja']);
		$aplikacja = [];
		for($i = 0; $i < $ileDostepow; $i++) {
			$flaga = true;
			if($_SESSION['dostep']['grupa'][$i] != 'Brak') {
				if(count($aplikacja) > 0) {
					for($j = 0; $j < count($aplikacja); $j++) {
						if($_SESSION['dostep']['aplikacja'][$i] == $aplikacja[$j]) {
							$flaga = false;
						}
					}
					if($flaga) {
						$aplikacja[] = $_SESSION['dostep']['aplikacja'][$i];
					}
				}
				else {
					$aplikacja[] = $_SESSION['dostep']['aplikacja'][$i];
				}
			}
		}
		$ileAplikacji = count($aplikacja);
		for($i = 0; $i < $ileAplikacji; $i++) { ?>
			<button class='mainaplikacje' id='<?php echo $aplikacja[$i]; ?>'><?php echo $aplikacja[$i]; ?></button>
		<?php }
	}
?>