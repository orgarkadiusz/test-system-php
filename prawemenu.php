<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_SESSION['zalogowany']) AND $_SESSION['zalogowany'] == 'Zalogowano') { 
		if(isset($_SESSION['prawemenu']['todolist']) AND $_SESSION['prawemenu']['todolist'] == 1) { ?>
			<div id='ToDoList'>
				<button  info='Moja lista'></button>
			</div>
			<hr>
		<?php }
		if(isset($_SESSION['prawemenu']['informacje']) AND $_SESSION['prawemenu']['informacje'] == 1) { ?>
			<div id='Informacje'>
				<button info='Informacje i pliki ogólnodostępne'></button>
			</div>
			<hr>
		<?php }
		if(isset($_SESSION['prawemenu']['zgloszeniaIT']) AND $_SESSION['prawemenu']['zgloszeniaIT'] == 1) { ?>
			<div id='Zgloszenia'>
				<button info='Zgłoszenia IT'></button>
			</div>
			<hr>
		<?php }
		if(isset($_SESSION['prawemenu']['czat']) AND $_SESSION['prawemenu']['czat'] == 1) { ?>
			<div id='Czat'>
				<button info='Czat'></button>
			</div>
			<hr>
		<?php }
		if(isset($_SESSION['prawemenu']['kalendarz']) AND $_SESSION['prawemenu']['kalendarz'] == 1) { ?>
			<div id='Kalendarz'>
				<button info='Mój kalendarz'></button>
			</div>
			<hr>
		<?php }
		if(isset($_SESSION['prawemenu']['aplikacje']) AND $_SESSION['prawemenu']['aplikacje'] == 1) { ?>
			<div id='Aplikacje'>
				<button info='Zarządzanie aplikacjami'></button>
			</div>
			<hr>
		<?php }
		if(isset($_SESSION['prawemenu']['uzytkownicy']) AND $_SESSION['prawemenu']['uzytkownicy'] == 1) { ?>
			<div id='Uzytkownicy'>
				<button info='Zarządzanie użytkownikami'></button>
			</div>
			<hr>
		<?php }
		if(isset($_SESSION['prawemenu']['dostepy']) AND $_SESSION['prawemenu']['dostepy'] == 1) { ?>
			<div id='Dostepy'>
				<button info='Zarządzanie dostępami'></button>
			</div>
			<hr>
		<?php }
		if(isset($_SESSION['prawemenu']['zasobyIT']) AND $_SESSION['prawemenu']['zasobyIT'] == 1) { ?>
			<div id='Wyposazenie'>
				<button info='Zarządzanie oraz ewidencja zasobów IT'></button>
			</div>
			<hr>
		<?php }
		if(isset($_SESSION['prawemenu']['ustawienia']) AND $_SESSION['prawemenu']['ustawienia'] == 1) { ?>
			<div id='Ustawienia'>
				<button info='Ustawienia'></button>
			</div>
			<hr>
		<?php }
		if(isset($_SESSION['prawemenu']['pomoc']) AND $_SESSION['prawemenu']['pomoc'] == 1) { ?>
			<div id='Pomoc'>
				<button info='Pomoc'></button>
			</div>
			<hr>
		<?php } ?>
		<div id='LogOutApplication'>
			<button info='Wylogowanie'></button>
		</div>
		<div id='Settings'></div>
	<?php }
?>