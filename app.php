<?php

require_once 'google-api-php-client/src/Google/autoload.php';

session_start();

       $client = new Google_Client();


        // $storageService = new Google_Service_Storage($client);
        $computeService = new Google_Service_Compute($client);

        define('API_VERSION', 'v1');
        define('DEFAULT_PROJECT', 'versatile-digit-93720');
        define('DEFAULT_BUCKET', 'cluster-mgmt-bucket');
        define('DEFAULT_OBJECT', 'mccartney.mp3');
        define('DEFAULT_ZONE_NAME', 'us-central1-b');


/**
 * Constants for sample request parameters.
 */

/**
 * Generates the markup for a specific Google Cloud Storage API request.
 * @param string $apiRequestName The name of the API request to process.
 * @param string $apiResponse The API response to process.
 * @return string Markup for the specific Google Cloud Storage API request.
 */

// function instantiate($project, $zone, Google_Service_Compute_Instance $postBody, $optParams = array())
// {
//   $params = array('versatile-digit-93720 ' => $project, 'us-central1-b' => $zone, 'postBody' => $postBody);
//   $params = array_merge($params, $optParams);
//   return $this->call('insert', array($params), "Google_Service_Compute_Operation");
// }


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
 // function listInstances($project, $zone) {
 //    $params = array('versatile-digit-93720' => $project, 'us-central1-b' => $zone);
 //    // $params = array_merge($params, $optParams);
 //    return $this->call('list', array($params), "Google_Service_Compute_InstanceList");
 //  }
    print "<pre>";
  $instances = $computeService->instances->listInstances(DEFAULT_PROJECT, DEFAULT_ZONE_NAME);
  $listInstancesMarkup = generateMarkup('List Instances', $instances);

  // $buckets = $storageService->buckets->listBuckets(DEFAULT_PROJECT);
  // $listBucketsMarkup = generateMarkup('List Buckets', $buckets);

 
  // $bucketsAccessControls = $storageService->bucketAccessControls->
  //   listBucketAccessControls(DEFAULT_BUCKET);
  // $listBucketsAccessControlsMarkup = generateMarkup(
  //   'List Buckets Access Controls', $bucketsAccessControls);

  // $bucket = $storageService->buckets->get(DEFAULT_BUCKET);
  // $getBucketMarkup = generateMarkup('Get Bucket', $bucket);

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
        <p><strong>Hooray!</strong> There's instances, but they cannot be seen yet!</p>
      <?php endif ?>

      <?php if(isset($listBucketsMarkup)): ?>
        <div id="listBuckets">
          <?php print $listBucketsMarkup ?>
        </div>
      <?php endif ?>

      <?php if(isset($listObjectsMarkup)): ?>
        <div id="listObjects">
          <?php print $listObjectsMarkup ?>
        </div>
      <?php endif ?>

      <?php if(isset($listBucketsAccessControlsMarkup)): ?>
        <div id="listBucketsAccessControls">
          <?php print $listBucketsAccessControlsMarkup ?>
        </div>
      <?php endif ?>

      <?php if(isset($listObjectsAccessControlsMarkup)): ?>
        <div id="listObjectsAccessControls">
          <?php print $listObjectsAccessControlsMarkup ?>
        </div>
      <?php endif ?>

      <?php if(isset($getBucketMarkup)): ?>
        <div id="getBucket">
          <?php print $getBucketMarkup ?>
        </div>
      <?php endif ?>

      <?php
        if(isset($authUrl)) {
          print "<a class='login' href='$authUrl'>Authorize Me!</a>";
        } else {
          print "<a class='logout' href='?logout'>Logout</a>";
        }
      ?>
    </div>
  </body>
</html>
