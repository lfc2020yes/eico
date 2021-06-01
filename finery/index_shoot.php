<?
//убрать подпись наряда для  начальников участка и выше

session_start();
$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; include_once $url_system.'module/config.php'; include_once $url_system.'module/function.php'; include_once $url_system.'login/function_users.php'; initiate($link); include_once $url_system.'module/access.php';

//правам к просмотру к действиям
$hie = new hierarchy($link,$id_user);
//echo($id_user);
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


$role->GetColumns();
$role->GetRows();
$role->GetPermission();
//правам к просмотру к действиям
$edit_price=0;
if ($role->is_column_edit('n_material','price'))
{
	$edit_price=1;
}


//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//проверка адреса сайта на существование такой страницы
//      /finery/plus/28/
//     0   1     2  3
$error=0;
$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);



if ( count($_GET) == 1 ) //--Если были приняты данные из HTML-формы
{

	
  if(($sign_level!=1))
  {
  if($D_404[4]=='')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
	$token=htmlspecialchars($_POST['tk_sign']);
	$id=htmlspecialchars($_GET['id']);
	
	if(token_access_yes($token,'shoot_naryd_user',$id,120))
    {		
		
	  $error.='1';	
	  //проверим может пользователь вообще не может работать с себестоимостью
	  if (($role->permission('Наряды','R'))or($sign_admin==1))
	  {
        
		$result_url=mysql_time_query($link,'select A.* from n_nariad as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0)
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} else
		{
			$error.='2';	
			$row_list = mysqli_fetch_assoc($result_url);
			//проверим что он имеет доступ к данному объекту этого наряда
			if(($sign_admin!=1)and(array_search($row_list["id_object"],$hie_object)===false))
			{
			  header("HTTP/1.1 404 Not Found");
	          header("Status: 404 Not Found");
	          $error_header=404;
			} else
			{
			   if(array_search($row_list["id_user"],$hie_user)===false)
		       {
				  header("HTTP/1.1 404 Not Found");
	              header("Status: 404 Not Found");
	              $error_header=404;  
			   } else
			   {
				
				
			   $error.='3';		
			   //проверить не подписан ли он выше или им или проведен вообще
	           if((sign_naryd_level($link,$id_user,$sign_level,$_GET["id"],$sign_admin)))
	           {
				  $error.='x';	 
			      //если нет флага что все заполнено для подписи   
			      if($row_list["ready"]==0)
			      {
			        header("HTTP/1.1 404 Not Found");
	                header("Status: 404 Not Found");
	                $error_header=404;
			      } else
			      {
					  $error.='y';
					  
					  
					  $niz_podpis=down_signature($sign_level,$sign_admin,$link,$_GET["id"]);
					  //смотрим есть ли подписчики ниже его
					  if($niz_podpis==-1)
					  {
					  	 header("HTTP/1.1 404 Not Found");
	                     header("Status: 404 Not Found");
	                     $error_header=404;
				      } else
				      {
						$error.='d';  
					   //перепроверка по базе данных
					   mysql_time_query($link,'update n_nariad set id_signed'.$niz_podpis.'="0" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');	 
						  
					   
										   				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	
				  $user_send= array();	
				  $user_send_new= array();	
				
				  
				  
	if($sign_level==1)
	{	
		$user_send_new=array_merge($hie->boss['2'],$hie->boss['4']);
		$user_send_new=array_merge($user_send_new,$hie->boss['3']);
	}
	if($sign_level==2)
	{	
		$user_send_new=array_merge($hie->boss['3'],$hie->boss['4']);		
	}
	if($sign_level==3)
	{	
		$user_send_new=$hie->boss['4'];
	}	
						  
	//cообщаем пользователю чью запись сняли
    array_push($user_send_new, $row_list['id_signed'.$niz_podpis]);						  
	
	//сообщаем создателю наряда					  
	if($id_user!=$row_list["id_user"])
	{
      array_push($user_send_new, $row_list["id_user"]);
	  //echo("!");
	}	
						  
						  
				 $user_send_new= array_unique($user_send_new);		
				 //print_r($user_send_new);	
	 

					  
				   $result_txs=mysql_time_query($link,'Select a.name_user from r_user as a where a.id="'.htmlspecialchars(trim($row_list['id_signed'.$niz_podpis]	)).'"');
	               if($result_txs->num_rows!=0)
	               {   
		       
		            $rowxs = mysqli_fetch_assoc($result_txs);
				   }
						  

				  $text_not='<strong>'.$name_user.'</strong> снял подпись <strong>'.$rowxs["name_user"].'</strong> с <a href="finery/'.htmlspecialchars(trim($_GET['id'])).'/">наряда №'.htmlspecialchars(trim($_GET['id'])).'</a>';
				 
				  
				  //echo($text_not);
				  		  
					
				  notification_send($text_not,$user_send_new,$id_user,$link);	
				  
	  
				  		  
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	  
						  
						  
				       }
			     }
			   } else 
			   {
				 header("HTTP/1.1 404 Not Found");
	             header("Status: 404 Not Found");
	             $error_header=404;				
			   }
			}
		}
		}
	}  else
			    {
				 header("HTTP/1.1 404 Not Found");
	             header("Status: 404 Not Found");
	             $error_header=404;				
			    }
	} else
	{
       header("HTTP/1.1 404 Not Found");
	   header("Status: 404 Not Found");
	   $error_header=404;
	}
  } else
  {
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    $error_header=404;	  
  }
} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}	
} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}

} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;	
}

//echo($error);
header("Location:".$base_usr."/finery/".$_GET['id'].'/');


//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
	
?>