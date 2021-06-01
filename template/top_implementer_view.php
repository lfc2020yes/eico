    <div class="menu_top"><div class="menu1">
   <? 
   echo'<h3 class="head_h j_cash" style=" margin-bottom:0px; float:left; font-size:30px;">'.$row_list["implementer"].'<div></div></h3>';
?>
 <!--
 <div class="close_all_r">закрыть все</div>
<div data-tooltip="Удалить всю себестоимость" class="del_seb"></div>
<div data-tooltip="Добавить раздел" class="add_seb"></div>
   -->
   

    <!--<a href="quit/" data-tooltip="выйти из системы" class="icon1"><i></i></a>-->
    <!--
    <div class="icon1 icon2"><i></i></div>
    <div class="icon1 icon3"><i></i></div>-->
    <?

	
  if($row_list["summa_made"]>0)
  {
		 echo'<div class="pay_summ4">'.rtrim(rtrim(number_format($row_list["summa_made"], 2, '.', ' '),'0'),'.').'</div>';	
  }
    if($row_list["summa_paid"]>0)
  {		
	  echo'<div class="pay_summ3">'.rtrim(rtrim(number_format($row_list["summa_paid"], 2, '.', ' '),'0'),'.').'</div>';
  }
     if($row_list["summa_debt"]>0)
  { 
  echo'<div class="pay_summ2">'.rtrim(rtrim(number_format($row_list["summa_debt"], 2, '.', ' '),'0'),'.').'</div>';
  }
	  if (($role->permission('Исполнители','U'))or($sign_admin==1))
    {  
    
  echo'<div data-tooltip="Редактировать Исполнителя" class="icon1 icon2 imp_option"><i></i></div>';
	}
    if (($role->permission('Касса','R'))or($sign_admin==1))
    {
	  if($row_list["summa_debt"]>0)
	  {
		  if (($role->permission('Касса','A'))or($sign_admin==1))
{	
		  echo'<div class="pay_baks_top" data-tooltip="Выдать"  id_rel="'.$row_list["id"].'"><span class="pay22_top">₽</span></div>';
		  //echo'<div class="icon1 iconl"><i></i></div>';
}
	  }
		
		
	if (($role->permission('Аванс','R'))or($sign_admin==1)) 
	{
		
		  echo'<div class="pay_avans_top" data-tooltip="Выдать аванс"  id_avans="'.$row_list["id"].'"></div>';
		
	}	
	
		
		
	}		
	
     include_once $url_system.'module/notification.php';
		
		?>
    

   
    </div></div>