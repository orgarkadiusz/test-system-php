<?php
	include '/moduly/PHPPass/passwordLib.php';
	$test = 'NapisTestowy';
	echo password_hash($test, PASSWORD_BCRYPT);
	echo '</br>'.hash('sha256', $test);
	echo '</br>'.hash('sha256', $test);
?>