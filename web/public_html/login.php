<?php

use OneLogin\Saml2\Auth;

require('../resources/config.php');

$HIDE_NAV = true;

$pageTitle = 'Inloggen';

if (isset($_GET["id"])) {
  $_SESSION["userID"] = $_GET["id"];
  header("Location: /overzicht");
  die();
}

require RESOURCES_PATH . '/adfs-settings.php';

if (isset($_GET["redirect"]) && !empty($_GET["redirect"])) {
  $_SESSION["redirect"] = $_GET["redirect"];
}

$auth = new Auth($settingsInfo);

if (isset($_GET["sso"])) {
  //Login met Summa College ADFS
  $auth->login();
} elseif (isset($_GET["acs"])) {
  if (isset($_SESSION) && isset($_SESSION['AuthNRequestID'])) {
    $requestID = $_SESSION['AuthNRequestID'];
  } else {
    $requestID = null;
  }

  try {
    $auth->processResponse($requestID);
    $errors = $auth->getErrors();

    if (empty($errors)) {

      if ($auth->isAuthenticated()) {

        $_SESSION['samlNameId'] = $auth->getNameId();
        $_SESSION['samlNameIdFormat'] = $auth->getNameIdFormat();
        $_SESSION['samlSessionIndex'] = $auth->getSessionIndex();
        $_SESSION['samlUserdata'] = $auth->getAttributes();

        switch (Authenticatie::login($_CONNECTION, $_SESSION)) {
          case Authenticatie::LOGIN_SUCCESS:
            $_GEBRUIKER = Gebruiker::fromID($_CONNECTION, $_SESSION["userSession"]);
            if ($_GEBRUIKER->toegang == 1) {
              if (isset($_SESSION["redirect"]) && !empty($_SESSION["redirect"])) {
                header("Location: ".$_SESSION["redirect"]);
                unset($_SESSION["redirect"]);
              } else {
                header("Location: /index.php");
              }
            } else {
              header("Location: /login.php?toegang=none");
            }
            break;
          case Authenticatie::LOGIN_INVALID_SESSION:
            echo '<script>M.toast({html: \'Er is een fout opgetreden tijden het inloggen\'})</script>';
            break;
          case Authenticatie::LOGIN_INVALID_DATA:
            echo '<script>M.toast({html: \'Er is een fout opgetreden tijden het inloggen\'})</script>';
            break;
        }
      } else {
        echo '<script>M.toast({html: \'Er is een fout opgetreden tijden het inloggen\'})</script>';
      }
    } else {
      echo '<script>M.toast({html: \'Er is een fout opgetreden tijden het inloggen\'})</script>';
    }
  } catch (Exception $e) {
    echo '<script>M.toast({html: \'Er is een fout opgetreden tijden het inloggen\'})</script>';
  }
} elseif (isset($_GET["loguit"])) {
  echo '<script>M.toast({html: \'U bent nu uitgelogd\'})</script>';
} elseif (isset($_GET["toegang"])) {
  if ($_GET["toegang"] == "false") {
    echo '<script>M.toast({html: \'U heeft geen toegang tot het Opleidingsportfolio\'})</script>';
    $_SHOW_NO_ACCESS = true;
  }
}

include TEMPLATE_PATH . '/header.php';
?>

  <div class="container">
    <div class="row">
      <div class="col m2 l3 xl4"></div>
      <div style="margin-top:30vh" class="col s12 m8 l6 xl4">
        <div class="card">
          <div class="card-content">
            <img src="/images/logo.png" width="100%"/>
            <a class="btn btn-block waves-effect waves-light" href="?sso">Inloggen</a>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
include TEMPLATE_PATH . '/footer.php';
?>