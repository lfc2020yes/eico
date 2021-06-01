<?
set_time_limit(300); //файл должен загрузиться за 5 минут
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
//include_once $url_system.'module/ajax_access.php';
session_start();
//подключение к базе
include_once $url_system.'module/config.php';

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
  $v_error='HTTP_HOST!=HTTP_REFERER';
	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")'); 
	
    // @header ( 'Location: ' . $config['http_home_url'] );
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
    die ();
}
     
    // echo($_SERVER['HTTP_X_REQUESTED_WITH']);
 
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    /* значит ajax-запрос */
     
    /* обрабатываем */
     
} else {
	  $v_error='HTTP_X_REQUESTED_WITH';	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")'); 

	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
}




define( '_SECRETJ', 7 );

//Проверяем чтобы доступ напрямую был закрыт для этого файла
//Пишем в файле который присоединяем в ajax
//if (!defined('_SECRETJ')){  header("HTTP/1.1 404 Not Found"); header("Status: 404 Not Found"); die(); }
//Проверяем чтобы доступ напрямую был закрыт для этого файла


//header("Content-type: application/json");

//подключение написанных функций для сайта
include_once $url_system.'module/function.php';
//проверка авторизации
include_once $url_system.'login/function_users.php'; 
initiate($link);
if((isset($_SESSION["user_id"])))
{	
 $id_user=id_key_crypt_encrypt(htmlspecialchars(trim($_SESSION['user_id'])));

 //считываем все необходимые доступы для этого пользователя
 include_once $url_system.'ilib/lib_interstroi.php'; 
 $role=new RoleUser($link,$id_user);  //создаем класс прав
 $role->GetColumns();
 $role->GetRows();
 $role->GetPermission();

 $hie = new hierarchy($link,$id_user);

$hie_object=array();
$hie_town=array();
$hie_kvartal=array();
$hie_user=array();	
$hie_object=$hie->obj;
$hie_kvartal=$hie->id_kvartal;
$hie_town=$hie->id_town;
$hie_user=$hie->user;

 $sign_level=$hie->sign_level;
 $sign_admin=$hie->admin;
} else
{

$v_error='id_session';	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")');
}

//Проверяем вдруг это взлом. смотрим есть ли такой тип, относятся ли эти условия поиска к этому типу, существует ли сортировка
//если есть n_st смотрим число ли это, append тоже проверяем

function img_name($log,$link)
{
   $result=mysql_time_query($link,'select id from z_invoice_attach where name="'.htmlspecialchars(trim($log)).'"');
   $num_results = $result->num_rows;
   if($num_results!=0)
   {         
     return true; //такой xah уже есть
   } else
   {
     return false; //такого xah еще нет
   }
}




if ((isset($_POST["id"]))and((is_numeric($_POST["id"])))) 
{
	  if(isset($_SESSION["user_id"]))
	  { 
		 //может ли читать наряды 
		 
		 if (($role->permission('Накладные','A'))or($sign_admin==1))
	     { 
			 
		   $result_t=mysql_time_query($link,'Select a.* from z_invoice as a where a.id="'.htmlspecialchars(trim($_POST['id'])).'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t!=0)
	       {	
			 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд
		     if((($row_t["status"]==1)))
		     { 
				 
			
			//проверяем. Если это не аванс то может ли столько провести человек. возможно долг уже меньше 
			//если аванс проводить в любом случае
				
	mysql_time_query($link,'INSERT INTO z_invoice_attach (id_invoice,name,type,displayOrder,visible) VALUES ("'.htmlspecialchars(trim($_POST["id"])).'","","","0","0")');
	$ID_D=mysqli_insert_id($link);		   			 		

$uploaddir = $_SERVER["DOCUMENT_ROOT"].'/invoices/scan/';
				 

do {
    $name_imgs=rand_string(20);
} while (img_name($name_imgs,$link));				 

			 
				 
//application/vnd.ms-excel
	

$allowedExts = array("pdf", "doc", "docx","jpg","jpeg","rtf","xlsx","xls"); 
$extension = end(explode(".", $_FILES["thefile"]["name"]));
				 //echo($extension);
if ( in_array(trim($extension), $allowedExts))
{   				 

$file_na=$ID_D.'_'.$name_imgs.'.'.$allowedExts[array_search(trim($extension), $allowedExts)];				 
$uploadfile = $uploaddir.$file_na;
//echo($uploadfile);	
	
if (move_uploaded_file($_FILES['thefile']['tmp_name'], $uploadfile)) {
 
	
	
	
 //загрузился
  mysql_time_query($link,'update z_invoice_attach set visible="1",name="'.$name_imgs.'",type="'.$allowedExts[array_search($extension, $allowedExts)].'" where id = "'.$ID_D.'"');
	
} else
{
	mysqli_query($link,'delete FROM z_invoice_attach where id="'.$ID_D.'"');

	$v_error='1';	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")');
					 	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
}
} else
{
		mysqli_query($link,'delete FROM z_invoice_attach where id="'.$ID_D.'"');
}

			 } else
			 {
				
				 	$v_error='2';	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")');
				 	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
			 }
			 } else
			 {
				
				 	$v_error='3';	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")');
				 	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
			 }
			 			 } else
			 {
				 
				 	$v_error='4';	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")');
				 	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
			 }
		  			 } else
			 {
				 
				 	$v_error='5';	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")');
				 	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
			 }
				 } else
			 {
				
				 	$v_error='6';	
  mysqli_query($link,'insert into v_error (module,error,date_error)  values ("'.htmlspecialchars($_SERVER['REQUEST_URI']).'","'.htmlspecialchars($v_error).'","'.date("y.m.d").' '.date("H:i:s").'")');
				 	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
			 }
?>