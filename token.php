<?php
/**
 * Library Requirements
 *
 * 1. Install composer (https://getcomposer.org)
 * 2. On the command line, change to this directory (api-samples/php)
 * 3. Require the google/apiclient library
 *    $ composer require google/apiclient:~2.0
 */
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}
session_start();
require_once __DIR__ . '/vendor/autoload.php';
include('config.php');
date_default_timezone_set("Asia/Bangkok");
/*
 * You can acquire an OAuth 2.0 client ID and client secret from the
 * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
 * For more information about using OAuth 2.0 to access Google APIs, please see:
 * <https://developers.google.com/youtube/v3/guides/authentication>
 * Please ensure that you have enabled the YouTube Data API for your project.
 */

$_SESSION['channel_id'] = (isset($_GET["channel_id"])) ? $_GET["channel_id"] : $_SESSION['channel_id'];
$_SESSION['status'] = (isset($_GET["status"])) ? $_GET["status"] : $_SESSION['status'];
$OAUTH2_CLIENT_ID = OAUTH2_CLIENT_ID;
$OAUTH2_CLIENT_SECRET = OAUTH2_CLIENT_SECRET;
$channelId = $_SESSION['channel_id'];
$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/youtube');
$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
    FILTER_SANITIZE_URL);
$client->setRedirectUri($redirect);

// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);

// Check if an auth token exists for the required scopes
$tokenSessionKey = 'token-' . $client->prepareScopes();

if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate($_GET['code']);
  $accessToken = $client->getAccessToken();
  $_SESSION[$tokenSessionKey] = $accessToken;
  $token = $accessToken['access_token'];
  $updateSql = "UPDATE channels SET access_token = '$token' where channel_id = '" . $_SESSION['channel_id'] . "'";
  $db->query($updateSql);

} else {

  $sql = "select * from channels where channel_id = '$channelId' ";

  $channel_sql = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($channel_sql,MYSQLI_ASSOC);

  if(!isset($row) || $row['access_token'] == '') {
    // If the user hasn't authorized the app, initiate the OAuth flow
    $state = mt_rand();
    $client->setState($state);
    $_SESSION['state'] = $state;

    $authUrl = $client->createAuthUrl() . "&channel_id='$channelId'";
    $htmlBody = <<<END
    <h3>Authorization Required</h3>
    <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
    echo $htmlBody;
    die;
  } else {
        $_SESSION[$tokenSessionKey] = $row['access_token'];
  }
}
if (isset($_SESSION[$tokenSessionKey])) {
  $client->setAccessToken($_SESSION[$tokenSessionKey]);
}
// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
  try {
    // Execute an API request that lists broadcasts owned by the user who
    // authorized the request.
    $broadcastsResponse = $youtube->liveBroadcasts->listLiveBroadcasts(
        'id,snippet,status',
        array(
            'mine' => 'true',
        ));
    foreach ($broadcastsResponse['items'] as $broadcastItem) {
      $broadcastItem["status"]->setPrivacyStatus($_SESSION['status']);
      $broadcastItem->setStatus($broadcastItem["status"]);
      $youtube->liveBroadcasts->update('snippet,status', $broadcastItem, array());
    }
  } catch (Google_Service_Exception $e) {
    $htmlBody = sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
        echo $htmlBody; die;
  } catch (Google_Exception $e) {
    $htmlBody = sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
        echo $htmlBody; die;
  }

  $_SESSION[$tokenSessionKey] = $client->getAccessToken();
  header('Location: index.php');
}
?>
