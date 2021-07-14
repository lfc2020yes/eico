<?php
//форма добавления нового счета 

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';



$status=0;


if((!isset($_SESSION["user_id"]))or(!is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
{	
	goto end_code;
}

$id_user=id_key_crypt_encrypt($_SESSION["user_id"]);

//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) != 0)or(!isset($_COOKIE['basket_supply_'.htmlspecialchars(trim($id_user))]))or(($_COOKIE['basket_supply_'.htmlspecialchars(trim($id_user))]==''))) 
{
	goto end_code;	
}	

if ((!$role->permission('Счета','A'))and($sign_admin!=1))
{
    goto end_code;	
}
//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id_user'],'add_soply',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;
	   
	   
?>
<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd2 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

            <?
            echo'<h1 class="h111 gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id_user'])).'"><span>Добавление нового счета</span><span class="clock_table"></span></h1></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

            echo'<div class="na-100">

<form class="js-form-prime" id="form_prime_add_block" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

            echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id_user'])).'" name="id">';
            echo'<input type="hidden" value="'.$token.'" name="tk">';
            echo'<input name="tk1" value="weER23Dvmrw3E" type="hidden">';

            ?>

            <span class="hop_lalala" >
            <?
            //echo($_GET["url"]);
            echo'';


            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Номер счета</i><span>*</span></label><input name="number_soply1" value="" class="input_new_2021 gloab required  no_upperr js-number-acc-new" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Дата счета</i><span>*</span></label><input name="date_soply" value="" class="input_new_2021 gloab required  no_upperr date_picker_x" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Срок поставки в днях</i><span>*</span></label><input name="date_soply1" value="" class="input_new_2021 gloab required  no_upperr mask-count" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';


            echo'<div class="js-more-options-supply">';
                    echo'<!--input start	-->		
<div class="password_acc">
<div id="0" class="input-choice-click-pass js-password-acc js-type-soft-view active_pass">
<div class="choice-head">поставщик</div>
<div class="choice-radio"><div class="center_vert1"><i class="active_task_cb"></i></div></div>
</div>	

<div id="1" class="input-choice-click-pass js-password-acc js-type-soft-view">
<div class="choice-head">Новый поставщик</div>
<div class="choice-radio"><div class="center_vert1"><i></i></div></div>
</div>
<input name="new_contractor_" class="js-type-soft-view1" value="0" type="hidden">	
</div>		
<!--input end -->';

                    //существующий поставщик
echo'<div class="js-options-supply-0">';


                   $su_5_name='';
                    $su_5='';

                    echo'<!--input start	-->';

                    echo'<div class=" big_list">';
                    //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

                    echo'<div class="list_2021 input_2021 input-search-list gray-color js-zindex" list_number="box2"><i class="js-open-search"></i><span class="click-search-name"></span><div class="b_loading_small loader-list-2021"></div><label>Поиск поставщика (название/инн)</label><input name="kto" value="'.$su_5_name.'" id="date_124" sopen="search_contractor" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 25px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search gloab2" name="id_kto" id="search_items_5"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';



                    $result_work_zz=mysql_time_query($link,'SELECT A.name,A.id,A.inn FROM z_contractor as A ORDER BY A.name limit 0,40');



                    $num_results_work_zz = $result_work_zz->num_rows;
                    if($num_results_work_zz!=0)
                    {
                        //echo'<li><a href="javascript:void(0);" rel="0"></a></li>';
                        for ($i=0; $i<$num_results_work_zz; $i++)
                        {
                            $row_work_zz = mysqli_fetch_assoc($result_work_zz);

                            $yop='';
                            if($row_work_zz["id"]==$su_5) {
                                $yop='sel_active';
                            }

                            echo'<li class="'.$yop.'"><a href="javascript:void(0);" rel="'.$row_work_zz["id"].'">'.$row_work_zz["name"].' <span class="gray-date">(ИНН-'.$row_work_zz["inn"].')</span></a></li>';

                        }
                    }

                    echo'</ul><div class="div_new_2021"><div class="oper_name"></div></div></div></div><!--input end	-->';






echo'</div>';


//новый поставщик
                    echo'<div class="js-options-supply-1 option-new-contractor none">';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Название поставщика</i><span>*</span></label><input name="name_contractor" value="" class="input_new_2021 gloab1 required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

                        echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Адрес поставщика</i><span>*</span></label><input name="address_contractor" value="" class="input_new_2021 gloab1 required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

                                    echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>ИНН поставщика</i><span>*</span></label><input name="inn_contractor" value="" class="input_new_2021 gloab1 required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

                    echo'</div>';

            echo'</div>';


                    echo'<!--input start-->
<div class="margin-input" style="margin-top: 20px;"><div class="input_2018 input_2018_resize  gray-color '.iclass_("comm_b",$stack_error,"required_in_2018").'"><label><i>Комментарий</i></label><div class="otziv_add js-resize-block"><textarea cols="10" rows="1" name="text_comment" class="di input_new_2018  text_area_otziv js-autoResize "></textarea></div><div class="div_new_2018"><div class="error-message"></div></div></div></div>
<!--input end	-->';


echo'<span class="h3-f h-25">Материалы из заявок содержащиеся в счете</span><input type="hidden" name="mat_bill_" class="input_option_xvg mat_bill_" value="1">';


		$sql='';
	if (( isset($_COOKIE["basket_supply_".$id_user]))and($_COOKIE["basket_supply_".$id_user]!=''))
	{
		$D = explode('.', $_COOKIE["basket_supply_".$id_user]);
		for ($ir=0; $ir<count($D); $ir++)
		{
			if($ir==0)
			{
				$sql.='"'.$D[$ir].'"';
			} else
			{
				$sql.=', "'.$D[$ir].'"';
			}
		}
	}

	//echo($sql);

  //$result_t2=mysql_time_query($link,'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where b.id IN ('.$sql.') and c.id=b.id_i_material and a.id=b.id_doc');
$result_t2=mysql_time_query($link,'Select  b.id_stock,b.id,a.name,a.id as id_doc from z_doc as a,z_doc_material as b,i_material as c where b.id IN ('.$sql.') and c.id=b.id_i_material and a.id=b.id_doc');

  //echo'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where b.id IN ('.$sql.') and c.id=b.id_i_material and a.id=b.id_doc';


  $num_results_t2 = $result_t2->num_rows;
  if($num_results_t2!=0)
  {

echo'<div class="xvg_add_material option_slice_xxg active_xxg">';
	  $ddf=1;
	  for ($ksss=0; $ksss<$num_results_t2; $ksss++)
      {

		$row__2= mysqli_fetch_assoc($result_t2);
		  $rr=$ksss+1;
	/*
		$result_url_m=mysql_time_query($link,'select A.material,A.units from i_material as A where A.id="'.htmlspecialchars(trim($row__2["id_i_material"])).'"');
        $num_results_custom_url_m = $result_url_m->num_rows;
        if($num_results_custom_url_m!=0)
        {
			$row_material = mysqli_fetch_assoc($result_url_m);

		}
		*/

		  	$result_work_zz=mysql_time_query($link,'
			SELECT a.count_units AS ss,
c.price AS mm,
c.units
FROM 
z_doc_material AS a,
i_material AS c
WHERE 
a.id_i_material=c.id AND
a.id="'.$row__2["id"].'"');

		    $num_results_work_zz = $result_work_zz->num_rows;
	        if($num_results_work_zz!=0)
	        {
		        $id_work=0;

			    $row_work_zz = mysqli_fetch_assoc($result_work_zz);
				   //echo('<div>'.$row_work_zz['count_units'].' '.$row_material['units'].'</div>');

		/*
		$result_url=mysql_time_query($link,'select A.* from z_stock as A where A.id="'.htmlspecialchars(trim($row__2["id_stock"])).'"');
			   //echo('select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_work_zz["id_object"])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url!=0)
        {
			$row_list1 = mysqli_fetch_assoc($result_url);


		}
		*/
		$xmd='';
		$result_t3=mysql_time_query($link,'SELECT a.id
FROM 
z_doc_material AS a
WHERE 
a.id="'.$row__2["id"].'"');
  		$num_results_t3 = $result_t3->num_rows;
        if($num_results_t3!=0)
        {
			for ($op=0; $op<$num_results_t3; $op++)
            {
		       $row__3= mysqli_fetch_assoc($result_t3);
		       if($op==0) {$xmd=$row__3["id"];} else {$xmd=$xmd.'.'.$row__3["id"];}
	        }
		}



					  if($row__2["id_stock"]!='')
					 {
					 $result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row__2["id_stock"].'"');
			        $num_results_t1__341 = $result_t1__341->num_rows;
	                if($num_results_t1__341!=0)
	                {
		              $row1ss__341 = mysqli_fetch_assoc($result_t1__341);
					}
					 }



                echo'<div class="js-acc-block items_acc_basket   " yi_sopp_="'.$row__2["id"].'">
                <input type="hidden" value="'.$row__2["id"].'" name="material['.$rr.'][stock]">
					 <input type="hidden" value="'.$xmd.'" class="xvg_material_doc" name="material['.$rr.'][xmd]">
                <div class="name-user-57"><span class="label-task-gg ">Название
</span><div class="h57-2020"><span class="name-items">'.$row1ss__341["name"].'</span>
                <a href="app/'.$row__2["id_doc"].'/" class="app-items" data-tooltip="Для заявки">'.$row__2["name"].'</a></div>
            
</div>
<div class="tender-date"><span class="label-task-gg ">Единица измерения
</span>
                <span class="item-ed">'.$row_work_zz['units'].'</span>
</div>

<div class="tender-col">';
            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Кол-во (MAX '.$row_work_zz['ss'].')</i><span>*</span></label><input  name="material['.$rr.'][count]" value="" count="'.$row__2["id"].'" max="'.$row_work_zz['ss'].'" class="input_new_2021 gloab required  no_upperr count_mask count_xvg_ " style="padding-right: 20px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';
 echo'</div>               
  
 <div class="tender-col">';

             echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Цена (MAX '.$row_work_zz['mm'].')</i><span>*</span></label><input  name="material['.$rr.'][price]" value="" price="'.$row__2["id"].'" data-tooltip="Цена в счете за единицу с ндс" max="'.$row_work_zz['mm'].'" class="input_new_2021 gloab required  no_upperr money_mask1 price_xvg_" style="padding-right: 20px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

 echo'</div>  
    <div class="tender-summ all_price_count_xvg"><span class="pay_summ_bill1">0</span>
 </div>               
                <div class="tender-but" style="padding-left: 10px;"><div id_rel="'.$row__2["id"].'" class="del-item js-del-items-basket del_basket_joo" data-tooltip="Удалить из счета"></div></div>
                
                
                
                </div>';




/*
					 echo'<div class="xvg_material" yi_sopp_="'.$row__2["id"].'">
					 <input type="hidden" value="'.$row__2["id"].'" name="material['.$rr.'][stock]">	
					 <input type="hidden" value="'.$xmd.'" class="xvg_material_doc" name="material['.$rr.'][xmd]">	
			  <div class="table w_mat">
			      <div class="table-cell name_wall wall1">'.$row1ss__341["name"].'<div class="font-rank del_basket_joo" id_rel="'.$row__2["id"].'"><span class="font-rank-inner">x</span></div></div>
				  <div class="table-cell name_wall wall2">'.$row_work_zz['units'].'</div>
				  <div class="table-cell name_wall wall3"><div class="width-setter xvg_pp"><label>MAX('.$row_work_zz['ss'].')</label><input count="'.$row__2["id"].'" style="margin-top:0px;" data-tooltip="Количество в счете"  name="material['.$rr.'][count]" max="'.$row_work_zz['ss'].'" placeholder="MAX - '.$row_work_zz['ss'].'" class="input_f_1 input_100 white_inp label_s count_mask count_xvg_ jj_number" autocomplete="off" type="text" value=""></div></div>
				  
				  
			      <div class="table-cell count_wall wall4"><div class="width-setter xvg_pp"><label>MAX('.$row_work_zz['mm'].')</label><input price="'.$row__2["id"].'" style="margin-top:0px;" data-tooltip="Цена в счете за единицу с ндс"  name="material['.$rr.'][price]" max="'.$row_work_zz['mm'].'" placeholder="MAX - '.$row_work_zz['mm'].'" class="input_f_1 input_100 white_inp label_s count_mask price_xvg_ jj_number" autocomplete="off" type="text" value=""></div></div>
				  <div class="table-cell name_wall wall6 all_price_count_xvg "><span class="pay_summ_bill1"></span></div>
				  
			  </div>
			</div>';
*/
					/*
					<div class="width-setter"><label>MAX('.$ostatok.')</label><input style="margin-top:0px;" all="'.$row1ss["count_units"].'" name="mat_zz['.$i.'][count]" max="'.$ostatok.'" placeholder="MAX - '.$ostatok.'" class="input_f_1 input_100 white_inp label_s count_app_mater_ '.iclass_($row1ss["id"].'_w_count',$stack_error,"error_formi").'" autocomplete="off" type="text" value="'.ipost_($_POST['mat_zz'][$i]["count"],"").'"></div>
					*/
					/*
					echo'<tr yi_sopp_="'.$row_work_zz['id'].'"><td>';



					echo'<span class="number_basket_soply">№'.$ddf.'</span>';
					$ddf++;
					//echo $row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')';

					echo'</td><td>';

					echo'<div class="nmss supl">'.$row_material["material"].'</div>';

		if($row__2["id_stock"]!='')
					 {
					 $result_t1__341=mysql_time_query($link,'Select a.*  from z_stock as a where a.id="'.$row__2["id_stock"].'"');
			        $num_results_t1__341 = $result_t1__341->num_rows;
	                if($num_results_t1__341!=0)
	                {
		              $row1ss__341 = mysqli_fetch_assoc($result_t1__341);
					  echo'<span data-tooltip="название товара на складе" class="stock_name_mat">'.$row1ss__341["name"].'</span>';
					} else
					{
					   echo'<span class="stock_name_mat">не связан с товаром на складе</span>';
					}
					 } else
					{
					   echo'<span class="stock_name_mat">не связан с товаром на складе</span>';
					}
					//error_formi

					echo'</td><td class="bold_soply"><label>Необходимо</label><div style="margin-top:19px;">'.$row_work_zz['count_units'].' '.$row_material['units'].'</div></td><td class="bold_soply"><label>Количество в счете</label><input id_jj="'.$row_work_zz['id'].'" name="number_ryyy" id="number_ryy" class="input_f_1 input_100 white_inp count_mask jj_number " autocomplete="off" type="text"></td>';
					echo'<td><label>Объект</label>'.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</td><td><div class="font-rank del_basket_joo" id_rel="'.$row_work_zz['id'].'"><span class="font-rank-inner">x</span></div></td></tr>';
				*/

		    }
	  }



	  echo'<div class="all_xvg none"><div class="all-xvg-2021">
			      <div class=" wall--1">Итого по счету</div>
				  <div class=" wall--6 all_summa_xvg"><span class="pay_summ_bill1"></span></div>
				  
			  </div></div>
	  ';






	  echo'</div>';
  }





            echo'<span class="h3-f h-25">Загрузить счет</span>';

            //загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо
            $class_aa='';
            $style_aa='';

            echo'<div class="input-block-2020">';

            echo'<div class="margin-input"><div class="img_invoice_div js-image-gl"><div class="list-image" '.$style_aa.'></div><input type="hidden" class="js-files-acc-new" name="files_8" value=""><div type_load="8" id_object="" class="invoice_upload js-upload-file js-helps '.$class_aa.'"><span>прикрепите <strong>дополнительные документы</strong>, для этого выберите или перетащите файлы сюда </span><i>чтобы прикрепить ещё <strong>необходимые документы</strong>,выберите или перетащите их сюда</i><div class="help-icon-x" data-tooltip="Принимаем только в форматах .pdf, .jpg, .jpeg, .png, .doc , .docx , .zip" >u</div></div></div></div>';




            ?>


            </span>
            </form>
        </div>
    </div>
</div>
    <div class="button-50">
        <div class="na-50">
            <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
        </div>
        <div class="na-50"><div id="yes_ra" class="save_button js-add-acc-block-x"><i>Добавить</i></div></div>
    </div>

    <!--
     <div class="over">
    <div id="yes_ra" class="save_button"><i>добавить</i></div></div>
    -->
</div>
<input type=hidden name="ref" value="00">
</form>
</span></div>

</div>
<?



end_code:

if($status==0)
{
    //что то не так. Почему то бронировать нельзя
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    die ();
}


$no_script=1;
include_once $url_system.'template/form_js.php';
?>
<script type="text/javascript">
    $(function() {
        initializeTimer();
        initializeFormsJs();
    });
</script>
<?
//include_once $url_system.'template/form_js.php';
?>
<script type="text/javascript">
    var TimerScript = setInterval(LoadFFo, 200);

    function ScriptForms(){
        console.log("yes start code end");
        Zindex();
        AutoResizeT();
        NumberBlockFile();
        $('.money_mask1').inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: " ",
            digits: 2,
            autoGroup: true,
            prefix: '', //No Space, this will truncate the first character
            rightAlign: false,
            oncleared: function () { self.Value(''); }
        });

        ToolTip();
        input_2021();

        $('.date_picker_x').inputmask("datetime",{
            mask: "1.2.y",
            placeholder: "dd.mm.yyyy",
            separator: ".",
            alias: "dd.mm.yyyy"
        });

        $(".slct").unbind('click.sys');
        $(".slct").bind('click.sys', slctclick);
        $(".drop").find("li").unbind('click');
        $(".drop").find("li").bind('click', dropli);

        //кнопка отмена
        $('.js-box-modal-two .js-exit-window-add-task-two').off("change keyup input click");
        $('.js-box-modal-two').on("change keyup input click",'.js-exit-window-add-task-two',js_exit_form_sel1);

        //кнопка принять решение
        $('.js-box-modal-two').on("change keyup input click",'.js-add-acc-block-x',js_add_acc_x);

        $('.mask-count').mask('99999');


    }

</script>