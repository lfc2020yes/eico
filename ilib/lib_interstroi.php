<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/lib_edo.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/lib_report.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/Isql.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'module/function.php';

/*

DELIMITER $$
USE `atsunru_interstroi`$$

DROP PROCEDURE IF EXISTS `get_numer_doc`$$

CREATE
    //[DEFINER = { user | CURRENT_USER }]
    PROCEDURE `atsunru_interstroi`.`get_numer_doc`(IN vol_data DATE, IN vol_type INT, OUT vol_numer INT)
    LANGUAGE SQL
    	BEGIN
    	
    	//DECLARE num INT DEFAULT 1; 
        SELECT numer_doc INTO vol_numer FROM n_numer WHERE date_doc=vol_data AND type_doc=vol_type;
        #001    
        IF vol_numer IS NULL THEN
           #002
           SET vol_numer=1;
           INSERT INTO n_numer VALUE (vol_data,vol_type,vol_numer);
        ELSE
           #003
           SET vol_numer=vol_numer+1;
           UPDATE n_numer SET numer_doc=vol_numer WHERE date_doc=vol_data AND type_doc=vol_type;  
        END IF;
        #004  
	END$$

DELIMITER ;

*/
// Получить номер документа
//$numer=get_numer_doc(&$mysqli,"2017-02-28",1)

function get_numer_doc(&$mysqli,$date,$type) {
    $num=0;
    $sql = "select numer_doc from n_numer WHERE  date_doc='$date' AND type_doc=$type";
    $result = $mysqli->query( $sql );
    //echo "<br>". $sql;

    if( $row = $result->fetch_assoc() ) {
        $num = 1+$row[numer_doc];
        $sql = "UPDATE n_numer SET numer_doc=$num WHERE date_doc='$date' AND type_doc=$type";
         //echo "<br>". $sql;
        $mysqli->query($sql);
    } else {
        $num = 1;
        $sql = "INSERT INTO n_numer VALUE ('$date',$type,$num)";
        //echo "<br>". $sql;
        $mysqli->query($sql);
    }
    return $num;
}
function get_numer_doc__(&$mysqli,$date,$type) {
  
  $num = 0;  
  $sql = "CALL get_numer_doc('$date',$type,@num)";
  $mysqli->query($sql);
  echo "<br>". $sql;
  if($result=$mysqli->query('SELECT @num as numer')) {
    while( $row = $result->fetch_assoc() ){ 
      $num=$row['numer'];
      break;
    } 
  }
  return $num;
}

//получить доступы на вывод из базы
class RoleUser
{
  var  $mysqli;  
  var  $id;
  var  $row   =array();
  var  $column =array();
  var  $right = array();
  var  $codec;
  
  function RoleUser(&$mysqli,$id_user)  {           //читать права на доступ к данным     
      $this->mysqli=$mysqli;
      $this->id=$id_user;
      $this->codec = new codec();
   
    //echo '<p/> иницилизация '.$this->id.':'.$id_user;
  }
  //-------------------------------Читать разрешения на модули
  function GetPermission() {
    $r=array();  
    //$m=$this->mysqli;
    if($result=$this->mysqli->query("
SELECT a.alias,m.permission 
FROM r_user u, r_role_modul m , r_alias_table a
WHERE u.id=$this->id
AND u.id_role=m.id_role                    
AND m.id_alias_table=a.id    
                    ")){
     //echo '<p/>sql='.$this->mysqli->info.' user='.$this->id.' count='.$result->num_rows.' ver='.$this->mysqli->host_info ;
     while( $row = $result->fetch_assoc() ){
        //echo '<p/> alias='.iconv("UTF-8", "WINDOWS-1251",$row['alias']).' permission='.iconv("UTF-8", "WINDOWS-1251",$row['permission']);
        $r[]=$row['alias'];
        $r[]=$row['permission'];
        $this->right[]=$r;
        unset($r);
     }
     $result->close();
    }    
  }
  function permission($alias,$action) {
    $res=FALSE;
    for($i=0;$i<count($this->right);$i++) {
        //echo '<p/>'.'>>'.$this->right[$i][0].'->>'.$this->right[$i][1].'->'.$alias.'->>'.$action;
        if (strcasecmp($this->right[$i][0],$alias)==0) {
            //echo '<p/>ok';
            if (!(strpos(strtoupper($this->right[$i][1]),strtoupper($action))===false)) {
                $res=TRUE;
                break;
            }
        }
    }
    return $res;
  }  
  //-------------------------------Читать все исключения строк по значениям
  function GetRows() { 
    $r=array();  
    if($result=$this->mysqli->query("
                    SELECT re.* 
                    FROM r_user u, r_razdel_exlude re
                    WHERE 
                    u.id=$this->id AND re.id_role=u.id_role
                    ")){
    //echo '<p/>'.$sql0->sql;
     while( $row = $result->fetch_assoc() ){  //Упаковка в память
        $r[]=$row['name_table'];
        $r[]=$row['name_column'];
        $r[]=$row['value_column'];
        $this->row[]=$r;
        unset($r);
     }
     $result->close();
    }
  }  
  //-------------------------------Читать все исключения полей по значениям
  function GetColumns() {
    $r=array();  
    if($result=$this->mysqli->query("
                    select ce.* 
                    from r_user u, r_column_exclude ce
                    where 
                    u.id=$this->id and ce.id_role=u.id_role
                    ")){
    //echo '<p/>'.$sql0->sql;
     while( $row = $result->fetch_assoc() ) {   //Упаковка в память
        $r[]=$row['name_table'];
        $r[]=$row['name_column'];
        $r[]=$row['permission'];
        $this->column[]=$r;
        unset($r);
    
     }
     $result->close();
    }
  }
  //-------------------------------проверить доступ к строке
  function is_row($name_table,$name_column,$value_column)
  {
    $res=TRUE;
    //echo "<p/>".json_encode($this->row);
    //echo "<p/>".':'.$name_table.':'.$name_column.':'.$value_column;
    for($i=0;$i<count($this->row);$i++) {
        //echo "<p/>".json_encode($this->row[$i]);
        if (($this->row[$i][0]==$name_table) 
         && ($this->row[$i][1]==$name_column) 
         && (strcasecmp((string)$this->row[$i][2],(string)$value_column)==0))  {
            $res=FALSE; 
            break;
        }
    }
    return $res;
  }
  //-------------------------------получить разрешенное значение поля
  function is_column($name_table,$name_column,$value_column=true,$default=false) {
    //echo "<p/>".json_encode($this->column);
      // echo "<pre>$name_table -> $name_column</pre>";  //Проверка запросов
    for($i=0;$i<count($this->column);$i++) {
        if (($this->column[$i][0]==$name_table)
         && ($this->column[$i][1]==$name_column )) {
         //echo "<p/>2ok"; 
            if ($this->column[$i][2]=='U') return $value_column;  //можно показывать, но нельзя редактировать, нужно писать посимвольный разбор
            return $default;
        }
    }
    return $value_column;
  }
  function is_column_edit($name_table,$name_column) {
      for($i=0;$i<count($this->column);$i++) {
        if (($this->column[$i][0]==$name_table)
         && ($this->column[$i][1]==$name_column )) {
            //if ($name_table == 'n_material' and $name_column == 'price') echo "<pre>test1</pre>";
            if ($this->column[$i][2]=='U') {    //нужно писать посимвольный разбор  РАБОТАЕТ ТОЛЬКО [U]
                //if ($name_table == 'n_material' and $name_column == 'price') echo "<pre>test2</pre>";
              return true;
            } else break;
        }
      }
      return false;
  }
} //class

// получуть разрещение на вывод поля
/*
//пример использования
$role = new RoleUser(&$mysqli,$id_user);
$role->GetPermission();
$role->GetRows();  
$role->GetColumns();  

if ($role->is_row($name_table,$name_column,$value_column)){};   //true -> false
echo $role->is_column($name_table,$name_column,$value_column,null);   //data -> null

if ($role->permission("Себестоимость",'R')) {};   //R A U D
if ($role->permission("Себестоимость",'A')) {};
 
 */
function material_nariad_jurnal_delete(&$mysqli, $row_nariad) {
    return "delete from z_doc_material_nariad where id_nariad = {$row_nariad['id']}";
}

function material_to_doc(&$mysqli, $row_n_material)
{
    $sqls = '';
    $COMA = '';
    $sql="select * from z_doc_material_nariad where id_n_material = {$row_n_material['id']}";
    if ($result_r = $mysqli->query($sql)) {
        while ($row_r = $result_r->fetch_assoc()) {  // могут быть разные заявки - поэтому не надо суммировать
            $sqls .=$COMA. "
update z_doc_material 
set count_units_nariad = count_units_nariad - {$row_r[count_units]} 
where 
id = {$row_r[id_doc_material]}
            ";
            $COMA=';';
        }
        $result_r->close();
    }
    return $sqls;
}

/*
 -- SELECT M.*, I.`alien` FROM z_doc_material M, i_material I
-- where M.`id_i_material` = 30850 -- id_stock=3
-- and M.`id_i_material` = I.`id`
обеспечить полученную заявку в зависимости от alien

-- взять все заявки с этим материалом и обеспеченные материалом
SELECT M.* FROM z_doc_material M WHERE M.id_stock = 3
обеспечить полученную заявку в зависимости от alien
-- взять материал по цене в зависимости от alien

  */

/** Заполнение заявок по материалам при закрытии наряда (только +)
 * @param $mysqli
 * @param $arr_docs - массив для сбора заявок по закрытию
 * @param $row_nariad
 * @param $row_n_material
 * @return string - sql срипт
 */


function material_from_doc(&$mysqli, &$arr_docs, $row_nariad, $row_n_material, $show = false){  // id_nariad id_n_material
    $sqls = ''; $COMA='';

    //$row_nariad[id_user]
    //row_n_work[id_razdeel2]
    $count_units_m = $row_n_material[count_units]; // Сколько можно списывать
//взять заявку по этому материалу
    $sql = "SELECT M.*, I.`alien` FROM z_doc_material M, i_material I
     where M.`id_i_material` = {$row_n_material[id_material]} -- 30850 
     and M.`id_i_material` = I.`id` 
 ";
    if($show) echo "<pre>SQL:$sql</pre>";
    if ($result_doc_material = $mysqli->query($sql)) {  //может быть несколько заявок по одному пункту работ
        while  ($row_doc_material = $result_doc_material->fetch_assoc()) {  //$row_doc_material[count_units] - $row_doc_material[count_units_nariad]
            //получить материалы в зависимости от alien
            //$cena =  ($row_doc_material[alien]==0) ? "<>0" : "=0";
            $count_z = $row_doc_material[count_units]-$row_doc_material[count_units_nariad]; //Сколько незакрытого материала в заявке
            if($show) echo "<pre>Материал Заявки id = {$row_doc_material[id]} количество = $count_z надо: $count_units_m</pre>";
            $sql_material = "
            SELECT * FROM z_stock N, `z_stock_material` S
            WHERE N.id = {$row_doc_material[id_stock]}
            AND S.`id_stock` = N.`id`
            AND S.`id_user` = {$row_nariad[id_user]}
            AND S.`alien` = {$row_doc_material[alien]}
            -- AND S.price > 0
            AND S.`count_units` > 0            
            ";
            if($show) echo "<pre>SQL:$sql_material</pre>";
            if ($result_stock = $mysqli->query($sql_material)) {
                $update_count_sum = 0;
                while ($row_stock = $result_stock->fetch_assoc()) {
                    if($count_units_m == 0) break;

                    if($count_z > 0) { //Есть что списать
                        $update_count = ($count_units_m > $count_z) ? $count_z : $count_units_m; //спишем часть или ВСЕ
                        if ($update_count == $count_z) { //Списывается весь материал по заявке для закрытия мозиции по заявке
                            $arr_docs[$row_doc_material[id_doc]] = $row_doc_material[id_doc];   // Сохранить в массиве заявок (не совпадающие)
                        }

                        $sqls .=$COMA. "
                        INSERT INTO `z_doc_material_nariad` (
                          `id_doc_material`,
                          `count_units`,
                          `id_doc`,
                          `id_nariad`,
                          `id_n_material`
                                                             
                        )
                        VALUES
                          (
                            {$row_doc_material[id]},
                            $update_count,
                            {$row_doc_material[id_doc]},
                            {$row_nariad[id]},
                            {$row_n_material[id]}
                          )";
                        $COMA=';';
                        $count_units_m -= $update_count;
                        $count_z -= $update_count;
                        $update_count_sum += $update_count;
                    }
                }
                $result_stock->close();
                if ($update_count_sum>0) {
                    $sqls .=$COMA. "
                        update z_doc_material 
                        set count_units_nariad = count_units_nariad + $update_count_sum 
                        where id = ".$row_doc_material[id];
                    $COMA=';';
                }
            }
        }
        $result_doc_material->close();
        if ($count_units_m > 0) {
            $sqls .= $COMA. "-- ОШИБКА недостаточно материалов в заявках пользователя";
            if ($show) echo "<pre>ОШИБКА НЕДОСТАТОЧНО МАТЕРИАЛОВ В ЗАЯВКАХ ПОЛЬЗОВАТЕЛЯ</pre>";
        }
    }
    return $sqls;
}

/** Возврат материалов пользователю из за расподписания наряда по n_material_act
 * @param $mysqli
 * @param $row_nariad
 * @param $row_n_material
 * @return string
 */
function material_to_user(&$mysqli,  $row_nariad,$row_n_material)
{
    $sqls = '';
    if($row_nariad[status]==2 and $row_nariad[signedd_nariad]==1) {
        $sql = "SELECT * FROM `n_material_act` WHERE `id_n_materil` = {$row_n_material[id]}";
        if ($result = $mysqli->query($sql)) {
            $COMA = '';
            while ($row = $result->fetch_assoc()) {
                $sqls .= $COMA . "
UPDATE z_stock_material 
SET count_units = count_units + {$row[count_units]} 
WHERE id = '{$row[id_stock_material]}'";
                $COMA = ';';
            }
            $sqls .= $COMA . "delete from `n_material_act` WHERE `id_n_materil` = {$row_n_material[id]}";
            $result->close();
        }
    }
    return ($sqls == '')? false : $sqls;
}

/** Получить id_kvartal по id_object
 * @param $mysqli
 * @param $row_nariad
 */
function oblect2kvartal($mysqli,$id_object) {
    $id_kvartal = 0;
    $sql="
SELECT id_kvartal FROM i_object WHERE id='$id_object'
    ";
    if ($result = $mysqli->query($sql)) {
        if ($row = $result->fetch_assoc()) {
            $id_kvartal = $row[id_kvartal];
        }
    }
    return $id_kvartal;
}
/** Списание с пользователя материалов
 * @param $mysqli
 * @param $row_nariad
 * @param $row_n_material
 * @return false|string
 */
function material_from_user(&$mysqli, &$summa_material, &$count_material, $row_nariad,$row_n_material, $show = false){

    $id_kvartal = oblect2kvartal($mysqli,$row_nariad[id_object]);
    $sqls = ''; $COMA='';
    $count_units_m = $row_n_material[count_units];
    $sql="
SELECT
S.`id` AS id_stock_materil,S.`count_units` AS stock_count_units, S.`price` AS stock_price,       
I.*, S.*
FROM
`i_material` I,
`z_stock_material` S
WHERE 
I.`id` = {$row_n_material[id_material]}
AND I.`id_stock` = S.`id_stock`
AND I.`alien` = S.`alien`
AND S.`id_kvartal` = '$id_kvartal'  
AND S.`count_units` > 0  
AND S.`id_user` = ".$row_nariad[id_user];

    if($show) echo "<pre> ОТЛАДКА material_from_user {$row_n_material[count_units]} $sql </pre>";

    if ($result_s = $mysqli->query($sql)) {
        while ($row_s = $result_s->fetch_assoc()) { //перебор полученных пользователем материалов
            if ($count_units_m == 0) break;
            $count_z = $row_s[count_units];
            if ($count_z > 0) { //Есть что списать
                $update_count = ($count_units_m > $count_z) ? $count_z : $count_units_m; //спишем часть или ВСЕ
                $sqls .= $COMA . "
update z_stock_material 
set count_units = count_units - $update_count 
where 
id = ".$row_s[id_stock_materil];
                $COMA = ';';
                //Аст списания материалов (по транзакциям от полученных с разными ценами)
                $sqls .= $COMA . "
INSERT INTO n_material_act (
  id_n_materil,
  id_stock_material,
  count_units,
  price
)
VALUES
  (
    {$row_n_material[id]},
    {$row_s[id_stock_materil]},
    {$update_count},
    {$row_s[stock_price]}
  )";
                $count_units_m -= $update_count;
                if (round($row_s[stock_price],2)>0) {
                    $summa_material += ($row_s[stock_price] * $update_count);
                    $count_material += $update_count;
                }
            }

        }
        $result_s->close();
    }
    //echo "<pre> ОТЛАДКА [$sqls] </pre>";
    return ($count_units_m>0) ? false : $sqls;
}
//===========================================================================
/** Расчет выполнение при подписи наряда
 * @param $mysqli
 * @param $id_nariad
 * @param $signedd
 * @param $sign_level
 * @param int $id_user = 0 от запустившего пользователя
 * @param false $show
 * @return false|mixed 0-false 1-true 2-недостаточно материалов у пользователя 3-недостаточно материалов в заявках
 */
function nariad_sign(&$mysqli, $id_nariad, $signedd, $sign_level, $id_user=0,$show=false, $exec=true) {
     $codecP= new codec();
     $plus = ($signedd==1) ? '+': '-';
     if ($show) echo "<pre> SIGNED = $plus</pre>";
     $sql = '';
     $COMA = '';
     $ret = 0;
     $arr_docs = array();
     if ($sql_nariad = $mysqli->query("select * from n_nariad where id='$id_nariad'")) {
      while( $row0 = $sql_nariad->fetch_assoc() ){   //if
         //----------------------обход по работам
         if ($sql_nwork = $mysqli->query("select * from n_work where id_nariad='$id_nariad'")) {
          while( $row1 = $sql_nwork->fetch_assoc() ){  
             if($show) 
             echo "<p/>id=".$row1['id_razdeel2']
                           .' name_work='.$codecP->iconv($row1['name_work'])
                           .' count='. $row1['count_units'] .' summa='.$row1['subtotal']; 
             //----------------------------------обход по материалам
             //$summa_mat=0;
             if ($sql_nmat = $mysqli->query("select * from n_material where id_nwork='".$row1['id']."'")) {
               while( $row2 = $sql_nmat->fetch_assoc() ){ 
                 if($show) {
                     echo "<p/><tab>id=" . $row2['id_material']
                         . ' material=' . $codecP->iconv($row2['material'])
                         . ' count=' . $row2['count_units'] . ' summa=' . $row2['subtotal'];   ///TODO
                 }
                 if ($row2['count_units']>0) {


                     if ($signedd == 1) {   //Провести наряд
                         $summa_material = 0.00;
                         $count_material = 0.000;
                         if (($sm = material_from_user($mysqli, $summa_material, $count_material, $row0, $row2, $show)) === false) {  //Списать материал с пользователя
                             /* ошибка недостаточно материалов у пользователя */
                             $ret = 2;
                             break 2;
                         } else {
                             $sql .= $COMA . $sm;
                             $COMA = ';';
                             //Уточнение списываемой цены и суммы материала в наряде (по триггеру)
                             if (round($count_material,3) > 0) {
                                 $sql .= $COMA . "
update n_material set price = " . (round($summa_material / $count_material /*$row2['count_units']*/, 2)) . " where id = {$row2['id']}";

                             }
                         }
                         $sm = material_from_doc($mysqli, $arr_docs, $row0, $row2, $show); //Списание материалов c заявок
                         //echo "<pre>ПОЛУЧИЛ[$sm]</pre>";
                             /* ошибка недостаточно материалов в заявках */
                             //$ret = 3;
                             //break 2;
                         $sql .= $COMA . $sm; $COMA = ';';
                     } else {   //Отменить проведение наряда
                         if (($sm = material_to_user($mysqli, $row0, $row2)) === false) {  // возврат списанных материалов пользователю
                         } else { $sql .= $COMA . $sm; $COMA = ';'; }
                         if (($sm = material_to_doc($mysqli, $row2)) !== '') { // возврат списанных материалов в заявки
                             $sql .= $COMA . $sm; $COMA = ';';
                         }
                     }
                     $sql .= $COMA . "update i_material set"
                         . " count_realiz=count_realiz" . $plus . $row2['count_units']
                         . " , summa_realiz=summa_realiz" . $plus . (($signedd == 1) ? $summa_material : $row2['subtotal'])
                         . " , id_implementer=" . $row0['id_implementer']
                         . " where id=" . $row2['id_material'];

                 }
               } //row2
               if ($signedd == 0) {
                   if (($sm = material_nariad_jurnal_delete($mysqli, $row0) )!== '') {
                       $sql .= $COMA . $sm; $COMA = ';';
                   }
               }
               $sql_nmat->close();
             } //nmat                          //Учет работы
             $sql.= $COMA."update i_razdel2 set"
                                    . " count_r2_realiz=count_r2_realiz".$plus.$row1['count_units']
                                    . " , summa_r2_realiz=summa_r2_realiz".$plus.$row1['subtotal']  
                                    //. " , summa_mat_realiz=summa_mat_realiz".$plus.$summa_mat
                                    . " , id_implementer=".$row0['id_implementer']             
                                    . " where id=".$row1['id_razdeel2'];
             $COMA = ';';
              /*$sql.= $COMA."
UPDATE n_work SET  
-- count_units_razdel2=count_all,
count_units_razdel2_realiz={$row1[count_units]}
-- ,price_razdel2=row1[price]
WHERE id={$row1[id]}          
          ";
              $COMA = ';';*/
          } //row1
          $sql_nwork->close();
         } //nwork
         //--------------------------Изменить подпись наряда
         $sql.= $COMA.'update i_implementer set summa_made=summa_made'.$plus.$row0['summa_work'].' where id="'.$row0['id_implementer'].'"';
         if ($id_user==0) $id_user=$row0['id_user'];
         if ($signedd==1) {
             switch ($sign_level) {
                 case 1:
                     $id_signed='id_signed0';
                     break;
                 case 2:
                     $id_signed='id_signed1';
                     break;
                 case 3:
                 case 4:
                 case 5:    
                     $id_signed='id_signed2';
                     break;
             }
             $id_signed = ", $id_signed=$id_user";
             $sign_status=20;
         } else {  //снять подпись
             $sign_status=9;
             $id_signed = '';
         }
          $sql.= $COMA."update n_nariad set"
              . " signedd_nariad=".$signedd
              . " , status=$sign_status"                //подписан / в работе
              .$id_signed
              //. " ,  id_signed0=null, id_signed1=null, id_signed2=null"
              . " where id=".$id_nariad;


         //============================выполнить транзакцию
          if ($show) {
              echo "<pre>" . print_r(explode(';',$sql), true) . "</pre>";
              echo "<pre> arr_docs:" . print_r($arr_docs, true) . "</pre>";
          }
          if ($exec) {
              if ($show) echo "<p>===================================>>>";
              $ret = Nariad_transaction($mysqli, $sql, $show);
          }
            if($ret === true) {
                if($show) { echo "<pre>Закрытие заявок, затронутых в наряде</pre>";}
                // Закрытие заявок, затронутых в наряде
                $edo = new EDO($mysqli,11,false);  // От администратора
                foreach($arr_docs as $id_doc) {
                    if($show) { echo "<pre>заявка: $id_doc</pre>"; }
                    $doc_date = new Doc_Data($id_doc, $mysqli);
                    if(!($doc_date->row_doc[status] == 10)) {  //  Если не исполнена
                        $doc_date->Get_Data();
                        $docz = new DocZ($doc_date->row_doc);
                        $docz->analyze();
                        if ($show) { echo "<pre> docz status_all=" . print_r($docz->status_all, true) . "</pre>"; }

                        if ($docz->status_all[0]==1) {
                            // Закрыть задание по заявке
                            $arr_document = $edo->my_documents(0, $id_doc );
                            if ($show) { echo "<pre> arr_document:" . print_r($arr_document, true) . "</pre>"; }
                            foreach($arr_document as $document) {
                                if (isset($document[state])) {
                                    foreach ($document[state] as $task) {
                                        if ($show) { echo "<pre> task:" . print_r($task, true) . "</pre>"; }
                                        if (($id_task=$edo->set_status($task[id_s], 2, 'Автоматическое закрытие'))===false) {
                                            $ret=false;
                                            if ($show) { echo "<pre> ERROR: {$edo->error} {$edo->error_name}</pre>"; }
                                            break 2;
                                        } else if ($show) { echo "<pre> ЗАКРЫТА id_task: $id_task </pre>";}
                                    }
                                    $edo->next($id_doc, 0);
                                    //разослать уведомления, если есть новые задачи

                                    if(isset($edo->arr_task)) {
                                        foreach ($edo->arr_task as $id_task => $value) {
                                            //оправляем всем уведомления кому нужно рассмотреть этот документ далее
                                            $user_send_new = array();
                                            //array_push($user_send_new, $value[id_executor]);
                                            //$user_send_new = array_unique($user_send_new);
                                            $user_send_new[] = $value[id_executor];
                                            $text_note = 'Вам поступила задача по заявке: <a class="link-history" href="app/' . $value[id_document] . '/">' . $value[name].' - '. $value[name_items]. '</a>';
                                            //отправка уведомления

                                            notification_send($text_note, $user_send_new, $id_user, $mysqli);
                                        }
                                    }

                                    // записать статус заявке 10 - исполнено
                                    if (iDelUpd($mysqli,"UPDATE z_doc SET status = 10 WHERE id = $id_doc",false)===false) {
                                        // ошибка изменния статуса заявки
                                        $ret = false;
                                        break;
                                    }

                                }

                            }
                        }
                    }
                }
            }
     } //row0
     $sql_nariad->close();
    } //nariad
    return $ret;
}      
/*
function Nariad_Stop(&$mysqli) {     
         $mysqli->autocommit(TRUE);
         $mysqli->close();
    }
*/

/**  Выполнить sql-запросы по массиву
 * @param $mysqli
 * @param $sql
 * @param false $show - только выводит на экран, не выполняет
 * @return false
 */
function Nariad_transactionA(&$mysqli,&$sql,$show=false) {
  $ret=false;
  $arr=explode(';',$sql);

  for ($i=0; $i<count($arr); $i++) {
      if($show) echo "<p/> $i=".$arr[$i];
      if (($ret=$mysqli->query(trim($arr[$i])))!==true) {
             $ret=$mysqli->errno;
             if($show) echo "<p/>query$i=".$mysqli->errno;
             break;
      }       
  } 
  return $ret;
}    
function Nariad_transaction(&$mysqli,&$sql,$show=false) {  
    $ret=false;
    do {
            /* Откл. автофиксацию изменений */
        if($show) echo "<p>step 00__";
        $mysqli->autocommit(FALSE);
       
        if($show) echo "<p>step 01";
        if (($ret=Nariad_transactionA(&$mysqli,&$sql,$show))!==true) {
             rollback_ (&$mysqli,$show,98);
             break; 
        }
         
        if($show) echo "<p>step 02"; 
        if (!$mysqli->commit()) {
             $ret = rollback_ (&$mysqli,$show,99);
             break;
        }
        if($show) echo "<p>step 03=$ret"; 
    } while (1==0); 
    $mysqli->autocommit(TRUE);    
    return $ret;
} 
function rollback_ (&$mysqli,$show,$step) {
    if($show) echo "<p/> result:$step mysqli=".$mysqli->errno;
    $ret=$mysqli->errno;
    $mysqli->rollback();
    return $ret;    
} 

define ('PNG','../images/tree_S/hie/');
// $hie = new hierarchy(&$mysqli,$id_user);
// if ($hie->id_user==0) {/*disable*/}
class hierarchy {
     
 var  $mysqli;
 var  $obj=array();
 var  $user=array();
 var  $sign_level;
 var  $admin=0;
 var  $show;
 var  $id_kvartal=array();
 var  $id_town=array();
 var  $codec;
 var  $num=array();
 var  $id_user=0;
 var  $boss=array(2=>array(),3=>array(),4=>array() );  //Подчинение
 var  $email;
 
 function hierarchy(&$mysqli,$id_user,$show=0) {
   $this->mysqli=$mysqli;
   $this->codec = new codec();    //("UTF-8","windows-1251")
   $this->show=$show;
   
   $this->arr_add(&$this->user,$id_user); 
   //$this->user[]=$id_user;
   if ($result = $this->mysqli->query('
    SELECT u.id,u.name_user,u.email_notifications,u.email,r.name_role,r.sign_level,r.system
    FROM r_user u, r_role r
    WHERE u.id="'.$id_user 
    .'" AND u.id_role=r.id
    AND u.enabled=1 AND r.enabled=1'
    )){ 
       $this->id_user=$id_user;
       $tab=0;
       //$this->num[]=$result->num_rows;
       while( $row = $result->fetch_assoc() ){
           $this->sign_level=$row['sign_level'];
           $this->admin=$row['system'];
           $this->user_info($row,$tab);
           $this->user_object($row,$tab);
           //$this->num[(count($this->num)-1)]--;
           $this->user_level(($row['sign_level'])-1,$tab+1);
           $this->user_town();
           $this->email = ($row['email_notifications']==1) ? $row['email'] : '';
           
       }
       //unset( $this->num[(count($this->num)-1)] );
       //$this->num=array_values($this->num);
       $result->close();
       $this->get_boss();
    }
 }

 function is_email_notifications() {
     return ($this->email=='') ? false : $this->email;
 }
 
function arr_add(&$arr,$id) {
    for ($i=0;$i<count($arr);$i++) {
        if($arr[$i]==$id)break;
    }
    if ($i==count($arr))$arr[]=$id;
}

 function tabul($tab) {
     $ret='';
     while ($tab>0) {
         $ret.='<td>';
         $tab--;
     }
     return $ret;
 } 
 function tree($main=false) {
    $str='';
    if (count($this->num)>0) { 
     $h3='<img src="'.PNG.'h03.png">'; 
     $h4='<img src="'.PNG.'h04.png">';
     $h5='<img src="'.PNG.'h05.png">';
     $h6='<img src="'.PNG.'h06.png">';
     
     for($i=0;$i<(count($this->num));$i++) {
       if($i==count($this->num)-1) {
           if ($main) { $hh3=$h3;$hh4=$h4; }
           else       { $hh3=$h5;$hh4=$h6; }
            if($this->num[$i]>0) {
                   $str.=$hh4.$hh3;  
            } else $str.=$h5.$h5;
           
       } else {   
            if($this->num[$i]>0) {
                   $str.=$h6.$h5;  
            } else $str.=$h5.$h5;
       }
     }
     if ($main) $this->num[(count($this->num)-1)]--;
    } 
    return $str;
     
 }
 function arr() {   //Вывод массива
     $str='';
     for($i=0;$i<count($this->num);$i++) {
         $str.='+'.$this->num[$i];
     }
     echo '<a/>'.$str;
 }
 function user_info(&$row,$tab){
   if($this->show)  { 
    /*   
    echo "<tr><td>".$row['sign_level']."<td>".$this->tabul($tab)
            .$this->codec->iconv($row['name_user'])
            ."<td>"
            .$this->codec->iconv($row['name_role']);
     */
    //$this->arr();  
      
    echo '<li>'.$this->tree(true)
            .'<div class="level"><img src="'.PNG.'h01.png">'
            .'<span>'.$row['sign_level'].'</span>'
            .'</div>'
        
               .'<a style="font-weight: bold;">'.'  '.$this->codec->iconv($row['name_user']).'</a></li>'
        .'<li>'.$this->tree() 
               .'<img src="'.PNG.'h04.png">'.'<img src="'.PNG.'h03.png">'.'<img src="'.PNG.'h02w.png">'  
               .'<a style="font-style:italic;">'.$this->codec->iconv($row['name_role']).'</a>'
               ."</li>";
   }
 }
 function user_object(&$row,$tab) {
   //--------------------вывод объектов пользователя
    $sql='
            SELECT * FROM r_user_object uo, i_object o 
            WHERE uo.id_user='.$row['id'].' AND uo.enabled=1 AND uo.id_object=o.id AND o.enable=1';  
    //echo "<p>sql=$sql";   
    if ($result = $this->mysqli->query($sql)) {
                $tre=$this->tree();
                while( $row01 = $result->fetch_assoc() ){
                  if($this->show) {  
                    //echo '<p/>'.$this->codec->iconv($row01['object_name']);  
                    echo '<li>'.$tre.'<img src="'.PNG.'h04.png">'.'<img src="'.PNG.'h03.png">'.'<img src="'.PNG.'h02.png">'  
                               .'<a style="font-size: 80%;">'.$this->codec->iconv($row01['object_name'])."</a></li>";
                  }
                  $this->arr_add(&$this->obj,$row01['id_object']);
                  $this->object_owner($row01['id_object']);
                } 
                $result->close(); 
    }
    //echo "<p>obj=$obj";
    //return $obj;   
 }
 /*
  * Поиск дополнительных смет (себестоимостей)
  */
 function object_owner($id_object) {
     $sql="
            SELECT * FROM i_object o 
            WHERE o.id_object_owner = $id_object AND o.enable=1";
     if ($result = $this->mysqli->query($sql)) {
         $tre=$this->tree();
         while( $row01 = $result->fetch_assoc() ){
             if($this->show) {
                 //echo '<p/>'.$this->codec->iconv($row01['object_name']);
                 echo '<li>'.$tre.'<img src="'.PNG.'h04.png">'.'<img src="'.PNG.'h03.png">'.'<img src="'.PNG.'h02.png">'
                     .'<a style="font-size: 80%;">'.$this->codec->iconv($row01['object_name'])."</a></li>";
             }
             $this->arr_add(&$this->obj,$row01['id']);
             $this->object_owner($row01['id']);               //Вызов по Рекурсии
         }
         $result->close();
     }
 }


 function user_level($sign_level,$tab) {
  if ($sign_level>0) {  
      $obj= implode(',', $this->obj);
      //echo "<p>obj=$obj";
      $sql='
SELECT DISTINCT u.id,u.name_user,r.name_role,r.sign_level
-- , uo.id_object, o.object_name  
FROM r_user u, r_role r, r_user_object uo
-- , i_object o 
WHERE u.id_role=r.id
AND r.system=0 AND u.enabled=1 AND r.enabled=1
AND r.sign_level='.$sign_level
.' AND u.id=uo.id_user
-- AND uo.id_object=o.id
AND uo.id_object IN ('.$obj.')
ORDER BY u.name_user';
       //echo "<p>sql=$sql";   
      if ($result = $this->mysqli->query($sql)){
        $this->num[]=$result->num_rows; 
        while( $row = $result->fetch_assoc() ){
           $this->arr_add(&$this->user,$row['id']); 
           $this->user_info (&$row,$tab);
           $this->user_object(&$row,$tab);
           //$this->num[(count($this->num)-1)]--;
           $this->user_level(($row['sign_level'])-1,$tab+1); 
           
        }   
        //echo "<p>user=". implode(',', $this->user).' level='.$tab;
        unset( $this->num[(count($this->num)-1)] );
        $this->num=array_values($this->num);
        $result->close();  
       
      }
  }   
 }
  function get_boss() {
      $obj=$this->obj;
      for($i=$this->sign_level+1; $i<=4; $i++) {
          if ($i==4) $system='';
          else $system='AND r.system=0';
          $sql='
SELECT DISTINCT u.id,u.name_user,r.name_role,r.sign_level
FROM r_user u, r_role r, r_user_object uo
WHERE u.id_role=r.id
'.$system.' 
AND u.enabled=1 AND r.enabled=1
AND r.sign_level="'.$i.'" 
AND u.id=uo.id_user
AND uo.id_object IN ('.implode(',', $obj).')
ORDER BY u.name_user';
            if ($result = $this->mysqli->query($sql)) {
                while( $row = $result->fetch_assoc() ){
                    $this->arr_add(&$this->boss[$i],$row['id']);
                    $this->boss_object($row['id'],&$obj);
                }
                $result->close();  
            }
      }
  }
   function boss_object($id_user,&$obj) {
   //--------------------вывод объектов пользователя
    $sql='
            SELECT * FROM r_user_object uo, i_object o 
            WHERE uo.id_user='.$id_user.' AND uo.id_object=o.id AND o.enable=1';  
    if ($result = $this->mysqli->query($sql)) {
                while( $row01 = $result->fetch_assoc() ){
                    $this->arr_add(&$obj,$row01['id_object']);
                } 
                $result->close(); 
    }
 }
 
  function user_town() {
   //--------------------получение кварталов и городов разрешенных объектов
  if (count($this->obj)>0) {
     $sql='
    select DISTINCT k.id,k.kvartal from i_object o, i_kvartal k
    where o.id in ('.implode(',', $this->obj).')
    AND o.id_kvartal=k.id';  
     //echo "<p>sql=$sql";   
     if ($result = $this->mysqli->query($sql)) {
         while( $row = $result->fetch_assoc() ){
          $this->id_kvartal[]=$row['id'];   
         }
         $result->close();  
     }
     if (count($this->id_kvartal)>0) {
     $sql='
        SELECT DISTINCT t.id,t.town FROM i_kvartal k, i_town t
        WHERE k.id IN ('.implode(',', $this->id_kvartal).')
        AND k.id_town=t.id';  
     //echo "<p>sql=$sql";   
     if ($result = $this->mysqli->query($sql)) {
         while( $row = $result->fetch_assoc() ){
          $this->id_town[]=$row['id'];   
         }
         $result->close();  
     }
    } 
   }
  }
 } //class   

// Получить массив доступа к разделам сметы всех объектов по пользователю
class User_Object_Razdel{
    private $IDS;

    public function User_Object_Razdel(&$mysqli,$id_user)
    {
        $this->IDS = array();
        $sql="
SELECT  o.id_object,r.id_razdel
FROM 
    r_user_object_razdel r,
    r_user_object o
WHERE r.id_user='$id_user'
    AND r.id_user_object = o.id
    AND r.enabled=TRUE
ORDER BY o.id_object,r.id_razdel";
        if ($result = $mysqli->query($sql)){
            while( $row = $result->fetch_assoc() ){
                $this->IDS[$row['id_object']][$row['id_razdel']] = $row['id_razdel'];
            }
        }
        $result->close();
    }
    public function is_uses($id_object,$id_razdel) {
        if (isset($this->IDS[$id_object])) { //есть ограничение на работу с разделами
            if (isset($this->IDS[$id_object][$id_razdel])) {
                return true;
            } else return false;
        } else return true;
    }
    public function select($id_object) {
        if (isset($this->IDS[$id_object])) {
            return ' and a.id in ('.implode (',',$this->IDS[$id_object]).')';
        } else return '';
    }
}
//пОЛУЧИТЬ ответственного за склад (id_system=1) по обьъекту 
class stock_user {
var $id_stock;    
  function stock_user(&$mysqli,$id_object,$show=0) {
$sql='      
SELECT u.id,u.name_user,r.name_role,r.sign_level,uo.id_object
FROM r_user u, r_role r, r_user_object uo
WHERE r.id_system=1
AND u.id_role=r.id
AND u.enabled=1 AND r.enabled=1
AND u.id=uo.id_user
AND uo.id_object IN ("'.$id_object.'")
ORDER BY u.name_user
        ';
if ($show) echo "<p>sql=$sql";
    if ($result = $mysqli->query($sql)) {
        while( $row = $result->fetch_assoc() ){
          $this->id_stock=$row['id'];   
        }
        $result->close();  
    }
  }               
} 

/*  поиск пользователей имеющих доступ к объекту,модулю и правам на модуль 
 *   http://compass.kkbox.com/
 
 $FUSER=new find_user(&$mysqli,44,'S','Модуль','fix_name_role' );
 $FUSER=new find_user(&$mysqli,'44,36','S','Заявки','plan' );
 for ($i=0;$i<count($FUSER->id_user);$i++) {
   SendMessage($FUSER->id_user[$i]);
 }
  
если поступила заявка: Снабжение
$FUSER=new find_user(&$mysqli,'44','R','','supply' );
если надо согласовать заявку: Инженер ПТО
$FUSER=new find_user(&$mysqli,'44,36','S','Заявки','plan' );   // 44,36 - несколько объектов - необязательно
ответ на согласование или отказ - $id_user создателя заявки
снабжение подготовило счет:
hierarchy->boss[3], hierarchy->boss[4] 
Счет согласован - на оплату:
$FUSER=new find_user(&$mysqli,'*','U','','buh' ); // * - любые объекты
Сообщение для приема товара по накладным при оплаченном счете
$FUSER=new find_user(&$mysqli,'*','R','Накладные','control' ); // * - любые объекты
произведен прием товара и произведена разноска материала по заявке - $id_user создателя заявки

*/

class find_user {
var $id_user=array();
var $mysqli;
    function find_user(&$mysqli,$id_object,$permission, $modul, $proff='', $show=false) {
        $this->mysqli=$mysqli; 
if ($id_object=='*') { $obj=''; }
else { $obj="o.id_object in($id_object) and"; }

if ($modul=='') $mdl='';
else            $mdl="and a.alias='$modul'";
if ($proff=='') $prf='';
else            $prf="and r.role='$proff'";
$sql="
select * from r_user_object o, r_user u,r_role r, r_role_modul m, r_alias_table a
where 
$obj 
o.enabled=1
and o.id_user=u.id
and u.enabled=1
and u.id_role=r.id
and r.enabled=1
and r.id=m.id_role
and m.permission like '%$permission%'
and m.id_alias_table=a.id
$mdl
$prf    
group by u.id  
ORDER BY u.name_user
"; 
        if ($show) echo "<p>sql=$sql";
        if ($result = $mysqli->query($sql)) {
            $i=0;
            while( $row = $result->fetch_assoc() ){
              $this->id_user[]=$row['id_user']; 
              $i++;
              if ($show) echo "<p/>$i id=".$row['id_user'];
            }
            $result->close();  
        } else {
            if ($show) echo "<p/>(".$mysqli->errno.')';
        }         
    }
}

class kvartal_users {
    var $users=array();
    var $ids_kvartal=array();
    var $mysqli;
    var $show;

    function kvartal_users(&$mysqli,$show=false) {
        $this->mysqli=$mysqli;
        $this->show = $show;
    }

    /** Принадлежность пользователя к кварталам
     * @param $id_user
     * @return array
     */

    function get_kvartals($id_user) {
        $sql = "
SELECT id_kvartal from `r_user_object` 
WHERE id_user='$id_user'
GROUP by id_kvartal
        ";
        if ($this->show) echo "<p>sql=$sql";
        if ($result = $this->mysqli->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $this->ids_kvartal[] = $row['id_kvartal'];
            }
        }
        return $this->ids_kvartal;
    }

    /** Доступ пользователей к кварталам
     * @param array $kvartals
     * @param null $material_stock
     * @return array
     */
    function get_users(array &$kvartals, $material_stock=null) {
        $mats = (is_null($material_stock))? '' : "AND u.`material_stock` = '$material_stock'";
        $sql = "
SELECT o.id_user,u.`name_user` FROM `r_user_object` o, `r_user` u 
WHERE o.id_kvartal IN (".implode(',',$kvartals).")
AND o.id_user=u.`id`
$mats
GROUP BY o.id_user 
ORDER BY u.`name_user`       
        ";
        if ($this->show) echo "<p>sql=$sql";
        if ($result = $this->mysqli->query($sql)) {
            $i=0;
            while ($row = $result->fetch_assoc()) {
                $this->users[][id_user]  =  $row['id_user'];
                $this->users[$i][name_user]  =  $row['name_user'];
                $i++;
            }
        }
        return $this->users;
    }
}


// $hie = new hierarchy(&$mysqli,$id_user);
// if ($hie->id_user==0) {/*disable*/}
//$NUser = new notification_user (&$hie);  //$hierarchy

class notification_user {
   var $id=array();
    function notification_user (&$hie) { // $id_object,$permission, $modul, $proff='', $show=0) {
      if ($hie->id_user>0) {  
        if ($hie->sign_level>0 && $hie->sign_level<4) {  //Нужно послать начальнику sign+1
           $this->id=$hie->boss[$hie->sign_level+1];  //array
        } else if ($hie->sign_level==0) {
            $EngUser=new find_user(&$hie->mysqli,"'".implode(',',$hie->obj)."'",'R','','engineer',true );
            $this->id=$EngUser->id_user;	//array
        } 
      }
    }
}

class codec {
var $ch0;
var $ch1;
function codec($charset_from=0,$charset_to=0) {
    $this->ch0=$charset_from;
    $this->ch1=$charset_to;
           
}    
function iconv($str){
    if ($this->ch0==$this->ch1) return $str;
    //return iconv("UTF-8","windows-1251", $str);
    else    return iconv($this->ch0,$this->ch1, $str);
}


}

