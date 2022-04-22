<?php
//форма добавления материала к работе в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';

//создание секрет для формы
/*
$secret=rand_string_string(4);
$_SESSION['s_form'] = $secret;
*/

$status=0;



if((!isset($_SESSION["user_id"]))or(!is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
{
    goto end_code;
}

$id_user=id_key_crypt_encrypt($_SESSION["user_id"]);

//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) != 1)or(!isset($_GET["id"]))or((!is_numeric($_GET["id"]))))
{
    goto end_code;
}

if ((!$role->permission('Себестоимость','A'))and($sign_admin!=1))
{
    goto end_code;
}

$result_tdd=mysql_time_query($link,'Select a.id,a.razdel1,a.razdel2,a.name_working,b.id_object from i_razdel2 as a,i_razdel1 as b where b.id=a.id_razdel1 and a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_tdd = $result_tdd->num_rows;
if($num_results_tdd==0)
{

    $debug=h4a(5,$echo_r,$debug);
    goto end_code;

} else
    {
        $row_list = mysqli_fetch_assoc($result_tdd);
    }


//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'add_dop_22',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

$status=1;



?>

<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

            <?
            echo'<h1 style="margin-bottom:0px;" class="h111 gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'" ><span>Добавление связи с дополнительной сметой</span><span class="clock_table"></span></h1><span class="tii">'.$row_list["razdel1"].'.'.$row_list["razdel2"].' '.$row_list["name_working"].'</span></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

            echo'<div class="na-100">

<form class="js-form-price-mats" id="form_prime_add_mat_stock" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

            echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
            echo'<input type="hidden" value="'.$token.'" name="tk">';
            echo'<input name="tk1" value="weER23Dvmrw3E" type="hidden">';

            echo'<input name="object" value="'.$row_list["id_object"].'"  type="hidden">';

            ?>

            <span class="hop_lalala" >
            <?
            //echo($_GET["url"]);
            echo'';





            echo'<div class="js-more-options-supply">';


            //существующий поставщик
            echo'<div class="js-options-invoice-0">';

            $su_5_name='';
            $su_5='';
if($row_list["id_object"]!='')
{

    $result_uu_obb = mysql_time_query($link, 'select id,object_name from i_object where id="' . ht($row_list["id_object"]) . '"');
    $num_results_uu_obb = $result_uu_obb->num_rows;

    if ($num_results_uu_obb != 0) {
        $row_uu_obb = mysqli_fetch_assoc($result_uu_obb);
        $su_5_name=$row_uu_obb["object_name"];
        $su_5=$row_uu_obb["id"];
    }

}




            echo'<!--input start	-->';

            echo'<div class=" big_list" style="margin-bottom: 10px;">';
            //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

            echo'<div class="list_2021 input_2021 input-search-list gray-color js-zindex" list_number="box2"><i class="js-open-search"></i><div class="b_loading_small loader-list-2021"></div><label>Поиск Объекта (название)</label><input name="kto" value="'.$su_5_name.'" fns="" id="date_124" sopen="search_smeta" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 25px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search gloab js-posta js-click-object-dop" name="posta_posta_object" id="search_items_5"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';



            $result_work_zz=mysql_time_query($link,'
            
            Select a.id,a.object_name from i_object as a order by a.object_name limit 0,40


');
            $num_results_work_zz = $result_work_zz->num_rows;
            if($num_results_work_zz!=0)
            {
                //echo'<li><a href="javascript:void(0);" rel="0"></a></li>';
                for ($i=0; $i<$num_results_work_zz; $i++)
                {
                    $row_work_zz = mysqli_fetch_assoc($result_work_zz);

                    if((array_search($row_work_zz["id"],$hie_object) !== false)or($sign_admin==1)) {

                        $yop = '';
                        if ($row_work_zz["id"] == $su_5) {
                            $yop = 'sel_active';
                        }

                        echo '<li class="' . $yop .' li_search_stock"><a href="javascript:void(0);" rel="' . $row_work_zz["id"] . '">' . $row_work_zz["object_name"].'';
                        echo '</a></li>';
                    }

                }
            }

            echo'</ul><div class="div_new_2021"><div class="oper_name"></div></div></div></div><!--input end	-->';










echo'<div class="search_razdel_ed">';


            $su_5_name='';
            $su_5='';

            echo'<!--input start	-->';

            echo'<div class=" big_list" style="margin-bottom: 10px;">';
            //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

            echo'<div class="list_2021 input_2021 input-search-list gray-color js-zindex" list_number="box2"><i class="js-open-search"></i><div class="b_loading_small loader-list-2021"></div><label>Поиск раздела (название)</label><input name="kto" value="'.$su_5_name.'" fns="'.$row_list["id_object"].'" id="date_124" sopen="search_razdel" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 25px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search gloab js-posta js-mat-inv-posta10" name="posta_posta" id="search_items_5"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';



            $result_work_zz=mysql_time_query($link,'
            
            SELECT DISTINCT t.id,t.name1,t.razdel1
            FROM 
                 i_razdel1 as t where t.id_object="'.ht($row_list["id_object"]).'"
             ORDER BY t.razdel1 limit 0,40


');
            $num_results_work_zz = $result_work_zz->num_rows;
            if($num_results_work_zz!=0)
            {
                //echo'<li><a href="javascript:void(0);" rel="0"></a></li>';
                for ($i=0; $i<$num_results_work_zz; $i++)
                {
                    $row_work_zz = mysqli_fetch_assoc($result_work_zz);

                    if($role->is_row('i_razdel1','razdel1',$row_work_zz["razdel1"]))

                    {

                        $yop = '';
                        if ($row_work_zz["id"] == $su_5) {
                            $yop = 'sel_active';
                        }

                        echo '<li class="' . $yop . ' li_search_stock "><a href="javascript:void(0);" rel="' . $row_work_zz["id"] . '">' . $row_work_zz["razdel1"] . '. ' . $row_work_zz["name1"] . '';
                        echo '</a></li>';
                    }

                }
            }

            echo'</ul><div class="div_new_2021"><div class="oper_name"></div></div></div></div><!--input end	-->';

echo'</div>';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Количество</i><span>*</span></label><input name="count_work" value="" class="input_new_2021 gloab required  no_upperr  money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';


            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Сумма материалов</i><span>*</span></label><input name="count_maats" value="" class="input_new_2021 gloab required  no_upperr  money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';


            echo'<!--input start-->
<div class="margin-input"><div class="input_2021 input_2021_resize  gray-color '.iclass_("text",$stack_error,"required_in_2021").'"><label><i>Комментарий</i><span>*</span></label><div class="otziv_add js-resize-block"><textarea cols="10" rows="1" name="remark" class="di gloab input_new_2021  text_area_otziv js-autoResize "></textarea></div><div class="div_new_2021"><div class="error-message"></div></div></div></div>
<!--input end	-->';



            echo'</div>';



            //echo'</div>';



            ?>


            </span>
            </form>
        </div></div>
    </div>

<div class="button-50">
    <div class="na-50">
        <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
    </div>
    <div class="na-50"><div id="yes_ra" class="save_button js-add-dop-block-x"><i>Добавить</i></div></div>
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
        $('.js-box-modal-two').on("change keyup input click",'.js-add-dop-block-x',js_add_dop_mat_stock);

        $('.mask-count').mask('99999');
        $('.js-box-modal-two').on("change",'.js-click-object-dop',option_dop_22);


        $('.money_mask1').inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: " ",
            digits: 2,
            autoGroup: true,
            prefix: '', //No Space, this will truncate the first character
            rightAlign: false,
            oncleared: function () { self.Value(''); }
        });


    }

</script>