<?php
//форма изменения счета доп. данных

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';

$status=0;



//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) != 1)or(!isset($_GET["id"]))or((!is_numeric($_GET["id"]))))
{
   goto end_code;
}

if((!isset($_SESSION["user_id"]))or(!is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
	{
   goto end_code;
	}


	if ((!$role->permission('Счета','U'))and($sign_admin!=1))
	{
	   goto end_code;
	}


$result_t=mysql_time_query($link,'Select a.* from z_acc as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0) {

    goto end_code;

} else
{
    $row_t = mysqli_fetch_assoc($result_t);
}

if(($row_t["status"]!=1)and($row_t["status"]!=8))
{
    goto end_code;
}

	    //составление секретного ключа формы
		//составление секретного ключа формы	
		$token=token_access_compile($_GET['id'],'edit_acc_more_x',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы


		   $status=1;
	   
	   
	   ?>
<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

<?
			echo'<h1 class="h111 gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Редактирование данных по счету</span><span class="clock_table"></span></h1><span class="tii">Счет №'.$row_t["number"].' от '.date_ex(0,$row_t["date"]).'</span></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

echo'<div class="na-100">

<form class="js-form-acc-edit" id="form_acc_edit_block" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
echo'<input type="hidden" value="'.$token.'" name="tk">';
echo'<input name="tk1" value="weER23FvmrwEE" type="hidden">';

?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';


            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Номер счета</i><span>*</span></label><input name="number_soply1" value="'.$row_t["number"].'" class="input_new_2021 gloab required  no_upperr js-number-acc-new" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Дата счета</i><span>*</span></label><input name="date_soply" value="'.date_ex(0,$row_t["date"]).'" class="input_new_2021 gloab required  no_upperr date_picker_x" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Срок поставки в днях</i><span>*</span></label><input name="date_soply1" value="'.$row_t["delivery_day"].'" class="input_new_2021 gloab required  no_upperr mask-count" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
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

            if ($row_t["id_contractor"]!=0)
            {
                $result_uu = mysql_time_query($link, 'select * from z_contractor where id="' . ht($row_t["id_contractor"]) . '"');
                $num_results_uu = $result_uu->num_rows;

                if ($num_results_uu != 0) {
                    $row_uu = mysqli_fetch_assoc($result_uu);
                    $su_5=$row_uu["id"];
                    $su_5_name=$row_uu["name"].' (ИНН-'.$row_uu["inn"].')';
                }
            }

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

            $class_th='';
            if($row_t["comment"]!='') {
                $class_th='active_in_2018';
            }

            echo'<!--input start-->
<div class="margin-input" style="margin-top: 20px;"><div class="input_2018 input_2018_resize  gray-color '.$class_th.'"><label><i>Комментарий</i></label><div class="otziv_add js-resize-block"><textarea cols="10" rows="1" name="text_comment" class="di input_new_2018  text_area_otziv js-autoResize ">'.$row_t["comment"].'</textarea></div><div class="div_new_2018"><div class="error-message"></div></div></div></div>
<!--input end	-->';


echo'<input name="list" value="0" type="hidden">';


?>


            </span>
                    </form>
                      </div>
                    </div>
<div class="button-50">
                <div class="na-50">
                    <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
                </div>
                <div class="na-50"><div  class="save_button js-edit-save-acc-x"><i>Сохранить</i></div></div>
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
        $('.js-box-modal-two').on("change keyup input click",'.js-edit-save-acc-x',js_edit_save_acc_x);

        $('.mask-count').mask('99999');


        var cc_le=$('.js-list-acc').length;

        if(cc_le>0)
        {
            var box = $('.box-modal:last');
            box.find('[name=list]').val(1);
        }


    }

</script>
