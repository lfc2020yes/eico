<?php
//согласовать напрямую из снабжения

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


	if ((!$role->permission('Счета','A'))and($sign_admin!=1))
	{
	   goto end_code;
	}


//**************************************************
$result_url=mysql_time_query($link,'select A.* from z_acc as A where A.id="'.htmlspecialchars(trim($_GET['id'])).'"');
$num_results_custom_url = $result_url->num_rows;
if($num_results_custom_url==0)
{
    header404(6,$echo_r);
} else
{
    $row_list = mysqli_fetch_assoc($result_url);
}
//**************************************************

if(($row_list["status"]!=1)and($row_list["status"]!=3)and($row_list["status"]!=8))
{
    header404(7,$echo_r);
}
//**************************************************



$status_user_zay=array("0","0"); //по умолчанию это никто
if((($row_list["id_user"]==$id_user)and($role->permission('Счета','A')))or($sign_admin==1))
{
    $status_user_zay[0]=1;
}

if($status_user_zay[0]!=1)
{
    header404(8,$echo_r);
}


	    //составление секретного ключа формы
		//составление секретного ключа формы	
		$token=token_access_compile($_GET['id'],'sign_acc_order',$secret);
        //составление секретного ключа формы
		//составление секретного ключа формы

$status=1;
echo'

<form class="js-form-sign-min none" id="form-sign-min" style=" padding:0; margin:0;" method="post" enctype="multipart/form-data">';

echo'<input type="hidden" value="'.htmlspecialchars(trim($_GET['id'])).'" name="id">';
echo'<input type="hidden" value="'.$token.'" name="tk">';

echo'<input name="tk1" value="weER23DvmrIrt" type="hidden">';


                    echo'</form>';


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

        var for_id=$('.js-form-sign-min').find('[name=id]').val();
//alert(for_id);
        AjaxClient('acc', 'sign_acc', 'POST', 0, 'AfterSignAcc', for_id, 'form-sign-min');


    }

</script>
