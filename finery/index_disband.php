<?
//распровести  наряд только для админа директора

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

	
  if(($sign_level>1)or($sign_admin==1))
  {
  if($D_404[4]=='')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
	$token=htmlspecialchars($_POST['tk_sign']);
	$id=htmlspecialchars($_GET['id']);
	
	if(token_access_yes($token,'disband_naryd_admin',$id,120))
    {		
		
	  $error.='1';	
	  //проверим может пользователь вообще не может работать с себестоимостью
	  if ($sign_admin==1)
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
			   //проведен ли вообщще наряд
	           if($row_list["signedd_nariad"]==1)
	           {

				  $error.='y';
						   //проводим наряд
				  //nariad_sign($link, $_GET["id"], 0, $id_user);
				    nariad_sign($link, $_GET["id"], 0,$sign_level, $id_user);
				   
				   

							   
						  //добавляем у пользователя материалы которые были в этом наряде
						  //добавляем у пользователя материалы которые были в этом наряде
						  //добавляем у пользователя материалы которые были в этом наряде
							/*
						  $result_pro=mysql_time_query($link,'Select b.*,c.id_stock from n_work as a,n_material as b,i_material as c where b.id_material=c.id and a.id_nariad="'.htmlspecialchars(trim($_GET['id'])).'" and a.id=b.id_nwork');
                           $num_results_pro = $result_pro->num_rows;
	                       if($num_results_pro!=0)
	                       {
		                     for ($ip=0; $ip<$num_results_pro; $ip++)
		                     {
			                   $row_pro = mysqli_fetch_assoc($result_pro);
							   mysql_time_query($link,'INSERT INTO z_stock_material (id,id_stock,count_units,price,subtotal,id_user,id_object) VALUES ("","'.$row_pro["id_stock"].'","'.$row_pro["count_units"].'","0","0","'.$row_list["id_user"].'","'.$row_list["id_object"].'")');


							 }
							   
						   }
							*/
						  //добавляем у пользователя материалы которые были в этом наряде
						  //добавляем у пользователя материалы которые были в этом наряде
						  //добавляем у пользователя материалы которые были в этом наряде					   
							   				   
				   
				   
			
				   
				   //скинуть подпись ниже по level
				   $niz_podpis=down_signature($sign_level,$sign_admin,$link,$_GET["id"]);
				  
				   
				   				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	
				  $user_send= array();	
					$user_send_new= array();	
				
				  
				  
	
						  
	//cообщаем пользователям которые подписывали и создавали этот наряд
	  if(($row_list['id_signed2']!=0)and($id_user!=$row_list['id_signed2']))
	  {
		array_push($user_send_new, $row_list['id_signed2']); 
	  }
	  if(($row_list['id_signed1']!=0)and($id_user!=$row_list['id_signed1']))
	  {
		array_push($user_send_new, $row_list['id_signed1']); 
	  }
	  if(($row_list['id_signed0']!=0)and($id_user!=$row_list['id_signed0']))
	  {
		array_push($user_send_new, $row_list['id_signed0']); 
	  }	
					   
	
	//сообщаем создателю наряда					  
	if($id_user!=$row_list["id_user"])
	{
      array_push($user_send_new, $row_list["id_user"]);
	}	
						  
						  
				 $user_send_new= array_unique($user_send_new);		
				 //print_r($user_send_new);	
	 					  

				  $text_not='<a href="finery/'.htmlspecialchars(trim($_GET['id'])).'/">Наряд №'.htmlspecialchars(trim($_GET['id'])).'</a> был распроведен <strong>'.$name_user.'</strong>';
				 
				  
				  //echo($text_not);
				  		  
					
				  notification_send($text_not,$user_send_new,$id_user,$link);	
				  
	  
				  		  
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	
				   
				   
				   
				   
				   
				   if($niz_podpis!=-1)
				   {
				     mysql_time_query($link,'update n_nariad set id_signed'.$niz_podpis.'="0" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
					   
				   }

                   header("Location:".$base_usr."/finery/".$_GET['id'].'/disband/');
						   
					  
			     
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
header("Location:".$base_usr."/finery/".$_GET['id'].'/no/');


//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
	
?>