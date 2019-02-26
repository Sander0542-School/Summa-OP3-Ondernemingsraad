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
                      <input id="periode_<?=$periode->getID()?>_naam" type="text" class="validate" value="<?=$periode->getNaam()?>">
                      <label for="periode_<?=$periode->getID()?>_naam">Periode Naam</label>
                    </div>
                    <div class="input-field col s12">
                      <input id="periode_<?=$periode->getID()?>_begin_datum" name="periodeBeginDatum" value="<?=$periode->getBeginDatum()?>" type="text" class="datepicker validate">
                      <label for="periode_<?=$periode->getID()?>_begin_datum">Begin Datum</label>
                    </div>
                    <div class="input-field col s12">
                      <input id="periode_<?=$periode->getID()?>_eind_datum" name="periodeEindDatum" value="<?=$periode->getEindDatum()?>" type="text" class="datepicker validate">
                      <label for="periode_<?=$periode->getID()?>_eind_datum">Eind Datum</label>
                    </div>
                  </div>
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