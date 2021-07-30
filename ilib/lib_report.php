<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/Isql.php';

// Электронный документооборот
class REPORT
{
    var $mysqli;

    var $error;
    var $error_name;

    var $debug;
    var $show;

    public function EDO($mysqli, $show=false)
    {
        $this->mysqli = $mysqli;
        $this->error_name = array(
            'ок' //0

        );
        $this->debug = array();
        $this->show = $show;
    }
    /** Сбор последовательности запросов
     * @param $sql
     * @param $name_function
     */
    private function Debug($sql, $name_function) {
        $this->debug[] = $name_function;
        $i = count($this->debug) - 1;
        $this->debug[$i][sql] = $sql;
    }
// Выбор по объектам реализации
/*SELECT
T.`town`, K.`kvartal`,
O.`object_name`, O.`total_r0`,O.`total_r0_realiz`, O.`total_m0`,O.`total_m0_realiz`,
SUM(R1.summa_r1), SUM(R1.`summa_m1_realiz`), SUM(R1.`summa_m1`), SUM(R1.`summa_r1_realiz`)
FROM
`i_town` AS T,
`i_kvartal` AS K,
`i_object` AS O,
`i_razdel1` AS R1
WHERE
T.`id` = K.`id_town`
AND K.`id` = O.`id_kvartal`
AND O.`id` = R1.`id_object`
GROUP BY
T.`town`, K.`kvartal`,
O.`object_name`, O.`total_r0`,O.`total_r0_realiz`, O.`total_m0`,O.`total_m0_realiz`
*/

/*
SELECT

O.`object_name`, O.`total_r0`,O.`total_r0_realiz`, O.`total_m0`,O.`total_m0_realiz`
,R1.*
,R2.*
,M.*

-- ,SUM(R1.summa_r1), SUM(R1.`summa_m1_realiz`), SUM(R1.`summa_m1`), SUM(R1.`summa_r1_realiz`)
FROM

`i_object` AS O,
`i_razdel1` AS R1,
`i_razdel2` AS R2,
`i_material` AS M
WHERE

R1.`id_object` =50

AND O.`id` = R1.`id_object`
AND R1.`id` = R2.`id_razdel1`
AND R2.`id` = M.`id_razdel2`
-- GROUP BY

-- O.`object_name`, O.`total_r0`,O.`total_r0_realiz`, O.`total_m0`,O.`total_m0_realiz`

 */

/*
 Отчет всегда по всей стройке или отдельно группировать по подъобектам.
Отчет по плану и закрытому факту
Отчет по заявкам (всем, в т.ч. не закрытым)
Отчет по всем заявкам
-по всем взятым счетам (несогласованным в т.ч.)
- по согласованным сетам
- по оплаченным счетам

- пересчет счета
- пересчет заявки
*/


}

class Doc_Data {
    var $mysqli;
    var $id_doc;
    var $row_doc;
    var $si;  //SqlInfo

    /**  Получить начальные значения заявки
     * Doc_Data constructor.
     * @param $id_doc
     * @param $mysqli
     */
    public function Doc_Data($id_doc,$mysqli)
    {
        $this->si = new SqlInfo();
        $this->row_doc = array();
        $this->mysqli = $mysqli;
        $this->id_doc = $id_doc;
        $sql = "
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
        $this->si->Save($sql, __FUNCTION__);
        if ($result = $mysqli->query($sql)) {
            $this->row_doc = $result->fetch_assoc();
        }
    }

    /** ПОлучить полные данные по заявке и связанных с ней документов
     *
     */
    public function Get_Data() {
        if ($this->row_doc) {
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
  D.count_units_nariad, 
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
D.id_doc=$this->id_doc
AND D.`id_i_material` = M.`id`                 
                ";
                $this->si->Save($sql_m,__FUNCTION__);
                if ($result_m = $this->mysqli->query($sql_m)) {
                    while ($row_m = $result_m->fetch_assoc()) {
                        $this->row_doc[material][] = $row_m;
                        $i = count($this->row_doc[material]) - 1;
                        //----------------------------------------счета по материалу
                        $sql_a = "
SELECT
  M.`id` as id_doc_material_acc,
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
                        $this->si->Save($sql_a,__FUNCTION__);
                        if ($result_a = $this->mysqli->query($sql_a)) {
                            while ($row_a = $result_a->fetch_assoc()) {
                                $this->row_doc[material][$i][acc][] = $row_a;
//-------------------------------Накладные по счету
                                $sql_na = "
SELECT
  N.`id`,
  N.`id_invoice`,
  N.`id_acc`,
  N.`id_doc_material_acc`,
  N.`id_stock`,
  N.`count_units`,
  N.`price`,
  N.`price_nds`,
  N.`subtotal`,
  N.`subtotal_defect`,
  N.`count_defect`,
  N.`defect`,
  N.`defect_comment`,
  V.*,
  S.`name_status`,
  U.`name_user`
FROM
`z_invoice_material` N, 
z_invoice V
LEFT JOIN `r_status` S ON(V.`status` = S.`numer_status` AND S.`id_system` = 17)
LEFT JOIN `r_user` U ON (V.`id_user` = U.`id`)

WHERE N.`id_doc_material_acc` = ".$row_a[id_doc_material_acc]."
AND N.`id_invoice` = V.`id`                        
                        ";
                                $this->si->Save($sql_na,__FUNCTION__);
                                if ($result_na = $this->mysqli->query($sql_na)) {
                                    while ($row_na = $result_na->fetch_assoc()) {
                                        $this->row_doc[material][$i][invoice][acc][] = $row_na;
                                    }
                                    $result_na->close();
                                }

                            }
                            $result_a->close();
                        }
                        //--------------------------------склад суммой
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
                        $this->si->Save($sql_t,__FUNCTION__,"Склад суммой");
                        if ($result_t = $this->mysqli->query($sql_t)) {
                            if ($row_t = $result_t->fetch_assoc()) {
                                $this->row_doc[material][$i][stock] = $row_t;
                            }
                            $result_t->close();
                        }
//--------------------------------склад по ответственным
                        $sql_ts = "
SELECT
S.*,M.*,
U.`name_user`
FROM
`z_stock` S, 
`z_stock_material` M
LEFT JOIN `r_user` U ON (M.`id_user` = U.`id`)
WHERE
S.`id`=".$row_m[id_stock]."
AND S.`id` = M.`id_stock`
                     
                            ";
                        $this->si->Save($sql_ts,__FUNCTION__,"Склад по ответственным");
                        if ($result_ts = $this->mysqli->query($sql_ts)) {
                            while ($row_ts = $result_ts->fetch_assoc()) {
                                $this->row_doc[material][$i][stock_user][] = $row_ts;
                            }
                            $result_ts->close();
                        }
                        //-------------------------------Накладные по складу
                        $sql_n = "
SELECT
  N.`id`,
  N.`id_invoice`,
  N.`id_acc`,
  N.`id_doc_material_acc`,
  N.`id_stock`,
  N.`count_units`,
  N.`price`,
  N.`price_nds`,
  N.`subtotal`,
  N.`subtotal_defect`,
  N.`count_defect`,
  N.`defect`,
  N.`defect_comment`,
  V.*,
  S.`name_status`,
  U.`name_user`
FROM
`z_invoice_material` N, 
z_invoice V
LEFT JOIN `r_status` S ON(V.`status` = S.`numer_status` AND S.`id_system` = 17)
LEFT JOIN `r_user` U ON (V.`id_user` = U.`id`)

WHERE N.`id_stock` = ".$row_m[id_stock]."
AND N.`id_invoice` = V.`id`                        
                        ";
                        $this->si->Save($sql_n,__FUNCTION__,'Накладные по id_stock');
                        if ($result_n = $this->mysqli->query($sql_n)) {
                            while ($row_n = $result_n->fetch_assoc()) {
                                $row_n[in] = $this->is_acc_in_array($row_n, $this->row_doc[material][$i][invoice][acc] );  //Проверить, есть ли уже такая накладная, связанная со счетом
                                $this->row_doc[material][$i][invoice][stock][] = $row_n;
                            }
                            $result_n->close();
                        }
                    }
                    $result_m->close();
                }
            }

    }


    /** Проверить наличие накладной полученной по id_stock как накладной, связанной со счетом
     * @param $acc array
     * @param $arr array[]
     * @return int 0 1
     */
    private function is_acc_in_array ($acc, $arr) {
        //echo "<pre> ACC=".print_r($acc,true)."</pre>";
        foreach ($arr as $item) {
            if ( $acc[number] == $item[number]
                AND $acc[date] == $item[date]
                AND $acc[summa] == $item[summa]
                AND $acc[date_create] == $item[date_create]
                AND $acc[id_user] == $item[id_user])
                return 1;

        }
        return 0;
    }

}

class SqlInfo {
    /** Сбор последовательности запросов
     * @param $sql
     * @param $name_function
     */
    var $debug;
    public function SqlInfo(){
        $debug = array();
    }

    /** Сохранить запрос
     * @param $sql
     * @param $name_function
     * @param string $comment
     */
    public function Save($sql, $name_function,$comment='') {
        $this->debug[][name] = $name_function;
        $i = count($this->debug) - 1;

        if (!($comment==''))
            $this->debug[$i][comment] = $comment;
        $this->debug[$i][sql] = $sql;
    }

    /**
     *  вывести все запросы
     */
    public function Show() {
        echo '<pre>'.print_r($this->debug,true) .'</pre>';
        echo '<pre>=====================================</pre>';
    }
}
//Анализировать массив данных по заявке
class DocZ {
    var $status_all;
    var $status;
    var $doc;

    public function DocZ(&$arr) {
        $this->status = array();
        $this->doc = $arr;
    }

    public function analyze() {
        // $doc[id_user] - владелец заявки
        foreach($this->doc[material] as $material)  {
            $count_user = 0;
            $count =0;
            if (isset($material[stock_user]))
                foreach($material[stock_user] as $material_user) {
                    $count += $material_user[count_units];
                    if ($material_user[id_user] == $this->doc[id_user]) {
                        $count_user += $material_user[count_units];
                    }
                }
            $status = 0; $comment = '';
            //echo "<pre>{$material[count_units_doc]} - {$material[count_units_nariad]} = ".($material[count_units_doc] - $material[count_units_nariad])."</pre>";
            if (($material[count_units] - $material[count_units_nariad]) <= 0 ) {  //Закрытие по наряду
                $status = 1; // позиция готова к закрытию заявки
                $comment = 'закрыта по наряду - готова к закрытию заявки';
            } elseif (($material[count_units_doc] - $material[count_units_act]) <= $count_user) { //Передача по акту приемо-передачи
                $status = 5; //
                $comment = 'Материал получен';
            } elseif (($material[count_units_doc] - $material[count_units_act]) <= $count) {
                $status = 2; // необходимо передать материал со склада на владельца заявки
                $comment = "Необходимо передать ".($material[count_units_doc] - $material[count_units_act] - $count_user)
                    ." ".$material[units]." со склада [".$this->doc[name_user]."]";
            } elseif ($count==0) {
                $status = 3;
                $comment = "Необходимо получить материал на склад";
            }  elseif ($count>0) {
                $status = 4;
                $comment = "Недостаточно материала на складе";
            }
            $st = array($status,$comment);
            $this->status[] = $st;
        }
        $this->status_all = array(0,'');
        foreach ($this->status as $item) {
            if ($this->status_all[0] < $item[0]) {
                $this->status_all[0] = $item[0];
                $this->status_all[1] = $item[1];
            }
        }
    }
}
