    <div id="results" class="row">
      <div class="col l1"></div>
      <div class="col s12 l10">
        <div class="row">

<?php
$periodes = Periode::getPeriodes($_CONNECTION);

if ($periodes !== false) {
  foreach ($periodes as $periode) {
    
    $verkiesbaar = $periode->getVerkiesbare();
?>

          <div class="col s12 l4">
            <div class="card">
              <div class="card-content">
                <span class="card-title"><?=$periode->getNaam()?></span>
                <p>Aantal Stemmen: <?=$periode->getAantalStemmen()?></p>
                <p>Aantal Verkiesbaar: <?=($verkiesbaar !== false ? count($verkiesbaar) : 0)?></p>
              </div>
              <div class="card-action">
                <a class="primary-color-text" href="#">Exporteer</a>
              </div>
            </div>
          </div>

<?php
  }
}
?>

        </div>
      </div>
    </div>