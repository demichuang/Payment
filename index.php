<?php 
header('Content-type: text/html; charset=utf-8');   //使用萬用字元碼utf-8
require_once("connect_db.php");                     // 連結資料庫bank

$name = $_POST['txtAccountname'];         // 輸入帳戶名
$money = $_POST['txtMoney'];              // 輸入金額
  
$cmd="SELECT * FROM `user` 
      WHERE `username` ='$name'";       
$result=$db->query($cmd);               
$row=$result->fetch();                    // 查詢輸入的帳戶

if (isset($_POST["in"]))                  // 點選"存款按鈕"     
{
	$total =$row['money']+$money;               // 金額=帳戶金額+存入金額                                
	
	$cmd="UPDATE `user` 
	      SET `money`='$total'                      
        WHERE `username` ='$name'";
  $db->query($cmd);                           // 更新帳戶金額
  
  $cmd1="INSERT `record`(`username`,`action`,`moneyaction`)                      
         VALUES ('$name','存入','$money')";
  $db->query($cmd1);                          // 更新帳戶紀錄 
  
  $msg="存款成功，帳戶金額：".$total;         // 顯示存款成功訊息、帳戶金額 
}


if (isset($_POST["out"]))                 // 點選"提款按鈕"          
{
	if($row['money']>=$money)                   // 如果帳戶金額>=提款金額
	{
  	$total =$row['money']-$money;             // 金額=帳戶金額-提出金額                                  
  	
  	$cmd="UPDATE `user` 
  	      SET `money`='$total'                      
          WHERE `username` ='$name'";
    $db->query($cmd);                         // 更新帳戶金額
    
    $cmd1="INSERT `record`(`username`,`action`,`moneyaction`)                      
         VALUES ('$name','匯出','$money')";
    $db->query($cmd1);                          // 更新帳戶紀錄 
    
    $msg="提款成功，帳戶金額：".$total;       // 顯示提款成功訊息、帳戶金額
	}
	else                                        // 如果帳戶金額<提款金額
	  $msg="提款失敗，金額不足，帳戶金額：".$row['money'];   // 顯示提款失敗訊息、帳戶金額 
}


if (isset($_POST["search"]))              // 點選"查詢明細按鈕"      
{
  $cmd="SELECT * FROM `record` 
        WHERE `username` ='$name'";       
  $result=$db->query($cmd);
  $row=$result->fetchAll();                   //　搜尋資料
  
  $msg="帳戶明細";                            // 顯示帳戶明細
}

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
          &nbsp;<button name="search" type="submit">查詢明細</button>  
        </form>
      </div>
    </div>
    &nbsp;&nbsp;
    
    <h4 class="text-center  wowload fadeInUp"><?php echo $msg?><h4>       <!-- 訊息顯示 -->
    
<?php
if (isset($_POST["search"]))
{
  echo "<h4 class='text-center'><table>";
  foreach($row as $values)
  {  
    echo "<tr>
      <td>{$values['action']}</td><td>{$values['moneyaction']}</td>
    </tr>";                                                               // 顯示帳戶明細資料
  }
  echo "</table></h4>";
}
?>

  </div>
</div>

</body>
</html>