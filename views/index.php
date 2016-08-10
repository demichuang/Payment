<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Life is Travel</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="/Payment/views/assets/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/Payment/views/assets/animate/animate.css" />
<link rel="stylesheet" href="/Payment/views/assets/animate/set.css" />
<link rel="stylesheet" href="/Payment/views/assets/gallery/blueimp-gallery.min.css">
<link rel="shortcut icon" href="/Payment/views/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="/Payment/views/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/Payment/views/assets/style.css">
</head>

<body>
<div class="topbar animated fadeInLeftBig"></div>
  <div id="contact" class="mail">
    <div class="container contactform center">
      <h2 class="text-center  wowload fadeInUp">Bank</h2>
      <div class="row wowload fadeInLeftBig">
        <div class="col-sm-6 col-sm-offset-3 col-xs-12">
          <form method="post" action="/Payment/Index/getButton">
            <input type="text" placeholder="accountname" name="txtAccountname" required>
            <input type="text" placeholder="money" name="txtMoney">
            <button class="btn btn-primary" name="in" type="submit">存款</button>&nbsp;
            &nbsp;<button class="btn btn-primary" name="out" type="submit">提款</button>&nbsp;
            &nbsp;<button name="searchmoney" type="submit">查詢餘額</button>&nbsp;
            &nbsp;<button name="searchdetail" type="submit">查詢明細</button>
          </form>
        </div>
      </div>
      &nbsp;&nbsp;
      <?php
      if (!empty($data)) {
          echo "<h4 class='text-center  wowload fadeInUp'>$data<h4>";       // 訊息顯示
      }

      if (!empty($data2)) {
          echo "<h4 class='text-center'><table>";
          foreach ($data2 as $values) {
              echo "<tr> <td> {$values['action']}: </td>
                         <td> {$values['money']} </td>
                         <td> ( 餘額 : </td>
                         <td> {$values['balance']}) </td> </tr>";          // 顯示帳戶明細資料
          }
          echo "</table></h4>";
      }
      ?>
  </div>
</div>
</body>
</html>