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
				
	        if(($key==0)and(!isset($_GET[$var_get])))
			{
			 echo'<li class="tab active"><a id="'.$key.'" href="finery/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
			 $title_key=$key;	
			} else
			{
				
				
			if($_GET[$var_get]==$menu_get[$key])	
			{			
			  echo'<li class="tab active"><a id="'.$key.'" href="finery/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

			  $title_key=$key;	
			} else
			{
			echo'<li class="tab"><a  id="'.$key.'" href="finery/'.$menu_url[$key].'">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>'; 	
			}
			}
			}
			}
	echo'<div class="slider"></div></ul></div>';
	/*
	<div rel_tabs="0" id="tabs2017"><ul class="tabs_hed"><li class="tab active"><a id="1" href="#prime-1" class="active">Ульяновск</a><span class="ripple rippleEffect" style="width: 129px; height: 129px;"></span></li><li class="tab"><a id="2" href="#prime-2">Волгоград</a></li><li class="tab"><a id="3" href="#prime-3">Калач на Дону</a></li><li class="tab"><a id="4" href="#prime-4">Уфа</a></li><div class="slider" style="left: 0px; width: 129px;"></div></ul></div>
	
	
echo'<div rel_tabs="0" id="tabs2017">';
   $result_t=mysql_time_query($link,'Select a.id,a.town from i_town as a order by a.id');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {	 
echo'<ul class="tabs_hed">';
     for ($ks=0; $ks<$num_results_t; $ks++)
     {     
       $row__ = mysqli_fetch_assoc($result_t);
       //echo'<li><a href="#tabs-'.$ks.'">'.$row__["year"].'</a></li>';
	   if($ks==0)
	   {
	      echo'<li class="tab active"><a id="'.$row__["id"].'" href="#prime-'.$row__["id"].'" class="active">'.$row__["town"].'</a></li>';
		   $id=$row__["id"];
	   } else
	   {
		  echo'<li class="tab"><a  id="'.$row__["id"].'" href="#prime-'.$row__["id"].'">'.$row__["town"].'</a></li>';  
	   }
		 
	   $echo.='<div  id="tabs_0-'.$row__["id"].'" class="tb">';
		 
	   $result_t1=mysql_time_query($link,'Select a.* from i_kvartal as a where a.id_town="'.$row__["id"].'" order by a.id');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {
		   
		   for ($kss=0; $kss<$num_results_t1; $kss++)
           {     
                  $row__1= mysqli_fetch_assoc($result_t1);
			      $echo.='<div kvartal="'.$row__1["id"].'" class="block_i active">';
			   
			      $echo.='<div class="top_bl"><h2><span class="s_j">'.$row__1["kvartal"].'</span></h2></div>';
			      $echo.='<div class="rls">';
			   
			   	   $result_t2=mysql_time_query($link,'Select a.* from i_object as a where a.id_kvartal="'.$row__1["id"].'" order by a.id');
                   $num_results_t2 = $result_t2->num_rows;
	              if($num_results_t2!=0)
	              {
		             
					  $echo.='<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_'.$ks.'_'.$kss.'" class="smeta"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_2 no_padding_left_">Наименование объекта</th><th class="t_3">Площать (м2)</th><th class="t_8">итого работа</th><th class="t_9">итого материал</th><th class="t_10">итого всего</th></tr></thead><tbody>';
		             for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                     {     
                       $row__2= mysqli_fetch_assoc($result_t2);
					   $echo.='<tr class="loader_tr"><td colspan="6"><div class="loaderr"><div class="teps" rel_w="70" style="width:0%"><div class="peg_div"><div><i class="peg"></i></div></div></div></div></td></tr>';
						
					   
					$echo.='<tr class=" n1n" rel_id="'.$row__2["id"].'"><td class="middle_"></td>
                  <td class="no_padding_left_ pre-wrap"><a class="musa" href="prime/'.$row__2["id"].'/"><span class="s_j">'.$row__2["object_name"].'</span></a></td>
<td class="pre-wrap">';

$echo.=$row__2["object_area"].' м2';						 

$echo.='</td>

<td><span class="s_j">'.rtrim(rtrim(number_format($row__2["total_r0"], 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row__2["total_m0"], 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(($row__2["total_r0"]+$row__2["total_m0"]), 2, '.', ' '),'0'),'.').'</span></td>
           </tr>';	 
						 
						 
						 
					 }	
					 $echo.='</tbody></table>'; 
					 $echo.='<script>
				  OLD(document).ready(function(){  OLD("#table_freez_'.$ks.'_'.$kss.'").freezeHeader({\'offset\' : \'67px\'}); });
				  </script>';
				     
				  }
			      $echo.='</div>';
			      $echo.='</div>';
			   
		   }
		   
	   } else
	   {
		   
		   		  $echo.='<div class="block_i active">';
			   
			      $echo.='<div class="top_bl"><h2>По этому городу не найдено объектов</h2></div></div>';
		   
	   }
	   $echo.='</div>'; 
		 
		 
		 
	 }
echo'<div class="slider"></div>';  
	 echo'</ul>';
   }
*/
//echo'</div>';	
	 include_once $url_system.'module/notification.php';
?>
</div></div>