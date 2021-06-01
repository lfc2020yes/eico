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




if(token_access_new($token,'add_work_mat',$id,"s_form"))
{

  if(((isset($_GET['id']))and(is_numeric($_GET['id']))))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
		  
		 if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	     {  
		  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		$result_t1=mysql_time_query($link,'Select a.id,a.id_object,a.razdel1 from i_razdel1 as a where a.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
		  //такой раздел есть можно проверять переданные переменные
		   $row1 = mysqli_fetch_assoc($result_t1);
		 
		 if((isset($_GET['count_work']))and(is_numeric($_GET['count_work']))and(isset($_GET['price_work']))and(is_numeric($_GET['price_work']))and(isset($_GET['ed_work']))and(trim($_GET["ed_work"])!='')and(isset($_GET['ispol_work']))and(is_numeric($_GET['ispol_work']))and(isset($_GET['name_work']))and(trim($_GET["name_work"])!='')) 
		 {
        $status_ee='ok';

        $rann=1;
	    $result_town2=mysql_time_query($link,'select max(A.razdel1) as mm from i_razdel1 as A where  A.id_object="'.htmlspecialchars(trim($_GET['id'])).'"');
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
			 
$ID_D=0;								 
mysql_time_query($link,'INSERT INTO i_razdel2 (id,id_razdel1,razdel1,razdel2,name_working,id_implementer,units,count_units,price) VALUES ("","'.htmlspecialchars(trim($id)).'","'.$row1["razdel1"].'","'.$rann.'","'.htmlspecialchars(trim($_GET["name_work"])).'","'.htmlspecialchars(trim($_GET["ispol_work"])).'","'.htmlspecialchars(trim($_GET["ed_work"])).'","'.htmlspecialchars(trim($_GET["count_work"])).'","'.htmlspecialchars(trim($_GET["price_work"])).'")');			
$ID_D=mysqli_insert_id($link);	
		

$echo.='<tr class="jop n1n" rel_id="'.$ID_D.'"><td class="middle_"><div class="st_div"><i></i></div></td>
                  <td class="no_padding_left_ pre-wrap"><span class="s_j">'.htmlspecialchars(trim($_GET["name_work"])).'</span><span class="edit_panel">';
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
$echo.='<div class="musa_plus mpp">+</div>';
$echo.='</td>
<td><span class="s_j">'.htmlspecialchars(trim($_GET["ed_work"])).'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim($_GET["count_work"])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim($_GET["price_work"])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(($_GET["count_work"]*$_GET["price_work"]), 2, '.', ' '),'0'),'.').'</span></td>
<td>0</td>';
if(array_search('summa_r2_realiz',$stack_td) === false) 
{
$echo.='<td>0</td>
<td><strong>'.rtrim(rtrim(number_format(($_GET["count_work"]*$_GET["price_work"]), 2, '.', ' '),'0'),'.').'</strong></td>';
}
$echo.='</tr>';			 
			 
			 
			 if(($ID_D!=0)and($ID_D!=''))
			 {
			 //добавление материалов к работе если такие есть
			 if($_GET["count_material"]>0)
			 {
			 $material=$_GET['material'];
             foreach ($material as $value) 
			 {
              //echo("4");
				 if((isset($value['count']))and(is_numeric($value['count']))and(isset($value['price']))and(is_numeric($value['price']))and(isset($value['ed']))and(trim($value["ed"])!='')and(isset($value['name']))and(trim($value["name"])!='')) 
		         {
					 //echo("!");
					 //добавляем материал к добавленной работе
					 mysql_time_query($link,'INSERT INTO i_material (id,id_razdel2,razdel1,razdel2,material,id_implementer,units,count_units,price) VALUES ("","'.htmlspecialchars(trim($ID_D)).'","'.$row1["razdel1"].'","'.$rann.'","'.htmlspecialchars(trim($value['name'])).'","'.htmlspecialchars(trim($_GET["ispol_work"])).'","'.htmlspecialchars(trim($value['ed'])).'","'.htmlspecialchars(trim($value['count'])).'","'.htmlspecialchars(trim($value['price'])).'")');	 
					 $ID_D1=mysqli_insert_id($link);	
					 $echo.='<tr class="material" rel_ma="'.$ID_D1.'">
           
           <td colspan="2" class="no_padding_left_ pre-wrap name_m"><div class="nm"><i></i><span class="s_j">'.htmlspecialchars(trim($value['name'])).'</span><span class="edit_panel_">';
					 if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	                  {
					 $echo.='<span data-tooltip="редактировать материал" for="'.$ID_D1.'" class="edit_icon_m">3</span>';
					  }
					  if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	                  {
					 $echo.='<span data-tooltip="удалить материал" for="'.$ID_D1.'" class="del_icon_m">5</span>';
					  }
						 
						 $echo.='</span></div></td>
<td class="pre-wrap"></td>
<td><span class="s_j">'.htmlspecialchars(trim($value['ed'])).'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim($value['count'])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim($value['price'])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(($value['count']*$value['price']), 2, '.', ' '),'0'),'.').'</span></td>
<td></td>';
	if(array_search('summa_r2_realiz',$stack_td) === false) 
	{						 
$echo.='<td></td>
<td></td>';
	}
           $echo.='</tr>';  
					 
					 
					 
				 }

             
			 
		 }
	   }
	
} else
{

$status_ee='number';

}
		 }
		 	  
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

 }
}
}


$aRes = array("debug"=>$debug,"status"   => $status_ee,"table" =>  $table,"echo" =>  $echo,"id"=>$ID_D);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>