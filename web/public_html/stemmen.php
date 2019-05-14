<?php

require('../resources/config.php');

$pageTitle = 'Stemmen';

include(TEMPLATE_PATH . '/header.php');

if (isset($_POST["verkiesbareID"])) {
  $verkiesbare = Verkiesbare::fromID($_CONNECTION, $_POST["verkiesbareID"]);

  if ($verkiesbare !== false) {
    $verkiesbareNaam = $verkiesbare->getGebruiker()->getNaam();

    if ($verkiesbare->getPeriode()->magStemmen($_GEBRUIKER)) {
      if ($verkiesbare->getPeriode()->heeftGestemd($_GEBRUIKER, $verkiesbare)) {

        if ($addstem = Stemmen::addStem($_CONNECTION, $verkiesbare, $_GEBRUIKER)) {
          $modal = [
            'title' => 'Gestemd!',
            'content' => 'U heeft succesvol gestemd op '.$verkiesbareNaam,
            'autoLoad' => true
          ];
        } else {
          $modal = [
            'title' => 'Niet Gestemd',
            'content' => 'Er is een fout opgetreden tijdens het stemmen. Als dit vaker gebeurt kunt u contact opnemen met de beheerders van dit systeem',
            'autoLoad' => true
          ];
        }
      } else {
        $modal = [
          'title' => 'Fout',
          'content' => 'U heeft al gestemd op '.$verkiesbareNaam,
          'autoLoad' => true
        ];
      }
    } else {
      $modal = [
        'title' => 'Fout',
        'content' => 'U mag niet meer stemmen, omdat u al heeft gestemd',
        'autoLoad' => true
      ];
    }
    (new Modal($modal))->show();
  }
}

if (!isset($_POST['periode'])) {
?>
    <div id="results" class="row">
      <div class="col l1"></div>
      <div class="col s12 l10">
        <div class="row">

<?php
$periodes = Periode::getPeriodes($_CONNECTION, Periode::PERIODES_HUIDIG);

if ($periodes !== false) {
  foreach ($periodes as $periode) {
?>

          <div class="col s12 l4">
            <div class="card">
              <div class="card-content">
                <form method="post" action="/stemmen">
                  <input type="hidden" name="periode" value="<?=$periode->getID()?>"/>
                  <span class="card-title"><?=$periode->getNaam()?></span><br/>
                  <p class="center" style="width:100%">
                    <button type="submit" class="btn-floating btn-large center accent-color">
                      <i class="material-icons">arrow_forward</i>
                    </button>
                  </p>
                </form>
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

<?php 
} else {
  $periode = Periode::fromID($_CONNECTION, $_POST["periode"]);
  
  if ($periode !== false) {
    ?>

  <div class="row">
    <div class="col l1"></div>
    <div class="col s12 l10">
  
      <div class="row">
        <div class="col s12 m4 l3">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">Aantal stemmen</span>
              <p>U heeft <?=$periode->aantalGestemd($_GEBRUIKER)?> van de <?=$periode->maxStemmen($_GEBRUIKER)?> keer gestemd</p>
            </div>
          </div>
        </div>
      </div>

<?php
    $verkiesbaren = $periode->getVerkiesbare($_GEBRUIKER);

    if ($verkiesbaren !== false) {
    /**
     * @var $verkiesbare Verkiesbare
     */
?>
    
      <div class="row flex">

<?php
      foreach ($verkiesbaren as $verkiesbare) {
?>
  
        <div class="col s12 m4 l3">
          <div class="card">
            <div class="card-image">
              <img src="/images/defualt.jpg">
            </div>
            <div class="card-content">
              <span class="card-title"><?=$verkiesbare->getGebruiker()->getNaam()?></span>
              <p><?=$verkiesbare->omschrijving?></p>
            </div>
          <div class="card-action">
            <a class="primary-color-text" href="# " onclick="openStemModal(<?=$verkiesbare->getID()?>, '<?=$verkiesbare->getGebruiker()->getNaam()?>' )">Stem</a>
          </div>
          </div>
        </div>

<?php
      }
?>

      </div>

<?php
    }
?>

    </div>
  </div>

<?php
  }
}
?>

  <!-- Modal Structure Stemmen -->
  
  <div id="modalStemmen" class="modal modal-small">
    <form action="/stemmen" method="post">
      <input type="hidden" id="verkiesbareID" name="verkiesbareID"/>
      <input type="hidden" value="<?=$_POST["periode"]?>" name="periode"/>
      <div class="modal-content">
        <h4>Stemmen</h4>
        <p >Weet u zeker dat u op <b id="verkiesbareNaam"></b> wilt stemmen?</p>

      </div>
      <div class="modal-footer">
        <button type="submit" class="waves-effect waves-green btn-flat modal-close green-text">Stem</button>
        <a href="#" class="modal-close waves-effect waves-red red-text btn-flat left">Annuleren</a>
      </div>
    </form>
  </div>
  
<?php 
include(TEMPLATE_PATH . '/scripts.php');

include(TEMPLATE_PATH . '/footer.php');
?>