<?php

require('../resources/config.php');

$mpdf = new \Mpdf\Mpdf();

$mpdf->SetFooter('Summa College Ondernemingsraad');
$mpdf->SetAuthor('Summa College Ondernemingsraad');

if ($_GEBRUIKER !== false && $_GEBRUIKER->isBeheerder()) {

  if (isset($_GET['ID']) && ($periode = Periode::fromID($_GET["id"])) !== false) {

    $mpdf->SetTitle("Uitslagen " . $periode->getNaam());
    $mpdf->SetSubject('OR Verkiezingen Summa College');
    $mpdf->SetKeywords('Verkiezingen, Uitslagen, Summa College');

    $mpdf->WriteHTML('<h1 style="text-align:center">Stem resultaten</h1>');
  }

} else {
  $mpdf->WriteHTML('<p>U moet inloggen als beheerder om restultaten te kunnen bekijken</p>');
}

$mpdf->Output();

?>