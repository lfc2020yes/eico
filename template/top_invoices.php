<?php
/*

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
			 echo'<li class="tab active"><a id="'.$key.'" href="invoices/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
			 $title_key=$key;	
			} else
			{
				
				
			if($_GET[$var_get]==$menu_get[$key])	
			{			
			  echo'<li class="tab active"><a id="'.$key.'" href="invoices/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

			  $title_key=$key;	
			} else
			{
			echo'<li class="tab"><a  id="'.$key.'" href="invoices/'.$menu_url[$key].'">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>'; 	
			}
			}
			}
			}
	echo'<div class="slider"></div></ul></div>';
	
	
	
	if (($role->permission('Накладные','A'))or($sign_admin==1))
	{
   echo'<a href="invoices/add/" data-tooltip="добавить накладную" class="add_invoice"><i></i></a>';
	//echo'<div class="icon1 iconl"><i></i></div>';
	}
	
	
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




                    $mym=0;
                    // echo count($arr_tasks) ;
                    if(isset($_GET["tabs"]))
                    {
                        if($_GET["tabs"]==1) {$mym=2;}
                        if($_GET["tabs"]==2) {$mym=1;}
                    }

                    $tabs_menu_x = array("Новые", "История");
                    $tabs_menu_x_id = array("0", "2");
                    $tabs_menu_x_link = array("", ".tabs-2");
                    $tabs_menu_x_class = array("", "");
                    $tabs_menu_x_count = array($subor_cc[0],$subor_cc[1]);





                    for ($i=0; $i<count($tabs_menu_x); $i++)
                    {
                        if($i!=0)
                        {

                            if((isset($_GET['tabs']))and($_GET['tabs']==$tabs_menu_x_id[$i]))
                            {
                                echo'<a href="invoices/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg active '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].' <i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
                            } else
                            {
                                echo'<a href="invoices/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].' <i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
                            }

                        } else
                        {

                            if((!isset($_GET['tabs']))or($_GET['tabs']==$tabs_menu_x_id[$i]))
                            {
                                echo'<a href="invoices/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg active '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].'<i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
                            } else
                            {
                                echo'<a href="invoices/'.$tabs_menu_x_link[$i].'" class="tabsss_orgg '.$tabs_menu_x_class[$i].'" id="'.$tabs_menu_x_id[$i].'">'.$tabs_menu_x[$i].'<i class="ystal">('.$tabs_menu_x_count[$i].')</i></a>';
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

       // echo'<a data-tooltip="сохранить заявку" class="js-add-app add_clients yellow-style hide-mobile">Сохранить   →</a>';

        if (($role->permission('Накладные','A'))or($sign_admin==1))
        {
            echo'<a href="invoices/add/" data-tooltip="добавить накладную" class="add_clients yellow-style hide-mobile">Добавить →</a>';
            //echo'<div class="icon1 iconl"><i></i></div>';
        }


        ?>

        <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

    </div>


