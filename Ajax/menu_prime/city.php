<?php
//получение в меню сверху в разделе себестоимость квартала и домов после выбора города
//если в этом городе один квартал то выводить сразу и дома

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");



$status_ee='error';
$eshe=0;
$debug='';
$count_all_all=0;

$id_city=htmlspecialchars($_GET['id']);


//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


  if((isset($_GET['id']))and(is_numeric($_GET['id'])))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
		  
		  if (($role->permission('Себестоимость','R'))or($sign_admin==1))
	      {  
		  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
$status_ee='ok';
if($sign_admin!=1)
{
$result_t=mysql_time_query($link,'Select a.id,a.kvartal from i_kvartal as a where a.id_town="'.$id_city.'" AND a.id in ('.implode(',',$hie->id_kvartal).')  order by a.id');	
} else
{
$result_t=mysql_time_query($link,'Select a.id,a.kvartal from i_kvartal as a where a.id_town="'.$id_city.'" order by a.id');
}
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);
		   		  if($num_results_t==1)
	              {
		   $echo.='<div class="left_drop menu2_prime"><div class="select eddd"><a class="slct" data_src="'.$row_t["id"].'">'.$row_t["kvartal"].'</a><ul class="drop">';
				  } else
				  {
		   $echo.='<div class="left_drop menu2_prime"><div class="select eddd"><a class="slct" data_src="0">...</a><ul class="drop">';					  
				  }
		   $active=$row_t["id"];
		   for ($i=0; $i<$num_results_t; $i++)
             {  
			   if($i!=0)
			   {
                  $row_t = mysqli_fetch_assoc($result_t);
			   }
			
			   if((array_search($row_t["id"],$hie_kvartal) !== false)or($sign_admin==1)) 
               { 
				 
			      if($num_results_t==1)
	              {
				    $echo.='<li class="sel_active"><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["kvartal"].'</a></li>'; 
				  } else
				  {
					$echo.='<li><a href="javascript:void(0);"  rel="'.$row_t["id"].'">'.$row_t["kvartal"].'</a></li>';   
				  }
			   }
			 }
		   $echo.='</ul><input type="hidden"  name="kvartal" id="kvartal" value="'.$active.'"></div></div>'; 
	   }
	   if($num_results_t==1)
	   {
		   
if($sign_admin!=1)
{
$result_t=mysql_time_query($link,'Select a.id,a.object_name from i_object as a where a.id_kvartal="'.$row_t["id"].'" AND a.id in ('.implode(',',$hie->obj).') order by a.id');
} else
{
$result_t=mysql_time_query($link,'Select a.id,a.object_name from i_object as a where a.id_kvartal="'.$row_t["id"].'" order by a.id');
}
       $num_results_t = $result_t->num_rows;
	   if($num_results_t!=0)
	   {
		   $row_t = mysqli_fetch_assoc($result_t);
		   $echo.='<div class="left_drop menu3_prime"><div class="select eddd"><a class="slct" data_src="0">...</a><ul class="drop">';
		   $url_prime="prime/";
		   $active=$row_t["id"];
		   for ($i=0; $i<$num_results_t; $i++)
             {  
			   if($i!=0)
			   {
                  $row_t = mysqli_fetch_assoc($result_t);
			   }
			   
				  $echo.='<li><a href="'.$url_prime.$row_t["id"].'/"  rel="'.$row_t["id"].'">'.$row_t["object_name"].'</a></li>'; 
			   
			 }
		   $echo.='</ul><input type="hidden"  name="dom" id="dom"  value="'.$active.'"></div></div>'; 
	   }
		   
	   
	   }

	  }
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }



$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>