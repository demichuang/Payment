<?php
require_once("models/Connect.php");
require_once("models/SqlCommand.php");

class SqlCommandTest extends \PHPUnit_Framework_TestCase {

	// 測試檢查是否有此使用者
    public function testCheckUser()
    {
    	$account = "jj";

        $sql = new SqlCommand();
        $num = $sql->checkUser($account);

        $this->assertEquals(1, $num);
    }

	// 測試查詢餘額
    public function testMoneySearch()
    {
    	$account = "jj";

        $sql = new SqlCommand();
        $money = $sql->moneySearch($account);

        $this->assertEquals(2000, $money);
    }

    // 測試查詢明細
    public function testDetailSearch()
    {
    	$account = "jj";
    	$expect = array (0 => array ('id' => "7",
    	                             0 => "7",
    	                             'username' => "jj",
    	                             1 => "jj",
    	                             'action' => "存入",
    	                             2 => "存入",
    	                             'money' => "2000",
    	                             3 => "2000",
    	                             'balance' => "2000",
    	                             4 => "2000",
    	                             'time' => "2016-08-02 05:39:28",
    	                             5 => "2016-08-02 05:39:28" ));
        $sql = new SqlCommand();
        $row = $sql->detailSearch($account);

        $this->assertEquals($expect, $row);
    }
}
