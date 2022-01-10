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
$echo_r=1;

//$query=htmlspecialchars($_GET['query']);
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=0; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************
if ( count($_GET) != 4 )
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
if ((!$role->permission('Накладные_1c','A'))and($sign_admin!=1))
{
    goto end_code;
}

include_once $url_system.'ilib/lib_import.php';

$csv = new CSV($link, $id_user);
$mask = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/*.csv';
$mask_attach = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/1c_attach/';
if(isset($_GET["file"])) {
    //iconv( 'windows-1251','UTF-8',$debug)\
    //echo(base64_decode($_GET['id']));
    $data = $csv->read_data(iconv( 'UTF-8','windows-1251',base64_decode($_GET['file'])));
    if(count($data)==0)
    {
        goto end_code;
    }
} else
{
    goto end_code;
}

$nn=0;
if(isset($_GET["key"])) {
    if (!isset($data[$_GET['key']])) {
        goto end_code;
    }
} else
{
    goto end_code;
}
$nn=$_GET['key'];


//**************************************************
//**************************************************
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



$CA=0;
//определяем какой по id у нас это контрагент
$contractor = new CONTRACTOR($link, $id_user);
if (($id=$contractor->get($data[0]["ИНН"])) !== false) { $CA=$id; }
else
    if (($id=$contractor->put($data[0]))!==false) { $CA=$id; }


$result_score=mysql_time_query($link,
							  
'select DISTINCT a.id,a.number,a.date,a.summa,a.id_contractor from z_acc as a,z_doc_material_acc as b,z_doc_material as c where a.id=b.id_acc and b.id_doc_material=c.id and c.id_stock="'.htmlspecialchars(trim($_GET['id_stock'])).'" and a.status IN ("2","3", "4","20") and a.id_contractor="'.htmlspecialchars(trim($CA)).'"');
	
//если по счету все приняли не видеть этого счета

/*		 
			   <div class="score_a score_active"><i>2</i></div>
			   <div class="score_a"><i>10</i></div>			 
				*/	
			   //score_pay score_app score_active
				 
        $num_results_score = $result_score->num_rows;
	    if($num_results_score!=0)
	    {

			//$echo.='</select>';
            $status_ee='ok';
		} else
        {
            $status_ee='no';
        }


end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"count" => $dom,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>