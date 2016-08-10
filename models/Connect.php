<?php

class Connect
{
    public $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=127.0.0.1;dbname=bank;charset=utf8', 'root', '');
    }

}
