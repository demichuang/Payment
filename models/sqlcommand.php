<?php

class sqlcommand extends connect_db
{
    // 檢查是否有此使用者
    function checkUser($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM `user` WHERE `username` = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $num = $stmt->rowCount();

        return $num;
    }

    // 點選"存款按鈕"
    function moneyIn($name, $money)
    {
        $this->db->beginTransaction();
        $sql = "SELECT * FROM `user` WHERE `username` = :name FOR UPDATE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $row = $stmt->fetch();
        sleep(5);

        $total = $row['money'] + $money;          // 金額 = 帳戶金額 + 存入金額

        $sql = "UPDATE `user` SET `money` = :total WHERE `username` = :name";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':name', $name);
        $stmt->execute();                         // 更新帳戶金額

        $stmt = $this->db->prepare(
            "INSERT `record`(`username`, `action`, `money`, `balance`) VALUES (:name, '存入', :money, :balance)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':money', $money);
        $stmt->bindParam(':balance', $total);
        $stmt->execute();                         // 更新帳戶紀錄
        $msg = "存款成功，帳戶金額：" . $total;   // 顯示存款成功訊息、帳戶金額
        $this->db->commit();

        return $msg;
    }

    // 點選"提款按鈕"
    function moneyOut($name, $money)
    {
        $this->db->beginTransaction();
        $stmt = $this->db->prepare("SELECT * FROM `user` WHERE `username` = :name FOR UPDATE");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $row = $stmt->fetch();
        sleep(5);

        if ($row['money'] >= $money) {             // 如果帳戶金額 >= 提款金額
            $total = $row['money'] - $money;       // 金額 = 帳戶金額 - 提出金額

            $stmt = $this->db->prepare("UPDATE `user` SET `money`= :total WHERE `username` = :name");
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':name', $name);
            $stmt->execute();                      // 更新帳戶金額

            $stmt = $this->db->prepare(
                "INSERT `record`(`username`, `action`, `money`, `balance`)  VALUES (:name, '匯出', :money, :balance)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':money', $money);
            $stmt->bindParam(':balance', $total);
            $stmt->execute();                      // 更新帳戶紀錄
            $msg = "提款成功，帳戶金額：" . $total;// 顯示提款成功訊息、帳戶金額
        } else {                                     // 如果帳戶金額 < 提款金額
            $msg = "提款失敗，金額不足，帳戶金額：" . $row['money'];    // 顯示提款失敗訊息、帳戶金額
        }

        $this->db->commit();

        return $msg;
    }

    // 點選"查詢餘額按鈕"
    function moneySearch($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM `user` WHERE `username` = :name" );
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $row = $stmt->fetch();                     // 搜尋資料
        $msg = "帳戶餘額:" . $row['money'];        // 顯示帳戶餘額

        return $msg;
    }

    // 點選"查詢明細按鈕"
    function detailSearch($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM `record` WHERE `username` = :name" );
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $row = $stmt->fetchAll();                   // 搜尋資料
        $msg = "帳戶明細";                          // 顯示帳戶明細

        return [$msg,$row];
    }

}