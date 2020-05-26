<?php
if (isset($_SESSION["id"])){
    header("Location: /");
}else{
    include "html/reg.php";
}