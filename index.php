<?php 
header('Content-type: text/html; charset=utf-8');   //使用萬用字元碼utf-8
require_once("connect_db.php");                     // 連結資料庫bank

?>

<!DOCTYPE html>
<html lang="en">
  
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Bank System</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="assets/animate/animate.css" />
<link rel="stylesheet" href="assets/animate/set.css" />
<link rel="stylesheet" href="assets/gallery/blueimp-gallery.min.css">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="assets/style.css">
</head>


<body>
<div class="topbar animated fadeInLeftBig"></div>


<div id="contact" class="mail">
  <div class="container contactform center">
    <h2 class="text-center  wowload fadeInUp">Bank</h2>
    <div class="row wowload fadeInLeftBig">      
      <div class="col-sm-6 col-sm-offset-3 col-xs-12"> 
        <form method="post" action="index.php">
          <input type="text" placeholder="accountname" name="txtAccountname" required>
          <input type="text" placeholder="money" name="txtMoney"  required>
          <button class="btn btn-primary" name="in" type="submit">存款</button>&nbsp;
          &nbsp;<button class="btn btn-primary" name="out" type="submit">提款</button> 
        </form>
      </div>
    </div>
    &nbsp;&nbsp;
   
  </div>
</div>


</body>
</html>