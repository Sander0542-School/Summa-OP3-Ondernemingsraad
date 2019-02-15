<?php

require('../resources/config.php');

$pageTitle = 'Verkiesbaar';

include(TEMPLATE_PATH . '/header.php');

$_GEBRUIKER = Gebruiker::fromGebruikerID($_CONNECTION, 1);

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
              <form class="col s12">
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
                    <textarea rows="10" id="description" class="materialize-textarea"></textarea>
                    <label for="description">Omschrijving</label>
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
    </div>

  </div>
</div>

<?php
include(TEMPLATE_PATH . '/scripts.php');

include(TEMPLATE_PATH . '/footer.php');
?>