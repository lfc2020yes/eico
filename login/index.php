<?
session_start();
//$location_url="http://www.is.ru";

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/config.php';
include_once $url_system.'login/function_users.php';
include_once $url_system.'module/function.php';
initiate($link);   //авторизация - проверка взлома и сохранение сессии


//echo(password_crypt_(4,'123','solo'));

if(isset($_GET['n']))
{
	$n=$_GET['n']+1;
} else
{
 $n=0;	
}

//проверяем не знает ли пользователя система

if (isset($_SESSION['user_id']))
{ 
     if(isset($_GET['next'])&&$_GET['next']!='')
     {
  	       
	          header("Location: ".base64_decode($_GET['next']));		  			  	  	  	       		   
     } else
     {
        header("Location:".$base_usr);	
     }
}  

if ((array_key_exists('ref', $_POST))and(array_key_exists('email', $_POST))and(array_key_exists('password', $_POST)))
{
   $error="0";
   $count_login1=0;
   $time_step=10;
   
   if(isset($_SESSION["da"]))
   {
		$rt2=explode('/',$_SESSION["da"]);
		for ($is=0; $is<count($rt2); $is++)
        {
		   $time_difference1 = time() - $rt2[$is]; 
           $minutes1 = round($time_difference1 / 60 );
		   if($minutes1<$time_step)
		   {
			   $count_login1++;
		   }
		}				
	} 
   if($count_login1>=10) { $error='3'; $error11='3'; }	
   

   /* проверка поля логин */   
   if(trim($_POST['email'])=='') {  $error='1';  } else  { if(log_email(trim($_POST['email']))==0) {  $error='1';   }} 
    
   /* проверка поля пароль */      
   if(trim($_POST['password'])=='') {  $error='1';  } else  { if((pas_lench(trim($_POST['password']))==0)or(pas_pr(trim($_POST['password']))==0)) {  $error='1'; } }
  if($error=="0")
  {
    //ошибок нет

   $result_o=mysql_time_query($link,'select id,login from r_user where login="'.htmlspecialchars(trim($_POST['email'])).'"');
   $num_results_o = $result_o->num_rows;
   if($num_results_o!=0)
   {    
     $row1222_o = mysqli_fetch_assoc($result_o);     
	 

//echo(password_crypt_($row1222_o["id"],htmlspecialchars(trim($_POST['password'])),$row1222_o["email"]));

    $result=mysql_time_query($link,'select id,login,password from r_user where ((login="'.htmlspecialchars(trim($_POST['email'])).'")and(password="'.password_crypt_($row1222_o["id"],htmlspecialchars(trim($_POST['password'])),$row1222_o["login"]).'"))');
	
    $num_results = $result->num_rows;
    if($num_results!=0)
	{
      //логин с паром подошли
	  $row = mysqli_fetch_assoc($result);
	  	  
      login(0, $row["id"], false,$link);
	  	
	  setcookie("lis",$_POST['email'], time() + 60 * 60 * 24 * 365, "/", $base_cookie, false, true); //на год
	  //echo($row["id"]);	  
	} else
	{
        unset($_SESSION['user_id']);
	    //ошибка логин-пароль
	    $error="1";
	  setcookie("tsl","0", time()+3600, "/", $base_cookie, false, false); //на год
	}

	 
  }else
  {
        unset($_SESSION['user_id']);
	  setcookie("tsl","0", time()+3600, "/", $base_cookie, false, false); //на год
       //ошибка логин-пароль 
	   $error="1";	  
  }


  } else
  {
        unset($_SESSION['user_id']);
	  setcookie("tsl","0", time()+3600, "/", $base_cookie, false, false); //на год
       //ошибка логин-пароль 
	   $error="1";
  }
} else
{
	//ошибка логин-пароль
	$error="1";
	setcookie("tsl","0", time()+3600, "/", $base_cookie, false, false); //на год
 
}

//проверка количество входов после 10 подрят неудачных не принемать данные 10 минут
$time_step=10;

if(($error=="1")and(array_key_exists('ref', $_POST)))
{
    if(isset($_SESSION["da"]))
	{
		$rt1=explode('/',$_SESSION["da"]);
		$ses='';
		$count_login=0;
		for ($is=(count($rt1)-1); (($is>=0)and($count_login<9)); $is--)
        {
		  if ((is_numeric($rt1[$is]))and($rt1[$is]!=''))
		  {	
		   $time_difference1 = time() - $rt1[$is]; 
           $minutes1 = round($time_difference1 / 60 );
		   if($minutes1<$time_step)
		   {
			   if($count_login==0)
			   {
				  $ses=$rt1[$is];
			   } else
			   {
			      $ses=$rt1[$is].'/'.$ses;
			   }
			   $count_login++;
		   }
		  }
		}
		//echo($rt1[$is]);
		$time_difference2 = time() - $rt1[$is]; 
        $minutes2 = round($time_difference2 / 60 );	  
		$jdat=$time_step-$minutes2;
		
		$_SESSION['da'] =$ses.'/'.mktime();
		$count_login++;
		
		
	} else
	{
	
	  $_SESSION['da'] = mktime();  	
		
	}

}
 
//шифрование пароля в базе
//id_user- id записи user
//pas - пароль который хочет задать
//email - логин пользователя

//то есть если нужно задать пароль для пользователя с id - 25 и логином marat, и хотим задать пароль 123
//$password=password_crypt_(25,'123','marat')
//и заносим в базу данных 
	
function password_crypt_($id_user,$pas,$email)
{
$chars = $email.$email.$email.$email.$email.$email;
$posl_chifra_id=$id_user%10;
$ch=10+$posl_chifra_id;	
$st=$email.$email;
$st_1 = substr($st, 0, $posl_chifra_id);
$st_2= substr($st, $posl_chifra_id);
$crypt=sha1($st_1.$id_user.$pas.$chars[$ch].$st_2); 	
return($crypt);	
}


function password_crypt_key_($id_user,$pas,$pas1,$link,$email)
{
//$pas - пароль который ввел пользователь
//$pas1 - зашифрованный password в таблице users
$chars = $email.$email.$email.$email.$email.$email;
$posl_chifra_id=$id_user%10;
$ch=10+$posl_chifra_id;
$st=$email.$email;	
$st_1 = substr($st, 0, $posl_chifra_id);
$st_2= substr($st, $posl_chifra_id);
$crypt=sha1($st_1.$id_user.$pas.$chars[$ch].$st_2);
if($crypt==$pas1)
{
  return 1; //все верно
} else
{
  //подмен пароля в таблице users
  
  $IP="";
		         if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"] != ""){ 
                      $IP = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]; 
                      $proxyip = $HTTP_SERVER_VARS["REMOTE_ADDR"]; 
                 }else{ 
                      $IP = $HTTP_SERVER_VARS["REMOTE_ADDR"]; 
                 } 
		
		   
			  
                 $today[0] = date("y.m.d"); //присвоено 03.12.01
                 $today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17

	             $date_=$today[0].' '.$today[1];		
  
  
  
   $query = 'insert into hacking_site (dates,ip,link,what)  values (
													 "'.$date_.'",
													 "'.$IP.'","'.htmlspecialchars($_SERVER['REQUEST_URI']).'","users->password update rows")';

  mysqli_query($link,$query); 
  
  return 0;
}

} 
 

//проверка пароля
function pas_lench($pass)
{
  if (strlen($pass) < 1)
  {         
     return 0; //ошибка
  } else
  {
     return 1; //все верно	   
  }
}

//проверка пароля
function pas_pr($pass)
{
  if ($pass != '' AND !preg_match("/^[0-9a-zA-Z_]{1,}$/",$pass))  
  {          
     return 0; //ошибка
  } else
  {
     return 1; //все верно	   
  }
}

//проверка логина
function log_($log)
{
  if ($log != '' AND !eregi("^[A-Za-z]{1,}[0-9a-zA-Z_][0-9a-zA-Z]{1,}$",$log))
  
  {         
     return 0; //ошибка
  } else
  {
     return 1; //все верно	   
  }
}

function log_email($log)
{
  if (($log != '' AND !preg_match("/^[A-Za-z]{1,}[0-9a-zA-Z_][0-9a-zA-Z]{1,}$/",$log))and($log != '' AND !preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,3}$/",$log)))
  
  {              
	 return 0; //ошибка	 
  } else
  { 
     return 1; //все верно	   
  }
}



//проверяем занят ли такой логин или нет
function log_home($log,$link)
{
//include '../php/config.php';
   $result=mysql_time_query($link,'select id from users where login="'.htmlspecialchars(trim($log)).'"');
   $num_results = $result->num_rows;
   if($num_results!=0)
   {         
     return 1; //все верно	
   } else
   {
     return 0; //ошибка   
   }
}

if(($error=="0")&&(isset($_SESSION['user_id'])))
{
  //логин-пароль подошел вход в систему произведен переходим откуда перешел пользователь
     if(isset($_GET['next'])&&$_GET['next']!='')
     {
		header("Location: ".base64_decode($_GET['next']));
  } else
  {
	 header("Location: ".$base_usr);	
  }
} else
{



include $url_system.'template/html.php';
include $url_system.'module/seo.php';
SEO('0','','','',$link);   

include_once $url_system.'module/config_url.php'; 
include $url_system.'template/head.php';
?>


</head><body>
<table id="container_login" align="center"><tr><td style="padding-left:0px; padding-right:0px;">

<?

//echo ('!'.id_key_crypt(14).'<br>');
//echo ('!'.id_key_crypt(560).'<br>');

//echo(id_key_crypt_encrypt(id_key_crypt(14)).'<br>');
//echo(id_key_crypt_encrypt(id_key_crypt(560)).'<br>');
  // include_once $url_system.'Template/top.php';
  //echo(password_crypt_(829,'123','edik'));
?>

<div class="jurnal_bg bg_form " id="gradient">

<div class="formi_css_login">
<br><br>
<div class="big_logo"><img src="image/logo_big.png"></div>

<h3>Вход в систему<span>**</span></h3>
<?

if(isset($_GET["next"]))
{
echo'<form id="pod_form" action="/login/?next='.$_GET["next"].'&n='.$n.'" method="POST" enctype="multipart/form-data" >';
	
} else
{
echo'<form id="pod_form" action="/login/?next='.$_SERVER['HTTP_REFERER'].'&n='.$n.'" method="POST" enctype="multipart/form-data" >';
}

if(isset($_POST["ref"]))
{

echo'<div class="input-width"><div class="width-setter"><input type="text" value="'.$_POST["email"].'" name="email" id="email_formi" placeholder="Логин" class="input_f_1 error_formi" autocomplete="off"></div></div><br>';

echo'<div class="input-width"><div class="width-setter"><input type="password" name="password" id="password_formi" value="" placeholder="Пароль" class="input_f_1 error_formi" autocomplete="off"></div></div><br>';


echo'<input type=hidden name="ref" value="00">';
	
} else
{
if(!isset($_COOKIE["lis"]))
{	
?>
<div class="input-width"><div class="width-setter"><input type="text" name="email" id="email_formi" placeholder="Логин" class="input_f_1" autocomplete="off"></div></div><br>
<?
} else
{
echo'<div class="input-width"><div class="width-setter"><input type="text" value="'.$_COOKIE["lis"].'" name="email" id="email_formi" placeholder="Логин" class="input_f_1" autocomplete="off"></div></div><br>';	
}
	?>

<div class="input-width"><div class="width-setter"><input type="password" name="password" id="password_formi" value="" placeholder="Пароль" class="input_f_1" autocomplete="off"></div></div><br>

<?
echo'<input type=hidden name="ref" value="00">';
}


if(isset($_POST["ref"]))
{
	
if($error11==3)
{	
 echo'<div class="text_formi_error">Слишком много неуспешных попыток авторизации. Необходимо подождать '.$jdat.' '.PadejNumber($jdat,'минуту,минуты,минут').'</div>';
} else
{
  echo'<div class="text_formi_error">Логин и пароль не совпадают.</div>';
}
}


//Если 2 раза отправили форму
/*
if(($n>1)&&($error!=2))
{
echo'<div class="text_formi" style="margin-top:5px;">Быстрый вход в учетную запись. <a id="speed_auth" href="account/auth/">Отправить ссылку</a> на мой адрес электронной почты</div>';
}
*/
?>
 <div style="height:70px;">  
<div class="blue_blue" id="yes1" style="float:left;">Войти</div>

<!--<a href="/account/password/recover/"><div class="gray_gray1" id="" style="float:left; margin-left:30px;"><span>Забыли пароль?</span></div></a>-->
</div>
<?



?>
</form>
<br><br><br><br>

</div>

</div>

<?
 // include_once $url_system.'Template/bottom.php';
 // bottom($link,'small');
  
 // include_once $url_system.'Template/hoteliBox.php';

?>

</td></tr></table>
<script src="Js/rem.js" type="text/javascript"></script>
<script  type="text/javascript">window.LoginVar=1; window.NotifVar=1;

$(function (){  
	
	updateloginhak();
	
	
	if($('#email_formi').val()=='') {  $('#email_formi').focus();  } else { $('#password_formi').focus();  }  });	
	
	
var colors = new Array(
  [121,142,161],
  [139,119,110],
  [185,180,186],
  [105,125,149],
  [75,202,225]);

var step = 0;
//color table indices for: 
// current color left
// next color left
// current color right
// next color right
var colorIndices = [0,1,2,3];

//transition speed
var gradientSpeed = 0.002;

function updateGradient()
{
  
  if ( $===undefined ) return;
  
var c0_0 = colors[colorIndices[0]];
var c0_1 = colors[colorIndices[1]];
var c1_0 = colors[colorIndices[2]];
var c1_1 = colors[colorIndices[3]];

var istep = 1 - step;
var r1 = Math.round(istep * c0_0[0] + step * c0_1[0]);
var g1 = Math.round(istep * c0_0[1] + step * c0_1[1]);
var b1 = Math.round(istep * c0_0[2] + step * c0_1[2]);
var color1 = "rgb("+r1+","+g1+","+b1+")";

var r2 = Math.round(istep * c1_0[0] + step * c1_1[0]);
var g2 = Math.round(istep * c1_0[1] + step * c1_1[1]);
var b2 = Math.round(istep * c1_0[2] + step * c1_1[2]);
var color2 = "rgb("+r2+","+g2+","+b2+")";

 $('#gradient').css({
   background: "-webkit-gradient(linear, left top, right top, from("+color1+"), to("+color2+"))"}).css({
    background: "-moz-linear-gradient(left, "+color1+" 0%, "+color2+" 100%)"});
  
  step += gradientSpeed;
  if ( step >= 1 )
  {
    step %= 1;
    colorIndices[0] = colorIndices[1];
    colorIndices[2] = colorIndices[3];
    
    //pick two new target color indices
    //do not pick the same as the current one
    colorIndices[1] = ( colorIndices[1] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
    colorIndices[3] = ( colorIndices[3] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
    
  }
}

setInterval(updateGradient,10);

</script>
</body>
</html>


<?
 // echo($_SESSION["da"]);
}
?>