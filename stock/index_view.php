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

if((!$role->permission('Склад','R'))and($sign_admin!=1))
{
  header404(3,$echo_r);
}


$result_url=mysql_time_query($link,'select A.* from z_stock as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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





include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('stock_view','','','',$link); } else { SEO('0','','','',$link); }

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
    echo'<div class="iss big">';
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

	  include_once $url_system.'template/top_stock_view.php';

echo'<div id="fullpage" class="margin_60  input-block-2020 ">
    <div class="oka_block_2019" style="min-height:auto;">
 <div class="oka_block">
<div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">';
 
    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?



  $result_t2=mysql_time_query($link,'Select DISTINCT b.id_user,(SELECT sum(a.count_units) as ccc from z_stock_material as a where a.id_user=b.id_user  and a.id_stock="'.htmlspecialchars(trim($_GET['id'])).'") as ccv FROM z_stock_material as b WHERE b.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');	  
  
	 $sql_count='Select count(DISTINCT b.id_user) as kol from z_stock_material as b where b.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"';

	
$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);	  

 
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
	echo' <h3 class="head_h" style=" margin-bottom:0px;">Пользователи на которых числится<i>'.$row__221["kol"].'</i><div></div></h3> ';	 				  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2 stock_table_list"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Пользователь</th><th class="t_1"></th><th class="t_1">Количество</th><th class="t_8">Ед. Изм.</th><th class="t_10"></th></tr></thead><tbody>';

	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {

					$row__2= mysqli_fetch_assoc($result_t2);

						 
echo'<tr class="nary n1n suppp_tr" idu_stock="'.$row__2["id"].'"><td class="middle_"><div class="supply_tr_o1"></div></td><td colspan="2" class="middle_"><div class="nm supl">';

						 $result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row__2["id_user"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
		}
		echo'<a class="s_j send_mess" sm="'.$row__2["id_user"].'">'.$rowxs["name_user"].'</a></div>';				 
						 
echo'</td>';
						 
echo'<td style="white-space:nowrap;">';
						 
echo '<span class="count_stock_x">'.$row__2["ccv"].'</span>';
			 
echo'</td>';						 
			 

echo'<td>';

echo($row_list["units"]);			 
				 
						 
echo'</td>';
	
	

 echo'<td></td>		   
		   
		   </tr>';		

	
echo'<tr idu_stock="'.$row__2["id"].'" class="tr_dop_supply_line"><td colspan="6"></td></tr>';						 


	

					  
						 
					 }
$result_xp=mysql_time_query($link,'SELECT sum(b.count_units) as cc FROM z_stock_material as b WHERE b.id_stock="'.htmlspecialchars(trim($row_list["id"])).'"');
					        	 
$num_results_xp = $result_xp->num_rows;
if($num_results_xp!=0)
{  
		//такая работа есть
		$row_xp = mysqli_fetch_assoc($result_xp);

}
	
echo'<tr idu_stock="'.$row__2["id"].'" class="tr_dop_supply_line itogss"><td></td><td colspan="2">Итого всего наименования</td><td><span class="count_stock_x">'.$row_xp["cc"].'</span></td><td>'.$row_list["units"].'</td><td></td></tr>';						  
					  
					  
echo'</tbody></table>'; 
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_1").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';	 
					  
								  
 }

	  

$result_t2=mysql_time_query($link,'SELECT DISTINCT A.id,A.material,A.count_units,A.id_razdel2 FROM i_material as A WHERE A.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');	  
  
$sql_count='Select count(DISTINCT A.id) as kol FROM i_material as A WHERE A.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"';

	
$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);	  

 
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
	echo' <br><h3 class="head_h" style=" margin-bottom:0px;">Связи в себестоимостях <i>'.$row__221["kol"].'</i><div></div></h3> ';	 				  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_2" class="smeta2 stock_table_list"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Себестоимость</th><th class="t_1"></th><th class="t_1">Раздел</th><th class="t_8">Работа</th><th class="t_8">Количество</th><th class="t_10"></th></tr></thead><tbody>';

	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {

					$row__2= mysqli_fetch_assoc($result_t2);

						 
echo'<tr class="nary n1n suppp_tr" idu_stock="'.$row__2["id"].'"><td class="middle_"><div class="supply_tr_o1"></div></td><td colspan="2" class="middle_"><div class="nm supl">';

						 $result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row__2["id_user"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
		}
						 
$result_xp=mysql_time_query($link,'SELECT b.name_working,a.name1,a.id_object FROM i_razdel1 as a,i_razdel2 as b WHERE b.id="'.htmlspecialchars(trim($row__2["id_razdel2"])).'" and b.id_razdel1=a.id');
					        	 
$num_results_xp = $result_xp->num_rows;
if($num_results_xp!=0)
{  
		//такая работа есть
		$row_xp = mysqli_fetch_assoc($result_xp);
	
		 $result_t=mysql_time_query($link,'Select a.id,a.object_name,a.id_town,c.town from i_object as a,i_town as c where a.id_town=c.id and a.id="'.$row_xp["id_object"].'"');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {	
		    $row_t = mysqli_fetch_assoc($result_t);
	   }	
}				 
echo'<a href="prime/'.$row_xp["id_object"].'/" class="s_j">'.$row_t["object_name"].' ('.$row_t["town"].')</a></div>';				 
						 
echo'</td>';
						 
echo'<td style="white-space:nowrap;">';
						 
echo ''.$row_xp["name1"].'';
			 
echo'</td>';						 

echo'<td style="white-space:nowrap;">';
						 
echo ''.$row_xp["name_working"].'';
			 
echo'</td>';						 

echo'<td>';

echo '<span class="count_stock_x">'.$row__2["count_units"].'</span>';		 
				 
						 
echo'</td>';
	
	

 echo'<td></td>		   
		   
		   </tr>';		

	
echo'<tr idu_stock="'.$row__2["id"].'" class="tr_dop_supply_line"><td colspan="7"></td></tr>';						 


	

					  
						 
					 }
echo'</tbody></table>'; 
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_2").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';	 
					  

					  
					  
 }	  

	  

  $result_t2=mysql_time_query($link,'Select DISTINCT b.id_invoice,(SELECT sum(a.count_units) as ccc from z_invoice_material as a where a.id_invoice=b.id_invoice  and a.id_stock="'.htmlspecialchars(trim($_GET['id'])).'") as ccv FROM z_invoice_material as b WHERE b.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"');	  
  
	 $sql_count='Select count(DISTINCT b.id_invoice) as kol from z_invoice_material as b where b.id_stock="'.htmlspecialchars(trim($_GET['id'])).'"';

	
$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);	  

 
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
	echo'<br> <h3 class="head_h" style=" margin-bottom:0px;">Связь в накладных<i>'.$row__221["kol"].'</i><div></div></h3> ';	 				  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_3" class="smeta2 stock_table_list"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Номер накладной</th><th class="t_1"></th><th class="t_1">Статус</th><th class="t_8">Количество</th><th class="t_10"></th></tr></thead><tbody>';

	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {

					$row__2= mysqli_fetch_assoc($result_t2);

						 
echo'<tr class="nary n1n suppp_tr" idu_stock="'.$row__2["id"].'"><td class="middle_"><div class="supply_tr_o1"></div></td><td colspan="2" class="middle_"><div class="nm supl">';

						 $result_txs=mysql_time_query($link,'Select a.* from z_invoice as a where a.id="'.htmlspecialchars(trim($row__2["id_invoice"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
		}
		echo'<a class="s_j" href="invoices/'.$row__2["id_invoice"].'/" >№'.$rowxs["number"].'</a></div>';				 
						 
echo'</td>';
						 
echo'<td style="white-space:nowrap;">';
						 
		//выводим статус заявки 
	$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$rowxs["status"].'" and a.id_system=17');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	
   //$status_class=array("status_z1","Наряды","Служебные записки","Заявки на материалы","Касса","Исполнители");
	
	
	if($rowxs["status"]==3)
	{
       echo'<div class="user_mat naryd_yes" style="margin-left:0px;"></div><div class="status_material1">'.$row_status["name_status"].'</div>';	
	} else
	{
		echo'<div class="status_material2 status_z'.$rowxs["status"].' memo_zay">'.$row_status["name_status"].'</div>';	
	}
}		
			 
echo'</td>';						 
			 

echo'<td>';

echo '<span class="count_stock_x">'.$row__2["ccv"].'</span>';		 
				 			 
				 
						 
echo'</td>';
	
	

 echo'<td></td>		   
		   
		   </tr>';		

	
echo'<tr idu_stock="'.$row__2["id"].'" class="tr_dop_supply_line"><td colspan="6"></td></tr>';						 


	

					  
						 
					 }
echo'</tbody></table>'; 
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_3").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';	 
					  
								  
 }	  
	  
?>

       
        
  <?       

	
    ?>
    </div>
  </div>

</div>
</div></div></div></div>
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

<script type="text/javascript">
 $(document).ready(function(){ 
$('.circlestat').circliful();	
 });
</script>


</body></html>