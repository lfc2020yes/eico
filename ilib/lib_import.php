<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/'.'ilib/lib_interstroi.php';
/*
  $csv = new CSV(null, 43);
  $mask = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/*.csv';
  $arFiles = $csv->read_dir ($mask);
  echo "<pre> ФАЙЛЫ [$mask]: ".print_r($arFiles,true)."</pre>";
*/
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
    public function read_dir ($mask) {
        $files = array();
        foreach (glob($mask) as $filename) {
            $fn = $this->Codec->iconv($filename);
            $files[][file] = $fn;
            $num = count($files)-1;
            $files[$num][organization] = $this->get_organization($fn);
            $files[$num][data] = $this->read_data($filename);
        }
        return($files);
    }
    public function get_organization ($filename) {
        $arFN = explode('.',$filename);
        $arName = explode(' ',$arFN[0]);
        return (count($arName)>1) ? $arName[1] : false;
    }

    public function read_data($filename) {
        $list = $names = array(); $i = 0;
        if (($fp = fopen($filename, "r")) !== FALSE) {
            while (($fields = fgetcsv($fp, 0, ";")) !== FALSE) {
                if ($i == 0) {
                    foreach ($fields as $field) {
                        $names[] = $this->Codec->iconv($field);
                    }
                } else {
                    $j=0;
                    foreach ($fields as $field) {
                        $list[$i-1][ $names[$j] ] = $this->Codec->iconv($field);
                        $j++;
                    }
                }
                $i++;
            }
            fclose($fp);

        }
        return $list;
    }
}
