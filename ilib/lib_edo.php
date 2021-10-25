<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/Isql.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/task_time.php';
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
    var $type;      // тип таблицы (0-3)
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
        $this->arr_table = array('z_doc', 'z_acc', 'n_nariad','z_dogovor'); // связан с id edo_name_process
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
            ,'ошибка изменния статуса задания' //19
            ,'ошибка изменения статуса' //20
            ,'ошибка перенаправления задания' //21
            ,'создано дополнительное согласование на превышение' //22
            ,'ожидание согласования текущее' //23

        );
        $this->arr_sql = array();
        $this->func = array();
        $this->arr_task = array();
        $this->show = $show;
    }

    // произвести следующее действие над документом или получить его текущий статус

    /**
     * @param $id - id документа из таблицы z_doc, z_acc, n_nariad
     * @param $type 0 1 2 3  соответственно таблицам
     * @param 0 $id_edo_run  Если не указан, береться из документа
     * @param false $restart Перезапуск процесса
     * @return bool
     */
    public function next ( $id, $type, $id_edo_run=0, $restart=false ) {
        $ret = false;
        $this->type = $type;
        do {
            if ($id_edo_run == 0) {
                if(($id_edo_run = $this->get_id_run($id, $type))===false) break; // получить id_edo_run из документа
            }
            if ((!($id_edo_run>0) /*and count($this->arr_state)==0*/) or $restart) { //нет записей процесса - это первый запуск
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
        $sql = "
SELECT A.id,A.id_doc_material,A.id_acc,
M.`id_doc` 
FROM 
z_doc_material_acc A, z_doc_material M
WHERE A.id_acc=$id_acc
AND A.`id_doc_material` = M.`id`
";
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
                        $this->error(17);  // ожидание согласования
                        break;
                    }
                    if ($row[id_status] == 1) {
                        $ok_item = false;
                        if($this->show) echo "отказ согласования";
                        $this->error = 16;
                        break;
                    }
                    if ($row[id_status] > 1) {      //проверить на дополнительное согласование
                        //========================================================================

                        if ($this->show) {
                            echo "<pre>ROW:" . print_r($row, true) . "</pre>";
                            echo "<pre>id_document:" . print_r($this->arr_run[0][id_document], true) . "</pre>";
                        }

                        if ($row[id_checking]>0
                            /*&& $row[sign_checking] == 0*/
                            && $row[id_checking] <> $row[id_executor]     // Это уже контрольное согласование
                            && $this->is_excess($this->arr_run[0][id_document])) {
                            //echo 'STEP I<br>';
                                if (!($new_id = $this->confirmation($row))===false) {
                                    //echo 'STEP II<br>';

                                    $this->error = 22; //создано дополнительное согласование на превышение
                                    break 2;
                                }
                                $ok_item = false;
                                break;
                        }
                        continue;
                    }
                }
                if ($ok_item) { // все условия для этого задания одобрены
                    if (($row = $this->get_state_row($id_run_item)) !== false) { //Задание существует
                        switch ($row[id_status]) {   //0-активный 1-отказ 2-согласован 3-согласон с замечаниями
                            case 0: // активное - ждем рассмотрения
                                $ok_item = false;
                                //$ok = false;
                                $this->error(23); //ожидание согласования
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
                    //break;
                }
                if($ok===false) break;

            }
        }
        $ok = ($this->error == 0 )?true:false;
        return $ok;
    }



    /** Получить массив правил по ID -> [id_run_item][id_run_item_after] в последовательности выполнения
     * @param $id_edo_run
     * @return array
     */
    private function get_run($id_edo_run){
        $arr_run = array();
        $sql =
            "
SELECT *, i.`displayOrder` AS dOrd  FROM `edo_run` r
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
            if ($id_run_item_after == $row[id_run_item] && $row[id_status]>=0) {
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
        //$timeReady = \CCM\TimeReady\srok_vip(date('Y.m.d H:i:s', time()),$row[timing]*60,$this->mysqli);
        $day_now = date('d.m.Y H:i:s', time());
        $timeReady = \CCM\TimeReady\srok_vip($day_now,$row[timing]*60,$this->mysqli);
        if ($timeReady===false) $timeReady = null;

        $sql ="
INSERT INTO `edo_state` (
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
   `date_ready`,
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
    '$timeReady', 
    -- '$row[sign_owner]',
    '$row[timing]',
    '$row[dOrd]',
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
     * @param $status='=0' - только невыполненные задания
     *                '>=0' - все задания
     * @param $only_user = true - задания только для этого пользователя
     * @return array
     */
    public function my_documents($type,
                                 $id_doc=0,
                                 $status_task = '=0',
                                 $only_user = false,
                                 $limit='LIMIT 0,100',
                                 $order_by = 'ORDER BY date_create DESC'
                                 )
    {
        $document = ($id_doc==0)?"`id_user`=".$this->id_user : "id=$id_doc";
        $task_user = ($only_user)?"AND s.`id_executor`=".$this->id_user : '';
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
    s.id AS id_s, s.id_run_item, s.name AS name_task,s.descriptor AS descriptor_task ,  s.`id_executor`, s.id_status, s.comment_executor,
    s.`date_ready`, s.`date_execute`, s.`timing`,
    u.`name_user`,
    ST.`name_status`       
FROM edo_state AS s 
LEFT JOIN r_user AS u ON s.`id_executor` = u.id
LEFT JOIN edo_status AS ST ON s.`id_status` = ST.`id_status`
WHERE s.id_run=".$row[id_edo_run]."
AND s.id_status $status_task
$task_user
ORDER BY s.`displayOrder`,s.`date_create`
$limit            
";
                    $this->Debug($sql,__FUNCTION__);
                    if ($result2 = $this->mysqli->query($sql)) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $arr_document[$row[id]][state][] = $row2;
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
     * @param string $order_by 'ORDER BY d.date_create DESC'
     * @param string $limit 'LIMIT 0,100'
     * @param null $id_action 1,2,3,4,5,6,7,8
     * @return array
     */
    public function my_tasks($type,
                             $status='=0',
                             $order_by = 'ORDER BY d.date_create DESC',
                             $limit='LIMIT 0,100',
                             $id_action = null)  {
        $action = ($id_action == null)? '' : "AND R.`id_action` = $id_action";
        $sql=
/*"
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
";*/
 "
 SELECT
d.*,
T.*,
u.`name_user`
FROM ".$this->arr_table[$type]." AS d
LEFT JOIN 
    (
        SELECT 
        s.id AS id_s, s.id_run, s.id_run_item, s.name AS name_s,s.descriptor, s.`id_executor`, s.id_status,
        R.`id_action`
        ,A.`name_action`
        FROM edo_state s, edo_run_items R, edo_action A 
        WHERE 
        s.`id_executor`=".$this->id_user." 
        AND s.id_status $status 
        $action
        AND s.id_run_item = R.`id`
        AND R.`id_action` = A.`id`
    )
        AS T ON d.`id_edo_run` = T.`id_run`
, r_user AS u
WHERE
T.id_status $status AND
T.`id_executor`=".$this->id_user." AND 
d.`id_user` = u.`id`

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

    /**
     * @param $id_task - id из edo_state ($id_s)
     * @param int $status 0 - на рассмотрении, 1-отказ, 2-согласованно, 3-согласованно с замечаиями
     * @param $comment - комментарий согласования
     * @param $next - ссылка (id) на запись, при пересылке или при дополнительном подтверждении
     * @return false / $id_task
     */
    public function set_status($id_task, $status=2, $comment=null, $next=null){
        $comment_executor = ( $comment==null ) ? '' : ", comment_executor = '$comment'";
        $next_data = ( $next==null ) ? '' : ", next = '$next'";
        $date_now = date('Y-m-d H:i:s', time());
        $sql = "
UPDATE `edo_state` SET id_status = $status , date_execute='$date_now' $comment_executor $next_data WHERE id = $id_task
        ";
        $this->Debug($sql,__FUNCTION__);
        if (iDelUpd($this->mysqli,$sql,false)===false) {
            $this->error = 19;  // ошибка изменния статуса задания
            return false;
        }
        return $id_task;
    }

    /**
     * @param $id_run_item
     * @return false/ $row
     */
    public function get_action($id_run_item){
        $sql = "    
SELECT * FROM `edo_run_items` R, `edo_action` A
WHERE
R.id = $id_run_item
AND R.`id_action` = A.id
";
        $this->Debug($sql,__FUNCTION__);
        if ($result = $this->mysqli->query($sql)) {
            return $result->fetch_assoc();
        }
        return false;
    }

    /** Перенаправление выполнения задания
     * @param $id_s - id задания
     * @param $id_executor - Новый исполнитель
     * @param $id_status - новый статус
     * @param $comment - измененный коментарий основной записи
     * @param int $timing
     * @return false|int
     */
    public function send_task($id_s, $id_executor, $id_status=-1, $comment='Перенаправлено', $timing=0) {
        $day_now = date('d.m.Y H:i:s', time());
        //echo "<br>--timing=$timing";
        $timeReady = \CCM\TimeReady\srok_vip($day_now,$timing*60,$this->mysqli);
        if ($timeReady===false) $timeReady = null;

        $sql ="
INSERT INTO edo_state (
  `id_run`,
  `id_run_item`,
  `name`,
  `descriptor`,
  `id_executor`,
  `comment_executor`,
  `sign_executor`,
  `id_checking`,
  `sign_checking`,
  `id_controller`,
  `sign_controller`,
  
  `date_ready`,
  `sign_owner`,
  `timing`,
  `displayOrder`,
  `id_status`,
  `prev`
)
( SELECT 
`id_run`,
  `id_run_item`,
  `name`,
  `descriptor`,
  $id_executor,
  NULL,
  `sign_executor`,
  `id_checking`,
  `sign_checking`,
  `id_controller`,
  `sign_controller`,
  
  '$timeReady',
  `sign_owner`,
  `timing`,
  `displayOrder`,
  0,
  $id_s
  FROM  edo_state
  WHERE id=$id_s
  )
        ";
        $this->Debug($sql,__FUNCTION__);
        if(($new_id = iInsert_1R($this->mysqli,$sql,$show=false))==0) {
            $this->error = 21;  // ошибка перенаправления задания
            return false;
        }
        if($this->set_status($id_s, $id_status, $comment, $new_id)===false) {
            $this->error = 20;  // ошибка изменения статуса
            return false;
        }
        return $new_id;
    }



    /** Проверка на превышение заявки по себестоимости
     * @param $id_doc
     * @return bool
     */
    public function is_excess($id_doc)
    {                    //".$this->arr_table[$this->type]." AS d
        if ($this->type==0 or $this->type==2) {
        switch ($this->type) {
            case 0:
                $sql = "
SELECT a.id 
FROM z_doc_material AS a 
WHERE 
a.id_doc=$id_doc 
AND 
((NOT(a.memorandum = '') AND a.id_sign_mem = 0)
OR
(NOT(a.memorandum = '') AND NOT(a.id_sign_mem = 0) AND a.signedd_mem = 0))
";
                break;
            case 2:
                $sql = "
select w.id, w.`id_nariad`, w.`memorandum`,
m.`id` as id_material, m.`memorandum` as mem_materil
from `n_work` as w
left join `n_material` as m on w.id = m.`id_nwork`
where
w.`id_nariad` = $id_doc
AND
( w.`memorandum` <> '' or m.`memorandum` <> '')
";
                break;
        }
             $this->Debug($sql, __FUNCTION__);
            // echo "<pre> TEST:".print_r($this->arr_sql,true)."</pre>";
            if ($result = $this->mysqli->query($sql)) {
                if ($result->num_rows > 0) {
                    return true;
                }
            }
        }
        return false;
    }

    /** Дополнительное согласование
     * @param $row_state
     * @return false|int
     */
    public function confirmation( &$row_state){
        $arr_action = $this->get_action($row_state[id_run_item]);
        if($this->show) {
            echo "<pre>arr_action:" . print_r($arr_action, true) . "</pre>";
        }
        if($arr_action[checking] == 1) { // нужно делать дополнительное согласование

            if(!(($new_id = $this->send_task($row_state[id], $row_state[id_checking], -($row_state[id_status]), '',$row_state[timing]))===false)) { // Создать задачу подтверждения
                if ($this->show) echo "создано дополнительное согласование!<br";
                $row = $row_state;
                $row[id_executor] = $row[id_checking];
                $row[id_status] = 0;
                $this->arr_task[$new_id] = $row;  // Для уведомления о созданной задаче
                return $new_id;
            }
        }
        return false;
    }

    /** История согласования документа
     * @param $id_document
     * @param $type
     */
    public function history( $id_document, $type) {
        $arr_history = array();
        $sql = "
SELECT * FROM `edo_run` 
WHERE 
`id_document` = $id_document 
  AND `table_name` = '".$this->arr_table[$type]."'        
        ";
        $this->Debug($sql,__FUNCTION__);
        if ($result = $this->mysqli->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                //$arr_history[] = $row;

                $sql1 = "
SELECT 
s.*,
-- s.id AS id_s, s.id_run_item, s.name AS name_task,s.descriptor AS descriptor_task ,  s.`id_executor`, s.`id_checking`, s.id_status, s.comment_executor,
u.`name_user`, u1.`name_user` AS name_user_checking,
ST.`name_status`       
FROM edo_state AS s 
LEFT JOIN r_user AS u ON s.`id_executor` = u.id
LEFT JOIN r_user AS u1 ON s.`id_checking` = u1.id
LEFT JOIN edo_status AS ST ON s.`id_status` = ST.`id_status`
WHERE s.id_run=" . $row[id] . "
-- AND s.id_status 
ORDER BY s.`date_create`, s.`displayOrder`
            ";
                $this->Debug($sql1, __FUNCTION__);
                if ($result1 = $this->mysqli->query($sql1)) {
                    while ($row1 = $result1->fetch_assoc()) {
                        //История согласования
                        $row[state][] = $row1;
                    }
                    $result1->close();
                }
                $arr_history[] = $row;

            }
            $result->close();
        }
        return $arr_history;
    }
}
