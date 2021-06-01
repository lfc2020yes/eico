<?php
//редактировать раздел в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$number=htmlspecialchars($_GET['number']);
$text=htmlspecialchars($_GET['text']);
$token=htmlspecialchars($_GET['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

/*
$day_nedeli=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_user=date("w", mktime(0, 0, 0, $dates[1], $dates[2], $dates[0]));
$day_today=date("Y-m-d");
*/

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

if(token_access_new($token,'edit_block',$id,"s_form"))
{




 if(((isset($_GET['id']))and(is_numeric($_GET['id'])))and((isset($_GET['number']))and(is_numeric($_GET['number']))))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
		if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	    { 
		  
		$result_tx=mysql_time_query($link,'Select a.id_object,a.razdel1,a.name1 from i_razdel1 as a where a.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_tx = $result_tx->num_rows;
	   if($num_results_tx!=0)
	   {  
		  $row_tx = mysqli_fetch_assoc($result_tx); 
	   }
		  
		  
		//возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		$result_t1=mysql_time_query($link,'Select a.id from i_razdel1 as a where a.id_object="'.htmlspecialchars(trim($row_tx["id_object"])).'" and a.razdel1="'.htmlspecialchars(trim($number)).'" and not(id="'.htmlspecialchars(trim($id)).'")');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1==0)
	   {  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';


mysql_time_query($link,'update i_razdel1 set name1="'.htmlspecialchars(trim($text)).'",razdel1="'.htmlspecialchars(trim($number)).'" where id = "'.htmlspecialchars(trim($id)).'"');
		   
		   
		   
		   //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления
		   
		  if($sign_admin!=1)
		   {   
		 
		
		       $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_tx["id_object"])).'"');
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
				$text_not='В себестоимость - <strong>'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</strong> изменен раздел - <strong>№'.$row_tx["razdel1"].' '.htmlspecialchars(trim($row_tx["name1"])).'</strong> на <strong>№'.$number.' '.htmlspecialchars(trim($text)).'</strong>.';		
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);		   
		   } 
		   
			   //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления
		   //уведомления уведомления уведомления уведомления уведомления уведомления	   
		   
		   
					

$result_t=mysql_time_query($link,'Select a.razdel1,a.name1 from i_razdel1 as a where a.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);

		   $echo.='<span class="s_j">'.$row_t["razdel1"].'. '.$row_t["name1"].'</span><span class="edit_12">';
		   	if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	       {
		   $echo.='<span for="'.htmlspecialchars(trim($id)).'" data-tooltip="редактировать раздел" class="edit_icon_block">3</span>';
		   }
			if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	       {   
		   $echo.='<span for="'.htmlspecialchars(trim($id)).'" data-tooltip="Удалить раздел" class="del_icon_block">5</span>';
		   }
			if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	       {   
		   $echo.='<span for="'.htmlspecialchars(trim($id)).'" data-tooltip="Добавить работу" class="add_icon_block">J</span>';
		   }
			   
			   
		   $echo.='</span>'; 
	   }
	   } else
	   {		   		   
           $status_ee='number';
	   }

		}
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

 

}


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>