<?php 
include_once "db_func.php";
$secretKey = "6LdVJvwUAAAAAPGsSFjtvbhOreFCqPM37JNdISHE";
$publicKey = "6LdVJvwUAAAAABzmUmYFiOO4edS4MJxabwhf6lCw";
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