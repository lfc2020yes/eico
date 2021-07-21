<?php
//получение материалов из счета при выборе текущего счета

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';
header("Content-type: application/json");

$status_ee='error';
$eshe=0;
$echo='';
$vid=0;
$debug='';
$count_all_all=0;
$basket='';

//$query=htmlspecialchars($_GET['query']);
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=1; //выводить или нет ошибку 0 -нет
$debug='';
$id=ht($_GET["id"]);
$token=ht($_GET["tk"]);

//**************************************************
if ( count($_GET) != 6 )
{
   $debug=h4a(1,$echo_r,$debug);
   goto end_code;	
}
//**************************************************
 if ((!$role->permission('Накладные','A'))and($sign_admin!=1))
{
  $debug=h4a(2,$echo_r,$debug);
  goto end_code;	
}
//**************************************************
 if(!isset($_SESSION["user_id"]))
{ 
  $status_ee='reg';	
  $debug=h4a(3,$echo_r,$debug);
  goto end_code;
}

if(!token_access_new($token,'add_material_invoice',$id,"rema",2880))
{
    $debug=h4a(111,$echo_r,$debug);
    goto end_code;
}


//**************************************************
if ((!isset($_GET["id"]))or((!is_numeric($_GET["id"])))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}

if ((!isset($_GET["demo"]))or((!is_numeric($_GET["demo"])))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}

if ((!isset($_GET["ss"]))or((!is_numeric($_GET["ss"])))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}

$result_t=mysql_time_query($link,'Select a.status from z_invoice as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{	
		$debug=h4a(7,$echo_r,$debug);
		goto end_code;
	
} else
{
	 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд
		     if((($row_t["status"]!=1)))
		     { 
				    $debug=h4a(5,$echo_r,$debug);
                    goto end_code;	
			 }
}


$result_t2=mysql_time_query($link,'Select a.* from z_stock as a where a.id="'.htmlspecialchars(trim($_GET['demo'])).'"');
$num_results_t2 = $result_t2->num_rows;
if($num_results_t2==0)
{	
		$debug=h4a(5,$echo_r,$debug);
		goto end_code;
	
} else
{
	$row_t2 = mysqli_fetch_assoc($result_t2);
}
//**************************************************
//**************************************************
/*
if(($row_t["id_user"]!=$id_user)and($sign_admin!=1))
{ 
	    $debug=h4a(7,$echo_r,$debug);
		goto end_code;	
}
*/
//**************************************************
//**************************************************
//**************************************************


$status_ee='ok';

$number_acc='';
if ((isset($_GET["number"]))and((is_numeric($_GET["number"])))) 
{
	$result_t1=mysql_time_query($link,'Select a.status,a.number,a.date,a.id from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['number'])).'"');
    $num_results_t1 = $result_t1->num_rows;
    if($num_results_t1!=0)
    {
		$row_t1 = mysqli_fetch_assoc($result_t1);
		if(($row_t1["status"]==3)or($row_t1["status"]==4))
		{
			$number_acc=$_GET["number"];
			$date_graf2  = explode("-",$row_t1["date"]);
			
			
			//подсказки по количеству и сумме которые еще не доставили по этому счету
			
			$summ=0;
			$summ1=0;
			$result_url2=mysql_time_query($link,'select sum(A.count_material) as cc,sum(A.price_material) as cc1,count(A.price_material) as cc2   from z_doc_material_acc as A,z_doc_material as B where A.id_doc_material=B.id and B.id_stock="'.htmlspecialchars(trim($_GET['demo'])).'" and A.id_acc="'.htmlspecialchars(trim($_GET['number'])).'"');

                  $num_results_custom_url2 = $result_url2->num_rows;
                  if($num_results_custom_url2!=0)
                  {
			         $row_list3 = mysqli_fetch_assoc($result_url2);
					  if($row_list3["cc"]!='')
					  {
						  $summ=round($row_list3["cc"],3);
					  }
					  if(($row_list3["cc1"]!='')and($row_list3["cc"]!='')and($row_list3["cc"]!=0))
					  {
						  $summ1=round($row_list3["cc1"]/$row_list3["cc2"],3);
					  }
		          }	
			
			
			
			$PROC=0;	
			   $result_proc=mysql_time_query($link,'select sum(a.count_units) as summ,sum(a.count_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="'.htmlspecialchars(trim($_GET['number'])).'" and a.id_stock="'.htmlspecialchars(trim($_GET['demo'])).'"');
                
	           $num_results_proc = $result_proc->num_rows;
               if($num_results_proc!=0)
               {
		          $row_proc = mysqli_fetch_assoc($result_proc);
				   				   
				  $result_proc1=mysql_time_query($link,'select sum(a.count_material) as ss from z_doc_material_acc as a,z_doc_material as b where a.id_doc_material=b.id and a.id_acc="'.htmlspecialchars(trim($_GET['number'])).'" and b.id_stock="'.htmlspecialchars(trim($_GET['demo'])).'"');	
				  $num_results_proc1 = $result_proc1->num_rows;
				   
				  if($num_results_proc1!=0)
                  { 				   
				    $row_proc1 = mysqli_fetch_assoc($result_proc1); 
				  }
				   
				  if($row_proc1["ss"]!=0)
				  {
		            $PROC=round($row_proc1["ss"]-($row_proc["summ"]-$row_proc["summ1"]),3); 					  
				  }
				   
	           } 
			
			
			
			
		}
	}
}


mysql_time_query($link,'INSERT INTO z_invoice_material (id_invoice,id_acc,id_stock,count_units,price,price_nds,subtotal) VALUES ("'.htmlspecialchars(trim($_GET['id'])).'","'.htmlspecialchars(trim($number_acc)).'","'.htmlspecialchars(trim($_GET['demo'])).'","0","0","0","0")');

$ID_D=mysqli_insert_id($link);	



$echo.='<tr invoice_material="'.$ID_D.'" style="background-color:#f0f4f6;" class="jop">';

$echo.='<td class="no_padding_left_ pre-wrap one_td">'.$row_t2["name"].' <span class="invoice_units">('.$row_t2["units"].')</span><div style="margin-right:10px;" class="font-ranks del_invoice_material" data-tooltip="Удалить материал" id_rel="'.$ID_D.'"><span class="font-ranks-inner">x</span><div></div></div><div id_rel="'.$ID_D.'" class="material_defect" data-tooltip="Добавить акт на отбраковку"><span>></span></div></td>';
if($number_acc!='')
{
	$echo.='<td class="pre-wrap center_text_td number_st_invoice"><a class="link-acc-2021" href="acc/'.$row_t1["id"].'/">'.$row_t1["number"].'</a></td><td class="pre-wrap center_text_td invoice_units">'.$date_graf2[2].'.'.$date_graf2[1].'.'.$date_graf2[0].'</td><td class="pre-wrap center_text_td count_st_invoice">'.$summ.'</td>';
	
	
} else
{
	$echo.='<td class="pre-wrap center_text_td"> -</td><td class="pre-wrap center_text_td">- </td><td class="pre-wrap center_text_td">- </td>';
}

	
$echo.='<td class="t_7 jk5"><div class="width-setter"><label style="display: inline;">КОЛ-ВО</label>';
if($number_acc!='')
{
	$echo.='<input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][count]" max="'.$PROC.'" id="count_invoice_'.$_GET["ss"].'" class="input_f_1 input_100 white_inp label_s count_in_  count_mask   " autocomplete="off" value="" type="text" placeholder="'.$PROC.'">';
} else
{

$echo.='<input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][count]" max="'.$summ.'" id="count_invoice_'.$_GET["ss"].'" class="input_f_1 input_100 white_inp label_s count_in_  count_mask   " autocomplete="off" value="0" type="text">';
	
}

$echo.='</div></td><td class="t_7 jk5"><div class="width-setter"><label style="display: inline;">БЕЗ НДС</label>

<input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][price]" id="price_invoice_'.$_GET["ss"].'" placeholder="" class="input_f_1 input_100 white_inp label_s price_in_  count_mask    " autocomplete="off" value="0" type="text">

</div></td><td class="t_7 jk5"><div class="width-setter"><label style="display: inline;">С НДС</label>';
if($number_acc!='')
{
$echo.='<input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][price_nds]" id="price_nds_invoice_'.$_GET["ss"].'" placeholder="'.$summ1.'" class="input_f_1 input_100 white_inp label_s price_nds_in_  count_mask    " autocomplete="off" value="" type="text">';
} else
{
$echo.='<input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][price_nds]" id="price_nds_invoice_'.$_GET["ss"].'" placeholder="" class="input_f_1 input_100 white_inp label_s price_nds_in_  count_mask    " autocomplete="off" value="0" type="text">';	
}

$echo.='</div></td><td class="t_7 jk5"><span class="price_supply_ summa_ii"></span><input value="'.$ID_D.'" name="invoice['.$_GET["ss"].'][id]" type="hidden">
<input type=hidden value="0" class="defect_inp" name="invoice['.$_GET["ss"].'][defect]">
<input type=hidden value="'.htmlspecialchars(trim($_GET['demo'])).'" class="stock_inp" name="invoice['.$_GET["ss"].'][stock]">
</td></tr>';



$echo.='<tr invoice_group="'.$ID_D.'" invoices_messa="'.$ID_D.'" class=" jop messa_invoice" style="display: none;"><td><span class="hsi">Акт на отбраковку<div></div></span><div class="del_invoice_akt" data-tooltip="Удалить акт" id_rel="'.$ID_D.'"><span class="font-ranks-inner">x</span><div></div></div></td><td style="padding:0px;white-space: nowrap"><div class="img_akt"><ul></ul></div><div id_upload_a="'.$ID_D.'" data-tooltip="загрузить акт на отбраковку" class="add_akt_defect"></div><div class="b_loading_small_akt"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div></td><td colspan="2" style="padding:0px;white-space: nowrap"><div class="img_akt1"><ul></ul></div><div id_upload_a1="'.$ID_D.'" data-tooltip="загрузить фото с браком" class="add_akt_defect1"></div><div class="b_loading_small_akt1"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div></td><td><div class="width-setter"><label style="display: inline;">КОЛ-ВО БРАКА</label><input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][count_defect]" id="count_invoice_defect_'.$_GET["ss"].'" class="input_f_1 akt_ss input_100 white_inp label_s count_defect_in_  count_mask   " autocomplete="off" value="0" type="text"></div></td><td colspan="3"><div class="width-setter"><input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][text]" placeholder="Комментарий по браку" class="akt_ss input_f_1 input_100   white_inp label_s text_zayva_message_ " autocomplete="off" value="" type="text"></div></td></tr><tr class="loader_tr" style="height:2px;"><td colspan="8"></td></tr>';
/*
$echo1='<form  class="form_up" id="upload_akt1_'.$ID_D.'" id_a="'.$ID_D.'" name="upload_akt1'.$ID_D.'"><input class="invoice_file_photo" type="file" name="myfilephoto'.$ID_D.'"></form>';	
$echo1.='<form  class="form_up" id="upload_akt_'.$ID_D.'" id_a="'.$ID_D.'" name="upload_akt'.$ID_D.'"><input class="invoice_file_akt" type="file" name="myfileakt'.$ID_D.'"></form>';
*/
end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"echo1" => $echo1,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>