    <div class="menu_top"><div class="menu1 menu_jjs">
    
    
    
    
    <? 
       $os = array( "дата поставки", "по алфавиту","новые");
	   $os_id = array("0", "1", "2");	
		
		$su_1=0;
		if (( isset($_COOKIE["su_1"]))and(is_numeric($_COOKIE["su_1"]))and(array_search($_COOKIE["su_1"],$os_id)!==false))
		{
			$su_1=$_COOKIE["su_1"];
		}
		
		
		   echo'<div class="left_drop menu1_prime"><label>Сортировка</label><div class="select eddd"><a class="slct" list_number="t1" data_src="'.$os_id[$su_1].'">'.$os[$su_1].'</a><ul class="drop">';
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
	 
		
		
		
		
       $os2 = array( "любая", "неделя","выбрать");
	   $os_id2 = array("0", "1", "2");	
		
		$su_2=0;
		$date_su='';
		if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and(array_search($_COOKIE["su_2"],$os_id2)!==false))
		{
			$su_2=$_COOKIE["su_2"];
		}
		$val_su2=$os2[$su_2];
		
		
		if ( isset($_COOKIE["sudd"]))
		{
			$date_base__=explode(".",$_COOKIE["sudd"]);
		if (( isset($_COOKIE["su_2"]))and(is_numeric($_COOKIE["su_2"]))and($_COOKIE["su_2"]==2)and(checkdate(date_minus_null($date_base__[1]), date_minus_null($date_base__[0]),$date_base__[2])))
		{
			$date_su=$_COOKIE["sudd"];
			$val_su2=$_COOKIE["sudd"];
		}
		}
		
		
		echo'<input id="date_hidden_table" name="date" value="'.$date_su.'" type="hidden">';
		   echo'<div class="left_drop menu1_prime"><label>Дата</label><div class="select eddd"><a class="slct" list_number="t2" data_src="'.$os_id2[$su_2].'">'.$val_su2.'</a><ul class="drop">';
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
		   echo'</ul><input type="hidden" name="sort2" id="sort2" value="'.$os2[$su_1].'"></div></div>'; 		
		

       $os3 = array( "любой", "не обработанные","в работе","на согласовании","оплата");
	   $os_id3 = array("0", "9", "11","12","13");	
		
		$su_3=0;
		if (( isset($_COOKIE["su_3"]))and(is_numeric($_COOKIE["su_3"]))and(array_search($_COOKIE["su_3"],$os_id3)!==false))
		{
			$su_3=$_COOKIE["su_3"];
		}
		
		
		   echo'<div class="left_drop menu1_prime"><label>Статус</label><div class="select eddd"><a class="slct" list_number="t3" data_src="'.$os_id3[$su_3].'">'.$os3[array_search($_COOKIE["su_3"], $os_id3)].'</a><ul class="drop">';
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

   

		       $os4 = array( "краткий", "подробный");
	   $os_id4 = array("0", "1");	
		
		$su_4=0;
		if (( isset($_COOKIE["su_4"]))and(is_numeric($_COOKIE["su_4"]))and(array_search($_COOKIE["su_4"],$os_id4)!==false))
		{
			$su_4=$_COOKIE["su_4"];
		}
		
		
		   echo'<div class="left_drop menu1_prime"><label>Вид</label><div class="select eddd"><a class="slct" list_number="t4" data_src="'.$os_id4[$su_4].'">'.$os4[array_search($_COOKIE["su_4"], $os_id4)].'</a><ul class="drop">';
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
		
		
		
		echo'<a href="supply/" class="show_sort_supply"><i>Применить</i></a>';
		?>
		<div id="date_table" class="table_suply_x"></div>
		
<div class="pad10" style="padding: 0;"><span class="bookingBox"></span></div>		
<script type="text/javascript" src="Js/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="Js/jquery.datepicker.extension.range.min.js"></script>
<script type="text/javascript">
var disabledDays = [];
 $(document).ready(function(){
	
            $("#date_table").datepicker({ 
altField:'#date_hidden_table',
onClose : function(dateText, inst){
        //alert(dateText); // Âûáðàííàÿ äàòà 
		
    },
altFormat:'dd.mm.yy',
defaultDate:null,
beforeShowDay: disableAllTheseDays,
dateFormat: "d MM yy"+' г.', 
firstDay: 1,	
autoclose: true,
minDate: "-1Y", maxDate: "+1Y",
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
} }).hide().on('change', function(){
        $('#date_table').hide();
		$('[list_number=t2]').empty().append($('#date_hidden_table').val());		
		$.cookie("sudd", null, {path:'/',domain: window.is_session,secure: false}); 	
CookieList("sudd",$('#date_hidden_table').val(),'add');		
		$('.show_sort_supply').removeClass('active_supply');
$('.show_sort_supply').addClass('active_supply');		
    });
	 		
 });
	 
	 
function resizeDatepicker() {
    setTimeout(function() { $('.bookingBox > .ui-datepicker').width('100%'); }, 10);
}	 

function jopacalendar(queryDate,queryDate1,date_all) 
	{
	
if(date_all!='')
	{
var dateParts = queryDate.match(/(\d+)/g), realDate = new Date(dateParts[0], dateParts[1] -1, dateParts[2]); 
var dateParts1 = queryDate1.match(/(\d+)/g), realDate1 = new Date(dateParts1[0], dateParts1[1] -1, dateParts1[2]); 	 	 
	}
	}
	
	
	
 </script>		
	<?	
	echo'<div class="more_supply menu_click"></div>';
		
		$menu = array( "Добавить счет", "Очистить корзину");
	$menu_id = array("1", "2");	
	
	echo'<div class="menu_supply menu_su1"><ul class="drops no_active" data_src="0" style="right:-20px; top:10px;">';
		   for ($it=0; $it<count($menu); $it++)
             {   
				  echo'<li><a href="javascript:void(0);"  rel="'.$menu_id[$it].'">'.$menu[$it].'</a></li>'; 
			   
			 
			 }
	echo'</ul><input rel="x" type="hidden" name="vall" class="vall_basket" value="0"></div>';	
		
		
	echo'<span class="add_sss"></span>';	
	//echo'<a href="prime/'.$row_list["id_object"].'/add_a/'.$_GET['id'].'/" data-tooltip="добавить счет" class="add_score"><i class="score_plus"></i><i class="score_">1</i></a>';	
	
	echo'<div class="more_supply2 menu_click"></div>';
		
	$menu = array( "Сохранить текущий", "Закрыть текущий","Просмотр");
	$menu_id = array("1", "2","3");	
	
	echo'<div class="menu_supply menu_su1"><ul class="drops no_active" data_src="0" style="right:-40px; top:10px;">';
		   for ($it=0; $it<count($menu); $it++)
             {   
				  echo'<li><a href="javascript:void(0);"  rel="'.$menu_id[$it].'">'.$menu[$it].'</a></li>'; 
			   
			 
			 }
	echo'</ul><input rel="x" type="hidden" name="vall2" class="vall_basket2" value="0"></div>';	
			
	if (( isset($_COOKIE["current_supply_".$id_user]))and(is_numeric($_COOKIE["current_supply_".$id_user])))
	{	
	//определяем текущий счет и количество материалов в нем
		$result_t_=mysql_time_query($link,'Select a.*,(select count(g.id) from z_doc_material_acc as g where g.id_acc=a.id ) as countss from z_acc as a where a.id="'.htmlspecialchars(trim($_COOKIE["current_supply_".$id_user])).'"');
        $num_results_t_ = $result_t_->num_rows;
        if($num_results_t_!=0)
        {	
	         
			$row_t_ = mysqli_fetch_assoc($result_t_);
	        $date_base__=explode("-",$row_t_["date"]);
			echo'<div class="current_score"><div class="score_cc">текущий счет <div class="number_score">№'.$row_t_["number"].' от '.$date_base__[2].'.'.$date_base__[1].'.'.$date_base__[0].'</div></div><i class="count_scire" data-tooltip="сохранить текущий счет"><i class="count_numb_score">'.$row_t_["countss"].'</i></i></div>';
			
        }
		
	} else
	{	
	echo'<div class="current_score"><div class="score_cc">текущий счет <div class="number_score"></div></div><i class="count_scire" data-tooltip="сохранить текущий счет"><i class="count_numb_score"></i></i></div>';
		
	}
			
     include_once $url_system.'module/notification.php';
		
	?>
   
    </div></div>
    