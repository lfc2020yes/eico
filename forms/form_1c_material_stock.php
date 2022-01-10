<?php
//форма редактирования материала по работе в себестоимости

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';


//создание секрет для формы
$status=0;



if((!isset($_SESSION["user_id"]))or(!is_numeric(id_key_crypt_encrypt($_SESSION["user_id"]))))
{
    goto end_code;
}

$id_user=id_key_crypt_encrypt($_SESSION["user_id"]);

//проверить есть ли переменная id и можно ли этому пользователю это делать
if ((count($_GET) != 3)or(!isset($_GET["number"]))or((!is_numeric($_GET["number"]))))
{
    goto end_code;
}

if ((!$role->permission('Накладные_1c','A'))and($sign_admin!=1))
{
    goto end_code;
}

include_once '../ilib/lib_import.php';

$csv = new CSV($link, $id_user);
$mask = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/*.csv';
$mask_attach = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/1c_attach/';
if(isset($_GET["id"])) {
    //iconv( 'windows-1251','UTF-8',$debug)\
    //echo(base64_decode($_GET['id']));
    $data = $csv->read_data(base64_decode($_GET['id']));
    if(count($data)==0)
    {
        goto end_code;
    }
} else
{
    goto end_code;
}

$nn=0;
if(isset($_GET["number"])) {
    if (!isset($data[$_GET['number']])) {
        goto end_code;
    }
} else
{
    goto end_code;
}
$nn=$_GET['number'];



//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['number'],'edit_sklad_1c',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы
$status=1;

?>
<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

            <?


            echo'<h1 style="margin-bottom:0px;" cor="" keyss="'.htmlspecialchars(trim($_GET['key'])).'" class="h111 gloab-cc js-form2 js-form-save-1c" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'" ><span>Назначить соответствие на складе</span><span class="clock_table"></span></h1><span class="tii">'.$data[$nn]["Номенклатура"].' → <span class="unit-opa">'.$data[$nn]["ЕдиницаИзмерения"].'</span></span></div><div class="center_modal">';

            $stock = new STOCK($link, $id_user);
            $arFiles = $stock->find_byName($data[$nn]["Номенклатура"],2);

            //echo "<pre> $arFiles: ".print_r($arFiles,true)."</pre>";

            if((count($arFiles)>0)and($arFiles!=false)) {

                echo '<span class="h-25" style="margin-bottom: 5px !important;">Предложенные варианты</span><div class="js-group-c js-tolko-one">';
                foreach ($arFiles as $key => $value) {
                    //echo($value);



                        echo '<div class="material-1c-vibor" id_key="0">
<div class="zero_one js-checkbox-group js-tolko-one js-matic-ko">';
/*
<div class="mild mild-1c js-checkbox-group"><div class="mild_mild" data-tooltip="Выбрать соответствие">
<i class="select-mild"></i></div></div>
*/
	echo'<div class="choice-radiox"><i></i><input name="pro[type][]" value="'.$value["id"].'" type="hidden"><input name="pro[unitss][]" value="'.$value["units"].'" type="hidden"><input name="pro[val][]" value="1" type="hidden"></div>';

echo'</div>
        <div class="name_one">
          <span class="label-task-gg ">Наименование на складе</span>    
          <span class="nm">'.$value["name"].'</span>
        </div>
        <div class="name_two">
             <span class="label-task-gg ">ед. изм.</span>'.$value["units"].'</div>
        <div class="name_free">
                  <span class="label-task-gg ">Связанные счета</span>';

                  /*  $result_score = mysql_time_query($link, 'Select a.date,a.date_paid,a.delivery_day,a.number,a.status,a.summa,a.id as id from z_acc as a,z_doc_material_acc as b,z_doc_material as c where c.id=b.id_doc_material and a.status IN ("2","3", "4","20") and b.id_acc=a.id and c.id_stock="' . ht($value["id"]) . '"');
*/

                    $CA=0;
//определяем какой по id у нас это контрагент
                    $contractor = new CONTRACTOR($link, $id_user);
                    if (($id=$contractor->get($data[0]["ИНН"])) !== false) { $CA=$id; }
                    else
                        if (($id=$contractor->put($data[0]))!==false) { $CA=$id; }

                    $result_score=mysql_time_query($link,

                        'select DISTINCT a.id,a.number,a.date,a.summa,a.id_contractor from z_acc as a,z_doc_material_acc as b,z_doc_material as c where a.id=b.id_acc and b.id_doc_material=c.id and c.id_stock="'.htmlspecialchars(trim($value["id"])).'" and a.status IN ("2","3", "4","20") and a.id_contractor="'.htmlspecialchars(trim($CA)).'"');


                    $num_results_score = $result_score->num_rows;
                    if ($num_results_score != 0) {
                        for ($ss = 0; $ss < $num_results_score; $ss++) {
                            $row_score = mysqli_fetch_assoc($result_score);


                            //определим количество материала в этом счете
                            $count_vse=0;

                            /*
                            $result_uu = mysql_time_query($link, 'select sum(A.count_material) as count_material  from z_doc_material_acc as A,z_doc_material as B where A.id_doc_material=B.id and A.id_acc="'.$row_score["id"].'" and B.id_stock="' . ht($value["id"]) . '"');
                            $num_results_uu = $result_uu->num_rows;

                            if ($num_results_uu != 0) {
                                $row_uu = mysqli_fetch_assoc($result_uu);
                                $count_vse=$row_uu["count_material"];
                            }
*/
                            $result_uu = mysql_time_query($link, 'select b.id,b.count_material from z_doc_material as a,z_doc_material_acc as b where a.id_stock="'.ht($value["id"]).'" and a.id=b.id_doc_material and b.id_acc="' . ht($row_score['id']) . '"');

                            if ($result_uu) {
                                $i = 0;
                                $nado=0;
                                $maric='';

                                while ($row_uu = mysqli_fetch_assoc($result_uu)) {

                                    //проверить в этом счете необходимо ли еще материал или уже весь приняли
                                    $PROC = 0;
                                    $PROC_ALL = 0;

                                    $result_proc = mysql_time_query($link, 'select sum(a.count_units) as summ,sum(a.count_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="' . $row_score['id'] . '" and a.id_stock="'.ht($value["id"]).'" and a.id_doc_material_acc="'.ht($row_uu["id"]).'"');

                                    $num_results_proc = $result_proc->num_rows;
                                    if ($num_results_proc != 0) {
                                        $row_proc = mysqli_fetch_assoc($result_proc);
                                        $count_vse = $count_vse+($row_uu["count_material"] - $row_proc["summ"] - $row_proc["summ1"]);

                                    }



                                }


                            }




if($count_vse>0) {

    echo '<a target="_blank" class="acc_1c_form" href="acc/' . $row_score["id"] . '/"><span class="spans ggh-e name-blue-b1"><span>Cчет №' . $row_score["number"] . ' (' . date_ex(0, $row_score["date"]) . ')</span><span class="count-c1-m">→ ' . rtrim(rtrim(number_format($count_vse, 3, '.', ' '), '0'), '.') . ' ' . $value["units"] . '</span></span></a>';
}

                        }

                    } else
                    {
                        echo'—';
                    }


                  echo'</div>           
            
           </div>';

                }
                echo'</div>';
            }


            echo '<span class="h-25" style="margin-bottom: 5px !important; margin-top: 10px;">Поиск на складе</span>';




echo'<div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

            echo'<div class="na-100">

<form class="js-form-supply-mats" id="form_supply_edit_mat_stock" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

            echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['number'])).'" name="id">';
            echo'<input type="hidden" value="'.$token.'" name="tk">';
            echo'<input name="file" value="'.htmlspecialchars(trim($_GET['id'])).'" type="hidden">';

            ?>

            <span class="hop_lalala" >
            <?
            //echo($_GET["url"]);
            echo'';





            echo'<div class="js-more-options-supply">';






            $stock='';
            $stock_display1='none';
            $stock_class1='';
            $stock_class2='';
            if($row_list["id_stock"]!=0)
            {

                $result_uu = mysql_time_query($link, 'select * from z_stock where id="' . ht($row_list["id_stock"]) . '"');
                $num_results_uu = $result_uu->num_rows;

                if ($num_results_uu != 0) {
                    $row_uu = mysqli_fetch_assoc($result_uu);
                    $stock=0;
                    $stock_class1='active_pass';
                    $stock_class1_1='active_task_cb';
                    $stock_class2='';
                    $stock_class2_2='';
                    $stock_display1='';

                }

            }





            echo'<!--input start	-->		
<div class="password_acc js-matic-cc">
<div id="0" class="input-choice-click-pass js-password-acc js-type-stock-prime js-1c-matic  '.$stock_class1.'">
<div class="choice-head">Позиция на складе</div>
<div class="choice-radio"><div class="center_vert1"><i class="'.$stock_class1_1.'"></i></div></div>
</div>	

<div id="1" class="input-choice-click-pass js-password-acc js-type-stock-prime js-1c-matic '.$stock_class2.'">
<div class="choice-head">Новая позиция на складе</div>
<div class="choice-radio"><div class="center_vert1"><i class="'.$stock_class2_2.'"></i></div></div>
</div>
<input name="new_sklad_i" class="js-type-stock-prime1 matic-op gloab" value="'.$stock.'" type="hidden">	
</div>		
<!--input end -->';

            //существующий поставщик
            echo'<div class="js-options-invoice-0 '.$stock_display1.'">';


            $su_5_name='';
            $su_5='';
            $su_5_class='';
            if($stock==0)
            {
                $su_5_name=$row_uu["name"];
                $su_5=$row_list["id_stock"];
                $su_5_class='active_in_2018x active_in_2021';
            }

            echo'<!--input start	-->';

            echo'<div class=" big_list" style="margin-bottom: 10px;">';
            //$query_string.='<div style="margin-top: 30px;" class="input_doc_turs js-zindex">';

            echo'<div class="list_2021 input_2021 input-search-list gray-color js-zindex '.$su_5_class.'" list_number="box2"><i class="js-open-search"></i><div class="b_loading_small loader-list-2021"></div><label>Поиск позиции (название)</label><input name="kto" value="'.$su_5_name.'" id="date_124" sopen="search_stock" oneli="" class=" input_new_2021 required js-keyup-search no_upperr" style="padding-right: 25px;" autocomplete="off" type="text"><input type="hidden" value="" class="js-hidden-search gloab2 js-posta js-mat-inv-posta10" name="posta_posta" id="search_items_5"><input type="hidden" value="" class="js-hidden-unit" ><input type="hidden" value="" class="js-hidden-name-m" ><ul class="drop drop-search js-drop-search js-stock-1c" style="transform: scaleY(0);">';



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
/*
            if($stock==0)
            {
                echo '<div class="search_bill_ed">';

                echo '<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021" style="background-color: rgba(0, 0, 0, 0.08);"><label><i>Ед. Изм.</i><span>*</span></label><input name="number_soply1" value="'.$row_uu["units"].'" class="input_new_2021 gloab20 required  no_upperr" disabled readonly style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';

                echo'</div>';
            } else {
                echo '<div class="search_bill_ed none"></div>';
            }
*/
/*
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

*/

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
    <div class="na-50"><div id="yes_ra" class="save_button js-edit-matic-block-x"><i>Сохранить</i></div></div>
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


       LoadSave1c('<? echo($_GET["key"]); ?>');


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
        $('.js-box-modal-two').on("change keyup input click",'.js-edit-matic-block-x',js_edit_matic_mat_stock);

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