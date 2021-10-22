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
if (strripos($url_404, 'print_finery.php') !== false) {
           header("HTTP/1.1 404 Not Found");
	       header("Status: 404 Not Found");
	       $error_header=404;
}

if (( count($_GET) == 1 )) 
{
 if(( count($_GET) == 1 )and(isset($_GET["id"])))
 {
       //на главной по страничкам
         $result_url=mysql_time_query($link,'select a.* from n_nariad a where a.id="'.htmlspecialchars(trim($_GET["id"])).'" and a.signedd_nariad=1 ');
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
		$result_url1=mysql_time_query($link,'select a.* from i_implementer as a where a.id="'.$row_list["id_implementer"].'"');
        $num_results_custom_url1 = $result_url1->num_rows;
        if($num_results_custom_url1!=0)
        {
			$row_list1= mysqli_fetch_assoc($result_url1);
			
						//узнаем организацию
		$result_url11=mysql_time_query($link,'select a.* from i_company as a where a.id=1');
        $num_results_custom_url11 = $result_url11->num_rows;
        if($num_results_custom_url11!=0)
        {
			$row_list11= mysqli_fetch_assoc($result_url11);		
		}
			
			
			
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
		 
		       if (($role->permission('Печать наряда','R'))or($sign_admin==1))
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
echo'<title>Печать - НАРЯД №'.$row_list["id"].'</title>';
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

echo'<table width="100%"  class="orl" border="0" cellspacing="0" cellpadding="0" >
  <tbody>
           <tr>
           <td  width="3%">&nbsp;</td>
<td  width="6%">&nbsp;</td>
<td  width="33%">&nbsp;</td>
<td  width="8%">&nbsp;</td>
<td  width="7%">&nbsp;</td>
<td  width="9%">&nbsp;</td>
<td  width="9%">&nbsp;</td>
<td  width="11%">&nbsp;</td>
<td  width="10%">&nbsp;</td>
<td  width="4%">&nbsp;</td>
</tr>

<tr>
<td colspan="3"></td>
<td class="h1 pb10" colspan="4"><strong>НАРЯД №'.$row_list["id"].'</strong></td>
<td class="right ver_8 pb10" colspan="3"><strong>'.$date_rcc.'</strong></td>
</tr>

<tr>
<td class="right" colspan="3">Период:</td>
<td class="bl bt br ll" colspan="7">'.$date_rcc1.' - '.$date_rcc2.'</td>
</tr>';

        $result_town=mysql_time_query($link,'select C.object_name,B.town,A.kvartal from i_kvartal as A,i_town as B,i_object as C where C.id_kvartal=A.id and A.id_town=B.id and C.id="'.$row_list["id_object"].'"');
        
		$num_results_custom_town = $result_town->num_rows;
        
		if($num_results_custom_town!=0)
        {
			$row_town = mysqli_fetch_assoc($result_town);
		}
		
	
echo'<tr>
<td class="right" colspan="3">Объект:</td>
<td class="bl  br ll" colspan="7">'.$row_town["object_name"].', '.$row_town["kvartal"].', '.$row_town["town"].'</td>
</tr>
<tr>
<td class="right" colspan="3">Заказчик:</td>
<td class="bl  br ll" colspan="7">'.htmlspecialchars_decode($row_list11["name_company"]).', '.htmlspecialchars_decode($row_list11["adress"]).'</td>
</tr>
<tr>
<td class="right" colspan="3">Исполнитель:</td>
<td class="bl bb br ll" colspan="7">'.pad($row_list1["fio"],0).', '.htmlspecialchars_decode($row_list1["name_team"]).'</td>
</tr>
<tr>
<td colspan="10">&nbsp;</td>
</tr>

<tr>
<td class="bl bb bt ll ver_6 center"><strong>1</strong></td>
<td class=" bb bt ll ver_6 center"><strong>2</strong></td>
<td class="bb bt ll ver_6 center"><strong>3</strong></td>
<td class="bb bt ll ver_6 center"><strong>4</strong></td>
<td class="bb bt ll ver_6 center"><strong>5</strong></td>
<td class="bb bt ll ver_6 center"><strong>6</strong></td>
<td class="bb bt ll br ver_6 center"><strong>7</strong></td>
<td class="bb bt ll ver_6 center"><strong>8</strong></td>
<td class="bb bt br ll ver_6 center"><strong>9</strong></td>
<td class="bb bt ll br ver_6 center"><strong>10</strong></td>
</tr>
<tr>

<td class="bl bb bt ll ver_7 center" rowspan="2"><strong>№ п/п</strong></td>
<td class=" bb bt ll ver_7 center" rowspan="2"><strong>Раздел сметы</strong></td>
<td class=" bb bt ll ver_7 center" rowspan="2"><strong>Наименование работ</strong></td>
<td class=" bb bt ll ver_7 center" rowspan="2"><strong>ед.изм.</strong></td>
<td class=" bb bt ll ver_7 center" rowspan="2"><strong>кол-во</strong></td>
<td class="  bt ll br ver_7 center" colspan="2"><strong>стоимость ед.(руб.)</strong></td>
<td class="  bt ll br ver_7 center" colspan="2"><strong>Итого (руб.)</strong></td>
<td class=" bb bt br ll ver_7 center" rowspan="2"><strong>прим. *</strong></td>
</tr>
<tr>
<td class=" bb  ll ver_7 center" ><strong>работа</strong></td>
<td class=" bb  ll br ver_7 center" ><strong>материалы</strong></td>
<td class=" bb  ll ver_7 center" ><strong>работа</strong></td>
<td class=" bb  ll br ver_7 center" ><strong>материалы</strong></td>

</tr>';
	
		$result_work=mysql_time_query($link,'Select a.* from n_work as a where a.id_nariad="'.$row_list["id"].'" order by a.id');
        $num_results_work = $result_work->num_rows;
	    if($num_results_work!=0)
	    {
		  
   $rrr=0;
		   for ($i=0; $i<$num_results_work; $i++)
		   {
			   $row_work = mysqli_fetch_assoc($result_work);
			   
			          $result_raz=mysql_time_query($link,'select B.razdel1,A.razdel2 from i_razdel2 as A,i_razdel1 as B where B.id=A.id_razdel1 and A.id="'.$row_work["id_razdeel2"].'"');
        
		$num_results_custom_raz = $result_raz->num_rows;
        
		if($num_results_custom_raz!=0)
        {
			$row_raz = mysqli_fetch_assoc($result_raz);
		} 
			  
			   
			  
			   
			    $rrr++;
			   echo'<tr>
<td class=" bl  ll  right" >'.$rrr.'</td>
<td class="   ll  center" ><strong>'.$row_raz["razdel1"].'.'.$row_raz["razdel2"].'</strong></td>
<td class="   ll  " ><strong>'.$row_work["name_work"].'</strong></td>
<td class="   ll  center" ><strong>'.$row_work["units"].'</strong></td>
<td class="   ll  right" >'.number_format(($row_work["count_units"]), 2, ',', ' ').'</td>
<td class="   ll  right" >'.number_format(($row_work["price"]), 2, ',', ' ').'</td>
<td class="   ll br  right" ></td>
<td class="   ll  right" >'.number_format(($row_work["subtotal"]), 2, ',', ' ').'</td>
<td class="   ll br  right" ></td>
<td class=" br  ll  center" >';
if((($row_work['id_sign_mem']==0)and($row_work['signedd_mem']==0))or($row_work['id_sign_mem']!=0))
{
	echo'*';
}
echo'</td>

</tr>';
			   
//смотрим возможно служебная записка по работе
if((($row_work['id_sign_mem']==0)and($row_work['signedd_mem']==0))or($row_work['id_sign_mem']!=0))
{


$result_userss=mysql_time_query($link,'Select a.name_user,b.name_role from r_user as a,r_role as b where a.id_role=b.id and a.id="'.htmlspecialchars(trim($row_work['id_sign_mem'])).'"');	 
					   $num_results_userss = $result_userss->num_rows;
	                   if($num_results_userss!=0)
	                   {
                         $row_userss= mysqli_fetch_assoc($result_userss);	
						   
					   }
//узнаем кто такой кто согласовал служебную записку	
	
echo'<tr>
<td class=" bl  ll  right" ></td>
<td class="   ll  center" >*</td>
<td class="   ll br it ver_7 " colspan="5" >'.$row_work["memorandum"].'</td>
<td colspan="3" class=" br   ll it ver_7 " >Согласовано: '.$row_userss["name_user"].', '.$row_userss["name_role"].'</td>
</tr>';			   			   
}

//материалы вывовим
					   $result_mat=mysql_time_query($link,'Select a.*,a.count_units_material as count_seb,a.price_material as price_seb,a.count_units_material_realiz as count_realiz from n_material as a where a.id_nwork="'.$row_work["id"].'" order by a.id');				   
$num_results_mat = $result_mat->num_rows;
	                 if($num_results_mat!=0)
	                 {
		  
		               for ($mat=0; $mat<$num_results_mat; $mat++)
                        {  
                            $row_mat = mysqli_fetch_assoc($result_mat);
							$rrr++;
							echo'<tr>
<td class=" bl  ll  right" >'.$rrr.'</td>
<td class="   ll  center" ><strong></strong></td>
<td class=" right   ll  " >'.$row_mat["material"].'</td>
<td class="   ll  center" ><strong>'.$row_mat["units"].'</strong></td>
<td class="   ll  right" >'.number_format(($row_mat["count_units"]), 2, ',', ' ').'</td>
<td class="   ll  right" ></td>
<td class="   ll br  right" >'.number_format(($row_mat["price"]), 2, ',', ' ').'</td>
<td class="   ll  right" ></td>
<td class="   ll br  right" >'.number_format(($row_mat["subtotal"]), 2, ',', ' ').'</td>
<td class=" br  ll  center" >';
		if((($row_mat['id_sign_mem']==0)and($row_mat['signedd_mem']==0))or($row_mat['id_sign_mem']!=0))
{							
							echo'*';
	
}
								
echo'</td>

</tr>';
							
							//смотрим вдруг служебная записка
		if((($row_mat['id_sign_mem']==0)and($row_mat['signedd_mem']==0))or($row_mat['id_sign_mem']!=0))
{
	
$result_userss=mysql_time_query($link,'Select a.name_user,b.name_role from r_user as a,r_role as b where a.id_role=b.id and a.id="'.htmlspecialchars(trim($row_mat['id_sign_mem'])).'"');	 
					   $num_results_userss = $result_userss->num_rows;
	                   if($num_results_userss!=0)
	                   {
                         $row_userss= mysqli_fetch_assoc($result_userss);	
						   
					   }	
	
echo'<tr>
<td class=" bl  ll  right" ></td>
<td class="   ll  center" >*</td>
<td class="   ll br it ver_7 " colspan="5" >'.$row_mat["memorandum"].'</td>
<td colspan="3" class=" br   ll it ver_7 " >Согласовано: '.$row_userss["name_user"].', '.$row_userss["name_role"].'</td>
</tr>';			   			   
}					
							
							
							
							
						}
					 }
			   
		   }
			
		//вывод итогов	
echo'<tr>
<td class=" bl bb  ll br  right" colspan="7" >Итого:</td>
<td class=" bb  ll  right" >'.number_format(($row_list["summa_work"]), 2, ',', ' ').'</td>
<td class=" bb   ll br  right" >'.number_format(($row_list["summa_material"]), 2, ',', ' ').'</td>
<td class=" bb br  ll  center" ></td>

</tr>';
/*
echo'<tr>
<td class="   right" colspan="7" >Итого по наряду:</td>
<td class="  right" ></td>
<td class=" bl  ll br  right" >'.number_format(($row_list["summa_work"]+$row_list["summa_material"]), 2, ',', ' ').'</td>
<td class="  center" ></td>

</tr>';
*/				
			
echo'<tr>
<td class="   right" colspan="7" >В том числе НДС 18%</td>
<td class="  bb bl  ll  right" >'.number_format((($row_list["summa_work"])/1.18*0.18), 2, ',', ' ').'</td>
<td class=" bb  ll br  right" >'.number_format((($row_list["summa_material"])/1.18*0.18), 2, ',', ' ').'</td>
<td class="  center" ></td>

</tr>';			
			
			
		}
	
	

echo'<tr>
<td colspan="10">&nbsp;</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td colspan="8"><strong>Примечание:</strong></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td>Претензии к качеству произведенных работ:</td>
<td class=" ll" colspan="7">&nbsp;</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td>Претензии к нарушению сроков исполнения:</td>
<td class=" ll" colspan="7">&nbsp;</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td>Претензии к состоянию подъотчетного оборудования: </td>
<td class=" ll" colspan="7">&nbsp;</td>
</tr>
<tr>
<td colspan="10">&nbsp;</td>
</tr>
<tr>
<td colspan="10">&nbsp;</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td >Исполнитель</td>
<td class="nobottom" colspan="3"><strong>'.pad($row_list1["fio"],0).'</strong></td>
</tr>
<tr>
<td colspan="3"></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
<td ></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
</tr>

<tr>
<td colspan="2">&nbsp;</td>
<td colspan="8"><strong>От заказчика:</strong></td>
</tr>
<tr>
<td colspan="10">&nbsp;</td>
</tr>
<tr>';

if(($row_list['id_signed0']!=0)and($row_list['id_signed1']!=0)and($row_list['id_signed2']!=0))	
{
	//подписан - согласован - утвержден
$result_userss=mysql_time_query($link,'Select a.name_user,b.name_role from r_user as a,r_role as b where a.id_role=b.id and a.id="'.htmlspecialchars(trim($row_list['id_signed0'])).'"');	 
					   $num_results_userss = $result_userss->num_rows;
	                   if($num_results_userss!=0)
	                   {
                         $row_userss= mysqli_fetch_assoc($result_userss);	
						   
					   }
echo'<tr>
<td colspan="2">&nbsp;</td>
<td >Подписан</td>
<td class="nobottom" colspan="3"><strong>'.$row_userss["name_user"].'</strong>, <span class="upp">'.$row_userss["name_role"].'</span></td>
</tr>
<tr>
<td colspan="3"></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
<td ></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
</tr>';	
$result_userss=mysql_time_query($link,'Select a.name_user,b.name_role from r_user as a,r_role as b where a.id_role=b.id and a.id="'.htmlspecialchars(trim($row_list['id_signed1'])).'"');	 
					   $num_results_userss = $result_userss->num_rows;
	                   if($num_results_userss!=0)
	                   {
                         $row_userss= mysqli_fetch_assoc($result_userss);	
						   
					   }
echo'<tr>
<td colspan="2">&nbsp;</td>
<td >Согласован</td>
<td class="nobottom" colspan="3"><strong>'.$row_userss["name_user"].'</strong>, <span class="upp">'.$row_userss["name_role"].'</span></td>
</tr>
<tr>
<td colspan="3"></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
<td ></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
</tr>';	
$result_userss=mysql_time_query($link,'Select a.name_user,b.name_role from r_user as a,r_role as b where a.id_role=b.id and a.id="'.htmlspecialchars(trim($row_list['id_signed2'])).'"');	 
					   $num_results_userss = $result_userss->num_rows;
	                   if($num_results_userss!=0)
	                   {
                         $row_userss= mysqli_fetch_assoc($result_userss);	
						   
					   }	
echo'<tr>
<td colspan="2">&nbsp;</td>
<td >Утвержден</td>
<td class="nobottom" colspan="3"><strong>'.$row_userss["name_user"].'</strong>, <span class="upp">'.$row_userss["name_role"].'</span></td>
</tr>
<tr>
<td colspan="3"></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
<td ></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
</tr>';		
	
}
	
if(($row_list['id_signed2']==0))	
{
	//подписан - согласован - утвержден
$result_userss=mysql_time_query($link,'Select a.name_user,b.name_role from r_user as a,r_role as b where a.id_role=b.id and a.id="'.htmlspecialchars(trim($row_list['id_signed0'])).'"');	 
					   $num_results_userss = $result_userss->num_rows;
	                   if($num_results_userss!=0)
	                   {
                         $row_userss= mysqli_fetch_assoc($result_userss);	
						   
					   }
echo'<tr>
<td colspan="2">&nbsp;</td>
<td >Подписан</td>
<td class="nobottom" colspan="3"><strong>'.$row_userss["name_user"].'</strong>, <span class="upp">'.$row_userss["name_role"].'</span></td>
</tr>
<tr>
<td colspan="3"></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
<td ></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
</tr>';	

$result_userss=mysql_time_query($link,'Select a.name_user,b.name_role from r_user as a,r_role as b where a.id_role=b.id and a.id="'.htmlspecialchars(trim($row_list['id_signed1'])).'"');	 
					   $num_results_userss = $result_userss->num_rows;
	                   if($num_results_userss!=0)
	                   {
                         $row_userss= mysqli_fetch_assoc($result_userss);	
						   
					   }	
echo'<tr>
<td colspan="2">&nbsp;</td>
<td >Утвержден</td>
<td class="nobottom" colspan="3"><strong>'.$row_userss["name_user"].'</strong>, <span class="upp">'.$row_userss["name_role"].'</span></td>
</tr>
<tr>
<td colspan="3"></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
<td ></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
</tr>';		
	
}	
if(($row_list['id_signed1']==0))	
{
	//подписан - согласован - утвержден
$result_userss=mysql_time_query($link,'Select a.name_user,b.name_role from r_user as a,r_role as b where a.id_role=b.id and a.id="'.htmlspecialchars(trim($row_list['id_signed0'])).'"');	 
					   $num_results_userss = $result_userss->num_rows;
	                   if($num_results_userss!=0)
	                   {
                         $row_userss= mysqli_fetch_assoc($result_userss);	
						   
					   }
echo'<tr>
<td colspan="2">&nbsp;</td>
<td >Подписан</td>
<td class="nobottom" colspan="3"><strong>'.$row_userss["name_user"].'</strong>, <span class="upp">'.$row_userss["name_role"].'</span></td>
</tr>
<tr>
<td colspan="3"></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
<td ></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
</tr>';	

$result_userss=mysql_time_query($link,'Select a.name_user,b.name_role from r_user as a,r_role as b where a.id_role=b.id and a.id="'.htmlspecialchars(trim($row_list['id_signed2'])).'"');	 
					   $num_results_userss = $result_userss->num_rows;
	                   if($num_results_userss!=0)
	                   {
                         $row_userss= mysqli_fetch_assoc($result_userss);	
						   
					   }	
echo'<tr>
<td colspan="2">&nbsp;</td>
<td >Утвержден</td>
<td class="nobottom" colspan="3"><strong>'.$row_userss["name_user"].'</strong>, <span class="upp">'.$row_userss["name_role"].'</span></td>
</tr>
<tr>
<td colspan="3"></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
<td ></td>
<td colspan="3" valign="top" class="he"><div class="line"></div></td>
</tr>';		
	
}		

	
echo'</tbody>
</table>';	
	
	
//**************
//**************
//**************

?>

</body>
</html>