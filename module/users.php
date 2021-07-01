<?
echo'<div class="logo_90">'; 
	 

if(isset($_SESSION['user_id']))
{
$result_uu=mysql_time_query($link,'select a.*,b.name_role from r_user as a,r_role as b where b.id=a.id_role and a.id="'.id_key_crypt_encrypt(htmlspecialchars(trim($_SESSION['user_id']))).'"');
   $num_results_uu = $result_uu->num_rows;

   if($num_results_uu!=0)
   {                 
	$row_uu = mysqli_fetch_assoc($result_uu);
   }
}

echo'<div class="users">';
	  $filename=$url_system.'img/users/'.$row_uu["id"].'_100x100.jpg';
if (file_exists($filename)) {	  

echo'<div class="logi-hovi"><img src="img/users/'.$row_uu["id"].'_100x100.jpg?a='.$row_uu["img_xah"].'"></div>
<div class="users_rule" iu="'.$id_user.'" not="'.$row_uu["noti_key"].'">';
} else
{
//echo'<div class="users_rule" style="padding-left:22px;">';
	echo'<img src="img/users/0_100x100.jpg">
<div class="users_rule" ui="'.$id_user.'" not="'.$row_uu["noti_key"].'">';
}

$name=$row_uu["name_user"];

$name=preg_replace('/^ +| +$|( ) +/m', '$1', $name);
//echo($name);
$name=tolkofi($name);


$name_ss = explode(" ", ht($name));


echo'<i>'.$row_uu["name_role"].'</i>
<strong>'.$name_ss[1].' '.$name_ss[0].'</strong>';

?>
</div></div> 	 
<?	 
	echo'</div>';
	