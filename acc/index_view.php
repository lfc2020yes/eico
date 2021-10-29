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


$active_menu='acc';
//правам к просмотру к действиям
//$user_send_new=array();


$podpis=0;  //по умолчанию нельзя редактировать статус заказано


//кому можно изменять заявку
//если это создатель заявки
//и статус заявки сохранено
//никто выше не может изменять чужие заявки
//выше могут ставить решение по служебным запискам
//выше могут ставить соответствие заказанного материала с материалом на складе
$result_url=mysql_time_query($link,'select A.id from z_acc as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'" and A.id_user="'.$id_user.'" and ((A.status=1) or (A.status=8))');
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




		
       
		$result_url=mysql_time_query($link,'select A.* from z_acc as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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
			if (($role->permission('Счета','R'))or($sign_admin==1)or($role->permission('Счета','S')))
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
if($row_list["id_user"]!=$id_user) {

    if (!is_object($edo)) {
        include_once $url_system.'ilib/lib_interstroi.php';
        include_once $url_system.'ilib/lib_edo.php';
        $edo = new EDO($link, $id_user, false);
    }

    $arr_document = $edo->my_documents(1, ht($_GET["id"]), '>=-10', true);
    $arr_tasks = $edo->my_tasks(1, '>=-10' ,'','LIMIT 0,1',null,ht($_GET["id"]));

//echo(count($arr_tasks));

    if((count($arr_tasks)==0)and(count($arr_document)==0))
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
/*
	$status_user_zay=array("1","0","0");
	
	if((($role->permission('Заявки','S'))and(array_search($row_list["id_user"],$hie_user)!==false)and($row_list["id_user"]!=$id_user))or($sign_admin==1))
	{
		$status_user_zay[1]=1;
	}
	if(($role->permission('Заявки','R'))and(!$role->permission('Заявки','A'))and(array_search($row_list["id_object"],$hie_object)!==false))
	{
		$status_user_zay[2]=1;
	}
*/
	//print_r($status_user_zay);







if((isset($_POST['save_naryad']))and($_POST['save_naryad']==1))
{
	$token=htmlspecialchars($_POST['tk']);
	$id=htmlspecialchars($_GET['id']);

	//токен доступен в течении 120 минут

    if(token_access_new($token,'save_mat_acc_x',$id,"rema",120))



       // if(token_access_yes($token,'save_mat_zay_x',$id,120))
    {

	//возможно проверка что этот пользователь это может делать
	 if (($role->permission('Счета','U'))and($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8)))
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
		
			 $works=$_POST['material'];
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

				
				$result_tx=mysql_time_query($link,'Select b.id_acc from z_doc_material_acc as b where b.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такой материал есть
		           $rowx = mysqli_fetch_assoc($result_tx);
					
				   //проверяем что материал относится к нужному объекту
					if($rowx["id_acc"]!=$_GET['id'])
					{
					  array_push($stack_error, $value['id']."work_not_acc");
					}
					

				   $count_user=trimc($value['count']);
                    $price_user=trimc($value['price']);
				   
				   //$count_sys=$rowx['count_units'];

					
					
					
//***************************************************************************************************************************		

					 
//***************************************************************************************************************************					

				   //******************************************************	
				   $error_work = array();  //обнуляем массив ошибок по конкретной работе
				   
				   $flag_message=0;	//0 - вывод служебной записки по работе не нужен
				   $flag_work=0;

					
				   if((!is_numeric($count_user))or($count_user<=0)) { array_push($stack_error, $value['id']."count_null"); }
                    if((!is_numeric($price_user))or($price_user<=0)) { array_push($stack_error, $value['id']."price_null"); }
					

				} else
                {
                    array_push($stack_error, $value['id']."work_not_base");
                }
			 }
			 }
		 


	    //есть ли ошибки по заполнению
		//print_r($stack_error);
		//echo($flag_podpis);
	    if((count($stack_error)==0)and($error_count==0))
		{
		   //ошибок нет
		   //сохраняем заявку
		   	 $works=$_POST['material'];

             foreach ($works as $key => $value) 
			 {
			   	 
			   if($value['id']!='') 
			   {

                   mysql_time_query($link,'update z_doc_material_acc set 				 
					 count_material="'.htmlspecialchars(trim(trimc($value['count']))).'",					 
					 price_material="'.htmlspecialchars(trim(trimc($value['price']))).'"
		
					 
					 where id = "'.htmlspecialchars(trim($value['id'])).'"');


               }
			 }


				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	

		

			   header("Location:".$base_usr."/acc/".$_GET["id"].'/save/');
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



include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('aсс_view','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_acc_view.php';

	?>
      <div id="fullpage" class="margin_60  input-block-2020 ">
      <div class="section" id="section0">
          <div class="height_100vh">
              <div class="oka_block_2019">

                  <?
                  echo'<div class="line_mobile_blue">Счет №'.$row_list["id"];
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
                          include $url_system . 'acc/code/block_app.php';
                          echo($task_cloud_block);
                      }
                      echo'</div>';



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
                                      if (( isset($_GET["a"]))and($_GET["a"]=='order')) {
                                          echo "alert_message('ok', 'отправлено на согласование');";
                                      } else
                                      {
                                          if(( isset($_GET["a"]))and($_GET["a"]=='dell'))
                                          {
                                              echo "alert_message('ok', 'позиция удалена из счета');";
                                          } else {

                                              if(( isset($_GET["a"]))and($_GET["a"]=='save'))
                                              {
                                                  echo "alert_message('ok', 'данные сохранены');";
                                              } else {
                                                  if((isset($_POST['save_naryad']))and($_POST['save_naryad']==1))
                                                  {

                                                      echo " alert_message('error', 'Ошибка - попробуйте еще раз');";

                                                  } else {
                                                      echo "alert_message('ok', text_xx);";
                                                  }
                                                  }
                                          }
                                      }
?>
                                      var title_url=$(document).attr('title'); var url=window.location.href;
                                      url=url.replace('add/', '');
                                      url=url.replace('order/', '');
                                      url=url.replace('yes/', '');
                                      url=url.replace('dell/', '');
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



                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо

                      if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)or($row_list["status"]==8))) {
                          $query_string .= '<div class="info-suit"><div class="input-block-2020">';


                          $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="8" and A.visible=1 and A.id_object="' . ht($row_list["id"]) . '"');

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


                          $query_string .= '</div><input type="hidden" name="files_9" value=""><div type_load="8" id_object="' . ht($row_list["id"]) . '" class="invoice_upload js-upload-file js-helps ' . $class_aa . '"><span>прикрепите <strong>дополнительные документы</strong>, для этого выберите или перетащите файлы сюда </span><i>чтобы прикрепить ещё <strong>необходимые документы</strong>,выберите или перетащите их сюда</i><div class="help-icon-x" data-tooltip="Принимаем только в форматах .pdf, .jpg, .jpeg, .png, .doc , .docx , .zip" >u</div></div></div></div>';

                          $query_string .= '</div></div>';


                          echo $query_string;
                      }
                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                      //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
                      //конец

                      ?>


                      <div class="info-suit">





<form id="lalala_add_form" class="js-save-form-acc my_nn" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
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
	  $rr=0;
	  

	  
	  
	  
	  
	  
	  echo'<div class="content_block block_primes1">';



  echo'<span class="h3-f h-25">Материалы из заявок содержащиеся в счете</span>';

  $sql='';

  $result_work_zz45=mysql_time_query($link,'Select a.* from z_doc_material_acc as a where a.id_acc="'.htmlspecialchars($_GET['id']).'" order by a.id');



  $num_results_work_zz45 = $result_work_zz45->num_rows;
  if($num_results_work_zz45!=0) {


      $id_work = 0;
      echo'<div class="xvg_add_material option_slice_xxg active_xxg js-acc-view">';
      $ddf=1;
      for ($i = 0; $i < $num_results_work_zz45; $i++) {
          $row1ssx = mysqli_fetch_assoc($result_work_zz45);
          $rrtt++;
          $result_t2=mysql_time_query($link,'SELECT 
       
       a.id AS id_acc, 
       f.id_stock,
       f.id as idd,
       b.id,
       rt.name,
       rt.id AS id_doc,
       b.count_material,
       b.price_material,
       b.path_buy

FROM 
z_acc AS a,
z_doc_material_acc AS b,
i_material AS c,
z_doc_material AS f,
z_doc AS rt 

WHERE rt.id=f.id_doc AND f.id=b.id_doc_material AND b.id="'.ht($row1ssx["id"]).'" AND c.id=f.id_i_material AND a.id=b.id_acc');


          $num_results_t2 = $result_t2->num_rows;
          if($num_results_t2!=0)
          {
              $row__2= mysqli_fetch_assoc($result_t2);



              $result_work_zz=mysql_time_query($link,'
			SELECT a.count_units AS ss,
c.price AS mm,
c.units
FROM 
z_doc_material AS a,
i_material AS c
WHERE 
a.id_i_material=c.id AND
a.id="'.$row__2["idd"].'"');

              $num_results_work_zz = $result_work_zz->num_rows;
              if($num_results_work_zz!=0)
              {
                  $id_work=0;

                  $row_work_zz = mysqli_fetch_assoc($result_work_zz);
                  //echo('<div>'.$row_work_zz['count_units'].' '.$row_material['units'].'</div>');

                  $xmd='';
                  $result_t3=mysql_time_query($link,'SELECT a.id
FROM 
z_doc_material AS a
WHERE 
a.id="'.$row__2["idd"].'"');
                  $num_results_t3 = $result_t3->num_rows;
                  if($num_results_t3!=0)
                  {
                      for ($op=0; $op<$num_results_t3; $op++)
                      {
                          $row__3= mysqli_fetch_assoc($result_t3);
                          if($op==0) {$xmd=$row__3["id"];} else {$xmd=$xmd.'.'.$row__3["id"];}
                      }
                  }



                  if($row__2["id_stock"]!='')
                  {
                      $result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row__2["id_stock"].'"');
                      $num_results_t1__341 = $result_t1__341->num_rows;
                      if($num_results_t1__341!=0)
                      {
                          $row1ss__341 = mysqli_fetch_assoc($result_t1__341);
                      }
                  }



                  $PROC=0;

                  $result_proc=mysql_time_query($link,'select sum(a.count_units) as summ,sum(a.count_defect) as summ1  from 
             
             z_invoice_material as a,
             z_invoice as b,
             z_doc_material_acc as y
                                                                     
             

where 
      y.id_acc=a.id_acc and
      a.id_acc="'.$row__2["id_acc"].'" and
      b.id=a.id_invoice and 
      not(b.status=1) and 
      y.id="'.$row__2["id"].'" and a.id_stock="'.$row__2["id_stock"].'"');

$POL=0;
                  //echo('select sum(a.subtotal) as summ,sum(a.subtotal_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.$row_score["id"].'"');
                  $num_results_proc = $result_proc->num_rows;
                  if($num_results_proc!=0)
                  {
                      $row_proc = mysqli_fetch_assoc($result_proc);
                      $POL=$row_proc["summ"]-$row_proc["summ1"];

                      $result_uu9=mysql_time_query($link,'select a.count_material as summa from z_doc_material_acc as a where a.id="'.ht($row__2["id"]).'"');
                      $num_results_uu9 = $result_uu9->num_rows;

                      if($num_results_uu9!=0)
                      {
                          $row_uu9 = mysqli_fetch_assoc($result_uu9);
                          $PROC=round((($row_proc["summ"]-$row_proc["summ1"])*100)/$row_uu9["summa"]);
                      }
                      if($PROC>100) {$PROC=100;}
                  }


                  echo'<div data-tooltip="Получено '.$POL.' '.$row_work_zz['units'].' из '.$row_uu9["summa"].' '.$row_work_zz['units'].'"  class="loaderr-acc"><div id_loader="'.$row__2["id"].'" class="teps" rel_w="'.$PROC.'" style="width: 0%;"><div class="peg_div"><div><i class="peg"></i></div></div></div></div>';

                  echo'<div style="background-color: #f0f4f6;" class="js-acc-block items_acc_basket   " yi_sopp_="'.$row__2["id"].'">';






                  echo'<input type="hidden" value="'.$row__2["id"].'" name="material['.$rr.'][id]">
					 
                <div class="name-user-57"><span class="label-task-gg ">Название
</span><div class="h57-2020"><span class="name-items">'.$row1ss__341["name"].'</span>
                <a href="app/'.$row__2["id_doc"].'/" class="app-items" data-tooltip="Для заявки">'.$row__2["name"].'</a></div>
            
</div>
<div class="tender-date"><span class="label-task-gg ">Единица измерения
</span>
                <span class="item-ed">'.$row_work_zz['units'].'</span>
</div>

<div class="tender-col">';
                  echo'<!--input start-->';

                  echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Кол-во (MAX '.$row_work_zz['ss'].')</i><span>*</span></label><input  name="material['.$rr.'][count]" value="'.ipost_($_POST['material'][$rr]["count"],$row__2["count_material"]).'" count="'.$row__2["id"].'" max="'.$row_work_zz['ss'].'" class="input_new_2021 gloab required   no_upperr count_mask count_xvg_ '.$status_class.'" style="padding-right: 20px;" '.$status_edit.' autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
                  echo'<!--input end-->';
                  echo'</div>               
  
 <div class="tender-col">';

                  echo'<!--input start-->';
                  echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Цена (MAX '.$row_work_zz['mm'].')</i><span>*</span></label><input  name="material['.$rr.'][price]" value="'.ipost_($_POST['material'][$rr]["price"],$row__2["price_material"]).'" price="'.$row__2["id"].'" data-tooltip="Цена в счете за единицу с ндс" max="'.$row_work_zz['mm'].'" class="input_new_2021 gloab required  no_upperr money_mask1 price_xvg_ '.$status_class.'" '.$status_edit.' style="padding-right: 20px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
                  echo'<!--input end-->';

                  echo'</div>  
    <div class="tender-summ all_price_count_xvg"><span class="pay_summ_bill1">0</span>
 </div>               
                <div class="tender-but" style="padding-left: 10px;">';

                  if($status_edit=='') {
                      echo'<div id_rel="'.$row__2["id"].'" class="del-item js-del-items-basket-view del_basket_jooss" data-tooltip="Удалить из счета" ></div >';
                }
                echo'</div>
                
                
                
                </div>';
                  $rr=$rr+1;
              }

          }


          }

      echo'<div class="all_xvg none"><div class="all-xvg-2021">
			      <div class=" wall--1">Итого по счету</div>
				  <div class=" wall--6 all_summa_xvg"><span class="pay_summ_bill1"></span></div>
				  
			  </div></div>';


      echo'</div>';
      }


					 
	

	  
	  if($rrtt==0)
	  {
		  //echo'Добавьте необходимые материалы в разделе снабжение для отправки счета на согласование';

          echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Добавьте необходимые материалы в разделе <a class="help-link" href="supply/">снабжение</a> для отправки счета на согласование.</span></span></div>';


	  } else
      {
          $token=token_access_compile($_GET['id'],'save_mat_acc_x',$secret);


          echo'<input type="hidden" value="'.$token.'" name="tk">';
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
<script type="text/javascript">
    $(function() {
        itogprice_xvg();
        input_2021();
        $('.money_mask1').inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: " ",
            digits: 2,
            autoGroup: true,
            prefix: '', //No Space, this will truncate the first character
            rightAlign: false,
            oncleared: function () { self.Value(''); }
        });
    });
</script>
<?php
echo'<script>
    $(function (){';

        if($visible_gray==0)
        {
            echo'$(\'.tabs_006U[id=1]\').trigger(\'click\');';

        }



        echo'});
</script>';

?>