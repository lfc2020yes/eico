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


setcookie("tsl","0", time()+3600, "/", "eico.atsun.ru", false, false); //на год
    
	 unset($_SESSION['user_id']);
	 unset($_SESSION['da']);

     session_unset();
     session_destroy(); 
	 
?>
			
			<div id="Modal-one" class="box-modal table-modal"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			

			   <h1>Вход в систему**</h1>


			
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'<form  id="pod_form" style=" padding:0; margin:0;" class="form-fiz" action="login/?next='.base64_encode($_GET["url"]).'" method="post" enctype="multipart/form-data">';
			
			if(!isset($_COOKIE["lis"]))
          {	
			
	

			echo'<div class="input-width"><div class="width-setter"><input name="email" id="email_formi" placeholder="Логин" class="input_f_1 input_100" autocomplete="off" type="text"></div></div>';
		  } else
		  {
			echo'<div class="input-width"><div class="width-setter"><input name="email" value="'.$_COOKIE["lis"].'" id="email_formi" placeholder="Логин" class="input_f_1 input_100" autocomplete="off" type="text"></div></div>';
		  }
?>
			<div class="input-width"><div class="width-setter"><input type="password" name="password" id="password_formi" value="" placeholder="Пароль" class="input_f_1 input_100" autocomplete="off" type="text"></div></div>
            
            <div class="input-width"><div class="width-setter"><button onClick="return false;" id="yes1" class="blue_blue">войти</button></div></div>


			<br>
<input type=hidden name="ref" value="00">
            </form>
            </span>
            </div></div>
<?			



?>

<?
include_once $url_system.'template/form_js.php';
?>
<script type="text/javascript">
$(function (){  if($('#email_formi').val()=='') {  $('#email_formi').focus();  } else { $('#password_formi').focus();  }  });
</script>