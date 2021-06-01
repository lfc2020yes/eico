<?
 
//узнаем есть ли меморандум у материалов этой заявки
$memo_i=0; //нет


$result_txs=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($row_list["id"])).'" and ((not(a.memorandum="") and a.id_sign_mem=0)or(not(a.memorandum="") and not(a.id_sign_mem=0)and a.signedd_mem=0))');
if($result_txs->num_rows!=0)
{
 	$memo_i=1;				
}


 
 
?>
 
 <div class="menu_top" style="border-bottom:0; box-shadow: 0 20px 30px -30px rgba(0, 0, 0, 0.6);"><div class="menu1">
  <?
   echo'<h3 class="head_h" style=" margin-bottom:0px; float:left;"> Заявка на материал №'.$row_list["number"].'<div></div></h3>';
	
	//выводим создателя заявки

				   $result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.$row_list["id_user"].'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);
									  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}	
					
			   echo'<div sm="'.$row_list["id_user"].'"  data-tooltip="Создан - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row_list["id_user"],'_100x100.jpg">').'</div>';
				} 
	 
	 
	 //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ 
	//echo($row_list["status"]);
	 
	if((isset($_GET["id"]))and($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8)))
	{
	  echo'<a href="prime/'.$row_list["id_object"].'/add_a/'.$_GET['id'].'/" data-tooltip="добавить материалы" class="add_materialll_app"><i></i></a>';
	}
    
	 
	 
		//выводим статус заявки 
	$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row_list["status"].'" and a.id_system=13');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	
   //$status_class=array("status_z1","Наряды","Служебные записки","Заявки на материалы","Касса","Исполнители");
	
	
	if($row_list["status"]==10)
	{
       echo'<div class="user_mat naryd_yes"></div><div class="status_material1">'.$row_status["name_status"].'</div>';	
	} else
	{
		echo'<div class="status_material2 status_z'.$row_list["status"].'">'.$row_status["name_status"].'</div>';	
	}
}
	 
	 
	 
	 

	

	
//КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ
		
		
		if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8))and($row_list["ready"]==0))
		{
	      echo'<div class="save_button add_zay"><i>Сохранить</i></div>';
		  if((isset($stack_error))and((count($stack_error)!=0)))
          {	
		      echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';	
		  } else
		  {
			 echo'<div style="display:none;" class="error_text_add"></div>';  
		  }			
		}
		
		//заказать
		if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8))and($row_list["ready"]==1)and($memo_i==0))
		{
	
		   echo'<form id="lalala_pod_form" action="app/order/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'sign_app_order',$secret).'" type="hidden">
</form>';	
           echo'<div class="save_button pod_zay pod_pro"><i>Заказать</i></div><div style="display:none;" class="save_button add_zay"><i>Сохранить</i></div>';
	 	   if((isset($stack_error))and((count($stack_error)!=0)))
           {	
		      echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';	
		   } else
		   {
			 echo'<div style="display:none;" class="error_text_add"></div>';  
		   }
			
		}
		
		//согласовать
		if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8))and($row_list["ready"]==1)and($memo_i==1))
		{
          echo'<form id="lalala_pod_form" action="app/sign/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'sign_app_sogl',$secret).'" type="hidden">
</form>';	
			echo'<div class="save_button pod_zay sog_nar sogl_pro"><i>Согласовать</i></div><div style="display:none;" class="save_button add_zay"><i>Сохранить</i></div>';	
			
	 	   if((isset($stack_error))and((count($stack_error)!=0)))
           {	
		      echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';	
		   } else
		   {
			 echo'<div style="display:none;" class="error_text_add"></div>';  
		   }			
			
		}
	 
	    


	 
	 //сохранить для того у кого S
	 //если не все служебки с положительным ответом
	 if((decision_memo_app($link,$_GET["id"]))and($row_list["status"]==3)and($role->permission('Заявки','S')))
	 {
		 echo'<div class="save_button add_zay"><i>Сохранить</i></div>';
		  if((isset($stack_error))and((count($stack_error)!=0)))
          {	
		      echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';	
		  } else
		  {
			 echo'<div style="display:none;" class="error_text_add"></div>';  
		  }	
	 }
	 
	 
	 //заказать для того у кого S
	 //если все служебки положительные
	 	 if((!decision_memo_app($link,$_GET["id"]))and($row_list["status"]==3)and($role->permission('Заявки','S'))and($row_list["ready"]==1))
	 {
		  echo'<form id="lalala_pod_form" action="app/order/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'sign_app_order',$secret).'" type="hidden">
</form>';	
           echo'<div class="save_button pod_zay pod_pro"><i>Заказать</i></div><div style="display:none;" class="save_button add_zay"><i>Сохранить</i></div>';
	 	   if((isset($stack_error))and((count($stack_error)!=0)))
           {	
		      echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';	
		   } else
		   {
			 echo'<div style="display:none;" class="error_text_add"></div>';  
		   }
	 }
		
		//отменить
		if(($row_list["id_user"]!=$id_user)and($row_list["status"]==3)and((((array_search($row_list["id_user"],$hie_user)!==false)and($role->permission('Заявки','S'))))or($sign_admin==1)))
		{
	
			//cнять подпись
			echo'<form id="lalala_shoot_form" action="app/cancel/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'shoot_app_cancel',$secret).'" type="hidden">
</form>';	
			echo'<div class="save_button pod_del shoot"><i>отменить</i></div>';
			
		}		
		
	

include_once $url_system.'module/notification.php';
?>
	</div></div>
	