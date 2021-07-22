<?php
include_once '../ilib/Isql.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/task_time.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{


    $GT=array();
    GET_PARAM($GT,$PARAM);

    $id_doc =  (isset($_POST["id_doc"]))?$_POST["id_doc"]:0;

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
        echo "<pre> id_doc=".$_POST["id_doc"]." <br>".print_r($doc_date->row_doc,true)."</pre>";

?>

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

        foreach ($doc_date->row_doc[material] as $item) {
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
    <tr><td colspan="2">закрыто:
        <td>
        <td>
        <td><?=$item[count_realiz]?>
        <td>
        <td><?=$item[summa_realiz]?>
        <td>
            <?php
            if(isset($item[acc]))
            foreach ($item[acc] as $acc) {
            ?>
    <tr><td colspan="2">Счет:
        <td>№ <?=$acc[number]?> от <?=$acc[date]?> на сумму: <?=$acc[summa]?>
        <td>
        <td><?=$acc[count_material]?>
        <td><?=$acc[price_material]?>
        <td><?=($acc[count_material]*$acc[price_material])?>
        <td><?=$acc[date_delivery]?>
            <?php
            }
            ?>
    <tr><td colspan="2">склад:
        <td><?=$item[stock][name]?>
        <td><?=$item[stock][units]?>
        <td><?=$item[stock][count_units]?>
        <td><td><?=$item[stock][subtotal]?>
            <?php
        }
        ?>
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

class Doc_Data {
    var $mysqli;
    var $row_doc;

    public function Doc_Data($id_doc,$mysqli) {
        $this->row_doc = array();
        $this->mysqli = $mysqli;
        $sql ="
SELECT
  D.`id`,
  D.`name`,
  D.`number`,
  D.`date`,
  D.`date_last`,
  D.`date_create`,
  D.`id_user`,
  D.`ready`,
  D.`status`,
  D.`id_object`,
  D.`id_edo_run`,
  U.`name_user`,
  S.`name_status`
FROM
  `z_doc` D 
  LEFT JOIN `r_user` U ON (D.`id_user` = U.`id`)
  LEFT JOIN `r_status` S ON(D.`status` = S.`numer_status` AND S.`id_system` = 13)
WHERE
D.id = $id_doc
    ";
        if ($result = $mysqli->query($sql)) {
            if ($this->row_doc = $result->fetch_assoc()) {
                // ------------------- материалы заявки, в смете и статусы по материалам
                $sql_m = "
SELECT
  D.`id` as id_doc_material,
  D.`id_doc`,
  D.`id_i_material`,
  D.`id_stock`,
  D.`id_object`,
  D.`count_units` AS count_units_doc,
  D.`count_units_act`,
  D.`date_delivery`,
  D.`id_group_material`,
  D.`status`,
  D.`memorandum`,
  D.`id_sign_mem`,
  D.`signedd_mem`,
  M.*,
  S.`name_status`
FROM
  `z_doc_material` D
  LEFT JOIN `r_status` S ON(D.`status` = S.`numer_status` AND S.`id_system` = 13)
  , `i_material` M
WHERE 
D.id_doc=$id_doc
AND D.`id_i_material` = M.`id`                 
                ";
                if ($result_m = $mysqli->query($sql_m)) {
                    while ($row_m = $result_m->fetch_assoc()) {
                        $this->row_doc[material][] = $row_m;
                        $i = count($this->row_doc[material]) - 1;
                        //----------------------------------------счета по материалу
                        $sql_a = "
SELECT
  M.`id`,
  M.`id_doc_material`,
  M.`count_material`,
  M.`price_material`,
  M.`id_acc`,
  M.`path_buy`,
  A.*,
  S.`name_status`,
  U.`name_user`
FROM
  `z_doc_material_acc` M, 
  `z_acc` A
  LEFT JOIN `r_status` S ON(A.`status` = S.`numer_status` AND S.`id_system` = 16)
  LEFT JOIN `r_user` U ON (A.`id_user` = U.`id`)
WHERE
M.`id_doc_material` = ".$row_m[id_doc_material]."
AND M.`id_acc` = A.`id`                        
                        ";
                        if ($result_a = $mysqli->query($sql_a)) {
                            while ($row_a = $result_a->fetch_assoc()) {
                                $this->row_doc[material][$i][acc][] = $row_a;

                            }
                            $result_a->close();
                        }
                        //--------------------------------склад
                        $sql_t = "
SELECT 
S.`id`, S.`name`, S.`units`
, SUM(M.count_units) AS count_units, SUM(M.subtotal) AS subtotal
FROM 
`z_stock` S, `z_stock_material` M
WHERE 
S.`id`=".$row_m[id_stock]."
AND S.`id` = M.`id_stock`                            
                            ";
                        if ($result_t = $mysqli->query($sql_t)) {
                            if ($row_t = $result_t->fetch_assoc()) {
                                $this->row_doc[material][$i][stock] = $row_t;
                            }
                            $result_t->close();
                        }

                    }
                    $result_m->close();
                }
            }
            $result->close();

        }
    }
}
?>


