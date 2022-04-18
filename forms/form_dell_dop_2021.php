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


if ((!$role->permission('Себестоимость','D'))and($sign_admin!=1))
{
    goto end_code;
}


$result_t=mysql_time_query($link,'Select a.*,c.name_working,c.razdel2,c.razdel1 from i_razdel2_replace as a,i_razdel2 as c where a.id_razdel2=c.id and a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
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
$token=token_access_compile($_GET['id'],'dell_dop_21',$secret);
//составление секретного ключа формы
//составление секретного ключа формы


$status=1;


?>
<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

            <?
            echo'<h1 class="h111 gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Удаление Связи с доп. сметой</span><span class="clock_table"></span></h1></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

            echo'<div class="na-100">';
            $result_uu = mysql_time_query($link, 'select * from i_razdel1 where id="' . ht($row_t['id_razdel1_replace']) . '"');
            $num_results_uu = $result_uu->num_rows;

            if ($num_results_uu != 0) {
                $row_uu = mysqli_fetch_assoc($result_uu);
            }

            echo'<div class="comme">Вы точно хотите удалить Связь <b>'.$row_t["razdel1"].'.'.$row_t["razdel2"].' '.$row_t["name_working"].' → '.$row_uu["razdel1"].'.'.$row_uu["name1"].'</b>?</div>';

            ?>



        </div>
    </div>
    <div class="button-50">
        <div class="na-50">
            <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
        </div>
        <div class="na-50"><div  class="save_button js-dell-acc-dop-x"><i>Удалить</i></div></div>
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
        $('.js-box-modal-two').on("change keyup input click",'.js-dell-acc-dop-x',js_dell_acc_dop);




    }

</script>