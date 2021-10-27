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
if (strripos($url_404, 'print_m.php') !== false) {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
}

if (( count($_GET) == 1 )) 
{
 if(( count($_GET) == 1 )and(isset($_GET["id"])))
 {
       //на главной по страничкам
         $result_url=mysql_time_query($link,'select a.* from z_doc a where a.id="'.htmlspecialchars(trim($_GET["id"])).'"');
        $num_results_custom_url = $result_url->num_rows;
        if($num_results_custom_url==0)
        {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
		} else
		{			
			$row_list= mysqli_fetch_assoc($result_url);
			

			
			
		/*
					$result_url2=mysql_time_query($link,'select a.name_role from r_user as b,r_role as a where a.id=b.id_role and b.id="'.$row_list1["id_boss"].'"');
        $num_results_custom_url2 = $result_url2->num_rows;
        if($num_results_custom_url2!=0)
        {
			$row_list2= mysqli_fetch_assoc($result_url2);
		
		}
		*/	
			
		}
			
			
			
			if(isset($_SESSION["user_id"]))
	        { 
		      //может ли читать наряды 
		 
		     /*  if (($role->permission('Печать наряда','R'))or($sign_admin==1))
	           { 
			   } else
			   {
			   header("HTTP/1.1 404 Not Found");
   header("Status: 404 Not Found");
   $error_header=404;   
			   }
				*/
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
	
	

	



include_once $url_system.'/ilib/lib_interstroi.php';
include_once $url_system.'/ilib/lib_edo.php';
$edo = new EDO($link, $id_user, false);



$arr_document = $edo->my_documents(0, ht($_GET["id"]), '>=-10', true);
$arr_tasks = $edo->my_tasks(0, '>=-10' ,'','LIMIT 0,1',null,ht($_GET["id"]));

//echo(count($arr_tasks));

if((count($arr_tasks)==0)and(count($arr_document)==0))
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
echo'<title>Печать - Форма заявки №'.$row_list["id"].'</title>';
//include $url_system.'template/head.php';
?>
<link rel="stylesheet" type="text/css" href="stylesheets/print/print.css" />
<style>
            body {
                font-family: Times New Roman, Cambria, Hoefler Text, Liberation Serif, Times, serif;
                font-size: 12px;
            }
	.shar { color:#511DA7;  font-size: 16px; text-transform: uppercase; }
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
	.pb10 {padding-bottom: 20px!important;}
	.it {font-style: italic;}
	.upp {text-transform: lowercase;}

    .flex {display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex; width: 100%; height: 20px;}
    .m-333 { white-space: nowrap}
    .line-b { width: 100%; border-bottom: 1px solid #000;}

    .va {vertical-align: middle;}
    .nowrap {white-space: nowrap;}

</style>	

</head>
<body>
<?
	
$date_rc=explode('-',$row_list["date_doc"]);
$date_rcc=$date_rc[2].'.'.$date_rc[1].'.'.$date_rc[0];
	

$date_rc1=explode('-',$row_list["date_begin"]);
$date_rcc1=$date_rc1[2].'.'.$date_rc1[1].'.'.$date_rc1[0];	
$date_rc2=explode('-',$row_list["date_end"]);
$date_rcc2=$date_rc2[2].'.'.$date_rc2[1].'.'.$date_rc2[0];

//echo('select * from r_user where id="' . ht($row_list["id_user"]) . '"');
$result_uu = mysql_time_query($link, 'select * from r_user where id="' . ht($row_list["id_user"]) . '"');
$num_results_uu = $result_uu->num_rows;

if ($num_results_uu != 0) {
    $row_uu = mysqli_fetch_assoc($result_uu);
}



$result_url=mysql_time_query($link,'select A.* from i_object as A where A.id="'.htmlspecialchars(trim($row_list["id_object"])).'"');
$num_results_custom_url = $result_url->num_rows;
if($num_results_custom_url!=0)
{
    $row_list1 = mysqli_fetch_assoc($result_url);
}

$result_town=mysql_time_query($link,'select A.id_town,B.town,A.kvartal from i_kvartal as A,i_town as B where A.id_town=B.id and A.id="'.$row_list1["id_kvartal"].'"');
$num_results_custom_town = $result_town->num_rows;
if($num_results_custom_town!=0)
{
    $row_town = mysqli_fetch_assoc($result_town);
}

echo'<table width="100%" align="center" style="margin: auto;"  class="orl" border="0" cellspacing="0" cellpadding="0">
<tbody><tr><td class="h1 pb10 center" colspan="2" style="text-align: center;"><br><br><strong>ЗАЯВКА № '.$_GET["id"].' от « '.date_fik($row_list["date"]).' » </strong></td></tr>
<tr><td width="50%" class="va">

<table width="100%" align="center" style="margin: auto;"  class="orl" border="0" cellspacing="0" cellpadding="0">
<tbody>


<tr>
<td class="right" width="200px">Дата заявки:</td>
<td class="bl bt br ll" >'.date_fik($row_list["date"]).'</tr>
<tr>
<td class="right" >Объект:</td>
<td class="bl  br ll">'.$row_list1["object_name"].' ('.$row_town["town"].', '.$row_town["kvartal"].')</td>
</tr>
<tr>
<td class="right" >Фактический адрес доставки:</td>
<td class="bl bb  br ll" ></td>
</tr>
</tbody></table>

</td><td align="right" class="va">

<table width="250px" align="right" style="margin: auto;"  class="orl" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="right" ><strong>УТВЕРЖДЕНО:</strong></td>
</tr>
<tr>
<td class="right">Генеральный директор ООО «ЭВРИКА»</td>
</tr>
<tr>
<td class="right">Исмагилов Э. Р.</td>
</tr>
<tr>
<td class="he" valign="top"><div class="line"></div></td>
</tr>


</tbody></table>
</td></tr>

</tbody></table><br><br>';



echo'<table width="100%" align="center" style="margin: auto;"  class="orl" border="0" cellspacing="0" cellpadding="0" >
  <tbody>
<tr>
<td  class="bl bb bt ll ver_7 center"><strong>№ п/п</strong></td>
<td  class="bl bb bt ll ver_7 center"><strong>Наименование материала</strong><br>(техники, оборудования)</td>
<td  class=" bb bt ll ver_7 center"><strong>Наименование работ</strong><br>
(в соответствии с перечнем в себестоимости)</td>
<td  class="bb bt ll ver_7 center"><strong>Порядковый номер материала</strong><br>
 (в соответствии с перечнем в себестоимости)</td>
<td  class="bb bt ll ver_7 center"><strong>Единица измерения</strong></td>
<td  class="bb bt ll ver_7 center"><strong>Количество</strong></td>
<td class="bb bt ll ver_7 center"><strong>Срок поставки на объект</strong></td>
<td class="bb bt br ll ver_7 center"><strong>Фактический срок поставки
(заполняется ОМТС)
</strong></td>
<td  class="bb bt br ll ver_7 center"><strong>Примечание
</strong></td>
<td  class="bb bt br ll ver_7 center"><strong>Давальческий материал
</strong></td>
</tr>
<tr>
<td class=" bl  ll  center">1</td>
<td class="   ll  center">2</td>
<td class="   ll  center">3</td>
<td class="   ll  center">4</td>
<td class=" center   ll  ">5</td>
<td class="   ll  center">6</td>
<td class="   ll  center">7</td>
<td class="   ll  center">8</td>
<td class="   ll  center">9</td>
<td class="   ll  center">10</td>
</tr>
';
$number=1;
$result_work_zz=mysql_time_query($link,'Select a.* from z_doc_material as a where a.id_doc="'.htmlspecialchars($_GET['id']).'" order by a.id');
$num_results_work_zz = $result_work_zz->num_rows;
if($num_results_work_zz!=0) {


    $id_work = 0;

    for ($i = 0; $i < $num_results_work_zz; $i++) {
        $row_work_zz = mysqli_fetch_assoc($result_work_zz);

//проверим может вообще такого материала уже нет
        $result_t1 = mysql_time_query($link, 'Select a.* from i_material as a where a.id="' . htmlspecialchars(trim($row_work_zz["id_i_material"])) . '"');
        $num_results_t1 = $result_t1->num_rows;
        if ($num_results_t1 != 0) {
//такая работа есть
            $row1ss = mysqli_fetch_assoc($result_t1);

            $result_t1__34=mysql_time_query($link,'Select b.razdel1,a.name_working,a.razdel2,a.date0,a.date1  from i_razdel2 as a,i_razdel1 as b where a.id="'.$row1ss["id_razdel2"].'" and a.id_razdel1=b.id');
            $num_results_t1__34 = $result_t1__34->num_rows;
            if($num_results_t1__34!=0)
            {
                $row1ss__34 = mysqli_fetch_assoc($result_t1__34);

            }
            $dava='нет';
            $class_dava='';
            if($row1ss["alien"]==1)
            {
                $class_dava='dava';

            }

            if($row1ss["alien"]==1)
            {
                $dava='да';
            }


            echo '<tr>
<td class=" bl  ll  center">'.$number.'</td>
<td class="   ll  left">'.$row1ss["material"].'</td>
<td class="   ll  left">'.$row1ss__34["razdel1"].'.'.$row1ss__34["razdel2"].' '.$row1ss__34["name_working"].'</td>
<td class="   ll  center va">'.$row1ss__34["razdel1"].'.'.$row1ss__34["razdel2"].'.'.$row1ss["displayOrder"].'</td>
<td class=" center   ll  va">'. $row1ss["units"].'</td>
<td class="   ll  center va">'.$row_work_zz["count_units"].'</td>
<td class="   ll  center nowrap va">'.ipost_(date_fik($row_work_zz["date_delivery"]),"").'</td>
<td class="   ll  center"></td>
<td class="   ll  center">'.$row_work_zz["commet"].'</td>
<td class="   ll  center">'.$dava.'</td>
</tr>';
            $number++;
        }
    }
}

echo'<tr><td colspan="9" style="">&nbsp;</td></tr>';
echo'<tr><td colspan="9" style="">&nbsp;</td></tr>';
echo'

<tr>
<td ></td>
<td ><strong>Составил:</strong></td>
<td colspan="7" class="he" valign="top">

<table class="orl notop" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
        <tr>

      <td class="ver_8 center  nobottom" >&nbsp;</td>
      <td class="ver_8 center " ></td>
      <td class="ver_8 center "></td>
     
      </tr>
        <tr>
 
      <td class="he" valign="top" width="33%"><div class="line">должность</div></td>
      <td class="he" valign="top" width="33%"><div class="line">подпись</div></td>
      <td class="he" valign="top"><div class="line">расшифровка подписи</div></td>
      
      </tr>  
  </tbody>
</table>


</td>
</tr>


<tr>
<td ></td>
<td ><strong>Согласовано:</strong></td>
<td colspan="7" class="he" valign="top"><div class="flex"><div class="m-333">Руководитель проекта</div><div class="line-b"></div></div></td>
</tr>

<tr>
<td ></td>
<td ></td>
<td colspan="7" class="he" valign="top"><div class="flex"><div class="m-333">Начальник ПТО</div><div class="line-b"></div></div></td>
</tr>

<tr>
<td ></td>
<td ></td>
<td colspan="7" class="he" valign="top"><div class="flex"><div class="m-333">Инженер-экономист</div><div class="line-b"></div></div></td>
</tr>
<tr>
<td></td>
<td colspan="8">';

echo'<table class="orl" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
        <tr>
      <td class="ver_8 right" width="10px" valign="bottom">«</td>
      <td class="ver_8 left " width="40px"></td>
      <td class="ver_8 left " width="10px">»</td>
      <td class="ver_8 left " width="100px"></td>
      <td class="ver_8 center " width="80px"></td>
      <td class="ver_8 left " width="">г.</td>
      <td class="ver_8 right" width="55px"></td>
      <td class="ver_8 left " width="200px"></td>
      </tr>
        <tr>
      <td></td>
      <td class="he" valign="top"><div class="line">&nbsp;</div></td>
      <td class="he" valign="top"></td>
      <td class="he" valign="top"><div class="line">&nbsp;</div></td>
      <td class="he" valign="top"><div class="line">&nbsp;</div></td>
      <td class="he" valign="top"></td>
      <td class="he" valign="top"></td>
      <td class="he" valign="top"></td>
      </tr>
  </tbody>
</table>';

echo'</td>
</tr>



';
echo'</tbody>
</table>';

	
//**************
//**************
//**************

?>

</body>
</html>