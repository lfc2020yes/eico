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
if (( count($_GET) != 3 ) and( count($_GET) != 4 ))
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
if ((!$role->permission('Наряды','R'))and($sign_admin!=1))
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
if (((!isset($_GET["id"])))or((!is_numeric($_GET["id"])))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}
if (((!isset($_GET["count"])))or((!is_numeric($_GET["count"])))) 
{
   $debug=h4a(466,$echo_r,$debug);
   goto end_code;	
}
if (((isset($_GET["fin"])))and((is_numeric($_GET["fin"])))) 
{
	
	$result_t=mysql_time_query($link,'Select a.id,a.signedd_nariad from n_nariad as a where a.id="'.htmlspecialchars(trim($_GET["fin"])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t!=0)
{	
	$row_t = mysqli_fetch_assoc($result_t);
	//проверяем может ли видеть этот наряд
	if($row_t["signedd_nariad"]==1)
	{ 
		$debug=h4a(5,$echo_r,$debug);
		goto end_code;
	}
} else
{
		$debug=h4a(5,$echo_r,$debug);
		goto end_code;
}
	
}
//**************************************************
//**************************************************
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';
$basket=array();





				   
							   
						  //списываем у пользователя материалы которые были в этом наряде
						  //списываем у пользователя материалы которые были в этом наряде
						  //списываем у пользователя материалы которые были в этом наряде
							   
if (((!isset($_GET["fin"])))or((!is_numeric($_GET["fin"])))) 
{

	$id_user_finery=$id_user;
	
	
} else
{
		$result_status=mysql_time_query($link,'SELECT a.id_user FROM n_nariad AS a WHERE a.id="'.htmlspecialchars(trim($_GET["fin"])).'"');	
		if($result_status->num_rows!=0)
        {  
           $row_status = mysqli_fetch_assoc($result_status);
		   $id_user_finery=$row_status["id_user"];
		}	
}
	
$total=0;
$cost_ss=0;
							   $count_sp=htmlspecialchars(trim($_GET['count']));  
							   //списываем к уменьшению количества записей на складе. сначала с записей которые мелкие потом большие
							   $result_t2=mysql_time_query($link,'Select a.* from z_stock_material as a where a.id_stock="'. htmlspecialchars(trim($_GET['id'])).'" and a.id_user="'.$id_user_finery.'" order by a.count_units');	
					           $num_results_t2 = $result_t2->num_rows;
	                           if($num_results_t2!=0)
	                           {		   
							   	  for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                                  {

					                   $row__2= mysqli_fetch_assoc($result_t2);
									   if($row__2["count_units"]<=$count_sp)
										{
											$count_sp=$count_sp-$row__2["count_units"];
											//удаляем запись вообще
											$total=$total+($row__2["count_units"]*$row__2["price"]);
										} else
										{
											$new_count=$row__2["count_units"]-$count_sp;
											
											$total=$total+($count_sp*$row__2["price"]);
											$count_sp=0;
										}
									    if($count_sp==0)
										{
											break;
										}
									  
						 
					              }
								 
				              }
								 $cost_ss=round($total/$_GET['count'],2);
				
							   
						  //списываем у пользователя материалы которые были в этом наряде
						  //списываем у пользователя материалы которые были в этом наряде
						  //списываем у пользователя материалы которые были в этом наряде					   
							   
			


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"cost"=>$cost_ss);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>