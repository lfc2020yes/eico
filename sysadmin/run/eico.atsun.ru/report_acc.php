<?php
include_once '../ilib/Isql.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/task_time.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{


    $GT=array();
    GET_PARAM($GT,$PARAM);

    $id_acc =  (isset($_POST["id_acc"]))?$_POST["id_acc"]:0;

    if ($ROW_role!=0) {
        $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
        $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
    }
    else { $styleH=''; $styleF=''; }

    $ret = 0;
    $mysqli = new_connect($ret);
    echo "<p/> result_connect mysqli=" . $mysqli->connect_errno;
    //=============================================================Информация по id счета
    if ($_POST["id_acc"]>0) {
        $acc_date = new Acc_Data($_POST["id_acc"],$mysqli);
        echo "<pre> id_acc=".$_POST["id_acc"]." <br>".print_r($acc_date->row_acc,true)."</pre>";

        ?>
<table border='1' style='border-collapse: collapse;'>
    <tr><td colspan="4">счет № <?=$acc_date->row_acc[number]?> от <?=$acc_date->row_acc[date]?> [<?=$acc_date->row_acc[name]?> инн: <?=$acc_date->row_acc[inn]?>]
    <tr><td>на сумму: <td><?=$acc_date->row_acc[summa]?>
    <tr><td>срок поставки (дней): <td><?=$acc_date->row_acc[delivery_day]?>
        <td>дата поставки: <td><?=$acc_date->row_acc[date_delivery]?>
    <tr><td>дата создания: <td><?=$acc_date->row_acc[date_create]?>
    <tr><td>дата изменения: <td><?=$acc_date->row_acc[date_last]?>
    <tr><td>комментарий к счету: <td><?=$acc_date->row_acc[comment]?>
    <tr><td>создал: <td><?=$acc_date->row_acc[name_user]?>
    <tr><td>материалы:
    <tr><td colspan="4"><table border='1' style='border-collapse: collapse;'>
         <tr><th>раздел<th>статья<th>наименование<th>ед<th>кол<th>цена<th>сумма<th>поставка
            <?php
            foreach ($acc_date->row_acc[material] as $item) {
?>
    <tr><td>
        <td>
        <td><?=$item[smeta][material]?>

        <td><td><?=$item[count_material]?>
        <td><?=$item[price_material]?>
        <td><?=($item[count_material]*$item[price_material])?>
        <td>
    <tr><td><?=$item[smeta][razdel1]?>
        <td><?=$item[smeta][razdel2]?>
        <td><td><?=$item[smeta][units]?>
        <td><?=$item[smeta][count_units]?>
        <td><?=$item[smeta][price]?>
        <td><?=$item[smeta][subtotal]?>
    <tr><td colspan="2">закрыто:
        <td><td><td><?=$item[smeta][count_realiz]?>
        <td><td><?=$item[smeta][summa_realiz]?>
    <tr><td colspan="2">заявка:
        <td>№<?=$item[doc_material][number]?> от <?=$item[doc_material][date]?> <?=$item[doc_material][name]?>
        <td><td><?=$item[doc_material][count_units]?>
        <td><td><td><?=$item[doc_material][date]?>
    <tr><td colspan="2">склад:
        <td><?=$item[stock][name]?>
        <td><?=$item[stock][units]?>
        <td><?=$item[stock][count_units]?>
        <td><td><?=$item[stock][subtotal]?>
            <?
            }
            ?>
        </table>
</table>
<?php
    }
    ?>
    <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="edo" value="1"/>

        <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">
            <caption <?=$styleH?>><div style="padding:3px;">Информация по счету</div></caption>

            <tr><td style="padding-right: 10px">id Счета:<td>
                    <input class="text"  name="id_acc" size="10" value="<?=$id_acc?>" />



                    <?php
                    SHOW_tfoot(4,1,1,1);
                    ?>
        </table>

        <?



}

class Acc_Data {
    var $mysqli;
    var $row_acc;

    public function Acc_Data($id_acc,$mysqli) {
        $this->row_acc = array();
        $this->mysqli = $mysqli;
        $sql ="
SELECT A.*,
C.`inn`,C.`name`,
U.`name_user` 
FROM `z_acc` A 
LEFT JOIN `z_contractor` C ON (A.`id_contractor` = C.`id`) 
LEFT JOIN `r_user` U ON (A.`id_user` = U.`id`)
WHERE 
A.id=$id_acc
    ";
        if ($result = $mysqli->query($sql)) {
            if ($this->row_acc = $result->fetch_assoc()) {
                // ------------------- материалы счета
                $sql_m = "
SELECT * FROM `z_doc_material_acc` WHERE id_acc=$id_acc                 
                ";
                if ($result_m = $mysqli->query($sql_m)) {
                    while ($row_m = $result_m->fetch_assoc()) {
                        $this->row_acc[material][] = $row_m;

                    }
                    $result_m->close();
                }
                //--------------------как материалы связаны с заявкой и информация о заявке
                foreach ($this->row_acc[material] as $key => $item_acc) {
                    $sql_z = "
SELECT 
  Z.`id`,
  Z.`id_doc`,
  Z.`id_i_material`,
  Z.`id_stock`,
  Z.`id_object`,
  Z.`count_units`,
  Z.`count_units_act`,
  Z.`date_delivery`,
  Z.`id_group_material`,
  Z.`status`,
  Z.`memorandum`,
  Z.`id_sign_mem`,
  Z.`signedd_mem`,
  D.*
   
FROM  
`z_doc_material` Z, `z_doc` D
WHERE 
Z.`id` = ".$item_acc[id_doc_material]."
AND Z.`id_doc` = D.`id`
                    ";
                    if ($result_z = $mysqli->query($sql_z)) {
                        if ($row_z = $result_z->fetch_assoc()) {
                            $this->row_acc[material][$key][doc_material] = $row_z;
                            //----------------------материал в себестоимости (смете)
                            $sql_s = "
SELECT
  `id`,
  `id_razdel2`,
  `razdel1`,
  `razdel2`,
  `material`,
  `id_implementer`,
  `units`,
  `count_units`,
  `price`,
  `subtotal`,
  `title`,
  `count_realiz`,
  `summa_realiz`,
  `displayOrder`,
  `id_stock`
FROM
  `i_material`
  WHERE id = ".$this->row_acc[material][$key][doc_material][id_i_material];
                            if ($result_s = $mysqli->query($sql_s)) {
                                if ($row_s = $result_s->fetch_assoc()) {
                                    $this->row_acc[material][$key][smeta] = $row_s;
                                }
                                $result_s->close();
                            }
                            //--------------------материал на складе
                            $sql_t = "
SELECT 
S.`id`, S.`name`, S.`units`
, SUM(M.count_units) AS count_units, SUM(M.subtotal) AS subtotal
FROM 
`z_stock` S, `z_stock_material` M
WHERE 
S.`id`=".$this->row_acc[material][$key][doc_material][id_stock]."
AND S.`id` = M.`id_stock`                            
                            ";
                            if ($result_t = $mysqli->query($sql_t)) {
                                if ($row_t = $result_t->fetch_assoc()) {
                                    $this->row_acc[material][$key][stock] = $row_t;
                                }
                                $result_t->close();
                            }

                        }
                        $result_z->close();
                    }
                }
            }
            $result->close();
        }
    }
}
?>


