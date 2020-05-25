<?php 
include_once "db_func.php";
session_start();
$path = $_SERVER["REDIRECT_URL"];            
switch($path){
    case "/":
        include "main.php";
    break;
    case "/reg":
        include "reg.php";
    break;
    case "/ajax":
        include "auth/login.php";
    break;
}