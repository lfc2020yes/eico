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


$active_menu='app';
//правам к просмотру к действиям
//$user_send_new=array();


$podpis=0;  //по умолчанию нельзя редактировать статус заказано


//кому можно изменять заявку
//если это создатель заявки
//и статус заявки сохранено
//никто выше не может изменять чужие заявки
//выше могут ставить решение по служебным запискам
//выше могут ставить соответствие заказанного материала с материалом на складе
$result_url=mysql_time_query($link,'select A.id from z_doc as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'" and A.id_user="'.$id_user.'" and ((A.status=1) or (A.status=8))');
$num_results_custom_url = $result_url->num_rows;
if($num_results_custom_url!=0)
{
	$podpis=1;
}

$status_edit='';
$status_class='';
$status_edit1='';
if($podpis==0)		
{	
   $status_edit='readonly';	
   $status_edit1='disabled';
   $status_class='grey_edit';		
}


//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /finery/add/28/
//     0   1     2  3

$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);


if (( count($_GET) == 1 )or( count($_GET) == 2 )) //--Если были приняты данные из HTML-формы
{

  if($D_404[4]=='')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
		
       
		$result_url=mysql_time_query($link,'select A.* from z_doc as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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
			if (($role->permission('Заявки','R'))or($sign_admin==1)or($role->permission('Заявки','S')))
	        {
				//имеет ли он доступ в эту заявку	
				
				 
				//если это не его заявка
				//но статус у нее 0 не сохранено
				//тогда не допускать к этой заявки
				if(($row_list["id_user"]!=$id_user)and($row_list["status"]==1))
				{
				 
				  header("HTTP/1.1 404 Not Found");
	              header("Status: 404 Not Found");
	              $error_header=404;
				} else
				{
				
				
			
				
				//если статус равен заказано или исполнено
				//и это не его заявка
				//объект по заявки должен быть в его подчинении
				//и он должен обладать правами видеть все заявки пользователей R not A
				if(($sign_admin!=1)and($row_list["id_user"]!=$id_user)and(($row_list["status"]==9)or($row_list["status"]==10))and($role->permission('Заявки','R'))and(!$role->permission('Заявки','S')))
				{
				   
				 if((array_search($row_list["id_object"],$hie_object)===false))
			    {
			      header("HTTP/1.1 404 Not Found");
	              header("Status: 404 Not Found");
	              $error_header=404;
			    } 
				} else
					
					
				{
					//echo("1");
					//Если статус заявки со служебной запиской
					//и это не его заявка
					//он должен обладать правами видеть все служебные записки по заявкам S
					//и создатель заявки должен быть в его подчинении
				 if(($sign_admin!=1)and($row_list["id_user"]!=$id_user)and($row_list["status"]!=1)and($row_list["status"]!=8))
				{	
					/*
					if((array_search($row_list["id_user"],$hie_user)===false)or(!$role->permission('Заявки','S')))
			        {
						header("HTTP/1.1 404 Not Found");
	                    header("Status: 404 Not Found");
	                    $error_header=404;	
					}
				*/
				}
					
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





	//определяем кто есть пользователь
	//0 тот прораб делающий заявку 
	//1 тот кто обрабатывает служебные записки может обладать и добавлением заявок, но обрабатывать может все кроме своих, админ тоже может решать служебки
	//2 тот кто формирует групповые заявки	
	//$status_user_zay=0; //прораб по умолчанию
	$status_user_zay=array("1","0","0");
	
	if((($role->permission('Заявки','S'))and(array_search($row_list["id_user"],$hie_user)!==false)and($row_list["id_user"]!=$id_user))or($sign_admin==1))
	{
		$status_user_zay[1]=1;
	}
	if(($role->permission('Заявки','R'))and(!$role->permission('Заявки','A'))and(array_search($row_list["id_object"],$hie_object)!==false))
	{
		$status_user_zay[2]=1;
	}
	
	//print_r($status_user_zay);
	







if((isset($_POST['save_naryad']))and($_POST['save_naryad']==1))
{
	$token=htmlspecialchars($_POST['tk']);
	$id=htmlspecialchars($_GET['id']);
	//echo("!!");
	//токен доступен в течении 120 минут

    if(token_access_new($token,'save_mat_zay_x',$id,"rema",120))



       // if(token_access_yes($token,'save_mat_zay_x',$id,120))
    {
		//echo("!");
	//возможно проверка что этот пользователь это может делать
	 if (($role->permission('Заявки','A'))or($sign_admin==1)or(($role->permission('Заявки','S'))and(array_search($row_list["id_user"],$hie_user)!==false)or($row_list["id_user"]!=$id_user)and($row_list["status"]==3)))
	 {	
	//echo("!");
	$edit_zay=0;	 
	$stack_memorandum = array();  // общий массив ошибок
	$stack_id_work	  = array();
	$stack_error = array();  // общий массив ошибок
	$error_count=0;  //0 - ошибок для сохранения нет
	$flag_podpis=0;  //0 - все заполнено можно подписывать

	//print_r($stack_error);
	//исполнитель			
		
			 $works=$_POST['mat_zz'];
             foreach ($works as $key => $value) 
			 {
			   //смотрим вдруг был удален эта работа при оформлении	 
			   if($value['id']!='') 
			   {
				 /*
				$value['id']
				$value['count_mat']
				$value['max_count']
				$value['count']
				$value['date_base']
				$value['text']
				
				$_POST['works'][0]["id"]
				*/
				   
				//if($value['status']=='') { /*$error_count++;*/ $flag_podpis++; } 
				array_push($stack_id_work,$value['id']);
				
				$result_tx=mysql_time_query($link,'Select a.*,b.id_object,b.id_doc from i_material as a,z_doc_material as b where b.id_i_material=a.id and b.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такой материал есть
		           $rowx = mysqli_fetch_assoc($result_tx);
					
				   //проверяем что материал относится к нужному объекту
					if($rowx["id_doc"]!=$_GET['id'])
					{
					  array_push($stack_error, $value['id']."work_not_object"); 
					}
					
				   $date_base=$value['date_base'];
					//г м д
					$date_base__=explode('-',$date_base);
					
				   //проверяем возможно служебная записка нужна и поля не все заполнены	
				   $count_user=$value['count'];
				   
				   
				   //$count_sys=$rowx['count_units'];
					
				   //находим максимальное возможное количество без служебной записки
				   //******************************************************	
				   $count_sys=$rowx['count_units']-$rowx['count_realiz'];
				   
					$stock=new stock_user($link,htmlspecialchars($rowx['id_object'])); 
				   $z_stock_count_users=0;	//на складе на всех прорабах по этому объекту числится
				 if(($rowx["id_stock"]!='')and($rowx["id_stock"]!=0))
				 {	
					 $text_stock='';
					 if($stock->id_stock>0)
					 {
					 $text_stock=' and not(a.id_user="'.htmlspecialchars(trim($stock->id_stock)).'")';
					 }
				    $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE
a.id_object="'.htmlspecialchars(trim($rowx['id_object'])).'" AND a.id_stock="'.$rowx["id_stock"].'" '.$text_stock.'');
						             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					 {
					     $z_stock_count_users=$row1ss_["summ"];
					 }
				 }
				 
				 }	
					
					
					
//***************************************************************************************************************************		
                //вдруг он до этого сделал заявку и она в статусе не откланено и не сохранено
				$z_stock_count_doc=0;	 
				$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.id_object="'.htmlspecialchars(trim($rowx['id_object'])).'" and  
a.id_i_material="'.htmlspecialchars(trim($rowx["id"])).'"  AND a.status NOT IN ("1","8","10","3","5","4") and not(a.id_doc="'.htmlspecialchars($_GET['id']).'")');
					 
					 	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					 {
					     $z_stock_count_doc=$row1ss_["summ"];
						 //$sklad_name=$row1ss_["name_user"];
					 }
				 }	 
					 
//***************************************************************************************************************************					
					
					
					
					
					
					$count_sys=$count_sys-$z_stock_count_users-$z_stock_count_doc;
					
				   
				   //******************************************************	
				   $error_work = array();  //обнуляем массив ошибок по конкретной работе
				   
				   $flag_message=0;	//0 - вывод служебной записки по работе не нужен
				   $flag_work=0;
					
				   if($count_sys<$count_user) { $flag_work++; $flag_message=1; if((!is_numeric($count_user))or($count_user==0)) { array_push($error_work, $value['id']."_w_count");  }  }
					
				   if((!is_numeric($count_user))or($count_user<=0)) { $flag_podpis++; }
				   if($date_base!='')
				   {
					if(!checkdate(date_minus_null($date_base__[1]), date_minus_null($date_base__[2]),$date_base__[0])) { $flag_podpis++; array_push($error_work, $value['id']."_w_date"); }
				   } else { $flag_podpis++; }
				 			
				    if((trim($value['text'])=='')and($flag_work>0)) {  $flag_podpis++;  array_push($error_work, $value['id']."_w_text"); }
				   
					if($flag_work>0) { array_push($stack_memorandum, $value['id']."_w_flag");  /*где- то в работе есть служебная записка*/	 }
				 
					//echo("!!!");
					//echo($flag_podpis);
				 
				 
				 /*
				 if($flag_message==1)
				 {
					 array_push($stack_error, $value['id']."_w_flag");  //где-то в работе есть служебная записка					 
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
		 
		 //проверим что в сохран. материалах не было одинаковых
		     $stack_id_work_new= array_unique($stack_id_work);
		     if(count($stack_id_work_new)!=count($stack_id_work))
			 {
				array_push($stack_error,"est_work_odinakovie"); 
			 }
		 //проверяем что все материала из заявки сохранялись
		 
		 $result_cc=mysql_time_query($link,'Select count(a.id) as cco from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'"');
         $num_results_cc = $result__cc->num_rows;
	     if($num_results_cc!=0)
	     {  
		   //такая работа есть
		   $row_cc = mysqli_fetch_assoc($result_cc);
		 
		 
		 
		 if(($row_cc["cco"]!=count($works))or(count($works)==0))
		 {
			array_push($stack_error,"count_save_no_count_zayva");  
		 }
		 }
		 
		 
	    //есть ли ошибки по заполнению
		//print_r($stack_error);
		//echo($flag_podpis);
	    if((count($stack_error)==0)and($error_count==0))
		{
		   //ошибок нет
		   //сохраняем заявку
		   	 $works=$_POST['mat_zz'];
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
				$value['count_mat']
				$value['max_count']
				$value['count']
				$value['date_base']
				$value['text']
				*/
				$result_tx=mysql_time_query($link,'Select a.* from z_doc_material as a where a.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такая работа есть
		           $rowx = mysqli_fetch_assoc($result_tx);
				   
				   if($count_work==0)	
				   {		
                     $id_user=id_key_crypt_encrypt(htmlspecialchars(trim($_SESSION['user_id'])));

				   }	
				 
				  $count_work++;	 
				
				  $count_memo=0;	
				  $status_memo=$rowx["signedd_mem"];
				  $user_dec_memo=$rowx["id_sign_mem"];
				  $memo='';	
					
					
				  //проверяем есть ли служебка	
				  $found1 = array_search($value['id']."_w_flag",$stack_memorandum);   
	              if($found1 !== false) 
	              {
					  
				    $memo=htmlspecialchars(trim($value['text'])); 
					  $count_memo++;
					  if(($status_user_zay[1]==1)and($row_list["id_user"]!=$id_user))
					  {
						//есть меморандум смотрим есть ли по нему решение
					   if($value['decision']==0) { $status_memo=0;  $user_dec_memo=$id_user; }
					   if($value['decision']==1) { $status_memo=1;  $user_dec_memo=$id_user; }	  
					  }
					  
					  
				  } else { $status_memo=0; $user_dec_memo=0; }
					
				  //проверить были ли изменения в работе количество,дата
				  //если да то обнуляем решение о проверке меморандума
				  $count_redac=0;
					$count_redac1=0;
				  $izm_rab=0;
					
				  $result_tyd=mysql_time_query($link,'Select a.* from z_doc_material as a where a.id="'.htmlspecialchars(trim($value['id'])).'"');
                  $num_results_tyd = $result_tyd->num_rows;
	              if($num_results_tyd!=0)
	              {
	                 $row_tyd = mysqli_fetch_assoc($result_tyd);
					 $id_sign_mem=$row_tyd['id_sign_mem'];
					  
					 if($row_tyd["count_units"]!=$value['count']) { $count_redac++; }

					 if($row_tyd["commet"]!=$value['commun_text']) { $count_redac++; }

					 if($row_tyd["memorandum"]!=$value['text']) { $count_redac++; }
					 if($row_tyd["date_delivery"]!=$value['date_base']) { $count_redac++; } 
					 if($row_tyd['id_sign_mem']!=$user_dec_memo) { $count_redac++; $count_redac1++; }
                     if($row_tyd['signedd_mem']!=$status_memo) { $count_redac++; $count_redac1++; }
					  //echo("!!!");
				  }
					//echo($count_redac);
				  if($count_redac!=0)
				  {
				    $id_sign_mem=0;
					$izm_rab=1;
					$edit_zay++;
					  //если в материале прораб что -то изменил то сохранения по решению меморандума обнуляются и статус становится просто сохранено
					if(($row_tyd["memorandum"]!='')and($status_user_zay[1]!=1) )
					{
						$user_dec_memo=0;
						$status_memo=0;
						mysql_time_query($link,'update z_doc_material set 				 
					 status="1"
					 
					 where id = "'.htmlspecialchars(trim($value['id'])).'"'); 	
					}
					  
					  
					  
				  }	
					
				  if($count_redac!=0)
				  {

                      $commun='';
                      if($value['commun']!=0)
                      {
                          $commun=trim($value['commun_text']);
                      }

                      $j_sql='';
                      if($row_list["id_user"]==$id_user)
                      {
                          $j_sql=',commet="'.ht($commun).'"';
                      }

					  //значит были изменения в материале сохраняем их и решения если и были по меморандуму обнуляем их
mysql_time_query($link,'update z_doc_material set 				 
					 count_units="'.htmlspecialchars(trim($value['count'])).'",					 
					 date_delivery="'.htmlspecialchars(trim($value['date_base'])).'",
					 memorandum="'.htmlspecialchars(trim($value["text"])).'", 
					 id_sign_mem="'.$user_dec_memo.'", 
					 signedd_mem="'.$status_memo.'"'.$j_sql.'
					 
					 where id = "'.htmlspecialchars(trim($value['id'])).'"'); 
	//значит у этого материала поменялся ответ по служебке		
	//меняем статус у этого материала на 5- утв 4- отк				  
	if(($status_user_zay[1]==1)and($count_redac1!=0)and($user_dec_memo!=0))
	{
		$mes_mem=5;
		if($status_memo==0)
		{
			$mes_mem=4;
		}
	mysql_time_query($link,'update z_doc_material set 				 
					 status="'.$mes_mem.'"
					 
					 where id = "'.htmlspecialchars(trim($value['id'])).'"'); 	
	}
					  
					  
				  }
				  //добавляем материал к заявке
				  
				  //$ID_W=mysqli_insert_id($link); 

				   //изменяем статус наряда в зависимости от заполнения
				}
			   }
			 }
				   $status_nariad=0;
			       $status_zayka=1;  //сохранено
				   if($flag_podpis==0){ $status_nariad=1; }
			       
			       //если значение ready=1 и ничего не менялось $edit_zay=0 то изменяем статус заявки и всех материалов на 9 = заказано
			       //если есть непринятые служебки то статус=3 = на рассмотрении со сл. запис.
			/*
				   $result_tyd2=mysql_time_query($link,'Select a.ready,a.id_user,a.id_object,a.number,a.id from z_doc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"' );
                   $num_results_tyd2 = $result_tyd2->num_rows;
	               if($num_results_tyd2!=0)
	               {
	                 $row_tyd2 = mysqli_fetch_assoc($result_tyd2);
					   
				   }
			if(($row_tyd2['ready']==1)and($edit_zay==0))
			{
			
			$result_tyd1=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'" and not(a.memorandum="") and a.signedd_mem=0 and a.id_sign_mem=0');
                   $num_results_tyd1 = $result_tyd1->num_rows;
	               if($num_results_tyd1!=0)
	               {
	                 //$row_tyd1 = mysqli_fetch_assoc($result_tyd1);
					   //есть неотвеченные служебные записки
					   $status_zayka=3;
				   } else
				   {
					   $status_zayka=9;
				   }
			}
			   */    
			      
				   mysql_time_query($link,'update z_doc set ready="'.$status_nariad.'" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
			/*
			if($status_zayka==9)
			{
				   //меняем у всех материалов статус на заказано
				   mysql_time_query($link,'update z_doc_material set status="'.$status_zayka.'" where id_doc = "'.htmlspecialchars(trim($_GET['id'])).'"');
			}
			if($status_zayka==3)
			{				
				  mysql_time_query($link,'update z_doc_material set status="1" where id_doc = "'.htmlspecialchars(trim($_GET['id'])).'"');
				  //меняем статусы только у которых по служебке нет решения
				  for ($ids=0; $ids<$num_results_tyd1; $ids++)
		          {
					  $row_tyd1 = mysqli_fetch_assoc($result_tyd1);
					  mysql_time_query($link,'update z_doc_material set status="'.$status_zayka.'" where id = "'.htmlspecialchars(trim($row_tyd1['id'])).'"');
				  }
			}
			*/
			
			
			//если статус изменился на заказать. -> приходит уведомление тем кто занимается групповыми заявками
			//если статус изменился на согласовать -> приходит уведомление тем кто может принемать решения по служебным запискам			
			//если статус изменился с согласовать на заказать -> прислать создателю заявки уведомление что заявка изменила свой статус на заказано
			
			
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
			
			//если статус изменился не на сохранить
			/*
			if($status_zayka!=1)
			{
				  $user_send= array();	
				  $user_send_new= array();		

				  $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_tyd2['id_object'])).'"');
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
			
			
			
			if(($status_zayka==9)and($row_tyd2['id_user']==$id_user))
			{
				  $FUSER=new find_user($link,$row_tyd2['id_object'],'RA','Группировка');
				  $user_send_new=$FUSER->id_user;
				  
				
				  $text_not='Поступила новая <a href="app/'.$row_tyd2['id'].'/">заявка на материал №'.$row_tyd2['number'].'</a>, от <strong>'.$name_user.'</strong>, по объекту -  '.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';					  
				  //отправка уведомления
			      $user_send_new= array_unique($user_send_new);	
			      notification_send($text_not,$user_send_new,$id_user,$link);	  
			}
			
			if(($status_zayka==3)and($row_tyd2['id_user']==$id_user))
			{
				$FUSER=new find_user($link,$row_tyd2['id_object'],'S','Заявки');
				$user_send_new=$FUSER->id_user;
				$text_not='Поступила новая <a href="app/'.$row_tyd2['id'].'/">служебная записка</a> по заявке на материал №'.$row_tyd2['number'].', от <strong>'.$name_user.'</strong>, по объекту -  '.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);
			}
			
			if(($status_zayka==9)and($row_tyd2['id_user']!=$id_user))
			{	
				//отправляем тем кто работает с групповыми заявками
				$FUSER=new find_user($link,$row_tyd2['id_object'],'RA','Группировка');
				$user_send_new=$FUSER->id_user;
				$text_not='Поступила новая <a href="app/'.$row_tyd2['id'].'/">заявка на материал №'.$row_tyd2['number'].'</a>, от <strong>'.$name_user.'</strong>, по объекту -  '.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';	
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);
				
				//отправляем создателю заявки что его служебные приняты и заявка изменила статус
				$user_send_new= array();
				array_push($user_send_new,$row_tyd2['id_user']);
				$text_not='<a href="app/'.$row_tyd2['id'].'/">Заявка на материал №'.$row_tyd2['number'].'</a> изменила свой статус - заказано.';
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);
			}
				

			}
				  
	*/
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	

		

			   header("Location:".$base_usr."/app/".$_GET["id"].'/');	
			   die();				 
			
		    }
			 }
			 }			
		  
		   
		}
	



/*
$secret=rand_string_string(4);
$_SESSION['s_t'] = $secret;	
*/


//89084835233

//проверить и перейти к последней себестоимости в которой был пользователь

$b_co='basket_'.$id_user;
$b_cm='basket1_'.$id_user;


include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('app_view','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php'; include $url_system.'template/head.php';
?>
</head><body><div class="alert_wrapper"><div class="div-box"></div></div><div class="container">
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
/*
			$result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_list["id_object"])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {
			$row_list1 = mysqli_fetch_assoc($result_url);
		}
	
        $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list1["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}	
	*/
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

	  include_once $url_system.'template/top_app_view.php';

	?>
      <div id="fullpage" class="margin_60  input-block-2020 ">
      <div class="section" id="section0">
          <div class="height_100vh">
              <div class="oka_block_2019">

                  <?
                  echo'<div class="line_mobile_blue">Заявка №'.$row_list["id"];
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
                      echo '<div class="ring_block ring-block-line js-global-preorders-link">';
                      $new_pre = 1;
                      $task_cloud_block='';


                      //echo '<pre>arr_document:'.print_r($arr_document,true) .'</pre>';

                      foreach ($arr_document as $key => $value) {
                          include $url_system . 'app/code/block_app.php';
                          echo($task_cloud_block);
                      }
                      echo'</div>';



                      //сообщения после добавление редактирования чего то
                      //сообщения после добавление редактирования чего то
                      //сообщения после добавление редактирования чего то

                      $echo_help=0;
                      if (( isset($_GET["a"])))
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
                                      if (( isset($_GET["a"]))and($_GET["a"]=='order')) {
                                          echo "alert_message('ok', 'отправлено на согласование');";
                                      } else
                                      {
                                          echo "alert_message('ok', text_xx);";
                                      }
?>
                                      var title_url=$(document).attr('title'); var url=window.location.href;
                                      url=url.replace('yes/', '');
                                      url=url.replace('order/', '');
                                      //var url1 = removeParam("a", url);
                                      History.pushState('', title_url, url);

                                  }, 1000 );
                              });
                          </script>
                          <?
                      }
                      //сообщения после добавление редактирования чего то
                      //сообщения после добавление редактирования чего то
                      //сообщения после добавление редактирования чего то



                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо

                      if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8))) {
                          $query_string .= '<div class="info-suit"><div class="input-block-2020">';


                          $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="11" and A.visible=1 and A.id_object="' . ht($row_list["id"]) . '"');

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


                          $query_string .= '</div><input type="hidden" name="files_9" value=""><div type_load="11" id_object="' . ht($row_list["id"]) . '" class="invoice_upload js-upload-file js-helps ' . $class_aa . '"><span>прикрепите <strong>дополнительные документы</strong>, для этого выберите или перетащите файлы сюда </span><i>чтобы прикрепить ещё <strong>необходимые документы</strong>,выберите или перетащите их сюда</i><div class="help-icon-x" data-tooltip="Принимаем только в форматах .pdf, .jpg, .jpeg, .png, .doc , .docx , .zip" >u</div></div></div></div>';

                          $query_string .= '</div></div>';


                          echo $query_string;
                      }
                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                      //конец

                      ?>


                      <div class="info-suit">





<form id="lalala_add_form" class="my_nn" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
 <input name="save_naryad" value="1" type="hidden">
 <input name="save_zayy" value="1" type="hidden">
  <?
	
    //echo'<div class="content_block1" id_content="'.$id_user.'">';

//print_r($stack_error);
	/*echo '<pre>';
print_r($_POST["works"]);	
	echo '</pre>';
	*/

	
	  
	  
	  $rrtt=0;
	  

	  
	  
	  
	  
	  
	  echo'<div class="content_block block_primes1">';
	

	//определяем какой столбик выводить а какой нет
	$td_status=0;  //по умолчанию выводить все
	$td_sklad=1;
	$td_dell=1;
	$count_td_table=6;
	$count_td_table_datepiker1=3;
	$count_td_table_datepiker2=1;
	
	if(($row_list["status"]!=1)and($status_user_zay[0]==1))
	{
		//прораб заказал и ему все равно уже что на складе ему важны только статусы материалов
		$td_sklad=0;
		$td_status=1;
		$td_dell=0;
		$count_td_table=5;
		
		$count_td_table_datepiker1=2;
	    $count_td_table_datepiker2=1;
		
	}
	
	if(($row_list["status"]!=3)and($row_list["status"]!=1)and($status_user_zay[1]==1))
	{
		//кто то кто в праве отвечать на служебные записки хочет посмотреть что стало с материалами после его ответа важны статусы
		$td_sklad=0;
		$td_status=1;
		$td_dell=0;
		$count_td_table=5;
		$count_td_table_datepiker1=2;
	    $count_td_table_datepiker2=1;
	}	
	
		if(($row_list["status"]==3)and($row_list["status"]!=1)and($status_user_zay[1]==1))
	{
		//кто то кто в праве отвечать на служебные записки хочет посмотреть что стало с материалами после его ответа важны статусы
		$td_sklad=1;
		$td_status=1;
		$td_dell=0;
		$count_td_table=6;
		$count_td_table_datepiker1=3;
	    $count_td_table_datepiker2=1;
	}	
	
	
	
					 
	//echo($_COOKIE["basket_".htmlspecialchars(trim($_GET['id']))]);	
	  //определяем совхоза по объекту
	  $stock=new stock_user($link,$row_list["id_object"]); 
	
	
		$result_work_zz=mysql_time_query($link,'Select a.* from z_doc_material as a where a.id_doc="'.htmlspecialchars($_GET['id']).'" order by a.id');
        $num_results_work_zz = $result_work_zz->num_rows;
	    if($num_results_work_zz!=0)
	    {

	
	
		  $id_work=0;
			
			for ($i=0; $i<$num_results_work_zz; $i++)
		   {
			   $row_work_zz = mysqli_fetch_assoc($result_work_zz);
				
	             //проверим может вообще такого материала уже нет
			     $result_t1=mysql_time_query($link,'Select a.* from i_material as a where a.id="'.htmlspecialchars(trim($row_work_zz["id_i_material"])).'"');
                 $num_results_t1 = $result_t1->num_rows;
	             if($num_results_t1!=0)
	             {  
		            //такая работа есть
		            $row1ss = mysqli_fetch_assoc($result_t1);
					 
					 
					 
					 
					$rrtt++;
					if($rrtt==1)
					{
		$token=token_access_compile($_GET['id'],'save_mat_zay_x',$secret);


						echo'<input type="hidden" value="'.$token.'" name="tk">';
						
						
						//заголовок таблицы
						
						 echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_0" class="smeta1"><thead>
		   <tr class="title_smeta"><th class="t_2 no_padding_left_ jk4">Наименование</th>';
						
						//<th class="t_3">статус</th>
							
							echo'<th class="t_4 jk44">ед. изм.</th>
							<th class="t_5">кол-во</th>';
							if($td_sklad==1)
							{
							echo'<th class="t_55">Склад</th>';
							}
							echo'<th class="t_6">дата поставки</th>';
							
						    if($td_status==1)
							{
							echo'<th class="t_7 jk5">статус</th>';
							}
							if($td_dell==1)
							{						
							echo'<th class="t_10 jk6"></th>';
							}
						
						echo'</tr></thead><tbody>';
						 //echo'<tr class="loader_tr" style="height:20px;"><td colspan="7"></td></tr>';
					}
					 
					 
					$result_t1__34=mysql_time_query($link,'Select b.razdel1,a.name_working,a.razdel2,a.date0,a.date1  from i_razdel2 as a,i_razdel1 as b where a.id="'.$row1ss["id_razdel2"].'" and a.id_razdel1=b.id'); 
			        $num_results_t1__34 = $result_t1__34->num_rows;
	                if($num_results_t1__34!=0)
	                {  
		              $row1ss__34 = mysqli_fetch_assoc($result_t1__34);
					
					}	 
					 
				//выводим к какой работе относится материал
				if($id_work!=$row1ss["id_razdel2"])
				{
					 $id_work=$row1ss["id_razdel2"];
				
				/*
					if($rrtt!=1)
					{	
					*/
				echo'<tr work="'.$row1ss["id_razdel2"].'" class="loader_tr" style="height:20px;"><td colspan="'.$count_td_table.'"><input class="count_workssss" value="1" name="mat_zz['.$i.'][count_mat]" type="hidden"></td></tr>';
				//	}
					
					
					 
					 
				 $summ=0;
                 $ostatok=0;
                 $proc_view=0;	
				 $flag_history=0;
			    
					
				
					

					
					echo'<tr work="'.$row1ss["id_razdel2"].'" style="background-color:#f0f4f6;" class="jop work__s" id_trr="'.$i.'" rel_id="'.$row1ss["id_razdel2"].'">
                  <td colspan="'.$count_td_table.'" class="no_padding_left_ pre-wrap one_td"><span class="s_j">'.$row1ss__34["razdel1"].'.'.$row1ss__34["razdel2"].' '.$row1ss__34["name_working"];
					
					//график работ выводим если заданы даты
					if($row1ss__34["date0"]!='')
					{
						echo' ('.MaskDate_D_M_Y_ss($row1ss__34["date0"]).' - '.MaskDate_D_M_Y_ss($row1ss__34["date1"]).')';
					}
					
					echo'</span></td></tr>';
					
				}
					 
		//***************************************************************************************************************************					
				 $z_stock_count_users=0;	//на складе на всех прорабах по этому объекту числится
				 if(($row1ss["id_stock"]!='')and($row1ss["id_stock"]!=0))
				 {	
					 $text_stock='';
					 if($stock->id_stock>0)
					 {
					 $text_stock=' and not(a.id_user="'.htmlspecialchars(trim($stock->id_stock)).'")';
					 }
				    $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE
a.id_object="'.$row_work_zz["id_object"].'" AND a.id_stock="'.$row1ss["id_stock"].'" '.$text_stock.'');
						             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					 {
					     $z_stock_count_users=$row1ss_["summ"];
					 }
				 }
				 
				 }
//***************************************************************************************************************************					
                $z_stock_count_sklad=0;	//на складе на каком то, где то по этому объекту числится
					$sklad_name='';
				
                if(($stock->id_stock>0)and($row1ss["id_stock"]!=0)and($row1ss["id_stock"]!=''))
				{
				   $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ,b.name_user FROM z_stock_material AS a,r_user as b WHERE a.id_user=b.id and 
a.id_user="'.htmlspecialchars(trim($stock->id_stock)).'"  AND a.id_stock="'.$row1ss["id_stock"].'"');
					/*echo('SELECT SUM(a.count_units) AS summ,b.name_user FROM z_stock_material AS a,r_user as b WHERE a.id_user=b.id and 
a.id_user="'.htmlspecialchars(trim($stock->id_stock)).'"  AND a.id_stock="'.$row1ss["id_stock"].'"'); */	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					 {
					     $z_stock_count_sklad=$row1ss_["summ"];
						 $sklad_name=$row1ss_["name_user"];
					 }
				 }
				}
					
					
//***************************************************************************************************************************		
                //вдруг он до этого сделал заявку и она в статусе не откланено и не сохранено
				$z_stock_count_doc=0;	 
				$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.id_object="'.$row_work_zz["id_object"].'" and  
a.id_i_material="'.$row_work_zz["id_i_material"].'"  AND a.status NOT IN ("1", "8", "10","3","5","4") and not(a.id_doc="'.htmlspecialchars($_GET['id']).'") ');
					 	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
	                 //такая работа есть
                     $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					 {
					     $z_stock_count_doc=$row1ss_["summ"];
						 //$sklad_name=$row1ss_["name_user"];
					 }
				 }	 
					 
//***************************************************************************************************************************		
					 
					 $ostatok=$row1ss["count_units"]-$row1ss["count_realiz"]-$z_stock_count_users-$z_stock_count_doc;
					
					 if($ostatok<0)
				     {
					     $ostatok=0;
					 }
					 $proc_view=round((($row1ss["count_units"]-$ostatok)*100)/$row1ss["count_units"]); 
					 					
					
		
					 
					 
					//линия сколько товара уже заказано и есть
					echo'<tr works="'.$row1ss["id_razdel2"].'"  mat_zz="'.$row1ss["id"].'" class="loader_tr"><td colspan="'.$count_td_table.'"><div class="loaderr"><div id_loader="'.$row1ss["id"].'" class="teps" rel_w="'.$proc_view.'" style="width:0%"><div class="peg_div"><div><i class="peg"></i></div></div></div></div></td></tr>';


                     $dava='';
                     $class_dava='';
                     if($row1ss["alien"]==1)
                     {
                         $class_dava='dava';

                     }

                     if($row1ss["alien"]==1)
                     {
                         $dava='<div class="chat_kk" data-tooltip="давальческий материал"></div>';
                     }
							  //вывод материала
							echo'<tr works="'.$row1ss["id_razdel2"].'" mat_zz="'.$row1ss["id"].'" style="background-color:#f0f4f6;" class="jop1 mat_zz" rel_w="'.$row1ss["id"].'" rel_mat_zz="'.$row1ss["id"].'">
                  <td colspan="1" class="no_padding_left_ pre-wrap one_td plus_comm_vot">';
$text_tool='есть комментарий';
                     $val_commun=0;
if(trim($row_work_zz["commet"])!='')
{
    $class_bu='yes-note';
    $val_commun=1;
} else
{
    $text_tool='нет комментария';
    $class_bu='';
}



$visible_form_commet=0;


                 if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8)))
                 {
                     $text_tool='Написать/изменить комментарий';
                     $visible_form_commet=1;
                     $class_bu.=' js-zame-tours';
                 }


                     $task_cloud_block ='<div class="zame_kk css-zame-tours '.$class_bu.'" data-tooltip = "'.$text_tool.'" ></div>';

if($visible_form_commet==1) {

    $task_cloud_block .= '<div class="form-rate-ok1 form-rate-ok-chat"><div class="rate-input"><div class="rates_visible">';

    $task_cloud_block .= '<label style="text-transform: uppercase; font-size:10px;">↑ Комментарий по материалу (сколько шт, точные размеры...)</label><div class="div_textarea_otziv1 js-prs"  style="margin-top: 0px;"><div class="otziv_add">';


    $task_cloud_block .= '<textarea cols="10" rows="1" placeholder="" id="otziv_chat1_' . $row1ss["id"] . '" name="mat_zz[' . $i . '][commun_text]" class="di text_area_otziv no_comment_bill22_2 tyyo1 
 ">'.$row_work_zz["commet"].'</textarea>';

    $task_cloud_block .= '</div>      
</div>  

        <script type="text/javascript"> 
	  $(function (){ 
$(\'#otziv_chat1_' . $row1ss["id"] . '\').autoResize({extraSpace : 10});
//$(\'.tyyo1' . +$row1ss["id"] . '\').trigger(\'keyup\');
$(\'.tyyo1\').trigger(\'keyup\');
});

	</script>
	';
    $task_cloud_block .= '</div></div><div class="rate-button1"><div class="js-ok-rate-chat-left">ОК</div></div></div>';

}

                     echo($task_cloud_block);






                  echo'<div class="nm"><span class="s_j '.$class_dava.'">'. $row1ss["material"].'</span>'.$dava.'</div>';

echo'<div class="commun">'.$row_work_zz["commet"].'</div>';
echo'<input type=hidden class="commun_hide" value="'.$val_commun.'" name="mat_zz['.$i.'][commun]">';
echo'<input type=hidden value="'.$row_work_zz["id"].'" name="mat_zz['.$i.'][id]"><input type=hidden class="hidden_max_count" value="" name="mat_zz['.$i.'][max_count]">';
					 
				             //вдруг товар уже связан с каким то товаром на складе выводим его название на складе
					 if($row1ss["id_stock"]!='')
					 {
					 //$result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row1ss["id_stock"].'"');

                     $result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row_work_zz["id_stock"].'"');
			        $num_results_t1__341 = $result_t1__341->num_rows;
	                if($num_results_t1__341!=0)
	                {  
		              $row1ss__341 = mysqli_fetch_assoc($result_t1__341);
					  echo'<span data-tooltip="название товара на складе" class="stock_name_mat">'.$row1ss__341["name"].'</span>';
					} else
					{
					   echo'<span class="stock_name_mat">не связан с товаром на складе</span>';	
					}
					 } else
					{
					   echo'<span class="stock_name_mat">не связан с товаром на складе</span>';	
					}
					 
					 
					 
					 echo'</td>
<td class="pre-wrap center_text_td">'. $row1ss["units"].'';
					 //вдруг товар уже связан с каким то товаром на складе выводим его единицу измерения на складе
					 if(($row1ss["id_stock"]!='')and($num_results_t1__341!=0))
					 {
						echo'<br><span data-tooltip="единица измерения товара на складе" class="stock_unit_mat">'.$row1ss__341["units"].'</span>'; 
					 }
					 
echo'</td>
<td>';
					 
$os = array("3", "1", "8", "5", "4");
if (in_array($row_list["status"], $os)) 
{ 		
echo'<div class="width-setter"><label>MAX('.$ostatok.')</label><input style="margin-top:0px;" '.$status_edit.' all="'.$row1ss["count_units"].'" name="mat_zz['.$i.'][count]" max="'.$ostatok.'" placeholder="MAX - '.$ostatok.'" class="input_f_1 input_100 white_inp label_s count_app_mater_ '.iclass_($row1ss["id"].'_w_count',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['mat_zz'][$i]["count"],$row_work_zz["count_units"]).'"></div>';
					 
} else
{
echo'<div class="width-setter"><input style="margin-top:0px;" '.$status_edit.' name="mat_zz['.$i.'][count]"  class="input_f_1 input_100 white_inp label_s count_app_mater_ '.iclass_($row1ss["id"].'_w_count',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['mat_zz'][$i]["count"],$row_work_zz["count_units"]).'"></div>';	
}

$z_stock_dd='';
if($z_stock_count_doc!=0){
	$z_stock_dd=' / <span data-tooltip="в заявках" class="yest_sklad">'.$z_stock_count_doc.'</span>';
}					 
					 
echo'</td>';
if($td_sklad==1)
{					 
echo'<td>
<div class="skladd_nei"><span class="yest_sklad" data-tooltip="на складе">'.$z_stock_count_sklad.'</span> / <span data-tooltip="на работниках" class="yest_users">'.$z_stock_count_users.'</span>'.$z_stock_dd.'<i>a</i>

<div class="sklad_plus_uss">';
if($sklad_name!='')
{
echo'<div>'.$sklad_name.'<br><span>'.$z_stock_count_sklad.'</span></div>';
}
					 
$result_t1_=mysql_time_query($link,'SELECT b.name_user, sum(a.count_units) as summ FROM z_stock_material AS a,r_user as b WHERE b.id=a.id_user and 
a.id_object="'.$row_list["id_object"].'" AND a.id_stock="'.$row1ss["id_stock"].'" '.$text_stock.' group by b.id');
					 
					 	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		           for ($ksss=0; $ksss<$num_results_t1_; $ksss++)
                   {   
					 
					  //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  echo'<div>'.$row1ss_["name_user"].'<br><span class="ctrrr">'.$row1ss_["summ"].'</span></div>';
				   }
				 }
echo'</div>
</div>';
echo'</td>';
}

echo'<td>';

					 
					 
		echo'<div class="_50_x">';
		   echo'<div class="input-width m10_right" style="position:relative; margin-right: 0px;">';
		    
		    echo'<input id="date_hidden_table" class="date_r_base" name="mat_zz['.$i.'][date_base]" value="'.ipost_($_POST['mat_zz'][$i]["date_base"],$row_work_zz["date_delivery"]).'" type="hidden">';
			
			if(!is_numeric(strtotime($row_work_zz["date_delivery"])))
			{
			echo'<input readonly="true" id_rel="'.$row1ss["id"].'" '.$status_edit1.' style="margin-top:0px;" name="mat_zz['.$i.'][date]" value="'.ipost_($_POST['mat_zz'][$i]["date"],"").'" class="input_f_1 input_100 calendar_t white_inp calendar_zay '.iclass_($row1ss["id"].'_w_date',$stack_error,"error_formi").' '.$status_class.'" placeholder="Дата поставки"  autocomplete="off" type="text"><i class="icon_cal cal_223 cal_zayva"></i></div></div>';				
			} else
			{
					 
			echo'<input readonly="true" id_rel="'.$row1ss["id"].'" '.$status_edit1.' style="margin-top:0px;" name="mat_zz['.$i.'][date]" value="'.ipost_($_POST['mat_zz'][$i]["date"],date_fik($row_work_zz["date_delivery"])).'" class="input_f_1 input_100 calendar_t white_inp calendar_zay '.iclass_($row1ss["id"].'_w_date',$stack_error,"error_formi").' '.$status_class.'" placeholder="Дата поставки"  autocomplete="off" type="text"><i class="icon_cal cal_223 cal_zayva"></i></div></div>';
			}
		//echo'<div class="pad10" style="padding: 0;"><span id_rel="'.$row1ss["id"].'" class="bookingBox"></span></div>';
					 
					 
					 
echo'</td>';
if($td_status==1)
{					 
echo'<td>';
//вывод статуса по материалу
$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row_work_zz["status"].'" and a.id_system=13');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	if($row_work_zz["status"]==10)
	{
       echo'<div class="status_material1">'.$row_status["name_status"].'</div><div class="user_mat naryd_yes"></div>';	
	} else
	{
		echo'<div style="margin-right: 20px;" class="status_materialz status_z'.$row_work_zz["status"].'">'.$row_status["name_status"].'</div>';
		if($row_work_zz["status"]==14)
		{
		//если статус оплачено
		//выводим доп информацию какое количество и когда примерно ждать
		$result_book=mysql_time_query($link,'SELECT b.*,a.delivery_day,a.date_paid,c.id_stock FROM z_acc as a,z_doc_material_acc as b,z_doc_material as c WHERE b.id_acc=a.id and a.status=4 and b.id_doc_material=c.id and b.id_doc_material="'.$row_work_zz["id"].'"');	
		$num_results_book = $result_book->num_rows;
	    if($num_results_book!=0)
	    {
	
		   for ($srs=0; $srs<$num_results_book; $srs++)
		   {			   			  			   
			   $row_book = mysqli_fetch_assoc($result_book);
			   
			   		$date_delivery=date_step($row_book["date_paid"],$row_book["delivery_day"]);	
			   
		$date_graf2  = explode("-",$date_delivery);	
			   
			   
			   //узнаем единицу измерения на складе
$result_t1_1=mysql_time_query($link,'SELECT b.units FROM z_stock as b WHERE b.id="'.$row_book["id_stock"].'"');
					 
			     $num_results_t1_1 = $result_t1_1->num_rows;
	             if($num_results_t1_1!=0)
	             {  
		              //такая работа есть
		              $row1ss_1 = mysqli_fetch_assoc($result_t1_1);
				 }
			   
			   
			   //подсвечиваем красным за 2 дня до доставки
			   $date_delivery1=date_step($row_book["date_paid"],($row_book["delivery_day"]-2));	
			   
			   
			   $style_book='';
			   if(dateDiff_1(date("y-m-d").' '.date("H:i:s"),$date_delivery1.' 00:00:00')>=0)
			   {
				   $style_book='reddecision1';
			   }
			   
			   
			   echo'<span class="dop_status_app '.$style_book.'">'.$row_book["count_material"].' '.$row1ss_1["units"].' ~ до '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</span><br>';
		   }
		}
			
			
			
		} 
	}
}
					 
					 
echo'</td>';
}
if($td_dell==1)
{	
echo'<td class="zay_2020">';
if($podpis==1)		
{
echo'<div data-tooltip="удалить материал из заявки" class="font-rank del_material_zayva1" zayu="'.$_GET['id'].'" id_rel="'.$row_work_zz["id"].'"><span class="font-rank-inner zayva_del_naf">x</span></div>';
}
echo'</td>';
}
          echo' </tr>';			
	
		//поля необходимые для вывода даты поставки календаря
		//если редактировать нельзя дату то и не выводить	
if($podpis==1)		
{					 
	echo'<tr works="'.$row1ss["id_razdel2"].'" mat_zz="'.$row1ss["id"].'" class="loader_tr" style="height:0px;"><td colspan="2"></td><td colspan="'.$count_td_table_datepiker1.'">';
	echo'<div class="pad10" style="padding: 0;"><span id_rel="'.$row1ss["id"].'" class="bookingBox"></span></div>';				 
	echo'</td><td colspan="'.$count_td_table_datepiker2.'"></td></tr>';	
}
					 
					 
		//служебная записка по материалу			
	 echo'<tr works="'.$row1ss["id_razdel2"].'" mat_zz="'.$row1ss["id"].'" class="loader_tr" style="height:0px;"><td colspan="'.$count_td_table.'">';
	 if($row_work_zz["memorandum"]!='')
	 {
	 echo'<div class="messa" style="display:block;" id_mes="'.$row1ss["id"].'"><span class="hs">';
	 } else
	 {
	echo'<div class="messa" id_mes="'.$row1ss["id"].'"><span class="hs">';	 
	 }
	if($podpis==0)		
    {
	   echo'Cлужебная записка'; 
	} else
	{
	   echo'Оформление служебной записки';
	}
					 
					 
	if((($status_user_zay[1]!=1)and($sign_admin!=1))or(($status_user_zay[1]==1)and($row_list["status"]!=3)))
	{

	  //для прорабов и начальникам участка выводим просто статус служебных записок	
	  if(($row_work_zz["signedd_mem"]==1)and($row_work_zz["id_sign_mem"]!=0)and($row_work_zz["id_sign_mem"]!=''))
	  {		
		  
		$result_txsss=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row_work_zz["id_sign_mem"])).'"');
      
	    if($result_txsss->num_rows!=0)
	    {   
		//такая работа есть
		$rowxsss = mysqli_fetch_assoc($result_txsss);
		}
		  
		  
		echo'<span style="visibility:visible" class="edit_12"><i data-tooltip="Подписана - '.$rowxsss["name_user"].'">S</i></span>';
		
	  }
	  if(($row_work_zz["signedd_mem"]==0)and($row_work_zz["id_sign_mem"]!=0)and($row_work_zz["id_sign_mem"]!=''))
	  {		
		$result_txsss=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row_work_zz["id_sign_mem"])).'"');
      
	    if($result_txsss->num_rows!=0)
	    {   
		//такая работа есть
		$rowxsss = mysqli_fetch_assoc($result_txsss);
		}
		  
		  
		  
		echo'<span style="visibility:visible" class="edit_12"><i style="color:#ff2828; font-size: 21px;" data-tooltip="Отказано - '.$rowxsss["name_user"].'">5</i></span>';
		
	  }		
	}				 
	
	//если это пользователь который в праве отвечать на служебные записки				 
	if(($status_user_zay[1]==1)and($row_list["status"]==3))
	{
		//echo("!!!");
			  $decision=-1;	
	  if(($row_work_zz["signedd_mem"]==0)and(($row_work_zz["id_sign_mem"]==0)or($row_work_zz["id_sign_mem"]=='')))
	  {		
		//решения пока нет  
		echo'<span class="edit_123 '.$readyonly.'"><i class="yes"  for_s="w" for="'.$row_work_zz["id"].'" data-tooltip="Согласовать">S</i><i class="no"  for_s="w" for="'.$row_work_zz["id"].'" data-tooltip="Отказать">5</i></span>'; 
		$decision=-1;  
	  }
	  if(($row_work_zz["signedd_mem"]==0)and(($row_work_zz["id_sign_mem"]!=0)and($row_work_zz["id_sign_mem"]!='')))
	  {		
		//отказано 
		echo'<span class="edit_123 '.$readyonly.'"><i class="yes"  for_s="w" for="'.$row_work_zz["id"].'" data-tooltip="Согласовать">S</i><i class="no active"  for_s="w" for="'.$row_work_zz["id"].'"  data-tooltip="Отказать">5</i></span>'; 
		$decision=0;  
	  }	
	  if(($row_work_zz["signedd_mem"]==1)and(($row_work_zz["id_sign_mem"]!=0)and($row_work_zz["id_sign_mem"]!='')))
	  {		
		//согласовано 
		echo'<span class="edit_123 '.$readyonly.'"><i class="yes active" for_s="w" for="'.$row_work_zz["id"].'" data-tooltip="Согласовать">S</i><i class="no"  for_s="w" for="'.$row_work_zz["id"].'"  data-tooltip="Отказать">5</i></span>'; 
		$decision=1;  
	  }	
	if(($status_user_zay[1]==1)and($row_list["status"]==3))
	{	
	  echo'<input class="decision_mes" name="mat_zz['.$i.'][decision]" value="'.$decision.'" type="hidden">';
	}
	}
					 
					 
					 
	 echo'<div></div></span>';
	 

echo'<div class="width-setter mess_slu"><input style="margin-top:0px;" '.$status_edit.' name="mat_zz['.$i.'][text]"  placeholder="Напиши руководству причину превышения параметров относительно запланированной" class="input_f_1 input_100 white_inp label_s text_zayva_message_ '.iclass_($row1ss["id"].'_w_text',$stack_error,"error_formi").' '.$status_class.'" autocomplete="off" type="text" value="'.ipost_($_POST['mat_zz'][$i]["text"],$row_work_zz["memorandum"]).'"></div>';								
							
							
	 echo'</div>
	 </td></tr>';
				 						
							
							
						
					 

					 
					 
					 

					 
					 
					 
				 }
		   }
		?>
	  
	      
	<script type="text/javascript" src="Js/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="Js/jquery.datepicker.extension.range.min.js"></script>
<script type="text/javascript">var disabledDays = [];
$(function() {
$(".calendar_zay").each(function(){	
$(this).datepicker({	
          //  $(".calendar_zay").datepicker({ 
altField:$(this).prev(),
altFormat:'yy-mm-dd',
defaultDate:null,
beforeShowDay: disableAllTheseDays,
dateFormat: "d MM yy"+' г.', 
firstDay: 1,
minDate: "0", maxDate: "+1Y",
beforeShow:function(textbox, instance){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 0,
                left: 0
            });
        }, 10);
	
	var id_rel=$(textbox).attr('id_rel');
	//alert(id_rel);
	
    $('.bookingBox[id_rel='+id_rel+']').append($('#ui-datepicker-div'));
    $('#ui-datepicker-div').hide();
} });
	 
	 	 
//$('#date_table1').datepicker('setDate', ['+1d', '+30d']);
});
});	 


	 
function resizeDatepicker() {
    setTimeout(function() { $('.bookingBox > .ui-datepicker').width('100%'); }, 10);
}	 


	 

            </script>			  
		  
		 
	<?	  
		   if($rrtt>0){ echo'</tbody></table>'; echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_0").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>'; }
		 
		  //запускаем загрузку лодеров выполенных работ
		  //делаем пересчет суммы и итоговой
		  //выводим служебные записки где нужно
		  

		     echo'<script>
				  $(function (){  $(\'.count_app_mater_\').change();  
				  
				  ';
		   if($visible_gray==0)
           {
               echo'$(\'.tabs_005U[id=1]\').trigger(\'click\');';

               }



            echo'});
				  </script>';
		  
		  
	  }
					 
	

	  
	  if($rrtt==0)
	  {
		  echo'Выберите сначала нужные материалы для оформления заявки';		  
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
</div></div></div></div></div></div>
<?
include_once $url_system.'template/left.php';
?>

</div>
</div><script src="Js/rem.js" type="text/javascript"></script>
<?
echo'<script type="text/javascript">var b_co=\''.$b_co.'\'</script>';
echo'<script type="text/javascript">var b_cm=\''.$b_cm.'\'</script>';
?>
<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
	
</div>

</body></html>