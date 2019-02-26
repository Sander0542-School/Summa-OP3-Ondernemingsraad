<div id="aanvragen" class="row">
  <div class="col l1"></div>
  <div class="col s12 l10">
    <div class="row flex">
  
<?php
$verkiesbare = Verkiesbare::getAanvraag($_CONNECTION);

if ($periode !== false) {
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
      <div class="row">
        <div class="col s12 l7">
          <p>
            <span>Naam: <span id="verkiesbareNaam"></span></span><br/>
            <span>Omschrijving:<br/><span id="verkiesbareOmschrijving"></span></span>
          </p>
        </div>
      </div>
      <h4>Aanvraag</h4>
      <p >Weet u zeker dat u  wilt goedkeuren?</p>
      <p >Omschrijving: <b name="omschrijving" id="omschrijving"></b></p>
    </div>
    <div class="modal-footer">
      <button type="submit" class="waves-effect waves-green btn-flat modal-close green-text">Goedkeuren</button>
      <a href="#" class="modal-close waves-effect waves-red red-text btn-flat left">Weigeren</a>
    </div>
  </form>
</div>