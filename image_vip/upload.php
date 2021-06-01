<?
set_time_limit(300); //файл должен загрузиться за 5 минут
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
//include_once $url_system.'module/ajax_access.php';
session_start();
//подключение к базе
include_once $url_system.'module/config.php';





$uploaddir = $_SERVER["DOCUMENT_ROOT"].'/image_vip/scan/';
$file_na=$_POST["id"].'_'.$_FILES['thefile']['name'];				 
$uploadfile = $uploaddir.$file_na;


if (move_uploaded_file($_FILES['thefile']['tmp_name'], $uploadfile)) {
  //загрузился
  //mysql_time_query($link,'update c_cash set sign_rco="'.$id_user.'",status=1,file_name="'.htmlspecialchars(trim($file_na)).'" where id = "'.htmlspecialchars(trim($_POST['id'])).'"');
	
} else
{
	$v_error='1';	
}

?>