<?php

require('../resources/config.php');

$pageTitle = 'Stemmen';

include(TEMPLATE_PATH . '/header.php');



if (isset($_POST["verkiesbare"]) && Gebruiker::isIngelogd($_CONNECTION)) {
  $verkiesbare = Verkiesbare::fromID();
  if ($verkiesbare !== false) {
    Stemmen::addStem($_CONNECTION, $verkiesbare, $_GEBRUIKER);
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
          <a href="#" onclick="openStemModal(<?=$verkiesbare->getID()?>, '<?=$verkiesbare->getGebruiker()->getNaam()?>')">Stem</a>
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

  <!-- Modal Structure -->
  
  <div id="modalStemmen" class="modal modal-small">
    <form action="/stemmen" method="post">
      <input type="hidden" id="verkiesbareID" name="verkiesbare"/>
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