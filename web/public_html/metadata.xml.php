<?php

require('../resources/config.php');

require RESOURCES_PATH . '/adfs-settings.php';

use OneLogin\Saml2\Error;
use OneLogin\Saml2\Settings;

try {
  #$auth = new OneLogin_Saml2_Auth($settingsInfo);
  #$settings = $auth->getSettings();
  // Now we only validate SP settings
  $settings = new Settings($settingsInfo, true);
  $metadata = $settings->getSPMetadata();
  $errors = $settings->validateMetadata($metadata);
  if (empty($errors)) {
    header('Content-Type: text/xml');
    echo $metadata;
  } else {
    throw new Error(
      'Invalid SP metadata: ' . implode(', ', $errors),
      Error::METADATA_SP_INVALID
    );
  }
} catch (Exception $e) {
  echo $e->getMessage();
}