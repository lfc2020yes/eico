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


$role->GetColumns();
$role->GetRows();
$role->GetPermission();
//правам к просмотру к действиям


$active_menu='finery';


//проверим можно редактировать или нет цены в наряде
$edit_price=0;
if ($role->is_column_edit('n_material','price'))
{
	$edit_price=1;
}

$edit_price1=0;
if ($role->is_column_edit('n_work','price'))
{
    $edit_price1=1;
}

$podpis=0;  //по умолчанию нельзя редактировать подписана свыше
if((sign_naryd_level($link,$id_user,$sign_level,$_GET["id"],$sign_admin)))
{
	$podpis=1;
}
	$status_edit='';
	$status_class='';
	if($podpis==0)		
	{	
       $status_edit='readonly';	
	   $status_edit1='disabled';
	   $status_class='grey_edit';		
	}

//обработка формы отправленной по наряду - сохранение
//print_r($_POST['works']);
if((isset($_POST['save_naryad']))and($_POST['save_naryad']==1))
{
	$token=htmlspecialchars($_POST['tk']);
	$id=htmlspecialchars($_GET['id']);
	//проверим токен			
	if(token_access_yes($token,'save_naryd_x',$id,120))
    {
	//есть ли такой наряд в которй хотим сохранить	
    $result_ty=mysql_time_query($link,'Select a.id,a.id_user from n_nariad as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
    $num_results_ty = $result_ty->num_rows;
	if($num_results_ty!=0)
	{
	 $row_ty = mysqli_fetch_assoc($result_ty);
	 //проверяем может ли видеть этот наряд
	 if(array_search($row_ty["id_user"],$hie_user)!==false)
	 {	
	  //не подписан ли он выше кем то
	 if((sign_naryd_level($link,$id_user,$sign_level,$_GET["id"],$sign_admin)))
	 {	
	//возможно проверка что этот пользователь это может делать
	if (($role->permission('Наряды','R'))or($sign_admin==1))
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
		
		     //проверим что количество работ в форме такое же как количество в наряде
		     $result_t22=mysql_time_query($link,'Select count(a.id) as cc from n_work as a where a.id_nariad="'.htmlspecialchars(trim($_GET['id'])).'"');
             $row_t22 = mysqli_fetch_assoc($result_t22); 
		     if($row_t22["cc"]!=count($_POST['works']))
			 {
				 array_push($stack_error,"count_work_not_count_naryad");
			 }
		     $stack_id_work = array();  // массив обработанных работ
		     $stack_id_material = array();  // массив обработанных материалов
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
				
				//проеряем что есть такая работа в данном наряде
				$result_tx=mysql_time_query($link,'Select a.*,b.id as idd from n_work as a,n_nariad as b where a.id_nariad=b.id and a.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такая работа есть
		           $rowxr = mysqli_fetch_assoc($result_tx);
					
				    //проверяем что работа относится к нужному наряду
					if($rowxr["idd"]!=$_GET['id'])
					{
					  array_push($stack_error, $value['id']."work_not_naryad"); 
					}
					
					array_push($stack_id_work,$value['id']);
					
					$id_worksss=$rowxr["id_razdeel2"];
					$result_txg=mysql_time_query($link,'Select a.* from i_razdel2 as a where a.id="'.htmlspecialchars(trim($rowxr["id_razdeel2"])).'"');
                    $num_results_txg = $result_txg->num_rows;
	                if($num_results_txg!=0)
	                {  
		              //такая работа есть
		              $rowx = mysqli_fetch_assoc($result_txg);
					
					
				   //проверяем возможно служебная записка нужна и поля не все заполнены	
				   $count_user=$value['count'];
				   $price_user=$value['price'];
				   
				   //$count_sys=$rowx['count_units'];
				   $count_sys=$rowx['count_units']-$rowx['count_r2_realiz'];
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
				 
					
				//проверяем что количество материалов по этом работе равно количеству в форме материалов по работе
				$result_tc=mysql_time_query($link,'Select count(a.id) as cou from i_material as a where a.id_razdel2="'.htmlspecialchars(trim($rowxr['id_razdeel2'])).'"');
						//echo('Select count(a.id) as cou from i_material as a where a.id_razdel2="'.htmlspecialchars(trim($value['id'])).'"');
                $rowc = mysqli_fetch_assoc($result_tc);		
				//echo($rowc["cou"]);		
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
					//проеряем что есть такая работа в данном наряде
				$result_tx=mysql_time_query($link,'Select a.* from n_material as a where a.id="'.htmlspecialchars(trim($value1['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такая работа есть
		           $rowxr = mysqli_fetch_assoc($result_tx);
					
				    //проверяем что работа относится к нужному наряду
					if($rowxr["id_nwork"]!=$value['id'])
					{
					  array_push($stack_error, $value1['id']."material_not_work"); 
					}  
					  
					  
					$flag_matter=0;
					  
					$result_txx=mysql_time_query($link,'Select a.* from i_material as a where a.id="'.htmlspecialchars(trim($rowxr["id_material"])).'"');
                    $num_results_txx = $result_txx->num_rows;
	                

					
					if($num_results_txx!=0)
	                { 
					   $rowxx = mysqli_fetch_assoc($result_txx);
					   
					   //проверяем что этот материал относится к этой работе
					   if($rowxx["id_razdel2"]!=$id_worksss)
					   {
						   array_push($stack_error, $value1['id']."_material_no_works");
					   }
						
						array_push($stack_id_material,$value1['id']);
						
						$count_user=$value1['count'];
						
				       $price_user=$value1['price'];
						
				       //$count_sys=$rowxx['count_units'];  
					   $count_sys=$rowxx['count_units']-$rowxx['count_realiz']; 
				       $price_sys=$rowxx['price'];
				      
						
				      //больше остаточного количества по материалу
                        /*
				      if($count_sys<$count_user) { $flag_matter++; $flag_message=1; if((!is_numeric($count_user))or($count_user==0)) { array_push($error_work, $value1['id']."_m_count");   }  }
						*/
                        if($count_sys<$count_user) { $flag_matter++; $flag_message=1; if((!is_numeric($count_user))) { array_push($error_work, $value1['id']."_m_count");   }  }

					  //больше предполагаемого количества по материалу	
						$count_end=0; 
						$count_all_matt = $rowxx["count_units"];
		              $count_end = (($count_all_matt*$value['count'])/$rowx['count_units']); 

		              if($count_end>$count_sys)
		              {
		                  $count_est=round($count_sys,3);
						  
		              } else
					  {
						  $count_est=round($count_end,3);
					  }

					  //echo($count_est.'<'.$count_user.' ');	
						
					//  if($count_est!=$count_user) { $flag_matter++;  $flag_message=1; if((!is_numeric($count_user))or($count_user==0)) { array_push($error_work, $value1['id']."_m_count_est");   }  }

                        if($count_est!=$count_user) { $flag_matter++;  $flag_message=1; if((!is_numeric($count_user))) { array_push($error_work, $value1['id']."_m_count_est");   }  }
                        //echo("!");
						
					  //если количество материала у пользователя меньше чем введенное
	$my_material=0;							
//Определяем сколько материала на пользователе который оформляет наряд
							if($rowxx["id_stock"]!='')
							{
if($row_ty["id_user"]==$id_user)	
{								
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_user="'.$id_user.'" and a.id_stock="'.htmlspecialchars(trim($rowxx["id_stock"])).'"');
					$z_stock_count_users=0;	             	 
} else
{
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_user="'.$row_ty["id_user"].'" and a.id_stock="'.htmlspecialchars(trim($rowxx["id_stock"])).'"');	
}
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
							
							}
						
						if($my_material<$count_user) {  $flag_podpis++;  }
						
						
					 // if((!is_numeric($count_user))or($count_user<=0)) {  $flag_podpis++; }
                        if((!is_numeric($count_user))or($count_user<0)) {   $flag_podpis++; }
                        /*
                        if($price_sys<$price_user) {  $flag_matter++;  $flag_message=1; if((!is_numeric($price_user))or($price_user==0)) { array_push($error_work, $value1['id']."_m_price");  }  }
                        */
						
					  //if((!is_numeric($price_user))or($price_user<=0)) { $flag_podpis++; }
					  
					  if((trim($value1['text'])=='')and($flag_matter>0)) {   $flag_podpis++; array_push($error_work, $value1['id']."_m_text"); } 
					  
						
					  if($flag_matter>0) { array_push($stack_memorandum, $value1['id']."_m_flag");  /*где- то в работе есть служебная записка*/	 }
						 
						
				    } 
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
			 }
		     
		     //проверим что в сохран. работах не было одинаковых
		     $stack_id_work_new= array_unique($stack_id_work);
		     if(count($stack_id_work_new)!=count($stack_id_work))
			 {
				array_push($stack_error,"est_work_odinakovie"); 
			 }
		 
		     //проверяем что в сохран. материалах не было одинаковых
		 	 $stack_id_material_new= array_unique($stack_id_material);
		     if(count($stack_id_material_new)!=count($stack_id_material))
			 {
				array_push($stack_error,"est_material_odinakovie"); 
			 }
		  
		     
	    //есть ли ошибки по заполнению
		//print_r($stack_error);
		 //echo($flag_podpis);
		 //echo(count($stack_error));
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
			   //echo("!");	 
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
				$result_tx=mysql_time_query($link,'Select a.*,b.id as idd from n_work as a,n_nariad as b where a.id_nariad=b.id and a.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такая работа есть
		           $rowxr = mysqli_fetch_assoc($result_tx);   
				   
				   
				$result_tx=mysql_time_query($link,'Select a.* from i_razdel2 as a where a.id="'.htmlspecialchars(trim($rowxr['id_razdeel2'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такая работа есть
		           $rowx = mysqli_fetch_assoc($result_tx);
				   
				   if($count_work==0)	
				   {		
                     //$id_user=id_key_crypt_encrypt(htmlspecialchars(trim($_SESSION['user_id'])));
					 
					 //include_once $url_system.'ilib/lib_interstroi.php'; 
					 $numer=get_numer_doc(&$link,htmlspecialchars(trim($_POST["date_naryad"])),1);
					   					   
					 //изменяем неподписанный наряд  
				     mysql_time_query($link,'update n_nariad set 				 
					 numer_doc="'.$numer.'",					 
					 id_implementer="'.htmlspecialchars(trim($_POST['ispol_work'])).'",
					 date_doc="'.htmlspecialchars(trim($_POST["date_naryad"])).'",
					 date_begin="'.htmlspecialchars($_POST['date_start']).'", 
					 date_end="'.htmlspecialchars($_POST['date_end']).'", 
					 ready="0"
					 
					 where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
	   
					   
					 $ID_N=htmlspecialchars(trim($_GET['id']));  
				   }	
				 
				  $count_work++;	 
				
				  if(($sign_level!=3)and($sign_admin!=1))
				  {	
				  $count_memo=0;	
				  $status_memo=0;
				  	
				  $memo='';	
					
				  $found1 = array_search($value['id']."_w_flag",$stack_memorandum);   
	              if($found1 !== false) 
	              {
					  
				    $memo=htmlspecialchars(trim($value['text'])); 
					$count_memo++;
					  
				  } else { $status_memo=1; }
				
				
				  //проверить были ли изменения в работе количество-стоимость-меморандум
				  //если да то обнуляем инфу о проверке меморандума
				  $count_redac=0;
				  $izm_rab=0;	
				  $result_tyd=mysql_time_query($link,'Select a.memorandum,a.count_units,a.price,a.id_sign_mem from n_work as a where a.id="'.htmlspecialchars(trim($value['id'])).'"');
                  $num_results_tyd = $result_tyd->num_rows;
	              if($num_results_tyd!=0)
	              {
	                 $row_tyd = mysqli_fetch_assoc($result_tyd);
					 $id_sign_mem= $row_tyd['id_sign_mem'];
					 if($row_tyd["count_units"]!=$value['count']) { $count_redac++; }
					 if($row_tyd["memorandum"]!=$value['text']) { $count_redac++; }
					 if($edit_price1==1) { if($row_tyd["price"]!=$value['price']) { $count_redac++; } }
				  }
				  if($count_redac!=0)
				  {
				    $id_sign_mem=0;
					  $izm_rab=1;
					//if($status_memo)
				  }
				  } else
				  {
				     //для админов и главного инженера
				     $count_memo=0;	
				     $status_memo=0;
				  	 $user_dec_memo=0;
				     $memo='';	
					
				     $found1 = array_search($value['id']."_w_flag",$stack_memorandum);   
	                 if($found1 !== false) 
	                 {
					  
				       $memo=htmlspecialchars(trim($value['text'])); 
					   $count_memo++;
						
					   //есть меморандум смотрим есть ли по нему решение
					   if($value['decision']==0) { $user_dec_memo=$id_user; }
					   if($value['decision']==1) { $status_memo=1;  $user_dec_memo=$id_user; }	   
						 
					  
				     } else { $status_memo=1; }
				  
				  //проверить были ли изменения в работе количество-стоимость-меморандум
				  //если да то обнуляем инфу о проверке меморандума
				  $count_redac=0;
				  $izm_rab=0;	
				  $result_tyd=mysql_time_query($link,'Select a.memorandum,a.count_units,a.price,a.id_sign_mem,a.signedd_mem from n_work as a where a.id="'.htmlspecialchars(trim($value['id'])).'"');
                  $num_results_tyd = $result_tyd->num_rows;
	              if($num_results_tyd!=0)
	              {
	                 $row_tyd = mysqli_fetch_assoc($result_tyd);
					 $id_sign_mem= $row_tyd['id_sign_mem'];
					  
					 if($row_tyd["count_units"]!=$value['count']) { $count_redac++; }
					 if($row_tyd["memorandum"]!=$value['text']) { $count_redac++; }
					 if($edit_price1==1) { if($row_tyd["price"]!=$value['price']) { $count_redac++; } }
					 if($row_tyd['id_sign_mem']!=$user_dec_memo) { $count_redac++; }
                     if($row_tyd['signedd_mem']!=$status_memo) { $count_redac++; }
					  
				  }
				  if($count_redac!=0)
				  {
				    $id_sign_mem=0;
					  $izm_rab=1;
					//if($status_memo)
				  }
					  
					  
					  
				  }
					
				  //изменяет если только есть изменения	
				  if($count_redac!=0)
				  {
				  if($edit_price1==1)
                  {				
				  //изменение работу к наряду	
					  /*
				  mysql_time_query($link,'INSERT INTO n_work (id,id_nariad,id_razdeel2,name_work,procent,units,count_units,count_units_razdel2,price,price_razdel2,memorandum,id_sign_mem,signedd_mem) VALUES ("","'.$ID_N.'","'.htmlspecialchars(trim($value['id'])).'","'.htmlspecialchars(trim($rowx['name_working'])).'","","'.htmlspecialchars(trim($rowx['units'])).'","'.htmlspecialchars(trim($value['count'])).'","'.htmlspecialchars(trim($rowx['count_units'])).'","'.htmlspecialchars(trim($value['price'])).'","'.htmlspecialchars(trim($rowx['price'])).'","'.$memo.'","","'.$status_memo.'")');	
				  */
					 if(($sign_level!=3)and($sign_admin!=1))
				     {	
	  
					  
				  mysql_time_query($link,'update n_work set 				 
					 count_units="'.htmlspecialchars(trim($value['count'])).'",					 
					 price="'.htmlspecialchars(trim($value['price'])).'",
					 memorandum="'.$memo.'",
					 id_sign_mem="0", 
					 signedd_mem="'.$status_memo.'" 
					 
					 where id = "'.htmlspecialchars(trim($value['id'])).'" and id_nariad="'.$ID_N.'"');  
					 } else
					 {
				  mysql_time_query($link,'update n_work set 				 
					 count_units="'.htmlspecialchars(trim($value['count'])).'",					 
					 price="'.htmlspecialchars(trim($value['price'])).'",
					 memorandum="'.$memo.'",
					 id_sign_mem="'.$user_dec_memo.'", 
					 signedd_mem="'.$status_memo.'" 
					 
					 where id = "'.htmlspecialchars(trim($value['id'])).'" and id_nariad="'.$ID_N.'"');					 
					 }
					  
				  } else
				  {
				  //если он не может редактировать цены заносим максимальные цены из себестоимости	  
				  mysql_time_query($link,'update n_work set 				 
					 count_units="'.htmlspecialchars(trim($value['count'])).'",					 
					 memorandum="'.$memo.'",
					 id_sign_mem="0", 
					 signedd_mem="'.$status_memo.'" 
					 
					 where id = "'.htmlspecialchars(trim($value['id'])).'" and id_nariad="'.$ID_N.'"'); 					  
				  }
				  }
				  $ID_W=$value['id']; 
					
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
				$result_tx=mysql_time_query($link,'Select a.* from n_material as a where a.id="'.htmlspecialchars(trim($value1['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такая работа есть
		           $rowxr = mysqli_fetch_assoc($result_tx);  
					  
					  
					$result_txx=mysql_time_query($link,'Select a.* from i_material as a where a.id="'.htmlspecialchars(trim($rowxr['id_material'])).'"');
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
				  if(($sign_level!=3)and($sign_admin!=1))
				  {		
						
					   
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
						
				  //проверить были ли изменения в материале количество-стоимость-меморандум
				  //если да то обнуляем инфу о проверке меморандума
				  $count_redac=0;
				  $result_tyd=mysql_time_query($link,'Select a.memorandum,a.count_units,a.price,a.id_sign_mem from n_material as a where a.id="'.htmlspecialchars(trim($value1['id'])).'"');
                  $num_results_tyd = $result_tyd->num_rows;
	              if($num_results_tyd!=0)
	              {
	                 $row_tyd = mysqli_fetch_assoc($result_tyd);
					 $id_sign_mem= $row_tyd['id_sign_mem'];
					 if($row_tyd["count_units"]!=$value1['count']) { $count_redac++; }
					 if($row_tyd["memorandum"]!=$value1['text']) { $count_redac++; }
					 if($edit_price==1) { if($row_tyd["price"]!=$value1['price']) { $count_redac++; } }
				  }
				  if($count_redac!=0)
				  {
				    $id_sign_mem=0;
					//if($status_memo)
				  }		
					} else
					{
					   //для главных инженеров и директоров
					 $status_memo=0;
				   $memo='';
					$user_dec_memo=0;	
					//print_r($stack_memorandum);
						//echo($value1['id']);
				   $found1 = array_search($value1['id']."_m_flag",$stack_memorandum);   
	               if($found1 !== false) 
	               {
					  $count_memo++;
				    $memo=htmlspecialchars(trim($value1['text'])); 
					//есть меморандум смотрим есть ли по нему решение
					   if($value1['decision']==0) { $user_dec_memo=$id_user; }
					   if($value1['decision']==1) { $status_memo=1;  $user_dec_memo=$id_user; }	   
					  
				   } else { $status_memo=1; }
						
						//$value1['max_count']
						
					//echo('.'.$status_memo.'-')	;
						
				  //проверить были ли изменения в материале количество-стоимость-меморандум
				  //если да то обнуляем инфу о проверке меморандума
				  $count_redac=0;
				  $result_tyd=mysql_time_query($link,'Select a.memorandum,a.count_units,a.price,a.id_sign_mem,a.signedd_mem from n_material as a where a.id="'.htmlspecialchars(trim($value1['id'])).'"');
                  $num_results_tyd = $result_tyd->num_rows;
	              if($num_results_tyd!=0)
	              {
	                 $row_tyd = mysqli_fetch_assoc($result_tyd);
					 $id_sign_mem= $row_tyd['id_sign_mem'];
					 if($row_tyd["count_units"]!=$value1['count']) { $count_redac++; }
					 if($row_tyd["memorandum"]!=$value1['text']) { $count_redac++; }
					 if($edit_price==1) { if($row_tyd["price"]!=$value1['price']) { $count_redac++; } }
					 if($row_tyd['id_sign_mem']!=$user_dec_memo) { $count_redac++; }
                     if($row_tyd['signedd_mem']!=$status_memo) { $count_redac++; } 
				  }
				  if($count_redac!=0)
				  {
				    $id_sign_mem=0;
					//if($status_memo)
				  }	
						
					}
				//если работа изменилась а материал нет все равно изменяем решение по меморандуму на нерешенное		
				  if(($count_redac!=0)or($izm_rab!=0))
				  {
						if($edit_price==1)
                       {	
					   //изменяем материал к работе
						   
					 if(($sign_level!=3)and($sign_admin!=1))
				     {

					   mysql_time_query($link,'update n_material set 				 
					 count_units="'.htmlspecialchars(trim($value1['count'])).'",
					 count_units_material="'.$count_end.'",					 
					 price="'.htmlspecialchars(trim($value1['price'])).'",
					 memorandum="'.$memo.'",
					 id_sign_mem="0", 
					 signedd_mem="'.$status_memo.'" 
					 
					 where id = "'.htmlspecialchars(trim($value1['id'])).'" and id_nwork="'.$ID_W.'"');
					 } else
					 {

					   mysql_time_query($link,'update n_material set 				 
					 count_units="'.htmlspecialchars(trim($value1['count'])).'",
					 count_units_material="'.$count_end.'",					 
					 price="'.htmlspecialchars(trim($value1['price'])).'",
					 memorandum="'.$memo.'",
					 id_sign_mem="'.$user_dec_memo.'", 
					 signedd_mem="'.$status_memo.'" 
					 
					 where id = "'.htmlspecialchars(trim($value1['id'])).'" and id_nwork="'.$ID_W.'"');					 
					 }
						   
						   
					   } else
					   {
                           if(($sign_level!=3)and($sign_admin!=1))
                           {
					   mysql_time_query($link,'update n_material set 				 
					 count_units="'.htmlspecialchars(trim($value1['count'])).'",		
					 count_units_material="'.$count_end.'",			 
					 memorandum="'.$memo.'",
					 id_sign_mem="0", 
					 signedd_mem="'.$status_memo.'" 
					 
					 where id = "'.htmlspecialchars(trim($value1['id'])).'" and id_nwork="'.$ID_W.'"'); 							   } else
                           {
                               mysql_time_query($link,'update n_material set 				 
					 count_units="'.htmlspecialchars(trim($value1['count'])).'",		
					 count_units_material="'.$count_end.'",			 
					 memorandum="'.$memo.'",
					 id_sign_mem="'.$user_dec_memo.'", 
					 signedd_mem="'.$status_memo.'" 
					 
					 where id = "'.htmlspecialchars(trim($value1['id'])).'" and id_nwork="'.$ID_W.'"');
                           }
					   }
				  }
						
						
					}
				  }
				  }
				}

	
				}
			   }
			 }
			 }		   
			
			 //изменяем статус наряда в зависимости от заполнения
					
			 $status_nariad=0;
			 if($flag_podpis==0){ $status_nariad=1; }
			 //if($count_memo!=0){ $status_nariad=-1; }
			 mysql_time_query($link,'update n_nariad set ready="'.$status_nariad.'" where id = "'.htmlspecialchars(trim($_GET["id"])).'"');
			
			
			 header("Location:".$base_usr."/finery/".$_GET["id"].'/');	
			 die();	
		}
	
				/* if((isset($value['count']))and(is_numeric($value['count']))and(isset($value['price']))and(is_numeric($value['price']))and(isset($value['ed']))and(trim($value["ed"])!='')and(isset($value['name']))and(trim($value["name"])!='')) 
		         {
*/
}
    }
	}
	}
}
	
	
}


//формирование нового секретного ключа
$secret=rand_string_string(4);
$_SESSION['s_t'] = $secret;	





//проверить и перейти к последней себестоимости в которой был пользователь



//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /finery/add/28/
//     0   1     2  3

$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);


if (( count($_GET) == 1 )or( count($_GET) == 2)) //--Если были приняты данные из HTML-формы
{

  if($D_404[4]=='')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
		
        
		$result_url=mysql_time_query($link,'select A.* from n_nariad as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0)
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} else
		{
			$row_list = mysqli_fetch_assoc($result_url);
			//проверим может пользователь вообще не может работать с себестоимостью
			if (($role->permission('Себестоимость','R'))or($sign_admin==1))
	        {
				//имеет ли он доступ в этот наряд
				
				if(($sign_admin!=1)and(array_search($row_list["id_object"],$hie_object)===false))
			    {
			      header("HTTP/1.1 404 Not Found");
	              header("Status: 404 Not Found");
	              $error_header=404;
			    } else
				{
					//создатель наряда не входит в подчинения пользователя который просматривает
					//echo("!");
					//echo($row_list["id_user"]);
					if((array_search($row_list["id_user"],$hie_user)===false)and($sign_admin!=1))
					{
						header("HTTP/1.1 404 Not Found");
	                    header("Status: 404 Not Found");
	                    $error_header=404;	
					}
					
				}
				
			} else
			{
			  header("HTTP/1.1 404 Not Found");
	          header("Status: 404 Not Found");
	          $error_header=404;				
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

if($error_header!=404){ SEO('finery','','','',$link); } else { SEO('0','','','',$link); }

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
	
        $result_town=mysql_time_query($link,'select C.object_name,B.town,A.kvartal from i_kvartal as A,i_town as B,i_object as C where C.id_kvartal=A.id and A.id_town=B.id and C.id="'.$row_list["id_object"].'"');
        
		$num_results_custom_town = $result_town->num_rows;
        
		if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);
			//echo($row_town["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')');
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

	  include_once $url_system.'template/top_prime_finery_view.php';
	            ?>
      <div id="fullpage" class="margin_60  input-block-2020 ">
          <div class="section" id="section0">
              <div class="height_100vh">
                  <div class="oka_block_2019">

                      <?
                      echo'<div class="line_mobile_blue">Наряд №'.$row_list["id"];
                      /*
                       $D = explode('.', $_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);

                       if(count($D)>0)
                       {
                           echo'<span all="8" class="menu-mobile-count">'.count($D).'</span>';
                       }
     */
                      echo'</div>';

                      ?>
      <div class="div_ook" style="border-bottom: 1px solid rgba(0,0,0,0.05);">


<?
          //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
          //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
          //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо

if(($row_list["id_user"]==$id_user)and($podpis==1)) {
          $query_string .= '<div class="info-suit"><div class="input-block-2020">';


                  $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="13" and A.visible=1 and A.id_object="' . ht($row_list["id"]) . '"');

                  $num_results_uu = $result_6->num_rows;

                  $class_aa = '';
                  $style_aa = '';
                  if ($num_results_uu != 0) {
                  $class_aa = 'eshe-load-file';
                  $style_aa = 'style="display: block;"';
                  }


                  $query_string .= '<div class=""><div class="img_invoice_div js-image-gl"><div class="list-image" ' . $style_aa . '>';

                          if ($num_results_uu != 0) {
                          $i = 1;
                          while ($row_6 = mysqli_fetch_assoc($result_6)) {
                          $query_string .= '	<div number_li="' . $i . '" class="li-image yes-load"><span class="name-img"><a href="/upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '">' . $row_6["name_user"] . '</a></span><span class="del-img js-dell-image" id="' . $row_6["name"] . '"></span><div class="progress-img"><div class="p-img" style="width: 0px; display: none;"></div></div></div>';
                          $i++;
                          }
                          }


                          $query_string .= '</div><input type="hidden" name="files_9" value=""><div type_load="13" id_object="' . ht($row_list["id"]) . '" class="invoice_upload js-upload-file js-helps ' . $class_aa . '"><span>прикрепите <strong>скан с подписью технадзора</strong>, для этого выберите или перетащите файлы сюда </span><i>чтобы прикрепить ещё <strong>необходимые документы</strong>, выберите или перетащите их сюда</i><div class="help-icon-x" data-tooltip="Принимаем только в форматах .pdf, .jpg, .jpeg, .png, .doc , .docx , .zip" >u</div></div></div></div>';

          $query_string .= '</div></div>';


                  echo $query_string;
                  } else
{


//если заявка уже отправлена на согласования файлы просто выводятся списком. никто их исправлять не может
        $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="13" and A.visible=1 and A.id_object="' . ht($row_list["id"]) . '"');

        $num_results_uu = $result_6->num_rows;

        if ($num_results_uu != 0) {
            $task_cloud_block22='<div class="info-suit"><div class="input-block-2020"><div class="strong_wh_2020">↓ Сканы с подписью технадзора</div>';


            while ($row_6 = mysqli_fetch_assoc($result_6)) {

                $task_cloud_block22 .= '<div class="li-image download-file"><span class="name-img"><a class="bold_file" target="_blank" href="/upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '">' . $row_6["name_user"] . '</a></span><span class="size-img">' . $row_6["type"] . ', ' . get_filesize($url_system.'upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '') . '</span></div>';

            }

            $task_cloud_block22 .='</div></div>';
        }


echo $task_cloud_block22;

}
                  //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                  //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                  //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                  //конец
?>



                  <div class="info-suit">
	  <?

	if($row_list["signedd_nariad"]==1)
	{
	   //утвержден проведен
	   echo' <input name="status_naryad" value="too" type="hidden">';	
	}
  
	  
?>
<form id="lalala_add_form" class="my_n" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
 <input name="save_naryad" value="1" type="hidden">
  <?
	/*
	if($row_list["status"]==1)
	{	
		echo'<input id="save" name="save" save="0" value="" type="hidden">';
	}
	*/
    echo'<div class="content_block1" style="padding-top:20px;"  iu="'.$id_user.'"  id_content="'.$id_user.'">';

//print_r($stack_error);
	/*echo '<pre>';
print_r($_POST["works"]);	
	echo '</pre>';
	*/
//echo'<h3 style=" margin-bottom:0px;">Добавление наряда<div></div></h3>';
echo'<div class="comme" >'.$row_town["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</div>';	  
	
	  
	  
	  $rrtt=0;
	  
	       					
	echo'<div style="height:70px;"><div class="_50_na_50_1" style="width:50%; float:left;"><div class="_50_x">';
		   echo'<div class="input-width m10_right">';
		
		
	$result_t=mysql_time_query($link,'Select a.id,a.implementer from i_implementer as a order by a.id');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="select_box eddd_box"><a class="slct_box '.iclass_('ispol_work',$stack_error,"error_formi").' '.$status_class.'" data_src="0"><span class="ccol">'.ipost_x($_POST['ispol_work'],$row_list["id_implementer"],"Исполнитель","i_implementer","implementer",$link).'</span></a><ul class="drop_box">';
		  // echo'<li><a href="javascript:void(0);"  rel="0">--</a></li>';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);

				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["implementer"].'</a></li>'; 
			  
			 }
		   echo'</ul><input defaultv="'.ipost_x($_POST['ispol_work'],$row_list["id_implementer"],"0").'" '.$status_edit.' name="ispol_work" id="ispol" value="'.ipost_x($_POST['ispol_work'],$row_list["id_implementer"],"0").'" type="hidden"></div>'; 
	   }
		
		
		
		
		echo'</div>';
		echo'</div>';
		
		echo'<div class="_50_x">';
		   echo'<div class="input-width m10_right" style="position:relative; margin-right: 0px;">';
		    
		    echo'<input id="date_hidden_table" name="date_naryad" value="'.ipost_($_POST['date_naryad'],$row_list["date_doc"]).'" type="hidden">';
			
			echo'<input '.$status_edit1.' defaultv="'.ipost_($_POST['datess'],date_fik($row_list["date_doc"])).'" readonly="true" name="datess" defuat="" value="'.ipost_($_POST['datess'],date_fik($row_list["date_doc"])).'" id="date_table" class="input_f_1 input_100 calendar_t white_inp '.$status_class.' '.iclass_("date_naryad",$stack_error,"error_formi").'" placeholder="Дата документа"  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div></div>';
		
		echo'<div class="pad10" style="padding: 0;"><span class="bookingBox"></span></div>';
		
		echo'</div>';
	  
		  
		  
		  
			echo'<div class="_50_na_50_1" style="width:50%; float:left;"><div class="_50_x" style="width:100%; padding-left:10px;">';
		   echo'<div class=" input-width m10_right" style="position:relative; margin-right: 0px;">';
		    
		    echo'<input id="date_hidden_start" name="date_start" value="'.ipost_($_POST['date_start'],$row_list["date_begin"]).'" type="hidden">';
			echo'<input id="date_hidden_end" name="date_end" value="'.ipost_($_POST['date_end'],$row_list["date_end"]).'" type="hidden">';
		  
			echo'<label>Период работ</label><input defaultv="'.ipost_($_POST['datess1'],date_fik($row_list["date_begin"],$row_list["date_end"])).'" '.$status_edit1.' readonly="true" name="datess1" value="'.ipost_($_POST['datess1'],date_fik($row_list["date_begin"],$row_list["date_end"])).'" id="date_table1" class="input_f_1 input_100 calendar_t white_inp label_s '.iclass_("date_period",$stack_error,"error_formi").' '.$status_class.'" placeholder="Период работ"  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div></div>';
		
		
		
		echo'</div>';  
	 echo'<div class="pad10" style="padding: 0; width:100%;"><span class="bookingBox1"></span></div>';
	  echo'</div>';
	  
	?>  
	<script type="text/javascript" src="Js/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="Js/jquery.datepicker.extension.range.min.js"></script>
<script type="text/javascript">var disabledDays = [];
 $(document).ready(function(){           
            $("#date_table").datepicker({ 
altField:'#date_hidden_table',
onClose : function(dateText, inst){
        //alert(dateText); // Âûáðàííàÿ äàòà 
		
    },
onSelect: function(dateText, inst) {				
	savedefault($("#date_table"));			
},
altFormat:'yy-mm-dd',
defaultDate:null,
beforeShowDay: disableAllTheseDays,
dateFormat: "d MM yy"+' г.', 
firstDay: 1,
minDate: "-60D", maxDate: "+60D",
beforeShow:function(textbox, instance){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 65,
                left: 0
            });
        }, 10);
	
    $('.bookingBox').append($('#ui-datepicker-div'));
    $('#ui-datepicker-div').hide();
} });
	 
	 
	 
$("#date_table1").datepicker({ 
range: 'period', // режим - выбор периода
numberOfMonths: 2,	
//altField:'#date_hidden_period',
/*
	onClose : function(dateText, inst){
        //alert(dateText); // Âûáðàííàÿ äàòà 
		
    },
altFormat:'yy-mm-dd',
defaultDate:null,
*/
onSelect: function(dateText, inst, extensionRange) {
    	// extensionRange - объект расширения
	resizeDatepicker();
	$('#date_table1').val(jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.startDate) + ' - ' + jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.endDate));
	  

	$('#date_hidden_start').val(jQuery.datepicker.formatDate('yy-mm-dd',extensionRange.startDate));
	$('#date_hidden_end').val(jQuery.datepicker.formatDate('yy-mm-dd',extensionRange.endDate));
	
	$('#date_table1').prev('label').show();
	
	savedefault($("#date_table1"));
	
    },	
	
//beforeShowDay: disableAllTheseDays,
//dateFormat: "d MM yy"+' г.', 
//firstDay: 1,
//minDate: "-60D", maxDate: "+60D",
onChangeMonthYear: resizeDatepicker,	
beforeShow:function(textbox, instance, extensionRange){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 65,
                left: 0,
				width:'100%'
            });
        }, 10);
	
    $('.bookingBox1').append($('#ui-datepicker-div'));
    $('#ui-datepicker-div').hide();
} 

});	
function resizeDatepicker() {
    setTimeout(function() { $('.bookingBox1 > .ui-datepicker').width('100%'); }, 10);
}	 
<?
if(($_POST['datess1']!='')or($row_list["date_begin"]!=''))
{
echo'var st=\''.ipost_($_POST['date_start'],$row_list["date_begin"]).'\';
var st1=\''.ipost_($_POST['date_end'],$row_list["date_end"]).'\';
var st2=\''.ipost_($_POST['datess1'],date_fik($row_list["date_begin"],$row_list["date_end"])).'\';';
echo'jopacalendar(st,st1,st2);';		  
}
?>				 
	 
 });
	
	
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
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  echo'</div><div class="content_block block_primes1">';			
					
	  
					 
	//echo($_COOKIE["basket_".htmlspecialchars(trim($_GET['id']))]);				 
	 /*
	if (( isset($_COOKIE["basket_".htmlspecialchars(trim($_GET['id']))]))and($_COOKIE["basket_".htmlspecialchars(trim($_GET['id']))]!=''))
	  {
	  */
	
		$result_work=mysql_time_query($link,'Select a.* from n_work as a where a.id_nariad="'.$row_list["id"].'" order by a.id');
        $num_results_work = $result_work->num_rows;
	    if($num_results_work!=0)
	    {
		  

		   for ($i=0; $i<$num_results_work; $i++)
		   {
			   $row_work = mysqli_fetch_assoc($result_work);

					$rrtt++;
					if($rrtt==1)
					{

		$token=token_access_compile($_GET['id'],'save_naryd_x',$secret);					
						
						
						echo'<input type="hidden" value="'.$token.'" name="tk">'; 
						echo'<input type="hidden" value="'.$_GET['id'].'" name="id_naa">'; 
						
						//заголовок таблицы
						
						 echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_0" class="smeta1"><thead>
		   <tr class="title_smeta"><th class="t_2 no_padding_left_ jk4">Наименование работ</th><th class="t_4 jk44">ед. изм.</th><th class="t_5">кол-во</th><th class="t_6">стоимость ед. (руб.)</th><th class="t_7 jk5">всего (руб.)</th><th class="t_10 jk6"></th></tr></thead><tbody>';
						 echo'<tr class="loader_tr" style="height:20px;"><td colspan="7"></td></tr>';
					}
					 
				 $summ=0;
                 $ostatok=0;
                 $proc_view=0;	
				 $flag_history=0;
					 
			     $result_t1_=mysql_time_query($link,'Select c.count_r2_realiz,c.count_units as count_all,a.count_units from n_work as a, i_razdel2 as c where c.id=a.id_razdeel2 and a.id_razdeel2="'.$row_work["id_razdeel2"].'"');
					 
                 //echo('Select sum(a.count_units) as summ from n_work as a where a.id_razdeel2="'.$row1ss["id"].'" and a.status="1"');
			   
			     //если наряд проведен то выводим информацию какая была на момент проводки а не та которая сейчас по этому наряду в зависимости от себестоимости
			     if($row_list["signedd_nariad"]==1)
				 {
					$result_t1_=mysql_time_query($link,'Select a.count_units_razdel2_realiz as count_r2_realiz,a.count_units_razdel2 as count_all,a.count_units from n_work as a where a.id_razdeel2="'.$row_work["id_razdeel2"].'" and a.id_nariad="'.$row_list["id"].'"');		
				 } else
				 {
					$result_t1_=mysql_time_query($link,'Select c.count_r2_realiz,c.count_units as count_all,a.count_units from n_work as a, i_razdel2 as c where c.id=a.id_razdeel2 and a.id_razdeel2="'.$row_work["id_razdeel2"].'" and a.id_nariad="'.$row_list["id"].'"');
				 }
			   
			   
			   
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["count_r2_realiz"]!='')and($row1ss_["count_r2_realiz"]!=0))
					 {
					  $summ=$row1ss_["count_r2_realiz"];
						 $flag_history=1;
					 }
				 }
	             //сколько всего осталось сделать работ на момент утверждения

					 $ostatok=$row1ss_["count_all"]-$summ;
			   //echo($ostatok);
					 if($ostatok<0)
				     {
					     $ostatok=0;
					 }
			        //echo($ostatok);
			   if($row1ss_["count_all"]!=0)
			   {
					 $proc_view=round((($row1ss_["count_all"]-$ostatok)*100)/$row1ss_["count_all"]); 
			   } else
			   {
				 $proc_view=0;  
			   }
					 //линия выполеннных работ
					echo'<tr work="'.$row_work["id"].'" class="loader_tr"><td colspan="6"><div class="loaderr"><div id_loader="'.$row_work["id"].'" class="teps" rel_w="'.$proc_view.'" style="width:0%"><div class="peg_div"><div><i class="peg"></i></div></div></div></div></td></tr>';
					 
					 //история нарядов по этой работе
if(($flag_history==1)or($row_list["signedd_nariad"]==1))
				
{	
		 echo'<tr work="'.$row_work["id"].'" class="loader_tr loader_history" fo="'.$row_work["id_razdeel2"].'" style="height:0px;"><td colspan="6"><div class="loader_inter"><div></div><div></div><div></div><div></div></div></td></tr>';
}
					 
                     //работа сама
					 echo'<tr work="'.$row_work["id"].'" style="background-color:#f0f4f6;" class="jop work__s workx" id_trr="'.$i.'" rel_id="'.$row_work["id"].'">
                  <td class="no_padding_left_ pre-wrap one_td"><span class="s_j">'.$row_work["name_work"].'</span><input type=hidden value="'.$row_work["id"].'" name="works['.$i.'][id]">';
					 if(($flag_history==1)or($row_list["signedd_nariad"]==1))
					 {
					   echo'<span class="edit_panel11"><span data-tooltip="история нарядов" for="'.$row_work["id_razdeel2"].'" class="history_icon">M</span></span>';
					 }
						 
						 echo'</td>';
			   /*
			<td class="pre-wrap">';

		   echo'<div class="select_box eddd_box" style="margin-top:0px;"><a class="slct_box" data_src="0" style="margin-bottom: 0px;"><span class="ccol"></span></a><ul class="drop_box">';



				  echo'<li><a href="javascript:void(0);"  rel="1"><100%</a></li>'; 
			  echo'<li><a href="javascript:void(0);"  rel="2">Сделано</a></li>'; 
			
		   echo'</ul><input defaultv="" '.$status_edit.' name="works['.$i.'][status]" id="status_'.$i.'" value="" type="hidden"></div>'; 
	   
					   
			echo'</td>	  
				*/ 
				  
echo'<td class="pre-wrap center_text_td">'.$row_work["units"].'';
	            
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
echo'<div class="width-setter"><label>MAX('.$ostatok.')</label><input defaultv="'.ipost_($_POST['works'][$i]["count"],$row_work["count_units"]).'" '.$status_edit.' style="margin-top:0px;" name="works['.$i.'][count]" all="'.$row1ss_["count_all"].'" max="'.$ostatok.'" id="count_work_'.$i.'" placeholder="MAX - '.$ostatok.'" class="input_f_1 input_100 white_inp label_s '.$class_c.' count_finery_ '.iclass_($row1ss["id"].'_w_count',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["count"],$row_work["count_units"]).'"></div>';					 
					 
echo'</td>
<td>';
if($edit_price1==1)
{			   
echo'<div class="width-setter"><label>MAX('.$row_work["price_razdel2"].')</label><input defaultv="'.ipost_($_POST['works'][$i]["price"],$row_work["price"]).'" '.$status_edit.' style="margin-top:0px;" name="works['.$i.'][price]" max="'.$row_work["price_razdel2"].'" id="price_work_'.$i.'" placeholder="MAX - '.$row_work["price_razdel2"].'" class="input_f_1 input_100 white_inp label_s price_finery_ '.iclass_($row_work["id"].'_w_price',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["price"],$row_work["price"]).'"></div>';
} else
{
echo'<div class="width-setter"><label>MAX('.$row_work["price_razdel2"].')</label><input readonly="true" defaultv="'.ipost_($_POST['works'][$i]["price"],$row_work["price"]).'" '.$status_edit.' style="margin-top:0px;" name="works['.$i.'][price]" max="'.$row_work["price_razdel2"].'" id="price_work_'.$i.'" placeholder="MAX - '.$row_work["price_razdel2"].'" class="input_f_1 input_100 white_inp label_s price_finery_ grey_edit '.iclass_($row_work["id"].'_w_price',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["price"],$row_work["price"]).'"></div>';	
}
echo'</td>
<td><span class="summ_price s_j " id="summa_finery_'.$i.'" ></span>';
if($edit_price1==1)
{	
echo'<div class="exceed"></div>';
}
echo'</td>

<td>';
			   
	if($podpis==1)
	{			
        echo'<div class="font-rank del_naryd_work1" naryd="'.$_GET['id'].'" id_rel="'.$row_work["id"].'"><span class="font-rank-inner">x</span></div>';		
	}
			   
echo'</td>
           </tr>';
					 
				 
	//служебная записка по работе			
	 echo'<tr work="'.$row_work["id"].'" class="loader_tr workx" style="height:0px;"><td colspan="6">
	 <div class="messa" id_mes="'.$row_work["id"].'">
	 <span class="hs">';
	if(($sign_level==3)or($sign_admin==1))
	{
	   echo'Cлужебная записка'; 
	} else
	{
	   echo'Оформление служебной записки';
	}
	
	if(($sign_level!=3)and($sign_admin!=1))
	{

	  //для прорабов и начальникам участка выводим просто статус служебных записок	
	  if(($row_work["signedd_mem"]==1)and($row_work["id_sign_mem"]!=0)and($row_work["id_sign_mem"]!=''))
	  {		
		echo'<span style="visibility:visible" class="edit_12"><i data-tooltip="Подписана руководством">S</i></span>';
		
	  }
	  if(($row_work["signedd_mem"]==0)and($row_work["id_sign_mem"]!=0)and($row_work["id_sign_mem"]!=''))
	  {		
		echo'<span style="visibility:visible" class="edit_12"><i style="color:#ff2828; font-size: 21px;" data-tooltip="Отказано руководством">5</i></span>';
		
	  }		
	}

			   

	$readyonly='';
	if($podpis==0)
	{
		$readyonly='ready';
	}
							
	//если это главный инженер смотрим не подписан ли наряд и если нет выводим кнопки по ответам служебных записок
	if(($sign_level==3)or($sign_admin==1))
	{	
	  $decision=-1;	
	  if(($row_work["signedd_mem"]==0)and(($row_work["id_sign_mem"]==0)or($row_work["id_sign_mem"]=='')))
	  {		
		//решения пока нет  
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes"  for_s="w" for="'.$row_work["id"].'" data-tooltip="Согласовать">S</i><i class="no"  for_s="w" for="'.$row_work["id"].'" data-tooltip="Отказать">5</i></span>'; 
		$decision=-1;  
	  }
	  if(($row_work["signedd_mem"]==0)and(($row_work["id_sign_mem"]!=0)and($row_work["id_sign_mem"]!='')))
	  {		
		//отказано 
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes"  for_s="w" for="'.$row_work["id"].'" data-tooltip="Согласовать">S</i><i class="no active"  for_s="w" for="'.$row_work["id"].'"  data-tooltip="Отказать">5</i></span>'; 
		$decision=0;  
	  }	
	  if(($row_work["signedd_mem"]==1)and(($row_work["id_sign_mem"]!=0)and($row_work["id_sign_mem"]!='')))
	  {		
		//согласовано 
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes active" for_s="w" for="'.$row_work["id"].'" data-tooltip="Согласовать">S</i><i class="no"  for_s="w" for="'.$row_work["id"].'"  data-tooltip="Отказать">5</i></span>'; 
		$decision=1;  
	  }	
	 	if($podpis==1)
	{	
	  echo'<input class="decision_mes" name="works['.$i.'][decision]" value="'.$decision.'" type="hidden">';
	}
		
	}						
					   
			   
	echo'<div></div></span>';
/*
echo'<div class="div_textarea_otziv div_text_glo '.iclass_($row1ss["id"].'_w_text',$stack_error,"error_formi").'" style="margin-top:15px;">
			<div class="otziv_add">
          <textarea placeholder="Напиши руководству причину привышения параметров по этой работе относительно запланированной себестоимости" cols="40" rows="1" id="otziv_area_'.$i.'" name="works['.$i.'][text]" class="di text_area_otziv">'.ipost_($_POST['works'][$i]["text"],"").'</textarea>
		  
        </div></div>';
*/

echo'<div class="width-setter mess_slu"><input defaultv="'.ipost_($_POST['works'][$i]["text"],$row_work["memorandum"]).'" style="margin-top:0px;" name="works['.$i.'][text]" '.$status_edit.'  placeholder="Напиши руководству причину превышения параметров относительно запланированной себестоимости" class="input_f_1 input_100 white_inp label_s text_finery_message_ '.iclass_($row_work["id"].'_w_text',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["text"],$row_work["memorandum"]).'"></div>';					 
					 
					 
	 echo'</div>
	 </td></tr>';
				 

					 //смотрим может есть материалы с этой работой
			   		 if($row_list["signedd_nariad"]==1)
				     {
					   $result_mat=mysql_time_query($link,'Select a.*,a.count_units_material as count_seb,a.price_material as price_seb,a.count_units_material_realiz as count_realiz from n_material as a where a.id_nwork="'.$row_work["id"].'" order by a.id');	
						 
						 
											 	 
					 } else
					 {
					   $result_mat=mysql_time_query($link,'Select a.*,b.count_units as count_seb,b.price as price_seb,b.count_realiz,b.id_stock from n_material as a,i_material as b where a.id_material=b.id and a.id_nwork="'.$row_work["id"].'" order by a.id');
						 
						
					 }
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
				
					 
					 $ostatok=$row_mat["count_seb"]-$summ;
					 if($ostatok<0)
				     {
					     $ostatok=0;
					 }			
				/*	
	    $count_all_matt = $row_mat["count_seb"];
		$count_end=0;   
		$count_end = (($count_all_matt*$value['count'])/$rowx['count_units']); 
	
		//если рассчитанное кол-во материала больше чем запланировано в себестоимости
		//бывает из-за привышения работы связанной с этими материалами
		if($count_end>$count_ost_matt)
		{
		  $count_end=$count_ost_matt; 
		}							
		*/	
							
							
$my_material=0;							
//Определяем сколько материала на пользователе который оформляет наряд
							if($row_mat["id_stock"]!='')
							{
if($row_list["id_user"]==$id_user)	
{
$result_t1_=mysql_time_query($link,'SELECT b.units,(SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_stock=b.id and a.id_user="'.$id_user.'") as summ FROM z_stock as b WHERE b.id="'.htmlspecialchars(trim($row_mat["id_stock"])).'"');
} else
{
$result_t1_=mysql_time_query($link,'SELECT b.units,(SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_stock=b.id and a.id_user="'.$row_list["id_user"].'") as summ FROM z_stock as b WHERE b.id="'.htmlspecialchars(trim($row_mat["id_stock"])).'"');	
}
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
					 $units=$row1ss_["units"];
					
				 }									
							
							}
														
							
							
							echo'<tr work="'.$row_work["id"].'" style="background-color:#f0f4f6;" class="jop1 mat mattx" rel_w="'.$row_work["id"].'" rel_mat="'.$row_mat["id"].'" rel_matx="'.$row_mat["id"].'">
                  <td  class="no_padding_left_ pre-wrap one_td"><div class="nm" style="position:relative;"><span class="s_j">'.$row_mat["material"].'</span>&nbsp;';
								   		 if($row_list["signedd_nariad"]!=1)
				     {
							$tool_my="Материала на вас";
							if($row_list["id_user"]!=$id_user)	
{
		$result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row_list["id_user"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
	    $tool_my="Количество материала у - ".$rowxs["name_user"];
		}
}
							
							/*
							if($my_material!=0)
							{
								echo'<span class="my_material" data-tooltip="'.$tool_my.'">['.$my_material.' '.$units.']</span>';
							} else
							{
								echo'<span class="my_material" data-tooltip="'.$tool_my.'">[нет материала]</span>';
							}
						 */
						 if($my_material!=0)
							{
								echo'<span class="my_material" count="'.$my_material.'" id_stock_m="'.htmlspecialchars(trim($row_mat["id_stock"])).'" data-tooltip="'.$tool_my.'">['.$my_material.' '.$units.']</span>';
							} else
							{
								echo'<span class="my_material" count="0" id_stock_m="'.htmlspecialchars(trim($row_mat["id_stock"])).'" data-tooltip="'.$tool_my.'">[нет материала]</span>';
							}
						 
						 
						 
						 
						 
					 } else
                                         {

if(($row_mat["count_units"]!=0)and($row_mat["count_units"]!=0.000)) {
    echo '<span class="edit_panel11_mat"><span data-tooltip="история списания" for="' . $row_mat["id"] . '" class="history_icon">M</span>';

    echo '<div class="history_act_mat">
                                             <div class="line_brock"><div class="count_brock"><span>Объем</span></div><div class="price_brock"><span>Цена за ед.</span></div></div>';

    $result_uu_xo = mysql_time_query($link, 'select * from n_material_act where id_n_materil="' . ht($row_mat["id"]) . '"');

    if ($result_uu_xo) {
        $i = 0;
        while ($row_uu_xo = mysqli_fetch_assoc($result_uu_xo)) {


            echo'<div class="line_brock"><div class="count_brock">'.$row_uu_xo["count_units"].'<b>'.$row_mat["units"].'</b></div><div class="price_brock">'.$row_uu_xo["price"].'<b>₽</b></div></div>';
        }
    }


echo'</div>';
    echo '</span>';
}





                                         }
							echo'</div>
				  <input type=hidden value="'.$row_mat["id"].'" name="works['.$i.'][mat]['.$mat.'][id]">
				  <input type=hidden class="hidden_max_count" value="" name="works['.$i.'][mat]['.$mat.'][max_count]"></td>
<td class="pre-wrap center_text_td">'.$row_mat["units"].'';
echo'</td>
<td>';
//макс возможное количество берем всегда из себестоимости.							
echo'<div class="width-setter"><label>';
$maxmax='';	
$placeh='';							
if($row_mat["count_seb"]!='')
{
//echo'MAX ('.$row_mat["count_units_material"].')';
//$maxmax=$row_mat["count_units_material"];		
//$placeh='MAX - '.$row_mat["count_units_material"];
}
echo'</label><input  my="'.$my_material.'"
defaultv="'.ipost_($_POST['works'][$i]["mat"][$mat]["count"],$row_mat["count_units"]).'" '.$status_edit.' style="margin-top:0px;" 
ost="'.$ostatok.'"
all="'.$row_mat["count_seb"].'" 
name="works['.$i.'][mat]['.$mat.'][count]" 
max="'.$maxmax.'" placeholder="'.$placeh.'" 
class="input_f_1 input_100 white_inp label_s count_finery_mater_ '.iclass_($row_mat["id"].'_m_count',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" 

value="'.ipost_($_POST['works'][$i]["mat"][$mat]["count"],$row_mat["count_units"]).'"></div>';
				 
					 
echo'</td>
<td>';
/*						
if($edit_price==1)
{							
echo'<div class="width-setter"><label>MAX ('.$row_mat["price_material"].')</label><input defaultv="'.ipost_($_POST['works'][$i]["mat"][$mat]["price"],$row_mat["price"]).'" '.$status_edit.' style="margin-top:0px;" name="works['.$i.'][mat]['.$mat.'][price]" max="'.$row_mat["price_material"].'" placeholder="MAX - '.$row_mat["price_material"].'" class="input_f_1 input_100 white_inp label_s price_finery_mater_ '.iclass_($row_mat["id"].'_m_price',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["mat"][$mat]["price"],$row_mat["price"]).'"></div>';		
} else
{
*/
							//echo($row_mat["price"]);
echo'<div class="width-setter"><label>MAX ('.$row_mat["price_material"].')</label><input readonly="true" defaultv="'.ipost_($_POST['works'][$i]["mat"][$mat]["price"],$row_mat["price"]).'" '.$status_edit.' style="margin-top:0px;" name="works['.$i.'][mat]['.$mat.'][price]" max="'.$row_mat["price_material"].'" placeholder="MAX - '.$row_mat["price_material"].'" class="input_f_1 input_100 white_inp label_s price_finery_mater_ grey_edit '.iclass_($row_mat["id"].'_m_price',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["mat"][$mat]["price"],$row_mat["price"]).'"></div>';		
//}
echo'</td>
<td><span class="s_j summa_finery_mater_"></span>';
if($edit_price==1)
{	
echo'<div class="exceed"></div>';
}							
echo'</td>

<td></td>
           </tr>';			
							
		//служебная записка по материалу			
	 echo'<tr rel_matx="'.$row_mat["id"].'" work="'.$row_work["id"].'" class="loader_tr mattx" style="height:0px;"><td colspan="6">
	 <div class="messa" id_mes="'.$row_work["id"].'_'.$row_mat["id"].'">
	 <span class="hs">';
	if(($sign_level==3)or($sign_admin==1))
	{
	   echo'Cлужебная записка'; 
	} else
	{
	   echo'Оформление служебной записки';
	}
	if(($sign_level!=3)and($sign_admin!=1))
	{

	  //для прорабов и начальникам участка выводим просто статус служебных записок	
	  if(($row_mat["signedd_mem"]==1)and($row_mat["id_sign_mem"]!=0)and($row_mat["id_sign_mem"]!=''))
	  {		
		echo'<span style="visibility:visible" class="edit_12"><i data-tooltip="Подписана руководством">S</i></span>';
		
	  }
	  if(($row_mat["signedd_mem"]==0)and($row_mat["id_sign_mem"]!=0)and($row_mat["id_sign_mem"]!=''))
	  {		
		echo'<span style="visibility:visible" class="edit_12"><i style="color:#ff2828; font-size: 21px;" data-tooltip="Отказано руководством">5</i></span>';
		
	  }		
	}
	
	$readyonly='';
	if($podpis==0)
	{
		$readyonly='ready';
	}
							
	//если это главный инженер смотрим не подписан ли наряд и если нет выводим кнопки по ответам служебных записок
	if(($sign_level==3)or($sign_admin==1))
	{		
	  $decision=-1;	
	  if(($row_mat["signedd_mem"]==0)and(($row_mat["id_sign_mem"]==0)or($row_mat["id_sign_mem"]=='')))
	  {		
		//решения пока нет  
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes"  for_s="m" for="'.$row_mat["id"].'" data-tooltip="Согласовать">S</i><i class="no" for_s="m" for="'.$row_mat["id"].'" data-tooltip="Отказать">5</i></span>'; 
		$decision=-1;  
	  }
	  if(($row_mat["signedd_mem"]==0)and(($row_mat["id_sign_mem"]!=0)and($row_mat["id_sign_mem"]!='')))
	  {		
		//отказано 
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes" for_s="m" for="'.$row_mat["id"].'" data-tooltip="Согласовать">S</i><i class="no active" for_s="m" for="'.$row_mat["id"].'"  data-tooltip="Отказать">5</i></span>';
		$decision=0;  
	  }	
	  if(($row_mat["signedd_mem"]==1)and(($row_mat["id_sign_mem"]!=0)and($row_mat["id_sign_mem"]!='')))
	  {		
		//согласовано 
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes active" for_s="m" for="'.$row_mat["id"].'" data-tooltip="Согласовать">S</i><i class="no" for_s="m" for="'.$row_mat["id"].'"  data-tooltip="Отказать">5</i></span>'; 
		$decision=1;  
	  }		
      if(($row_mat["signedd_mem"]==1)and(($row_mat["id_sign_mem"]==0)or($row_mat["id_sign_mem"]=='')))
	  {			
		//пока вообще нет служебной записки
		echo'<span class="edit_122 '.$readyonly.'"><i class="yes"  for_s="m" for="'.$row_mat["id"].'" data-tooltip="Согласовать">S</i><i class="no" for_s="m" for="'.$row_mat["id"].'" data-tooltip="Отказать">5</i></span>'; 	  
	  }
	if($podpis==1)
	{	
	   echo'<input class="decision_mes" name="works['.$i.'][mat]['.$mat.'][decision]" value="'.$decision.'" type="hidden">';
	}
	}						
							
	echo'<div></div></span>';
	 
/*echo'<div class="div_textarea_otziv div_text_glo '.iclass_($row_mat["id"].'_m_text',$stack_error,"error_formi").'" style="margin-top:15px;">
			<div class="otziv_add">
          <textarea placeholder="Напиши руководству причину привышения параметров по этой работе относительно запланированной себестоимости" cols="40" rows="1" id="otziv_area_'.$i.'" name="works['.$i.'][mat]['.$mat.'][text]" class="di text_area_otziv">'.ipost_($_POST['works'][$i]["mat"][$mat]["text"],"").'</textarea>
		  
        </div></div>';
*/
echo'<div class="width-setter mess_slu"><input defaultv="'.ipost_($_POST['works'][$i]["mat"][$mat]["text"],$row_mat["memorandum"]).'" style="margin-top:0px;" name="works['.$i.'][mat]['.$mat.'][text]" '.$status_edit.'  placeholder="Напиши руководству причину превышения параметров относительно запланированной себестоимости" class="input_f_1 input_100 white_inp label_s text_finery_message_ '.iclass_($row_mat["id"].'_m_text',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['works'][$i]["mat"][$mat]["text"],$row_mat["memorandum"]).'"></div>';								
							
							
	 echo'</div>
	 </td></tr>';
				 						
	//Вывод подсказки что у вас не хватает материала чтобы оформить такое количество в наряде
//служебная записка по материалу
if($row_list["id_user"]==$id_user)	
{
	$text_mess_my='У вас недостаточно материала, чтобы оформить такое количество в наряде. Закажите необходимый материал.';
} else
{
	$text_mess_my='У пользователя - '.$rowxs["name_user"].' недостаточно материала, чтобы оформить такое количество в наряде.';
}
							
					 if($row_list["signedd_nariad"]!=1)
				     {							
	 echo'<tr work="'.$row_work["id"].'" class="loader_tr" style="height:0px;"><td colspan="6">
	 <div class="messa_my" id_mes="'.$row_work["id"].'_'.$row_mat["id"].'">
	 <span class="hs_my">'.$text_mess_my.'<div></div></span>';
														
	 echo'</div>
	 </td></tr>';							
					 }
						}
					 }

					 
					 
					 
					 
					 echo'<tr work="'.$row_work["id"].'" class="loader_tr" style="height:20px;"><td colspan="6"><input class="count_workssss" type=hidden value="'.$num_results_mat.'" name="works['.$i.'][count_mat]"></td></tr>';
					 
					 
					 
					 
				 //}
		   }
		  
		  //вывод итогов
		   echo'<tr style="" class="jop1 mat itogss">
                  <td class="no_padding_left_ pre-wrap one_td">Итого Работа</td>

<td class="pre-wrap center_text_td"></td>
<td style="padding-left:30px;"></td>
<td style="padding-left:20px;"></td><td style="padding-left:10px;"><span class="itogsumwork"></span></td><td></td></tr>'; 

		  		   echo'<tr style="" class="jop1 mat itogss">
                  <td class="no_padding_left_ pre-wrap one_td">Итого Материал</td>

<td class="pre-wrap center_text_td"></td>
<td style="padding-left:30px;"></td>
<td style="padding-left:20px;"></td><td style="padding-left:10px;"><span class="itogsummat"></span></td><td></td></tr>'; 
/*
		  		   echo'<tr style="" class="jop1 mat itogss">
                  <td class="no_padding_left_ pre-wrap one_td">Итого всего по наряду</td>

<td class="pre-wrap center_text_td"></td>
<td style="padding-left:30px;"></td>
<td style="padding-left:20px;"></td><td style="padding-left:10px;"><span class="itogsumall"></span></td><td></td></tr>'; 
*/
	if($edit_price1==1)
{	
		  		   echo'<tr style="" class="previ">
                  <td class="no_padding_left_ pre-wrap one_td previs">Превышение по наряду</td>

<td class="pre-wrap center_text_td previs"></td>
<td class="previs" style="padding-left:30px;"></td>
<td class="previs" style="padding-left:20px;"></td><td class="previs" style="padding-left:0px !important;"><span class="itogsumall1"></span></td><td  class="previs"></td></tr>'; 		
	
}
		  
		   if($rrtt>0){ echo'</tbody></table>'; echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_0").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>'; }
		 
		  //запускаем загрузку лодеров выполенных работ
		  //делаем пересчет суммы и итоговой
		  //выводим служебные записки где нужно
		  /*
		  if((isset($_POST['save_naryad']))and($_POST['save_naryad']==1))
          {
	*/
		     echo'<script>
				  $(function (){  $(\'.count_finery_,.price_finery_,.count_finery_mater_,.price_finery_mater_\').change();  });
				  </script>';
		  
		 // }
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
  </div>


</form>
                  </div></div></div></div></div></div></div>
<?
include_once $url_system.'template/left.php';
?>
<!--<div class="w_size debug"></div>-->
	</div>
</div><script src="Js/rem.js" type="text/javascript"></script>

<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
	
</div>

</body></html>
<?php
    //сообщения после добавление редактирования чего то
    //сообщения после добавление редактирования чего то
    //сообщения после добавление редактирования чего то

    $echo_help=0;
    if (( isset($_GET["a"]))or(isset($_POST["save_naryad"])))
    {

    $echo_help++;
    }

    if($echo_help!=0)
    {
    ?>
    <script type="text/javascript">

        <?
        echo'var text_xx=\''.$end_step_task.'\';';
        ?>
        $(function (){
            setTimeout ( function () {

                $('.js-hide-help').slideUp("slow");
                <?
                if (( isset($_GET["a"]))and($_GET["a"]=='seal')) {
                    echo "alert_message('ok', 'Наряд утвержден');";
                }
                if(( isset($_GET["a"]))and($_GET["a"]=='sign'))
                 {
                        echo "alert_message('ok', 'Наряд отправлен на подпись');";
                 }
                if(( isset($_GET["a"]))and($_GET["a"]=='shoot'))
                {
                    echo "alert_message('ok', 'Подпись снята с наряда');";
                }
                if(( isset($_GET["a"]))and($_GET["a"]=='disband'))
                {
                    echo "alert_message('ok', 'Наряд распроведен');";
                }
                 if(( isset($_GET["a"]))and($_GET["a"]=='no'))
                 {
                            echo "alert_message('error', 'Ошибка! Попробуйте еще раз!');";
                 }


                if((isset($_POST["save_naryad"]))and((count($stack_error)==0)and($error_count==0)))
                {
                    echo "alert_message('ok', 'данные сохранены');";
                }
                if((isset($_POST["save_naryad"]))and((count($stack_error)!=0)or($error_count!=0)))
                {
                    echo "alert_message('error', 'ошибка сохранения наряда');";
                }
                ?>
                var title_url=$(document).attr('title'); var url=window.location.href;
                url=url.replace('seal/', '');
                url=url.replace('sign/', '');
                url=url.replace('disband/', '');
                url=url.replace('shoot/', '');
                url=url.replace('yes/', '');
                url=url.replace('no/', '');
                url=url.replace('save/', '');
                var url1 = removeParam("a", url);
                History.pushState('', title_url, url1);

            }, 500 );




        });
    </script>
<?
}


//сообщения после добавление редактирования чего то
//сообщения после добавление редактирования чего то
//сообщения после добавление редактирования чего то
