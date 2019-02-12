<?php

require('../resources/config.php');

$pageTitle = 'Stemmen';

include(TEMPLATE_PATH . '/header.php');
?>

<?php

$_VERKIESBARE = Stemmen::getVerkiesbare($_CONNECTION);

for () {
?>

<div class="row">
  <div class="col l1"></div>
  <div class="col s12 l10">

    <div class="row">
      <div class="col s12 m4 l3">

        <div class="card">
          <div class="card-image">
            <img src="/images/defualt.jpg">
          </div>
          <div class="card-content">
            <span class="card-title">Card Title</span>
            <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I
              require little markup to use effectively.</p>
          </div>
        </div>

      </div>
    </div>


  </div>
</div>
<?php 
}
?>