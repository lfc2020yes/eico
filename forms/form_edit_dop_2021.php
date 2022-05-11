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
$token=token_access_compile($_GET['id'],'edit_dop_22',$secret);
//составление секретного ключа формы
//составление секретного ключа формы

$result_town=mysql_time_query($link,'Select a.*,c.name_working,c.razdel2,c.razdel1 from i_razdel2_replace as a,i_razdel2 as c where a.id_razdel2=c.id and a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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

            $result_uu = mysql_time_query($link, 'select * from i_razdel1 where id="' . ht($row_town['id_razdel1_replace']) . '"');
            $num_results_uu = $result_uu->num_rows;

            if ($num_results_uu != 0) {
                $row_uu = mysqli_fetch_assoc($result_uu);
            }


            echo'<h1 class="gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Изменение данных по дополнительной смете</span><span class="clock_table"></span></h1><span class="tii">'.$row_town["razdel1"].'.'.$row_town["razdel2"].' '.$row_town["name_working"].' → '.$row_uu["razdel1"].'. '.$row_uu["name1"].' </span></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

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
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021"><label><i>Количество</i><span>*</span></label><input name="count_work" value="'.$row_town["count_units"].'" class="input_new_2021 gloab required  no_upperr money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';



            echo'<span class="h3-f h-25">Материалы содержащиеся в работе</span><input type="hidden" name="mat_bill_" class="input_option_xvg mat_bill_" value="1">';
            $result_t2=mysql_time_query($link,'Select a.* from i_material as a where a.id_razdel2="'.ht($row_town["id_razdel2"]).'" order by a.id');

            //echo'Select DISTINCT b.id_stock,b.id_i_material from z_doc as a,z_doc_material as b,i_material as c where b.id IN ('.$sql.') and c.id=b.id_i_material and a.id=b.id_doc';


            $num_results_t2 = $result_t2->num_rows;
            if($num_results_t2!=0)
            {

                echo'<div class="xvg_add_material option_slice_xxg active_xxg">';
                $ddf=1;
                for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                {

                    $row__2= mysqli_fetch_assoc($result_t2);

                    $class_dava='';
                    if($row__2["alien"]==1)
                    {
                        $class_dava='dava';

                    }

                    $rr=$ksss+1;
                    /*
                        $result_url_m=mysql_time_query($link,'select A.material,A.units from i_material as A where A.id="'.htmlspecialchars(trim($row__2["id_i_material"])).'"');
                        $num_results_custom_url_m = $result_url_m->num_rows;
                        if($num_results_custom_url_m!=0)
                        {
                            $row_material = mysqli_fetch_assoc($result_url_m);

                        }
                        */

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



                    echo'<div class="js-acc-block items_acc_basket basket_dop_22   " yi_sopp_="'.$row__2["id"].'">
                <input type="hidden" value="'.$row__2["id"].'" name="material[stock][]">					
                <div class="name-user-57"><span class="label-task-gg ">Название
</span><div class="h57-2020"><span class="name-items"><span class="'.$class_dava.'">'.$row__2["material"].'</span></span>
              </div>
            
</div>
<div class="tender-date"><span class="label-task-gg ">Единица измерения
</span>
                <span class="item-ed">'.$row__2['units'].'</span>
</div>

<div class="tender-col">';


                    //определяем количество которое забили до этого
                    $val=0;
                    $result_uu_val = mysql_time_query($link, 'select * from i_material_replace where id_razdel2_replace="'.htmlspecialchars(trim($_GET['id'])).'" and id_material="'.$row__2["id"].'"');
                    $num_results_uu_val = $result_uu_val->num_rows;

                    if ($num_results_uu_val != 0) {
                        $row_uu_val = mysqli_fetch_assoc($result_uu_val);
                        $val=$row_uu_val["count_units"];

                    }






                    echo'<!--input start-->';
                    echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Кол-во (MAX '.$row__2['count_units'].')</i><span>*</span></label><input  name="material[count][]" value="'.$val.'" count="'.$row__2["id"].'" max="'.$row__2['count_units'].'" class="input_new_2021 gloab required  no_upperr count_mask " style="padding-right: 20px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
                    echo'<!--input end	-->';
                    echo'</div>';
                    /*
                    echo'<div class="tender-col">';

                                           echo'<!--input start-->';
                                           echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Цена (MAX '.$row_work_zz['mm'].')</i><span>*</span></label><input  name="material['.$rr.'][price]" value="" price="'.$row__2["id"].'" data-tooltip="Цена в счете за единицу с ндс" max="'.$row_work_zz['mm'].'" class="input_new_2021 gloab required  no_upperr money_mask1 price_xvg_" style="padding-right: 20px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
                                           echo'<!--input end	-->';

                                           echo'</div>  ';*/
                    /*
                                        echo'<div class="tender-summ all_price_count_xvg"><span class="pay_summ_bill1">0</span>
                     </div>
                                    <div class="tender-but" style="padding-left: 10px;"><div id_rel="'.$row__2["id"].'" class="del-item js-del-items-basket del_basket_joo" data-tooltip="Удалить из счета"></div></div>
                        */


                    echo'</div>';


                }

                echo'</div>';
            }


/*
            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021"><label><i>Сумма материалов</i><span>*</span></label><input name="price_work" value="'.$row_town["summa_material"].'" class="input_new_2021 gloab required  no_upperr money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';
*/
            echo'<!--input start-->
<div class="margin-input"><div class="input_2021 input_2021_resize  gray-color '.iclass_("text",$stack_error,"required_in_2021").'"><label><i>Комментарий</i><span>*</span></label><div class="otziv_add js-resize-block"><textarea cols="10" rows="1" name="remark" class="di gloab input_new_2021  text_area_otziv js-autoResize ">'.$row_town["comment"].'</textarea></div><div class="div_new_2021"><div class="error-message"></div></div></div></div>
<!--input end	-->';

            ?>


            </span>
            </form>
        </div>
    </div>
    <div class="button-50">
        <div class="na-50">
            <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
        </div>
        <div class="na-50"><div class="save_button js-edit-dop-work-new-x"><i>Сохранить</i></div></div>
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
        $('.js-box-modal-two').on("change keyup input click",'.js-edit-dop-work-new-x',js_edit_dop_new_x);

        $('.mask-count').mask('99999');


    }

</script>
