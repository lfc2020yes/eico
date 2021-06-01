<?php
function InitArray(&$arr,$size) {
    for ($i=0;$i<$size;$i++)
    $arr[$i]=0.0;
}
function MakeArray(&$arr,$size) {
    for ($i=0;$i<$size;$i++)
    $arr[]=0.0;
}
function AddSumma(&$ITOGO,&$ROW_data) {
    $ITOGO[0]+=$ROW_data[7];
    $ITOGO[1]+=$ROW_data[8];
    $ITOGO[2]+=($ROW_data[7]+$ROW_data[8]);
}
function GetFloat($cell) {
    $type=$cell->getDataType();
    if ($type=='n' || $type=='f') {
      //$data_=round($data,2);
      $data=trim($cell->getCalculatedValue());  
      $data_=number_format(0.0+$data, 2, '.', '');
    }
    else $data_=null;
    return $data_;
}
function ROW_save(&$ROW_data,$NumColumn,$RAZDEL,$data,$count=null) {
    if ($data<>null && $data<>'' && $RAZDEL<>'') {
        if ($count<>null) {
            $ROW_data[$NumColumn]=$data*$count;
        }
        else
        $ROW_data[$NumColumn]=$data;
    }
}
function SUMMA_save(&$SUMMA,$num,$RAZDEL,$data) {
    if ($RAZDEL<>'') {
        $SUMMA[$num]+=$data;
    }    
}
function SUMMA_cmp($summa,$data,&$delta,$str='') {
    $title='';
    $summa_=number_format(0.0+$summa, 2, '.', '');
    $data_=number_format(0.0+$data, 2, '.', '');
    $delta=round($summa_-$data_,2);
    if ($delta<>0 || $str<>'') {
        $title= $str.' Σ='.$summa_.' δ='.$delta;
    }
    return $title;
}
function ROW_error(&$ROW_data) {
    return 'title="7='.$ROW_data[7].' 8='.$ROW_data[8].'"';
}
function ITOGO_error(&$ITOGO) {
    return 'title="0='.$ITOGO[0].' 1='.$ITOGO[1].' 2='.$ITOGO[2].'"';
}

function XLS_DB( $FName, &$row_TREE=0)
{
    //echo $FN.'<p/>';
    //$FName=iconv("WINDOWS-1251","UTF-8",$FName);
    //echo $FName.'<p/>';
    
    $url_system='./';
    include $url_system.'config.php';

$Key_RAZDEL='Раздел';
$Key_NotLoad = array ('Итого работа',      //0  [7]
                      'Итого материал',    //1  [8]
                      'ИТОГО по разделу',  //2  [9]
                      'Итого по разделу',  //3  [9]
                      'Накладные расходы', //4
                      'ВСЕГО ПО СМЕТЕ',    //5  ИТОГО
                      'прибыль',           //6
                      'в т.ч. НДС',        //7  18%
                      'Стоимость 1 м2'     //8
                      );      
$Key_Special = array (                                   
                        'З/п ИТР',
                        'з/п Рабочие',
                        'Накладные расходы',
                        'Доп. Работы',
                        'Электроэнергия',
                        'Техника аренда',
                        'Лизинги',
                        'Налоги',
                      );
/*
$Key_RASHOD='Накладные расходы';
$Key_PRIBIL='прибыль';
$Key_NDS='в т.ч. НДС';
*/

$okrugl=2;
$size_array=10;
$ITOGO=array(0,0,0);  //7-работа 8-материалы 9-всего
$SUMMA=array();
$ROW_data=array();
MakeArray(&$SUMMA,$size_array);
MakeArray(&$ROW_data,$size_array);


echo '<p/>Ключевое слово поиска раздела:'.$Key_RAZDEL;
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2010 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2010 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.2, 2010-01-11
 */

/** Error reporting */
error_reporting(E_ALL);

/** PHPExcel_IOFactory */
require_once './Classes/PHPExcel/IOFactory.php';

$Error=0;

if (!file_exists($FName)) {
     echo '<p>'.$FName." - не найден.".'</p>';
     echo '<p>'.realpath('.').'</p>';
}
else
 {

  //echo '<p>'.date('H:i:s') . " Load from Excel file - ".$FName.'</p>';
  $objReader = PHPExcel_IOFactory::createReader('Excel2007');     //Excel2007  //Excel5
  $objPHPExcel = $objReader->load($FName);
  $Sheet=0;
  $DZ=date('Y-M-D H:i:s');
  echo '<p>'.$DZ. " Перечитывание вкладок worksheets".'</p>';
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
	//echo '<table cellspacing="0" align="left" border="1" >';
	//$WS=iconv("UTF-8","windows-1251", $worksheet->getTitle());
        $WS= $worksheet->getTitle();
        
	echo '<p>'.'<caption align="left"> Вкладка: ' . $WS .'</caption>'.'</p>' ;
    echo '<div>';
    //echo '<th><th>A id_type_place <th>B url <th>C name <th>D address <th>E phone <th>F Otime';
    if ($WS=='Себестоимость') {
        $id_object=SQL_save_object(iconv("WINDOWS-1251","UTF-8",$FName));
        if (!($id_object===false)) {
      
            //----------------------------------------------------------создать таблицу
            echo '<table cellspacing="0" align="left" border="1" >';
            //$BG=' bgcolor="yellow"';
            $objPHPExcel->setActiveSheetIndex($Sheet);
            $sharedStyle1 = new PHPExcel_Style();                 //Стиль для чтения цвета ячейки
            $U1=0; $U2=0; $U3=0;
            $Begin_num_row=13;
            $RAZDEL='';
            $R1='';
            $R2='';
      
	    foreach ($worksheet->getRowIterator() as $row) {     //По строчкам
                $visible_row=$worksheet->getRowDimension($row->getRowIndex())->getVisible();
                if ($visible_row==false) continue;
                if ($row->getRowIndex()<$Begin_num_row) continue;

                echo '<tr><td>'. $row->getRowIndex() ; ////
                echo '<td>'.$RAZDEL ; 
        //$BG=' bgcolor="yellow"';
                $name='';
                $inver='';
                $cena='';
                $type='';


                InitArray(&$ROW_data,$size_array);
                $load=true; 
                $data_type=0;
                $razdel_row=false;
                $row_num=count($Key_NotLoad);
                $NumColumn=0;
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
		foreach ($cellIterator as $cell) {              //По столбцам
		    $error=0;
                    $delta=0; 
                    //$col=echo $excel->getActiveSheet()->getStyle($cell)->getFill()->getStartColor()->getRGB();
                    //$cell_data=iconv("UTF-8","windows-1251//IGNORE", $cell->getCalculatedValue()) ; 
                    //$Merge=$cell->isInMergeRange();
                    $data=trim($cell->getCalculatedValue());
                    $data_=$data; 
                    $title='';
                    if ($cell->getColumn()>'X') break;   //Отсечка по правому краю
                    //--------------------------------------Стуль ячейки
                    $sharedStyle=$objPHPExcel->getActiveSheet()->getStyle($cell->getColumn().$cell->getRow());
                    $ali=$sharedStyle->getAlignment()->getHorizontal();
                    if ($ali=='right') {    //['horizontal']
                        $align='align="right"';
                    } elseif ($ali=='center') { 
                        $align='align="center"';
                    } else { $align='align="left"'; }
                    
                    $visible_column=$worksheet->getColumnDimension($cell->getColumn())->getVisible();
                    switch ($cell->getColumn())
                    {
                      case 'A': 
                          //поиск .
                        $FColor='yellow';
                        if ($data<>'') {  
                          $tpos=strpos($data,'.');
                          if(!($tpos===false)) {
                            $R1=0+Substr($data,0,$tpos);
                            if ($R1<>$RAZDEL) {    
                              $FColor='red';
                              $error=1; //Номер подраздела не равен разделу
                            }
                            $R2=Substr($data,$tpos+1);
                          } else {
                              
                              $error=2;  //нет точки
                          }
                        } else $error=3;  //нет номера подраздела (но может быть это не подраздел) 
                        echo '<td bgcolor="'.$FColor.'">'.$R1.'.'.$R2;
                        break;
                      case 'B':   //Наименование работ, разделов, материалов
                        $pos=strpos($data,$Key_RAZDEL);
                        $ali_B=$ali;                        //Признак материалов
                        if (!($pos===false)) {  //--------------------------------это строка раздела
                            $RAZDEL=0+substr($data,$pos+strlen($Key_RAZDEL));
                            $R1='';
                            $R2='';
                            InitArray(&$SUMMA,$size_array);
                            $name_razdel=Get_Name_Razdel(substr($data,$pos+strlen($Key_RAZDEL)));
                            $id_razdel1=SQL_insert_razdel($id_object,$RAZDEL,$name_razdel);
                            $razdel_row=true;
                        } else {
                           for ($row_num=0; $row_num<count($Key_NotLoad); $row_num++) { //Row_num - номер специальной строки
                              if (!(strpos($data,$Key_NotLoad[$row_num])===false)) {
                                  if ($RAZDEL<>100)
                                       $load=false;
                                  elseif($row_num==5 || $row_num==7 || $row_num==8)
                                      $load=false;
                                  break;
                              }
                           } 
                        }
                        ROW_save(&$ROW_data,$NumColumn,$RAZDEL,$data);
                        //$title=ROW_error(&$ROW_data);
                        //$title=ITOGO_error(&$ITOGO);
                        break;
                      case 'C': // 2 исполнитель  
                      case 'D': // 3 единицы
                          ROW_save(&$ROW_data,$NumColumn,$RAZDEL,$data);
                          break;
                      case 'E': //4 кол-во
                          $data_=GetFloat($cell);
                          ROW_save(&$ROW_data,$NumColumn,$RAZDEL,$data);
                          break;
                      case 'F': //5 стоимость работы
                          $num=7;
                          $data_=GetFloat($cell);
                          ROW_save(&$ROW_data,$NumColumn,$RAZDEL,$data);
                          ROW_save(&$ROW_data,$num,$RAZDEL,$data,$ROW_data[4]);
                          SUMMA_save(&$SUMMA,$num,$RAZDEL,$ROW_data[$num]);
                          //$title=ROW_error(&$ROW_data);
                          //$title=ITOGO_error(&$ITOGO);
                          break;
                      case 'G': //6 стоимость материалов
                          $num=8;
                          $data_=GetFloat($cell);
                          ROW_save(&$ROW_data,$NumColumn,$RAZDEL,$data);
                          ROW_save(&$ROW_data,$num,$RAZDEL,$data,$ROW_data[4]);
                          SUMMA_save(&$SUMMA,$num,$RAZDEL,$ROW_data[$num]);
                          //$title=ROW_error(&$ROW_data);
                          //$title=ITOGO_error(&$ITOGO);
                          break;
                      
                      case 'H': //7 Цена работа
                      case 'I': //8 Цена материалы
                          break;
                      case 'J': //9 Сумма   
                          $data_=GetFloat($cell);
                          if($ROW_data[4]<>null) {          //Строка с данными
                            
                            if ($ROW_data[5]>0 && $ROW_data[6]>0) {
                                $cmp_data=$ROW_data[7]+$ROW_data[8];
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
                            $title=SUMMA_cmp($cmp_data,$data,&$delta,$coment); 
                            $error=0;
                          }
                          elseif($RAZDEL==100) {   //Спецраздел Загрузка данных общими суммами как РАБОТЫ
                            $data_type=6;  
                            ROW_save(&$ROW_data,7,$RAZDEL,$data);
                            SUMMA_save(&$SUMMA,7,$RAZDEL,$ROW_data[7]);
                            $title=SUMMA_cmp($ROW_data[7],$data,&$delta,'общей суммой');
                            //$load=true;
                          } //else $error=4;           //нет данных по количеству
                          ROW_save(&$ROW_data,$NumColumn,$RAZDEL,$data);
                           
                          break;
                    }
                    if ($cell->getColumn()=='J' && $error==0) { //9-сумма
                        switch ($row_num) {       //Дополнительная проверка итоговых сумм
                            case 0:      //работы
                                $title=SUMMA_cmp($SUMMA[7],$data,&$delta,'работа:');
                                break;
                            case 1:      //материалы
                                $title=SUMMA_cmp($SUMMA[8],$data,&$delta,'материалы:');
                                break;
                            case 2:      //по разделу
                            case 3: 
                                $title=SUMMA_cmp($SUMMA[7]+$SUMMA[8],$data,&$delta,'итого по разделу:');
                                break;
                            case 4:      //накладные
                                break;
                            case 5:      //ИТОГО
                                $title=SUMMA_cmp($ITOGO[2],$data,&$delta,'итого:');
                                break;
                            case 6:      //прибыль
                                break;
                            case 7:      //НДC
                                $nds=($SUMMA[7]+$SUMMA[8])/1.18*0.18;
                                $title=SUMMA_cmp($nds,$data,&$delta,'НДС по разделу:');
                                break;
                            case 8: //Стоимость 1 м2
                                break;
                            default :
                                AddSumma(&$ITOGO,&$ROW_data);
                        }
                        
                    }
                    if ($cell->getColumn()=='J' && $error==0 && $load==true && $razdel_row==false) { //9-сумма  Запись в базу
                       switch ($data_type) {
                           case 1:                 //И работы и материалы
                               $id_razdel2=SQL_insert_work($id_razdel1,$R1,$R2,&$ROW_data,$title);
                               //SQL_insert_work($id_razdel2,$R2,&$ROW_data,$title);/////
                               break;
                           case 2:                 //работы
                               $id_razdel2=SQL_insert_work($id_razdel1,$R1,$R2,&$ROW_data,$title);
                               break;
                           case 3:                 //материалы
                               SQL_insert_material($id_razdel2,$R1,$R2,&$ROW_data,$title);
                               break;
                           case 4: //работы пусто
                               $id_razdel2=SQL_insert_work($id_razdel1,$R1,$R2,&$ROW_data,$title);
                               break;
                           case 5: //материалы пусто
                               SQL_insert_material($id_razdel2,$R1,$R2,&$ROW_data,$title);
                               break;
                           
                           case 6:                 //спецраздел
                               $id_razdel2=SQL_insert_work($id_razdel1,$R1,$R2,&$ROW_data,$title);//////
                               break;
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
                    
                    if ($delta<>0) $colorE ='darkred';
                    elseif ($title=='' && $NumColumn==9 && $data<>'') $colorE='lightgray';
                    elseif ($load==false) $colorE = 'darkblue'; 
                    elseif ($visible_row==false || $visible_column==false) $colorE = 'gray';
                    if ($colorE=='000000') $bgcolor='';
                    else $bgcolor='bgcolor="'.$colorE.'"';
                    
                    
                    $type=$cell->getDataType();
                    if ($type=='n' || $type=='f') $data_show=$data_;  //Форматированные числа
                    else $data_show=$data;
                    
                    echo '<td '.$align.' '.$bgcolor.'>'
                               .$font.$bold
                                .'<a title="'.$title.'">'. $data_show .'</a>'
                                .$bold_.'</font>' ; ////
                    $NumColumn++;  
                    continue;           ////
                    //--------------------------------------------------------------------------------------------
	        } //for cell
	    } //row
	    echo '</table>';
        } // id_object   
    }  //sheet
    $Sheet++;
  }
  echo '</div>';
  // Echo memory peak usage
  echo '<p>'.date('H:i:s')." Обновление ОК!, Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB".'</p>';

  // Echo done
  //echo '<p>' .date('H:i:s') . " Done writing files.";
 }


}

function ved_int($digit, $width_, $SIM='0')
{
    while(strlen($digit) < $width_)
      $digit = $SIM.$digit;
    return $digit;
}
//===============================================================================
function SQL_save_object($str){
    //$name=urlencode($str);
    //заменить \ на \\
    $name=str_replace('\\','\\\\',$str);
    $error=false;
    //----------------------------------поиск такого объекта
    
    $sql='select id from i_object where object_name="'.$name.'"';
    
    $res=mysql_query($sql);
    $num_results = mysql_num_rows($res);
        
    echo "$sql -> $num_results<p/>"; 
    if($num_results>0) {
        //----------------------------------если есть - вопрос о перезаписи
        echo "ПЕРЕЗАПИСЬ объекта: ".$name."<p/>";
        //----------------------------------удалить объект 
        $sql='delete from i_object where object_name="'.$name.'"';
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

        $sql="insert into i_object (object_name) values ('$name')";
        $res=mysql_query($sql);
        $arows=mysql_affected_rows();
        if ($res==TRUE && $arows==1) {
            $id=mysql_insert_id();
        }
        else echo "$sql -> $res<p/>"; 
    }    
    return $id;
}
function SQL_insert_razdel($id_object,$razdel1,$name1) {
        $id=false;                    
        $sql='insert into i_razdel1 (id_object,razdel1,name1)'
                                    . 'values ('
                                    ."'$id_object',"
                                    ."'$razdel1',"
                                    ."'$name1'"
                                    . ')';  
        $res=mysql_query($sql);
        $arows=mysql_affected_rows();
        if ($res==TRUE && $arows==1) {
            $id=mysql_insert_id();
        }
        else echo "$sql -> $res<p/>"; 
        return $id;
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
function SQL_insert_work($id_razdel1,$R1,$R2,&$ROW_data,$title){   //not title
    $id=false; 
    if (!($id_razdel1===false)) {
        //-----------------------------------------Поиск исполнителя
        if ($ROW_data[2]<>null && $ROW_data[2]<>'') {
            $id_implementer=SQL_find_implementer($ROW_data[2]);
        } else $id_implementer=null;
        if (!($id_implementer===false)) {
            if ($R1<>100) { 
            $sql='insert into i_razdel2 (id_razdel1,razdel1,razdel2,name_working,id_implementer,units,count_units,price,title)'
                                        . 'values ('
                                        ."'$id_razdel1',"
                                        ."'$R1',"
                                        ."'$R2',"
                                        ."'$ROW_data[1]',"
                                        ."'$id_implementer',"
                                        ."'$ROW_data[3]',"
                                        ."'$ROW_data[4]',"
                                        ."'$ROW_data[5]',"
                                        ."'$title'"
                                        . ')';      
            } else {
            $sql='insert into i_razdel2 (id_razdel1,razdel1,razdel2,name_working,id_implementer,units,count_units,price,title)'
                                        . 'values ('
                                        ."'$id_razdel1',"
                                            ."'$R1',"
                                        ."'$R2',"
                                        ."'$ROW_data[1]',"
                                        ."'$id_implementer',"
                                        ."'$ROW_data[3]',"
                                        ."'1',"
                                        ."'$ROW_data[7]',"
                                        ."'$title'"
                                        . ')';  
            }
            $res=mysql_query($sql);
            $arows=mysql_affected_rows();
            if ($res==TRUE && $arows==1) {
                $id=mysql_insert_id();
            }
            else echo "$sql -> $res<p/>"; 
        }
    }
    return $id;
}
function SQL_find_implementer($name){
    //----------------------------------поиск 
    $sql='select id from i_implementer where implementer="'.$name.'"';
    $res=mysql_query($sql);
    $num_results = mysql_num_rows($res);
    //echo "$sql -> $num_results<p/>"; 
    if($num_results>0) {    //----------получить id
       $row = mysql_fetch_array($res);
       $id=$row['id']; 
    } else {   //-----------------добавить исполнителя
       $id=SQL_insert_implementer($name); 
    }
    return $id;
}
function SQL_insert_implementer($name){
        $id=false;                    
        $sql='insert into i_implementer (implementer)'
                                    . 'values ('
                                    ."'$name'"
                                    . ')';  
        $res=mysql_query($sql);
        $arows=mysql_affected_rows();
        if ($res==TRUE && $arows==1) {
            $id=mysql_insert_id();
        }
        else echo "$sql -> $res<p/>"; 
        return $id;
}
function SQL_insert_material($id_razdel2,$R1,$R2,&$ROW_data,$title){
    $id=false; 
    if (!($id_razdel2===false)) {
        //-----------------------------------------Поиск исполнителя
        if ($ROW_data[2]<>null && $ROW_data[2]<>'') {
            $id_implementer=SQL_find_implementer($ROW_data[2]);
        } else $id_implementer=null;
        if (!($id_implementer===false)) {
            $sql='insert into i_material (id_razdel2,razdel1,razdel2,material,    id_implementer,units,count_units,price,title)'
                                        . 'values ('
                                        ."'$id_razdel2',"
                                        ."'$R1',"
                                        ."'$R2',"
                                        ."'$ROW_data[1]',"
                                        ."'$id_implementer',"
                                        ."'$ROW_data[3]',"
                                        ."'$ROW_data[4]',"
                                        ."'$ROW_data[6]',"
                                        ."'$title'"
                                        . ')';      
            
            $res=mysql_query($sql);
            $arows=mysql_affected_rows();
            if ($res==TRUE && $arows==1) {
                $id=mysql_insert_id();
            }
            else echo "$sql -> $res<p/>"; 
        }
    }
    return $id; 
} 


?>