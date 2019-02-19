function openStemModal(verkiesbareID, verkiesbareNaam) {
  $('#modalStemmen').modal('open');
  $('#verkiesbareID').val(verkiesbareID);
  $('#verkiesbareNaam').text(verkiesbareNaam);
}

function openGestemdModal(verkiesbareNaam) {
  $('#modalGestemd').modal('open');
  $('#verkiesbareNaam').text(verkiesbareNaam);
}

