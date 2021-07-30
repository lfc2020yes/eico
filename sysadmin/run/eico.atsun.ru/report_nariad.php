<?php
include_once '../ilib/Isql.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/lib_interstroi.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{


    $GT=array();
    GET_PARAM($GT,$PARAM);

    $id_nariad =  (isset($_POST["id_nariad"])) ? $_POST["id_nariad"] : 0;
    $sign =  (isset($_POST["sign"])) ? $_POST["sign"] : 1;
    $exec =  (isset($_POST["exec"])) ? $_POST["exec"] : 0;

    if ($ROW_role!=0) {
        $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
        $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
    }
    else { $styleH=''; $styleF=''; }

    $ret = 0;
    $mysqli = new_connect($ret);
    echo "<p/> result_connect mysqli=" . $mysqli->connect_errno;
    //=============================================================Информация по id счета
    if ($_POST["id_nariad"]>0) {
        $sql = '';
        $ret = nariad_sign($mysqli, $id_nariad, $sign, 5, 0, true, $exec);
        echo "<p/> код возврата: $ret";
    }
    ?>
    <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="edo" value="1"/>

        <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">
            <caption <?=$styleH?>><div style="padding:3px;">Информация по наряду</div></caption>

            <tr><td style="padding-right: 10px">id Наряда:<td>
                    <input class="text"  name="id_nariad" size="10" value="<?=$id_nariad?>" />
            <tr><td style="padding-right: 10px">Sign [0 1]:<td>
                    <input class="text"  name="sign" size="10" value="<?=$sign?>" />
            <tr><td style="padding-right: 10px">exec [0 1]:<td>
                    <input class="text"  name="exec" size="10" value="<?=$exec?>" />


                    <?php
                    SHOW_tfoot(4,1,1,1);
                    ?>
        </table>

        <?



}

?>


