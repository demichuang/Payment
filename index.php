<?php 
header('Content-type: text/html; charset=utf-8');   // 使用萬用字元碼utf-8
require_once("sqlcommand.php");                     // 引入有sql指令頁面

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
          <input type="text" placeholder="money" name="txtMoney">
          <button class="btn btn-primary" name="in" type="submit">存款</button>&nbsp;
          &nbsp;<button class="btn btn-primary" name="out" type="submit">提款</button>&nbsp;
          &nbsp;<button name="searchmoney" type="submit">查詢餘額</button>&nbsp;
          &nbsp;<button name="search" type="submit">查詢明細</button>  
        </form>
      </div>
    </div>
    &nbsp;&nbsp;
    
    <h4 class="text-center  wowload fadeInUp"><?php echo $msg?><h4>       <!-- 訊息顯示 -->

    <?php
    if (isset($_POST["search"])) {
        echo "<h4 class='text-center'><table>";
        foreach ($row as $values) {  
            echo "<tr><td>{$values['action']}</td><td>{$values['moneyaction']}</td></tr>"; // 顯示帳戶明細資料                                                               
        }
        echo "</table></h4>";
    }

    ?>

  </div>
</div>

</body>
</html>