<?php

session_start();

header('Content-type: text/html; charset = utf-8');   //使用萬用字元碼utf-8

require_once 'models/Connect.php';
require_once 'core/App.php';
require_once 'core/Controller.php';

$app = new App();