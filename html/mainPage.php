<? include "html/header.php";?>
<div class="auth container-sm">
    <div class="mt-5">
       <h2>Привет, <? echo $arr['login'] ?>!</h2>
       <div>
           <p>Вот возможность обновить вход по соц. сетям:</p>
           <script src="//ulogin.ru/js/ulogin.js"></script>
           <div id="message" class="alert mb-3" role="alert"></div>
           <div id="uLogin" data-ulogin="display=small;theme=flat;fields=first_name,last_name;providers=vkontakte,odnoklassniki,google,facebook,mailru;hidden=;mobilebuttons=0;callback=preview;"></div>
       </div>
    </div>
</div>
<script>
$("#message").hide(0);



    
function preview(token){
    $.getJSON("//ulogin.ru/token.php?host=" +
        encodeURIComponent(location.toString()) + "&token=" + token + "&callback=?",
    function(data){
        data=$.parseJSON(data.toString());
        $.ajax({
            url: "/ajax?auth=s_upd",
            method: "post",
            data: {
                uid: data.uid,
                f_name: data.first_name,
                l_name: data.last_name,
                network: data.network
            },
            success: function (e){
                if (e == 'success'){
                    $("#message").text('Успешно');
                    $("#message").attr("class", "alert mb-3 alert-success");
                    
                }
                else {
                    $("#message").text(e);
                    $("#message").attr("class", "alert mb-3 alert-danger");
                }
                $('#message').show(1000, function(){
                    setTimeout(function(){
                        $('#message').hide(500);
                    }, 5000);
                });
            }
        })
    });
}
</script>
<? include "html/footer.php";?>