<?php
//добавление нового счета

/*
   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&summa='+$("#summa_soply").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&post_p='+$(".post_p").val();
	} else
	{
   var data ='url='+window.location.href+'&id='+for_id+'&tk='+$('.h111').attr('mor')+'&number='+$("#number_soply1").val()+'&summa='+$("#summa_soply").val()+'&date1='+$("#date_soply").val()+'&date2='+$("#date_soply1").val()+'&new_c='+$(".new_contractor_").val()+'&name_c='+$("#name_contractor").val()+'&address_c='+$("#address_contractor").val()+'&inn_c='+$("#inn_contractor").val();	
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
if(!token_access_new($token,'add_soply',$id,"rema",2880))
{
   $debug=h4a(111,$echo_r,$debug);
   goto end_code;	
}

//**************************************************
/*
if (( count($_GET) != 10 )&&( count($_GET) != 12 ))
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
*/
//**************************************************
 if ((!$role->permission('Счета','A'))and($sign_admin!=1))
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
if (((!isset($_COOKIE["basket_supply_".$id_user])))or($_COOKIE["basket_supply_".$id_user]==''))
{
  $debug=h4a(25,$echo_r,$debug);
  goto end_code;	
}
//**************************************************
if((htmlspecialchars(trim($_GET['number']))=='')or(htmlspecialchars(trim($_GET['date1']))==''))
{
  $debug=h4a(35,$echo_r,$debug);
  goto end_code;	
}
//**************************************************


if((isset($_GET['post_p']))and($_GET["new_c"]==0))
{
$result_t=mysql_time_query($link,'Select a.* from z_contractor as a where a.id="'.htmlspecialchars(trim($_GET['post_p'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{	
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
}
} else
{
if((!isset($_GET['name_c']))or(trim($_GET['name_c']=='')or!isset($_GET['inn_c']))or(trim($_GET['inn_c'])=='')or(!isset($_GET['address_c']))or(trim($_GET['address_c'])==''))
{	
	    $debug=h4a(66,$echo_r,$debug);
		goto end_code;	
	
}
}
$dates=ht($_GET["date1"]);
//**************************************************
//**************************************************
//проверка что количество не больше нужного
 $D = explode('.', $_COOKIE["basket_supply_".$id_user]);
$xvg= explode('-', trim(htmlspecialchars($_GET['xvg'])));
$summaa=0;
 for ($i=0; $i<count($D); $i++)
{
	$xvg1= explode(':', $xvg[$i]);
	$summaa=$summaa+($xvg1[1]*$xvg1[0]);
	$result_t3=mysql_time_query($link,'SELECT a.count_units
FROM 
z_doc_material AS a
WHERE 
a.id="'.trim(htmlspecialchars($D[$i])).'"');	
	
	
		if(($xvg1[0]==0)or(!is_numeric($xvg1[0])))
		{
			$debug=h4a(79,$echo_r,$debug);
		    goto end_code;	
		}
		if(($xvg1[1]==0)or(!is_numeric(trimc($xvg1[1]))))
		{
			$debug=h4a(89,$echo_r,$debug);
		    goto end_code;	
		}	
	
	
  		$num_results_t3 = $result_t3->num_rows; 
        if($num_results_t3==0)
        {	
				    $debug=h4a(77,$echo_r,$debug);
		            goto end_code;	
		} else
		{
		       $row__3= mysqli_fetch_assoc($result_t3);
		       /*
			if($row__3["count_units"]<$xvg1[0])
			{
					    $debug=h4a(777,$echo_r,$debug);
		                goto end_code;	
			}
		       */
		}
	
			  // mysql_time_query($link,'INSERT INTO z_doc_material_acc (id_doc_material,count_material,id_acc) VALUES ("'.htmlspecialchars(trim($D[$i])).'","'.htmlspecialchars(trim($xvg[$i])).'","'.$ID_D.'")');			   
}


/*
if(($row_t["id_user"]!=$id_user)and($sign_admin!=1))
{ 
	    $debug=h4a(7,$echo_r,$debug);
		goto end_code;	
}
*/
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';

	//echo($_GET['name_c']);
//добавить новых поставщиков если надо
if((!isset($_GET['post_p']))and($_GET["new_c"]==1))
{	
 mysql_time_query($link,'INSERT INTO z_contractor (name,name_small,adress,inn,ogrn,status,dir) VALUES ("'.htmlspecialchars(trim($_GET['name_c'])).'","'.htmlspecialchars(trim($_GET['name_small_c'])).'","'.htmlspecialchars(trim($_GET['address_c'])).'","'.htmlspecialchars(trim($_GET['inn_c'])).'","'.htmlspecialchars(trim($_GET['ogrn_c'])).'","'.htmlspecialchars(trim($_GET['status_c'])).'","'.htmlspecialchars(trim($_GET['dir_c'])).'")');
$ID_P=mysqli_insert_id($link);	
} else
{
	$ID_P=htmlspecialchars(trim($_GET['post_p']));
}

	
$DATER1 = explode('.', trim(htmlspecialchars($_GET['date1'])));

//$DATER2 = explode('.', trim(htmlspecialchars($_GET['date2'])));
		
	/*
mysql_time_query($link,'INSERT INTO z_acc (number,date,date_create,id_contractor,summa,date_delivery,delivery_day,id_user,status,comment) VALUES ("'.htmlspecialchars(trim($_GET['number'])).'","'.$DATER1[2].'-'.$DATER1[1].'-'.$DATER1[0].'","'.date("y-m-d").' '.date("H:i:s").'","'.$ID_P.'","'.$summaa.'","","'.htmlspecialchars(trim($_GET['date2'])).'","'.$id_user.'","1","'.htmlspecialchars(trim($_GET['com'])).'")');
*/
$delivery=0;
if((trimc($_GET["summa_delivery"])!='')and(trimc($_GET["summa_delivery"])!=0)and(is_numeric(trimc($_GET["summa_delivery"]))))
{
    $delivery=trimc($_GET["summa_delivery"]);
    $summaa=$summaa+$delivery;
}

mysql_time_query($link,'INSERT INTO z_acc (number,date,date_create,id_contractor,summa,date_delivery,delivery_day,id_user,status,comment,summa_delivery) VALUES ("'.htmlspecialchars(trim($_GET['number'])).'","'.$DATER1[2].'-'.$DATER1[1].'-'.$DATER1[0].'","'.date("y-m-d").' '.date("H:i:s").'","'.$ID_P.'","0","","'.htmlspecialchars(trim($_GET['date2'])).'","'.$id_user.'","1","'.htmlspecialchars(trim($_GET['com'])).'","'.$delivery.'")');

	$ID_D=mysqli_insert_id($link);	

   $D = explode('.', $_COOKIE["basket_supply_".$id_user]);
   $xvg= explode('-', trim(htmlspecialchars($_GET['xvg'])));
 for ($i=0; $i<count($D); $i++)
		   {
			   $xvg1= explode(':', $xvg[$i]);
			   mysql_time_query($link,'INSERT INTO z_doc_material_acc (id_doc_material,count_material,price_material,id_acc) VALUES ("'.htmlspecialchars(trim($D[$i])).'","'.htmlspecialchars(trim($xvg1[0])).'","'.htmlspecialchars(trim($xvg1[1])).'","'.$ID_D.'")');			   
		   }


if($_GET['files']!='')
{
    $license=explode(",",$_GET['files']);
    foreach ($license as $key => $value)
    {
        if(FileBase($value,$link))
        {

            mysql_time_query($link,'update image_attach set id_object="'.$ID_D.'" where name = "'.ht($value).'"');

        }
    }

}

//пишем уведомление админу что новая заявка создана и отправлена на согласование
//пишем уведомление админу что новая заявка создана и отправлена на согласование
$user_admin= array();
array_push($user_admin, 11);

$title='Создан новый счет №'.ht($_GET['number']);
$kto=name_sql_x($id_user);
$message=$kto.' создал новый <a class="link-history" href="acc/'.$ID_D.'/">Счет №'.ht($_GET['number']).'</a>';
notification_send_admin($title,$message,$user_admin,$id_user,$link);

//пишем уведомление админу что новая заявка создана и отправлена на согласование
//пишем уведомление админу что новая заявка создана и отправлена на согласование




end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"ty" => $ID_D,"basket"=>$basket,"summa"=>$summaa,"dates"=>$dates);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>