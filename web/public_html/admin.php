<?php

require('../resources/config.php');

if (!$_GEBRUIKER->isBeheerder()) {
  header("Location: /stemmen");
}

$pageTitle = 'Beheerder';

include(TEMPLATE_PATH . '/header.php');

?>

  <div style="margin-top: 50px">

<?php

  include(TEMPLATE_PATH . '/admin/results.php');

  include(TEMPLATE_PATH . '/admin/aanvragen.php');

  include(TEMPLATE_PATH . '/admin/periodes.php');

  include(TEMPLATE_PATH . '/admin/gebruikers.php');

?>

  </div>

<?php

include(TEMPLATE_PATH . '/scripts.php');

include(TEMPLATE_PATH . '/footer.php');