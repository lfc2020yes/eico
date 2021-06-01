<?php
//форма удаления  наряда который уже оформлен

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';


//создание секрет для формы
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;

$status=0;
//$dom=0;
$id=htmlspecialchars($_GET['id']);

//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) ==1)and(isset($_GET["id"]))and((is_numeric($_GET["id"])))) 
{
    //
	

  if(((isset($_GET['id']))and(is_numeric($_GET['id']))))
  {
	  if(isset($_SESSION["user_id"]))
	  { 
	     //возможно проверка на доступ к этому действию для данного пользователя. можно ли ему это выполнять или нет
		if (($role->permission('Себестоимость','R'))or($sign_admin==1))  
		{
		
	
	    //составление секретного ключа формы
		//составление секретного ключа формы		
		//$token=token_access_compile($_GET['id'],'dell_naryd_x',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы
	   
	   //существует ли такой наряд
	   			    
		   
		   $status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal table-modal"><div class="box-modal-pading"><div class="box-modal_close arcticmodal-close"></div>
			<span class="clock_table"></span>
<?
			echo'<h1 class="h111" mor="" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>История реализации работы по себестоимости</span></h1>';

		
	   $result_t1=mysql_time_query($link,'Select a.*,b.date_doc,b.numer_doc,b.id as idd  from n_work as a,n_nariad as b where b.signedd_nariad=1 and a.id_nariad=b.id and a.id_razdeel2="'.htmlspecialchars(trim($id)).'" order by b.date_doc');
			
		//echo('Select a.*,b.date_doc,b.numer_doc,b.id as idd  from n_work as a,n_nariad as b where b.signedd_nariad=1 and a.id_nariad=b.id and a.id_razdeel2="'.htmlspecialchars(trim($id)).'" order by b.date_doc');
			
       $num_results_t1 = $result_t1->num_rows;
	   if($num_results_t1!=0)
	   {  
		  		   echo'<table id="" class="smeta1 smeta_history" cellspacing="0" cellpadding="0" border="0"><thead>
		   <tr class="title_smeta"><th class="t_2 no_padding_left_ jk4">Дата/Наряд</th><th class="t_4 jk44">ед. изм.</th><th class="t_5">кол-во</th><th class="t_6">стоимость ед. (руб.)</th><th class="t_7 jk5">всего (руб.)</th></tr></thead><tbody>'; 
		   
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
		   echo'<tr work="'.$id.'" style="background-color:rgba(255, 236, 87, 0.7);" class="jop1 mat histtory" rel_h="'.$id.'">
                  <td class="no_padding_left_ pre-wrap one_td"><div class="nm11">
	
	<div class="font-rank2"><span class="font-rank-inner2">'.($i+1).'</span></div>
	<span class="s_j" style="float:left; margin-left:15px; margin-top:7px">'.MaskDate($row_t["date_doc"]).'</span><a href="finery/'.$row_t["idd"].'/" class="nariad_link">№'.$row_t["idd"].'</a></div></td>';
	//<td class="pre-wrap center_text_td"><100%</td>
 echo'<td class="pre-wrap center_text_td">'.$row_t["units"].'</td>
<td style="padding-left:30px;">';

		  
			  
$Ostalos=$Ostalos-$row_t["count_units"];
if($row_t["count_units_razdel2"]<$row_t["count_units"])	
{
echo'<span class="morr">'.rtrim(rtrim(number_format($row_t["count_units"], 2, '.', ' '),'0'),'.').'</span>';
} else
{
echo''.rtrim(rtrim(number_format($row_t["count_units"], 2, '.', ' '),'0'),'.');
}
	
echo'</td>
<td style="padding-left:30px;">';
if($row_t["price_razdel2"]<$row_t["price"])	
{
echo'<span class="morr">'.rtrim(rtrim(number_format($row_t["price"], 2, '.', ' '),'0'),'.').'</span>';
} else
{
	echo''.rtrim(rtrim(number_format($row_t["price"], 2, '.', ' '),'0'),'.');
}			  
echo'</td>
<td><span class="s_j">'.rtrim(rtrim(number_format(($row_t["price"]*$row_t["count_units"]), 2, '.', ' '),'0'),'.').'</span></td>


           </tr>';
					  
		  }
		   $status_ee='ok';
		   
		  //итоговые суммы
		  $sum=($sum/$i);	
		   echo'<tr work="'.$id.'" style="" class="jop1 mat histtory itog" rel_h="'.$id.'">
                  <td class="no_padding_left_ pre-wrap one_td">Итого осталось</td>';
	//<td class="pre-wrap center_text_td"></td>
echo'<td class="pre-wrap center_text_td"></td>
<td style="padding-left:30px;">'.rtrim(rtrim(number_format($Ostalos, 3, '.', ' '),'0'),'.').'</td>
<td style="padding-left:20px;">~';
	if($price<$sum)	
{	  
	echo'<span class="morr">'.rtrim(rtrim(number_format($sum, 2, '.', ' '),'0'),'.').'</span></td>';
} else
{
		   echo''.rtrim(rtrim(number_format($sum, 2, '.', ' '),'0'),'.').'</td>';	
}

echo'<td style="padding-left:0px;"><span class="s_j">~'.rtrim(rtrim(number_format($sum*$Ostalos, 2, '.', ' '),'0'),'.').'</span></td>

           </tr>'; 
		

		   
		   
		   echo'</tbody></table>';
		   
	   } else
	   {
		   
	echo'<div class="comme">По этой работе пока нет истории по реализации</div>';
	   
		   
	   }

			
			
			
		
?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';
			?>
            

			<br>
 <div class="over">           

<div id="no_rd" class="no_button"><i>Закрыть</i></div>            
 </div>           
<input type=hidden name="ref" value="00">
            </form>
            </span></div>
            
            </div>		
<?
		   } 
	   
	   
	
	}

	}
	  
}
if($status==0)
{
	//что то не так. Почему то бронировать нельзя
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");    
	die ();	
}
/*

						 $datetime1 = date_create('Y-m-d');
                         $datetime2 = date_create('2017-01-17');
						 
                         $interval = date_create(date('Y-m-d'))->diff( $datetime2	);				 
                         $date_plus=$interval->days;
						 */
						 //echo(dateDiff_(date('Y-m-d'),'2017-01-17'));
						 


?>
<script type="text/javascript">initializeTimer();</script>
<?
include_once $url_system.'template/form_js.php';
?>

