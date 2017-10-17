<?php
require '../vendor/autoload.php';
include('../config.php');
date_default_timezone_set("Asia/Bangkok");
$sql = "SELECT video_id, privacy_status, history FROM tracking_videos";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $videoId = $row['video_id'];
      $history = $row['history'];
      $youtube = new Madcoda\Youtube\Youtube(array('key' => GOOGLE_API_KEY));
      $video = $youtube->getVideoInfo($videoId);
      $privacyStatus = $video->status->privacyStatus;
      if($privacyStatus != $row['privacy_status']) {
           $history .= date('Y/m/d h:i:s a', time()) . "=>" . $privacyStatus . "<br />";
          echo $history;
          $updateSql = "UPDATE tracking_videos SET privacy_status = '$privacyStatus', history = '$history' WHERE video_id='$videoId'";
          if ($db->query($updateSql) == TRUE) {

          } else {
              echo "Error: " . $updateSql . "<br>" . $db->error;
              die;
          }
      }
    }
}



$db->close();

?>
