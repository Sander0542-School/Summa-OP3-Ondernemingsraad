function openStemModal(verkiesbareID, verkiesbareNaam) {
  $('#modalStemmen').modal('open');
  $('#verkiesbareID').val(verkiesbareID);
  $('#verkiesbareNaam').text(verkiesbareNaam);
}

function openGebruikerBeheerderModal(gebruikerID, gebruikerNaam, gebruikerType, type) {
  $('#modalGebruikerBeheerder').modal('open');
  $('#gebruikerID').val(gebruikerID);
  $('#gebruikerNaam').text(gebruikerNaam);
  $('#gebruikerType').text(gebruikerType);
  $('#submitType').attr('name',type);
}

function openGestemdModal(verkiesbareNaam) {
  $('#modalGestemd').modal('open');
  $('#verkiesbareNaam').text(verkiesbareNaam);
}

function openAanvraagModal(verkiesbareID, verkiesbareNaam, omschrijving) {
  $('#modalAanvraag').modal('open');
  $('#verkiesbareID').val(verkiesbareID);
  $('#verkiesbareNaam').text(verkiesbareNaam);
  $('#verkiesbareOmschrijving').text(omschrijving);
}

function nieuwePeriode() {
  $('#modalNieuwePeriode').modal('open');
}

function editPeriode(periodeNaam, periodeID, periodeBegin, periodeEind) {
  $('#modelEditPeriode').modal('open');
  $('#periodeID').val(periodeID);
  $('#periodeNaam').val(periodeNaam);
  $('#periodeBegin').val(periodeBegin);
  $('#periodeEind').val(periodeEind);
}
