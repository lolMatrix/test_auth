<? include "html/header.php";?>
<div class="auth container-sm">
    <div class="mt-5">
       <h2>Привет, <? echo $arr['login'] ?>!</h2>
       <div>
           <p>Вот возможность обновить вход по соц. сетям:</p>
           <script src="//ulogin.ru/js/ulogin.js"></script>
           <div id="uLogin" data-ulogin="display=small;theme=flat;fields=first_name,last_name;providers=vkontakte,odnoklassniki,google,facebook,mailru;hidden=;mobilebuttons=0;callback=preview;"></div>
       </div>
    </div>
</div>

<? include "html/footer.php";?>