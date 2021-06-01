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


$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

//index.php не должно быть в $url_404
if (strripos($url_404, 'index_view.php') !== false) {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
}

if (( count($_GET) == 1 )) 
{


 if(( count($_GET) == 1 )and(isset($_GET["id"])))
 {
   //не на главной в побочных страницах
   
	 
   //можно ли этому пользователю смотреть эти побочные страницы
$result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
if(($result_txs->num_rows!=0)and($_GET['id']!=$id_user))
  {   	 
	 $rowlist = mysqli_fetch_assoc($result_txs);
	  mysql_time_query($link,'update r_message set status="0" where id_user="'.htmlspecialchars(trim($id_user)).'" and id_sign="'.htmlspecialchars(trim($_GET['id'])).'"');

   } else
   {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	   
   }
   
	 
 } else
 {

           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
	 
 
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

//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы

include_once $url_system.'template/html.php'; include $url_system.'module/seo.php';

if($error_header!=404){ SEO('message','','','',$link); } else { SEO('0','','','',$link); }

include_once $url_system.'module/config_url.php'; include $url_system.'template/head.php';
?>
</head><body><div class="container">
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

	  include_once $url_system.'template/top_message_view.php';

	  echo'<div class="menu_top sendler" style="border-bottom:0; bottom:0; top:auto;">';
	echo'<div id="yes_send" data-tooltip="отправить" class="save_button2"><i>.</i></div>';
	echo'<div class="div_textarea_otziv otziv_mess1"><div class="otziv_add"><textarea placeholder="Ваше сообщение" cols="40" rows="1" id="otziv_area" name="text" class="di text_area_otziv input_mess1"></textarea></div></div>';
	?>
	<script type="text/javascript"> 
	  $(function (){ 
$('#otziv_area').autoResize({extraSpace : 20, animateCallback : function() { /*$('.padding_mess').css("padding-bottom", $(this).outerHeight()); scroll_to_bottom(20);*/ }
});
ToolTip();

});

	</script>  
	<?
	echo'</div>';
	  

    echo'<div class="content_block message_block" n="1" id_content="'.htmlspecialchars(trim($_GET["id"])).'"><div class="padding_mess" style="overflow:hidden; padding-bottom: 40px;">';
	  
	  
	  
	?>

  <?

	$result_t22=mysql_time_query($link,'
SELECT count(*) as cc FROM ( 
(SELECT ff.id FROM r_message AS ff WHERE  (ff.id_user = "'.htmlspecialchars(trim($id_user)).'") and ff.id_sign="'.htmlspecialchars(trim($_GET["id"])).'" ORDER BY ff.datesend)
UNION
(SELECT ff.id FROM r_message AS ff WHERE (ff.id_sign = "'.htmlspecialchars(trim($id_user)).'") and ff.id_user="'.htmlspecialchars(trim($_GET["id"])).'" ORDER BY ff.datesend)

) Z');	  
	  $count_message=10;
	  $s_message=0;
	  
	  
                   $num_results_t22 = $result_t22->num_rows;
	              if($num_results_t22!=0)
	              {	  
					  $row__22= mysqli_fetch_assoc($result_t22);
					  if(($row__22["cc"]!=0)and($row__22["cc"]>$count_message))
					  {
						  $s_message=$row__22["cc"]-$count_message;
					  }
				  }
	
	$result_t2=mysql_time_query($link,'
SELECT * FROM ( 
(SELECT ff.*,ff.id_sign as idd FROM r_message AS ff WHERE  (ff.id_user = "'.htmlspecialchars(trim($id_user)).'") and ff.id_sign="'.htmlspecialchars(trim($_GET["id"])).'" ORDER BY ff.datesend)
UNION
(SELECT ff.*,ff.id_sign as idd FROM r_message AS ff WHERE (ff.id_sign = "'.htmlspecialchars(trim($id_user)).'") and ff.id_user="'.htmlspecialchars(trim($_GET["id"])).'" ORDER BY ff.datesend)

) Z ORDER BY datesend limit '.$s_message.','.$count_message);

	  
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
					  $messi=array();

		   for ($ksss=0; $ksss<$num_results_t2; $ksss++)
           {     
              $row__2= mysqli_fetch_assoc($result_t2);
			  $messi[$ksss]["id"]=$row__2["id"]; 
			  $messi[$ksss]["status"]=$row__2["status"];  
			  $messi[$ksss]["idd"]=$row__2["idd"];
			  $messi[$ksss]["date"]=$row__2["datesend"]; 
			  $messi[$ksss]["datesend"]=time_stamp_mess($row__2["datesend"]); 
			  $messi[$ksss]["text"]=$row__2["message"];
			  $messi[$ksss]["time"]=time_stamp_time($row__2["datesend"]); 
		   }
				  
					  
//echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_cash" class="smeta2 notif_imp"><tbody>';
					  $date_prev='';
					  $user_prev='';
					  //print_r($messi);
					  if($s_message!=0)
					  {
echo'<div class="history_message" s_m="'.$s_message.'"></div>';		
					  }
foreach ($messi as $key => $value)
{     
                
           //echo($messi[1]["idd"]);          
$cll='';
  
if($value['status'] != 0) 
{
  $cll='bluesss';
}
			   $date_flag=0;
if($date_prev!=$value["datesend"])
{
$date_flag=1;	
$date_prev=$value["datesend"];	
echo'<div class="dialog_clear"></div>';		
	if($date_prev=='сегодня')
	{
		echo'<div class="message_date"><div><span class="sego_mess">'.$date_prev.'</span></div></div>';
	} else
	{
echo'<div class="message_date"><div><span>'.$date_prev.'</span></div></div>';		
	}
	
}
echo'<div class="dialog_clear"></div>';	
$fl='dialog_left';
if($value["idd"]==$id_user)
{
	//свои сообщения
	$fl='dialog_right';
}
echo'<a class="table dialog_message '.$fl.'" dmes_e="'.$value["date"].'" id_message="'.$value["id"].'"><div class="row">';
if($value["idd"]==$id_user)
{
	$rtt='';
		if(($value["idd"]!=$messi[$key+1]["idd"]))
	{
		$rtt='<div class="ull"></div>';
	}
	
	
	//свои сообщения
echo'<div class="cell b"><div class="messi  '.$cll.'">'.$rtt.htmlspecialchars_decode($value["text"]).'<span class="clock_message">'.$value["time"].'</span></div></div>';	
	
	if($value["idd"]!=$messi[$key+1]["idd"])
	{
		$user_prev=$value["idd"];
		echo'<div class="cell a"><div  sm="'.$value["idd"].'" style="margin-left: 0px;margin-top: 0px;" class="user_soz">'.avatar_img('<img src="img/users/',$value["idd"],'_100x100.jpg">').'</div></div>';
	} else
	{
	echo'<div class="cell a"></div>';
	}
} else	
{
	
	$rtt='';
		if($value["idd"]!=$messi[$key+1]["idd"])
	{
		$rtt='<div class="ull"></div>';
	}	
	
	if($value["idd"]!=$messi[$key+1]["idd"])
	{
		$user_prev=$value["idd"];
		echo'<div class="cell a"><div  sm="'.$value["idd"].'" style="margin-left: 0px;margin-top: 0px;" class="user_soz">'.avatar_img('<img src="img/users/',$value["idd"],'_100x100.jpg">').'</div></div>';
	} else
	{
echo'<div class="cell a"></div>';
	}
echo'<div class="cell b"><div class="messi  '.$cll.'">'.$rtt.htmlspecialchars_decode($value["text"]).'<span class="clock_message">'.$value["time"].'</span></div></div>';
}




 

						 


 //echo'<div class="font-rank del_notif" data-tooltip="Удалить" id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div>';

	
	/*echo'</td><td></td>		   
		   
		   </tr>';	 */ 
					echo'</div></a>';	 
					 }
					  
//echo'</tbody></table>'; 
					 /*echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_cash").freezeHeader({\'offset\' : \'67px\'}); });
				  </script>';	*/ 
					  
					  
		  
					  
 }	  	
 ?>
   
    </div></div>
  </div>

</div>
    <script>
$(function (){
scroll_to_bottom(1);
setInterval(function(){  if(inWindow(".history_message").length!=0) {  message_load();  }  }, 1000); // 1000 м.сек		
});
</script>
<?
include_once $url_system.'template/left.php';
?>
</div></div><script src="Js/rem.js" type="text/javascript"></script><div id="nprogress"><div class="bar" role="bar" ><div class="peg"></div></div></div></body></html>