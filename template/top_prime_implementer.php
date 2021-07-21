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
			 echo'<li class="tab active"><a id="'.$key.'" href="cashbox/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
			 $title_key=$key;	
			} else
			{
				
				
			if($_GET[$var_get]==$menu_get[$key])	
			{			
			  echo'<li class="tab active"><a id="'.$key.'" href="cashbox/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

			  $title_key=$key;	
			} else
			{
			echo'<li class="tab"><a  id="'.$key.'" href="cashbox/'.$menu_url[$key].'">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>'; 	
			}
			}
			}
			}
	echo'<div class="slider"></div></ul></div>';

	
	
	    if (($role->permission('Исполнители','A'))or($sign_admin==1))
	{
    echo'<div data-tooltip="добавить исполнителя" class="icon1 icon4 add__ispoln"><i></i></div>';
	//echo'<div class="icon1 iconl"><i></i></div>';
	}
	

	//$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
     include_once $url_system.'module/notification.php';
	
	
	
?>
<!--
<div class="noti_block">
	<div class="title_noti">	
	<ul class="t_ul">
	  <li>Уведомления</li>
	  <li><i><span>3</span></i></li>
	</ul>
	</div>
	<div class="scro">
	
	<div class="block" rel_noti=""><div class="bb"></div>
	<div class="users"><img src="img/users/4_100x100.jpg"></div>
	<div class="text"><strong>Муромцев Е.В.</strong> создал новый <strong>наряд №45</strong>, по объекту -  дом №43 (Волгоград, 9й квартал)</div>
	<div class="ui"><div class="font-rank del_notif" data-tooltip="Удалить" id_rel="2"><span class="font-rank-inner">x</span></div></div>
	</div>
	
	<div class="block"><div class="bb"></div>
	<div class="users"><img src="img/users/5_100x100.jpg"></div>
	<div class="text"><strong>Муромцев Е.В.</strong> создал новый <strong>наряд №45</strong>, по объекту -  дом №43 (Волгоград, 9й квартал)</div>
	<div class="ui"><div class="font-rank del_notif" data-tooltip="Удалить" id_rel="1"><span class="font-rank-inner">x</span></div></div>
	</div>

			
	
	</div>
</div>
-->


</div>

</div>




*/
foreach ($menu_b as $key => $val) {
    if((($edit_price==1)and($menu_role_sign012[$key]==1))or(($menu_role_sign0[$key]==1)and($edit_price==0)))
    {

        $result_tcc=mysql_time_query($link,$menu_sql[$key]);
        $row__cc= mysqli_fetch_assoc($result_tcc);
        $count_n=$row__cc["kol"];

        if(($key==0)and(!isset($_GET[$var_get])))
        {
            //echo'<li class="tab active"><a id="'.$key.'" href="cashbox/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
            $title_key=$key;
        } else
        {


            if($_GET[$var_get]==$menu_get[$key])
            {
                //echo'<li class="tab active"><a id="'.$key.'" href="cashbox/'.$menu_url[$key].'" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

                $title_key=$key;
            } else
            {
                //echo'<li class="tab"><a  id="'.$key.'" href="cashbox/'.$menu_url[$key].'">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
            }
        }
    }
}

?>



<div class="menu-09  input-line" style="z-index:150;">
    <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
    <div class="menu-09-left">
        <a href="/" class="menu-09-global"></a><a onclick="history.back();" class="menu-09-prev"><i></i></a>


        <?

        echo'<span class="menu-09-pc-h" ><span >Исполнители</span >';

        echo'<span all="8" class="menu-09-count none" style="display: none;"></span>';

        echo'</span >';

        ?>


        <?

        ?>
    </div>
    <div class="menu-09-right tours-right-block">
        <?



        include_once $url_system.'module/notification.php';
        include_once $url_system.'module/users.php';


        if (($role->permission('Исполнители','A'))or($sign_admin==1))
        {

            echo'<a data-tooltip="добавить исполнителя" class="add__ispoln add_clients yellow-style hide-mobile">Добавить →</a>';
        }





        echo'</div>';




        ?>

        <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

    </div>
