<?php
/*


    $recaptcha=$_POST['g-recaptcha-response'];
    if(!empty($recaptcha))
    {
        include("../PLUGIN/recaptcha/getCurlData.php");
        $google_url="https://www.google.com/recaptcha/api/siteverify";
        $secret='6Le1LxMUAAAAAAbP7Quy_bJZOIv6wa7k1EccNZkY';
        $ip=$_SERVER['REMOTE_ADDR'];
        $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
        $res=getCurlData($url);
        $res= json_decode($res, true);
        //reCaptcha введена
        if($res['success'])
        {
            // Продолжаем проверку данных формы
        }
        else
        {
            $errorR="Не прошли проверку - я не робот";
	    $error[3]='captcha_o';
	    $r_er=1;
        }

    }
    else
    {
           $errorR="Не прошли проверку - я не робот";
	    $error[3]='captcha_o';
	    $r_er=1;
    }

*/




function reset_url($url) {
    $value = str_replace ( "http://", "", $url );
    $value = str_replace ( "https://", "", $value );
    $value = str_replace ( "www.", "", $value );
    $value = explode ( "/", $value );
    $value = reset ( $value );
    return $value;
}

$_SERVER['HTTP_REFERER'] = reset_url ( $_SERVER['HTTP_REFERER'] );
$_SERVER['HTTP_HOST'] = reset_url ( $_SERVER['HTTP_HOST'] );
 
 
 
 
 
if ($_SERVER['HTTP_HOST'] != $_SERVER['HTTP_REFERER']) {

    // @header ( 'Location: ' . $config['http_home_url'] );
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
    die ();
}
     
     
 
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    /* значит ajax-запрос */
     
    /* обрабатываем */
     
} else {

	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
}

//Проверяем вдруг это взлом. смотрим есть ли такой тип, относятся ли эти условия поиска к этому типу, существует ли сортировка


define( '_SECRETJ', 7 );
session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
//подключение к базе
include_once $url_system.'module/config.php';
//подключение написанных функций для сайта
include_once $url_system.'module/function.php';


setcookie("tsl","0", time()+3600, "/", $base_cookie, false, false); //на год
    
	 unset($_SESSION['user_id']);
	 unset($_SESSION['da']);

     session_unset();
     session_destroy(); 
	 
?>

<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

            <?
            echo'<h1 class="h111 gloab-cc js-form2"><span>Вход в систему**</span><span class="clock_table"></span></h1></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

            echo'<div class="na-100">

<form class="js-form-login-x" id="pod_form" style=" padding:0; margin:0;" action="login/?next='.base64_encode($_GET["url"]).'" method="post" enctype="multipart/form-data">';
            if(!isset($_COOKIE["lis"])) {

                echo '<!--input start-->';
                echo '<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Логин</i><span>*</span></label><input id="email_formi" name="email" value="" class="input_new_2021 gloab required  no_upperr " style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
                echo '<!--input end	-->';
            } else
            {
                echo '<!--input start-->';
                echo '<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Логин</i><span>*</span></label><input id="email_formi" name="email" value="'.$_COOKIE["lis"].'" class="input_new_2021 gloab required  no_upperr " style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
                echo '<!--input end	-->';
            }


            /*
                       echo'<div class="input-width"><div class="width-setter"><input name="number_r" id="number_r" placeholder="Номер раздела" class="input_f_1 input_100 white_inp count_mask_cel" autocomplete="off" type="text"></div></div>';
            */

            //номер раздела по умолчанию макс+1
            //если ввел и такой уже есть подсвечивать красным поле

            echo '<!--input start-->';
            echo '<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Логин</i><span>*</span></label><input id="password_formi" name="password" value="" class="input_new_2021 gloab required  no_upperr " style="padding-right: 100px;" autocomplete="off" type="password"><div class="div_new_2021"></div></div></div>';
            echo '<!--input end	-->';


            ?>


            </span>
            <input type=hidden name="ref" value="00">
            </form>
        </div>
    </div>
    <div class="button-50">
        <div class="na-50">
            <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
        </div>
        <div class="na-50"><div   class="save_button js-login-login"><i>Войти</i></div></div>
    </div>

    <!--
     <div class="over">
    <div id="yes_ra" class="save_button"><i>добавить</i></div></div>
    -->
</div>
<input type=hidden name="ref" value="00">
</form>
</span></div>

</div>
<?



$no_script=1;
include_once $url_system.'template/form_js.php';
?>
<script type="text/javascript">
    $(function() {
        initializeTimer();
        initializeFormsJs();
    });
</script>
<?
//include_once $url_system.'template/form_js.php';
?>
<script type="text/javascript">
    var TimerScript = setInterval(LoadFFo, 200);

    function ScriptForms(){
        console.log("yes start code end");

        ToolTip();
        input_2021();


        if($('#email_formi').val()=='') {  $('#email_formi').focus();  } else { $('#password_formi').focus();  }



        //кнопка войти
        $('.js-box-modal-two').on("change keyup input click",'.js-login-login',js_login_login);
    }

</script>
