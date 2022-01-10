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


$active_menu='implementer';


$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

//index.php не должно быть в $url_404
if (strripos($url_404, 'index_view.php') !== false) {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
}

if ( count($_GET) == 1 ) //--Если были приняты данные из HTML-формы
{

  if($D_404[4]=='')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
		
        
		$result_url=mysql_time_query($link,'select A.* from i_implementer as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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
			if (($role->permission('Исполнители','R'))or($sign_admin==1))
	        {
				//имеет ли он доступ в этот наряд
                if ((!$role->permission('Исполнители','B'))and($sign_admin!=1))
                {
                    if($row_list["id_user"]!=$id_user)
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

if($error_header!=404){ SEO('implementer','','','',$link); } else { SEO('0','','','',$link); }

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
    echo'<div class="iss big">';
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

	  include_once $url_system.'template/top_implementer_view.php';
?>
	                  <div id="fullpage" class="margin_60  input-block-2020 ">
          <div class="oka_block_2019" style="min-height:auto;">
              <div class="div_ook hop_ds"><div class="search_task" style="text-align: right;">

<?


if($row_list["summa_made"]>0)
{
    echo'<div class="pay_summ4">'.rtrim(rtrim(number_format($row_list["summa_made"], 2, '.', ' '),'0'),'.').'</div>';
}
if($row_list["summa_paid"]>0)
{
    echo'<div class="pay_summ3" style="margin-left: 50px;">'.rtrim(rtrim(number_format($row_list["summa_paid"], 2, '.', ' '),'0'),'.').'</div>';
}
if($row_list["summa_debt"]>0)
{
    echo'<div class="pay_summ2" style="margin-left: 80px;">'.rtrim(rtrim(number_format($row_list["summa_debt"], 2, '.', ' '),'0'),'.').'</div>';
}

?>

                  </div>
              </div>
              <div class="oka_block">
                  <div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">
	<?

    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$row_list["id"].'">';
	?>

  <?


	  

//echo' <h3 class="head_h" style=" margin-bottom:0px;">'.$row_list["implementer"].'<div></div></h3>';

	echo'<table cellspacing="0"  cellpadding="0" border="0" class="smeta2"> 
	<tr class="nary n1n"><td></td><td class="no_padding_left_ pre-wrap" style="color: rgba(0, 0, 0, 0.3);">Организация</td><td class="no_padding_left_ pre-wrap" >'.htmlspecialchars_decode($row_list["name_team"]).'</td></tr>
	<tr class="nary n1n"><td></td><td class="no_padding_left_ pre-wrap" style="color: rgba(0, 0, 0, 0.3);">Руководитель организации</td><td class="no_padding_left_ pre-wrap">'.pad($row_list["fio"],0).'</td></tr>	
	<tr class="nary n1n"><td></td><td class="no_padding_left_ pre-wrap" style="color: rgba(0, 0, 0, 0.3);">Телефон</td><td class="no_padding_left_ pre-wrap"><a href="tel:+'.$row_list["tel"].'" rel="nofollow">+'.$row_list["tel"].'</a></td></tr>		
	
	</table><br><br>';

  
	  
 

	     
	  $result_t2=mysql_time_query($link,'select A.*,B.name_user,B.timelast,B.id as id_s from c_cash as A,r_user as B where A.id_cash=B.id and A.id_implementer="'.htmlspecialchars(trim($_GET['id'])).'" order by A.id desc');
	  $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
	echo' <h3 class="head_h" style=" margin-bottom:0px;">История выдачи денежных средств<div></div></h3>';				  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_cash" class="smeta2 pay_imp"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">№ документа</th><th class="t_1">Дата выдачи</th><th class="t_2 no_padding_left_">сумма</th><th class="t_8">Выписал/Статус</th><th class="t_10"></th><th class="t_10"></th></tr></thead><tbody>';
	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {     
                       $row__2= mysqli_fetch_assoc($result_t2);	  
                     
$cll='';
if($row__2["sign_rco"]!=0)
{
  $cll='whites';
}
					
echo'<tr class="nary n1n '.$cll.'" rel_cash="'.$row__2["id"].'"><td></td>';
 echo'<td class="no_padding_left_ pre-wrap">

<a target="_black" href="cashbox/print/'.$row__2["id"].'/">'.$row__2["numer"].'</a>';


 if($row__2["prepayment"]==1)
 {
 echo'<span style="border-bottom: 1px solid #ff540e; float:none;" class="status_nana">аванс</span>';						 
 }
 echo'</td>';
                  echo'<td class="no_padding_left_ pre-wrap">'.date_fik($row__2["date_rco"]).'</td>';
/*
echo'<td class="pre-wrap"><span class="per">';

echo MaskDate($row__2["date_begin"]).' - '.MaskDate($row__2["date_end"]);						 

echo'</span></td>';
*/
echo'<td>
<span class="s_j pay_summ boldi">'.rtrim(rtrim(number_format($row__2["summa_rco"], 2, '.', ' '),'0'),'.').'
';
						 
echo'</span></td><td cl_pay="'.$row__2["id"].'">';
if((($row__2["sign_rco"]!=0)and($row__2["id_cash"]!=$row__2["sign_rco"]))or($row__2["sign_rco"]==0))
{
								   $online='';	
				  if(online_user($row__2["timelast"],$row__2["id_s"],$id_user)) { $online='<div class="online"></div>';}	

/*
echo'<div m="'.$row__2["id_cash"].'" style="margin-left: 0px;" data-tooltip="Выписал - '.$row__2["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row__2["id_cash"],'_100x100.jpg"></div>');
*/

echo'<div m="'.$row__2["id_cash"].'" class="pass_wh_trips_2021" style="margin-top: 10px;"><label>Выписал</label><div class="obi">'.$row__2["name_user"].'</div></div>';


}
if($row__2["sign_rco"]!=0)
{
			   $result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.$row__2["sign_rco"].'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);	
					
								   $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}					
					
if(($row__2["id_cash"]==$row__2["sign_rco"]))
{

    /*
echo'<div sm="'.$row__2["sign_rco"].'" style="margin-left: 0px;" data-tooltip="Провел - '.$rowxs["name_user"].'" class="user_soz n_yes send_mess">'.$online.avatar_img('<img src="img/users/',$row__2["sign_rco"],'_100x100.jpg"></div>');
    */

echo'<div sm="'.$row__2["sign_rco"].'" class="pass_wh_trips_2021" style="margin-top: 10px;"><label>Провел</label><div class="obi">'.$rowxs["name_user"].'</div></div>';



} else {
	
	/*echo'<div sm="'.$row__2["sign_rco"].'"  data-tooltip="Провел - '.$rowxs["name_user"].'" class="user_soz n_yes send_mess">'.$online.avatar_img('<img src="img/users/',$row__2["sign_rco"],'_100x100.jpg"></div>');
*/
    echo'<div sm="'.$row__2["sign_rco"].'" class="pass_wh_trips_2021" style="margin-top: 10px;"><label>Провел</label><div class="obi">'.$rowxs["name_user"].'</div></div>';

}				

}

if($row__2["cashless"]==0)
{
    echo'<div class="status-imp-2021">проведен</div><div></div>';

/*

echo'<div data-tooltip="проведен" class="user_soz naryd_yes"></div>
<div class="status_nana">проведен - <a target="_blank" class="scan_pay" href="implementer/scan/'.$row__2["file_name"].'">скан</a></div>';

*/

    $query_string='';
    $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="14" and A.visible=1 and A.id_object="' . ht($row__2["id"]) . '"');

    $num_results_uu = $result_6->num_rows;

    $class_aa = '';
    $style_aa = '';
    if ($num_results_uu != 0) {
        $class_aa = 'eshe-load-file';
        $style_aa = 'style="display: block;"';
    }


    $query_string .= '<div style="display: inline-block" class=""><div class="img_invoice_div1 js-image-gl"><div style="display: inline-block"><div class="list-image list-image-icons" ' . $style_aa . '>';

    if ($num_results_uu != 0) {
        $i = 1;
        while ($row_6 = mysqli_fetch_assoc($result_6)) {
            $query_string .= '	<div number_li="' . $i . '" class="li-image yes-load"><span class="name-img"><a href="/upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '">' . $row_6["name_user"] . '</a></span>';

            $query_string .= '<span class="type-img">'.$row_6["type"].'</span>';

            //$query_string .= '<span class="del-img js-dell-image" id="' . $row_6["name"] . '"></span>';


            $query_string .= '<div class="progress-img"><div class="p-img" style="width: 0px; display: none;"></div></div></div>';
            $i++;
        }
    }


    $query_string .= '</div></div>';







    $query_string .= '</div></div>';
echo $query_string;




} else
{
    /*
$echo.='<div data-tooltip="проведен по безналичному расчету" class="user_soz naryd_yes"></div>
<div class="status_nana">проведен по безналу</div>';
echo'<div data-tooltip="проведен по безналичному расчету" class="user_soz naryd_yes"></div>
<div class="status_nana">проведен по безналу</div>';
*/
    echo'<div class="status-imp-2021 status-imp-2022">проведен по безналу</div><div></div>';



}	
	

} else
{
	/*
echo'<div id_upload="'.$row__2["id"].'" data-tooltip="загрузить кассовый ордер" class="user_soz naryd_upload"></div>';	
echo'<form  class="form_up" id="upload_sc_'.$row__2["id"].'" id_sc="'.$row__2["id"].'" name="upload'.$row__2["id"].'"><input class="sc_sc_loo" type="file" name="myfile'.$row__2["id"].'"></form><div class="loaderr_scan scap_load_'.$row__2["id"].'"><div class="scap_load__" style="width: 0%;"></div></div>';
*/






    $query_string='';
    $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="14" and A.visible=1 and A.id_object="' . ht($row__2["id"]) . '"');

    $num_results_uu = $result_6->num_rows;

    $class_aa = '';
    $style_aa = '';
    if ($num_results_uu != 0) {
        $class_aa = 'eshe-load-file';
        $style_aa = 'style="display: block;"';
    }


    $query_string .= '<div style="display: inline-block" class=""><div class="img_invoice_div1 js-image-gl"><div style="display: inline-block"><div class="list-image list-image-icons" ' . $style_aa . '>';
/*
    if ($num_results_uu != 0) {
        $i = 1;
        while ($row_6 = mysqli_fetch_assoc($result_6)) {
            $query_string .= '	<div number_li="' . $i . '" class="li-image yes-load"><span class="name-img"><a href="/upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '">' . $row_6["name_user"] . '</a></span>';

            $query_string .= '<span class="type-img">'.$row_6["type"].'</span>';

            $query_string .= '<span class="del-img js-dell-image" id="' . $row_6["name"] . '"></span>';


            $query_string .= '<div class="progress-img"><div class="p-img" style="width: 0px; display: none;"></div></div></div>';
            $i++;
        }
    }
*/

    $query_string .= '</div></div>';



    $query_string .= '<input type="hidden" class="js-files-acc-new" name="files_9" value=""><div type_load="14" id_object="' . ht($row__2["id"]) . '" data-tooltip="загрузить кассовый ордер" class="invoice_upload js-upload-file js-helps ' . $class_aa . ' upload-but-2021 upload-but-2023" style="background-color: #fff !important;" ></div>';







    $query_string .= '</div></div>';


    echo $query_string;








	/*
echo'<div id_bez="'.$row__2["id"].'" data-tooltip="безналичный расчет" class="user_soz beznal_upload beznal_upload_2021"></div>';*/

    echo'<div id_bez="'.$row__2["id"].'" data-tooltip="безналичный расчет" class="user_soz beznal_upload beznal_upload_2021"></div>';


}
					  

echo'</td>';


echo'


 <td or_pay="'.$row__2["id"].'">';
if (($role->permission('Касса','A'))or($sign_admin==1))
{	
						 
if($row__2["sign_rco"]==0)
{

						 echo'<div class="font-rank del_pay" data-tooltip="Удалить" id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div>';
}
if($row__2["sign_rco"]!=0)
{
						 echo'<div class="font-rank rasp_pay" data-tooltip="Распровести" id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div>';
	
}
}
	echo'</td><td></td>		   
		   
		   </tr>';	  
						 
					 }
					  
echo'</tbody></table>'; 
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_cash").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';	 
					  
		/*			  
	  $count_pages=CountPage($sql_count,$link,$count_write);
	  if($count_pages>1)
	  {
		  if(isset($_GET["by"]))
		  {
			displayPageLink_new('cashbox/'.$_GET["by"].'/','cashbox/'.$_GET["by"].'/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);	  
		  } else
		  {
			  displayPageLink_new('cashbox/','fcashbox/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
		  }
	    
	  }
		*/			  
					  
 }


	  
//Вывод его нарядов


			   	   $result_t2=mysql_time_query($link,'Select a.* from n_nariad as a where a.id_implementer="'.htmlspecialchars(trim($_GET['id'])).'" order by a.date_create desc');
	  
  
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {



                      include_once '../ilib/lib_interstroi.php';
                      include_once '../ilib/lib_edo.php';

                      $edo = new EDO($link,$id_user,false);


					  
			echo'<br><br><h3 class="head_h j_n_cash" style=" margin-bottom:0px;">Наряды исполнителя<div></div></h3>';




                      echo '<div class="ring_block ring-block-line js-global-preorders-link">';
                      $small_block=1;
                      for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                      {
                          $value= mysqli_fetch_assoc($result_t2);
                          $new_pre = 1;
                          $task_cloud_block='';



                          include $url_system . 'worder/code/block_worder.php';
                          echo($task_cloud_block);

                      }

                      echo'</div>';



			/*

					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Номер</th><th class="t_1">Статус</th><th class="t_2 no_padding_left_">Объект/Период Наряда</th><th class="t_8">Итого работа/материал</th><th class="t_10"></th><th class="t_1"></th></tr></thead><tbody>';
	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {     
                       $row__2= mysqli_fetch_assoc($result_t2);	  
                       //узнаем название 						 
				$result_t22=mysql_time_query($link,'Select a.implementer from i_implementer as a where a.id="'.$row__2["id_implementer"].'"');
                $num_results_t22 = $result_t22->num_rows;
	            if($num_results_t22!=0)
	            {
					$row_t22 = mysqli_fetch_assoc($result_t22);
                   // echo'<a class="musa" href="implementer/'.$row_t2["id"].'/"><span class="s_j">'.$row_t2["implementer"].'</span></a>';
				}
$cll='';
if($row__2["signedd_nariad"]==1)
{
  $cll='whites';
}
					
echo'<tr class="nary n1n '.$cll.'" rel_id="'.$row__2["id"].'"><td></td><td class="middle_"><a href="finery/'.$row__2["id"].'/">№'.$row__2["id"].'</a></td><td>';


	   //смотрим подписан ли он создателем
	   $hie1 = new hierarchy($link,$row__2["id_user"]);
	   $sign_level1=$hie1->sign_level;
       $sign_admin1=$hie1->admin;
	   $stack_users = array();		
	   for ($is=($sign_level1-1); $is<=3; $is++)
       {
		   		if($row__2["id_signed".$is]!=0)
				{
					  array_push($stack_users, $row__2["id_signed".$is]); 
				}

	   }
	  // print_r($stack_users);
	   for ($is=0; $is<count($stack_users); $is++)
       {	
		   if(($is==0)and($stack_users[$is]==$row__2["id_user"]))
		   {
			   $result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.htmlspecialchars(trim($stack_users[$is])).'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);
					$online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}
			   echo'<div  sm="'.$stack_users[$is].'"  data-tooltip="Создан/Подписан - '.$rowxs["name_user"].'" class="user_soz n_yes send_mess">'.$online.avatar_img('<img src="img/users/',$stack_users[$is],'_100x100.jpg"></div>');
				}
		   } else
		   {
			   if(($is==0))
			   {
				   $result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.htmlspecialchars(trim($row__2["id_user"])).'"');
	               if($result_txs->num_rows!=0)
	               {   
		       
		            $rowxs = mysqli_fetch_assoc($result_txs);
					   $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}
				    echo'<div sm="'.$row__2["id_user"].'"  data-tooltip="Создан - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row__2["id_user"],'_100x100.jpg"></div>');	
		           }
			   }
			    $hiex = new hierarchy($link,$stack_users[$is]);
	            $sign_levelx=$hiex->sign_level;
                $sign_adminx=$hiex->admin;
			    $but_text='Подписан';
			   //echo($is);
			    if(($sign_adminx!=1)and($sign_levelx==2)and($row__2["signedd_nariad"]==1)and(($is+1)==count($stack_users)))
				{
					$but_text='Утвержден';
				}
			   	if(($sign_adminx!=1)and($sign_levelx==2)and($row__2["signedd_nariad"]!=1))
				{
					$but_text='Согласовать';
				}
			   	if(($sign_adminx!=1)and($sign_levelx==2)and($row__2["signedd_nariad"]==1)and(($is+1)<count($stack_users)))
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
			      echo'<div sm="'.$stack_users[$is].'"  data-tooltip="'.$but_text.' - '.$rowxs["name_user"].'" class="user_soz n_yes send_mess">'.$online.avatar_img('<img src="img/users/',$stack_users[$is],'_100x100.jpg"></div>');
				}
		   }
		   
		   
	   }
	//если нет подписанных то выводит просто создателя наряда
	if(count($stack_users)==0)
	{
		$result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.htmlspecialchars(trim($row__2["id_user"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
			$online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}
		echo'<div sm="'.$row__2["id_user"].'"  data-tooltip="Создан - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row__2["id_user"],'_100x100.jpg"></div>');
	    }
	}
	
	if($row__2["signedd_nariad"]==1)
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
		if(($row__2["id_signed0"]!=0)and($row__2["id_signed1"]==0)and($row__2["signedd_nariad"]==0)and($slyjj==0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}
		if(($row__2["id_signed0"]!=0)and($row__2["id_signed1"]==0)and($row__2["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на согласование</div>';
		}		
		if(($row__2["id_signed1"]!=0)and($row__2["signedd_nariad"]==0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}	
		if(($row__2["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}	
	}
	if(($sign_level==2)and($sign_admin!=1))
	{	
        if(($row__2["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}
		
		if(($podpis==0)and($slyjj!=0)and($row__2["signedd_nariad"]==0))
		{
			echo'<div class="status_nana">Подписан на утверждение</div>';	
		}			
	}
	if(($sign_level==3)and($sign_admin!=1))
	{	
        if(($row__2["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}
	}
	
	if(($sign_admin==1))
	{
		if(($row__2["id_signed0"]!=0)and($row__2["id_signed1"]==0)and($row__2["signedd_nariad"]==0)and($slyjj==0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}
		if(($row__2["id_signed0"]!=0)and($row__2["id_signed1"]==0)and($row__2["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на согласование</div>';
		}
		if(($row__2["id_signed0"]!=0)and($row__2["id_signed1"]!=0)and($row__2["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}	
	
		if(($row__2["id_signed0"]==0)and($row__2["id_signed1"]!=0)and($row__2["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}			
		if(($row__2["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}		
	}						 
						 
						 
						 
						 echo'</td>';
                  //echo'<td class="no_padding_left_ pre-wrap"><a href="implementer/'.$row__2["id_implementer"].'/"><span class="s_j">'.$row_t22["implementer"].'</span></a></td>';

echo'<td><span class="per1">';
						 
        $result_town=mysql_time_query($link,'select C.object_name,B.town,A.kvartal from i_kvartal as A,i_town as B,i_object as C where C.id_kvartal=A.id and A.id_town=B.id and C.id="'.$row__2["id_object"].'"');
        
		$num_results_custom_town = $result_town->num_rows;
        
		if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);
			echo($row_town["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')');
			echo '<br>'.MaskDate($row__2["date_begin"]).' - '.MaskDate($row__2["date_end"]);
		}
		
						 
					
 echo'</span></td>
<td><span class="s_j"><strong>'.rtrim(rtrim(number_format($row__2["summa_work"], 2, '.', ' '),'0'),'.').'</strong> / <span class="s_j">'.rtrim(rtrim(number_format($row__2["summa_material"], 2, '.', ' '),'0'),'.').'</span></td>';


 echo'<td>';
$podpis=0;  //по умолчанию нельзя редактировать подписана свыше
if((sign_naryd_level($link,$id_user,$sign_level,$row__2["id"],$sign_admin)))
{
	$podpis=1;
}						 
if($podpis!=0)
{
						 echo'<div class="font-rank del_naryd"  id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div>';
}
	
	echo'</td><td></td>		   
		   
		   </tr>';	  
						 
					 }
					  
echo'</tbody></table>'; 
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_1").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';	 
					  
					  

		*/
					  
 }	  
	  
	  
	  
?>

     
        
  <?       

	
    ?>
    </div>
  </div>

</div>

<?
include_once $url_system.'template/left.php';
?>
                      </div></div></div>
</div>
</div><script src="Js/rem.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function (){
        NumberBlockFile();
    });


<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
</div>

</body></html>