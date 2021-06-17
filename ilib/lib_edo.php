<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/Isql.php';

//==============example
//$mysqli
//$id_user
//$id_doc
//$type

/*$edo = new EDO($mysqli,$id_user);
if ($edo->next($id_doc, $type)===false) {
   if ($edo->error == 1) {
       // в array $edo->arr_task задания на согласование
   } else {
     echo '<pre>'.$edo->error_name[$edo->error].'</pre>';
   }
} else {
    // процесс согласования со всеми заданиями выполнен
}*/

// Электронный документооборот
class EDO
{
    var $mysqli;
    var $id_user;
    var $arr_table; // название таблиц
    var $arr_run;    //Массив шаблона
    var $arr_rule;   //Короткий массив правил
    var $arr_state;  //Массив выполнения
    var $arr_task;   //Массив задания
    var $error;
    var $error_name;
    var $arr_sql;
    var $func;
    var $show;

    public function EDO($mysqli, $id_user, $show=false)
    {
        $this->mysqli = $mysqli;
        $this->id_user = $id_user;
        $this->arr_table = array('z_doc', 'z_acc', 'n_nariad'); // связан с id edo_name_process
        $this->error_name = array(
            'завершен' //0
            ,'ок' //1    - в массиве arr_task задания на выполнение согласования

            ,'не удалось получить документ по переданному id' //2
            ,'нет записи в z_doc_material_acc' //3
            ,'нет записи об объекте с переданным id' //4
            ,'нет такого описания объекта' //5
            ,'нет описания шаблона процесса, связанного с кварталом' //6
            ,'нет шаблона с таким id' //7
            ,'нет процессов в выбранном шаблоне' //8
            ,'ошибка копирования процеса шаблона' //9
            ,'ошибка сохранения id скопированного шаблона' //10
            ,'нет правил в последовательности процессов шаблона' //11
            ,'не определен элемент правил выполнения процесса' //12
            ,'ошибка записи в edo_run_item_after' //13
            ,'не определены правила согласования для документа' //14
            ,'Нет запущенных процессов' //15 - первый запуск
            ,'отказ по согласованию' //16
            ,'ожидание согласования' //17
            ,'ошибка записи процесса согласования' //18

        );
        $this->arr_sql = array();
        $this->func = array();
        $this->show = $show;
    }

    // произвести следующее действие над документом или получить его текущий статус
    public function next ( $id, $type, $id_edo_run=null ) {
        $ret = false;
        do {
            if ($id_edo_run == null) {
                if(($id_edo_run = $this->get_id_run($id, $type))===false) break; // получить id_edo_run из документа
            }
            if (!($id_edo_run>0) and count($this->arr_state)==0) { //нет записей процесса - это первый запуск
                if (($id_edo_run = $this->make($id, $type))===false) break;

            }
            $this->arr_state = $this->get_state($id_edo_run);
            // нужно по текущему состоянию $arr_state иcпользуя edo_run сгенерить новые согласования
            return $this->rule($id_edo_run);

        } while (1==0);
        return $ret;
    }

    /**  получить id_edo_run   ???
     * @param $id
     * @param $type
     * @return false|mixed
     */
    private function get_id_run($id, $type){
        $ret = false;
        $sql = "select id_edo_run from ".$this->arr_table[$type]." where id=$id";
        $this->Debug($sql,__FUNCTION__);
        if ($result = $this->mysqli->query($sql)) {
            if ($row = $result->fetch_assoc()) {
                $ret = $row[id_edo_run];
            }
            $result->close();
        } else $this->error = 2;  // не удалось получить документ по переданному id
        return $ret;
    }

    /** получить массив данных по процессу согласования
     * @param $id_edo_run
     * @return array - count==0 нет ничего
     */
    private function get_state($id_edo_run){
        $arr_state = array();
        $sql = "select * from edo_state where id_run=$id_edo_run order by displayOrder";
        $this->Debug($sql,__FUNCTION__);
        if ($result = $this->mysqli->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $arr_state[] = $row;
            }
            $result->close();
        }
        return $arr_state;
    }

    /** Создать копию шаблона процесса и прописать его в документе НОВЫЙ ПРОЦЕСС
     * @param $id id документа из таблиц type
     * @param $type 0-z_doc,1-z_acc,2-n_nariad
     * @return bool false или id_run (то что прописано)
     */

    public function make ( $id, $type) {
        $ret = false;
        $table = $this->arr_table[$type];
        $id_name = $type+1;
        do {
            if ($type == 1) {
                if (($id_doc = $this->get_doc($id)) === false) break;   // Ссылка на заявку из счета
                if (($id_kvartal = $this->get_kvartal($id_doc, $this->arr_table[0])) === false) break;
            } else {
                if (($id_kvartal = $this->get_kvartal($id, $table)) === false) break;
            }
            // получить шаблон
            if (($id_shablon = $this->get_shablon($id_name, $id_kvartal)) === false) break;
            //копировать шаблон
            if(($id_run = $this->copy_shablon($id_shablon, $id, $table)) === false ) break;
            if($this->show) echo '<pre>save_id_run'."($id, $id_run, $table)".'</pre>';
            return $this->save_id_run($id, $id_run, $table);

        } while (1==0);
        return $ret;
    }

    /** получить id_doc из z_doc_material_acc
     * @param $id_acc
     * @return false|mixed
     */
    private function get_doc($id_acc) {
        $ret = false;
        $sql = "select id,id_doc,id_acc from z_doc_material_acc where id_acc=$id_acc";
        $this->Debug($sql,__FUNCTION__);
        if ($result = $this->mysqli->query($sql)) {
            if ($row = $result->fetch_assoc()) {
                $ret = $row['id_doc'];
            }
            $result->close();
        } else $this->error = 3; // нет записи в z_doc_material_acc
        return $ret;
    }

    /** Получить по id документа id_kvartal (только для z_doc и n_nariad)
     * @param $id
     * @param $table
     * @return false|mixed
     */
    private function get_kvartal($id, $table) {
        $ret = false;
        $sql = "select id,id_object from $table where id=$id";
        $this->Debug($sql,__FUNCTION__);
        if ($result = $this->mysqli->query($sql)) {
            if ($row = $result->fetch_assoc()) {
                $id_object = $row[id_object];
                $sql = "select id,id_kvartal from i_object where id=$id_object";
                $this->Debug($sql,__FUNCTION__);
                if ($result2 = $this->mysqli->query($sql)) {
                    if ($row2 = $result2->fetch_assoc()) {
                        $ret = $row2[id_kvartal];
                    }
                    $result2->close();
                } else $this->error = 5; // нет такого описания объекта
            }
            $result->close();
        } else $this->error = 4; // нет записи об объекте с переданным id
        return $ret;
    }

    /** Получить шаблон
     * @param $id_name
     * @param $id_kvartal
     * @return false|mixed
     */
    private function get_shablon($id_name, $id_kvartal) {
        $ret = false;
        $sql = "select * from edo_setup where id_name_process=$id_name and id_kvartal = $id_kvartal";
        $this->Debug($sql,__FUNCTION__);
        if ($result = $this->mysqli->query($sql)) {
            if ($row = $result->fetch_assoc()) {
                $ret = $row['id_shablon'];
            }
            $result->close();
        } else $this->error = 6; // Нет описания шаблона процесса, связанного с кварталом
        return $ret;
    }

    /** Копировать шаблон на исполнение, три таблицы
     * @param $id_shablon
     * @param $id_doc
     * @param $table
     * @return bool
     */
    private function copy_shablon($id_shablon, $id_doc, $table) {
        $ret = false;
        if (($data = $this->get_array_after($id_shablon))===false) return $ret;


        $sql = "select * from edo_shablon where id=$id_shablon";
        $this->Debug($sql,__FUNCTION__);
        if ($result = $this->mysqli->query($sql)) {
            if ($row = $result->fetch_assoc()) {
                // запись
                $sqlInsert =
                    "INSERT INTO edo_run (
`name`,
`id_document`,
`table_name`,
`id_user`,
--  `date_ready`,
--  `timing`,
`id_shablon`
)
VALUES
(
'$row[name]',
$id_doc,
'$table',
$this->id_user,
--    'date_ready',
--    'timing',
$id_shablon
)";
                //$this->Debug($sqlInsert,__FUNCTION__);
                if (($id_run = iInsert_1R($this->mysqli,$sqlInsert,true)) > 0) { //Это новый id_shablon
                    //копировать содержание шаблона
                    $sqlItem = "select * from edo_shablon_items where id_shablon=$id_shablon order by displayOrder";
                    $this->Debug($sqlItem,__FUNCTION__);

                    if ($result2 = $this->mysqli->query($sqlItem)) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $sqlInsertItem =
                                "INSERT INTO edo_run_items (
`id_run`,
`name_items`,
`displayOrder`,
`id_action`,
`description`,
`timing`,
`id_executor`,
`id_checking`,
`id_controller`,
`start_at_once`,
`start_after_any`
)
VALUES
(
    $id_run,
    '$row2[name_items]',
    $row2[displayOrder],
    $row2[id_action],
    '$row2[description]',
    $row2[timing],
    $row2[id_executor],
    $row2[id_checking],
    $row2[id_controller],
    $row2[start_at_once],
    $row2[start_after_any]
)";
                            //$this->Debug($sqlInsertItem,__FUNCTION__);

                            if (($id_run_item = iInsert_1R($this->mysqli,$sqlInsertItem,true)) == 0) {
                                $this->error = 9; //Ошибка копирования процеса шаблона
                                break;
                            }
                            $this->new_id($row2[id], $id_run_item,&$data);  //Добавить новые связи

                        }

                        if($this->copy_after($data, $id_run)>0)
                            $ret=$id_run;  // Нормальное завершение
                        $result2->close();
                    } else $this->error = 8; // Нет процессов в выбранном шаблоне

                }
            }
            $result->close();
        } else $this->error = 7;  //нет шаблона с таким id
        return $ret;
    }



    /** Получить массив правил по шаблону
     * @param $id_shablon
     * @return array|false
     */
    private function get_array_after($id_shablon) {
        $ret = false;
        $data = array();
        $sql = "select * from edo_shablon_item_after where id_shablon=$id_shablon order by id_shablon_item";
        $this->Debug($sql,__FUNCTION__);
        if ($result = $this->mysqli->query($sql)) {
            $i=0;
            while ($row = $result->fetch_assoc()) {
                //if($this->show) echo '<pre>row:'.print_r($row,true) .'</pre>';
                $data[$i] = $row;

                //$data[$row[displayOrder]][$row[id_shablon_item]] = $row[id_shablon_item];
                //$data[$row[displayOrder]][$row[id_shablon_item_after]] = $row[id_shablon_item_after];
                //$data[$row[displayOrder]]['after_and'] = $row[after_and];
                $i++;
            }
            $result->close();
            return $data;
        } else $this->error = 11; // Нет правил в последовательности процессов шаблона
        return $ret;
    }

    /**  Найти соответствие нового ид и добавить
     * @param $id_shablon_item
     * @param $id_run_item
     * @param $data
     */
    private function new_id($id_shablon_item, $id_run_item, &$data) {
        foreach ($data as $key => $item ) {
            if ($item[id_shablon_item]==$id_shablon_item) {
                $data[$key][id_shablon_item_new] = $id_run_item;
            }
            if ($item[id_shablon_item_after]==$id_shablon_item) {
                $data[$key][id_shablon_item_after_new] = $id_run_item;
            }
            if ($item[id_shablon_item_after]==0) {
                $data[$key][id_shablon_item_after_new] = 0;
            }
        }
    }

    /** записать правила для исполнения с новыми id
     * @param $data
     * @param $id_run
     * @return bool|int
     */
    private function copy_after(&$data, $id_run) {
        $ret = 0;
        foreach ($data as $key => $item ) {

            if (isset($item[id_shablon_item_new]) and  isset($item[id_shablon_item_after_new])) {
                $sql =
                    "insert into edo_run_item_after (
  `id_run`,
  `id_run_item`,
  `id_run_item_after`,
  `after_and`,
  `displayOrder`
)
values
  (
    $id_run,
    $item[id_shablon_item_new],
    $item[id_shablon_item_after_new],
    $item[after_and],
    $key
  )";
                //$this->Debug($sql,__FUNCTION__);

                if (($ret = iInsert_1R($this->mysqli,$sql,false)) == 0) { $this->error = 13; break; } // ошибка записи в edo_run_item_after
            } else { $this->error = 12; break;}   // не определен элемент правил выполнения процесса
        }
        return $ret;
    }

    /** сохранить id копии процесса
     * @param $id
     * @param $id_run
     * @param $table
     * @return bool
     */
    private function save_id_run($id, $id_run, $table) {
        $sql = "update $table set id_edo_run = $id_run where id=$id";
        $this->Debug($sql,__FUNCTION__);

        if (iDelUpd($this->mysqli,$sql,false)===false) {
            $this->error = 10;  // Ошибка сохранения id скопированного шаблона
            return false;
        }
        return $id_run;
    }

// Проверка выполнения правил
    public function rule($id_edo_run)
    {
        //$ok = false;
        $this->arr_run = $this->get_run($id_edo_run);

        if (count($this->arr_run) == 0) { // Нет правил
            // копировать правила !!!
            $this->error = 14; // нет определены правила согласования для документа

        } elseif (count($this->arr_state) == 0) {
            // создать первые процесс----------------------------------------------все с $id_run_item_after=0
            foreach ($this->arr_run as $item) {
                if ($item[id_run_item_after] > 0) continue;
                if ($this->write_state_row($item) === false) break;
                //$this->error = 15; // Нет запущенных процессов
                $this->error = 1;
            }


        } else {
            $ok = true; // общее состояние согласования
            $this->error = 0;   // Ошибка по обходу
            $this->run2rule();
            if($this->show) {
                echo "<pre>arr_run:" . print_r($this->arr_run, true) . "</pre>";
                echo "<pre>arr_rule:" . print_r($this->arr_rule, true) . "</pre>";
                echo "<pre>arr_state:" . print_r($this->arr_state, true) . "</pre>";
            }
            foreach ($this->arr_rule as $id_run_item => $arr_after) {    //Проверка готовности для следующего задания
                $ok_item = true;
                if($this->show) echo "<pre>Задание = $id_run_item</pre>";
                foreach ($arr_after as $id_run_item_after) {  //Условия для задания
                    if($this->show) echo "<pre>Условие = $id_run_item_after</pre>";
                    if ($id_run_item_after == 0) {    //не надо проверять, должен быть уже запущен
                        $ok_item = false;
                        if($this->show) echo "Не проверять";
                        continue;
                    }
                    if (($row = $this->get_state_row($id_run_item_after)) === false) {
                        $ok_item = false;
                        if($this->show) echo "Не существует";
                        break;
                    }
                    if ($row[id_status] == 0) {
                        $ok_item = false;
                        if($this->show) echo "на согласовании";
                        $this->error(17);
                        break;
                    }
                    if ($row[id_status] == 1) {
                        $ok_item = false;
                        if($this->show) echo "отказ согласования";
                        $this->error = 16;
                        break;
                    }
                }
                if ($ok_item) { // все условия для этого задания одобрены
                    if (($row = $this->get_state_row($id_run_item)) !== false) { //Задание существует
                        switch ($row[id_status]) {   //0-активный 1-отказ 2-согласован 3-согласон с замечаниями
                            case 0: // активное - ждем рассмотрения
                                $ok_item = false;
                                //$ok = false;
                                $this->error(17); //ожидание согласования
                                break;
                            case 1: // отказ - больше не продолжать
                                $ok_item = false;
                                $ok = false;
                                $this->error =16; // Отказ по согласованию
                                break;
                            default: //Согласованно
                                break;
                        }
                        if ($ok == false) break;

                    } else { //----------------------------------нет такого задания - нужно его создать
                        if($this->show) echo "записать новое задание $id_run_item";
                        if ($this->write_rows_run($id_run_item) === false) break;
                        $ok_item = false;
                        $this->error(1);
                        // дойти до конца этого цикла и прекратить (создать другие задания)
                    }
                } else {  //Условия не выполнены
                    continue;
                }
                if($ok===false) break;

            }
        }
        $ok = ($this->error == 0 )?true:false;
        return $ok;
    }



/*
SELECT * FROM `edo_shablon` r
,`edo_shablon_items` i
, `edo_shablon_item_after` a
WHERE
r.`id` = 1 AND
i.`id_shablon` = r.`id` AND
i.`id` = a.`id_shablon_item`
ORDER BY r.`displayOrder`,i.`displayOrder`

SELECT * FROM `edo_run` r
,`edo_run_items` i
, `edo_run_item_after` a
WHERE
r.`id` = 1 AND
i.`id_run` = r.`id` AND
i.`id` = a.`id_run_item`
ORDER BY r.`displayOrder`,i.`displayOrder`
*/

    /** Получить массив правил по ID -> [id_run_item][id_run_item_after] в последовательности выполнения
     * @param $id_edo_run
     * @return array
     */
    private function get_run($id_edo_run){
        $arr_run = array();
        $sql =
            "
SELECT * FROM `edo_run` r
,`edo_run_items` i
, `edo_run_item_after` a
WHERE
r.`id` = $id_edo_run AND
r.`id` = i.`id_run`  AND
i.`id` = a.`id_run_item`
ORDER BY r.`displayOrder`,i.`displayOrder` 
";
        $this->Debug($sql,__FUNCTION__);

        if ($result = $this->mysqli->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $arr_run[] = $row;
                //$arr_run[$row['id_run_item']] = $row;
                //$arr_run[$row['id_run_item']][] = $row['id_run_item_after'];
            }
            $result->close();
        } else {  //Нет запущенных правил

        }
        return $arr_run;
    }

    /** поиск по массиву записи и ее запись в state
     * @param $id_run_item
     * @return bool
     */
    private function write_rows_run($id_run_item){
        $res = false;

        foreach($this->arr_run as $item) {
            if ($item[id_run_item]==$id_run_item) {
                //if(($res = $this->write_state_row($item))===false) break;
                $res = $this->write_state_row($item);    //ТОлько одна запись
                break;
            }
        }
        return $res;
    }

    /** Выбрать искомую строку в массиве состояния
     * @param $id_run_item_after
     * @param $arr_state
     * @return false|mixed
     */
    private function get_state_row($id_run_item_after) {
        foreach ($this->arr_state as $row) {
            if ($id_run_item_after == $row[id_run_item]) {
                return $row;
            }
        }
        return false;
    }

    /** Записать задание на согласование
     * @param $id_run_item
     * @return bool
     */
    private function write_state_row($row) {
        $ret = false;
        $sql ="
INSERT INTO `atsunru_interstroi`.`edo_state` (
  `id_run`,
  `id_run_item`,
  `name`,
  `descriptor`,
  `id_executor`,
  -- `sign_executor`,
  `id_checking`,
  -- `sign_checking`,
  `id_controller`,
  -- `sign_controller`,
 -- `date_ready`,
  -- `sign_owner`,
  `timing`,
  `displayOrder`,
  `id_status`
)
VALUES
  (
    '$row[id_run]',
    '$row[id_run_item]',
    '$row[name_items]',
    '$row[description]',
    '$row[id_executor]',
    -- '$row[sign_executor]',
    '$row[id_checking]',
    -- '$row[sign_checking]',
    '$row[id_controller]',
    -- '$row[sign_controller]',
  --  'date_ready',
    -- '$row[sign_owner]',
    '$row[timing]',
    '$row[displayOrder]',
    0
  );        
        ";
        $this->Debug($sql,__FUNCTION__);
        if (($id_state = iInsert_1R($this->mysqli,$sql,false)) > 0) {
            $ret = true;
            $this->arr_task[$id_state] = $row;
        }
        else { $this->error(18); } // ошибка записи процесса согласования
        return $ret;
    }

    /** Сбор последовательности запросов
     * @param $sql
     * @param $name_function
     */
    private function Debug($sql, $name_function) {
        $this->arr_sql[] = $sql;
        $this->func[] = $name_function;
    }

    /** Составление массива правил
     *
     */
    private function run2rule() {
        $this->arr_rule = array();
        foreach ($this->arr_run as $item) {
            $this->arr_rule[$item[id_run_item]][] = $item[id_run_item_after];
        }

    }
    private function error($i) {
       if($this->error == 0)  $this->error = $i;
    }

    /** Мои неисполненные документы id_status =0
     * @param $type = 0,1,2
     * @param null $id_doc - один конкретный документ
     * @return array
     */
    public function my_documents($type,
                                 $id_doc=0,
                                 $order_by = 'ORDER BY date_create DESC',
                                 $limit='LIMIT 0,100')
    {
        $document = ($id_doc==0)?"`id_user`=".$this->id_user : "id=$id_doc";
        $sql =
"
SELECT * FROM ".$this->arr_table[$type]."
WHERE
$document  
$order_by
$limit    
";
        $this->Debug($sql,__FUNCTION__);
        $arr_document = array();
        if ($result = $this->mysqli->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $arr_document[$row[id]] = $row;
                if ($row[id_edo_run]!==null) {
                    $sql =
                        "
SELECT 
s.id AS id_s, s.id_run_item, s.name AS name_s,s.descriptor,  s.`id_executor`, s.id_status,
u.`name_user`
FROM edo_state AS s 
LEFT JOIN r_user AS u ON s.`id_executor` = u.id
WHERE s.id_run=".$row[id_edo_run]."
AND s.id_status=0
$limit            
";
                    $this->Debug($sql,__FUNCTION__);
                    if ($result2 = $this->mysqli->query($sql)) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $arr_document[$row[id]][state][] = $row;
                        }
                        $result2->close();
                    }
                }
            }
            $result->close();
        }
/*"
SELECT 
d.*,
s.id AS id_s, s.id_run_item, s.name AS name_s,s.descriptor,  s.`id_executor`, s.id_status,
u.`name_user`
FROM ".$this->arr_table[$type]." AS d 
LEFT JOIN edo_state AS s ON d.`id_edo_run` = s.`id_run` 
AND s.id_status=0
LEFT JOIN r_user AS u ON s.`id_executor` = u.id
WHERE 
$document
$order_by
$limit            
";
        $this->Debug($sql,__FUNCTION__);
        $arr_document = array();
        if ($result = $this->mysqli->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $arr_document[$row[id]][] = $row;
            }
            $result->close();
        }*/
        return $arr_document;
    }

    /** Задания мне
     * @param $type = 0,1,2
     * @param string $status =0-неисполненные =1-отказанные >1-исполненные
     * @return array
     */
    public function my_tasks($type,
                             $status='=0',
                             $order_by = 'ORDER BY d.date_create DESC',
                             $limit='LIMIT 0,100' )  {
        $sql=
"
SELECT 
d.*,
s.id AS id_s, s.id_run_item, s.name AS name_s,s.descriptor,  s.`id_executor`, s.id_status,
u.`name_user`
FROM ".$this->arr_table[$type]." AS d 
    LEFT JOIN edo_state AS s ON d.`id_edo_run` = s.`id_run` 
        AND s.id_status $status
, r_user AS u
WHERE 
    s.`id_executor`=".$this->id_user." AND d.`id_user` = u.`id`
$order_by
$limit 
";
        $this->Debug($sql,__FUNCTION__);
        $arr_document = array();
        if ($result = $this->mysqli->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $arr_document[] = $row;
            }
            $result->close();
        }
        return $arr_document;
    }
}