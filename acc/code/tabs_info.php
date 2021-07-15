<?
//загрузить дополнительные прикреплленные файлы и документы по клиенту частное лицо

$query_string.='<div class="input-block-2020">';




include_once $url_system.'/ilib/lib_interstroi.php';
include_once $url_system.'/ilib/lib_edo.php';

$edo = new EDO($link, $id_user, false);
$arr_document = $edo->my_documents(1, ht($_GET["id"]), '=0', true);
//$query_string.='<pre>arr_document:' . print_r($arr_document, true) . '</pre>';

foreach ($arr_document as $key => $value) {
    if ((is_array($value["state"])) and (!empty($value["state"]))) {

        foreach ($value["state"] as $keys => $val) {



            $query_string.='<div class="px_flex">
                <div class="px_left">
                    <div class="strong_wh_2020">↓ Задача</div>
            <div class="pass_wh"><span>'.$val["name_task"].'</span></div>
            </div>
                   <div class="px_left">
                    <div class="strong_wh_2020">↓ Описание</div>
            <div class="pass_wh"><span>'.$val["descriptor_task"].'</span></div>
            </div>
            </div>';




        }
    }
}




$query_string.='</div>';
