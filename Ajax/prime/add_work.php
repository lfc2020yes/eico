<?php
//добавление работы в разделе в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$debug='';
$count_all_all=0;
$table='';

//$_GET["ispol_work"]=0;


$id=htmlspecialchars($_GET['id']);
//$number=htmlspecialchars($_GET['number']);
//$text=htmlspecialchars($_GET['text']);
$token=htmlspecialchars($_GET['tk']);

//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован


	 	   //эти столбцы видят только особые пользователи	
		   $count_rows=10;	
		   $stack_td = array();			
		   
	       
	       if($sign_admin!=1)
		   {   
			 //столбцы  выполнено на сумму - остаток по смете  
	         if ($role->is_column('i_razdel2','summa_r2_realiz',true,false)==false) 
		     { 
			  $count_rows=$count_rows-2;
			  array_push($stack_td, "summa_r2_realiz"); 
		     } 
             //строка итого по работе, по материалам, по разделу
		     if ($role->is_column('i_razdel1','summa_r1',true,false)==false) 
		     { 
			    array_push($stack_td, "summa_r1"); 
		     } 	  
             //строка итого по объекту
		     if ($role->is_column('i_object','total_r0',true,false)==false) 
		     { 
			    array_push($stack_td, "total_r0"); 
		     } 
	         //строка итого за метр кв
		     if ($role->is_column('i_object','object_area',true,false)==false) 
		     { 
			    array_push($stack_td, "object_area"); 
		     } 		
		   }


if(!token_access_new($token,'add_work_mat',$id,"rema",2880))
{
    $debug=h4a(100,$echo_r,$debug);
    goto end_code;
}

if(!isset($_SESSION["user_id"])) {
    $status_ee='reg';
    $debug=h4a(102,$echo_r,$debug);
    goto end_code;
}

if ((!$role->permission('Себестоимость','A'))and($sign_admin!=1))
{
    $debug=h4a(103,$echo_r,$debug);
    goto end_code;
}


$result_t1=mysql_time_query($link,'Select a.name1,a.id,a.id_object,a.razdel1 from i_razdel1 as a where a.id="'.htmlspecialchars(trim($id)).'"');
$num_results_t1 = $result_t1->num_rows;
if($num_results_t1==0)
{
    $debug=h4a(3103,$echo_r,$debug);
    goto end_code;
} else {
    //такой раздел есть можно проверять переданные переменные
    $row1 = mysqli_fetch_assoc($result_t1);
}


        $status_ee='ok';

        $rann=1;
	    $result_town2=mysql_time_query($link,'select max(0+A.razdel2) as mm from i_razdel2 as A where  A.id_razdel1="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_town2 = $result_town2->num_rows;
        if($num_results_custom_town2!=0)
        {
			$row_town2 = mysqli_fetch_assoc($result_town2);		
		    if($row_town2["mm"]!='')
		    {
		       $rann=$row_town2["mm"]+1;

				
				
			}
		}

$table.='<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_'.htmlspecialchars(trim($_GET['freez'])).'" class="smeta"><thead>
		   <tr class="title_smeta"><th class="t_1"></th><th class="t_2 no_padding_left_">Наименование работ</th><th class="t_3">Исполнитель</th><th class="t_4">ед. изм.</th><th class="t_5">кол-во</th><th class="t_6">стоимость ед.<br>(руб.)</th><th class="t_7">всего (руб.)</th><th class="t_9">выполнено<br>объемов</th>';
			 
			 if(array_search('summa_r2_realiz',$stack_td) === false) 
	         {
			 $table.='<th class="t_8">выполнено<br>на сумму</th><th class="t_10">остаток<br>по смете</th>';
			 }
				 
				 $table.='</tr></thead><tbody>';
				//количество выполненной работы
$table.='<tr class="loader_tr"><td colspan="'.$count_rows.'"><div class="loaderr"><div class="teps" rel_w="0" style="width:0%"><div class="peg_div"><div><i class="peg"></i></div></div></div></div></td></tr>';



$os = array('шт','м3','м2','т','пог.м','маш/час','компл');
$os_id = array('0','1','2','3','4','5','6');

$name_ed='';
$rtyy=array_search(ht($_GET["ed_work"]), $os_id );
if ($rtyy !== false) {

    $name_ed=$os[$rtyy];

}


$ID_D=0;								 
mysql_time_query($link,'INSERT INTO i_razdel2 (id,id_razdel1,razdel1,razdel2,name_working,id_implementer,units,count_units,price) VALUES ("","'.htmlspecialchars(trim($id)).'","'.$row1["razdel1"].'","'.htmlspecialchars(trim($_GET["number_razdel2"])).'","'.htmlspecialchars(trim($_GET["name_work"])).'","'.htmlspecialchars(trim($_GET["ispol_work"])).'","'.htmlspecialchars(trim($name_ed)).'","'.htmlspecialchars(trim(trimc($_GET["count_work"]))).'","'.htmlspecialchars(trim(trimc($_GET["price_work"]))).'")');
$ID_D=mysqli_insert_id($link);	

			 
 //уведомления уведомления уведомления уведомления уведомления уведомления
 //уведомления уведомления уведомления уведомления уведомления уведомления
 //уведомления уведомления уведомления уведомления уведомления уведомления
		   
		if($sign_admin!=1)
		{   
		 
		
		       $result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row1['id_object'])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {
     
			 $row_list= mysqli_fetch_assoc($result_url);	   
		}
			   
		$result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list["id_kvartal"].'"');
        $num_results_custom_town = $result_town->num_rows;
        if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);	
		}
			   
			   
			   
				$user_send= array();	
				$user_send_new= array();		

				  
                //$FUSER=new find_user($link,$row_list['id_object'],'U','Группировка');
                $user_send_new=array_merge($hie->boss['4']);		
				$text_not='В себестоимость - <strong>'.$row_list["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</strong> в раздел - <strong>'.$row1["name1"].'</strong> добавлена новая работа - <strong>'.htmlspecialchars(trim($_GET["name_work"])).'</strong>, количество -  <strong>'.htmlspecialchars(trim($_GET["count_work"])).' '.htmlspecialchars(trim($name_ed)).'</strong>, стоимость за единицу - <strong>'.htmlspecialchars(trim($_GET["price_work"])).' руб.</strong>';
				//отправка уведомления
			    $user_send_new= array_unique($user_send_new);	
			    notification_send($text_not,$user_send_new,$id_user,$link);		   
		} 
		   
	//уведомления уведомления уведомления уведомления уведомления уведомления
	//уведомления уведомления уведомления уведомления уведомления уведомления
	//уведомления уведомления уведомления уведомления уведомления уведомления						 
					 
					 			 
			 

$echo.='<tr class="jop n1n" rel_id="'.$ID_D.'"><td class="middle_"><div class="st_div"><i></i></div></td>
                  <td class="no_padding_left_ pre-wrap"><span class="s_j">'.$row1["razdel1"].'.'.$_GET["number_razdel2"].' '.htmlspecialchars(trim($_GET["name_work"])).'</span><br>';
				  
					  
					  
					  //вывод дат начала и конца работы
					  if (($role->permission('График','R'))or($sign_admin==1))
					  {
					    $class_graf='';
						   if (($role->permission('График','U'))or($sign_admin==1))
					      {	
							  $class_graf='class="UGRAFE"';
							   $echo.='<span data-tooltip="редактировать график работы" for="'.$ID_D.'" '.$class_graf.'><span class="UD0">задать график работ</span></span>';
							  
						  }
							
						
					  }
			 
			 $echo.='<span class="edit_panel">';
			 				      if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	                  {
			 $echo.='<span data-tooltip="редактировать работу" for="'.$ID_D.'" class="edit_icon">3</span>';
					  }
			 				      if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	                  {
		     $echo.='<span data-tooltip="удалить работу" for="'.$ID_D.'" class="del_icon">5</span>';
					  }
			 				      if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	                  {
		     $echo.='<span data-tooltip="Добавить материал" for="'.$ID_D.'" class="addd_icon">J</span>';
					  }
				 
			$echo.='</span></td>
<td class="pre-wrap">';
			 
	            $result_t2=mysql_time_query($link,'Select a.* from i_implementer as a where a.id="'.htmlspecialchars(trim($_GET["ispol_work"])).'"');
                $num_results_t2 = $result_t2->num_rows;
	            if($num_results_t2!=0)
	            {
					$row_t2 = mysqli_fetch_assoc($result_t2);
											if (($role->permission('Исполнители','R'))or($sign_admin==1))
	        {	
                    $echo.='<a class="musa" href="implementer/'.$row_t2["id"].'/"><span class="s_j">'.$row_t2["implementer"].'</span></a>';
			} else
			{
				  $echo.='<span class="s_j">'.$row_t2["implementer"].'</span>';
			}
				}
				//количество нарядов по данной работе
				
//<div class="musa_plus">3</div>
//$echo.='<div class="musa_plus mpp">+</div>';
$echo.='</td>
<td><span class="s_j">'.htmlspecialchars(trim($name_ed)).'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim(trimc($_GET["count_work"]))), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim(trimc($_GET["price_work"]))), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format((trimc($_GET["count_work"])*trimc($_GET["price_work"])), 2, '.', ' '),'0'),'.').'</span></td>
<td>0</td>';
if(array_search('summa_r2_realiz',$stack_td) === false) 
{
$echo.='<td>0</td>
<td><strong>'.rtrim(rtrim(number_format((trimc($_GET["count_work"])*trimc($_GET["price_work"])), 2, '.', ' '),'0'),'.').'</strong></td>';
}
$echo.='</tr>';


end_code:


$aRes = array("debug"=>$debug,"status"   => $status_ee,"table" =>  $table,"echo" =>  $echo,"id"=>$ID_D);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>