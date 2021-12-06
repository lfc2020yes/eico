<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/lib_interstroi.php';

  /*$csv = new CSV(null, 43);
  $mask = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/*.csv';
  $mask_attach = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/1c_attach/';
  $arFiles = $csv->read_dir ($mask, $mask_attach);
  echo "<pre> ФАЙЛЫ [$mask]: ".print_r($arFiles,true)."</pre>";*/

/* получить аттачи
  $arAttach = $csv->list_attach( $data[0][УИДДокумента],$mask_attach);
*/

// Поиск по имени
/*$find = new STOCK($mysqli, 43);
$find->find_byName('бетон','т',2);*/

class CSV
{
    var $mysqli;
    var $id_user;
    var $Codec;

    public function CSV($mysqli, $id_user)
    {
        $this->mysqli = $mysqli;
        $this->id_user = $id_user;
        $this->Codec = new codec("windows-1251","UTF-8");
    }

    public function read_dir ($mask,$mask_attach) {
        $files = array();
        foreach (glob($mask) as $filename) {
            $fn = $this->Codec->iconv($filename);
            $files[][file] = $fn;
            $num = count($files)-1;
            $files[$num][organization] = $this->get_organization($fn);
            $files[$num][data] = $this->read_data($filename);
            $files[$num][attach] = $this->list_attach( $files[$num][data][0][УИДДокумента],$mask_attach);
        }
        return($files);
    }

    public function list_attach ($uid, $mask) {
        $files = array();
        foreach (glob($mask.$uid."*.*") as $filename) {
            $files[] = $this->Codec->iconv($filename);
        }
        return($files);
    }

    public function get_organization ($filename) {
        $arFN = explode(' ',$filename);
        $arName = explode('.',$arFN[1]);
        return (count($arName)>0) ? $arName[0] : false;
    }

    public function read_data($filename) {
        $list = $names = array(); $i = 0;
        if (($fp = fopen($filename, "r")) !== FALSE) {
            while (($fields = fgetcsv($fp, 0, ";")) !== FALSE) {
                if (count($fields)>1) {
                    if ($i == 0) {
                        foreach ($fields as $field) {
                            $names[] = $this->Codec->iconv($field);
                        }
                    } else {
                        $j = 0;
                        foreach ($fields as $field) {
                            $list[$i - 1][$names[$j]] = $this->Codec->iconv($field);
                            $j++;
                        }
                    }
                    $i++;
                }
            }
            fclose($fp);

        }
        return $list;
    }
}


/*$contractor = new CONTRACTOR(mysqli, $id_user);
if (($id=$contractor->get( ИНН )) !== false) { Уже есть }
else
if (($id=$contractor->put($arData[0][data][0]))!==false { Добавили новый }*/
class CONTRACTOR {
    var $mysqli;
    var $id_user;
   public function CONTRACTOR ($mysqli, $id_user)
   {    $this->mysqli = $mysqli;
        $this->id_user = $id_user;
   }
   public function get ($inn_contractor) {
       $ret = false;
       if ($result = $this->mysqli->query("SELECT id FROM `z_contractor` WHERE inn = '$inn_contractor'")) {
           if ($row = $result->fetch_assoc()) {
               $ret = $row[id];
           }
           $result->close();
       }
       return $ret;
   }
    public function put ($arData)
    {   $sql = "
INSERT INTO `atsunru_interstroi`.`z_contractor` (
  `name`,
  `name_small`,
  `adress`,
  `inn`,
  `ogrn`,
  `status`,
  `dir`,
  `date_create`,
  `id_user`
)
VALUES
  (
    '{$arData[НаименованиеПолноеКонтрагента]}',
    '{$arData[НаименованиеКонтрагента]}',
    '{$arData[Адрес]}',
    '{$arData[ИНН]}',
    '{$arData[ОГРН]}',
    'действующий',
    '{$arData[Директор]}',
    'date_create',
    '{$this->id_user}'
  );
    ";
        $id_run = iInsert_1R($this->mysqli,$sql,false);
        return ($id_run>0) ? $id_run : false;
    }
}

class STOCK {
    var $mysqli;
    var $id_user;
    var $deb;

    public function STOCK ($mysqli, $id_user)
    {
        $this->mysqli = $mysqli;
        $this->id_user = $id_user;
        $this->deb = array();
    }

    // $type 0-точно 1-name% 2-%name%

    public function find_byName ($name,$units,$type=0)
    {
        $rows = array(); $EQ = '=';
        switch ($type) {
            case 0: break;
            case 1: $EQ = 'LIKE';
                    $name = $name.'%';
                    break;
            case 2: $EQ = 'LIKE';
                    $name = '%'.$name.'%';
                    break;
        }

        $sql = "SELECT * FROM `z_stock` WHERE `name` $EQ LOWER('$name')";
        $this->Debug($sql,__FUNCTION__);
        if ($result = $this->mysqli->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $result->close();
        }
        return count($rows)>0 ? $rows : false;
    }

    public function find_byNameUnits ($name, $units, $type=0)
    {

    }
    private function Debug($sql, $name_function) {
        $ar[sql] = $sql;
        $ar[func] = $name_function;
        $this->deb[] = $ar;
    }
}
