<?
//заказать для прорабов которые заполнили всю заявки на материал без служебок
//заказать для инженеров ПТО которые приняли служебку и заказали

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



//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /finery/plus/28/
//     0   1     2  3
$error=0;
$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);


$echo_r=1; //выводить или нет ошибку 0 -нет

//**************************************************
if ( count($_GET) != 1 ) 
{
   header404(1,$echo_r);		
}
//**************************************************
if($D_404[4]!='')
{		
    header404(2,$echo_r);		  	  
}
//**************************************************
if(!isset($_GET["id"]))
{
    header404(3,$echo_r);		
}
//**************************************************

$token=htmlspecialchars($_POST['tk_sign']);
$id=htmlspecialchars($_GET['id']);
	
//if(!token_access_yes($token,'sign_app_order',$id,120))
if(!token_access_new($token,'sign_tender_order',$id,"rema",120)) {
    header404(4, $echo_r);
}
//**************************************************
$result_url=mysql_time_query($link,'select A.* from z_tender as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_custom_url = $result_url->num_rows;
if($num_results_custom_url==0)
{
     header404(6,$echo_r);
} else
{	
	$row_list = mysqli_fetch_assoc($result_url);
}
//**************************************************

if(($row_list["status"]!=1)and($row_list["status"]!=3)and($row_list["status"]!=8))
{	
	header404(7,$echo_r);
}
//**************************************************



$status_user_zay=array("0","0"); //по умолчанию это никто
if((($row_list["id_user"]==$id_user)and($role->permission('Тендеры','A')))or($sign_admin==1))
{
    $status_user_zay[0]=1;
}

/*
if((($role->permission('Заявки','S'))and(array_search($row_list["id_user"],$hie_user)!==false)and($row_list["id_user"]!=$id_user))or($sign_admin==1))
{
    $status_user_zay[1]=1;
}
*/

//**************************************************	
if(($status_user_zay[0]==0)and($status_user_zay[1]==0))
{
	header404(8,$echo_r);
}


include_once '../ilib/lib_interstroi.php';
include_once '../ilib/lib_edo.php';


$edo = new EDO($link,$id_user,false);

$restart=false;
if(($row_list["id_edo_run"]!='')and($row_list["id_edo_run"]!=0))
{
    //значит ему возвращали уже и это просто пересоглашение
    $restart=true;
}
//echo($next_edo);


if ($edo->next($id, 4,0,$restart)===false) {
//echo("!");
    //id_executor
    mysql_time_query($link,'update z_tender set status="9" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');


//echo(gettype($edo->arr_task));
    foreach ($edo->arr_task as $key => $value)
    {
        //оправляем всем уведомления кому нужно рассмотреть этот документ далее


				$user_send_new= array();
                //уведомление
               array_push($user_send_new, $value["id_executor"]);

               $name_c='';
        $result_uu = mysql_time_query($link, 'select * from z_tender_place where id="' . ht($row_list['id_z_tender_place']) . '"');
        $num_results_uu = $result_uu->num_rows;

        if ($num_results_uu != 0) {
            $row_uud = mysqli_fetch_assoc($result_uu);
            $name_c='Площадка - '.$row_uud["name"];
        }

        $text_not='Вам поступила задача по тендеру <a class="link-history" href="tender/'.$row_list['id'].'/">'.$row_list['name'].'</a>. '.$name_c.' '.$value["description"];

               //$text_not='Поступила <strong>новая заявка на материал №'.$row_list['number'].'</strong>, от '.$name_user.', по объекту -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].'). Детали в разделе <a href="supply/">cнабжение</a>.';
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);
			    notification_send($text_not,$user_send_new,$id_user,$link);



        //пишем уведомление админу что новая заявка создана и отправлена на согласование
        //пишем уведомление админу что новая заявка создана и отправлена на согласование
        $user_admin= array();
        array_push($user_admin, 11);

        $title='Создан новый тендер и отправлен на согласование';
        $kto=name_sql_x($id_user);
        $message=$kto.' создал и отправил на согласование тендер - <a class="link-history" href="tender/'.$row_list['id'].'/">'.$row_list['name'].'</a>';
        notification_send_admin($title,$message,$user_admin,$id_user,$link);

        //пишем уведомление админу что новая заявка создана и отправлена на согласование
        //пишем уведомление админу что новая заявка создана и отправлена на согласование


    }



   // echo '<pre>arr_task:'.print_r($edo->arr_task,true) .'</pre>';

    if ($edo->error == 1) {
        // в array $edo->arr_task задания на согласование
    } else {

    }
} else {
    // процесс согласования со всеми заданиями выполнен
   // echo '<pre>'.$edo->error_name[$edo->error].' - процесс согласования со всеми заданиями выполнен </pre>';
}
header("Location:".$base_usr."/tender/".$_GET['id'].'/order/');

/*


//**************************************************
$memo_i=0; //нет
$result_txs=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'" and ((not(a.memorandum="") and a.id_sign_mem=0)or(not(a.memorandum="") and not(a.id_sign_mem=0)and a.signedd_mem=0))');
if($result_txs->num_rows!=0)
{
 	$memo_i=1;				
}
//согласовать может у кого есть несогласованные меморандумы или с отрицательным ответом
if($memo_i==1)
{
	header404(9,$echo_r);
}
//**************************************************

    //определяем совхоза по объекту
	$stock=new stock_user($link,$row_list["id_object"]);
	$edit_zay=0;	 
	$stack_memorandum = array();  // общий массив ошибок
	$stack_id_work	  = array();
	$stack_error = array();  // общий массив ошибок
	$error_count=0;  //0 - ошибок для сохранения нет
	$flag_podpis=0;  //0 - все заполнено можно подписывать

	//print_r($stack_error);
	//исполнитель			
		

		$result_work_zz=mysql_time_query($link,'Select a.* from z_doc_material as a where a.id_doc="'.htmlspecialchars($_GET['id']).'" order by a.id');
        $num_results_work_zz = $result_work_zz->num_rows;
	    if($num_results_work_zz!=0)
	    {
			//while ($works = mysqli_fetch_assoc($result_work_zz)) { 
     //foreach($works as $key => $value) { 
while($value = mysqli_fetch_assoc($result_work_zz)) {			
//foreach ($result_work_zz as $value) {
			   //смотрим вдруг была удалена эта работа при оформлении	 
			   if($value['id']!='') 
			   {
				   //echo($value['id'].'-');

				   
				//if($value['status']=='') {  $flag_podpis++; }
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
					
					
				   //проверяем возможно служебная записка нужна и поля не все заполнены	
				   $count_user=$value['count_units'];
				   $date_base=$value['date_delivery'];
				   $date_base__=explode('-',$date_base);
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
					
				   if((!is_numeric($count_user))or($count_user<=0)) { array_push($error_work, $value['id']."_w_count1"); }
					
				   if($date_base!='')
				   {
					if(!checkdate(date_minus_null($date_base__[1]), date_minus_null($date_base__[2]),$date_base__[0])) { array_push($error_work, $value['id']."_w_date"); }
					   
				   } else { array_push($error_work, $value['id']."_w_date1"); }
				 	//служебка не заполнена		
				    if((trim($value['memorandum'])=='')and($flag_work>0)) {    array_push($error_work, $value['id']."_w_text"); }  
					//служебка без ответа
					if((trim($value['id_sign_mem'])==0)and($flag_work>0)) {    array_push($error_work, $value['id']."_w_text1"); }
					//служебка с отрицательным ответом
				    if((trim($value['id_sign_mem'])!=0)and($value['signedd_mem']==0)and($flag_work>0)) {  array_push($error_work, $value['id']."_w_text1"); }
					if($flag_work>0) { array_push($stack_memorandum, $value['id']."_w_flag");  	 }
				 

				 if(count($error_work)!=0)
				 {
					// print_r($error_work);
					 header404(11,$echo_r);
					 
				 }
				}
			 }
			 }
		
		//}

		 
		
			
		} else
		{
			header404(10,$echo_r);
		}

//ДЕЙСТВИЯ ДЕЙСТВИЯ ДЕЙСТВИЯ ДЕЙСТВИЯ ДЕЙСТВИЯ ДЕЙСТВИЯ ДЕЙСТВИЯ ДЕЙСТВИЯ ДЕЙСТВИЯ ДЕЙСТВИЯ ДЕЙСТВИЯ ДЕЙСТВИЯ




	 
mysql_time_query($link,'update z_doc set status="9" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
//меняем статусы у материалов на заказано
$result_tyd1=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_tyd1 = $result_tyd1->num_rows;
				
for ($ids=0; $ids<$num_results_tyd1; $ids++)
{
	$row_tyd1 = mysqli_fetch_assoc($result_tyd1);
	mysql_time_query($link,'update z_doc_material set status="9" where id = "'.htmlspecialchars(trim($row_tyd1['id'])).'"');
}
				   
				   
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	

				  $user_send= array();	
				  $user_send_new= array();		

				  $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_list['id_object'])).'"');
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
				  
				 
                //уведомление снабженцу
                $FUSER=new find_user($link,$row_list['id_object'],'R','','supply');
				$user_send_new=$FUSER->id_user;
				$text_not='Поступила <strong>новая заявка на материал №'.$row_list['number'].'</strong>, от '.$name_user.', по объекту -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].'). Детали в разделе <a href="supply/">cнабжение</a>.';	
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);

                //уведомление создателю заявки если это через служебную записку
                if($row_list["status"]==3)
				{
				 $user_send_new= array();		
				 array_push($user_send_new, $row_list["id_user"]);
					
				 $text_not='Ваша <a href="app/'.$row_list['id'].'/">заявка на материал №'.$row_list['number'].'</a> согласована и отправлена в заказ.';	
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);
				 
				 
				}
	  
				  		  
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде		  
				  
						  
	*/
						  
				       
		
//header("Location:".$base_usr."/app/".$_GET['id'].'/');


	
?>