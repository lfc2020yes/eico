<?php
//форма коррекция количества в заявке для снабженца в модуле снабжения

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
if ((count($_GET) != 1)or(!isset($_GET['id']))or($_GET['id']=='')) 
{
	goto end_code;	
}	

if ((!$role->permission('Счета','A'))and($sign_admin!=1))
{
    goto end_code;	
}


$result_t=mysql_time_query($link,'Select a.*,c.name from z_doc_material as a,z_doc as c where c.id=a.id_doc and a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
           $num_results_t = $result_t->num_rows;
	       if($num_results_t==0)
	       {	
			 goto end_code;
		   }else
		   {
			 $row_t = mysqli_fetch_assoc($result_t);
			   
		   }


$result_uu45 = mysql_time_query($link, 'SELECT DISTINCT 
b.id_stock

FROM 
z_doc AS a,
z_doc_material AS b,
i_material AS c, 
edo_state AS edo

WHERE 
b.id="'.ht($_GET['id']).'"
AND c.id=b.id_i_material
AND a.id=b.id_doc
AND a.id_edo_run = edo.id_run
AND edo.id_status = 0
AND edo.id_executor IN ('.ht($id_user).')

AND b.status NOT IN ("1","8","10","3","5","4") 	 ');
$num_results_uu45 = $result_uu45->num_rows;

if ($num_results_uu45 == 0) {
    goto end_code;
}



//составление секретного ключа формы
//составление секретного ключа формы
//соль для данного действия
$token=token_access_compile($_GET['id'],'waves_soply',$secret);
//составление секретного ключа формы
//составление секретного ключа формы
//составление секретного ключа формы

	   

$status=1;

?>
<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

            <?
            echo'<h1 class="h111 gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Нормализовать количество материала</span><span class="clock_table"></span></h1><span class="tii">Заявка №'.$row_t["id"].' → '.$row_t["name"].'</span></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

            echo'<div class="na-100">

<form class="js-form-waves" id="form_waves" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

            echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
            echo'<input type="hidden" value="'.$token.'" name="tk">';
            echo'<input name="tk1" value="weER23FvmrwEE" type="hidden">';

            ?>

            <span class="hop_lalala" >
            <?
            //echo($_GET["url"]);
            echo'';

            $result_uus = mysql_time_query($link, 'select name from z_stock where id="' . ht($row_t["id_stock"]) . '"');
            $num_results_uus = $result_uus->num_rows;

            if ($num_results_uus != 0) {
                $row_uus = mysqli_fetch_assoc($result_uus);
            }


            echo'<div class="search_bill_ed"><div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color active_in_2021" style="background-color: rgba(0, 0, 0, 0.08);"><label><i>Название материала</i><span>*</span></label><input name="number_soply1" value="'.$row_uus["name"].'" class="input_new_2021 gloab20 required  no_upperr" disabled="" readonly="" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div></div>';



            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Количество в заявке</i><span>*</span></label><input name="summa_waves" max="'.$row_t["count_units"].'" value="'.$row_t["count_units"].'" class="input_new_2021 required js-waves-count  no_upperr count_mask gloab" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
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
        <div class="na-50"><div  class="save_button js-waves-acc-x"><i>Сохранить</i></div></div>
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
        $('.js-box-modal-two').on("change keyup input click",'.js-waves-acc-x',js_waves_x);

        $('.mask-count').mask('99999');


        var cc_le=$('.js-list-acc').length;

        if(cc_le>0)
        {
            var box = $('.box-modal:last');
            box.find('[name=list]').val(1);
        }


    }

</script>
