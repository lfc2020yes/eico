<? //include $url_system.'php/seo/seo.php';
session_start();
$size_page = array(
    array(2,3,14,1),                  //portret   первая-одна первая средняя последняя
    array(1,3,10,6,)                   //landscape первая-одна первая средняя прследняя
);
$type_page=0;                        //portret

$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; 
include_once $url_system.'module/config.php'; 
include_once $url_system.'module/function.php'; 
include_once $url_system.'login/function_users.php';
initiate($link);
include_once $url_system.'module/access.php';


//правам к просмотру к действиям
$hie = new hierarchy($link,$id_user);
//echo($id_user);
$hie_object=array();
$hie_town=array();
$hie_kvartal=array();
$hie_user=array();	
$hie_object=$hie->obj;
$hie_kvartal=$hie->id_kvartal;
$hie_town=$hie->id_town;
$hie_user=$hie->user;



$sign_level=$hie->sign_level;
$sign_admin=$hie->admin;


$role->GetColumns();
$role->GetRows();
$role->GetPermission();
//правам к просмотру к действиям


$error_header=0;
$url_404=$_SERVER['REQUEST_URI'];
//echo($url_404);
$D_404 = explode('/', $url_404);

//index.php не должно быть в $url_404
if (strripos($url_404, 'print_order.php') !== false) {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
}

if(($role->permission('Склад','A'))or($sign_admin==1)){ 
} else {
                    header("HTTP/1.1 404 Not Found");
                    header("Status: 404 Not Found");
                    $error_header=404;   
}


$id=htmlspecialchars($_POST['id']);
$token=htmlspecialchars($_POST['tk']);
if(!token_access_new($token,'print_stock_report8',$id,'s_form'))
{
	include $url_system.'module/error404.php';
	die();
}


if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}
//=========================================================================
  function minut_stamp($date_time) 
{ 

//2011-01-19 15:07:31

$date_elements  = explode(" ",$date_time);
$date_elements1  = explode(":",$date_elements[1]);
$date_elements2  = explode("-",$date_elements[0]);

	
      $vremy=$date_elements1[0].":".$date_elements1[1];
	  return $vremy;	


} 


function kopee($num) {
	$num= round(($num-intval($num))*pow(10,2));
	return($num);
}

function num2str($num) {
    $nul='ноль';
    $ten=array(
        array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
    );
    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
    $unit=array( // Units
        array('копейка' ,'копейки' ,'копеек',	 1),
        array('рубль'   ,'рубля'   ,'рублей'    ,0),
        array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
        array('миллион' ,'миллиона','миллионов' ,0),
        array('миллиард','милиарда','миллиардов',0),
    );
    //
    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub)>0) {
        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit)-$uk-1; // unit key
            $gender = $unit[$uk][3];
            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
        } //foreach
    }
    else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
    //$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}


function morph($n, $f1, $f2, $f5) {
    $n = abs(intval($n)) % 100;
    if ($n>10 && $n<20) return $f5;
    $n = $n % 10;
    if ($n>1 && $n<5) return $f2;
    if ($n==1) return $f1;
    return $f5;
}


function NumToIndex4($num)
{
 $octatok1=$num%100; 
 if((($num>=11)and($num<=14))or(($octatok1>=11)and($octatok1<=14))) { $ind=2; } else
 {
	
   $octatok=$num%10;
   if($octatok==0) { $ind=2; } else
   {
	  if($octatok==1) { $ind=0; } else
	  { 
   if ($octatok>4) $ind=2; else $ind=1; 
	  }
   }
 }
 return $ind;
}


function PadejToStr4($Age,$type)
{
  $SKL=explode(',',$type);
  $ind=NumToIndex4($Age);
	



  return $SKL[$ind];	
  
}

/*
// Подключаем класс для работы с excel
require_once($url_system.'library/Excel/PHPExcel.php');
// Подключаем класс для вывода данных в формате excel
require_once($url_system.'library/Excel/PHPExcel/Writer/Excel5.php');
include ($url_system.'library/Excel/PHPExcel/IOFactory.php');

$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
$rendererLibrary = 'domPDF0.6.0beta3';
$rendererLibraryPath = dirname(__FILE__). 'libs/classes/dompdf' . $rendererLibrary;

//  Here's the magic: you __tell__ PHPExcel what rendering engine to use
//     and where the library is located in your filesystem
if (!PHPExcel_Settings::setPdfRenderer(
    $rendererName,
    $rendererLibraryPath
)) {
    die('NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
        '<br />' .
        'at the top of this script as appropriate for your directory structure'
    );
}

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objPHPExcel = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objPHPExcel->load("order.xlsx");
$objPHPExcel->setActiveSheetIndex(0);

// Add some data
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->SetCellValue('H19', 'ЗА наряд');


// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Расходный кассовый ордер');

// Save Excel 2007 file

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save("2.xlsx");
header('2.xlsx');

// Redirect output to a client.s web browser (PDF)

*/



include_once $url_system.'template/html.php';
include_once $url_system.'module/config_url.php'; 
echo'<title>Печать - Ведомость инвентаризации</title>';
?>
<link rel="stylesheet" type="text/css" href="stock/print/lib/akt.css" />
	

</head>
<body>
<?php
	
include_once $url_system.'stock/print/lib/lib.php'; 
include_once $url_system.'stock/print/lib/akt.php'; 
?>

</body>
</html>