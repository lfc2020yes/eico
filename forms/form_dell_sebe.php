<?php
//форма редактирование раздела в себестоимости дома

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
include_once $url_system.'login/function_users.php';
initiate($link);


//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;



//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) == 1)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
	if((isset($_SESSION["user_id"]))and(is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
	{		
	
	    //составление секретного ключа формы
		//составление секретного ключа формы
		//соль для данного действия
		$sale='dell_prime';
		
		$posl_chifra_id2=htmlspecialchars(trim($_GET['id']))%10;
		$timeet=time();  //1335939007
		$st_time1 = substr($timeet, 0, $posl_chifra_id2);
        $st_time2= substr($timeet, $posl_chifra_id2);		
		$token=htmlspecialchars(trim($_GET['id'])).'.'.md5($secret.htmlspecialchars(trim($_GET['id'])).$secret[0].$sale).'.'.encode_x($secret[2].$st_time2.$st_time1.$secret[3],$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   
	   $result_t=mysql_time_query($link,'Select a.object_name from i_object as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal eddd1"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Удаление себестоимости</span></h1>';

		
		
		
echo'<div class="comme">Вы точно хотите удалить всю себестоимость к объекту <b>"'.$row_t["object_name"].'"</b> и все его компоненты?</div>';
		
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           
<div id="yes_sd" class="save_button"><i>Удалить</i></div>
<div id="no_rd" class="no_button"><i>Отменить</i></div>            
 </div>           
<input type=hidden name="ref" value="00">
            </form>
            </span></div>
            
            </div>		
<?
	  }
	
	}
}
if($status==0)
{
	//что то не так. Почему то бронировать нельзя
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();	
}
/*

						 $datetime1 = date_create('Y-m-d');
                         $datetime2 = date_create('2017-01-17');
						 
                         $interval = date_create(date('Y-m-d'))->diff( $datetime2	);				 
                         $date_plus=$interval->days;
						 */
						 //echo(dateDiff_(date('Y-m-d'),'2017-01-17'));
						 


?>
<script type="text/javascript">initializeTimer();</script>
<?
include_once $url_system.'template/form_js.php';
?>

