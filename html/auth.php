<? include "html/header.php";?>
<div class="auth container-sm mt-5">
<span id="error"  role="alert"></span>
<form class="mt-3" id="login" action="/ajax" method="post">
    <lable class="mt-2">Логин</lable>
    <input class="form-control mt-2" required="required" type="text" name="login">
    <lable class="mt-2">Пароль</lable>
    <input class="form-control mt-2" required="required" type="password" name="pass">
    <div class="row container">
        <button class="btn btn-outline-primary mt-2 col-3">Войти</button>
        
        <script src="//ulogin.ru/js/ulogin.js"></script>
        <div id="uLogin" class="col-3 mt-2" data-ulogin="display=small;theme=flat;fields=first_name,last_name;providers=vkontakte,odnoklassniki,google,facebook,mailru;hidden=;mobilebuttons=0;callback=preview;"></div>
        <div class="col-3 pt-3">
            <a href="/reg" >Регистрация</a>
        </div>
    </div>
    <div id="capt" class="g-recaptcha mt-3" data-sitekey="<? echo $publicKey; ?>"></div>
</form>

</div>
<script>
    
    $("#error").hide(0);
    <? if (!isset($_SESSION["wrong_count"]) || $_SESSION["wrong_count"] < 3) { ?>
        $(".g-recaptcha").hide(0); 
    <? } ?>
    $("#login").ajaxForm(function(result){
        if(result == 'success'){
            location.reload();
        } else if(result == "captcha"){
            $(".g-recaptcha").show(0);
            $("#error").text("Введите капчу");
            $("#error").attr("class", "alert mb-3 alert-warning");
            $('#error').show(1000, function(){
                setTimeout(function(){
                    $('#error').hide(500);
                }, 5000);
            });
        }
        else{
            grecaptcha.reset();
            $("#error").text(result);
            $("#error").attr("class", "alert mb-3 alert-danger");
            $('#error').show(1000, function(){
                setTimeout(function(){
                    $('#error').hide(500);
                }, 5000);
            });
        }
    });
    
    function preview(token){
    $.getJSON("//ulogin.ru/token.php?host=" +
        encodeURIComponent(location.toString()) + "&token=" + token + "&callback=?",
    function(data){
        data=$.parseJSON(data.toString());
        $.ajax({
            url: "/ajax?auth=s_reg",
            method: "post",
            data: {
                uid: data.uid,
                f_name: data.first_name,
                l_name: data.last_name,
                network: data.network
            },
            success: function (e){
                if (e == "success")
                    location.href = "/";
                else
                    console.log(e);
        }
        })
    });
}
</script>
<? include "html/footer.php";?>