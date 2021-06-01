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


$active_menu='notification';


$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

//index.php не должно быть в $url_404
if (strripos($url_404, 'index.php') !== false) {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
}

if ( count($_GET) == 0 ) //--Если были приняты данные из HTML-формы
{

	 
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

//делаем автоматически все уведомления просмотренными
$stack_new = array();  // общий массив ошибок


$result_t2=mysql_time_query($link,'select A.id from r_notification as A where A.status=1 and  A.id_user="'.htmlspecialchars(trim($id_user)).'"');
$num_results_t2 = $result_t2->num_rows;
if($num_results_t2!=0)
{
   for ($ksss=0; $ksss<$num_results_t2; $ksss++)
   {     
      $row__2= mysqli_fetch_assoc($result_t2);	
	  array_push($stack_new, $row__2["id"]); 
   }
}



mysql_time_query($link,'update r_notification set status="0" where id_user = "'.htmlspecialchars(trim($id_user)).'"');


include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('notification','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php'; include $url_system.'template/head.php';
?>
</head><body><div class="container">
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

	  //include_once $url_system.'template/top_implementer_view.php';


    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?


	  

//echo' <h3 class="head_h" style=" margin-bottom:0px;">'.$row_list["implementer"].'<div></div></h3>';


  	     
	  $result_t2=mysql_time_query($link,'select A.* from r_notification as A where  A.id_user="'.htmlspecialchars(trim($id_user)).'" order by A.datetime desc');
	  $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
	echo' <h3 class="head_h" style=" margin-bottom:0px;">Ваши Уведомления<div></div></h3>';				  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_cash" class="smeta2 notif_imp"><tbody>';
					  $date_paid='';	
	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {     
                       $row__2= mysqli_fetch_assoc($result_t2);	  
                     $opl=0;	
$cll='';
$found1 = array_search($row__2["id"],$stack_new);   
if($found1 !== false) 
{
  $cll='blues';
}
						 
	$ddd  = explode(" ",$row__2["datetime"]);	 
$day_raz=dateDiff_1(date('Y-m-d'),$ddd[0]);			

			
			if($ddd[0]!=$date_paid)
			{
			  $date_paid=$ddd[0]; $opl=1;	
			  $mess=time_stamp_mess($row__2["datetime"]);
			}
			
		if($opl==1)	
	{
		if($ksss!=0)
		{
		echo'<tr style="height:50px;" class="tr_dop_supply_line"><td colspan="5"><td></tr>';
		}
		
		echo'<tr class="tr_dop_supply_line"><td colspan="5"><div class="message_date"><div><span style=" font-family: "GEInspiraBold"; font-size: 14px;">'.$mess.'</span></div></div></td></tr>';	
	}					 
					
echo'<tr class="nary n1n '.$cll.'" rel_noti="'.$row__2["id"].'"><td>';
if($found1 !== false) 
{
						 echo'<div class="bbo"><i class="Effectbbo"></i></div>';
}
							 
							 echo'</td>';
echo'<td class="no_padding_left_ pre-wrap">';
/*
			   $result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.$row__2["sign_user"].'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);
					$online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}
				  echo'<div sm="'.$row__2["sign_user"].'" style="margin-left: 0px;" class="user_soz send_mess">'.$online.'<img src="img/users/'.$row__2["sign_user"].'_100x100.jpg"></div>';
				}
*/
						 
		$result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row__2["sign_user"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
											  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}		
		echo'<div  sm="'.$row__2["sign_user"].'"   data-tooltip="'.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row__2["sign_user"],'_100x100.jpg">').'</div>';
	    }						 
						 
echo'</td>';


/*
echo'<td class="pre-wrap"><span class="per">';

echo MaskDate($row__2["date_begin"]).' - '.MaskDate($row__2["date_end"]);						 

echo'</span></td>';
*/
echo'<td style="padding-top:30px; padding-bottom:30px;"><span class="s_j notif_text">';
echo htmlspecialchars_decode($row__2["notification"]).'<br><span class="time_notifi">'.time_stamp($row__2["datetime"]).'</span>';
					 
						 
echo'</span></td>';
echo'


 <td or_pay="'.$row__2["id"].'">';

						 


 echo'<div class="font-rank del_notif" data-tooltip="Удалить" id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div>';

	
	echo'</td><td></td>		   
		   
		   </tr>';	  
						 
					 }
					  
echo'</tbody></table>'; 
 
					  
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


	  
	  
?>

     
        
  <?       

	
    ?>
    </div>
  </div>

</div>

<?
include_once $url_system.'template/left.php';
?>

</div>
</div><script src="Js/rem.js" type="text/javascript"></script>

<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
</div>

</body></html>