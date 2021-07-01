<!--
<div class="menu_top" style="border-bottom:0; box-shadow: 0 20px 30px -30px rgba(0, 0, 0, 0.6);">
-->
  <?
/*
   echo'<h3 class="head_h" style=" margin-bottom:0px; float:left;">Оформление заявки на материалы<div></div></h3>';
	$D = explode('.', $_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);
	if(count($D)>0)
	{
echo'<div class="font-rank1"><span class="font-rank-inner1 basket_order">'.count($D).'</span></div>

<div class="save_button add_zay"><i>Сохранить</i></div>';	
if((isset($stack_error))and((count($stack_error)!=0)))
   {
	echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';
} else
   {
echo'<div class="error_text_add"></div>';	
}
	}
	*/
	?>
	

<!--

	</div>
-->




<div class="menu-09  input-line" style="z-index:150;">
    <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
    <div class="menu-09-left">
        <a href="/" class="menu-09-global"></a><a onclick="history.back();" class="menu-09-prev"><i></i></a>

        <?

        echo'<span class="menu-09-pc-h" ><span>Ваши Уведомления</span >';


        $result_t2=mysql_time_query($link,'select A.id from r_notification as A where A.id_user="'.htmlspecialchars(trim($id_user)).'"');
        $num_results_t2 = $result_t2->num_rows;

if($num_results_t2>0)
{
  echo'<span all="8" class="menu-09-count">'.$num_results_t2.'</span>';
}

    echo'</span >';

        ?>

    </div>
    <div class="menu-09-right tours-right-block">
        <?



        include_once $url_system.'module/notification.php';
        include_once $url_system.'module/users.php';

        echo'</div>';




        ?>

        <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

    </div>






