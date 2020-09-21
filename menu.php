<?php 
	session_start();
	if(!isset($_SESSION['zalogowany'])) { ?>
		<div id='navLogo'>
			<img id='Logo' src='img/logo.svg' />
		</div>
		<div id='navRight'>
			<input id='Login' placeholder='Login' type='text' /> 
			<input id='Password' placeholder='Hasło' type='password' />
			<button type='submit' id='LogInApplication' class='btn sukces'>Zaloguj</button>
		</div>
	<?php }
	else if($_SESSION['zalogowany'] == 'Zalogowano') { ?>
		<div id='navLogo'>
			<img id='Logo' src='img/logo.svg' />
		</div>
		<div id='navLeft'></div>
		<div id='navRight'>
			<div id='User'>
				<?php if(isset($_SESSION['imie']) AND $_SESSION['imie'] != ' ' AND isset($_SESSION['nazwisko']) AND $_SESSION['nazwisko'] != ' ') { ?>
					Zalogowany jako <?php echo $_SESSION['imie'].' '.$_SESSION['nazwisko']; ?>
				<?php } ?>
			</div>
		</div>
	<?php }
	/*
		Przykład buttonów
		<div class='navDrop'>
			<button class='navBtn'>Lewo4</button>
			<div class='dropZaw'>
				<button class='navBtn' info='testowyNapis'>Lewo4Lewo1</button>
				<button class='navBtn' info='kolejny napis testowy'>Lewo4Lewo2</button>
				<button class='navBtn'>Lewo4Lewo3</button>
				<button class='navBtn'>Lewo4Lewo4</button>
			</div>
		</div>
		<div class='navDrop'>
			<button type='button' class='navBtn'>Lewo5</button>
			<div class='dropZaw'>
				<button type='button' class='navBtn'>Lewo5Lewo1</button>
				<div class='navDrop'>
					<button type='button' class='navBtn'>Lewo5Lewo2</button>
					<div class='dropZaw'>
						<button class='navBtn' value='test_test'>Lewo5Lewo2Lewo1</button>
						<button class='navBtn'>Lewo5Lewo2Lewo2</button>
						<button class='navBtn'>Lewo5Lewo2Lewo3</button>
						<button class='navBtn'>Lewo5Lewo2Lewo4</button>
					</div>
				</div>
				<button class='navBtn'>Lewo5Lewo3</button>
				<button class='navBtn'>Lewo5Lewo4</button>
			</div>
		</div>
		<div class='navDrop'>
			<button class='navBtn'>Lewo6</button>
		</div>
	*/
?>