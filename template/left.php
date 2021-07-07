<!--<div class="mobile"><i>V</i></div>-->

<div class="mobile">
    <div class="burger js-burger">
        <div class="burger__line-1 "></div>
        <div class="burger__line-2 "></div>
        <div class="burger__line-3 "></div>
    </div></div>

<div class="mobile1 burger_ok">
    <div class="burger js-burger">
        <div class="burger__line-1 "></div>
        <div class="burger__line-2 "></div>
        <div class="burger__line-3 "></div>
    </div></div>
<div class="mobile-nav">
    <span></span>
</div>


<div class="logo_2000">
    <a class="logo" href=""></a>
</div>

<div class="left_menu menu_flex scrollbar-inner">

    <!--<div class="logo_block"><a class="logo" href="">-->
<?php
/*
 $local='C:/OpenServer/domains/'.$local_host.'';


if($_SERVER['DOCUMENT_ROOT']!=$local)
{
          echo'<img src="image/logo.png">';
} else
    {
        echo'<img src="image/logo_local.png">';
    }
*/
?>

      <!--</a><div class="hide_left"></div></div>-->


  <div class="menu_x  inner-content scrollbar-dynamic">
 

<?
/*
if(isset($_SESSION['user_id']))
{
$result_uu=mysql_time_query($link,'select a.*,b.name_role from r_user as a,r_role as b where b.id=a.id_role and a.id="'.id_key_crypt_encrypt(htmlspecialchars(trim($_SESSION['user_id']))).'"');
   $num_results_uu = $result_uu->num_rows;

   if($num_results_uu!=0)
   {                 
	$row_uu = mysqli_fetch_assoc($result_uu);
   }
}

echo'<div class="users">';
	  $filename=$url_system.'img/users/'.$row_uu["id"].'_100x100.jpg';
if (file_exists($filename)) {	  

echo'<img src="img/users/'.$row_uu["id"].'_100x100.jpg">
<div class="users_rule" not="'.$row_uu["noti_key"].'">';
} else
{
//echo'<div class="users_rule" style="padding-left:22px;">';
	echo'<img src="img/users/0_100x100.jpg">
<div class="users_rule" not="'.$row_uu["noti_key"].'">';
}



echo'<i>'.$row_uu["name_role"].'</i>
<strong>'.$row_uu["name_user"].'</strong>';

?>
</div>

</div> 

<?
*/

$local='C:/OpenServer/domains/'.$local_host.'';


if($_SERVER['DOCUMENT_ROOT']!=$local)
{
    echo'<a class="link_suitt" href="">construction costs<br>monitoring</a>';
} else
{
    echo'<a class="link_suitt" href="">ccm local hay</a>';
}


$nav_text=array("Себестоимость","Наряды","Заявки","Касса","Исполнители","Накладные","Склад","Прием-Передача");
$nav_url=array("prime","finery","app","cashbox","implementer","invoices","stock","aktpp/res");						 
$found = array_search($active_menu,$nav_url);

?>

<ul class="nav">
<li class="line"><div></div></li>
<?
//уведомления
		 $result_t=mysql_time_query($link,'Select count(a.id) as cc from r_notification as a where a.status=1 and a.id_user="'.htmlspecialchars(trim($id_user)).'"');
         $num_results_t = $result_t->num_rows;
	     if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
			 if($row_t["cc"]!=0)
			 {
			 
echo'<li class="not_li"><a class="a11" href="notification/">Уведомления<i>'.$row_t["cc"].'</i></a></li>';
			 } else
			 {
echo'<li class="not_li" style=""><a class="a11" href="notification/">Уведомления<i style="display:none;"></i></a></li>';
			 }
		 } else 
		 {
echo'<li class="not_li" style=""><a class="a11" href="notification/">Уведомления<i style="display:none;"></i></a></li>';
		 }
	
	
	
//счета на материалы
	  if (($role->permission('Счета','R'))or($sign_admin==1))
	  {	
			$actt1='';
if($active_menu=='bill')
{
	$actt1='actives';
} 		  
	
//определяем кол-во счетов на согласовании которые		  
		   $new_zay=0;
		   $result_t=mysql_time_query($link,'SELECT count(b.id) AS kol FROM z_acc AS b WHERE b.status=2');
	if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
			 $new_zay=$new_zay+$row_t["kol"];
			 
		 }	
		  
		  
		  if($new_zay!=0)
			 {	 
                 echo'<li class=" '.$actt1.'"><a class="a11" href="bill/">Счета</a><i>'.$new_zay.'</i></li>';
			 } else
			 {
				 echo'<li class=" '.$actt1.'" ><a class="a11" href="bill/">Счета</a></li>';
			 } 
		  
		  
	  }
	
	
	
//служебные записки	
	
	$rt=0;
	  $new_zay=0;
	if (($role->permission('Служебные записки','R'))or($role->permission('Заявки','S'))or($sign_admin==1))
	  {	
//echo("!!!");
		  $rt=1;
		  
$actt1='';
if($active_menu=='decision')
{
	$actt1='actives';
} 
		  
   $result_t=mysql_time_query($link,'select count(DISTINCT a.id) as kol from z_doc as a,z_doc_material as b where a.status=3 and a.id_object in('.implode(',', $hie->obj ).') and a.id=b.id_doc 
AND a.id_user in('.implode(',',$hie->user).') and not(b.memorandum="") and b.id_sign_mem=0');

	if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
			 $new_zay=$new_zay+$row_t["kol"];
			 if($row_t["kol"]!=0)
			 {
				 $rt_url='app_new';
			 }
		 }		  
		  
	  }
	
//	if (($role->permission('Служебные записки','R'))or($role->permission('Наряды','R'))or($sign_admin==1))
	if (($role->permission('Служебные записки','R'))or($sign_admin==1))
	  {	
//echo("!!!");
		  
		  $rt=1;
		  
$actt1='';
if($active_menu=='decision')
{
	$actt1='actives';
} 

		
		   $result_t=mysql_time_query($link,'select count(DISTINCT a.id) as kol from n_nariad as a,n_work as b,n_material as c where c.id_nwork=b.id and a.id=b.id_nariad and a.id_object in('.implode(',', $hie->obj ).')
AND a.id_user in('.implode(',',$hie->user).')  and ((not(b.memorandum="") and b.id_sign_mem=0 ) or(not(c.memorandum="") and c.id_sign_mem=0))');
	if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
			 $new_zay=$new_zay+$row_t["kol"];
			 			 if($row_t["kol"]!=0)
			 {
				 $rt_url='finery_new';
			 }
		 }

	  }	
	
	
	if($rt!=0)
	{
			  if($new_zay!=0)
			 {				 
                 echo'<li class="a11 '.$actt1.'"><a href="decision/'.$rt_url.'/">Служебные записки</a><i>'.$new_zay.'</i></li>';
			 } else
			 {
	
				 echo'<li class="a11 '.$actt1.'" style="display:none;"><a href="decision/'.$rt_url.'/">Служебные записки</a><i></i></li>';
			 }
	}
	
//снабжение	
	if((($role->permission('Снабжение','R')))or($sign_admin==1))
	{
					$actt2='';
if($active_menu=='supply')
{
	$actt2='actives';
} 
		echo'<li class=" '.$actt2.'"><a class="a11" href="supply/">Снабжение</a></li>';
	}

//бухгалтерия	
	
	
	
$result_t=mysql_time_query($link,'Select count(DISTINCT b.id) as kol from z_acc as b where  b.status=3 ');	
$num_results_t = $result_t->num_rows;	
$new_zay=0;
if($num_results_t!=0)
{				 
			 $row_t = mysqli_fetch_assoc($result_t);
			 $new_zay=$new_zay+$row_t["kol"];		 
}
	
	
	
	if((($role->permission('Бухгалтерия','R')))or($sign_admin==1))
	{
					$actt2='';
if($active_menu=='booker')
{
	$actt2='actives';
} 
		if($new_zay==0)
		{
		echo'<li class=" '.$actt2.'"><a class="a11" href="booker/">бухгалтерия</a></li>';
		} else
		{
		echo'<li class=" '.$actt2.'"><a class="a11" href="booker/">бухгалтерия</a><i>'.$new_zay.'</i></li>';
		}
	}	
	
?>
<?	
    foreach ($nav_url as $key_nav => $value_nav) 
	{
	  if (($role->permission($nav_text[$key_nav],'R'))or($sign_admin==1))
	  {

	     if($value_nav=='app')
         {
//по заявкам смотрим и выводим если есть сколько надо выполнить задач
             if (!is_object($edo)) {

                 include_once $url_system.'ilib/lib_interstroi.php';
                 include_once $url_system.'ilib/lib_edo.php';
                 $edo = new EDO($link, $id_user, false);

             }
             $arr_tasks = $edo->my_tasks(0, '=0' );
             $class_left_l='';
             $count_l=count($arr_tasks);
if(count($arr_tasks)==0)
{
    $class_left_l='nonex';
    $count_l='';
}

             if ($found === $key_nav) {
                 echo '<li class="actives"><a class="a11" href="' . $value_nav . '/">' . $nav_text[$key_nav] . '<i class="'.$class_left_l.'">'.$count_l.'</i></a></li>';
             } else {
                 echo '<li><a class="a11" href="' . $value_nav . '/">' . $nav_text[$key_nav] . '<i class="'.$class_left_l.'">'.$count_l.'</i></a></li>';
             }


         } else {

             if ($found === $key_nav) {
                 echo '<li class="actives"><a class="a11" href="' . $value_nav . '/">' . $nav_text[$key_nav] . '</a></li>';
             } else {
                 echo '<li><a class="a11" href="' . $value_nav . '/">' . $nav_text[$key_nav] . '</a></li>';
             }
         }
	  }
	}
	
	
//сообщения
	$actt='';
if($active_menu=='message')
{
	$actt='actives';
}
	
$result_t=mysql_time_query($link,'Select count(a.id) as cc from r_message as a where a.status=1 and a.id_user="'.htmlspecialchars(trim($id_user)).'"');
         $num_results_t = $result_t->num_rows;
	     if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
			 if($row_t["cc"]!=0)
			 {
			 
echo'<li class="mess_li '.$actt.'"><a class="a11" href="message/">Сообщения<i>'.$row_t["cc"].'</i></a></li>';
			 } else
			 {
echo'<li class="mess_li '.$actt.'"><a class="a11" href="message/">Сообщения<i style="display:none;"></i></a></li>';
			 }
		 }	
	
?>	
	<!--
 <li class="actives"><a href="prime/">Себестоимость</a></li>
  <li><a href="finery/">Наряды</a></li>
    <li><a href="memorandum/">Служебные записки</a><i>25</i></li>
-->
	<!--
     <li><a href="">Финансирование</a></li>
      <li><a href="">Претензии</a><i>1</i></li>
       <li><a href="">Команда</a></li>
-->
        <li class="line"><div></div></li>
	<!--
         <li><a href="">Безопасность</a></li>
-->
          <li><a class="a11" href="quit/">Выход</a></li>
 <?         
	
	   $result_t56=mysql_time_query($link,'Select a.id,a.name_user from r_user as a,r_role as b where a.id_role=b.id and b.name_role="admin" and a.id="'.id_key_crypt_encrypt(htmlspecialchars(trim($_SESSION['user_id']))).'"');
         $num_results_t56 = $result_t56->num_rows;
	     if($num_results_t56==0)
	     {				 
		
	
   $result_t56=mysql_time_query($link,'Select a.id,a.name_user from r_user as a,r_role as b where a.id_role=b.id and b.name_role="admin"');
         $num_results_t56 = $result_t56->num_rows;
	     if($num_results_t56!=0)
	     {				 
		   $row_t56 = mysqli_fetch_assoc($result_t56);       
          
           echo'<li class="help_user"><a class="a11" href="javascript:void(0)" sm="'.$row_t56["id"].'"  data-tooltip="Написать Администратору" class="send_mess">Помощь</a></li>';
			 
		 }
		 }
?>

</ul>


  
  </div>
</div>


<!--<div class="w_size debug"></div>-->
