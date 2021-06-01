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



$menu_b=array("Все","Заказанные","Исполненные");
	
$menu_title=array("Все Заявки на материалы","Заявки в исполненнии","Исполненные заявки");	
	
$menu_get=array("","orders","okay");
$menu_url=array("","orders/","okay/");
$menu_role_sign0=array(1,1,1);
$menu_role_sign012=array(1,1,1);	
$menu_sql=array();
$menu_sql1=array();	

//все кроме сохраненных чужих
 array_push($menu_sql, 'select count(a.id) as kol from z_doc as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') and (not(a.status=1)or((a.id_user='.$id_user.')and(a.status=1)))');

 array_push($menu_sql1, ' and (not(a.status=1)or((a.id_user='.$id_user.')and(a.status=1)))');
	
//В заказе
 array_push($menu_sql, 'select count(a.id) as kol from z_doc as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') and a.status NOT IN ("1", "8", "10","3","5","4")');

 array_push($menu_sql1, ' and a.status NOT IN ("1", "8", "10","3","5","4")');	

//исполненные
 array_push($menu_sql, 'select count(a.id) as kol from z_doc as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') and a.status="10"');	

 array_push($menu_sql1, ' and a.status="10" ');		
$var_get='by';	



$active_menu='app';  // в каком меню



$count_write=10;  //количество выводимых записей на одной странице

$edit_price=0;
if ($role->is_column_edit('n_material','price'))
{
	$edit_price=1;
}

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

			if (($role->permission('Заявки','R'))or($sign_admin==1)or($role->permission('Заявки','S')))
	        {
			} else
			{
			           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	
			}


if (( count($_GET) == 1 )or( count($_GET) == 0 )or( count($_GET) == 2 )) //--Åñëè áûëè ïðèíÿòû äàííûå èç HTML-ôîðìû
{

 if(( count($_GET) == 1 )and(isset($_GET["n_st"])))
 {
       //на главной по страничкам
         $result_url=mysql_time_query($link,'select a.id from z_doc as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') '.limitPage('n_st',$count_write));
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} 
 } else
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
   } else
   {
	 
   //можно ли этому пользователю смотреть эти побочные страницы
   if((($edit_price==1)and($menu_role_sign012[$found1]==1))or(($menu_role_sign0[$found1]==1)and($edit_price==0)))
   {	 
	 
   } else
   {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	   
   }
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
   if((($edit_price==1)and($menu_role_sign012[$found1]==1))or(($menu_role_sign0[$found1]==1)and($edit_price==0)))
   {	 
	 
	     //есть ли такая страница
	    $result_url=mysql_time_query($link,'select a.id from z_doc as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') '.$menu_sql1[$found1].' '.limitPage('n_st',$count_write));
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
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

if($error_header!=404){ SEO('app','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_prime_app.php';


    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?


//echo'<span class="hh1" style=" margin-bottom:0px;">Наряды</span>';

	
	//echo'</div><div class="content_block block_primes1">';  
	  
	//echo'</div>';
	
	//echo'<div class="content_block1">';	
/*
<div class="close_all_r">закрыть все</div>
<div data-tooltip="Удалить всю себестоимость" class="del_seb"></div>
<div data-tooltip="Добавить раздел" class="add_seb"></div>
';
*/
  
	  
	  	//echo'</div>';  
	
			   	   $result_t2=mysql_time_query($link,'Select a.* from z_doc as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') '.$menu_sql1[$title_key].' order by a.id desc '.limitPage('n_st',$count_write));
	  
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
	
					  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2"><thead>
		   <tr class="title_smeta"><th class="t_1">Номер</th><th class="t_2 no_padding_left_">Создатель</th><th class="t_2 no_padding_left_">Объект</th><th class="t_1">Статус</th><th class="t_10">Дата создания</th><th class="t_10"></th></tr></thead><tbody>';
					  
	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {						 
                       $row__2= mysqli_fetch_assoc($result_t2);
	
	
				$result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row__2["id_object"])).'"');
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
	
	
                       //узнаем название 						 
				$result_t22=mysql_time_query($link,'Select a.implementer from i_implementer as a where a.id="'.$row__2["id_implementer"].'"');
                $num_results_t22 = $result_t22->num_rows;
	            if($num_results_t22!=0)
	            {
					$row_t22 = mysqli_fetch_assoc($result_t22);
                   // echo'<a class="musa" href="implementer/'.$row_t2["id"].'/"><span class="s_j">'.$row_t2["implementer"].'</span></a>';
				}
$cll='';
if($row_t22["status"]==10)
{
  $cll='whites';
}

echo'<tr class="nary n1n '.$cll.'" rel_id="'.$row__2["id"].'"><td class="middle_"><a href="app/'.$row__2["id"].'/">№'.$row__2["number"].'</a></td>';
	
echo'<td>';
		$result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row__2["id_user"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
											  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}		
		echo'<div  sm="'.$row__2["id_user"].'"   data-tooltip="Создан - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row__2["id_user"],'_100x100.jpg">').'</div>';
	    }						 
echo'</td>';						 
						 
echo'<td><span class="per1">';
						 
        
			echo($row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')');
						 
					
 echo'</span></td>	
	
	<td>';

			//выводим статус заявки 
	$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row__2["status"].'" and a.id_system=13');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	
   //$status_class=array("status_z1","Наряды","Служебные записки","Заявки на материалы","Касса","Исполнители");
	
	
	if($row__2["status"]==10)
	{
       echo'<div class="user_mat naryd_yes" style="margin-left:0px;"></div><div class="status_material1">'.$row_status["name_status"].'</div>';	
	} else
	{
		echo'<div class="status_material2 status_z'.$row__2["status"].' memo_zay">'.$row_status["name_status"].'</div>';	
	}
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

 echo'<td>';
						 
echo time_stamp_mess($row__2["date_create"]).', '.time_stamp_time($row__2["date_create"]);					 
						 
	echo'</td>';	
	
 echo'<td>';
						 					 
$os = array("3", "1", "8", "5", "4");
if (((in_array($row__2["status"], $os))and($row__2["id_user"]==$id_user))or(($sign_admin==1)and(in_array($row__2["status"], $os))))
{ 
  echo'<div data-tooltip="Удалить заявку" class="font-rank del_zay_zay"  id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div>';
}

	
	echo'</td>		
		   
		   </tr>';		

	
	
	
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
			displayPageLink_new('app/'.$_GET["by"].'/','app/'.$_GET["by"].'/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);	  
		  } else
		  {
			  displayPageLink_new('app/','app/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
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