<?php   //POST id - id акта для удаления
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';   //$link $id_user $role
include_once $url_system.'aktpp/lib.php';
include_once $url_system.'ilib/Isql.php';
header('Content-type: text/html; charset=utf-8');

$id_akt=htmlspecialchars(trim($_POST['id']));
if($role->permission('Прием-Передача','D')) {
    $sql='delete from z_act where id="'.$id_akt.'"';    //Удаление с триггером
    if($count=iDelUpd($link,$sql,false)<>1) { 
        echo "ошибка удаления акта ($count)";
    }
    //echo $sql;   ////
} //Права на удаление