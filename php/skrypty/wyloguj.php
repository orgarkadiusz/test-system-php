<?php
	session_start();
	unset($_SESSION['zalogowany']);
	session_destroy();
?>