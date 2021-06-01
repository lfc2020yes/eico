<?php
//POST id - id акта для подписи
$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
include_once $url_system.'module/ajax_access.php';   //$link $id_user $role
include_once $url_system.'aktpp/lib.php';
include_once $url_system.'ilib/Isql.php';
include_once $url_system.'module/function.php'; 
header('Content-type: text/html; charset=utf-8');

$id_akt=htmlspecialchars(trim($_POST['id']));
$ptype='Прием-Передача';
if($role->permission($ptype,'U') || $role->permission($ptype,'S')) {
    $sql='update z_act set date0=NOW() where id="'.$id_akt.'"';    //date0
    if($count=iDelUpd($link,$sql,false)>1) { 
        echo "ошибка изменения акта ($count) $sql ";
    }   else {
    //echo $sql;   ////
        $sql='select * from z_act where id="'.$id_akt.'"';
        $res=mysql_time_query($link,$sql);
        if ($res->num_rows>0) {
            $row= mysqli_fetch_assoc($res);    
            $note='материальные ценности по Акту приема-передачи № ';
            $note0=$row['number'].' от '.$row['date'];
            notification_send('<strong>Получите</strong> '.$note.' <a href="aktpp/res/">'.$note0.'</a>',  array($row['id1_user']),$id_user,$link);
            //if ($row['id0_user']<>$id_user)
            notification_send('<strong>Передайте</strong> '.$note.' <a href="/aktpp/print/'.$id_akt.'/">'.$note0.'</a>',  array($row['id0_user']),$id_user,$link);

        }    
    }
} //Права на изменение
