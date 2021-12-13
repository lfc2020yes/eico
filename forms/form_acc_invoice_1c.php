<?php
//

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
if ((count($_GET) != 3)or(!isset($_GET["id_stock"]))or((!is_numeric($_GET["id_stock"]))))
{
    goto end_code;
}

if ((!$role->permission('Накладные_1c','A'))and($sign_admin!=1))
{
    goto end_code;
}




//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id_stock'],'edit_acc_1c',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы
$status=1;

?>
<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

            <?


            echo'<h1 style="margin-bottom:0px;" acc="" keyss="'.htmlspecialchars(trim($_GET['key'])).'" class="h111 gloab-cc js-form2 js-form-save-1c" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'" ><span>Выбор позиции в счетах</span><span class="clock_table"></span>';

            echo'
            ';

            echo'</h1><div><div class="vsego-x vsego-1c-two"><label>Осталось</label><i></i> <span></span></div>
            <div class="vsego-x vsego-1c-one"><label>Всего в накладной</label><i></i><span></span></div><div class="vsego-x vsego-1c-zero"><label>Единицы соответствия</label><i></i></div></div><span class="tii"></span></div><div class="center_modal">';




            $result_uu3 = mysql_time_query($link, 'select name,units from z_stock where id="' . ht($_GET['id_stock']) . '"');
            $num_results_uu3 = $result_uu3->num_rows;

            if ($num_results_uu3 != 0) {
                $row_uu3 = mysqli_fetch_assoc($result_uu3);
            }




            $result_score=mysql_time_query($link,

                'select DISTINCT a.id,a.number,a.date,a.summa,a.id_contractor from z_acc as a,z_doc_material_acc as b,z_doc_material as c where a.id=b.id_acc and b.id_doc_material=c.id and c.id_stock="'.htmlspecialchars(trim($_GET['id_stock'])).'" and a.status IN ("2","3", "4","20") and a.id_contractor="'.htmlspecialchars(trim($_GET['cont'])).'"');

            //если по счету все приняли не видеть этого счета

            /*
                           <div class="score_a score_active"><i>2</i></div>
                           <div class="score_a"><i>10</i></div>
                            */
            //score_pay score_app score_active

            $num_results_score = $result_score->num_rows;
            if($num_results_score!=0)
            {
            $echo.='<!--select start-->';
                //echo '<span class="h-25" style="margin-bottom: 5px !important;">Найденные счета</span>

echo'<div class="js-group-c">';
            $os = array();
            $os_id = array();






            /*
            $echo.='<select class="demo-6" name="posta_posta">';
            $echo.='<option selected value="0">Выберите счет</option>';*/
            for ($ss=0; $ss<$num_results_score; $ss++) {
                $row_score = mysqli_fetch_assoc($result_score);


                $result_uu = mysql_time_query($link, 'select b.id,b.count_material from z_doc_material as a,z_doc_material_acc as b where a.id_stock="'.ht($_GET["id_stock"]).'" and a.id=b.id_doc_material and b.id_acc="' . ht($row_score['id']) . '"');

                if ($result_uu) {
                    $i = 0;
                    $nado=0;
                    $maric='';

                    while ($row_uu = mysqli_fetch_assoc($result_uu)) {

                        //проверить в этом счете необходимо ли еще материал или уже весь приняли
                        $PROC = 0;
                        $PROC_ALL = 0;

                        $result_proc = mysql_time_query($link, 'select sum(a.count_units) as summ,sum(a.count_defect) as summ1 from z_invoice_material as a,z_invoice as b where b.id=a.id_invoice and b.status NOT IN ("1") and a.id_acc="' . $row_score['id'] . '" and a.id_stock="'.ht($_GET["id_stock"]).'" and a.id_doc_material_acc="'.ht($row_uu["id"]).'"');

                        $num_results_proc = $result_proc->num_rows;
                        if ($num_results_proc != 0) {
                            $row_proc = mysqli_fetch_assoc($result_proc);
                            $PROC = $row_uu["count_material"] - $row_proc["summ"] - $row_proc["summ1"];

                            $PROC_ALL =  round(($row_proc["summ"] + $row_proc["summ1"])*100/$row_uu["count_material"]);
                            if($PROC_ALL>100)
                            {
                                $PROC_ALL=100;
                            }
                        }

                        if($PROC>0)
                        {
                            //выводим так как еще необходимо
                            $nado++;
                           // $maric.=$row_uu3["name"].' '.'еще надо -'.$PROC.' из '.$row_uu["count_material"].' '.$row_uu3["units"].'<br>';

                            $maric.='<div class="material-1c-vibor" id_key="'.$row_uu["id"].'">
<div class="teps_1c" all_inv="'.($row_proc["summ"] - $row_proc["summ1"]).'" all_acc="'.$row_uu["count_material"].'" rel_all="'.$PROC_ALL.'" rel_w="'.$PROC_ALL.'"><div class="peg_div"><div></div></div></div>


<div class="zero_one js-checkbox-group js-acc-ko">';

                            $maric.='<div class="choice-radiox"><i></i><input name="acc[type][]" value="'.$row_uu["id"].'" type="hidden"><input name="acc[count][]" value="'.$PROC.'" type="hidden"><input name="acc[val][]" value="1" type="hidden"></div>';

                            $maric.='</div>
        <div class="name_one">
          <span class="label-task-gg ">Наименование на складе</span>    
          <span class="nm">'.$row_uu3["name"].'</span>
        </div>
        <div class="name_two">
             <span class="label-task-gg ">ед. изм.</span>'.$row_uu3["units"].'</div>
        <div class="name_free">
                  <span class="label-task-gg ">Кол-во в счете/остаток</span><span class="meta_units_1c" style="display: inline-block;" data-tooltip="всего в счете">'.rtrim(rtrim(number_format($row_uu["count_material"], 3, '.', ' '),'0'),'.').' '.$row_uu3["units"].'</span> / <span data-tooltip="осталось принять">'.rtrim(rtrim(number_format($PROC, 3, '.', ' '),'0'),'.').'</span> '.$row_uu3["units"];


                            $maric.='</div>           
            
           </div>';


                        }


                    }

                    if($nado!=0)
                    {
                       // echo 'Счет №'.$row_score["id"].'<br>';

                        echo '<span class="h-25" style="margin-top: 10px;
text-transform: uppercase;
margin-bottom: 0px !important;
  
  font-size: 14px !important;

font-family: GEInspiraBold;">Cчет №'.$row_score["number"].' ('.date_ex(0,$row_score["date"]).') →</span>';

                        echo ($maric);
                    }


                }





/*

                echo '<div class="material-1c-vibor" id_key="0">
<div class="zero_one js-checkbox-group">';

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


                echo'</div>           
            
           </div>';
*/

            }


                echo'</div>';
            }

echo'</div>';




echo'</div>';
?>
<div class="button-50">
    <div class="na-50">
        <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
    </div>
    <div class="na-50"><div id="yes_ra" class="save_button js-edit-matic-block-xxx"><i>Сохранить</i></div></div>
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
        $('.js-box-modal-two').on("change keyup input click",'.js-edit-matic-block-xxx',js_edit_matic_mat_stock_acc);

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

        animation_teps_1c();
        load_basket_1c('<? echo($_GET["key"]); ?>');
    }

</script>