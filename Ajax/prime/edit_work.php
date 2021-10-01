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



if(!token_access_new($token,'edit_work',$id,"rema",2880))
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
		$result_t1=mysql_time_query($link,'Select a.name1,a.id,a.id_object,a.razdel1,b.name_working,b.subtotal,b.count_units,b.units,b.price from i_razdel1 as a,i_razdel2 as b where b.id_razdel1=a.id and b.id="'.htmlspecialchars(trim($id)).'"');
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
		 
			 
			 
mysql_time_query($link,'update i_razdel2 set name_working="'.htmlspecialchars(trim($_GET['name_work'])).'",units="'.htmlspecialchars(trim($_GET['ed_work'])).'",id_implementer="'.$_GET['ispol_work'].'",count_units="'.htmlspecialchars(trim(trimc($_GET['count_work']))).'",price="'.htmlspecialchars(trim(trimc($_GET['price_work']))).'" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
			 
			 
			 
	//уведомления уведомления уведомления уведомления уведомления уведомления
 //уведомления уведомления уведомления уведомления уведомления уведомления
 //уведомления уведомления уведомления уведомления уведомления уведомления
		   
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
		   
	//уведомления уведомления уведомления уведомления уведомления уведомления
	//уведомления уведомления уведомления уведомления уведомления уведомления
	//уведомления уведомления уведомления уведомления уведомления уведомления						 
					 		 
			 


        $result_town__=mysql_time_query($link,'select A.* from i_razdel2 as A where  A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_town__ = $result_town__->num_rows;
        if($num_results_custom_town__!=0)
        {
			$row_town__ = mysqli_fetch_assoc($result_town__);				
		}
		
			 
			 
$proc_realiz=round(($row_town__["count_r2_realiz"]*100)/$row_town__["count_units"]);			 
				
//мигает красным если дата прошла а работа не выполнена
					  $actv12='';
					 if(($proc_realiz<100)and(($role->permission('График','R'))or($sign_admin==1))and($row_town__["date1"]!=''))
					 {
						 if((time_compare($row_town__["date1"].' 00:00:00',0)==0))
						 {
						   $actv12.=' redgraf';
						 }
					 }		
			 

$echo.='<td class="middle_"><div class="st_div"><i class="'.$actv12.'"></i></div></td>
                  <td class="no_padding_left_ pre-wrap"><span class="s_j">'.htmlspecialchars(trim($_GET["name_work"])).'</span><br>';
				  
					  
					  
					  //вывод дат начала и конца работы
					  if (($role->permission('График','R'))or($sign_admin==1))
					  {
					    $class_graf='';
					    if($row_town__["date0"]!='')
					    {
						  if (($role->permission('График','U'))or($sign_admin==1))
					      {	
							  $class_graf='class="UGRAFE"';
						  }
					      $echo.='<span data-tooltip="редактировать график работы" for="'.$row_town__["id"].'" '.$class_graf.'><span class="UD0">'.MaskDate_D_M_Y_ss($row_town__["date0"]).'</span><span> - </span>';
					      $echo.='<span class="UD1">'.MaskDate_D_M_Y_ss($row_town__["date1"]).'</span></span>';
					    } else
						{
						   if (($role->permission('График','U'))or($sign_admin==1))
					      {	
							  $class_graf='class="UGRAFE"';
							   $echo.='<span data-tooltip="редактировать график работы" for="'.$row_town__["id"].'" '.$class_graf.'><span class="UD0">задать график работ</span></span>';
							  
						  }
							
						}
					  }
			 
			 $echo.='<span class="edit_panel">';
			 		   if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	       {
			 $echo.='<span data-tooltip="редактировать работу" for="'.htmlspecialchars(trim($_GET['id'])).'" class="edit_icon">3</span>';
		   }
			 		   if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	       {
			 $echo.='<span data-tooltip="удалить работу" for="'.htmlspecialchars(trim($_GET['id'])).'" class="del_icon">5</span>';
		   }
			 		   if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	       {
			 $echo.='<span data-tooltip="Добавить материал" for="'.htmlspecialchars(trim($_GET['id'])).'" class="addd_icon">J</span>';
		   }
				 
			 $echo.='</span></td>
<td class="pre-wrap">';
			 
	            $result_t2=mysql_time_query($link,'Select a.* from i_implementer as a where a.id="'.htmlspecialchars(trim($_GET["ispol_work"])).'"');
                $num_results_t2 = $result_t2->num_rows;
	            if($num_results_t2!=0)
	            {
					$row_t2 = mysqli_fetch_assoc($result_t2);
																if (($role->permission('Исполнители','R'))or($sign_admin==1))
	        {	
                    $echo.='<a class="musa" href="implementer/'.$row_t2["id"].'/"><span class="s_j">'.$row_t2["implementer"].'</span></a>';
			} else
			{
	                    $echo.='<span class="s_j">'.$row_t2["implementer"].'</span>';			
			}
				}
				//количество нарядов по данной работе
			
		 
//<div class="musa_plus">3</div>
$echo.='';
$echo.='</td>
<td><span class="s_j">'.htmlspecialchars(trim($_GET["ed_work"])).'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim(trimc($_GET["count_work"]))), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim(trimc($_GET["price_work"]))), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format((trimc($_GET["count_work"])*trimc($_GET["price_work"])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j" data-tooltip="'.$proc_realiz.'%">'.mor_class(($row_town__["count_units"]-$row_town__["count_r2_realiz"]),rtrim(rtrim(number_format($row_town__["count_r2_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td>';
if(array_search('summa_r2_realiz',$stack_td) === false) 
{			 
$echo.='<td><span class="s_j">'.mor_class(($row_town__["subtotal"]-$row_town__["summa_r2_realiz"]),rtrim(rtrim(number_format($row_town__["summa_r2_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td><td><strong><span class="s_j">'.mor_class(($row_town__["subtotal"]-$row_town__["summa_r2_realiz"]),rtrim(rtrim(number_format(($row_town__["subtotal"]-$row_town__["summa_r2_realiz"]), 2, '.', ' '),'0'),'.'),1).'</span></strong></td>';			 
}



end_code:


$aRes = array("debug"=>$debug,"status"   => $status_ee,"table" =>  $table,"echo" =>  $echo,"id"=>$ID_D);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>