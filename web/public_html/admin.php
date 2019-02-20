<?php

require('../resources/config.php');

$pageTitle = 'Beheerder';

include(TEMPLATE_PATH . '/header.php');

?>

<div style="margin-top: 50px">

<?php
include(TEMPLATE_PATH . '/admin/results.php');
?>

</div>

<?php

include(TEMPLATE_PATH . '/scripts.php');

include(TEMPLATE_PATH . '/footer.php');