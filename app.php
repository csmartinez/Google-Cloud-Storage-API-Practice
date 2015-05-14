<?php

require_once 'google-api-php-client/src/Google/autoload.php';

session_start();

       $client = new Google_Client();


        define('API_VERSION', 'v1');
        define('GOOGLE_PROJECT', 'google');
        define('DEFAULT_DISK', 'https://www.googleapis.com/compute/v1/projects/versatile-digit-93720/zones/us-central1-b/diskTypes/pd-standard');
        define('DEFAULT_PROJECT', 'versatile-digit-93720');
        define('BASE_URL', 'https://www.googleapis.com/compute/'. API_VERSION . '/projects/');
        define('DEFAULT_ZONE_NAME', 'us-central1-b');
        define('DEFAULT_MACHINE_TYPE', BASE_URL . DEFAULT_PROJECT . '/zones/' . DEFAULT_ZONE_NAME . '/machineTypes/n1-standard-1');
        define('DEFAULT_NAME', 'new-node');
        define('DEFAULT_ZONE', BASE_URL . DEFAULT_PROJECT . '/zones/' . DEFAULT_ZONE_NAME);
        define('DEFAULT_NAME_WITH_METADATA', 'new-node-with-metadata');
        define('DEFAULT_IMAGE', BASE_URL . GOOGLE_PROJECT .
  '/global/images/gcel-12-04-v20130104');
        define('DEFAULT_NETWORK', BASE_URL . DEFAULT_PROJECT .
  '/global/networks/default');


function generateMarkup($apiRequestName, $apiResponse) {
  $apiRequestMarkup = '';
  $apiRequestMarkup .= "<header><h2>" . $apiRequestName . "</h2></header>";

  if ($apiResponse['items'] == '' ) {
    $apiRequestMarkup .= "<pre>";
    $apiRequestMarkup .= print_r(json_decode(json_encode($apiResponse), true),
      true);
    $apiRequestMarkup .= "</pre>";
  } else {
    foreach($apiResponse['items'] as $response) {
      $apiRequestMarkup .= "<pre>";
      $apiRequestMarkup .= print_r(json_decode(json_encode($response), true),
        true);
      $apiRequestMarkup .= "</pre>";
    }
  }

  return $apiRequestMarkup;
}
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);
}

// if($client->isAccessTokenExpired()) {

//     $authUrl = $client->createAuthUrl();
//     header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));

// }
if ($client->getAccessToken()) {

    print "<pre>";
  $instances = $computeService->instances->listInstances(DEFAULT_PROJECT, DEFAULT_ZONE_NAME);
  $listInstancesMarkup = generateMarkup('List Instances', $instances);

  // $name = DEFAULT_NAME_WITH_METADATA;
  // $machineType = DEFAULT_MACHINE_TYPE;
  // $zone = DEFAULT_ZONE_NAME;
  // $disk = DEFAULT_DISK;
  // $imageSpaceGb = DEFAULT_IMAGE;
  // $googleNetworkInterfaceObj = new Google_Service_Compute_NetworkInterface();
  // $googleAttachedDiskObj = new Google_Service_Compute_AttachedDisk();
  // $network = DEFAULT_NETWORK;
  // $googleNetworkInterfaceObj->setNetwork($network);
  // $metadataItemsObj = new Google_Service_Compute_MetadataItems();
  // $metadataItemsObj->setKey('startup-script');
  // $metadataItemsObj->setValue('apt-get install apache2');
  // $metadata = new Google_Service_Compute_Metadata();
  // $metadata->setItems(array($metadataItemsObj));
  // $new_instance = new Google_Service_Compute_Instance();
  // $new_instance->setName($name);
  // $new_instance->setMachineType($machineType);
  // $new_instance->setNetworkInterfaces(array($googleNetworkInterfaceObj));
  // $new_instance->setMetadata($metadata);
  // // $new_instance->setDisks(array($googleAttachedDiskObj));
  // $insertInstanceWithMetadata = $computeService->instances->insert(
  //   DEFAULT_PROJECT, $zone, $new_instance);
  // $insertInstanceWithMetadataMarkup = generateMarkup(
  //   'Insert Instance With Metadata', $insertInstanceWithMetadata);


  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <header><h1>Google Cloud Storage Sample App</h1></header>
    <div class="main-content">
      <?php if ($instances): ?>
        <p>05.14.15 <strong>Hooray!</strong> There's instances, and they can finally be seen!</p>
      <?php endif ?>
      <?php
        if(isset($authUrl)) {
          print "<a class='login' href='$authUrl'>Authorize Me!</a>";
        } else {
          print "<a class='logout' href='?logout'>Logout</a>";
        }
      ?>


      <?php if(isset($listInstancesMarkup)): ?>
        <div id="listBuckets">
          <?php print $listInstancesMarkup ?>
        </div>
      <?php endif ?>


    </div>
  </body>
</html>