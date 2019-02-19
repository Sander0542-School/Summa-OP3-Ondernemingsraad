<script>
  $(document).ready({
    ...open
  })
</script>
  
<div id="modalGestemd" class="modal modal-small">
  <form action="/stemmen" method="post">
    <div class="modal-content">
      <h4>Stemmen</h4>
      <p >U heeft succesvol op <b id="verkiesbareNaam"></b> gestemd!</p>
    </div>
    <div class="modal-footer">
      <button type="#" class="waves-effect waves-green btn-flat modal-close green-text">OK</button>
    </div>
  </form>
</div>