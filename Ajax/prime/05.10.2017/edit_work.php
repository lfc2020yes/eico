<?php
//редактирование работы в себестоимости

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

if(token_access_new($token,'edit_work',$id,"s_form"))
{
	


  if(((isset($_GET['id']))and(is_numeric($_GET['id']))))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
		 if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	     {  
		  
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		$result_t1=mysql_time_query($link,'Select a.id from i_razdel2 as a where a.id="'.htmlspecialchars(trim($id)).'"');
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
		  //такой раздел есть можно проверять переданные переменные
		   $row1 = mysqli_fetch_assoc($result_t1);
		 
		 if((isset($_GET['count_work']))and(is_numeric($_GET['count_work']))and(isset($_GET['price_work']))and(is_numeric($_GET['price_work']))and(isset($_GET['ed_work']))and(trim($_GET["ed_work"])!='')and(isset($_GET['ispol_work']))and(is_numeric($_GET['ispol_work']))and(isset($_GET['name_work']))and(trim($_GET["name_work"])!='')) 
		 {
        $status_ee='ok';

        $rann=1;
		 
			 
			 
mysql_time_query($link,'update i_razdel2 set name_working="'.htmlspecialchars(trim($_GET['name_work'])).'",id_implementer="'.htmlspecialchars(trim($_GET['ispol_work'])).'",units="'.htmlspecialchars(trim($_GET['ed_work'])).'",count_units="'.htmlspecialchars(trim($_GET['count_work'])).'",price="'.htmlspecialchars(trim($_GET['price_work'])).'" where id = "'.htmlspecialchars(trim($_GET['id'])).'"');


        $result_town__=mysql_time_query($link,'select A.* from i_razdel2 as A where  A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
        $num_results_custom_town__ = $result_town__->num_rows;
        if($num_results_custom_town__!=0)
        {
			$row_town__ = mysqli_fetch_assoc($result_town__);	
			
		}
		

$echo.='<td class="middle_"><div class="st_div"><i></i></div></td>
                  <td class="no_padding_left_ pre-wrap"><span class="s_j">'.htmlspecialchars(trim($_GET["name_work"])).'</span><span class="edit_panel">';
			 		   if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	       {
			 $echo.='<span data-tooltip="редактировать работу" for="'.htmlspecialchars(trim($_GET['id'])).'" class="edit_icon">3</span>';
		   }
			 		   if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	       {
			 $echo.='<span data-tooltip="удалить работу" for="'.htmlspecialchars(trim($_GET['id'])).'" class="del_icon">5</span>';
		   }
			 		   if (($role->permission('Себестоимость','A'))or($sign_admin==1))
	       {
			 $echo.='<span data-tooltip="Добавить материал" for="'.htmlspecialchars(trim($_GET['id'])).'" class="addd_icon">J</span>';
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
			
$proc_realiz=round(($row_town__["count_r2_realiz"]*100)/$row_town__["count_units"]);			 
			 
//<div class="musa_plus">3</div>
$echo.='';
$echo.='</td>
<td><span class="s_j">'.htmlspecialchars(trim($_GET["ed_work"])).'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim($_GET["count_work"])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim($_GET["price_work"])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(($_GET["count_work"]*$_GET["price_work"]), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j" data-tooltip="'.$proc_realiz.'%">'.mor_class(($row_town__["count_units"]-$row_town__["count_r2_realiz"]),rtrim(rtrim(number_format($row_town__["count_r2_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td>';
if(array_search('summa_r2_realiz',$stack_td) === false) 
{			 
$echo.='<td><span class="s_j">'.mor_class(($row_town__["subtotal"]-$row_town__["summa_r2_realiz"]),rtrim(rtrim(number_format($row_town__["summa_r2_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td><td><strong><span class="s_j">'.mor_class(($row_town__["subtotal"]-$row_town__["summa_r2_realiz"]),rtrim(rtrim(number_format(($row_town__["subtotal"]-$row_town__["summa_r2_realiz"]), 2, '.', ' '),'0'),'.'),1).'</span></strong></td>';			 
}

			 //добавление материалов к работе если такие есть
			 if($_GET["count_material"]>0)
			 {
			 $material=$_GET['material'];
             foreach ($material as $value) 
			 {		     if((isset($value['count']))and(is_numeric($value['count']))and(isset($value['price']))and(is_numeric($value['price']))and(isset($value['ed']))and(trim($value["ed"])!='')and(isset($value['name']))and(trim($value["name"])!='')) 
		         {
					 if((isset($value['idd']))and($value['idd']!=0)and($value['name']!=''))
					 {
						 //обновление
						 mysql_time_query($link,'update i_material set material="'.htmlspecialchars(trim($value['name'])).'",units="'.htmlspecialchars(trim($value['ed'])).'",count_units="'.htmlspecialchars(trim($value['count'])).'",price="'.htmlspecialchars(trim($value['price'])).'" where id = "'.htmlspecialchars(trim($value['idd'])).'"');
						 $ID_D1=$value['idd'];
					 } else
					 {
						//добавление
						mysql_time_query($link,'INSERT INTO i_material (id,id_razdel2,razdel1,razdel2,material,id_implementer,units,count_units,price) VALUES ("","'.htmlspecialchars(trim($_GET['id'])).'","'.$row_town__["razdel1"].'","'.$row_town__["razdel2"].'","'.htmlspecialchars(trim($value['name'])).'","","'.htmlspecialchars(trim($value['ed'])).'","'.htmlspecialchars(trim($value['count'])).'","'.htmlspecialchars(trim($value['price'])).'")');	
						$ID_D1=mysqli_insert_id($link);
					 }
					 //echo("!");
					 //добавляем материал к добавленной работе
					 
					 $table.='<tr class="material" rel_ma="'.$ID_D1.'">
           
           <td colspan="2" class="no_padding_left_ pre-wrap name_m"><div class="nm"><i></i><span class="s_j">'.htmlspecialchars(trim($value['name'])).'</span><span class="edit_panel_">';
		   if (($role->permission('Себестоимость','U'))or($sign_admin==1))
	       {
					 $table.='<span data-tooltip="редактировать материал" for="'.$ID_D1.'" class="edit_icon_m">3</span>';
		   }
					 
		   if (($role->permission('Себестоимость','D'))or($sign_admin==1))
	       {		 
				     $table.='<span data-tooltip="удалить материал" for="'.$ID_D1.'" class="del_icon_m">5</span>';
		   }
						 
				   $table.='</span></div></td>
<td class="pre-wrap"></td>
<td><span class="s_j">'.htmlspecialchars(trim($value['ed'])).'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim($value['count'])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(htmlspecialchars(trim($value['price'])), 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(($value['count']*$value['price']), 2, '.', ' '),'0'),'.').'</span></td>
<td></td>';
if(array_search('summa_r2_realiz',$stack_td) === false) 
{					 
$table.='<td></td>
<td></td>';
}
           $table.='</tr>';  
					 
					 
					 
				 }

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


$aRes = array("debug"=>$debug,"status"   => $status_ee,"table" =>  $table,"echo" =>  $echo,"id"=>$ID_D);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>