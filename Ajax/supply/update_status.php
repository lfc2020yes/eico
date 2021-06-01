<?php
//получение материалов из счета при выборе текущего счета

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
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************
if ( count($_GET) != 2 ) 
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
 if ((!$role->permission('Снабжение','U'))and($sign_admin!=1))
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
if ((!isset($_GET["id"]))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
//**************************************************
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';
$basket=array();

$id_status_list=explode(".",$_GET['id']);
for ($it=0; $it<count($id_status_list); $it++)
{   
	if(is_numeric($id_status_list[$it]))
	{
			$result_t_s=mysql_time_query($link,'Select a.* from z_doc_material as a where a.id="'.htmlspecialchars(trim($id_status_list[$it])).'"');
        $num_results_t_s = $result_t_s->num_rows;
        if($num_results_t_s!=0)
        {	
	         
			$row_work_zz = mysqli_fetch_assoc($result_t_s);	
		//вывод статуса по материалу
$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row_work_zz["status"].'" and a.id_system=13');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	
	$live='';
	$menu_id = array("9", "11");
	if(array_search($row_work_zz["status"],$menu_id)!==false)
	{
		$live='live_menu';
	}
	if($row_work_zz["status"]==10)
	{
       $basket[$it].='<div rel_status="'.$row_work_zz["id"].'" class="st_bb menu_click status_material1">'.$row_status["name_status"].'</div><div class="user_mat naryd_yes"></div>';	
	} else
	{
		$basket[$it].='<div rel_status="'.$row_work_zz["id"].'" class="st_bb menu_click status_materialz status_z'.$row_work_zz["status"].' '.$live.'">'.$row_status["name_status"].'</div>';	
	}
	
	
	$menu = array( "Заказано", "В работе");
		
	if(array_search($row_work_zz["status"],$menu_id)!==false)
	{
	$basket[$it].='<div class="menu_supply"><ul class="drops" data_src="'.$row_work_zz["status"].'">';
		   for ($itd=0; $itd<count($menu); $itd++)
             {   
			   if($row_work_zz["status"]==$menu_id[$itd])
			   {
				   $basket[$it].='<li class="sel_active_sss"><a href="javascript:void(0);"  rel="'.$menu_id[$itd].'">'.$menu[$itd].'</a></li>';
			   } else
			   {
				  $basket[$it].='<li><a href="javascript:void(0);"  rel="'.$menu_id[$itd].'">'.$menu[$itd].'</a></li>'; 
			   }
			 
			 }
	$basket[$it].='</ul><input rel="'.$row_work_zz["id"].'" type="hidden" name="vall" class="vall_supply" value="'.$row_work_zz["status"].'"></div>';
	}
	
}
		}
		
	} else
	{
		$basket[$it]='';
	}
}


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"basket"=>$basket);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>