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



if(!token_access_new($token,'edit_sklad',$id,"s_form"))
{
   $debug=h4a(111,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
if ( count($_GET) != 8 )
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
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
  //$debug=h4a(3,$echo_r,$debug);
  goto end_code;
}
//**************************************************
//**************************************************
if((htmlspecialchars(trim($_GET['new']))=='1')and((htmlspecialchars(trim($_GET['name']))=='')or(htmlspecialchars(trim($_GET['ed']))=='')or(htmlspecialchars(trim($_GET['group']))=='')))
{
  //$debug=h4a(35,$echo_r,$debug);
  $status_ee='no_name';	
  goto end_code;	
}
//**************************************************
$result_t=mysql_time_query($link,'Select a.id_stock,a.id_i_material from z_doc_material as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{	
	    $debug=h4a(6,$echo_r,$debug);
		goto end_code;
} else
{
	$row1s = mysqli_fetch_assoc($result_t);
}
//**************************************************
if(htmlspecialchars(trim($_GET['new']))=='1')
{
	//echo($_GET['name']);
$query=mb_convert_case(htmlspecialchars($_GET['name']), MB_CASE_LOWER, "UTF-8");
	
   $result_t=mysql_time_query($link,'Select a.* from z_stock as a where LOWER(a.name)="'.htmlspecialchars(trim($query)).'"');
	//echo('Select a.* from z_stock as a where LOWER(a.name)="'.htmlspecialchars(trim($query)).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t!=0)
{	
	$status_ee='name_yest';
	    //$debug=h4a(6,$echo_r,$debug);
		goto end_code;
}
}
//**************************************************
if(($row1s["id_stock"]==$_GET['select'])and(htmlspecialchars(trim($_GET['new']))=='0'))
{ 
	   // $debug=h4a(7,$echo_r,$debug);
	$status_ee='hide';
		goto end_code;	
}

//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';

	
//добавить новых поставщиков если надо
if(($_GET["new"]==1))
{	
	/*
	   $result_url_m=mysql_time_query($link,'select A.units from i_material as A where A.id="'.htmlspecialchars(trim($row1s["id_i_material"])).'"');
        $num_results_custom_url_m = $result_url_m->num_rows;
        if($num_results_custom_url_m!=0)
        {
			$row_material = mysqli_fetch_assoc($result_url_m);
			
		}
	
	*/
	
 mysql_time_query($link,'INSERT INTO z_stock (name,units,id_stock_group) VALUES ("'.htmlspecialchars(trim($_GET['name'])).'","'.htmlspecialchars(trim($_GET["ed"])).'","'.htmlspecialchars(trim($_GET["group"])).'")');	
$ID_P=mysqli_insert_id($link);	
} else
{
	if(($_GET['select']==0)or($_GET['select']==''))
	{
		$ID_P=0;
	} else
	{
	    $ID_P=htmlspecialchars(trim($_GET['select']));
	}
}


mysql_time_query($link,'update z_doc_material set id_stock="'.$ID_P.'" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');  


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"select" => $ID_P,"basket"=>$row1s["id_i_material"]);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>