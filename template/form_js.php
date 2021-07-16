<?php
$local='C:/OpenServer/domains/'.$local_host.'';

if(!isset($no_script)) {
if ($_SERVER['DOCUMENT_ROOT'] != $local) {
echo '<script language="JavaScript" type="text/javascript" src="/public/forms.map.min.js?cb=1626434774795"></script>';
} else {
echo '<script language="JavaScript" type="text/javascript" src="/public/forms.map.js?cb=1626434774795"></script>';
}
} else
{
echo'<script type="text/javascript">';

    if ($_SERVER['DOCUMENT_ROOT'] != $local) {
        echo 'window.src_forms="/public/forms.map.min.js?cb=1626434774795";';
    } else {
        echo 'window.src_forms="/public/forms.map.js?cb=1626434774795";';
    }

    echo'</script>';


}

?>