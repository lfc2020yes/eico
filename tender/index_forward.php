<?
//переслать заявку на другого

session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; include_once $url_system.'module/config.php'; include_once $url_system.'module/function.php'; include_once $url_system.'login/function_users.php'; initiate($link); include_once $url_system.'module/access.php';

//правам к просмотру к действиям
$hie = new hierarchy($link,$id_user);
//echo($id_user);
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


$role->GetColumns();
$role->GetRows();
$role->GetPermission();



//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /finery/plus/28/
//     0   1     2  3
$error=0;
$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

$echo_r=1; //выводить или нет ошибку 0 -нет
//**************************************************
if ( count($_GET) != 1 )
{
    header404(1,$echo_r);
}
//**************************************************
if($D_404[4]!='')
{
    header404(2,$echo_r);
}
//**************************************************
if(!isset($_GET["id"]))
{
    header404(3,$echo_r);
}
if((!isset($_SESSION["user_id"]))or(!is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
{
    header404(31,$echo_r);
}

	
if((!$role->permission('Тендеры','R'))and($sign_admin!=1)) {

    header404(4,$echo_r);

}


if((!isset($_POST["tk1"]))or($_POST["tk1"]!='weER23Dvmrtrr'))
{
    header404(99,$echo_r);
}

if((!isset($_POST["forward_id"]))or(trim($_POST["forward_id"])==''))
{
    header404(94,$echo_r);
}



//header404(94,$echo_r);
//**************************************************
$result_url=mysql_time_query($link,'select A.* from z_tender as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_custom_url = $result_url->num_rows;
if($num_results_custom_url==0)
{
    header404(6,$echo_r);
} else
{
    $row_list = mysqli_fetch_assoc($result_url);
}


	$token=htmlspecialchars($_POST['tk']);
	$id=htmlspecialchars($_GET['id']);


        if(!token_access_new($token,'sign_tender_forward_2',$id,"rema",120)) {
            header404(490, $echo_r);
        }


include_once $url_system.'/ilib/lib_interstroi.php';
include_once $url_system.'/ilib/lib_edo.php';

$edo = new EDO($link, $id_user, false);
$arr_document = $edo->my_documents(4, ht($_GET["id"]), '=0', true);
//echo '<pre>arr_document:' . print_r($arr_document, true) . '</pre>';

 $id_s=0;
foreach ($arr_document as $key => $value)
{
    if((is_array($value["state"]))and(!empty($value["state"]))) {

        foreach ($value["state"] as $keys => $val) {
//echo($val["id_run_item"]);
            $id_s=$val["id_s"];
            $class_by = '';
            if ($val["id_status"] != 0) {
                header404(5, $echo_r);
            }

            $but_mass = $edo->get_action($val["id_run_item"]);
        }} else
    {
        header404(6, $echo_r);
    }


}


$FUSER=new find_user($link,$value['id_object'],'R','Тендеры');
$user_send_new=$FUSER->id_user;

if (array_search($_POST["forward_id"], $user_send_new) == false) {
    header404(9999, $echo_r);
}


//изменяем статус по

$new_id = $edo->send_task( $val["id_s"] ,ht($_POST["forward_id"]));

if($new_id==false)
{
    header404(78, $echo_r);
}

//уведомление кому пересылаем заявку

//добавляем уведомления о новом наряде
//добавляем уведомления о новом наряде
//добавляем уведомления о новом наряде
$user_send= array();
$user_send_new= array();

$name_c='';
$result_uu = mysql_time_query($link, 'select * from z_tender_place where id="' . ht($row_list['id_z_tender_place']) . '"');
$num_results_uu = $result_uu->num_rows;

if ($num_results_uu != 0) {
    $row_uud = mysqli_fetch_assoc($result_uu);
    $name_c='Площадка - '.$row_uud["name"];
}

//отправляем создателю заявки что его служебные приняты и заявка изменила статус
$user_send_new= array();
array_push($user_send_new,ht($_POST["forward_id"]));
//$text_not='Ваша <a href="app/'.$value['id'].'/">Заявка №'.$value['id'].'</a> отклонена.';


$text_not='Вам поступила задача по тендеру <a class="link-history" href="tender/'.$value['id'].'/">'.$value['name'].'</a>. '.$name_c.' '.$val["descriptor_task"];


//отправка уведомления
$user_send_new= array_unique($user_send_new);
notification_send($text_not,$user_send_new,$id_user,$link);



//добавляем уведомления о новом наряде
//добавляем уведомления о новом наряде
//добавляем уведомления о новом наряде


//изменение статуса заявки
/*
mysql_time_query($link,'update z_doc set status="8" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
mysql_time_query($link,'update z_doc_material set status="8" where id_doc = "'.htmlspecialchars(trim($_GET['id'])).'"');
*/

/*
mysql_time_query($link,'update z_doc set status="3" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
				//меняем статусы у материалов у которых нет решения по служебной записки или оно отрицательное
				$result_tyd1=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'" and ((not(a.memorandum="") and a.id_sign_mem=0)or(not(a.memorandum="") and not(a.id_sign_mem=0)and a.signedd_mem=0))');
                $num_results_tyd1 = $result_tyd1->num_rows;
				
				for ($ids=0; $ids<$num_results_tyd1; $ids++)
		        {
				   $row_tyd1 = mysqli_fetch_assoc($result_tyd1);
				   mysql_time_query($link,'update z_doc_material set status="3" where id = "'.htmlspecialchars(trim($row_tyd1['id'])).'"');
				}
				   
				   
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	
				  $user_send= array();	
				  $user_send_new= array();		

				  $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_list['id_object'])).'"');
                  $num_results_custom_url = $result_url->num_rows;
                  if($num_results_custom_url!=0)
                  {
			         $row_list1 = mysqli_fetch_assoc($result_url);
		          }
					
				  $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list1["id_kvartal"].'"');
                  $num_results_custom_town = $result_town->num_rows;
                  if($num_results_custom_town!=0)
                  {
			         $row_town = mysqli_fetch_assoc($result_town);	
		          }	
				  
				  //echo($row_list['id_object']);
                $FUSER=new find_user($link,$row_list['id_object'],'S','Заявки','plan');
				  
				$user_send_new=$FUSER->id_user;
				// print_r($user_send_new);
				$text_not='Поступила новая <a href="app/'.$row_list['id'].'/">служебная записка</a> по заявке на материал №'.$row_list['number'].', от <strong>'.$name_user.'</strong>, по объекту -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);
				  
	  
				  		  
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде		  
				  
					*/
						  
						  
				       
			     


//echo($error);
header("Location:".$base_usr."/tender/".$_GET['id'].'/yes/');


//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
	
?>