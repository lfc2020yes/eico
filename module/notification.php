<?
$noti=0;
		 $result_t=mysql_time_query($link,'Select count(a.id) as cc from r_notification as a where a.status=1 and a.id_user="'.htmlspecialchars(trim($id_user)).'"');
         $num_results_t = $result_t->num_rows;
	     if($num_results_t!=0)
	     {				 
			 $row_t = mysqli_fetch_assoc($result_t);
			 $noti=$row_t["cc"];
		 }
if($noti==0)
{

echo'<div style="display:none;" data-tooltip="Новые уведомления" class="icon1 icon_not view__not"><i></i></div>';
} else
{
echo'<div data-tooltip="Новые уведомления" class="icon1 icon_not view__not"><i></i></div>';	
}
?>