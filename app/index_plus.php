<?
//добавление работ у уже оформленный наряд но не подписанный

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


$b_co='edit_basket1_'.$id_user;

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

  if($D_404[4]=='')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
	  $error.='1';	
	  //проверим может пользователь вообще не может работать с себестоимостью
	  if (($role->permission('Заявки','A'))or($sign_admin==1))
	  {
        
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
			if($row_list["status"]!=1)
			{
			  header("HTTP/1.1 404 Not Found");
	          header("Status: 404 Not Found");
	          $error_header=404;
			} else
			{
			   if(($row_list["id_user"]!=$id_user)and($sign_admin!=1))
		       {
				  header("HTTP/1.1 404 Not Found");
	              header("Status: 404 Not Found");
	              $error_header=404;  
			   } else
			   {
				
				
			   $error.='3';		
			   //проверить не подписан ли он выше или им или проведен вообще	 
			      //кукки существует по добавлению в наряд	   
			      if((!isset($_COOKIE["edit_basket1_".$id_user."_".$row_list["id_object"]]))or($_COOKIE["edit_basket1_".$id_user."_".$row_list["id_object"]]==''))
			      {
			        header("HTTP/1.1 404 Not Found");
	                header("Status: 404 Not Found");
	                $error_header=404;
			      } else
			      {
                       $error.='4';	
			  	       $D = explode('.', $_COOKIE["edit_basket1_".$id_user."_".$row_list["id_object"]]);
					   $count_add_dell=0;
                       for ($i=0; $i<count($D); $i++)
		               {
	                         //проверим может вообще такой работы уже нет
			                 $result_t1=mysql_time_query($link,'Select a.*,c.id_object from i_material as a,i_razdel1 as c,i_razdel2 as b where a.id_razdel2=b.id and b.id_razdel1=c.id and a.id="'.htmlspecialchars(trim($D[$i])).'"');
                             $num_results_t1 = $result_t1->num_rows;
	                         if($num_results_t1!=0)
	                         {  
		                        //такая работа есть
		                        $row1ss = mysqli_fetch_assoc($result_t1);
								//работа выбрана из того же объекта
								if($row1ss["id_object"]==$row_list["id_object"])
								{
									$error.='5';	
									$result_t12=mysql_time_query($link,'Select a.id from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'" and  a.id_i_material="'.htmlspecialchars(trim($D[$i])).'"');
                                    $num_results_t12 = $result_t12->num_rows;
	                                if($num_results_t12==0)
	                                {
										//такой работы еще нет в наряде
										$error.='6';	
										//добавляем работу к наряду и материалы по ней
										$status_memo=1;
				                        $memo='';	
										$count_add_dell++;
										
														  mysql_time_query($link,'INSERT INTO z_doc_material (id,id_doc,id_i_material,id_stock,id_object,count_units,date_delivery,status,memorandum,id_sign_mem,signedd_mem) VALUES ("","'.htmlspecialchars(trim($_GET['id'])).'","'.htmlspecialchars(trim($D[$i])).'","'.htmlspecialchars(trim($row1ss['id_stock'])).'","'.$row1ss["id_object"].'","","","1","'.$memo.'","0","0")');
									}
								}
			            	 }
		               }
					   
					   //пробегаем по работам наряда и если нет такой работы в cookie удаляем ее вместе с материалами
					   $result_tx=mysql_time_query($link,'Select a.* from z_doc_material as a where a.id_doc="'.htmlspecialchars(trim($_GET['id'])).'"');
                       $num_results_tx = $result_tx->num_rows;
	                   if($num_results_tx!=0)
	                   {
		                  for ($ix=0; $ix<$num_results_tx; $ix++)
                          {  
			                 $row_tx = mysqli_fetch_assoc($result_tx);
							 if(array_search($row_tx["id_i_material"],$D)===false) 
							 {
								 //удаляем эту работу и материал из наряда
								 mysql_time_query($link,'delete FROM z_doc_material where id="'.$row_tx["id"].'"'); 
							 }
						  }
					   }
					   //удаляем кукки по добавлению
			 setcookie("edit_basket1_".$id_user."_".$row_list["id_object"], "", time()-3600,"/", "i-s.group");
					  if($count_add_dell!=0)
					  {
						   mysql_time_query($link,'update z_doc set ready="0" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
					  }
				
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

//echo($error);

header("Location:".$base_usr."/app/".$_GET['id'].'/');	


//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
?>