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
            $sql = "SELECT * FROM `user` WHERE `username` = :name FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $row = $stmt->fetch();

            $sql = "UPDATE `user` SET `money` = :initMoney + $money WHERE `username` = :name";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':initMoney', $row['money']);
            $stmt->bindParam(':name', $name);
            $stmt->execute();                            // 更新帳戶金額

            $stmt = $this->db->prepare("INSERT `record`(`username`, `action`, `money`, `balance`)
                VALUES (:name, '存入', :money, :balance + $money)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':money', $money);
            $stmt->bindParam(':balance', $row['money']);
            $stmt->execute();                            // 更新帳戶紀錄
            $msg = "存款成功，帳戶金額：" . ($row['money'] + $money);   // 顯示存款成功訊息、帳戶金額

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
            $stmt = $this->db->prepare("SELECT * FROM `user` WHERE `username` = :name FOR UPDATE");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $row = $stmt->fetch();

                if ($row['money'] >= $money) {             // 如果帳戶金額 >= 提款金額
                    $sql = "UPDATE `user` SET `money`= :initMoney - $money WHERE `username` = :name";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(':initMoney', $row['money']);
                    $stmt->bindParam(':name', $name);
                    $stmt->execute();                      // 更新帳戶金額

                    $stmt = $this->db->prepare("INSERT `record`(`username`, `action`, `money`, `balance`)
                        VALUES (:name, '匯出', :money, :balance - $money)");
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':money', $money);
                    $stmt->bindParam(':balance', $row['money']);
                    $stmt->execute();                      // 更新帳戶紀錄
                    $msg = "提款成功，帳戶金額：" . ($row['money'] - $money);
                } else {                                   // 如果帳戶金額 < 提款金額
                    $msg = "提款失敗，金額不足，帳戶金額：" . $row['money'];
                }

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
        $stmt = $this->db->prepare("SELECT * FROM `user` WHERE `username` = :name" );
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $row = $stmt->fetch();                     // 搜尋資料
        $msg = "帳戶餘額:" . $row['money'];

        return $msg;
    }

    // 查詢明細
    function detailSearch($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM `record` WHERE `username` = :name" );
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $row = $stmt->fetchAll();                   // 搜尋資料
        $msg = "帳戶明細";

        return [$msg, $row];
    }

}