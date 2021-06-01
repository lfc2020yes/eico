<?


$limit_not=10; //лимит непрочитанных уведомлений после чего отправлять инженеру
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';


session_start();
//подключение к базе
include_once $url_system.'module/config.php';
//подключение написанных функций для сайта
include_once $url_system.'module/function.php';

//считываем все необходимые доступы для этого пользователя
 include_once $url_system.'ilib/lib_interstroi.php'; 
 $role=new RoleUser($link,$id_user);  //создаем класс прав
 $role->GetColumns();
 $role->GetRows();
 $role->GetPermission();

 $hie = new hierarchy($link,$id_user);

$hie_object=array();
$hie_town=array();
$hie_kvartal=array();
$hie_user=array();	
$hie_object=$hie->obj;
$hie_kvartal=$hie->id_kvartal;
$hie_town=$hie->id_town;
$hie_user=$hie->user;

 $sign_level=$hie->sign_level;
 $sign_admin=$hie->admin;


$result_score=mysql_time_query($link,'Select DISTINCT a.id_user,(select count(b.id) as cc from r_notification as b where b.id_user=a.id_user AND b.status=1) as vv from r_notification as a where a.status=1');

$num_results_score = $result_score->num_rows;
if($num_results_score!=0)
{

	for ($ss=0; $ss<$num_results_score; $ss++)
	{			   			  			   
		$row_score = mysqli_fetch_assoc($result_score);
		if($row_score["vv"]>$limit_not)
		{
			//отправляем уведомление инженеру что у пользователя больше 10 непрочитанных уведомлений
		
			
			
			
		$result_txs=mysql_time_query($link,'Select a.id,a.name_user,a.timelast,a.enabled from r_user as a where a.id="'.htmlspecialchars(trim($row_score["id_user"])).'"');
      
	    if($result_txs->num_rows!=0)
	    {   
		  //такая работа есть
		  $rowxs = mysqli_fetch_assoc($result_txs);
		}
			
			
			if($rowxs["enabled"]==1)
			{
			 $hie = new hierarchy($link,$row_score["id_user"]);
	
			$NUser = new notification_user(&$hie);
				
     // echo '<br><b>'.$row_score["id_user"].'</b> $NUser->id=['.implode(',', $NUser->id).']';
			
			
			$user_send_new= array();	
			$user_send_new=array_merge($user_send_new,$NUser->id);		

		    //array_push($user_send_new,$row_list11["id_user"]);
		
			
			
			$text_not='У работника - <strong>'.$rowxs["name_user"].'</strong> более '.$limit_not.' непрочитанных уведомлений в системе. Это может привезти к нарушению сроков строительства. Если этот работник входит в вашу команду, необходимо связать с ним по вопросам неактивности в системе.';
			
			
			//отправка уведомления
			$user_send_new= array_unique($user_send_new);	
			notification_send($text_not,$user_send_new,11,$link);
		
			}
			
			
		}
	}
			
}
?>

