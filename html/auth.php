<? include "html/header.php";?>
<div class="auth container-sm">

<form class="mt-5" id="login" action="/ajax" method="post">
   <span id="error"></span>
   <br>
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
</form>

</div>
<script>
    
    $("#error").hide(0);
    
    $("#login").ajaxForm(function(result){
        if(result == 'success'){
            location.reload();
        }
        else{
            $("#error").text(result);
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