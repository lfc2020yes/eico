<!--<div class="menu_top" style="border-bottom:0; box-shadow: 0 20px 30px -30px rgba(0, 0, 0, 0.6);"><div class="menu1">
-->

        <div class="menu-09  input-line" style="z-index:150;">
            <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
            <div class="menu-09-left">
                <a href="/" class="menu-09-global"></a><a onclick="history.back();" class="menu-09-prev"><i></i></a>


  <?php
                    //--------------Заполнить информацию по заявке
    function Get_info_doc ($id_zay,$link) {                
        $sql='
        Select z.*,u.name_user,s.name_status from z_doc z, r_user u, r_status s
        where z.id="'.$id_zay.'"
        and z.id_user=u.id
        and z.status=s.numer_status';

        if ($result = $link->query($sql)) {
            //if($row = $result->fetch_assoc() ){
            //    $zay_info='по заявке № '.$row['number'].' от '.$row['date'].' отв: '.$row['name_user'].' ['.$row['name_status'].']';
            //    $id1_user=$row['id_user']; // Принимающий по умолчанию
            //}
            $row = $result->fetch_assoc();
        } else $row=false;
        unset($result);
        return $row;
    } 
  
            $id_edit=0;
            $save_akt=false;
            $sign_akt=false;
            $revers=false;
            if (isset($_GET['id']) && $_GET['id']>0) { //это редактирование акта

                $id_edit=htmlspecialchars(trim($_GET['id']));
                $sql=  "select a.*,u.name_user as name1_user, u0.name_user as name0_user
                        from z_act a
                        left join r_user u on (a.id1_user =u.id)
                        left join r_user u0 on (a.id0_user =u0.id)
                        where a.id='$id_edit' and a.id0_user='$id_visor'";
                $resE=mysql_time_query($link,$sql);
                if ($resE->num_rows>0) {
                    $rowE= mysqli_fetch_assoc($resE);
                    $dt='Акт №'.$rowE['number'];   //.' от '.$rowE['date'];
                    $ddate=$rowE['date'];
                    $name0_user=$rowE['name0_user'];
                    $name1_user=$rowE['name1_user'];
                    $id0_user=$rowE['id0_user'];
                    $id1_user=$rowE['id1_user'];
                    //--------------Заполнить информацию по заявке
                    if ($rowE['id_doc']>0) {
                        if($row=Get_info_doc($rowE['id_doc'],$link)) {
                            $zay_info='по заявке № '.$row['number'].' от '.$row['date'].' отв: '.$row['name_user'].' ['.$row['name_status'].']';
                            $id1_user=$row['id_user']; // Принимающий по умолчанию 
                        } else {
                            $zay_info='[не найдена]';
                        }
                    } else $zay_info='';
                    
                    if (isset($_GET['revers'])) {  //Снять date0
                        //$revers=false;
                        if($role->permission($trole,'U') || $role->permission($trole,'S')) {
                            $sql='update z_act set date0=NULL where id="'.$id_edit.'"';    //date0
                            $count=iDelUpd($link,$sql,false);
                            if($count>1)  {
                              echo "<p>ошибка отзыва акта -- ($count)";
                              die ($sql);
                            } else $revers=true;
                        }
                        if ($revers==false) {
                            ?> <script type="text/javascript">
                                   location.href = 'aktpp/sen/';
                               </script> <?php
                               die ('not revers');
                        }
                         ?> <script type="text/javascript">
                        console.log('push new='+window.location.href) ;
                        </script> <?php
                        $dt.=' (отозван)';
                    }
                    //echo '<input id="id_akt_edit" name="id_akt_edit" value="'.$id_edit.'" type="hidden">';
                } else $id_edit=0;
                unset($resE);
            }
            if ($id_edit==0) {    //Создать акт из корзины
                $dt='Новый Акт';
                $save_akt=true;
                $ddate=date('Y-m-d');
                $id_zay=0;
                if (isset($_GET['zay']) && $_GET['zay']>0) {   //Это заполнение по заявке
                    
                    $id_zay=$_GET['zay'];
                    echo '<input name="id_doc" value="'.$id_zay.'" type="hidden">';
   
                    //--------------Заполнить информацию по заявке
                    if($row=Get_info_doc($id_zay,$link)) {
                        $zay_info='по заявке № '.$row['number'].' от '.$row['date'].' отв: '.$row['name_user'].' ['.$row['name_status'].']';
                        $id1_user=$row['id_user']; // Принимающий по умолчанию 
                    } else {
                        $zay_info="[не найдена]";
                    }
/*                    
                    $zay_info='по заявке '.get_box_data($id_zay,"[не найдена]"
,"z_doc"
//0   1     2     3    4    5     6    7           8     9    10   11         12
,"id,№ ,number, ,от ,date, ,отв: ,name_user, ,[,name_status,]"
,$link
,'Select z.*,u.name_user,s.name_status from z_doc z, r_user u, r_status s
where z.id="'.$id_zay.'"
and z.id_user=u.id
and z.status=s.numer_status'
                      );*/
                }
                /* ----------------------------------------------------------
                 получить новый номер акта
                 сохранить шапку акта
                 сохранить всю корзину в теле акта
                 */
            }
            /*//<div></div>
            echo '<div style="float:left;">';
            echo'<h3 class="head_h" style=" margin-bottom:0px; float:left;">'.$dt.'</h3>';
	    if($id_zay>0) echo '<h4 style="line-height: 10px; clear: left; float:left; font-size: 14px;">'.$zay_info.' </h4>';
	    echo '</div>';*/

  echo'<span class="menu-09-pc-h" ><span class="js-acc-name-top">'.$dt;

 if($id_zay>0)  echo'<i class="ystal">('.$zay_info.')</i>';

  echo'</span >';


	        echo '</div>
    <div class="menu-09-right tours-right-block">';
            
	//если не пользователь ее создатель выводим историю создателей и подписавших
	/*
	if($id_user!=$row_list["id_user"])
	{
	*/
	   //смотрим подписан ли он создателем
	   $hie1 = new hierarchy($link,$row_list["id_user"]);
	   $sign_level1=$hie1->sign_level;
       $sign_admin1=$hie1->admin;
	   $stack_users = array();
	   for ($is=($sign_level1-1); $is<=3; $is++)
       {
		   		if($row_list["id_signed".$is]!=0)
				{
					  array_push($stack_users, $row_list["id_signed".$is]);
				}
				/*
					echo'<div  data-tooltip="Создан/Подписан - " class="user_soz"><img src="img/users/'.$rowx["id_signed".$i].'_100x100.jpg"></div>';
				} else
				{
				    echo'<div  data-tooltip="Создан - " class="user_soz n_yes"><img src="img/users/4_100x100.jpg"></div>';
				}
				*/
	   }
	  // print_r($stack_users);
	   for ($is=0; $is<count($stack_users); $is++)
       {
		   if(($is==0)and($stack_users[$is]==$row_list["id_user"]))
		   {
			   $result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.htmlspecialchars(trim($stack_users[$is])).'"');
	            if($result_txs->num_rows!=0)
	            {
		          $rowxs = mysqli_fetch_assoc($result_txs);
									  $online='';
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}
			   echo'<div sm="'.$stack_users[$is].'"  data-tooltip="Создан/Подписан - '.$rowxs["name_user"].'" class="user_soz n_yes send_mess">'.$online.avatar_img('<img src="img/users/',$stack_users[$is],'_100x100.jpg">').'</div>';
				}
		   } else
		   {
			   if(($is==0))
			   {
				   $result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.htmlspecialchars(trim($row_list["id_user"])).'"');
	               if($result_txs->num_rows!=0)
	               {

		            $rowxs = mysqli_fetch_assoc($result_txs);
					   $online='';
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}
				    echo'<div sm="'.$row_list["id_user"].'"  data-tooltip="Создан - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row_list["id_user"],'_100x100.jpg">').'</div>';
		           }
			   }
			    $hiex = new hierarchy($link,$stack_users[$is]);
	            $sign_levelx=$hiex->sign_level;
                $sign_adminx=$hiex->admin;
			    $but_text='Подписан';
			   //echo($is);
			    if(($sign_adminx!=1)and($sign_levelx==2)and($row_list["signedd_nariad"]==1)and(($is+1)==count($stack_users)))
				{
					$but_text='Утвержден';
				}
			   	if(($sign_adminx!=1)and($sign_levelx==2)and($row_list["signedd_nariad"]!=1))
				{
					$but_text='Согласовать';
				}
			   	if(($sign_adminx!=1)and($sign_levelx==2)and($row_list["signedd_nariad"]==1)and(($is+1)<count($stack_users)))
				{
					$but_text='Согласовать';
				}
			   	if($sign_levelx==3)
				{
					$but_text='Утвержден';
				}

			   	$result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.htmlspecialchars(trim($stack_users[$is])).'"');
	            if($result_txs->num_rows!=0)
	            {
		          $rowxs = mysqli_fetch_assoc($result_txs);
										   $online='';
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}
			      echo'<div sm="'.$stack_users[$is].'"  data-tooltip="'.$but_text.' - '.$rowxs["name_user"].'" class="user_soz n_yes send_mess">'.$online.avatar_img('<img src="img/users/',$stack_users[$is],'_100x100.jpg">').'</div>';
				}
		   }


	   }
	//если нет подписанных то выводит просто создателя наряда
	if(count($stack_users)==0)
	{
		$result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.htmlspecialchars(trim($row_list["id_user"])).'"');

	    if($result_txs->num_rows!=0)
	    {
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
								   $online='';
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}
		echo'<div sm="'.$row_list["id_user"].'"  data-tooltip="Создан - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row_list["id_user"],'_100x100.jpg">').'</div>';
	    }
	}

	if($row_list["signedd_nariad"]==1)
	{
	   //утвержден проведен
	   echo'<div data-tooltip="Утвержден" class="user_soz naryd_yes"></div>';
	}


		//определяем есть ли в наряде служебные записки
		$slyjj=0;
		$slyjj=memo_count_nariad($link,$_GET["id"]);
		//определяем есть ли подпись снизу
		$niz_podpis=-1;
		$niz_podpis=down_signature($sign_level,$sign_admin,$link,$_GET["id"]);

	//вывод статусов по наряду для пользователя
	if(($sign_level==1)and($sign_admin!=1))
	{
		if(($row_list["id_signed0"]!=0)and($row_list["id_signed1"]==0)and($row_list["signedd_nariad"]==0)and($slyjj==0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}
		if(($row_list["id_signed0"]!=0)and($row_list["id_signed1"]==0)and($row_list["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на согласование</div>';
		}
		if(($row_list["id_signed1"]!=0)and($row_list["signedd_nariad"]==0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}
		if(($row_list["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}
	}
	if(($sign_level==2)and($sign_admin!=1))
	{
        if(($row_list["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}

		if(($podpis==0)and($slyjj!=0)and($row_list["signedd_nariad"]==0))
		{
			echo'<div class="status_nana">Подписан на утверждение</div>';
		}
	}
	if(($sign_level==3)and($sign_admin!=1))
	{
        if(($row_list["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}
	}

	if(($sign_admin==1))
	{
		if(($row_list["id_signed0"]!=0)and($row_list["id_signed1"]==0)and($row_list["signedd_nariad"]==0)and($slyjj==0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}
		if(($row_list["id_signed0"]!=0)and($row_list["id_signed1"]==0)and($row_list["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на согласование</div>';
		}
		if(($row_list["id_signed0"]!=0)and($row_list["id_signed1"]!=0)and($row_list["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}

		if(($row_list["id_signed0"]==0)and($row_list["id_signed1"]!=0)and($row_list["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}
		if(($row_list["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}
	}


  include_once $url_system.'module/notification.php';
  include_once $url_system.'module/users.php';

  //================================================================================
  //if (isset($_GET['id'])) {
  //  $id=htmlspecialchars(trim($_GET['id']));
  if ($id_edit>0) {
      if(($role->permission('Прием-Передача','U'))or($sign_admin==1))
          echo'<a href="aktpp/mat/'.$id_edit.'/" data-tooltip="добавить материалы" class="user_press add_work_nary"><i></i></a>';
      echo'<a target="_blank" href="aktpp/print/'.$id_edit.'/" data-tooltip="Печатать документа" class="user_press naryd_print"></a>';
      echo '<a href="aktpp/work/'.$id_edit.'/" data-tooltip="Документы" class="user_press key_work"><i></i></a>';
      if(($role->permission('Прием-Передача','D'))or($sign_admin==1))
          echo '<div class="div_delete"  id="'.$id_edit.'" id_rel="'.$dt.' от '.$ddate.'"><a target="_blank"  data-tooltip="Удалить" class="user_press key_delete"><i></i></a></div>';
  } {
      //прораб
      //сохранить
      //подписать
      //подписано



//	    if(($row_list["ready"]==1)and($podpis==1))
      {
          //все заполнено и не подписано им или выше
          echo'<form id="lalala_pod_form" action="finery/sign/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
                    <input name="tk_sign" value="'.token_access_compile($_GET['id'],'sign_naryd_plus',$secret).'" type="hidden">
                    </form>';
          //if ($save_akt==false) {   //pod_nar pod_pro
         // echo '<div class="save_button pod_nar send_akt" style="display:none;"><i>Отправить</i></div>';

          echo '<div class="save_button add_zay send_akt add_clients green-bb" style="display:none;">Отправить   →</div>';

          //}
          if ($save_akt)  $saveshow="block";
          else            $saveshow="none";
          //echo '<div class="save_button save_akt" id_rel="'.$id_edit.'" style="display:'.$saveshow.';"><i>Сохранить</i></div>';

          echo '<div class="save_button add_zay save_akt add_clients yellow-style" id_rel="'.$id_edit.'" style="display:'.$saveshow.';">Сохранить   →</div>';

          if((isset($stack_error))and((count($stack_error)!=0)))
              $style='block'; else $style='none';
          //echo'<div style="display:'.$style.';" class="error_text_add">Не все поля заполнены для сохранения</div>';
      }

      /*
      if(($podpis==0)and($row_list["signedd_nariad"]==0))
      {
              echo'<div class="save_button green_nar"><i>Подписан</i></div><div class="error_text_green">Не допускается изменения в наряде</div>';
      }
      */

  }
  //==========================================================$sign_level==2
  if(($sign_level==2)and($sign_admin!=1))//====================================
  {
      //начальник участка
      //сохранить
      //утвердить - если все заполнено и нет служебных записок
      //согласовать - если все заполнено но есть служебные записки
      //снять подпись снизу - если не он сам создатель наряда и не утверждено и не согласовано им или выше



      //echo($slyjj);

      if(($row_list["ready"]==1)and($podpis==1))
      {
          //все заполнено и не подписано им или выше
          if($slyjj==0)
          {
              echo'<form id="lalala_seal_form" action="finery/seal/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'seal_naryd_xx',$secret).'" type="hidden">
</form>';
              echo'<div class="save_button pod_nar ut_nar"><i>Утвердить</i></div><div style="display:none;" class="save_button add_nar"><i>Сохранить</i></div>';
          } else
          {
              echo'<form id="lalala_pod_form" action="finery/sign/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'sign_naryd_plus',$secret).'" type="hidden">
</form>';
              echo'<div class="save_button pod_nar sog_nar sogl_pro"><i>Согласовать</i></div><div style="display:none;" class="save_button add_nar"><i>Сохранить</i></div>';
          }
          if((isset($stack_error))and((count($stack_error)!=0)))
          {
              echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';
          } else
          {
              echo'<div style="display:none;" class="error_text_add"></div>';
          }
      }

      if(($row_list["ready"]==0)and($podpis==1))
      {
          //все заполнено и не подписано им или выше
          echo'<div class="save_button add_nar"><i>Сохранить</i></div>';
          if((isset($stack_error))and((count($stack_error)!=0)))
          {
              echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';
          } else
          {
              echo'<div style="display:none;" class="error_text_add"></div>';
          }
      }

      //echo($niz_podpis);
      //echo($niz_podpis);
      if(($niz_podpis!=-1)and($podpis==1))
      {
          //cнять подпись
          echo'<form id="lalala_shoot_form" action="finery/shoot/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'shoot_naryd_user',$secret).'" type="hidden">
</form>';
          echo'<div class="save_button pod_del shoot"><i>Снять подпись</i></div>';
      }


  }
  if(($sign_level==3)and($sign_admin!=1))//=====================================
  {
      //главный инженер
      //сохранить
      //утвердить - если он согласен со всеми служебными записками
      //снять подпись снизу - если не он сам создатель наряда и не не утвержено

      //echo($niz_podpis);



      if(($row_list["ready"]==1)and($podpis==1))
      {
          //все заполнено и не подписано им или выше
          if(decision_memo($link,$_GET["id"])==0)
          {
              echo'<form id="lalala_seal_form" action="finery/seal/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'seal_naryd_xx',$secret).'" type="hidden">
</form>';
              echo'<div class="save_button pod_nar ut_nar"><i>Утвердить</i></div><div style="display:none;" class="save_button add_nar"><i>Сохранить</i></div>';
          } else
          {
              echo'<div class="save_button add_nar"><i>Сохранить</i></div>';
          }
          if((isset($stack_error))and((count($stack_error)!=0)))
          {
              echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';
          } else
          {
              echo'<div style="display:none;" class="error_text_add"></div>';
          }
      }


      if(($row_list["ready"]==0)and($podpis==1))
      {
          //все заполнено и не подписано им или выше
          echo'<div class="save_button add_nar"><i>Сохранить</i></div>';
          if((isset($stack_error))and((count($stack_error)!=0)))
          {
              echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';
          } else
          {
              echo'<div style="display:none;" class="error_text_add"></div>';
          }
      }


      if(($niz_podpis!=-1)and($podpis==1))
      {
          //cнять подпись
          echo'<form id="lalala_shoot_form" action="finery/shoot/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'shoot_naryd_user',$secret).'" type="hidden">
</form>';
          echo'<div class="save_button pod_del shoot"><i>Снять подпись</i></div>';
      }


  }
  if($sign_admin==1)  //==================================================
  {
      //директор
      //сохранить
      //утвердить
      //распровести
      if($podpis==0)
      {
          echo'<div class="save_button rasp_nar"><i>Распровести</i></div>';
          echo'<form id="lalala_disband_form" action="finery/disband/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'disband_naryd_admin',$secret).'" type="hidden">
</form>';
      }


      if(($row_list["ready"]==1)and($podpis==1))
      {
          //все заполнено и не подписано им или выше
          if(decision_memo($link,$_GET["id"])==0)
          {
              echo'<form id="lalala_seal_form" action="finery/seal/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'seal_naryd_xx',$secret).'" type="hidden">
</form>';
              echo'<div class="save_button pod_nar ut_nar"><i>Утвердить</i></div><div style="display:none;" class="save_button add_nar"><i>Сохранить</i></div>';
          } else
          {
              echo'<div class="save_button add_nar"><i>Сохранить</i></div>';
          }
          if((isset($stack_error))and((count($stack_error)!=0)))
          {
              echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';
          } else
          {
              echo'<div style="display:none;" class="error_text_add"></div>';
          }
      }



      if(($row_list["ready"]==0)and($podpis==1))
      {
          //все заполнено и не подписано им или выше
          echo'<div class="save_button add_nar"><i>Сохранить</i></div>';
          if((isset($stack_error))and((count($stack_error)!=0)))
          {
              echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';
          } else
          {
              echo'<div style="display:none;" class="error_text_add"></div>';
          }
      }


      if(($niz_podpis!=-1)and($podpis==1))
      {
          //cнять подпись
          echo'<form id="lalala_shoot_form" action="finery/shoot/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'shoot_naryd_user',$secret).'" type="hidden">
</form>';
          echo'<div class="save_button pod_del shoot"><i>Снять подпись</i></div>';
      }



  }

  ?>



    </div>

</div>