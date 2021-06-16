<?
//файл - сохранение авторизации пользователя во время гуляния по сайту и при закрытии браузера

 function rand_string($len, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') 
 { 
    $string = ''; for ($i = 0; $i < $len; $i++) 
	{ 
	   $pos = rand(0, strlen($chars)-1); 
	   $string .= $chars{$pos}; 
	} 
	return $string; 
 } 
 
 function session_encrypt($string) 
 { 
	return md5($string); 
 } 
 
 function safe_var($str)
 { 
    $str=trim(stripslashes(htmlspecialchars($str))); 
	return $str; 
 }
//формирование закодированного ключа в кукки для сохранения сессии пользователя
function xah_crypt($id_user,$st)
{
$chars = 'сookiesareverycomplexсookiesareverycomplex';
$posl_chifra_id=$id_user%10;
$ch=5+$posl_chifra_id;	
$st_1 = substr($st, 0, $posl_chifra_id);
$st_2= substr($st, $posl_chifra_id);
$crypt=sha1($st_1.$id_user.$chars[$ch].$st_2); 	
return($crypt);	
}


function id_key_crypt_encrypt($string)
{
$string=base64_decode($string);
$id_iuser='';
$chars = 'tgbyhnujmiklrfvedcsqawzx'; //соль 1
$chars3 = 'qazwsxedcrfvtgbyhnujmiklop';

$string_id=	$string[strlen($string)-1];
$count_simv_id=strpos($chars3, $string_id);

$st_1 = substr($string, 4, $count_simv_id);
	for ($i = strlen($st_1); $i > 0; $i--) 
    {
		$pos = strpos($chars, $st_1[$i-1]);

       $id_iuser.=$pos;
    }
	
return($id_iuser);
}

//формирование закодированного id пользователя для хранения в сессии пользователя
function id_key_crypt($id_user)
{
$chars = 'tgbyhnujmiklrfvedcsqawzx'; //соль 1
$chars1 = 'aDHAFKWHEBSBVWODHasfgshfh'; //соль 2
$chars2 = 'zxckjvcrehuhrujsdnklverfjdjas';  //соль 3

$chars3 = 'qazwsxedcrfvtgbyhnujmiklop';   //соль 4


$posl_chifra_id=$id_user%10;   //число от 0 до 10
$posl_chifra_id1=$id_user%6;   //число от 0 до 10

$ch=7+$posl_chifra_id;	//число от 5 до 15
$ch1=10+$posl_chifra_id1;	//число от 5 до 15

//$st_1 = substr($st, 0, $posl_chifra_id); // с 0 символа n символов
//$st_2= substr($st, $posl_chifra_id);  //с n символа до конца

$id_user_key='';
$fgg=$id_user.'';
for ($i = strlen($id_user); $i > 0; $i--) 
{
  $id_user_key.=$chars[$fgg[$i-1]];
}



$crrr=$chars3[$ch1].$chars2[$ch].$chars1[$ch1].$chars[$ch1].$id_user_key.$chars[$ch].$chars1[$ch].$chars2[$ch1].$chars3[$ch].$chars3[strlen($id_user)];



//$crypt=sha1($st_1.$id_user.$chars[$ch].$st_2); 	
return(base64_encode($crrr));	
}

// Вывод строки в обратном порядке
function foo($s) {
    for ($i = strlen($s); $i > 0; $i--) {
        echo $s[$i-1];
    }
}

//проверка закодированных данных кукки для восстановления сессии пользователя
function xah_crypt_key($id_user,$pas,$pas1,$link)
{
$chars = 'сookiesareverycomplexсookiesareverycomplex';
$posl_chifra_id=$id_user%10;
$ch=5+$posl_chifra_id;	
$st_1 = substr($pas1, 0, $posl_chifra_id);
$st_2= substr($pas1, $posl_chifra_id);
$crypt=sha1($st_1.$id_user.$chars[$ch].$st_2);
if($crypt==$pas)
{
  return 1; //все верно
} else
{
  //подмен тикета. Скорее всего взлом. записываем данные об этом пользователи в базу
  
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
													 "'.$IP.'","'.htmlspecialchars($_SERVER['REQUEST_URI']).'","users_xah->xah!=xah1")';

  mysqli_query($link,$query); 
  
  return 0;
}

}



//при каждом зарегистрированном входе обновляем xah для того чтобы его не успели скопировать
function login($key, $id,$flag,$link) 
{
	//$flag=true для обычного входа с xah
	//$flag=false для входа в первый раз когда надо создать новый xah
	//проверим существует ли такой пользователь
	//может он есть но не подтвердил регистрацию
    $sql = mysql_time_query($link,"SELECT id FROM r_user WHERE  id = '" . htmlspecialchars(trim($id)) . "'");
    //echo("SELECT id FROM users WHERE  id = '" . htmlspecialchars(trim($id)) . "' AND activate=1");
	$num_results = $sql->num_rows;
    if($num_results==0) 
    {
       return false;
    }
    else
    {
		//echo("!!!");
       while($u = mysqli_fetch_assoc($sql))
       {
		  setcookie("tsl","1", time()+3600, "/", "eico.atsun.ru", false, false); //на год
		   session_regenerate_id(true); //создаёт новый идентификатор сессии при каждом входе пользователя в систему
          $session_id = id_key_crypt($u['id']);
          //$session_username = $username;

          $_SESSION['user_id'] = $session_id;
          //$_SESSION['user_name'] = $session_username;
          //$_SESSION['user_lastactive'] = time();
		   //alert("!");
		  	 
          return true;
      }
   }
} 


//функция выхода из системы
//удаляем сессию
//удаляем кукки сохранения авторизации 
//удаляем строку из  users_xah
function logout($link)
{
     // Need to delete auth key from database so cookie can no longer be used
     //$username = $_SESSION['user_id'];
     //$auth_query = mysql_time_query($link,"delete FROM users_xah where id=".htmlspecialchars(trim($username))." and xah=".htmlspecialchars(trim($_COOKIE['remixid'])));
	 //setcookie("remixid", "", time()-3600,"/", "ulmenu.ru");
     // If auth key is deleted from database proceed to unset all session variables

     unset($_SESSION['user_id']);
	
	
	//$.cookie("tsl", null, {path:'/',domain: window.is_session,secure: false});
	
	 setcookie("tsl","0", time()+3600, "/", "eico.atsun.ru", false, false); //на год
	 unset($_SESSION['da']);

     session_unset();
     session_destroy(); 
     return true;
}

//проверка есть ли такой XAH или нет
function xah_xah($log,$link)
{
   $result=mysql_time_query($link,'select id from users_xah where xah="'.htmlspecialchars(trim($log)).'"');
   $num_results = $result->num_rows;
   if($num_results!=0)
   {         
     return true; //такой xah уже есть
   } else
   {
     return false; //такого xah еще нет
   }
}


//функция инициализации пользователя. выполняется каждый раз
function initiate($link)
{
   $logged_in = false;
   if(isset($_SESSION['user_id']))
   {
  
   
   //проверяем есть ли такой id в базе
   $id_user=id_key_crypt_encrypt($_SESSION['user_id']);
   if(is_numeric($id_user))
   {
   
		$auth_key_query = mysql_time_query($link,"SELECT id FROM r_user WHERE id='".safe_var($id_user)."'");
		$num_results = $auth_key_query->num_rows;
        if($num_results==0)
        {	
		   //взлом системы удаляем все кукии и сессии и выходим из системы
		   

                    //взлом выходим из системы
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
													 "'.$IP.'","'.htmlspecialchars($_SERVER['REQUEST_URI']).'","подмена сессии users_id='.$_SESSION['user_id'].'")';

                    mysqli_query($link,$query); 		   
		   //setcookie("tsl","1",time() - 3600, "/", "interstroi.atsun.ru", false, true); //на год	
           unset($_SESSION['user_id']);
           //unset($_SESSION['user_name']);;
           //unset($_SESSION['user_lastactive']);
           session_unset();
           session_destroy(); 
		   //обновляем страницу
           header('Location: .');
		} else
		{
        		
			
			
		$logged_in = true;
		//mysqli_query($link,'CALL set_user('.$id_user.')');  //для бати зачем то)
        mysqli_query($link,"SET @id_user='$id_user'");

		//обновляем время последнего действия на сайте пользователя (онлайн)	
		mysqli_query($link,'update r_user set timelast="'.time().'" where id = "'.htmlspecialchars(trim($id_user)).'"');  //для бати зачем то)	
		}
   }
   
   }
	 
  
}






?>