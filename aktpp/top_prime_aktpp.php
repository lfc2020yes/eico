<?php
/*
<div class="menu_top"><div class="menu1">
   <?php  
    $id=0;	 
	$echo='';
	
	echo'<div rel_tabs="0" id="tabs2017"><ul class="tabs_hed">';
        $title_key=0;
        foreach ($menu_b as $key => $val) {    //строчное меню
            if((($edit_price==1)and($menu_role_sign012[$key]==1))or(($menu_role_sign0[$key]==1)and($edit_price==0)))
            {
                $result_tcc=mysql_time_query($link,$menu_sql[$key]);	  
                $row__cc= mysqli_fetch_assoc($result_tcc);		
                $count_n=$row__cc["kol"];	

                if(($key==0)and(!isset($by)))   //По умолчанию
                {
                    echo'<li class="tab active"><a id="'.$key.'" href="aktpp/'.$menu_get[$key].'/" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
                    $title_key=$key;	
                }   else {
                    if($by==$menu_get[$key])   //активное меню	
                    {			
                        echo'<li class="tab active"><a id="'.$key.'" href="aktpp/'.$menu_get[$key].'/" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';
                        $title_key=$key;	
                    }   else {                             // ПАССИВНОЕ меню
                        echo'<li class="tab"><a  id="'.$key.'" href="aktpp/'.$menu_get[$key].'/">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>'; 	
                    }
                }
            }
        }
	echo'<div class="slider"></div></ul></div>';


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

                    $title_key=0;
                    foreach ($menu_b as $key => $val) {    //строчное меню
                        if((($edit_price==1)and($menu_role_sign012[$key]==1))or(($menu_role_sign0[$key]==1)and($edit_price==0)))
                        {
                            $result_tcc=mysql_time_query($link,$menu_sql[$key]);
                            $row__cc= mysqli_fetch_assoc($result_tcc);
                            $count_n=$row__cc["kol"];

                            if(($key==0)and(!isset($by)))   //По умолчанию
                            {
                                echo'<a id="'.$key.'" href="aktpp/'.$menu_get[$key].'/" class="tabsss_orgg active">'.$menu_b[$key].'<i class="ystal">('.$count_n.')</i></a>';

                                $title_key=$key;
                            }   else {
                                if($by==$menu_get[$key])   //активное меню
                                {
                                    //echo'<li class="tab active"><a id="'.$key.'" href="aktpp/'.$menu_get[$key].'/" class="active">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

                                    echo'<a id="'.$key.'" href="aktpp/'.$menu_get[$key].'/" class="tabsss_orgg active">'.$menu_b[$key].'<i class="ystal">('.$count_n.')</i></a>';


                                    $title_key=$key;
                                }   else {                             // ПАССИВНОЕ меню
                                    //echo'<li class="tab"><a  id="'.$key.'" href="aktpp/'.$menu_get[$key].'/">'.$menu_b[$key].'<i>'.$count_n.'</i></a></li>';

                                    echo'<a id="'.$key.'" href="aktpp/'.$menu_get[$key].'/" class="tabsss_orgg ">'.$menu_b[$key].'<i class="ystal">('.$count_n.')</i></a>';


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


        if($title_key==3) {  // закладка mat  (корзина)
            /*     если ?id существует - это дополнение акта ПП
             *          найти номер акта и дату
             *          aktpp/make/&id 
             *     создать новый акт ПП
             */
            $id_edit=0; 
          if(($role->permission('Прием-Передача','A'))
        or  (($role->permission('Прием-Передача','U')) and (isset($_GET['id'])) and ($_GET['id']>0))       
                or($sign_admin==1)) {  
              
          }
            if (isset($_POST['id_akt']) && $_POST['id_akt']>0) { //это дополнение акта
                $id_edit=htmlspecialchars(trim($_POST['id_akt']));
                $sql="select * from z_act where id='$id_edit' and id0_user='$id_user'";
                $resE=mysql_time_query($link,$sql);
                if ($resE->num_rows>0) {
                    $rowE= mysqli_fetch_assoc($resE);
                    $dt='Редактировать Акт №'.$rowE['number'].' от '.$rowE['date'];
                    $sim='O';
                }
                unset($resE);
                
            } else { 
              //Создать акт из корзины
                $dt='Создать новый Акт на передачу';
                $sim='d';
            }
            if (count($arr)>0 && $arr[0]>0) { 
                $style='block';
                $cnt=count($arr);
            } else  { 
                $style='none';
                $cnt='';
            }
                
            
            if (($role->permission('Прием-Передача','U') and $id_edit>0)
             or ($role->permission('Прием-Передача','A') and $id_edit==0)     
             or $sign_admin==1 ) { 
                echo '<div class="add_akt" style="display:'.$style.';" id="make_akt" data-tooltip="'.$dt.'">'
                        .'<a href="aktpp/make/'.$id_edit.'/">'
                        .$sim.'<i style="transform: rotate(0deg) scale(1,1);">'
                        .$cnt.'</i></a>'.'</div>';
            }
        }


	//$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
        include_once $url_system.'module/notification.php';
        include_once $url_system.'module/users.php';


	
?>



</div>

</div>