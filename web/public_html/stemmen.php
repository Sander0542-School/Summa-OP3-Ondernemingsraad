<?php

require('../resources/config.php');

$pageTitle = 'Stemmen';

include(TEMPLATE_PATH . '/header.php');

$_VERKIESBARE = Verkiesbare::getVerkiesbare($_CONNECTION);
?>

<div class="row">
  <div class="col l1"></div>
  <div class="col s12 l10">

    <div class="row">


<?php
if ($_VERKIESBARE !== false) {
  /**
   * @var $verkiesbare Stemmen
   */
  foreach ($_VERKIESBARE as $verkiesbare) {
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
          <a class="" href="#">Stem</a>
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
include(TEMPLATE_PATH . '/scripts.php');

include(TEMPLATE_PATH . '/footer.php');
?>