<?
//подпись наряда для прорабов и начальников участка со служ. записками

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

	
  if(($sign_level!=3)and($sign_admin!=1))
  {
  if($D_404[4]=='')
  {		
	//echo("!");
	if(isset($_GET["id"]))
	{
	$token=htmlspecialchars($_POST['tk_sign']);
	$id=htmlspecialchars($_GET['id']);
	
	if(token_access_yes($token,'sign_naryd_plus',$id,120))
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
					  if((memo_count_nariad($link,$_GET["id"])==0)and($sign_level==2))
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


                                 $my_material=0;	//свой
                                 $my_material1=0;	//давальческий
                               //Определяем сколько материала на пользователе который оформляет наряд
							   if($row_pro["id_stock"]!='')
							   {
                                  if($row_list["id_user"]==$id_user)	
                                  {								
                                     $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.alien=0 and a.id_user="'.$id_user.'" and a.id_stock="'.htmlspecialchars(trim($row_pro["id_stock"])).'"');
                                  } else
                                  {
                                     $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.alien=0 and a.id_user="'.$row_list["id_user"].'" and a.id_stock="'.htmlspecialchars(trim($row_pro["id_stock"])).'"');
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



                                   if($row_list["id_user"]==$id_user)
                                   {
                                       $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.alien=1 and a.id_user="'.$id_user.'" and a.id_stock="'.htmlspecialchars(trim($row_pro["id_stock"])).'"');
                                   } else
                                   {
                                       $result_t1_=mysql_time_query($link,'SELECT SUM(a.count_units) AS summ FROM z_stock_material AS a WHERE a.alien=1 and a.id_user="'.$row_list["id_user"].'" and a.id_stock="'.htmlspecialchars(trim($row_pro["id_stock"])).'"');
                                   }
                                   $num_results_t1_ = $result_t1_->num_rows;
                                   if($num_results_t1_!=0)
                                   {

                                       $row1ss_ = mysqli_fetch_assoc($result_t1_);
                                       if(($row1ss_["summ"]!='')and($row1ss_["summ"]!=0))
                                       {
                                           $my_material1=$row1ss_["summ"];
                                       }
                                   }

                               }

                                 $my_material_prior=$my_material;  // по какому количеству материалу будет проверяться хватает ли материала у этого пользователя для оформления наряда
                                 if($row_pro["alien"]==1)
                                 {
                                     $my_material_prior=$my_material1;
                                 }
						
						if($my_material_prior<$row_pro["count_units"]) {  $flag_podpis++; }
								 
								 
								 
							 }
						   }
   
						   if($flag_podpis!=0)
						   {
							   
							   mysql_time_query($link,'update n_nariad set ready="0" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
							   header("Location:".$base_usr."/finery/".htmlspecialchars(trim($_GET['id'])).'/no/');
			                   die();
						   } else					   
						{  
						  
						$error.='d';  
					   //перепроверка по базе данных
					   mysql_time_query($link,'update n_nariad set id_signed'.($sign_level-1).'="'.$id_user.'" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');
					
						  
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
						  
	//вдруг не создатель его подписал на согласование
	if($id_user!=$row_list["id_user"])
	{
      array_push($user_send_new, $row_list["id_user"]);
	}	
						  
						  
				 $user_send_new= array_unique($user_send_new);		
				 //print_r($user_send_new);	
	 
				  $slyjj=0;
		          $slyjj=memo_count_nariad($link,$_GET["id"]);	
						  
				  if($slyjj!=0)
				  {
				  $text_not='<strong>'.$name_user.'</strong> подписал <a href="finery/'.htmlspecialchars(trim($_GET['id'])).'/">наряд №'.htmlspecialchars(trim($_GET['id'])).'</a> на согласование';
				  } else
				  {
				  $text_not='<strong>'.$name_user.'</strong> подписал <a href="finery/'.htmlspecialchars(trim($_GET['id'])).'/">наряд №'.htmlspecialchars(trim($_GET['id'])).'</a> на утверждение';					  
				  }
				  
				  //echo($text_not);
				  		  
					
				  notification_send($text_not,$user_send_new,$id_user,$link);	
				  
	  
				  		  
						  
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде
				  //добавляем уведомления о новом наряде		  
                            header("Location:".$base_usr."/finery/".htmlspecialchars(trim($_GET['id'])).'/sign/');
                            die();
						  
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
header("Location:".$base_usr."/finery/".$_GET['id'].'/no/');


//если такой страницы нет или не может быть выведена с такими параметрами
if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
	
?>