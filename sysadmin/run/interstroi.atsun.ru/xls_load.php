<?php
header('Content-type: text/html; charset=utf-8');
set_time_limit(300); //файл должен загрузиться за 5 минут

$url='./';      //'./sysadmin/run/interstroi.atsun.ru/'; Это каталог запуска этого PHP
require_once $url.'Classes/PHPExcel/IOFactory.php';
include_once("../../../ilib/lib_interstroi.php");

$url_system=$_SERVER['DOCUMENT_ROOT'].'/';
session_start();
$Codec = new codec("UTF-8","windows-1251");    //("UTF-8","windows-1251")

$loadfile = $_SERVER["DOCUMENT_ROOT"].'/ilib/XLShost/'.$_FILES['thefile']['name'];
//$loadfile_ = iconv('utf-8','windows-1251',$loadfile);

if (!(move_uploaded_file($_FILES['thefile']['tmp_name'], $Codec->iconv($loadfile) )) ) {
    echo "error, файл не загружен на сервер $loadfile";
} else  { //------------------------------------------------------загрузился
    echo "<br>";   //Ok
    ReadSheet($loadfile);
    echo " - выбрать вкладку с себестоимостью";
}

function ReadSheet($loadfile) {

$Codec = new codec("UTF-8","windows-1251");    //("UTF-8","windows-1251")
$FN_= $Codec->iconv($loadfile);
if (!file_exists($FN_)) {
     echo '<br> файл не найден: '.$FN_;
     echo '<br> реальная директория: '.realpath('.');
}
else
 {

  //echo '<p>'.date('H:i:s') . " Load from Excel file - ".$FN_ame_.'</p>';
  $objReader = PHPExcel_IOFactory::createReader('Excel2007');     //Excel2007  //Excel5
  $objPHPExcel = $objReader->load($FN_);
  $Sheet=0;
  //$DZ=date('Y-M-D H:i:s');
  //echo '<p>'.$DZ. " Перечитывание вкладок worksheets".'</p>';
  
  
  $FLD='sheet';
  echo '<input type="hidden" name="loadfile" id="loadfile" value="'.$loadfile.'" />';
  echo '<select name="'.$FLD.'" id="'.$FLD.'" class="text" onchange="AjaxXLS(\''.$loadfile.'\')">';
  echo'<option value = "0">выбрать вкладку сметы</option>';
  
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
        //$WS= $Codec->iconv($worksheet->getTitle());
        $WS= $worksheet->getTitle();
        echo'<option value = "' . $WS .'">' . $WS .'</option>';
	//echo '<p>'.'<caption align="left"> Вкладка: ' . $WS .'</caption>'.'</p>' ;
  }
  echo '</select>';
 }
}
 
 