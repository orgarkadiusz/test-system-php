<?php
	include 'PDF/tcpdf.php';
	
	$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
	$pdf->SetCreator('System testowy');
	$pdf->SetAuthor('Arkadiusz Orgaś');
	$pdf->SetTitle('Żółć');
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetFont('freesans');
	$pdf->SetMargins(15, 15);
	$pdf->AddPage();
	$pdf->Cell(180, 50, 'Żółć', 1);
	$pdf->Output('moduly/Żółć.pdf', 'F');
?>