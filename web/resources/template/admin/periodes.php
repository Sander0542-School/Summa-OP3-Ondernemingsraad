 <?php
if (isset($_POST["action"])){
  $periode = Periode::fromID($_CONNECTION, $_POST["periodeID"]);
  if ($periode !== false) {
    $periodeNaam = $periode->getNaam();
    $periodeBegin = DateTime::createFromFormat("d-m-Y H:i:s", $_POST["periodeBeginDatum"]." 00:00:00")->format("Y-m-d H:i:s");
    $periodeEind = DateTime::createFromFormat("d-m-Y H:i:s", $_POST["periodeEindDatum"]." 23:59:59")->format("Y-m-d H:i:s");
    if ($periode->updatePeriode( $_POST["periodeNaam"], $periodeBegin,  $periodeEind)) {
      $modal = [
        'title' => 'Gewijzigd!',
        'content' => 'U heeft '.$periodeNaam.' succesvol gewijzigd.',
        'autoLoad' => true
      ];
    } else {
      $modal = [
        'title' => 'Fout',
        'content' => 'Er is een fout opgetreden tijdens het wijzigen. Als dit vaker gebeurt kunt u contact opnemen met de beheerders van dit systeem',
        'autoLoad' => true
      ];
    }
  (new Modal($modal))->show();
  }
}
 ?>
    <div id="periodes" class="row">
      <div class="col l1"></div>
      <div class="col s12 l10">
        <div class="row">

<?php
$periodes = Periode::getPeriodes($_CONNECTION);

if ($periodes !== false) {
  /**
   * @var $periode Periode
   */
  foreach ($periodes as $periode) {
?>

          <div class="col s12 l4">
            <div class="card">
              <div class="card-content">
                <form method="POST" action="/admin#periodes">
                  <input type="hidden" name="periodeID" value="<?=$periode->getID()?>">
                  <div class="row">
                    <div class="input-field col s12">
                      <input id="periode_<?=$periode->getID()?>_naam" name="periodeNaam" type="text" value="<?=$periode->getNaam()?>">
                      <label for="periode_<?=$periode->getID()?>_naam">Periode Naam</label>
                    </div>
                    <div class="input-field col s12">
                      <input id="periode_<?=$periode->getID()?>_begin_datum" name="periodeBeginDatum" data-date="<?=$periode->getBeginDatum('Y-m-d')?>" type="text" class="datepicker">
                      <label for="periode_<?=$periode->getID()?>_begin_datum">Begin Datum</label>
                    </div>
                    <div class="input-field col s12">
                      <input id="periode_<?=$periode->getID()?>_eind_datum" name="periodeEindDatum" data-date="<?=$periode->getEindDatum('Y-m-d')?>" type="text" class="datepicker">
                      <label for="periode_<?=$periode->getID()?>_eind_datum">Eind Datum</label>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Updaten
                    <i class="material-icons right">edit</i>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>

<?php
  }
}
?>
          <div class="col s12 l4">
  <a class="btn-floating btn-large waves-effect waves-light red" onclick="nieuwePeriode()" ><i class="material-icons">add</i></a>
  </div>

        </div>
      </div>
    </div>

    <!-- Modal Structure Niewe Periode -->
  
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