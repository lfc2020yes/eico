<?php
//добавление материала к работе в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");


$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;

$id=htmlspecialchars($_GET['id']);
$number=htmlspecialchars($_GET['ed']);
$text=htmlspecialchars($_GET['text']);
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

if(token_access_new($token,'add_material',$id,"s_form"))
{

 if(((isset($_GET['id']))and(is_numeric($_GET['id'])))and((isset($_GET['count']))and(is_numeric($_GET['count'])))and((isset($_GET['price']))and(is_numeric($_GET['price'])))and((isset($_GET['text']))and($_GET['text']!=''))and((isset($_GET['ed']))and($_GET['ed']!='')))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
		  
		if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	    { 
		  
		  
		//возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		$result_t1=mysql_time_query($link,'Select a.name1,a.id,a.id_object,a.razdel1,b.* from i_razdel1 as a,i_razdel2 as b where b.id_razdel1=a.id and b.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
		   $row1 = mysqli_fetch_assoc($result_t1);
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';


					 mysql_time_query($link,'INSERT INTO i_material (id,id_razdel2,razdel1,razdel2,material,id_implementer,units,count_units,price) VALUES ("","'.htmlspecialchars(trim($id)).'","'.$row1["razdel1"].'","'.$row1["razdel2"].'","'.htmlspecialchars(trim($_GET['text'])).'","","'.htmlspecialchars(trim($_GET['ed'])).'","'.htmlspecialchars(trim($_GET['count'])).'","'.htmlspecialchars(trim($_GET['price'])).'")');	 
					 $ID_D1=mysqli_insert_id($link);	
		   
		   
		   
		   
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
				$text_not='В себестоимость - <strong>'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</strong> в раздел - <strong>'.$row1["name1"].'</strong>, в работу - <strong>'.htmlspecialchars(trim($row1["name_working"])).'</strong>, добавлен новый материал - <strong>'.htmlspecialchars(trim($_GET['text'])).'</strong>, количество -  <strong>'.htmlspecialchars(trim($_GET['count'])).' '.htmlspecialchars(trim($_GET['ed'])).'</strong>, стоимость за единицу - <strong>'.htmlspecialchars(trim($_GET['price'])).' руб.</strong>';		
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);		   
		} 
		   
	//уведомления уведомления уведомления уведомления уведомления уведомления
	//уведомления уведомления уведомления уведомления уведомления уведомления
	//уведомления уведомления уведомления уведомления уведомления уведомления			   
		   
		   
		   
		   
		   
		   
					 $echo.='<tr class="material" rel_ma="'.$ID_D1.'">
           
           <td colspan="2" class="no_padding_left_ pre-wrap name_m"><div class="nm"><i></i><span class="s_j">'.htmlspecialchars(trim($_GET['text'])).'</span><span class="edit_panel_">';
				   if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	       {   
		   $echo.='<span data-tooltip="редактировать материал" for="'.$ID_D1.'" class="edit_icon_m">3</span>';
		   }
		   		   if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	       {
		   $echo.='<span data-tooltip="удалить материал" for="'.$ID_D1.'" class="del_icon_m">5</span>';
		   }
			   
			   $echo.='</span></div></td>
<td class="pre-wrap"></td>
<td><span class="s_j">'.htmlspecialchars(trim($_GET['ed'])).'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim($_GET['count'])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim($_GET['price'])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(($_GET['count']*$_GET['price']), 2, '.', ' '),'0'),'.').'</span></td>
<td></td>';
if(array_search('summa_r2_realiz',$stack_td) === false) 
{			   
$echo.='<td></td>
<td></td>';
}
           $echo.='</tr>';  		   
		   
         }
	   }
		 	  
	  } else
	  {
		  $status_ee='reg';
	  }
	  
 // }

 //}
}
}


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>