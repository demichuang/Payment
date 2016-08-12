<?php

class SqlCommand extends Connect
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

    // 存提款
    function moneyAction($name, $money)
    {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("SELECT `money` FROM `user` WHERE `username` = :name LOCK IN SHARE MODE");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $initMoney = $stmt->fetchColumn();

            if ($money + $initMoney < 0) {
                throw new Exception("提款失敗，金額不足，帳戶金額：" . $initMoney);
            }

            $sql = "UPDATE `user` SET `money`= `money` + $money WHERE `username` = :name";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            date_default_timezone_set('Asia/Taipei');
            $time = date("Y-m-d H:i:s");
            $moneyAction = $money < 0 ? '匯出' : '存入';
            $action = $money < 0 ? '提款' : '存款';

            $stmt = $this->db->prepare("INSERT `record`(`username`, `action`, `money`, `balance`, `time`)
                VALUES (:name, :moneyAction, :money, :balance + $money, :time)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':moneyAction', $moneyAction);
            $stmt->bindParam(':money', $money);
            $stmt->bindParam(':balance', $initMoney);
            $stmt->bindParam(':time', $time);
            $stmt->execute();
            $msg = $action . "成功，帳戶金額：" . ($initMoney + $money);
            $this->db->commit();
        } catch (Exception $error) {
            $this->db->rollBack();
            $msg = $error->getMessage();
        }

        return $msg;
    }

    // 查詢餘額
    function moneySearch($name)
    {
        $stmt = $this->db->prepare("SELECT `money` FROM `user` WHERE `username` = :name" );
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        return $result;
    }

    // 查詢明細
    function detailSearch($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM `record` WHERE `username` = :name" );
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $row = $stmt->fetchAll();

        return $row;
    }
}
