<?php

require('../resources/config.php');

$pageTitle = 'Verkiesbaar';

include(TEMPLATE_PATH . '/header.php');

if (isset($_POST["description"]) && isset($_POST["periode"], $_FILES["profilePicture"])) {
  $periode = Periode::fromID($_CONNECTION, $_POST["periode"]);
  if ($periode !== false) {
    $verkiesbareID = $_GEBRUIKER->verkiesbaarStellen($periode, $_POST["description"]);
    if ($verkiesbareID !== false) {

        $target_dir = "images/user/";
        $target_file = $target_dir . basename($_FILES["profilePicture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $uploadPath = $target_dir . 'u' . $verkiesbareID . '.png';
        $errormsg = "Sorry, tijdens het uploaden van je foto is er iets fout gegaan!";
        $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
        if($check == false) {
            $uploadOk = 0;
        }
        if ($_FILES["profilePicture"]["size"] > 5000000) {
            $uploadOk = 0;
        }
        switch ($imageFileType) {
            case "png":
                $image = imagecreatefrompng($_FILES["profilePicture"]["tmp_name"]);
                break;
            case "jpg":
            case "jpeg":
                $image = imagecreatefromjpeg($_FILES["profilePicture"]["tmp_name"]);
                break;
            default:
                $uploadOk = 0;
        }
        if ($uploadOk == 0) {
          $modal = [
            'title' => 'Fout',
            'content' => 'Sorry, tijdens het uploaden van je foto is er iets fout gegaan!',
            'autoLoad' => true
          ];
        } else {
            if (imagepng($image, $uploadPath)) {
                //Success TODO()
            } else {
              $modal = [
                'title' => 'Fout',
                'content' => 'Sorry, tijdens het uploaden van je foto is er iets fout gegaan!',
                'autoLoad' => true
              ];
            }
        }

      $modal = [
        'title' => 'Verkiesbaar Gesteld',
        'content' => 'U heeft zich verkiesbaar gesteld. Deze actie moet nu nog goed gekeurd worden door de beheerders',
        'autoLoad' => true
      ];
    } else {
      $modal = [
        'title' => 'Fout',
        'content' => 'Er is een fout opgetreden tijdens het verkiesbaar stellen voor deze verkiezing.',
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
            
              <form class="col s12" method="post" action="/verkiesbaar" enctype="multipart/form-data">
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
                  <div class="file-field input-field col s12">
                    <div class="btn">
                      <span>Bestand</span>
                      <input name="profilePicture" type="file" accept="image/*">
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate" type="text">
                    </div>
                  </div>
                  <div class="input-field col s12">
                    <select id="periode" name="periode" required>
                      <option value="" disabled selected>Kies een periode</option>
<?php
$periodes = Periode::getPeriodes($_CONNECTION, Periode::PERIODES_AANKOMEND);

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
            <span class="card-title">Verkiesbare Aanvragen</span>
<?php
$aanvragen = $_GEBRUIKER->getVerkiesbareAanvragen();

if ($aanvragen !== false) {
?>
            <table>
              <thead>
                <tr>
                  <th>Periode</th>
                  <th>Omschrijving</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
<?php
  /**
   * @var $aanvraag Verkiesbare
   */
  foreach ($aanvragen as $aanvraag) {
?>
                <tr>
                  <td><?=$aanvraag->getPeriode()->getNaam()?></td>
                  <td><?=$aanvraag->omschrijving?></td>
                  <td><?=$aanvraag->getStatus()?></td>
                </tr>
<?php
  }
?>
              </tbody>
            </table>
<?php
}
?>
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