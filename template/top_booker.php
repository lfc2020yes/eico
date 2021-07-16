<?php
/*
 ?>
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
			 echo'<li class="tab active"><a id="'.$key.'" href="booker/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
			 $title_key=$key;	
			} else
			{
				
				
			if($_GET[$var_get]==$menu_get[$key])	
			{			
			  echo'<li class="tab active"><a id="'.$key.'" href="booker/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

			  $title_key=$key;	
			} else
			{
			echo'<li class="tab"><a  id="'.$key.'" href="booker/'.$menu_url[$key].'">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>'; 	
			}
			}
			}
			}
	echo'<div class="slider"></div></ul></div>';
	
	 include_once $url_system.'module/notification.php';
?>
</div></div>
<?php
*/
?>

<div class="menu-09  input-line" style="z-index:150;">
    <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
    <div class="menu-09-left">
        <a href="/" class="menu-09-global"></a><a onclick="history.back();" class="menu-09-prev"><i></i></a>


        <div class="menu_client_w_org">
            <div class="mm_w">
                <ul class="tabs_hedi js-tabs-menuxx">
                    <?
                    include_once $url_system.'ilib/lib_interstroi.php';
                    include_once $url_system.'ilib/lib_edo.php';

                    $edo = new EDO($link,$id_user,false);
                    $subor_cc = array();
                    //невыполненные
                    $arr_tasks = $edo->my_tasks(1,'=0' ,'ORDER BY d.date_create DESC','LIMIT 0,10000', '3');
                    array_push($subor_cc,count($arr_tasks));

                    $mym=0;
                    // echo count($arr_tasks) ;
                    if(isset($_GET["tabs"]))
                    {
                        if($_GET["tabs"]==1) {$mym=2;}
                        if($_GET["tabs"]==2) {$mym=1;}
                    }
                    //выполненные все
                    $arr_tasks1 = $edo->my_tasks(1, '<>0','ORDER BY d.date_create DESC','LIMIT 0,10000', '3' );
                    // echo count($arr_document) ;
                    array_push($subor_cc,count($arr_tasks1));
                    //если у него нет своих заявок то выводить только задания и выполненные


                        $tabs_menu_x = array("К оплате", "Оплаченные");
                        $tabs_menu_x_id = array("0", "1");
                        $tabs_menu_x_link = array("", ".tabs-2");
                        $tabs_menu_x_class = array("", "");
                        $tabs_menu_x_count = array($subor_cc[0],$subor_cc[1]);





                    for ($i=0; $i<count($tabs_menu_x); $i++)
                    {
                        if($i!=0)
                        {

                            if((isset($_GET['tabs']))and($_GET['tabs']==$tabs_menu_x_id[$i]))
                            {
                                echo'<a href="booker/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg active '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].' <i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
                            } else
                            {
                                echo'<a href="booker/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].' <i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
                            }

                        } else
                        {

                            if((!isset($_GET['tabs']))or($_GET['tabs']==$tabs_menu_x_id[$i]))
                            {
                                echo'<a href="booker/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg active '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].'<i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
                            } else
                            {
                                echo'<a href="booker/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].'<i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
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



