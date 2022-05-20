<?php
$local_server_x = 0;
$local_host_s = array('eico.atsun.local','eico.atsun.ru','eico.atsun.local');
//адреса где могут лежать эти сайты на локалке
$local = array('D:/DOMAIN/'.$local_host_s[0],'C:/OpenServer/domains/'.$local_host_s[1],'C:/OpenServer/domains/'.$local_host_s[2]);


$number_local=array_search($_SERVER['DOCUMENT_ROOT'], $local);
if ($number_local !== false) {
//локалка
    $local_server_x = 1;
}

if(!isset($no_script)) {
if ($local_server_x==0) {
echo '<script language="JavaScript" type="text/javascript" src="/public/forms.map.min.js?cb=1653048951862"></script>';
} else {
echo '<script language="JavaScript" type="text/javascript" src="/public/forms.map.js?cb=1653048951862"></script>';
}
} else
{
echo'<script type="text/javascript">';

    if ($local_server_x==0) {
        echo 'window.src_forms="/public/forms.map.min.js?cb=1653048951862";';
    } else {
        echo 'window.src_forms="/public/forms.map.js?cb=1653048951862";';
    }

    echo'</script>';


}

?>