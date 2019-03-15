<?php
if (isset($_POST["makeUser"], $_POST["gebruikerID"])) {
  $gebruiker = Gebruiker::fromID($_CONNECTION, $_POST["gebruikerID"]);

  if ($gebruiker !== false) {
    if ($gebruiker->setRecht(0)) {
      $modal = [
        'title' => 'Gebruiker geüpdate',
        'content' => $gebruiker->getNaam().' is nu een gebruiker gemaakt.',
        'autoLoad' => true
      ];
    } else {
      $modal = [
        'title' => 'Fout',
        'content' => $gebruiker->getNaam().' kon geen gebruiker gemaakt worden.',
        'autoLoad' => true
      ];
    }
    (new Modal($modal))->show();
  }
} elseif (isset($_POST["makeAdmin"], $_POST["gebruikerID"])) {
  $gebruiker = Gebruiker::fromID($_CONNECTION, $_POST["gebruikerID"]);

  if ($gebruiker !== false) {
    if ($gebruiker->setRecht(1)) {
      $modal = [
        'title' => 'Gebruiker geüpdate',
        'content' => $gebruiker->getNaam().' is nu een beheerder gemaakt.',
        'autoLoad' => true
      ];
    } else {
      $modal = [
        'title' => 'Fout',
        'content' => $gebruiker->getNaam().' kon geen beheerder gemaakt worden.',
        'autoLoad' => true
      ];
    }
    (new Modal($modal))->show();
  }
}
?>
<div id="gebruikers" class="row">
  <div class="col l1"></div>
  <div class="col s12 l10">
  
<?php
$gebruikers = Gebruiker::getGebruikers($_CONNECTION);

if ($gebruikers !== false) {
?>

    <div class="card">
      <div class="card-content">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Naam</th>
              <th>Groep</th>
              <th>Type</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

<?php
  /**
   * @var $verkiesbare Verkiesbare
   */
  foreach ($gebruikers as $gebruiker) {
?>

            <tr>
              <td><?=$gebruiker->getID()?></td>
              <td><?=$gebruiker->getNaam()?></td>
              <td></td>
              <td><?=$gebruiker->getType()?></td>
              <td>
<?php
    if ($gebruiker->isBeheerder()) {
?>
                <button class="btn waves-effect waves-light" onclick="openGebruikerBeheerderModal('<?=$gebruiker->getID()?>','<?=$gebruiker->getNaam()?>','gebruiker', 'makeUser')">Maak Gebruiker</button>
<?php
    }
    if (!$gebruiker->isBeheerder()) {
?>
                <button class="btn waves-effect waves-light" onclick="openGebruikerBeheerderModal('<?=$gebruiker->getID()?>','<?=$gebruiker->getNaam()?>','beheerder', 'makeAdmin')">Maak Beheerder</button>
<?php
    }
?>
              </td>
            </tr>

<?php
  }
?>

          <tbody>
        <table>
      </div>
    </div>

<?php
}
?>

  </div>
</div>

<!-- Modal Structure Gebruiker Beheerder -->

<div id="modalGebruikerBeheerder" class="modal modal-small">
  <form action="/admin#gebruikers" method="post">
    <input type="hidden" id="gebruikerID" name="gebruikerID"/>
    <div class="modal-content">
      <h4>Gebruiker Wijzingen</h4>
      <p>Weet u zeker dat u <span id="gebruikerNaam"></span> <span id="gebruikerType"></span> wilt maken?</p>
    </div>
    <div class="modal-footer">
      <button id="submitType" type="submit" name="makeUser" class="waves-effect waves-green btn-flat modal-close green-text">Bevestig</button>
      <a href="#gebruikers" class="modal-close waves-effect waves-red red-text btn-flat left">Annuleren</a>
    </div>
  </form>
</div>