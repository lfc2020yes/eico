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

$id=ht($_GET["id"]);
$token=ht($_GET["tk"]);

//$query=htmlspecialchars($_GET['query']);
$dom=0;
$status_echo='';
//проверка что есть такой город что это число
//проверка что пользователь зарегистрирован

$echo_r=1; //выводить или нет ошибку 0 -нет
$debug='';

//**************************************************
if ( count($_GET) != 7 )
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
//**************************************************
if ((!isset($_GET["id"]))or((!is_numeric($_GET["id"])))) 
{
   $debug=h4a(4,$echo_r,$debug);
   goto end_code;	
}

if ((!isset($_GET["name"]))or($_GET["name"]=='')) 
{
   $debug=h4a(5,$echo_r,$debug);
   goto end_code;	
}

if ((!isset($_GET["ed"]))or($_GET["ed"]=='')) 
{
   $debug=h4a(6,$echo_r,$debug);
   goto end_code;	
}
if ((!isset($_GET["ss"]))or((!is_numeric($_GET["ss"])))) 
{
   $debug=h4a(7,$echo_r,$debug);
   goto end_code;	
}
/*
if ((!isset($_GET["group"]))or((!is_numeric($_GET["group"])))) 
{
   $debug=h4a(8,$echo_r,$debug);
   goto end_code;	
}
*/

if(!token_access_new($token,'add_material_invoice',$id,"rema",2880))
{
    $debug=h4a(111,$echo_r,$debug);
    goto end_code;
}


$result_t=mysql_time_query($link,'Select a.status from z_invoice as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{	
		$debug=h4a(9,$echo_r,$debug);
		goto end_code;
	
} else
{
	 
			 $row_t = mysqli_fetch_assoc($result_t);
		   
		     //проверяем может ли видеть этот наряд
		     if((($row_t["status"]!=1)))
		     { 
				    $debug=h4a(15,$echo_r,$debug);
                    goto end_code;	
			 }
}


$result_t2=mysql_time_query($link,'Select a.* from z_stock as a where a.name="'.htmlspecialchars(trim($_GET['name'])).'"');
$num_results_t2 = $result_t2->num_rows;
if($num_results_t2!=0)
{	
		$debug=h4a(25,$echo_r,$debug);
		goto end_code;
	
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


$os = array('шт','м3','м2','т','пог.м','маш/час','компл');
$os_id = array('0','1','2','3','4','5','6');

$name_ed='';
$rtyy=array_search(ht($_GET["ed"]), $os_id );
if ($rtyy !== false) {

    $name_ed=$os[$rtyy];

}


 mysql_time_query($link,'INSERT INTO z_stock (name,units,id_stock_group) VALUES ("'.htmlspecialchars(trim($_GET['name'])).'","'.htmlspecialchars(trim($name_ed)).'","'.htmlspecialchars(trim($_GET["group"])).'")');
$ID_P=mysqli_insert_id($link);	



mysql_time_query($link,'INSERT INTO z_invoice_material (id_invoice,id_acc,id_doc_material_acc,id_stock,count_units,price,price_nds,subtotal) VALUES ("'.htmlspecialchars(trim($_GET['id'])).'","'.htmlspecialchars(trim($number_acc)).'",NULL,"'.$ID_P.'","0","0","0","0")');

$ID_D=mysqli_insert_id($link);	



$echo.='<tr invoice_material="'.$ID_D.'" style="background-color:#f0f4f6;" class="jop">';

$echo.='<td class="no_padding_left_ pre-wrap one_td">
<div class="mild_dava_xx">
<div class="mild"><div class="mild_mild" data-tooltip="мягкая накладная">
<i class="select-mild"></i></div></div>
<div class="mild_dav"><div class="mild_mild_dav" data-tooltip="давальческий материал">
<i class="select-mild_dav"></i></div></div>


'.$_GET['name'].' <span class="invoice_units">('.$name_ed.')</span><div style="margin-right:10px;" class="font-ranks del_invoice_material" data-tooltip="Удалить материал" id_rel="'.$ID_D.'"><span class="font-ranks-inner">x</span><div></div></div>

<div id_rel="'.$ID_D.'" class="material_defect" data-tooltip="Добавить акт на отбраковку"><span>></span></div>	   
		
</div></td>';

$echo.='<td class="pre-wrap center_text_td"> -</td><td class="pre-wrap center_text_td">- </td><td class="pre-wrap center_text_td">- </td>';


	
$echo.='<td class="t_7 jk5"><div class="width-setter"><label style="display: inline;">КОЛ-ВО</label>

<input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][count]" max="" id="count_invoice_'.$_GET["ss"].'" class="input_f_1 input_100 white_inp label_s count_in_  count_mask   " autocomplete="off" value="0" type="text">

</div></td><td class="t_7 jk5"><div class="width-setter"><label style="display: inline;">БЕЗ НДС</label>

<input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][price]" id="price_invoice_'.$_GET["ss"].'" placeholder="" class="input_f_1 input_100 white_inp label_s price_in_  count_mask    " autocomplete="off" value="0" type="text">

</div></td><td class="t_7 jk5"><div class="width-setter"><label style="display: inline;">С НДС</label>

<input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][price_nds]" id="price_nds_invoice_'.$_GET["ss"].'" placeholder="" class="input_f_1 input_100 white_inp label_s price_nds_in_  count_mask    " autocomplete="off" value="0" type="text">

</div></td><td class="t_7 jk5"><span class="price_supply_ summa_ii"></span><input value="'.$ID_D.'" name="invoice['.$_GET["ss"].'][id]" type="hidden">
<input type=hidden value="0" class="defect_inp" name="invoice['.$_GET["ss"].'][defect]"><input type=hidden value="0" class="mild_inp" name="invoice['.$_GET["ss"].'][mild]">
<input type=hidden value="'.$ID_P.'" class="stock_inp" name="invoice['.$_GET["ss"].'][stock]"><input type=hidden value="0" class="prime_inp" name="invoice['.$_GET["ss"].'][prime]">

</td></tr>';

$class_aa = '';
$style_aa = '';

$echo.='<tr invoice_group="'.$ID_D.'" invoices_messa="'.$ID_D.'" class=" jop messa_invoice" style="display: none;"><td><span class="hsi">Акт на отбраковку<div></div></span><div class="del_invoice_akt" data-tooltip="Удалить акт" id_rel="'.$ID_D.'"><span class="font-ranks-inner">x</span><div></div></div></td><td style="padding:0px;white-space: nowrap">';

$echo.='<div style="display: inline-block" class="photo-akt-invoice"><div class="img_invoice_div1 js-image-gl"><div style="display: inline-block"><div class="list-image list-image-icons" ' . $style_aa . '></div></div><input type="hidden" class="js-files-acc-new" name="files_9" value=""><div type_load="7" id_object="' . $ID_D.'" data-tooltip="загрузить акт на отбраковку" class="invoice_upload js-upload-file js-helps ' . $class_aa . ' upload-but-2022" style="background-color: #fff !important;" ></div></div></div>';
/*
$echo.='<div class="img_akt"><ul></ul></div><div id_upload_a="'.$ID_D.'" data-tooltip="загрузить акт на отбраковку" class="add_akt_defect"></div><div class="b_loading_small_akt"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>';
*/

$echo.='</td><td colspan="2" style="padding:0px;white-space: nowrap">';

$echo.='<div style="display: inline-block" class=""><div class="img_invoice_div1 js-image-gl"><div style="display: inline-block"><div class="list-image list-image-icons" ' . $style_aa . '></div></div><input type="hidden" class="js-files-acc-new" name="files_9" value=""><div type_load="6" id_object="' . $ID_D . '" data-tooltip="загрузить фото с браком" class="invoice_upload js-upload-file js-helps ' . $class_aa . ' upload-but-2021" style="background-color: #fff !important;" ></div></div></div>';
/*
$echo.='<div class="img_akt1"><ul></ul></div><div id_upload_a1="'.$ID_D.'" data-tooltip="загрузить фото с браком" class="add_akt_defect1"></div><div class="b_loading_small_akt1"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>';
*/
$echo.='</td><td>

<div class="width-setter"><label style="display: inline;">КОЛ-ВО БРАКА</label><input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][count_defect]" id="count_invoice_defect_'.$_GET["ss"].'" class="input_f_1 akt_ss input_100 white_inp label_s count_defect_in_  count_mask   " autocomplete="off" value="0" type="text"></div></td><td colspan="3"><div class="width-setter"><input style="margin-top:0px;" name="invoice['.$_GET["ss"].'][text]" placeholder="Комментарий по браку" class="akt_ss input_f_1 input_100   white_inp label_s text_zayva_message_ " autocomplete="off" value="" type="text"></div></td></tr><tr class="loader_tr" style="height:2px;"><td colspan="8"></td></tr>';

$echo1='<form  class="form_up" id="upload_akt1_'.$ID_D.'" id_a="'.$ID_D.'" name="upload_akt1'.$ID_D.'"><input class="invoice_file_photo" type="file" name="myfilephoto'.$ID_D.'"></form>';	

$echo1.='<form  class="form_up" id="upload_akt_'.$ID_D.'" id_a="'.$ID_D.'" name="upload_akt'.$ID_D.'"><input class="invoice_file_akt" type="file" name="myfileakt'.$ID_D.'"></form>';

end_code:

$aRes = array("debug"=>$debug,"status"   => $status_ee,"status_echo"   => $status_echo,"echo1" => $echo1,"echo"=>$echo);
require_once $url_system.'Ajax/lib/Services_JSON.php';
$oJson = new Services_JSON();
//функция работает только с кодировкой UTF-8
echo $oJson->encode($aRes);


?>