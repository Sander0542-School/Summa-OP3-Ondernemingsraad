<div class="navbar-fixed">
  <nav class="nav-extended">
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
if ($_GEBRUIKER !== false && $_GEBRUIKER->isBeheerder()) {
?>
        <li <?=($_SERVER["PHP_SELF"] == '/admin.php' ? 'class="active"' : '')?>><a href="/admin">Beheerder</a></li>
<?php
}
if ($_GEBRUIKER !== false) {
?>
        <li><a href="/login?slo">Uitloggen</a></li>
<?php
}
?>
        <li class="navbar-empty"><a href=""></a></li>
      </ul>
    </div>
<?php
if ($_SERVER["PHP_SELF"] == '/admin.php') {
?>
    <div class="nav-content">
      <ul class="tabs tabs-transparent">
        <li class="navbar-empty"><a href=""></a></li>
        <li class="tab"><a href="#periodes">Periodes</a></li>
        <li class="tab"><a href="#aanvragen">Aanvragen</a></li>
        <li class="tab"><a href="#gebruikers">Gebruikers</a></li>
      </ul>
    </div>
<?php
}
?>
  </nav>
</div>
<div class="navbar-bottom"></div>