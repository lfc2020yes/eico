<?php
$local='C:/OpenServer/domains/'.$local_host.'';

if(!isset($no_script)) {
if ($_SERVER['DOCUMENT_ROOT'] != $local) {
echo '<script language="JavaScript" type="text/javascript" src="/public/forms.map.min.js?cb=1623930439445"></script>';
} else {
echo '<script language="JavaScript" type="text/javascript" src="/public/forms.map.js?cb=1623930439445"></script>';
}
} else
{
echo'<script type="text/javascript">';

    if ($_SERVER['DOCUMENT_ROOT'] != $local) {
        echo 'window.src_forms="/public/forms.map.min.js?cb=1623930439445";';
    } else {
        echo 'window.src_forms="/public/forms.map.js?cb=1623930439445";';
    }

    echo'</script>';


}

?>