<style>
    .div_err , .div_ok {
    }
    .div_ved {
        display: none; /*block; none*/
        background: aliceblue;
    }  
    .div_itogo {
        display: table-row; /*block; none*/
        background: bottom;
    } 
    .mtable, .itable {
    background: #fff; /* Цвет фона таблицы */
    border: 3px double #000; /* Рамка вокруг таблицы */
    border-collapse: collapse;
   }
   TD, TH {
    padding: 4px; /* Поля вокруг текста */
    border: 1px solid #000; /* Рамка вокруг ячеек */
   }
    
</style>
<?php
$sys=$_SERVER['DOCUMENT_ROOT'];
include_once $sys."/ilib/lib_interstroi.php";
include_once $sys.'/ilib/Isql.php';
//include_once($sys."/sysadmin/module/tree/Tsql.php");

// define('ROUND00',2);   //Точность вычиления


function cons($log,$str) {   //log info warn error   ВЫВОД НА КОНСОЛЬ
?>    
  <script type="text/javascript">
  console.<?=$log?>("<?=$str?>");
  </script> 
  <?php
}
function echo_S($show, $str)
{
    if ($show) {
        echo $str;
    }
}
function InitArray(&$arr,$size) {
    for ($i=0;$i<$size;$i++)
    $arr[$i]=0.0;
}
function MakeArray(&$arr,$size) {
    for ($i=0;$i<$size;$i++)
    $arr[]=0.0;
}

function ROW_error(&$ROW_data) {
    return 'title="7='.$ROW_data[7].' 8='.$ROW_data[8].'"';
}
function ITOGO_error(&$ITOGO) {
    return 'title="0='.$ITOGO[0].' 1='.$ITOGO[1].' 2='.$ITOGO[2].'"';
}
//===============================================================================
class set_xlsx {
    private static $round__;        //int
    private static $nds__;          //int
    private static $nds_enable = array();       // array boolean
    private $row_razdel;
    private $run_type;
    private $RAZDEL;

private function GetFloat($cell)
{
    $type = $cell->getDataType();
    if ($type == 'n' || $type == 'f') {
        //$data_=round($data,2);
        $data = trim($cell->getCalculatedValue());
        $data_ = number_format(0.0 + $data, $this->round__ + 2, '.', '');
    } else {
        $data_ = null;
    }

    return $data_;
}

private function ROW_save(&$ROW_data,$NumColumn,$data,$count=null) {
    if ($data<>null && $data<>'' && $this->RAZDEL<>'') {
        if ($count<>null) {
            $ROW_data[$NumColumn]=$data*$count;
        }
        else
        $ROW_data[$NumColumn]=$data;
    }
}
private function SUMMA_save(&$SUMMA,$num,$data) {
    if ($this->RAZDEL<>'') {
            $SUMMA[$num] += $data;
    }
}
private function SUMMA_cmp($summa,$data,&$delta,$str='',$z=0) {
    $title='';
    $znak=array('∑','×','+','≠','<');   //0,1,2,3,4
    $summa_=number_format(0.0+$summa, 2, '.', '');
    $data_=number_format(0.0+$data, 2, '.', '');
    $delta=round(round($summa_,$this->round__)-$data_,$this->round__);          //$summa_ ROUND00
    if ($z==4 && $delta>0) $delta=0; //Контроль на непревышение
    
    if ($delta<>0 || $str<>'') {
        //$title= $str.' ('.$znak[$z].') ⊂='.$summa_.' ячейка='.$data_.' ∆='.$delta;
        $delta = round($summa-$data, $this->round__+2);
        //$delta=round(round($summa_,4)-$data_,4);
        $title= $str.' расч.('.$znak[$z].') ⊂='.$summa.' ячейка='.$data.' ∆='.$delta;
    }
    return $title;
}

private function Vedomost($name_razdel,&$SUMMA, $show) {
    if ($show) {
       $str='<tr id="ved" class="div_ved">'
               .'<td colspan="4">'.$this->RAZDEL
               .'<td colspan="6">'.$name_razdel
               .'<td align="right">'.number_format(0.0+$SUMMA[7], 2, '.', '')
               .'<td align="right">'.number_format(0.0+$SUMMA[8], 2, '.', '')
               .'<td align="right">'.number_format(0.0+$SUMMA[7]+$SUMMA[8], 2, '.', '')
               .'<td colspan="2">'
               .'</tr>';
       
       echo $str; 
    }
}
private function Vedomost_ITOGO(&$ITOGO, $show,$class="div_ved",$id="ved") { 
    if ($show) {
       $str='<tr id="'.$id.'" class="'.$class.'">'
               .'<td colspan="4">'
               .'<td colspan="6" align="right">'.'ВСЕГО ПО СМЕТЕ'
               .'<td align="right">'.number_format(0.0+$ITOGO[0], $this->round__, '.', '')
               .'<td align="right">'.number_format(0.0+$ITOGO[1], $this->round__, '.', '')
               .'<td align="right">'.number_format(0.0+$ITOGO[2], $this->round__, '.', '')
               .'<td colspan="2">'
               .'</tr>';
       $str.='<tr id="'.$id.'" class="'.$class.'">'
               .'<td colspan="4">'
               .'<td colspan="6" align="right">'."в т.ч. НДС $this->nds__%"
               .'<td align="right">'.number_format( 0.0+($ITOGO[0]) * $this->nds__ / (100+$this->nds__), $this->round__, '.', '')   
               .'<td align="right">'.number_format( 0.0+($ITOGO[1]) * $this->nds__ / (100+$this->nds__), $this->round__, '.', '') 
               .'<td align="right">'.number_format( 0.0+($ITOGO[2]) * $this->nds__ / (100+$this->nds__), $this->round__, '.', '')   //  /1.20*0.20
               .'<td colspan="2">'
               .'</tr>';
       
       //echo $str; 
    }
    return $str;
}
//Если $id_object - нужно сверять расчетные значения с базой 

private function Vedomost_ITOGO2(&$ITOGO, $show,$class="div_ved",$id="ved",$id_object=0) { 
    if ($show) {
       $str='<tr id="'.$id.'" class="'.$class.'">'
               .'<td colspan="4">'
               .'<td colspan="6" align="right">'.'ВСЕГО ПО СМЕТЕ'
               .'<td align="right">'.number_format(0.0+$ITOGO[0], $this->round__, '.', '')
               .'<td align="right">'.number_format(0.0+$ITOGO[1], $this->round__, '.', '')
               .'<td align="right">'.number_format(0.0+$ITOGO[2], $this->round__, '.', '')
               .'<td align="right">'.number_format(0.0+$ITOGO[3], $this->round__, '.', '')
               .'<td align="right">'.number_format(0.0+$ITOGO[4], $this->round__, '.', '')
               .'<td align="right">'.number_format(0.0+$ITOGO[3]+$ITOGO[4], $this->round__, '.', '')
               .'</tr>';
       $str.='<tr id="'.$id.'" class="'.$class.'">'
               .'<td colspan="4">'
               .'<td colspan="6" align="right">'."в т.ч. НДС $this->nds__%"
               .'<td align="right">'.number_format( 0.0+($ITOGO[0]) * $this->nds__ / (100+$this->nds__), $this->round__, '.', '')   
               .'<td align="right">'.number_format( 0.0+($ITOGO[1]) * $this->nds__ / (100+$this->nds__), $this->round__, '.', '') 
               .'<td align="right">'.number_format( 0.0+($ITOGO[2]) * $this->nds__ / (100+$this->nds__), $this->round__, '.', '')   

               .'<td align="right">'.number_format( 0.0+($ITOGO[3]) * $this->nds__ / (100+$this->nds__), $this->round__, '.', '')
               .'<td align="right">'.number_format( 0.0+($ITOGO[4]) * $this->nds__ / (100+$this->nds__), $this->round__, '.', '')
               .'<td align="right">'.number_format( 0.0+($ITOGO[3]+$ITOGO[4]) * $this->nds__ / (100+$this->nds__), $this->round__, '.', '')
               .'</tr>';
       
       //echo $str; 
    }
    return $str;
}

private function AddSumma(&$ITOGO,&$ROW_data) {
    /*$ITOGO[0]+=round($ROW_data[7],$this->round__);
    $ITOGO[1]+=round($ROW_data[8],$this->round__);
    $ITOGO[2]+=(round($ROW_data[7],$this->round__)+round($ROW_data[8],$this->round__));*/

    if ($this->is_run_show($this->RAZDEL,0) or $this->run_type==0) {
        //echo "<pre> ---RAZDEL=$this->RAZDEL </pre>";

    $ITOGO[0]+=$ROW_data[7];
    $ITOGO[1]+=$ROW_data[8];
    $ITOGO[2]+=$ROW_data[7]+$ROW_data[8];
    }
}
    private function is_run_load ($id_object,$R1,$R2) {
        if (($this->run_type==0 and $id_object>0)
            or ($this->run_type==1 and $this->row_razdel['razdel1']==$R1)
            or ($this->run_type==2 and $this->row_razdel['razdel1']==$R1 and $this->row_razde['razdel2']==$R2)
        ) {
            return true;
        } else return false;

    }

    private function is_run_show ($R1,$R2) {
        if (($this->run_type==1 and $this->row_razdel['razdel1']==$R1)
            or ($this->run_type==2 and $this->row_razdel['razdel1']==$R1 and $this->row_razdel['razdel2']==$R2)) { //выборочная подгрузка подраздела
            return true;
        } else return false;
    }

//$reload=false Предварительная загрузка
public function XLS_DB( $id_object, $id_r1, $id_r2, $reload, $FName, $sheet_find, $shablon, $show=false)    //Если $id_object==0 - это предварительная загрузка
{   cons("log","XLS_DB");
    if ($_POST["debug"]==true) {
        $DBG=true;
        cons("log","DEBUG XLS");
    } 
    echo_S($show,'<div class="div_info" id="info"> '
        .'<br>file='.$FName
        .'<br>sheet='.$sheet_find 
        .'<br>shablon='.$shablon
        .'<br> debug='.$_POST["debug"]   
        .'</div>');
$ret=0;  
$mysqli=new_connect(&$ret);
echo_S($show,'<div class="div_info" id="info"> '
        .'<br>mysqli ret='.$ret.' errno->'.$mysqli->errno.' error->'.$mysqli->error
        .'</div>');
if (!$mysqli->connect_errno) {   
    //echo $FN.'<p/>';
    //$FName=iconv("WINDOWS-1251","UTF-8",$FName);
    //echo '<p>'.$FName;
    if ($reload) {
        if ($id_object>0) {
            if (Delete_Data_object($mysqli, $id_object) === false) exit(-1);
        } elseif($id_r1>0) {
            if (Delete_Data_razdel1($mysqli, $id_r1) === false) exit(-1);
        } elseif($id_r2>0) {
            if (Delete_Data_razdel2($mysqli, $id_r2) === false) exit(-1);
        }
        // Нужно писать лог файл
        if (Update_File_object($mysqli,$id_object,$FName.' вкладка:'.$sheet_find)>1) exit(-2);
    }
    $url_system=$_SERVER['DOCUMENT_ROOT'].'/sysadmin/run/interstroi.atsun.ru/';
    require_once $url_system.'Classes/PHPExcel/IOFactory.php';
    
    $Codec = new codec("UTF-8","windows-1251");    //("UTF-8","windows-1251")
    $FName_=$Codec->iconv($FName);
    unset ($Codec);
    $Codec = new codec();            // Для перекодировки данных

$Key_RAZDEL='Раздел';
$Key_NotLoad = array ('Итого работа',      //0  [7]
                      'Итого материал',    //1  [8]
                      'ИТОГО по разделу',  //2  [9]
                      'XXСметная прибыль',   //3  [9]
                      'XXНакладные расходы', //4       Накладные расходы
                      'ВСЕГО ПО СМЕТЕ',    //5  ИТОГО
                      'XXприбыль',           //6
                      'в т.ч. НДС'        //7  18%
                      ,'в том числе НДС' //8
                      ,'Стоимость 1 м2'     //9
                      ,'Ориентировочная площадь квартир'//10
                      ,'Итого' //11
                      ,'итого' //12
                      );  
/*
$Key_Special = array (                                   
                        'З/п ИТР',
                        'з/п Рабочие',
                        'Накладные расходы',
                        'Доп. Работы',
                        'Электроэнергия',
                        'Техника аренда',
                        'Лизинги',
                        'Налоги'
                      );
*/
 $errtext=array(
    "Номер подраздела не равен разделу", //1
    "нет точки",                         //2    
    "нет номера подраздела",             //3
    "нет данных по количеству",          //4
    "суммы не равны",                   //5
    "единицы измерения не соответствуют сохраненным в базе",    //6
    "номер подраздела работы имеет вложенность для материала", //7
     "нет дополнительной вложенности для материалов", //8
     "нет точки в разделителе работ и материалов", //9
     "нет данных в подразделе", //10
     "не указаны единицы измерения" //11
 );

 if ($id_r2>0)  $this->run_type = 2;
 elseif ($id_r1>0) $this->run_type = 1;
 else $this->run_type = 0; // 0-полная, 1-раздел 2-подраздел

 if ($this->run_type>0) {
     switch ($this->run_type) {     //Получить информацию по заменяемому разделу (подразделу)
         case 1:
             $sql='SELECT * from i_razdel1 as i1, i_object as o where i1.id="' . $id_r1 . '"  and i1.id_object= o.id';
             break;
         case 2:
             $sql='SELECT * FROM i_razdel2 AS i2, i_razdel1 AS i1, i_object AS o WHERE i2.id="' . $id_r2 . '" AND i2.id_razdel1=i1.id  AND i1.id_object= o.id';
             break;
     }
     $Rzd = $mysqli->query($sql);
     if ($Rzd->num_rows > 0) {
         $this->row_razdel = $Rzd->fetch_assoc();
     } else exit(1);
     $select_show=false;
 }
 
$rtype = array ('работ','материалов');
//$okrugl=2;
$size_array=16;  // было 12 +4 было 10 добавил реализацию
$ITOGO=array(0,0,0,0,0);  //ПЛАН 7-работа 8-материалы 9-всего РЕАЛИЗАЦИЯ 10-работа 11-материалы 
$SUMMA=array();
$ROW_data=array();
MakeArray(&$SUMMA,$size_array);
MakeArray(&$ROW_data,$size_array);


//echo_S ($show, '<p/>Ключевое слово поиска раздела:'.$Key_RAZDEL);
error_reporting(E_ALL);

$Error=0;
if (!file_exists($FName_)) {
     echo '<p>'.$FName." - не найден.".'</p>';
     echo '<p>'.realpath('.').'</p>';
     $Error=-1;
}
else
 {

  //echo '<p>'.date('H:i:s') . " Load from Excel file - ".$FName.'</p>';
  $objReader = PHPExcel_IOFactory::createReader('Excel2007');     //Excel2007  //Excel5
  $objPHPExcel = $objReader->load($FName_);
  $Sheet=0;
  $DZ=date('Y-M-D H:i:s');
  //echo '<p>'.$DZ. " Перечитывание вкладок worksheets".'</p>';
  echo_S ($show,'<input type="hidden" name="sheet" value="'.$sheet_find.'" />');  //!!!!!!!!!!!!!!!!!!!!!!!!!!!
  
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
    $WS= $Codec->iconv($worksheet->getTitle());
    
    if ($sheet_find==$worksheet->getTitle()) {
        //$id_object=SQL_save_object(iconv("WINDOWS-1251","UTF-8",$FName));
        //if (!($id_object===false)) {
        {             
            //----------------------------------------------------------создать таблицу
            $CountColumn = PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn());
            echo_S ($show, '<div class="div_info" id="info"><br>Количество row/cell: '.$worksheet->getHighestRow().'/'.$CountColumn.'</div>' );    //Количество строк в закладке
            echo_S ($show,'<div id="excel">');   
            echo_S ($show, '<table cellspacing="0" align="left" class="mtable"><tr><td>');
            echo_S ($show, '<table cellspacing="0" align="left" class="mtable">');
            //$BG=' bgcolor="yellow"';
            $objPHPExcel->setActiveSheetIndex($Sheet);
            $sharedStyle1 = new PHPExcel_Style();                 //Стиль для чтения цвета ячейки
            $U1=0; $U2=0; $U3=0;
            $this->RAZDEL='';
            $R1='';
            $R2='';
            //--------------------------------------------------------прочитать шаблон
            $Begin_num_row=13;
            $Last_cell='P';
            $X_prog=array();
            
               $sql='select * from shablon_xls where id="'.$shablon.'"';
               // echo '<p/>'.$sql; 
                  if ($result = $mysqli->query($sql)) {
                      while( $row = $result->fetch_assoc() ){
                         //echo '<p/>'.$row['id'].'->'.$row['last_cell'];
                         $Begin_num_row=$row['begin_row'];
                         $Last_cell=$row['last_cell'];
                        // Значения по умолчанию для расчета сметы
                         $this->round__ = ($row['precision_']>0)?$row['precision_']:2;
                         $this->nds__ = ($row['nds']>0)?$row['nds']:20;
                         $this->nds_enable[0] = ($row['nds_work'] >= 0)? $row['nds_work'] : true;
                          $this->nds_enable[1] = ($row['nds_material'] >= 0) ? $row['nds_material'] : true;




                         
                         if ($result1 = $mysqli->query('select * from shablon_cell c, shablon_programm p
                                                        where c.id_shablon="'.$shablon.'"
                                                        and c.id_programm=p.id
                                                        order by cell_programm')) {
                            while( $row1 = $result1->fetch_assoc() ){
                                $key=$row1['cell'];
                                //if (array_search($key,array_keys($X_prog))===false) {
                                //    
                                //}
                                $X_prog[$key]=$row1['cell_programm'];
                                //echo '<p>'.$key.'=>'.$row1['cell_programm'];
 
                            }
                            $result1->close();  
                        } else echo '<p/>'.$result1;
                         
                      }
                      $result->close();  
                  } else { 
                    echo '<p/>'.$result;
                    $X_prog=array("A"=>"A","B"=>"B","C"=>"C","D"=>"D","E"=>"E","F"=>"F","G"=>"G","H"=>"H","I"=>"I","J"=>"J"
                        ,"K"=>"K","L"=>"L"
                        ,"M"=>"M","N"=>"N"
                        ,"O"=>"O","P"=>"P");
                  
                  }
                  //echo '<pre>'.print_r($X_prog,true).'</pre>';
            
    
        $REJIM=0;    //0-просто считывание строк, 1-раздел, 2-итоги раздела, 3-всего, 4-данные раздела
        
	    foreach ($worksheet->getRowIterator() as $row) {     //По строчкам
            $visible_row=$worksheet->getRowDimension($row->getRowIndex())->getVisible();
            if ($visible_row==false) continue;
            if ($row->getRowIndex()<$Begin_num_row) continue;
            //echo_S ($show, '<tr id="xls_err" class="div_err">'
            $htm='';

            //$BG=' bgcolor="yellow"';
            $name='';
            $inver='';
            $cena='';
            $type='';


            InitArray(&$ROW_data,$size_array);
            $load=true;
            $data_type=0;
            $razdel_row_yes=false;
            $row_num=count($Key_NotLoad);
            //$NumColumn=0;
            //$TekColumn=0;
            $ErrC=0; $error=0;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
		    foreach ($cellIterator as $cell) {              //По столбцам
                    //$TekColumn++;
                    if ($error>0)$ErrC=$error;
		            $error=0;
                    $delta=0;
                    $frm_date=false;
                    //$col=echo $excel->getActiveSheet()->getStyle($cell)->getFill()->getStartColor()->getRGB();
                    //$cell_data=iconv("UTF-8","windows-1251//IGNORE", $cell->getCalculatedValue()) ; 
                    //$Merge=$cell->isInMergeRange();
                    $data=$Codec->iconv(trim($cell->getCalculatedValue()));
                    $data_=$data; 
                    $title=''; $titleR='';
                    //$nColumn = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
                    if (    PHPExcel_Cell::columnIndexFromString($cell->getColumn())>
                            PHPExcel_Cell::columnIndexFromString($Last_cell)) { 
                      if ($ErrC==1 or $ErrC > 4 ) {
                             $ide='id="xls_err" class="div_err"';
                      } else $ide='id="ok" class="div_ok"';
                      if ($REJIM==1) {                 //Для Вывода раздела
                          if ($R2=='' || $load==false) $htm0  = '<td>';
                          else $htm0  = $htm0.$R1.'.'.$R2;
                      } else $htm0  = '<td>'; 
                      if($ErrC>0) 
                          { $ErrC='<a title="'.$errtext[($ErrC-1)].'">'. $ErrC .'</a>'; }
                      $htm = '<tr '.$ide.'>'
                              .'<td>'. $row->getRowIndex()
                              .'<td>'. $this->RAZDEL
                              .$htm0
                              .$htm
                              .'<td><a title="ErrC">'.$ErrC.'</a>'
                              .'<td><a title="REJIM">'.$REJIM.'</a>'
                              .'<td><a title="data_type">'.$data_type.'</a>'
                              .'</tr>';                     //последний столбец - ErrC



                      if ($this->run_type==0 or $REJIM==0 or $this->is_run_show($this->RAZDEL,$R2))  echo_S($show,$htm);


                            $htm0='';
                      $R1=$R2=$R3='';
                      break;   //Отсечка по правому краю
                    }
                    $NumColumn=array_search($cell->getColumn(),array_keys($X_prog));
                    if ($NumColumn===false) { //Нет такого ключа?
                        continue;    //По шаблону ячейка не рассмотривается
                    }        
                    //$NumColumn=array_search($X_prog[$cell->getColumn()],array_keys($X_prog));
                    //$ic=iconv("UTF-8", "WINDOWS-1251",$X_prog[$cell->getColumn()]);
                    $ic=mb_substr(iconv("UTF-8", "WINDOWS-1251",$X_prog[$cell->getColumn()]), 0, 1);
                    //$ic1=0+ord($ic);
                    //$ic=(integer)ord($ic);
                    //var_dump($ic,$ic1,$ic2);
                    //echo '<p/>'.$X_prog[$cell->getColumn()].'-'.$ic.'-'.$ic1.'-'.$ic2;
                    //$NumColumn=0+(integer)(utf8_decode($X_prog[$cell->getColumn()]))-(integer)(utf8_decode('A')) ;  
                    $NumColumn=(integer)ord($ic)-65;  
                    ////echo '<p/>'.$row->getRowIndex().'->'.$NumColumn.'-'.$cell->getColumn().'-'.$X_prog[$cell->getColumn()];
                    //--------------------------------------Стиль ячейки
                    $sharedStyle=$objPHPExcel->getActiveSheet()->getStyle($cell->getColumn().$cell->getRow());
                    $ali=$sharedStyle->getAlignment()->getHorizontal();
                    if ($ali=='right') {    //['horizontal']
                        $align='align="right"';
                    } elseif ($ali=='center') { 
                        $align='align="center"';
                    } else { $align='align="left"'; }
                    $realiz_type=-1;
                    $visible_column=$worksheet->getColumnDimension($cell->getColumn())->getVisible();
                    switch ($X_prog[$cell->getColumn()])               //-------------------Первичный разбор - Формирование таблицы HTML
                    {
                      case 'A': 
                          //поиск .
                        $FColor='yellow';
                        if ($data<>'') {  
                          $tpos=strpos($data,'.');
                          if(!($tpos===false)) {
                            $R1=0+Substr($data,0,$tpos);
/*                            if ($this->run_type>0 and $this->RAZDEL<>$this->row_razdel['razdel1']) {  //выборочная подгрузка
                                  $select_show = false;
                                  break 2;
                            }
                            $select_show = true;*/
                            if ($R1<>$this->RAZDEL) {
                              $FColor='red';
                              $error=1; //Номер в подразделе не равен разделу
                            }
                            $R2=Substr($data,$tpos+1);
/*                            if ($this->run_type==2 and $R2<>$this->row_razdel['razdel2']) { //выборочная подгрузка подраздела
                                $select_show = false;
                                  break 2;
                            }*/

                          } else {
                              
                              $error=2;  //нет точки
                          }
                        } else { $error=3;}  //нет номера подраздела (но может быть это не подраздел)
                        $htm0  = '<td bgcolor="'.$FColor.'">';

                        break;
                      case 'B':   //Наименование работ, разделов, материалов
                        $pos=mb_strpos(mb_strtolower($data, 'UTF-8'),mb_strtolower($Key_RAZDEL, 'UTF-8'));                                 //mb_strtolower(
                        $ali_B=$ali;                        //Признак материалов
                        if ((!($pos===false) && $pos<6)) {  //--------------------------------это строка раздела
                            if ($REJIM>0) {   //Идет смена раздела
                               $this->Vedomost($this->RAZDEL,$name_razdel,&$SUMMA,$show);
                            }
                            $REJIM=1;
                            $this->RAZDEL=0+substr($data,$pos+strlen($Key_RAZDEL));

                            $title=mb_strtolower($Key_RAZDEL, 'UTF-8');
                            $R1='';
                            $R2='';
                            InitArray(&$SUMMA,$size_array);
                            $name_razdel=Get_Name_Razdel(substr($data,$pos+strlen($Key_RAZDEL)));
                            if ($reload) {  // или все разделы или только выборочный раздел
                                if ($id_object>0 or ($id_r1>0 and $this->row_razdel['razdel1']==$this->RAZDEL)) {
                                    $id_razdel1 = SQL_insert_razdel($mysqli, $id_object, $this->RAZDEL, $name_razdel);
                                }
                            }
                            $razdel_row_yes=true;
                        } else {
                           for ($row_num=0; $row_num<count($Key_NotLoad); $row_num++) { //Row_num - номер специальной строки
                              if (!(mb_strpos(mb_strtolower($data, 'UTF-8'),mb_strtolower($Key_NotLoad[$row_num], 'UTF-8'))===false)) {
                                  $load=false;
                                  $title=mb_strtolower($Key_NotLoad[$row_num], 'UTF-8');
                                  break;
                              }
                           } 
                        }
                        
                             
                        $this->ROW_save(&$ROW_data,$NumColumn,$data);
                        //$title=ROW_error(&$ROW_data);
                        //$title=ITOGO_error(&$ITOGO);
                        break;
                      case 'C': // 2 исполнитель  
                      case 'D': // 3 единицы
                          //-----------------------проверить материал на складе и соответствие единиц измерения
                          //..................
                         $this->ROW_save(&$ROW_data,$NumColumn,$data);
                         if ($R2!='' && $data=='') $error=11;
                          break;
                      case 'E': //4 кол-во
                      case 'F': //5 стоимость работы   
                      case 'G': //6 стоимость материалов    
                          $data_=$this->GetFloat($cell);
                          $this->ROW_save(&$ROW_data,$NumColumn,$data);
                          break;
                      /*
                      case 'F': //5 стоимость работы
                          //$num=7;
                          $data_=$this->GetFloat($cell);
                          $this->ROW_save(&$ROW_data,$NumColumn,$data); //ok
                          //$this->ROW_save(&$ROW_data,$num,      $data,$ROW_data[4]);
                          //$this->SUMMA_save(&$SUMMA,$num,$ROW_data[$num]);
                          //$title=ROW_error(&$ROW_data);
                          //$title=ITOGO_error(&$ITOGO);
                          break;
                      case 'G': //6 стоимость материалов
                          $num=8;
                          $data_=$this->GetFloat($cell);
                          $this->ROW_save(&$ROW_data,$NumColumn,$data);
                          $this->ROW_save(&$ROW_data,$num,      $data,$ROW_data[4]);
                          $this->SUMMA_save(&$SUMMA,$num,$ROW_data[$num]);
                          //$title=ROW_error(&$ROW_data);
                          //$title=ITOGO_error(&$ITOGO);
                          
                          break;
                      */
                      case 'H': //7 Цена работа
                      case 'I': //8 Цена материалы 
                        if ($REJIM>0) {  
                          if ($load) {
                              if ($this->RAZDEL!=100) {
                                $this->ROW_save(&$ROW_data,$NumColumn,$ROW_data[$NumColumn-2],$ROW_data[4]);   //сохранить рассчитанное значение
                          
                                $this->SUMMA_save(&$SUMMA,$NumColumn,$ROW_data[$NumColumn]);
                                $title = $this->SUMMA_cmp($ROW_data[$NumColumn],$data,&$delta,'',1);    //Сравнение произведения 4*5 4*6
                              }    
                          } elseif ($row_num<count($Key_NotLoad) ) {
                                  switch ($row_num) {       //Дополнительная проверка 
                                    case 0:      //итого работы (по разделу)
                                    case 1:      //итого материалы (по разделу)  
                                    case 2:      //итого по разделу 
                                        if ($data>'')
                                            $title = $this->SUMMA_cmp($SUMMA[$NumColumn],$data,&$delta,$Key_NotLoad[$row_num].':',0);
                                            break;
                                    case 5:      //Всего по смете
                                            $title = $this->SUMMA_cmp($ITOGO[$NumColumn-7],$data,&$delta,$Key_NotLoad[$row_num].':',0);
                                            break;
                                  }
                                  $this->ROW_save(&$ROW_data,$NumColumn,$data);
                          }          
                        }  
                          break;
                      case 'J': //9 Сумма   --------------------------------------------------------------
                          
                          $data_=$this->GetFloat($cell);
                          if($ROW_data[4]<>null) {          //Строка с данными
                            
                            if ($ROW_data[5]>0 && $ROW_data[6]>0) {
                                $cmp_data=round($ROW_data[7],$this->round__)+round($ROW_data[8],$this->round__);
                                $data_type=1;
                                $coment='работы и материалы';
                            } elseif($ROW_data[5]>0){  //Строка с работой
                                $cmp_data=$ROW_data[7];
                                $data_type=2;
                                $coment='работы';
                            } elseif($ROW_data[6]>0){ //строка с материалами
                                $cmp_data=$ROW_data[8];
                                $data_type=3;
                                $coment='материалы';
                            } else {                 //все по нулям
                                $cmp_data=0;
                                if ($ali_B=='right') {
                                    $data_type=5;
                                    $coment='материалы - пусто';
                                } else {
                                    $data_type=4;
                                    $coment='работы - пусто';
                                }
                            }           
                            $title=$this->SUMMA_cmp($cmp_data,$data,&$delta,$coment,2);   //плюс по горизонтали
                            //$error=0;
                          }
                          elseif($this->RAZDEL==100) {   //Спецраздел Загрузка данных общими суммами как РАБОТЫ
                            $data_type=6; 
                            if ($load) {   //НДС 
                                $this->ROW_save(&$ROW_data,7,$data);
                                $this->SUMMA_save(&$SUMMA,7,$ROW_data[7]);
                                $title=$this->SUMMA_cmp($ROW_data[7],$data,&$delta,"Oбщей суммой (р100)",3);
                            }
                            //$load=true;
                          } //else $error=4;           //нет данных по количеству
                          switch ($data_type) {    // Дополнительный разбор номера подраздела по типу данных
                              case 0:          // не определен тип
                                  if ($R2!='') $error=10; // нет данных в подразделе
                                  break;
                              case 1:  // работы и материалы
                              case 2:  // работы
                                  if  (ctype_digit($R2)==false) { //Видимо есть точка, это неправильно по любому
                                     $error=7;
                                  }
                                  break;
                              case 3:  // материалы
                                  if  (ctype_digit($R2)) { //Нет дополнительной вложенности для материалов
                                      $error = 8;
                                  } else {
                                      if (is_numeric($R2)==false) {  //нет точки в разделителе работ и материалов
                                          $error = 9;
                                      } else {  //Переопределить R2 и R3
                                        $R3 = get_R3 (&$R2);
                                      }
                                  }
                                  break;
                              case 4:  // все по нулям - определить это работа или материалы по R2
                              case 5:
                                  if (ctype_digit($R2)==true) { //только цифры - это работы
                                      $data_type = 2;
                                  } else {
                                      if (is_numeric($R2)==false ) { //нет точки в разделителе работ и материалов
                                          $error = 9;
                                      } else {  //Переопределить R2 и R3
                                          $data_type = 3;
                                          $R3 = get_R3 (&$R2);
                                      }
                                  }
                                  break;
                          }

                          $this->ROW_save(&$ROW_data,$NumColumn,$data);
                          //echo "<p/>J $R1.$R2 data_type=$data_type";
                          break;
                        case 'L': // Реализация материалов  
                            $realiz_type=0;
                        case 'K': // Реализация работ 
                             $realiz_type++;
                            if (($load) && ($REJIM>0))
                            if (($data_type==1) || ($data_type==2) || ($data_type==3) || ($data_type==6))
                            if ($data>0) {
                                $cmp_data=$ROW_data[$NumColumn-3];
                                $coment="Реализация".$rtype[$realiz_type];
                                $titleR=$this->SUMMA_cmp($cmp_data,$data,&$delta,$coment,4);
                                $this->ROW_save(&$ROW_data,$NumColumn,$data);
                            }
                            //echo "<p/> ".$X_prog[$cell->getColumn()]." $R1.$R2 data_type=$data_type";
                            break;
                        case 'M':  // реализация работ - количество
                             $this->ROW_save(&$ROW_data,$NumColumn,$data);
                            break;
                        case 'N':  // реализация материалов - количество
                             $this->ROW_save(&$ROW_data,$NumColumn,$data);
                            break;
                        case 'O':  // начало работ 
                        case 'P':  // окончание работ
                             if ($data>0) {
                             $this->ROW_save(&$ROW_data,$NumColumn,$data);
                             $ROW_data[$NumColumn] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($ROW_data[$NumColumn]));
                             $frm_date=true;
                             
                             }
                            break;
                    }

                    $X_column =  $X_prog[$cell->getColumn()];  //Вторичный разбор для НДС по работам и материалам
                    if (($X_column=='H' || $X_column=='I') && $error==0 ) { // H=7 I=8- итого работы/материалы
                        if ($load == false) {
                            $X_number = ($X_column=='H') ? 0:1;    //Номер в массиве SUMMA
                            if ($delta == 0)          //Чтобы не было вторичного наложения title
                                switch ($row_num) {       //Дополнительная проверка строк исключенных их подгрузки и формирование title
                                    case 7: //НДC номера исключений (совпали)
                                    case 8:
                                        if ($REJIM==3) {
                                            $nds=($ITOGO[($X_number)]) * $this->nds__ / (100+$this->nds__);
                                            $PO= 'смете';
                                        } else {
                                            $nds = $SUMMA[$X_number+7] * $this->nds__ / (100+$this->nds__);     //$SUMMA[7]+$SUMMA[8]
                                            $PO= 'разделу';
                                        }
                                        if ($this->nds_enable[$X_number]==false) $nds=0;   // Не стоит флаг учета НДС

                                        $title=$this->SUMMA_cmp($nds,$data,&$delta,$Key_NotLoad[7]." $this->nds__% по ".$PO.':',3); //$row_num
                                        break;
                                }
                        }
                    }


                    if ($X_prog[$cell->getColumn()]=='J' && $error==0 ) { //9-сумма        //Вторичный разбор по сумме
                      if ($load==false) {  
                        if  ( $delta==0)          //Чтобы не было вторичного наложения title
                        switch ($row_num) {       //Дополнительная проверка строк исключенных их подгрузки и формирование title
                            case 0:      //итого работы
                                $title=$this->SUMMA_cmp($SUMMA[7],$data,&$delta,$Key_NotLoad[$row_num].':',0);
                                break;
                            case 1:      //итого материалы
                                $title=$this->SUMMA_cmp($SUMMA[8],$data,&$delta,$Key_NotLoad[$row_num].':',0);
                                break;
                            case 2:      //итого по разделу
                                $REJIM=2;
                                $title=$this->SUMMA_cmp($SUMMA[7]+$SUMMA[8],$data,&$delta,$Key_NotLoad[$row_num].':',0);
                                break;
                            case 3: 
                            case 4:      //накладные   ZZZZ
                                break;
                            case 5:      //Всего по смете
                                $title=$this->SUMMA_cmp($ITOGO[2],$data,&$delta,$Key_NotLoad[$row_num].':',0);
                                $REJIM=3;
                                break;
                            case 6:      //прибыль
                                break;
                            case 7:      //НДC
                            case 8:    
                                if ($REJIM==3) {
                                    $nds = ($this->nds_enable[0]==false) ? 0 : $ITOGO[0];
                                    $nds += ($this->nds_enable[1]==false) ? 0 : $ITOGO[1];
                                    //$nds=($ITOGO[2]) * $this->nds__ / (100+$this->nds__);
                                    $PO= 'смете';
                                } else {
                                    $nds = ($this->nds_enable[0]==false) ? 0 : $SUMMA[7];
                                    $nds += ($this->nds_enable[1]==false) ? 0 : $SUMMA[8];
                                    $PO= 'разделу';
                                    
                                }
                                $nds=$nds * $this->nds__ / (100+$this->nds__);
                                $title=$this->SUMMA_cmp($nds,$data,&$delta,$Key_NotLoad[7]." $this->nds__% по ".$PO.':',3); //$row_num
                                break;
                            case 9: //Стоимость 1 м2
                                break;
                            default : break;
                        }
                      } else $this->AddSumma(&$ITOGO,&$ROW_data); //Суммировать те, которые грузить
                        
                    }                   //-------------------------------------------Запись в базу
                    $id_stock=0;
                    if ($cell->getColumn() == $Last_cell && $error==0 && $load==true && $razdel_row_yes==false && isset($id_razdel1)) { //9-сумма  Запись в базу
                       if ($reload && $this->is_run_load($id_object,$R1,$R2)) {
                        //echo "<p/> $R1.$R2 data_type=$data_type id_razdel1=$id_razdel1";
                        switch ($data_type) {
                           case 1:                 //И работы и материалы
                               $id_razdel2 = SQL_insert_work($mysqli, $id_razdel1, $R1, $R2, &$ROW_data, $title);
                               //----------------------------------------поиск материала на складе
                               $id_stock = SQL_find_stock($mysqli, $ROW_data[1], $ROW_data[3]); //-1 0 >0
                               if ($id_stock < 0) $error = 6;
                               SQL_insert_material($mysqli, $id_razdel2, $R1, $R2, 0, &$ROW_data, $title, $id_stock);
                               break;
                           case 2:                 //работы
                               $id_razdel2 = SQL_insert_work($mysqli, $id_razdel1, $R1, $R2, &$ROW_data, $title);
                               break;
                           case 3:                 //материалы
                               $id_stock= SQL_find_stock($mysqli, $ROW_data[1], $ROW_data[3]); //-1 0 >0
                               if($id_stock<0)$error=6;
                               SQL_insert_material($mysqli,$id_razdel2,$R1,$R2,$R3,&$ROW_data,$title,$id_stock);
                               break;
                           case 4: //работы пусто
                               $id_razdel2=SQL_insert_work($mysqli,$id_razdel1,$R1,$R2,&$ROW_data,$title);
                               break;
                           case 5: //материалы пусто
                               $id_stock= SQL_find_stock($mysqli, $ROW_data[1], $ROW_data[3]); //-1 0 >0
                               if($id_stock<0)$error=6;
                               SQL_insert_material($mysqli,$id_razdel2,$R1,$R2,$R3,&$ROW_data,$title,$id_stock);
                               break;
                           
                           case 6:                 //спецраздел
                               //echo "<p/> 100: data_type=$data_type id_razdel1=$id_razdel1";
                               $id_razdel2=SQL_insert_work($mysqli,$id_razdel1,$R1,$R2,&$ROW_data,$title);//////
                               break;
                        }
                       }
                    }
                    if ($delta<>0)$error=5;    //суммы не равны
                    
                    
                    
                    $FName =$sharedStyle->getFont()->getName();
                    $FSize =$sharedStyle->getFont()->getSize();
                    $FColor=$sharedStyle->getFont()->getColor()->getRGB();
                    $FBold=$sharedStyle->getFont()->getBold();
                    //if ($FSize>0)   $size='size="'.$FSize.'"'; else  //12 - Очень большой
                    $size='';
                    if ($FName<>'') $face='face="'.$FName.'"'; else $face='';
                    if ($load==false)$FColor='white';
                    if ($error>0 && $NumColumn==9)$FColor='yellow';
                    if ($FColor<>'')$color='color="'.$FColor.'"'; else $color='';
                    $font="<font $face $size $color>";
                    IF ($FBold) { $bold='<b>'; $bold_='</b>'; }
                    else { $bold=''; $bold_=''; }
                    //-----------------------------------------------------backgrount
                    $colorE=$sharedStyle->getFill()->getStartColor()->getRGB();
                    if ($id_stock==-1 || ($error>0 && $error != 2 && $error != 3) ) $colorE ='darkred';
                    if ($delta<>0) $colorE ='darkred';
                    elseif ($title=='' && $NumColumn==9 && $data<>'') $colorE='lightgray';
                    elseif ($load==false) $colorE = 'blue';                          //light
                    elseif ($visible_row==false || $visible_column==false) $colorE = 'lightgray';
                    
                    /*
                    if (($error==6) ) {  //&& ($NumColumn==3)
                       $titleR="единицы измерения не соответствуют сохраненным в базе"; 
                       $colorE ='green';
                    }
                    */
                    
                    if ($colorE=='000000') $bgcolor='';
                    else $bgcolor='bgcolor="'.$colorE.'"';
                    
                    $type=$cell->getDataType();
                    if (($frm_date)&& ($REJIM>0)) { 
                        $data_show=$ROW_data[$NumColumn];
                        /*   
                        $titleR="NC=$NumColumn ";   
                        for ($f=0;$f<count($ROW_data);$f++) {    //Отладка
                             $titleR.=";$f=".$ROW_data[$f];
                        }
                         */
                    }
                    elseif (($type=='n' || $type=='f')
                         && ($REJIM>0)) $data_show=number_format(0.0+$data, 2, '.', '');  //Форматированные числа $data_
                    else $data_show=$data; 
                    
                    if ($titleR<>'')$title=$titleR;
                    if ($title=='') $tdata=$data_show;
                    else $tdata='<a title="'.$title.'">'. $data_show .'</a>';
                    $htm.='<td '.$align.' '.$bgcolor.'>'
                               .$font.$bold
                                .$tdata
                                .$bold_.'</font>' ; 
                    continue;           
                    //--------------------------------------------------------------------------------------------
	        } //for cell
	    } //row
            if ($REJIM>0) {   //последний раздел
                $this->Vedomost($name_razdel,&$SUMMA,$show);
                if ($show)
                echo $this->Vedomost_ITOGO(&$ITOGO, $show);
            }
	    echo_S ($show,  '</table></div>');
        } // id_object   
    }  //sheet
    $Sheet++;
  }
  //echo_S ($show, '</div>');
  echo_S ($show,  //'<br/><p>'.'<div style="word-wrap: break-word; overflow-wrap: break-word;">'
           '</tr><tr><td><table class="itable">'
          
             .'<tr id="itogo" class="div_itogo">'
               .'<th colspan="10">'
               .'<th colspan="3">План'
               .'<th colspan="3">Реализация'
               .'</tr>'
              
               .'<tr id="itogo" class="div_itogo">'
               .'<th colspan="4">'
               .'<th colspan="6">'.'Наименование'
               .'<th>Работы'
               .'<th>Материалы'
               .'<th>Итого'
               .'<th>Работы'
               .'<th>Материалы'
               .'<th>Итого'
               .'</tr>'
               //.$itable
          .$this->Vedomost_ITOGO2(&$ITOGO, $show,'div_itogo','itogo')
                .'</table></div></p>');
  // Echo memory peak usage
  echo_S ($show,  '</<tr><tr><th>'.date('H:i:s')." Обновление ОК!, Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB".'</tr></table>');
 }

} 
$mysqli->close();
}
} // class

function XLS_DB($id_object, $id_r1, $id_r2, $reload, $FName, $sheet_find, $shablon, $show = false)
{
    $xDB = new set_xlsx;
    echo "<pre>id_object=$id_object, id_r1=$id_r1, id_r2=$id_r2, reload=$reload</pre>";
    $xDB->XLS_DB($id_object, $id_r1, $id_r2, $reload, $FName, $sheet_find, $shablon, $show);
}


function ved_int($digit, $width_, $SIM='0')
{
    while(strlen($digit) < $width_)
      $digit = $SIM.$digit;
    return $digit;
}

function get_R3(&$data) {

    $R3='';
    if ($data<>'') {
        $tpos = strpos($data, '.');
        if (!($tpos === false)) {
            $R2 = 0 + Substr($data, 0, $tpos);
            $R3 = 0 + Substr($data, $tpos + 1);
            $data = $R2;
        }
    }
    return $R3;
}
//===============================================================================
/*
function SQL_save_object($str){
    //$name=urlencode($str);
    //заменить \ на \\
    $name=str_replace('\\','\\\\',$str);
    $error=false;
    //----------------------------------поиск такого объекта
    
    $sql='select id from i_object where file_name="'.$name.'"';
    
    $res=mysql_query($sql);
    $num_results = mysql_num_rows($res);
        
    echo "$sql -> $num_results<p/>"; 
    if($num_results>0) {
        //----------------------------------если есть - вопрос о перезаписи
        echo "ПЕРЕЗАПИСЬ объекта: ".$name."<p/>";
        //----------------------------------удалить объект 
        $sql='delete from i_object where file_name="'.$name.'"';
        $res=mysql_query($sql);
        $arows=mysql_affected_rows();
        if (!($res==TRUE && $arows==1)) {
           echo "ОШИБКА: $SQL -> $res:$arows<p/>";  
           $error=true;
        }
    }
    $id=false;
    if ($error==false) {    
        //----------------------------------добавить новый объект

        $sql="insert into i_object (file_name) values ('$name')";
        $res=mysql_query($sql);
        $arows=mysql_affected_rows();
        if ($res==TRUE && $arows==1) {
            $id=mysql_insert_id();
        }
        else echo "$sql -> $res<p/>"; 
    }    
    return $id;
}
 * 
 */
function SQL_insert_razdel($mysqli, $id_object,$razdel1,$name1) {  //Возврат 0 или id
        $sql='insert into i_razdel1 (id_object,razdel1,name1)'
                                    . 'values ('
                                    ."'$id_object',"
                                    ."'$razdel1',"
                                    ."'".$mysqli->real_escape_string($name1)."'"
                                    . ')';  
        
        return iInsert_1R($mysqli,$sql);
}
function Get_Name_Razdel($str) {
    $name=$str;
    $tpos=strpos($str,'.');
    if($tpos===false) {
        $tpos=strpos($str,' ');
        if(!($tpos===false)) $name=trim(mb_substr($str, $tpos+1));
    } else $name=trim(mb_substr($str, $tpos+1));
    return $name;
}
function SQL_insert_work($mysqli,$id_razdel1,$R1,$R2,&$ROW_data,$title){   //not title
    $id=0;
    if (!($id_razdel1==0)) {
        //-----------------------------------------Поиск исполнителя
        if ($ROW_data[2]<>null && $ROW_data[2]<>'') {
            $id_implementer=SQL_find_implementer($mysqli,$ROW_data[2]);
            if ($id_implementer==0) $id_implementer=false;               //Не найден
        } else $id_implementer=null;                                //Нет в смете
        
        if (!($id_implementer===false)) {
            if ($R1<>100) { 
            $sql='insert into i_razdel2 (id_razdel1,razdel1,razdel2,name_working,id_implementer,units,count_units,price,title,summa_r2_realiz,count_r2_realiz,date0,date1)'
                                        . 'values ('
                                        ."'$id_razdel1',"
                                        ."'$R1',"
                                        ."'$R2',"
                                        ."'".$mysqli->real_escape_string($ROW_data[1])."',"
                                        ."'$id_implementer',"
                                        ."'$ROW_data[3]',"
                                        ."'$ROW_data[4]',"
                                        ."'$ROW_data[5]',"
                                        ."'$title',"
                                        ."'$ROW_data[10]',"
                                        ."'$ROW_data[12]',"                    
                                        .DataNull($ROW_data[14],'null').","
                                        .DataNull($ROW_data[15],'null')
                                        . ')';      
            } else {
            $sql='insert into i_razdel2 (id_razdel1,razdel1,razdel2,name_working,id_implementer,units,count_units,price,title,summa_r2_realiz,count_r2_realiz,date0,date1)'
                                        . 'values ('
                                        ."'$id_razdel1',"
                                            ."'$R1',"
                                        ."'$R2',"
                                        ."'".$mysqli->real_escape_string($ROW_data[1])."',"
                                        ."'$id_implementer',"
                                        .DataNull($ROW_data[3]).","
                                        .DataNull($ROW_data[4],'1').","
                                        ."'$ROW_data[7]',"
                                        ."'$title',"
                                        ."'$ROW_data[10]',"
                                        ."'$ROW_data[12]',"                    
                                        .DataNull($ROW_data[14],'null').","
                                        .DataNull($ROW_data[15],'null')                    
                                        . ')';  
            }
            $id=iInsert_1R($mysqli,$sql); 

        }
    }
    return $id;
}
function DataNull($data,$d2='') {
                if ($data==0 && $data=='' && $data==null) $ret=$d2;
                else $ret= $data;
                if ($ret!='null') $ret="'".$ret."'";
                return $ret;
}
// 0 - нет 
// -1 - Не сходятся единицы исчисления
function SQL_find_stock($mysqli,$name,$units){
    $id=0;
    //----------------------------------поиск 
    $sql='select id,units from z_stock where name="'.$mysqli->real_escape_string($name).'"';
    $res=$mysqli->query($sql);
    if ($res->num_rows>0) {        //-----Уже есть на складе
        $row = $res->fetch_assoc();
        $id=$row['id'];
        if ($row['units']<>$units) {
            $id=-1;     //Не сходятся единицы исчисления
            //окно подтверждения - изменить в смете, изменить на складе, добавить новую позицию
        }
    } else {                       //-----Добавить материал на склад
        $id=SQL_insert_stock($mysqli,$name,$units); 
    }
    return $id;
}
function SQL_insert_stock($mysqli,$name,$units){
        $sql='insert into z_stock (name,units)'
                                    . 'values ('
                                    ."'".$mysqli->real_escape_string($name)."',"
                                    ."'$units'"
                                    . ')';  
        return iInsert_1R($mysqli,$sql);
}
function SQL_find_implementer($mysqli,$name){
    $id=0;
    //----------------------------------поиск 
    $sql='select id from i_implementer where implementer="'.$name.'"';
    $res=$mysqli->query($sql);
    if ($res->num_rows>0) {        //-----Уже есть исполнитель
        $row = $res->fetch_assoc();
        $id=$row['id']; 
    } else {                       //-----Добавить исполнителя
        $id=SQL_insert_implementer($mysqli,$name); 
    }
    return $id;
}
function SQL_insert_implementer($mysqli,$name){
        $sql='insert into i_implementer (implementer)'
                                    . 'values ('
                                    ."'$name'"
                                    . ')';  
        return iInsert_1R($mysqli,$sql);
}
function SQL_insert_material($mysqli,$id_razdel2,$R1,$R2,$R3,&$ROW_data,$title,$id_stock){
    $id=0; 
    if (!($id_razdel2==0)) {
        //-----------------------------------------Поиск исполнителя
        if ($ROW_data[2]<>null && $ROW_data[2]<>'') {
            $id_implementer=SQL_find_implementer($mysqli,$ROW_data[2]);
            if ($id_implementer==0) $id_implementer=false;               //Не найден
        } else $id_implementer=null;
        //----------------------------------------поиск материала на складе
        ///$id_stock= SQL_find_stock($mysqli, $ROW_data[1], $ROW_data[3]);
        
        if (!($id_implementer===false)) {
            $sql='insert into i_material (id_razdel2,razdel1,razdel2,displayOrder,material,    id_implementer,units,count_units,price,title,summa_realiz,count_realiz,id_stock)'
                                        . 'values ('
                                        ."'$id_razdel2',"
                                        ."'$R1',"
                                        ."'$R2',"
                                        ."'$R3',"
                                        ."'".$mysqli->real_escape_string($ROW_data[1])."',"
                                        ."'$id_implementer',"
                                        ."'$ROW_data[3]',"
                                        ."'$ROW_data[4]',"
                                        ."'$ROW_data[6]',"
                                        ."'$title'," 
                                        ."'$ROW_data[11]',"
                                        ."'$ROW_data[13]',"
                                        ."'$id_stock'"
                                        . ')';      
            
            $id=iInsert_1R($mysqli,$sql); 
        }
    }
    return $id; 
} 

//=======================================================================

/*
//Проверка на возможность удаления объекта
function Get_Realiz_object($mysqli,$id_object){       
 $ret=0;
 $sql = 'select * from i_object where id="'.$id_object.'"';
 $obj = $mysqli->query($sql); 
     if ($obj->num_rows>0) { 
         $row = $obj->fetch_assoc();
         if (!(($row['total_r0_realiz']==0) and ($row['total_m0_realiz']==0))) {
            echo "<p/>Невозможно перегрузить объект: ".$row['object_name']
               ."<p/>, потому что по нему открыто выполнение по смете"
               ."<p/> сумма выполненных работ: ".$row['total_r0_realiz']
               ."<p/> сумма затраченных материалов: ".$row['total_m0_realiz'];
            $ret=2;
         }
     } else {                           //Объект не существует
           echo "<p/>Нет доступа к вызываемому объекту";
           $ret=1;
     }
 

 return $ret;
}
 * 
 */
function Delete_Data_object($mysqli,$id_object){
    $sql='delete from i_razdel1 where id_object="'.$id_object.'"';
    $ret=iDelUpd($mysqli,$sql,false);
    if ($ret===false) Sql_info($ret,$sql);
    return $ret;    //,false
}
function Delete_Data_r1($mysqli,$id_r1){
    $sql='delete from i_razdel1 where id="'.$id_r1.'"';
    $ret=iDelUpd($mysqli,$sql,false);
    if ($ret===false) Sql_info($ret,$sql);
    return $ret;    //,false
}
function Delete_Data_r2($mysqli,$id_r2){
    $sql='delete from i_razdel2 where id="'.$id_r2.'"';
    $ret=iDelUpd($mysqli,$sql,false);
    if ($ret===false) Sql_info($ret,$sql);
    return $ret;    //,false
}
function Update_File_object($mysqli,$id_object,$name){
    $sql='update i_object set file_name="'.$name
            .'", total_r0="0", total_m0="0"'
            .', total_r0_realiz="0", total_m0_realiz="0"'
            .' where id="'.$id_object.'"';
    $ret=iDelUpd($mysqli,$sql,false);
    if ($ret<>1) Sql_info($ret,$sql);
    return $ret; //,false
}
function Sql_info($ret,$sql) {
    echo_S(true,'<div class="div_info" id="info"> '
        .'<br>mysqli ret='.$ret.'->'.$sql
        .'</div>');
}
?>