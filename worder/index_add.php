<?
session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; include_once $url_system.'module/config.php'; include_once $url_system.'module/function.php'; include_once $url_system.'login/function_users.php'; initiate($link); include_once $url_system.'module/access.php';




//правам к просмотру к действиям
$hie = new hierarchy($link,$id_user);
//echo($id_user);
$hie_object=array();
$hie_town=array();
$hie_kvartal=array();
$hie_user=array();	
$hie_object=$hie->obj;
$hie_kvartal=$hie->id_kvartal;
$hie_town=$hie->id_town;
$hie_user=$hie->user;

$sign_level=$hie->sign_level;
$sign_admin=$hie->admin;


include_once $url_system.'module/kvartal_select.php';
$user_select_kvartal = oblect2kvartal($link,$_GET["id"]);




$role->GetColumns();
$role->GetRows();
$role->GetPermission();
//правам к просмотру к действиям
//$user_send_new=array();

//создателю
//админу
//всем кто выше поо левал

	//echo($sign_level);
/*
	if($sign_level==1)
	{	
		$user_send_new=array_merge($hie->boss['2'],$hie->boss['4']);
		$user_send_new=array_merge($user_send_new,$hie->boss['3']);
	}
	if($sign_level==2)
	{	
		$user_send_new=array_merge($hie->boss['3'],$hie->boss['4']);		
	}
	if($sign_level==3)
	{	
		$user_send_new=$hie->boss['4'];
	}

print_r($user_send_new);
*/
//обработка формы отправленной по наряду - сохранение
//print_r($_POST['works']);

//проверим можно редактировать или нет цены по материалу в наряде
$edit_price=0;
if ($role->is_column_edit('n_material','price'))
{
	$edit_price=1;
}

//проверим можно редактировать или нет цены по работе в наряде
$edit_price1=0;
if ($role->is_column_edit('n_work','price'))
{
    $edit_price1=1;
}


if((isset($_POST['save_naryad']))and($_POST['save_naryad']==1))
{
	$token=htmlspecialchars($_POST['tk']);
	$id=htmlspecialchars($_GET['id']);
	
	//токен доступен в течении 120 минут
	if(token_access_yes($token,'add_naryd_x',$id,120))
    {
		//echo("!");
	//возможно проверка что этот пользователь это может делать
	 if (($role->permission('Себестоимость','R'))or($sign_admin==1))
	 {	
	
	$stack_memorandum = array();  // общий массив ошибок
	$stack_error = array();  // общий массив ошибок
	$error_count=0;  //0 - ошибок для сохранения нет
	$flag_podpis=0;  //0 - все заполнено можно подписывать

	//print_r($stack_error);
	//исполнитель	
	if(($_POST['ispol_work']==0)or($_POST['ispol_work']==''))
	{
		array_push($stack_error, "ispol_work");
		$error_count++;
		$flag_podpis++;  
	}
	//дата документ
	if($_POST['date_naryad']=='')
	{
		array_push($stack_error, "date_naryad");
		$error_count++;
		$flag_podpis++;
	}	
    //период наряда
	if(($_POST['date_start']=='')or($_POST['date_end']=='')or(($_POST['date_start']==$_POST['date_end'])))
	{
		array_push($stack_error, "date_period");
		$error_count++;
		$flag_podpis++;
	}	
		
		
		
			 $works=$_POST['works'];
             foreach ($works as $key => $value) 
			 {
			   //смотрим вдруг был удален эта работа при оформлении	 
			   if($value['id']!='') 
			   {
				 /*
				$value['id']
				$value['status']
				$value['count']
				$value['price']
				$value['count_mat']
				$value['text']
				
				$_POST['works'][0]["id"]
				*/
				   
				//if($value['status']=='') { /*$error_count++;*/ $flag_podpis++; } 
				
				
				$result_tx=mysql_time_query($link,'Select a.*,b.id_object from i_razdel2 as a,i_razdel1 as b where a.id_razdel1=b.id and a.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такая работа есть
		           $rowx = mysqli_fetch_assoc($result_tx);


				   //проверяем что работа относится к нужному объекту
					if($rowx["id_object"]!=$_GET['id'])
					{
					  array_push($stack_error, $value['id']."work_not_object"); 
					}
					
					
					
				   //проверяем возможно служебная записка нужна и поля не все заполнены	
				   $count_user=$value['count'];
				   $price_user=$value['price'];
				   
				   //$count_sys=$rowx['count_units'];
				   $count_sys=$rowx['count_units']-$rowx['count_r2_realiz']-$rowx['count_r2_replace'];
				   $price_sys=$rowx['price'];
				   
				   $error_work = array();  //обнуляем массив ошибок по конкретной работе
				   
				   $flag_message=0;	//0 - вывод служебной записки по работе не нужен
				   $flag_work=0;
					
				   if($count_sys<$count_user) { $flag_work++; $flag_message=1; if((!is_numeric($count_user))or($count_user==0)) { array_push($error_work, $value['id']."_w_count");  }  }
					
					
					
					if((!is_numeric($count_user))or($count_user<=0)) { $flag_podpis++; }
					
				   if($price_sys<$price_user) { $flag_work++;  $flag_message=1; if((!is_numeric($price_user))or($price_user==0)) { array_push($error_work, $value['id']."_w_price");   }  }	
					
					if((!is_numeric($price_user))or($price_user<=0)) {  $flag_podpis++; }
				 			
				    if((trim($value['text'])=='')and($flag_work>0)) {  $flag_podpis++;  array_push($error_work, $value['id']."_w_text"); }
				   
					if($flag_work>0) { array_push($stack_memorandum, $value['id']."_w_flag");  /*где- то в работе есть служебная записка*/	 }
				 
					
				//проверяем что количество работ по этом работе равно количеству в форме материалов по работе
				$result_tc=mysql_time_query($link,'Select count(a.id) as cou from i_material as a where a.id_razdel2="'.htmlspecialchars(trim($value['id'])).'"');
                $rowc = mysqli_fetch_assoc($result_tc);		
				if(count($value['mat'])!=$rowc["cou"]){  array_push($stack_error, $value['id']."_work_no_count_mat_seb"); }
					
				 
				//идем по его материалам 
				if(is_array($value['mat']))
				{
				  foreach ($value['mat'] as $keys => $value1) 
			      {
					  /*
					$value1['count']
					$value1['price']
					$value1['id']
					$value1['text]
					$value1['max_count']
					$_POST['works'][1]["mat"][0]["id"]
					*/
					$flag_matter=0;
					  
					$result_txx=mysql_time_query($link,'Select a.* from i_material as a where a.id="'.htmlspecialchars(trim($value1['id'])).'"');
                    $num_results_txx = $result_txx->num_rows;
	                

					
					if($num_results_txx!=0)
	                { 
					   $rowxx = mysqli_fetch_assoc($result_txx);
					   
					   //проверяем что этот материал относится к этой работе
					   if($rowxx["id_razdel2"]!=$value['id'])
					   {
						   array_push($stack_error, $value1['id']."_material_no_works");
					   }
						
						
						$count_user=$value1['count'];
						
				       $price_user=$value1['price'];
						
				       //$count_sys=$rowxx['count_units'];  
					   $count_sys=$rowxx['count_units']-$rowxx['count_realiz'];
				       $price_sys=$rowxx['price'];
				      
				      //больше остаточного количества по материалу
                       /*
				      if($count_sys<$count_user) { $flag_matter++;  $flag_message=1; if((!is_numeric($count_user))or($count_user==0)) { array_push($error_work, $value1['id']."_m_count");   }  }
*/
                        if($count_sys<$count_user) { $flag_matter++;  $flag_message=1; if((!is_numeric($count_user))) { array_push($error_work, $value1['id']."_m_count");   }  }
						
					  //больше предполагаемого количества по материалу
					  $count_end=0;  	
					  $count_all_matt = $rowxx["count_units"];	
		              $count_end = (($count_all_matt*$value['count'])/$rowx['count_units']); 
//echo($count_end.'-');
		              if($count_end>$count_sys)
		              {
		                  $count_est=round($count_sys,3);
						  
		              } else
					  {
						  $count_est=round($count_end,3);
					  }
	/*
					  if($count_est!=$count_user) { $flag_matter++;  $flag_message=1; if((!is_numeric($count_user))or($count_user==0)) { array_push($error_work, $value1['id']."_m_count_est");   }  }*/
                        if(($count_est!=$count_user)or($count_user==0)) { $flag_matter++;  $flag_message=1; if((!is_numeric($count_user))) { array_push($error_work, $value1['id']."_m_count_est");   }  }
						
						  //если количество материала у пользователя меньше чем введенное
	$my_material=0;	//свой
    $my_material1=0;	//давальческий
//Определяем сколько материала на пользователе который оформляет наряд
							if($rowxx["id_stock"]!='')
							{
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_kvartal="'.$user_select_kvartal.'" and a.alien=0 and a.id_user="'.$id_user.'" and a.id_stock="'.htmlspecialchars(trim($rowxx["id_stock"])).'"');
					$z_stock_count_users=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $my_material=$row1ss_["summ"];
					  }
					
				 }


                                $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE  a.id_kvartal="'.$user_select_kvartal.'" and  a.alien=1 and a.id_user="'.$id_user.'" and a.id_stock="'.htmlspecialchars(trim($rowxx["id_stock"])).'"');
                                $z_stock_count_users=0;
                                $num_results_t1_ = $result_t1_->num_rows;
                                if($num_results_t1_!=0)
                                {
                                    //такая работа есть
                                    $row1ss_ = mysqli_fetch_assoc($result_t1_);
                                    if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
                                    {
                                        $my_material1=$row1ss_["summ"];
                                    }

                                }

                                /*
                            $result_t1_11=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_user="'.$id_user.'" and a.id_stock="'.htmlspecialchars(trim($rowxx["id_stock"])).'"');
                                            $z_stock_count_users=0;
                                         $num_results_t1_11 = $result_t1_11->num_rows;
                                         if($num_results_t1_11!=0)
                                         {
                                             $row1ss_11 = mysqli_fetch_assoc($result_t1_11);

                                         }

                                */
							
							}
                        $my_material_prior=$my_material;  // по какому количеству материалу будет проверяться хватает ли материала у этого пользователя для оформления наряда
                        if($rowxx["alien"]==1)
                        {
                            $my_material_prior=$my_material1;
                        }


						
					  	if($my_material_prior<$count_user) {  $flag_podpis++; }
						
					  //if((!is_numeric($count_user))or($count_user<=0)) {  $flag_podpis++; }

                        if((!is_numeric($count_user))or($count_user<0)) {  $flag_podpis++; }
						/*
				      if($price_sys<$price_user) {  $flag_matter++;  $flag_message=1; if((!is_numeric($price_user))or($price_user==0)) { array_push($error_work, $value1['id']."_m_price");  }  }
						*/
					  //if((!is_numeric($price_user))or($price_user<=0)) {  $flag_podpis++; }
					  
					  if((trim($value1['text'])=='')and($flag_matter>0)) {  $flag_podpis++; array_push($error_work, $value1['id']."_m_text"); } 
					  
						
					  if($flag_matter>0) { array_push($stack_memorandum, $value1['id']."_m_flag");  /*где- то в работе есть служебная записка*/	 }
						 
						
				    }
					  
				  }
				 } 
					
				 
				 /*
				 if($flag_message==1)
				 {
					 array_push($stack_error, $value['id']."_w_flag");  //где- то в работе есть служебная записка					 
				 }
				*/	
					
				 if(($flag_message==1)and(count($error_work)!=0))
				 {
					 //echo("!");
					 //print_r($error_work);
					 //ошибка общая для служебной записке не все поля заполнены
					 //добавляем ошибки из $error_work в $stack_error
					 foreach ($error_work as $keys_w => $value_w) 
			         {
					   array_push($stack_error, $error_work[$keys_w]);
					 }
					 $error_count++;
				 }
				}
			 }
			 }
	    //есть ли ошибки по заполнению
		//print_r($stack_error);
	    if((count($stack_error)==0)and($error_count==0))
		{
		   //ошибок нет
		   //сохраняем наряд
		   	 $works=$_POST['works'];
			 $count_work=0;
			 $today[0] = date("y.m.d"); //присвоено 03.12.01
             $today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17

	         $date_=$today[0].' '.$today[1];
             foreach ($works as $key => $value) 
			 {
			   	 
			   if($value['id']!='') 
			   { 
				 /*
				$value['id']
				$value['status']
				$value['count']
				$value['price']
				$value['count_mat']
				$value['text']
				*/
				$result_tx=mysql_time_query($link,'Select a.* from i_razdel2 as a where a.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такая работа есть
		           $rowx = mysqli_fetch_assoc($result_tx);
				   
				   if($count_work==0)	
				   {		
                     $id_user=id_key_crypt_encrypt(htmlspecialchars(trim($_SESSION['user_id'])));
					 
					 //include_once $url_system.'ilib/lib_interstroi.php'; 
					 $numer=get_numer_doc($link,'"'.htmlspecialchars(trim($_POST["date_naryad"])).'"',1);
					   
					 //echo('INSERT INTO n_nariad (id,numer_doc,id_user,id_object,id_implementer,date_make,date_doc,date_begin,date_end,status,id_sign_nariad,signedd_nariad) VALUES ("","'.$numer.'","'.$id_user.'","'.htmlspecialchars($_GET['id']).'","'.htmlspecialchars(trim($_POST['ispol_work'])).'","'.$date_.'","'.htmlspecialchars(trim($_POST["date_naryad"])).'","'.htmlspecialchars($_POST['date_start']).'","'.htmlspecialchars($_POST['date_end']).'","'.$id_user.'","0")') ; 
					   
					 //добавляем неподписанный наряд  
				     mysql_time_query($link,'INSERT INTO n_nariad (id,numer_doc,id_user,id_object,id_implementer,date_make,date_create,date_doc,date_begin,date_end,ready,id_signed0,id_signed1,id_signed2,signedd_nariad,status,comment) VALUES ("","'.$numer.'","'.$id_user.'","'.htmlspecialchars($_GET['id']).'","'.htmlspecialchars(trim($_POST['ispol_work'])).'","'.$date_.'","'.$date_.'","'.htmlspecialchars(trim($_POST["date_naryad"])).'","'.htmlspecialchars($_POST['date_start']).'","'.htmlspecialchars($_POST['date_end']).'","0","0","0","0","0","1","'.ht($_POST['name_b']).'")');
					   
					 $ID_N=mysqli_insert_id($link);  
				   }	
				 
				  $count_work++;	 
				
				  $count_memo=0;	
				  $status_memo=0;
				  $memo='';	
					
				  $found1 = array_search($value['id']."_w_flag",$stack_memorandum);   
	              if($found1 !== false) 
	              {
					  
				    $memo=htmlspecialchars(trim($value['text'])); 
					  $count_memo++;
					  
				  } else { $status_memo=1; }
					

				  if($edit_price1==1)
                  {				
				  //добавляем работу к наряду	
				  mysql_time_query($link,'INSERT INTO n_work (id,id_nariad,id_razdeel2,name_work,procent,units,count_units,count_units_razdel2,price,price_razdel2,memorandum,id_sign_mem,signedd_mem) VALUES ("","'.$ID_N.'","'.htmlspecialchars(trim($value['id'])).'","'.htmlspecialchars(trim($rowx['name_working'])).'","","'.htmlspecialchars(trim($rowx['units'])).'","'.htmlspecialchars(trim($value['count'])).'","'.htmlspecialchars(trim($rowx['count_units'])).'","'.htmlspecialchars(trim($value['price'])).'","'.htmlspecialchars(trim($rowx['price'])).'","'.$memo.'","","'.$status_memo.'")');	
				  } else
				  {
				  //если он не может редактировать цены заносим максимальные цены из себестоимости	  
				  mysql_time_query($link,'INSERT INTO n_work (id,id_nariad,id_razdeel2,name_work,procent,units,count_units,count_units_razdel2,price,price_razdel2,memorandum,id_sign_mem,signedd_mem) VALUES ("","'.$ID_N.'","'.htmlspecialchars(trim($value['id'])).'","'.htmlspecialchars(trim($rowx['name_working'])).'","","'.htmlspecialchars(trim($rowx['units'])).'","'.htmlspecialchars(trim($value['count'])).'","'.htmlspecialchars(trim($rowx['count_units'])).'","'.htmlspecialchars(trim($rowx['price'])).'","'.htmlspecialchars(trim($rowx['price'])).'","'.$memo.'","","'.$status_memo.'")');						  
				  }
				  $ID_W=mysqli_insert_id($link); 
					
			    //идем по его материалам 
				if(is_array($value['mat']))
				{
				  foreach ($value['mat'] as $keys => $value1) 
			      {
					  /*
					$value1['count']
					$value1['price']
					$value1['id']
					*/
					$result_txx=mysql_time_query($link,'Select a.* from i_material as a where a.id="'.htmlspecialchars(trim($value1['id'])).'"');
                    $num_results_txx = $result_txx->num_rows;
	                if($num_results_txx!=0)
	                { 
					   $rowxx = mysqli_fetch_assoc($result_txx);
		
					 //подсчитываем оставшееся количество материала по смете для этой работы		
                     $summ=0;
					    if(($rowxx["count_realiz"]!='')and($rowxx["count_realiz"]!=0))
						{
					     $summ=$rowxx["count_realiz"];
					    }
				
					 
					 $count_ost_matt=$rowxx["count_units"]-$summ;
					 if($count_ost_matt<0)
				     {
					     $count_ost_matt=0;
					 }


	//----------

	    $count_all_matt = $rowxx["count_units"];
		$count_end=0;   
		$count_end = (($count_all_matt*$value['count'])/$rowx['count_units']); 
	
		//если рассчитанное кол-во материала больше чем запланировано в себестоимости
		//бывает из-за привышения работы связанной с этими материалами
		if($count_end>$count_ost_matt)
		{
		  $count_end=$count_ost_matt; 
		}

    //----------						
						
						
					   
				   $status_memo=0;
				   $memo='';	
					//print_r($stack_memorandum);
						//echo($value1['id']);
				   $found1 = array_search($value1['id']."_m_flag",$stack_memorandum);   
	               if($found1 !== false) 
	               {
					  $count_memo++;
				    $memo=htmlspecialchars(trim($value1['text']));  
					  
				   } else { $status_memo=1; }
						
						//$value1['max_count']
						
					//echo('.'.$status_memo.'-')	;
						/*
						if($edit_price==1)
                       {	*/
					   //добавляем материал к добавленной работе
						   
						   
				       mysql_time_query($link,'INSERT INTO n_material (id,id_nwork,id_material,material,units,count_units,count_units_material,count_units_material_all,price,price_material,memorandum,id_sign_mem,signedd_mem,alien) VALUES ("","'.$ID_W.'","'.htmlspecialchars(trim($value1['id'])).'","'.htmlspecialchars(trim($rowxx['material'])).'","'.htmlspecialchars(trim($rowxx['units'])).'","'.htmlspecialchars(trim($value1['count'])).'","'.$count_end.'","'.htmlspecialchars(trim($rowxx['count_units'])).'","'.htmlspecialchars(trim($value1['price'])).'","'.htmlspecialchars(trim($rowxx['price'])).'","'.$memo.'","","'.$status_memo.'","'.$rowxx["alien"].'")');
					   /*} else
					   {
					       mysql_time_query($link,'INSERT INTO n_material (id,id_nwork,id_material,material,units,count_units,count_units_material,count_units_material_all,price,price_material,memorandum,id_sign_mem,signedd_mem) VALUES ("","'.$ID_W.'","'.htmlspecialchars(trim($value1['id'])).'","'.htmlspecialchars(trim($rowxx['material'])).'","'.htmlspecialchars(trim($rowxx['units'])).'","'.htmlspecialchars(trim($value1['count'])).'","'.$count_end.'","'.htmlspecialchars(trim($rowxx['count_units'])).'","'.htmlspecialchars(trim($rowxx['price'])).'","'.htmlspecialchars(trim($rowxx['price'])).'","'.$memo.'","","'.$status_memo.'")');						   
					   }*/
						
						
					}
				  }
				}
				   //изменяем статус наряда в зависимости от заполнения
					
				   $status_nariad=0;
				   if($flag_podpis==0){ $status_nariad=1; }
				   //if($count_memo!=0){ $status_nariad=-1; }
				   mysql_time_query($link,'update n_nariad set ready="'.$status_nariad.'" where id = "'.htmlspecialchars(trim($ID_N)).'"');
					
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
                    /*
				  $user_send= array();	
				  $user_send_new= array();		
				
				  
				  
				  if($sign_level==1)
	{	
		$user_send_new=array_merge($hie->boss['2'],$hie->boss['4']);
		$user_send_new=array_merge($user_send_new,$hie->boss['3']);
	}
	if($sign_level==2)
	{	
		$user_send_new=array_merge($hie->boss['3'],$hie->boss['4']);		
	}
	if($sign_level==3)
	{	
		$user_send_new=$hie->boss['4'];
	}	
				 $user_send_new= array_unique($user_send_new);		
				 //print_r($user_send_new);	
				  $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
                  $num_results_custom_url = $result_url->num_rows;
                  if($num_results_custom_url!=0)
                  {
			         $row_list = mysqli_fetch_assoc($result_url);
		          }
					
				  $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list["id_kvartal"].'"');
                  $num_results_custom_town = $result_town->num_rows;
                  if($num_results_custom_town!=0)
                  {
			         $row_town = mysqli_fetch_assoc($result_town);	
		          }		
					
				  $text_not='<strong>'.$name_user.'</strong> создал новый <a href="worder/'.$ID_N.'/">наряд №'.$ID_N.'</a>, по объекту -  '.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';
				  
				  //echo($text_not);	
					
				  notification_send($text_not,$user_send_new,$id_user,$link);

				  */
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	
				}
			 }
			 }
			
			 //удаляем из корзины нарядов по этому дому
			 setcookie("basket_".$id_user."_".htmlspecialchars($_GET['id']), "", time()-3600,"/", $base_cookie, false, false);
			
			//echo($flag_podpis);
			
			 if($flag_podpis==0)
			 {
			   //можно предложить сразу подписать его
			   header("Location:".$base_usr."/worder/".$ID_N.'/');
			   die();				 
			 } else
			 {		 
			    header("Location:".$base_usr."/worder/");
			    die();
			 }
			
		  
		   
		}
	
				/* if((isset($value['count']))and(is_numeric($value['count']))and(isset($value['price']))and(is_numeric($value['price']))and(isset($value['ed']))and(trim($value["ed"])!='')and(isset($value['name']))and(trim($value["name"])!='')) 
		         {
*/
}

}
	
	
}



$secret=rand_string_string(4);
$_SESSION['s_t'] = $secret;	





//проверить и перейти к последней себестоимости в которой был пользователь

$b_co='basket_'.$id_user;

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /finery/add/28/
//     0   1     2  3

$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);


if ( count($_GET) == 1 ) //--Если были приняты данные из HTML-формы
{

  if($D_404[4]=='')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
		
        
		$result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0)
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} else
		{
			$row_list = mysqli_fetch_assoc($result_url);
			if(!isset($_COOKIE["basket_".$id_user."_".htmlspecialchars(trim($_GET['id']))]))
			{
			    header("Location:".$base_usr);	
			    die();
			} else
			{
				//проверим может пользователь вообще не может работать с себестоимостью
				if (($role->permission('Себестоимость','R'))or($sign_admin==1))
	            {
				
			    } else
			    {
				 header("HTTP/1.1 404 Not Found");
	             header("Status: 404 Not Found");
	             $error_header=404;				
			    }
			}
		}
		
	} else
	{
       header("HTTP/1.1 404 Not Found");
	   header("Status: 404 Not Found");
	   $error_header=404;
	}
  } else
  {
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $error_header=404;	  
  }
} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}

//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы


include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('worder_add','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php'; include $url_system.'template/head.php';
?>
</head><body><div class="alert_wrapper"><div class="div-box"></div></div>
<?
include_once $url_system.'template/body_top.php';	
?>

<div class="container">
<?


if ( isset($_COOKIE["iss"]))
{
    if($_COOKIE["iss"]=='s')
    {
        echo'<div class="iss small">';
    } else
    {
        echo'<div class="iss big">';
    }
} else
{
    echo'<div class="iss small">';
}

//echo(mktime());

/*
        $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}
*/
	
        $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}	
	
?>

<div class="left_block">
  <div class="content">

<?
                $act_='display:none;';
	            $act_1='';
	            if(cookie_work('it_','on','.',60,'0'))
	            {
		            $act_='';
					$act_1='on="show"';
	            }

	  include_once $url_system.'template/top_prime_worder_add.php';
	            ?>
      <div id="fullpage" class="margin_60  input-block-2020 ">
          <div class="section" id="section0">
              <div class="height_100vh">
                  <div class="oka_block_2019">

                      <?
                      echo'<div class="line_mobile_blue">Оформление наряда';
                      $D = explode('.', $_COOKIE["basket_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);

if(count($D)>0)
{
  echo'<span all="8" class="menu-mobile-count">'.count($D).'</span>';
}

echo'</div>';

                      ?>

                      <div class="div_ook" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
<form id="lalala_add_form" style=" padding:0; margin:0;" method="post" class="js-add-worder-material" enctype="multipart/form-data">
 <input name="save_naryad" value="1" type="hidden">

<?

    if (( isset($_COOKIE["basket_".$id_user."_".htmlspecialchars(trim($_GET['id']))]))and($_COOKIE["basket_".$id_user."_".htmlspecialchars(trim($_GET['id']))]!=''))
    {

    $query_string .= '<div class="info-suit"><div class="input-block-2020">';


            $query_string .= '<span class="h3-f">Данные по наряду</span>';



            $su_5_name='';
            $su_5='';
            $su_5_class='';
            $su5_st='';


            if($_POST['ispol_work']!=0)
            {


            $result_uui = mysql_time_query($link, 'select implementer from i_implementer where id="' . ht($_POST['ispol_work']) . '"');
            $num_results_uui = $result_uui->num_rows;

            if ($num_results_uui != 0) {
            $row_uui = mysqli_fetch_assoc($result_uui);
            $su_5_name=$row_uui["implementer"];
            }


            $su_5=$_POST['ispol_work'];
            $su_5_class='active_in_2018x active_in_2021';
            $su5_st='style="display: inline-block;"';
            }



            $query_string .= '<!--input start	-->';

            $query_string .= '<div class=" big_list" style="margin-bottom: 10px;">';
                //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

                    $query_string .= '<div class="list_2021 input_2021 input-search-list gray-color js-zindex  '.$su_5_class.'" list_number="box2"><i class="js-open-search"></i><span class="click-search-icon" '.$su5_st.'></span><div class="b_loading_small loader-list-2021"></div><label>Поиск исполнителя (название)</label><input name="kto" value="'.$su_5_name.'" id="date_124" sopen="search_implementer" fns="0" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search gloab2 js-id-kto-ajax" name="ispol_work" id="search_items_5"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';



                            //выбирать только тех у кого есть какие то счета на этом контрагенте
                            $result_work_zz=mysql_time_query($link,"SELECT distinct A.id,A.implementer from i_implementer as A where A.id_user='".$id_user."' ORDER BY A.implementer limit 0,40");



                            $num_results_work_zz = $result_work_zz->num_rows;
                            if($num_results_work_zz!=0)
                            {
                            //echo'<li><a href="javascript:void(0);" rel="0"></a></li>';
                            for ($i=0; $i<$num_results_work_zz; $i++)
                            {
                            $row_work_zz = mysqli_fetch_assoc($result_work_zz);

                            $yop='';
                            if($row_work_zz["id"]==$su_5) {
                            $yop='sel_active';
                            }

                            $query_string .= '<li class="'.$yop.'"><a href="javascript:void(0);" rel="'.$row_work_zz["id"].'">'.$row_work_zz["implementer"].' </a></li>';

                            }
                            }

                            $query_string .= '</ul><div class="div_new_2021"><div class="oper_name"></div></div></div></div><!--input end	-->';




                /*
                echo'<input id="date_hidden_table" name="date_naryad" value="'.ipost_($_POST['date_naryad'],$row_list["date_doc"]).'" type="hidden">';

                echo'<input '.$status_edit1.' defaultv="'.ipost_($_POST['datess'],date_fik($row_list["date_doc"])).'" readonly="true" name="datess" defuat="" value="'.ipost_($_POST['datess'],date_fik($row_list["date_doc"])).'" id="date_table" class="input_f_1 input_100 calendar_t white_inp '.$status_class.' '.iclass_("date_naryad",$stack_error,"error_formi").'" placeholder="Дата документа"  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div></div>';
        */
        $class_cal1='';
        if((ipost_($_POST['date_naryad'],'')!='')and(validateDate(ipost_($_POST['date_naryad'],''),'Y-m-d')))
        {
        $class_cal1='active_in_2021';
        }

        $query_string .= '<!--input start-->';
        $query_string .= '<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color '.$class_cal1.'"><label><i>Дата документа</i><span>*</span></label><input name="datess" id="date_table" readonly="true" value="'.ipost_($_POST['datess'],'').'" class="input_new_2021 gloab2 required cal_2021  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div><div class="pad10" style="padding: 0;"><span class="bookingBox"></span></div><input id="date_hidden_table" class="gloab2" name="date_naryad" value="'.ipost_($_POST['date_naryad'],'').'" type="hidden"></div>';
        $query_string .= '<!--input end	-->';

        ?>

        <script type="text/javascript">var disabledDays = [];
            $(document).ready(function(){
                window.date_picker_step=0;
                input_2021();
                $("#date_table").datepicker({
                    altField:'#date_hidden_table',
                    onClose : function(dateText, inst){
                        //alert(dateText); // Âûáðàííàÿ äàòà
                        input_2021();
                    },
                    altFormat:'yy-mm-dd',
                    defaultDate:null,
                    beforeShowDay: disableAllTheseDays,
                    dateFormat: "d MM yy"+' г.',
                    firstDay: 1,
                    minDate: "-120D", maxDate: "+120D",
                    beforeShow:function(textbox, instance){
                        //alert('before');
                        setTimeout(function () {
                            instance.dpDiv.css({
                                position: 'absolute',
                                top: 0,
                                left: 0
                            });
                        }, 10);

                        $('.bookingBox').append($('#ui-datepicker-div'));
                        $('#ui-datepicker-div').hide();
                    } });

                $("#date_table1").datepicker({
                    range:'period',
                    numberOfMonths: 2,
                    firstDay: 1,
                    minDate: "-1Y", maxDate: "+1Y",
                    onClose : function(dateText, inst){
                        //alert(dateText); // Âûáðàííàÿ äàòà
                        input_2021();
                    },
                    onSelect: function(dateText, inst, extensionRange) {


                        $('#date_hidden_start').val(jQuery.datepicker.formatDate('yy-mm-dd',extensionRange.startDate));
                        $('#date_hidden_end').val(jQuery.datepicker.formatDate('yy-mm-dd',extensionRange.endDate));

                        $('#date_table1').val(jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.startDate) + ' - ' + jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.endDate));
                        window.date_picker_step++;



                        if(window.date_picker_step==2)
                        {
                            //$('#date_table').сlose();
                            //$('.datepicker').hide();
                            window.date_picker_step=0;
                            setTimeout ( function () { $('.bookingBox1').hide(); }, 1000 );

                        }
                    },
                    beforeShow:function(textbox, instance){
                        //alert('before');
                        setTimeout(function () {
                            instance.dpDiv.css({
                                position: 'absolute',
                                top: 0,
                                left: 0
                            });

                            $('.bookingBox1').css({
                                display:'none'
                            });
                        }, 10);

                        $('.bookingBox1').append($('#ui-datepicker-div'));
                        $('#ui-datepicker-div').hide();
                    } });

                <?
                if($_POST['datess1']!='')
                {
                    /*
                    $query_string .= 'var st=\''.ipost_($_POST['date_start'],"").'\';
var st1=\''.ipost_($_POST['date_end'],"").'\';
var st2=\''.ipost_($_POST['datess1'],"").'\';';
                    $query_string .= 'jopacalendar(st,st1,st2);';*/

                    echo 'var st=\''.ipost_($_POST['date_start'],"").'\'; ';
                    echo 'var st1=\''.ipost_($_POST['date_end'],"").'\'; ';
                    echo 'var st2=\''.ipost_($_POST['datess1'],"").'\'; ';
                    echo 'jopacalendar(st,st1,st2);';


                }
                ?>
                //$('#date_table1').datepicker('setDate', ['+1d', '+30d']);
            });




            function resizeDatepicker() {
                setTimeout(function() { $('.bookingBox1 > .ui-datepicker').width('100%'); }, 10);
            }

            function jopacalendar(queryDate,queryDate1,date_all)
            {

                if(date_all!='')
                {
                    var dateParts = queryDate.match(/(\d+)/g), realDate = new Date(dateParts[0], dateParts[1] -1, dateParts[2]);
                    var dateParts1 = queryDate1.match(/(\d+)/g), realDate1 = new Date(dateParts1[0], dateParts1[1] -1, dateParts1[2]);
                    $('#date_table1').datepicker('setDate', [realDate,realDate1]);
                    $('#date_table1').val(date_all);
                }
            }


        </script>




        <?


                          $class_cal1='';
                          if((ipost_($_POST['datess1'],'')!='')and(validateDate(ipost_($_POST['datess1'],''),'Y-m-d')))
                          {
                              $class_cal1='active_in_2021';
                          }
/*
                          echo'<input id="date_hidden_start" name="date_start" value="'.ipost_($_POST['date_start'],$row_list["date_begin"]).'" type="hidden">';
                          echo'<input id="date_hidden_end" name="date_end" value="'.ipost_($_POST['date_end'],$row_list["date_end"]).'" type="hidden">';

                          echo'<label>Период работ</label><input defaultv="'.ipost_($_POST['datess1'],date_fik($row_list["date_begin"],$row_list["date_end"])).'" '.$status_edit1.' readonly="true" name="datess1" value="'.ipost_($_POST['datess1'],date_fik($row_list["date_begin"],$row_list["date_end"])).'" id="date_table1" class="input_f_1 input_100 calendar_t white_inp label_s '.iclass_("date_period",$stack_error,"error_formi").' '.$status_class.'" placeholder="Период работ"  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div></div>';
*/

                          $query_string .= '<!--input start-->';
                          $query_string .= '<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color '.$class_cal1.'"><label><i>Период работ</i><span>*</span></label><input name="datess1" id="date_table1" readonly="true" value="'.ipost_($_POST['datess1'],'').'" class="input_new_2021 gloab2 required  no_upperr cal_rang_2021" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div><div class="pad10" style="padding: 0;"><span class="bookingBox1"></span></div><input id="date_hidden_start" class="gloab2" name="date_start" value="'.ipost_($_POST['date_start'],'').'" type="hidden"><input id="date_hidden_end" class="gloab2" name="date_end" value="'.ipost_($_POST['date_end'],'').'" type="hidden"></div>';
                          echo'<!--input end	-->';

        $query_string .= '<!--input start-->
<div class="margin-input"><div class="input_2018 input_2018_resize '.$class_t.'  gray-color '.iclass_("name_b",$stack_error,"required_in_2018").'"><label><i>Комментарий</i></label><div class="otziv_add js-resize-block"><textarea cols="10" rows="1" name="name_b" class="di input_new_2018  text_area_otziv js-autoResize ">'.ipost_($_POST['name_b'],'').'</textarea></div><div class="div_new_2018"><div class="error-message"></div></div></div></div>
<!--input end	-->';


                      $query_string .= '</div></div>';




         }

echo($query_string);


	
    //echo'<div class="content_block1" style="padding-top:20px;" id_content="'.$id_user.'">';


					 
	//echo($_COOKIE["basket_".htmlspecialchars(trim($_GET['id']))]);				 
	  if (( isset($_COOKIE["basket_".$id_user."_".htmlspecialchars(trim($_GET['id']))]))and($_COOKIE["basket_".$id_user."_".htmlspecialchars(trim($_GET['id']))]!=''))
	  {
          echo' <div class="info-suit">
                          <span class="h3-f">Список работ <span class="pol-card" >'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</span></span>';
	       $D = explode('.', $_COOKIE["basket_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);
           for ($i=0; $i<count($D); $i++)
		   {
	             //проверим может вообще такой работы уже нет
			     $result_t1=mysql_time_query($link,'Select a.* from i_razdel2 as a where a.id="'.$D[$i].'"');
                 $num_results_t1 = $result_t1->num_rows;
	             if($num_results_t1!=0)
	             {  
		            //такая работа есть
		            $row1ss = mysqli_fetch_assoc($result_t1);
					 
					$rrtt++;
					if($rrtt==1)
					{
						/*
						$sale='add_naryad';
		//echo($secret);
		$posl_chifra_id2=htmlspecialchars(trim($_GET['id']))%10;
		$timeet=time();  //1335939007
		$st_time1 = substr($timeet, 0, $posl_chifra_id2);
        $st_time2= substr($timeet, $posl_chifra_id2);		
		$token=htmlspecialchars(trim($_GET['id'])).'.'.md5($secret.htmlspecialchars(trim($_GET['id'])).$secret[0].$sale).'.'.encode_x($secret[2].$st_time2.$st_time1.$secret[3],$secret);
		*/
		$token=token_access_compile($_GET['id'],'add_naryd_x',$secret);				
						
						echo'<input type="hidden" value="'.$token.'" name="tk">'; 
						
						
						//заголовок таблицы
						
						 echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_0" class="smeta1"><thead>
		   <tr class="title_smeta"><th class="t_2 no_padding_left_ jk4">Наименование работ</th>';
						
						//<th class="t_3">статус</th>
							
							echo'<th class="t_4 jk44">ед. изм.</th><th class="t_5">кол-во</th><th class="t_6">стоимость ед. (руб.)</th><th class="t_7 jk5">всего (руб.)</th><th class="t_10 jk6"></th></tr></thead><tbody>';
						 echo'<tr class="loader_tr" style="height:20px;"><td colspan="7"></td></tr>';
					}
					 
				 $summ=0;
					$replace=0;
                 $ostatok=0;
                 $proc_view=0;	
				 $flag_history=0;
			    
			     //$result_t1_=mysql_time_query($link,'Select sum(a.count_units) as summ from n_work as a,n_nariad as b where b.id=a.id_nariad and b.signedd_nariad=1 and a.id_razdeel2="'.$row1ss["id"].'"');
				 $result_t1_=mysql_time_query($link,'Select count_r2_realiz as summ,count_r2_replace as replace_c from i_razdel2 as a where a.id="'.$row1ss["id"].'"');
					 	 
                 //echo('Select sum(a.count_units) as summ from n_work as a where a.id_razdeel2="'.$row1ss["id"].'" and a.status="1"');
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					 {
					     $summ=$row1ss_["summ"];
						 $flag_history=1;
					 }
                     if(($row1ss_["replace_c"]!='')and($row1ss_["replace_c"]!=0))
                     {
                         $replace=$row1ss_["replace_c"];
                     }


				 }
					 $ostatok=$row1ss["count_units"]-$summ-$replace;
					 if($ostatok<0)
				     {
					     $ostatok=0;
					 }
					 $proc_view=round((($row1ss["count_units"]-$ostatok)*100)/$row1ss["count_units"]); 
					 
					 //линия выполеннных работ
					echo'<tr work="'.$row1ss["id"].'" class="loader_tr"><td colspan="6"><div class="loaderr"><div id_loader="'.$row1ss["id"].'" class="teps" rel_w="'.$proc_view.'" style="width:0%"><div class="peg_div"><div><i class="peg"></i></div></div></div></div></td></tr>';
					 
					 //история нарядов по этой работе
if($flag_history==1)
{	
		 echo'<tr work="'.$row1ss["id"].'" class="loader_tr loader_history" fo="'.$row1ss["id"].'" style="height:0px;"><td colspan="6"><div class="loader_inter"><div></div><div></div><div></div><div></div></div></td></tr>';
}

                     $result_t1__34=mysql_time_query($link,'Select b.razdel1,a.name_working,a.razdel2,a.date0,a.date1  from i_razdel2 as a,i_razdel1 as b where a.id="'.$row1ss["id"].'" and a.id_razdel1=b.id');
                     $num_results_t1__34 = $result_t1__34->num_rows;
                     if($num_results_t1__34!=0)
                     {
                         $row1ss__34 = mysqli_fetch_assoc($result_t1__34);

                     }



                     //работа сама
					 echo'<tr work="'.$row1ss["id"].'" style="background-color:#f0f4f6;" class="jop work__s" id_trr="'.$i.'" rel_id="'.$row1ss["id"].'">
                  <td class="no_padding_left_ pre-wrap one_td"><span class="s_j">'.$row1ss__34["razdel1"].'.'.$row1ss__34["razdel2"].' '.$row1ss["name_working"].'</span><input type=hidden value="'.$row1ss["id"].'" name="works['.$i.'][id]">';
					 if($flag_history==1)
					 {
					   echo'<span class="edit_panel11"><span data-tooltip="история нарядов" for="'.$row1ss["id"].'" class="history_icon">M</span></span>';
					 }
						 
						 echo'</td>';
					 /*
			<td class="pre-wrap">';

		   echo'<div class="select_box eddd_box" style="margin-top:0px;"><a class="slct_box" data_src="0" style="margin-bottom: 0px;"><span class="ccol"></span></a><ul class="drop_box">';



				  echo'<li><a href="javascript:void(0);"  rel="1"><100%</a></li>'; 
			  echo'<li><a href="javascript:void(0);"  rel="2">Сделано</a></li>'; 
			
		   echo'</ul><input name="works['.$i.'][status]" id="status_'.$i.'" value="" type="hidden"></div>'; 
	   
					   
			echo'</td>	  
				  */
				  
echo'<td class="pre-wrap center_text_td">'.$row1ss["units"].'';
	            
				//количество нарядов по данной работе
				
//<div class="musa_plus">3</div>
//echo'<div class="musa_plus mpp">+</div>';
echo'</td>
<td>';

//проверим сколько работ уже было закрыто

$class_c='';
if($ostatok==0)
{
	$class_c='redaa';
}
echo'<div class="width-setter"><label>MAX('.$ostatok.')</label><input style="margin-top:0px;" name="works['.$i.'][count]" all="'.$row1ss["count_units"].'" max="'.$ostatok.'" id="count_work_'.$i.'" placeholder="MAX - '.$ostatok.'" class="input_f_1 input_100 white_inp label_s '.$class_c.' count_finery_ '.iclass_($row1ss["id"].'_w_count',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["count"],"").'"></div>';					 
					 
echo'</td>
<td>';
if($edit_price1==1)
{					 
echo'<div class="width-setter"><label>MAX('.$row1ss["price"].')</label><input style="margin-top:0px;" name="works['.$i.'][price]" max="'.$row1ss["price"].'" id="price_work_'.$i.'" placeholder="MAX - '.$row1ss["price"].'" class="input_f_1 input_100 white_inp label_s price_finery_ '.iclass_($row1ss["id"].'_w_price',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["price"],"").'"></div>';		
} else
{
//проставлять макс сумму по себестоимости
//запретить редактировать
    //echo($_POST['works'][$i]["price"]);
    //echo('price-'.$row1ss["price"]);
echo'<div class="width-setter"><label>MAX('.$row1ss["price"].')</label><input readonly="true" style="margin-top:0px;" name="works['.$i.'][price]" max="'.$row1ss["price"].'" id="price_work_'.$i.'" placeholder="MAX - '.$row1ss["price"].'" class="input_f_1 input_100 white_inp label_s price_finery_ grey_edit '.iclass_($row1ss["id"].'_w_price',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["price"],$row1ss["price"]).'"></div>';
}
echo'</td>
<td><span class="summ_price s_j " id="summa_finery_'.$i.'" ></span></td>

<td><div class="font-rank del_naryd_work" naryd="'.$_GET['id'].'" id_rel="'.$row1ss["id"].'"><span class="font-rank-inner">x</span></div></td>
           </tr>';
					 
				 
	//служебная записка по работе			
	 echo'<tr work="'.$row1ss["id"].'" class="loader_tr" style="height:0px;"><td colspan="6">
	 <div class="messa" id_mes="'.$row1ss["id"].'">
	 <span class="hs">Оформление служебной записки<div></div></span>';
/*
echo'<div class="div_textarea_otziv div_text_glo '.iclass_($row1ss["id"].'_w_text',$stack_error,"error_formi").'" style="margin-top:15px;">
			<div class="otziv_add">
          <textarea placeholder="Напиши руководству причину привышения параметров по этой работе относительно запланированной себестоимости" cols="40" rows="1" id="otziv_area_'.$i.'" name="works['.$i.'][text]" class="di text_area_otziv">'.ipost_($_POST['works'][$i]["text"],"").'</textarea>
		  
        </div></div>';
*/

echo'<div class="width-setter mess_slu"><input style="margin-top:0px;" name="works['.$i.'][text]"  placeholder="Напиши руководству причину превышения параметров относительно запланированной себестоимости" class="input_f_1 input_100 white_inp label_s text_finery_message_ '.iclass_($row1ss["id"].'_w_text',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["text"],"").'"></div>';					 
					 
					 
	 echo'</div>
	 </td></tr>';
				 

					 //смотрим может есть материалы с этой работой
					 $result_mat=mysql_time_query($link,'Select a.* from i_material as a where a.id_razdel2="'.$row1ss["id"].'" order by a.id');
                     $num_results_mat = $result_mat->num_rows;
	                 if($num_results_mat!=0)
	                 {
		  
		               for ($mat=0; $mat<$num_results_mat; $mat++)
                        {  
                            $row_mat = mysqli_fetch_assoc($result_mat);
							
					 //подсчитываем оставшееся количество материала по смете для этой работы		

					    if(($row_mat["count_realiz"]!='')and($row_mat["count_realiz"]!=0))
						{
					     $summ=$row_mat["count_realiz"];
					    }
				
					 
					 $ostatok=$row_mat["count_units"]-$summ;
					 if($ostatok<0)
				     {
					     $ostatok=0;
					 }						
							
							
					
							
$my_material=0;		//нашего материала
$my_material1=0;	//давальческого материала

//Определяем сколько материала на пользователе который оформляет наряд
							if($row_mat["id_stock"]!='')
							{
$result_t1_=mysql_time_query($link,'SELECT b.units,(SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE  a.id_kvartal="'.$user_select_kvartal.'" and  a.alien=0 and a.id_stock=b.id and a.id_user="'.$id_user.'") as summ,(SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE  a.id_kvartal="'.$user_select_kvartal.'" and  a.alien=1 and a.id_stock=b.id and a.id_user="'.$id_user.'") as summ1  FROM z_stock as b WHERE b.id="'.htmlspecialchars(trim($row_mat["id_stock"])).'"');
					$z_stock_count_users=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $my_material=$row1ss_["summ"];
					  }

                     if(($row1ss_["summ1"]!='')and($row1ss_["summ1"]!=0))
                     {
                         $my_material1=$row1ss_["summ1"];
                     }

					 $units=$row1ss_["units"];
					
				 }



							
							}

                           $my_material_prior=$my_material;  // по какому количеству материалу будет проверяться хватает ли материала у этого пользователя для оформления наряда
                           if($row_mat["alien"]==1)
                           {
                               $my_material_prior=$my_material1;
                           }
                           $dava='';
                           $class_dava='';
                           if($row_mat["alien"]==1)
                           {
                               $class_dava='dava';

                           }

                           if($row_mat["alien"]==1)
                           {
                               $dava='<div class="chat_kk" data-tooltip="давальческий материал"></div>';
                           }
							
							echo'<tr work="'.$row1ss["id"].'" style="background-color:#f0f4f6;" class="jop1 mat" rel_w="'.$row1ss["id"].'" rel_mat="'.$row_mat["id"].'">
                  <td colspan="1" class="no_padding_left_ pre-wrap one_td"><div class="nm"><span class="s_j '.$class_dava.'">'.$row_mat["material"].'</span>'. $dava.'&nbsp;';
					
							if(($my_material!=0)or($my_material1!=0))
							{
								echo'<span class="my_material" count="'.$my_material_prior.'" id_stock_m="'.htmlspecialchars(trim($row_mat["id_stock"])).'">(<span style="font-style: normal;" data-tooltip="Нашего материала на вас">'.$my_material.'</span> / <span style="font-style: normal; color: #53b374;" data-tooltip="Давальческого материала на вас">'.$my_material1.'</span> '.$units.')</span>';
							} else
							{
								echo'<span class="my_material" count="0" id_stock_m="'.htmlspecialchars(trim($row_mat["id_stock"])).'" data-tooltip="Материала на вас">(нет материала)</span>';
							}
							
							
							echo'</div><input type=hidden value="'.$row_mat["id"].'" name="works['.$i.'][mat]['.$mat.'][id]"><input type=hidden class="hidden_max_count" value="" name="works['.$i.'][mat]['.$mat.'][max_count]"></td>
<td class="pre-wrap center_text_td">'.$row_mat["units"].'';
echo'</td>
<td>';
							
echo'<div class="width-setter"><label></label><input style="margin-top:0px;" ost="'.$ostatok.'" my="'.$my_material_prior.'" all="'.$row_mat["count_units"].'" name="works['.$i.'][mat]['.$mat.'][count]" max="" placeholder="" class="input_f_1 input_100 white_inp label_s count_finery_mater_ '.iclass_($row_mat["id"].'_m_count',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["mat"][$mat]["count"],"").'"></div>';
				 
					 
echo'</td>
<td>';
							/*
if($edit_price==1)
{							
echo'<div class="width-setter"><label>MAX ('.$row_mat["price"].')</label><input style="margin-top:0px;" name="works['.$i.'][mat]['.$mat.'][price]" max="'.$row_mat["price"].'" placeholder="MAX - '.$row_mat["price"].'" class="input_f_1 input_100 white_inp label_s price_finery_mater_ '.iclass_($row_mat["id"].'_m_price',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["mat"][$mat]["price"],"").'"></div>';
} else
{*/
//проставлять макс сумму по себестоимости
//запретить редактировать	
echo'<div class="width-setter"><label>MAX ('.$row_mat["price"].')</label><input readonly="true" style="margin-top:0px;" name="works['.$i.'][mat]['.$mat.'][price]" max="'.$row_mat["price"].'" placeholder="MAX - '.$row_mat["price"].'" class="input_f_1 input_100 white_inp label_s price_finery_mater_ grey_edit '.iclass_($row_mat["id"].'_m_price',$stack_error,"error_formi").'" autocomplete="off" type="text" value=""></div>';	
//}
echo'</td>
<td><span class="s_j summa_finery_mater_"></span></td>

<td></td>
           </tr>';			
							
		//служебная записка по материалу			
	 echo'<tr work="'.$row1ss["id"].'" class="loader_tr" style="height:0px;"><td colspan="6">
	 <div class="messa" id_mes="'.$row1ss["id"].'_'.$row_mat["id"].'">
	 <span class="hs">Оформление служебной записки<div></div></span>';
	 
/*echo'<div class="div_textarea_otziv div_text_glo '.iclass_($row_mat["id"].'_m_text',$stack_error,"error_formi").'" style="margin-top:15px;">
			<div class="otziv_add">
          <textarea placeholder="Напиши руководству причину привышения параметров по этой работе относительно запланированной себестоимости" cols="40" rows="1" id="otziv_area_'.$i.'" name="works['.$i.'][mat]['.$mat.'][text]" class="di text_area_otziv">'.ipost_($_POST['works'][$i]["mat"][$mat]["text"],"").'</textarea>
		  
        </div></div>';
*/
echo'<div class="width-setter mess_slu"><input style="margin-top:0px;" name="works['.$i.'][mat]['.$mat.'][text]"  placeholder="Напиши руководству причину превышения параметров относительно запланированной себестоимости" class="input_f_1 input_100 white_inp label_s text_finery_message_ '.iclass_($row_mat["id"].'_m_text',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["mat"][$mat]["text"],"").'"></div>';								
							
							
	 echo'</div>
	 </td></tr>';
	
//Вывод подсказки что у вас не хватает материала чтобы оформить такое количество в наряде
//служебная записка по материалу			
	 echo'<tr work="'.$row1ss["id"].'" class="loader_tr" style="height:0px;"><td colspan="6">
	 <div class="messa_my" id_mes="'.$row1ss["id"].'_'.$row_mat["id"].'">
	 <span class="hs_my">У вас недостаточно материала, чтобы оформить такое количество в наряде. Закажите необходимый материал.<div></div></span>';
														
	 echo'</div>
	 </td></tr>';							
							
							
						}
					 }

					 
					 
					 
					 
					 echo'<tr work="'.$row1ss["id"].'" class="loader_tr" style="height:20px;"><td colspan="6"><input class="count_workssss" type=hidden value="'.$num_results_mat.'" name="works['.$i.'][count_mat]"></td></tr>';
					 
					 
					 
					 
				 }
		   }
		  
		  //вывод итогов
		   echo'<tr style="" class="jop1 mat itogss">
                  <td class="no_padding_left_ pre-wrap one_td">Итого Работа</td>';
		  
	//<td class="pre-wrap center_text_td"></td>
echo'<td class="pre-wrap center_text_td"></td>
<td style="padding-left:30px;"></td>
<td style="padding-left:20px;"></td><td style="padding-left:10px;"><span class="itogsumwork"></span></td><td></td></tr>'; 

		  		   echo'<tr style="" class="jop1 mat itogss">
                  <td class="no_padding_left_ pre-wrap one_td">Итого Материал</td>';
	//<td class="pre-wrap center_text_td"></td>
echo'<td class="pre-wrap center_text_td"></td>
<td style="padding-left:30px;"></td>
<td style="padding-left:20px;"></td><td style="padding-left:10px;"><span class="itogsummat"></span></td><td></td></tr>'; 

		  		   echo'<tr style="" class="jop1 mat itogss">
                  <td class="no_padding_left_ pre-wrap one_td">Итого всего по наряду</td>';
	//<td class="pre-wrap center_text_td"></td>
echo'<td class="pre-wrap center_text_td"></td>
<td style="padding-left:30px;"></td>
<td style="padding-left:20px;"></td><td style="padding-left:10px;"><span class="itogsumall"></span></td><td></td></tr>'; 		  
		  
		  
		   if($rrtt>0){ echo'</tbody></table>'; echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_0").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>'; }
		 
		  //запускаем загрузку лодеров выполенных работ
		  //делаем пересчет суммы и итоговой
		  //выводим служебные записки где нужно
		  
		  if((isset($_POST['save_naryad']))and($_POST['save_naryad']==1))
          {
	
		     echo'<script>
				  
				  $(function (){  $(\'.count_finery_,.price_finery_,.count_finery_mater_,.price_finery_mater_\').change();  });
				  
				   
				  </script>';
		  
		  }

		  echo'</div>';

	  }
					 
					 /*
					 echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_'.$i.'" class="smeta1"><thead>
		   <tr class="title_smeta"><th class="t_2 no_padding_left_">Наименование работ</th><th class="t_3">статус</th><th class="t_4">ед. изм.</th><th class="t_5">кол-во</th><th class="t_6">стоимость ед. (руб.)</th><th class="t_7">всего (руб.)</th><th class="t_10"></th></tr></thead><tbody>';
					 
				echo'<tr class="loader_tr" style="height:20px;"><td colspan="10"></td></tr>';	 
					 
				echo'<tr class="loader_tr"><td colspan="10"><div class="loaderr"><div class="teps" rel_w="70" style="width:0%"><div class="peg_div"><div><i class="peg"></i></div></div></div></div></td></tr>';
					 

					 echo'<tr style="background-color:#f0f4f6;" class="jop" rel_id="12321">
                  <td class="no_padding_left_ pre-wrap one_td"><span class="s_j">Кирпичная кладка перегородок</span></td>
			<td class="pre-wrap">';
		
	$result_t=mysql_time_query($link,'Select a.id,a.implementer from i_implementer as a order by a.id');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="select_box eddd_box" style="margin-top:0px;"><a class="slct_box" data_src="0" style="margin-bottom: 0px;"><span class="ccol"><100%</span></a><ul class="drop_box">';
		   echo'<li><a href="javascript:void(0);"  rel="0">--</a></li>';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);

				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["implementer"].'</a></li>'; 
			  
			 }
		   echo'</ul><input name="ispol_work" id="status_0" value="0" type="hidden"></div>'; 
	   }
					   
			echo'</td>	  
				  
				  
<td class="pre-wrap center_text_td">Шт.';
	            
				//количество нарядов по данной работе
				
//<div class="musa_plus">3</div>
//echo'<div class="musa_plus mpp">+</div>';
echo'</td>
<td>';

echo'<input style="margin-top:0px;" name="count_work" id="count_work_0" placeholder="MAX - 34" class="input_f_1 input_100 white_inp count_mask" autocomplete="off" type="text">';					 
					 
echo'</td>
<td>';
echo'<input style="margin-top:0px;" name="count_work" id="price_work_0" placeholder="MAX - 2400" class="input_f_1 input_100 white_inp count_mask" autocomplete="off" type="text">';						 
echo'</td>
<td><span class="s_j">'.rtrim(rtrim(number_format(45000, 2, '.', ' '),'0'),'.').'</span></td>

<td><div class="font-rank"><span class="font-rank-inner">x</span></div></td>
           </tr>';
					 


					 echo'<tr style="background-color:#f0f4f6;" class="jop1 mat" rel_id="12321">
                  <td colspan="2" class="no_padding_left_ pre-wrap one_td"><div class="nm"><span class="s_j">Кирпич керамический размером 250х120х88 1,4НФ/100/1,4/50</span></div></td>
<td class="pre-wrap center_text_td">Шт.';
echo'</td>
<td style="padding-left:30px;">12';

				 
					 
echo'</td>
<td style="padding-left:30px;">756';
					 
echo'</td>
<td><span class="s_j">'.rtrim(rtrim(number_format(24531, 2, '.', ' '),'0'),'.').'</span></td>

<td></td>
           </tr>';					 
					

					 echo'<tr style="background-color:#f0f4f6;" class="jop1 mat" rel_id="12321">
                  <td colspan="2" class="no_padding_left_ pre-wrap one_td"><div class="nm"><span class="s_j">Кирпич керамический размером 250х120х88 1,4НФ/100/1,4/50</span></div></td>
<td class="pre-wrap center_text_td">Шт.';
echo'</td>
<td style="padding-left:30px;">12';

				 
					 
echo'</td>
<td style="padding-left:30px;">756';
					 
echo'</td>
<td><span class="s_j">'.rtrim(rtrim(number_format(24531, 2, '.', ' '),'0'),'.').'</span></td>

<td></td>
           </tr>';						 
					 
					 echo'</tbody></table>';
		  */

	  
	  if($rrtt==0)
	  {
		  echo'Выберите сначала нужные работы для оформления наряда';		  
	  }
	  
		   
	//echo'<div class="content_block1">';	
/*
<div class="close_all_r">закрыть все</div>
<div data-tooltip="Удалить всю себестоимость" class="del_seb"></div>
<div data-tooltip="Добавить раздел" class="add_seb"></div>
';
*/
  
	  
	  	//echo'</div>';  
	

	
 

   
	  

	
    ?>

  </div>


</form>
              </div> </div></div></div></div></div>
<?
include_once $url_system.'template/left.php';
?>

</div>
</div><script src="Js/rem.js" type="text/javascript"></script>
<?
echo'<script type="text/javascript">var b_co=\''.$b_co.'\'</script>';
?>
<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
	
</div>

</body></html>
<script type="text/javascript">
    $(function() {
        Zindex();
        AutoResizeT();
    });
</script>