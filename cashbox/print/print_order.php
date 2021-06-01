<? //include $url_system.'php/seo/seo.php';
session_start();

$url_system=$_SERVER['DOCUMENT_ROOT'].'/'; include_once $url_system.'module/config.php'; include_once $url_system.'module/function.php'; include_once $url_system.'login/function_users.php'; initiate($link); include_once $url_system.'module/access.php';


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

if (( count($_GET) == 1 )) 
{
 if(( count($_GET) == 1 )and(isset($_GET["id"])))
 {
       //на главной по страничкам
         $result_url=mysql_time_query($link,'select a.*,b.* from c_cash as a,i_implementer as b where a.id="'.htmlspecialchars(trim($_GET["id"])).'" and a.id_implementer=b.id');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0)
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} else
		{			
			$row_list= mysqli_fetch_assoc($result_url);
			
			//узнаем организацию
		$result_url1=mysql_time_query($link,'select a.* from i_company as a where a.id=1');
        $num_results_custom_url1 = $result_url1->num_rows;
        if($num_results_custom_url1!=0)
        {
			$row_list1= mysqli_fetch_assoc($result_url1);
		
					$result_url2=mysql_time_query($link,'select a.name_role from r_user as b,r_role as a where a.id=b.id_role and b.id="'.$row_list1["id_boss"].'"');
        $num_results_custom_url2 = $result_url2->num_rows;
        if($num_results_custom_url2!=0)
        {
			$row_list2= mysqli_fetch_assoc($result_url2);
		
		}
			
			
		}
			
			
			
			if(isset($_SESSION["user_id"]))
	        { 
		      //может ли читать наряды 
		 
		       if (($role->permission('Касса','R'))or($sign_admin==1))
	           { 
			   } else
			   {
			   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;   
			   }
				
			} else
			{
		   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;		
			}
			
		}
 } else
 {
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
 }
	
	

	
} else
{
   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;
}

if($error_header==404)
{
	include $url_system.'module/error404.php';
	die();
}




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
echo'<title>Печать - Расходный кассовый ордер №'.$row_list["numer"].'</title>';
//include $url_system.'template/head.php';
?>
<link rel="stylesheet" type="text/css" href="stylesheets/print/print.css" />
<style>
            body {
                font-family: Times New Roman, Cambria, Hoefler Text, Liberation Serif, Times, serif;
                font-size: 12px;
            }
	.shar { color:#280365;  font-size: 16px; text-transform: uppercase; font-family: Arial; }
	.ver_6 {font-size: 8px;}
	.ver_8 {font-size: 12px;}
	.ver_7 {font-size: 11px;}
	.h1 {font-size: 18px;}
	.lus_9 {font-family:Times New Roman, Cambria, Hoefler Text, Liberation Serif, Times, serif;
                font-size: 14px;}
	.right { text-align: right;}
	.center { text-align: center;}
	.line{ width: 100%; text-align: center; border-top:1px solid #000; font-size: 8px; padding-top: 0px; margin-top:0px; }
	.orl {border-collapse: collapse;}
	.orl td { padding: 4px; }
	.ll {border:1px solid #000}
	.bl  {border-left:3px solid #000}
	.bt  {border-top:3px solid #000}
	.br {border-right:3px solid #000}
	.bb {border-bottom:3px solid #000}
	.he {  padding-top:0px !important; }
	.bottom { padding-bottom: 0px !important;}
	.notop td { padding-top: 0px!important;}
	.nobottom { padding-bottom: 0px!important;}
	.nowrap {white-space: nowrap;}
	.stamp {position: relative;}
	.pechat {position: absolute; top:-27px; right:43px; display: inline-block;}
</style>	

</head>
<body>
<?
	
$date_rc=explode('-',$row_list["date_rco"]);
$date_rcc=$date_rc[2].'.'.$date_rc[1].'.'.$date_rc[0];
	
echo'<table width="100%" class="orl" border="0" cellspacing="0" cellpadding="0" >
  <tbody>
           <tr>
      <td colspan="4" align="right" class="ver_6 right">Унифицированная форма № КО-2<br>Утверждена постановлением Госкомстата России от 18.08.98 № 88</td>

    </tr>
           <tr>
      <td  width="70%">&nbsp;</td>
      <td width="7%">&nbsp;</td>
      <td width="7%">&nbsp;</td>
      <td width="" class="ver_8 center ll">Код</td>
    </tr>

        <tr>
      <td  ></td>
     
      <td colspan="2" class="right lus_9 nowrap">Форма по ОКУД</td>
      <td class="center lus_9 ll bl bt br nowrap"> 0310002</td>
      </tr>
        <tr>
      <td  class="ver_8 center nobottom nowrap"><strong class="shar">'.htmlspecialchars_decode($row_list1["name_company"]).'</strong></td>
      
      <td colspan="2" class="right lus_9 nowrap">по ОКПО</td>
      <td class="ll bl  br"></td>
      </tr>
        <tr>
      <td valign="top" class="he"><div class="line">организация</div></td>
      <td></td>
      <td></td>
      <td class="bl  br"></td>
    </tr>
     <tr>
      <td colspan="2" class="ver_8 nowrap center nobottom"><strong class="shar">'.htmlspecialchars_decode($row_list["name_team"]).'</strong></td>
      
      <td>&nbsp;</td>
      <td class=" bl  br bb">&nbsp;</td>
    </tr>   
        <tr>
      <td valign="top" class="he" colspan="2"><div class="line">структурное подразделение</div></td>
      <td></td>
      <td></td>
    </tr>
        
        
  </tbody>
</table>


<table width="100%" class="orl" border="0" style="margin-top:10px;" cellspacing="0" cellpadding="0" >
  <tbody>
         
     <tr>
      <td width="">&nbsp;</td>
      <td width="16%" class="ver_8 center ll">Номер документа</td>
      <td width="16%" class="ver_8 center ll">Дата составления</td>
    </tr>
     <tr>
      <td class="right h1"><strong>РАСХОДНЫЙ КАССОВЫЙ ОРДЕР</strong></td>
      <td  class="ver_8 center ll bl bt bb nobottom"><strong class="shar">'.$row_list["numer"].'</strong></td>
      <td  class="ver_8 center ll br bt bb nobottom"><strong class="shar">'.$date_rcc.'</strong></td>
    </tr>
 
               
  </tbody>
</table>


<table width="100%" class="orl" border="0" cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td width="5%">&nbsp;</td>
      <td width="15%"></td>
      <td width="15%"></td>
      <td width="15%"></td>
      <td width="15%"></td>
      <td width="15%"></td>
      <td width="15%"></td>
      <td width="5%"></td>
    </tr>
             
          <tr>
      <td colspan="4"  class="ver_7 center ll">Дебет</td>

      <td  rowspan="2"  class="ver_7 center ll">Кредит</td>
      <td rowspan="2"  class="ver_7 center ll">Сумма, руб. коп.</td>
      <td rowspan="2"  class="ver_7 center ll">Код целевого назначения</td>
      <td rowspan="2"  class="ver_8 center ll"></td>
    </tr>


        <tr>
      <td  class="ver_8 center ll">&nbsp;</td>
      <td  class="ver_7 center ll">код структурного подразделения</td>
      <td  class="ver_7 center ll">корреспондирующий счет, субсчет</td>
      <td  class="ver_7 center ll">код аналитического учета</td>
 
    </tr>
  
            <tr>
      <td  class="ver_8 center ll bl bt bb">&nbsp;</td>
      <td class="ver_8 center ll  bt bb  nobottom"><strong class="shar"></strong></td>
      <td class="ver_8 center ll  bt bb nobottom"><strong class="shar"></strong></td>
      <td class="ver_8 center ll  bt bb nobottom"><strong class="shar"></strong></td>
      <td class="ver_8 center ll  bt bb nobottom"><strong class="shar"></strong></td>
      <td class="ver_8 center ll  bt bb nobottom"><strong class="shar">'.$row_list["summa_rco"].'</strong></td>
      <td class="ver_8 center ll  bt bb nobottom"><strong class="shar"></strong></td>
      <td class="ver_8 center ll br  bt bb">&nbsp;</td>
    </tr>  
  </tbody>
</table>


<table width="100%" class="orl" border="0" style="margin-top: 10px;" cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td valign="bottom" width="47px" class="ver_8 left nowrap">Выдать</td>
      <td class="ver_8 left nobottom"><strong class="shar">'.pad($row_list["fio"],1).'</strong></td>
      </tr>
        <tr>
      <td ></td>
      <td valign="top" class="he"><div class="line">фамилия, имя, отчество</div></td>
      </tr>  
  </tbody>
</table>    


<table width="100%" class="orl" border="0" cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td valign="bottom" width="60px" class="ver_8 left nowrap">Основание</td>
      <td class="ver_8 left nobottom"><strong class="shar"></strong></td>
      </tr>
        <tr>
      <td ></td>
      <td valign="top" class="he"><div class="line">&nbsp;</div></td>
      </tr>  
  </tbody>
</table>  

<table width="100%" class="orl notop" border="0" cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td valign="bottom" width="40px" class="ver_8 left nowrap">Cумма</td>
      <td class="ver_8 left nobottom"><strong class="shar">'.num2str($row_list["summa_rco"]).'</strong></td>
      <td width="35px" class="ver_8 center ">руб.</td>
      <td width="40px" class="ver_8 center nobottom"><strong class="shar">'.kopee($row_list["summa_rco"]).'</strong></td>
      <td width="35px" class="ver_8 center ">коп.</td>
      </tr>
        <tr>
      <td ></td>
      <td valign="top" class="he"><div class="line">прописью</div></td>
      <td valign="top" class="he"></td>
      <td valign="top" class="he"><div class="line">&nbsp;</div></td>
      <td valign="top" class="he"></td>
      </tr>  
  </tbody>
</table>  
<table width="100%" class="orl" border="0" cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td valign="bottom" width="70px" class="ver_8 left nowrap">Приложение</td>
      <td class="ver_8 left nobottom"><strong class="shar"></strong></td>
      </tr>
        <tr>
      <td ></td>
      <td valign="top" class="he"><div class="line">&nbsp;</div></td>
      </tr>  
  </tbody>
</table>  


<table width="100%" class="orl notop" border="0" cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td valign="bottom" width="140px" class="ver_8 left nowrap">Руководитель организации</td>
      <td width="25%" class="ver_8 center  nobottom"><strong class="shar">'.$row_list2["name_role"].'</strong></td>
      <td width="25%" class="ver_8 center "></td>
      <td class="ver_8 center "></td>
     
      </tr>
        <tr>
      <td ></td>
      <td valign="top" class="he"><div class="line">должность</div></td>
      <td valign="top" class="he"><div class="line">подпись</div></td>
      <td valign="top" class="he"><div class="line">расшифровка подписи</div></td>
      
      </tr>  
  </tbody>
</table> 


<table width="100%" class="orl" border="0" cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td valign="bottom" width="100px" class="ver_8 left nowrap">Главный бухгалтер</td>
      <td width="25%" class="ver_8 center "></td>
      <td width="35%" class="ver_8 center "></td>
      <td class="ver_8 center "></td>
     
      </tr>
        <tr>
      <td ></td>
      <td valign="top" class="he"><div class="line">подпись</div></td>
      <td valign="top" class="he"><div class="line">расшифровка подписи</div></td>
      <td valign="top" class="he"></td>
      
      </tr>  
  </tbody>
</table> 
<table width="100%" class="orl" border="0" cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td valign="bottom" width="40px" class="ver_8 left nowrap">Получил</td>
      <td class="ver_8 left "></td>
      <td width="35px" class="ver_8 center ">руб.</td>
      <td width="40px" class="ver_8 left "></td>
      <td width="35px" class="ver_8 center ">коп.</td>
      </tr>
        <tr>
      <td ></td>
      <td valign="top" class="he"><div class="line">прописью</div></td>
      <td valign="top" class="he"></td>
      <td valign="top" class="he"><div class="line">&nbsp;</div></td>
      <td valign="top" class="he"></td>
      </tr>  
  </tbody>
</table>  


<table width="100%" class="orl" border="0" cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td valign="bottom" width="10px" class="ver_8 right">«</td>
      <td width="40px" class="ver_8 left "></td>
      <td width="10px" class="ver_8 left ">»</td>
      <td width="100px" class="ver_8 left "></td>
      <td width="80px" class="ver_8 center "></td>
      <td width="" class="ver_8 left ">г.</td>
      <td width="55px" class="ver_8 right">Подпись</td>
      <td width="200px" class="ver_8 left "><div class="stamp">';
	if($row_list["cashless"]==1)
	{
	   echo'<div class="pechat"><img src="img/stamp/st1.png"></div>';
	}
	
	echo'</div></td>
      </tr>
        <tr>
      <td ></td>
      <td valign="top" class="he"><div class="line">&nbsp;</div></td>
      <td valign="top" class="he"></td>
      <td valign="top" class="he"><div class="line">&nbsp;</div></td>
      <td valign="top" class="he"><div class="line">&nbsp;</div></td>
      <td valign="top" class="he"></td>
      <td valign="top" class="he"></td>
      <td valign="top" class="he"><div class="line">&nbsp;</div></td>
      </tr>  
  </tbody>
</table>  


<table width="100%" class="orl notop" border="0"  cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td valign="bottom" width="20px" class="ver_8 left ">По</td>
      <td class="ver_8 left "></td>
      </tr>
        <tr>
      <td ></td>
      <td valign="top" class="he"><div class="line">наименование, номер, дата и место выдачи документа, удостоверяющего личность получателя</div></td>
      </tr>  
  </tbody>
</table>    

<table width="100%" class="orl" border="0" cellspacing="0" cellpadding="0">
  <tbody>
        <tr>
      <td valign="bottom" width="80px" class="ver_8 left nowrap">Выдал кассир</td>
      <td width="25%" class="ver_8 center "></td>
      <td width="35%" class="ver_8 center "></td>
      <td class="ver_8 center "></td>
     
      </tr>
        <tr>
      <td ></td>
      <td valign="top" class="he"><div class="line">подпись</div></td>
      <td valign="top" class="he"><div class="line">расшифровка подписи</div></td>
      <td valign="top" class="he"></td>
      
      </tr>  
  </tbody>
</table>'; 
?>

</body>
</html>