<?php
include "db_settings.php";
function login($login, $pass){
    global $login_db, $password_db, $host, $bd;
    $connect = mysqli_connect($host, $login_db, $password_db,  $bd);
    
    $query = "SELECT * FROM users WHERE `login` = '$login'";
    $result = mysqli_query($connect, $query);
    $arr = mysqli_fetch_array($result);
    
    
    mysqli_close($connect);
    
    if($arr == null){
        echo "Такого аккаунта не существует";
    }
    else if(md5($pass) !== $arr["pass"]){
        echo "Неправильный логин или пароль";
    }else{
        $_SESSION["id"] = $arr["id"];
        echo "success";
        
    }
    
}

function registration($login, $pass, $email){
    global $login_db, $password_db, $host, $bd;
    $connect = mysqli_connect($host, $login_db, $password_db,  $bd);
    
    $query = "SELECT * FROM users WHERE `login` = '$login' OR `email` = '$email'";
    $result = mysqli_query($connect, $query);
    $arr = mysqli_fetch_array($result);
    
    if($arr == null)
    {
        
        $query = "INSERT INTO users (`login`, `pass`, `email`) VALUES ('$login', '$pass', '$email')";
        $result = mysqli_query($connect, $query);
        if(!$result){
            echo "Ошибка: не удалось создать пользователя";
        }
        else{
            echo "success";
        }
        
    }
    else
    {
        echo "Такой пользователь уже существует";
    }
    
    mysqli_close($connect);
    
}

function sLogin($uid, $f_name, $l_name, $network){
    global $login_db, $password_db, $host, $bd;
    $connect = mysqli_connect($host, $login_db, $password_db,  $bd);
    
    $query = "SELECT * FROM social WHERE `$network` = '$uid'";
    $result = mysqli_query($connect, $query);
    $arr = mysqli_fetch_array($result);
    
    if($arr == null){
        
        $pass = md5($uid);
        
        $query = "INSERT INTO users (`login`, `pass`) VALUES ('$f_name $l_name', '$pass')";
        $result = mysqli_query($connect, $query);
        if(!$result){
            echo "Ошибка: не удалось создать пользователя";
            exit();
        }
        
        $query = "SELECT `id` FROM users WHERE `login` = '$f_name $l_name'";
        $result = mysqli_query($connect, $query);
        $arr = mysqli_fetch_array($result);
        
        $id = $arr['id'];
        $_SESSION['id'] = $id;
        
        $query = "INSERT INTO social (`id`, `$network`) VALUES ('$id', '$uid')";
        $result = mysqli_query($connect, $query);
        echo 'success';
    }
    else{
        $_SESSION['id'] = $arr['id'];
        echo 'success';
    }
    
    mysqli_close($connect);
    
}

function getInform($id){
    global $login_db, $password_db, $host, $bd;
    $connect = mysqli_connect($host, $login_db, $password_db,  $bd);
    
    $query = "SELECT * FROM users INNER JOIN social ON users.id = social.id WHERE users.id = '$id'";
    
    $result = mysqli_query($connect, $query);
    $arr = mysqli_fetch_array($result);
    
    mysqli_close($connect);
    return $arr;
    
}