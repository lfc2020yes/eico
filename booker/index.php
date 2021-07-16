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

	  include_once $url_system.'template/top_booker.php';

echo'<div id="fullpage" class="margin_60  input-block-2020 ">
    <div class="oka_block_2019" style="min-height:auto;">
 <div class="oka_block">
<div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">';

    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?



  
	  
	  	//echo'</div>';  
if((isset($_GET["tabs"]))and($_GET["tabs"]==2))
{
    //оплаченные

    $arr_tasks = $edo->my_tasks(1, '>0'
        ,'ORDER BY d.date_create DESC'
        ,limitPage('n_st',$count_write)
        ,3);


} else
{
    //неоплаченные
    $arr_tasks = $edo->my_tasks(1, '=0'
        ,'ORDER BY d.date_create DESC'
        ,limitPage('n_st',$count_write)
        ,3);
}
   //запрос для определения общего количества = 
	  /*
   $sql_count='select count(a.id) as kol from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).')';
*/


//echo' <h3 class="head_h" style=" margin-bottom:0px;">'.$menu_title[$title_key].'<i>'.$value21["kol"].'</i><div></div></h3>';	  
	  
                  // $num_results_t2 = $result_t2->num_rows;
	              if(count($arr_tasks)!=0)
	              {
	
					  
				  
				  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2 booker_table"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Счет</th><th class="t_1">Сумма</th><th class="t_1">Оплатить</th><th class="t_1">Поставщик</th><th class="t_1">Документы</th><th class="t_1"></th><th class="t_8 center_">Действия</th><th class="t_10"></th></tr></thead><tbody>';
			
			$date_paid='';		  
		  foreach ($arr_tasks as $key => $value) {
		      

                  $cll = '';
                  if ($value["status"] == 10) {
                      $cll = 'whites';
                  }
                  if ($ksss != 0) {
                      //echo'<tr><td colspan="8" height="20px"></td></tr>';	
                  }


                  $result_t1 = mysql_time_query($link, 'Select a.* from z_contractor as a where a.id="' . $value["id_contractor"] . '"');
                  $num_results_t1 = $result_t1->num_rows;
                  if ($num_results_t1 != 0) {
                      $row_t1 = mysqli_fetch_assoc($result_t1);
                  }
                  $opl = 0;
                  $mess = '';


                  if ($value["status"] == 3) {
                      $day_raz = dateDiff_1(date('Y-m-d'), $value["date_buy"]);
                      if (($ksss == 0) and (($value["date_buy"] == '0000-00-00') or ($value["date_buy"] == date("Y-m-d")) or ($day_raz > 0))) {
                          $date_paid = $value["date_buy"];
                          $opl = 1;
                          $mess = 'Оплатить Сегодня';
                      } else {
                          if ($ksss == 0) {
                              $date_paid = $value["date_buy"];
                              $opl = 1;
                              $mess = 'Оплатить ' . time_stamp_mess($value["date_buy"] . ' 00:00:00');
                          } else {

                              if (($value["date_buy"] != $date_paid) and ($value["date_buy"] != date("Y-m-d")) and ($day_raz <= 0)) {
                                  $date_paid = $value["date_buy"];
                                  $opl = 1;
                                  $mess = 'Оплатить ' . time_stamp_mess($value["date_buy"] . ' 00:00:00');
                              }

                          }
                      }
                  } else {
                      $day_raz = dateDiff_1(date('Y-m-d'), $value["date_paid"]);


                      if ($value["date_paid"] != $date_paid) {
                          $date_paid = $value["date_paid"];
                          $opl = 1;
                          $mess = time_stamp_mess($value["date_paid"] . ' 00:00:00');
                      }


                  }
                  if ($opl == 1) {


                      echo '<tr style="height:50px;" id_book="' . $value["id"] . '" class="tr_dop_supply_line ' . $sql_su4 . '"><td colspan="9"><div class="okss" style="margin-bottom: 20px;
margin-top: 20px;"><span class="title_book" style="padding-left: 0px; margin: 0px;">' . $mess . '</span></div><td></tr>';


                  }


                  echo '<tr class="book nary n1n suppp_tr" rel_id="' . $value["id"] . '"><td class="middle_"></td><td  class="middle_"><div class="nm supl"><a href="acc/' . $value["id"] . '/" class="s_j new-aa-2021"><span>Счет №' . $value["number"] . '</span></a></div>';
                  $date_graf2 = explode("-", $value["date"]);
                  echo '<span class="stock_name_mat">от ' . $date_graf2[2] . '.' . $date_graf2[1] . '.' . $date_graf2[0] . '</span>';


                  echo '</td>';

                  $ddd = '';
                  if ($value["status"] != 4) {

                      $date_delivery = date_step(date('Y-m-d'), $value["delivery_day"]);
                  } else {
                      $date_delivery = date_step($value["date_paid"], $value["delivery_day"]);
                  }

                  $date_graf3 = explode("-", $date_delivery);


                  if (strtotime($date_delivery) != 0) {

                      //$date_graf3  = explode("-",$value["date_delivery"]);
                      $ddd = $date_graf3[2] . '.' . $date_graf3[1] . '.' . $date_graf3[0];
                  }

                  echo '<td>';

                  echo '<span data-tooltip="Сумма по счету" class="s_j pay_summ">' . rtrim(rtrim(number_format($value["summa"], 2, '.', ' '), '0'), '.') . '</span>';

                  if ($ddd != '') {
                      echo '<div class="stock_name_mat">доставка ~ ' . $ddd . '</div>';
                  }

                  echo '</td>';

                  echo '<td>';

                  if (($value["path_summa"] != '') and ($value["path_summa"] != 0)) {
                      echo '<span data-tooltip="Сумма к оплате" class="s_j pay_summ" style="border-bottom: 2px solid #24c32d;">' . rtrim(rtrim(number_format($value["path_summa"], 2, '.', ' '), '0'), '.') . '</span>';

                  } else {
                      echo '<span data-tooltip="Сумма к оплате" class="s_j pay_summ" style="border-bottom: 2px solid #24c32d;">' . rtrim(rtrim(number_format($value["summa"], 2, '.', ' '), '0'), '.') . '</span>';
                  }

                  echo '</td>';


                  echo '<td>' . $row_t1["name"] . '</td><td colspan="2">';


                  $result_6 = mysql_time_query($link, 'select A.* from image_attach as A WHERE A.for_what="8" and A.visible=1 and A.id_object="' . ht($value['id']) . '"');

                  $num_results_uu = $result_6->num_rows;

                  if ($num_results_uu != 0) {
                      while ($row_6 = mysqli_fetch_assoc($result_6)) {

                          echo '<div class="li-image download-file"><span class="name-img"><a class="bold_file" target="_blank" href="/upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '">' . $row_6["name_user"] . '</a></span><span class="size-img">' . $row_6["type"] . ', ' . get_filesize($url_system . 'upload/file/' . $row_6["id"] . '_' . $row_6["name"] . '.' . $row_6["type"] . '') . '</span></div>';

                      }
                  }


                  echo '</td>';


                  echo '<td colspan="2" class="menu_jjs button_ada_wall">';

                  if ($value["status"] == 3) {

                      echo '<div  data-tooltip="Подтвердить оплату" rel_booker="' . $value["id"] . '" class="user_mat xvg_yes booker_yes"></div>';
                  } else {

                      $date_graf3 = explode("-", $value["date_paid"]);
                      $ddd1 = $date_graf3[2] . '.' . $date_graf3[1] . '.' . $date_graf3[0];


                      $result_txs = mysql_time_query($link, 'Select a.id,a.name_user,a.timelast from r_user as a where a.id="' . htmlspecialchars(trim($value["id_user_paid"])) . '"');

                      if ($result_txs->num_rows != 0) {
                          //такая работа есть
                          $rowxs = mysqli_fetch_assoc($result_txs);

                      }

                      echo '<div class="mat_memo_zay">ОПЛАЧЕНО<br>' . $rowxs["name_user"] . '<br><strong>' . $ddd1 . '</strong></div>';
                  }

                  echo '</td>';


                  /*
                  echo'<td class="pre-wrap"><span class="per">';
                  
                  echo MaskDate($value["date_begin"]).' - '.MaskDate($value["date_end"]);						 
                  
                  echo'</span></td>';
                  */

                  /*						 
                  echo'<td><span class="s_j"><strong>'.rtrim(rtrim(number_format(($value["summa_work"]+$value["summa_material"]), 2, '.', ' '),'0'),'.').'</strong>';
                  if($edit_price==1)
                  {
                    //выводим на сколько привышение если есть
                      
                  }
                                           
                  echo'</span></td>';
                  */

                  echo '</tr>';


                  echo '<tr supply_stock="57" class="tr_dop_supply tr_dop_memo none" style="display: table-row;"><td><span class="zay_str">→</span></td><td colspan="3"><label>Комментарий по оплате</label><div class="mat_memo_zay">' . $value["comment_status"] . '</div></td><td colspan="2">';
                  if (($value["path_summa"] != '') and ($value["path_summa"] != 0)) {
                      echo '<label>Оплатить частично</label><div class="mat_memo_zay">' . rtrim(rtrim(number_format($value["path_summa"], 2, '.', ' '), '0'), '.') . '</div>';
                  }


                  echo '</td><td colspan="3">';

                  if (($value["date_buy"] != '') and ($value["date_buy"] != 0)) {
                      $date_graf3 = explode("-", $value["date_buy"]);
                      $ddd = $date_graf3[2] . '.' . $date_graf3[1] . '.' . $date_graf3[0];

                      echo '<label>Оплатить после</label><div class="mat_memo_zay">' . $ddd . '</div>';
                  }


                  echo '</td></tr>';


                  echo '<tr id_book="' . $value["id"] . '" class="tr_dop_supply_line ' . $sql_su4 . '"><td colspan="9"></td></tr>';

              

          }
echo'</tbody></table>'; 
					  
					  
				
					  
					  
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_1").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';


                      $count_pages=ceil($subor_cc[$mym]/$count_write);

                      if($count_pages>1)
                      {
                          if(isset($_GET["tabs"]))
                          {
                              displayPageLink_new('booker/.tabs-'.$_GET["tabs"].'','booker/.tabs-'.$_GET["tabs"].'.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
                          } else
                          {
                              displayPageLink_new('booker/','booker/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
                          }

                      }

	  } else
                  {

                      echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Пока счетов в разделе нет.</span></span></div>';


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

</body></html>