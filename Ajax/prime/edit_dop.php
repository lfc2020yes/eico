<?php
//редактирование работы в себестоимости
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;
$table='';

$id=htmlspecialchars($_GET['id']);
//$number=htmlspecialchars($_GET['number']);
//$text=htmlspecialchars($_GET['text']);
$token=htmlspecialchars($_GET['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

	 	   //эти столбцы видят только особые пользователи	
		   $count_rows=10;	
		   $stack_td = array();			
		   
	       
	       if($sign_admin!=1)
		   {   
			 //столбцы  выполнено на сумму - остаток по смете  
	         if ($role->is_column('i_razdel2','summa_r2_realiz',true,false)==false) 
		     { 
			  $count_rows=$count_rows-2;
			  array_push($stack_td, "summa_r2_realiz"); 
		     }


               if ($role->is_column('i_razdel2','summa_r2_today',true,false)==false)
               {
                   $count_rows=$count_rows-2;
                   array_push($stack_td, "summa_r2_today");
               }


             //строка итого по работе, по материалам, по разделу
		     if ($role->is_column('i_razdel1','summa_r1',true,false)==false) 
		     { 
			    array_push($stack_td, "summa_r1"); 
		     } 	  
             //строка итого по объекту
		     if ($role->is_column('i_object','total_r0',true,false)==false) 
		     { 
			    array_push($stack_td, "total_r0"); 
		     } 
	         //строка итого за метр кв
		     if ($role->is_column('i_object','object_area',true,false)==false) 
		     { 
			    array_push($stack_td, "object_area"); 
		     } 		
		   }



if(!token_access_new($token,'edit_dop_22',$id,"rema",2880))
{
    $debug=h4a(100,$echo_r,$debug);
    goto end_code;
}

if(!isset($_SESSION["user_id"])) {
    $status_ee='reg';
    $debug=h4a(102,$echo_r,$debug);
    goto end_code;
}

if ((!$role->permission('Себестоимость','U'))and($sign_admin!=1))
{
    $debug=h4a(103,$echo_r,$debug);
    goto end_code;
}


	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		$result_t1=mysql_time_query($link,'Select a.* from i_razdel2_replace as a where a.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0) {
           //такой раздел есть можно проверять переданные переменные
           $row1 = mysqli_fetch_assoc($result_t1);

       } else {
           $debug=h4a(3103,$echo_r,$debug);
           goto end_code;
       }
		 

        $status_ee='ok';

        $rann=1;

$today[0] = date("y.m.d"); //присвоено 03.12.01
$today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17



$date_=$today[0].' '.$today[1];
			 
mysql_time_query($link,'update i_razdel2_replace set 

count_units="'.htmlspecialchars(trim(trimc($_GET['count_work']))).'",
summa_material="'.htmlspecialchars(trim(trimc($_GET['price_work']))).'",
comment="'.htmlspecialchars(trim($_GET['remark'])).'",
date_last="'.$date_.'"

where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
			 
			 
			 
	//уведомления уведомления уведомления уведомления уведомления уведомления
 //уведомления уведомления уведомления уведомления уведомления уведомления
 //уведомления уведомления уведомления уведомления уведомления уведомления
	/*
		if($sign_admin!=1)
		{   
		 
		
		       $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row1['id_object'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {
     
			 $row_list= mysqli_fetch_assoc($result_url);	   
		}
			   
		$result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}
			   
			   
			   
				$user_send= array();	
				$user_send_new= array();		

				  
                //$FUSER=new find_user($link,$row_list['id_object'],'U','Группировка');
                $user_send_new=array_merge($hie->boss['4']);		
				$text_not='В себестоимости - <strong>'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</strong> в разделе - <strong>'.$row1["name1"].'</strong> была изменена работа - <strong>'.htmlspecialchars(trim($row1["name_working"])).'</strong>, с количеством -  <strong>'.htmlspecialchars(trim($row1["count_units"])).' '.htmlspecialchars(trim($row1["units"])).'</strong>, стоимостью за единицу - <strong>'.htmlspecialchars(trim($row1["price"])).' руб.</strong> на работу - <strong>'.htmlspecialchars(trim($_GET["name_work"])).'</strong>, количество -  <strong>'.htmlspecialchars(trim($_GET["count_work"])).' '.htmlspecialchars(trim($_GET["ed_work"])).'</strong>, стоимость за единицу - <strong>'.htmlspecialchars(trim($_GET["price_work"])).' руб.</strong>';		
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);		   
		} 
	*/
	//уведомления уведомления уведомления уведомления уведомления уведомления
	//уведомления уведомления уведомления уведомления уведомления уведомления
	//уведомления уведомления уведомления уведомления уведомления уведомления						 




$result_uu55 = mysql_time_query($link, 'select A.*,B.name1,B.razdel1,C.price,C.units from i_razdel2_replace as A,i_razdel1 as B,i_razdel2 as C where C.id=A.id_razdel2 and A.id_razdel1_replace=B.id and
A.id="' . ht($_GET['id']) . '"');
$num_results_uu55 = $result_uu55->num_rows;

if ($num_results_uu55 != 0) {
    $row_uu_dop = mysqli_fetch_assoc($result_uu55);

    $echo='<td colspan="2" class="no_padding_left_ pre-wrap name_m"><div class="dop-i"><div class="status_dop_i" data-tooltip="Дополнительная смета к работе">ДОП</div>';

    $result_uu_iod = mysql_time_query($link, 'select id,object_name from i_object where id="' . ht($row_uu_dop["id_object_replace"]) . '"');
    $num_results_uu_iod = $result_uu_iod->num_rows;

    if ($num_results_uu_iod != 0) {
        $row_uu_iod = mysqli_fetch_assoc($result_uu_iod);
        $echo.='<a class="a-dop_link" href="prime/'.$row_uu_iod["id"].'/">'.$row_uu_iod["object_name"].'</a>';
    }



    $echo.=' → <a class="a-dop_link1" href="prime/'.$row_uu_dop["id_object_replace"].'/#dop-'.$row_uu_dop["id_razdel1_replace"].'" class="s_j s-j-dopxx">'.$row_uu_dop["razdel1"].'. '.$row_uu_dop["name1"].'</a><span class="edit_panel_">';
    if (($role->permission('Себестоимость','U'))or($sign_admin==1))
    {
        $echo.='<span data-tooltip="редактировать данные дополнительной сметы" for="'.$row_uu_dop["id"].'" class="edit_iconkkk js-edit-dop-sm">3</span>';
    }
    if (($role->permission('Себестоимость','D'))or($sign_admin==1))
    {
        $echo.='<span data-tooltip="разорвать связь" for="'.$row_uu_dop["id"].'" class="del_icon_mkkk js-del-dop-sm">5</span>';
    }

    $echo.='</span>';
    if($row_uu_dop["comment"]!='')
    {
        $echo.='<div class="comment-dop">('.$row_uu_dop["comment"].')</div>';
    }

    $echo.='</div></td><td class="pre-wrap"></td>
<td><span class="s_j">'.$row_uu_dop["units"].'</span></td>
<td style="text-align: right;"><span class="s_j">- '.number_format($row_uu_dop["count_units"], 3, '.', ' ').'</span></td>
<td style="text-align: right;"><span class="s_j" style="line-height: 15px;">'.number_format($row_uu_dop["price"], 2, '.', ' ').'</span></td>';
    $minus='';
    if($row_uu_dop["subtotal"]<0)
    {
        $minus='- ';
    }


    $echo.='<td style="text-align: right;"><span class="s_j">'.$minus.number_format($row_uu_dop["subtotal"], 2, '.', ' ').'</span></td><td style="text-align: right;"><span class="s_j" data-tooltip="0%">-</span></td><td style="text-align: right;"><span class="s_j">-</span></td><td style="text-align: right;"><span class="s_j">-</span></td>';

}


end_code:


$aRes = array("debug"=>$debug,"status"   => $status_ee,"table" =>  $table,"echo" =>  $echo,"id"=>$ID_D,"proc"=>$proc_realiz);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>