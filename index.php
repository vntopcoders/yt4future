<?php
require 'vendor/autoload.php';
include('session.php');
date_default_timezone_set("Asia/Bangkok");
$sql = "SELECT * FROM channels";
$result = $db->query($sql);


$db->close();

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

<style>
.trash { color:rgb(209, 91, 71); }
.flag { color:rgb(248, 148, 6); }
.panel-body { padding:0px; }
.panel-footer .pagination { margin: 0; }
.panel .glyphicon,.list-group-item .glyphicon { margin-right:5px; }
.panel-body .radio, .checkbox { display:inline-block;margin:0px; }
.panel-body input[type=checkbox]:checked + label { text-decoration: line-through;color: rgb(128, 144, 160); }
.list-group-item:hover, a.list-group-item:focus {text-decoration: none;background-color: rgb(245, 245, 245);}
.list-group { margin-bottom:0px; }
</style>
</head>
<body>
 <div class="container">
     <div class="row">
         <div class="">
             <div class="panel panel-primary">
                 <div class="panel-heading">
                     <span class="glyphicon glyphicon-list"></span>Channels List
                 </div>

                 <?php
                 if ($result->num_rows > 0) {

                 ?>
                 <div class="panel-body">
                     <ul class="list-group">
                       <?php
                       while($row = $result->fetch_assoc()) {
                       ?>
                         <li class="list-group-item">
                             <div class="checkbox">
                                  <label for="checkbox">
                                     <?php
                                      echo $row['channel_title'] . "(" . $row['channel_name'] . ")";
                                     ?>
                                 </label>
                             </div>
                             <div class="pull-right action-buttons">
                                 <a href="token.php?channel_id=<?php echo $row['channel_id'] . "&status=public" ?>"><span class="glyphicon glyphicon-play"></span></a>
                                 <a href="token.php?channel_id=<?php echo $row['channel_id'] . "&status=private" ?>" class="trash"><span class="glyphicon glyphicon-lock"></span></a>
                                 <a href="token.php?channel_id=<?php echo $row['channel_id'] . "&status=unlisted" ?>" class="flag"><span class="glyphicon glyphicon-pause"></span></a>
                             </div>
                         </li>
                         <?php
                       }
                       ?>
                     </ul>
                 </div>
                 <?php

                }
                ?>
                 <div class="panel-footer">
                     <div class="row">
                         <div class="col-md-6">
                             <h6>
                                 Total Count <span class="label label-info">25</span></h6>
                         </div>
                         <div class="col-md-6">
                             <ul class="pagination pagination-sm pull-right">
                                 <li class="disabled"><a href="javascript:void(0)">«</a></li>
                                 <li class="active"><a href="javascript:void(0)">1 <span class="sr-only">(current)</span></a></li>
                                 <li><a href="http://www.jquery2dotnet.com">2</a></li>
                                 <li><a href="http://www.jquery2dotnet.com">3</a></li>
                                 <li><a href="http://www.jquery2dotnet.com">4</a></li>
                                 <li><a href="http://www.jquery2dotnet.com">5</a></li>
                                 <li><a href="javascript:void(0)">»</a></li>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
