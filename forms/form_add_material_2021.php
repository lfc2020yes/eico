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

$result_tdd=mysql_time_query($link,'Select a.id,a.razdel1,a.razdel2,a.name_working from i_razdel2 as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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
$token=token_access_compile($_GET['id'],'add_material',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

$status=1;



?>

<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

            <?
            echo'<h1 style="margin-bottom:0px;" class="h111 gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'" ><span>Добавление материала в себестоимость</span><span class="clock_table"></span></h1><span class="tii">'.$row_list["razdel1"].'.'.$row_list["razdel2"].' '.$row_list["name_working"].'</span></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

            echo'<div class="na-100">

<form class="js-form-price-mats" id="form_prime_add_mat_stock" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

            echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
            echo'<input type="hidden" value="'.$token.'" name="tk">';
            echo'<input name="tk1" value="weER23Dvmrw3E" type="hidden">';

            ?>

            <span class="hop_lalala" >
            <?
            //echo($_GET["url"]);
            echo'';





            echo'<div class="js-more-options-supply">';
            echo'<!--input start	-->		
<div class="password_acc">
<div id="0" class="input-choice-click-pass js-password-acc js-type-stock-prime active_pass">
<div class="choice-head">Позиция на складе</div>
<div class="choice-radio"><div class="center_vert1"><i class="active_task_cb"></i></div></div>
</div>	

<div id="1" class="input-choice-click-pass js-password-acc js-type-stock-prime">
<div class="choice-head">Новая позиция на складе</div>
<div class="choice-radio"><div class="center_vert1"><i></i></div></div>
</div>
<input name="new_sklad_i" class="js-type-stock-prime1" value="0" type="hidden">	
</div>		
<!--input end -->';

            //существующий поставщик
            echo'<div class="js-options-invoice-0">';


            $su_5_name='';
            $su_5='';

            echo'<!--input start	-->';

            echo'<div class=" big_list" style="margin-bottom: 10px;">';
            //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

            echo'<div class="list_2021 input_2021 input-search-list gray-color js-zindex" list_number="box2"><i class="js-open-search"></i><div class="b_loading_small loader-list-2021"></div><label>Поиск позиции (название)</label><input name="kto" value="'.$su_5_name.'" id="date_124" sopen="search_stock" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 25px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search gloab2 js-posta js-mat-inv-posta10" name="posta_posta" id="search_items_5"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';



            $result_work_zz=mysql_time_query($link,'
            
            SELECT DISTINCT t.id,t.name,t.units 
            FROM 
                 z_stock as t
             ORDER BY t.name limit 0,40


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

                    echo'<li class="'.$yop.' li_search_stock "><a href="javascript:void(0);" rel="'.$row_work_zz["id"].'">'.$row_work_zz["name"].'';
                    echo'</a><span class="search_units_stock">'.$row_work_zz["units"].'</span></li>';

                }
            }

            echo'</ul><div class="div_new_2021"><div class="oper_name"></div></div></div></div><!--input end	-->';






            echo'</div>';

            echo'<div class="search_bill_ed none"></div>';
            //новый поставщик
            echo'<div class="js-options-invoice-1 option-new-material none">';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Название позиции</i><span>*</span></label><input name="name_new_stock" value="" class="input_new_2021 gloab1 required  no_upperr js-name-stock" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';



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
            echo'</ul><input type="hidden" class="gloab1  js-in6 js-ed-stock" name="ed_new_stock"  value=""></div></div></div>';
            echo'<!--select end-->';


            $su_5_name='';
            $su_5='';

            echo'<!--input start	-->';

            echo'<div class=" big_list">';
            //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

            echo'<div class="list_2021 input_2021 input-search-list gray-color js-zindex" list_number="box2"><i class="js-open-search"></i><div class="b_loading_small loader-list-2021"></div><label>Поиск группы (название)</label><input name="kto1" value="'.$su_5_name.'" id="date_124" sopen="search_group" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 25px;" autocomplete="off" type="text"><input type="hidden" value="'.$su_5.'" class="js-hidden-search gloab20 js-group-stock" name="group_new_stock" id="search_items_5"><ul class="drop drop-search js-drop-search" style="transform: scaleY(0);">';



            $result_work_zz=mysql_time_query($link,'
            
           Select a.* from z_stock_group as a order by a.name limit 0,40


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

                    echo'<li class="'.$yop.'"><a href="javascript:void(0);" rel="'.$row_work_zz["id"].'">'.$row_work_zz["name"].'';
                    echo'</a></li>';

                }
            }

            echo'</ul><div class="div_new_2021"><div class="oper_name"></div></div></div></div><!--input end	-->';



            echo'</div>';

            //echo'</div>';


            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Количество</i><span>*</span></label><input name="count_work" value="" class="input_new_2021 gloab required  no_upperr js-click-inpute-stock money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Стоимость за единицу</i><span>*</span></label><input name="price_work" value="" class="input_new_2021 gloab required  no_upperr js-click-inpute-stock money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

echo'<!--input start-->';
            echo'<div class="all-summ-stock none">
            <div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021" style=""><label><i>Итого сумма</i></label><input name="summ_work" value="" class="input_new_2021 gloab20 required  no_upperr" disabled readonly style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>
            </div>';
            echo'<!--input end	-->';




            echo'<!--input start	-->		
<div class="password_acc">
<div id="0" class="input-choice-click-pass js-password-acc active_pass">
<div class="choice-head">Наш материал</div>
<div class="choice-radio"><div class="center_vert1"><i class="active_task_cb"></i></div></div>
</div>	

<div id="1" class="input-choice-click-pass js-password-acc ">
<div class="choice-head">Давальческий материал</div>
<div class="choice-radio"><div class="center_vert1"><i></i></div></div>
</div>
<input name="dava_stock"  value="0" type="hidden">	
</div>		
<!--input end -->';


            ?>


            </span>
            </form>
        </div></div>
    </div>

<div class="button-50">
    <div class="na-50">
        <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
    </div>
    <div class="na-50"><div id="yes_ra" class="save_button js-add-prime-block-x"><i>Добавить</i></div></div>
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
        //input_2021();

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
        $('.js-box-modal-two').on("change keyup input click",'.js-add-prime-block-x',js_add_prime_mat_stock);

        $('.mask-count').mask('99999');
        $('.js-box-modal-two').on("change",'.js-mat-inv-posta10',option_demo20);


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