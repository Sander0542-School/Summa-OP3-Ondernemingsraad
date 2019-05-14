<?php

require('../resources/config.php');

if (!$_GEBRUIKER->isBeheerder()) {
  header("Location: /stemmen");
  die();
}

$pageTitle = 'Beheerder';

if (isset($_POST["NieuwePeriode"])) {

  $periodeNaam = $_POST["periodeNaam"];
  $periodeBegin = DateTime::createFromFormat("d-m-Y H:i:s", $_POST["periodeBeginDatum"]." 00:00:00")->format("Y-m-d H:i:s");
  $periodeEind = DateTime::createFromFormat("d-m-Y H:i:s", $_POST["periodeEindDatum"]." 23:59:59")->format("Y-m-d H:i:s");

  if ($newPeriode = Periode::addPeriode($_CONNECTION, $periodeNaam, $periodeBegin, $periodeEind)) {
    $modal = [
      'title' => 'Aangemaakt!',
      'content' => 'U heeft succesvol verkiezing aangemaakt',
      'autoLoad' => true
    ];
  }
}

include(TEMPLATE_PATH . '/header.php');

?>

  <div style="margin-top: 50px">

<?php

  if (isset($_GET["periode"]) && !is_null($periode = Periode::fromID($_CONNECTION, $_GET['periode']))) {

    if (isset($_POST["periode"], $_FILES["excel"]) && $_POST['periode'] == $_GET['periode']) {

      ExcelImport::LaadGebruikers($_CONNECTION, $_FILES['excel'], $periode->getID());

    }

?>

    <div class="row">

      <div class="col l1"></div>

      <div class="col s12 l10">
        <div class="row">

          <div class="col s12 m5 l4">
            <div class="card">
              <div class="card-content">
                <span class="card-title"><?=$periode->getNaam()?></span>

                <p>Begin: <?=$periode->getBeginDatum()?></p>
                <p>Eind: <?=$periode->getEindDatum()?></p>
              </div>
            </div>


            <div class="card">
              <div class="card-content">
                <span class="card-title">Gebruikers Inladen</span>
                
                <form action="/admin?periode=<?=$periode->getID()?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="periode" value="<?=$periode->getID()?>">

                  <div class="file-field input-field">
                    <div class="btn">
                      <span>Bestand</span>
                      <input name="excel" accept=".xlsx" type="file">
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate" type="text">
                    </div>
                  </div>

                  <button class="btn waves-effect waves-light" type="submit" name="action">Uploaden</button>
                </form>
              </div>
            </div>

          </div>

          <div class="col s12 m7 l8">
            <div class="card">
              <div class="card-content">
                <span class="card-title">Gebruikers</span>
                
                <table>
                  <thead>
                    <tr>
                      <th>Code</th>
                      <th>Groep</th>
                      <th>Stemmen</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
<?php
$stemmers = $periode->getStemmers();

if ($stemmers) {
  foreach ($stemmers as $stemmer) {
    $gebruiker = $stemmer->getGebruiker();
?>
                    <tr>
                      <td><?=$stemmer->getCode()?></td>
                      <td><?=$stemmer->getGroep()?></td>
                      <td><?=$stemmer->getStemmen()?></td>
                      <td><?=($gebruiker ? ($periode->magStemmen($_GEBRUIKER) ? 'Niet gestemd' : 'Gestemd') : 'Niet gestemd')?></td>
                    </tr>
<?php
  }
}
?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

<?php

  } else {

    // include(TEMPLATE_PATH . '/admin/periodes.php');
    include(TEMPLATE_PATH . '/admin/periodes2.php');

    include(TEMPLATE_PATH . '/admin/aanvragen.php');

    include(TEMPLATE_PATH . '/admin/gebruikers.php');

  }

?>

  </div>

<?php

include(TEMPLATE_PATH . '/scripts.php');

include(TEMPLATE_PATH . '/footer.php');