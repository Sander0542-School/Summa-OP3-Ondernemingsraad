<div class="navbar-fixed">
  <nav>
    <div class="nav-wrapper">
      <ul class="left">
        <li class="navbar-empty"><a href=""></a></li>
        <li><a href="" class="brand-logo">Ondernemingsraad</a></li>
      </ul>
      <ul class="right">
        <li <?=($_SERVER["PHP_SELF"] == '/overzicht.php' ? 'class="active"' : '')?>><a href="/overzicht">Overzicht</a></li>
        <li <?=($_SERVER["PHP_SELF"] == '/stemmen.php' ? 'class="active"' : '')?>><a href="/stemmen">Stemmen</a></li>
        <li <?=($_SERVER["PHP_SELF"] == '/verkiesbaar.php' ? 'class="active"' : '')?>><a href="/verkiesbaar">Verkiesbaar</a></li>
<?php
if (Gebruiker::isIngelogd($_CONNECTION)) {
?>
        <li><a href="/login?slo">Uitloggen</a></li>
<?php
}
?>
        <li class="navbar-empty"><a href=""></a></li>
      </ul>
    </div>
  </nav>
</div>
<div class="navbar-bottom"></div>