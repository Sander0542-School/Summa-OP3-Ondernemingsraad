<?php
if (isset($_POST['verkiesbareID'])){
  $verkiesbare = Verkiesbare::fromID($_CONNECTION, $_POST["verkiesbareID"]);
  if ($verkiesbare !== false) {
    $verkiesbareNaam = $verkiesbare->getGebruiker()->getNaam();
    if ($acceptaanvraag = Verkiesbare::acceptAanvraag($_CONNECTION, $_POST['verkiesbareID'])) {
      $modal = [
        'title' => 'Geaccepteerd!',
        'content' => 'U heeft '.$verkiesbareNaam.' succesvol goedgekeurd.',
        'autoLoad' => true
      ];
    } else {
      $modal = [
        'title' => 'Fout',
        'content' => 'Er is een fout opgetreden tijdens het goedkeuren. Als dit vaker gebeurt kunt u contact opnemen met de beheerders van dit systeem',
        'autoLoad' => true
      ];
    }
  (new Modal($modal))->show();
  }
}
?>

<div id="aanvragen" class="row">
  <div class="col l1"></div>
  <div class="col s12 l10">
    <div class="row flex">
  
<?php
$verkiesbare = Verkiesbare::getAanvraag($_CONNECTION);

if ($verkiesbare !== false) {

  /**
   * @var $verkiesbare Verkiesbare
   */
  foreach ($verkiesbare as $aanvraag) {
?>
  
      <div class="col s12 m4 l3">
        <div class="card">
          <div class="card-content">
            <span class="card-title"><?=$aanvraag->getGebruiker()->getNaam()?></span>
          </div>
          <div class="card-action">
            <a class="primary-color-text" href="#" onclick="openAanvraagModal(<?=$aanvraag->getID()?>, '<?=$aanvraag->getGebruiker()->getNaam()?>', '<?=$aanvraag->omschrijving?>')">Bekijk</a>
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

      <!-- Modal Structure Aanvraag -->
  
<div id="modalAanvraag" class="modal">
  <form action="/admin#aanvragen" method="post">
    <input type="hidden" id="verkiesbareID" name="verkiesbareID"/>
    <div class="modal-content">
      <h4>Aanvraag</h4>
      <p >Weet u zeker dat u <span id="verkiesbareNaam"></span> wilt goedkeuren?</p>
      <p >Omschrijving:  <span id="verkiesbareOmschrijving"></span></p>
    </div>
    <div class="modal-footer">
      <button type="submit" class="waves-effect waves-green btn-flat modal-close green-text">Goedkeuren</button>
      <a href="#" class="modal-close waves-effect waves-red red-text btn-flat left">Weigeren</a>
    </div>
  </form>
</div>

