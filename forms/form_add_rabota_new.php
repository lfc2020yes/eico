<?php
//форма добавления нового раздела в себестоимость

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';

$status=0;



//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) != 2)or(!isset($_GET["id"]))or((!is_numeric($_GET["id"]))))
{
    goto end_code;
}

if((!isset($_SESSION["user_id"]))or(!is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
{
    goto end_code;
}


if ((!$role->permission('Себестоимость','A'))and($sign_admin!=1))
{
    goto end_code;
}


//составление секретного ключа формы
//составление секретного ключа формы
$token=token_access_compile($_GET['id'],'add_work_mat',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
$result_town=mysql_time_query($link,'select A.* from i_razdel1 as A where  A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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



            echo'<h1 class="gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Добавление работы</span><span class="clock_table"></span></h1><span class="tii">Вы добавляете работы в раздел - «'.$row_town["name1"].'»</span></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px; padding-top: 0px;">';

            echo'<div class="na-100">

<form class="js-form-add-works" id="form_prime_add_work_new" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

            echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
            echo'<input type="hidden" value="'.$token.'" name="tk">';
            echo'<input name="tk1" value="weER23Dvmrw3E" type="hidden">';
            echo'<input type=hidden id="freez" name="freez" value="'.htmlspecialchars(trim($_GET['freez'])).'">';
            ?>

            <span class="hop_lalala" >
            <?
            //echo($_GET["url"]);
            echo'';


            $rann=0;
            $result_town2=mysql_time_query($link,'select max(0+A.razdel2) as mm from i_razdel2 as A where  A.id_razdel1="'.htmlspecialchars(trim($_GET['id'])).'"');
            $num_results_custom_town2 = $result_town2->num_rows;
            if($num_results_custom_town2!=0)
            {
                $row_town2 = mysqli_fetch_assoc($result_town2);

                $rann=$row_town2["mm"];
                $rann=$rann+1;

                if($row_town2["mm"]!='')
                {

                    echo'<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Предполагаемый номер добавляемой работы - <strong>'.$row_town["razdel1"].'.'.$rann.'</strong></span></span></div>';


                }
            }




            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021"><label><i>Номер статьи</i><span>*</span></label><input name="number_razdel2" value="'.$rann.'" class="input_new_2021  required  no_upperr gloab" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';


            echo'<!--input start-->
<div class="margin-input"><div class="input_2021 input_2021_resize  gray-color '.iclass_("text",$stack_error,"required_in_2021").'"><label><i>Название работы</i><span>*</span></label><div class="otziv_add js-resize-block"><textarea cols="10" rows="1" name="name_work" class="di gloab input_new_2021  text_area_otziv js-autoResize "></textarea></div><div class="div_new_2021"><div class="error-message"></div></div></div></div>
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
                //echo'<li><a href="javascript:void(0);" rel="0"></a></li>';
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





            echo'<!--select start-->';

            $os = array();
            $os_id = array();

            $os = array('шт','м3','м2','т','пог.м','маш/час','компл');
            $os_id = array('0','1','2','3','4','5','6');


            $su_1=ipost_x($_POST['ispol_type'],$row_list["type_contractor"],"0");

            $class_s='';
            if($su_1!=-1)
            {
                $class_s='active_in_2018x';
            }




            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="list_2021 gray-color js-zindex "><label><i>Ед. Изм.</i><span>*</span></label><div class="select eddd"><a class="slct" data_src=""></a><ul class="drop">';


            for ($i=0; $i<count($os); $i++)
            {
                if($su_1==$os_id[$i])
                {
                    echo'<li class="sel_active"><a href="javascript:void(0);"  rel="'.$os_id[$i].'">'.$os[$i].'</a></li>';
                } else
                {
                    echo'<li><a href="javascript:void(0);"  rel="'.$os_id[$i].'">'.$os[$i].'</a></li>';
                }

            }
            echo'</ul><input type="hidden" class="gloab  js-in6 js-ed-stock" name="ed_work"  value=""></div></div></div>';
            echo'<!--select end-->';



            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Количество</i><span>*</span></label><input name="count_work" value="" class="input_new_2021 gloab required  no_upperr js-click-inpute-stock money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Стоимость за единицу</i><span>*</span></label><input name="price_work" value="" class="input_new_2021 gloab required  no_upperr js-click-inpute-stock money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="all-summ-stock none">
            <div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021" style=""><label><i>Итого сумма</i></label><input name="summa_work" value="" class="input_new_2021 gloab20 required  no_upperr" disabled readonly style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>
            </div>';
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
        <div class="na-50"><div class="save_button js-add-prime-work-new-x"><i>Добавить</i></div></div>
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
        $('.js-box-modal-two').on("change keyup input click",'.js-add-prime-work-new-x',js_add_work_new_x);

        $('.mask-count').mask('99999');


    }

</script>
