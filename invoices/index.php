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



$menu_b=array("Новые","История");
	
$menu_title=array("Накладные новые","История накладных");	
	
$menu_get=array("","old");
$menu_url=array("","old/");
$menu_role_sign0=array(1,1);
$menu_role_sign012=array(1,1);	
$menu_sql=array();
$menu_sql1=array();	

//к оплате
 array_push($menu_sql, 'Select count(DISTINCT b.id) as kol from z_invoice as b where b.status=1');	

 array_push($menu_sql1, '  b.status=1');	

//оплаченные счета
 array_push($menu_sql, 'Select count(DISTINCT b.id) as kol from z_invoice as b ');		
 array_push($menu_sql1, ' ');	


$var_get='by';	



$active_menu='invoices';  // в каком меню


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



if((($role->permission('Накладные','R')))or($sign_admin==1)){} else
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
	   
	    if(($_GET["by"]=='old'))
		{
	    $result_url=mysql_time_query($link,'select b.id from z_invoice as b where '.$menu_sql1[$found1].' '.limitPage('n_st',$count_write));
			
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
		 

	    $result_url=mysql_time_query($link,'select b.id from z_invoice as b where '.$menu_sql1[0].' '.limitPage('n_st',$count_write));
			
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

if($error_header!=404){ SEO('invoices','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_invoices.php';


    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?



  
	  
	  	//echo'</didv>';  
if(($_GET["by"]=='old'))	
{	  
  $result_t2=mysql_time_query($link,'Select DISTINCT b.* from z_invoice as b '.$menu_sql1[$title_key].' order by b.date_create '.limitPage('n_st',$count_write));
} else
{
  $result_t2=mysql_time_query($link,'Select DISTINCT b.* from z_invoice as b where '.$menu_sql1[$title_key].' order by b.date_create  '.limitPage('n_st',$count_write));	
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
	
					  
				  
				  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2 invoice_table block_invoice_20188"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Накладная</th><th class="t_1">Дата</th><th class="t_1">Сумма</th><th class="t_1">Поставщик</th><th class="t_1">Документы</th><th class="t_1"></th><th class="t_8 center_">Статус</th><th class="t_10"></th></tr></thead><tbody>';
			
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
						 
   	  					 

	   

						 
						 
						 
echo'<tr class="book nary n1n suppp_tr" rel_invoice_="'.$row__2["id"].'"><td class="middle_"></td><td  class="middle_"><div class="nm supl"><a href="invoices/'.$row__2["id"].'/" class="s_j" style="margin-right:10px;">№'. $row__2["number"].'</a>';
						 
		if(($row__2["status"]==1)and(($role->permission('Накладные','A'))or($sign_admin==1)))
		{ 	
			   echo'<div class="font-ranks del_invoice" data-tooltip="Удалить накладную" id_rel="'.$row__2['id'].'"><span class="font-ranks-inner">x</span><div></div></div>';
		}					 
						 
						 echo'</div>';
																		 
echo'</td>';
						 
$ddd='';
		if(strtotime($row__2["date"]) != 0)
		{	
		
		$date_graf3  = explode("-",$row__2["date"]);
			$ddd=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];
		}						 
						 
echo'<td>';

						 echo'<span class="s_j pay_summ_in">'.$ddd.'</span>';
						 
	$result_scorex=mysql_time_query($link,'Select count(b.id) as vv from z_invoice_material as b where b.defect=1 and b.id_invoice="'.htmlspecialchars(trim($row__2['id'])).'"');
    $num_results_scorex = $result_scorex->num_rows;
    if($num_results_scorex!=0)
    {
		$row_scorex = mysqli_fetch_assoc($result_scorex);
		$result_scorex1=mysql_time_query($link,'SELECT COUNT(DISTINCT b.id_invoice_material) AS vv FROM z_invoice_attach_defect AS b,z_invoice_material AS c WHERE b.type_invoice=0 AND b.id_invoice_material=c.id AND c.id_invoice="'.htmlspecialchars(trim($row__2['id'])).'"');
	    $num_results_scorex1 = $result_scorex1->num_rows;
			   
        if($num_results_scorex1!=0)
        {
			$row_scorex1 = mysqli_fetch_assoc($result_scorex1);
			if($row_scorex1["vv"]!=$row_scorex["vv"])
			{
				 echo'<span class="red_akt">Загрузите Акт</span>';
			}
        }
	
	
	
    }
						 
						 


						 
echo'</td>';	
						 
echo'<td>';
	

	 echo'<span class="s_j pay_summ" style="border-bottom: 2px solid #24c32d;">'.rtrim(rtrim(number_format($row__2["summa"], 2, '.', ' '),'0'),'.').'</span>';

						 
echo'</td>';						 

						 
						 
						 
echo'<td>'.$row_t1["name"].'</td>

<td>';
$result_score=mysql_time_query($link,'Select a.* from z_invoice_attach as a where a.id_invoice="'.htmlspecialchars(trim($row__2['id'])).'"');
	


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
		
	echo'<li sop="'.$row_score["id"].'"><a target="_blank" href="invoices/scan/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].'" rel="'.$row_score["id"].'"><div style=" background-image: url(invoices/scan/'.$row_score["id"].'_'.$row_score["name"].'.jpg)"></div></a></li>'; 
		} else
		{
		echo'<li sop="'.$row_score["id"].'"><a target="_blank" href="invoices/scan/'.$row_score["id"].'_'.$row_score["name"].'.'.$row_score["type"].'" rel="'.$row_score["id"].'"><div class="doc_pdf1">'.$row_score["type"].'</div></a></li>'; 
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

						 						 
		//выводим статус заявки 
	$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row__2["status"].'" and a.id_system=17');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	
   //$status_class=array("status_z1","Наряды","Служебные записки","Заявки на материалы","Касса","Исполнители");
	
	
	if($row__2["status"]==3)
	{
       echo'<div class="user_mat naryd_yes" style="margin-left:0px;"></div><div class="status_material1">'.$row_status["name_status"].'</div>';	
	} else
	{
		echo'<div class="status_material2 status_z'.$row__2["status"].' memo_zay">'.$row_status["name_status"].'</div>';	
	}
}						 

echo'</td>';
	
	
	


 echo'</tr>';		

					 
						 
echo'<tr rel_invoice_="'.$row__2["id"].'" id_book="'.$row__2["id"].'" class="tr_dop_supply_line '.$sql_su4.'"><td colspan="9"></td></tr>';						  
						 
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