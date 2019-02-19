<?php

require('../resources/config.php');

$pageTitle = 'Verkiesbaar';

include(TEMPLATE_PATH . '/header.php');

if (isset($_POST["description"]) && isset($_POST["periode"])) {
  $periode = Periode::fromID($_CONNECTION, $_POST["periode"]);
  if ($periode !== false) {
    if ($_GEBRUIKER->verkiesbaarStellen($periode, $_POST["description"])) {
      $modal = [
        'title' => 'Verkiesbaar Gesteld',
        'content' => 'U heeft zich verkiesbaar gesteld. Deze actie moet nu nog goed gekeurd worden door de beheerders',
        'autoLoad' => true
      ];
    } else {
      $modal = [
        'title' => 'Fout',
        'content' => 'Er is een fout opgetreden tijdens het verkiesbaar stellen.',
        'autoLoad' => true
      ];
    }
    (new Modal($modal))->show();
  }
}

?>

<div class="row">
  <div class="col l1"></div>
  <div class="col s12 l10">

    <div class="row">

      <div class="col s12 m6">

        <div class="card">
          <div class="card-content">
            <span class="card-title">Verkiesbaar Stellen</span>
            <div class="row">
            
              <form class="col s12" method="post" action="/verkiesbaar">
                <div class="row">
                  <div class="input-field col s6">
                    <input id="first_name" type="text" value="<?=$_GEBRUIKER->voornaam?>" class="validate" readonly>
                    <label for="first_name" class="active">Voornaam</label>
                  </div>
                  <div class="input-field col s6">
                    <input id="last_name" type="text" value="<?=$_GEBRUIKER->achternaam?>" class="validate" readonly>
                    <label for="last_name" class="active">Achternaam</label>
                  </div>
                  <div class="input-field col s12">
                    <textarea rows="10" id="description" name="description" class="materialize-textarea" required></textarea>
                    <label for="description">Omschrijving</label>
                  </div>
                  <div class="input-field col s12">
                    <select id="periode" name="periode" required>
                      <option value="" disabled selected>Kies een periode</option>
<?php
$periodes = Periode::getPeriodes($_CONNECTION, false);

if ($periodes !== false) {
  foreach ($periodes as $periode) {
?>

                      <option value="<?=$periode->getID()?>"><?=$periode->getNaam()?> (<?=$periode->getBeginDatum()?> - <?=$periode->getEindDatum()?>)</option>

<?php
  }
}
?>
                    </select>
                    <label for="periode">Periode</label>
                  </div>
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="action">Aanvragen
                  <i class="material-icons right">send</i>
                </button>
              </form>
            </div>
          </div>
        </div>

      </div>

      <div class="col s12 m6">
        <div class="card">
          <div class="card-content">
            <span class="card-title"></span>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<?php
include(TEMPLATE_PATH . '/scripts.php');

include(TEMPLATE_PATH . '/footer.php');
?>