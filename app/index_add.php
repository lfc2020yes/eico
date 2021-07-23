<?
session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; include_once $url_system.'module/config.php'; include_once $url_system.'module/function.php'; include_once $url_system.'login/function_users.php'; initiate($link); include_once $url_system.'module/access.php';


$active_menu='app';


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

//проверим можно редактировать или нет цены в наряде


if((isset($_POST['save_naryad']))and($_POST['save_naryad']==1))
{
	$token=htmlspecialchars($_POST['tk']);
	$id=htmlspecialchars($_GET['id']);
	
	//токен доступен в течении 120 минут
	if(token_access_yes($token,'add_mat_zay_x',$id,120))
    {
		//echo("!");
	//возможно проверка что этот пользователь это может делать
	 if (($role->permission('Заявки','A'))or($sign_admin==1))
	 {	
	
	$stack_memorandum = array();  // общий массив ошибок
	$stack_error = array();  // общий массив ошибок
	$error_count=0;  //0 - ошибок для сохранения нет
	$flag_podpis=0;  //0 - все заполнено можно подписывать

         if(trim($_POST['name_b'])=='')
         {
             array_push($stack_error, "name_b");

         }


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
				
				
				$result_tx=mysql_time_query($link,'Select a.*,c.id_object from i_material as a,i_razdel1 as c,i_razdel2 as b where a.id_razdel2=b.id and b.id_razdel1=c.id and a.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такой материал есть
		           $rowx = mysqli_fetch_assoc($result_tx);
					
				   //проверяем что материал относится к нужному объекту
					if($rowx["id_object"]!=$_GET['id'])
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
				   //echo($count_sys.'!');
					$stock=new stock_user($link,htmlspecialchars($_GET['id'])); 
				   $z_stock_count_users=0;	//на складе на всех прорабах по этому объекту числится
				 if(($rowx["id_stock"]!='')and($rowx["id_stock"]!=0))
				 {	
					 $text_stock='';
					 if($stock->id_stock>0)
					 {
					 $text_stock=' and not(a.id_user="'.htmlspecialchars(trim($stock->id_stock)).'")';
					 }
				    $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE
a.id_object="'.htmlspecialchars(trim($_GET['id'])).'" AND a.id_stock="'.$rowx["id_stock"].'" '.$text_stock.'');
						             	 
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
				//echo($z_stock_count_users);	
					
					
//***************************************************************************************************************************		
                //вдруг он до этого сделал заявку и она в статусе не откланено и не сохранено
				$z_stock_count_doc=0;	 
				$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.id_object="'.htmlspecialchars(trim($_GET['id'])).'" and  
a.id_i_material="'.htmlspecialchars(trim($rowx["id"])).'"  AND a.status NOT IN ("1","8","10","3","5","4")');
					 
					 	             	 
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
				//echo($z_stock_count_doc);	 
//***************************************************************************************************************************					
					
					
					
					
					
					$count_sys=$count_sys-$z_stock_count_users-$z_stock_count_doc;
					
				   
					//echo($count_sys);
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
				$result_tx=mysql_time_query($link,'Select a.* from i_material as a where a.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такая работа есть
		           $rowx = mysqli_fetch_assoc($result_tx);
				   
				   if($count_work==0)	
				   {		
                     $id_user=id_key_crypt_encrypt(htmlspecialchars(trim($_SESSION['user_id'])));
					 				   
					   
					 $numer=get_numer_doc(&$link,htmlspecialchars(trim(date("Y-m-d"))),1);					   
					 $dateTime = new DateTime("now"); 
                     $timestamp=$dateTime->format('U');
					  // echo($timestamp);
					 //добавляем неподписанный наряд  
				     mysql_time_query($link,'INSERT INTO z_doc (id,name,number,date,date_create,id_user,status,id_object) VALUES ("","'.ht($_POST['name_b']).'","'.$numer.'","'.$today[0].'","'.$date_.'","'.$id_user.'","1","'.htmlspecialchars(trim($_GET['id'])).'")');
			
					   
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
	/*				
id                 int(10) unsigned  (NULL)           NO      PRI     (NULL)   auto_increment  select,insert,update,references           
id_doc             int(10) unsigned  (NULL)           YES             (NULL)                   select,insert,update,references           
id_i_material      int(10) unsigned  (NULL)           YES             (NULL)                   select,insert,update,references           
id_stock           int(10) unsigned  (NULL)           YES             (NULL)                   select,insert,update,references           
id_object          int(10) unsigned  (NULL)           YES             (NULL)                   select,insert,update,references           
count_units        double unsigned   (NULL)           YES             (NULL)                   select,insert,update,references           
date_delivery      date              (NULL)           YES             (NULL)                   select,insert,update,references           
id_group_material  int(10) unsigned  (NULL)           YES             (NULL)                   select,insert,update,references           
status             int(11)           (NULL)           YES             (NULL)                   select,insert,update,references           
memorandum         text              utf8_general_ci  YES             (NULL)                   select,insert,update,references           
id_sign_mem        int(10) unsigned  (NULL)           YES             (NULL)                   select,insert,update,references           
signedd_mem        tinyint(1)        (NULL)           YES             (NULL)                   select,insert,update,references           
*/
				  			
				  //добавляем материал к заявке
				  mysql_time_query($link,'INSERT INTO z_doc_material (id,id_doc,id_i_material,id_stock,id_object,count_units,date_delivery,status,memorandum,id_sign_mem,signedd_mem) VALUES ("","'.$ID_N.'","'.htmlspecialchars(trim($value['id'])).'","'.htmlspecialchars(trim($rowx['id_stock'])).'","'.htmlspecialchars(trim($_GET['id'])).'","'.htmlspecialchars(trim($value['count'])).'","'.htmlspecialchars(trim($value['date_base'])).'","1","'.$memo.'","0","0")');	
				  
					
				  //$ID_W=mysqli_insert_id($link); 

				   //изменяем статус наряда в зависимости от заполнения
					
				   $status_nariad=0;
				   if($flag_podpis==0){ $status_nariad=1; }
				   //if($count_memo!=0){ $status_nariad=-1; }
				   mysql_time_query($link,'update z_doc set ready="'.$status_nariad.'" where id = "'.htmlspecialchars(trim($ID_N)).'"');
					
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
					
				  $text_not='<strong>'.$name_user.'</strong> создана новая <a href="app/'.$ID_N.'/">заява на материал №'.$ID_N.'</a>, по объекту -  '.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';	
				  
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
			 
			 setcookie("basket1_".$id_user."_".htmlspecialchars($_GET['id']), "", time()-3600,"/", ".eico.atsun.ru", false, false);
			
			//echo($flag_podpis);
			/*
			 if($flag_podpis==0)
			 {
			   //можно предложить сразу подписать его
			   header("Location:".$base_usr."/app/".$ID_N.'/');	
			   die();				 
			 } else
			 {		 
			    header("Location:".$base_usr."/app/");	
			    die();
			 }*/
            header("Location:".$base_usr."/app/".$ID_N.'/');
            die();


        }
	
				/* if((isset($value['count']))and(is_numeric($value['count']))and(isset($value['price']))and(is_numeric($value['price']))and(isset($value['ed']))and(trim($value["ed"])!='')and(isset($value['name']))and(trim($value["name"])!='')) 
		         {
*/
}

}
	
	
}



$secret=rand_string_string(4);
$_SESSION['s_t'] = $secret;	



//89084835233

//проверить и перейти к последней себестоимости в которой был пользователь

$b_co='basket_'.$id_user;
$b_cm='basket1_'.$id_user;
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
			if(!isset($_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]))
			{
			    header("Location:".$base_usr);	
			    die();
			} else
			{
				//проверим может пользователь вообще не может добавлять новые заявки
				if (($role->permission('Заявки','A'))or($sign_admin==1))
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

if($error_header!=404){ SEO('app_add','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_app_add.php';

	?>
      <div id="fullpage" class="margin_60  input-block-2020 ">
          <div class="section" id="section0">
              <div class="height_100vh">
                  <div class="oka_block_2019">

                      <?
                      echo'<div class="line_mobile_blue">Оформление заявки на материалы';
                      $D = explode('.', $_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);

if(count($D)>0)
{
  echo'<span all="8" class="menu-mobile-count">'.count($D).'</span>';
}

echo'</div>';

                      ?>
                      <div class="div_ook" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                          <div class="info-suit">
<form class="js-add-app-material" id="lalala_add_form" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
 <input name="save_naryad" value="1" type="hidden">
    <?


    echo'<!--input start-->
<div class="margin-input"><div class="input_2018 input_2018_resize  gray-color '.iclass_("name_b",$stack_error,"required_in_2018").'"><label><i>Название заявки</i><span>*</span></label><div class="otziv_add js-resize-block"><textarea cols="10" rows="1" name="name_b" class="di gloab input_new_2018  text_area_otziv js-autoResize ">'.ipost_($_POST['name_b'],"").'</textarea></div><div class="div_new_2018"><div class="error-message"></div></div></div></div>
<!--input end	-->';


    echo'<span class="h3-f">Список материалов <span class="pol-card" >'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</span></span>';
/*
	
    echo'<div class="content_block1" id_content="'.$id_user.'">';

//print_r($stack_error);

//echo'<h3 style=" margin-bottom:0px;">Добавление наряда<div></div></h3>';
echo'<div class="comme" >'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</div>';	  
	
	  
	  
	  $rrtt=0;
	  

	  
	  
	  
	  
	  
	  echo'</div>';
	  */






    echo'<div class="content_block block_primes1">';
	
					 
	//echo($_COOKIE["basket_".htmlspecialchars(trim($_GET['id']))]);	
	  //определяем совхоза по объекту
	  $stock=new stock_user($link,htmlspecialchars($_GET['id'])); 
	
	
	  if (( isset($_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]))and($_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]!=''))
	  {
	       $D = explode('.', $_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);
		  $id_work=0;
           for ($i=0; $i<count($D); $i++)
		   {
	             //проверим может вообще такого материала уже нет
			     $result_t1=mysql_time_query($link,'Select a.* from i_material as a where a.id="'.htmlspecialchars(trim($D[$i])).'"');
                 $num_results_t1 = $result_t1->num_rows;
	             if($num_results_t1!=0)
	             {  
		            //такая работа есть
		            $row1ss = mysqli_fetch_assoc($result_t1);
					 
					 
					 
					 
					$rrtt++;
					if($rrtt==1)
					{
		$token=token_access_compile($_GET['id'],'add_mat_zay_x',$secret);				
						
						echo'<input type="hidden" value="'.$token.'" name="tk">'; 
						
						
						//заголовок таблицы
						
						 echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_0" class="smeta1"><thead>
		   <tr class="title_smeta"><th class="t_2 no_padding_left_ jk4">Наименование</th>';
						
						//<th class="t_3">статус</th>
							
							echo'<th class="t_4 jk44">ед. изм.</th><th class="t_5">кол-во</th><th class="t_55">Склад</th><th class="t_6">дата поставки</th><th class="t_10 jk6"></th></tr></thead><tbody>';
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
				echo'<tr work="'.$row1ss["id_razdel2"].'" class="loader_tr" style="height:20px;"><td colspan="6"><input class="count_workssss" value="1" name="mat_zz['.$i.'][count_mat]" type="hidden"></td></tr>';
				//	}
					
					
					 
					 
				 $summ=0;
                 $ostatok=0;
                 $proc_view=0;	
				 $flag_history=0;
			    
					
				
					

					
					echo'<tr work="'.$row1ss["id_razdel2"].'" style="background-color:#f0f4f6;" class="jop work__s" id_trr="'.$i.'" rel_id="'.$row1ss["id_razdel2"].'">
                  <td colspan="6" class="no_padding_left_ pre-wrap one_td"><span class="s_j">'.$row1ss__34["razdel1"].'.'.$row1ss__34["razdel2"].' '.$row1ss__34["name_working"];
					
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
a.id_object="'.htmlspecialchars(trim($_GET['id'])).'" AND a.id_stock="'.$row1ss["id_stock"].'" '.$text_stock.'');
						             	 
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
					 //echo($z_stock_count_users);
//***************************************************************************************************************************					
                $z_stock_count_sklad=0;	//на складе на каком то, где то по этому объекту числится
					$sklad_name='';
				
                if(($stock->id_stock>0)and($row1ss["id_stock"]!=0)and($row1ss["id_stock"]!=''))
				{
				   $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ,b.name_user FROM z_stock_material AS a,r_user as b WHERE a.id_user=b.id and 
a.id_user="'.htmlspecialchars(trim($stock->id_stock)).'"  AND a.id_stock="'.$row1ss["id_stock"].'"');
					 	             	 
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
				$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.id_object="'.htmlspecialchars(trim($_GET['id'])).'" and  
a.id_i_material="'.htmlspecialchars(trim($D[$i])).'"  AND a.status NOT IN ("1","8","10","3","5","4")');
					 
					 	             	 
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
					 //echo($z_stock_count_doc);
//***************************************************************************************************************************		
					 
					 $ostatok=$row1ss["count_units"]-$row1ss["count_realiz"]-$z_stock_count_users-$z_stock_count_doc;
					 //echo($ostatok);
					
					 if($ostatok<0)
				     {
					     $ostatok=0;
					 }
					 $proc_view=round((($row1ss["count_units"]-$ostatok)*100)/$row1ss["count_units"]); 
					 					
					
				 
					 
					 
							  //линия сколько товара уже заказано и есть
					echo'<tr works="'.$row1ss["id_razdel2"].'"  mat_zz="'.$row1ss["id"].'" class="loader_tr"><td colspan="6"><div class="loaderr"><div id_loader="'.$row1ss["id"].'" class="teps" rel_w="'.$proc_view.'" style="width:0%"><div class="peg_div"><div><i class="peg"></i></div></div></div></div></td></tr>';

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
                  <td colspan="1" class="no_padding_left_ pre-wrap one_td"><div class="nm"><span class="s_j '.$class_dava.'">'. $row1ss["material"].'</span>'. $dava.'</div><input type=hidden value="'.$row1ss["id"].'" name="mat_zz['.$i.'][id]"><input type=hidden class="hidden_max_count" value="" name="mat_zz['.$i.'][max_count]">';
					 
				             //вдруг товар уже связан с каким то товаром на складе выводим его название на складе
					 if($row1ss["id_stock"]!='')
					 {
					 $result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row1ss["id_stock"].'"'); 
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
							
echo'<div class="width-setter"><label>MAX('.$ostatok.')</label><input style="margin-top:0px;" all="'.$row1ss["count_units"].'" name="mat_zz['.$i.'][count]" max="'.$ostatok.'" placeholder="MAX - '.$ostatok.'" class="input_f_1 input_100 white_inp label_s count_app_mater_ '.iclass_($row1ss["id"].'_w_count',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['mat_zz'][$i]["count"],"").'"></div>';
				 
$z_stock_dd='';
if($z_stock_count_doc!=0){
	$z_stock_dd=' / <span data-tooltip="в заявках" class="yest_sklad">'.$z_stock_count_doc.'</span>';
}					 
					 
echo'</td>
<td>
<div class="skladd_nei"><span class="yest_sklad" data-tooltip="на складе">'.$z_stock_count_sklad.'</span> / <span data-tooltip="на работниках" class="yest_users">'.$z_stock_count_users.'</span>'.$z_stock_dd.'<i>a</i>

<div class="sklad_plus_uss">';
if($sklad_name!='')
{
echo'<div>'.$sklad_name.'<br><span>'.$z_stock_count_sklad.'</span></div>';
}
					 
$result_t1_=mysql_time_query($link,'SELECT b.name_user, sum(a.count_units) as summ FROM z_stock_material AS a,r_user as b WHERE b.id=a.id_user and 
a.id_object="'.htmlspecialchars(trim($_GET['id'])).'" AND a.id_stock="'.$row1ss["id_stock"].'" '.$text_stock.' group by b.id');
					 
					 	             	 
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
echo'</td>

<td>';

					 
					 
		echo'<div class="_50_x">';
		   echo'<div class="input-width m10_right" style="position:relative; margin-right: 0px;">';
		    
		    echo'<input id="date_hidden_table" class="date_r_base" name="mat_zz['.$i.'][date_base]" value="'.ipost_($_POST['mat_zz'][$i]["date_base"],"").'" type="hidden">';
			
			echo'<input readonly="true" id_rel="'.$row1ss["id"].'" style="margin-top:0px;" name="mat_zz['.$i.'][date]" value="'.ipost_($_POST['mat_zz'][$i]["date"],"").'" class="input_f_1 input_100 calendar_t white_inp calendar_zay '.iclass_($row1ss["id"].'_w_date',$stack_error,"error_formi").'" placeholder="Дата поставки"  autocomplete="off" type="text"><i class="icon_cal cal_223 cal_zayva"></i></div></div>';
		
		//echo'<div class="pad10" style="padding: 0;"><span id_rel="'.$row1ss["id"].'" class="bookingBox"></span></div>';
					 
					 
					 
echo'</td>

<td><div data-tooltip="удалить материал из заявки" class="font-rank del_material_zayva" naryd="'.$_GET['id'].'" id_rel="'.$row1ss["id"].'"><span class="font-rank-inner">x</span></div></td>
           </tr>';			
					
	echo'<tr works="'.$row1ss["id_razdel2"].'" mat_zz="'.$row1ss["id"].'" class="loader_tr" style="height:0px;"><td colspan="2"></td><td colspan="3">';
	echo'<div class="pad10" style="padding: 0;"><span id_rel="'.$row1ss["id"].'" class="bookingBox"></span></div>';				 
	echo'</td><td colspan="1"></td></tr>';				 
					 
		//служебная записка по материалу			
	 echo'<tr works="'.$row1ss["id_razdel2"].'" mat_zz="'.$row1ss["id"].'" class="loader_tr" style="height:0px;"><td colspan="6">
	 <div class="messa" id_mes="'.$row1ss["id"].'">
	 <span class="hs">Оформление служебной записки<div></div></span>';
	 
/*echo'<div class="div_textarea_otziv div_text_glo '.iclass_($row_mat["id"].'_m_text',$stack_error,"error_formi").'" style="margin-top:15px;">
			<div class="otziv_add">
          <textarea placeholder="Напиши руководству причину привышения параметров по этой работе относительно запланированной себестоимости" cols="40" rows="1" id="otziv_area_'.$i.'" name="works['.$i.'][mat]['.$mat.'][text]" class="di text_area_otziv">'.ipost_($_POST['works'][$i]["mat"][$mat]["text"],"").'</textarea>
		  
        </div></div>';
*/
echo'<div class="width-setter mess_slu"><input style="margin-top:0px;" name="mat_zz['.$i.'][text]"  placeholder="Напиши руководству причину превышения параметров относительно запланированной" class="input_f_1 input_100 white_inp label_s text_zayva_message_ '.iclass_($row1ss["id"].'_w_text',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['mat_zz'][$i]["text"],"").'"></div>';								
							
							
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
		  
		  if((isset($_POST['save_naryad']))and($_POST['save_naryad']==1))
          {
	
		     echo'<script>
				  $(function (){  $(\'.count_app_mater_\').change();  });
				  </script>';
		  
		  }
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
                  </div></div></div></div></div></div></div>
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

<script type="text/javascript">
    $(function() {
        Zindex();
        AutoResizeT();
    });
</script>
<?
//include_once $url_system.'template/form_js.php';
?>