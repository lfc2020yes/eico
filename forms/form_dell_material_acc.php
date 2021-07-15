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


if ((!$role->permission('Счета','U'))and($sign_admin!=1))
{
    goto end_code;
}


$result_t=mysql_time_query($link,'Select f.name,a.number,a.date from z_acc as a,z_doc_material_acc
 as c,z_doc_material as d,z_stock as f where d.id=c.id_doc_material and d.id_stock=f.id and c.id_acc=a.id and ((a.status=1)or(a.status=8)) and c.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0)
{

    goto end_code;

} else
{
    $row_t = mysqli_fetch_assoc($result_t);
}

//составление секретного ключа формы
//составление секретного ключа формы
$token=token_access_compile($_GET['id'],'dell_mat_acc',$secret);
//составление секретного ключа формы
//составление секретного ключа формы


$status=1;


?>
<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

            <?
            echo'<h1 class="h111 gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Удаление позиции из счета</span><span class="clock_table"></span></h1></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

            echo'<div class="na-100">';


            echo'<div class="comme">Вы точно хотите удалить позицию <b>"'.$row_t["name"].'"</b> и вашего счета №'.$row_t["number"].' от '.date_ex(0,$row_t["date"]).'</div>';

            ?>



        </div>
    </div>
    <div class="button-50">
        <div class="na-50">
            <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
        </div>
        <div class="na-50"><div  class="save_button js-dell-acc-mat-x"><i>Удалить</i></div></div>
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
        //кнопка отмена
        $('.js-box-modal-two .js-exit-window-add-task-two').off("change keyup input click");
        $('.js-box-modal-two').on("change keyup input click",'.js-exit-window-add-task-two',js_exit_form_sel1);

        //кнопка принять решение
        $('.js-box-modal-two').on("change keyup input click",'.js-dell-acc-mat-x',js_dell_acc_mat);




    }

</script>