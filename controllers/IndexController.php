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

        if (!$num) {
            $this->view("index", "查無此帳戶");
        }

        if (isset($_POST["in"])) {
            if ($money <= 0) {
                $this->view("index", "輸入錯誤");
                exit();
            }

            $msg = $this->model("SqlCommand")->moneyAction($name, $money);
            $this->view("index", $msg);
        }

        if (isset($_POST["out"])) {
            if ($money <= 0) {
                $this->view("index", "輸入錯誤");
                exit();
            }

            $msg = $this->model("SqlCommand")->moneyAction($name, - $money);
            $this->view("index", $msg);
        }

        if (isset($_POST["searchMoney"])) {
            $result = $this->model("SqlCommand")->moneySearch($name);
            $this->view("index", "帳戶餘額:" . $result);
        }

        if (isset($_POST["searchDetail"])) {
            $row = $this->model("SqlCommand")->detailSearch($name);
            $this->view("index", "帳戶明細", $row);
        }
    }
}
