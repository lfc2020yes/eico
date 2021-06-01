    <div class="menu_top"><div class="menu1 menu_jjs">
    
    
    
    
    <? 
    		
		

       $os3 = array( "любой", "не обработанные","согласованные","отмена","оплата");
	   $os_id3 = array("0", "2", "4","5","3");	
		
		$su_3=0;
		if (( isset($_COOKIE["bi_3"]))and(is_numeric($_COOKIE["bi_3"]))and(array_search($_COOKIE["bi_3"],$os_id3)!==false))
		{
			$su_3=$_COOKIE["bi_3"];
		}
		
		
		   echo'<div class="left_drop menu1_prime"><label>Статус</label><div class="select eddd"><a class="slct" list_number="t3" data_src="'.$os_id3[$su_3].'">'.$os3[array_search($_COOKIE["bi_3"], $os_id3)].'</a><ul class="drop">';
		   for ($i=0; $i<count($os3); $i++)
             {   
			   if($su_3==$os_id3[$i])
			   {
				   echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$os_id3[$i].'">'.$os3[$i].'</a></li>';
			   } else
			   {
				  echo'<li><a href="javascript:void(0);"  rel="'.$os_id3[$i].'">'.$os3[$i].'</a></li>'; 
			   }
			 
			 }
		   echo'</ul><input type="hidden" name="sort3" id="sortb3" value="'.$os3[$su_3].'"></div></div>'; 

   

		       $os4 = array( "краткий", "подробный");
	   $os_id4 = array("0", "1");	
		
		$su_4=0;
		if (( isset($_COOKIE["bi_4"]))and(is_numeric($_COOKIE["bi_4"]))and(array_search($_COOKIE["bi_4"],$os_id4)!==false))
		{
			$su_4=$_COOKIE["bi_4"];
		}
		
		
		   echo'<div class="left_drop menu1_prime"><label>Вид</label><div class="select eddd"><a class="slct" list_number="t4" data_src="'.$os_id4[$su_4].'">'.$os4[array_search($_COOKIE["bi_4"], $os_id4)].'</a><ul class="drop">';
		   for ($i=0; $i<count($os4); $i++)
             {   
			   if($su_4==$os_id4[$i])
			   {
				   echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$os_id4[$i].'">'.$os4[$i].'</a></li>';
			   } else
			   {
				  echo'<li><a href="javascript:void(0);"  rel="'.$os_id4[$i].'">'.$os4[$i].'</a></li>'; 
			   }
			 
			 }
		   echo'</ul><input type="hidden" name="sort4" id="sortb4" value="'.$os4[$su_4].'"></div></div>'; 
		
		
		
		echo'<a href="bill/" class="show_sort_supply"><i>Применить</i></a>';
		?>
		<div id="date_table" class="table_suply_x"></div>
		
<!--<div class="pad10" style="padding: 0;"><span class="bookingBox"></span></div>	-->	

	<?	
		/*
	echo'<div class="more_supply menu_click"></div>';
		
		$menu = array( "Добавить счет", "Очистить корзину");
	$menu_id = array("1", "2");	
	
	echo'<div class="menu_supply menu_su1"><ul class="drops no_active" data_src="0" style="right:-20px; top:10px;">';
		   for ($it=0; $it<count($menu); $it++)
             {   
				  echo'<li><a href="javascript:void(0);"  rel="'.$menu_id[$it].'">'.$menu[$it].'</a></li>'; 
			   
			 
			 }
	echo'</ul><input rel="x" type="hidden" name="vall" class="vall_basket" value="0"></div>';	
		
		
	echo'<span class="add_sss"></span>';	
	//echo'<a href="prime/'.$row_list["id_object"].'/add_a/'.$_GET['id'].'/" data-tooltip="добавить счет" class="add_score"><i class="score_plus"></i><i class="score_">1</i></a>';	
	
	echo'<div class="more_supply2 menu_click"></div>';
		
	$menu = array( "Сохранить текущий", "Закрыть текущий","Просмотр");
	$menu_id = array("1", "2","3");	
	
	echo'<div class="menu_supply menu_su1"><ul class="drops no_active" data_src="0" style="right:-40px; top:10px;">';
		   for ($it=0; $it<count($menu); $it++)
             {   
				  echo'<li><a href="javascript:void(0);"  rel="'.$menu_id[$it].'">'.$menu[$it].'</a></li>'; 
			   
			 
			 }
	echo'</ul><input rel="x" type="hidden" name="vall2" class="vall_basket2" value="0"></div>';	
	*/
		/*	
	if (( isset($_COOKIE["current_supply_".$id_user]))and(is_numeric($_COOKIE["current_supply_".$id_user])))
	{	
	//определяем текущий счет и количество материалов в нем
		$result_t_=mysql_time_query($link,'Select a.*,(select count(g.id) from z_doc_material_acc as g where g.id_acc=a.id ) as countss from z_acc as a where a.id="'.htmlspecialchars(trim($_COOKIE["current_supply_".$id_user])).'"');
        $num_results_t_ = $result_t_->num_rows;
        if($num_results_t_!=0)
        {	
	         
			$row_t_ = mysqli_fetch_assoc($result_t_);
	        $date_base__=explode("-",$row_t_["date"]);
			echo'<div class="current_score"><div class="score_cc">текущий счет <div class="number_score">№'.$row_t_["number"].' от '.$date_base__[2].'.'.$date_base__[1].'.'.$date_base__[0].'</div></div><i class="count_scire" data-tooltip="сохранить текущий счет"><i class="count_numb_score">'.$row_t_["countss"].'</i></i></div>';
			
        }
		
	} else
	{	
	echo'<div class="current_score"><div class="score_cc">текущий счет <div class="number_score"></div></div><i class="count_scire" data-tooltip="сохранить текущий счет"><i class="count_numb_score"></i></i></div>';
		
	}
		*/
			
     include_once $url_system.'module/notification.php';
		
	?>
   
    </div></div>
    