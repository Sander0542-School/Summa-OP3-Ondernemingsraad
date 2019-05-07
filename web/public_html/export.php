<?php

require('../resources/config.php');

$mpdf = new \Mpdf\Mpdf();

$mpdf->SetHTMLHeader();
$mpdf->SetFooter('Summa College Ondernemingsraad');
$mpdf->SetAuthor('Summa College Ondernemingsraad');

if ($_GEBRUIKER !== false && $_GEBRUIKER->isBeheerder() && isset($_GET['id'])) {

  $periode = Periode::fromID($_CONNECTION, $_GET["id"]);

  if ($periode !== false) {

    $mpdf->SetHTMLHeader("Test");
    $mpdf->SetTitle("Uitslagen " . $periode->getNaam());
    $mpdf->SetSubject('OR Verkiezingen Summa College');
    $mpdf->SetKeywords('Verkiezingen, Uitslagen, Summa College');

    $mpdf->WriteHTML('<h1 style="text-align:center">Stem resultaten</h1>');

    foreach ($periode->getVerkiesbare() as $verkiesbare) {
      $mpdf->WriteHTML('<p>'.$verkiesbare->getGebruiker()->getNaam().': '.$verkiesbare->getAantalStemmen().'</p>');
    }

    $mpdf->WriteHTML('Totaal: '.$periode->getAantalStemmen());

    $mpdf->WriteHTML('<img src="exportchart.php?key=eref3454trg8ffwe&id='.$_GET['id'].'">');

    // $mpdf->Image('exportchart.php?key=eref3454trg8ffwe&id='.$_GET['id']);
    
    $mpdf->Output();

  } else {
    header("HTTP/1.0 404 Not Found");
  }
} else {
  header("HTTP/1.0 404 Not Found");
}
?>