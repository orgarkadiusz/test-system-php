<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(!isset($_SESSION['zalogowany'])) { ?>
		<div id='rejestracjaUzytkownika'>
			<div class='naglowekRejestracji'>Panel rejestracji</div>
			<div class="polaRejestracji">
				<div class='poleRejestracji'>
					<label for='rejImie'>Imię</label>
					<div class='tooltip'><input id='rejImie' name='imie' placeholder='Imię' type='text' tooltip='left' tooltiptext='Imię powinno zaczynać się z wielkiej litery,</br>dozwolone są polskie znaki.'></div>
				</div>
				<div class='poleRejestracji'>
					<label for='rejNazwisko'>Nazwisko</label>
					<div class='tooltip'><input id='rejNazwisko' name='nazwisko' placeholder='Nazwisko' type='text' tooltip='left' tooltiptext='Nazwisko powinno zaczynać się z wielkiej litery,</br>dozwolone są polskie znaki.'></div>
				</div>
				<div class='poleRejestracji'>
					<label for='rejLogin'>Login</label>
					<div class='tooltip'><input id='rejLogin' name='login' placeholder='Login' type='text' tooltip='left' tooltiptext='W loginie mogą znajdować się tylko litery i cyfry,</br>bez polskich znaków.'></div>
				</div>
				<div class='poleRejestracji'>
					<label for='rejEmail'>e-Mail</label>
					<div class='tooltip'><input id='rejEmail' name='email' placeholder='e-Mail' type='text' tooltip='left' tooltiptext='Email powinien być w formacie:</br>name@domena.xx</br>gdzie:</br>name - nazwa (dozwolone znaki specjalne),</br>domena - nazwa domeny, w której jest email,</br>xx - końcówka oznaczająca kraj'></div>
				</div>
			</div>
			<div class='konczenieRejestracji'>
				<div class='tekstWRejestracji'>
					<b>Informacja odnośnie przetwarzania danych osobowych:</b></br>
					Wyrażam zgodę na przetwarzanie moich danych osobowych zgodnie z ustawą o ochronie danych osobowych w celu rejestracji i możliwości korzystania z zasobów strony internetowej.</br>
					Podanie danych osobowych jest dobrowolne. Poinformowano mnie, że przysługuje mi prawo dostępu do moich danych, możliwości ich poprawiania oraz żądania zaprzestania ich przetwarzania.
				</div>
				<div class='checkBoxRejestracji'><input id='rejRodo' name='rodo' type='checkbox'><label for='rejRodo' class='CheckBox'><span>&#10003;</span>Rozumiem i akceptuję!</label></div>
				<div class='RejestracjaDiv'><button type='button' id='Rejestracja' class='btn glowny' disabled>Zarejestruj się</button></div>
				<span class='mamkod'>Mam kod</span>
			</div>
		</div>
	<?php }
?>