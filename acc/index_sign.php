<?
//согласовать для прорабов которые заполнили всю заявку на материал но у них есть служебные записки

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

	
if((!$role->permission('Счета','R'))and($sign_admin!=1)) {

    header404(4,$echo_r);

}


if((!isset($_POST["tk1"]))or($_POST["tk1"]!='weER23DvmrIrt'))
{
    header404(99,$echo_r);
}

if((!isset($_POST["remark"]))or(trim($_POST["remark"])==''))
{
    header404(94,$echo_r);
}
//header404(94,$echo_r);
//**************************************************
$result_url=mysql_time_query($link,'select A.* from z_acc as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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


        if(!token_access_new($token,'sign_acc_remark',$id,"rema",120)) {
            header404(4, $echo_r);
        }


include_once $url_system.'/ilib/lib_interstroi.php';
include_once $url_system.'/ilib/lib_edo.php';

$edo = new EDO($link, $id_user, false);
$arr_document = $edo->my_documents(1, ht($_GET["id"]), '=0', true);
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

//изменяем статус по

$array_status=$edo->set_status($id_s, 3,ht(trim($_POST["remark"])));
if($array_status==false)
{
    header404(78, $echo_r);
}


//отправляем следующим уведомления
if (($edo->next($id, 1))===false) {

    //id_executor
    //mysql_time_query($link,'update z_doc set status="9" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
//меняем статусы у материалов на заказано
    /*
    $result_tyd1=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'"');
    $num_results_tyd1 = $result_tyd1->num_rows;

    for ($ids=0; $ids<$num_results_tyd1; $ids++)
    {
        $row_tyd1 = mysqli_fetch_assoc($result_tyd1);
        mysql_time_query($link,'update z_doc_material set status="9" where id = "'.htmlspecialchars(trim($row_tyd1['id'])).'"');
    }
*/



//echo(gettype($edo->arr_task));
    if(isset($edo->arr_task)) {
        foreach ($edo->arr_task as $key => $value) {
            //оправляем всем уведомления кому нужно рассмотреть этот документ далее


            $user_send_new = array();
            //уведомление
            array_push($user_send_new, $value["id_executor"]);

            $name_c='';
            $result_uu = mysql_time_query($link, 'select * from z_contractor where id="' . ht($row_list['id_contractor']) . '"');
            $num_results_uu = $result_uu->num_rows;

            if ($num_results_uu != 0) {
                $row_uud = mysqli_fetch_assoc($result_uu);
                $name_c='Контрагент - '.$row_uud["name"];
            }


            //если это задача на подготовить счета
            if($value["id_action"]==4)
            {

                //    $text_not = 'Вам поступила задача <a class="link-history" href="app/' . $_GET['id'] . '/">' . $row_list['name'] . '</a> - ' . $row_list1["object_name"] . ' (' . $row_town["town"] . ', ' . $row_town["kvartal"] . ')' . $value["description"];

               /* $text_not='Вам поступила задача по счету <a class="link-history" href="acc/' . $_GET['id'] . '/">' . $row_list['name'] . '</a>. '.$name_c.' ' . $value["description"].'';*/
                $text_not = 'Вам поступила задача по счету <a class="link-history" href="acc/' . $_GET['id'] . '/">№'.$value['number'].' от '.date_ex(0,$value['date']).'</a>. ' . $name_c . ' ' . $value["description"];


            } else {
                $text_not = 'Вам поступила задача по счету <a class="link-history" href="acc/' . $_GET['id'] . '/">№'.$value['number'].' от '.date_ex(0,$value['date']).'</a>. ' . $name_c . ' ' . $value["description"];
            }

            //$text_not='Поступила <strong>новая заявка на материал №'.$row_list['number'].'</strong>, от '.$name_user.', по объекту -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].'). Детали в разделе <a href="supply/">cнабжение</a>.';
            //отправка уведомления
            $user_send_new = array_unique($user_send_new);
            notification_send($text_not, $user_send_new, $id_user, $link);


        }
    }


    // echo '<pre>arr_task:'.print_r($edo->arr_task,true) .'</pre>';

    if ($edo->error == 1) {
        // в array $edo->arr_task задания на согласование
    } else {

    }
} else {
    // процесс согласования со всеми заданиями выполнен
    // echo '<pre>'.$edo->error_name[$edo->error].' - процесс согласования со всеми заданиями выполнен </pre>';
}


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
header("Location:".$base_usr."/acc/".$_GET['id'].'/yes/');


//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
	
?>