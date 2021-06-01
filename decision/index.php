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



$menu_b=array("с.з. Наряды новые","Все с.з. нарядов","с.з. Заявки на материал новые","История с.з. Заявки на материал");
	
$menu_title=array("Несогласованные служебные записки по нарядам","Все служебные записки по нарядам","Несогласованные служебные записки по заявкам на материал","Согласованные служебные записки по заявкам на материал");	
	
$menu_get=array("finery_new","finery","app_new","app");
$menu_url=array("finery_new/","finery/","app_new/","app/");
$menu_role_sign0=array(0,0,0,0);
$menu_role_sign012=array(0,0,0,0);	
$menu_sql=array();
$menu_sql1=array();	

if(($role->permission('Заявки','S'))or($sign_admin==1))
{
	$menu_role_sign0[2]=1;
	$menu_role_sign0[3]=1;
	$menu_role_sign012[2]=1;
	$menu_role_sign012[3]=1;
}
if(($role->permission('Наряды','R'))or($sign_admin==1))
{
		$menu_role_sign0[1]=1;
	$menu_role_sign0[0]=1;
	$menu_role_sign012[0]=1;
	$menu_role_sign012[1]=1;
	
}
//на согласовании наряды
 array_push($menu_sql, 'select count(DISTINCT a.id) as kol from n_nariad as a,n_work as b,n_material as c where c.id_nwork=b.id and a.id=b.id_nariad and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') and ((not(b.memorandum="") and b.id_sign_mem=0 ) or(not(c.memorandum="") and c.id_sign_mem=0))');	

 array_push($menu_sql1, ' and ((not(b.memorandum="") and b.id_sign_mem=0 ) or(not(c.memorandum="") and c.id_sign_mem=0)) ');	

//история служебных по нарядам
 array_push($menu_sql, 'select count(DISTINCT a.id) as kol from n_nariad as a,n_work as b,n_material as c where c.id_nwork=b.id and a.id=b.id_nariad and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') and ((not(b.memorandum=""))or (not(c.memorandum="")))');	

 array_push($menu_sql1, ' and ((not(b.memorandum=""))or (not(c.memorandum=""))) ');	


//новые по заявкам
 array_push($menu_sql, 'select count(DISTINCT a.id) as kol from z_doc as a,z_doc_material as b where a.status=3 and a.id_object in('.implode(',', $hie->obj ).') and a.id=b.id_doc 
AND a.id_user in('.implode(',',$hie->user).') and not(b.memorandum="") and b.id_sign_mem=0');

 array_push($menu_sql1, ' and not(b.memorandum="") and b.id_sign_mem=0 ');	

//история по заявкам
 array_push($menu_sql, 'select count(DISTINCT a.id) as kol from z_doc as a,z_doc_material as b where a.id=b.id_doc and a.id_object in('.implode(',', $hie->obj ).') 
AND a.id_user in('.implode(',',$hie->user).') and not(b.memorandum="") and not(b.id_sign_mem=0)');

 array_push($menu_sql1, ' and not(b.memorandum="") and not(b.id_sign_mem=0) ');	


$var_get='by';	



$active_menu='decision';  // в каком меню


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
	   
	    if(($_GET["by"]=='finery')or($_GET["by"]=='finery_new'))
		{
	    $result_url=mysql_time_query($link,'select a.id from n_nariad as a,n_work as b where a.id=b.id_nariad and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') '.$menu_sql1[$found1].' '.limitPage('n_st',$count_write));
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} 
		}
	   	    if(($_GET["by"]=='app')or($_GET["by"]=='app_new'))
		{
	    $result_url=mysql_time_query($link,'select a.id from z_doc as a,z_doc_material as b where a.id=b.id_doc and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') '.$menu_sql1[$found1].' '.limitPage('n_st',$count_write));
        $num_results_custom_url = $result_url->num_rows;
        if(($num_results_custom_url==0)or($_GET["n_st"]==1))
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} 
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

if($error_header!=404){ SEO('decision','','','',$link); } else { SEO('0','','','',$link); }

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

	  include_once $url_system.'template/top_prime_decision.php';


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
if(($_GET["by"]=='finery')or($_GET["by"]=='finery_new'))	
{	  
  $result_t2=mysql_time_query($link,'Select DISTINCT a.* from n_nariad as a,n_work as b,n_material as c where c.id_nwork=b.id and a.id=b.id_nariad and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') '.$menu_sql1[$title_key].' order by a.date_make desc '.limitPage('n_st',$count_write));
} else
{
  $result_t2=mysql_time_query($link,'Select DISTINCT a.* from z_doc as a,z_doc_material as b where a.id=b.id_doc and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).') '.$menu_sql1[$title_key].' order by a.date_create desc '.limitPage('n_st',$count_write));	
}
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
	
					  
				  
if(($_GET["by"]=='finery')or($_GET["by"]=='finery_new'))	
{					  
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2"><thead>
		   <tr class="title_smeta"><th class="t_1">Номер</th><th class="t_1">Статус</th><th class="t_1">Исполнитель</th><th class="t_2 no_padding_left_">Объект/Период Наряда</th><th class="t_8">Итого работа/материал</th><th class="t_10"></th></tr></thead><tbody>';
} else
{
echo'<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_1" class="smeta2"><thead>
		   <tr class="title_smeta"><th class="t_1">Номер</th><th class="t_2 no_padding_left_">Объект</th><th class="t_1"></th><th class="t_1">Статус</th><th class="t_10"></th></tr></thead><tbody>';	
}
	       for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {
						 
if(($_GET["by"]=='finery')or($_GET["by"]=='finery_new'))	
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

	if($ksss!=0)
	{
	echo'<tr><td colspan="6" height="20px"></td></tr>';	
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
						 //echo'<div class="font-rank del_naryd"  id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div>';
}
						 
						 
						 
		if((($row__2["signedd_nariad"]==1))and(($role->permission('Печать наряда','R'))or($sign_admin==1)))
		{
		  echo'<a target="_blank" href="finery/print/'.$row__2["id"].'/" class="font-rank22"  id_rel="'.$row__2["id"].'"><span class="font-rank-inner">*</span></a>';	
		}
	
	echo'</td>		   
		   
		   </tr>';
	
	
	
		$result_work_zz=mysql_time_query($link,'Select a.* from n_work as a where a.id_nariad="'.$row__2["id"].'" order by a.id');
	//echo 'Select a.* from n_work as a where a.id_nariad="'.$row__2["id"].'" order by a.id';
        $num_results_work_zz = $result_work_zz->num_rows;
	    if($num_results_work_zz!=0)
	    {

	
	
		  $id_work=0;
			
		   for ($i=0; $i<$num_results_work_zz; $i++)
		   {
			   $row_work_zz = mysqli_fetch_assoc($result_work_zz);
			   if($row_work_zz["memorandum"]!='')
			   {
			   echo'<tr class="tr_dop_memo"><td><span class="zay_str">&#8594;</span></td><td>';
			   //$row_work_zz = mysqli_fetch_assoc($result_work_zz);
				

					echo'<div class="mat_memo_zay">';
					 



	 
					 
					 
					echo $row_work_zz["name_work"];
			   echo'</div><td><div class="mat_memo_zay">';
			   if($row_work_zz["count_units"]>$row_work_zz["count_units_razdel2"])
			   {
			     echo' <b data-tooltip="Max возможное значение">(MAX '.$row_work_zz["count_units_razdel2"].' '.$row_work_zz["units"].'</b> &#8594; <span data-tooltip="введенное значение" class="red_zat">'.$row_work_zz["count_units"].' '.$row_work_zz["units"].'</span>)';
			   } else
			   {
				 echo' <b data-tooltip="Max возможное значение">(MAX '.$row_work_zz["price_razdel2"].'руб.</b> &#8594; <span data-tooltip="введенное значение" class="red_zat">'.$row_work_zz["price"].'руб.</span>)';  
			   }
					
					echo'</div>';
					 
				 
				 
				 
			  echo'</td><td>'; 
	
	  //для прорабов и начальникам участка выводим просто статус служебных записок	
	  if(($row_work_zz["signedd_mem"]=='1')and($row_work_zz["id_sign_mem"]!=0))
	  {		
		echo'<span style="visibility:visible" class="edit_1_1"><i data-tooltip="Подписана руководством">S</i></span>';
		
	  }
					 
	  if(($row_work_zz["signedd_mem"]==0)and($row_work_zz["id_sign_mem"]!=0)and($row_work_zz["id_sign_mem"]!=''))
	  {		
		echo'<span style="visibility:visible" class="edit_1_1"><i style="color:#ff2828; font-size: 21px;" data-tooltip="Отказано руководством">5</i></span>';	
	  }	
			   
	  if($row_work_zz["id_sign_mem"]==0)
	  {	
		  echo'<div class="status_material2 status_z1000 memo_zay">НЕТ РЕШЕНИЯ</div>';
	  }
			   
	
echo'</td><td><div class="mat_memo_zay">РАБОТА</div></td><td></td></tr>';	
			   }
			   
		$result_work_zz1=mysql_time_query($link,'Select a.* from n_material as a where not(a.memorandum="") and a.id_nwork="'.$row_work_zz["id"].'" order by a.id');
        $num_results_work_zz1 = $result_work_zz1->num_rows;
	    if($num_results_work_zz1!=0)
	    {

	
	
		  $id_works=0;
			
		   for ($is=0; $is<$num_results_work_zz1; $is++)
		   {
			   echo'<tr class="tr_dop_memo"><td><span class="zay_str">&#8594;</span></td><td>';
			   $row_work_zz1 = mysqli_fetch_assoc($result_work_zz1);
				

					echo'<div class="mat_memo_zay">';
					 



	 
					 
					 
					echo $row_work_zz1["material"];
			   echo'</div><td><div class="mat_memo_zay">';
			   if($row_work_zz1["count_units"]>$row_work_zz1["count_units_material"])
			   {
			     echo'(<span data-tooltip="введенное значение" class="red_zat">'.$row_work_zz1["count_units"].' '.$row_work_zz1["units"].'</span>)';
			   } else
			   {
				 echo' <b data-tooltip="Нужное значение">('.$row_work_zz1["price_material"].'руб.</b> &#8594; <span data-tooltip="введенное значение" class="red_zat">'.$row_work_zz1["price"].'руб.</span>)';  
			   }
					
					echo'</div>';
					 
				 
				 
				 
			  echo'</td><td>'; 
	
	  //для прорабов и начальникам участка выводим просто статус служебных записок	
	  if(($row_work_zz1["signedd_mem"]=='1')and($row_work_zz1["id_sign_mem"]!=0))
	  {		
		echo'<span style="visibility:visible" class="edit_1_1"><i data-tooltip="Подписана руководством">S</i></span>';
		
	  }
					 
	  if(($row_work_zz1["signedd_mem"]==0)and($row_work_zz1["id_sign_mem"]!=0)and($row_work_zz1["id_sign_mem"]!=''))
	  {		
		echo'<span style="visibility:visible" class="edit_1_1"><i style="color:#ff2828; font-size: 21px;" data-tooltip="Отказано руководством">5</i></span>';	
	  }	
			   
	  if($row_work_zz1["id_sign_mem"]==0)
	  {	
		  echo'<div class="status_material2 status_z1000 memo_zay">НЕТ РЕШЕНИЯ</div>';
	  }
			   
	
echo'</td><td><div class="mat_memo_zay">МАТЕРИАЛ</div></td><td></td></tr>';	 
		   }
		}				   
			   
		   }
		
		
		
		}

	

	
						 
					 } else
{
	

						 
                       $row__2= mysqli_fetch_assoc($result_t2);
	
	
				$result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row__2["id_object"])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {
			$row_list1 = mysqli_fetch_assoc($result_url);
	
		}
	
        $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list1["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}	
	
	
                       //узнаем название 						 
				$result_t22=mysql_time_query($link,'Select a.implementer from i_implementer as a where a.id="'.$row__2["id_implementer"].'"');
                $num_results_t22 = $result_t22->num_rows;
	            if($num_results_t22!=0)
	            {
					$row_t22 = mysqli_fetch_assoc($result_t22);
                   // echo'<a class="musa" href="implementer/'.$row_t2["id"].'/"><span class="s_j">'.$row_t2["implementer"].'</span></a>';
				}
$cll='';
if($row_t22["status"]==10)
{
  $cll='whites';
}
	if($ksss!=0)
	{		
	echo'<tr><td colspan="6" height="20px"></td></tr>';	
	}			
	
echo'<tr class="nary n1n '.$cll.'" rel_id="'.$row__2["id"].'"><td class="middle_"><a href="app/'.$row__2["id"].'/">№'.$row__2["number"].'</a></td>';
	
echo'<td><span class="per1">';
						 
			echo($row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')');
						 
					
 echo'</span></td>	
	<td>';
	
	
	//только для необработаннх служебок
	if(($row__2["status"]==3))
	{
	//вывод ближайщей даты по доставке
					$result_t22=mysql_time_query($link,'SELECT MIN(a.date_delivery) AS mx  FROM z_doc_material AS a WHERE  a.id_doc="'.$row__2["id"].'"');
                $num_results_t22 = $result_t22->num_rows;
	            if($num_results_t22!=0)
	            {
					$row_t22 = mysqli_fetch_assoc($result_t22);					
					$actv122='';
					
			 		if((time_compare_step($row_t22['mx'].' 00:00:00',0,3)==0))
				    {
						   $actv122.=' reddecision ';
				    }  
					$date_graf3  = explode("-",$row_t22["mx"]);
			          $ddd=$date_graf3[2].'.'.$date_graf3[1].'.'.$date_graf3[0];
		
	                echo'<span data-tooltip="ближайшая дата доставки из заявки" class="date_end_dec '.$actv122.'">'.$ddd.'</span>';
					
				}
	}
	
	echo'</td>
	<td>';

			//выводим статус заявки 
	$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row__2["status"].'" and a.id_system=13');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	
   //$status_class=array("status_z1","Наряды","Служебные записки","Заявки на материалы","Касса","Исполнители");
	
	
	if($row__2["status"]==10)
	{
       echo'<div class="user_mat naryd_yes" style="margin-left:0px;"></div><div class="status_material1">'.$row_status["name_status"].'</div>';	
	} else
	{
		echo'<div class="status_material2 status_z'.$row__2["status"].' memo_zay">'.$row_status["name_status"].'</div>';	
	}
}
	 
						 
						 
						 
						 echo'</td>';
	
	
	
/*
echo'<td class="pre-wrap"><span class="per">';

echo MaskDate($row__2["date_begin"]).' - '.MaskDate($row__2["date_end"]);						 

echo'</span></td>';
*/

/*						 
echo'<td><span class="s_j"><strong>'.rtrim(rtrim(number_format(($row__2["summa_work"]+$row__2["summa_material"]), 2, '.', ' '),'0'),'.').'</strong>';
if($edit_price==1)
{
  //выводим на сколько привышение если есть
	
}
						 
echo'</span></td>';
*/

 echo'<td>';
						 
	
	echo'</td>		   
		   
		   </tr>';		

	


	$result_work_zz=mysql_time_query($link,'Select a.* from z_doc_material as a where not(a.memorandum="") and a.id_doc="'.$row__2["id"].'" order by a.id');
        $num_results_work_zz = $result_work_zz->num_rows;
	    if($num_results_work_zz!=0)
	    {

	
	
		  $id_work=0;
			
		   for ($i=0; $i<$num_results_work_zz; $i++)
		   {
			   echo'<tr class="tr_dop_memo"><td><span class="zay_str">&#8594;</span></td><td>';
			   $row_work_zz = mysqli_fetch_assoc($result_work_zz);
				
	             //проверим может вообще такого материала уже нет
			     $result_t1=mysql_time_query($link,'Select a.* from i_material as a where a.id="'.htmlspecialchars(trim($row_work_zz["id_i_material"])).'"');
                 $num_results_t1 = $result_t1->num_rows;
	             if($num_results_t1!=0)
	             {  
		            //такая работа есть
		            $row1ss = mysqli_fetch_assoc($result_t1);
					 
					echo'<div class="mat_memo_zay">';
					 



	 
					 
					 
					echo $row1ss["material"].'</div>';
					 
				 
				 
				 }
			  echo'</td>
			  
			  
			  
			  ';
			   
			 
echo'<td>';

			   
					 
				 $summ=0;
                 $ostatok=0;
                 $proc_view=0;	
				 $flag_history=0;
			    
					
		$result_t1=mysql_time_query($link,'Select a.* from i_material as a where a.id="'.htmlspecialchars(trim($row_work_zz["id_i_material"])).'"');
                 $num_results_t1 = $result_t1->num_rows;
	             if($num_results_t1!=0)
	             {  
		            //такая работа есть
		            $row1ss = mysqli_fetch_assoc($result_t1);
					 
					 		
	//только для необработаннх служебок
					 //echo($row__2["memorandum"]);
	if(( $row_work_zz["memorandum"]!='')and( $row_work_zz["id_sign_mem"]==0))
	{					
echo'<div class="mat_memo_zay">';
				  //определяем совхоза по объекту
	  $stock=new stock_user($link,$row1ss["id_object"]); 		 
		//***************************************************************************************************************************					
				 $z_stock_count_users=0;	//на складе на всех прорабах по этому объекту числится
				 if(($row1ss["id_stock"]!='')and($row1ss["id_stock"]!=0))
				 {	
					 $text_stock='';
					 if($stock->id_stock>0)
					 {
					 $text_stock=' and not(a.id_user="'.htmlspecialchars(trim($stock->id_stock)).'")';
					 }
				    $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE
a.id_object="'.$row_work_zz["id_object"].'" AND a.id_stock="'.$row1ss["id_stock"].'" '.$text_stock.'');
						             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					 {
					     $z_stock_count_users=$row1ss_["summ"];
					 }
				 }
				 
				 }
//***************************************************************************************************************************					
                $z_stock_count_sklad=0;	//на складе на каком то, где то по этому объекту числится
					$sklad_name='';
				
                if(($stock->id_stock>0)and($row1ss["id_stock"]!=0)and($row1ss["id_stock"]!=''))
				{
				   $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ,b.name_user FROM z_stock_material AS a,r_user as b WHERE a.id_user=b.id and 
a.id_user="'.htmlspecialchars(trim($stock->id_stock)).'"  AND a.id_stock="'.$row1ss["id_stock"].'"');
					/*echo('SELECT SUM(a.count_units) AS summ,b.name_user FROM z_stock_material AS a,r_user as b WHERE a.id_user=b.id and 
a.id_user="'.htmlspecialchars(trim($stock->id_stock)).'"  AND a.id_stock="'.$row1ss["id_stock"].'"'); */	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					 {
					     $z_stock_count_sklad=$row1ss_["summ"];
						 $sklad_name=$row1ss_["name_user"];
					 }
				 }
				}
					
					
//***************************************************************************************************************************		
                //вдруг он до этого сделал заявку и она в статусе не откланено и не сохранено
				$z_stock_count_doc=0;	 
				$result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_doc_material AS a WHERE a.id_object="'.$row1ss["id_object"].'" and  
a.id_i_material="'.$row_work_zz["id_i_material"].'"  AND a.status NOT IN ("1", "8", "10","3","5","4") and not(a.id_doc="'.$row_work_zz['id'].'") ');
					 	             	 
			     $num_results_t1_ = $result_t1_->num_rows;
	             if($num_results_t1_!=0)
	             {  
		              //такая работа есть
		              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					 if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					 {
					     $z_stock_count_doc=$row1ss_["summ"];
						 //$sklad_name=$row1ss_["name_user"];
					 }
				 }	 
					 
//***************************************************************************************************************************		
					 
					 $ostatok=$row1ss["count_units"]-$row1ss["count_realiz"]-$z_stock_count_users-$z_stock_count_doc;			   
					 
					 /*
					 echo $row1ss["count_units"].'<br>';
				 	echo $row1ss["count_realiz"].'<br>';		   
			   echo $z_stock_count_users.'<br>';
			   
			   echo $z_stock_count_doc.'<br>';
					 
					 */
			     echo' <b data-tooltip="Max возможное значение">(MAX '.$ostatok.' '.$row1ss["units"].'</b> &#8594; <span data-tooltip="введенное значение" class="red_zat">'.$row_work_zz["count_units"].' '.$row1ss["units"].'</span>)';
				 }
					echo'</div>';
			   
		   }
			  echo'</td>';
			  
			  
			  
			  echo'<td>'; 
	
	  //для прорабов и начальникам участка выводим просто статус служебных записок	
	  if(($row_work_zz["signedd_mem"]=='1')and($row_work_zz["id_sign_mem"]!=0))
	  {		
	
		$result_txsx=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row_work_zz["id_sign_mem"])).'"');
      
	    if($result_txsx->num_rows!=0)
	    {   
		//такая работа есть
		$rowxsx = mysqli_fetch_assoc($result_txsx);
			
		}
		  
		  
		echo'<span style="visibility:visible" class="edit_1_1"><i data-tooltip="Подписана - '.$rowxsx["name_user"].'">S</i></span>';
		
	  }
					 
	  if(($row_work_zz["signedd_mem"]==0)and($row_work_zz["id_sign_mem"]!=0)and($row_work_zz["id_sign_mem"]!=''))
	  {		
	
		  		$result_txsx=mysql_time_query($link,'Select a.id,a.name_user,a.timelast from r_user as a where a.id="'.htmlspecialchars(trim($row_work_zz["id_sign_mem"])).'"');
      
	    if($result_txsx->num_rows!=0)
	    {   
		//такая работа есть
		$rowxsx = mysqli_fetch_assoc($result_txsx);
			
		}
		  
		  
		echo'<span style="visibility:visible" class="edit_1_1"><i style="color:#ff2828; font-size: 21px;" data-tooltip="Отказано - '.$rowxsx["name_user"].'">5</i></span>';	
	  }	
			   
	  if($row_work_zz["id_sign_mem"]==0)
	  {	
		  echo'<div class="status_material2 status_z1000 memo_zay">НЕТ РЕШЕНИЯ</div>';
	  }
			   
	
echo'</td><td></td></tr>';	 
		   }
		}
	
	

	
}
					  
						 
					 }
echo'</tbody></table>'; 
					 echo'<script>
				  OLD(document).ready(function(){  OLD("#table_freez_1").freezeHeader({\'offset\' : \'67px\'}); });
				  </script>';	 
					  
					  
	  $count_pages=CountPage($sql_count,$link,$count_write);
	  if($count_pages>1)
	  {
		  if(isset($_GET["by"]))
		  {
			displayPageLink_new('decision/'.$_GET["by"].'/','decision/'.$_GET["by"].'/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);	  
		  } else
		  {
			  displayPageLink_new('decision/','decision/.page-',"", NumberPageActive('n_st'),$count_pages ,5,9,"journal_oo",1);
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

</div>
</div><script src="Js/rem.js" type="text/javascript"></script>

<div id="nprogress">
<div class="bar" role="bar" >
<div class="peg"></div>
</div>
</div>

</body></html>