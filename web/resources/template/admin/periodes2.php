    <div id="periodes" class="row">
      <div class="col l1"></div>
      <div class="col s12 l10">
        <div class="row flex">

          <div class="col s12 l4">
            <div class="card">
              <div class="card-content">
                <p class="center-align">
                  <br/>
                  <a class="btn-floating btn-large waves-effect waves-light red" onclick="nieuwePeriode()" ><i class="material-icons">add</i></a>
                </p>
              </div>
            </div>
          </div>

<?php
$periodes = Periode::getPeriodes($_CONNECTION);

if ($periodes !== false) {
  /**
   * @var $periode Periode
   */
  foreach ($periodes as $periode) {
?>

          <div class="col s12 l4">
            <div class="card clickable" onclick="window.location.href = '/admin?periode=<?=$periode->getID()?>'">
              <div class="card-content">
              
                <span class="card-title"><?=$periode->getNaam()?></span>

                <p>Begin: <?=$periode->getBeginDatum('Y-m-d')?></p>
                <p>Eind: <?=$periode->getEindDatum('Y-m-d')?></p>

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

    <!-- Modal Structure Niewe Periode -->
  
  <div id="modalNieuwePeriode" class="modal modal-small">
    <form action="/admin" method="post">
      <input type="hidden" name="NieuwePeriode"/>
      <div class="modal-content">
        <h4>Nieuwe periode</h4>
        <p >Voer een begin en eind datum in voor de nieuwe periode</p>
        <input name="periodeBeginDatum" type="text" class="datepicker">
        <label for="periodeBeginDatum">Begin Datum</label>
        <input name="periodeEindDatum" type="text" class="datepicker">
        <label for="periodeEindDatum">Eind Datum</label>

      </div>
      <div class="modal-footer">
        <button type="submit" class="waves-effect waves-green btn-flat modal-close green-text">Nieuwe periode aanmaken</button>
        <a href="#" class="modal-close waves-effect waves-red red-text btn-flat left">Annuleren</a>
      </div>
    </form>
  </div>