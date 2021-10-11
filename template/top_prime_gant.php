<?php
/*
?>
<div class="menu_top"><div class="menu1">
    
    
    <div class="close_prime_dom"><i></i></div><a class="close_prime_dom_a" href="prime/"></a>
    
    <?
    
       $result_t=mysql_time_query($link,'Select a.id,a.town from i_town as a order by a.id');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="left_drop menu1_prime"><label>Город</label><div class="select eddd"><a class="slct" data_src="'.$row_town["id_town"].'">'.$row_town["town"].'</a><ul class="drop">';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);
			    if((array_search($row_t["id"],$hie_town) !== false)or($sign_admin==1)) 
               {	 
			   if($row_t["id"]==$row_town["id_town"])
			   {
				   echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["town"].'</a></li>';
			   } else
			   {
				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["town"].'</a></li>'; 
			   }
			 }
			 }
		   echo'</ul><input type="hidden" name="city" id="city" value="'.$row_town["id_town"].'"></div></div>'; 
	   }
	

  $result_t=mysql_time_query($link,'Select a.id,a.kvartal from i_kvartal as a where a.id_town="'.$row_town["id_town"].'" order by a.id');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="left_drop menu2_prime"><label>Квартал</label><div class="select eddd"><a class="slct" data_src="'.$row_list["id_kvartal"].'">'.$row_town["kvartal"].'</a><ul class="drop">';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);
			   if((array_search($row_t["id"],$hie_kvartal) !== false)or($sign_admin==1)) 
               { 
			   if($row_t["id"]==$row_list["id_kvartal"])
			   {
				   echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["kvartal"].'</a></li>';
			   } else
			   {
				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["kvartal"].'</a></li>'; 
			   }
			 }
			 }
		   echo'</ul><input type="hidden"  name="kvartal" id="kvartal" value="'.$row_list["id_kvartal"].'"></div></div>'; 
	   }




  $result_t=mysql_time_query($link,'Select a.id,a.object_name from i_object as a where a.id_kvartal="'.$row_list["id_kvartal"].'" order by a.id');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   echo'<div class="left_drop menu3_prime"><label>Объект</label><div class="select eddd"><a class="slct" data_src="'.$row_list["id"].'">'.$row_list["object_name"].'</a><ul class="drop">';
		   for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);
			   $url_prime="prime/";
				 
	  
               if((array_search($row_t["id"],$hie_object) !== false)or($sign_admin==1)) 
               {
				//он может видеть этот объект 
				 
			   if($row_t["id"]==$row_list["id"])
			   {
				   echo'<li class="sel_active"><a href="'.$url_prime.$row_t["id"].'/"  rel="'.$row_t["id"].'">'.$row_t["object_name"].'</a></li>';
			   } else
			   {
				  echo'<li><a href="'.$url_prime.$row_t["id"].'/"  rel="'.$row_t["id"].'">'.$row_t["object_name"].'</a></li>'; 
			   }
			   }
				 
			 }
		   echo'</ul><input type="hidden"  name="dom" id="dom" value="'.$row_list["id"].'"></div></div>'; 
	   }	
    ?>
 <!--
 <div class="close_all_r">закрыть все</div>
<div data-tooltip="Удалить всю себестоимость" class="del_seb"></div>
<div data-tooltip="Добавить раздел" class="add_seb"></div>
   -->
   
   
    <span class="add_nnn"></span>
    
    <?
    if (($role->permission('Заявки','A'))or($sign_admin==1))
    {
    echo'<span class="add_mmm"></span>';
    }
    ?>
    <!--<a href="quit/" data-tooltip="выйти из системы" class="icon1"><i></i></a>-->
    <!--
    <div class="icon1 icon2"><i></i></div>
    <div class="icon1 icon3"><i></i></div>-->

    
    
    <?
		

		?>
    
    <!--<div data-tooltip="удалить всю себестоимость" class="icon1 icon5 del__seb"><i></i></div>-->
    <!--<div data-tooltip="загрузить из exel" class="icon1 icon6"><i></i></div>-->


   <div data-tooltip="поиск по себестоимости" class="icon1 icon3"><i></i></div>
   
      <div class="search_seb"><i>n</i><input name="search_text" id="search_text" class="input_f_s input_100 white_inp" autocomplete="off" value="" type="text"><div class="result_s"><span  class="se_next">C</span><span class="se_prev">D</span><div>найдено: <span class="s_ss">45</span></div></div></div>
      <?
	    if (($role->permission('Объект','U'))or($sign_admin==1))
	{
		echo'<div data-tooltip="настройки по дому" class="icon1 icon2"><i></i></div>';
	}	
		
   	if((array_search('summa_r1',$stack_td) === false) or($sign_admin==1))
	{	
    echo'<div '.$act_1.' data-tooltip="быстрый вывод итогов" class="icon1 icon17"><i></i></div>';
	}
		
		?>
   
    <div data-tooltip="закрыть все разделы" class="icon1 close_all_r"><i></i></div>
      
       <?
    if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	{
    echo'<div data-tooltip="добавить раздел" class="icon1 icon4 add__razdel"><i></i></div>';
	//echo'<div class="icon1 iconl"><i></i></div>';
	}
			
     include_once $url_system.'module/notification.php';
		
	?>
   
    </div></div>

*/
?>

























    <div class="menu-09  input-line" style="z-index:150;">
        <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
        <div class="menu-09-left">
            <a href="/" class="menu-09-global"></a><a href="prime/" class="js-close_prime_dom js-close_prime_dom_a menu-09-prev"><i></i></a>

            <?

            echo'<span class="menu-09-pc-h" ><span > '.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].') </span >';


            echo'</span >';

            ?>
            <span class="add_nnn"></span>

            <?
    ?>
        </div>
        <div class="menu-09-right tours-right-block">
            <?



            include_once $url_system.'module/notification.php';
            include_once $url_system.'module/users.php';

            ?>

           <div data-tooltip="поиск по себестоимости" class="icon1 icon1-xxx icon3"><i></i></div>

      <div class="search_seb"><i>n</i><input name="search_text" id="search_text" class="input_f_s input_100 white_inp" autocomplete="off" value="" type="text"><div class="result_s"><span  class="se_next">C</span><span class="se_prev">D</span><div>найдено: <span class="s_ss">45</span></div></div></div>
      <?


/*
		?>

            <div data-tooltip="закрыть все разделы" class="icon1 icon1-xxx close_all_r"><i></i></div>

            <?
*/
            echo'</div>';




            ?>

            <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

        </div>
