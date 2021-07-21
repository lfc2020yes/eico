<?php
/*

<div class="menu_top"><div class="menu1 menu_jjs">
    
    
    
    
    <? 
       $os = array("по алфавиту", "по количеству");
	   $os_id = array("0", "1");	
		
		$su_1=0;
		if (( isset($_COOKIE["su_st_1"]))and(is_numeric($_COOKIE["su_st_1"]))and(array_search($_COOKIE["su_st_1"],$os_id)!==false))
		{
			$su_1=$_COOKIE["su_st_1"];
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
		   echo'</ul><input type="hidden" name="sort_stock1" id="sort_stock1" value="'.$os[$su_1].'"></div></div>'; 
	 
		
		
		
		
		
		

		
		
		$su_4=0;
		$su4_name='Любой';
		if (( isset($_COOKIE["su_st_4"]))and(is_numeric($_COOKIE["su_st_4"]))and($_COOKIE["su_st_4"]!=0))
		{
			$su_4=$_COOKIE["su_st_4"];
			
		    $result_url1=mysql_time_query($link,'select A.name from z_stock_group as A where A.id="'.htmlspecialchars(trim($_COOKIE["su_st_4"])).'"');
            $num_results_custom_url1 = $result_url1->num_rows;
            if($num_results_custom_url1!=0)
            {
			    $row_list11 = mysqli_fetch_assoc($result_url1);
				$su4_name=$row_list11["name"];
		    }				
			
		}
		
		
	 $result_t=mysql_time_query($link,'Select a.* from z_stock_group as a order by a.name');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {	
		   $active_id=0;
		   echo'<div class="left_drop menu1_prime"><label>Тип</label><div class="select eddd"><a class="slct" list_number="t4" data_src="'.$su_4.'">'.$su4_name.'</a><ul class="drop">';
		echo'<li><a href="javascript:void(0);"  rel="0">Любой</a></li>'; 
		for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);
			   if($su_4==$row_t["id"])
			   {
				   echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>';
			   } else
			   {
				  echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["name"].'</a></li>'; 
			   }
			 
			 }
		   echo'</ul><input type="hidden" name="sort_stock4" id="sort_stock4" value="'.$su_4.'"></div></div>'; 
		
	   }
		
		
		
		
		
		
		
		
		
		
		
	$su_5=0;
		$su5_name='Любой';
		if (( isset($_COOKIE["su_st_3"]))and(is_numeric($_COOKIE["su_st_3"]))and($_COOKIE["su_st_3"]!=0)and((array_search($_COOKIE["su_st_3"],$hie_object) !== false)or($sign_admin==1)))
		{		
			$su_5=$_COOKIE["su_st_3"];
			
		    $result_url1=mysql_time_query($link,'Select a.id,a.object_name from i_object as a where a.id="'.htmlspecialchars(trim($_COOKIE["su_st_3"])).'"');
            $num_results_custom_url1 = $result_url1->num_rows;
            if($num_results_custom_url1!=0)
            {
			    $row_list11 = mysqli_fetch_assoc($result_url1);
				$su5_name=$row_list11["object_name"];
		    }				
			
		}
		
		
	 $result_t=mysql_time_query($link,'Select a.id,a.object_name,a.id_town from i_object as a where a.enable=1 order by a.id');
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {	
		   $active_id=0;
		   echo'<div class="left_drop menu1_prime"><label>Объект</label><div class="select eddd"><a class="slct" list_number="t4" data_src="'.$su_4.'">'.$su5_name.'</a><ul class="drop">';
		echo'<li><a href="javascript:void(0);"  rel="0">Любой</a></li>'; 
		for ($i=0; $i<$num_results_t; $i++)
             {  
               $row_t = mysqli_fetch_assoc($result_t);
				 
			  if((array_search($row_t["id"],$hie_object) !== false)or($sign_admin==1)) 
              {
				  
				 $result_town=mysql_time_query($link,'select B.* from i_town as B where B.id="'.$row_t["id_town"].'"');
	
                 $num_results_custom_town = $result_town->num_rows;
                 if($num_results_custom_town!=0)
                 {
		         	$row_town = mysqli_fetch_assoc($result_town);	
		         }
 
				  
			     if($su_5==$row_t["id"])
			     {
				   echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["object_name"].' ('.$row_town["town"].')</a></li>';
			     } else
			     {
				   echo'<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["object_name"].' ('.$row_town["town"].')</a></li>'; 
			     }
			  }
			 
			 }
		   echo'</ul><input type="hidden" name="sort_stock3" id="sort_stock3" value="'.$su_5.'"></div></div>'; 
		
	   }	
		
		
		
		
		
		
		
			echo'<div class="left_drop menu1_prime"><label>Поиск по названию</label><div class="select eddd">
		   
		   <input name="sort_stock2" id="name_stock_search" class="name_stock_search_input" autocomplete="off" value="'.$_COOKIE["su_st_2"].'" type="text">';
		   if (( isset($_COOKIE["su_st_2"]))and($_COOKIE["su_st_2"]!=''))
		   {
		   echo'<div style="display:block;" class="dell_stock_search" data-tooltip="Удалить"><span>x</span></div>';
		   } else
		   {
			 echo'<div  class="dell_stock_search" data-tooltip="Удалить"><span>x</span></div>';  
		   }
		   echo'</div></div>'; 		
			
		
		
		echo'<a href="stock/" class="show_sort_stock"><i>Применить</i></a>';
		
		
	
		

		

	
	if (($role->permission('Склад','A'))or($sign_admin==1))
	{
      echo'<div data-tooltip="добавить наименование" class="add_invoice1"><i></i></div>';
	//echo'<div class="icon1 iconl"><i></i></div>';
	}	
		
	
		echo'<div data-tooltip="Печатать" class="print_stock_"><i></i></div>';		
		
		
		
     include_once $url_system.'module/notification.php';
		
	?>
   
    </div></div>


















*/
?>






    <div class="menu-09  input-line" style="z-index:150;">
        <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
        <div class="menu-09-left">
            <a href="/" class="menu-09-global"></a><a onclick="history.back();" class="menu-09-prev"><i></i></a>


            <?

            echo'<span class="menu-09-pc-h" ><span >Склад</span >';

            echo'<span all="8" class="menu-09-count none" style="display: none;"></span>';

            echo'</span >';

            ?>


            <?

            ?>
        </div>
        <div class="menu-09-right tours-right-block">
            <?



            include_once $url_system.'module/notification.php';
            include_once $url_system.'module/users.php';

            echo'<a data-tooltip="Печатать" class="js-print-stock add_clients ser-style hide-mobile">Печать →</a>';


            if (($role->permission('Склад','A'))or($sign_admin==1))
            {
               // echo'<div data-tooltip="добавить наименование" class="add_invoice1"><i></i></div>';
                //echo'<div class="icon1 iconl"><i></i></div>';
                echo'<a data-tooltip="добавить наименование" class="js-add-stock add_clients yellow-style hide-mobile">Добавить →</a>';
            }





            echo'</div>';




            ?>

            <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

        </div>
