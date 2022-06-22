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

include_once $url_system.'module/kvartal_select.php';

$sign_level=$hie->sign_level;
$sign_admin=$hie->admin;


$role->GetColumns();
$role->GetRows();
$role->GetPermission();
//правам к просмотру к действиям


$active_menu='worder';  // в каком меню



$count_write=20;  //количество выводимых записей на одной странице

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

			if (($role->permission('Наряды','R'))or($sign_admin==1)or($role->permission('Наряды','S')))
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
         $result_url=mysql_time_query($link,'select a.id from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user="'.$id_user.'"'.limitPage('n_st',$count_write));
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} 
 } else
 {

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

$menu_no_my=0;
$subor_cc = array();
//если у него нет своих заявок то выводить только задания и выполненные
include_once '../ilib/lib_interstroi.php';
include_once '../ilib/lib_edo.php';

$edo = new EDO($link,$id_user,false);
$arr_document = $edo->my_documents(2, 0 );
// echo count($arr_document) ;
//array_push($subor_cc,count($arr_document));

    if (count($arr_document) == 0) {
        if(!isset($_GET["tabs"])) {
            header("Location:" . $base_usr . "/worder/.tabs-1");
        }
        array_push($subor_cc,0);
    } else
    {
        $menu_no_my = count($arr_document);
        array_push($subor_cc,count($arr_document));
    }

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы

include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('worder','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_prime_worder.php';
echo'<div id="fullpage" class="margin_60  input-block-2022 ">
    <div class="oka_block_2019" style="min-height:auto;">';

    ?>



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
              if (( isset($_COOKIE["su_2w_".$id_user]))and(is_numeric($_COOKIE["su_2w_".$id_user]))and(array_search($_COOKIE["su_2w_".$id_user],$os_id2)!==false))
              {
                  $su_2=$_COOKIE["su_2w_".$id_user];
              }
              $val_su2=$os2[$su_2];


              if ( isset($_COOKIE["suddbcw".$id_user]))
              {
                  //$date_base__=explode(".",$_COOKIE["suddw"]);
                  if (( isset($_COOKIE["su_2w_".$id_user]))and(is_numeric($_COOKIE["su_2w_".$id_user]))and($_COOKIE["su_2w_".$id_user]==2))
                  {
                      $date_su=$_COOKIE["suddbc_morw".$id_user];
                      $val_su2=$_COOKIE["suddbc_morw".$id_user];
                  }
              }

             // echo($_COOKIE["suddbcw".$id_user]); 2022-05-05/2022-06-15

              echo'<input id="date_hidden_table" name="date" value="'.$date_su.'" type="hidden"><input id="date_hidden_start" name="start_date" type="hidden"><input id="date_hidden_end" name="end_date" type="hidden">';
              echo'<div class="left_drop menu1_prime book_menu_sel js--sort js-call-no-v gop_io"><label>Промежуток создания</label><div class="select eddd"><a class="slct" list_number="t2" data_src="'.$os_id2[$su_2].'">'.$val_su2.'</a><ul class="drop">';
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
              echo'</ul><input type="hidden" name="sort2w" id="sort2w_x" value="'.$os2[$su_2].'"></div></div>';



              $os4 = array();
              $os_id4 = array();

              $result_t=mysql_time_query($link,'Select a.id,a.town from i_town as a order by a.id');
              $num_results_t = $result_t->num_rows;
              if($num_results_t!=0) {
                  for ($i = 0; $i < $num_results_t; $i++) {
                      $row_t = mysqli_fetch_assoc($result_t);
                      if ((array_search($row_t["id"], $hie_town) !== false) or ($sign_admin == 1)) {

                          array_push($os4, $row_t['town']);
                          array_push($os_id4, $row_t['id']);

                      }
                  }
              }



              $su_4 = array();
              if (isset($_COOKIE["acc_x" . $id_user])) {
                  $su_4 = explode(",", $_COOKIE["acc_x" . $id_user]);
              } else {
                  $su_4 = $os_id4;
              }


              $select_val_name = '';
              for ($i = 0; $i < count($su_4); $i++) {
                  if ($select_val_name == '') {
                      $select_val_name = $os4[array_search($su_4[$i], $os_id4)];
                  } else {
                      $select_val_name .= ', ' . $os4[array_search($su_4[$i], $os_id4)];
                  }
              }

              echo '<div class="left_drop menu1_prime book_menu_sel js--sort gop_io js-zindex js-city' . $class_js_search . '" ><label>Город</label><div class="select eddd"><a class="slct" list_number="t5" data_src="' . implode(",", $su_4) . '">' . $select_val_name . '</a><ul class="drop-radio js-no-nul-select">';
              $zindex--;

              for ($i = 0; $i < count($os4); $i++) {
                  if ((in_array($os_id4[$i], $su_4)) or ($_COOKIE["acc_x" . $id_user] == '')) {
                      echo '<li>
				   <div class="choice-radio"><div class="center_vert1"><i class="active_task_cb"></i></div></div>
				   
				   <a href="javascript:void(0);"  rel="' . $os_id4[$i] . '">' . $os4[$i] . '</a></li>';
                  } else {
                      echo '<li> <div class="choice-radio"><div class="center_vert1"><i></i></div></div><a href="javascript:void(0);"  rel="' . $os_id4[$i] . '">' . $os4[$i] . '</a></li>';
                  }

              }
              echo '</ul><input type="hidden" ' . $class_js_readonly . ' name="sort3pr" id="acc_x" value="' . implode(",", $su_4) . '"></div></div>';

              $su_mass=implode("','", $su_4);
              $su_mass_p=$su_4;









              $os4 = array();
              $os_id4 = array();

              $result_t=mysql_time_query($link,'Select a.id,a.kvartal from i_kvartal as a where a.id_town in(\''.$su_mass.'\') order by a.id');



              $num_results_t = $result_t->num_rows;
              if($num_results_t!=0) {
                  for ($i = 0; $i < $num_results_t; $i++) {
                      $row_t = mysqli_fetch_assoc($result_t);
                      if ((array_search($row_t["id"], $hie_kvartal) !== false) or ($sign_admin == 1)) {

                          array_push($os4, $row_t['kvartal']);
                          array_push($os_id4, $row_t['id']);

                      }
                  }
              }



              $su_4 = array();
              if (isset($_COOKIE["acc_y" . $id_user])) {
                  $su_4 = explode(",", $_COOKIE["acc_y" . $id_user]);
              } else {
                  $su_4 = $os_id4;
              }


              $select_val_name = '';
              for ($i = 0; $i < count($su_4); $i++) {
                  if ($select_val_name == '') {
                      $select_val_name = $os4[array_search($su_4[$i], $os_id4)];
                  } else {
                      $select_val_name .= ', ' . $os4[array_search($su_4[$i], $os_id4)];
                  }
              }

              echo '<div class="left_drop menu1_prime book_menu_sel js--sort gop_io js-zindex js-kvartal' . $class_js_search . '" ><label>Квартал</label><div class="select eddd"><a class="slct" list_number="t6" data_src="' . implode(",", $su_4) . '">' . $select_val_name . '</a><ul class="drop-radio js-no-nul-select">';
              $zindex--;

              for ($i = 0; $i < count($os4); $i++) {
                  if ((in_array($os_id4[$i], $su_4)) or ($_COOKIE["acc_8" . $id_user] == '')) {
                      echo '<li>
				   <div class="choice-radio"><div class="center_vert1"><i class="active_task_cb"></i></div></div>
				   
				   <a href="javascript:void(0);"  rel="' . $os_id4[$i] . '">' . $os4[$i] . '</a></li>';
                  } else {
                      echo '<li> <div class="choice-radio"><div class="center_vert1"><i></i></div></div><a href="javascript:void(0);"  rel="' . $os_id4[$i] . '">' . $os4[$i] . '</a></li>';
                  }

              }
              echo '</ul><input type="hidden" ' . $class_js_readonly . ' name="sort3pr" id="acc_y" value="' . implode(",", $su_4) . '"></div></div>';

              $su_mass1=implode("','", $su_4);
              $su_mass_p1=$su_4;


              $os4 = array();
              $os_id4 = array();

              $result_t=mysql_time_query($link,'Select a.id,a.object_name from i_object as a where a.id_kvartal in(\''.$su_mass1.'\') order by a.id');



              $num_results_t = $result_t->num_rows;
              if($num_results_t!=0) {
                  for ($i = 0; $i < $num_results_t; $i++) {
                      $row_t = mysqli_fetch_assoc($result_t);
                      if ((array_search($row_t["id"], $hie_object) !== false) or ($sign_admin == 1)) {

                          array_push($os4, $row_t['object_name']);
                          array_push($os_id4, $row_t['id']);

                      }
                  }
              }



              $su_4 = array();
              if (isset($_COOKIE["acc_p" . $id_user])) {
                  $su_4 = explode(",", $_COOKIE["acc_p" . $id_user]);
              } else {
                  $su_4 = $os_id4;
              }


              $select_val_name = '';
              for ($i = 0; $i < count($su_4); $i++) {
                  if ($select_val_name == '') {
                      $select_val_name = $os4[array_search($su_4[$i], $os_id4)];
                  } else {
                      $select_val_name .= ', ' . $os4[array_search($su_4[$i], $os_id4)];
                  }
              }

              echo '<div class="left_drop menu1_prime book_menu_sel js--sort gop_io js-zindex js-object-c' . $class_js_search . '" ><label>Объект</label><div class="select eddd"><a class="slct" list_number="t7" data_src="' . implode(",", $su_4) . '">' . $select_val_name . '</a><ul class="drop-radio js-no-nul-select">';
              $zindex--;

              for ($i = 0; $i < count($os4); $i++) {
                  if ((in_array($os_id4[$i], $su_4)) or ($_COOKIE["acc_p" . $id_user] == '')) {
                      echo '<li>
				   <div class="choice-radio"><div class="center_vert1"><i class="active_task_cb"></i></div></div>
				   
				   <a href="javascript:void(0);"  rel="' . $os_id4[$i] . '">' . $os4[$i] . '</a></li>';
                  } else {
                      echo '<li> <div class="choice-radio"><div class="center_vert1"><i></i></div></div><a href="javascript:void(0);"  rel="' . $os_id4[$i] . '">' . $os4[$i] . '</a></li>';
                  }

              }
              echo '</ul><input type="hidden" ' . $class_js_readonly . ' name="sort3pr" id="acc_p" value="' . implode(",", $su_4) . '"></div></div>';

              $su_mass2=implode("','", $su_4);
              $su_mass_p2=$su_4;

              $su_5_name='Любой';
              $su_5=0;
              if (( isset($_COOKIE["acc_4w".$id_user]))and(is_numeric($_COOKIE["acc_4w".$id_user])))
              {
                  $result_uu = mysql_time_query($link, 'select id,name_user from r_user where id="' . ht($_COOKIE["acc_4w".$id_user]) . '"');
                  $num_results_uu = $result_uu->num_rows;

                  if ($num_results_uu != 0) {
                      $row_uu = mysqli_fetch_assoc($result_uu);
                      $su_5=$_COOKIE["acc_4w".$id_user];
                      $su_5_name=$row_uu["name_user"];
                  }
              }


              echo'<!--input start	-->';

              echo'<div class="left_drop menu1_prime book_menu_sel js--sort gop_io js-zindex input-search-2021 '.$class_js_search.'">';
              //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';



              echo'<div class="input_2020 input_2021 input_2018 input-search-list js--sort" list_number="s222"><i class="js-open-search"></i><div class="b_loading_small"></div><label>Создатель</label><input name="kto" value="'.$su_5_name.'" id="date_124" sopen="search_user" oneli="Любой" class="input_new_2020 input_new_2018 required js-keyup-search width-auto " style="padding-right: 25px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search" name="id_kto" id="sort4w_x"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';

              $query_ob='';

              //если это служба безопасности или админ видит всех

              $result_work_zz=mysql_time_query($link,'Select a.id,a.name_user from r_user as a  ORDER BY a.name_user DESC limit 0,20');

              $num_results_work_zz = $result_work_zz->num_rows;
              if($num_results_work_zz!=0)
              {
                  echo'<li><a href="javascript:void(0);" rel="0">Любой</a></li>';
                  for ($i=0; $i<$num_results_work_zz; $i++)
                  {
                      $row_work_zz = mysqli_fetch_assoc($result_work_zz);
                      echo'<li><a href="javascript:void(0);" rel="'.$row_work_zz["id"].'">'.$row_work_zz["name_user"].' <span class="gray-date">('.$row_work_zz["id"].')</span></a></li>';
                  }
              }

              echo'</ul><div class="div_new_2018"><div class="oper_name"></div></div></div></div><!--input end	-->';


/*
              echo'<div class="left_drop menu1_prime book_menu_sel gop_io"><label>Статья (1.1)</label><div class="select eddd">
		   
		   <input name="sort_stock2" id="name_stock_searchw" class="name_stock_search_inputw" autocomplete="off" value="'.$_COOKIE["su_st_2w"].'" type="text">';
              if (( isset($_COOKIE["su_st_2w"]))and($_COOKIE["su_st_2w"]!=''))
              {
                  echo'<div style="display:block;" class="dell_stock_search" data-tooltip="Удалить"><span>x</span></div>';
              } else
              {
                  echo'<div  class="dell_stock_search" data-tooltip="Удалить"><span>x</span></div>';
              }
              echo'</div></div>';
*/


              if(isset($_GET["tabs"]))
              {
                  echo'<div class="inline_reload js-reload-top"><a href="worder/.tabs-'.$_GET["tabs"].'" class="show_reload">Поиск</a></div>';
              } else
              {
                  echo'<div class="inline_reload js-reload-top"><a href="worder/" class="show_reload">Поиск</a></div>';
              }

              echo'<span style="display: none;" class="search-count-2022"></span>';

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

                              $.cookie("suddbc_morw"+iu, null, {path:'/',domain: window.is_session,secure: false});
                              CookieList("suddbc_morw"+iu,jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.startDate) + ' - ' + jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.endDate),'add');


                              $('#date_hidden_start').val(jQuery.datepicker.formatDate('yy-mm-dd',extensionRange.startDate));
                              $('#date_hidden_end').val(jQuery.datepicker.formatDate('yy-mm-dd',extensionRange.endDate));

                              $('[list_number=t2]').empty().append(jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.startDate) + ' - ' + jQuery.datepicker.formatDate('d MM yy'+' г.',extensionRange.endDate));
                              $.cookie("suddbcw"+iu, null, {path:'/',domain: window.is_session,secure: false});
                              CookieList("suddbcw"+iu,$('#date_hidden_start').val()+'/'+$('#date_hidden_end').val(),'add');

                              $('.js-reload-top').removeClass('active-r');
                              $('.js-reload-top').addClass('active-r');
                              $('.search-count-2022').hide();
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
                              if((isset($_COOKIE["su_2w"]))and(is_numeric($_COOKIE["su_2w"]))and($_COOKIE["su_2w"]==2))
                              {
                                  $date_range=explode("/",$_COOKIE["suddbcw".$id_user]);
                                  echo'var st=\''.ipost_($date_range[0],'').'\';
var st1=\''.ipost_($date_range[1],'').'\';
var st2=\''.ipost_($_COOKIE["suddbc_morw".$id_user],'').'\';';
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






  <?
 echo'<div class="oka_block">
<div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">';
/*
echo'<span class="h3-f">Ваши заявки</span>';

echo'<span class="h3-f">Документы <span class="pol-card" >(Необходимо выполнить)</span></span>';

echo'<span class="h3-f">Документы <span class="pol-card" >(Выполненные вами)</span></span>';
*/
    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?


  /*
//переменные для поиска сверхуaff

$_COOKIE["su_st_2w"] - статья [текст типо 1.2]
$_COOKIE["acc_4w".$id_user] - создатель [id одно]
$_COOKIE["acc_9" . $id_user] - объект [id,id,id]
$_COOKIE["acc_8" . $id_user] - квартал [id,id,id]
$_COOKIE["acc_7" . $id_user] - город [id,id,id]
$_COOKIE["su_2w"]=0 любой промежуток создания
$_COOKIE["su_2w"]=2 определенный промежуток создания $_COOKIE["suddbcw".$id_user] - период  [2022-05-05/2022-06-15]

*/

  if((isset($_COOKIE["su_2w_".$id_user]))and($_COOKIE["su_2w_".$id_user]==2))
  {
     // echo($_COOKIE["suddbcw".$id_user]);
      $edo->task_date($_COOKIE["suddbcw".$id_user]);
  }
  //print_r($su_mass_p2);
  if(count($su_mass_p)!=0)
  {
      $edo->task_town($su_mass_p);
  }
  if(count($su_mass_p1)!=0)
  {
      $edo->task_kvartal($su_mass_p1);
  }
  //print_r($su_mass_p2);

  if(count($su_mass_p2)!=0)
  {
      $edo->task_object($su_mass_p2);
  }

//echo($_COOKIE["suddbcw".$id_user]);

  if($su_5!=0) $edo->task_owner(0+$su_5);   //Фильтр на создателя

     /* if($ids_town!='') $edo->task_town(explode(',',$ids_town));
      if($ids_kvartal!='') $edo->task_kvartal(explode(',',$ids_kvartal));
      if($ids_object!='') $edo->task_object(explode(',',$ids_object));
*/

  $sql_mass = array();
$sql_mass=$arr_document;
  //необходимо выполнить
  if((isset($_GET["tabs"]))and($_GET["tabs"]==1))
  {
      $arr_tasks = $edo->my_tasks(2, '=0','ORDER BY d.date_create DESC',limitPage('n_st',$count_write) );
      $sql_mass=$arr_tasks;
  }

  //уже как то выполнено
  if((isset($_GET["tabs"]))and($_GET["tabs"]==2))
  {
      $arr_tasks = $edo->my_tasks(2, '<>0','ORDER BY d.date_create DESC',limitPage('n_st',$count_write));
      $sql_mass=$arr_tasks;
  }

  if(!isset($_GET["tabs"]))
  {
      $arr_document = $edo->my_documents(2, 0 ,false, limitPage('n_st',$count_write));
      $sql_mass=$arr_document;
  }

  //echo '<pre>arr_document:'.print_r($sql_mass,true) .'</pre>';

  //echo($sql_mass[0]["total_count"]);
  $count_page_a=0;
  if(isset($sql_mass[0]["total_count"]))
  {
      $count_page_a=$sql_mass[0]["total_count"];
  }

  echo'';

  echo '<div class="ring_block ring-block-line js-global-preorders-link">';
  $small_block=1;
  foreach ($sql_mass as $key => $value)
  {
      $new_pre = 1;
      $task_cloud_block='';



      include $url_system . 'worder/code/block_worder.php';
      echo($task_cloud_block);

  }
  if(count($sql_mass)==0)
  {
      echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Нарядов в данном разделе пока нет.</span></span></div>';
  }

  $count_pages=ceil($count_page_a/$count_write);

  if($count_pages>1)
  {
      if(isset($_GET["tabs"]))
      {
          displayPageLink_new('worder/.tabs-'.$_GET["tabs"].'','worder/.tabs-'.$_GET["tabs"].'.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
      } else
      {
          displayPageLink_new('worder/','worder/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
      }
  }

  echo'</div>';





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


<script type="text/javascript">
    $(function () {
        $('.search-count-2022').empty().append(<? echo($count_page_a) ?>+' '+PadejNumber(<? echo($count_page_a) ?>,'найденный наряд,найденных наряда,найденных нарядов'));
        $('.search-count-2022').show();
    });
    </script>