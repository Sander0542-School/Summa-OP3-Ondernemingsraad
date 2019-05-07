<?php

require('../resources/config.php');

$mpdf = new \Mpdf\Mpdf();

$periode = Periode::fromID($_CONNECTION, $_GET["id"]);

$h = array('odd' => array('L' => array('content' => "Summa College", 'font-size' => 8, 'font-style' => 'B'), 'C' => array('content' =>  $periode->getNaam(), 'font-size' => 8, 'font-style' => 'B'), 'line' => 1));

$mpdf->SetFooter('Summa College Ondernemingsraad');

if ($_GEBRUIKER !== false && $_GEBRUIKER->isBeheerder() && isset($_GET['id'])) {


  if ($periode !== false) {

    $mpdf->SetHeader($h);
    $mpdf->SetTitle("Uitslagen " . $periode->getNaam());
    $mpdf->SetSubject('OR Verkiezingen Summa College');
    $mpdf->SetKeywords('Verkiezingen, Uitslagen, Summa College');

    $mpdf->WriteHTML('<h1 style="text-align:center">Stemresultaten</h1>');

    foreach ($periode->getVerkiesbare() as $verkiesbare) {
      $mpdf->WriteHTML('<p>'.$verkiesbare->getGebruiker()->getNaam().': '.$verkiesbare->getAantalStemmen().'</p>');
    }

    $mpdf->WriteHTML('Totaal: '.$periode->getAantalStemmen());

    $mpdf->WriteHTML('<img style="  
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
    " src="exportchart.php?key=eref3454trg8ffwe&id='.$_GET['id'].'">');
    
    $mpdf->Output();

  } else {
    header("HTTP/1.0 404 Not Found");
  }
} else {
  header("HTTP/1.0 404 Not Found");
}
?>