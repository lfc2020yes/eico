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


$count_write=60;  //количество выводимых записей на одной странице
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

if((!$role->permission('Склад','R'))and($sign_admin!=1))
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

if($error_header!=404){ SEO('stock','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_stock.php';
	            ?>
      <div id="fullpage" class="margin_60  input-block-2020 ">
          <div class="oka_block_2019" style="min-height:auto;">
              <div class="div_ook hop_ds"><div class="search_task">
                      <?

                      $class_js_search='';
                      $class_js_readonly='';
                      if(( isset($_COOKIE["su_st_2"]))and($_COOKIE["su_st_2"]!=''))
                      {
                          $class_js_search='greei_input';
                          $class_js_readonly='readonly=""';
                      }






                      $os = array("по алфавиту", "по количеству");
                      $os_id = array("0", "1");

                      $su_1=0;
                      if (( isset($_COOKIE["su_st_1"]))and(is_numeric($_COOKIE["su_st_1"]))and(array_search($_COOKIE["su_st_1"],$os_id)!==false))
                      {
                          $su_1=$_COOKIE["su_st_1"];
                      }


                      echo'<div class="left_drop menu1_prime book_menu_sel js--sort gop_io '.$class_js_search.'"><label>Сортировка</label><div class="select eddd"><a class="slct" list_number="t1" data_src="'.$os_id[$su_1].'">'.$os[$su_1].'</a><ul class="drop">';
                      for ($i=0; $i<count($os); $i++)
                      {
                          if($su_1==$os_id[$i])
                          {
                              echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$os_id[$i].'">'.$os[$i].'</a></li>';
                          } else
                          {
                              echo'<li><a href="javascript:void(0);"  rel="'.$os_id[$i].'">'.$os[$i].'</a></li>';
                          }

                      }
                      echo'</ul><input type="hidden" '.$class_js_readonly.' name="sort_stock1" id="sort_stock1" value="'.$os[$su_1].'"></div></div>';











                      $su_4=0;
                      $su4_name='Любой';
                      if (( isset($_COOKIE["su_st_4"]))and(is_numeric($_COOKIE["su_st_4"]))and($_COOKIE["su_st_4"]!=0))
                      {
                          $su_4=$_COOKIE["su_st_4"];

                          $result_url1=mysql_time_query($link,'select A.name from z_stock_group as A where A.id="'.htmlspecialchars(trim($_COOKIE["su_st_4"])).'"');
                          $num_results_custom_url1 = $result_url1->num_rows;
                          if($num_results_custom_url1!=0)
                          {
                              $row_list11 = mysqli_fetch_assoc($result_url1);
                              $su4_name=$row_list11["name"];
                          }

                      }


                      $result_t=mysql_time_query($link,'Select a.* from z_stock_group as a order by a.name');
                      $num_results_t = $result_t->num_rows;
                      if($num_results_t!=0)
                      {
                          $active_id=0;
                          echo'<div class="left_drop menu1_prime book_menu_sel js--sort gop_io '.$class_js_search.'"><label>Тип</label><div class="select eddd"><a class="slct" list_number="t4" data_src="'.$su_4.'">'.$su4_name.'</a><ul class="drop">';
                          echo'<li><a href="javascript:void(0);"  rel="0">Любой</a></li>';
                          for ($i=0; $i<$num_results_t; $i++)
                          {
                              $row_t = mysqli_fetch_assoc($result_t);
                              if($su_4==$row_t["id"])
                              {
                                  echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>';
                              } else
                              {
                                  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>';
                              }

                          }
                          echo'</ul><input type="hidden" '.$class_js_readonly.' name="sort_stock4" id="sort_stock4" value="'.$su_4.'"></div></div>';

                      }











                      $su_5=0;
                      $su5_name='Любой';
                      if (( isset($_COOKIE["su_st_3"]))and(is_numeric($_COOKIE["su_st_3"]))and($_COOKIE["su_st_3"]!=0)and((array_search($_COOKIE["su_st_3"],$hie_object) !== false)or($sign_admin==1)))
                      {
                          $su_5=$_COOKIE["su_st_3"];

                          $result_url1=mysql_time_query($link,'Select a.id,a.object_name from i_object as a where a.id="'.htmlspecialchars(trim($_COOKIE["su_st_3"])).'"');
                          $num_results_custom_url1 = $result_url1->num_rows;
                          if($num_results_custom_url1!=0)
                          {
                              $row_list11 = mysqli_fetch_assoc($result_url1);
                              $su5_name=$row_list11["object_name"];
                          }

                      }


                      $result_t=mysql_time_query($link,'Select a.id,a.object_name,a.id_town from i_object as a where a.enable=1 order by a.id');
                      $num_results_t = $result_t->num_rows;
                      if($num_results_t!=0)
                      {
                          $active_id=0;
                          echo'<div class="left_drop menu1_prime book_menu_sel js--sort gop_io '.$class_js_search.'"><label>Объект</label><div class="select eddd"><a class="slct" list_number="t4" data_src="'.$su_4.'">'.$su5_name.'</a><ul class="drop">';
                          echo'<li><a href="javascript:void(0);"  rel="0">Любой</a></li>';
                          for ($i=0; $i<$num_results_t; $i++)
                          {
                              $row_t = mysqli_fetch_assoc($result_t);

                              if((array_search($row_t["id"],$hie_object) !== false)or($sign_admin==1))
                              {

                                  $result_town=mysql_time_query($link,'select B.* from i_town as B where B.id="'.$row_t["id_town"].'"');

                                  $num_results_custom_town = $result_town->num_rows;
                                  if($num_results_custom_town!=0)
                                  {
                                      $row_town = mysqli_fetch_assoc($result_town);
                                  }


                                  if($su_5==$row_t["id"])
                                  {
                                      echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["object_name"].' ('.$row_town["town"].')</a></li>';
                                  } else
                                  {
                                      echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["object_name"].' ('.$row_town["town"].')</a></li>';
                                  }
                              }

                          }
                          echo'</ul><input type="hidden" '.$class_js_readonly.' name="sort_stock3" id="sort_stock3" value="'.$su_5.'"></div></div>';

                      }







                      echo'<div class="left_drop menu1_prime book_menu_sel gop_io"><label>Поиск по названию</label><div class="select eddd">
		   
		   <input name="sort_stock2" id="name_stock_search" class="name_stock_search_input" autocomplete="off" value="'.$_COOKIE["su_st_2"].'" type="text">';
                      if (( isset($_COOKIE["su_st_2"]))and($_COOKIE["su_st_2"]!=''))
                      {
                          echo'<div style="display:block;" class="dell_stock_search" data-tooltip="Удалить"><span>x</span></div>';
                      } else
                      {
                          echo'<div  class="dell_stock_search" data-tooltip="Удалить"><span>x</span></div>';
                      }
                      echo'</div></div>';



                      //echo'<a href="stock/" class="show_sort_stock"><i>Применить</i></a>';
                      echo'<div class="inline_reload js-reload-top"><a href="stock/" class="show_reload">Поиск</a></div>';
?>
</div>
              </div>
              <div class="oka_block">
                  <div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">
<?

                      echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?



	  $sql_su1=' order by b.name';
	  $sql_su1_=' order by a.name';
	  
 		if (( isset($_COOKIE["su_st_1"]))and(is_numeric($_COOKIE["su_st_1"]))and(array_search($_COOKIE["su_st_1"],$os_id)!==false))
		{
			if($_COOKIE["su_st_1"]==1)
			{
				//по количеству
				$sql_su1=' order by ccs desc';
				//$sql_su1_=' order by ccs desc';
			}
		}

	  $sql_select='';
      $sql_select_='';
$sql_select1='';
$sql_select1_='';
	  $sql_su2='';
	  $sql_su2_='';
 		if (( isset($_COOKIE["su_st_4"]))and(is_numeric($_COOKIE["su_st_4"]))and($_COOKIE["su_st_4"]!=0))
		{
				$sql_su2=' and b.id_stock_group='.htmlspecialchars(trim($_COOKIE["su_st_4"]));
				$sql_su2_=' and a.id_stock_group='.htmlspecialchars(trim($_COOKIE["su_st_4"]));
			//WHERE ("'.date("Y").'-'.date("m").'-'.date("d").'" between sk.start_date and sk.end_date)

            $sql_select=' ,z_stock_group as a ';
            $sql_select_=$sql_select;
            $sql_select1=' and not(a.id=0) ';
            $sql_select1_=' and not(a.id=0) ';
		}		  
	  //echo("!".$sql_su2);
	  
	  $sql_su3='';
	  $sql_su3_='';
 		if (( isset($_COOKIE["su_st_2"]))and($_COOKIE["su_st_2"]!=''))
		{
            $query=mb_convert_case(htmlspecialchars($_COOKIE["su_st_2"]), MB_CASE_LOWER, "UTF-8");


            $lower='';
            $query_mass = explode(" ", $query);
            for ($i = 0; $i < count($query_mass); $i++) {

                $lower=plus_string(' and ',$lower,'LOWER(b.name) LIKE "%'.$query_mass[$i].'%"');

            }


            $sql_su3=$lower;
				$sql_su3_=$lower;




		}	  

	  $sql_su4='';
	  $sql_su4_='';
 		if (( isset($_COOKIE["su_st_3"]))and($_COOKIE["su_st_3"]!='')and($_COOKIE["su_st_3"]!=0))
		{
				$sql_su4='and c.id_object='.htmlspecialchars(trim($_COOKIE["su_st_3"]));
				$sql_su4_='and c.id_object='.htmlspecialchars(trim($_COOKIE["su_st_3"]));
		}		  
	  
	 // echo($_COOKIE["su_st_2"]);
if ((isset($_COOKIE["su_st_2"]))and($_COOKIE["su_st_2"]!=''))
{
    //echo("!");
    /*
  $result_t2=mysql_time_query($link,'Select DISTINCT b.*,(SELECT sum(c.count_units) as cc FROM z_stock_material as c WHERE c.id_stock=b.id) as ccs from z_stock as b,z_stock_group as a,z_stock_material as c where c.id_stock=b.id and not(a.id=0) '.$sql_su2.' '.$sql_su3.' '.$sql_su4.' '.$sql_su1.' '.limitPage('n_st',$count_write));


	
  $sql_count='Select count(DISTINCT b.id) as kol from z_stock as b,z_stock_group as a,z_stock_material as c where  c.id_stock=b.id and not(a.id=0) '.$sql_su2.' '.$sql_su3.' '.$sql_su4_;
*/

    $sql_su1=' order by b.name';
    $sql_su1_=' order by a.name';
    $result_t2=mysql_time_query($link,'Select DISTINCT b.*,(SELECT sum(c.count_units) as cc FROM z_stock_material as c WHERE c.id_stock=b.id) as ccs from z_stock as b,z_stock_material as c where '.$sql_su3.' and c.id_stock=b.id '.$sql_su1.' '.limitPage('n_st',$count_write));

    //echo 'Select DISTINCT b.*,(SELECT sum(c.count_units) as cc FROM z_stock_material as c WHERE c.id_stock=b.id) as ccs from z_stock as b,z_stock_material as c where c.id_stock=b.id '.$sql_su3.' '.$sql_su1.' '.limitPage('n_st',$count_write);


    $sql_count='Select count(DISTINCT b.id) as kol from z_stock as b,z_stock_material as c where '.$sql_su3_.' and  c.id_stock=b.id';

} else
{
  $result_t2=mysql_time_query($link,'Select DISTINCT b.*,(SELECT sum(c.count_units) as cc FROM z_stock_material as c WHERE c.id_stock=b.id) as ccs from z_stock as b,z_stock_material as c '.$sql_select.' where c.id_stock=b.id  '.$sql_select1.' '.$sql_su2.'  '.$sql_su4.' '.$sql_su1.' '.limitPage('n_st',$count_write));

//echo 'Select DISTINCT b.*,(SELECT sum(c.count_units) as cc FROM z_stock_material as c WHERE c.id_stock=b.id) as ccs from z_stock as b,z_stock_material as c '.$sql_select.' where c.id_stock=b.id  '.$sql_select1.' '.$sql_su2.'  '.$sql_su4.' '.$sql_su1.' '.limitPage('n_st',$count_write);

  $sql_count='Select count(DISTINCT b.id) as kol from z_stock as b,z_stock_material as c '.$sql_select_.' where c.id_stock=b.id '.$sql_select1_.' '.$sql_su2.'  '.$sql_su4_;
}
	
$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);	  

echo' <h3 class="head_h" style=" margin-bottom:0px;">Склад материалов<i>'.$row__221["kol"].'</i><div></div></h3> ';	  
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
					  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2 stock_table_list"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Наименование</th><th class="t_1"></th><th class="t_1">Связь</th><th class="t_1">Тип</th><th class="t_1">Количество</th><th class="t_1"></th><th class="t_8">Ед. Изм.</th><th class="t_10"></th></tr></thead><tbody>';

	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {

					$row__2= mysqli_fetch_assoc($result_t2);

						 
echo'<tr class="nary n1n suppp_tr" idu_stock="'.$row__2["id"].'"><td class="middle_ gray-2022-color">'.$row__2["id"].'</td><td colspan="2" class="middle_"><div class="nm supl"><a href="stock/'.$row__2["id"].'/" class="s_j">'.$row__2["name"].'</a></div>';

						 
echo'</td>';
						 
echo'<td style="white-space:nowrap;">';

$svyz=0;						 
//количество взаимосвязей в себестоимости
$result_t1_=mysql_time_query($link,'SELECT count(A.id) as cc FROM i_material as A WHERE A.id_stock="'.$row__2["id"].'"');
	
$z_rabota2=0;	             	 
$num_results_t1_ = $result_t1_->num_rows;
if($num_results_t1_!=0)
{  		             
	$row1ss_ = mysqli_fetch_assoc($result_t1_);
	if(($row1ss_["cc"]!='')and($row1ss_["cc"]!=0))
	{
		$z_rabota2=$row1ss_["cc"];
		$svyz++;
	}					 
}	
						 
//количество взаимосвязей в заявках
$result_t1_=mysql_time_query($link,'SELECT count(A.id) as cc FROM z_doc_material as A WHERE A.id_stock="'.$row__2["id"].'"');
	
$z_rabota3=0;	             	 
$num_results_t1_ = $result_t1_->num_rows;
if($num_results_t1_!=0)
{  		             
	$row1ss_ = mysqli_fetch_assoc($result_t1_);
	if(($row1ss_["cc"]!='')and($row1ss_["cc"]!=0))
	{
		$z_rabota3=$row1ss_["cc"];
		$svyz++;
	}					 
}						 
//количество взаимосвязей в заявках
$result_t1_=mysql_time_query($link,'SELECT count(A.id) as cc FROM z_invoice_material as A WHERE A.id_stock="'.$row__2["id"].'"');
	
$z_rabota4=0;	             	 
$num_results_t1_ = $result_t1_->num_rows;
if($num_results_t1_!=0)
{  		             
	$row1ss_ = mysqli_fetch_assoc($result_t1_);
	if(($row1ss_["cc"]!='')and($row1ss_["cc"]!=0))
	{
		$z_rabota4=$row1ss_["cc"];
		$svyz++;
	}					 
}							 
						 
						 
echo'<div class="skladd_nei1"><span class="yest_sklad" data-tooltip="в себестоимости">'.$z_rabota2.'</span> / <span data-tooltip="в заявках" class="yest_users">'.$z_rabota3.'</span> / <span data-tooltip="в накладных" class="yest_users">'.$z_rabota4.'</span> </div>';						 
						 
echo'</td>';						 
echo'<td>';
						 
						 
if(($row__2["id_stock_group"]!=0)and($row__2["id_stock_group"]!=''))
{						 
	
	$result_xp=mysql_time_query($link,'SELECT b.* FROM z_stock_group as b WHERE b.id="'.htmlspecialchars(trim($row__2["id_stock_group"])).'"');
					        	 
	$num_results_xp = $result_xp->num_rows;
	if($num_results_xp!=0)
	{  
		//такая работа есть
		$row_xp = mysqli_fetch_assoc($result_xp);		
		echo'<span>'.$row_xp["name"].'</span>';
	} else
	{
		echo'<span>-</span>';
	}
		
}	else
	{
		echo'<span>-</span>';
	}					 
//echo'<div class="supply_bb1 yoop_ hide_yoop" id_ada="'.$row__2["id_stock"].'">';
$echo='';
//$row__2["id_stock"]


						 

//echo'<div class="yoop_"><div class="yoop_rt"><span>на складе</span> <i>'.$z_stock_count_users.'</i> <strong>'.$units.'</strong></div>';	
//echo'<div class="yoop_rt"><span>на складе</span> <i>'.$z_stock_count_users.'</i> <strong>'.$units.'</strong></div></div>';							 
						 
						 
echo'</td>';
						 
echo'<td colspan="2" >';
//вывод заложенной стоимости за единицу товара из себестоимости
//определяем количество материала на складе
$result_xp=mysql_time_query($link,'SELECT sum(b.count_units) as cc FROM z_stock_material as b WHERE b.id_stock="'.htmlspecialchars(trim($row__2["id"])).'"');
					        	 
$num_results_xp = $result_xp->num_rows;
if($num_results_xp!=0)
{  
		//такая работа есть
		$row_xp = mysqli_fetch_assoc($result_xp);
	if($row_xp["cc"]!=0)
	{
		echo'<span class="count_stock_x">'.$row_xp["cc"].'</span>';
		$svyz++;	
	} else
	{
		echo'<span class="count_stock_x">0</span>';
	}
}						 
		
echo'</td>';						 
						 
					 
		 
echo'<td>';

echo($row__2["units"]);			 
				 
						 
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
if($svyz==0)
{
		if (($role->permission('Склад','U'))or($sign_admin==1))
	{
echo'<div data-tooltip="Удалить" rel_bill="'.$row__2["id"].'" class="user_mat xvg_no1"></div><div data-tooltip="Изменить" rel_bill="'.$row__2["id"].'" class="user_mat xvg_yes1"></div>';		
	}
}			 
	
	echo'</td>		   
		   
		   </tr>';		

	
echo'<tr idu_stock="'.$row__2["id"].'" class="tr_dop_supply_line"><td colspan="9"></td></tr>';						 


	

					  
						 
					 }
echo'</tbody></table>'; 
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_1").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';	 
					  
					  
	  $count_pages=CountPage($sql_count,$link,$count_write);
	  if($count_pages>1)
	  {


			  displayPageLink_new('stock/','stock/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
		  
	    
	  }
					  
					  
 } else
				  {
					  

                      echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>С такими параметрами ничего не найдено.</span></span></div>';
					  
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