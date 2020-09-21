<?php
	include 'php/dane.php';
	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	$nazwa = $_POST['nazwaAplikacji'];
	$sql = "INSERT INTO aplikacje (id, nazwa) VALUES ('null', '$nazwa')";
	if($nazwa != '') {
		if($polaczenie->query($sql)) {
			mkdir('../aplikacje/'.$nazwa, 0777);
			$baza = '`'.$dbname.'`.`'.$nazwa.'access`';
			echo $baza;
			$sql = "CREATE TABLE IF NOT EXISTS $baza (
						`id` INT(11) NOT NULL,
						`uzytkownik` INT(6) NULL DEFAULT 0,
						`funkcja` INT(1) NULL DEFAULT 0,
						PRIMARY KEY (`id`),
						INDEX `uzytkownik_idx` (`uzytkownik` ASC),
						INDEX `funkcja_idx` (`funkcja` ASC),
						CONSTRAINT `uzytkownik`
							FOREIGN KEY (`uzytkownik`)
							REFERENCES `system`.`uzytkownicy` (`id`)
							ON DELETE NO ACTION
							ON UPDATE NO ACTION,
						CONSTRAINT `funkcja`
							FOREIGN KEY (`funkcja`)
							REFERENCES `system`.`funkcjeadm` (`id`)
							ON DELETE NO ACTION
							ON UPDATE NO ACTION)
						ENGINE = InnoDB
						DEFAULT CHARACTER SET = utf8 COLLATE utf8_polish_ci;";
			echo $sql;
			$polaczenie->query($sql);
		}
	}
	//header('Location: '.$_SERVER['HTTP_REFERER']);
	$polaczenie->close();
?>