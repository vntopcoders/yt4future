<?php
  require '../vendor/autoload.php';
  include('../session.php');
  $errVideoId = "";
  $errBrand = "";
  $result='';
	if (isset($_POST["submit"])) {
		$video_id = mysqli_real_escape_string($db, $_POST['video_id']);
    $brand = mysqli_real_escape_string($db, $_POST['brand']);

    $youtube = new Madcoda\Youtube\Youtube(array('key' => GOOGLE_API_KEY));
    $video = $youtube->getVideoInfo($video_id);
    $channelId = $video->snippet->channelId;
    $channelTitle = $video->snippet->channelTitle;
    $title = $video->snippet->title;
    $privacy_status = $video->status->privacyStatus;
    $sql = "INSERT INTO tracking_videos (video_id, title, channel_id, channel_title, privacy_status, brand, created_at)
     VALUES ('$video_id', '$title', '$channelId', '$channelTitle', '$privacy_status', '$brand', NOW());";

     if ($db->query($sql) === TRUE) {
         echo "New record created successfully";
     } else {
         echo "Error: " . $sql . "<br>" . $db->error;
     }
		// $email = $_POST['email'];
		// $message = $_POST['message'];
		// $human = intval($_POST['human']);
		// $from = 'Demo Contact Form';
		// $to = 'example@domain.com';
		// $subject = 'Message from Contact Demo ';
    //
		// $body ="From: $name\n E-Mail: $email\n Message:\n $message";
    //
		// // Check if name has been entered
		// if (!$_POST['name']) {
		// 	$errName = 'Please enter your name';
		// }
    //
		// // Check if email has been entered and is valid
		// if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		// 	$errEmail = 'Please enter a valid email address';
		// }
    //
		// //Check if message has been entered
		// if (!$_POST['message']) {
		// 	$errMessage = 'Please enter your message';
		// }
		// //Check if simple anti-bot test is correct
		// if ($human !== 5) {
		// 	$errHuman = 'Your anti-spam is incorrect';
		// }


    // If there are no errors, send the email
    // if (!$errName && !$errEmail && !$errMessage && !$errHuman) {
    // 	if (mail ($to, $subject, $body, $from)) {
    // 		$result='<div class="alert alert-success">Thank You! I will be in touch</div>';
    // 	} else {
    // 		$result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
    // 	}
    // }
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap contact form with PHP example by BootstrapBay.com.">
    <meta name="author" content="BootstrapBay.com">
    <title>Youtube Management System - Add new video to tracking</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
  </head>
  <body>
  	<div class="container">
  		<div class="row">
  			<div class="col-md-6 col-md-offset-3">
  				<h1 class="page-header text-center">Add new Video to Tracking</h1>
				<form class="form-horizontal" role="form" method="post" action="add.php">
					<div class="form-group">
						<label for="video_id" class="col-sm-2 control-label">Video ID</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="video_id" name="video_id" placeholder="video id" value="">
							<?php echo "<p class='text-danger'>$errVideoId</p>";?>
						</div>
					</div>
					<div class="form-group">
						<label for="brand" class="col-sm-2 control-label">Brand</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="brand" name="brand" placeholder="foxtv" value="">
							<?php echo "<p class='text-danger'>$errBrand</p>";?>
						</div>
					</div>
					<!--div class="form-group">
						<label for="message" class="col-sm-2 control-label">Message</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="4" name="message"><?php echo htmlspecialchars($_POST['message']);?></textarea>
							<?php echo "<p class='text-danger'>$errMessage</p>";?>
						</div>
					</div-->
          <div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<input id="submit" name="submit" type="submit" value="Add" class="btn btn-primary">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
