function openStemModal(verkiesbareID, verkiesbareNaam) {
  $('#modalStemmen').modal('open');
  $('#verkiesbareID').val(verkiesbareID);
  $('#verkiesbareNaam').text(verkiesbareNaam);
}

function openGestemdModal(verkiesbareNaam) {
  $('#modalGestemd').modal('open');
  $('#verkiesbareNaam').text(verkiesbareNaam);
}

function openAanvraagModal(verkiesbareID, verkiesbareNaam, omschrijving) {
  $('#modalAanvraag').modal('open');
  $('#verkiesbareID').val(verkiesbareID);
  $('#verkiesbareNaam').text(verkiesbareNaam);
  $('#omschrijving').text(omschrijving);
}


