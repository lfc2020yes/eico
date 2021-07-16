<?php
//на оплату счет

/*
		   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&date='+$("#date_hidden_table_gr1").val()+'&summa='+$(".summ_input_ww").val()+'&add='+add;	
*/

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;
$basket='';

$id=htmlspecialchars($_GET['id']);
$token=htmlspecialchars($_GET['tk']);

$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=1; //выводить или нет ошибку 0 -нет
$debug='';
if(!token_access_new($token,'yes_bill',$id,"rema",60))
{
    /*
}
if(!token_access_new($token,'yes_bill',$id,"s_form"))
{
    */
   $debug=h4a(111,$echo_r,$debug);
   goto end_code;	
}

//**************************************************
if (( count($_GET) != 8 ))
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
 if ((!$role->permission('Счета','U'))and($sign_admin!=1))
{
  $debug=h4a(2,$echo_r,$debug);
  goto end_code;	
}
//**************************************************
 if(!isset($_SESSION["user_id"]))
{ 
  $status_ee='reg';	
  $debug=h4a(3,$echo_r,$debug);
  goto end_code;
}
//**************************************************
if ((!isset($_GET["id"]))or((!is_numeric($_GET["id"])))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
//**************************************************


$result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t!=0)
{	
	$row_t = mysqli_fetch_assoc($result_t);
	//проверяем может ли видеть этот наряд
	if($row_t["status"]!=2)
	{ 
		$debug=h4a(5,$echo_r,$debug);
		goto end_code;
	}
} else
{
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
}


$name_c='';
$result_uu = mysql_time_query($link, 'select * from z_contractor where id="' . ht($row_t['id_contractor']) . '"');
$num_results_uu = $result_uu->num_rows;

if ($num_results_uu != 0) {

    $row_uud = mysqli_fetch_assoc($result_uu);
    $name_c='Контрагент - '.$row_uud["name"];

}

//**************************************************
if ((!isset($_GET["summa"]))or((!is_numeric($_GET["summa"])))or(($_GET["summa"]==0))) 
{
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
}

//**************************************************
$sum_ada='';
if($_GET["summa"]>$row_t['summa'])
{
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;	
}else
{
	if($_GET["summa"]!=$row_t['summa'])
   {
	   $sum_ada=$_GET["summa"];
   }
}

//**************************************************
if ((!isset($_GET["add"]))or((($_GET["add"]=='')))) 
{
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
}

//**************************************************

include_once $url_system.'/ilib/lib_interstroi.php';
include_once $url_system.'/ilib/lib_edo.php';

$edo = new EDO($link, $id_user, false);
$id_s=0;
$arr_document = $edo->my_documents(1, ht($_GET["id"]), '=0', true);
foreach ($arr_document as $key => $value) {
    if ((is_array($value["state"])) and (!empty($value["state"]))) {

        $echo_bb = '';
        foreach ($value["state"] as $keys => $val) {
            //echo($val["id_run_item"]);
            $id_s=$val["id_s"];
            $class_by = '';
            if ($val["id_status"] != 0) {
                $visible_gray = 1;  //Значит он выполнил уже и кнопки будут но просто серые
                $class_by = 'gray-bb';
            } else {
                $visible_gray = 0;  //Значит он выполнил уже и кнопки будут но просто серые
                $class_by = '';
            }

            $but_mass = $edo->get_action($val["id_run_item"]);
            if($but_mass["id_action"]!=2) {

                $debug=h4a(78,$echo_r,$debug);
                goto end_code;

            }
        }
    }
}






$date_ada='';
if ((isset($_GET["date"]))and((($_GET["date"]!='')))) 
{
	$date_ada=$_GET["date"];
}


$status_ee='ok';




$array_status=$edo->set_status($id_s, 2);
if($array_status==false)
{
    header404(78, $echo_r);
}


//отправляем следующим уведомления
if (($edo->next($id, 1))===false) {




//echo(gettype($edo->arr_task));
    if(isset($edo->arr_task)) {
        foreach ($edo->arr_task as $key => $value) {
            //оправляем всем уведомления кому нужно рассмотреть этот документ далее


            $user_send_new = array();
            //уведомление
            array_push($user_send_new, $value["id_executor"]);



            $text_not='Вам поступила задача по счету <a class="link-history" href="acc/'.$row_t['id'].'/">Счет №'.$row_t['number'].' от '.date_ex(0,$row_t['date']).'</a>. '.$name_c.' '.$value["description"];

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




if($_GET["pol"]==0)
{
    //к оплате
mysql_time_query($link,'update z_acc set status="3",path_summa="'.htmlspecialchars(trim($sum_ada)).'",date_buy="'.$date_ada.'",comment_status="'.htmlspecialchars(trim($_GET['comm'])).'" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
} else
{
    //оплатить после получения
mysql_time_query($link,'update z_acc set status="20",path_summa="'.htmlspecialchars(trim($sum_ada)).'",date_buy="'.$date_ada.'",comment_status="'.htmlspecialchars(trim($_GET['comm'])).'" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');	
}

mysql_time_query($link,'update z_doc_material_acc set path_buy="0" where id_acc = "'.htmlspecialchars(trim($_GET['id'])).'"');	       


		//уведомление создателю счету, снабженцу об изменение статуса счета на -  к оплате


if($_GET["pol"]==0)
{
		$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="3" and a.id_system=16');	
} else
{
		$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="20" and a.id_system=16');		
}
		if($result_status->num_rows!=0)
        {  
           $row_status = mysqli_fetch_assoc($result_status);
		}
        $user_send_new= array();		
		array_push($user_send_new,$row_t["id_user"]);
					
		$text_not='<a class="link-history" href="acc/'.$row_t['id'].'/">Счет №'.$row_t['number'].' от '.date_ex(0,$row_t['date']).'</a> изменил свой статус - <strong>'.$row_status["name_status"].'</strong>. '.$name_c;
		//отправка уведомления
		$user_send_new= array_unique($user_send_new);	
		notification_send($text_not,$user_send_new,$id_user,$link);	
/*
if($_GET["pol"]==0)
{      
       
        //уведомление в бухгалтерию о поступлении нового счета на оплату
        $FUSER=new find_user($link,'*','U','','buh');
		$user_send_new=$FUSER->id_user;

		$text_not='Поступил новый <strong>Счет №'.$row_t['number'].' на оплату</strong>. Оплатить можно в разделе <a href="booker/">бухгалтерия</a>.';
		//отправка уведомления
		$user_send_new= array_unique($user_send_new);	
		notification_send($text_not,$user_send_new,$id_user,$link);	

}
*/

$D = explode('.',htmlspecialchars(trim($_GET['add'])));
for ($i=0; $i<count($D); $i++)
{
	mysql_time_query($link,'update z_doc_material_acc set path_buy="1" where id = "'.$D[$i].'" and id_acc="'.htmlspecialchars(trim($_GET['id'])).'"');	
}




$result_score=mysql_time_query($link,'Select b.id,b.id_doc from z_doc_material_acc as a,z_doc_material as b where a.id_doc_material=b.id and a.id_acc="'.htmlspecialchars(trim($_GET['id'])).'" and a.path_buy=1');

				 
        $num_results_score = $result_score->num_rows;
	    if($num_results_score!=0)
	    {
	
		   for ($ss=0; $ss<$num_results_score; $ss++)
		   {			   			  			   
			   $row_score = mysqli_fetch_assoc($result_score);
			   
			   //определить есть ли у этого материала еще счета не равные 1 сохранено
			   $result_score1=mysql_time_query($link,'
			   SELECT
			   a.status
			   
			   FROM 
			   z_acc as a,
			   z_doc_material_acc as b 
			   
			   WHERE 
			   not(a.id ="'.htmlspecialchars(trim($_GET['id'])).'") and
			   a.status NOT IN ("1") and
			   b.id_acc=a.id and
			   b.path_buy=1 and
			   b.id_doc_material="'.$row_score["id"].'"
			   ');

						 
        $num_results_score1 = $result_score1->num_rows;
	    $plus=0;
		$os_status = array("3","4","20");	 
	    if($num_results_score1!=0)
	    {
       	   for ($ss1=0; $ss1<$num_results_score1; $ss1++)
		   {			   			  			   
			   $row_score1 = mysqli_fetch_assoc($result_score1);
			   
			   if(array_search($row_score1["status"],$os_status)!==false)
			   {
			     $plus++;
			   }
		   }
		}
			   
			   
			   if((($num_results_score==0)or($plus==0)))
			   {
				 //оплата - изменяем статус в заявки в материале
			     mysql_time_query($link,'update z_doc_material set status="13" where id = "'.$row_score["id"].'"');
				   
				   
				 $result_noti=mysql_time_query($link,'Select a.*,c.material from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and b.id="'.$row_score["id"].'"');

				 
        $num_results_noti = $result_noti->num_rows;
	    if($num_results_score!=0)
	    {		   			  			   
			   $row_noti = mysqli_fetch_assoc($result_noti);
			
		}
				 
		$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="13" and a.id_system=13');	
		if($result_status->num_rows!=0)
        {  
           $row_status = mysqli_fetch_assoc($result_status);
		}
		//уведомление создателю заявки об изменение статуса по одному из материалов его заявки

        $user_send_new= array();		
		array_push($user_send_new,$row_noti["id_user"]);
					
		$text_not='В вашей заявке на материал <a href="app/'.$row_noti['id'].'/">'.$row_noti['name'].'</a>, позиция <strong>'.$row_noti['material'].'</strong> изменила свой статус - <strong>'.$row_status["name_status"].'</strong>.';
				     
		//отправка уведомления
		$user_send_new= array_unique($user_send_new);	
		notification_send($text_not,$user_send_new,$id_user,$link);	 
				   
				  
				   
				   
				 //пройти по всем материалам заявки и если у всех такой статус стал то и у заявки изменить его
				  $result_score2=mysql_time_query($link,'
			   SELECT
			   b.id,
			   b.status
			   
			    
			   
			   FROM 
			   z_doc_material as b 
			   
			   WHERE 
			  
			   b.id_doc="'.$row_score["id_doc"].'"
			   
			   
			   ');

						 
        $num_results_score2= $result_score2->num_rows; 
	    if($num_results_score2!=0)
	    {
			$count_13=0;
       	   for ($ss2=0; $ss2<$num_results_score2; $ss2++)
		   {			   			  			   
			   $row_score2 = mysqli_fetch_assoc($result_score2); 
			   if($row_score2["status"]==13) { $count_13++;}
		   }
			if($count_13==$num_results_score2)
			{
				mysql_time_query($link,'update z_doc set status="13" where id = "'.$row_score["id_doc"].'"');
			}
			
		}
				   
				   
				   
			   }
			   
			   
		   }
		}

end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"ty" => $ID_D,"basket"=>$basket);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>