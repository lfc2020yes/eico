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
//$user_send_new=array();



if((isset($_POST['save_invoice_two_step']))and($_POST['save_invoice_two_step']==1))
{
	$token=htmlspecialchars($_POST['tk']);
	$id=htmlspecialchars($_GET['id']);
	
	//токен доступен в течении 120 минут
	if(token_access_yes($token,'view_invoicess_x',$id,120))
    {
		//echo("!");
	//возможно проверка что этот пользователь это может делать
	 if (($role->permission('Накладные','A'))or($sign_admin==1))
	 {	
	
		 
	$result_url=mysql_time_query($link,'select A.* from z_invoice as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {

			$row_list = mysqli_fetch_assoc($result_url);
			if($row_list["status"]==1)
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
	
	//ндс без			
	if(($_POST['ispol_type']!=0)and($_POST['ispol_type']!=1))
	{
		array_push($stack_error, "ispol_type");
		$error_count++;
		$flag_podpis++;  
	}			
				
	//дата документ
	if($_POST['datess']=='')
	{
		array_push($stack_error, "datess");
		$error_count++;
		$flag_podpis++;
	}	

	if($_POST['number_invoices']=='')
	{
		array_push($stack_error, "number_invoices");
		$error_count++;
		$flag_podpis++;
	}
				
	
			
		
	    if((count($stack_error)==0)and($error_count==0))
		{
		   //ошибок нет
		   //сохраняем накладную
		   
		   $today[0] = date("y.m.d"); //присвоено 03.12.01
           $today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17
		   
			mysql_time_query($link,'update z_invoice set number="'.htmlspecialchars($_POST['number_invoices']).'",date="'.htmlspecialchars($_POST['date_invoice']).'",id_contractor="'.htmlspecialchars(trim($_POST["ispol_work"])).'",type_contractor="'.htmlspecialchars(trim($_POST["ispol_type"])).'",nds_view="'.htmlspecialchars($_POST['nds_ff']).'" where id = "'.htmlspecialchars($_GET['id']).'"');	
			
		   
		}
				
			
				
		
				
		  $error_work = array();  //обнуляем массив ошибок по конкретной материалу				   
		  $flag_message=0;	//0 - вывод акта по работе нет
				
				
				
		$works=$_POST['invoice'];
        foreach ($works as $key => $value) 
	    {
			   //смотрим вдруг был удален этот материал при оформлении	 
			   if($value['id']!='') 
			   {
				 /*
				$value['id']
				$value['price']
				$value['count']
				$value['price_nds']

				
				$_POST['invoice'][0]["id"]
				*/		
				$result_tx=mysql_time_query($link,'Select a.id from z_invoice_material as a where a.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такой материал есть
		           $rowx = mysqli_fetch_assoc($result_tx);		
				   $count_mat=$value['count'];
				   $price_mat=$value['price'];
				   $price_nds_mat=$value['price_nds'];
				   $count_mat_akt=$value['count_defect'];
				   $comment_mat_akt=$value['text'];	
				   $defect=$value['defect'];
				 
					
				   if($defect==1)
				   {
					$flag_message=1;   
					if((!is_numeric($count_mat_akt))or($count_mat_akt<=0)or($count_mat<$count_mat_akt)) { $flag_podpis++; array_push($error_work, $value['id']."_w_count_defect");}
					
					//смотрим есть ли прикрепленные акты
					$result_scorexx=mysql_time_query($link,'Select a.* from z_invoice_attach_defect as a where a.type_invoice=0 and a.id_invoice_material="'.htmlspecialchars(trim($value['id'])).'"');
	                $num_results_scorexx = $result_scorexx->num_rows;
                    if($num_results_scorexx==0)
                    {  
						if($comment_mat_akt=='') { $flag_podpis++;  array_push($error_work, $value['id']."_w_text"); }
	
                    }
					   
					   
					   
				   }
				}
			   }
		}
				
				
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
				
				
		if((count($stack_error)==0)and($error_count==0))
		{			
		
		
		   $works=$_POST['invoice'];
		   $summa_all=0;
				
$count_material=0;
        foreach ($works as $key => $value) 
	    {
			   //смотрим вдруг был удален этот материал при оформлении	 
			   if($value['id']!='') 
			   {
				 /*
				$value['id']
				$value['price']
				$value['count']
				$value['price_nds']

				
				$_POST['invoice'][0]["id"]
				*/		
				   
				$summ_tr=0;   
				
				$result_tx=mysql_time_query($link,'Select a.id from z_invoice_material as a where a.id="'.htmlspecialchars(trim($value['id'])).'"');
                $num_results_tx = $result_tx->num_rows;
	            if($num_results_tx!=0)
	            {  
		           //такой материал есть
		           $rowx = mysqli_fetch_assoc($result_tx);		
				   $count_material++;
				   $count_mat=$value['count'];
				   $price_mat=$value['price'];
				   $price_nds_mat=$value['price_nds'];
				   $count_mat_akt=$value['count_defect'];
				   $comment_mat_akt=$value['text'];	
				   $defect=$value['defect'];
				 
					
				   if($defect==1)
				   {
					   
					if((!is_numeric($count_mat_akt))or($count_mat_akt<=0)or($count_mat<$count_mat_akt)) { $flag_podpis++; array_push($error_work, $value['id']."_w_count_defect");}
					
					//смотрим есть ли прикрепленные акты
					$result_scorexx=mysql_time_query($link,'Select a.* from z_invoice_attach_defect as a where a.type_invoice=0 and a.id_invoice_material="'.htmlspecialchars(trim($value['id'])).'"');
	                $num_results_scorexx = $result_scorexx->num_rows;
                    if($num_results_scorexx==0)
                    {  
						if($comment_mat_akt=='') { $flag_podpis++;  array_push($error_work, $value['id']."_w_text"); }
	
                    }
					   
					   
					   
				   }
					
				
					
				   if((($price_nds_mat==0)or($price_nds_mat=='')or(!is_numeric($price_nds_mat)))and(($price_mat==0)or($price_mat=='')or(!is_numeric($price_mat)))) { $flag_podpis++; $summ_tr++; }					
				   if((!is_numeric($count_mat))or($count_mat<=0)) { $flag_podpis++; $summ_tr++;}	
				   $s_tr=0;
				   $s_tr1=0;	
				   $cost_table=0;
				   $cost_table_nds=0;
					
					
				   if($summ_tr==0)
				   {
					   if($_POST["ispol_type"]==0)
					   {
						   
						  if($_POST['nds_ff']==0)
					     {
					       $s_tr=$price_nds_mat*$count_mat;
						   $s_tr1=$price_nds_mat*$count_mat_akt;	 
						   $cost_table_nds=$price_nds_mat;
					      } else
					     {
						    $s_tr=$price_mat*1.18*$count_mat; 
							$s_tr1=$price_mat*1.18*$count_mat_akt; 
							 $cost_table=$price_mat;
					     }
						  /* 
					     if((is_numeric($price_nds_mat))and($price_nds_mat!=0))
					     {
					       $s_tr=$price_nds_mat*$count_mat;
						   $s_tr1=$price_nds_mat*$count_mat_akt;	 
						   $cost_table_nds=$price_nds_mat;
					      } else
					     {
						    $s_tr=$price_mat*1.18*$count_mat; 
							$s_tr1=$price_mat*1.18*$count_mat_akt; 
							 $cost_table=$price_mat;
					     }
						 */
					   } else
				       {
					   $s_tr=$price_mat*$count_mat;
					   $s_tr1=$price_mat*$count_mat_akt; 	   
					   $cost_table=$price_mat;
				       } 
					   
					   
				   }
					
				   $summa_all=$summa_all+$s_tr;	
					//echo('update z_invoice_material set count_units="'.htmlspecialchars($count_mat).'",price="'.htmlspecialchars($cost_table).'",price_nds="'.htmlspecialchars(trim($cost_table_nds)).'",subtotal="'.htmlspecialchars(trim($s_tr)).'" where id = "'.htmlspecialchars($value['id']).'"');
				   mysql_time_query($link,'update z_invoice_material set count_units="'.htmlspecialchars($count_mat).'",price="'.htmlspecialchars($cost_table).'",price_nds="'.htmlspecialchars(trim($cost_table_nds)).'",subtotal="'.htmlspecialchars(trim($s_tr)).'",subtotal_defect="'.htmlspecialchars(trim($s_tr1)).'",defect="'.htmlspecialchars($value['defect']).'",count_defect="'.htmlspecialchars($value['count_defect']).'",defect_comment="'.htmlspecialchars($value['text']).'" where id = "'.htmlspecialchars($value['id']).'"');
					
				   if($value['defect']==0)
				   {
					   //удаляем всю инфу по актам по этому материалу
					   
					   
					   $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/invoices/scan_akt/';
				       $uploaddir1 = $_SERVER["DOCUMENT_ROOT"].'/invoices/scan_material/';
					   
					   $result_scorex1=mysql_time_query($link,'Select a.* from z_invoice_attach_defect as a where a.id_invoice_material="'.htmlspecialchars(trim($value['id'])).'"');
                       $num_results_scorex1 = $result_scorex1->num_rows;
                       if($num_results_scorex1!=0)
					   {
						   for ($ssx=0; $ssx<$num_results_scorex1; $ssx++)
						   {	
							   $row_scorex1 = mysqli_fetch_assoc($result_scorex1);
							    $uploadfile = $uploaddir.$value['id'].'_'.$row_scorex1["name"].'.jpg';
							    $uploadfile1 = $uploaddir1.$value['id'].'_'.$row_scorex1["name"].'.jpg';
							   if (file_exists($uploadfile)) {unlink($uploadfile);}
							    if (file_exists($uploadfile1)) {unlink($uploadfile1);}
						   }
					   
					   
					   }
                      
					   mysql_time_query($link,'delete FROM z_invoice_attach_defect where id_invoice_material="'.htmlspecialchars(trim($value['id'])).'"');
					   
				   }
					
					
					
				}
			   }
		}
		
		if((count($stack_error)==0)and($error_count==0))
		{
		   //ошибок нет
		   //сохраняем накладную

			mysql_time_query($link,'update z_invoice set summa="'.$summa_all.'" where id = "'.htmlspecialchars($_GET['id']).'"');	
			
		   
		}		
	
				
		if(($flag_podpis==0)and($count_material!=0))
		{
			
			//все заполнено можно ставить ready на передачу
			mysql_time_query($link,'update z_invoice set ready="1" where id = "'.htmlspecialchars($_GET['id']).'"');
			
		} else
		{
			mysql_time_query($link,'update z_invoice set ready="0" where id = "'.htmlspecialchars($_GET['id']).'"');
		}
				
				
		}
		}
		}

}

}
	
	
}



$secret=rand_string_string(4);
$_SESSION['s_t'] = $secret;	





//проверить и перейти к последней себестоимости в которой был пользователь


//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /invoices/add/
//    0    1      2  
$echo_r=1; //выводить или нет ошибку 0 -нет
$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

if (strripos($url_404, 'index_view.php') !== false) {
   header404(1,$echo_r);	
}

//**************************************************
if (( count($_GET) != 1 ) )
{
   header404(2,$echo_r);		
}

if((!$role->permission('Накладные','R'))and($sign_admin!=1))
{
  header404(3,$echo_r);
}


$result_url=mysql_time_query($link,'select A.* from z_invoice as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0)
        {
           header404(5,$echo_r);
		} else
		{
			$row_list = mysqli_fetch_assoc($result_url);
		}


if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы


$status_edit='';
$status_class='';
$status_edit1='';
if($row_list["status"]==3)		
{	
   $status_edit='readonly';	
   $status_edit1='disabled';
   $status_class='grey_edit';		
}



include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('invoices_view','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php'; include $url_system.'template/head.php';
?>
</head><body>
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
			echo'<div class="iss">';	
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

	  include_once $url_system.'template/top_invoices_view.php';


    echo'<div class="content_block1 invoice_block" id_content="'.$id_user.'">';

echo'<div class="comme_invoice" style="" >Загруженные документы</div><div class="img_invoice_div">';	  
	  
$result_score=mysql_time_query($link,'Select a.* from z_invoice_attach as a where a.id_invoice="'.htmlspecialchars(trim($_GET['id'])).'"');
	


$num_results_score = $result_score->num_rows;
if($num_results_score!=0)
{	  
echo'<div class="img_invoice"  style="display:block;"><ul>';
	
	for ($ss=0; $ss<$num_results_score; $ss++)
	{			   			  			   
	    $row_score = mysqli_fetch_assoc($result_score);	
		echo'<li sop="'.$row_score["id"].'">';
		if($row_list["status"]==1)
		{
		echo'<i for="'.$row_score["id"].'" data-tooltip="Удалить изображение" class="del_image_invoice"></i>';
		}
		
		if(($row_score["type"]=='jpg')or($row_score["type"]=='jpeg'))
		{
		
		echo'<a target="_blank" href="invoices/scan/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].'" rel="'.$row_score["id"].'"><div style=" background-image: url(invoices/scan/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].')"></div></a></li>';
		} else
		{
			
			echo'<a target="_blank" href="invoices/scan/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].'" rel="'.$row_score["id"].'"><div class="doc_pdf">'.$row_score["type"].'</div></a></li>';		
			
		}
	}
	
	echo'</ul></div>';	
} else
{
	echo'<div class="img_invoice"><ul></ul></div>';	
}
	  
		if(($row_list["status"]==1)and(($role->permission('Накладные','A'))or($sign_admin==1)))
		{ 
			
			echo'<div id_upload="'.htmlspecialchars(trim($_GET['id'])).'" data-tooltip="загрузить накладную" class="invoice_upload">Перетащите файл, который Вы хотите прикрепить</div><form  class="form_up" id="upload_sc_'.htmlspecialchars(trim($_GET['id'])).'" id_sc="'.htmlspecialchars(trim($_GET['id'])).'" name="upload'.htmlspecialchars(trim($_GET['id'])).'"><input class="sc_sc_loo12" type="file" name="myfile'.htmlspecialchars(trim($_GET['id'])).'"></form><div class="loaderr_scan scap_load_'.htmlspecialchars(trim($_GET['id'])).'" style="width:100%"><div class="scap_load__" style="width: 0%;"></div></div>';
			
		}
	?>
</div><form id="lalala_add_form" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
 <input name="save_invoice_two_step" value="1" type="hidden">
  <?
		
echo'<br><div class="comme_invoice" >Необходимые данные</div>';	  
	
	  
	  
	  $rrtt=0;
	  

	       
					
	echo'<div style="height:70px;"><div class="_50_na_50_1" style="width:25%; float:left;">';
	
	echo'<div class="width-setter1"><label style="display: none; margin-top: 20px;">Номер</label><input style=" margin-top: 20px;" name="number_invoices"  placeholder="Номер" class="input_f_1 input_100 white_inp label_s save__s '.$status_class.'" autocomplete="off" id="number_invoice" value="'.ipost_($_POST['number_invoices'],$row_list["number"]).'" '.$status_edit.' type="text"></div>';
	
		   
		echo'</div>';
		
		echo'<div class="_50_na_50_1" style="width:25%; float:left;">';
		   echo'<div class="input-width m10_right" style="position:relative; margin-left: 10px; ">';
		    
		    echo'<input id="date_hidden_table" name="date_invoice" value="'.ipost_($_POST['date_invoice'],$row_list["date"]).'" type="hidden"><label style="display: none; margin-top: 20px; top:9px; text-transform: uppercase;">Дата</label>';
			
			echo'<input '.$status_edit1.' readonly="true" name="datess" value="'.ipost_($_POST['datess'],date_fik($row_list["date"])).'" id="date_table" class="input_f_1 input_100 calendar_t label_s save__s white_inp '.iclass_("date_naryad",$stack_error,"error_formi").' '.$status_class.'" placeholder="Дата"  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div></div>';
		
		echo'<div class="pad10" style="padding: 0;"><span class="bookingBox"></span></div>';
		
		echo'';
	  
		  
		  
		  
			echo'<div class="_50_na_50_1" style="width:25%; float:left;">';
		   
	echo'<div class="input-width m10_left" style="margin-left:10px;">';
		
		
	$result_t=mysql_time_query($link,'Select a.id,a.name from z_contractor as a order by a.name');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="select_box eddd_box "><a class="slct_box save__s '.iclass_('ispol_work',$stack_error,"error_formi").' '.$status_class.'" data_src="'.ipost_x($_POST['ispol_work'],$row_list["id_contractor"],"0").'">'.ipost_x($_POST['ispol_work'],$row_list["id_contractor"],"Исполнитель","z_contractor","name",$link).'</a><ul class="drop_box">';
		  // echo'<li><a href="javascript:void(0);"  rel="0">--</a></li>';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);

				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>'; 
			  
			 }
		   echo'</ul><label style="display: none; margin-top: 20px; top:-9px; text-transform: uppercase;">Поставщик</label><input class="label_s" '.$status_edit.' name="ispol_work" id="ispol_invoice" value="'.ipost_x($_POST['ispol_work'],$row_list["id_contractor"],"0").'" type="hidden"></div>'; 
	   }
		
		
		
		
		echo'</div>';
	
	  echo'</div>';
	
	
		echo'<div class="_50_na_50_1" style="width:25%; float:left;">';
		   
	echo'<div class="input-width m10_left" style="margin-left:10px;">';
		
		

		   echo'<div class="select_box eddd_box "><a class="slct_box save__s '.iclass_('ispol_type',$stack_error,"error_formi").' '.$status_class.'" data_src="'.ipost_x($_POST['ispol_type'],$row_list["type_contractor"],"0").'">'.ipost_x($_POST['ispol_type'],$row_list["type_contractor"],"С НДС/БЕЗ НДС","z_contractor_type","type",$link).'</a><ul class="drop_box">';
		  // echo'<li><a href="javascript:void(0);"  rel="0">--</a></li>';
		   
		   echo'<li><a href="javascript:void(0);"  rel="0">С НДС</a></li>'; 
	       echo'<li><a href="javascript:void(0);"  rel="1">БЕЗ НДС</a></li>';
			  
			 
		   echo'</ul><label style="display: none; margin-top: 20px; top:-9px; text-transform: uppercase;">С НДС/БЕЗ НДС</label><input class="label_s" '.$status_edit.' name="ispol_type" id="ispol_type_invoice" value="'.ipost_x($_POST['ispol_type'],$row_list["type_contractor"],"0").'" type="hidden"></div>'; 
	   
		
		
		
		
		echo'</div>';
	
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
	 


<?
if($_POST['datess1']!='')
{
echo'var st=\''.ipost_($_POST['date_start'],"").'\';
var st1=\''.ipost_($_POST['date_end'],"").'\';
var st2=\''.ipost_($_POST['datess1'],"").'\';';
echo'jopacalendar(st,st1,st2);';		  
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
$(document).ready(function(){           	 
label_show_load();
});
            </script>	  
	  
	  
	  <?
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  echo'</div>';
	  
	  
	  echo'<div class="comme_invoice" style="margin-top:30px;">Материалы в накладной</div>';
		
	$ss=0;
	$result_score=mysql_time_query($link,'select DISTINCT a.* from z_invoice_material as a where a.id_invoice="'.htmlspecialchars(trim($_GET['id'])).'" order by a.id');
	

		 
      $num_results_score = $result_score->num_rows;
	  if($num_results_score==0)
	  {
	       $display_vv='display:none;';
	  }
	

	echo'<div class="content_block block_primes1 block_invoice_2019 " style="margin-top:15px; '.$display_vv.'"><table cellspacing="0"  cellpadding="0" border="0" id="table_freez_0" class="smeta1"><thead>
				
			<tr class="title_smeta"><th class="t_2 no_padding_left_ jk4" rowspan="2">Материал</th>';
	
	  echo'<th class="t_4 jk44" colspan="3">Счет</th><th colspan="3" class="t_7 jk5">Накладная</th><th class="t_7 jk5 x130" rowspan="2" >всего (руб.)</th></tr>	
				
				
		   <tr class="title_smeta">';
	
	  echo'<th class="t_4 jk44">№ счета</th><th class="t_5">Дата</th><th class="t_6">Кол-во</th><th class="t_7 jk5 x170">Кол-во</th><th class="t_7 jk5 x170 cosy_title"></th><th class="t_7 jk5 x170 active_n_ac">Цена с НДС ';
	if($row_list["status"]==1)		
    {
	echo'<div class="checkbox_cost_inv yes_nds"><i></i></div>';
    }
		
		
		echo'</th></tr></thead><tbody>';
						 echo'<tr class="loader_tr" style="height:20px;"><td colspan="8"></td></tr>';
	
	$nds_save=0;  //c ндс по умолчания
	    if($num_results_score!=0)
	    {
				
	$echo='';
		   for ($ss=0; $ss<$num_results_score; $ss++)
		   {			   			  			   
			   $row_score = mysqli_fetch_assoc($result_score);
	
	
	//узнаем какой это материал
			  $result_url=mysql_time_query($link,'select A.name,A.units from z_stock as A where A.id="'.htmlspecialchars(trim($row_score['id_stock'])).'"');
                  $num_results_custom_url = $result_url->num_rows;
                  if($num_results_custom_url!=0)
                  {
			         $row_list1 = mysqli_fetch_assoc($result_url);
		          }
			   
			   
			   
	//узнаем что за счет если есть
			    if(($row_score['id_acc']!='')and($row_score['id_acc']!=0))
				{
				  $result_url1=mysql_time_query($link,'select A.number,A.date,A.summa from z_acc as A where A.id="'.htmlspecialchars(trim($row_score['id_acc'])).'"');
                  $num_results_custom_url1 = $result_url1->num_rows;
                  if($num_results_custom_url1!=0)
                  {
			         $row_list2 = mysqli_fetch_assoc($result_url1);
					  $date_graf2  = explode("-",$row_list2["date"]);
		          }
				}
	//количество материала в этом счете		 
			   $summ=0;
			   $count_max='';
			   $PROC='';
			   $summ1='';
			   $summ2='';
				if(($row_score['id_acc']!='')and($row_score['id_acc']!=0))
				{
					if($row_list["status"]==1)		
    {
		 $count_max=0;
				  $result_url2=mysql_time_query($link,'select sum(A.count_material) as cc,sum(A.price_material) as cc1,count(A.price_material) as cc2  from z_doc_material_acc as A,z_doc_material as B where A.id_doc_material=B.id and B.id_stock="'.$row_score['id_stock'].'" and A.id_acc="'.htmlspecialchars(trim($row_score['id_acc'])).'"');

                  $num_results_custom_url2 = $result_url2->num_rows;
                  if($num_results_custom_url2!=0)
                  {
			         $row_list3 = mysqli_fetch_assoc($result_url2);
					  if($row_list3["cc"]!='')
					  {
						  $summ=round($row_list3["cc"],3);
						  $summ1=round($row_list3["cc"],3);
					  }
					  if(($row_list3["cc1"]!='')and($row_list3["cc"]!='')and($row_list3["cc"]!=0))
					  {
						  $summ2=round($row_list3["cc1"]/$row_list3["cc2"],3);
					  }
					  
					  
		          }		
		
		
			
			   $result_proc=mysql_time_query($link,'select sum(a.count_units) as summ,sum(a.count_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.htmlspecialchars(trim($row_score['id_acc'])).'" and a.id_stock="'.$row_score['id_stock'].'"');
                
	           $num_results_proc = $result_proc->num_rows;
               if($num_results_proc!=0)
               {
		          $row_proc = mysqli_fetch_assoc($result_proc);
				   				   
				  $result_proc1=mysql_time_query($link,'select sum(a.count_material) as ss from z_doc_material_acc as a,z_doc_material as b where a.id_doc_material=b.id and a.id_acc="'.htmlspecialchars(trim($row_score['id_acc'])).'" and b.id_stock="'.$row_score['id_stock'].'"');	
				  $num_results_proc1 = $result_proc1->num_rows;
				   
				  if($num_results_proc1!=0)
                  { 				   
				    $row_proc1 = mysqli_fetch_assoc($result_proc1); 
				  }
				   
				  if($row_proc1["ss"]!=0)
				  {
		            $PROC=round($row_proc1["ss"]-($row_proc["summ"]-$row_proc["summ1"]),3); 
					$count_max=$PROC;
				  }
				   
	           } 
		
				}
			}
			   
	echo'<tr invoice_group="'.$row_score['id'].'" invoice_material="'.$row_score['id'].'" style="background-color:#f0f4f6;" class="jop" >';
			   
			   echo'<td class="no_padding_left_ pre-wrap one_td">'.$row_list1["name"].' <span class="invoice_units">('.$row_list1["units"].')</span>';

		if(($row_list["status"]==1)and(($role->permission('Накладные','A'))or($sign_admin==1)))
		{ 	
			   echo'<div style="margin-right:10px;" class="font-ranks del_invoice_material" data-tooltip="Удалить материал" id_rel="'.$row_score['id'].'"><span class="font-ranks-inner">x</span><div></div></div>';
		
		//иконка акта на отбраковку
		echo'<div id_rel="'.$row_score['id'].'" class="material_defect" data-tooltip="Добавить акт на отбраковку"><span>></span></div>';	   
		}
			  
			   
			   echo'</td>';
			   				if(($row_score['id_acc']!='')and($row_score['id_acc']!=0))
				{
			   echo'<td class="pre-wrap center_text_td number_st_invoice">'.$row_list2["number"].'</td><td class="pre-wrap center_text_td invoice_units">'.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</td><td class="pre-wrap center_text_td count_st_invoice">'.$summ.'</td>';
				} else
				{
			   echo'<td class="pre-wrap center_text_td"> -</td><td class="pre-wrap center_text_td">- </td><td class="pre-wrap center_text_td">- </td>';					
				}
			   
			   
			   echo'<td class="t_7 jk5">';
			   
			   
			   echo'<div class="width-setter"><label>КОЛ-ВО</label><input style="margin-top:0px;" name="invoice['.$ss.'][count]"  max="'.$count_max.'" id="count_invoice_'.$ss.'"  class="input_f_1 input_100 white_inp label_s count_in_  count_mask '.$class_c.' '.$status_class.' '.iclass_($row_score['id'].'_w_count',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" placeholder="'.$PROC.'" value="'.ipost_x($_POST['invoice'][$ss]["count"],$row_score['count_units'],"").'"></div>';	
			   
			   
			   echo'</td><td class="t_7 jk5">';
			   
			   echo'<div class="width-setter"><label>БЕЗ НДС</label><input style="margin-top:0px;" name="invoice['.$ss.'][price]"  id="price_invoice_'.$ss.'" placeholder="" class="input_f_1 input_100 white_inp label_s price_in_  count_mask '.$class_c.' '.$status_class.'  '.iclass_($row_score['id'].'_w_price',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["price"],$row_score['price'],"").'"></div>';	
			   
			   echo'</td><td class="t_7 jk5">';
			   
			   echo'<div class="width-setter"><label>С НДС</label><input style="margin-top:0px;" name="invoice['.$ss.'][price_nds]"  id="price_nds_invoice_'.$ss.'" placeholder="'.$summ2.'" class="input_f_1 input_100 white_inp label_s price_nds_in_  count_mask '.$class_c.' '.$status_class.'  '.iclass_($row_score['id'].'_w_price_nds',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["price_nds"],$row_score['price_nds'],"").'"></div>';	
			   
			   
			   if(ipost_x($_POST['invoice'][$ss]["price_nds"],$row_score['price_nds'],"0")!=0)
			   {
				   $nds_save=1; //без ндс
			   }
			   
			   echo'</td><td class="t_7 jk5" ><span  class="price_supply_ summa_ii"></span><input type=hidden value="'.$row_score['id'].'" name="invoice['.$ss.'][id]"><input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["defect"],$row_score['defect'],"0").'" class="defect_inp" name="invoice['.$ss.'][defect]">
			   <input type=hidden value="'.ipost_x($_POST['invoice'][$ss]["stock"],$row_score['id_stock'],"0").'" class="stock_inp" name="invoice['.$ss.'][stock]">
			   </td></tr>';
						
	

			 //акт на отбраковку	
			   if(ipost_x($_POST['invoice'][$ss]["defect"],$row_score['defect'],"0")==0)
			   {
	 echo'<tr invoice_group="'.$row_score['id'].'" invoices_messa="'.$row_score['id'].'" class=" jop messa_invoice" style="display:none" >';
			   } else
			   {
		 echo'<tr invoice_group="'.$row_score['id'].'"  invoices_messa="'.$row_score['id'].'" class=" jop messa_invoice" >';			   
			   }
				   
				   echo'<td>

	 <span class="hsi">Акт на отбраковку<div></div></span>';
		if(($row_list["status"]==1)and(($role->permission('Накладные','A'))or($sign_admin==1)))
		{  
			   echo'<div class="del_invoice_akt" data-tooltip="Удалить акт" id_rel="'.$row_score['id'].'"><span class="font-ranks-inner">x</span><div></div></div>';
			
			 echo'<a class="print_invoice_akt" data-tooltip="Распечатать акт" href="invoices/print/'.$row_score['id'].'/"><span class="font-ranks-inner">*</span><div></div></a>';
		}
/*
echo'<div class="div_textarea_otziv div_text_glo '.iclass_($row_mat["id"].'_m_text',$stack_error,"error_formi").'" style="margin-top:15px;">
			<div class="otziv_add">
          <textarea placeholder="Напиши руководству причину привышения параметров по этой работе относительно запланированной себестоимости" cols="40" rows="1" id="otziv_area_'.$i.'" name="works['.$i.'][mat]['.$mat.'][text]" class="di text_area_otziv">'.ipost_($_POST['works'][$i]["mat"][$mat]["text"],"").'</textarea>		  
        </div></div>';
*/
			   
			   echo'</td><td style="padding:0px;white-space: nowrap">';
			   
	//выбираем фото актов		   
	$result_scorex=mysql_time_query($link,'Select a.* from z_invoice_attach_defect as a where a.type_invoice=0 and a.id_invoice_material="'.htmlspecialchars(trim($row_score['id'])).'"');
	


$num_results_scorex = $result_scorex->num_rows;
			   echo'<div class="img_akt" ><ul>';
if($num_results_scorex!=0)
{
	
	for ($sse=0; $sse<$num_results_scorex; $sse++)
	{			   			  			   
	    $row_scorex = mysqli_fetch_assoc($result_scorex);	
		$allowedExts = array("pdf", "doc", "docx","jpg","jpeg"); 
		if(($row_scorex["type"]=='jpg')or($row_scorex["type"]=='jpeg'))
		{
		
	echo'<li sops="'.$row_scorex["id"].'"><a target="_blank" href="invoices/scan_akt/'.$row_scorex["id"].'_'.$row_scorex["name"].'.'.$row_scorex["type"].'" rel="'.$row_scorex["id"].'"><div style=" background-image: url(invoices/scan_akt/'.$row_scorex["id"].'_'.$row_scorex["name"].'.jpg)"></div></a></li>'; 
		} else
		{
		echo'<li sops="'.$row_scorex["id"].'"><a target="_blank" href="invoices/scan_akt/'.$row_scorex["id"].'_'.$row_scorex["name"].'.'.$row_scorex["type"].'" rel="'.$row_scorex["id"].'"><div class="doc_pdf1">'.$row_scorex["type"].'</div></a></li>'; 
		}
	}
			
}	
echo'</ul></div>';			   
//выводим кнопку добавить акт
echo'<div id_upload_a="'.$row_score['id'].'" data-tooltip="загрузить акт на отбраковку" class="add_akt_defect"></div>';	
echo'<div class="b_loading_small_akt"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>';			   

$echo.='<form  class="form_up" id="upload_akt_'.$row_score["id"].'" id_a="'.$row_score["id"].'" name="upload_akt'.$row_score["id"].'"><input class="invoice_file_akt" type="file" name="myfileakt'.$row_score["id"].'"></form>';
			   
			  //echo'<div class="loaderr_scan scap_load_'.$row__2["id"].'"><div class="scap_load__" style="width: 0%;"></div></div>';	
	
			   
			   
			   echo'</td><td colspan="2" style="padding:0px;white-space: nowrap">';
			   
	
	//выбираем фото брака	   
	$result_scorex=mysql_time_query($link,'Select a.* from z_invoice_attach_defect as a where a.type_invoice=1 and a.id_invoice_material="'.htmlspecialchars(trim($row_score['id'])).'"');
	//echo('Select a.* from z_invoice_attach_defect as a where a.type_invoice=1 and a.id_invoice_material="'.htmlspecialchars(trim($row_score['id'])).'"');
	


$num_results_scorex = $result_scorex->num_rows;
echo'<div class="img_akt1"><ul>';			   
if($num_results_scorex!=0)
{
	
	for ($sse=0; $sse<$num_results_scorex; $sse++)
	{			   			  			   
	    $row_scorex = mysqli_fetch_assoc($result_scorex);	
		$allowedExts = array("pdf", "doc", "docx","jpg","jpeg"); 
		if(($row_scorex["type"]=='jpg')or($row_scorex["type"]=='jpeg'))
		{
		
	echo'<li sops="'.$row_scorex["id"].'"><a target="_blank" href="invoices/scan_material/'.$row_scorex["id"].'_'.$row_scorex["name"].'.'.$row_scorex["type"].'" rel="'.$row_scorex["id"].'"><div style=" background-image: url(invoices/scan_material/'.$row_scorex["id"].'_'.$row_scorex["name"].'.jpg)"></div></a></li>'; 
		} 
	}
		
}
echo'</ul></div>';				   
			   
//выводим кнопку добавить акт
echo'<div id_upload_a1="'.$row_score["id"].'" data-tooltip="загрузить фото с браком" class="add_akt_defect1"></div>';	
echo'<div class="b_loading_small_akt1"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>';				   
$echo.='<form  class="form_up" id="upload_akt1_'.$row_score["id"].'" id_a="'.$row_score["id"].'" name="upload_akt1'.$row_score["id"].'"><input class="invoice_file_photo" type="file" name="myfilephoto'.$row_score["id"].'"></form>';			   
			   
			   
				echo'</td><td>';  
			
			    echo'<div class="width-setter"><label>КОЛ-ВО БРАКА</label><input style="margin-top:0px;" name="invoice['.$ss.'][count_defect]" id="count_invoice_defect_'.$ss.'"  class="input_f_1 akt_ss input_100 white_inp label_s count_defect_in_  count_mask '.$class_c.' '.$status_class.' '.iclass_($row_score['id'].'_w_count_defect',$stack_error,"error_formi").'"  '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["count_defect"],$row_score['count_defect'],"0").'"></div>';	
				   
				   echo'</td><td colspan="3">';
			   
echo'<div class="width-setter"><input style="margin-top:0px;" name="invoice['.$ss.'][text]"  placeholder="Комментарий по браку" class="akt_ss input_f_1 input_100  '.$status_class.' white_inp label_s text_zayva_message_ '.iclass_($row_score['id'].'_w_text',$stack_error,"error_formi").'" '.$status_edit.' autocomplete="off" type="text" value="'.ipost_x($_POST['invoice'][$ss]["text"],$row_score['defect_comment'],"").'"></div>';								
							
							
	 echo'
	 </td></tr>';  
		 echo'<tr class="loader_tr" style="height:2px;"><td colspan="8"></td></tr>';	   
			   
			   
		   }
	
	
		}
	
	echo'<tr style="" class="jop1 mat itogss"><td class="no_padding_left_ pre-wrap one_td title_itog_invoice" colspan="7"></td><td style="padding-left:10px;"><span  class="price_supply_ itog_invoice"></span></td></tr>'; 		  

	echo'<tr style="" class="jop1 mat itogss_defect"><td class="no_padding_left_ pre-wrap one_td title_itog_nds_invoice" colspan="7">В том числе отбраковка на сумму</td><td style="padding-left:10px;"><span  class="price_supply_ itog_invoice_defect">0</span></td></tr>'; 	
	
	echo'<tr style="" class="jop1 mat itogss_nds"><td class="no_padding_left_ pre-wrap one_td title_itog_nds_invoice" colspan="7">В том числе НДС</td><td style="padding-left:10px;"><span  class="price_supply_ itog_invoice_nds"></span></td></tr>'; 	
		  
		   echo'</tbody></table></div>'; echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_0").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';

		

	?>
	
	<script type="text/javascript"> 
	  $(function (){ 
itog_invoice();
		  nds_invoice();
		  countErrorMax();
});

	</script>
	<?


	
	
		if(($row_list["status"]==1)and(($role->permission('Накладные','A'))or($sign_admin==1)))
		{ 	
	echo'<div class="invoices_mess add_material_invoice" for="'.$row_list["id"].'" col="'.ipost_x($_POST['ispol_work'],$row_list["id_contractor"],"0").'">Добавить материал в накладную</div>';	  
		}
		
					
			$token=token_access_compile($_GET['id'],'view_invoicess_x',$secret);				
						
						echo'<input type="hidden" value="'.$token.'" name="tk">';   
					 echo'<input type="hidden" value="'.$ss.'" name="ss">'; 
echo'<input type="hidden" class="popa_nds" value="'.ipost_($_POST['nds_ff'],$row_list["nds_view"]).'" name="nds_ff">'; 

	  

	  
		   
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

<?
echo'<div class="messa_form_a">'.$echo.'</div>';
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