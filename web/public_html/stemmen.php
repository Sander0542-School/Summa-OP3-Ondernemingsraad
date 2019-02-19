<?php

require('../resources/config.php');

$pageTitle = 'Stemmen';

include(TEMPLATE_PATH . '/header.php');



if (isset($_POST["verkiesbareID"])) {
  $verkiesbare = Verkiesbare::fromID($_CONNECTION, $_POST["verkiesbareID"]);
  if ($verkiesbare !== false) {  
    $verkiesbareNaam = $verkiesbare->getGebruiker()->getNaam();
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
    (new Modal($modal))->show();
  }
}

?>

<div class="row">
  <div class="col l1"></div>
  <div class="col s12 l10">

    <div class="row flex">


<?php
$verkiesbaren = Verkiesbare::getVerkiesbare($_CONNECTION);

if ($verkiesbaren !== false) {
  /**
   * @var $verkiesbare Verkiesbare
   */
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
          <a class="primary-color-text" href="# " onclick="openStemModal(<?=$verkiesbare->getID()?>, '<?=$verkiesbare->getGebruiker()->getNaam()?>')">Stem</a>
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

  <!-- Modal Structure Stemmen -->
  
  <div id="modalStemmen" class="modal modal-small">
    <form action="/stemmen" method="post">
      <input type="hidden" id="verkiesbareID" name="verkiesbareID"/>
      <div class="modal-content">
        <h4>Stemmen</h4>
        <p >Weet u zeker dat u op <b name="verkiesbareNaam" id="verkiesbareNaam"></b> wilt stemmen?</p>

      </div>
      <div class="modal-footer">
        <button type="submit" class="waves-effect waves-green btn-flat modal-close green-text">Stem</button>
        <a href="#" class="modal-close waves-effect waves-red red-text btn-flat left">Annuleren</a>
      </div>
    </form>
  </div>

  <?php
 // include TEMPLATE_PATH.'/modals/modalGestemd.php';
  ?>
<?php 
include(TEMPLATE_PATH . '/scripts.php');

include(TEMPLATE_PATH . '/footer.php');
?>