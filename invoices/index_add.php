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



if((isset($_POST['save_invoice']))and($_POST['save_invoice']==1))
{
	$token=htmlspecialchars($_POST['tk']);
	$id=htmlspecialchars($_GET['id']);
	
	//токен доступен в течении 120 минут
	if(token_access_yes($token,'add_invoicess_x',$id,120))
    {
		//echo("!");
	//возможно проверка что этот пользователь это может делать
	 if (($role->permission('Накладные','R'))or($sign_admin==1))
	 {	
	
	$stack_memorandum = array();  // общий массив ошибок
	$stack_error = array();  // общий массив ошибок
	$error_count=0;  //0 - ошибок для сохранения нет
	$flag_podpis=0;  //0 - все заполнено можно подписывать

	//print_r($stack_error);
	//исполнитель	
	if(($_POST['ispol_work']==0)or($_POST['ispol_work']==''))
	{
		array_push($stack_error, "ispol_work");
		$error_count++;
		$flag_podpis++;  
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
		

			
		   mysql_time_query($link,'INSERT INTO z_invoice (id,number,date,date_last,date_create,summa,id_contractor,id_user,status) VALUES ("","'.htmlspecialchars($_POST['number_invoices']).'","'.htmlspecialchars($_POST['date_invoice']).'","'.date("y-m-d").' '.date("H:i:s").'","'.date("y-m-d").' '.date("H:i:s").'","0","'.htmlspecialchars(trim($_POST["ispol_work"])).'","'.$id_user.'","1")');
			$ID_N=mysqli_insert_id($link); 
			
			//переадрессуем для дальнейшего сохранения
			  header("Location:".$base_usr."/invoices/".$ID_N.'/');	
		}

	

}

}
	
	
}



$secret=rand_string_string(4);
$_SESSION['s_t'] = $secret;	





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
if (( count($_GET) != 0 ) )
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

	  include_once $url_system.'template/top_invoices_add.php';

	?>
<form id="lalala_add_form" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
 <input name="save_invoice" value="1" type="hidden">
  <?
	
    echo'<div class="content_block1" id_content="'.$id_user.'">';

//print_r($stack_error);
	/*echo '<pre>';
print_r($_POST["works"]);	
	echo '</pre>';
	*/
//echo'<h3 style=" margin-bottom:0px;">Добавление наряда<div></div></h3>';
echo'<div class="comme" >Необходимые данные</div>';	  
	
	  
	  
	  $rrtt=0;
	  

	       
					
	echo'<div style="height:70px;"><div class="_50_na_50_1" style="width:33.3%; float:left;">';
	
	echo'<div class="width-setter1"><label style="display: none; margin-top: 20px;">Номер</label><input style=" margin-top: 20px;" name="number_invoices"  placeholder="Номер" class="input_f_1 input_100 white_inp label_s save__s" autocomplete="off" id="number_invoice" value="'.ipost_($_POST['number_invoices'],"").'" type="text"></div>';
	
		   
		echo'</div>';
		
		echo'<div class="_50_na_50_1" style="width:33.3%; float:left;">';
		   echo'<div class="input-width m10_right" style="position:relative; margin-left: 10px; ">';
		    
		    echo'<input id="date_hidden_table" name="date_invoice" value="'.ipost_($_POST['date_invoice'],"").'" type="hidden"><label style="display: none; margin-top: 20px; top:9px; text-transform: uppercase;">Дата с накладной</label>';
			
			echo'<input readonly="true" name="datess" value="'.ipost_($_POST['datess'],"").'" id="date_table" class="input_f_1 input_100 calendar_t label_s save__s white_inp '.iclass_("date_naryad",$stack_error,"error_formi").'" placeholder="Дата"  autocomplete="off" type="text"><i class="icon_cal cal_223"></i></div></div>';
		
		echo'<div class="pad10" style="padding: 0;"><span class="bookingBox"></span></div>';
		
		echo'';
	  
		  
		  
		  
			echo'<div class="_50_na_50_1" style="width:33.3%; float:left;">';
		   
	echo'<div class="input-width m10_left" style="margin-left:10px;">';
		
		
	$result_t=mysql_time_query($link,'Select a.id,a.name from z_contractor as a order by a.name');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="select_box eddd_box "><a class="slct_box save__s '.iclass_('ispol_work',$stack_error,"error_formi").'" data_src="0"><span class="ccol">'.ipost_($_POST['ispol_work'],"Поставщик","z_contractor","name",$link).'</span></a><ul class="drop_box">';
		  // echo'<li><a href="javascript:void(0);"  rel="0">--</a></li>';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);

				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>'; 
			  
			 }
		   echo'</ul><label style="display: none; margin-top: 20px; top:-9px; text-transform: uppercase;">Поставщик</label><input class="label_s" name="ispol_work" id="ispol" value="'.ipost_($_POST['ispol_work'],"0").'" type="hidden"></div>'; 
	   }
		
		
		
		
		echo'</div>';
	
	echo'';
	
	
	// echo'<div class="pad10" style="padding: 0; width:100%;"><span class="bookingBox1"></span></div>';
	  echo'</div>';
	  
	?>  
	<script type="text/javascript" src="Js/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="Js/jquery.datepicker.extension.range.min.js"></script>
<script type="text/javascript">var disabledDays = [];
 $(document).ready(function(){           
            $("#date_table").datepicker({ 
altField:'#date_hidden_table',
onClose : function(dateText, inst){
        //alert(dateText); // Âûáðàííàÿ äàòà 
		
    },
altFormat:'yy-mm-dd',
defaultDate:null,
beforeShowDay: disableAllTheseDays,
dateFormat: "d MM yy"+' г.', 
firstDay: 1,
minDate: "-60D", maxDate: "+60D",
beforeShow:function(textbox, instance){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 65,
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
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  echo'</div><div class="invoices_mess">Заполните и нажмите кнопку сохранить</div><div class="content_block block_primes1">';			
					
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
    </div>
  </div>


</form>
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