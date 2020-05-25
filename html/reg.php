<? include "html/header.php";?>
<div class="auth container-sm">

<form class="mt-5" id="login" action="/ajax?auth=reg" method="post">
   <span id="error"></span>
   <br>
    <lable class="mt-2">Логин</lable>
    <input class="form-control mt-2" required="required" type="text" name="login">
    <lable class="mt-2">E-mail</lable>
    <input class="form-control mt-2" required="required" type="email" name="email">
    <lable class="mt-2">Пароль</lable>
    <input class="form-control mt-2" required="required" type="password" name="pass">
    <lable class="mt-2">Подтверждение пароля</lable>
    <input class="form-control mt-2" required="required" type="password" name="pass_prov">
    <div class="row container">
        <button class="btn btn-outline-primary mt-2 col-4">Регистрация</button>
        <script src="//ulogin.ru/js/ulogin.js"></script>
        <div id="uLogin" class="col-3 mt-2" data-ulogin="display=small;theme=flat;fields=first_name,last_name;providers=vkontakte,odnoklassniki,google,facebook,mailru;hidden=;mobilebuttons=0;callback=preview;"></div>
    </div>
</form>

</div>
<script>
    $("#login").submit(function (result){
        pass = $("#login input[name='pass']").val();
        podt_pass = $("#login input[name='pass_prov']").val();
        if (pass != podt_pass){
            alert("Не совпадают");
        }else{
            $.ajax({
                url: $("#login").attr('action'),
                type: $("#login").attr('method'),
                data: $("#login").serialize(),
                success: success
            });
        }
        return false;
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
function success (e){
    if (e == "success")
        location.href = "/";
    else{
        $("#error").text(e);
        $('#error').show(1000, function(){
            setTimeout(function(){
                $('#error').hide(500);
            }, 5000);
        });
    }
}
</script>
<? include "html/footer.php";?>