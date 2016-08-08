<?php

$name = $_POST['txtAccountname'];       // 輸入帳戶名
$money = $_POST['txtMoney'];            // 輸入金額
  
$stmt = $db->prepare("SELECT * FROM `user` WHERE `username` = :name");
$stmt->bindParam(':name', $name);
$stmt->execute();
$row=$stmt->fetch();                    // 查詢輸入的帳戶

if (isset($_POST["in"]))                // 點選"存款按鈕"     
{
	$total =$row['money']+$money;           // 金額=帳戶金額+存入金額
	
	$stmt = $db->prepare("UPDATE `user` SET `money`= :total WHERE `username` = :name");
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':name', $name);
    $stmt->execute();                       // 更新帳戶金額
    
    $stmt = $db->prepare("INSERT `record`(`username`,`action`,`moneyaction`)                      
                            VALUES (?,'存入',?)");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $money);
    $stmt->execute();                       // 更新帳戶紀錄 
  
    $msg="存款成功，帳戶金額：".$total;     // 顯示存款成功訊息、帳戶金額 
}


if (isset($_POST["out"]))               // 點選"提款按鈕"          
{
	if($row['money']>=$money)              // 如果帳戶金額>=提款金額
	{
      	$total =$row['money']-$money;           // 金額=帳戶金額-提出金額                                  
      	
      	$stmt = $db->prepare("UPDATE `user` SET `money`= :total WHERE `username` = :name");
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':name', $name);
        $stmt->execute();                       // 更新帳戶金額
        
        $stmt = $db->prepare("INSERT `record`(`username`,`action`,`moneyaction`)                      
                                VALUES (?,'匯出',?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $money);
        $stmt->execute();                       // 更新帳戶紀錄 
        
        $msg="提款成功，帳戶金額：".$total;     // 顯示提款成功訊息、帳戶金額
	}
	else                                   // 如果帳戶金額<提款金額
	    $msg="提款失敗，金額不足，帳戶金額：".$row['money'];   // 顯示提款失敗訊息、帳戶金額 
}


if (isset($_POST["search"]))            // 點選"查詢明細按鈕"      
{
    $stmt = $db->prepare("SELECT * FROM `record` WHERE `username` = :name");
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $row=$stmt->fetchAll();                     //　搜尋資料
      
    $msg="帳戶明細";                            // 顯示帳戶明細
}

?>