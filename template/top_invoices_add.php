




<div class="menu-09  input-line" style="z-index:150;">
    <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
    <div class="menu-09-left">
        <a href="/" class="menu-09-global"></a><a href="invoices/" class="menu-09-prev"><i></i></a>

        <?
        //$D = explode('.', $_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);
        echo'<span class="menu-09-pc-h" ><span > Добавление новой накладной </span >';
/*
        if(count($D)>0)
        {
            echo'<span all="8" class="menu-09-count">'.count($D).'</span>';
        }
*/
        echo'</span >';

        ?>

    </div>
    <div class="menu-09-right tours-right-block">
        <?



        include_once $url_system.'module/notification.php';
        include_once $url_system.'module/users.php';

        echo'</div>';


        //if(count($D)>0) {
            echo'<a data-tooltip="сохранить заявку" class="add_invoicess add_clients yellow-style hide-mobile">Сохранить   →</a>';
       // }


        ?>

        <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

    </div>


	