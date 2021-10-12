<div class="menu-09  input-line" style="z-index:150;">
    <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
    <div class="menu-09-left">
        <a href="/" class="menu-09-global"></a><a onclick="history.back();" class="menu-09-prev"><i></i></a>


        <div class="menu_client_w_org">
            <div class="mm_w">
                <ul class="tabs_hedi js-tabs-menuxx">
                    <?


                    //невыполненные
                    $arr_tasks = $edo->my_tasks(0, '=0' );

                    //echo(count($arr_tasks));
                    array_push($subor_cc,count($arr_tasks));

                    $mym=0;
                   // echo count($arr_tasks) ;
                    if(isset($_GET["tabs"]))
                    {
                        if($_GET["tabs"]==1) {$mym=1;}
                        if($_GET["tabs"]==2) {$mym=2;}
                    }
//выполненные все
                    $arr_tasks1 = $edo->my_tasks(0, '<>0' );
                    // echo count($arr_document) ;
                    //echo(count($arr_tasks1));

                    array_push($subor_cc,count($arr_tasks1));
                    //если у него нет своих заявок то выводить только задания и выполненные

                    if($menu_no_my!=0)
                    {
                        $tabs_menu_x = array("Ваши заявки", "Выполнить", "Исполнено");
                        $tabs_menu_x_id = array("0", "1", "2");
                        $tabs_menu_x_link = array("", ".tabs-1",".tabs-2");
                        $tabs_menu_x_class = array("", "", "");
                        $tabs_menu_x_count = array($subor_cc[0], $subor_cc[1],$subor_cc[2]);
                    } else
                    {
                        $tabs_menu_x = array("Выполнить", "Исполнено");
                        $tabs_menu_x_id = array("1", "2");
                        $tabs_menu_x_link = array(".tabs-1", ".tabs-2");
                        $tabs_menu_x_class = array("", "");
                        $tabs_menu_x_count = array($subor_cc[1],$subor_cc[2]);
                    }




                    for ($i=0; $i<count($tabs_menu_x); $i++)
                    {
                        if($i!=0)
                        {

                            if((isset($_GET['tabs']))and($_GET['tabs']==$tabs_menu_x_id[$i]))
                            {
                                echo'<a href="app/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg active '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].' <i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
                            } else
                            {
                                echo'<a href="app/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].' <i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
                            }

                        } else
                        {

                            if((!isset($_GET['tabs']))or($_GET['tabs']==$tabs_menu_x_id[$i]))
                            {
                                echo'<a href="app/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg active '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].'<i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
                            } else
                            {
                                echo'<a href="app/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].'<i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
                            }


                        }

                    }
                    ?>

                </ul>
            </div>
        </div>





    </div>
    <div class="menu-09-right tours-right-block">
        <?



        include_once $url_system.'module/notification.php';
        include_once $url_system.'module/users.php';

        echo'</div>';



        ?>

        <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

    </div>





