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
if (( count($_GET) != 1 )and( count($_GET) != 0 )and( count($_GET) != 2 ) )
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

	  include_once $url_system.'template/top_supply.php';

	            ?>
      <div id="fullpage" class="margin_60  input-block-2020 ">
          <div class="oka_block_2019" style="min-height:auto;">
              <div class="div_ook hop_ds _hop_ds_2021"><div class="search_task">
                      <?
                      /*
                      $os = array( "дата поставки","дата поступления заявки");
                      $os_id = array("0", "1", "2");

                      $su_1=0;
                      if (( isset($_COOKIE["su_1"]))and(is_numeric($_COOKIE["su_1"]))and(array_search($_COOKIE["su_1"],$os_id)!==false))
                      {
                          $su_1=$_COOKIE["su_1"];
                      }


                      echo'<div class="left_drop menu1_prime book_menu_sel js--sort gop_io"><label>Сортировка</label><div class="select eddd"><a class="slct" list_number="t1" data_src="'.$os_id[$su_1].'">'.$os[$su_1].'</a><ul class="drop">';
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
                      echo'</ul><input type="hidden" name="sort1" id="sort1" value="'.$os[$su_1].'"></div></div>';
*/




                      $os2 = array( "любой","выбрать");
                      $os_id2 = array("0", "2");

                      $su_2=0;
                      $date_su='';
                      if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and(array_search($_COOKIE["su_2"],$os_id2)!==false))
                      {
                          $su_2=$_COOKIE["su_2"];
                      }
                      $val_su2=$os2[$su_2];


                      if ( isset($_COOKIE["suddbc".$id_user]))
                      {
                          $date_base__=explode(".",$_COOKIE["sudd"]);
                          if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and($_COOKIE["su_2"]==2))
                          {
                              $date_su=$_COOKIE["suddbc_mor".$id_user];
                              $val_su2=$_COOKIE["suddbc_mor".$id_user];
                          }
                      }


                      echo'<input id="date_hidden_table" name="date" value="'.$date_su.'" type="hidden"><input id="date_hidden_start" name="start_date" type="hidden"><input id="date_hidden_end" name="end_date" type="hidden">';
                      echo'<div class="left_drop menu1_prime book_menu_sel js--sort js-call-no-v gop_io"><label>Период</label><div class="select eddd"><a class="slct" list_number="t2" data_src="'.$os_id2[$su_2].'">'.$val_su2.'</a><ul class="drop">';
                      for ($i=0; $i<count($os2); $i++)
                      {
                          if($su_2==$os_id2[$i])
                          {
                              echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$os_id2[$i].'">'.$os2[$i].'</a></li>';
                          } else
                          {
                              echo'<li><a href="javascript:void(0);"  rel="'.$os_id2[$i].'">'.$os2[$i].'</a></li>';
                          }

                      }
                      echo'</ul><input type="hidden" name="sort2" id="sort2" value="'.$os2[$su_2].'"></div></div>';


                      $os3 = array( "любой", "не обработанные","в работе","на согласовании","заказано");
                      $os_id3 = array("0", "9", "11","12","20");

                      $su_3=0;
                      if (( isset($_COOKIE["su_3"]))and(is_numeric($_COOKIE["su_3"]))and(array_search($_COOKIE["su_3"],$os_id3)!==false))
                      {
                          $su_3=$_COOKIE["su_3"];
                      }


                      echo'<div class="left_drop menu1_prime book_menu_sel js--sort js-dava-hide gop_io"><label>Статус</label><div class="select eddd"><a class="slct" list_number="t3" data_src="'.$os_id3[$su_3].'">'.$os3[array_search($_COOKIE["su_3"], $os_id3)].'</a><ul class="drop">';
                      for ($i=0; $i<count($os3); $i++)
                      {
                          if($su_3==$os_id3[$i])
                          {
                              echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$os_id3[$i].'">'.$os3[$i].'</a></li>';
                          } else
                          {
                              echo'<li><a href="javascript:void(0);"  rel="'.$os_id3[$i].'">'.$os3[$i].'</a></li>';
                          }

                      }
                      echo'</ul><input type="hidden" name="sort3" id="sort3" value="'.$os3[$su_3].'"></div></div>';



                      $os4 = array( "краткий", "подробный","еще необходимо");
                      $os_id4 = array("0", "1","2");

                      $su_4=0;
                      if (( isset($_COOKIE["su_4"]))and(is_numeric($_COOKIE["su_4"]))and(array_search($_COOKIE["su_4"],$os_id4)!==false))
                      {
                          $su_4=$_COOKIE["su_4"];
                      }


                      echo'<div class="left_drop menu1_prime book_menu_sel js--sort gop_io"><label>Вид</label><div class="select eddd"><a class="slct" list_number="t4" data_src="'.$os_id4[$su_4].'">'.$os4[array_search($_COOKIE["su_4"], $os_id4)].'</a><ul class="drop">';
                      for ($i=0; $i<count($os4); $i++)
                      {
                          if($su_4==$os_id4[$i])
                          {
                              echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$os_id4[$i].'">'.$os4[$i].'</a></li>';
                          } else
                          {
                              echo'<li><a href="javascript:void(0);"  rel="'.$os_id4[$i].'">'.$os4[$i].'</a></li>';
                          }

                      }
                      echo'</ul><input type="hidden" name="sort4" id="sort4" value="'.$os4[$su_4].'"></div></div>';

$dava_var=0;
$dava_class='';

                      if (( isset($_COOKIE["dava_".$id_user]))and($_COOKIE["dava_".$id_user]==1))
                      {


                          $dava_var=1;
                          $dava_class='active_task_cb';
                      }


echo'<div class="left_drop menu1_prime book_menu_sel js--sort gop_io " style="margin-top: 0px !important;">
<div class="input-choice-click-left js-checkbox-group js-dava-click" style="margin-top: 0px; border-radius: 5px; background: transparent;
">
                     <div class="choice-head">Давальческий</div>
                 <div class="choice-radio" style="left: 15px;"><div class="center_vert1"><i class="'.$dava_class.'"></i><input name="dava_supply" value="'.$dava_var.'" class="js-dava-supply" type="hidden"></div></div></div>
</div>';


echo'<div class="left_drop menu1_prime book_menu_sel js--sort gop_io"><a style="float:left;" href="supply/csv/csv.php" class="search-count-csv">excel</a></div>';


echo'<div class="inline_reload js-reload-top"><a href="supply/" class="show_reload">Поиск</a></div>';

                      //echo'<a href="supply/" class="show_sort_supply"><i>Применить</i></a>';
                      ?>
                      <!--
                      <div id="date_table" class="table_suply_x"></div>

                      <div class="pad10" style="padding: 0;"><span class="bookingBox_range" style="display: none;"></span></div>
-->
                      <div class="pad10" style="padding: 0;"><span class="bookingBox_range"><div id="date_table" class="table_suply_x_st"></div></span></div>


                      <script type="text/javascript">
                          (function ($) {
                              $.extend($.datepicker, {

                                  // Reference the orignal function so we can override it and call it later
                                  _inlineDatepicker2: $.datepicker._inlineDatepicker,

                                  // Override the _inlineDatepicker method
                                  _inlineDatepicker: function (target, inst) {

                                      // Call the original
                                      this._inlineDatepicker2(target, inst);

                                      var beforeShow = $.datepicker._get(inst, 'beforeShow');

                                      if (beforeShow) {
                                          beforeShow.apply(target, [target, inst]);
                                      }
                                  }
                              });
                          }(jQuery));

                          var disabledDays = [];
                          $(document).ready(function(){

                              window.date_picker_step=0;


                              $("#date_table").datepicker({
                                  range: 'period', // режим - выбор периода
                                  numberOfMonths: 2,
                                  firstDay: 1,
                                  autoclose: true,
                                  minDate: "-1Y", maxDate: "+1Y",
                                  onSelect: function(dateText, inst, extensionRange) {

                                      $('#date_table').val(jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.startDate) + ' - ' + jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.endDate));

                                      var iu=$('.content_block').attr('iu');

                                      $.cookie("suddbc_mor"+iu, null, {path:'/',domain: window.is_session,secure: false});
                                      CookieList("suddbc_mor"+iu,jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.startDate) + ' - ' + jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.endDate),'add');


                                      $('#date_hidden_start').val(jQuery.datepicker.formatDate('yy-mm-dd',extensionRange.startDate));
                                      $('#date_hidden_end').val(jQuery.datepicker.formatDate('yy-mm-dd',extensionRange.endDate));

                                      $('[list_number=t2]').empty().append(jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.startDate) + ' - ' + jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.endDate));
                                      $.cookie("suddbc"+iu, null, {path:'/',domain: window.is_session,secure: false});
                                      CookieList("suddbc"+iu,$('#date_hidden_start').val()+'/'+$('#date_hidden_end').val(),'add');

                                      $('.js-reload-top').removeClass('active-r');
                                      $('.js-reload-top').addClass('active-r');
                                      window.date_picker_step++;



                                      if(window.date_picker_step==2)
                                      {
                                          //$('#date_table').сlose();
                                          //$('.datepicker').hide();
                                          window.date_picker_step=0;
                                          setTimeout ( function () { $('.bookingBox_range').hide(); }, 1000 );
                                          alert_message('ok','для обновления вывода нажмите кнопку поиск');
                                      }
                                  },


                                  beforeShow: function(textbox, instance){
                                      setTimeout(function() {
                                          instance.dpDiv.css({
                                              width:'100%'
                                          });
                                          $('.bookingBox_range').css({
                                              display:'none'
                                          });

                                      }, 10);


                                      <?
                                      if((isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and($_COOKIE["su_2"]==2))
                                      {
                                          $date_range=explode("/",$_COOKIE["suddbc".$id_user]);
                                          echo'var st=\''.ipost_($date_range[0],'').'\';
var st1=\''.ipost_($date_range[1],'').'\';
var st2=\''.ipost_($_COOKIE["suddbc_mor".$id_user],'').'\';';
                                          echo'jopacalendar(st,st1,st2);';
                                      }
                                      ?>


                                  }

                              });




                          });
                          function resizeDatepicker() {
                              //$('.ui-datepicker').width('100%');
                          }

                          function jopacalendar(queryDate,queryDate1,date_all)
                          {

                              if(date_all!='')
                              {
                                  var dateParts = queryDate.match(/(\d+)/g), realDate = new Date(dateParts[0], dateParts[1] -1, dateParts[2]);
                                  var dateParts1 = queryDate1.match(/(\d+)/g), realDate1 = new Date(dateParts1[0], dateParts1[1] -1, dateParts1[2]);
                                  //alert(realDate);
                                  $('#date_table').datepicker('setDate', [realDate,realDate1]);
                                  $('#date_table').val(date_all);
                                  //alert($('#date_table').val());
                              }
                          }




                      </script>
                  </div>
              </div>
              <div class="oka_block">
                  <div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">

<?
    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?

//дата поставки
	  $sql_order1=' order by b.date_delivery';
      $sql_order=' ';
$sql_last='';
/*
 		if (( isset($_COOKIE["su_1"]))and(is_numeric($_COOKIE["su_1"]))and(array_search($_COOKIE["su_1"],$os_id)!==false))
		{

			if($_COOKIE["su_1"]==2)
			{
			    //по алфавиту
                $sql_order1=' order by c.material';
                $sql_order=' ';
			}
			if($_COOKIE["su_1"]==1)
			{
			    //новые
                $sql_order=' order by z.date_last desc';
                $sql_order1='';
                $sql_last=',a.date_last';
			}
		}
*/
	  
	  $sql_su2='';
	  $sql_su2_='';
 		if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and(array_search($_COOKIE["su_2"],$os_id2)!==false)and($_COOKIE["su_2"]!=0))
		{

				if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and($_COOKIE["su_2"]==2))
				{
				    //выбранный период

                    $date_range = explode("/", $_COOKIE["suddbc" . $id_user]);
                        //Выбранные период пользователем
                    if((!isset($_COOKIE["su_1"]))or((isset($_COOKIE["su_1"]))and($_COOKIE["su_1"]==0))) {

                        $sql_su2 = ' and b.date_delivery>="' . ht($date_range[0]) . '" and b.date_delivery<="' . ht($date_range[1]) . '"';
                        $sql_su2_ = ' and a.date_delivery>="' . ht($date_range[0]) . '" and a.date_delivery<="' . ht($date_range[1]) . '"';

                    } else
                    {
                        $sql_su2 = ' and a.date_last>="' . ht($date_range[0]) . '" and a.date_last<="' . ht($date_range[1]) . '"';
                        $sql_su2_ = ' and b.date_last>="' . ht($date_range[0]) . '" and b.date_last<="' . ht($date_range[1]) . '"';
                    }


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

$sql_su4_x='';
 		if (( isset($_COOKIE["su_4"]))and(is_numeric($_COOKIE["su_4"]))and(array_search($_COOKIE["su_4"],$os_id4)!==false)and($_COOKIE["su_4"]==1))
		{
	  $sql_su4='';
	  $sql_su4_='active_supplyx';
		}

if (( isset($_COOKIE["su_4"]))and(is_numeric($_COOKIE["su_4"]))and(array_search($_COOKIE["su_4"],$os_id4)!==false)and($_COOKIE["su_4"]==2))
{
    //подробный+еще необходимо не равно 0
   /* $sql_su4='';
    $sql_su4_='active_supplyx';*/

    $sql_su4_x=' AND tem.nado>0 ';
}
	  /*
  $result_t2=mysql_time_query($link,'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') AND b.status NOT IN ("1","8","10","3","5","4") '.$sql_su2.' '.$sql_su3.' '.$sql_su1.' '.limitPage('n_st',$count_write));
*/

//,b.id_i_material



//создаем временную таблицу
//создаем временную таблицу
//создаем временную таблицу

$result_8 = mysql_time_query($link, 'CREATE TEMPORARY TABLE supply_temp  as (


SELECT DISTINCT 
b.id_stock

FROM 
z_doc AS a,
z_doc_material AS b,
i_material AS c, 
edo_state AS edo

WHERE 
c.`alien` = '.$dava_var.'      
AND c.id=b.id_i_material 
AND a.id=b.id_doc 
 AND a.id_edo_run = edo.id_run
 AND edo.id_status = 0
 AND edo.id_executor IN ('.ht($id_user).')

 AND b.status NOT IN ("1","8","10","3","5","4") 
 '.$sql_su2.' 
  '.$sql_su3.' 
 '.$sql_order1.' 

  
 )');
/*
echo 'CREATE TEMPORARY TABLE supply_temp  as (


SELECT DISTINCT 
b.id_stock

FROM 
z_doc AS a,
z_doc_material AS b,
i_material AS c, 
edo_state AS edo

WHERE 
c.`alien` = '.$dava_var.'      
AND c.id=b.id_i_material 
AND a.id=b.id_doc 
 AND a.id_edo_run = edo.id_run
 AND edo.id_status = 0
 AND edo.id_executor IN ('.ht($id_user).')

 AND b.status NOT IN ("1","8","10","3","5","4") 
 '.$sql_su2.' 
  '.$sql_su3.' 
 '.$sql_order1.' 

  
 )';
*/

//создаем столбцы нужного типа во временной таблице
$result_temp = mysql_time_query($link, '
ALTER TABLE supply_temp
ADD COLUMN stock decimal(11,3) NOT NULL,
ADD COLUMN app decimal(11,3) NOT NULL,
ADD COLUMN works decimal(11,3) NOT NULL,
ADD COLUMN acc_sign decimal(11,3) NOT NULL,
ADD COLUMN acc_sign_yes decimal(11,3) NOT NULL,
ADD COLUMN pay decimal(11,3) NOT NULL,
ADD COLUMN nado decimal(11,3) NOT NULL;
');

//идем по временной таблице и узнаем сколько надо а сколько нет
$result_temp = mysql_time_query($link, 'select * from supply_temp');

if ($result_temp) {
    $i = 0;
    while ($row_temp = mysqli_fetch_assoc($result_temp)) {


        if ($row_temp["id_stock"] != 0) {
//узнаем сколько материала на складе
            $result_t1_ = mysql_time_query($link, 'SELECT b.units,(SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_stock=b.id and a.alien=0) as summ FROM z_stock as b WHERE b.id="' . htmlspecialchars(trim($row_temp["id_stock"])) . '"');
            $z_stock_count_users = 0;
            $num_results_t1_ = $result_t1_->num_rows;
            if ($num_results_t1_ != 0) {
                //такая работа есть
                $row1ss_ = mysqli_fetch_assoc($result_t1_);
                if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                    $z_stock_count_users = $row1ss_["summ"];
                }

               // $echo .= '<div class="yoop_rt"><span>на складе</span><i>' . $z_stock_count_users . '</i> <strong>' . $row1ss_["units"] . '</strong></div>';


            }

//узнаем сколько материала в заявке
            /*
        $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.status=9 and  a.id_stock="'.htmlspecialchars(trim($row__2["id_stock"])).'"');
            */
            /*
z_doc as doc    doc.id=a.id_doc

            , edo_state AS edo WHERE doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.')
*/

            $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a,i_material as b,z_doc as doc, edo_state AS edo WHERE doc.id=a.id_doc and doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and a.id_i_material=b.id and b.alien=0 and a.status=9 and  a.id_stock="' . htmlspecialchars(trim($row_temp["id_stock"])) . '"');

            $z_zakaz = 0;
            $num_results_t1_ = $result_t1_->num_rows;
            if ($num_results_t1_ != 0) {
                //такая работа есть
                $row1ss_ = mysqli_fetch_assoc($result_t1_);
                if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                    $z_zakaz = $row1ss_["summ"];
                }
                //$echo .= '<div class="yoop_rt "><span>в заявках</span><i>' . $z_zakaz . '</i> <strong>' . $units . '</strong></div>';



            }
//узнаем сколько материала в работе

            /*
z_doc as doc    doc.id=a.id_doc

            , edo_state AS edo WHERE doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.')
*/


            $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a,z_doc as doc, edo_state AS edo WHERE doc.id=a.id_doc and doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and  a.status=11 and  a.id_stock="' . htmlspecialchars(trim($row_temp["id_stock"])) . '"');
            $z_rabota = 0;
            $num_results_t1_ = $result_t1_->num_rows;
            if ($num_results_t1_ != 0) {
                //такая работа есть
                $row1ss_ = mysqli_fetch_assoc($result_t1_);
                if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                    $z_rabota = $row1ss_["summ"];
                }
                //$echo .= '<div class="yoop_rt "><span>в работе</span><i>' . $z_rabota . '</i> <strong>' . $units . '</strong></div>';
            }

//узнаем сколько материала на согласовании со счетом

            /*
z_doc as doc    doc.id=a.id_doc

            , edo_state AS edo WHERE doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.')
*/


            $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c,z_doc as doc,edo_state AS edo WHERE doc.id=c.id_doc and 
                                                                                                                                     doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and
                                                                                                                                     a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($row_temp["id_stock"])) . '" AND a.id_acc=b.id AND b.status=2');

            $z_rabota1 = 0;
            $num_results_t1_ = $result_t1_->num_rows;
            if ($num_results_t1_ != 0) {
                //такая работа есть
                $row1ss_ = mysqli_fetch_assoc($result_t1_);
                if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                    $z_rabota1 = $row1ss_["summ"];
                }
               // $echo .= '<div class="yoop_rt "><span>на согласовании со счетом</span><i>' . round($z_rabota1, 2) . '</i> <strong>' . $units . '</strong></div>';



            }

//узнаем сколько материала согласовано со счетом
            /*
z_doc as doc    doc.id=a.id_doc

            , edo_state AS edo WHERE doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.')
*/


            $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c,z_doc as doc,edo_state AS edo WHERE doc.id=c.id_doc and 
                                                                                                                          doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and          
                                                                                                                                     a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($row_temp["id_stock"])) . '" AND a.id_acc=b.id AND b.status=3');

            $z_rabota2 = 0;
            $num_results_t1_ = $result_t1_->num_rows;
            if ($num_results_t1_ != 0) {
                //такая работа есть
                $row1ss_ = mysqli_fetch_assoc($result_t1_);
                if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                    $z_rabota2 = $row1ss_["summ"];
                }
                //$echo .= '<div class="yoop_rt"><span>согласовано со счетом</span><i>' . round($z_rabota2, 2) . '</i> <strong>' . $units . '</strong></div>';


            }
//узнаем сколько материала оплачено


            /*
z_doc as doc    doc.id=a.id_doc

   , edo_state AS edo WHERE doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.')
*/

            $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c,z_doc as doc,edo_state AS edo WHERE doc.id=c.id_doc and 
                                                                                                                         doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and            
                                                                                                                                     a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($row_temp["id_stock"])) . '" AND a.id_acc=b.id AND b.status=4');
            $z_rabota3 = 0;
            $num_results_t1_ = $result_t1_->num_rows;
            if ($num_results_t1_ != 0) {
                //такая работа есть
                $row1ss_ = mysqli_fetch_assoc($result_t1_);
                if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                    $z_rabota3 = $row1ss_["summ"];
                }
               // $echo .= '<div class="yoop_rt "><span>оплачено</span><i>' . round($z_rabota3, 2) . '</i> <strong>' . $units . '</strong></div>';




            }

//узнаем сколько материала получено по счету

            /*
z_doc as doc    doc.id=a.id_doc

   , edo_state AS edo WHERE doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.')
*/

            $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c,z_doc as doc,edo_state AS edo WHERE doc.id=c.id_doc and 
                                                                                                                             doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and        
                                                                                                                                     a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($row_temp["id_stock"])) . '" AND a.id_acc=b.id AND b.status=7');
            $z_take = 0;
            $num_results_t1_ = $result_t1_->num_rows;
            if ($num_results_t1_ != 0) {
                //такая работа есть
                $row1ss_ = mysqli_fetch_assoc($result_t1_);
                if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                    $z_take = $row1ss_["summ"];
                }
                //$echo.='<div class="yoop_rt "><span>оплачено</span><i>'.round($z_rabota3,2).'</i> <strong>'.$units.'</strong></div>';
            }

//узнаем сколько материала необходимо еще
            /*
        $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.status NOT IN ("1","8","10","3","5","4") and  a.id_stock="'.htmlspecialchars(trim($row__2["id_stock"])).'"');
            */

            /*
z_doc as doc    doc.id=a.id_doc

, edo_state AS edo WHERE doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.')
*/


            $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a,i_material as b,z_doc as doc,edo_state AS edo WHERE doc.id=a.id_doc and 
  
                                                                                                               doc.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and
                                                                                                               a.id_i_material=b.id and b.alien=0 and a.status NOT IN ("1","8","10","3","5","4") and  a.id_stock="' . htmlspecialchars(trim($row_temp["id_stock"])) . '"');

            $z_zakaz = 0;
            $neo=0;
            $num_results_t1_ = $result_t1_->num_rows;
            if ($num_results_t1_ != 0) {
                //такая работа есть
                $row1ss_ = mysqli_fetch_assoc($result_t1_);
                if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                    $z_zakaz = $row1ss_["summ"];
                }

                $neo = round(($z_zakaz - $z_rabota1 - $z_rabota2 - $z_rabota3 - $z_take), 3);

                //echo($row_temp["id_stock"].' - '.$neo.'<br>');

            }



            mysql_time_query($link, 'update supply_temp set
        
        stock="' . $z_stock_count_users . '",nado="' . $neo . '",pay="' . round($z_rabota3, 3) . '",acc_sign_yes="' . round($z_rabota2, 3) . '",acc_sign="' . round($z_rabota1, 3) . '",works="' . $z_rabota . '",app="' . $z_zakaz . '"
        
        where id_stock = "' . $row_temp["id_stock"] . '"');


        }
    }
}
//конец формирования временной таблицы
//конец формирования временной таблицы
//конец формирования временной таблицы






$result_t2=mysql_time_query($link,'SELECT * FROM 
(
SELECT DISTINCT 
tem.id_stock

FROM 
supply_temp as tem

WHERE 
not(tem.id_stock=0)
  '.$sql_su4_x.' 
) AS z 				
 '.limitPage('n_st',$count_write));

/*
echo'SELECT * FROM 
(
SELECT DISTINCT 
b.id_stock'.$sql_last.'

FROM 
z_doc AS a,
z_doc_material AS b,
i_material AS c, 
edo_state AS edo,
supply_temp as tem

WHERE 
tem.id_stock=b.id_stock 
AND c.`alien` = '.$dava_var.'      
AND c.id=b.id_i_material 
AND a.id=b.id_doc 
 AND a.id_edo_run = edo.id_run
 AND edo.id_status = 0
 AND edo.id_executor IN ('.ht($id_user).')

 AND b.status NOT IN ("1","8","10","3","5","4") 
 '.$sql_su2.' 
  '.$sql_su3.'
  '.$sql_su4_x.' 
 '.$sql_order1.' 
) AS z 				
'.$sql_order.' '.limitPage('n_st',$count_write);
*/
/*
echo 'SELECT * FROM 
(
SELECT DISTINCT 
b.id_stock,b.id_i_material'.$sql_last.'

FROM 
z_doc AS a,
z_doc_material AS b,
i_material AS c, 
edo_state AS edo

WHERE 
c.`alien` = '.$dava_var.'      
AND c.id=b.id_i_material 
AND a.id=b.id_doc 
 AND a.id_edo_run = edo.id_run
 AND edo.id_status = 0
 AND edo.id_executor IN ('.ht($id_user).')

 AND b.status NOT IN ("1","8","10","3","5","4") 
 '.$sql_su2.' 
  '.$sql_su3.' 
 '.$sql_order1.' 
) AS z 				
'.$sql_order.' '.limitPage('n_st',$count_write);

	*/
  $sql_count='SELECT count(id_stock) as kol FROM 
(
SELECT DISTINCT 
tem.id_stock

FROM 
  supply_temp as tem

WHERE 
     not(tem.id_stock=0)
  '.$sql_su4_x.' 
) AS z ';
	 
	
	  /*echo('Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where c.id=b.id_i_material and a.id=b.id_doc and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') AND b.status NOT IN ("1","8","10","3","5","4") '.$sql_su2.' '.$sql_su3.' '.$sql_su1.' '.limitPage('n_st',$count_write));
	  */
$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);
echo'<div class="hidden-count-task">'.$row__221["kol"].'</div>';

//echo' <h3 class="head_h" style=" margin-bottom:0px;">Cнабжение<i>'.$row__221["kol"].'</i><div></div></h3> ';
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
					  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_1">Материал</th><th class="t_1"></th><th class="t_1">Описание</th><th class="t_1"></th></th><th class="t_1"></th><th class="t_8 center_">Статус</th><th class="t_10"></th></tr></thead><tbody>';

	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {

					$row__2= mysqli_fetch_assoc($result_t2);
	
		$result_url_m=mysql_time_query($link,'select A.name as material,A.units from z_stock as A where A.id="'.htmlspecialchars(trim($row__2["id_stock"])).'"');
        $num_results_custom_url_m = $result_url_m->num_rows;
        if($num_results_custom_url_m!=0)
        {
			$row_material = mysqli_fetch_assoc($result_url_m);	
		}						 
						 
						 
	

	
	
                       //узнаем название
                      /*
				$result_t22=mysql_time_query($link,'Select a.implementer from i_implementer as a where a.id="'.$row__2["id_implementer"].'"');
                $num_results_t22 = $result_t22->num_rows;
	            if($num_results_t22!=0)
	            {
					$row_t22 = mysqli_fetch_assoc($result_t22);
                   // echo'<a class="musa" href="implementer/'.$row_t2["id"].'/"><span class="s_j">'.$row_t2["implementer"].'</span></a>';
				}*/
$cll='';
/*
if($row_t22["status"]==10)
{
  $cll='whites';
}
	if($ksss!=0)
	{		
	//echo'<tr><td colspan="8" height="20px"></td></tr>';	
	}
*/
                         $dava='';
                         $class_dava='';
                         $style_dava='';
	if($dava_var==1) {
        $dava='<div class="chat_kk" data-tooltip="давальческий материал"></div>';
        $class_dava='dava';
        $style_dava='style="font-size:14px;"';
    }
	
echo'<tr class="nary n1n '.$cll.' suppp_tr '.$sql_su4_.'" rel_id="'.$row__2["id_stock"].'"><td class="middle_"><div class="supply_tr_o"></div></td><td colspan="2" class="middle_"><div class="nm supl"><span class="s_j '.$class_dava.'" '.$style_dava.'>'. $row_material["material"].'</span>'.$dava.'</div>';
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
						 
if($dava_var==0) {

    //echo '<div class="supply_bb1 yoop_ hide_yoop" id_ada="' . $row__2["id_stock"] . '">';


    echo '<div class="eshe-supply-boo material-prime-v22" id_ada="' . $row__2["id_stock"] . '">';

    $echo = '';
//$row__2["id_stock"]
    if ($row__2["id_stock"] != 0) {


        $result_uu_temp = mysql_time_query($link, 'select * from supply_temp where id_stock="' . ht($row__2["id_stock"]) . '"');
        $num_results_uu_temp = $result_uu_temp->num_rows;

        if ($num_results_uu_temp != 0) {
            $row_uu_temp = mysqli_fetch_assoc($result_uu_temp);
        }

        $result_t1_ = mysql_time_query($link, 'SELECT b.units FROM z_stock as b WHERE b.id="' . htmlspecialchars(trim($row__2["id_stock"])) . '"');
        $z_stock_count_users = 0;
        $num_results_t1_ = $result_t1_->num_rows;
        if ($num_results_t1_ != 0) {
            //такая работа есть
            $row1ss_ = mysqli_fetch_assoc($result_t1_);
            $units = $row1ss_["units"];

        }



        //узнаем сколько материала на складе
        /*
        $echo .= '<div class="yoop_rt"><span>на складе</span><i>' . $row_uu_temp["stock"] . '</i> <strong>' . $units . '</strong></div>';
        //узнаем сколько материала в заявке
        $echo .= '<div class="yoop_rt "><span>в заявках</span><i>' . $row_uu_temp["app"] . '</i> <strong>' . $units . '</strong></div>';
        //узнаем сколько материала в работе
        $echo .= '<div class="yoop_rt "><span>в работе</span><i>' . $row_uu_temp["works"] . '</i> <strong>' . $units . '</strong></div>';
        //узнаем сколько материала на согласовании со счетом
        $echo .= '<div class="yoop_rt "><span>на согласовании со счетом</span><i>' . $row_uu_temp["acc_sign"] . '</i> <strong>' . $units . '</strong></div>';
        //узнаем сколько материала согласовано со счетом
        $echo .= '<div class="yoop_rt"><span>согласовано со счетом</span><i>' . $row_uu_temp["acc_sign_yes"] . '</i> <strong>' . $units . '</strong></div>';
        //узнаем сколько материала оплачено
        $echo .= '<div class="yoop_rt "><span>оплачено</span><i>' . $row_uu_temp["pay"] . '</i> <strong>' . $units . '</strong></div>';
*/
        //узнаем сколько материала необходимо еще
        $class_ada = "red_ada";
        if ($row_uu_temp["nado"] <= 0) {
            $neo = 0;
            $class_ada = "green_ada";
        } else
        {
            $neo = $row_uu_temp["nado"];
        }
        $echo .= '<div class="neo-supply-yes ' . $class_ada . '"><span class="eshe-span-boo">еще необходимо</span>';


        $echo .= '<span class="edit_panel11_mat more-panel-supply"><span data-tooltip="Подробнее" for="' . $row__2["id_stock"] . '" class="history_icon">M</span>';

        $echo .= '<div class="history_act_mat history-prime-mat">
                                             <div class="line_brock"><div class="count_brock"><span>Состояние</span></div><div class="count_brock"><span>Кол-во</span></div></div>';



                 $echo .= '<div class="line_brock"><div class="count_brock">На складе</div><div class="count_brock">' . rtrim(rtrim(number_format($row_uu_temp["stock"], 3, '.', ' '),'0'),'.') . '<b>' . $units . '</b></div></div>';

        $echo .= '<div class="line_brock"><div class="count_brock">в заявках</div><div class="count_brock">' . rtrim(rtrim(number_format($row_uu_temp["app"], 3, '.', ' '),'0'),'.') . '<b>' . $units . '</b></div></div>';

        $echo .= '<div class="line_brock"><div class="count_brock">в работе</div><div class="count_brock">' . rtrim(rtrim(number_format($row_uu_temp["works"], 3, '.', ' '),'0'),'.') . '<b>' . $units . '</b></div></div>';

        $echo .= '<div class="line_brock"><div class="count_brock">на согласовании со счетом</div><div class="count_brock">' . rtrim(rtrim(number_format($row_uu_temp["acc_sign"], 3, '.', ' '),'0'),'.') . '<b>' . $units . '</b></div></div>';

        $echo .= '<div class="line_brock"><div class="count_brock">согласовано со счетом</div><div class="count_brock">' . rtrim(rtrim(number_format($row_uu_temp["acc_sign_yes"], 3, '.', ' '),'0'),'.') . '<b>' . $units . '</b></div></div>';

        $echo .= '<div class="line_brock"><div class="count_brock">оплачено</div><div class="count_brock">' . rtrim(rtrim(number_format($row_uu_temp["pay"], 3, '.', ' '),'0'),'.') . '<b>' . $units . '</b></div></div>';



        $echo .= '</div>';
        $echo .= '</span>';



        $echo .= '<strong class="eshe-unit-boo">' . $units . '</strong><i class="eshe-count-boo">' . $neo . '</i> </div>';

        /*
//узнаем сколько материала на складе
        $result_t1_ = mysql_time_query($link, 'SELECT b.units,(SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_stock=b.id and a.alien=0) as summ FROM z_stock as b WHERE b.id="' . htmlspecialchars(trim($row__2["id_stock"])) . '"');
        $z_stock_count_users = 0;
        $num_results_t1_ = $result_t1_->num_rows;
        if ($num_results_t1_ != 0) {
            //такая работа есть
            $row1ss_ = mysqli_fetch_assoc($result_t1_);
            if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                $z_stock_count_users = $row1ss_["summ"];
            }
            $units = $row1ss_["units"];
            $echo .= '<div class="yoop_rt"><span>на складе</span><i>' . $z_stock_count_users . '</i> <strong>' . $row1ss_["units"] . '</strong></div>';
        }

//узнаем сколько материала в заявке




        $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a,i_material as b WHERE a.id_i_material=b.id and b.alien=0 and a.status=9 and  a.id_stock="' . htmlspecialchars(trim($row__2["id_stock"])) . '"');

        $z_zakaz = 0;
        $num_results_t1_ = $result_t1_->num_rows;
        if ($num_results_t1_ != 0) {
            //такая работа есть
            $row1ss_ = mysqli_fetch_assoc($result_t1_);
            if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                $z_zakaz = $row1ss_["summ"];
            }
            $echo .= '<div class="yoop_rt "><span>в заявках</span><i>' . $z_zakaz . '</i> <strong>' . $units . '</strong></div>';
        }
//узнаем сколько материала в работе
        $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.status=11 and  a.id_stock="' . htmlspecialchars(trim($row__2["id_stock"])) . '"');
        $z_rabota = 0;
        $num_results_t1_ = $result_t1_->num_rows;
        if ($num_results_t1_ != 0) {
            //такая работа есть
            $row1ss_ = mysqli_fetch_assoc($result_t1_);
            if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                $z_rabota = $row1ss_["summ"];
            }
            $echo .= '<div class="yoop_rt "><span>в работе</span><i>' . $z_rabota . '</i> <strong>' . $units . '</strong></div>';
        }

//узнаем сколько материала на согласовании со счетом	
        $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($row__2["id_stock"])) . '" AND a.id_acc=b.id AND b.status=2');

        $z_rabota1 = 0;
        $num_results_t1_ = $result_t1_->num_rows;
        if ($num_results_t1_ != 0) {
            //такая работа есть
            $row1ss_ = mysqli_fetch_assoc($result_t1_);
            if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                $z_rabota1 = $row1ss_["summ"];
            }
            $echo .= '<div class="yoop_rt "><span>на согласовании со счетом</span><i>' . round($z_rabota1, 2) . '</i> <strong>' . $units . '</strong></div>';
        }

//узнаем сколько материала согласовано со счетом		
        $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($row__2["id_stock"])) . '" AND a.id_acc=b.id AND b.status=3');

        $z_rabota2 = 0;
        $num_results_t1_ = $result_t1_->num_rows;
        if ($num_results_t1_ != 0) {
            //такая работа есть
            $row1ss_ = mysqli_fetch_assoc($result_t1_);
            if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                $z_rabota2 = $row1ss_["summ"];
            }
            $echo .= '<div class="yoop_rt"><span>согласовано со счетом</span><i>' . round($z_rabota2, 2) . '</i> <strong>' . $units . '</strong></div>';
        }
//узнаем сколько материала оплачено	
        $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($row__2["id_stock"])) . '" AND a.id_acc=b.id AND b.status=4');
        $z_rabota3 = 0;
        $num_results_t1_ = $result_t1_->num_rows;
        if ($num_results_t1_ != 0) {
            //такая работа есть
            $row1ss_ = mysqli_fetch_assoc($result_t1_);
            if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                $z_rabota3 = $row1ss_["summ"];
            }
            $echo .= '<div class="yoop_rt "><span>оплачено</span><i>' . round($z_rabota3, 2) . '</i> <strong>' . $units . '</strong></div>';
        }

//узнаем сколько материала получено по счету
        $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_material) AS summ FROM z_doc_material_acc AS a,z_acc AS b,z_doc_material AS c WHERE a.id_doc_material=c.id AND c.id_stock="' . htmlspecialchars(trim($row__2["id_stock"])) . '" AND a.id_acc=b.id AND b.status=7');
        $z_take = 0;
        $num_results_t1_ = $result_t1_->num_rows;
        if ($num_results_t1_ != 0) {
            //такая работа есть
            $row1ss_ = mysqli_fetch_assoc($result_t1_);
            if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                $z_take = $row1ss_["summ"];
            }
            //$echo.='<div class="yoop_rt "><span>оплачено</span><i>'.round($z_rabota3,2).'</i> <strong>'.$units.'</strong></div>';
        }

//узнаем сколько материала необходимо еще


        $result_t1_ = mysql_time_query($link, 'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a,i_material as b WHERE a.id_i_material=b.id and b.alien=0 and a.status NOT IN ("1","8","10","3","5","4") and  a.id_stock="' . htmlspecialchars(trim($row__2["id_stock"])) . '"');

        $z_zakaz = 0;
        $num_results_t1_ = $result_t1_->num_rows;
        if ($num_results_t1_ != 0) {
            //такая работа есть
            $row1ss_ = mysqli_fetch_assoc($result_t1_);
            if (($row1ss_["summ"] != '') and ($row1ss_["summ"] != 0)) {
                $z_zakaz = $row1ss_["summ"];
            }

            $neo = round(($z_zakaz - $z_rabota1 - $z_rabota2 - $z_rabota3 - $z_take), 2);
            $class_ada = "red_ada";
            if ($neo <= 0) {
                $neo = 0;
                $class_ada = "green_ada";
            }
            $echo .= '<div class="yoop_rt yoop_click ' . $class_ada . '"><span>еще необходимо</span><i>' . $neo . '</i> <strong>' . $units . '</strong></div>';
        }
*/

        echo($echo);
    }
    echo '</div>';
}
					 
echo'</td>';
						 
echo'<td  class="center_">';
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

	
echo'<tr supply_stock="'.$row__2["id_stock"].'" class="tr_dop_supply_line '.$sql_su4.'"><td colspan="8"></td></tr>';

/*
if($row__2["id_stock"]==0)
{
	$result_work_zz=mysql_time_query($link,'Select a.*,b.id as idd,b.id_user,b.id_object from z_doc_material as a,z_doc as b,i_material as c where a.id_i_material=c.id and c.alien='.$dava_var.' and a.id_i_material="'.$row__2["id_i_material"].'" and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_);

} else
{
*/
/*
	$result_work_zz=mysql_time_query($link,'Select a.*,b.id as idd,b.id_user,b.id_object,b.name as app_name,b.id as app_id from z_doc_material as a,z_doc as b,i_material as c where c.alien='.$dava_var.' and a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_);
*/

    $result_work_zz=mysql_time_query($link,'Select a.*,b.id as idd,b.id_user,b.id_object,b.name as app_name,b.id as app_id from z_doc_material as a,z_doc as b,i_material as c, edo_state AS edo where b.id_edo_run = edo.id_run AND edo.id_status = 0 AND edo.id_executor IN ('.$id_user.') and c.alien='.$dava_var.' and a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_);


//echo('<br>Select a.*,b.id as idd,b.id_user,b.id_object,b.name as app_name,b.id as app_id from z_doc_material as a,z_doc as b,i_material as c where c.alien='.$dava_var.' and a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_);

	//echo 'Select a.*,b.id as idd,b.id_user,b.id_object,b.name as app_name,b.id as app_id from z_doc_material as a,z_doc as b,i_material as c where c.alien=0 and a.id_i_material=c.id and a.id_doc=b.id and a.id_stock="'.$row__2["id_stock"].'"  and b.id_object in('.implode(',', $hie->obj ).') AND a.status NOT IN ("1","8","10","3","5","4") '.$sql_su2_.' '.$sql_su3_.' '.$sql_su1_;

//}
						 
					 
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
			   echo'<tr supply_id="'.$row_work_zz["id"].'" supply_stock="'.$row__2["id_stock"].'" class="tr_dop_supply '.$sql_su4.' '.$actvss.'"><td class="middle_ no_border_supply"></td>';

               echo'<td class="div-waves">';

               echo'<div class="supply-flex-21">
           <div class="st-flex-21">';
               if($dava_var==0) {
                   if ($row__2["id_stock"] != 0) {
                       echo '<div class="st_div_supply"><i class=""></i></div>';
                   } else {
                       echo '<div class="st_div_supply" style="display:none;"><i class=""></i></div>';
                   }
               }

echo'</div><div class="st-flex">';

               echo('<span class="js-normaliz-count">'.$row_work_zz['count_units'].'</span> '.$row_material['units']);

               if($dava_var==0) {

                   echo '<div class="waves_app js-waves-app" data-tooltip="нормализовать количество"></div>';

               }


               if($row_work_zz['commet']!='')
               {
                   echo'<div data-tooltip="Комментарий к заказу" class="commun1">('.$row_work_zz['commet'].')</div>';
               }


				   echo'</div></div>';
			  echo'</td>';


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

              // echo'<td colspan="2"><label>Заявка/Объект</label>';
               echo'<td colspan="2">';

               echo'<a data-tooltip="Заявка" href="app/'.$row_work_zz['app_id'].'/" class="app-soply">'.$row_work_zz['app_name'].'</a><span class="object-acc-xx2 " style="line-height: 16px !important;">';


               if($num_results_custom_url!=0)
               {
                   echo '('.$row_list1["object_name"].', '.$row_town["town"].', '.$row_town["kvartal"].')';
               } else
               {
                   echo 'Объект неизвестен';
               }
               echo'</span></td>';






               $style_red='';
               $d_day=dateDiff_1(date("Y-m-d").' '.date("H:i:s"),$row_work_zz['date_delivery'].' 00:00:00');

               if(($d_day>0))
               {
                   $style_red='red_proc_sroki';
               } else
               {
                   if((abs($d_day)==0)or(abs($d_day)==1)or(abs($d_day)==2))
                   {

                       $style_red='yellow_proc_sroki';

                   }
               }

			   
			   
			  echo'<td>
<div class="sroki-2020-xto">→ <span data-tooltip="дата поставки" class="'.$style_red.'">'.MaskDate_D_M_Y_ss($row_work_zz['date_delivery']).', '.day_nedeli_x_small($row_work_zz['date_delivery']).'</span></div>


</td>';

               echo'<td class=" menu_jjs scope_scope">';

               if($dava_var==0) {
                   //проверяем есть ли счета с этим материалом и их статусы
                   $result_score = mysql_time_query($link, 'Select a.date,a.date_paid,a.delivery_day,a.number,a.status,a.summa,a.id as id,(select count(g.id) from z_doc_material_acc as g where g.id_acc=a.id ) as countss,(select r.name_status from r_status as r where r.numer_status=a.status and r.id_system="16" ) as status_name from z_acc as a,z_doc_material_acc as b where b.id_acc=a.id and b.id_doc_material="' . $row_work_zz["id"] . '"');


                   $num_results_score = $result_score->num_rows;
                   if ($num_results_score != 0) {
                       $status_score = array("1", "2", "3", "5", "4");
                       //$status_score_class = array("", "score_app","score_pay","score_no","score_paid");
                       $status_score_class = array("", "", "", "", "");
                       for ($ss = 0; $ss < $num_results_score; $ss++) {
                           $row_score = mysqli_fetch_assoc($result_score);
                           $tec = '';

                           $too = '';
                           if ($row_score["status"] == 2) {
                               $nhh = 1;
                           }


                           if ($row_score["status"] != 1) {
                               $too = "data-tooltip=\"счет №" . $row_score["number"] . "- " . $row_score["status_name"] . "\"";
                           } else {
                               $too = "data-tooltip=\"счет №" . $row_score["number"] . "\"";
                           }

                           //$PROC=round($row_gog3["koll"]/$row_gog2["co"]);

                           //#4bcaff
                           if (($row_score["status"] == 4) or ($row_score["status"] == 20)) {

                               //узнаем сколько по этому договору уже привезли товара
                               $PROC = 0;

                               $result_proc = mysql_time_query($link, 'select sum(a.subtotal) as summ,sum(a.subtotal_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="' . $row_score["id"] . '"');

                               $num_results_proc = $result_proc->num_rows;
                               if ($num_results_proc != 0) {
                                   $row_proc = mysqli_fetch_assoc($result_proc);
                                   $PROC = round((($row_proc["summ"] - $row_proc["summ1"]) * 100) / $row_score["summa"]);
                               }


                               //подсвечиваем красным если конечная дата доставки завтра а товар привезли не весь или вообще не привезли
                               if (($row_score["status"] == 4)) {
                                   //подсвечиваем красным за 1 день до доставки
                                   $date_delivery1 = date_step($row_score["date_paid"], ($row_score["delivery_day"] - 1));
                                   //echo($date_delivery1);

                                   $style_book = '';
                                   if ((dateDiff_1(date("y-m-d") . ' ' . date("H:i:s"), $date_delivery1 . ' 00:00:00') >= 0) and ($PROC < 100)) {
                                       $style_book = 'reddecision1';
                                   }

                                   $date_delivery = date_step($row_score["date_paid"], $row_score["delivery_day"]);
                                   $date_graf2 = explode("-", $date_delivery);
                               } else {
                                   //подсвечиваем красным за 1 день до доставки
                                   $date_delivery1 = date_step($row_score["date"], ($row_score["delivery_day"] - 1));
                                   //echo($date_delivery1);

                                   $style_book = '';
                                   if ((dateDiff_1(date("y-m-d") . ' ' . date("H:i:s"), $date_delivery1 . ' 00:00:00') >= 0) and ($PROC < 100)) {
                                       $style_book = 'reddecision1';
                                   }

                                   $date_delivery = date_step($row_score["date"], $row_score["delivery_day"]);
                                   $date_graf2 = explode("-", $date_delivery);
                               }


                               echo '<div rel_score="' . $row_score["id"] . '" class="menu_click score_a1 score_a score_a_2021 ' . $tec . '"><span>№' . $row_score["number"] . '</span><span class="date_proc ' . $style_book . '">(до ' . $date_graf2[2] . '.' . $date_graf2[1] . '.' . $date_graf2[0] . ')</span><div data-tooltip="Получено ' . $PROC . '%" class="circlestat" data-dimension="20" data-text="~' . $PROC . '%" data-width="1" data-fontsize="12" data-percent="' . $PROC . '" data-fgcolor="#24c32d" data-bgcolor="rgba(0,0,0,0.1)" data-fill="rgba(0,0,0,0)"></div><form class="none" target = "_blank"  action="acc/' . $row_score["id"] . '/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="a" value="open" type="hidden">
</form></div>';


                           } else {
                               echo '<div rel_score="' . $row_score["id"] . '" ' . $too . ' class="menu_click score_a ' . $status_score_class[array_search($row_score["status"], $status_score)] . ' ' . $tec . '"><span>№' . $row_score["number"] . ' (' . date_ex(0, $row_score["date"]) . ')</span><strong><label>' . rtrim(rtrim(number_format($row_score["summa"], 2, '.', ' '), '0'), '.') . '</label></strong><i>' . $row_score["countss"] . '</i>';

                               if (($row_score["status"] != 1)) {
                                   $js_mod = '';
//статус обращения

                                   $color_status = 1;
                                   //на согласовании
                                   if ($row_score["status"] == 2) {
                                       $color_status = 2;
                                   }
                                   //к оплате
                                   if ($row_score["status"] == 3) {
                                       $color_status = 3;
                                   }
                                   //оплачено
                                   if ($row_score["status"] == 4) {
                                       $color_status = 5;
                                   }
                                   //отказано
                                   if (($row_score["status"] == 8) or ($row_score["status"] == 5)) {
                                       $color_status = 4;
                                   }

//выводим статус заявки
                                   $result_status = mysql_time_query($link, 'SELECT a.* FROM r_status AS a WHERE a.numer_status="' . $row_score["status"] . '" and a.id_system=16');
//echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
                                   if ($result_status->num_rows != 0) {
                                       $row_status = mysqli_fetch_assoc($result_status);


                                       echo '<div class="js-state-acc-link"><div id_status="' . $row_score["status"] . '" class="status_admin js-status-preorders s_pr_' . $color_status . ' ' . $js_mod . '">' . $row_status["name_status"] . '</div></div>';
                                   }
                               }

                               echo '<form class="none" target = "_blank"  action="acc/' . $row_score["id"] . '/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data"><input name="a" value="open" type="hidden"></form></div>';


                           }


                           $menu = array("Открыть", "Сделать текущим", "Согласовать", "Удалить");
                           $menu_id = array("1", "2", "3", "4");
                           $menu_id_visible = array("1", "1", "1", "1");
                           if (($row_score["status"] != 1) and ($row_score["status"] != 8)) {
                               $menu_id_visible = array("1", "0", "0", "0");
                           }


                           echo '<div class="menu_supply menu_su122"><ul class="drops no_active" data_src="0" style="left:-50px; top:5px;">';
                           for ($it = 0; $it < count($menu); $it++) {
                               if ($menu_id_visible[$it] == 1) {
                                   echo '<li><a href="javascript:void(0);"  rel="' . $menu_id[$it] . '">' . $menu[$it] . '</a></li>';
                               }


                           }
                           echo '</ul><input rel="x" type="hidden" name="vall" class="option_score1" value="0"></div>';
                       }
                   }
               }

               echo'</td>';


			  /*
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
		*/
	  echo'<td class="menu_jjs statusis">';
//вывод статуса по материалу
$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row_work_zz["status"].'" and a.id_system=13');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	
	$live='';
	$menu_id = array("9","20", "11");
	if(array_search($row_work_zz["status"],$menu_id)!==false)
	{
		$live='live_menu';
	}
	if($row_work_zz["status"]==9)
	{
       echo'<div rel_status="'.$row_work_zz["id"].'" class="st_bb menu_click status_materialz status_z0 '.$live.'">не обработана</div>';
	} else
	{
		echo'<div rel_status="'.$row_work_zz["id"].'" class="st_bb menu_click status_materialz status_z'.$row_work_zz["status"].' '.$live.'">'.$row_status["name_status"].'</div>';
	}
	
	
	$menu = array("Не обработана", "Заказано", "В работе");
		
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
					  
					 //echo'<div class="no_sql">С такими параметрами ничего не найдено</div>';

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
     count_task();
 });
</script>

<?
if((isset($_GET["step"]))and($_GET["step"]=='add'))
{
if(isset($_GET["id"])) {

    $podpis=0;  //по умолчанию нельзя редактировать статус заказано


    $result_url=mysql_time_query($link,'select A.id from z_acc as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'" and A.id_user="'.$id_user.'" and ((A.status=1) or (A.status=8))');
    $num_results_custom_url = $result_url->num_rows;
    if($num_results_custom_url!=0)
    {
        $podpis=1;
    }
if($podpis==1) {

    echo '<script type = "text/javascript" >
        $(function () {
            tek_acc(' . ht($_GET["id"]) . ');
        });
</script>';
}
}
}
$echo_help=0;
if (( isset($_GET["step"])))
{

    $echo_help++;
}

if($echo_help!=0)
{
    ?>
    <script type="text/javascript">

        <?
        //echo'var text_xx=\''.$end_step_task.'\';';
        ?>
        $(function (){
            setTimeout ( function () {

                $('.js-hide-help').slideUp("slow");
                <?
                if (( isset($_GET["a"]))and($_GET["a"]=='order')) {
                    //echo "alert_message('ok', 'отправлено на согласование');";
                } else
                {
                    //echo "alert_message('ok', text_xx);";
                }
                ?>
                var title_url=$(document).attr('title'); var url=window.location.href;
                /* url=url.replace('add/', '');
                 url=url.replace('order/', '');*/
                var url1 = removeParam("id", url);
                var url1 = removeParam("step", url1);
                History.pushState('', title_url, url1);

            }, 1000 );
        });
    </script>
    <?
}

?>




</body></html>
<?php
 $result_url=mysql_time_query($link,'DROP TEMPORARY TABLE supply_temp');
?>