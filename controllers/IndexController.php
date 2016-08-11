<?php

class IndexController extends Controller
{
    // 轉入首頁
    public function index()
    {
        $this->view("index");
    }

    // 點選"按鈕"
    public function getButton()
    {
        $name = $_POST['txtAccountname'];
        $money = $_POST['txtMoney'];

        $num = $this->model("SqlCommand")->checkUser($name);

        if ($num == 1) {
            if (isset($_POST["in"]) && $money > 0) {
                $msg = $this->model("SqlCommand")->moneyDeposit($name, $money);
                $this->view("index", $msg);
            }

            if (isset($_POST["out"]) && $money > 0) {
                $msg = $this->model("SqlCommand")->moneyWithdraw($name, $money);
                $this->view("index", $msg);
            }

            if (isset($_POST["searchMoney"])) {
                $msg = $this->model("SqlCommand")->moneySearch($name);
                $this->view("index", $msg);
            }

            if (isset($_POST["searchDetail"])) {
                $msg = $this->model("SqlCommand")->detailSearch($name);
                $this->view("index", $msg[0], $msg[1]);
            } else {
                $this->view("index", "輸入錯誤");
            }
        } else {
            $this->view("index", "查無此帳戶");
        }
    }
}
