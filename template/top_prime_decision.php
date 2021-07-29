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
			 echo'<li class="tab active"><a id="'.$key.'" href="decision/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
			 $title_key=$key;	
			} else
			{
				
				
			if($_GET[$var_get]==$menu_get[$key])	
			{			
			  echo'<li class="tab active"><a id="'.$key.'" href="decision/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

			  $title_key=$key;	
			} else
			{
			echo'<li class="tab"><a  id="'.$key.'" href="decision/'.$menu_url[$key].'">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>'; 	
			}
			}
			}
			}
	echo'<div class="slider"></div></ul></div>';
	
	 include_once $url_system.'module/notification.php';
?>
</div></div>

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


                    $id=0;
                    $echo='';



                    foreach ($menu_b as $key => $val) {
                        if((($edit_price==1)and($menu_role_sign012[$key]==1))or(($menu_role_sign0[$key]==1)and($edit_price==0)))
                        {

                            $result_tcc=mysql_time_query($link,$menu_sql[$key]);
                            $row__cc= mysqli_fetch_assoc($result_tcc);
                            $count_n=$row__cc["kol"];

                            if(($key==0)and(!isset($_GET[$var_get])))
                            {
                                //echo'<li class="tab active"><a id="'.$key.'" href="finery/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

                                echo'<a href="decision/'.$menu_url[$key].'" class="tabsss_orgg active" id="'.$key.'">'.$menu_b[$key].' <i class="ystal">('.$count_n.')</i></a>';


                                $title_key=$key;
                            } else
                            {


                                if($_GET[$var_get]==$menu_get[$key])
                                {
                                    // echo'<li class="tab active"><a id="'.$key.'" href="finery/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

                                    echo'<a href="decision/'.$menu_url[$key].'" class="tabsss_orgg active" id="'.$key.'">'.$menu_b[$key].' <i class="ystal">('.$count_n.')</i></a>';


                                    $title_key=$key;
                                } else
                                {
                                    //echo'<li class="tab"><a  id="'.$key.'" href="finery/'.$menu_url[$key].'">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
                                    echo'<a href="decision/'.$menu_url[$key].'" class="tabsss_orgg" id="'.$key.'">'.$menu_b[$key].' <i class="ystal">('.$count_n.')</i></a>';

                                }
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


