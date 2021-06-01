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



$menu_b=array("Непрочитанные","Все");
	
$menu_title=array("Диалоги с непрочитанными сообщениями","Все Диалоги");	
	
$menu_get=array("","all");
$menu_url=array("","all/");
$menu_role_sign0=array(1,1);
$menu_role_sign012=array(1,1);	
$menu_sql=array();
$menu_sql1=array();	

//непрочитанные от кого то
//'SELECT * FROM (SELECT * FROM r_message WHERE id_user = "'.htmlspecialchars(trim($id_user)).'" and status=1 ORDER BY datesend DESC) t GROUP BY id_sign ORDER BY datesend DESC';
	
 array_push($menu_sql, 'select count(a.id) as kol from r_message as a where a.status=1 and a.id_user="'.htmlspecialchars(trim($id_user)).'"');

 array_push($menu_sql1, 'SELECT *,id_sign as idd FROM (SELECT ff.* FROM r_message as ff,r_dialog as vv WHERE vv.id_user=ff.id_user  AND vv.dialog_user=ff.id_sign and ff.id_user = "'.htmlspecialchars(trim($id_user)).'" and ff.status=1 ORDER BY ff.datesend DESC) t GROUP BY id_sign ORDER BY datesend DESC');
	
//все сообщеня включая отправленные им
/*'SELECT * FROM ( 
SELECT * FROM ( 
(SELECT datesend,id_sign,id_user,message,id,id_sign AS idd FROM (SELECT * FROM r_message WHERE (id_user = "'.htmlspecialchars(trim($id_user)).'") ORDER BY datesend DESC) t GROUP BY id_sign)
UNION
(SELECT datesend,id_sign,id_user,message,id,id_user AS idd FROM (SELECT * FROM r_message WHERE (id_sign = "'.htmlspecialchars(trim($id_user)).'") ORDER BY datesend DESC) t GROUP BY id_user)

) Z ORDER BY datesend DESC ) AS Z GROUP BY idd ORDER BY datesend DESC';
*/

array_push($menu_sql, '');
 
array_push($menu_sql1, 'SELECT * FROM ( 
SELECT * FROM ( 
(SELECT status,datesend,id_sign,id_user,message,id,id_sign AS idd FROM (SELECT ff.* FROM r_message AS ff,r_dialog AS vv WHERE vv.id_user=ff.id_user AND vv.dialog_user=ff.id_sign AND  (ff.id_user = "'.htmlspecialchars(trim($id_user)).'") ORDER BY ff.datesend DESC) t GROUP BY id_sign)
UNION
(SELECT status,datesend,id_sign,id_user,message,id,id_user AS idd FROM (
SELECT ff.* FROM r_message AS ff,r_dialog AS vv WHERE vv.id_user=ff.id_sign AND vv.dialog_user=ff.id_user AND (ff.id_sign = "'.htmlspecialchars(trim($id_user)).'") ORDER BY ff.datesend DESC) t GROUP BY id_user)

) Z ORDER BY datesend DESC ) AS Z GROUP BY idd ORDER BY datesend DESC');


$var_get='by';	



$active_menu='message';  // в каком меню


//$count_write=10;  //количество выводимых записей на одной странице


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

if (( count($_GET) == 1 )or( count($_GET) == 0 )) 
{
/*
if (($role->permission('Касса','R'))or($sign_admin==1))
{
*/

 if(( count($_GET) == 1 )and(isset($_GET["by"])))
 {
   //не на главной в побочных страницах
   
   $found1 = array_search($_GET["by"],$menu_get);   
   if($found1 === false)
   {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	   
   } else
   {
	 
   //можно ли этому пользователю смотреть эти побочные страницы
   if((($edit_price==1)and($menu_role_sign012[$found1]==1))or(($menu_role_sign0[$found1]==1)and($edit_price==0)))
   {	 
	 
   } else
   {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;	   
   }
   }
	 
 } else
 {

	 
	 if(count($_GET) == 0)
	 {
		 
         //если новых сообщений нет автоматически переходить во все сообщения
		 			$result_tcc=mysql_time_query($link,$menu_sql[0]);	  
            $row__cc= mysqli_fetch_assoc($result_tcc);		
			$count_n=$row__cc["kol"];
		 if($count_n==0)
		 {
		 header("Location:".$base_usr."/message/all/");	
		 }
		 
	 } else
	 {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
	 }
 
 }
 
	
/*	
} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}	
*/
	
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

	  include_once $url_system.'template/top_message_index.php';


    echo'<div class="content_block" id_content="'.$id_user.'">';
	?>



  <?
//print_r($id_user);
//print_r($hie->boss[3]);	  
//print_r($hie->boss[4]);
	  $hie_user_x = array();
	 if(($sign_admin==1))
	 {
	
		 					   $result_mat=mysql_time_query($link,'Select a.id from r_user as a where not(a.id="'.$id_user.'") order by a.name_user DESC');						 
					 
                     $num_results_mat = $result_mat->num_rows;
	                 if($num_results_mat!=0)
	                 {
		  
		               for ($mat=0; $mat<$num_results_mat; $mat++)
                        {  
                            $row_mat = mysqli_fetch_assoc($result_mat);
							array_push($hie_user_x, $row_mat['id']); 
						}
						 
					 }
		 
	 } else{
		 
	 
	  
$hie_user_x=array_concat(array_concat($hie->boss[4],$hie->boss[3]),$hie->boss[2]);	
	 }
	 
	  if(($key = array_search($id_user, $hie_user_x))!== FALSE)
      {
        unset($hie_user_x[$key]);
      }

//print_r($hie_user_x);	  
	  
	 if(count($hie_user_x)!=0)
	 {
echo' <h3 class="head_h" style=" margin-bottom:0px;">Ваша команда<i>'.count($hie_user_x).'</i><div></div></h3><br><br>';
	  
	  
	//print_r($hie_user);  

	  
	$online='';
	  echo'<div class="m_u_h">';
	  	       //for ($ksss=0; $ksss<count($hie_user); $ksss++)
				  foreach ($hie_user_x as $keys => $value1) 
			      {
                      
						 if($id_user!=$value1)
						 {
					   $result_userss=mysql_time_query($link,'Select a.timelast,a.name_user,a.id,b.name_role from r_user as a,r_role as b where a.id_role=b.id and a.id="'.htmlspecialchars(trim($value1)).'"');	 
					   $num_results_userss = $result_userss->num_rows;
	                   if($num_results_userss!=0)
	                   {
                         $row_userss= mysqli_fetch_assoc($result_userss);
$online='';	  
	if(online_user($row_userss["timelast"],$row_userss["id"],$id_user)) { $online='<div class="online"></div>';}	
	echo'<div class="kop_users"><div sm="'.$row_userss["id"].'"  data-tooltip="'.$row_userss["name_user"].'" class="user_soz send_mess">'.$online;
						  $filename = $url_system.'img/users/'.$row_userss["id"].'_100x100.jpg'; 
						  if (file_exists($filename)) {
						   echo'<img src="img/users/'.$row_userss["id"].'_100x100.jpg">';
						  } else
						  {
							echo'<img src="img/users/0_100x100.jpg">';  
						  }
						  echo'</div>';  
						  echo'<div class="kop_name_user">'.$row_userss["name_user"].'<br><span>'.$row_userss["name_role"].'</span></div></div>';
					   }
						 }
					 }

	echo'</div>';
	 }
	$result_t2=mysql_time_query($link,$menu_sql1[$title_key]);

	  if($title_key==0)
	  {
	  $sql_count=$menu_sql[$title_key];
$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);	  
	  
echo' <h3 class="head_h" style=" margin-bottom:0px;">'.$menu_title[$title_key].'<i>'.$row__221["kol"].'</i><div></div></h3><br><br>';
	  } else
	  {
echo' <h3 class="head_h" style=" margin-bottom:0px;">'.$menu_title[$title_key].'<i></i><div></div></h3><br><br>';		  
	  }
	  
	  echo'<div class="div_dialog">';
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
					  
				  

	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {     
                       $row__2= mysqli_fetch_assoc($result_t2);	  
                     
$cll='';
  
if($row__2['status'] != 0) 
{
  $cll='blues';
}
echo'<a class="table dialog_a '.$cll.'" rel_diagol="'.$row__2["idd"].'"><div class="row">';

echo'<div class="cell a">';

			   $result_txs=mysql_time_query($link,'Select a.name_user,a.id,a.timelast from r_user as a where a.id="'.$row__2["idd"].'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);	
					$online='';
					if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}
				  echo'<div  sm="'.$row__2["idd"].'" style="margin-left: 0px;" class="user_soz send_mess">'.$online;
						  $filename=$url_system.'img/users/'.$row__2["idd"].'_100x100.jpg';
if (file_exists($filename)) {
					echo'<img src="img/users/'.$row__2["idd"].'_100x100.jpg">';
} else
{
	echo'<img src="img/users/0_100x100.jpg">';
}
					echo'</div>';
				}
						 
echo'</div>';


echo'<div class="cell b">';

echo'<strong>'.$rowxs["name_user"].'</strong>';						 
if($row__2["id_user"]!=$id_user)
{	
  echo'<div class="table tablex"><div class="row"><div class="cell ellipsis">'.avatar_img('<img class="img_self" src="img/users/',$id_user,'_100x100.jpg">').htmlspecialchars_decode($row__2["message"]).'</div></div></div>';	

} else
{
  echo '<div class="table tablex"><div class="row"><div class="cell ellipsis">'.htmlspecialchars_decode($row__2["message"]).'</div></div></div>';
}
						 
echo'</div>';
echo'


<div class="cell c">'; 
$cv= no_view_message($row__2["idd"],$id_user,$link);
						 if($cv)
						 {
							 echo'<i class="i__message">'.$cv.'</i>';
						 } else
						 {
						 echo time_stamp($row__2["datesend"]);
						 }						 						 						 
echo'</div>';
echo'<div class="cell d"><span for="'.$row__2["idd"].'" data-tooltip="удалить диалог" class="del_dialog">5</span>
</div>'; 
					echo'</div></a>';	 
					 }
					  
 }
	  echo'</div>';
?>

    <script>
$(document).ready(function(){
		
	
	var tabs = $('#tabs2017');
		
	

	
	
	tabs.on('click', '.tab', function(e){

		$(this).children('a')[0].click();
		
	});
	function tabs_activation(tabs)
	{
		tabs.find(".slider").css({left: tabs.find('li.active').position().left + "px",width: tabs.find('li.active').width()+"px"});
    };	

	tabs_activation(tabs);
	
	   });	

	</script>         
        
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

</body></html>