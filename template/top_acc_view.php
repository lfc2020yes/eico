<?
 
//узнаем есть ли меморандум у материалов этой заявки
/*
$memo_i=0; //нет


$result_txs=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($row_list["id"])).'" and ((not(a.memorandum="") and a.id_sign_mem=0)or(not(a.memorandum="") and not(a.id_sign_mem=0)and a.signedd_mem=0))');
if($result_txs->num_rows!=0)
{
 	$memo_i=1;				
}

*/
 
 

 
 //echo'<div class="menu_top" style="border-bottom:0; box-shadow: 0 20px 30px -30px rgba(0, 0, 0, 0.6);"><div class="menu1">';

  /*
   echo'<h3 class="head_h" style=" margin-bottom:0px; float:left;"> Заявка на материал №'.$row_list["id"].'<div></div></h3>';
	
	//выводим создателя заявки

				   $result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.$row_list["id_user"].'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);
									  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}	
					
			   echo'<div sm="'.$row_list["id_user"].'"  data-tooltip="Создан - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row_list["id_user"],'_100x100.jpg">').'</div>';
				} 
	*/
	 
	 //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ //ДОБАВИТЬ 
	//echo($row_list["status"]);
	 /*
	if((isset($_GET["id"]))and($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8)))
	{
	  echo'<a href="prime/'.$row_list["id_object"].'/add_a/'.$_GET['id'].'/" data-tooltip="добавить материалы" class="add_materialll_app"><i></i></a>';
	}
   */
	 
	 /*
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
	 
	 */
	 
	 

	

	
//КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ
		/*
		
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
*/


//********************************************************
//********************************************************
//********************************************************
//********************************************************


?>
<div class="menu-09  input-line" style="z-index:150;">
    <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
    <div class="menu-09-left">
        <a href="/" class="menu-09-global"></a><a onclick="history.back();" class="menu-09-prev"><i></i></a>

        <?
        //$D = explode('.', $_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);
        echo'<span class="menu-09-pc-h" ><span class="js-acc-name-top"> Счет №'.$row_list["number"].' от '.date_ex(0,$row_list["date"]).' </span >';
/*
        if(count($D)>0)
        {
            echo'<span all="8" class="menu-09-count">'.count($D).'</span>';
        }
*/
        echo'</span >';

        ?>

    </div>
    <div class="menu-09-right tours-right-block">
        <?



        include_once $url_system.'module/notification.php';
        include_once $url_system.'module/users.php';

        //добавить еще материал
        if((isset($_GET["id"]))and($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8)))
        {



            echo'<a href="supply/?step=add&id='.$_GET['id'].'" data-tooltip="добавить позиции в счет" class="add_invoice22 hide-mobile"><i></i></a>';
        }

        echo'</div>';

/*
        if(count($D)>0) {
            echo'<a data-tooltip="сохранить заявку" class="js-add-app add_clients yellow-style hide-mobile">Сохранить   →</a>';
        }
*/
        //КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ

/*
		if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8))and($row_list["ready"]==0))
		{
            //add_zay
	      echo'<div class="save_button add_zay js-add-app add_clients  yellow-style">Сохранить   →</div>';
		}
*/

        if (!is_object($edo)) {
            include_once $url_system.'ilib/lib_interstroi.php';
            include_once $url_system.'ilib/lib_edo.php';
            $edo = new EDO($link, $id_user, false);
        }

        $arr_document = $edo->my_documents(1, ht($_GET["id"]), '>=-10', true);


        if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8)))
        {

            echo'<form id="lalala_pod_form" action="acc/order/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'sign_acc_order',$secret).'" type="hidden">
</form>';
            echo'<div class="save_button pod_zay pod_pro add_clients green-bb">Согласовать   →</div><div style="display:none;" class="save_button add_zay js-add-acc-save add_clients yellow-style">Сохранить   →</div>';

        } else {


            //если уже заказано и нужно просто вывести по пользователю надо ему что-то делать в данный момент с этой заявкой или нет

           // echo '<pre>arr_document:' . print_r($arr_document, true) . '</pre>';

            $visible_gray=0;  //не выполнил
        foreach ($arr_document as $key => $value)
        {
            if((is_array($value["state"]))and(!empty($value["state"]))) {

                $echo_bb='';
                foreach ($value["state"] as $keys => $val)
                {
                    //echo($val["id_run_item"]);

                    $class_by='';
                    if($val["id_status"]!=0)
                    {
                        $visible_gray=1;  //Значит он выполнил уже и кнопки будут но просто серые
                        $class_by='gray-bb';
                    } else
                    {
                        $visible_gray=0;  //Значит он выполнил уже и кнопки будут но просто серые
                        $class_by='';
                    }

                    $but_mass=$edo->get_action($val["id_run_item"]);
                    //echo '<pre>arr_document:' . print_r($but_mass, true) . '</pre>';
//echo($but_mass["name_action"]);
                    //name_action

//echo($visible_gray);
//id_action - 4 выписать счета

if($but_mass["id_action"]!=4) {

    $echo_bb = '<div class="save_button  add_clients green-bb ' . $class_by . ' js-sign-a1">';
    if ($class_by == '') {
        $echo_bb .= '<div class="pass_tyu"><div class="password_turs">
<div id="1" class="input-choice-click-pass js-checkbox-group">
<div class="choice-radio" data-tooltip="' . $but_mass["name_action"] . ' с замечанием"><div class="center_vert1"><i class=""></i><input name="kto_komy" class="js-type-soft-view1" value="0" type="hidden"></div></div></div></div>

</div>
   <form id="js-form-next-sign" class="none" action="acc/sign_yes/' . $_GET["id"] . '/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk" value="' . token_access_compile($_GET['id'], 'sign_acc_2021_next', $secret) . '" type="hidden">  <input name="tk1" value="wEVR678vmrIrt" type="hidden">
</form>';
    }

    $echo_bb .= '<span son="0" class="js-son">' . $but_mass["name_action"] . '   →</span><span son="1" class="js-son none">' . $but_mass["name_action"] . ' с замечанием   →</span>


</div>';
}



                    $echo_bb.='<div class="save_button pod_zay pod_pro add_clients red-bb js-reject-acc '.$class_by.'">Отклонить   ⨰</div><div class="save_button pod_zay pod_pro add_clients js-forward-acc '.$class_by.'">Переслать   ⥃</div>';




                }
echo $echo_bb;
            }

        }


        }
		//заказать без привышений

        /*
		if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8))and($row_list["ready"]==1)and($memo_i==0))
		{

		   echo'<form id="lalala_pod_form" action="app/order/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'sign_app_order',$secret).'" type="hidden">
</form>';
           echo'<div class="save_button pod_zay pod_pro add_clients green-bb">Согласовать   →</div><div style="display:none;" class="save_button add_zay js-add-app add_clients yellow-style">Сохранить   →</div>';

		}

		//согласовать
		if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8))and($row_list["ready"]==1)and($memo_i==1))
		{
          echo'<form id="lalala_pod_form" action="app/sign/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'sign_app_sogl',$secret).'" type="hidden">
</form>';
			echo'<div class="save_button pod_zay sog_nar sogl_pro add_clients">Согласовать   →</div><div style="display:none;" class="save_button add_zay js-add-app add_clients yellow-style">Сохранить   →</div>';
		}





	 //сохранить для того у кого S
	 //если не все служебки с положительным ответом
	 if((decision_memo_app($link,$_GET["id"]))and($row_list["status"]==3)and($role->permission('Заявки','S')))
	 {
		 echo'<div class="save_button add_zay js-add-app add_clients yellow-style">Сохранить   →</div>';

	 }


	 //заказать для того у кого S
	 //если все служебки положительные (их нет наверно)
	 	 if((!decision_memo_app($link,$_GET["id"]))and($row_list["status"]==3)and($role->permission('Заявки','S'))and($row_list["ready"]==1))
	 {
		  echo'<form id="lalala_pod_form" action="app/order/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'sign_app_order',$secret).'" type="hidden">
</form>';
           echo'<div class="save_button pod_zay pod_pro add_clients green-bb">Согласовать   →</div><div style="display:none;" class="save_button add_zay js-add-app add_clients yellow-style">Сохранить   →</div>';

	 }
        */
/*
		//отменить
		if(($row_list["id_user"]!=$id_user)and($row_list["status"]==3)and((((array_search($row_list["id_user"],$hie_user)!==false)and($role->permission('Заявки','S'))))or($sign_admin==1)))
		{

			//cнять подпись
			echo'<form id="lalala_shoot_form" action="app/cancel/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'shoot_app_cancel',$secret).'" type="hidden">
</form>';
			echo'<div class="save_button pod_del shoot add_clients ">отменить   →</div>';

		}
*/

		//узнаем в данный момент может ли этот пользователь что-то сделать с данной заявкой. если статус уже на согласовании

        if($row_list["status"]==9) {

            include_once '../ilib/lib_interstroi.php';
            include_once '../ilib/lib_edo.php';


            $edo = new EDO($link, $id_user, false);
            if (($edo->next($id, 0)) === false) {



            }

        }











        ?>

        <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

    </div>


