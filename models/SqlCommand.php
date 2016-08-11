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

    // 存款
    function moneyDeposit($name, $money)
    {
        try {
            $this->db->beginTransaction();

            if ($money <= 0) {
                throw new Exception("輸入錯誤");
            }

            $sql = "SELECT `money` FROM `user` WHERE `username` = :name LOCK IN SHARE MODE";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $initMoney = $stmt->fetchColumn();

            $sql = "UPDATE `user` SET `money` = `money` + $money WHERE `username` = :name";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            $stmt = $this->db->prepare("INSERT `record`(`username`, `action`, `money`, `balance`, `time`)
                VALUES (:name, '存入', :money, :balance + $money, :time)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':money', $money);
            $stmt->bindParam(':balance', $initMoney);
            $stmt->bindParam(':time', $time);
            $stmt->execute();
            $msg = "存款成功，帳戶金額：" . ($initMoney + $money);
            $this->db->commit();
        } catch (Exception $error) {
            $this->db->rollBack();
            $msg = $error->getMessage();
        }

        return $msg;
    }

    // 提款
    function moneyWithdraw($name, $money)
    {
        try {
            $this->db->beginTransaction();

            if ($money <= 0) {
                throw new Exception("輸入錯誤");
            }

            $stmt = $this->db->prepare("SELECT `money` FROM `user` WHERE `username` = :name LOCK IN SHARE MODE");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $initMoney = $stmt->fetchColumn();

            if ($money > $initMoney) {
                throw new Exception("提款失敗，金額不足，帳戶金額：" . $initMoney);
            }

            $sql = "UPDATE `user` SET `money`= `money` - $money WHERE `username` = :name";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            date_default_timezone_set('Asia/Taipei');
            $time = date("Y-m-d H:i:s");

            $stmt = $this->db->prepare("INSERT `record`(`username`, `action`, `money`, `balance`, `time`)
                VALUES (:name, '匯出', :money, :balance - $money, :time)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':money', $money);
            $stmt->bindParam(':balance', $initMoney);
            $stmt->bindParam(':time', $time);
            $stmt->execute();
            $msg = "提款成功，帳戶金額：" . ($initMoney - $money);
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
