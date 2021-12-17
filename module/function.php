<?
function my_url_encode($s){
    $s= strtr ($s, array (" "=> "%20", "а"=>"%D0%B0", "А"=>"%D0%90","б"=>"%D0%B1", "Б"=>"%D0%91", "в"=>"%D0%B2", "В"=>"%D0%92", "г"=>"%D0%B3", "Г"=>"%D0%93", "д"=>"%D0%B4", "Д"=>"%D0%94", "е"=>"%D0%B5", "Е"=>"%D0%95", "ё"=>"%D1%91", "Ё"=>"%D0%81", "ж"=>"%D0%B6", "Ж"=>"%D0%96", "з"=>"%D0%B7", "З"=>"%D0%97", "и"=>"%D0%B8", "И"=>"%D0%98", "й"=>"%D0%B9", "Й"=>"%D0%99", "к"=>"%D0%BA", "К"=>"%D0%9A", "л"=>"%D0%BB", "Л"=>"%D0%9B", "м"=>"%D0%BC", "М"=>"%D0%9C", "н"=>"%D0%BD", "Н"=>"%D0%9D", "о"=>"%D0%BE", "О"=>"%D0%9E", "п"=>"%D0%BF", "П"=>"%D0%9F", "р"=>"%D1%80", "Р"=>"%D0%A0", "с"=>"%D1%81", "С"=>"%D0%A1", "т"=>"%D1%82", "Т"=>"%D0%A2", "у"=>"%D1%83", "У"=>"%D0%A3", "ф"=>"%D1%84", "Ф"=>"%D0%A4", "х"=>"%D1%85", "Х"=>"%D0%A5", "ц"=>"%D1%86", "Ц"=>"%D0%A6", "ч"=>"%D1%87", "Ч"=>"%D0%A7", "ш"=>"%D1%88", "Ш"=>"%D0%A8", "щ"=>"%D1%89", "Щ"=>"%D0%A9", "ъ"=>"%D1%8A", "Ъ"=>"%D0%AA", "ы"=>"%D1%8B", "Ы"=>"%D0%AB", "ь"=>"%D1%8C", "Ь"=>"%D0%AC", "э"=>"%D1%8D", "Э"=>"%D0%AD", "ю"=>"%D1%8E", "Ю"=>"%D0%AE", "я"=>"%D1%8F", "Я"=>"%D0%AF"));
    return $s;
}
// функция раскодирует строку из URL
function my_url_decode($s){
    $s= strtr ($s, array ("%20"=>" ", "%D0%B0"=>"а", "%D0%90"=>"А", "%D0%B1"=>"б", "%D0%91"=>"Б", "%D0%B2"=>"в", "%D0%92"=>"В", "%D0%B3"=>"г", "%D0%93"=>"Г", "%D0%B4"=>"д", "%D0%94"=>"Д", "%D0%B5"=>"е", "%D0%95"=>"Е", "%D1%91"=>"ё", "%D0%81"=>"Ё", "%D0%B6"=>"ж", "%D0%96"=>"Ж", "%D0%B7"=>"з", "%D0%97"=>"З", "%D0%B8"=>"и", "%D0%98"=>"И", "%D0%B9"=>"й", "%D0%99"=>"Й", "%D0%BA"=>"к", "%D0%9A"=>"К", "%D0%BB"=>"л", "%D0%9B"=>"Л", "%D0%BC"=>"м", "%D0%9C"=>"М", "%D0%BD"=>"н", "%D0%9D"=>"Н", "%D0%BE"=>"о", "%D0%9E"=>"О", "%D0%BF"=>"п", "%D0%9F"=>"П", "%D1%80"=>"р", "%D0%A0"=>"Р", "%D1%81"=>"с", "%D0%A1"=>"С", "%D1%82"=>"т", "%D0%A2"=>"Т", "%D1%83"=>"у", "%D0%A3"=>"У", "%D1%84"=>"ф", "%D0%A4"=>"Ф", "%D1%85"=>"х", "%D0%A5"=>"Х", "%D1%86"=>"ц", "%D0%A6"=>"Ц", "%D1%87"=>"ч", "%D0%A7"=>"Ч", "%D1%88"=>"ш", "%D0%A8"=>"Ш", "%D1%89"=>"щ", "%D0%A9"=>"Щ", "%D1%8A"=>"ъ", "%D0%AA"=>"Ъ", "%D1%8B"=>"ы", "%D0%AB"=>"Ы", "%D1%8C"=>"ь", "%D0%AC"=>"Ь", "%D1%8D"=>"э", "%D0%AD"=>"Э", "%D1%8E"=>"ю", "%D0%AE"=>"Ю", "%D1%8F"=>"я", "%D0%AF"=>"Я"));
    return $s;
}

//проверка ввода валидности даты
function validateDate($date, $format = 'd.m.Y H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function day_nedeli_x_small($dat2)
{
    $date=explode("-", $dat2);
    $dow = date("w", mktime(0, 0, 0, $date[1], $date[2], $date[0]));

    switch($dow)
    {
        case "0": {  $wr="Вс";  break; }
        case "1": {  $wr="Пн"; break; }
        case "2": {  $wr="Вт"; break; }
        case "3": {  $wr="Ср"; break; }
        case "4": {  $wr="Чт"; break; }
        case "5": {  $wr="Пт"; break; }
        case "6": {  $wr="Сб";  break; }
    }

    return $wr;

}


function password_crypt_x($id_user,$pas,$email)
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





//вывод value полей при отправле форм

//vars - переменная $_POST['bb'] или $_GET[]
//ret - значение по умолчанию "" или 0 допустим или значение с базы $row[]

//если есть vars то выбираем его или ret.
//если это значение равно mask то делаем значение на выходе функции value_mask
//нужно для селект полей когда пустое значение со значение -1

//mask - если значение

function ipost_new($vars,$ret,$mask='',$value_mask='')
{
    $end_value='';
    if((isset($vars))and($vars!=''))
    {
        $end_value=(htd($vars));
    }
    else
    {

        $end_value=$ret;

    }
    if($end_value==$mask)
    {
        $end_value=$value_mask;
    }
    return $end_value;
}


//удаление пробельный символов
function trimc($input)
{
    return str_replace(' ', '', $input);
}

function FileBase($value,$link)
{
    $result=mysql_time_query($link,'select A.id from image_attach as A where A.visible=1 and A.id_object=0 and A.for_what IN ("8","11","3") and A.name="'.ht($value).'"');
    $num_results = $result->num_rows;
    if($num_results!=0)
    {
        return 1; //ok
    } else
    {

        mysqli_query($link, 'insert into v_error (module,error,date_error)  values ("' . htmlspecialchars($_SERVER['REQUEST_URI']) . '","' . htmlspecialchars('select A.id from image_attach as A where A.visible=1 and A.id_object=0 and A.for_what IN ("8","11","3") and A.name="'.ht($value).'"') . '","' . date("y.m.d") . ' ' . date("H:i:s") . '")');


        return 0;  //с файлом что-то не так
    }
}

//перевод даты из формата 15.07.2020 в формат 2020-07-15 (sql)  -> ex=1
//перевод даты из формата 2020-07-15 (sql) в формат 15.07.2020  -> ex=0

function date_ex($ex,$date)
{
    if(($date!='')and($date!='00.00.0000')and($date!='0000-00-00'))
    {
        if($ex==1) {
            $date_ex = explode(".", htmlspecialchars(trim($date)));
            $date_start = $date_ex[2] . '-' . $date_ex[1] . '-' . $date_ex[0];
        } else
        {
            $date_ex = explode("-", htmlspecialchars(trim($date)));
            $date_start = $date_ex[2] . '.' . $date_ex[1] . '.' . $date_ex[0];
        }
    }
    return  $date_start;
}

function date_ex_time($ex,$date)
{
    $date_start='';
    if(($date!='')and($date!='00.00.0000 00:00')and($date!='0000-00-00 00:00:00'))
    {
        if($ex==1) {
            $date_ex_t = explode(" ", htmlspecialchars(trim($date)));
            $date_ex = explode(".", htmlspecialchars(trim($date_ex_t[0])));
            $date_start = $date_ex[2] . '-' . $date_ex[1] . '-' . $date_ex[0];
            $time=$date_ex_t[1].':00';

            $date_start=$date_start.' '.$time;
        } else
        {
            $date_ex_t = explode(" ", htmlspecialchars(trim($date)));
            $date_ex = explode("-", htmlspecialchars(trim($date_ex_t[0])));
            $date_start = $date_ex[2] . '.' . $date_ex[1] . '.' . $date_ex[0];
            $time_t=explode(":", htmlspecialchars(trim($date_ex_t[1])));
            $time=$time_t[0].':'.$time_t[1];

            $date_start=$date_start.' '.$time;
        }
    }
    return  $date_start;
}

//взятие файла с последней версией
/*
index-0.0.2.js
main-0.4.6.js
*/	
/*
version_file('/Js/','index','js')

function ve($dir,$name,$extension)
{
	$end_version='';
	
	$scan_result = scandir( $dir );
    foreach ( $scan_result as $key => $value ) {	

		if ( !in_array( $value, array( '.', '..' ) ) ) {
			
			  $type = explode( '.', $value ); 
              $type = array_reverse( $type );
              if( in_array( $type[0], $extension ) ) {
				
				  	$type1 = explode( '-', $value ); 
                    if( in_array( $type1[0], $name ) ) {
						
					}
				  
			  }
			
		}
		
	}
	
return 	$dir.$name.$end_version.'.'.$extension;
	
}
*/


// аргументов функции будет путь к файлу
//определение размера файла
function get_filesize($file)
{
    // идем файл
    if(!file_exists($file)) return "Файл  не найден";
    // теперь определяем размер файла в несколько шагов
    $filesize = filesize($file);
    // Если размер больше 1 Кб
    if($filesize > 1024)
    {
        $filesize = ($filesize/1024);
        // Если размер файла больше Килобайта
        // то лучше отобразить его в Мегабайтах. Пересчитываем в Мб
        if($filesize > 1024)
        {
            $filesize = ($filesize/1024);
            // А уж если файл больше 1 Мегабайта, то проверяем
            // Не больше ли он 1 Гигабайта
            if($filesize > 1024)
            {
                $filesize = ($filesize/1024);
                $filesize = round($filesize, 1);
                return $filesize." ГБ";
            }
            else
            {
                $filesize = round($filesize, 1);
                return $filesize." MБ";
            }
        }
        else
        {
            $filesize = round($filesize, 1);
            return $filesize." Кб";
        }
    }
    else
    {
        $filesize = round($filesize, 1);
        return $filesize." байт";
    }
}




//название для файлов на сервере
function rand_string_string_image($len, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_')
{
    $string = ''; for ($i = 0; $i < $len; $i++)
{
    $pos = rand(0, strlen($chars)-1);
    $string .= $chars[$pos];
}
    return $string;
}

//разница минут между двумя датами
function dateDiff_min($dt1, $dt2, $timeZone = 'GMT') {
    $tZone = new DateTimeZone($timeZone);
    $dt1 = new DateTime($dt1, $tZone);
    $dt2 = new DateTime($dt2, $tZone);
    $ts1 = $dt1->format('Y-m-d H:i:s');
    $ts2 = $dt2->format('Y-m-d H:i:s');
    $diff = strtotime($ts1)-strtotime($ts2);
    $diff/= 60;
    return floor($diff);
}


function ht($varr)
{
    return(htmlspecialchars(trim($varr)));

}


function htd($varr)
{
//return(htmlspecialchars_decode($varr));

    return html_entity_decode($varr, ENT_NOQUOTES, 'utf-8');

}

//оставить только фамилию и имя если в строке есть и отчество
function tolkofi($name)
{
    $new_name='';
    $i=0;
    $pr='';
    $date_end1 = explode(" ", ht($name));
    if(count($date_end1)==3)
    {
        foreach ($date_end1 as $index => $value) {
            if($index<2)
            {
                $new_name.=$pr.$value;
            }
            $pr=' ';
        }
    } else
    {
        $new_name=$name;
    }
    return $new_name;
}


function h4a($er,$echo,$debug)
{
	if($echo==0)
	{	
	$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   die();	
	} else
	{
		$debug.='-'.$er;
		return $debug;
	}	
}

function header404($er,$echo)
{
	$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
	if($echo!=0)
	{
	//echo($er);
	}
   include $url_system.'module/error404.php';
   die();
}

		  
//выводить аватар или заглушку
function avatar_img($img_start,$id,$img_end)
{
	$url_system1=$_SERVER['DOCUMENT_ROOT'].'/';
	$filename=$url_system1.'img/users/'.$id.'_100x100.jpg';
    if (file_exists($filename)) {
		return ($img_start.$id.$img_end);
    } else
    {
	   return ($img_start.'0'.$img_end);
    }
}


//выделение тегом в тексте нужного текста
function search_text_strong($regime,$search,$beginText)
{
	$search=mb_convert_case($search, MB_CASE_LOWER, "UTF-8");
	$beginText=mb_convert_case($beginText, MB_CASE_LOWER, "UTF-8");
	
//$regime    //Режим поиска (1 - точный поиск, 0 - вхождение)
//$search    // Что ищем (в примере: $search = "про"; )
//$beginText // Текст по которому необходимо провести поиск
 
/* Точный поиск. (Найдёт: "...не [B]про[/B] меня", 
Не найдёт "Этот ком[U]про[/U]мат не..." - ) отдельное слово */

if($regime == 1)                                       
  { $patterns = "/(\b".$search."\b)+/i"; }// Регулярное выражение
 
 
/* Отдельное слово и Вхождение в другие слова. 
(Найдёт: "...не [B]про[/B] меня", 
Найдёт: "Этот ком[B]про[/B]мат не...") */
else                                                       
  { $patterns = "/(".$search.")+/i"; }// Регулярное выражение
 
$replace = "<strong>$1</strong>";// На что заменить

setlocale(LC_ALL, 'ru_RU.CP1251');
$endText = PREG_REPLACE($patterns,$replace,$beginText);// Замена
 
return $endText;
}
	

//определение количества непрочитанных сообщений с этим пользователем
function no_view_message($id,$id_user,$link)
{
	$count_new_message=0;
	$result_tx=mysql_time_query($link,'select count(a.id) as kol from r_message as a where a.status=1 and a.id_user="'.htmlspecialchars(trim($id_user)).'" and a.id_sign="'.htmlspecialchars(trim($id)).'"');
        $num_results_tx = $result_tx->num_rows;
	    if($num_results_tx!=0)
	    { 
			$rowx = mysqli_fetch_assoc($result_tx);
			$count_new_message=$rowx["kol"];
		}
  return $count_new_message;
}
	


//открытие нового диалога при отправки сообщения
/*
id- кому отправили
id_user - кто отправил	
*/
function dialog($id,$id_user,$link)
{
	    //изменяем если нужно диалог у того кому отправили
		$result_tx=mysql_time_query($link,'Select a.* from r_dialog as a where a.id_user="'.htmlspecialchars(trim($id)).'" and a.dialog_user="'.htmlspecialchars(trim($id_user)).'"');
        $num_results_tx = $result_tx->num_rows;
	    if($num_results_tx==0)
	    {  
		  mysql_time_query($link,'INSERT INTO r_dialog (id_user,dialog_user) VALUES ("'.htmlspecialchars(trim($id)).'","'.htmlspecialchars(trim($id_user)).'")');		  	
		}
	
	    //изменяем если нужно диалог тот кто отправил
		$result_tx=mysql_time_query($link,'Select a.* from r_dialog as a where a.id_user="'.htmlspecialchars(trim($id_user)).'" and a.dialog_user="'.htmlspecialchars(trim($id)).'"');
        $num_results_tx = $result_tx->num_rows;
	    if($num_results_tx==0)
	    {  
		  mysql_time_query($link,'INSERT INTO r_dialog (id_user,dialog_user) VALUES ("'.htmlspecialchars(trim($id_user)).'","'.htmlspecialchars(trim($id)).'")');		  	
		}			
	
}


//Узнаем онлайн пользователь или нет
function online_user($times,$id_user,$you_id)
{
	//echo($id_user);
	//echo($you_id);
  $conts_razn= 5*60; //5 минут	
  $time_yes=time();
  if((($time_yes-$times)<$conts_razn)and($id_user!=$you_id))
  {
	  return true;
  } else
  {
	  return false;
  }

}

function name_sql_x($id)
{
    global $link;
    $result_txs=mysql_time_query($link,'Select a.name_user from r_user as a where a.id="'.$id.'"');
    if($result_txs->num_rows!=0)
    {
        $rowxs = mysqli_fetch_assoc($result_txs);
        return $rowxs["name_user"];

    } else
    {
        return 'Пользователь';
    }
}


//отправка уведомления админу на почту и на сайте
function notification_send_admin($title,$text,$mass,$id_user,$link)
{


    $today[0] = date("y.m.d"); //присвоено 03.12.01
    $today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17
    $date_=$today[0].' '.$today[1];

    foreach ($mass as $keys => $value)
    {
        mysql_time_query($link,'INSERT INTO r_notification (id_user,notification,sign_user,datetime ) VALUES ("'.$value.'","'.htmlspecialchars(trim($text)).'","'.$id_user.'","'.$date_.'")');
        $noti_key=new_key($link,10);
        mysql_time_query($link,'update r_user set noti_key="'.$noti_key.'" where id = "'.htmlspecialchars(trim($value)).'"');


        //отправляем на почту письмо
        //notification_mail($text,ht($value),$id_user,$link);

        //отправлять насильно все админу потом если что закомментировать
        notification_mail_admin($title,$text,11,$id_user,$link);



    }
}


//отправка уведомлений пользователям
function notification_send($text,$mass,$id_user,$link)
{


	$today[0] = date("y.m.d"); //присвоено 03.12.01
    $today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17
	$date_=$today[0].' '.$today[1];
	
    foreach ($mass as $keys => $value) 
	{		
		mysql_time_query($link,'INSERT INTO r_notification (id_user,notification,sign_user,datetime ) VALUES ("'.$value.'","'.htmlspecialchars(trim($text)).'","'.$id_user.'","'.$date_.'")');
		$noti_key=new_key($link,10);
		mysql_time_query($link,'update r_user set noti_key="'.$noti_key.'" where id = "'.htmlspecialchars(trim($value)).'"');


		//отправляем на почту письмо
        notification_mail($text,ht($value),$id_user,$link);

        //отправлять насильно все админу потом если что закомментировать
      //  notification_mail($text,11,$id_user,$link);



	}
}

function notification_mail($text1,$komy_id,$id_user,$link)
{
    global $notification_mail;
    if($notification_mail==1) {
        $today[0] = date("y.m.d"); //присвоено 03.12.01
        $today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17
        $date_ = $today[0] . ' ' . $today[1];

        $url_system = $_SERVER['DOCUMENT_ROOT'] . '/';
        include_once $url_system . 'module/config_mail.php';

        // отправка письма на почту
        // отправка письма на почту
        // отправка письма на почту
        $text = "<HTML>\r\n";
        $text .= "<HEAD>\r\n";
        $text .= "<META http-equiv=Content-Type content='html; charset=windows-1251'>\r\n";

        $text .= "<style type=\"text/css\">
.mail-st a {  color: #292f33; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 24px; font-weight: 300; line-height: 30px; border-bottom: 1px solid rgba(0,0,0,0.1);text-decoration: none;  }.time_notifi {color: rgba(0,0,0,0.4);
    font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 16px;}

</style>";
        $text .= "<base href=\"https://eico.atsun.ru/\">";

        $text .= "</HEAD>\r\n";
        $text .= "<BODY>\r\n";


        $text .= '<table width="100%" cellpadding="0" cellspacing="0" style="margin:0;padding:0;min-width:100%;" bgcolor="#E7E7EF"><tbody><tr><td align="center" style="padding: 0 5px;vertical-align:top;" bgcolor="#E7E7EF">';

        $text .= '<table align="center" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;margin:0 auto;direction:ltr; margin-top:40px;  margin-bottom:10px; ">
      <tbody><tr><td style="vertical-align:top; padding:30px;" bgcolor="#FFF">';


        $text .= "<br><span style=\"color: #66757f; font-family: 'Helvetica Neue Light',Helvetica,Arial,sans-serif; font-size: 16px; font-weight: 300;\">Приветствуем вас!</span><br><br>";


        $text .= '<div style=" width:100%; height:1px; border-top:1px solid #e1e8ed;"></div>';

        $text .= "<br><span class=\"mail-st\" style=\" color: #292f33; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 24px; font-weight: 300; line-height: 30px; margin: 0; padding: 0; text-align: left;\">" . $text1 . "</span><br><br>


<span style=\"color: #292f33;
    font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 16px;
    font-weight: 400;
    line-height: 22px;
    margin: 0;
    padding: 0;
    text-align: left;\">Ссылка на ваш личный кабинет: </span>

<br>
<a style=\"color:
#2c60a4;

border-bottom: 1px solid
rgba(0,0,0,0.1);

text-decoration: none;

font-size: 20px;\" href=\"https://eico.atsun.ru/notification/\">
COST CONTROL MANAGER
</a>

<br><br><br><span style=\"color: rgba(0,0,0,0.4);
    font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 12px;
    font-weight: 400;
    line-height: 19px;
    margin: 0;
    
    text-align: left;\"> Это письмо создано автоматически системой  COST CONTROL MANAGER. C уважением, Администрация <a style=\"color: rgba(0,0,0,0.4);
    
    text-decoration: none;\" href=\"https://eico.group/\">eico group</a></span>\r\n";

        $text .= "</td></tr></tbody></table>";


        $text .= "</td></tr></tbody></table>";


        $text .= "</BODY>\r\n";
        $text .= "</HTML>";


        //mail($_POST["login"],"www.ulmenu.ru: Подтверждение регистрации",$text,$header);
        // /отправка письма на почту

        $result_uu = mysql_time_query($link, 'select email,email_notifications from r_user where id="' . ht($komy_id) . '"');
        $num_results_uu = $result_uu->num_rows;

        if ($num_results_uu != 0) {
            $row_uu = mysqli_fetch_assoc($result_uu);
            $mail_admin = trim($row_uu["email"]);

            if (((filter_var(trim($mail_admin), FILTER_VALIDATE_EMAIL)))and($row_uu["email_notifications"]==1)) {
                SMTP_MAIL($mail_ulmenu, 'password', "Новое уведомление CCM", $text, $mail_admin);

            }
        }


    }

}

function notification_mail_admin($title,$text1,$komy_id,$id_user,$link)
{
    global $notification_mail;
    if($notification_mail==1) {
        $today[0] = date("y.m.d"); //присвоено 03.12.01
        $today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17
        $date_ = $today[0] . ' ' . $today[1];

        $url_system = $_SERVER['DOCUMENT_ROOT'] . '/';
        include_once $url_system . 'module/config_mail.php';

        // отправка письма на почту
        // отправка письма на почту
        // отправка письма на почту
        $text = "<HTML>\r\n";
        $text .= "<HEAD>\r\n";
        $text .= "<META http-equiv=Content-Type content='html; charset=windows-1251'>\r\n";

        $text .= "<style type=\"text/css\">
.mail-st a {  color: #292f33; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 24px; font-weight: 300; line-height: 30px; border-bottom: 1px solid rgba(0,0,0,0.1);text-decoration: none;  }.time_notifi {color: rgba(0,0,0,0.4);
    font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 16px;}

</style>";
        $text .= "<base href=\"https://eico.atsun.ru/\">";

        $text .= "</HEAD>\r\n";
        $text .= "<BODY>\r\n";


        $text .= '<table width="100%" cellpadding="0" cellspacing="0" style="margin:0;padding:0;min-width:100%;" bgcolor="#E7E7EF"><tbody><tr><td align="center" style="padding: 0 5px;vertical-align:top;" bgcolor="#E7E7EF">';

        $text .= '<table align="center" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;margin:0 auto;direction:ltr; margin-top:40px;  margin-bottom:10px; ">
      <tbody><tr><td style="vertical-align:top; padding:30px;" bgcolor="#FFF">';


        $text .= "<br><span style=\"color: #66757f; font-family: 'Helvetica Neue Light',Helvetica,Arial,sans-serif; font-size: 16px; font-weight: 300;\">Приветствуем вас!</span><br><br>";


        $text .= '<div style=" width:100%; height:1px; border-top:1px solid #e1e8ed;"></div>';

        $text .= "<br><span class=\"mail-st\" style=\" color: #292f33; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 24px; font-weight: 300; line-height: 30px; margin: 0; padding: 0; text-align: left;\">" . $text1 . "</span><br><br>


<span style=\"color: #292f33;
    font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 16px;
    font-weight: 400;
    line-height: 22px;
    margin: 0;
    padding: 0;
    text-align: left;\">Ссылка на ваш личный кабинет: </span>

<br>
<a style=\"color:
#2c60a4;

border-bottom: 1px solid
rgba(0,0,0,0.1);

text-decoration: none;

font-size: 20px;\" href=\"https://eico.atsun.ru/notification/\">
COST CONTROL MANAGER
</a>

<br><br><br><span style=\"color: rgba(0,0,0,0.4);
    font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 12px;
    font-weight: 400;
    line-height: 19px;
    margin: 0;
    
    text-align: left;\"> Это письмо создано автоматически системой  COST CONTROL MANAGER. C уважением, Администрация <a style=\"color: rgba(0,0,0,0.4);
    
    text-decoration: none;\" href=\"https://eico.group/\">eico group</a></span>\r\n";

        $text .= "</td></tr></tbody></table>";


        $text .= "</td></tr></tbody></table>";


        $text .= "</BODY>\r\n";
        $text .= "</HTML>";


        //mail($_POST["login"],"www.ulmenu.ru: Подтверждение регистрации",$text,$header);
        // /отправка письма на почту

        $result_uu = mysql_time_query($link, 'select email,email_notifications from r_user where id="' . ht($komy_id) . '"');
        $num_results_uu = $result_uu->num_rows;

        if ($num_results_uu != 0) {
            $row_uu = mysqli_fetch_assoc($result_uu);
            $mail_admin = trim($row_uu["email"]);

            if (((filter_var(trim($mail_admin), FILTER_VALIDATE_EMAIL)))and($row_uu["email_notifications"]==1)) {
                SMTP_MAIL($mail_ulmenu, 'password', $title, $text, $mail_admin);

            }
        }


    }

}


//получение нового ключа для уведомлений пользователю
function new_key($link,$len, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
	   do {
    $string = ''; 
	
	for ($i = 0; $i < $len; $i++) 
	{ 
	   $pos = rand(0, strlen($chars)-1); 
	   $string .= $chars{$pos}; 
	}

	$results1222=mysql_time_query($link,'select count(id) as r from r_user where noti_key="'.$string.'"');
	$row1222 = mysqli_fetch_assoc($results1222);
	
	
   } while($row1222["r"]!=0);
   
	return $string; 

}


function pad($fio,$n) {
	$rr=explode(';',$fio);
	return($rr[$n]);
}

//по всем ли служебкам есть решения и притом положительные для заявок
function decision_memo_app($link,$id_naryad)
{
		$result_tx=mysql_time_query($link,'Select count(a.id) as cc from z_doc_material as a where ((a.id_sign_mem=0 and a.signedd_mem=0 and not(a.memorandum=""))or(not(a.id_sign_mem=0)and a.signedd_mem=0 and not(a.memorandum="")))and( a.id_doc="'.htmlspecialchars(trim($id_naryad)).'")');	
	   	$rowx = mysqli_fetch_assoc($result_tx);	
	
	    return ($rowx["cc"]);
}

//по всем ли служебкам есть решения и притом положительные для нарядов
function decision_memo($link,$id_naryad)
{
		$result_tx=mysql_time_query($link,'Select count(a.id) as cc from n_work as a where ((a.id_sign_mem=0 and a.signedd_mem=0)or(not(a.id_sign_mem=0)and a.signedd_mem=0))and( a.id_nariad="'.htmlspecialchars(trim($id_naryad)).'")');	
	   	$rowx = mysqli_fetch_assoc($result_tx);	


		$result_tx1=mysql_time_query($link,'SELECT  COUNT(a.id) AS cc FROM n_material AS a, n_work AS b WHERE ((a.id_sign_mem=0 AND a.signedd_mem=0)or(not(a.id_sign_mem=0)and a.signedd_mem=0))AND( b.id_nariad="'.htmlspecialchars(trim($id_naryad)).'")AND(a.id_nwork=b.id)');
	    $rowx1 = mysqli_fetch_assoc($result_tx1);
	
	    return ($rowx["cc"]+$rowx1["cc"]);
}


//количество служ. записок по наряду
function memo_count_nariad($link,$id_naryad)
{
		$result_tx=mysql_time_query($link,'Select count(a.id) as cc from n_work as a where ((a.id_sign_mem=0 and a.signedd_mem=0)or not(a.id_sign_mem=0))and( a.id_nariad="'.htmlspecialchars(trim($id_naryad)).'")');	
	   	$rowx = mysqli_fetch_assoc($result_tx);
	
	   $result_tx1=mysql_time_query($link,'SELECT  COUNT(a.id) AS cc FROM n_material AS a, n_work AS b WHERE ((a.id_sign_mem=0 AND a.signedd_mem=0)OR not(a.id_sign_mem=0))AND( b.id_nariad="'.htmlspecialchars(trim($id_naryad)).'")AND(a.id_nwork=b.id)');
	   $rowx1 = mysqli_fetch_assoc($result_tx1);
			
	
	    return ($rowx["cc"]+$rowx1["cc"]);
}

//Определяем есть ли у этого наряда подпись ниже чем сам пользователь
//вдруг он сформировал этот наряд
function down_signature($sign_level,$sign_admin,$link,$id_naryad)
{
	//echo($sign_level);
	$sign_sign=$sign_level;
	$mojno=-1; //никем не  подписан ниже
	if($sign_admin==1) {$sign_sign=4;}
	
	if($sign_sign>1)
	{	
	
		$result_tx=mysql_time_query($link,'Select a.id_signed0,a.id_signed1,a.id_signed2,a.signedd_nariad from n_nariad as a where a.id="'.htmlspecialchars(trim($id_naryad)).'"');
        $num_results_tx = $result_tx->num_rows;
	    if($num_results_tx!=0)
	    {  
		  //такая работа есть
		  $rowx = mysqli_fetch_assoc($result_tx);
			$stack_sign = -1;
			//echo($sign_sign);
			  for ($i=($sign_sign-2); $i>=0; $i--)
              {
				if($rowx["id_signed".$i]!=0)
				{
					$stack_sign=$i;
					break;
				}
					
			  }
			  if($stack_sign!=-1)
			  {
				$mojno=$stack_sign; // подписан ниже
			  }
		}
	}
	return $mojno;
}

//функция проверки что наряд не подписан им и выше
function sign_naryd_level($link,$id_user,$sign_level,$id_naryad,$sign_admin)
{
	$mojno=0;  //по умолчанию подписан им или выше или проведен
	$result_tx=mysql_time_query($link,'Select a.id_signed0,a.id_signed1,a.id_signed2,a.signedd_nariad from n_nariad as a where a.id="'.htmlspecialchars(trim($id_naryad)).'"');
    $num_results_tx = $result_tx->num_rows;
	if($num_results_tx!=0)
	  {  
		//такая работа есть
		$rowx = mysqli_fetch_assoc($result_tx);
		if($rowx["signedd_nariad"]!=1)
		{
			
			$stack_sign = 0;
			if($sign_admin!=1)
			{	
				//echo($sign_level);
			  for ($i=($sign_level-1); $i<=3; $i++)
              {
				if($rowx["id_signed".$i]!=0)
				{
					$stack_sign++;
					break;
				}
					
			  }
			  if($stack_sign==0)
			  {
				$mojno=1; //никем не подписан
			  }	
			}else
			{
				$stack_sign++;
				$mojno=1;
			}
			

		}
	  }
	
	return $mojno;
}



//составление токена для формы
function token_access_compile($var,$sale,$secret)
{
    //$sale='edit_house';
    //$var= 92
    $posl_chifra_id2=htmlspecialchars(trim($var))%10; // остаток от деления  92 - 10*9 = 2
    $timeet=time();  //1335939007
    $st_time1 = substr($timeet, 0, $posl_chifra_id2); // с 0 символа по n символ = 133
    $st_time2= substr($timeet, ((int)$posl_chifra_id2));	// c n символа до конда = 5939007

    //echo'<br>до encode -'.$secret[2].$st_time2.$st_time1.$secret[3].' получилось-'.encode_x($secret[2].$st_time2.$st_time1.$secret[3],$secret).'<br>';
    //echo'<br>до encode -'.$secret[2].$st_time2.$st_time1.$secret[3].' получилось-'.encode_x($secret[2].$st_time2.$st_time1.$secret[3],$secret).'<br>';

    return htmlspecialchars(trim($var)).'.'.md5($secret.htmlspecialchars(trim($var)).$secret[0].$sale).'.'.encode_x($secret[2].$st_time2.$st_time1.$secret[3],$secret);

    /* echo('-'.$timeet);
     echo('-'.$st_time1);
     echo('-'.$secret[2].$st_time2.$st_time1.$secret[3]);
     echo('-'.decode_x(encode_x($secret[2].$st_time2.$st_time1.$secret[3],$secret),$secret));

 $id_p=$var;
 $token1[2]=$secret[2].$st_time2.$st_time1.$secret[3];
 $strt= substr($token1[2], 1,(strlen($token1[2])-2));
 echo('-'.$strt);
 $posl_chifra_idx=$id_p%10;  // остаток от деления  92 - 10*9 = 2
 $st_time11 = substr($strt, 0, (strlen($strt)-((int)$posl_chifra_idx)));
 $st_time22= substr($strt, (strlen($strt)-((int)$posl_chifra_idx)));

 $timeform=$st_time22.$st_time11;
 echo('-'.$timeform);
*/
    //1595502658
    //15
    //  95502658


}


//проверка токена ajax формы
//true все ок
//false токен не подходит

function token_access_new($token,$sale,$id,$name_session,$minutes=30)
{
    $error_t=false;
    $v_error='';

    if(isset($_SESSION[$name_session]))
    {
        /*
            if(isset($name_session))
            {*/
        //расшифровка токена
        //расшифровка токена

        // 170.798c56e633d1d1ea045b1e5ca2779498.s 5KzioLlSmIVRL9j 5sMbF7Qn0FmKLCJpRn6Og/Vrw=

        $token1=explode(".", $token);
        //соль для данного действия
        //$sale='edit_house';

        //xGLbxvu9lOEP

        $id_p=$token1[0];
        $secr=$_SESSION[$name_session];
        //$secr=$name_session;

        $rrr=md5($secr.$id_p.$secr[0].$sale);

        //echo'/1';
        //echo'/'.$rrr;
        //echo'/'.$token1[1];

        if(($rrr==$token1[1])and($id_p==$id))
        {
            //echo'/2';
            //$dsds=$token1[2];
            //$asd=decode_x($token1[2],$secr);
            $token1[2]=decode_x($token1[2],$secr);



            //echo'<br>получили - '.$dsds.'  после  decode -'.$token1[2].'<br>';
            // echo'<br>получили - '.$dsds.'  после  decode -'.$asd.'<br>';
            $strt= substr($token1[2], 1,(strlen($token1[2])-2));
            $posl_chifra_idx=$id_p%10;  // остаток от деления  92 - 10*9 = 2
            $st_time11 = substr($strt, 0, (strlen($strt)-((int)$posl_chifra_idx)));
            $st_time22= substr($strt, (strlen($strt)-((int)$posl_chifra_idx)));

            $timeform=$st_time22.$st_time11;
            //echo('<br>'.$timeform);
            //1595452530
            //ºó9545255017
            //1595452617ºó

            $time_sei=time();
            $razn=60*$minutes; //30 минут
            if((((int)$time_sei-(int)$timeform)<=$razn)and($timeform<=$time_sei))
            {
                $error_t=true;
            } else { $v_error='time_error ('.$time_sei.' >= '.$timeform.') session = '.$secr.'';	}

        } else { $v_error='id!=id session = '.$secr.' id_token='.$id_p.' id-проверки -'.$id;	}

    } else { $v_error='session_no - '.$name_session;	}

    if($v_error!='')
    {
        global $link;

//какой то ошибка. сбрасываем secret
        $secret=rand_string_string(16);
        $_SESSION['rema'] = $secret;

        mysql_time_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")');

    }
    //echo($v_error);
    return $error_t;
}


function token_access_yes($token,$sale,$id,$minutes=30)
{
    $error_t=false;
    if(isset($_SESSION['s_t']))
    {

        //расшифровка токена
        //расшифровка токена

        $token1=explode(".", $token);
        //соль для данного действия
        //$sale='edit_house';

        $id_p=$token1[0];
        $secr=$_SESSION['s_t'];

        $rrr=md5($secr.$id_p.$secr[0].$sale);
        if(($rrr==$token1[1])and($id_p==$id))
        {
            $token1[2]=decode_x($token1[2],$secr);
            $strt= substr($token1[2], 1,(strlen($token1[2])-2));
            $posl_chifra_idx=$id_p%10;
            $st_time11 = substr($strt, 0, (strlen($strt)-$posl_chifra_idx));
            $st_time22= substr($strt, (strlen($strt)-$posl_chifra_idx));

            $timeform=$st_time22.$st_time11;
            $time_sei=time();
            $razn=60*$minutes; //30 минут
            if((($time_sei-$timeform)<=$razn)and($timeform<=$time_sei))
            {
                $error_t=true;
            }

        }

    }
    return $error_t;
}

function token_access_not($link,$token,$sale,$id,$minutes=1)
{
  $v_error='';		
  $error_t=false;
  if(isset($_SESSION['s_not']))
  {

   //расшифровка токена
   //расшифровка токена
			
   $token1=explode(".", $token);
   //соль для данного действия
   //$sale='edit_house';
			
   $id_p=$token1[0];
   $secr=$_SESSION['s_not'];

   $rrr=md5($secr.$id_p.$secr[0].$sale);
   if(($rrr==$token1[1])and($id_p==$id))
   {
	 $token1[2]=decode_x($token1[2],$secr);		
	 $strt= substr($token1[2], 1,(strlen($token1[2])-2));
	 $posl_chifra_idx=$id_p%10;
	 $st_time11 = substr($strt, 0, (strlen($strt)-$posl_chifra_idx));
     $st_time22= substr($strt, (strlen($strt)-$posl_chifra_idx));
			
     $timeform=$st_time22.$st_time11;
	 $time_sei=time();
	 $razn=60*$minutes; //30 минут
	   
	 if((($time_sei-$timeform)<=$razn)and($timeform<=$time_sei))
	 {
	  $error_t=true; 
	 } else { $v_error='time_error ($time_sei - '.$time_sei.',$timeform - '.$timeform.',$razn - '.$razn.')';	}
	
} else { $v_error='id!=id secr - '.$secr;	}
	
} else { $v_error='session_no - '.$name_session;	}
	
if($v_error!='')
{
  // mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")'); 		   
		
}	
return $error_t;
}

//добавление нужно класса к инпут полям в случае ошибки в стеке по это полю
function iclass_($name_var,$stack_error,$class_name_error)
{
   if(isset($stack_error))
   {
	$found = array_search($name_var,$stack_error);   
	if($found !== false) 
	{
	   return $class_name_error;
	} else
	{
	   return "";		
	}
   } else
	{
	   return "";
	}   
	
}


//подчеркивание красным сумм с минусом и выделение красным если нужно
function mor_class($var,$var_format,$red=0)
{
	$class='';
	if(($red==1)and($var<0))  { $class='morr1';}
	if($var<0) {  $class.=' morr'; }
	if($class!='') { return '<span class="'.$class.'">'.$var_format.'</span>';} else { return $var_format; }
	
}


function ipost_x($vars,$rows,$ret,$table=false,$name_rows=false,$link=false)
{
	
	if((isset($vars))and($vars!=''))
	{
		if(($table)and($name_rows)and($link))
		{
		  $result_i=mysql_time_query($link,'Select a.'.$name_rows.' from '.$table.' as a where a.id="'.htmlspecialchars(trim($vars)).'"');
          $num_results_i = $result_i->num_rows;
	      if($num_results_i!=0)
	      {
		     $row_i = mysqli_fetch_assoc($result_i);
			 return $row_i[$name_rows];
		  } else
		  {
			 return $ret;
		  }		  
		} else
		{
		  return htmlspecialchars(trim($vars));
		}
	} else
	{
		if($rows!='')
		{
			if(($table)and($name_rows)and($link))
		{
		  $result_i=mysql_time_query($link,'Select a.'.$name_rows.' from '.$table.' as a where a.id="'.htmlspecialchars(trim($rows)).'"');
          $num_results_i = $result_i->num_rows;
	      if($num_results_i!=0)
	      {
		     $row_i = mysqli_fetch_assoc($result_i);
			 return $row_i[$name_rows];
		  } else
		  {
			 return $ret;
		  }		  
		} else
		{
		  return $rows;
		}
		} else
		{		
	       return $ret;
		}
	}
	
}


//вывод value полей при отправле форм
//ret - значение по умолчанию "" или 0 допустим
//vars - переменная $_POST['bb'] или $_GET[]
function ipost_($vars,$ret,$table=false,$name_rows=false,$link=false)
{
	
	if((isset($vars))and($vars!=''))
	{
		if(($table)and($name_rows)and($link))
		{
		  $result_i=mysql_time_query($link,'Select a.'.$name_rows.' from '.$table.' as a where a.id="'.htmlspecialchars(trim($vars)).'"');
          $num_results_i = $result_i->num_rows;
	      if($num_results_i!=0)
	      {
		     $row_i = mysqli_fetch_assoc($result_i);
			 return $row_i[$name_rows];
		  } else
		  {
			 return "";
		  }		  
		} else
		{
		  return htmlspecialchars(trim($vars));
		}
	} else
	{
	return $ret;
	}
	
}


function dateDiff_2021($dt1, $dt2, $timeZone = 'GMT') {
    $tZone = new DateTimeZone($timeZone);
    $dt1 = new DateTime($dt1, $tZone);
    $dt2 = new DateTime($dt2, $tZone);
    $ts1 = $dt1->format('Y-m-d H:i:s');
    $ts2 = $dt2->format('Y-m-d H:i:s');
    $diff = strtotime($ts1)-strtotime($ts2);
   //$diff/= 3600*24;
    return floor($diff/60);
}

//разница дней между двумя датами
function dateDiff_1($dt1, $dt2, $timeZone = 'GMT') {
    $tZone = new DateTimeZone($timeZone);
    $dt1 = new DateTime($dt1, $tZone);
    $dt2 = new DateTime($dt2, $tZone);
    $ts1 = $dt1->format('Y-m-d');
    $ts2 = $dt2->format('Y-m-d');
    $diff = strtotime($ts1)-strtotime($ts2);
    $diff/= 3600*24;
    return floor($diff);
}

//разница дней между двумя датами по модулю
function dateDiff_($dt1, $dt2, $timeZone = 'GMT') {
    $tZone = new DateTimeZone($timeZone);
    $dt1 = new DateTime($dt1, $tZone);
    $dt2 = new DateTime($dt2, $tZone);
    $ts1 = $dt1->format('Y-m-d');
    $ts2 = $dt2->format('Y-m-d');
    $diff = abs(strtotime($ts1)-strtotime($ts2));
    $diff/= 3600*24;
    return floor($diff);
}


function send_sms($host, $port, $login, $password, $phone, $text, $sender = false, $wapurl = false )
{
    $fp = fsockopen($host, $port, $errno, $errstr);
    if (!$fp) {
        return "errno: $errno \nerrstr: $errstr\n";
    }
    fwrite($fp, "GET /messages/v2/send/" .
        "?phone=" . rawurlencode($phone) .
        "&text=" . rawurlencode($text) .
        ($sender ? "&sender=" . rawurlencode($sender) : "") .
        ($wapurl ? "&wapurl=" . rawurlencode($wapurl) : "") .
        "  HTTP/1.0\n");
    fwrite($fp, "Host: " . $host . "\r\n");
    if ($login != "") {
        fwrite($fp, "Authorization: Basic " . 
            base64_encode($login. ":" . $password) . "\n");
    }
    fwrite($fp, "\n");
    $response = "";
    while(!feof($fp)) {
        $response .= fread($fp, 1);
    }
    fclose($fp);
    list($other, $responseBody) = explode("\r\n\r\n", $response, 2);
    return $responseBody;
}

function sms_podver($link,$len, $chars = '0123456789') 
{ 
   do {
    $string = ''; 
	
	for ($i = 0; $i < $len; $i++) 
	{ 
	   if($i!=0)
	   {
	     $pos = rand(0, strlen($chars)-1); 
	   } else
	   {
		 $pos = rand(1, strlen($chars)-1);  
	   }
	   $string .= $chars{$pos}; 
	}

	$results1222=mysql_time_query($link,'select count(id) as r from poddomen_all_reserver_code where code="'.$string.'"');
	$row1222 = mysqli_fetch_assoc($results1222);
	
	
   } while($row1222["r"]!=0);
   
	return $string; 
 }


function encode_x($unencoded,$key){//Шифруем
    /*
$string=base64_encode($unencoded);//Переводим в base64
echo'<br><br>';
echo $string.'<br>';
$arr=array();//Это массив
$x=0;
	$newstr='';
while ($x++< strlen($string)) {//Цикл
$arr[$x-1] = md5(md5($key.$string[$x-1]).$key);//Почти чистый md5
$newstr = $newstr.$arr[$x-1][4].$arr[$x-1][7].$arr[$x-1][2].$arr[$x-1][8];//Склеиваем символы
    echo $newstr.'   - md5-'.$arr[$x-1].' что - '.$key.$string[$x-1].'<br>';
}
    echo'<br><br>';
return $newstr;//Вертаем строку*/

    //$string=base64_encode($unencoded);
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $key);
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', ENCRYPTION_KEY), 0, 16);
    $output = base64_encode(openssl_encrypt($unencoded, $encrypt_method, $key, 0, $iv));

    return $output;
}

function decode_x($encoded, $key){//расшифровываем
    //    150b9d7a1714bc17150b195d150b21d4c7670cff74fa38d8150b195d83f5bc17
    //Mjk5MTYyMjQzM192f55
    /*
$strofsym="qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM=";//Символы, с которых состоит base64-ключ
$x=1;
    echo'<br><br>';
    echo $encoded.'<br>';
while ($x<= strlen($strofsym)) {//Цикл
$tmp = md5(md5($key.$strofsym[$x-1]).$key);//Хеш, который соответствует символу, на который его заменят.
$encoded = str_replace($tmp[4].$tmp[7].$tmp[2].$tmp[8], $strofsym[$x-1], $encoded);//Заменяем №3,6,1,2 из хеша на символ

    echo $encoded.' что- '.$key.$strofsym[$x-1].'   - md5-'.$tmp.' - кусок -'.$tmp[4].$tmp[7].$tmp[2].$tmp[8].'  на - '.$strofsym[$x-1].'<br>';
    $x++;
}
    echo'<br><br>';
return base64_decode($encoded);//Вертаем расшифрованную строку*/

    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $key);
    //echo '<br>key - '.$key.'<br>';
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', ENCRYPTION_KEY), 0, 16);
    //echo '<br>iv - '.$iv.'<br>';
    $output = openssl_decrypt(base64_decode($encoded), $encrypt_method, $key, 0, $iv);

    return $output;


}


/*

function encode_x($unencoded,$key){//Шифруем
$string=base64_encode($unencoded);//Переводим в base64

$arr=array();//Это массив
$x=0;
while ($x++< strlen($string)) {//Цикл
$arr[$x-1] = md5(md5($key.$string[$x-1]).$key);//Почти чистый md5
$newstr = $newstr.$arr[$x-1][4].$arr[$x-1][7].$arr[$x-1][2].$arr[$x-1][8];//Склеиваем символы
}
return $newstr;//Вертаем строку
}

function decode_x($encoded, $key){//расшифровываем
$strofsym="qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM=";//Символы, с которых состоит base64-ключ
$x=0;
while ($x++<= strlen($strofsym)) {//Цикл
$tmp = md5(md5($key.$strofsym[$x-1]).$key);//Хеш, который соответствует символу, на который его заменят.
$encoded = str_replace($tmp[4].$tmp[7].$tmp[2].$tmp[8], $strofsym[$x-1], $encoded);//Заменяем №3,6,1,2 из хеша на символ
}
return base64_decode($encoded);//Вертаем расшифрованную строку
}

*/

function rand_string_string($len, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') 
 { 
    $string = ''; for ($i = 0; $i < $len; $i++) 
	{ 
	   $pos = rand(0, strlen($chars)-1); 
	   $string .= $chars{$pos}; 
	} 
	return $string; 
 } 


//удаление первого 0 у числа   02 -> 2
function null_dell($number)
{
 if($number[0]=='0')
 {
	return $number[1];
 } else
 {
 return $number;
 }
}


//переводит элементы любого массива в нужную кодировку
function iconvArray ($inputArray,$newEncoding,$oldEncoding)
{
  $outputArray=array ();
  if ($newEncoding!=''){
    if (!empty ($inputArray)){
      foreach ($inputArray as $key => $element){
         if (!is_array($element)){
			//echo(mb_detect_encoding($element));
            $element=iconv($oldEncoding,$newEncoding,$element);
         } else 
		 {
			$element=iconvArray($element, $newEncoding,$oldEncoding);
         }
         $outputArray[$key]=$element;
     }
   }   
 }
 return $outputArray;
}


//удаление из массива элемента по значению
function rm_from_array($needle, &$array, $all = true){
    if(!$all){
        if(FALSE !== $key = array_search($needle,$array)) unset($array[$key]);
        return;
    }
    foreach(array_keys($array,$needle) as $key){
        unset($array[$key]);
    }
}

function limit_spec($count,$current_position,$n_st)
{
	$limit='';
	if($n_st!=null)
	{
		$limit=' '.(($n_st-1)*$count)+$current_position.',1';
	} else
	{
	   $limit=' '.$current_position.',1';	
	}
	return $limit;
}


function current_massiv($massiv_obr,$ist)
{
	$current_position=0;
	while ($fruit_name = current($massiv_obr)) {
        if ($fruit_name == ($ist+1)) {
			$current_position=key($massiv_obr);
        }
        next($massiv_obr);
        }
		return $current_position;
}

function compare ($v1, $v2) {
    /* Сравниваем значение по ключу st */
    if ($v1["st"] == $v2["st"]) return 0;
    return ($v1["st"] < $v2["st"])? -1: 1;
  }

function hop_mass($list_start,$list_step,$count_write)
{
  $mass_pos=array();	
  $mass_pos[0]=$list_start;
  //выводить спец с шагом не меньше 3 и 3 - минимум
  for ($ist=1; $ist<=(($count_write*2)/3); $ist++)
  {	
    $mass_pos[$ist]=$mass_pos[$ist-1]+$list_step;
  }
  return $mass_pos;
}


//массив с числами меньше заданного
function mass_del(&$mass,$value)
{
  $mass_new = array();	
  
  for ($ist=0; $ist<count($mass); $ist++)
  {	
	  if($mass[$ist]<=$value)
	  {
		  $mass_new[$ist]=$mass[$ist];
	  } else
	  {
		  break;	  
	  }
  }
  return $mass_new;
  //return array ($stat,$plplpl,$award,$pro_st,$name_user,$avatar,$online,$profession);
}





//Обрезает строчку до определенного символа, с учетом слов и знаков припинания
function cat_string($string,$count)
{
	if(strlen($string)<=$count)
	{
	return $string;
	} else
	{
	$string = strip_tags($string);
    $string = substr($string, 0, $count);
    $string = rtrim($string, "!,.-:?");
    $string = substr($string, 0, strrpos($string, ' '));
    return $string." ...";
	}
}


function request_url()
{
  $result = ''; // Пока результат пуст
  $default_port = 80; // Порт по-умолчанию
 
  // А не в защищенном-ли мы соединении?
  if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
    // В защищенном! Добавим протокол...
    $result .= 'https://';
    // ...и переназначим значение порта по-умолчанию
    $default_port = 443;
  } else {
    // Обычное соединение, обычный протокол
    $result .= 'http://';
  }
  // Имя сервера, напр. site.com или www.site.com
  $result .= $_SERVER['SERVER_NAME'];
 
  // А порт у нас по-умолчанию?
  if ($_SERVER['SERVER_PORT'] != $default_port) {
    // Если нет, то добавим порт в URL
    $result .= ':'.$_SERVER['SERVER_PORT'];
  }
  // Последняя часть запроса (путь и GET-параметры).
  $result .= $_SERVER['REQUEST_URI'];
  // Уфф, вроде получилось!
  return $result;
}

//3 Марта 2017 г.
//3 Марта 2017 г. - 3 Марта 2017 г.
function date_fik($D,$D1 = '')
{	
  if($D=='') {return "";} else
  {
	  
  if($D1!='')
  {

	    $F= explode('-', $D);
	  $F1= explode('-', $D1);

  switch($F[1])
  {
   case "1": $mont="Января"; break;
   case "2": $mont="Февраля"; break;
   case "3": $mont="Марта"; break;
   case "4": $mont="Апреля"; break;
   case "5": $mont="Мая"; break;
   case "6": $mont="Июня"; break;
   case "7": $mont="Июля"; break;
   case "8": $mont="Августа"; break;
   case "9": $mont="Сентября"; break;
   case "10": $mont="Октября"; break;
   case "11": $mont="Ноября"; break;
   case "12": $mont="Декабря"; break;
  }
    switch($F1[1])
  {
   case "1": $mont1="Января"; break;
   case "2": $mont1="Февраля"; break;
   case "3": $mont1="Марта"; break;
   case "4": $mont1="Апреля"; break;
   case "5": $mont1="Мая"; break;
   case "6": $mont1="Июня"; break;
   case "7": $mont1="Июля"; break;
   case "8": $mont1="Августа"; break;
   case "9": $mont1="Сентября"; break;
   case "10": $mont1="Октября"; break;
   case "11": $mont1="Ноября"; break;
   case "12": $mont1="Декабря"; break;
  }

  $DD=date_minus_null($F[2])." ".$mont." ".$F[0]." г. - ".date_minus_null($F1[2])." ".$mont1." ".$F1[0]." г.";
  
  return $DD;
	  
  } else
	 { 
	  
  //echo($D);
  $F= explode('-', $D);

  switch($F[1])
  {
   case "1": $mont="Января"; break;
   case "2": $mont="Февраля"; break;
   case "3": $mont="Марта"; break;
   case "4": $mont="Апреля"; break;
   case "5": $mont="Мая"; break;
   case "6": $mont="Июня"; break;
   case "7": $mont="Июля"; break;
   case "8": $mont="Августа"; break;
   case "9": $mont="Сентября"; break;
   case "10": $mont="Октября"; break;
   case "11": $mont="Ноября"; break;
   case "12": $mont="Декабря"; break;
  }
  

  $DD=date_minus_null($F[2])." ".$mont." ".$F[0]." г.";
  
  return $DD;
  }
  }
}

//преобразование даты к формату 05 Декабря 2009, 14:47
function MaskDate($D)
{
  //echo($D);
  $D = explode(' ', $D);
  $F= explode('-', $D[0]);
  $G= explode(':', $D[1]);

  switch($F[1])
  {
   case "1": $mont="января"; break;
   case "2": $mont="февраля"; break;
   case "3": $mont="марта"; break;
   case "4": $mont="апреля"; break;
   case "5": $mont="мая"; break;
   case "6": $mont="июня"; break;
   case "7": $mont="июля"; break;
   case "8": $mont="августа"; break;
   case "9": $mont="сентября"; break;
   case "10": $mont="октября"; break;
   case "11": $mont="ноября"; break;
   case "12": $mont="декабря"; break;
  }
  
  if($G[0]=='')
  {
  $DD=$F[2]." ".$mont." ".$F[0];	  
  } else
  {
  
  $DD=$F[2]." ".$mont." ".$F[0]." ".$G[0].":".$G[1];
  }
  return $DD;

}

//вывод цветных комментариев
function CommentsColor($count,$class_dop)
{
  if($count!=0)
  {	
    if($count<5)
	{
	   //синий	
	   echo('<div class="comment_tip2 '.$class_dop.'">'.$count.'</div>');
	} 
    if(($count<10)and($count>=5))
	{
	   //желтый	
	   echo('<div class="comment_tip  '.$class_dop.'">'.$count.'</div>');
	} 
    if($count>=10)
	{
	   //красный
	   echo('<div class="comment_tip1  '.$class_dop.'">'.$count.'</div>');
	} 	
  }	
}
function CommentsColorAjax($count,$class_dop)
{
  if($count!=0)
  {	
    if($count<5)
	{
	   //синий	
	   return('<div class="comment_tip2 '.$class_dop.'">'.$count.'</div>');
	} 
    if(($count<10)and($count>=5))
	{
	   //желтый	
	    return('<div class="comment_tip  '.$class_dop.'">'.$count.'</div>');
	} 
    if($count>=10)
	{
	   //красный
	    return('<div class="comment_tip1  '.$class_dop.'">'.$count.'</div>');
	} 	
  }	
}


//автоматическое определение limita у sql запроса для постраничного вывода
function limitPage($varpage,$countwrite)
{
    //$varpage - название GET переменной которая передает номер страницы
    //$countwrite - количество выводимого на одной странице
    $count_otziv=0;
    $kol_st_n=0;
    if(isset($_GET[$varpage]))
    {
        if (is_numeric($_GET[$varpage])) {
            $number_st=$_GET[$varpage];
            $flag_ot=$_GET[$varpage];
        } else
        {
            $number_st=1;
            $flag_ot=1;
        }

    } else
    {
        $number_st=1;
        $flag_ot=1;
    }

    if($number_st==1)
    {
        $number_st=0;
    } else
    {
        $number_st=($number_st*$countwrite)-$countwrite;
    }

    $limit=' limit '.$number_st.','.$countwrite;

    return $limit;
}


//определение номера активной страницы для постраничного вывода
function NumberPageActive($varpage)
{
    //$varpage - название GET переменной которая передает номер страницы
    //$countwrite - количество выводимого на одной странице
    if(isset($_GET[$varpage]))
    {
        if (is_numeric($_GET[$varpage])) {
            $flag_ot=$_GET[$varpage];
        } else
        {
            $flag_ot=1;
        }

    } else
    {
        $flag_ot=1;
    }

    return $flag_ot;
}


function CountNews($sql,$link)
{
    $count_otziv=0;
    $result_st=mysql_time_query($link,$sql);
    $num_results_st = $result_st->num_rows;
    if($num_results_st<>0)
    {
        $row_st = mysqli_fetch_assoc($result_st);
        $count_otziv=$row_st['kol'];
    }
    return $count_otziv;
}


function CountPage($sql,$link,$countwrite)
{
    $count_otziv=0;
    $result_st=mysql_time_query($link,$sql);
    $num_results_st = $result_st->num_rows;
    if($num_results_st<>0)
    {
        $row_st = mysqli_fetch_assoc($result_st);
        $count_otziv=ceil($row_st['kol']/$countwrite);
    }
    return $count_otziv;
}


//функция постраничные ссылки для статей, новостей, отзывов
function displayPageLink_new($link_one,$link_start, $link_end, $flag_ot, $count_otziv,$count_list,$count_visible,$class,$type)
{
    $style='';
    /*
            http://www.ulyanovskmenu.ru/place/kedy/news.php?page=2?go=news
            ----------------------------------------------------- --------
                            $link_start                           $link_end


            http://www.ulyanovskmenu.ru/place/kedy/news/2/news/
            -------------------------------------------- ------
                            $link_start                 $link_end
            $link_start="http://www.ulyanovskmenu.ru/place/kedy/news/"
            $link_end="/news/"
    */


    //$link_one       - ссылка первой страницы (чтобы не было дублей)
    //$link_start     - начало ссылки
    //$link_end       - конец ссылки
    //$count_list     - после какого номера страницы начинать движение остальных       const=10
    //$count_visible  - количество страниц видимых (10 -  1 2 3 4 5 6 7 8 9 10 ...)    const=20
    //$flag_ot        - номер активной страницы
    //$count_otziv    - количество страниц всего
    //$class          - какой класс
    //$type           - тип вывода 1-с кнопка предыдушая-следующая   0 - с кнопка первая-последняя


    echo'<div class="pgs '.$style.'"><ul class="pgs_ul">';


    if($flag_ot<=$count_list)
    {
        //вывод если страница не больше чем когда первые страницы будут не видны
        if(($type==1)and($flag_ot!=1))
        {
            if(($flag_ot-1)==1)
            {
                echo'<li class="pgs_li lefts"><a href="'.$link_one.'"><i></i></a></li>';
            } else
            {
                echo'<li class="pgs_li lefts"><a href="'.$link_start.($flag_ot-1).$link_end.'"><i></i></a></li>';
            }
        }


        for($i=1; (($i<=$count_visible)and($i<=$count_otziv)); $i++)
        {
            if($flag_ot==$i) { echo"<li class='pgs_li here'>".$i."</li>"; }
            else {
                if($i==1)
                {
                    echo"<li class='pgs_li'><a href='".$link_one."'>".$i."</a></li>";
                } else
                {
                    echo"<li class='pgs_li'><a href='".$link_start.$i.$link_end."'>".$i."</a></li>";
                }
            }
        }
        if(($i<$count_otziv)and($type==0)) { echo"<li class='pgs_li end'><a href='".$link_start.$i.$link_end."'>...</a></li>";	}


        if(($type==1)and($flag_ot!=$count_otziv))
        {
            echo'<li class="pgs_li rights"><a href="'.$link_start.($flag_ot+1).$link_end.'"><i></i></a></li>';
        }

    }
    else
    {

        if(($flag_ot+$count_list)<=$count_otziv)
        {

            $end_st=$flag_ot-$count_list;

            if($type==0)
            {
                if($end_st==1)
                {
                    echo"<li class='pgs_li end'><a href='".$link_one."'>...</a></li>";
                } else
                {
                    echo"<li class='pgs_li end'><a href='".$link_start.$end_st.$link_end."'>...</a></li>";
                }
            }
            if(($type==1)and($flag_ot!=1))
            {
                if(($flag_ot-1)==1)
                {
                    echo'<li class="pgs_li lefts"><a href="'.$link_one.'"><i></i></a></li>';
                } else
                {
                    echo'<li class="pgs_li lefts"><a href="'.$link_start.($flag_ot-1).$link_end.'"><i></i></a></li>';
                }
            }


            for($i=($end_st+1); (($i<=($count_visible+$end_st))and($i<=$count_otziv)); $i++)
            {
                if($flag_ot==$i) { echo"<li class='pgs_li here'>".$i."</li>"; }
                else {

                    //echo"<li class='pgs_li'><a href='".$link_start.$i.$link_end."'>".$i."</a></li>";
                    if($i==1)
                    {
                        echo"<li class='pgs_li'><a href='".$link_one."'>".$i."</a></li>";
                    } else
                    {
                        echo"<li class='pgs_li'><a href='".$link_start.$i.$link_end."'>".$i."</a></li>";
                    }


                }
            }
            if(($i<=$count_otziv)and($type==0)) { echo"<li class='pgs_li end'><a href='".$link_start.$i.$link_end."'>...</a></li>";	}

            if((($flag_ot+1)<=$count_otziv)and($type==1)) { echo"<li class='pgs_li rights'><a href='".$link_start.($flag_ot+1).$link_end."'><i></i></a></li>";	}



        } else
        {
            $end_st=$count_otziv-$count_visible;
            if($end_st<0)
            {
                $end_st=0;
            }
            if(($end_st>0)and($type==0))
            {
                if($end_st==1)
                {
                    echo"<li class='pgs_li end'><a href='".$link_one."'>...</a></li>";
                } else
                {
                    echo"<li class='pgs_li end'><a href='".$link_start.$end_st.$link_end."'>...</a></li>";
                }
            }


            if(($type==1)and(($flag_ot-1)>=1))
            {
                /*
            if(($end_st>0)and($type==1))
            {
                */
                if(($flag_ot-1)==1)
                {
                    echo"<li class='pgs_li lefts'><a href='".$link_one."'><i></i></a></li>";
                } else
                {
                    echo"<li class='pgs_li lefts'><a href='".$link_start.($flag_ot-1).$link_end."'><i></i></a></li>";
                }
            }

            for($i=($end_st+1); (($i<=($count_visible+$end_st))and($i<=$count_otziv)); $i++)
            {
                if($flag_ot==$i) { echo"<li class='pgs_li here'>".$i."</li>"; }
                else {

                    if($i==1)
                    {
                        echo"<li class='pgs_li'><a href='".$link_one."'>".$i."</a></li>";
                    } else
                    {
                        echo"<li class='pgs_li'><a href='".$link_start.$i.$link_end."'>".$i."</a></li>";
                    }

                }
            }

            if((($flag_ot+1)<=$count_otziv)and($type==1)) { echo"<li class='pgs_li rights'><a href='".$link_start.($flag_ot+1).$link_end."'><i></i></a></li>";	}

        }
    }
    echo'</ul></div>';
}





function EmailNameNik($email,$name,$nik)
{
	$namess=$nik;
	if($nik=='')
	{
		if($name=='')
		{
			$namess=$email;
		} else
		{
			$namess=$name;
		}
	}
	return $namess;
}

function MaskDate_D_M_Y_ss($D)
{
  if($D!='')	
  {
  //echo($D);
  $D = explode('-', $D);

  $DD=$D[2].".".$D[1].".".$D[0];
  return $DD;
  } else
  {
	 return ''; 
  }

}


function infoUser_new(&$USER,$id_us,$link)
{
$USER=array(); 	

/*
status            //статус пользователя
profession        //деятельность фотограф, ресторатор, программист
online            //онлайн или нет
avatar            //аватар
avatar_info       
avatar_rand
avatar_rand_sm
award             //медали
name_user         //имя или ник
pro_st            //про иконки
firstname         //имя
lastname          //фамилия
nik               //никнейм
birthday          //день рождение
city              //город
pol               //пол
key               //ключ для отправки сообщений
workers           //работник компании или нет. A - администратор 1 - работник компании 0 - обычный пользователь
*/

$USER["status"]='';  
$USER["key"]='';    
$USER["profession"]=''; 
$USER["award"]='';      
$USER["pro_st"]='';     
$USER["name_user"]='';
$USER["pol"]=0; 
$USER["nik"]='';
$USER["birthday"]='0000-00-00'; 
$USER["city"]='';   
$USER["workers"]='0'; 
$USER["last_visit"]='0000-00-00'; 


   $result_authority=mysql_time_query($link,'select C.nik,C.namess,C.last_visit,C.workers,C.avatar, C.avatar_rand_sm, A.*,B.name from users_authority as A,users_profession as B,users as C where C.id=A.id_users AND A.profession=B.id  AND A.id_users="'.$id_us.'"');
   $num_results_authority = $result_authority->num_rows; 
   
   if($num_results_authority<>0)
   {
	   $row_authority = mysqli_fetch_assoc($result_authority);
	   $USER["last_visit"]=$row_authority["last_visit"];
	   $USER["rating"]=0;
	   
	   

	   $USER["avatar"]=0;
	   $USER["avatar"]=$row_authority["avatar"];
	   $USER["avatar_rand_sm"]=$row_authority["avatar_rand_sm"];
	   /////////////////////////////////////////////////////////////////////
       if($row_authority["status"]=="0")
	   {
		  //если конкретный статус не установлен , определяем его по рейтингу типа заведения
		  //если ты в разделе "сауны" у тебя один статус в этом ты профи, но в тоже время ты можешь быть не профи в боулинге или кафе.
		  $USER["rating"]=0;
		  $result_importance1=mysql_time_query($link,'select rest_rating as rrr from users_rating where id_users="'.$id_us.'"');
          $num_results_importance1 = $result_importance1->num_rows;
		  if($num_results_importance1<>0)
		  {
			  $row_importance1 = mysqli_fetch_assoc($result_importance1);
			  $USER["rating"]=$row_importance1["rrr"];
		  }
          if($USER["rating"]!=0)
		  {
            $row_status = mysqli_fetch_assoc(mysql_time_query($link,'select * from users_status_const where start_limit<="'.$rating_200.'" order by end_limit desc limit 0,1'));
		    $USER["status"]=$row_status["name"];
		  } else
		  {
			$USER["status"]="аноним";  
		  }		  
		  
	   } else
	   {
		  $USER["status"]=$row_authority["status"];
		  
		  $result_importance1=mysql_time_query($link,'select rest_rating as rrr from users_rating where id_users="'.$id_us.'"');
          $num_results_importance1 = $result_importance1->num_rows;
		  if($num_results_importance1<>0)
		  {
			  $row_importance1 = mysqli_fetch_assoc($result_importance1);
			  $USER["rating"]=$row_importance1["rrr"];
		  }		  
		  
	   }
       $USER["profession"]=$row_authority["name"]; 	   
       if($row_authority["nik"]!="")
	   {
		 $USER["name_user"]=$row_authority["nik"];
	   } else
	   {
		 $USER["name_user"]=$row_authority["namess"];
		 
		 
		 
	   }
	   $USER["nik"]=$row_authority["nik"];  
	   $USER["workers"]=$row_authority["workers"];  	   
	   
	   //$name_user='<a  href="http://www.ulyanovskmenu.ru/users/'.$id_us.'/">'.$name_user.'</a>';
   //}
	   
	   $plplpl='';

	   if($row_authority["award"]!=0)
	   {	   
	      $award="";

          $result_award1=mysql_time_query($link,'select * from users_award as A where A.id IN ('.$row_authority["award"].')');

          $num_results_award1 = $result_award1->num_rows;

	      for ($iaw=0; $iaw<$num_results_award1; $iaw++)
          {
		    $row_award1 = mysqli_fetch_assoc($result_award1);
			
			if($iaw==0)
			{
					   $USER["award"]=$USER["award"].'<img onmouseover="ShowCloud( \''.$row_award1["text"].'\' );" onmouseout="HideCloud();" border=0  src="'.$row_award1["img_link"].'"/>';				
			} else
			{
			
					   $USER["award"]=$USER["award"].'<img onmouseover="ShowCloud( \''.$row_award1["text"].'\' );" onmouseout="HideCloud();" border=0 style=" padding-left:4px; " src="'.$row_award1["img_link"].'"/>';
			}
		  }
	   } else
	   {
		  $USER["award"]="";
	   }

	   /////////////////////////////////////////////////////////////////////
	   if($row_authority["pro"]!=0)
	   {	
          $pro_st="";

          $result_pro1=mysql_time_query($link,'select * from users_pro as A where A.id IN ('.$row_authority["pro"].')');
          $num_results_pro1 = $result_pro1->num_rows;

	      for ($ipr=0; $ipr<$num_results_pro1; $ipr++)
          {
		    $row_pro1 = mysqli_fetch_assoc($result_pro1);
			
			if($ipr==0)
			{
			$USER["pro_st"]=$USER["pro_st"].'<img onmouseover="ShowCloud( \''.$row_pro1["text"].'\' );" onmouseout="HideCloud();" border=0 src="'.$row_pro1["img_link"].'"/>';
			} else
			{			
			$USER["pro_st"]=$USER["pro_st"].'<img onmouseover="ShowCloud( \''.$row_pro1["text"].'\' );" onmouseout="HideCloud();" border=0 style=" padding-left:4px; " src="'.$row_pro1["img_link"].'"/>';
			}

		  }	   	   
	   } else
	   {
		  $USER["pro_st"]="";   
	   }


   }
   

   
   return $USER;	
}


//обход функции rand() в mysql для более быстрого выполнения запросов
//$link
//$sql - обычный sql запрос без limit и rand. Обязательно перед главным from ставить указатель **
//$rand - количество элементов которые надо получить
function  mysql_time_query_rand($link,$sql,$rand)
{
   $sql1='';
   //перевести запрос во все маленькие буквы
   $sql = mb_strtolower($sql);
   //удалить кусок до части from
   list($j,$sql1) = explode("**", $sql);
   $result_1 = mysql_time_query($link,"SELECT count(*) as b ".$sql1);
   $row_1 = mysqli_fetch_assoc($result_1);
   $row_count=$row_1["b"];
   $result_1->close();
   if(($row_count-$rand)<0)
   {
	 $rand_row = 0;   
   } else
   {
     $rand_row = rand(0, ($row_count-$rand));
   }
   $result_tany=mysql_time_query($link,$j.''.$sql1." limit ".$rand_row.",".$rand);
   //echo($j.''.$sql1." limit ".$rand_row.",".$rand);
   return $result_tany;
}


//поиск в кукки нужно переменной и значения разделенные каким то разделителем
//возвращает или false если нет такого значения или true соответственно
//если $work = add то если нет то добавится если же $work=0 то просто проверится есть или нет

function cookie_work ($var,$value,$explode,$hour,$work)
{
        $kk=0;$Po='';$hh=0;		
		if ( isset($_COOKIE[$var]))
		{
		   $D = explode($explode, $_COOKIE[$var]);
           for ($i=0; $i<count($D); $i++)
		   {
		      $hh=1;
			  if($D[$i]==$value) { $kk=1;}
		   }
		}
		//echo($work);
		//сессия существует но такого значения в ней нет
		if($work=='add')
		{
		if(($kk==0)and($hh==1))
		{
		   for ($i=0; $i<count($D); $i++)
		   { 
		      if($i==0)
			  {
			     $Po=$D[$i];
			  } else
			  {
			    $Po=$Po.'.'.$D[$i];
			  }
		    
		   }
		   $Po=$Po.'.'.$value;		   
		   setcookie ($var, $Po,mktime (date("H")+$hour),"/");

		}
		
		
		//сессии нет вообще
		if($hh==0)
		{
		  $Po=$value;
		   setcookie ($var, $Po,mktime (date("H")+$hour),"/");		   		  
		}
		}
	
	if($kk==1)
	{
		return true;
	} else
	{
	    return false;	
	}
	
}

//убрать первый 0 для часов
//02 - 2
//12 - 12
function date_minus_null($time) 
{ 
   if($time[0]==0)
   {
	 return   $time[1]; 
   } else
   {
	  return   $time;  
   }
}


//проверка осталось ли до даты меньше чем step дней
function time_compare_step($date_time,$clock_region,$step) 
{ 
//0 - прошло
//1 - не прошло

	
	
	
//2011-01-19 15:07:31

if($date_time!=null)
{
	
	
$date_elements  = explode(" ",$date_time);
$date_elements1  = explode(":",$date_elements[1]);
$date_elements2  = explode("-",$date_elements[0]);

$date_elements2=date("Y", mktime($date_elements1[0], $date_elements1[1], $date_elements1[2], $date_elements2[1],($date_elements2[2]-$step), $date_elements2[0])).'-'.date("m", mktime($date_elements1[0], $date_elements1[1], $date_elements1[2], $date_elements2[1],($date_elements2[2]-$step), $date_elements2[0])).'-'.date("d", mktime($date_elements1[0], $date_elements1[1], $date_elements1[2], $date_elements2[1],($date_elements2[2]-$step), $date_elements2[0]));		

$date_elements2	 = explode("-",$date_elements2);
//echo(date_minus_null($date_elements1[0])+1);

$session_time=mktime((date_minus_null($date_elements1[0])-$clock_region), $date_elements1[1], $date_elements1[2], $date_elements2[1], $date_elements2[2], $date_elements2[0]);
$time_difference = time() - $session_time; 
$minutes = round($time_difference / 60 );
//echo($minutes);
//Minutes
$vremy=0;
if($minutes <=0)
{
	$vremy=1;
}
return $vremy;
} else
{
	return 1;
}
} 

//проверка прошло ли событие или нет
function time_compare($date_time,$clock_region) 
{ 
//0 - прошло
//1 - не прошло

//2011-01-19 15:07:31

if($date_time!=null)
{

$date_elements  = explode(" ",$date_time);
$date_elements1  = explode(":",$date_elements[1]);
$date_elements2  = explode("-",$date_elements[0]);

//echo(date_minus_null($date_elements1[0])+1);

$session_time=mktime((date_minus_null($date_elements1[0])-$clock_region), $date_elements1[1], $date_elements1[2], $date_elements2[1], $date_elements2[2], $date_elements2[0]);
$time_difference = time() - $session_time; 
$minutes = round($time_difference / 60 );
//echo($minutes);
//Minutes
$vremy=0;
if($minutes <=0)
{
	$vremy=1;
}
return $vremy;
} else
{
	return 1;
}
} 

function month_rus($mon)
{
	switch($mon)
   {
   case "01": { $montw1="января";  break; }
   case "02": { $montw1="февраля"; break; }
   case "03": { $montw1="марта"; break; }
   case "04": {  $montw1="апреля"; break; }
   case "05": {  $montw1="мая"; break; }
   case "06": {  $montw1="июня"; break; }
   case "07": {   $montw1="июля"; break; }
   case "08": {  $montw1="августа"; break; }
   case "09": { $montw1="сентября"; break; }
   case "10": {  $montw1="октября"; break; }
   case "11": {  $montw1="ноября"; break; }
   case "12": {   $montw1="декабря"; break; }
   }
   return  $montw1;
}


//приведение даты к виду сегодня, вчера, или когда то там
function time_stamp_mess($date_time) 
{ 

//2011-01-19 15:07:31
//->>
	
$date_elements  = explode(" ",$date_time);
$date_elements1  = explode(":",$date_elements[1]);
$date_elements2  = explode("-",$date_elements[0]);


$session_time=mktime($date_elements1[0], $date_elements1[1], $date_elements1[2], $date_elements2[1], $date_elements2[2], $date_elements2[0]);
$time_difference = time() - $session_time; 
$minutes = round($time_difference / 60 );
//Minutes
$vremy='';


//проверяем сегодня ли это было
if($date_elements[0]==date("Y").'-'.date("m").'-'.date("d"))
{
      $vremy="сегодня";
	  return $vremy;	
}

//проверяем вчера ли это было
if($date_elements[0]==date("Y", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")-1), date("Y"))).'-'.date("m", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")-1), date("Y"))).'-'.date("d", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")-1), date("Y"))))
{
      $vremy="вчера";
	  return $vremy;	
}

//в этом ли году
//echo($date_elements2[0]);	
if($date_elements2[0]==date("Y"))
{
   $montw1='';
   switch($date_elements2[1])
   {
   case "01": { $montw1="января";  break; }
   case "02": { $montw1="февраля"; break; }
   case "03": { $montw1="марта"; break; }
   case "04": {  $montw1="апреля"; break; }
   case "05": {  $montw1="мая"; break; }
   case "06": {  $montw1="июня"; break; }
   case "07": {   $montw1="июля"; break; }
   case "08": {  $montw1="августа"; break; }
   case "09": { $montw1="сентября"; break; }
   case "10": {  $montw1="октября"; break; }
   case "11": {  $montw1="ноября"; break; }
   case "12": {   $montw1="декабря"; break; }
   }
	
	
      $vremy=$date_elements2[2]." ".$montw1;
	  return $vremy;	 	
} else
{
	
   $montw1='';
   switch($date_elements2[1])
   {
   case "01": { $montw1="января";  break; }
   case "02": { $montw1="февраля"; break; }
   case "03": { $montw1="марта"; break; }
   case "04": {  $montw1="апреля"; break; }
   case "05": {  $montw1="мая"; break; }
   case "06": {  $montw1="июня"; break; }
   case "07": {   $montw1="июля"; break; }
   case "08": {  $montw1="августа"; break; }
   case "09": { $montw1="сентября"; break; }
   case "10": {  $montw1="октября"; break; }
   case "11": {  $montw1="ноября"; break; }
   case "12": {   $montw1="декабря"; break; }
   }	
	
      $vremy=$date_elements2[2]." ".$montw1." ".$date_elements2[0];
	  return $vremy;	
}

} 

//функция какая дата будет через step дней
//2018-03-19 5дней -> 2018-03-24
function date_step($date,$day)
{
	$date_elements2  = explode("-",$date);
	
	
	$date_new=date("Y", mktime(date("G"), date("i"), date("s"), $date_elements2[1],($date_elements2[2]+$day), $date_elements2[0])).'-'.date("m", mktime(date("G"), date("i"), date("s"), $date_elements2[1],($date_elements2[2]+$day), $date_elements2[0])).'-'.date("d", mktime(date("G"), date("i"), date("s"), $date_elements2[1],($date_elements2[2]+$day), $date_elements2[0]));
	return $date_new;
}


//приведение даты к виду  - 14:25
function time_stamp_time($date_time) 
{ 

//2011-01-19 15:07:31
//->>
	
$date_elements  = explode(" ",$date_time);
$date_elements1  = explode(":",$date_elements[1]);
$date_elements2  = explode("-",$date_elements[0]);



	  return $date_elements1[0].':'.$date_elements1[1];	


} 


//приведение даты к виду 5,10,15,20,25 минут назад и так далее
function time_stamp($date_time) 
{ 

//2011-01-19 15:07:31
//->>
	
$date_elements  = explode(" ",$date_time);
$date_elements1  = explode(":",$date_elements[1]);
$date_elements2  = explode("-",$date_elements[0]);


$session_time=mktime($date_elements1[0], $date_elements1[1], $date_elements1[2], $date_elements2[1], $date_elements2[2], $date_elements2[0]);
$time_difference = time() - $session_time; 
$minutes = round($time_difference / 60 );
//Minutes
$vremy='';

if($minutes <=180)
{


   if($minutes<=10)
   {
      $vremy="5 минут назад";
	  return $vremy;
   }

   if($minutes<=15)
   {
      $vremy="10 минут назад";
	  return $vremy;
   }
   if($minutes<=20)
   {
      $vremy="15 минут назад";
	  return $vremy;
   }
   if($minutes<=25)
   {
      $vremy="20 минут назад";
	  return $vremy;
   }
   if($minutes<=30)
   {
      $vremy="25 минут назад";
	  return $vremy;
   }   
   if($minutes<=60)
   {
      $vremy="полчаса назад";
	  return $vremy;
   }
   if($minutes<=90)
   {
      $vremy="час назад";
	  return $vremy;
   }  
   if($minutes<=120)
   {
      $vremy="полтора часа назад";
	  return $vremy;
   } 
   
   if($minutes<=180)
   {
      $vremy="два часа назад";
	  return $vremy;
   }   

      $vremy="три часа назад";
	  return $vremy;
}

//проверяем сегодня ли это было
if($date_elements[0]==date("Y").'-'.date("m").'-'.date("d"))
{
      $vremy="сегодня в ".$date_elements1[0].':'.$date_elements1[1];
	  return $vremy;	
}

//проверяем вчера ли это было
if($date_elements[0]==date("Y", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")-1), date("Y"))).'-'.date("m", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")-1), date("Y"))).'-'.date("d", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")-1), date("Y"))))
{
      $vremy="вчера в ".$date_elements1[0].':'.$date_elements1[1];
	  return $vremy;	
}

//в этом ли году
//echo($date_elements2[0]);	
if($date_elements2[0]==date("Y"))
{
	//echo("!");
   $montw1='';
   switch($date_elements2[1])
   {
   case "01": { $montw1="января";  break; }
   case "02": { $montw1="февраля"; break; }
   case "03": { $montw1="марта"; break; }
   case "04": {  $montw1="апреля"; break; }
   case "05": {  $montw1="мая"; break; }
   case "06": {  $montw1="июня"; break; }
   case "07": {   $montw1="июля"; break; }
   case "08": {  $montw1="августа"; break; }
   case "09": { $montw1="сентября"; break; }
   case "10": {  $montw1="октября"; break; }
   case "11": {  $montw1="ноября"; break; }
   case "12": {   $montw1="декабря"; break; }
   }
	
	
      $vremy=$date_elements2[2]." ".$montw1." в ".$date_elements1[0].':'.$date_elements1[1];
	  return $vremy;	 	
} else
{
	
   $montw1='';
   switch($date_elements2[1])
   {
   case "01": { $montw1="января";  break; }
   case "02": { $montw1="февраля"; break; }
   case "03": { $montw1="марта"; break; }
   case "04": {  $montw1="апреля"; break; }
   case "05": {  $montw1="мая"; break; }
   case "06": {  $montw1="июня"; break; }
   case "07": {   $montw1="июля"; break; }
   case "08": {  $montw1="августа"; break; }
   case "09": { $montw1="сентября"; break; }
   case "10": {  $montw1="октября"; break; }
   case "11": {  $montw1="ноября"; break; }
   case "12": {   $montw1="декабря"; break; }
   }	
	
      $vremy=$date_elements2[2]." ".$montw1." ".$date_elements2[0]." в ".$date_elements1[0].':'.$date_elements1[1];
	  return $vremy;	
}

} 

/*комментарии*/

/*Смотрим нет ли в тексте ссылок и скриптов*/
function SpamLog($input)
{
  $spam=0;
  $r =array("<a","<?","?>","<\a","<A","<\A","<script","<\script","<SCRIPT");
  for ($i=0; $i<4; $i++)
  {
    if(substr_count(strtolower($input),$r[$i])!=0)
    {
      $spam=1;	 
    }

  }
  return $spam;
}

//проверяет нет ли в тексте слов больше 100 символов, относить такие тексты к спаму
function SpamLine($input)
{
  $spam=0;
  $slova  = explode(" ",$input);
  for ($i=0; $i<count($slova); $i++)
  {
	if(strlen($slova[$i])>100)
    {
      $spam=1;	  
    }

  }

  return $spam;
}
/*  закрытие и открытие тегов в полученной строке*/
function searchtags( $html )
{
    $spam=0;
	preg_match_all ( "#<([/]{0,1}[a-z]+)( .*)?(?!/)>#iU", $html, $result );
    $openedtags = $result[1];
 
	$len_opened = count ( $openedtags );
	if($len_opened!=0)
	{
		$spam=1;
	}
   return $spam;
}
function del_spec_tag($input)
{

// $document на выходе должен содержать HTML-документ. 
// Необходимо удалить все HTML-теги, секции javascript, 
// пробельные символы. Также необходимо заменить некоторые 
// HTML-сущности на их эквивалент. 

$search = array ("'<script[^>]*?>.*?</script>'si",  // Вырезает javaScript 
                 "'<[\/\!]*?[^<>]*?>'si",           // Вырезает HTML-теги 
                 "'([\r\n])[\s]+'",                 // Вырезает пробельные символы 
                 "'&(quot|#34);'i",                 // Заменяет HTML-сущности 
                 "'&(amp|#38);'i", 
                 "'&(lt|#60);'i", 
                 "'&(gt|#62);'i", 
                 "'&(nbsp|#160);'i", 
                 "'&(iexcl|#161);'i", 
                 "'&(cent|#162);'i", 
                 "'&(pound|#163);'i", 
                 "'&(copy|#169);'i", 
                 "'&#(\d+);'e",                    // интерпретировать как php-код 
                 "#\[[/]{0,1}[a-z ]+\]#");                    // интерпретировать как php-код 

$replace = array ("", 
                  "", 
                  "\\1", 
                  "\"", 
                  "&", 
                  "<", 
                  ">", 
                  " ", 
                  chr(161), 
                  chr(162), 
                  chr(163), 
                  chr(169), 
                  "chr(\\1)",
				  ""); 

$input = preg_replace($search, $replace, $input);
return $input;
}

function day_nedeli_x($number)
{

  switch($number)
   {
   case "0": {  $wr="Воскресенье";  break; }
   case "1": {  $wr="Понедельник"; break; }
   case "2": {  $wr="Вторник"; break; }
   case "3": {  $wr="Среда"; break; }
   case "4": {  $wr="Четверг"; break; }
   case "5": {  $wr="Пятница"; break; }
   case "6": {  $wr="Суббота";  break; }
   } 

	return $wr;
	
}

function NumToIndexPadej($num)
{
    $octatok=$num%10;


    $ind=2;
    if(($octatok==1)and($num!=11)) { $ind=0;  }
    if(($octatok>1)and($octatok<5)and(($num<11)or($num>14))) {  $ind=1;  }
    return $ind;

}

/*
         1    3    10
$skl='акцию,акции,акций';
 PadejNumber($count_otziv,$skl)
*/
function PadejNumber($Age,$type)
{
  $SKL=explode(',',$type);
  $ind=NumToIndexPadej($Age);
	

  return $SKL[$ind];	
}
//склеить 2 массива
function array_concat() {
	$args = func_get_args();
	foreach ($args as $ak => $av) {
		$args[$ak] = array_values($av);
	}
	return call_user_func_array('array_merge', $args);
}


?>