<?
//узнаем есть ли меморандум у материалов этой заявки
 
$count_image=0;
$result_scores=mysql_time_query($link,'Select count(a.id) as cc from image_attach as a where a.id_object="'.htmlspecialchars(trim($_GET['id'])).'" and a.for_what="9" and a.visible=1');
$num_results_scores = $result_scores->num_rows;
if($num_results_scores!=0)
{	  
  $row_scores = mysqli_fetch_assoc($result_scores);
  $count_image=$row_scores["cc"];
}

//узнаем сколько материалов забито по накладной
$count_material=0;
$result_scores=mysql_time_query($link,'Select count(a.id) as cc from z_invoice_material as a where a.id_invoice="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_scores = $result_scores->num_rows;
if($num_results_scores!=0)
{	  
  $row_scores = mysqli_fetch_assoc($result_scores);
  $count_material=$row_scores["cc"];
}
if((isset($_GET["prime"]))and(( isset($_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['prime']))]))and($_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['prime']))]!=''))) {


    $D = explode('.', $_COOKIE["basket1_" . $id_user . "_" . htmlspecialchars(trim($_GET['prime']))]);
if(count($D )!=0)
{
    $count_material=$count_material+count($D );
}
}

//есть ли материалы в кторых не заполнены обе цены
$count_no_price=0;
$result_scores=mysql_time_query($link,'Select count(a.id) as cc from z_invoice_material as a where a.id_invoice="'.htmlspecialchars(trim($_GET['id'])).'" and a.price=0 and a.price_nds=0 and a.mild=0');
$num_results_scores = $result_scores->num_rows;
if($num_results_scores!=0)
{	  
  $row_scores = mysqli_fetch_assoc($result_scores);
  $count_no_price=$row_scores["cc"];
}

/*
?>
 
 <div class="menu_top" style="border-bottom:0; box-shadow: 0 20px 30px -30px rgba(0, 0, 0, 0.6);"><div class="menu1">
  <?
   echo'<h3 class="head_h" style=" margin-bottom:0px; float:left;"> Накладная №'.$row_list["number"].'<div></div></h3>';
	
	//выводим создателя заявки

				   $result_txs=mysql_time_query($link,'Select a.name_user,a.timelast,a.id from r_user as a where a.id="'.$row_list["id_user"].'"');
	            if($result_txs->num_rows!=0)
	            {   
		          $rowxs = mysqli_fetch_assoc($result_txs);
									  $online='';	
				  if(online_user($rowxs["timelast"],$rowxs["id"],$id_user)) { $online='<div class="online"></div>';}	
					
			   echo'<div sm="'.$row_list["id_user"].'"  data-tooltip="Создал - '.$rowxs["name_user"].'" class="user_soz send_mess">'.$online.avatar_img('<img src="img/users/',$row_list["id_user"],'_100x100.jpg">').'</div>';
				} 
	 
	 	 
	 
		//выводим статус заявки 
	$result_status=mysql_time_query($link,'SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row_list["status"].'" and a.id_system=17');	
					 //echo('SELECT a.* FROM r_status AS a WHERE a.numer_status="'.$row1ss["status"].'" and a.id_system=13');
if($result_status->num_rows!=0)
{  
   $row_status = mysqli_fetch_assoc($result_status);
	
   //$status_class=array("status_z1","Наряды","Служебные записки","Заявки на материалы","Касса","Исполнители");
	
	
	if($row_list["status"]==3)
	{
       echo'<div class="user_mat naryd_yes" style="margin-top: 15px;"></div><div class="status_material1" style="margin-top: 26px;">'.$row_status["name_status"].'</div>';	
	} else
	{
		echo'<div class="status_material2 status_z'.$row_list["status"].'">'.$row_status["name_status"].'</div>';	
	}
}
	 
	 
	 
	 

	

	
//КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ КНОПКИ
		
		

		
		
		//заказать
		if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1))and($row_list["ready"]==1)and($count_image!=0)and($count_material!=0)and($count_no_price==0))
		{
	
		   echo'<form id="lalala_pod_form" action="invoices/take/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'take_invoices_2018',$secret).'" type="hidden">
</form>';	
           echo'<div class="save_button pod_zay transfer_invoicess" data-tooltip="Принять на склад"><i>Принять</i></div><div style="display:none;" class="save_button add_invoicess1"><i>Сохранить</i></div>';
	 	   if((isset($stack_error))and((count($stack_error)!=0)))
           {	
		      echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';	
		   } else
		   {
			 echo'<div style="display:none;" class="error_text_add"></div>';  
		   }
			
		} else
		{
		
		
		if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1)))
		{
	      echo'<div class="save_button add_invoicess1"><i>Сохранить</i></div>';
		  if((isset($stack_error))and((count($stack_error)!=0)))
          {	
		      echo'<div class="error_text_add">Не все поля заполнены для сохранения</div>';	
		  } else
		  {
			 echo'<div style="display:none;" class="error_text_add"></div>';  
		  }			
		} 			
			
			
		}
	

	 
	    


	
	

include_once $url_system.'module/notification.php';
?>
	</div></div>

*/
?>






<div class="menu-09  input-line" style="z-index:150;">
    <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
    <div class="menu-09-left">
        <a href="/" class="menu-09-global"></a><a  href="invoices/" class="menu-09-prev"><i></i></a>

        <?
        $D = explode('.', $_COOKIE["basket1_".$id_user."_".htmlspecialchars(trim($_GET['id']))]);
        echo'<span class="menu-09-pc-h" ><span >Накладная №'.$row_list["number"].'</span >';

        if($count_material>0)
        {
            echo'<span all="8" class="menu-09-count">'.$count_material.'</span>';
        }

        echo'</span >';

        ?>

    </div>
    <div class="menu-09-right tours-right-block">
        <?



        include_once $url_system.'module/notification.php';
        include_once $url_system.'module/users.php';

        echo'</div>';
        if(($row_list["id_user"]==$id_user)and(($row_list["status"]==1))and($row_list["ready"]==1)and($count_image!=0)and($count_material!=0)and($count_no_price==0)) {

            echo'<form id="lalala_pod_form" action="invoices/take/'.$_GET["id"].'/" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">
  <input name="tk_sign" value="'.token_access_compile($_GET['id'],'take_invoices_2018',$secret).'" type="hidden">
</form>';

            echo'<div data-tooltip="Принять на склад" class="save_button transfer_invoicess add_clients green-bb">Принять   →</div><div style="display:none;" class="add_invoicess1 add_clients yellow-style hide-mobile">Сохранить   →</div>';

        } else {

            if (($row_list["id_user"] == $id_user) and (($row_list["status"] == 1))) {
                echo '<a data-tooltip="сохранить накладную" class="add_invoicess1 add_clients yellow-style hide-mobile">Сохранить   →</a>';
            }
        }

        if (($row_list["id_user"] == $id_user) and (($row_list["status"] == 3))) {
            echo '<a href="/aktpp/make/0/" style="display: none;" data-tooltip="Принять на склад" class="save_button transfer_invoicess_2022 add_clients green-bb">Передать   →</a>';
        }


        ?>

        <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

    </div>


	