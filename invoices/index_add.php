<?
session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; include_once $url_system.'module/config.php'; include_once $url_system.'module/function.php'; include_once $url_system.'login/function_users.php'; initiate($link); include_once $url_system.'module/access.php';



$active_menu='invoices';  // в каком меню


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



if((isset($_POST['save_invoice']))and($_POST['save_invoice']==1))
{
	$token=htmlspecialchars($_POST['tk']);
	$id=htmlspecialchars($_GET['id']);
	
	//токен доступен в течении 120 минут
    $stack_error = array();  // общий массив ошибок
    $error_count=0;  //0 - ошибок для сохранения нет
        if(token_access_new($token,'add_invoicess_x',$id,"rema",120))



    {
		//echo("!");
	//возможно проверка что этот пользователь это может делать
	 if (($role->permission('Накладные','R'))or($sign_admin==1))
	 {	
	
	$stack_memorandum = array();  // общий массив ошибок

	$flag_podpis=0;  //0 - все заполнено можно подписывать

	//print_r($stack_error);

         //исполнитель

         if($_POST["new_contractor_"]==0) {
             if (($_POST['id_kto'] == 0) or ($_POST['id_kto'] == '')) {
                 array_push($stack_error, "id_kto");
                 $error_count++;
                 $flag_podpis++;
             }
         } else
         {
             //проверка что все заполнено при добавление нового поставщика!
         }



	//дата документ
	if($_POST['datess']=='')
	{
		array_push($stack_error, "datess");
		$error_count++;
		$flag_podpis++;
	}	

	if($_POST['number_invoices']=='')
	{
		array_push($stack_error, "number_invoices");
		$error_count++;
		$flag_podpis++;
	}			
		
	    if((count($stack_error)==0)and($error_count==0))
		{
		   //ошибок нет
		   //сохраняем накладную
		   
		   $today[0] = date("y.m.d"); //присвоено 03.12.01
           $today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17



           if($_POST["new_contractor_"]==1)
           {
               //добавляем нового поставщика

 mysql_time_query($link,'INSERT INTO z_contractor (name,name_small,adress,inn,ogrn,status,dir) VALUES ("'.htmlspecialchars(trim($_POST['name_contractor'])).'","'.htmlspecialchars(trim($_POST['name_small_contractor'])).'","'.htmlspecialchars(trim($_POST['address_contractor'])).'","'.htmlspecialchars(trim($_POST['inn_contractor'])).'","'.htmlspecialchars(trim($_POST['ogrn_contractor'])).'","'.htmlspecialchars(trim($_POST['status_contractor'])).'","'.htmlspecialchars(trim($_POST['dir_contractor'])).'")');

               $kto=mysqli_insert_id($link);

           } else
           {

               $kto=$_POST["id_kto"];

           }


            if(isset($_GET["id"])) {

                mysql_time_query($link, 'INSERT INTO z_invoice (number,date,date_last,date_create,summa,id_contractor,id_user,status,type_contractor) VALUES ("' . htmlspecialchars($_POST['number_invoices']) . '","' . htmlspecialchars($_POST['date_invoice']) . '","' . date("y-m-d") . ' ' . date("H:i:s") . '","' . date("y-m-d") . ' ' . date("H:i:s") . '","0","' . htmlspecialchars(trim($kto)) . '","' . $id_user . '","1","1")');
            } else
            {
                mysql_time_query($link, 'INSERT INTO z_invoice (number,date,date_last,date_create,summa,id_contractor,id_user,status) VALUES ("' . htmlspecialchars($_POST['number_invoices']) . '","' . htmlspecialchars($_POST['date_invoice']) . '","' . date("y-m-d") . ' ' . date("H:i:s") . '","' . date("y-m-d") . ' ' . date("H:i:s") . '","0","' . htmlspecialchars(trim($kto)) . '","' . $id_user . '","1")');
            }


			$ID_N=mysqli_insert_id($link); 
			
			//переадрессуем для дальнейшего сохранения


			  if(isset($_GET["id"]))
              {
                  header("Location:".$base_usr."/invoices/".$ID_N.'/'.$_GET["id"].'/');
                  die();
              } else
              {
                  header("Location:".$base_usr."/invoices/".$ID_N.'/');
                  die();
              }

		}

	

}

} else
        {
            array_push($stack_error, "token");
            $error_count++;
        }
	
	
}


/*
$secret=rand_string_string(4);
$_SESSION['s_t'] = $secret;	
*/




//проверить и перейти к последней себестоимости в которой был пользователь

$b_co='basket_'.$id_user;

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /invoices/add/
//    0    1      2  

$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

if (strripos($url_404, 'index_add.php') !== false) {
   header404(1,$echo_r);	
}

//**************************************************
if (( count($_GET) != 0 )and( count($_GET) != 1 ) )
{
   header404(2,$echo_r);		
}

if((!$role->permission('Накладные','R'))and($sign_admin!=1))
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

if($error_header!=404){ SEO('invoices_add','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_invoices_add.php';

	?>
      <div id="fullpage" class="margin_60  input-block-2020 ">
          <div class="section" id="section0">
              <div class="height_100vh">
                  <div class="oka_block_2019">
                      <div class="div_ook" style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                          <div class="info-suit">
                              <span class="h3-f">Данные из накладной</span>
<form id="lalala_add_form" class="js-save-form-invoices" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
 <input name="save_invoice" value="1" type="hidden">
  <?


  echo'<!--input start-->';
  echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Номер накладной</i><span>*</span></label><input name="number_invoices" value="'.ipost_($_POST['number_invoices'],"").'" class="input_new_2021 gloab required  no_upperr js-number-acc-new" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
  echo'<!--input end	-->';


  echo'<!--input start-->';
  echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Дата</i><span>*</span></label><input name="datess" id="date_table" readonly="true" value="'.ipost_($_POST['datess'],"").'" class="input_new_2021 gloab required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div><div class="pad10" style="padding: 0;"><span class="bookingBox"></span></div><input id="date_hidden_table" name="date_invoice" value="'.ipost_($_POST['date_invoice'],"").'" type="hidden"></div>';
  echo'<!--input end	-->';

/*
  $su_5_name=ipost_($_POST['ispol_work'],"","z_contractor","name",$link);
  $su_5=ipost_($_POST['ispol_work'],"0");

  echo'<!--input start	-->';

  echo'<div class=" big_list">';
  //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

  echo'<div class="list_2021 input_2021 input-search-list gray-color js-zindex" list_number="box2"><i class="js-open-search"></i><span class="click-search-icon"></span><div class="b_loading_small loader-list-2021"></div><label>Поиск поставщика (название/инн)</label><input name="ispol_work1" value="'.$su_5_name.'" id="date_124" sopen="search_contractor" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search gloab" name="ispol_work" id="search_items_5"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';

//выбирать только тех у кого есть какие то счета на этом контрагенте
  $result_work_zz=mysql_time_query($link,"SELECT distinct A.id,A.name,A.inn,(select count(g.id) from z_acc as g where g.status IN ('3','4','20')) as kol FROM z_contractor as A,z_acc as B WHERE B.id_contractor=A.id and B.status IN ('3','4','20') ORDER BY kol limit 0,40");



  $num_results_work_zz = $result_work_zz->num_rows;
  if($num_results_work_zz!=0)
  {
      //echo'<li><a href="javascript:void(0);" rel="0"></a></li>';
      for ($i=0; $i<$num_results_work_zz; $i++)
      {
          $row_work_zz = mysqli_fetch_assoc($result_work_zz);

          $yop='';
          if($row_work_zz["id"]==$su_5) {
              $yop='sel_active';
          }

          echo'<li class="'.$yop.'"><a href="javascript:void(0);" rel="'.$row_work_zz["id"].'">'.$row_work_zz["name"].' <span class="gray-date">(ИНН-'.$row_work_zz["inn"].')</span></a></li>';

      }
  }

  echo'</ul><div class="div_new_2021"><div class="oper_name"></div></div></div></div><!--input end	-->';

*/


  echo'<div class="js-more-options-supply">';
  echo'<!--input start	-->		
<div class="password_docs">
<div id="0" class="input-choice-click-pass js-password-docs js-type-soft-view js-ajax-new-profi active_pass">
<div class="choice-head">поставщик</div>
<div class="choice-radio"><div class="center_vert1"><i class="active_task_cb"></i></div></div>
</div>	

<div id="1" class="input-choice-click-pass js-password-docs js-type-soft-view js-ajax-new-profi">
<div class="choice-head">Новый поставщик</div>
<div class="choice-radio"><div class="center_vert1"><i></i></div></div>
</div>
<input name="new_contractor_" class="js-type-soft-view1" value="0" type="hidden">	
</div>		
<!--input end -->';

  //существующий поставщик
  echo'<div class="js-options-supply-0">';


  $su_5_name=ipost_($_POST['id_kto'],"","z_contractor","name",$link);
  $su_5=ipost_($_POST['id_kto'],"0");

  echo'<!--input start	-->';

  echo'<div class=" big_list">';
  //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

  echo'<div class="list_2021 input_2021 input-search-list gray-color js-zindex" list_number="box2"><i class="js-open-search"></i><span class="click-search-icon"></span><div class="b_loading_small loader-list-2021"></div><label>Поиск поставщика (название/инн)</label><input name="kto" value="'.$su_5_name.'" id="date_124" sopen="search_contractor" fns="1" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search gloab2 js-id-kto-ajax" name="id_kto" id="search_items_5"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';



  //выбирать только тех у кого есть какие то счета на этом контрагенте
  $result_work_zz=mysql_time_query($link,"SELECT distinct A.id,A.name,A.inn,(select count(g.id) from z_acc as g where g.status IN ('3','4','20')) as kol FROM z_contractor as A,z_acc as B WHERE B.id_contractor=A.id and B.status IN ('3','4','20') ORDER BY kol limit 0,40");



  $num_results_work_zz = $result_work_zz->num_rows;
  if($num_results_work_zz!=0)
  {
      //echo'<li><a href="javascript:void(0);" rel="0"></a></li>';
      for ($i=0; $i<$num_results_work_zz; $i++)
      {
          $row_work_zz = mysqli_fetch_assoc($result_work_zz);

          $yop='';
          if($row_work_zz["id"]==$su_5) {
              $yop='sel_active';
          }

          echo'<li class="'.$yop.'"><a href="javascript:void(0);" rel="'.$row_work_zz["id"].'">'.$row_work_zz["name"].' <span class="gray-date">(ИНН-'.$row_work_zz["inn"].')</span></a></li>';

      }
  }

  echo'</ul><div class="div_new_2021"><div class="oper_name"></div></div></div></div><!--input end	-->';






  echo'</div>';


  //новый поставщик
  echo'<div class="js-options-supply-1 option-new-contractor none">';

  echo'<!--input start-->';
  echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Полное название поставщика</i><span>*</span></label><input name="name_contractor" value="" class="input_new_2021 gloab1 required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
  echo'<!--input end	-->';

  echo'<!--input start-->';
  echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Адрес поставщика</i><span>*</span></label><input name="address_contractor" value="" class="input_new_2021 gloab1 required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
  echo'<!--input end	-->';

  echo'<!--input start-->';
  echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Директор</i><span>*</span></label><input name="dir_contractor" value="" class="input_new_2021 gloab1 required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
  echo'<!--input end	-->';


  echo'<!--input start-->';
  echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>ИНН поставщика</i><span>*</span></label><input name="inn_contractor" value="" class="input_new_2021 gloab1 required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
  echo'<!--input end	-->';
  echo'<!--input start-->';
  echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>ОГРН поставщика</i><span>*</span></label><input name="ogrn_contractor" value="" class="input_new_2021 gloab1 required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
  echo'<!--input end	-->';
  echo'<input name="name_small_contractor" value=""  type="hidden">';
  echo'<input name="status_contractor" value=""  type="hidden">';


  echo'</div>';

  echo'</div>';



  //echo'<div class="content_block1" id_content="'.$id_user.'">';

//print_r($stack_error);
	/*echo '<pre>';
print_r($_POST["works"]);	
	echo '</pre>';
	*/
//echo'<h3 style=" margin-bottom:0px;">Добавление наряда<div></div></h3>';

	  
	?>  
	<script type="text/javascript" src="Js/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="Js/jquery.datepicker.extension.range.min.js"></script>
<script type="text/javascript">var disabledDays = [];
 $(document).ready(function(){
     input_2021();
            $("#date_table").datepicker({ 
altField:'#date_hidden_table',
onClose : function(dateText, inst){
        //alert(dateText); // Âûáðàííàÿ äàòà 
    input_2021();
    },
altFormat:'yy-mm-dd',
defaultDate:null,
beforeShowDay: disableAllTheseDays,
dateFormat: "d MM yy"+' г.', 
firstDay: 1,
minDate: "-180D", maxDate: "+30D",
beforeShow:function(textbox, instance){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 0,
                left: 0
            });
        }, 10);
	
    $('.bookingBox').append($('#ui-datepicker-div'));
    $('#ui-datepicker-div').hide();
} });
	 


<?
if($_POST['datess1']!='')
{
echo'var st=\''.ipost_($_POST['date_start'],"").'\';
var st1=\''.ipost_($_POST['date_end'],"").'\';
var st2=\''.ipost_($_POST['datess1'],"").'\';';
echo'jopacalendar(st,st1,st2);';		  
}
?>		 
//$('#date_table1').datepicker('setDate', ['+1d', '+30d']);
});
	 


	 
function resizeDatepicker() {
    setTimeout(function() { $('.bookingBox1 > .ui-datepicker').width('100%'); }, 10);
}	 

function jopacalendar(queryDate,queryDate1,date_all) 
	{
	
if(date_all!='')
	{
var dateParts = queryDate.match(/(\d+)/g), realDate = new Date(dateParts[0], dateParts[1] -1, dateParts[2]); 
var dateParts1 = queryDate1.match(/(\d+)/g), realDate1 = new Date(dateParts1[0], dateParts1[1] -1, dateParts1[2]); 	 	 
$('#date_table1').datepicker('setDate', [realDate,realDate1]);	 	 
$('#date_table1').val(date_all);
	}
	}
	 

            </script>	  
	  
	  
	  <?
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  

					
			$token=token_access_compile($_GET['id'],'add_invoicess_x',$secret);				
						
						echo'<input type="hidden" value="'.$token.'" name="tk">';   
					 


	  

	  
		   
	//echo'<div class="content_block1">';	
/*
<div class="close_all_r">закрыть все</div>
<div data-tooltip="Удалить всю себестоимость" class="del_seb"></div>
<div data-tooltip="Добавить раздел" class="add_seb"></div>
';
*/
  
	  
	  	//echo'</div>';  
	

	
 

   
	  

	
    ?>




</form>
                  </div></div></div></div></div></div>
<?
include_once $url_system.'template/left.php';
?>

</div>
</div><script src="Js/rem.js" type="text/javascript"></script>
<?
echo'<script type="text/javascript">var b_co=\''.$b_co.'\'</script>';
?>
<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
	
</div>

</body></html>

<?php
if((count($stack_error)!=0))
{
    ?>
    <script type="text/javascript">
    $(function (){
    setTimeout ( function () {
        alert_message('error', 'Ошибка - попробуйте еще раз');
    });
    });
    </script>
    <?php
}
?>