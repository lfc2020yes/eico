<?php
header('Content-type: text/html; charset=utf-8');

include_once $_SERVER['DOCUMENT_ROOT'].'/'."sysadmin/run/interstroi.atsun.ru/XLS_DB.php";

//echo '<br>file='.$_POST["file"];
//echo '<br>sheet='.$_POST["sheet"];
?>
<script type="text/javascript">
$('.scap_load_20').find('.scap_load__').width('10%');
</script>
<?php
XLS_DB( $_POST["id_object"], $_POST["id_r1"],$_POST["id_r2"], true, $_POST["file"],$_POST["sheet"],$_POST["shablon"],true,$_POST["full_reload"]);


