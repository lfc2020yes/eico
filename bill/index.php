<?
session_start();
set_time_limit(300); //файл должен загрузиться за 5 минут

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



$active_menu='bill';  // в каком меню


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

if((!$role->permission('Счета','R'))and($sign_admin!=1))
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

if($error_header!=404){ SEO('bill','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_bill.php';


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
	  
	  
	  //сортировка по умолчанию по дате договора
	  
	  $sql_su1=' order by b.id DESC';
	  $sql_su1_=' order by b.id DESC';

	  //echo("!".$sql_su2);
	  
	  $sql_su3='';
	  $sql_su3_='';
 		if (( isset($_COOKIE["bi_3"]))and(is_numeric($_COOKIE["bi_3"]))and(array_search($_COOKIE["bi_3"],$os_id3)!==false)and($_COOKIE["bi_3"]!=0))
		{
				$sql_su3=' and b.status='.htmlspecialchars(trim($_COOKIE["bi_3"]));
				$sql_su3_=' and b.status='.htmlspecialchars(trim($_COOKIE["bi_3"]));
		}	  

	  
	  $sql_su4='none';
	  $sql_su4_='';
 		if (( isset($_COOKIE["bi_4"]))and(is_numeric($_COOKIE["bi_4"]))and(array_search($_COOKIE["bi_4"],$os_id4)!==false)and($_COOKIE["bi_4"]==1))
		{
	  $sql_su4='';
	  $sql_su4_='active_supplyx';
		}	  
	  
  $result_t2=mysql_time_query($link,'Select DISTINCT b.* from z_acc as b where b.status NOT IN ("1","5") '.$sql_su2.' '.$sql_su3.' '.$sql_su1.' '.limitPage('n_st',$count_write));
	  
	 
	  
  $sql_count='Select count(DISTINCT b.id) as kol from z_acc as b where  b.status NOT IN ("1","5") '.$sql_su2.' '.$sql_su3.' '.$sql_su1;
	 
	

$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);	  

echo' <h3 class="head_h" style=" margin-bottom:0px;">Счета<i>'.$row__221["kol"].'</i><div></div></h3> ';	  
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
					  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2 bill_table"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Счет</th><th class="t_1">Описание</th><th class="t_1"></th><th class="t_1">Документы</th><th class="t_1"></th><th class="t_8 center_">Статус</th><th class="t_10"></th></tr></thead><tbody>';

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
						 
	
echo'<tr class="billl nary n1n '.$cll.' suppp_tr '.$sql_su4_.'" rel_id="'.$row__2["id"].'"><td class="middle_">';
if($row__2["status"]==4)
						 {
							//узнаем сколько по этому договору уже привезли товара
				$PROC=0;
				   
				$result_proc=mysql_time_query($link,'select sum(a.subtotal) as summ,sum(a.subtotal_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.$row__2["id"].'"');
                
				$num_results_proc = $result_proc->num_rows;
                if($num_results_proc!=0)
                {
			         $row_proc = mysqli_fetch_assoc($result_proc);
					 $PROC=round((($row_proc["summ"]-$row_proc["summ1"])*100)/$row__2["summa"]); 
		        } 
//echo'<div style="position:relative;"><div class="loaderr_supply"><div class="teps_supply" rel_w="'.$PROC.'" style="width: 0%;"><div class="peg_div_supply"><div></div></div></div></div></div>';
						 }
echo'<div class="supply_tr_o"></div></td><td  class="middle_"><div class="nm supl"><span class="s_j">Счет №'. $row__2["number"].'</span></div>';
$date_graf2  = explode("-",$row__2["date"]);
					   echo'<span class="stock_name_mat">от '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</span>';	
											 
						 
echo'</td>';
						 
$ddd='';
		if($row__2["delivery_day"] != 0)
		{	
		
		
			$ddd=$row__2["delivery_day"];
		}						 
						 
echo'<td><span class="s_j pay_summ">'.rtrim(rtrim(number_format($row__2["summa"], 2, '.', ' '),'0'),'.').'</span>';

if($ddd!='')
{
	echo'<div class="stock_name_mat">срок поставки ~ '.$ddd.' '.PadejNumber($ddd,'день,дня,дней').'</div>';	
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
echo'<td>';

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
echo'<td class="status_wallet_ada">';
$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row__2["status"].'" and a.id_system=16');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
echo'<div rel_status="'.$row__2["id"].'" class="st_bb menu_click status_materialz status_bb'.$row__2["status"].' '.$live.'">'.$row_status["name_status"];
if($row__2["status"]==3)
{
if(($row__2["path_summa"]!='')and($row__2["path_summa"]!=0))
{
	echo'<br>Частично - '.rtrim(rtrim(number_format($row__2["path_summa"], 2, '.', ' '),'0'),'.');
}
if(($row__2["date_buy"]!='')and($row__2["date_buy"]!=0))
{
			$date_graf3  = explode("-",$row__2["date_buy"]);
			$ddd=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];
	echo'<br>Оплата после - '.$ddd;
}	
}
if($row__2["status"]==4)
{	
if(($row__2["path_summa"]!='')and($row__2["path_summa"]!=0))
{
	echo'<br>Частично - '.rtrim(rtrim(number_format($row__2["path_summa"], 2, '.', ' '),'0'),'.');
}

			
		$date_graf3  = explode("-",$row__2["date_paid"]);
		$ddd1=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];
	
		$result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row__2["id_user_paid"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
			
		}	
	echo '<br>'.$rowxs["name_user"].'<br>';
	echo $ddd1;
}
	
echo'</div>';			
}
						 	 

//echo'<div class="yoop_"><div class="yoop_rt"><span>на складе</span> <i>'.$z_stock_count_users.'</i> <strong>'.$units.'</strong></div>';	
//echo'<div class="yoop_rt"><span>на складе</span> <i>'.$z_stock_count_users.'</i> <strong>'.$units.'</strong></div></div>';							 
						 
						 
echo'</td>';


/*						 
echo'<td><span class="per1">';
						 
        
			echo($row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')');
						 
					
 echo'</span></td>';	
*/	
						 
		 
echo'<td class="menu_jjs button_ada_wall">';

	if($row__2["status"]==2)
	{
	echo'<div  data-tooltip="Не оплачивать" rel_bill="'.$row__2["id"].'" class="user_mat xvg_no"></div>';		
	echo'<div  data-tooltip="К оплате" rel_bill="'.$row__2["id"].'" class="user_mat xvg_yes"></div>';	
	}
	if(($row__2["status"]==3)or($row__2["status"]==20))
	{	
	   echo'<div style="float:right; width:20px;">';
	   echo'<div class="more_supply1 menu_click"></div>';	
		
		
	   echo'<div class="menu_supply menu_su1"><ul style="right: 10px; top: 0px;" class="drops no_active" data_src="0"><li><a href="javascript:void(0);" rel="1">Изменить</a></li><li><a href="javascript:void(0);" rel="2">Отменить оплату</a></li></ul><input rel="x" name="vall_bill" class="option_mat1" value="0" type="hidden"></div>';
		
	   echo'</div>';	
	}

						 if($row__2["status"]==4)
						 {
							//узнаем сколько по этому договору уже привезли товара
			
				   					 
echo'<div class="procss">'.$PROC.'%</div>';						 
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

	
echo'<tr supply_stock="'.$row__2["id"].'" class="tr_dop_supply_line '.$sql_su4.'"><td colspan="9"></td></tr>';						 


	$result_work_zz=mysql_time_query($link,'
	
	SELECT 
	a.*,b.id as idd,
	b.count_units,
	b.id_object,
	b.id_stock,
	c.id_user as users,
	c.date_create
	
	FROM 
	z_doc_material_acc as a,
	z_doc_material as b,
	z_doc as c
	WHERE
	b.id_doc=c.id and 
	a.id_acc="'.$row__2["id"].'" and
	a.id_doc_material=b.id
	
	;');

						 
		//echo 'Select a.*,b.id as idd,b.id_user,b.id_object from z_doc_material as a,z_doc as b,i_material as c where a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_;				 
						 
						 
        $num_results_work_zz = $result_work_zz->num_rows;
	    if($num_results_work_zz!=0)
	    {

	
	
		  $id_work=0;
			
		   for ($i=0; $i<$num_results_work_zz; $i++)
		   {			   			  			   
			   $row_work_zz = mysqli_fetch_assoc($result_work_zz);
			   $nhh=0;
			   $actvss='';
			   
			   
			   
			   
			   
			   $result_work_zz1=mysql_time_query($link,'
			SELECT a.count_units AS ss,
c.price AS mm,
c.units
FROM 
z_doc_material AS a,
i_material AS c
WHERE 
a.id_i_material=c.id AND
a.id="'.$row_work_zz["idd"].'"');
		  
		    $num_results_work_zz1 = $result_work_zz1->num_rows;
	        if($num_results_work_zz!=0)
	        {
		        $id_work=0;			
		   			  			   
			    $row_work_zz1 = mysqli_fetch_assoc($result_work_zz1);
				
			}
			   
			   
			   
			   
			   
			   
			   
			   //score_pay score_app
			   echo'<tr supply_id="'.$row_work_zz["id"].'" supply_stock="'.$row__2["id"].'" class="tr_dop_supply '.$sql_su4.'"><td class="middle_ no_border_supply">';
			   if($row_work_zz1["mm"]<$row_work_zz["price_material"])
			   {
				   
				   echo'<div class="red_jjp"></div>';
				   
			   }
			   
			   echo'</td><td class=" menu_jjs scope_scope">';
			   
			   
			   	$result_t1__341=mysql_time_query($link,'Select a.name,a.units  from z_stock as a where a.id="'.$row_work_zz["id_stock"].'"'); 
			    $num_results_t1__341 = $result_t1__341->num_rows;
	            if($num_results_t1__341!=0)
	            {  
		              $row1ss__341 = mysqli_fetch_assoc($result_t1__341);
					  echo'<div class="name_xvg">'.$row1ss__341["name"].'</div>';
					
					
					
					 echo'<div class="count_bill_new">'.$row_work_zz['count_material'].' '.$row1ss__341["units"].'</div>';
						  
					
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
	
	
			   $class_xvg='';
			   if($row_work_zz['count_material']>$row_work_zz['count_units'])
			   {
				   $class_xvg='red_xvg';
			   }
			   
			   
	            // echo'<i class="oracle_xvg '.$class_xvg.'">'.$row_work_zz['count_material'].' '.$row1ss__341["units"].'</i>';
			   if($row_work_zz1["mm"]<$row_work_zz["price_material"])
			   {
			     echo'<div class="mat_memo_zay"> <b data-tooltip="Max возможная стоимость">MAX <span class="rub">'.$row_work_zz1["mm"].'</span></b> → <span data-tooltip="введенная стоимость" class="red_zat"><span class="rub">'.$row_work_zz['price_material'].'</span></span></div>';
			   } else
			   {
			     echo'<div class="mat_memo_zay"><span data-tooltip="введенная стоимость"><span class="rub">'.$row_work_zz['price_material'].'</span></span></div>';
			   }
			   
			   
			   $actv12='';
			   
			   
			  echo'</td><td><label>Объект</label>';
			   
			  if($num_results_custom_url!=0)
              {
			   echo $row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';
			  } else
			  {
				  echo 'Объект неизвестен';
			  }
				   echo'</td>'; 
	echo'<td colspan="2">'; 
		$date_graf2  = explode(" ",$row_work_zz["date_create"]);	 		
		$date_graf3  = explode("-",$date_graf2[0]);
			$ddd1=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];  
		echo'<label>Заявка</label>от '.$ddd1.'  на <i class="line_xvg">'.$row_work_zz['count_units'].' '.$row1ss__341["units"].'</i>';			 
echo'</td>';
			   
			   
echo'<td colspan="2">';
	//вывести ссылки на счета если они есть у этого материала еще на согласовании кроме выводимого
	
			   $result_score=mysql_time_query($link,'
			   SELECT
			   a.number,
			   a.summa,
			   a.date_paid,
			   a.delivery_day,
			   a.status,
			   a.id as id,
			   (select count(g.id) from z_doc_material_acc as g where g.id_acc=a.id ) as countss,
			   (select r.name_status from r_status as r where r.numer_status=a.status and r.id_system="16" ) as status_name 
			   
			   FROM 
			   z_acc as a,
			   z_doc_material_acc as b 
			   
			   WHERE 
			   not(a.id ="'.$row__2["id"].'") and
			   a.status NOT IN ("1","5") and
			   b.id_acc=a.id and 
			   b.id_doc_material="'.$row_work_zz["id_doc_material"].'"
			   
			   
			   ');
				/*		 
			   <div class="score_a score_active"><i>2</i></div>
			   <div class="score_a"><i>10</i></div>			 
				*/	
			   //score_pay score_app score_active
						 
        $num_results_score = $result_score->num_rows;
	    if($num_results_score!=0)
	    {
           $status_score = array("1", "2","3");
		   $status_score_class = array("", "score_app","score_pay");	
		   for ($ss=0; $ss<$num_results_score; $ss++)
		   {			   			  			   
			   $row_score = mysqli_fetch_assoc($result_score);

			   
			   
				  $too="data-tooltip=\"счет №".$row_score["number"]."- ".$row_score["status_name"]."\"";

			   if($row_score["status"]==4)
			   {
				   
			   	//узнаем сколько по этому договору уже привезли товара
				$PROC=0;
				   
				$result_proc=mysql_time_query($link,'select sum(a.subtotal) as summ from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.$row_score["id"].'"');
                
				$num_results_proc = $result_proc->num_rows;
                if($num_results_proc!=0)
                {
			      $row_proc = mysqli_fetch_assoc($result_proc);
				  $PROC=round(($row_proc["summ"]*100)/$row_score["summa"]); 
		        } 
				   
				   				   
			   //подсвечиваем красным если конечная дата доставки завтра а товар привезли не весь или вообще не привезли
				
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
			   	   
				   
				   
			   echo'<div rel_score="'.$row_score["id"].'" class="xvg_bill_score score_a1 '.$tec.'">
    <div class="circle-container" data-tooltip="Получено '.$PROC.'%">
        <div class="circlestat" data-dimension="80" data-text="'.$PROC.'%" data-width="1" data-fontsize="38" data-percent="'.$PROC.'" data-fgcolor="#24c32d" data-bgcolor="rgba(0,0,0,0.1)" data-fill="rgba(0,0,0,0)"><span class="spann">№'.$row_score["number"].'</span><span class="date_proc '.$style_book.'">до '.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</span></div>
    </div>
</div>';	   
				   
			   } else
			   {
			   echo'<div '.$too.' rel_score="'.$row_score["id"].'"  class="xvg_bill_score score_a '.$status_score_class[array_search($row_score["status"],$status_score)].'"><i>'.$row_score["countss"].'</i><span>№'.$row_score["number"].'</span><strong><label>'.rtrim(rtrim(number_format($row_score["summa"], 2, '.', ' '),'0'),'.').'</label></strong></div>';
			   }

		   }
		}		   
			   
			   
echo'</td>';			   
			   
				
	  echo'</tr>';	 
		   }
		}
	
	    
    if($row__2["comment"]!='')
	{
	echo'<tr supply_stock="'.$row__2["id"].'" class="tr_dop_supply tr_dop_memo '.$sql_su4.'"><td><span class="zay_str">→</span></td><td colspan="8">';
	
		echo'<label>Комментарий</label>';
		echo'<div class="mat_memo_zay">'.$row__2["comment"].'</div>';
		//echo'<span>'.$row__2["comment"].'</span>';
	
	echo'</td></tr>';		
	}
	
	echo'<tr supply_stock="'.$row__2["id"].'" class="tr_dop_supply_line1 '.$sql_su4.'"><td colspan="9"></td></tr>';					 
						 
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
animation_teps_supply();
 });
</script>

</body></html>