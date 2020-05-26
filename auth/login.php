<? 

if((isset($_GET["auth"]) && $_GET["auth"] === "s_auth") || (isset($_GET["auth"]) && $_GET["auth"] === "s_reg")){
    
    sLogin($_POST['uid'], $_POST['f_name'], $_POST['l_name'], $_POST['network']);
    
}
else if(isset($_GET["auth"]) && $_GET["auth"] === "reg"){
    registration($_POST['login'], md5($_POST['pass']), $_POST["email"]);
}
else if(isset($_GET["exit"])){
    
    if(session_destroy())
        echo 'success';
} else if(isset($_GET["auth"]) && $_GET["auth"] === "s_upd"){
    socialUpdate($_SESSION['id'], $_POST['uid'], $_POST['network']);
}
else{
    if(isset($_SESSION['wrong_count']) && $_SESSION['wrong_count'] >= 3){
        $json = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=" . $_POST['g-recaptcha-response']), true);
        if($json['success'])
            login($_POST['login'], $_POST['pass']);
        else
            echo "Не введенна капча";
    }
    else login($_POST['login'], $_POST['pass']);
}