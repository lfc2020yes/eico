<?php
$local_server_x = 0;
$local_host = array('eico.atsun.local','eico.atsun.ru');
//адреса где могут лежать эти сайты на локалке
$local = array('D:/DOMAIN/'.$local_host[0],'C:/OpenServer/domains/'.$local_host[1]);


$number_local=array_search($_SERVER['DOCUMENT_ROOT'], $local);
if ($number_local !== false) {
//локалка
    $local_server_x = 1;
}

if(!isset($no_script)) {
if ($local_server_x==0) {
echo '<script language="JavaScript" type="text/javascript" src="/public/forms.map.min.js?cb=1635339614255"></script>';
} else {
echo '<script language="JavaScript" type="text/javascript" src="/public/forms.map.js?cb=1635339614255"></script>';
}
} else
{
echo'<script type="text/javascript">';

    if ($local_server_x==0) {
        echo 'window.src_forms="/public/forms.map.min.js?cb=1635339614255";';
    } else {
        echo 'window.src_forms="/public/forms.map.js?cb=1635339614255";';
    }

    echo'</script>';


}

?>