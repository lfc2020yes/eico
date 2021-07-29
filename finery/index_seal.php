<?
//утвердить наряд для начальников участка и выше

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
	
	if(token_access_yes($token,'seal_naryd_xx',$id,120))
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
					  //смотрим если ли служебных записок для начальника участка
					  
					  
					  
					  if((memo_count_nariad($link,$_GET["id"])!=0)and($sign_level==2))
					  {
					  	 header("HTTP/1.1 404 Not Found");
	                     header("Status: 404 Not Found");
	                     $error_header=404;
				      } else
				      {
						$error.='d';  
					
					   //если админ или главный инженер то все слуб. записки. должны быть с норм. решением  
					   if((decision_memo($link,$_GET["id"])!=0)and(($sign_level==3)or($sign_admin==1)))
					   { 
						 header("HTTP/1.1 404 Not Found");
	                     header("Status: 404 Not Found");
	                     $error_header=404; 
					   } else
					   {
						   
						   //проверить что количество указанного материала в наряде по работам не меньше чем у человека на складе , который создал этот наряд
						   $flag_podpis=0;
						   $result_pro=mysql_time_query($link,'Select b.*,c.id_stock from n_work as a,n_material as b,i_material as c where b.id_material=c.id and a.id_nariad="'.htmlspecialchars(trim($_GET['id'])).'" and a.id=b.id_nwork');
                           $num_results_pro = $result_pro->num_rows;
	                       if($num_results_pro!=0)
	                       {
		                     for ($ip=0; $ip<$num_results_pro; $ip++)
		                     {
			                   $row_pro = mysqli_fetch_assoc($result_pro);
								 
								 
								 	$result_tx=mysql_time_query($link,'Select sum(a.count_units) as dd from n_material as a,i_material as b,n_work as c where a.id_material=b.id and c.id_nariad="'.htmlspecialchars(trim($_GET['id'])).'" and c.id=a.id_nwork and b.id_stock="'.$row_pro["id_stock"].'"');
								 
                                    $num_results_tx = $result_tx->num_rows;
                                    if($num_results_tx!=0)
                                    {	
	                                   $row_tx = mysqli_fetch_assoc($result_tx);
                                    }
								 
							   
							   $my_material=0;							
                               //Определяем сколько материала на пользователе который оформляет наряд
							   if($row_pro["id_stock"]!='')
							   {
                                  if($row_list["id_user"]==$id_user)	
                                  {								
                                     $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_user="'.$id_user.'" and a.id_stock="'.htmlspecialchars(trim($row_pro["id_stock"])).'"');
                                  } else
                                  {
                                     $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.id_user="'.$row_list["id_user"].'" and a.id_stock="'.htmlspecialchars(trim($row_pro["id_stock"])).'"');	
                                  }
			                      $num_results_t1_ = $result_t1_->num_rows;
	                              if($num_results_t1_!=0)
	                              {  
		              
		                              $row1ss_ = mysqli_fetch_assoc($result_t1_);
					                  if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
					                  {
					                      $my_material=$row1ss_["summ"];
					                  }               
				                  }									
							
							   }
						
						if($my_material<$row_tx["dd"]) {  $flag_podpis++; }	 
								 
								 
								 
							 }
						   }
   
						   if($flag_podpis!=0)
						   {
							   //echo("!");
							   mysql_time_query($link,'update n_nariad set ready="0" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
							   header("Location:".$base_usr."/finery/".htmlspecialchars(trim($_GET['id'])).'/');	
			                   die();
						   } else
						   {
						   
						   
						   
						   //проводим наряд
						   
						   //записать посследнии данные по количествам которые были на момент утверждения
						   

						  $result_work=mysql_time_query($link,'Select a.* from n_work as a where a.id_nariad="'.htmlspecialchars(trim($_GET['id'])).'" order by a.id');
                          $num_results_work = $result_work->num_rows;
	                      if($num_results_work!=0)
	                      {
		  

		                    for ($i=0; $i<$num_results_work; $i++)
		                    {
			                $row_work = mysqli_fetch_assoc($result_work);
			
								
								
						   $result_t1_=mysql_time_query($link,'Select c.count_r2_realiz,c.count_units as count_all,a.count_units,c.price  from n_work as a, i_razdel2 as c where c.id=a.id_razdeel2 and a.id_razdeel2="'.$row_work["id_razdeel2"].'"');
						   $num_results_t1_ = $result_t1_->num_rows;
	                       if($num_results_t1_!=0)
	                       {  
							   $row1ss_ = mysqli_fetch_assoc($result_t1_); 
							   
							  //сохраняем последние данные по работе
							  mysql_time_query($link,'update n_work set 				 
					 count_units_razdel2="'.$row1ss_["count_all"].'",					 
					 count_units_razdel2_realiz="'.$row1ss_["count_r2_realiz"].'",
					 price_razdel2="'.$row1ss_["price"].'"					 					 
					 where id = "'.$row_work["id"].'"');
							   
							   //такая работа есть
		                       $result_mat=mysql_time_query($link,'Select a.*,b.count_units as count_seb,b.price as price_seb,b.count_realiz from n_material as a,i_material as b where a.id_material=b.id and a.id_nwork="'.$row_work["id"].'" order by a.id');
							   $num_results_mat = $result_mat->num_rows;
	                           if($num_results_mat!=0)
	                           {
		                         for ($mat=0; $mat<$num_results_mat; $mat++)
		                         {
                                      $row_mat = mysqli_fetch_assoc($result_mat);									  
									  //сохраняем последние данные по материалу
									  mysql_time_query($link,'update n_material set 				 
					 count_units_material="'.$row_mat["count_seb"].'",					 
					 count_units_material_realiz="'.$row_mat["count_realiz"].'",
					 price_material="'.$row_mat["price_seb"].'"					 					 
					 where id = "'.$row_mat["id"].'"');
		                         }
					           }
					          		   
							   
						   }
					      } 
						  }

						   nariad_sign($link, $_GET["id"], 1,$sign_level, $id_user);
						   //nariad_sign(&$mysqli,$id_narid, $sinedd,$sign_level, $id_user
						   //echo("!!");
							   
							   
							   
							   
						  //списываем у пользователя материалы которые были в этом наряде
						  //списываем у пользователя материалы которые были в этом наряде
						  //списываем у пользователя материалы которые были в этом наряде
							/*
						  $result_pro=mysql_time_query($link,'Select b.*,c.id_stock from n_work as a,n_material as b,i_material as c where b.id_material=c.id and a.id_nariad="'.htmlspecialchars(trim($_GET['id'])).'" and a.id=b.id_nwork');
                           $num_results_pro = $result_pro->num_rows;
	                       if($num_results_pro!=0)
	                       {
		                     for ($ip=0; $ip<$num_results_pro; $ip++)
		                     {
			                   $row_pro = mysqli_fetch_assoc($result_pro);
							   //$row_pro["count_units"] 
							   $count_sp=$row_pro["count_units"];
							   $cost_ss=0;
							   $total=0;
							   //списываем к уменьшению количества записей на складе. сначала с записей которые мелкие потом большие
							   $result_t2=mysql_time_query($link,'Select a.* from z_stock_material as a where a.id_stock="'. $row_pro["id_stock"].'" and a.id_user="'.$row_list["id_user"].'" order by a.count_units');	
					           $num_results_t2 = $result_t2->num_rows;
	                           if($num_results_t2!=0)
	                           {		   
							   	  for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                                  {

					                   $row__2= mysqli_fetch_assoc($result_t2);
									   if($row__2["count_units"]<=$count_sp)
										{
											$count_sp=$count_sp-$row__2["count_units"];
											$total=$total+($row__2["count_units"]*$row__2["price"]);
											//удаляем запись вообще
											mysql_time_query($link,'delete FROM z_stock_material where id="'.$row__2["id"].'"');
										} else
										{
											$new_count=$row__2["count_units"]-$count_sp;
											$total=$total+($count_sp*$row__2["price"]);
											$count_sp=0;
											if($new_count>0)
											{
											mysql_time_query($link,'update z_stock_material set count_units="'.$new_count.'" where id = "'.$row__2["id"].'"');
											} else
											{
											mysql_time_query($link,'delete FROM z_stock_material where id="'.$row__2["id"].'"');	
											}
										}
									    if($count_sp==0)
										{
											break;
										}
									  
						 
					              }
								   $cost_ss=round($total/$row_pro["count_units"],2);
								   
								 mysql_time_query($link,'update n_material set 				 
					 price="'.$cost_ss.'"					 					 
					 where id = "'.$row_pro["id"].'"');
				              }
								 
							 }
							   
						   }
							   */
						  //списываем у пользователя материалы которые были в этом наряде
						  //списываем у пользователя материалы которые были в этом наряде
						  //списываем у пользователя материалы которые были в этом наряде					   
							   
							   

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
						  
	//cообщаем пользователям которые подписывали до этого
    if($row_list['id_signed2']!=0)
	{
	  if(($row_list['id_signed1']!=0)and($id_user!=$row_list['id_signed1']))
	  {
		array_push($user_send_new, $row_list['id_signed1']); 
	  }
	  if(($row_list['id_signed0']!=0)and($id_user!=$row_list['id_signed0']))
	  {
		array_push($user_send_new, $row_list['id_signed0']); 
	  }	
	}
    if($row_list['id_signed2']==0)
	{
	  if(($row_list['id_signed0']!=0)and($id_user!=$row_list['id_signed0']))
	  {
		array_push($user_send_new, $row_list['id_signed0']); 
	  }	
	}						   
	
	//сообщаем создателю наряда					  
	if($id_user!=$row_list["id_user"])
	{
      array_push($user_send_new, $row_list["id_user"]);
	}	
						  
						  
				 $user_send_new= array_unique($user_send_new);		
				 //print_r($user_send_new);	
	 					  

				  $text_not='<strong>'.$name_user.'</strong> утвердил <a href="finery/'.htmlspecialchars(trim($_GET['id'])).'/">наряд №'.htmlspecialchars(trim($_GET['id'])).'</a>';
				 
				  
				  //echo($text_not);
				  		  
					
				  notification_send($text_not,$user_send_new,$id_user,$link);	
				  
	  
				  		  
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде						   
						   
						   
						   }
					   }  
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