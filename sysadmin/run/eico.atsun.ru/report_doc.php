<?php
include_once '../ilib/Isql.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/task_time.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/lib_report.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{


    $GT=array();
    GET_PARAM($GT,$PARAM);

    $id_doc =  (isset($_POST["id_doc"])) ? $_POST["id_doc"] : 0;

    if ($ROW_role!=0) {
        $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
        $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
    }
    else { $styleH=''; $styleF=''; }

    $ret = 0;
    $mysqli = new_connect($ret);
    echo "<p/> result_connect mysqli=" . $mysqli->connect_errno;
    //=============================================================Информация по id счета
    if ($_POST["id_doc"]>0) {

        $doc_date = new Doc_Data($_POST["id_doc"],$mysqli);
        //if($doc_date->row_doc[status] == 13) {
            $doc_date->Get_Data();
            $docz = new DocZ($doc_date->row_doc);
            $docz->analyze();
        //}
        // $doc_date->si->Show();
        echo "<pre> id_doc=".$_POST["id_doc"]." <br>".print_r($doc_date->row_doc,true)."</pre>";

?>
<style>
    .red {
        color: red;
        font-style: italic;
    }
    .blue {
        color: blue;
        font-style: italic;
    }
</style>

<table border='1' style='border-collapse: collapse;'>
    <tr><td colspan="2">заявка № <?=$doc_date->row_doc[number]?> от <?=$doc_date->row_doc[date]?> [<?=$doc_date->row_doc[name]?>]
    <tr><td>объект: <td><?=$doc_date->row_doc[id_object]?>
    <tr><td>статус: <td><?=$doc_date->row_doc[name_status]?>
    <tr><td>владелец: <td><?=$doc_date->row_doc[name_user]?>
    <tr><td colspan="2">материалы:
    <tr><td colspan="2">
        <table border='1' style='border-collapse: collapse;'>
    <tr><th>раздел<th>статья<th>наименование<th>ед<th>кол<th>цена<th>сумма/статус<th>поставка
            <?php

        foreach ($doc_date->row_doc[material] as $key => $item) {
            ?>
    <tr><td>
        <td>
        <td><b><?=$item[material]?></b>
        <td>
        <td><?=$item[count_units_doc]?>
        <td>
        <td><?=$item[name_status]?>
        <td><?=$item[date_delivery]?>
    <tr><td colspan="2">принято:
        <td>
        <td>
        <td><?=$item[count_units_act]?>
        <td>
        <td>
        <td>
    <tr><td><?=$item[razdel1]?>
        <td><?=$item[razdel2]?>
        <td>
        <td><?=$item[units]?>
        <td><?=$item[count_units]?>
        <td><?=$item[price]?>
        <td><?=$item[subtotal]?>
        <td>
    <tr><td colspan="2">реализация/по нарядам:
        <td>
        <td>
        <td class="blue"><?=$item[count_realiz]?> / <?=$item[count_units_nariad]?>
        <td>
        <td class="blue"><?=$item[summa_realiz]?>
        <td>
            <?php
            if(isset($item[acc]))
            foreach ($item[acc] as $acc) {
            ?>
    <tr><td colspan="2">Счет:
        <td>№ <?=$acc[number]?> от <?=$acc[date]?> на сумму: <?=$acc[summa]?> [ <?=$acc[name_status]?> ]
        <td>
        <td><?=$acc[count_material]?>
        <td><?=$acc[price_material]?>
        <td><?=($acc[count_material]*$acc[price_material])?>
        <td><?=$acc[date_delivery]?>
            <?php
            }
            if(isset($item[invoice][acc]))
            foreach ($item[invoice][acc] as $invoice) {
                ?>
                <tr><td colspan="2">накладные по счету:
                <td>№ <?=$invoice[number]?> от <?=$invoice[date]?> <?=$invoice[name_user]?> [ <?=$invoice[name_status]?> ]
                <td>
                <td><?=$invoice[count_units]?> / <?=$invoice[count_defect]?>
                <td><?=$invoice[price_nds]?> / <?=$invoice[price]?>
                <td><?=$invoice[subtotal]?>
                <?php
            }
            if(isset($item[invoice][stock]))
            foreach ($item[invoice][stock] as $invoice) {
                if ($invoice[in]==0) {
                ?>
                <tr><td colspan="2">накладные по складу:
                    <td>№ <?=$invoice[number]?> от <?=$invoice[date]?> <?=$invoice[name_user]?> [ <?=$invoice[name_status]?> ] <?=$invoice[in]?>
                    <td>
                    <td><?=$invoice[count_units]?> / <?=$invoice[count_defect]?>
                    <td><?=$invoice[price_nds]?> / <?=$invoice[price]?>
                    <td><?=$invoice[subtotal]?>
                <?php
                }
            }
            ?>
    <tr><td colspan="2">склад итого:
        <td><?=$item[stock][name]?>
        <td><?=$item[stock][units]?>
        <td><?=$item[stock][count_units]?>
        <td><td><?=$item[stock][subtotal]?>
            <?php
            if(isset($item[stock_user]))
            foreach ($item[stock_user] as $stock_user) {
                    ?>
                <tr><td colspan="2">у кого:
                    <td><?=$stock_user[name_user]?>
                    <td><?=$stock_user[units]?>
                    <td><?=$stock_user[count_units]?>
                    <td><?=$stock_user[price]?>
                    <td><?=$stock_user[subtotal]?>
                    <?php
            }
            ?>
    <tr><td colspan="1" class="blue"><?=$docz->status[$key][0]?>
        <td colspan="2" class="blue"><?=$docz->status[$key][1]?>
            <?php
        }
        ?>
    <tr><td colspan="1" class="red"><?=$docz->status_all[0]?>
        <td colspan="7" class="red"><?=$docz->status_all[1]?>

        </table></table>
            <?php
    }
    ?>
    <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="edo" value="1"/>

        <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">
            <caption <?=$styleH?>><div style="padding:3px;">Информация по заявке</div></caption>

            <tr><td style="padding-right: 10px">id Заявки:<td>
                    <input class="text"  name="id_doc" size="10" value="<?=$id_doc?>" />



                    <?php
                    SHOW_tfoot(4,1,1,1);
                    ?>
        </table>

        <?



}




?>


