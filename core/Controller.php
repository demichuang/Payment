<?php

class Controller
{
    public function model($model)
    {
        require_once "../Payment/models/$model.php";

        return new $model ();
    }

    public function view($view, $data = Array(),$data2 = Array(),$data3 = Array(),$data4 = Array())
    {
        require_once "../Payment/views/$view.php";
    }

}