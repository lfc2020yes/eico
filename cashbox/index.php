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



$menu_b=array("задолженность","Все");
	
$menu_title=array("Исполнители которым должны","Все исполнители");	
	
$menu_get=array("","all");
$menu_url=array("","all/");
$menu_role_sign0=array(1,1);
$menu_role_sign012=array(1,1);	
$menu_sql=array();
$menu_sql1=array();	

//задолженность
 array_push($menu_sql, 'select count(a.id) as kol from i_implementer as a where a.summa_debt>0');

 array_push($menu_sql1, ' where a.summa_debt>0');
	
//все
 array_push($menu_sql, 'select count(a.id) as kol from i_implementer as a');
 array_push($menu_sql1, '');


$var_get='by';	



$active_menu='cashbox';  // в каком меню


$count_write=10;  //количество выводимых записей на одной странице


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

if (( count($_GET) == 1 )or( count($_GET) == 0 )or( count($_GET) == 2 )) 
{
if (($role->permission('Касса','R'))or($sign_admin==1))
{	
 if(( count($_GET) == 1 )and(isset($_GET["n_st"])))
 {
       //на главной по страничкам
         $result_url=mysql_time_query($link,'select a.id from i_implementer as a where '.limitPage('n_st',$count_write));
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
	    $result_url=mysql_time_query($link,'select a.id from i_implementer as a '.$menu_sql1[$found1].' '.limitPage('n_st',$count_write));
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

if($error_header!=404){ SEO('cashbox','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_prime_cashbox.php';
echo'<div id="fullpage" class="margin_60  input-block-2020 ">
    <div class="oka_block_2019" style="min-height:auto;">
 <div class="oka_block">
<div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">';

    echo'<div class="content_block" id_content="'.$id_user.'">';
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
	
	$result_t2=mysql_time_query($link,'select a.* from i_implementer as a '.$menu_sql1[$title_key].' order by a.summa_debt desc '.limitPage('n_st',$count_write));
	  
   //запрос для определения общего количества = 
	  /*
   $sql_count='select count(a.id) as kol from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).')';
*/
	 // echo('!'.$title_key);
	  $sql_count=$menu_sql[$title_key];
$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);	  

echo' <h3 class="head_h" style=" margin-bottom:0px;">'.$menu_title[$title_key].'<i>'.$row__221["kol"].'</i><div></div></h3>';

	  
$result_t221x=mysql_time_query($link,'select sum(a.summa_debt) as kol from i_implementer as a where a.summa_debt>0');	  
$row__221x= mysqli_fetch_assoc($result_t221x);		  

if($row__221x["kol"]>0)
{
	  echo'<div class="pay_summ1">'.rtrim(rtrim(number_format($row__221x["kol"], 2, '.', ' '),'0'),'.').'</div>';
}
	  
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
					  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Исполнитель</th><th class="t_2 no_padding_left_">Выполнено на сумму</th><th class="t_8">Выдано на сумму</th><th class="t_10">Задолженность</th><th class="t_10"></th></tr></thead><tbody>';
	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {     
                       $row__2= mysqli_fetch_assoc($result_t2);	  
                     
$cll='';
if($row__2["summa_debt"]<=0)
{
  $cll='whites';
}
					
echo'<tr class="nary n1n '.$cll.'" rel_id="'.$row__2["id"].'"><td></td>';

                  echo'<td class="no_padding_left_ pre-wrap">';
						 						if (($role->permission('Исполнители','R'))or($sign_admin==1))
	        {	
						 echo'<a href="implementer/'.$row__2["id"].'/"><span class="s_j">'.$row__2["implementer"].'</span></a>';
			} else
			{
				echo'<span class="s_j">'.$row__2["implementer"].'</span>';
			}
						 echo'</td>';
/*
echo'<td class="pre-wrap"><span class="per">';

echo MaskDate($row__2["date_begin"]).' - '.MaskDate($row__2["date_end"]);						 

echo'</span></td>';
*/
echo'<td><span class="s_j pay_summ">'.rtrim(rtrim(number_format($row__2["summa_made"], 2, '.', ' '),'0'),'.').' </span></td>
<td><div class="ooo_pay"><span class="s_j pay_summ pay_meta">'.rtrim(rtrim(number_format($row__2["summa_paid"], 2, '.', ' '),'0'),'.').' </span>';

	   $result_t1=mysql_time_query($link,'Select sum(a.summa_rco) as sums  from c_cash as a where a.id_implementer="'.$row__2["id"].'" and status=0');
			
		//echo('Select a.*,b.date_doc,b.numer_doc,b.id as idd  from n_work as a,n_nariad as b where b.signedd_nariad=1 and a.id_nariad=b.id and a.id_razdeel2="'.htmlspecialchars(trim($id)).'" order by b.date_doc');
			
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  	
			
			
		   $row_t1 = mysqli_fetch_assoc($result_t1);
		   echo'<div data-tooltip="Есть неподписанные выдачи" class="yes_pay_grey">'.$row_t1["sums"].'</div>';
	   }
						 
						 
echo'</td>
<td><span class="s_j pay_summ boldi">'.mor_class(($row__2["summa_paid"]-$row__2["summa_made"]),rtrim(rtrim(number_format($row__2["summa_debt"], 2, '.', ' '),'0'),'.'),0).'
';
						 
echo'</span></td>


 <td>';
if($row__2["summa_debt"]>0)
{
	if (($role->permission('Касса','A'))or($sign_admin==1))
{	

						 echo'<div class="pay_baks" data-tooltip="Выдать"  id_rel="'.$row__2["id"].'"><span class="pay22">₽</span></div>';
}
}

						 
	if (($role->permission('Аванс','R'))or($sign_admin==1)) 
	{
		
		  echo'<div class="pay_avans" data-tooltip="Выдать аванс"  id_avans="'.$row__2["id"].'"></div>';
		
	}							 
						 
	echo'</td>		   
		   
		   </tr>';	  
						 
					 }
					  
echo'</tbody></table>'; 
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_1").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';	 
					  
					  
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
					  
					  
 }
	  
?>

    <script>
$(document).ready(function(){
		/*
	
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
	*/
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
</div></div></div></div>
</div>
</div><script src="Js/rem.js" type="text/javascript"></script>

<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
</div>

</body></html>