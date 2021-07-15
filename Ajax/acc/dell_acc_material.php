<?php
//удалить раздел в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$echo_r=1;
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$token=htmlspecialchars($_GET['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

if(!token_access_new($token,'dell_mat_acc',$id,"rema",2880))
{
    $debug=h4a(100,$echo_r,$debug);
    goto end_code;
}

if(!isset($_SESSION["user_id"])) {
    $status_ee='reg';
    $debug=h4a(102,$echo_r,$debug);
    goto end_code;
}

if ((!$role->permission('Счета','U'))and($sign_admin!=1))
{
    $debug=h4a(103,$echo_r,$debug);
    goto end_code;
}


		  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$result_tx=mysql_time_query($link,'Select f.name,a.number,a.date,c.id_acc from z_acc as a,z_doc_material_acc
 as c,z_doc_material as d,z_stock as f where d.id=c.id_doc_material and d.id_stock=f.id and c.id_acc=a.id and ((a.status=1)or(a.status=8)) and c.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_tx->num_rows;
if($num_results_t==0)
{

           $debug=h4a(104,$echo_r,$debug);
           goto end_code;
       }


	   $row_tx = mysqli_fetch_assoc($result_tx);
	  

//Вдруг это последний элемент

$result_uu = mysql_time_query($link, 'select count(A.id) as uii from z_doc_material_acc as A where A.id_acc="' . ht($row_tx['id_acc']) . '"');
$num_results_uu = $result_uu->num_rows;

if ($num_results_uu != 0) {
    $row_uu = mysqli_fetch_assoc($result_uu);
    if ($row_uu["uii"] <= 1)
    {
        $debug=h4a(121,$echo_r,$debug);
        goto end_code;
    }
}


			 
$status_ee='ok';

mysql_time_query($link,'delete FROM z_doc_material_acc where id="'.htmlspecialchars(trim($id)).'"');
//возможно удалить и работы связанные с ним
	
		   
		    //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления
		   

		   
			   //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления	   



end_code:



$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>