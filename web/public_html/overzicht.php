<?php

require('../resources/config.php');

$pageTitle = 'Overzicht';

include(TEMPLATE_PATH . '/header.php');

?>

    <div class="row">
      <div class="col l1"></div>
      <div class="col s12 l10">
        <h2>Welkom, <?=$_GEBRUIKER->voornaam?></h2>
        <div class="row">
<?php
$periodeHuidig = Periode::getHuidige($_CONNECTION);
if ($periodeHuidig !== false) {
?>

          <div class="col s12 m6 l4">
            <h5>Huidige Verkiezing</h5>
            <div class="card">
              <div class="card-content">
                <span class="card-title"><?=$periodeHuidig->getNaam()?></span>
                <p>
                  Begin: <?=$periodeHuidig->getBeginDatum()?><br/>
                  Eind: <?=$periodeHuidig->getEindDatum()?>
                </p>
              </div>
              <div class="card-action">
                <a href="#" onclick="document.getElementById('huidigePeriode').submit()" class="accent-color-text">Stemmen</a>
                <form id="huidigePeriode" method="post" action="/stemmen">
                  <input type="hidden" name="periode" value="<?=$periodeHuidig->getID()?>"/>
                </form>
              </div>
            </div>
          </div>

<?php
}

$periodeHuidig = Periode::getOpkomende($_CONNECTION);
if ($periodeHuidig !== false) {
?>

          <div class="col s12 m6 l4">
            <h5>Opkomende Verkiezing</h5>
            <div class="card">
              <div class="card-content">
                <span class="card-title"><?=$periodeHuidig->getNaam()?></span>
                <p>
                  Begin: <?=$periodeHuidig->getBeginDatum()?><br/>
                  Eind: <?=$periodeHuidig->getEindDatum()?>
                </p>
              </div>
            </div>
          </div>

<?php
}
?>

        </div>
      </div>
    </div>

<?php

include(TEMPLATE_PATH . '/scripts.php');

include(TEMPLATE_PATH . '/footer.php');

?>