<?php
//история нарядов по определенной работе

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



  if(((isset($_GET['id']))and(is_numeric($_GET['id']))))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		if (($role->permission('Себестоимость','R'))or($sign_admin==1))  
		{
	   $result_t1=mysql_time_query($link,'Select a.*,b.date_doc,b.numer_doc,b.id as idd  from n_work as a,n_nariad as b where b.signedd_nariad=1 and a.id_nariad=b.id and a.id_razdeel2="'.htmlspecialchars(trim($id)).'" order by b.date_doc');
			
		//echo('Select a.*,b.date_doc,b.numer_doc,b.id as idd  from n_work as a,n_nariad as b where b.signedd_nariad=1 and a.id_nariad=b.id and a.id_razdeel2="'.htmlspecialchars(trim($id)).'" order by b.date_doc');
			
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
		  $sum=0;
		  for ($i=0; $i<$num_results_t1; $i++)
          {  
			  
		   //такой раздел есть можно проверять переданные переменные
		   $row_t = mysqli_fetch_assoc($result_t1);
		   if($i==0)
		 {
		   $Ostalos=$row_t["count_units_razdel2"];
			$price=$row_t["price_razdel2"];
		 }
			$sum=$sum+$row_t["price"];  
		   $echo.='<tr work="'.$id.'" style="background-color:rgba(255, 236, 87, 0.7);" class="jop1 mat histtory" rel_h="'.$id.'">
                  <td class="no_padding_left_ pre-wrap one_td"><div class="nm11">
	
	<div class="font-rank2"><span class="font-rank-inner2">'.($i+1).'</span></div>
	<span class="s_j" style="float:left; margin-left:15px; margin-top:3px">'.MaskDate($row_t["date_doc"]).'</span><a href="finery/'.$row_t["idd"].'/" class="nariad_link">№'.$row_t["idd"].'</a></div></td>';
	//<td class="pre-wrap center_text_td"><100%</td>
 $echo.='<td class="pre-wrap center_text_td">'.$row_t["units"].'</td>
<td style="padding-left:30px;">';

		  
			  
$Ostalos=$Ostalos-$row_t["count_units"];
if($row_t["count_units_razdel2"]<$row_t["count_units"])	
{
$echo.='<span class="morr">'.rtrim(rtrim(number_format($row_t["count_units"], 2, '.', ' '),'0'),'.').'</span>';
} else
{
	$echo.=''.rtrim(rtrim(number_format($row_t["count_units"], 2, '.', ' '),'0'),'.');
}
	
$echo.='</td>
<td style="padding-left:30px;">';
if($row_t["price_razdel2"]<$row_t["price"])	
{
$echo.='<span class="morr">'.rtrim(rtrim(number_format($row_t["price"], 2, '.', ' '),'0'),'.').'</span>';
} else
{
	$echo.=''.rtrim(rtrim(number_format($row_t["price"], 2, '.', ' '),'0'),'.');
}			  
$echo.='</td>
<td><span class="s_j">'.rtrim(rtrim(number_format(($row_t["price"]*$row_t["count_units"]), 2, '.', ' '),'0'),'.').'</span></td>

<td></td>
           </tr>';
					  
		  }
		   $status_ee='ok';
		   
		  //итоговые суммы
		  $sum=($sum/$i);	
		   $echo.='<tr work="'.$id.'" style="" class="jop1 mat histtory itog" rel_h="'.$id.'">
                  <td class="no_padding_left_ pre-wrap one_td">Итого осталось</td>';
	//<td class="pre-wrap center_text_td"></td>
$echo.='<td class="pre-wrap center_text_td"></td>
<td style="padding-left:30px;">'.rtrim(rtrim(number_format($Ostalos, 3, '.', ' '),'0'),'.').'</td>
<td style="padding-left:20px;">~';
	if($price<$sum)	
{	  
	$echo.='<span class="morr">'.rtrim(rtrim(number_format($sum, 2, '.', ' '),'0'),'.').'</span></td>';
} else
{
		   $echo.=''.rtrim(rtrim(number_format($sum, 2, '.', ' '),'0'),'.').'</td>';	
}

$echo.='<td style="padding-left:0px;"><span class="s_j">~'.rtrim(rtrim(number_format($sum*$Ostalos, 2, '.', ' '),'0'),'.').'</span></td>

<td></td>
           </tr>'; 
		   
		   
	   }

	  }
	  } else
	  {
		  $status_ee='reg';
	  }
	  
  }

//}


$aRes = array("debug"=>$debug,"status"   => $status_ee,"echo" =>  $echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>