<?php


function reset_url($url) {
    $value = str_replace ( "http://", "", $url );
    $value = str_replace ( "https://", "", $value );
    $value = str_replace ( "www.", "", $value );
    $value = explode ( "/", $value );
    $value = reset ( $value );
    return $value;
}

$_SERVER['HTTP_REFERER'] = reset_url ( $_SERVER['HTTP_REFERER'] );
$_SERVER['HTTP_HOST'] = reset_url ( $_SERVER['HTTP_HOST'] );
 
 
 
 
 
if ($_SERVER['HTTP_HOST'] != $_SERVER['HTTP_REFERER']) {

    // @header ( 'Location: ' . $config['http_home_url'] );
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
    die ();
}
     
     
 
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    /* значит ajax-запрос */
     
    /* обрабатываем */
     
} else {

	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();
}

//Проверяем вдруг это взлом. смотрим есть ли такой тип, относятся ли эти условия поиска к этому типу, существует ли сортировка


define( '_SECRETJ', 7 );
session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
//подключение к базе
include_once $url_system.'module/config.php';
//подключение написанных функций для сайта
include_once $url_system.'module/function.php';
include_once $url_system.'login/function_users.php';

//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;



//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) == 1)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
	if((isset($_SESSION["user_id"]))and(is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
	{
/*
 $result_url=mysql_time_query($link,'select a.bron_table,bron_table_url from poddomen_all as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
 $num_results_custom_url = $result_url->num_rows;
 if(($num_results_custom_url!=0))
 {
	$row_acd = mysqli_fetch_assoc($result_url);
	if(($row_acd["bron_table"]==1)and($row_acd["bron_table_url"]==''))
	{
*/		
		
	   $status=1;
		
		
		
       
	   //Проверяем сколько адресов для бронирования у компании
	   //Адреса для брони хранятся в отдельной базе, так как имеют свои сокращения
	   //Адрес должен быть забит в базу poddomen_all_reserver_address - даже если он один
	   $address=0;
	   $adress_est=0;
	   
       $result_reserver_h=mysql_time_query($link,'select A.* from poddomen_all_reserver_address as A where A.id_poddomen_all="'.htmlspecialchars(trim($_GET['id'])).'" AND A.visible=1');
       $num_results_reserver_h = $result_reserver_h->num_rows;

       if($num_results_reserver_h>1)
       {
		   $address=1;
		   $adress_est=1;
		   $row_reserver_h = mysqli_fetch_assoc($result_reserver_h);
	   } else
	   {
		 $row_reserver_h = mysqli_fetch_assoc($result_reserver_h); 
		 $adress_est=1; 
	   }

       $result_reserver=mysql_time_query($link,'select A.*,B.name from poddomen_all_reserver as A, poddomen_all as B where A.id_poddomen_all=B.id and A.id_poddomen_all="'.htmlspecialchars(trim($_GET['id'])).'" AND A.visible=1');
       $num_results_reserver = $result_reserver->num_rows;

       if($num_results_reserver<>0)
       {		    
		    $row_reserver = mysqli_fetch_assoc($result_reserver);
			$name_place_bron='';
			
			echo'<div id="Modal-one" class="box-modal table-modal"><div class="box-modal_close arcticmodal-close"></div>

            <span class="bron_t bron_tgg" id="'.$_GET['id'].'">бронирование столика за 5 минут</span> <span class="clock_table"></span>';
			
			$name_place_bron=$row_reserver["name"];
			
			if(($address==0)and($adress_est==1))
            {
	            //у заведения бронировать можно только по одному адресу. поэтому для понятности выводим его в названии
               $name_place_bron.=', '.$row_reserver_h["address"];
			   $ad_t=$row_reserver_h["id"];
			   echo'<h1 class="name_bron_table" id="'.$row_reserver_h["id"].'">'.$name_place_bron.'</h1>';
			} else
			{
				echo'<h1>'.$name_place_bron.'</h1>';
			}
			
			echo'<span class="hop_lalala">';
			
			
			
			
            if($address==1)
            {
			   	//у заведения несколько адресов для бронирования
				//выводим чекбокс с выбором какой выбрать				
				$address_array=array();
                $ar_st='';
				echo'<div class="bron_adress addd">';
				for ($ih=0; $ih<$num_results_reserver_h; $ih++)
                {
					if($ih!=0){ $row_reserver_h = mysqli_fetch_assoc($result_reserver_h); }
					
				    $cheched='';
					if($ih==0){ $cheched='checked=""'; $ad_t=$row_reserver_h["id"]; }
					
					echo'<span><input class="Radiobox" '.$cheched.' name="adress_place" id="'.$row_reserver_h["id"].'" type="radio"><label id="'.$row_reserver_h["id"].'"><i>'.$row_reserver_h["address"].'</i></label></span>';
				}	
				echo'</div>';			
			}
			
				//echo'<input class="address_hidden_table" value="'.$ad_t.'" type="hidden">';
			//дата и количество человек
			//дата и количество человек
			echo'<div style="height:66px;"><div style="width:50%; float:left;"><div class="input-width"><div class="width-setter">';
			
			//определение сегодняшней даты
			
			//проверяем можно ли на сегодня бронировать по данному адресу
			//за час последнее бронирование
			$date_seachas=date("Y-m-d");
			//определяем день недели
			$day_nedeli= date("w");

$dateToday = new DateTime ('NOW');  //сколько сейчас времени

$tim=array("00:00","00:30","01:00","01:30","02:00","02:30","03:00","03:30","04:00","04:30","05:00","05:30 06:00","06:30","07:00","07:30","08:00","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30","20:00","20:30","21:00","21:30","22:00","22:30","23:00","23:30");

            $time_bron_user = 0;
			foreach ($tim as $key => $val) {
				$val  = date_create_from_format('H:i', $val);
				//$diff = date_diff($val, $dateToday);
				if ($dateToday < $val ) {
                    $time_bron_user = $key; // $number используется в дальнейшем, чтобы сделать срез массива
                    break;
                }
			}
			//echo($tim[$time_bron_user]);
			$time_place = array();
			$disabledDays=array();
			$flag_bron_today=0; //по умолчанию бронировать в этот день нельзя
			
			
			//если сегодня нет броней смотрим на следующий день
			
			$date_plus=0;
			$next_day=0;
			for ($day=0; (($day<7)and($flag_bron_today==0)); $day++)
			{
			if($day!=0) { array_push($disabledDays, date('n-j-Y', strtotime("+".$date_plus." days")));  $date_plus++;  if($day_nedeli!=6) { $day_nedeli++; $next_day=1; $time_bron_user=0; } else { $day_nedeli=0; $next_day=1; $time_bron_user=0; } }
			
			$result_day_time=mysql_time_query($link,'select A.start,A.end from poddomen_all_reserver_day as A where A.id_poddomen_all="'.htmlspecialchars(trim($_GET['id'])).'" and A.id_week="'.$day_nedeli.'" AND A.id_address="'.$ad_t.'" ORDER BY a.start');
			//echo('select A.start,A.end from poddomen_all_reserver_day as A where A.id_poddomen_all="'.htmlspecialchars(trim($_GET['id'])).'" and A.id_week="'.$day_nedeli.'" AND A.id_address="'.$ad_t.'"');
            $num_results_day_time = $result_day_time->num_rows;

            if($num_results_day_time<>0)
            {
				for ($d=0; $d<$num_results_day_time; $d++)
                {
				   $row_day_time = mysqli_fetch_assoc($result_day_time);
				   //echo("!");
				   //проверяем ближайшая дата входил ли в какой нибудь промежуток для бронирования этого заведения
				   $val_start  = date_create_from_format('H:i', $row_day_time["start"]);
				   $val_end  = date_create_from_format('H:i', $row_day_time["end"]);  //минус час до закрытия
				   
				   
			foreach ($tim as $key => $val) {
				
				$val  = date_create_from_format('H:i', $val);
				
				if ( $val_end == $val ) {
					
					if($tim[$key]=='00:00')
					{
					   	$zavt=$day_nedeli;
						if($zavt!=6) { $zavt++; } else { $zavt=0; }
						
						$result_day_time2=mysql_time_query($link,'select A.start,A.end from poddomen_all_reserver_day as A where A.id_poddomen_all="'.htmlspecialchars(trim($_GET['id'])).'" and A.id_week="'.$zavt.'" AND A.id_address="'.$ad_t.'" AND a.start="00:00"');

//echo('select A.start,A.end from poddomen_all_reserver_day as A where A.id_poddomen_all="'.htmlspecialchars(trim($_GET['id'])).'" and A.id_week="'.$zavt.'" AND A.id_address="'.$ad_t.'" AND a.start="00:00"');
                        $num_results_day_time2 = $result_day_time2->num_rows;

                        if($num_results_day_time2<>0)
                        {
						   //заведение работает и после 00:00 значит можно бронировать до 24:00 в этот день
						   $val_end  = date_create_from_format('H:i', '23:30');  //минус час до закрытия
						} else
						{
						   $val_end  = date_create_from_format('H:i', '23:00');  //минус час до закрытия
						}
					 
					}
					if($tim[$key]!='00:00')
					{
					if($key==1)
					   {
					   $val_end  = $val_start;    
					   } else
					   {
					   $val_end  = date_create_from_format('H:i', $tim[$key-2]);  //минус час до закрытия
					   }
					}
					
                    break;
                }
			}
		//echo($val_end->format('H:i'));
		//echo($tim[$time_bron_user]);
		
		$val_user  = date_create_from_format('H:i', $tim[$time_bron_user]);
			if((($val_user> $val_start)and($val_user<$val_end))or($val_user<$val_start)or($next_day==1))
			{
			  //есть бронирования за этот день
			  $flag_bron_today=1;
			  //echo("ddd");
			  
			  //добавляем в массив времени
			 //$key = array_search('red', $tim);
			 if(($next_day==1)or($val_user<$val_start))
			 {
				$time_bron_user=array_search($row_day_time["start"], $tim);
			 }
			  
				for ($ij=$time_bron_user; $ij<count($tim); $ij++)
                {
					//echo($val_end->format('H:i'));
					//echo($tim[$ij]);
					$valss  = date_create_from_format('H:i', $tim[$ij]);
					if ( $valss > $val_end ) {
						break;
					} else
					{
					array_push($time_place, $tim[$ij]);
					//echo( $tim[$ij]);
					
					}
				}			  
			  	
			}
			
			
				}
			}
			
			
			}
			
			//print_r($time_place);
			
			$day_nedeli_mojno=array();
			
			$result_day_timeggg=mysql_time_query($link,'select DISTINCT A.id_week from poddomen_all_reserver_day as A where A.id_poddomen_all="'.htmlspecialchars(trim($_GET['id'])).'" AND A.id_address="'.$ad_t.'"');

            $num_results_day_timeggg = $result_day_timeggg->num_rows;

            if($num_results_day_timeggg<>0)
            {
				for ($dg=0; $dg<$num_results_day_timeggg; $dg++)
                {
					$row_day_timeggg = mysqli_fetch_assoc($result_day_timeggg);
					array_push($day_nedeli_mojno,$row_day_timeggg["id_week"]);
				}
			}
			
			
			//проверяем можно ли бронировать на следующие 30 дней вперед
			
			for ($ijj=count($disabledDays)+1; $ijj<30; $ijj++)
            {
				$date_neww=date('n-j-Y', strtotime("+".$ijj." days"));
				$day_neww_nedeli=date('w', strtotime("+".$ijj." days"));
				if (!in_array($day_neww_nedeli, $day_nedeli_mojno)) 
				{
					array_push($disabledDays,$date_neww);
				}
			}
			//print_r($disabledDays);
			
			
			//date('Y-m-d', strtotime("+".$date_plus." days"));
			
			$posl_chifra_id2=htmlspecialchars(trim($_GET['id']))%10;
			$timeet=time();
			//echo($timeet.'<br>');
			//$posl_chifra_id2=9;
			$st_time1 = substr($timeet, 0, $posl_chifra_id2);
            $st_time2= substr($timeet, $posl_chifra_id2);
			//echo($st_time2.$st_time1.'<br>');
			//echo(encode_x($secret[2].$st_time2.$st_time1.$secret[3],$secret).'<br>');
			

			
			
			
            
			$token=htmlspecialchars(trim($_GET['id'])).'.'.md5($secret.htmlspecialchars(trim($_GET['id'])).$secret[0]).'.'.encode_x($secret[2].$st_time2.$st_time1.$secret[3],$secret);
			
			
			
			
			
			
			echo'<input mor="'.$token.'"  date="'.date('Y-m-d', strtotime("+".$date_plus." days")).'" id="date_hidden_table" value="'.date('Y-m-d', strtotime("+".$date_plus." days")).'" type="hidden">';
			
			echo'<input readonly="true" name="datess" id="date_table" class="input_f_1 input_100 calendar_t" value="'.date('j', strtotime("+".$date_plus." days")).' '.month_rus(date('m', strtotime("+".$date_plus." days"))).' '.date('Y', strtotime("+".$date_plus." days")).' г." autocomplete="off" type="text"><i class="icon_cal"></i></div></div></div><div style="width:50%; float:left; "><div style="margin-left:20px; position:relative;"><button class="input_f_1_minus"></button><button class="input_f_1_plus"></button><div class="input-width"><div class="width-setter"><input name="people" id="people_table" class="input_f_1 input_100 people_t" style="text-align:center" value="2 чел."  placeholder="2 чел." for="2" autocomplete="off" type="text"></div></div></div></div><div class="bookingBox"></div></div>';				
			

			//дата и количество человек
			//дата и количество человек
	echo'<div class="time_list">';
	for ($days=0; $days<count($time_place); $days++)
	{
	  if($days==0) { $class_time="active_time"; } else { $class_time=""; }
	  if($days>17) { $class_time="hide"; }
	 
	 
	  echo'<div active="'.$time_place[$days].'" class="time_group '.$class_time.' select_time_0" title="Забронировать столик на '.$time_place[$days].'"><span>'.$time_place[$days].'</span></div>';
	  
	  if($days==17)
	  {
		echo'<div title="Показать все" class="more_time"><span>99:99</span></div> '; 
	  }
	  
	}
	echo'</div>';
	
    echo'<div class="preloader_bron_table"></div>';


	echo'<input class="time_hidden_table" value="'.$time_place[0].'" type="hidden">';
	
	

	
	//смотрим нужно ли выводить залы по активному адресу
	
	       $result_reserver_hall=mysql_time_query($link,'select A.* from poddomen_all_reserver_hall as A where A.id_poddomen_all="'.htmlspecialchars(trim($_GET['id'])).'" AND A.visible=1 and id_address="'.$ad_t.'" ORDER by a.displayOrder');
       $num_results_reserver_hall = $result_reserver_hall->num_rows;

       if($num_results_reserver_hall<>0)
       {	
	      //нужно выводить дополнительные залы
		  echo'<div class="bron_adress bron_hall">';
		  					echo'<span><input class="Radiobox" checked="" name="hall_place" id="0" type="radio"><label id="0"><i>Любой зал</i></label></span>';
				for ($ih=0; $ih<$num_results_reserver_hall; $ih++)
                {
					$row_reserver_hall = mysqli_fetch_assoc($result_reserver_hall);
	echo'<span><input class="Radiobox" name="hall_place" id="'.$row_reserver_hall["id"].'" type="radio"><label id="'.$row_reserver_hall["id"].'"><i>'.$row_reserver_hall["hall"].'</i></label></span>';
				}
		  echo'</div>';		
	   } else
	   {
		     echo'<div class="bron_adress bron_hall hide"></div>';
	   }
			
			if(isset($_SESSION['user_id']))
            {
				$result_uu=mysql_time_query($link,'select telefon,namess from users where id="'.htmlspecialchars(trim($_SESSION['user_id'])).'"');
   $num_results_uu = $result_uu->num_rows;

   if($num_results_uu!=0)
   {                 
	$row_uu = mysqli_fetch_assoc($result_uu);
	
	
	echo'<div class="input-width"><div class="width-setter"><input value="'.$row_uu["namess"].'" name="name_us_table" id="name_us_table" placeholder="Ваше Имя" class="input_f_1 input_100" autocomplete="off" type="text"></div></div>';	
	if($row_uu["telefon"]!='')
	{
	/*
	base             form
	9603648858  -> +7 (960) 364-8858
	*/
	$telld=$row_uu["telefon"];
	$telld = "+7 (".substr($telld, 0, 3).") ".substr($telld, 3, 3)."-".substr($telld, 6, 4);
	//echo($telld);
	echo'<div class="tel_pl" style="height:66px;"><div style="width:50%; float:left;"><div class="input-width"><div class="width-setter"><input name="telefon_us_table" id="telefon_us_table" value="'.$telld.'" placeholder="Ваш телефон" class="input_f_1 input_100" autocomplete="off" type="text"></div></div></div>';
	} else
	{
	echo'<div class="tel_pl" style="height:66px;"><div style="width:50%; float:left;"><div class="input-width"><div class="width-setter"><input name="telefon_us_table" id="telefon_us_table" placeholder="Ваш телефон" class="input_f_1 input_100" autocomplete="off" type="text"></div></div></div>';		
	}
	
   }
			} else
		{
			echo'<div class="input-width"><div class="width-setter"><input name="name_us_table" id="name_us_table" placeholder="Ваше Имя" class="input_f_1 input_100" autocomplete="off" type="text"></div></div>';
			echo'<div  class="tel_pl" style="height:66px;"><div style="width:50%; float:left;"><div class="input-width"><div class="width-setter"><input name="telefon_us_table" id="telefon_us_table" placeholder="Ваш телефон" class="input_f_1 input_100" autocomplete="off" type="text"></div></div></div>';
			}

			echo'<div style="width:50%; float:left; "><div style="margin-left:20px;"><button class="input_f_1_b bron_i_vse">Забронировать</button></div></div></div>';
			
			
			
			echo'<span class="sms_hax"><div style="height:66px;"><div style="width:50%; float:left;"><div class="input-width"><div class="width-setter"><input name="code_us_table" id="code_us_table" placeholder="Код подтверждения с SMS" class="input_f_1 input_100" autocomplete="off" type="text"></div></div></div>';
	
			echo'<div style="width:50%; float:left; "><div style="margin-left:20px;"><button class="input_f_1_b bron_code_vse">Подтвердить</button></div></div></div></span>';		
			
			

			echo'<div class="input-width" style="position:relative;"><div class="width-setter"><input name="dop_table" id="dop_formi" placeholder="Дополнительные пожелания" class="input_f_1 input_100 dop_table_x" autocomplete="off" type="text"><i class="icon_cal1"></i></div>
			
			<div class="dop_table"><span><i>По возможности у окна</i></span><span><i>Желательно с диванчиками</i></span><span><i>Нужны детские стульчики</i></span><span><i>Не рядом с кондиционером</i></span></div>
			
			
			</div>';			
							
			echo'</span>';
			
			echo'<span class="yess_tt"></span>';
			
			
			
			echo'</div>';
			
	   }	
	
	}
/*	
 }
*/
}
if($status==0)
{
	//что то не так. Почему то бронировать нельзя
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();	
}
/*

						 $datetime1 = date_create('Y-m-d');
                         $datetime2 = date_create('2017-01-17');
						 
                         $interval = date_create(date('Y-m-d'))->diff( $datetime2	);				 
                         $date_plus=$interval->days;
						 */
						 //echo(dateDiff_(date('Y-m-d'),'2017-01-17'));
						 


?>
<script type="text/javascript" src="Js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="Js/bron_table.js"></script>

<script type="text/javascript">var disabledDays = [<? echo('"'.implode('","', $disabledDays).'"'); ?>];
 $(document).ready(function(){           
            $("#date_table").datepicker({ 
altField:'#date_hidden_table',
onClose : function(dateText, inst){
        //alert(dateText); // Выбранная дата 
		AjaxUpdateTimeTable();
    },
altFormat:'yy-mm-dd',
defaultDate:null,
beforeShowDay: disableAllTheseDays,
dateFormat: "d MM yy"+' г.', 
firstDay: 1,
minDate: 0, maxDate: "+30D",
beforeShow:function(textbox, instance){
	//alert('before');
	setTimeout(function () {
            instance.dpDiv.css({
                position: 'absolute',
				top: 77,
                left: 0
            });
        }, 10);
	
    $('.bookingBox').append($('#ui-datepicker-div'));
    $('#ui-datepicker-div').hide();
} });
 });
 initializeTimer();
            </script>

