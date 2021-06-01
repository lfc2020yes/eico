<div class="menu_top"><div class="menu1">
   <?  
    $id=0;	 
	$echo='';


	echo'<div rel_tabs="0" id="tabs2017"><ul class="tabs_hed">';
			foreach ($menu_b as $key => $val) {
			if((($edit_price==1)and($menu_role_sign012[$key]==1))or(($menu_role_sign0[$key]==1)and($edit_price==0)))
			{
				
			$result_tcc=mysql_time_query($link,$menu_sql[$key]);	  
            $row__cc= mysqli_fetch_assoc($result_tcc);		
			$count_n=$row__cc["kol"];	
			
			if(($count_n!=0)or($key==0))
			{
				
	        if(($key==0)and(!isset($_GET[$var_get])))
			{
			 echo'<li class="tab active"><a id="'.$key.'" href="app/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
			 $title_key=$key;	
			} else
			{
				
				
			if($_GET[$var_get]==$menu_get[$key])	
			{			
			  echo'<li class="tab active"><a id="'.$key.'" href="app/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

			  $title_key=$key;	
			} else
			{
			echo'<li class="tab"><a  id="'.$key.'" href="app/'.$menu_url[$key].'">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>'; 	
			}
			}
			
			}
			}
			}
	echo'<div class="slider"></div></ul></div>';

	 include_once $url_system.'module/notification.php';
?>
</div></div>