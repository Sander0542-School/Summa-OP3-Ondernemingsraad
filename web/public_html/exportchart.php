<?php

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$_FORCE_LOGIN = true;

require('../resources/config.php');

$key = 'eref3454trg8ffwe';

if (isset($_GET['key'], $_GET['id'])) {

  if ($_GET["key"] == $key) {

    $periode = Periode::fromID($_CONNECTION, $_GET["id"]);

    if ($periode !== false) {

      $data = array();
      $labels = array();

      foreach ($periode->getVerkiesbare() as $verkiesbare) {
        array_push($data, $verkiesbare->getAantalStemmen());
        array_push($labels, $verkiesbare->getGebruiker()->getNaam()."\n".'('.$verkiesbare->getAantalStemmen().')');
      }
 
      $graph = new Graph\PieGraph(500,500);
      $graph->SetShadow();
      
      $graph->title->Set("Verkiezings uitslag");

      //$graph->title->Set($periode->getNaam());
      
      $p1 = new Plot\PiePlot($data);
      $p1->SetLabels($labels);
      $p1->value->SetAlign('center');
      $graph->Add($p1);

      $graph->Stroke();
      
    }
  }
}

header("HTTP/1.0 404 Not Found");

//404