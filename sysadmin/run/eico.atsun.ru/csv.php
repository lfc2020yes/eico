<?php

//include_once '../ilib/lib_interstroi.php';
include_once '../ilib/lib_import.php';
include_once '../ilib/Isql.php';

function RUN_($PARAM,&$row_TREE=0,&$ROW_role=0)
{
  
    
  $GT=array();
  GET_PARAM($GT,$PARAM);
    $name =  (isset($_POST["name"]))?$_POST["name"]:'';
    $units =  (isset($_POST["units"]))?$_POST["units"]:'';
    $type =  (isset($_POST["type"]))?$_POST["type"]:0;

  
          if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          }
          else { $styleH=''; $styleF=''; }
//$mysqli
//$id_user
//$id_doc
//$type

  ?>        
  <form id="numer_form"  class="theform" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="csv" value="1"/>

  <table <?=$styleF?> id="numer_table" cellspacing="0" align="left" class="theform">            
  <caption <?=$styleH?>><div style="padding:3px;">Тест функций CSV</div></caption>


    <tr><td style="padding-right: 10px">Наименование:<td>
    <input class="text"  name="name" size="60" value="<?=$name?>" />

    <tr><td style="padding-right: 10px">Единицы:<td>
    <input class="text"  name="units" size="20" value="<?=$units?>" />

      <tr><td style="padding-right: 10px">type (0 1 2):<td>
              <input class="text"  name="type" size="1" value="<?=$type?>" />
<?php
   SHOW_tfoot(4,1,1,1);

//==============================================================================
  if ($_POST["csv"]>0) {
    $ret=0;
    
    $mysqli=new_connect($ret);
    echo "<p/> result_connect mysqli=".$mysqli->connect_errno;
    if (!$mysqli->connect_errno) {
      echo "<p>step one";
//-----------------------------------------------------------------------------
      $id_user = 43;

        $csv = new CSV(null, 43);
  $mask = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/*.csv';
  $mask_attach = $_SERVER['DOCUMENT_ROOT'].'/'.'upload/1c_import/1c_attach/';
  $arFiles = $csv->read_dir ($mask, $mask_attach);
  echo "<pre> ФАЙЛЫ [$mask]: ".print_r($arFiles,true)."</pre>";

        /* получить аттачи
          $arAttach = $csv->list_attach( $data[0][УИДДокумента],$mask_attach);
        */

// Поиск по имени
        $find = new STOCK($mysqli, $id_user);
        $arStock = $find->find_byName($_POST["name"], $_POST["units"], $_POST["type"]);
        echo '<pre>результат:'.print_r($arStock,true) .'</pre>';
        echo '<pre>'. print_r($find->deb,true) .'</pre>';

    } 
    $mysqli->close();
?>

<?php
  }
?>
  </table>
  </form>
  </html>
<?php
}
?>