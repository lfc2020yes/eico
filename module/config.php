<?
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';

include_once $url_system.'module/config_time.php';
include_once $url_system.'module/version.php';

$base_usr="https://eico.atsun.ru";
$local_host="eico.atsun.ru"; //как называет домен в локалке
$base_cookie = 'eico.atsun.ru';

//для работы на локальных адресах
$local_server_x=0;
//как называет домен в локалке
$local_host = array('eico.atsun.local','eico.atsun.ru');
//адреса где могут лежать эти сайты на локалке
$local = array('D:/DOMAIN/'.$local_host[0],'C:/OpenServer/domains/'.$local_host[1]);


$number_local=array_search($_SERVER['DOCUMENT_ROOT'], $local);
if ($number_local !== false) {
    //локалка
	$local_server_x=1;
	//это какая то локальная загрузка
	$base_usr="https://".$local_host[$number_local];
	$local_host=$local_host[$number_local];
	$base_cookie = $local_host[$number_local];
}


define('ENCRYPTION_KEY', 'qeda38s23kldfgd0');
define('ENCRYPTION_KEY_TOKEN', 'ppsLKodFrgeWv321');

/*
$dblocation = "localhost";
$dbname = "is";
$dbuser = "root";
$dbpasswd = "vlad2005vladvlfcg";	
*/

/*$dblocation = "localhost";
$dbname = "atsunru_interstroi";
$dbuser = "atsunru_inter";
$dbpasswd = "inter2017";*/

/*$dblocation = "89.111.177.28";
$dbname = "atsunru_interstroi";
$dbuser = "atsunru_inter";
$dbpasswd = "inter2017";*/

//$base_cookie='eico.atsun.ru';


//$dblocation = "mysql.hosting.nic.ru";
$dblocation ="localhost";
$dbname = "atsunru_interstroi";
$dbuser = "atsunru_inter";
$dbpasswd = "inter2017";

/* Подключение к серверу MySQL */ 
$link = mysqli_connect( 
            $dblocation,  /* Хост, к которому мы подключаемся */ 
            $dbuser,       /* Имя пользователя */ 
            $dbpasswd,   /* Используемый пароль */ 
            $dbname);     /* База данных для запросов по умолчанию */ 

if (!$link) { 
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error()); 
   exit; 
} 

//mysqli_query($link,'SET NAMES cp1251');
mysqli_query($link,'SET NAMES utf8');

// mysqli_query($link,'CALL set_value_trigger(0)');
mysqli_query($link,"SET @id_user='$id_user'");

$region=1; //регион сайта
$time_sql=1; //собирать статистику
$notification_mail=1; //уведомления по email

function mysql_time_query($link,$query)
{
global $time_sql;	
if($time_sql==1){ 
  $start_time = microtime(true);
  $ti_sql=$query;	
}	
if ($result = mysqli_query($link,$query)) {
   

} else
{
	echo'ошибка в запросе - '.$query;
}

$second_write=2;  // минимум секунд выполнения запроса для записи для наблюдений

if($time_sql==1){ 
    $query_time = round(((microtime(true)-$start_time)),2);
	if($query_time>$second_write) 
	{ 
	    $today[0] = date("y.m.d"); $today[1] = date("H:i:s"); $date_=$today[0].' '.$today[1];		
		mysqli_query($link,'insert into time_sql  values ("","'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'","'.htmlspecialchars(trim($ti_sql)).'","'.$query_time.'","'.$date_.'")');
	}
}
	 
return $result;

}

?>
