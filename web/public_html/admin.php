<?php

require('../resources/config.php');

if (!$_GEBRUIKER->isBeheerder()) {
  header("Location: /stemmen");
}

$pageTitle = 'Beheerder';

include(TEMPLATE_PATH . '/header.php');

?>

  <div style="margin-top: 50px">

<?php

  if (isset($_GET["periode"]) && !is_null($periode = Periode::fromID($_CONNECTION, $_GET['periode']))) {

    if (isset($_POST["periode"], $_FILES["excel"])) {



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

<?php
if (!file_exists(RESOURCES_PATH . '/periodes/p'.$periode->getID().'.xlsx')) {
?>

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

<?php
}
?>

          </div>

          <div class="col s12 m7 l8">
            <div class="card">
              <div class="card-content">
                <span class="card-title">Gebruikers</span>
                
                <table>
                  <thead>
                    <tr>
                      <th>Naam</th>
                      <th>Groep</th>
                      <th>Gestemd</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Naam</td>
                      <td>Groep</td>
                      <td>Gestemd</td>
                    </tr>
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