<div class="menu_top" style="border-bottom:0; box-shadow: 0 20px 30px -30px rgba(0, 0, 0, 0.6);"><div class="menu1">
  <?
   //echo'<h3 class="head_h" style=" margin-bottom:0px; float:left;"> Наряд №'.$_GET['id'].'<div></div></h3>';
	if(online_user($rowlist["timelast"],$rowlist["id"],$id_user)) { $online='<div class="online"></div>';}
	echo'<div  class="user_soz">'.$online;
		  $filename=$url_system.'img/users/'.$_GET["id"].'_100x100.jpg';
if (file_exists($filename)) {
	echo'<img src="img/users/'.$_GET["id"].'_100x100.jpg">';
} else{ echo'<img src="img/users/0_100x100.jpg">'; }
	echo'</div>';
	echo'<div class="status_dialog">'.$rowlist["name_user"].'</div>';
	
	

include_once $url_system.'module/notification.php';
?>
	</div></div>
	