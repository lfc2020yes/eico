    <div class="menu_top"><div class="menu1">
    
    <?
    echo'<h3 class="head_h" style=" margin-bottom:0px; float:left;"> Заявка на материал №'.$row_list1["number"].' <span class="edit_12" style="visibility:visible"><span class="icc">y</span> <strong>Добавление материалов</strong></span><div></div></h3>';

    ?>
 <!--
 <div class="close_all_r">закрыть все</div>
<div data-tooltip="Удалить всю себестоимость" class="del_seb"></div>
<div data-tooltip="Добавить раздел" class="add_seb"></div>
   -->
    <span class="add_nnn"></span>
    <!--<div class="font-rank11"><span class="font-rank-inner11 basket_order">1</span></div>-->
    <!--<a href="quit/" data-tooltip="выйти из системы" class="icon1"><i></i></a>-->
    <!--
    <div class="icon1 icon2"><i></i></div>
    <div class="icon1 icon3"><i></i></div>-->
    <?
    	   echo'<a href="app/plus/'.$_GET['add_a'].'/" style="float:right;" class="save_button add_zayy"><i>Сохранить</i></a>';
	   echo'<div style="float:right;" class="error_text"></div>';	
    ?>
    
    <div class="icon1 iconl"><i></i></div>
    
    <div data-tooltip="закрыть все разделы" class="icon1 close_all_r"><i></i></div>
    <?
    echo'<div '.$act_1.' data-tooltip="быстрый вывод итогов" class="icon1 icon17"><i></i></div>';
		?>
    <!--<div data-tooltip="удалить всю себестоимость" class="icon1 icon5 del__seb"><i></i></div>-->
    <!--<div data-tooltip="загрузить из exel" class="icon1 icon6"><i></i></div>-->
    <div class="search_seb"><i>n</i><input name="search_text" id="search_text" class="input_f_s input_100 white_inp" autocomplete="off" value="" type="text"><div class="result_s"><span  class="se_next">C</span><span class="se_prev">D</span><div>найдено: <span class="s_ss">45</span></div></div></div>
    <div data-tooltip="поиск по себестоимости" class="icon1 icon3"><i></i></div>
   
    </div></div>