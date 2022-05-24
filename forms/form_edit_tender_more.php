<?php
//форма изменения счета доп. данных

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


	if ((!$role->permission('Тендеры','U'))and($sign_admin!=1))
	{
	   goto end_code;
	}


$result_t=mysql_time_query($link,'Select a.* from z_tender as a where a.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_t = $result_t->num_rows;
if($num_results_t==0) {

    goto end_code;

} else
{
    $row_t = mysqli_fetch_assoc($result_t);
}

if(($row_t["status"]!=1)and($row_t["status"]!=8))
{
    goto end_code;
}

	    //составление секретного ключа формы
		//составление секретного ключа формы	
		$token=token_access_compile($_GET['id'],'edit_tender_more_x',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы


		   $status=1;
	   
	   
	   ?>
<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

<?
			echo'<h1 class="h111 gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Редактирование данных по тендеру</span><span class="clock_table"></span></h1></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

echo'<div class="na-100">

<form class="js-form-tender-edit" id="form_tender_edit_block" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
echo'<input type="hidden" value="'.$token.'" name="tk">';
echo'<input name="tk1" value="weER23FvmrwEE" type="hidden">';

?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';


            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Название</i><span>*</span></label><input name="number_soply1" value="'.$row_t["name"].'" class="input_new_2021 gloab required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Ссылка</i><span>*</span></label><input name="link_soply1" value="'.urldecode($row_t["link"]).'" class="input_new_2021 gloab required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Ссылка +</i></label><input name="link_soply2" value="'.urldecode($row_t["link1"]).'" class="input_new_2021 required  no_upperr" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';

            echo'<!--select start-->';
            $os = array();
            $os_id = array();

            $mass_ee=array();
            $query_ob='';

            //print_r($FUSER);
            //echo '<pre>arr_task:'.print_r($user_send_new,true) .'</pre>';

            $result_tr=mysql_time_query($link,'Select a.* from z_tender_place as a order by a.name desc');
            $num_results_tr = $result_tr->num_rows;
            if($num_results_tr!=0) {
                for ($i = 0; $i < $num_results_tr; $i++) {
                    $row_tr = mysqli_fetch_assoc($result_tr);

                        array_push($os,$row_tr["name"]);
                        array_push($os_id, $row_tr["id"]);


                }
            }



           // rm_from_array($id_user,$os_id);

            $su_1=ipost_new($_POST['forward_id'],$row_t["id_z_tender_place"],'',-1);
            $class_s='';
            if($su_1!=-1)
            {
                $class_s='active_in_2018x';
            }




            echo'<div class="margin-input"><div class="list_2021 gray-color js-zindex '.$class_s.'"><label><i>Площадка</i><span>*</span></label><div class="select eddd"><a class="slct" data_src="'.$os_id[array_search(ipost_($_POST['forward_id'],$row_t["id_z_tender_place"]), $os_id)].'">'.$os[array_search(ipost_($_POST['forward_id'],$row_t["id_z_tender_place"]), $os_id)].'</a><ul class="drop">';


            for ($i=0; $i<count($os_id); $i++)
            {
                if(isset($os_id[$i])) {
                    if ($su_1 == $os_id[$i]) {
                        echo '<li class="sel_active"><a href="javascript:void(0);"  rel="' . $os_id[$i] . '">' . $os[$i] . '</a></li>';
                    } else {
                        echo '<li><a href="javascript:void(0);"  rel="' . $os_id[$i] . '">' . $os[$i] . '</a></li>';
                    }
                }
            }
            echo'</ul><input type="hidden" class="gloab" name="pale_id" value="'.ipost_($_POST['forward_id'],$row_t["id_z_tender_place"]).'"></div></div></div>';
            echo'<!--select end-->';




            echo'<!--select start-->';
            $os = array();
            $os_id = array();

            $mass_ee=array();
            $query_ob='';

            //print_r($FUSER);
            //echo '<pre>arr_task:'.print_r($user_send_new,true) .'</pre>';

            $result_tr=mysql_time_query($link,'Select a.id,a.object_name,a.id_town from i_object as a where a.enable=1 order by a.id');
            $num_results_tr = $result_tr->num_rows;
            if($num_results_tr!=0) {
                for ($i = 0; $i < $num_results_tr; $i++) {
                    $row_tr = mysqli_fetch_assoc($result_tr);
                    if((array_search($row_tr["id"],$hie_object) !== false)or($sign_admin==1))
                    {
                        array_push($os,$row_tr["object_name"]);
                        array_push($os_id, $row_tr["id"]);

                    }
                }
            }





            $su_1=ipost_new($_POST['forward_id'],$row_t["id_object"],'',-1);
            $class_s='';
            if($su_1!=-1)
            {
                $class_s='active_in_2018x';
            }




            echo'<div class="margin-input"><div class="list_2021 gray-color js-zindex '.$class_s.'"><label><i>Объект</i><span>*</span></label><div class="select eddd"><a class="slct" data_src="'.$os_id[array_search(ipost_($_POST['forward_id'],$row_t["id_object"]), $os_id)].'">'.$os[array_search(ipost_($_POST['forward_id'],$row_t["id_object"]), $os_id)].'</a><ul class="drop">';


            for ($i=0; $i<count($os_id); $i++)
            {
                if(isset($os_id[$i])) {
                    if ($su_1 == $os_id[$i]) {
                        echo '<li class="sel_active"><a href="javascript:void(0);"  rel="' . $os_id[$i] . '">' . $os[$i] . '</a></li>';
                    } else {
                        echo '<li><a href="javascript:void(0);"  rel="' . $os_id[$i] . '">' . $os[$i] . '</a></li>';
                    }
                }
            }
            echo'</ul><input type="hidden" class="gloab" name="forward_id" value="'.ipost_($_POST['forward_id'],$row_t["id_object"]).'"></div></div></div>';
            echo'<!--select end-->';


            echo'<!--input start-->';
            echo'<div class="margin-input" style="margin-bottom: 10px;"><div class="input_2021 gray-color"><label><i>Сумма</i><span>*</span></label><input name="summa_soply" value="'.$row_t["summa"].'" class="input_new_2021 gloab required  no_upperr money_mask1" style="padding-right: 100px;" autocomplete="off" type="text"><div class="div_new_2021"></div></div></div>';
            echo'<!--input end	-->';


            $class_th='';
            if($row_t["comment"]!='') {
                $class_th='active_in_2018';
            }

            echo'<!--input start-->
<div class="margin-input" style="margin-top: 20px;"><div class="input_2018 input_2018_resize  gray-color '.$class_th.'"><label><i>Комментарий</i></label><div class="otziv_add js-resize-block"><textarea cols="10" rows="1" name="text_comment" class="di input_new_2018  text_area_otziv js-autoResize ">'.$row_t["comment"].'</textarea></div><div class="div_new_2018"><div class="error-message"></div></div></div></div>
<!--input end	-->';


echo'<input name="list" value="0" type="hidden">';


?>


            </span>
                    </form>
                      </div>
                    </div>
<div class="button-50">
                <div class="na-50">
                    <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
                </div>
                <div class="na-50"><div  class="save_button js-edit-save-tender-x"><i>Сохранить</i></div></div>
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
        $('.js-box-modal-two').on("change keyup input click",'.js-edit-save-tender-x',js_edit_save_tender_x);

        $('.mask-count').mask('99999');


        var cc_le=$('.js-list-tender').length;

        if(cc_le>0)
        {
            var box = $('.box-modal:last');
            box.find('[name=list]').val(1);
        }


    }

</script>
