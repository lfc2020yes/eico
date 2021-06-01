<?
//согласовать для прорабов которые заполнили всю заявку на материал но у них есть служебные записки

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

	
if(($role->permission('Заявки','A'))or($sign_admin==1))
  {
  if($D_404[4]=='')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
	$token=htmlspecialchars($_POST['tk_sign']);
	$id=htmlspecialchars($_GET['id']);
	
	if(token_access_yes($token,'sign_app_sogl',$id,120))
    {		
		
	  $error.='1';	
	  //проверим может пользователь вообще не может работать с себестоимостью
        
		$result_url=mysql_time_query($link,'select A.* from z_doc as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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
			if(($row_list["id_user"]!=$id_user)or($row_list["status"]!=1))
			{
			  header("HTTP/1.1 404 Not Found");
	          header("Status: 404 Not Found");
	          $error_header=404;
			} else
			{
				$memo_i=0; //нет
                $result_txs=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'" and ((not(a.memorandum="") and a.id_sign_mem=0)or(not(a.memorandum="") and not(a.id_sign_mem=0)and a.signedd_mem=0))');
                if($result_txs->num_rows!=0)
                {
 	              $memo_i=1;				
                }
				//согласовать может у кого есть несогласованные меморандумы или с отрицательным ответом
			   if($memo_i==0)
		       {
				  header("HTTP/1.1 404 Not Found");
	              header("Status: 404 Not Found");
	              $error_header=404;  
			   } else
			   {
				
				
			   $error.='3';		
	 
				mysql_time_query($link,'update z_doc set status="3" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
				//меняем статусы у материалов у которых нет решения по служебной записки или оно отрицательное
				$result_tyd1=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'" and ((not(a.memorandum="") and a.id_sign_mem=0)or(not(a.memorandum="") and not(a.id_sign_mem=0)and a.signedd_mem=0))');
                $num_results_tyd1 = $result_tyd1->num_rows;
				
				for ($ids=0; $ids<$num_results_tyd1; $ids++)
		        {
				   $row_tyd1 = mysqli_fetch_assoc($result_tyd1);
				   mysql_time_query($link,'update z_doc_material set status="3" where id = "'.htmlspecialchars(trim($row_tyd1['id'])).'"');
				}
				   
				   
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде	
				  $user_send= array();	
				  $user_send_new= array();		

				  $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_list['id_object'])).'"');
                  $num_results_custom_url = $result_url->num_rows;
                  if($num_results_custom_url!=0)
                  {
			         $row_list1 = mysqli_fetch_assoc($result_url);
		          }
					
				  $result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list1["id_kvartal"].'"');
                  $num_results_custom_town = $result_town->num_rows;
                  if($num_results_custom_town!=0)
                  {
			         $row_town = mysqli_fetch_assoc($result_town);	
		          }	
				  
				  //echo($row_list['id_object']);
                $FUSER=new find_user($link,$row_list['id_object'],'S','Заявки','plan');
				  
				$user_send_new=$FUSER->id_user;
				// print_r($user_send_new);
				$text_not='Поступила новая <a href="app/'.$row_list['id'].'/">служебная записка</a> по заявке на материал №'.$row_list['number'].', от <strong>'.$name_user.'</strong>, по объекту -  '.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);
				  
	  
				  		  
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде		  
				  
						  
						  
						  
				       
			     
			   
			}
		}
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
header("Location:".$base_usr."/app/".$_GET['id'].'/');


//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
	
?>