<?php

class indexController extends Controller
{
    // 到首頁
    public function index()
    {
        $this->view("index", "", "");
    }

    // 點選"按鈕"
    public function getbutton()
    {
        $name = $_POST['txtAccountname'];       // 輸入帳戶名
        $money = $_POST['txtMoney'];            // 輸入金額

        $num = $this->model("sqlcommand")->checkUser($name);

        if ($num == 1) {
            if (isset($_POST["in"]) && $money > 0) {   // 點選"存款按鈕"
                $msg = $this->model("sqlcommand")->moneyDeposit($name, $money);
                $this->view("index", $msg, "");
            } else {
                $this->view("index", "輸入錯誤", "");
            }

            if (isset($_POST["out"]) && $money > 0) {  // 點選"提款按鈕"
                $msg = $this->model("sqlcommand")->moneyWithdraw($name, $money);
                $this->view("index", $msg, "");
            } else {
                $this->view("index", "輸入錯誤", "");
            }

            if (isset($_POST["searchmoney"])) {        // 點選"查詢餘額按鈕"
                $msg = $this->model("sqlcommand")->moneySearch($name);
                $this->view("index", $msg, "");
            }

            if (isset($_POST["searchdetail"])) {       // 點選"查詢明細按鈕"
                $msg = $this->model("sqlcommand")->detailSearch($name);
                $this->view("index", $msg[0], $msg[1]);
            }
        } else {
            $this->view("index", "查無此帳戶", "");
        }
    }

}