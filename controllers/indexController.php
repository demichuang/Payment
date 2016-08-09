<?php

class indexController extends Controller
{
    // 到首頁
    function index()
    {
        $this->view("index","","");
    }

    // 點選"按鈕"
    function getbutton()
    {
        $name = $_POST['txtAccountname'];       // 輸入帳戶名
        $money = $_POST['txtMoney'];            // 輸入金額

        if (isset($_POST["in"])) {
            $msg = $this->model("sqlcommand")->moneyIn($name, $money);
            $this->view("index", $msg, "");
        }

        if (isset($_POST["out"])) {
            $msg = $this->model("sqlcommand")->moneyOut($name, $money);
            $this->view("index", $msg, "");
        }

        if (isset($_POST["searchmoney"])) {
            $msg = $this->model("sqlcommand")->moneySearch($name);
            $this->view("index", $msg, "");
        }

        if (isset($_POST["searchdetail"])) {
            $msg = $this->model("sqlcommand")->detailSearch($name);
            $this->view("index", $msg[0], $msg[1]);
        }
    }

}