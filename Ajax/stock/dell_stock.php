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
$id=htmlspecialchars($_GET['id']);
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';


if(!token_access_new($token,'dell_stock_',$id,"s_form"))
{
   $debug=h4a(100,$echo_r,$debug);
   goto end_code;
}

//**************************************************
if ( count($_GET) != 3 ) 
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
if ((!$role->permission('Склад','U'))and($sign_admin!=1))
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
	   $result_t=mysql_time_query($link,'Select a.* from z_stock as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t==0)
	   {
		    $debug=h4a(42,$echo_r,$debug);
		   goto end_code;	 
	   } else
	   {
		   $row_t = mysqli_fetch_assoc($result_t);

	   }

//смотрим чтобы не было связей с этим наименованием
$svyz=0;						 
//количество взаимосвязей в себестоимости
$result_t1_=mysql_time_query($link,'SELECT count(A.id) as cc FROM i_material as A WHERE A.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');            	 
$num_results_t1_ = $result_t1_->num_rows;
if($num_results_t1_!=0)
{  		             
	$row1ss_ = mysqli_fetch_assoc($result_t1_);
	if(($row1ss_["cc"]!='')and($row1ss_["cc"]!=0))
	{
		$svyz++;
	}					 
}	
						 
//количество взаимосвязей в заявках
$result_t1_=mysql_time_query($link,'SELECT count(A.id) as cc FROM z_doc_material as A WHERE A.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');            	 
$num_results_t1_ = $result_t1_->num_rows;
if($num_results_t1_!=0)
{  		             
	$row1ss_ = mysqli_fetch_assoc($result_t1_);
	if(($row1ss_["cc"]!='')and($row1ss_["cc"]!=0))
	{
		$svyz++;
	}					 
}						 
//количество взаимосвязей в заявках
$result_t1_=mysql_time_query($link,'SELECT count(A.id) as cc FROM z_invoice_material as A WHERE A.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');             	 
$num_results_t1_ = $result_t1_->num_rows;
if($num_results_t1_!=0)
{  		             
	$row1ss_ = mysqli_fetch_assoc($result_t1_);
	if(($row1ss_["cc"]!='')and($row1ss_["cc"]!=0))
	{
		$svyz++;
	}					 
}				


if($svyz!=0)
{
	 $debug=h4a(490,$echo_r,$debug);
	goto end_code;
}

//**************************************************
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';

mysql_time_query($link,'delete FROM z_stock where id="'.htmlspecialchars(trim($_GET['id'])).'"');


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>