<?
//бухгалтерия
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



$menu_b=array("К оплате","Оплаченные");
	
$menu_title=array("Счета необходимые оплатить","История оплаченных счетов");	
	
$menu_get=array("","paid");
$menu_url=array("","paid/");
$menu_role_sign0=array(1,1);
$menu_role_sign012=array(1,1);	
$menu_sql=array();
$menu_sql1=array();	

//к оплате
 array_push($menu_sql, 'Select count(DISTINCT b.id) as kol from z_acc as b where  b.status=3');	

 array_push($menu_sql1, ' b.status=3 ');	

//оплаченные счета
 array_push($menu_sql, 'Select count(DISTINCT b.id) as kol from z_acc as b where  b.status=4');		
 array_push($menu_sql1, ' b.status=4 ');	


$var_get='by';	



$active_menu='booker';  // в каком меню


$count_write=20;  //количество выводимых записей на одной странице
$edit_price=1;



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



if((($role->permission('Бухгалтерия','R')))or($sign_admin==1)){} else
{
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	
}


if (( count($_GET) == 1 )or( count($_GET) == 0 )or( count($_GET) == 2 )) //--Åñëè áûëè ïðèíÿòû äàííûå èç HTML-ôîðìû
{
 if(( count($_GET) == 1 )and(isset($_GET["by"])))
 {
   //не на главной в побочных страницах
   
   $found1 = array_search($_GET["by"],$menu_get);   
   if($found1 === false)
   {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	   
   } 
	 
 } else
 {
 if(( count($_GET) == 2 )and(isset($_GET["by"]))and(isset($_GET["n_st"])))
 {	 
	 
	 //проверить может ли он туда заходить и есть ли такая страница
	    $found1 = array_search($_GET["by"],$menu_get);   
   if($found1 === false)
   {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	   
   } else
   {
	 
   //можно ли этому пользователю смотреть эти побочные страницы
	 
	     //есть ли такая страница
	   
	    if(($_GET["by"]=='paid'))
		{
	    $result_url=mysql_time_query($link,'select b.id from z_acc as b where '.$menu_sql1[$found1].' '.limitPage('n_st',$count_write));
			
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} 
		}

	   
	   
	   
  
   }
	 
	 
 } else
 {
	 if((isset($_GET["n_st"]))and(count($_GET)==1))
	 {
		 

	    $result_url=mysql_time_query($link,'select b.id from z_acc as b where '.$menu_sql1[0].' '.limitPage('n_st',$count_write));
			
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} 
		 
		 
	 } else
	 {
	 
	 if(count($_GET) == 0)
	 {
	 } else
	 {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
	 }
	 }
 }
 }
 
	
	

	
} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}

if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы

include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('booker','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_booker.php';


    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?



  
	  
	  	//echo'</div>';  
if(($_GET["by"]=='paid'))	
{	  
  $result_t2=mysql_time_query($link,'Select DISTINCT b.* from z_acc as b where '.$menu_sql1[$title_key].' order by b.date_paid desc  '.limitPage('n_st',$count_write));
} else
{
  $result_t2=mysql_time_query($link,'Select DISTINCT b.* from z_acc as b where '.$menu_sql1[$title_key].' order by b.date_buy  '.limitPage('n_st',$count_write));	
}
   //запрос для определения общего количества = 
	  /*
   $sql_count='select count(a.id) as kol from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).')';
*/
	  $sql_count=$menu_sql[$title_key];
$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);	  

echo' <h3 class="head_h" style=" margin-bottom:0px;">'.$menu_title[$title_key].'<i>'.$row__221["kol"].'</i><div></div></h3> ';	  
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
					  
				  
				  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2 booker_table"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Счет</th><th class="t_1">Сумма</th><th class="t_1">Оплатить</th><th class="t_1">Поставщик</th><th class="t_1">Документы</th><th class="t_1"></th><th class="t_8 center_">Действия</th><th class="t_10"></th></tr></thead><tbody>';
			
			$date_paid='';		  
					  
					  
	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {
						 


					$row__2= mysqli_fetch_assoc($result_t2);
	
							 
						 
						 
	
$cll='';
if($row__2["status"]==10)
{
  $cll='whites';
}
	if($ksss!=0)
	{		
	//echo'<tr><td colspan="8" height="20px"></td></tr>';	
	}	
						 
						 
$result_t1=mysql_time_query($link,'Select a.* from z_contractor as a where a.id="'.$row__2["id_contractor"].'"');
           $num_results_t1 = $result_t1->num_rows;
	       if($num_results_t1!=0)
	       {	
			   $row_t1 = mysqli_fetch_assoc($result_t1);
		   }
		$opl=0;	
		$mess='';
						 
   	  					 
	if($row__2["status"]==3)		
	{
	$day_raz=dateDiff_1(date('Y-m-d'),$row__2["date_buy"]);		
	if(($ksss==0)and(($row__2["date_buy"]=='0000-00-00')or($row__2["date_buy"]==date("Y-m-d"))or($day_raz>0)))
	{
      $date_paid=$row__2["date_buy"]; $opl=1;
	  $mess='Оплатить Сегодня';						 
	} else
	{
		if($ksss==0)
		{
			$date_paid=$row__2["date_buy"]; $opl=1;	
			$mess='Оплатить '.time_stamp_mess($row__2["date_buy"].' 00:00:00');
	    } else
		{
			
			if(($row__2["date_buy"]!=$date_paid)and($row__2["date_buy"]!=date("Y-m-d"))and($day_raz<=0))
			{
			  $date_paid=$row__2["date_buy"]; $opl=1;	
			  $mess='Оплатить '.time_stamp_mess($row__2["date_buy"].' 00:00:00');
			}
			
		}
	}
	} else
	{
$day_raz=dateDiff_1(date('Y-m-d'),$row__2["date_paid"]);			

			
			if($row__2["date_paid"]!=$date_paid)
			{
			  $date_paid=$row__2["date_paid"]; $opl=1;	
			  $mess=time_stamp_mess($row__2["date_paid"].' 00:00:00');
			}
			
		
			
		
	}
	if($opl==1)	
	{
		echo'<tr style="height:50px;" id_book="'.$row__2["id"].'" class="tr_dop_supply_line '.$sql_su4.'"><td colspan="9"><td></tr><tr id_book="'.$row__2["id"].'" class="tr_dop_supply_line '.$sql_su4.'"><td colspan="9"><div class="message_date"><div><span style=" font-family: "GEInspiraBold"; font-size: 14px;">'.$mess.'</span></div></div></td></tr>';	
	}
	
	   

						 
						 
						 
echo'<tr class="book nary n1n suppp_tr" rel_id="'.$row__2["id"].'"><td class="middle_"></td><td  class="middle_"><div class="nm supl"><span class="s_j">Счет №'. $row__2["number"].'</span></div>';
$date_graf2  = explode("-",$row__2["date"]);
					   echo'<span class="stock_name_mat">от '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</span>';	
											 
						 
echo'</td>';
						 
$ddd='';                                
if($row__2["status"]!=4)
{

			   		$date_delivery=date_step(date('Y-m-d'),$row__2["delivery_day"]);	
} else
{
		$date_delivery=date_step($row__2["date_paid"],$row__2["delivery_day"]);	
}
			   
		$date_graf3  = explode("-",$date_delivery);	


		if(strtotime($date_delivery) != 0)
		{	
		
		//$date_graf3  = explode("-",$row__2["date_delivery"]);
			$ddd=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];
		}						 
						 
echo'<td>';

						 echo'<span class="s_j pay_summ">'.rtrim(rtrim(number_format($row__2["summa"], 2, '.', ' '),'0'),'.').'</span>';

if($ddd!='')
{
	echo'<div class="stock_name_mat">доставка ~ '.$ddd.'</div>';	
}
						 
echo'</td>';	
						 
echo'<td>';
	
if(($row__2["path_summa"]!='')and($row__2["path_summa"]!=0))
{
	 echo'<span class="s_j pay_summ" style="border-bottom: 2px solid #24c32d;">'.rtrim(rtrim(number_format($row__2["path_summa"], 2, '.', ' '),'0'),'.').'</span>';
	
} else
{
	 echo'<span class="s_j pay_summ" style="border-bottom: 2px solid #24c32d;">'.rtrim(rtrim(number_format($row__2["summa"], 2, '.', ' '),'0'),'.').'</span>';
}
						 
echo'</td>';						 
						 
						 
echo'<td>'.$row_t1["name"].'</td><td>';
$result_score=mysql_time_query($link,'Select a.* from z_acc_attach as a where a.id_acc="'.htmlspecialchars(trim($row__2['id'])).'"');
	


$num_results_score = $result_score->num_rows;
if($num_results_score!=0)
{
	echo'<div class="img_ssoply_bill" style="display:block;"><ul>';
	for ($ss=0; $ss<$num_results_score; $ss++)
	{			   			  			   
	    $row_score = mysqli_fetch_assoc($result_score);	
		$allowedExts = array("pdf", "doc", "docx","jpg","jpeg"); 
		if(($row_score["type"]=='jpg')or($row_score["type"]=='jpeg'))
		{
		
	echo'<li sop="'.$row_score["id"].'"><a target="_blank" href="supply/scan/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].'" rel="'.$row_score["id"].'"><div style=" background-image: url(supply/scan/'.$row_score["id"].'_'.$row_score["name"].'.jpg)"></div></a></li>'; 
		} else
		{
		echo'<li sop="'.$row_score["id"].'"><a target="_blank" href="supply/scan/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].'" rel="'.$row_score["id"].'"><div class="doc_pdf1">'.$row_score["type"].'</div></a></li>'; 
		}
	}
	echo'</ul></div>';		
}						 
echo'</td>';
echo'<td >';

						 $result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row__2["id_user"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
											  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}		
		echo'<div  sm="'.$row__2["id_user"].'"   data-tooltip="Создал счет - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row__2["id_user"],'_100x100.jpg">').'</div>';
	    }		
						 
						 
echo'</td >';						 
				 
		 
echo'<td colspan="2" class="menu_jjs button_ada_wall">';

	if($row__2["status"]==3)
	{

	echo'<div  data-tooltip="Подтвердить оплату" rel_booker="'.$row__2["id"].'" class="user_mat xvg_yes booker_yes"></div>';	
	} else
	{
					
		$date_graf3  = explode("-",$row__2["date_paid"]);
		$ddd1=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];
						 
						 
		$result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row__2["id_user_paid"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
			
		}
						 
		echo'<div class="mat_memo_zay">ОПЛАЧЕНО<br>'.$rowxs["name_user"].'<br><strong>'.$ddd1.'</strong></div>';				 
	}

echo'</td>';
	
	
	
/*
echo'<td class="pre-wrap"><span class="per">';

echo MaskDate($row__2["date_begin"]).' - '.MaskDate($row__2["date_end"]);						 

echo'</span></td>';
*/

/*						 
echo'<td><span class="s_j"><strong>'.rtrim(rtrim(number_format(($row__2["summa_work"]+$row__2["summa_material"]), 2, '.', ' '),'0'),'.').'</strong>';
if($edit_price==1)
{
  //выводим на сколько привышение если есть
	
}
						 
echo'</span></td>';
*/

 echo'</tr>';		

						 
echo'<tr supply_stock="57" class="tr_dop_supply tr_dop_memo none" style="display: table-row;"><td><span class="zay_str">→</span></td><td colspan="3"><label>Комментарий по оплате</label><div class="mat_memo_zay">'.$row__2["comment_status"].'</div></td><td colspan="2">';
if(($row__2["path_summa"]!='')and($row__2["path_summa"]!=0))
{
   echo'<label>Оплатить частично</label><div class="mat_memo_zay">'.rtrim(rtrim(number_format($row__2["path_summa"], 2, '.', ' '),'0'),'.').'</div>';
}


echo'</td><td colspan="3">';

if(($row__2["date_buy"]!='')and($row__2["date_buy"]!=0))
{
			$date_graf3  = explode("-",$row__2["date_buy"]);
			$ddd=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];
	
	echo'<label>Оплатить после</label><div class="mat_memo_zay">'.$ddd.'</div>';
}	



echo'</td></tr>';						 
						 

						 
						 
						 
						 
echo'<tr id_book="'.$row__2["id"].'" class="tr_dop_supply_line '.$sql_su4.'"><td colspan="9"></td></tr>';						  
						 
					 }
					  
echo'</tbody></table>'; 
					  
					  
				
					  
					  
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_1").freezeHeader({\'offset\' : \'67px\'}); });
				  </script>';	 
					  
					  
	  $count_pages=CountPage($sql_count,$link,$count_write);
	  if($count_pages>1)
	  {
		  if(isset($_GET["by"]))
		  {
			displayPageLink_new('booker/'.$_GET["by"].'/','booker/'.$_GET["by"].'/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);	  
		  } else
		  {
			  displayPageLink_new('booker/','booker/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
		  }
	    
	  }
					  
					  
 }
	  
?>

    <script>
$(document).ready(function(){
		
	
	var tabs = $('#tabs2017');
		
	
    //$('.tabs-content > div.tb', tabs).each(function(i){ if ( i != 0 ) { $(this).hide(0); }});
   
	
	
	tabs.on('click', '.tab', function(e){

		$(this).children('a')[0].click();
		
	});
	function tabs_activation(tabs)
	{
		tabs.find(".slider").css({left: tabs.find('li.active').position().left + "px",width: tabs.find('li.active').width()+"px"});
    };	

	tabs_activation(tabs);
	
	   });	

	</script>         
        
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