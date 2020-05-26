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
        if (isset($_SESSION["wrong_count"])){
            $_SESSION["wrong_count"]++;
        }else{
            $_SESSION["wrong_count"] = 1;
        }
        if($_SESSION["wrong_count"] == 3)
            exit("captcha");
        echo "Такого аккаунта не существует";
    }
    else if(md5($pass) !== $arr["pass"]){
        if (isset($_SESSION["wrong_count"])){
            $_SESSION["wrong_count"]++;
        }else{
            $_SESSION["wrong_count"] = 1;
        }
        
        if($_SESSION["wrong_count"] == 3)
            exit("captcha");

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
function socialUpdate($id, $uid, $network){
    global $login_db, $password_db, $host, $bd;
    $connect = mysqli_connect($host, $login_db, $password_db,  $bd);

    $query = "SELECT * FROM social WHERE $network = '$uid' AND id != '$id'";
    $result = mysqli_query($connect, $query);
    $arr = mysqli_fetch_array($result);
    
    if($arr != null){
        $query = "DELETE FROM social WHERE id = '".$arr['id']."'";
        $result = mysqli_query($connect, $query);
        $query = "DELETE FROM users WHERE id = '".$arr['id']."'";
        $result = mysqli_query($connect, $query);
    }
    
    
    
    $query = "SELECT * FROM users INNER JOIN social ON users.id = social.id WHERE social.id = '$id'";
    
    $result = mysqli_query($connect, $query);
    $arr = mysqli_fetch_array($result);
    
    
    if($arr == null){
        $query = "INSERT INTO social (`id`, `$network`) VALUES ('$id', '$uid')";
        $result = mysqli_query($connect, $query);
        echo "success";
    }else{
        $query = "UPDATE social SET $network = '$uid' WHERE id = '$id'";
        $result = mysqli_query($connect, $query);
        echo "success";
    }
    
    mysqli_close($connect);
}