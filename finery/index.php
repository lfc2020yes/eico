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



$menu_b=array("Все","Подписанные","Неподписанные","Утвержденные","На согласовании");
	
$menu_title=array("Все Наряды","Подписанные наряды","Неподписанные наряды","Утвержденные наряды","Наряды ждут согласования");	
	
$menu_get=array("","okay","nosigned","seal","decision");
$menu_url=array("","okay/","nosigned/","seal/","decision/");
$menu_role_sign0=array(1,1,1,1,0);
$menu_role_sign012=array(1,0,0,1,1);	
$menu_sql=array();
$menu_sql1=array();	

//все
 array_push($menu_sql, 'select count(a.id) as kol from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).')');

 array_push($menu_sql1, '');
	
//подписанные - только прорабам
 array_push($menu_sql, 'select count(a.id) as kol from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') and a.id_signed0="'.$id_user.'"');
 array_push($menu_sql1, ' and a.id_signed0="'.$id_user.'" ');	
//неподписанные	- только для прорабов
 array_push($menu_sql, 'select count(a.id) as kol from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') and a.id_signed0="0"');	
 array_push($menu_sql1, ' and a.id_signed0="0" ');		
//утвержденные
 array_push($menu_sql, 'select count(a.id) as kol from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') and a.signedd_nariad="1"');		
 array_push($menu_sql1, ' and a.signedd_nariad="1" ');	
//на согласовании
 array_push($menu_sql, 'select count(a.id) as kol from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') and a.signedd_nariad="0" and not(a.id_signed1=0)');		
 array_push($menu_sql1, ' and a.signedd_nariad="0" and not(a.id_signed1=0) ');	
$var_get='by';	



$active_menu='finery';  // в каком меню
if((isset($_GET["by"]))and($_GET["by"]=='decision'))
{
	$active_menu='finery/decision';
}


$count_write=10;  //количество выводимых записей на одной странице

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

if (( count($_GET) == 1 )or( count($_GET) == 0 )or( count($_GET) == 2 )) //--Åñëè áûëè ïðèíÿòû äàííûå èç HTML-ôîðìû
{

 if(( count($_GET) == 1 )and(isset($_GET["n_st"])))
 {
       //на главной по страничкам
         $result_url=mysql_time_query($link,'select a.id from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') '.limitPage('n_st',$count_write));
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} 
 } else
 {
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
 if(( count($_GET) == 2 )and(isset($_GET["by"]))and(isset($_GET["n_st"])))
 {	 
	 
	 //проверить может ли он туда заходить и есть ли такая страница
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
	 
	     //есть ли такая страница
	    $result_url=mysql_time_query($link,'select a.id from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') '.$menu_sql1[$found1].' '.limitPage('n_st',$count_write));
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
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
   }
	 
	 
 } else
 {
	 
	 if(count($_GET) == 0)
	 {
	 } else
	 {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
	 }
 }
 }
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

if($error_header!=404){ SEO('finery','','','',$link); } else { SEO('0','','','',$link); }

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
    echo'<div class="iss small">';
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

	  include_once $url_system.'template/top_prime_finery.php';
echo'<div id="fullpage" class="margin_60  input-block-2020 ">
    <div class="oka_block_2019" style="min-height:auto;">
 <div class="oka_block">
<div class="oka1 oka-newx js-cloud-devices" style="width:100%; text-align: left;">';

    echo'<div class="content_block" iu="'.$id_user.'" id_content="'.$id_user.'">';
	?>

  <?


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
  
	  
	  	//echo'</div>';  
	
			   	   $result_t2=mysql_time_query($link,'Select a.* from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') '.$menu_sql1[$title_key].' order by a.date_make desc '.limitPage('n_st',$count_write));
	  
   //запрос для определения общего количества = 
	  /*
   $sql_count='select count(a.id) as kol from n_nariad as a where a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).')';
*/
	  $sql_count=$menu_sql[$title_key];
$result_t221=mysql_time_query($link,$sql_count);	  
$row__221= mysqli_fetch_assoc($result_t221);	  

echo' <h3 class="head_h" style=" margin-bottom:0px;">'.$menu_title[$title_key].'<i>'.$row__221["kol"].'</i><div></div></h3> ';	  
	  
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
	
					  
				  
					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2"><thead>
		   <tr class="title_smeta"><th class="t_1">Номер</th><th class="t_1">Статус</th><th class="t_1">Исполнитель</th><th class="t_2 no_padding_left_">Объект/Период Наряда</th><th class="t_8">Итого работа/материал</th><th class="t_10"></th></tr></thead><tbody>';
	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {     
                       $row__2= mysqli_fetch_assoc($result_t2);	  
                       //узнаем название 						 
				$result_t22=mysql_time_query($link,'Select a.implementer from i_implementer as a where a.id="'.$row__2["id_implementer"].'"');
                $num_results_t22 = $result_t22->num_rows;
	            if($num_results_t22!=0)
	            {
					$row_t22 = mysqli_fetch_assoc($result_t22);
                   // echo'<a class="musa" href="implementer/'.$row_t2["id"].'/"><span class="s_j">'.$row_t2["implementer"].'</span></a>';
				}
$cll='';
if($row__2["signedd_nariad"]==1)
{
  $cll='whites';
}
					
echo'<tr class="nary n1n '.$cll.'" rel_id="'.$row__2["id"].'"><td class="middle_"><a href="finery/'.$row__2["id"].'/">№'.$row__2["id"].'</a></td><td>';
	/*					 
$status_title=array("подписан","не заполнен","не согласован","не подписан");
$status_class=array("sgreen","syelow","sred","sblue");						 
$status_value=array("2","0","-1","1");						 
$found = array_search($row__2["status"],$status_value);   
if($found !== false)
{	
echo'<div data-tooltip="'.$status_title[$found].'" class="status '.$status_class[$found].'"></div>';
}	
*/

	   //смотрим подписан ли он создателем
	   $hie1 = new hierarchy($link,$row__2["id_user"]);
	   $sign_level1=$hie1->sign_level;
       $sign_admin1=$hie1->admin;
	   $stack_users = array();		
	   for ($is=($sign_level1-1); $is<=3; $is++)
       {
		   		if($row__2["id_signed".$is]!=0)
				{
					  array_push($stack_users, $row__2["id_signed".$is]); 
				}
				/*	
					echo'<div  data-tooltip="Создан/Подписан - " class="user_soz"><img src="img/users/'.$rowx["id_signed".$i].'_100x100.jpg"></div>';
				} else
				{
				    echo'<div  data-tooltip="Создан - " class="user_soz n_yes"><img src="img/users/4_100x100.jpg"></div>';	
				}
				*/
	   }
	  // print_r($stack_users);
	   for ($is=0; $is<count($stack_users); $is++)
       {	
		   if(($is==0)and($stack_users[$is]==$row__2["id_user"]))
		   {
			   $result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($stack_users[$is])).'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);
				  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}	
			   echo'<div sm="'.$stack_users[$is].'"  data-tooltip="Создан/Подписан - '.$rowxs["name_user"].'" class="user_soz n_yes send_mess">'.$online.avatar_img('<img src="img/users/',$stack_users[$is],'_100x100.jpg">').'</div>';
				}
		   } else
		   {
			   if(($is==0))
			   {
				   $result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row__2["id_user"])).'"');
	               if($result_txs->num_rows!=0)
	               {   
		       
		            $rowxs = mysqli_fetch_assoc($result_txs);
									  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}	   
				    echo'<div sm="'.$row__2["id_user"].'"  data-tooltip="Создан - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row__2["id_user"],'_100x100.jpg">').'</div>';	
		           }
			   }
			    $hiex = new hierarchy($link,$stack_users[$is]);
	            $sign_levelx=$hiex->sign_level;
                $sign_adminx=$hiex->admin;
			    $but_text='Подписан';
			   //echo($is);
			    if(($sign_adminx!=1)and($sign_levelx==2)and($row__2["signedd_nariad"]==1)and(($is+1)==count($stack_users)))
				{
					$but_text='Утвержден';
				}
			   	if(($sign_adminx!=1)and($sign_levelx==2)and($row__2["signedd_nariad"]!=1))
				{
					$but_text='Согласовать';
				}
			   	if(($sign_adminx!=1)and($sign_levelx==2)and($row__2["signedd_nariad"]==1)and(($is+1)<count($stack_users)))
				{
					$but_text='Согласовать';
				}
			   	if($sign_levelx==3)
				{
					$but_text='Утвержден';
				}
			    
			   	$result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($stack_users[$is])).'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);
									  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}	
			      echo'<div sm="'.$stack_users[$is].'"  data-tooltip="'.$but_text.' - '.$rowxs["name_user"].'" class="user_soz n_yes send_mess">'.$online.avatar_img('<img src="img/users/',$stack_users[$is],'_100x100.jpg">').'</div>';
				}
		   }
		   
		   
	   }
	//если нет подписанных то выводит просто создателя наряда
	if(count($stack_users)==0)
	{
		$result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row__2["id_user"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		//такая работа есть
		$rowxs = mysqli_fetch_assoc($result_txs);
											  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}		
		echo'<div  sm="'.$row__2["id_user"].'"   data-tooltip="Создан - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row__2["id_user"],'_100x100.jpg">').'</div>';
	    }
	}
	
	if($row__2["signedd_nariad"]==1)
	{
	   //утвержден проведен
	   echo'<div data-tooltip="Утвержден" class="user_soz naryd_yes"></div>';	
	}
	
	
			//определяем есть ли в наряде служебные записки
		$slyjj=0;
		$slyjj=memo_count_nariad($link,$_GET["id"]);					
		//определяем есть ли подпись снизу
		$niz_podpis=-1;
		$niz_podpis=down_signature($sign_level,$sign_admin,$link,$_GET["id"]);
	
	//вывод статусов по наряду для пользователя
	if(($sign_level==1)and($sign_admin!=1))
	{
		if(($row__2["id_signed0"]!=0)and($row__2["id_signed1"]==0)and($row__2["signedd_nariad"]==0)and($slyjj==0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}
		if(($row__2["id_signed0"]!=0)and($row__2["id_signed1"]==0)and($row__2["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на согласование</div>';
		}		
		if(($row__2["id_signed1"]!=0)and($row__2["signedd_nariad"]==0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}	
		if(($row__2["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}	
	}
	if(($sign_level==2)and($sign_admin!=1))
	{	
        if(($row__2["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}
		
		if(($podpis==0)and($slyjj!=0)and($row__2["signedd_nariad"]==0))
		{
			echo'<div class="status_nana">Подписан на утверждение</div>';	
		}			
	}
	if(($sign_level==3)and($sign_admin!=1))
	{	
        if(($row__2["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}
	}
	
	if(($sign_admin==1))
	{
		if(($row__2["id_signed0"]!=0)and($row__2["id_signed1"]==0)and($row__2["signedd_nariad"]==0)and($slyjj==0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}
		if(($row__2["id_signed0"]!=0)and($row__2["id_signed1"]==0)and($row__2["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на согласование</div>';
		}
		if(($row__2["id_signed0"]!=0)and($row__2["id_signed1"]!=0)and($row__2["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}	
	
		if(($row__2["id_signed0"]==0)and($row__2["id_signed1"]!=0)and($row__2["signedd_nariad"]==0)and($slyjj!=0))
		{
			echo'<div class="status_nana">подписан на утверждение</div>';
		}			
		if(($row__2["signedd_nariad"]==1))
		{
			echo'<div class="status_nana">утвержден</div>';
		}		
	}						 
						 
						 
						 
						 echo'</td>
                  <td class="no_padding_left_ pre-wrap">';
			if (($role->permission('Исполнители','R'))or($sign_admin==1))
	        {	 
				  echo'<a href="implementer/'.$row__2["id_implementer"].'/"><span class="s_j">'.$row_t22["implementer"].'</span></a>';
			} else
			{
				echo'<span class="s_j">'.$row_t22["implementer"].'</span>';
			}
						 
				  echo'</td>';
/*
echo'<td class="pre-wrap"><span class="per">';

echo MaskDate($row__2["date_begin"]).' - '.MaskDate($row__2["date_end"]);						 

echo'</span></td>';
*/
echo'<td><span class="per1">';
						 
        $result_town=mysql_time_query($link,'select C.object_name,B.town,A.kvartal from i_kvartal as A,i_town as B,i_object as C where C.id_kvartal=A.id and A.id_town=B.id and C.id="'.$row__2["id_object"].'"');
        
		$num_results_custom_town = $result_town->num_rows;
        
		if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);
			echo($row_town["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')');
			echo '<br>'.MaskDate($row__2["date_begin"]).' - '.MaskDate($row__2["date_end"]);
		}
		
						 
					
 echo'</span></td>
<td><span class="s_j"><strong>'.rtrim(rtrim(number_format($row__2["summa_work"], 2, '.', ' '),'0'),'.').'</strong> / <span class="s_j">'.rtrim(rtrim(number_format($row__2["summa_material"], 2, '.', ' '),'0'),'.').'</span></td>';
/*						 
echo'<td><span class="s_j"><strong>'.rtrim(rtrim(number_format(($row__2["summa_work"]+$row__2["summa_material"]), 2, '.', ' '),'0'),'.').'</strong>';
if($edit_price==1)
{
  //выводим на сколько привышение если есть
	
}
						 
echo'</span></td>';
*/

 echo'<td>';
						 
$podpis=0;  //по умолчанию нельзя редактировать подписана свыше
if((sign_naryd_level($link,$id_user,$sign_level,$row__2["id"],$sign_admin)))
{
	$podpis=1;
}						 
if($podpis!=0)
{
						 echo'<div class="font-rank del_naryd"  id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div>';
}
						 
						 
						 
		if((($row__2["signedd_nariad"]==1))and(($role->permission('Печать наряда','R'))or($sign_admin==1)))
		{
		  echo'<a target="_blank" href="finery/print/'.$row__2["id"].'/" class="font-rank22"  id_rel="'.$row__2["id"].'"><span class="font-rank-inner">*</span></a>';	
		}
	
	echo'</td>		   
		   
		   </tr>';	  
						 
					 }
					  
echo'</tbody></table>'; 
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_1").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';	 
					  
					  
	  $count_pages=CountPage($sql_count,$link,$count_write);
	  if($count_pages>1)
	  {
		  if(isset($_GET["by"]))
		  {
			displayPageLink_new('finery/'.$_GET["by"].'/','finery/'.$_GET["by"].'/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);	  
		  } else
		  {
			  displayPageLink_new('finery/','finery/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
		  }
	    
	  }
					  
					  
 }
	  
?>

    <script>
$(document).ready(function(){
		
	
	var tabs = $('#tabs2017');
		
	
    //$('.tabs-content > div.tb', tabs).each(function(i){ if ( i != 0 ) { $(this).hide(0); }});
   
	
	
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
</div></div></div></div>
</div>
</div><script src="Js/rem.js" type="text/javascript"></script>

<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
</div>

</body></html>