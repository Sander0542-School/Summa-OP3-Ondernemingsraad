<?php

$spBaseUrl = 'http://localhost';

$settingsInfo = array (
  'sp' => array (
    'entityId' => $spBaseUrl,
    'assertionConsumerService' => array (
      'url' => $spBaseUrl.'/login.php?acs',
    ),
    'singleLogoutService' => array (
      'url' => $spBaseUrl.'/login.php?sls',
    ),
    'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
  ),
  'idp' => array (
    'entityId' => 'https://adfs-t.summacollege.nl/adfs/ls',
    'singleSignOnService' => array (
      'url' => 'https://adfs-t.summacollege.nl/adfs/ls',
    ),
    'x509cert' => '',
  ),
);