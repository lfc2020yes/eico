<?php
//форма добавления нового раздела в себестоимость

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


if ((!$role->permission('Себестоимость','U'))and($sign_admin!=1))
{
    goto end_code;
}


//составление секретного ключа формы
//составление секретного ключа формы
$token=token_access_compile($_GET['id'],'edit_work',$secret);
//составление секретного ключа формы
//составление секретного ключа формы

$result_town=mysql_time_query($link,'Select a.* from i_razdel2 as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_custom_town = $result_town->num_rows;
if($num_results_custom_town!=0)
{
    $row_town = mysqli_fetch_assoc($result_town);
    //echo'<div class="comme">'.$row_town["name1"].'</div>';
} else
{
    goto end_code;
}

$status=1;


?>
<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

            <?

            $result_uu = mysql_time_query($link, 'select * from i_razdel1 where id="' . ht($row_town['id_razdel1']) . '"');
            $num_results_uu = $result_uu->num_rows;

            if ($num_results_uu != 0) {
                $row_uu = mysqli_fetch_assoc($result_uu);
            }


            echo'<h1 class="gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Изменение работы</span><span class="clock_table"></span></h1><span class="tii">Вы изменяете работу в разделе - «'.$row_uu["razdel1"].'. '.$row_uu["name1"].'»</span></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

            echo'<div class="na-100">

<form class="js-form-edit-works" id="form_prime_edit_work_new" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

            echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
            echo'<input type="hidden" value="'.$token.'" name="tk">';
            echo'<input name="tk1" value="weER23Dvmrw3E" type="hidden">';
            ?>

            <span class="hop_lalala" >
            <?
            //echo($_GET["url"]);
            echo'';


            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021"><label><i>Номер статьи</i><span>*</span></label><input name="number_razdel2" value="'.$row_town["razdel2"].'" class="input_new_2021  required  no_upperr gloab" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';



            echo'<!--input start-->
<div class="margin-input"><div class="input_2021 input_2021_resize  gray-color active_in_2021 '.iclass_("text",$stack_error,"required_in_2021").'"><label><i>Название работы</i><span>*</span></label><div class="otziv_add js-resize-block"><textarea cols="10" rows="1" name="name_work" class="di gloab input_new_2021  text_area_otziv js-autoResize ">'.$row_town['name_working'].'</textarea></div><div class="div_new_2021"><div class="error-message"></div></div></div></div>
<!--input end	-->';

            /*
                        echo'<!--input start-->';
                        echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Номер раздела</i><span>*</span></label><input name="number_r" value="" class="input_new_2021 gloab required  no_upperr count_mask_cel" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
                        echo'<!--input end	-->';
            */

            /*
                       echo'<div class="input-width"><div class="width-setter"><input name="number_r" id="number_r" placeholder="Номер раздела" class="input_f_1 input_100 white_inp count_mask_cel" autocomplete="off" type="text"></div></div>';
            */

            //номер раздела по умолчанию макс+1
            //если ввел и такой уже есть подсвечивать красным поле



            $su_5_name='';
            $su_5='';

            if($row_town["id_implementer"]!=0)
            {
                $result_uu1 = mysql_time_query($link, 'select implementer from i_implementer where id="' . ht($row_town["id_implementer"]) . '"');
                $num_results_uu1 = $result_uu->num_rows;

                if ($num_results_uu1 != 0) {
                    $row_uu1 = mysqli_fetch_assoc($result_uu1);
                    $su_5_name=$row_uu1["implementer"];
                    $su_5=$row_town["id_implementer"];
                }

            }


            echo'<!--input start	-->';

            echo'<div class=" big_list">';
            //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

            echo'<div class="list_2021 input_2021 input-search-list gray-color js-zindex" list_number="box2"><i class="js-open-search"></i><div class="b_loading_small loader-list-2021"></div><label>Исполнитель</label><input name="kto1" value="'.$su_5_name.'" id="date_124" sopen="search_group" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 25px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search gloab20 js-group-stock" name="ispol_work" id="search_items_5"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';



            $result_work_zz=mysql_time_query($link,'
            
           Select a.id,a.implementer from i_implementer as a order by a.implementer


');
            $num_results_work_zz = $result_work_zz->num_rows;
            if($num_results_work_zz!=0)
            {
                echo'<li><a href="javascript:void(0);" rel="0">неизвестен</a></li>';
                for ($i=0; $i<$num_results_work_zz; $i++)
                {
                    $row_work_zz = mysqli_fetch_assoc($result_work_zz);

                    $yop='';
                    if($row_work_zz["id"]==$su_5) {
                        $yop='sel_active';
                    }

                    echo'<li class="'.$yop.'"><a href="javascript:void(0);" rel="'.$row_work_zz["id"].'">'.$row_work_zz["implementer"].'';
                    echo'</a></li>';

                }
            }

            echo'</ul><div class="div_new_2021"><div class="oper_name"></div></div></div></div><!--input end	-->';




            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021"><label><i>Ед. Изм.</i><span>*</span></label><input name="ed_work" value="'.$row_town["units"].'" class="input_new_2021 gloab required  no_upperr js-click-inpute-stock" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';


            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021"><label><i>Количество</i><span>*</span></label><input name="count_work" value="'.$row_town["count_units"].'" class="input_new_2021 gloab required  no_upperr js-click-inpute-stock money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021"><label><i>Стоимость за единицу</i><span>*</span></label><input name="price_work" value="'.$row_town["price"].'" class="input_new_2021 gloab required  no_upperr js-click-inpute-stock money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021"><label><i>Текущая стоимость</i><span>*</span></label><input name="price_work_today" value="'.$row_town["price_today"].'" class="input_new_2021 gloab required  no_upperr js-click-inpute-stock money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="all-summ-stock none">
            <div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021" style=""><label><i>Итого сумма</i></label><input name="summa_work" value="" class="input_new_2021 gloab20 required  no_upperr" disabled readonly style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>
            </div>';
            echo'<!--input end	-->';



            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021"><label><i>Реализовано количество</i><span>*</span></label><input name="count_realiz" value="'.$row_town["count_r2_realiz"].'" class="input_new_2021  required  no_upperr money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021"><label><i>Реализовано на сумму</i><span>*</span></label><input name="summ_realiz" value="'.$row_town["summa_r2_realiz"].'" class="input_new_2021  required  no_upperr  money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';


            ?>


            </span>
            </form>
        </div>
    </div>
    <div class="button-50">
        <div class="na-50">
            <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
        </div>
        <div class="na-50"><div class="save_button js-edit-prime-work-new-x"><i>Сохранить</i></div></div>
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
        $('.js-box-modal-two').on("change keyup input click",'.js-edit-prime-work-new-x',js_edit_work_new_x);

        $('.mask-count').mask('99999');


    }

</script>
