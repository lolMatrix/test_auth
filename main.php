<?php
if (isset($_SESSION["id"])){
    $arr = getInform($_SESSION['id']);
    include "html/mainPage.php";
}else{
    include "html/auth.php";
}