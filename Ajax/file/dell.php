<?php
//отправка сообщения с формы контактов

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;
$echo_r=1; //выводить или нет ошибку 0 -нет

 if ((count($_GET) != 1))
{
	    $debug=h4a(101,$echo_r,$debug);
        goto end_code;
}	


 if((!isset($_GET['id']))or($_GET['id']==''))
  {
	    $debug=h4a(100,$echo_r,$debug);
        goto end_code;
}
	
	
 $result_t=mysql_time_query($link,'Select b.id,b.for_what,b.id_object,b.type,b.name_user,b.name from image_attach as b where b.name="'.ht($_GET['id']).'" and b.visible=1');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{	
		$debug=h4a(5,$echo_r,$debug);
		goto end_code;
	
} else
{
	$row_score = mysqli_fetch_assoc($result_t);
}

if($row_score["for_what"]==8)
{

    $status_admin=0;
    $result_ss_new1 = mysql_time_query($link, 'select status_admin from trips where id="' . ht($row_score["id_object"]) . '"');
    $num_results_ss_new1 = $result_ss_new1->num_rows;

    if ($num_results_ss_new1 != 0) {

        $row_uuxx = mysqli_fetch_assoc($result_ss_new1);
        $status_admin=$row_uuxx['status_admin'];

    }
    if($status_admin!=0) {
        $debug=h4a(002,$echo_r,$debug);
        goto end_code;
    }


}



if ( ( $row_score[ 'id_object' ] != 0 )and( ( $row_score[ 'for_what' ] == 1 )or( $row_score[ 'for_what' ] == 2 ) ) ) {
  if ( ( !isset( $_SESSION[ "user_id" ] ) )or( !is_numeric( id_key_crypt_encrypt( $_SESSION[ "user_id" ] ) ) ) ) {
    $debug = h4a( 77, $echo_r, $debug );
    goto end_code;
  }
}

	  
				  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
         $status_ee='ok';			
mysql_time_query($link,'delete FROM image_attach where name="'.ht($_GET['id']).'"');

$uploaddir = $_SERVER["DOCUMENT_ROOT"].'/upload/file/';
				 
$uploadfile = $uploaddir.$row_score['id'].'_'.$_GET['id'].'.'.$row_score['type'];
	
			   
             if (file_exists($uploadfile)) {
			    unlink($uploadfile);
			 }

if((( $row_score[ 'for_what' ] == 1 )or( $row_score[ 'for_what' ] == 2 ))and( $row_score[ 'id_object' ] != 0 )and(isset( $_SESSION[ "user_id" ] ) ))
{
	
	
$result_uu=mysql_time_query($link,'select name_org,id from r_user where id="'.ht($row_score[ 'id_object' ]).'"');
   $num_results_uu = $result_uu->num_rows;

   if($num_results_uu!=0)
   {                 
	$row_uu = mysqli_fetch_assoc($result_uu);
   
	if( $row_score[ 'for_what' ] == 1 )
	{
    $text_notification.='Следующий файл в лицензии был удален: «'.$row_score["name_user"].'»<br>';
	} else
	{
	    $text_notification.='Следующий файл СРО был удален: «'.$row_score["name_user"].'»<br>';	
	}
	
$text_notification='<strong>Следующие данные участника №'.$row_uu["id"].' «'.$row_uu["name_org"].'» были изменены</strong><br>'.$text_notification; 	


//заносим в историю изменения по участнику
	   
$date_r=date("Y-m-d").' '.date("H:i:s");	   
	   
 mysql_time_query($link,'INSERT INTO r_user_history (id_user,action_history,datetimes,comment,comment_sys) VALUES ("'.$id_user.'","2","'.$date_r.'","","'.ht($text_notification).'")');

//отправляем Всем кто хочет и кому можно получать уведомление об изменении участника
$user_send_new= array();	
$user_send_new=array_merge(UserNotNumber(5,$link));
		
//array_push($user_send_new,34); 
//rm_from_array(0,$user_send_new);
//rm_from_array($id_user,$user_send_new);
$user_send_new= array_unique($user_send_new);	
notification_send_admin($text_notification,$user_send_new,0,$link);

}
}



end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee);
/*require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);
*/
echo json_encode($aRes);
?>