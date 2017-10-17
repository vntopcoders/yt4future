<?php
  require 'vendor/autoload.php';
  include('session.php');
  $errVideoId = "";
  $errBrand = "";
  $result='';
	if (isset($_POST["submit"])) {
		$channelId = mysqli_real_escape_string($db, $_POST['channel_id']);
    $channelName = mysqli_real_escape_string($db, $_POST['channel_name']);
    $brand = mysqli_real_escape_string($db, $_POST['brand']);
    $youtube = new Madcoda\Youtube\Youtube(array('key' => GOOGLE_API_KEY));
    // Return a std PHP object
    $channel = $youtube->getChannelById($channelId);
    $channelTitle = $channel->snippet->title;
    $sql = "INSERT INTO channels (channel_id, channel_name, channel_title, brand) VALUES ('$channelId', '$channelName', '$channelTitle', '$brand')";
     if ($db->query($sql) === TRUE) {
         echo "New record created successfully";
     } else {
         echo "Error: " . $sql . "<br>" . $db->error;
     }
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
  				<h1 class="page-header text-center">Add new Channel</h1>
				<form class="form-horizontal" role="form" method="post" action="add.php">
					<div class="form-group">
						<label for="channel_id" class="col-sm-2 control-label">Channel ID</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="channel_id" name="channel_id" placeholder="channel id" value="">
						</div>
					</div>
          <div class="form-group">
						<label for="brand" class="col-sm-2 control-label">Channel Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="channel_name" name="channel_name" value="">
						</div>
					</div>
          <div class="form-group">
						<label for="brand" class="col-sm-2 control-label">Brand</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="brand" name="brand" placeholder="foxtv" value="">
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
