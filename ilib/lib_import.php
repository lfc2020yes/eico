<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/lib_interstroi.php';

  /*$csv = new CSV(null, 43);
  $mask = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/*.csv';
  $mask_attach = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/1c_attach/';
  $arFiles = $csv->read_dir ($mask, $mask_attach);
  echo "<pre> ФАЙЛЫ [$mask]: ".print_r($arFiles,true)."</pre>";*/

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

class INN {
    var $mysqli;
   public function INN ($mysqli)
   { $this->mysqli = $mysqli;
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
}
