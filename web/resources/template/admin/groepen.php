<?php
if (isset($_POST["action"])){
  $groep = Groep::fromID($_CONNECTION, $_POST["groepID"]);
  if ($groep !== false) {
    $groepNaam = $groep->getNaam();
  }
}
 ?>
    <div id="groepen" class="row">
      <div class="col l1"></div>
      <div class="col s12 l10">
        <div class="row">

<?php
$groepen = Groep::getGroepen($_CONNECTION);

if ($groepen !== false) {
  /**
   * @var $groep Periode
   */
  foreach ($groepen as $groep) {
?>

          <div class="col s12 l4">
            <div class="card">
              <div class="card-content">
                <form method="POST" action="/admin#groepen">
                  <input type="hidden" name="groepID" value="<?=$groep->getID()?>">
                  <div class="row">
                    <div class="input-field col s12">
                      <input type="text" value="<?=$groep->getNaam()?>" disabled>
                      <label>Propositie</label>
                    </div>
                    <div class="input-field col s12">
                      <input id="groep_<?=$groep->getID()?>_naam" name="groepZetels" type="text" value="<?=$groep->getZetels()?>">
                      <label for="groep_<?=$groep->getID()?>_naam">Zetels</label>
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

        </div>
      </div>
    </div>