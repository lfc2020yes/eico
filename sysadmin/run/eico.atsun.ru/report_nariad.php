<?php
include_once '../ilib/Isql.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/lib_interstroi.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{


    $GT=array();
    GET_PARAM($GT,$PARAM);

    $id_nariad =  (isset($_POST["id_nariad"])) ? $_POST["id_nariad"] : 0;

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
        nariad_sign($mysqli, $id_nariad, 1, 5, 0, true);
    }
    ?>
    <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="edo" value="1"/>

        <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">
            <caption <?=$styleH?>><div style="padding:3px;">Информация по наряду</div></caption>

            <tr><td style="padding-right: 10px">id Наряда:<td>
                    <input class="text"  name="id_nariad" size="10" value="<?=$id_nariad?>" />



                    <?php
                    SHOW_tfoot(4,1,1,1);
                    ?>
        </table>

        <?



}

class Doc_Data {
    var $mysqli;
    var $row_doc;
    var $si;  //SqlInfo

    public function Doc_Data($id_doc,$mysqli) {
        $this->si = new SqlInfo();
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
        $this->si->Save($sql,__FUNCTION__);
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
                $this->si->Save($sql_m,__FUNCTION__);
                if ($result_m = $mysqli->query($sql_m)) {
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
                        if ($result_a = $mysqli->query($sql_a)) {
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
                                if ($result_na = $mysqli->query($sql_na)) {
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
                        if ($result_t = $mysqli->query($sql_t)) {
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
                        if ($result_ts = $mysqli->query($sql_ts)) {
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
                        if ($result_n = $mysqli->query($sql_n)) {
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
            $result->close();

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
          if (($material[count_units_doc] - $material[count_units_act]) <= $count_user) { //Передача по акту приемо-передачи
              if (($material[count_units_doc] - $material[сount_units_nariad]) == 0 ) {  //Закрытие по нарыду
                  $status = 1; // позиция готова к закрытию заявки
                  $comment = 'позиция готова к закрытию заявки';
              } else {
                  $status = 5; // позиция готова к закрытию заявки
                  $comment = 'Материал получен';
              }
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
?>

