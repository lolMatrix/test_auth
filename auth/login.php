<? 

if((isset($_GET["auth"]) && $_GET["auth"] === "s_auth") || (isset($_GET["auth"]) && $_GET["auth"] === "s_reg")){
    
    sLogin($_POST['uid'], $_POST['f_name'], $_POST['l_name'], $_POST['network']);
    
}
else if(isset($_GET["auth"]) && $_GET["auth"] === "reg"){
    registration($_POST['login'], $_POST['pass'], $_POST["email"]);
}
else if(isset($_GET["exit"])){
    
    if(session_destroy())
        echo 'success';
}
else{
    login($_POST['login'], $_POST['pass']);
}