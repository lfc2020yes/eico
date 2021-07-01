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



$active_menu='supply';  // в каком меню


$count_write=30;  //количество выводимых записей на одной странице
$edit_price=0;
if ($role->is_column_edit('n_material','price'))
{
	$edit_price=1;
}


$echo_r=1; //выводить или нет ошибку 0 -нет
$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

//index.php не должно быть в $url_404
if (strripos($url_404, 'index.php') !== false) {
   header404(1,$echo_r);	
}

//**************************************************
if (( count($_GET) != 1 )and( count($_GET) != 0 ) )
{
   header404(2,$echo_r);		
}

if((!$role->permission('Снабжение','R'))and($sign_admin!=1))
{
  header404(3,$echo_r);
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

if($error_header!=404){ SEO('supply','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_supply.php';


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
	   //$os = array( "дата поставки", "по алфавиту","новые");
	   //$os_id = array("0", "1", "2");	
	  $sql_su1=' order by b.date_delivery';
	  $sql_su1_=' order by a.date_delivery';
 		if (( isset($_COOKIE["su_1"]))and(is_numeric($_COOKIE["su_1"]))and(array_search($_COOKIE["su_1"],$os_id)!==false))
		{
			if($_COOKIE["su_1"]==1)
			{
				$sql_su1=' order by c.material';
				$sql_su1_=' order by c.material';
			}
			if($_COOKIE["su_1"]==2)
			{
				$sql_su1=' order by a.date_last desc';
				$sql_su1_=' order by b.date_last desc';
			}
		}

	  
	  $sql_su2='';
	  $sql_su2_='';
 		if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and(array_search($_COOKIE["su_2"],$os_id2)!==false)and($_COOKIE["su_2"]!=0))
		{
			$date_base__=explode(".",$_COOKIE["sudd"]);
			if( isset($_COOKIE["sudd"]))
			{
				if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and($_COOKIE["su_2"]==2)and(checkdate(date_minus_null($date_base__[1]), date_minus_null($date_base__[0]),$date_base__[2])))
				{
				$sql_su2=' and b.date_delivery="'.$date_base__[2].'-'.$date_base__[1].'-'.$date_base__[0].'"';
				$sql_su2_=' and a.date_delivery="'.$date_base__[2].'-'.$date_base__[1].'-'.$date_base__[0].'"';
				}
			}
			if($_COOKIE["su_1"]==1)
			{
				//сегодня дата
				
				//дата через 7 дней
				
				$sql_su2=' and b.date_delivery between "0000-00-00" and "'.date("Y", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")+7), date("Y"))).'-'.date("m", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")+7), date("Y"))).'-'.date("d", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")+7), date("Y"))).'"';
				$sql_su2_=' and a.date_delivery between "0000-00-00" and "'.date("Y", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")+7), date("Y"))).'-'.date("m", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")+7), date("Y"))).'-'.date("d", mktime(date("G"), date("i"), date("s"), date("n"),(date("j")+7), date("Y"))).'"';
			//WHERE ("'.date("Y").'-'.date("m").'-'.date("d").'" between sk.start_date and sk.end_date)
			}
		}		  
	  //echo("!".$sql_su2);
	  
	  $sql_su3='';
	  $sql_su3_='';
 		if (( isset($_COOKIE["su_3"]))and(is_numeric($_COOKIE["su_3"]))and(array_search($_COOKIE["su_3"],$os_id3)!==false)and($_COOKIE["su_3"]!=0))
		{
				$sql_su3=' and b.status='.htmlspecialchars(trim($_COOKIE["su_3"]));
				$sql_su3_=' and a.status='.htmlspecialchars(trim($_COOKIE["su_3"]));
		}	  

	  
	  $sql_su4='none';
	  $sql_su4_='';
 		if (( isset($_COOKIE["su_4"]))and(is_numeric($_COOKIE["su_4"]))and(array_search($_COOKIE["su_4"],$os_id4)!==false)and($_COOKIE["su_4"]==1))
		{
	  $sql_su4='';
	  $sql_su4_='active_supplyx';
		}	  
	  
  $result_t2=mysql_time_query($link,'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') AND b.status NOT IN ("1","8","10","3","5","4") '.$sql_su2.' '.$sql_su3.' '.$sql_su1.' '.limitPage('n_st',$count_write));
	  
	 
	  
  $sql_count='Select count(DISTINCT b.id_stock) as kol from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') AND b.status NOT IN ("1","8","10","3","5","4") '.$sql_su2.' '.$sql_su3.' '.$sql_su1;
	 
	
	  /*echo('Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') AND b.status NOT IN ("1","8","10","3","5","4") '.$sql_su2.' '.$sql_su3.' '.$sql_su1.' '.limitPage('n_st',$count_write));
	  */
$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);	  

echo' <h3 class="head_h" style=" margin-bottom:0px;">Cнабжение<i>'.$row__221["kol"].'</i><div></div></h3> ';	  
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
					  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Материал</th><th class="t_1"></th><th class="t_1">Описание</th><th class="t_1"></th><th class="t_1"></th><th class="t_1"></th><th class="t_8 center_">Статус</th><th class="t_10"></th></tr></thead><tbody>';

	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {

					$row__2= mysqli_fetch_assoc($result_t2);
	
		$result_url_m=mysql_time_query($link,'select A.material,A.units from i_material as A where A.id="'.htmlspecialchars(trim($row__2["id_i_material"])).'"');
        $num_results_custom_url_m = $result_url_m->num_rows;
        if($num_results_custom_url_m!=0)
        {
			$row_material = mysqli_fetch_assoc($result_url_m);	
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
	if($ksss!=0)
	{		
	//echo'<tr><td colspan="8" height="20px"></td></tr>';	
	}			
	
echo'<tr class="nary n1n '.$cll.' suppp_tr '.$sql_su4_.'" rel_id="'.$row__2["id_stock"].'_'.$row__2["id_i_material"].'"><td class="middle_"><div class="supply_tr_o"></div></td><td colspan="2" class="middle_"><div class="nm supl"><span class="s_j">'. $row_material["material"].'</span></div>';
if($row__2["id_stock"]!='')
					 {
					 $result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row__2["id_stock"].'"'); 
			        $num_results_t1__341 = $result_t1__341->num_rows;
	                if($num_results_t1__341!=0)
	                {  
		              $row1ss__341 = mysqli_fetch_assoc($result_t1__341);
					  echo'<span data-tooltip="название товара на складе" class="stock_name_mat">'.$row1ss__341["name"].'</span>';
					} else
					{
					   echo'<span class="stock_name_mat">не связан с товаром на складе</span>';	
					}
					 } else
					{
					   echo'<span class="stock_name_mat">не связан с товаром на складе</span>';	
					}						 
						 
echo'</td>';
echo'<td colspan="2">';
						 
						 
						 
echo'<div class="supply_bb1 yoop_ hide_yoop" id_ada="'.$row__2["id_stock"].'">';
$echo='';
//$row__2["id_stock"]
if($row__2["id_stock"]!=0)
{
//узнаем сколько материала на складе
$result_t1_=mysql_time_query($link,'SELECT b.units,(SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_stock=b.id) as summ FROM z_stock as b WHERE b.id="'.htmlspecialchars(trim($row__2["id_stock"])).'"');
					$z_stock_count_users=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_stock_count_users=$row1ss_["summ"];
					  }
					 $units=$row1ss_["units"];
					  $echo.='<div class="yoop_rt"><span>на складе</span><i>'.$z_stock_count_users.'</i> <strong>'.$row1ss_["units"].'</strong></div>';
				 }						 

//узнаем сколько материала в заявке
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.status=9 and  a.id_stock="'.htmlspecialchars(trim($row__2["id_stock"])).'"');
					$z_zakaz=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_zakaz=$row1ss_["summ"];
					  }
					  $echo.='<div class="yoop_rt "><span>в заявках</span><i>'.$z_zakaz.'</i> <strong>'.$units.'</strong></div>';
				 }						 
//узнаем сколько материала в работе
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.status=11 and  a.id_stock="'.htmlspecialchars(trim($row__2["id_stock"])).'"');
					$z_rabota=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_rabota=$row1ss_["summ"];
					  }
					  $echo.='<div class="yoop_rt "><span>в работе</span><i>'.$z_rabota.'</i> <strong>'.$units.'</strong></div>';
				 }		

//узнаем сколько материала на согласовании со счетом	
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="'.htmlspecialchars(trim($row__2["id_stock"])).'" AND a.id_acc=b.id AND b.status=2');

					$z_rabota1=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_rabota1=$row1ss_["summ"];
					  }
					  $echo.='<div class="yoop_rt "><span>на согласовании со счетом</span><i>'.round($z_rabota1,2).'</i> <strong>'.$units.'</strong></div>';
				 }		

//узнаем сколько материала согласовано со счетом		
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="'.htmlspecialchars(trim($row__2["id_stock"])).'" AND a.id_acc=b.id AND b.status=3');
	
					$z_rabota2=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_rabota2=$row1ss_["summ"];
					  }
					  $echo.='<div class="yoop_rt"><span>согласовано со счетом</span><i>'.round($z_rabota2,2).'</i> <strong>'.$units.'</strong></div>';
				 }	
//узнаем сколько материала оплачено	
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="'.htmlspecialchars(trim($row__2["id_stock"])).'" AND a.id_acc=b.id AND b.status=4');
					$z_rabota3=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_rabota3=$row1ss_["summ"];
					  }
					  $echo.='<div class="yoop_rt "><span>оплачено</span><i>'.round($z_rabota3,2).'</i> <strong>'.$units.'</strong></div>';
				 }		
//узнаем сколько материала необходимо еще
$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.status NOT IN ("1","8","10","3","5","4") and  a.id_stock="'.htmlspecialchars(trim($row__2["id_stock"])).'"');
					$z_zakaz=0;	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					  {
					    $z_zakaz=$row1ss_["summ"];
					  }
					 
					  $neo=round(($z_zakaz-$z_rabota1-$z_rabota2-$z_rabota3),2);
					 $class_ada="red_ada";
					  if($neo<=0)
					  {
						  $neo=0;
						  $class_ada="green_ada";
					  }
					  $echo.='<div class="yoop_rt yoop_click '.$class_ada.'"><span>еще необходимо</span><i>'.$neo.'</i> <strong>'.$units.'</strong></div>';
				 }	
	
	
		
echo($echo);
}
echo'</div>';	
						 
					 
echo'</td>';
						 
echo'<td colspan="2" class="center_">';
//вывод заложенной стоимости за единицу товара из себестоимости
if($row__2["id_stock"]!=0)
{						 
	
	$result_xp=mysql_time_query($link,'SELECT b.price FROM z_doc_material AS a,i_material as b WHERE a.id_stock="'.htmlspecialchars(trim($row__2["id_stock"])).'" and a.id_i_material=b.id');
					        	 
	$num_results_xp = $result_xp->num_rows;
	if($num_results_xp!=0)
	{  
		//такая работа есть
		$row_xp = mysqli_fetch_assoc($result_xp);
		echo'<span data-tooltip="Цена за ед. заложенная в себестоимости" class="price_supply_">'.$row_xp["price"].'</span>';
	}
		
}
echo'</td>';						 
						 

						 
		 
echo'<td>';

			 
						 
						 
						 echo'</td>';
	
	
	

 echo'<td>';
						 
	
	echo'</td>		   
		   
		   </tr>';		

	
echo'<tr supply_stock="'.$row__2["id_stock"].'_'.$row__2["id_i_material"].'" class="tr_dop_supply_line '.$sql_su4.'"><td colspan="9"></td></tr>';						 

if($row__2["id_stock"]==0)
{
	$result_work_zz=mysql_time_query($link,'Select a.*,b.id as idd,b.id_user,b.id_object from z_doc_material as a,z_doc as b,i_material as c where a.id_i_material=c.id and a.id_i_material="'.$row__2["id_i_material"].'" and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_);	
} else
{
	$result_work_zz=mysql_time_query($link,'Select a.*,b.id as idd,b.id_user,b.id_object from z_doc_material as a,z_doc as b,i_material as c where a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_);
}
						 
					 
        $num_results_work_zz = $result_work_zz->num_rows;
	    if($num_results_work_zz!=0)
	    {

	
	
		  $id_work=0;
			
		   for ($i=0; $i<$num_results_work_zz; $i++)
		   {			   			  			   
			   $row_work_zz = mysqli_fetch_assoc($result_work_zz);
			   $nhh=0;
			   $actvss='';
			   
			   	if (( isset($_COOKIE["current_supply_".$id_user]))and(is_numeric($_COOKIE["current_supply_".$id_user])))
	            {
				   if(cookie_work('basket_score_'.htmlspecialchars(trim($id_user)),$row_work_zz["id"],'.',60,'0'))
	              {
		            $actvss='checher_supply';
	              }				
				} else
				{
			   
			   if(cookie_work('basket_supply_'.htmlspecialchars(trim($id_user)),$row_work_zz["id"],'.',60,'0'))
	           {
		          $actvss='checher_supply';
	           }
				}
			   
			   //score_pay score_app
			   echo'<tr supply_id="'.$row_work_zz["id"].'" supply_stock="'.$row__2["id_stock"].'_'.$row__2["id_i_material"].'" class="tr_dop_supply '.$sql_su4.' '.$actvss.'"><td class="middle_ no_border_supply"></td><td class=" menu_jjs scope_scope">';
			   
			   
			   //проверяем есть ли счета с этим материалом и их статусы
			   $result_score=mysql_time_query($link,'Select a.date,a.date_paid,a.delivery_day,a.number,a.status,a.summa,a.id as id,(select count(g.id) from z_doc_material_acc as g where g.id_acc=a.id ) as countss,(select r.name_status from r_status as r where r.numer_status=a.status and r.id_system="16" ) as status_name from z_acc as a,z_doc_material_acc as b where b.id_acc=a.id and b.id_doc_material="'.$row_work_zz["id"].'"');

						 
        $num_results_score = $result_score->num_rows;
	    if($num_results_score!=0)
	    {
           $status_score = array("1","2","3","5","4");
		   $status_score_class = array("", "score_app","score_pay","score_no","score_paid");	
		   for ($ss=0; $ss<$num_results_score; $ss++)
		   {			   			  			   
			   $row_score = mysqli_fetch_assoc($result_score);
			   $tec='';
			   if (( isset($_COOKIE["current_supply_".$id_user]))and(is_numeric($_COOKIE["current_supply_".$id_user]))and($_COOKIE["current_supply_".$id_user]==$row_score["id"]))
		       {
				   //если выбран этот счет текущим
				   $tec='score_active'; 
			   }
			   
			   $too='';
			   if($row_score["status"]==2)
			   {
				   $nhh=1;
			   }
			   
			   
			   if($row_score["status"]!=1)
			   {
				  $too="data-tooltip=\"счет №".$row_score["number"]."- ".$row_score["status_name"]."\"";
			   } else
			   {
				  $too="data-tooltip=\"счет №".$row_score["number"]."\"";  
			   }
			   /*
			   echo'<div rel_score="'.$row_score["id"].'" '.$too.' class="menu_click score_a '.$status_score_class[array_search($row_score["status"],$status_score)].' '.$tec.'"><i>'.$row_score["countss"].'</i><span>№'.$row_score["number"].'</span></div>';
			   */
			   //$PROC=round($row_gog3["koll"]/$row_gog2["co"]);	
			   
			   //#4bcaff
			   if(($row_score["status"]==4)or($row_score["status"]==20))
			   {
				   
				//узнаем сколько по этому договору уже привезли товара
				$PROC=0;
				   
				$result_proc=mysql_time_query($link,'select sum(a.subtotal) as summ,sum(a.subtotal_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.$row_score["id"].'"');
                //echo('select sum(a.subtotal) as summ,sum(a.subtotal_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.$row_score["id"].'"');
				$num_results_proc = $result_proc->num_rows;
                if($num_results_proc!=0)
                {
			         $row_proc = mysqli_fetch_assoc($result_proc);
					 $PROC=round((($row_proc["summ"]-$row_proc["summ1"])*100)/$row_score["summa"]); 
		        } 
				   
				   
				   
				   
				   
				//подсвечиваем красным если конечная дата доставки завтра а товар привезли не весь или вообще не привезли
				if(($row_score["status"]==4))
				{
			   //подсвечиваем красным за 1 день до доставки
			   $date_delivery1=date_step($row_score["date_paid"],($row_score["delivery_day"]-1));	
			   //echo($date_delivery1);
			   
			   $style_book='';
			   if(dateDiff_1(date("y-m-d").' '.date("H:i:s"),$date_delivery1.' 00:00:00')>=0)
			   {
				   $style_book='reddecision1';
			   }   
				   
			   $date_delivery=date_step($row_score["date_paid"],$row_score["delivery_day"]);				   
		       $date_graf2  = explode("-",$date_delivery);	
				} else
				{
			   //подсвечиваем красным за 1 день до доставки
			   $date_delivery1=date_step($row_score["date"],($row_score["delivery_day"]-1));	
			   //echo($date_delivery1);
			   
			   $style_book='';
			   if(dateDiff_1(date("y-m-d").' '.date("H:i:s"),$date_delivery1.' 00:00:00')>=0)
			   {
				   $style_book='reddecision1';
			   }   
				   
			   $date_delivery=date_step($row_score["date"],$row_score["delivery_day"]);				   
		       $date_graf2  = explode("-",$date_delivery);						
				}
				   
				   
			   echo'<div rel_score="'.$row_score["id"].'" class="menu_click score_a1 '.$tec.'">
    <div class="circle-container" data-tooltip="Получено '.$PROC.'%">
        <div class="circlestat" data-dimension="80" data-text="~'.$PROC.'%" data-width="1" data-fontsize="38" data-percent="'.$PROC.'" data-fgcolor="#24c32d" data-bgcolor="rgba(0,0,0,0.1)" data-fill="rgba(0,0,0,0)"><span class="spann">№'.$row_score["number"].'</span><span class="date_proc '.$style_book.'">до '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</span></div>
    </div>
</div>';
				
			   } else
			   {
				   echo'<div rel_score="'.$row_score["id"].'" '.$too.' class="menu_click score_a '.$status_score_class[array_search($row_score["status"],$status_score)].' '.$tec.'"><i>'.$row_score["countss"].'</i><span>№'.$row_score["number"].'</span><strong><label>'.rtrim(rtrim(number_format($row_score["summa"], 2, '.', ' '),'0'),'.').'</label></strong></div>';
			   }
			   
			   
			   $menu = array( "Открыть","Сделать текущим","Согласовать","Удалить");
	           $menu_id = array("1","2","3","4");
			   $menu_id_visible= array("1","1","1","1");
			   if(($row_score["status"]==2)or($row_score["status"]==3)or($row_score["status"]==4)or($row_score["status"]==20))
			   {
				   $menu_id_visible= array("1","0","0","0");
			   }
			   
	
	echo'<div class="menu_supply menu_su122"><ul class="drops no_active" data_src="0" style="left:-50px; top:5px;">';
		   for ($it=0; $it<count($menu); $it++)
             {   
				 if($menu_id_visible[$it]==1)
				 {
				  echo'<li><a href="javascript:void(0);"  rel="'.$menu_id[$it].'">'.$menu[$it].'</a></li>'; 
				 }
			   
			 
			 }
	echo'</ul><input rel="x" type="hidden" name="vall" class="option_score1" value="0"></div>';	
		   }
		}

				   
			  echo'</td><td>';
			   if($row__2["id_stock"]!=0)
			   {
				  echo'<div class="st_div_supply"><i class=""></i></div>'; 
			   } else
			   {
				  echo'<div class="st_div_supply" style="display:none;"><i class=""></i></div>';   
			   }
			
			   
			   
			  echo'</td><td>';
			   
				
			   
			   		$result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_work_zz["id_object"])).'"');
			   //echo('select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_work_zz["id_object"])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {
			$row_list1 = mysqli_fetch_assoc($result_url);

			        $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list1["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}
		}
	
	
			   
			   
			   
	             echo($row_work_zz['count_units'].' '.$row_material['units']);

			   
			   $actv12='';
			 						 if((time_compare($row_work_zz['date_delivery'].' 00:00:00',0)==0))
						 {
						   $actv12.=' redsupply ';
						 }  
			   
			   
			  echo'</td><td><label>Дата поставки</label><span class="'.$actv12.'">'.MaskDate_D_M_Y_ss($row_work_zz['date_delivery']).'</span></td><td><label>Объект</label>';
			   
			  if($num_results_custom_url!=0)
              {
			   echo $row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';
			  } else
			  {
				  echo 'Объект неизвестен';
			  }
				   echo'</td>'; 
	echo'<td>';
		$result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row_work_zz["id_user"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
											  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}		
		echo'<div  sm="'.$row_work_zz["id_user"].'"   data-tooltip="Сделал заказ - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row_work_zz["id_user"],'_100x100.jpg">').'</div>';
	    }						 
echo'</td>';								 
				
	  echo'<td class="menu_jjs statusis">';
//вывод статуса по материалу
$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row_work_zz["status"].'" and a.id_system=13');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	
	$live='';
	$menu_id = array("9", "11");
	if(array_search($row_work_zz["status"],$menu_id)!==false)
	{
		$live='live_menu';
	}
	if($row_work_zz["status"]==10)
	{
       echo'<div rel_status="'.$row_work_zz["id"].'" class="st_bb menu_click status_material1">'.$row_status["name_status"].'</div><div class="user_mat naryd_yes"></div>';	
	} else
	{
		echo'<div rel_status="'.$row_work_zz["id"].'" class="st_bb menu_click status_materialz status_z'.$row_work_zz["status"].' '.$live.'">'.$row_status["name_status"].'</div>';	
	}
	
	
	$menu = array( "Заказано", "В работе");
		
	if(array_search($row_work_zz["status"],$menu_id)!==false)
	{
	echo'<div class="menu_supply"><ul class="drops" data_src="'.$row_work_zz["status"].'">';
		   for ($it=0; $it<count($menu); $it++)
             {   
			   if($row_work_zz["status"]==$menu_id[$it])
			   {
				   echo'<li class="sel_active_sss"><a href="javascript:void(0);"  rel="'.$menu_id[$it].'">'.$menu[$it].'</a></li>';
			   } else
			   {
				  echo'<li><a href="javascript:void(0);"  rel="'.$menu_id[$it].'">'.$menu[$it].'</a></li>'; 
			   }
			 
			 }
	echo'</ul><input rel="'.$row_work_zz["id"].'" type="hidden" name="vall" class="vall_supply" value="'.$row_work_zz["status"].'"></div>';
	}
	
}
					 
					 
echo'</td>';		   
			   
			   

			   
	
echo'<td class="no_border_supply menu_jjs mkr_">';
			   	$menu_id = array("9", "11");
	
	
	if(($nhh==0)and(array_search($row_work_zz["status"],$menu_id)!==false))
	{
echo'<div class="more_supply1 menu_click" ></div>';
		
		$menu = array( "Изменить связь");
	$menu_id = array("1");	
	
	echo'<div class="menu_supply menu_su1"><ul class="drops no_active" data_src="0" style="right:10px; top:0px;">';
		   for ($it=0; $it<count($menu); $it++)
             {   
				  echo'<li><a href="javascript:void(0);"  rel="'.$menu_id[$it].'">'.$menu[$it].'</a></li>'; 
			   
			 
			 }
	echo'</ul><input rel="x" type="hidden" name="vall" class="option_mat" value="0"></div>';				   
	}
			   echo'</td></tr>';	 
		   }
		}
	
	

	

					  
						 
					 }
echo'</tbody></table>'; 
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_1").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';	 
					  
					  
	  $count_pages=CountPage($sql_count,$link,$count_write);
	  if($count_pages>1)
	  {


			  displayPageLink_new('supply/','supply/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
		  
	    
	  }
					  
					  
 } else
				  {
					  
					 echo'<div class="no_sql">С такими параметрами ничего не найдено</div>';
					  
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