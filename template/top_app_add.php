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
        $D = explode('.', $_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);
        echo'<span class="menu-09-pc-h" ><span > Оформление заявки на материалы </span >';

if(count($D)>0)
{
  echo'<span all="8" class="menu-09-count">'.count($D).'</span>';
}

    echo'</span >';

        ?>

    </div>
    <div class="menu-09-right tours-right-block">
        <?



        include_once $url_system.'module/notification.php';
        include_once $url_system.'module/users.php';

        echo'</div>';


        if(count($D)>0) {
            echo'<a data-tooltip="сохранить заявку" class="js-add-app add_clients yellow-style hide-mobile">Сохранить   →</a>';
        }


        ?>

        <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

    </div>






