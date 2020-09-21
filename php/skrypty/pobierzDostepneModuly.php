<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_SESSION['zalogowany']) AND $_SESSION['zalogowany'] == 'Zalogowano') {
		$aplikacja = $_POST['aplikacja'];
		
		$ileDostepow = count($_SESSION['dostep']['aplikacja']);
		for($i = 0; $i < $ileDostepow; $i++) {
			if($aplikacja == $_SESSION['dostep']['aplikacja'][$i]) {
				echo $_SESSION['dostep']['modul'][$i].','.$_SESSION['dostep']['grupa'][$i].';';
			}
		}
	}
?>