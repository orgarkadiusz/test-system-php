<?php
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	$rok = '2019';//htmlspecialchars($_POST['rok']);
	$numer = sprintf('%02d/%03d', substr($rok, -2), '1');
	//$typ = htmlspecialchars($_POST['typ']);
	
	$tytulpdfp = 'Delegacja pracownika';
	$tytulpdf = iconv('UTF-8', 'Windows-1250', $tytulpdfp);
	
	include 'moduly/PHPPDF/tcpdf.php';
	$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8');
	$pdf->SetCreator('System testowy');
	$pdf->SetAuthor('Arkadiusz Orgaś');
	$pdf->SetTitle($tytulpdf);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetMargins(5, 8);
	$pdf->AddPage();
	
	//$pdf->SetFont('dejavusans', '', 10);
	//$pdf->MultiCell(140, 10, 'Zażółć gęślą jaźń', 1, 'J', false, 1, 8, 8);
	
	//$pdf->SetFont('arial', '', 10);
	//$pdf->MultiCell(140, 10, 'Zażółć gęślą jaźń', 1, 'J', false, 1, 149, 8);
	
	// Lewe paski {
		$pdf->Rect(5, 8, 2, 136, 'DF', array('all' => 0), array(200, 200, 200));		// 1
		$pdf->Rect(5, 149, 2, 52, 'DF', array('all' => 0), array(200, 200, 200));		// 6
		$pdf->Rect(7, 8, 0.8, 136, 'DF', array('all' => 0), array(150, 150, 150));		// 2
		$pdf->Rect(7, 149, 0.8, 52, 'DF', array('all' => 0), array(150, 150, 150));		// 7
		$pdf->Rect(7.8, 8, 0.4, 136, 'DF', array('all' => 0), array(255, 255, 255));	// 3
		$pdf->Rect(7.8, 149, 0.4, 52, 'DF', array('all' => 0), array(255, 255, 255));	// 8
		$pdf->Rect(8.2, 8, 0.8, 136, 'DF', array('all' => 0), array(150, 150, 150));	// 4
		$pdf->Rect(8.2, 149, 0.8, 52, 'DF', array('all' => 0), array(150, 150, 150));	// 9
		$pdf->Rect(9, 8, 2, 136, 'DF', array('all' => 0), array(200, 200, 200));		// 5
		$pdf->Rect(9, 149, 2, 52, 'DF', array('all' => 0), array(200, 200, 200));		// 10
	// }
	// Miejsce na pieczątke {
		$pdf->PolyLine(array(38, 29, 16, 29, 16, 8, 81, 8, 81, 11), 'D', array('width' => 0.1, 'color' => array(0, 0, 0)));		// 11 Ramka
		$pdf->SetFont('freesans', 'B', 5); // Czcionka
		$pdf->setFontSpacing(0); // Odstępy między znakami
		$pdf->MultiCell(7, 3, '(m.p.)', 0, 'R', false, 1, 75, 27); // Napis (m.p.)
	// }
	// Lewy prostokąt {
		$pdf->Rect(16, 30, 65, 114, 'DF', array('all' => 0.1), array(100, 100, 100));	// 12
		// Polecenie wyjazdu {
			$pdf->Rect(17, 31, 63, 13, 'DF', array('all' => 0.1), array(220, 220, 220)); 	// 13 Prostokąt Polecenie wyjazdu służbowego
			$pdf->SetFont('freesans', 'B', 12);
			$pdf->setFontSpacing(0.77);
			$pdf->MultiCell(62, 6, 'POLECENIE WYJAZDU', 0, 'C', false, 1, 17, 31);
			$pdf->SetFont('freesans', 'B', 12);
			$pdf->setFontSpacing(0);
			$pdf->MultiCell(34, 6, 'SŁUŻBOWEGO', 0, 'C', false, 1, 17, 38);
			$pdf->SetFont('freesans', 'B', 14);
			$pdf->setFontSpacing(0);
			$pdf->MultiCell(10, 6, 'Nr', 0, 'R', false, 1, 50, 37);
			// Miejsce na nr delegacji {
				$pdf->Rect(60, 37, 19, 6, 'DF', array('all' => 0.1), array(255, 255, 255)); 	// 14 Prostokąt wewnątrz polecenia służbowego
				$pdf->SetFont('freesans', 'B', 14);
				$pdf->setFontSpacing(0);
				$pdf->MultiCell(18, 5, $numer, 0, 'C', false, 1, 60, 37);
			// }
		// }
		// Wezwanie {
			$pdf->Rect(17, 45, 63, 12, 'DF', array('all' => 0.1), array(255, 255, 255));	// 15
			
		// }
		// Dane Pracownika {
			$pdf->Rect(17, 58, 63, 50, 'DF', array('all' => 0.1), array(255, 255, 255));	// 16
		// }
		// Środki Lokomocji {
			$pdf->Rect(17, 109, 63, 18, 'DF', array('all' => 0.1), array(255, 255, 255));	// 17
		// }
		// Podpis zlecenia {
			$pdf->Rect(17, 128, 63, 15, 'DF', array('all' => 0.1), array(255, 255, 255));	// 18
		// }
	// }
	// Prawy prostokąt {
		$pdf->PolyLine(array(82, 8, 138, 8, 138, 144, 82, 144, 82, 8), 'D', array('width' => 0.1, 'color' => array(0, 0, 0)));	// 19
		// Potwierdzenie {
			$pdf->Rect(83, 9, 54, 15, 'DF', array('all' => 0), array(220, 220, 220));	// 20
		// }
	// }
	// Linia przerywana oddzielająca dół i górę {
		$pdf->Line(16, 146, 138, 146, array('width' => 0.1, 'dash' => '2, 2', 'color' => array(100, 100, 100)));	// 21
		$pdf->SetLineStyle(array('dash' => 0, 'color' => array(0, 0, 0)));	// Zmiana linii na ciągłą
	// }
	// Prawe paski {
		$pdf->Rect(16, 170, 122, 31, 'DF', array('all' => 0.1), array(200, 200, 200));	// 22
		$pdf->Rect(144, 8, 0.8, 136, 'DF', array('all' => 0), array(200, 200, 200));	// 23
		$pdf->Rect(144, 149, 0.8, 52, 'DF', array('all' => 0), array(200, 200, 200));	// 26
		$pdf->Rect(144.8, 8, 0.4, 136, 'DF', array('all' => 0), array(255, 255, 255));	// 24
		$pdf->Rect(144.8, 149, 0.4, 52, 'DF', array('all' => 0), array(255, 255, 255));	// 27
		$pdf->Rect(145.2, 8, 0.8, 136, 'DF', array('all' => 0), array(200, 200, 200));	// 25
		$pdf->Rect(145.2, 149, 0.8, 52, 'DF', array('all' => 0), array(200, 200, 200));	// 28
	// }
	
	
	
	$pdf->Output('files/eSekretariat/Delegacje/'.$tytulpdf.'.pdf', 'F');
	
	//$_SESSION['tytulc'] = $tytulcp;
	$_SESSION['tytulpdf'] = $tytulpdfp.'.pdf';
	//header('Location: '.$_SERVER['HTTP_REFERER']);
?>