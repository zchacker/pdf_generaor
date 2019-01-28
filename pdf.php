<?php
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$count = 0;
$pages = 0;
for($i = 1; $i < 10; $i++){

  $pdf->Image('imgs/text.jpg', 5, $count+2 , 100 , 60);
  $pdf->Image('imgs/text.jpg', 110 , $count+2 , 100 , 60);

  $count += 70;
  if(($i%4) == 0){
    $count = 0;
    $pdf->AddPage();
  }
}


//$pdf->Image('imgs/text.jpg',0,70, 100 , 60);
//$pdf->Image('imgs/text.jpg',100,70, 100 , 60);

//$pdf->Image('imgs/text.jpg',10,10,-300);
//$pdf->Cell(40,10,'Hello World!');
//$pdf->Cell(40,10,'Hello World1!');
$pdf->Output();
?>
