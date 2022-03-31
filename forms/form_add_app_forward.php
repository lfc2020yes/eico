<?php
//переслать заявку другому

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


	if ((!$role->permission('Заявки','R'))and($sign_admin!=1))
	{
	   goto end_code;
	}


include_once $url_system.'/ilib/lib_interstroi.php';
include_once $url_system.'/ilib/lib_edo.php';

$edo = new EDO($link, $id_user, false);
$arr_document = $edo->my_documents(0, ht($_GET["id"]), '=0', true);
// echo '<pre>arr_document:' . print_r($arr_document, true) . '</pre>';

$visible_gray=0;
foreach ($arr_document as $key => $value)
{
if((is_array($value["state"]))and(!empty($value["state"]))) {

foreach ($value["state"] as $keys => $val) {
//echo($val["id_run_item"]);

    $class_by = '';
    if ($val["id_status"] != 0) {
        goto end_code;
    }

    $but_mass = $edo->get_action($val["id_run_item"]);
}} else
{
    goto end_code;
}


}

	    //составление секретного ключа формы
		//составление секретного ключа формы	
		$token=token_access_compile($_GET['id'],'sign_app_forward_2',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы


		$status=1;
	   
	   
	   ?>
			<div id="Modal-one" class="box-modal js-box-modal-two table-modal eddd1 input-block-2020"><div class="box-modal-pading"><div class="top_modal"><div class="box-modal_close arcticmodal-close"></div>

<?
			echo'<h1 style="margin-bottom: 0px;" class="h111 gloab-cc js-form2" mor="'.$token.'" for="'.htmlspecialchars(trim($_GET['id'])).'"><span>Переслать заявку</span><span class="clock_table"></span></h1><span class="tii">'.$value["name"].'</span></div><div class="center_modal"><div class="form-panel white-panel form-panel-form" style="padding-bottom: 10px;">';

echo'<div class="na-100">

<form class="js-form-forward" action="app/forward/'.$_GET["id"].'/" id="form_prime_add_block" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
echo'<input type="hidden" value="'.$token.'" name="tk">';

echo'<input name="tk1" value="weER23Dvmrtrr" type="hidden">';


?>	
			
			<span class="hop_lalala" >
            <?
			//echo($_GET["url"]);
			echo'';



/*
		   echo'<div class="input-width"><div class="width-setter"><input name="number_r" id="number_r" placeholder="Номер раздела" class="input_f_1 input_100 white_inp count_mask_cel" autocomplete="off" type="text"></div></div>';
*/

		//номер раздела по умолчанию макс+1
		//если ввел и такой уже есть подсвечивать красным поле   


            echo'<!--select start-->';
            $os = array();
            $os_id = array();

            $mass_ee=array();
            $query_ob='';

            $FUSER=new find_user($link,$value['id_object'],'R','Заявки');
            $user_send_new=$FUSER->id_user;
//print_r($FUSER);
            //echo '<pre>arr_task:'.print_r($user_send_new,true) .'</pre>';

            foreach ($FUSER->id_user as $key => $value)
            {

                $result_uu = mysql_time_query($link, 'select name_user from r_user where id="' . ht($value) . '"');
                $num_results_uu = $result_uu->num_rows;

                if ($num_results_uu != 0) {
                    $row_uu = mysqli_fetch_assoc($result_uu);
                    array_push($os,$row_uu["name_user"]);
                }


                array_push($os_id, $value);

            }


            rm_from_array($id_user,$os_id);
            /*
                        $result_6 = mysql_time_query($link,"select A.id,A.name_user from r_user as A where A.enabled=1");
                        //$row_1 = mysqli_fetch_assoc($result2);
                        if($result_6)
                        {
                            while($row_6 = mysqli_fetch_assoc($result_6)){
                                array_push($os,$row_6["name_user"]);
                                array_push($os_id,$row_6["id"]);
                            }
                        }
            */


            $su_1=-1;

            echo'<div class="margin-input"><div class="list_2021 gray-color js-zindex"><label><i>Ответственный</i><span>*</span></label><div class="select eddd"><a class="slct" data_src=""></a><ul class="drop">';


            for ($i=0; $i<count($os); $i++)
            {
                if(isset($os_id[$i])) {
                    if ($su_1 == $os_id[$i]) {
                        echo '<li class="sel_active"><a href="javascript:void(0);"  rel="' . $os_id[$i] . '">' . $os[$i] . '</a></li>';
                    } else {
                        echo '<li><a href="javascript:void(0);"  rel="' . $os_id[$i] . '">' . $os[$i] . '</a></li>';
                    }
                }
            }
            echo'</ul><input type="hidden" class="gloab" name="forward_id" value=""></div></div></div>';
            echo'<!--select end-->';



				?>


            </span>
                    </form>
                      </div>
                    </div>
<div class="button-50">
                <div class="na-50">
                    <div id="no_rd223" class="no_button js-exit-window-add-task-two"><i>Отменить</i></div>
                </div>
    <?
                echo'<div class="na-50"><div id="yes_ra" class="save_button js-add-forward-x"><i>Переслать</i></div></div>';

                ?>
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
        $('.js-box-modal-two').on("change keyup input click",'.js-add-forward-x',js_add_forward_x);

        $('.mask-count').mask('99999');


    }

</script>
