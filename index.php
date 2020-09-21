<?php
	session_start();
	include 'php/dane/dane.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$zeStrony = true;
	if(isset($_GET['strona'])) {
		$strona = $_GET['strona'];
	}
	else {
		$strona = 'main';
	}
	$_SESSION['bgb'] = 'T';
	if(isset($_SESSION['zalogowany'])) {
		$zalogowany = $_SESSION['zalogowany'];
	}
	else {
		$zalogowany = 'Nie';
	}
?>
<!DOCTYPE html>
<html lang="pl_PL">
	<head>
		<meta charset="utf-8">
		<title>System testowy</title>
		<script type="text/javascript">
			// Dodanie zmiennych na początku ładowania strony
			var zalogowany = '<?php echo $zalogowany; ?>';
			var wysokoscOkna;
			var szerokoscOkna;
		</script>
		<?php if($_SESSION['bgb'] == 'T') { ?>
			<link rel="stylesheet" href="css/cssb.css">
		<?php }
		else { ?>
			<link rel="stylesheet" href="css/cssw.css">
		<?php } ?>
		<link rel="stylesheet" href="css/datepicker.css">
		<link rel="shortcut icon" href="img/favicon.svg" >
	</head>
	<body>
		<nav id='navBar'></nav>
		<div id='navBarRight'></div>
		<div id='body'>
			<div id='maincontent' class='zakladka act'></div>
			<div id='settingsContent'></div>
			<div id='stopka'></div>
		</div>
		<div id='editField'>
			<div class='cialoFormularza'></div>
			<hr>
			<div class='stopkaFormularza'>
				<button class='btn uwaga anuluj'>Anuluj</button>
				<button class='btn sukces zapisz' style='float: right'>Zapisz</button>
			</div>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/system.js"></script>
		<script src="js/datepicker.js"></script>
	</body>
</html>
