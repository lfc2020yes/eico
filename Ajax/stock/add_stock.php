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
$token=htmlspecialchars($_GET['tk']);
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';


if(!token_access_new($token,'add_stock_',$id,"s_form"))
{
   $debug=h4a(100,$echo_r,$debug);
   goto end_code;
}

//**************************************************
if ( count($_GET) != 5 ) 
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
if ((!$role->permission('Склад','A'))and($sign_admin!=1))
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
if ((!isset($_GET["name"]))or($_GET["name"]=='')) 
{
   $debug=h4a(41,$echo_r,$debug);
   goto end_code;	
}

if ((!isset($_GET["ed"]))or($_GET["ed"]=='')) 
{
   $debug=h4a(42,$echo_r,$debug);
   goto end_code;	
}
if ((!isset($_GET["group"]))or((!is_numeric($_GET["group"])))) 
{
   $debug=h4a(43,$echo_r,$debug);
   goto end_code;	
}

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


//**************************************************
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';

mysql_time_query($link,'INSERT INTO z_stock (name,units,id_stock_group) VALUES ("'.htmlspecialchars(trim($_GET['name'])).'","'.htmlspecialchars(trim($_GET["ed"])).'","'.htmlspecialchars(trim($_GET["group"])).'")');	
$ID_P=mysqli_insert_id($link);	


$result_town=mysql_time_query($link,'select B.* from z_stock_group as B where B.id="'.htmlspecialchars(trim($_GET["group"])).'"');
	
                 $num_results_custom_town = $result_town->num_rows;
                 if($num_results_custom_town!=0)
                 {
		         	$row_town = mysqli_fetch_assoc($result_town);	
		         }


$echo.='<tr class="nary n1n suppp_tr" idu_stock="'.$ID_P.'"><td class="middle_"><div class="supply_tr_o1"></div></td><td colspan="2" class="middle_"><div class="nm supl"><a href="stock/'.$ID_P.'/" class="s_j">'.$_GET['name'].'</a></div></td><td><div class="skladd_nei1"><span class="yest_sklad" data-tooltip="в себестоимости">0</span> / <span data-tooltip="в заявках" class="yest_users">0</span> / <span data-tooltip="в накладных" class="yest_users">0</span> </div></td>
<td><span>'.$row_town["name"].'</span></td><td colspan="2"><span class="count_stock_x">0</span></td><td>кг</td><td><div data-tooltip="Удалить" rel_bill="'.$ID_P.'" class="user_mat xvg_no1"></div><div data-tooltip="Изменить" rel_bill="'.$ID_P.'" class="user_mat xvg_yes1"></div></td></tr>';




$echo.='<tr idu_stock="739" class="tr_dop_supply_line"><td colspan="9"></td></tr>';

end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>