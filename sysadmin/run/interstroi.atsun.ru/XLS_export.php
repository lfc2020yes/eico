<?php

$sys=$_SERVER['DOCUMENT_ROOT'];
include_once $sys."/ilib/lib_interstroi.php";
include_once $sys.'/ilib/Isql.php';
$url_system=$sys.'/sysadmin/run/interstroi.atsun.ru/';
require_once $url_system.'Classes/PHPExcel.php';
require_once $url_system.'Classes/PHPExcel/Writer/Excel2007.php';

function RUN____($PARAM,&$row_TREE=0,&$ROW_role=0) {
    if ($row_TREE["DEBUG"]==1) {
        $DBG=true;
        console ("log","DEBUG");
    } else $DBG=false;
    //echo "<p/>PARAM: $PARAM";
    $GT=array();
    GET_PARAM(&$GT,$PARAM);
    //echo "<p/>".json_encode($GT);
    
    if(array_key_exists('id_object',$GT))           //$_GET
    {
	$id_object=htmlspecialchars(trim( $GT["id_object"] ));
         //echo "<p/> id_user=".$id_user;
    } else exit();
    if(array_key_exists('name',$GT))           //$_GET
    {
	$name=htmlspecialchars(trim( $GT["name"] ));
         //echo "<p/> name=".$name;
    }
  //echo "<p/> id_object=$id_object name=$name";
  $ret=0;

 if ($_SERVER['REQUEST_METHOD']=='GET')
 {
                                           // readonly  padding:0; 
      ?>
      <form enctype="multipart/form-data" action="<?=$_SERVER['REQUEST_URI']?>" id="form_xls" method="post" class="theform" >
        <strong style="margin:8px;">Export XLSX: <?=$name?></strong><br>
        <input type="hidden" name="xlsx" value="1" />
        <input type="hidden" name="id_object" id="id_object" value="<?=$id_object?>" />
        <input type="hidden" name="debug" id="debug" value="<?=$DBG?>" />
        <!--
        <br>
        <div id="read_sheet" class="abs" ><img width=400px height=400px src="../images/tree_S/load/giphy.gif"></div>   
        <br>
        -->
        <input type="submit" name="real_xls" id="real_xls" class="typefile" value="Отправить" />
      </form>
      <?php 
      //CH_cell(1);
 }
 else  // Это POST
 {
     echo '<br>post id_object='. $_POST["id_object"];
     export2XLS('Estimate',$_POST["id_object"],true); 
 }
} 


    function CH_cell($num) {
        // $NumColumn=(integer)ord($ic)-65;
        $CH=chr($num+64); 
        //echo '<p>$num='.$num.' $CH='.$CH;
        return $CH;
    }
    //echo '<p/>$CHC='.$CHC.' $num_row='.$num_row.' $num='.$num.' $str='.$str.' verh='.$verh;
        
    function merge_cellv(&$sheet,&$style, $num_row, $num,  $value ) {
        //$sheet->getStyleByColumnAndRow($num-1,$num_row)->applyFromArray($style);
        $sheet->setCellValueByColumnAndRow($num-1,$num_row,$value);
        $CHC=CH_cell($num);
        $par=$CHC.$num_row.':'.$CHC.($num_row+1);  
        //echo '<p/> выражение='.$par;  
        $sheet->mergeCells($par);
        $sheet->getStyle($par)->applyFromArray($style);
    }
    function merge_cellh(&$sheet,&$style, $num_row, $num,  $value ) {                 //дубликат следующей
        //$sheet->getStyleByColumnAndRow($num-1,$num_row)->applyFromArray($style);
        $sheet->setCellValueByColumnAndRow($num-1,$num_row,$value);
          $par=CH_cell($num).$num_row.':'.CH_cell($num+1).$num_row;
          //echo '<p/> horizont='.$par;  
          $sheet->mergeCells($par);  
        $sheet->getStyle($par)->applyFromArray($style);
    }
    function merge_cellHi(&$sheet,&$style,$num_row,$num1,$num2,$value,$visible=true) {
        $sheet->setCellValueByColumnAndRow($num1-1,$num_row,$value);
        $par=CH_cell($num1).$num_row.':'.CH_cell($num2).$num_row;
        $sheet->mergeCells($par); 
        $sheet->getStyle($par)->applyFromArray($style);
        if($visible==false) {
          $sheet->getRowDimension($num_row)->setVisible(false);
        }
    }
    function cell_data_format(&$sheet,&$style,$num_row,$num
            ,$str
            ,$type=PHPExcel_Cell_DataType::TYPE_STRING
            ,$comment_data='') {
       //$sheet->setCellValueByColumnAndRow($num-1,$num_row,$str); 
       //$sheet->getCellByColumnAndRow($num-1,$num_row)->setValue($str);
       //->setValueExplicit('1.1', PHPExcel_Cell_DataType::TYPE_STRING);
       if ($str=='')$type=PHPExcel_Cell_DataType::TYPE_STRING; 
       if (substr($str,0,1)=='=') {  //Это формула
           $sheet->setCellValueByColumnAndRow($num-1,$num_row,$str); 
       } else {
         $sheet->getCellByColumnAndRow($num-1,$num_row)->setValueExplicit($str,$type); 
       }
       $sheet->getStyleByColumnAndRow($num-1,$num_row)->applyFromArray($style);
       if ($comment_data<>'')
           cell_comment(&$sheet,$num_row,$num,$comment_data); 
       
    }
    function cell_summ_format(&$sheet,&$style,$num_row,$num,$num_rowR,$comment_data='') {
        if (($num_row-$num_rowR)>1)
             $str='=SUM('.CH_cell($num).$num_rowR.':'.CH_cell($num).($num_row-1).')'; //SUMM
        else $str=0;
       
        //////$sheet->setCellValue(CH_cell($num).$num_row,$str);
        //echo '<p/>'.$sheet->getCell(CH_cell($num).$num_row)->getCalculatedValue().$str;
        /////$sheet->getStyleByColumnAndRow($num-1,$num_row)->applyFromArray($style);
        cell_data_format(&$sheet,&$style,$num_row,$num,$str,'',$comment_data);
        //echo '<p/>'.$sheet->getCellByColumnAndRow($num-1,$num_row)->getCalculatedValue().$str; 
    }
    
    function cell_itog_format(&$sheet,&$style,$num_row,$num,$num_rowA,$comment_data) {
       // $formula='='.'SUMIF($A$'.($num_rowA).':$A'.($num_row-1).';$A'.($num_row)      //СУММЕСЛИ SUMIF
       //         .';'.CH_cell($num).'$'.($num_rowA).':'.CH_cell($num).($num_row-1).')';
        $formula='=SUMIF($B$'.($num_rowA).':$B'.($num_row-1).',"ИТОГО по разделу:",'     
                 .CH_cell($num).'$'.($num_rowA).':'.CH_cell($num).($num_row-1).')';
       
        //echo '<p/>'.$formula;
        //////$sheet->setCellValue(CH_cell($num).$num_row,$formula);
        /////$sheet->getStyleByColumnAndRow($num-1,$num_row)->applyFromArray($style);
        cell_data_format(&$sheet,&$style,$num_row,$num,$formula,'',$comment_data); //,PHPExcel_Cell_DataType::TYPE_NUMERIC);
        /*
        $commentText = new PHPExcel_RichText;
        $commentText->createText($comment_data.$formula);
        
        $comment = $sheet->getCommentByColumnAndRow($num-1,$num_row);
        $comment->setText($commentText);            //Комментарии
         * 
         */
        //if ($comment_data<>'')
        //echo '<p/>$comment_data='.$comment_data;
        //echo '<p/>'.$sheet->getCell(CH_cell($num).$num_row)->getCalculatedValue().$formula;
    }
    function cell_comment(&$sheet,$num_row,$num,$comment_data){
        $commentText = new PHPExcel_RichText;
        $commentText->createText($comment_data);
        
        $sheet->getCommentByColumnAndRow($num-1,$num_row)->setText($commentText); //Комментарии
    }
    function NDS(&$sheet,&$style1,&$style2,&$style3,$num_row,$data) {
        //cell_data_format(&$sheet,&$style1,$num_row,1,'');
        cell_data_format(&$sheet,&$style2,$num_row,2,'в т.ч. НДС 20%');
        cell_data_format(&$sheet,&$style1,$num_row,3,'');
        cell_data_format(&$sheet,&$style1,$num_row,4,'');
        cell_data_format(&$sheet,&$style1,$num_row,5,'');
        cell_data_format(&$sheet,&$style1,$num_row,6,'');
        cell_data_format(&$sheet,&$style1,$num_row,7,'');
        $sheet->mergeCells(CH_cell(3).$num_row.':'.CH_cell(7).$num_row);
        cell_data_format(&$sheet,&$style1,$num_row,8,'');
        cell_data_format(&$sheet,&$style1,$num_row,9,'');
        if (calc) {
            cell_data_format(&$sheet,&$style3,$num_row,10,'=ROUND('.CH_cell(10).($num_row-1).'*20/120,2)');
        } else {
            cell_data_format(&$sheet,&$style3,$num_row,10,round($data*20/120,2),PHPExcel_Cell_DataType::TYPE_NUMERIC);
            
        }
        cell_data_format(&$sheet,&$style1,$num_row,11,'');
        cell_data_format(&$sheet,&$style1,$num_row,12,''); 
        cell_data_format(&$sheet,&$style1,$num_row,13,'');
        cell_data_format(&$sheet,&$style1,$num_row,14,''); 
        cell_data_format(&$sheet,&$style1,$num_row,15,'');
        cell_data_format(&$sheet,&$style1,$num_row,16,'');
    }
    
function export2XLS($sheet_name,$id_object,$calc=true) {
    include_once 'XLS_style.php';   
  //============================================================================  
  $ret=0;  
  $mysqli=new_connect(&$ret);
  if (!$mysqli->connect_errno) {  
    // Создаем объект класса PHPExcel
    $validLocale = PHPExcel_Settings::setLocale('ru');  
    $xls = new PHPExcel();
    
    // Устанавливаем индекс активного листа
    $xls->setActiveSheetIndex(0);
    // Получаем активный лист
    $sheet = $xls->getActiveSheet();
    // Подписываем лист
    $sheet->setTitle($sheet_name);
    
    $wsize=array(0,60,0,0,0,0,0,0,0,0,0,0,0,0);
    for($i=0; $i< count($wsize) ;$i++) {
        if($wsize[$i]==0)
             $sheet->getColumnDimension(CH_cell($i+1))->setAutoSize(true);
        else $sheet->getColumnDimension(CH_cell($i+1))->setWidth($wsize[$i]);
    }
    //$sheet->getColumnDimension(CH_cell(1))->setAutoSize(true);
    //$sheet->getColumnDimension(CH_cell(2))->setWidth(60);
    
    $begin_row=8;
    $head_row=0;
    $num_row=$begin_row;
    //echo '<p/>------------------шапка таблицы';
    $dim=array(0,60,0,0,6,10,10,10,10,12,12,12,10,10,8,8);
    for($i=1;$i<17;$i++) {
        cell_data_format(&$sheet,&$style0,$num_row,$i,$i);
    }
    
    
    $num_rowH1=$num_row;
    $num_row++;   
    //echo '<p/>-------------шаг 2';
    merge_cellv(&$sheet,&$styleH,$num_row,1,'№ п/п');
    merge_cellv(&$sheet,&$styleH,$num_row,2,'Наименование работ');
    merge_cellv(&$sheet,&$styleH,$num_row,3,'Исполнитель');
    $sheet->freezePane(CH_cell(3).($num_row+2));
    merge_cellv(&$sheet,&$styleH,$num_row,4,'ед. изм.');
    merge_cellv(&$sheet,&$styleH,$num_row,5,'кол-во');
    merge_cellh(&$sheet,&$styleH,$num_row,6,'стоимость ед. (руб.)');
    merge_cellh(&$sheet,&$styleH,$num_row,8,'Итого (руб.)');
    merge_cellv(&$sheet,&$styleH,$num_row,10,'Всего (руб.)');
    merge_cellh(&$sheet,&$styleH,$num_row,11,'Выполнение (руб)');
    merge_cellh(&$sheet,&$styleH,$num_row,13,'Выполнение (кол-во)');
    merge_cellh(&$sheet,&$styleH,$num_row,15,'График выполнения');
    
    $num_row++;
    //echo '<p/>-------------шаг 3';
    cell_data_format(&$sheet,&$styleH,$num_row,6,'работа');
    cell_data_format(&$sheet,&$styleH,$num_row,7,'материалы');
    cell_data_format(&$sheet,&$styleH,$num_row,8,'работа');
    cell_data_format(&$sheet,&$styleH,$num_row,9,'материалы');
    cell_data_format(&$sheet,&$styleH,$num_row,11,'работа');
    cell_data_format(&$sheet,&$styleH,$num_row,12,'материалы');
    cell_data_format(&$sheet,&$styleH,$num_row,13,'работа');
    cell_data_format(&$sheet,&$styleH,$num_row,14,'материалы');
    cell_data_format(&$sheet,&$styleH,$num_row,15,'начало');
    cell_data_format(&$sheet,&$styleH,$num_row,16,'окончание');
    ramka(&$sheet,&$style_r2,1,$begin_row,16,$num_row);
    //$sheet->setAutoFilter('A1:J1');  //Фильтр
    //
    //echo '<p/>-------------шаг 4';
   $num_rowA=$num_row+1;
   $sqlO='select * from i_object where id="'.$id_object.'"';
   $resultO=$mysqli->query($sqlO);
   while( $rowO = $resultO->fetch_assoc() ){  //Данные по объекту
    
    $sql='select * from i_razdel1 where id_object="'.$id_object.'" order by razdel1';
    $result=$mysqli->query($sql);
    $xls->getProperties()->setCreator("AtSun")
                        ->setLastModifiedBy("InterStroi")
                        ->setTitle($sheet_name)
                        ->setSubject($rowO['object_name'])
                        ->setDescription($rowO['about'])
                        ->setKeywords("Себестоимость EiCO")
                        ->setCategory("Сметы");
    
        while( $row = $result->fetch_assoc() ){     //Разделы
        Next_row(&$sheet,++$num_row);
        $num_rowR=$num_row+1;
        //----------------писать строку раздел
        cell_data_format(&$sheet,&$styleW,$num_row,1,'');
        $sheet->setCellValueByColumnAndRow(1,$num_row,'Раздел '.$row['razdel1'].'. '.$row['name1']);
        $sheet->getStyleByColumnAndRow(1,$num_row)->applyFromArray($styleR);
        $sheet->mergeCells(CH_cell(2).$num_row.':'.CH_cell(7).$num_row);
        for ($r=8;$r<=16;$r++)
             cell_data_format(&$sheet,&$styleRBlack,$num_row,$r,'');
        /*
        cell_data_format(&$sheet,&$styleRBlack,$num_row,8,'');
        cell_data_format(&$sheet,&$styleRBlack,$num_row,9,'');
        cell_data_format(&$sheet,&$styleRBlack,$num_row,10,'');
        cell_data_format(&$sheet,&$styleRBlack,$num_row,11,'');
        cell_data_format(&$sheet,&$styleRBlack,$num_row,12,'');
        cell_data_format(&$sheet,&$styleRBlack,$num_row,13,'');
        cell_data_format(&$sheet,&$styleRBlack,$num_row,14,'');
        */
        $sql2='select * from i_razdel2 where id_razdel1="'.$row['id'].'" order by  CAST(razdel2 as SIGNED)';
        $result2=$mysqli->query($sql2);
        while( $row2 = $result2->fetch_assoc() ){     //Работы
            Next_row(&$sheet,++$num_row);
            //-------------------писать строку работа
            cell_data_format(&$sheet,&$styleW,$num_row,1,$row['razdel1'].'.'.$row2['razdel2']);
            cell_data_format(&$sheet,&$styleW,$num_row,2,$row2['name_working']);
            
            cell_data_format(&$sheet,&$styleWN,$num_row,3
                      ,Get_implementer($mysqli,$row2['id_implementer'])); //!!!!!!!!!!!!!!
            cell_data_format(&$sheet,&$styleWN,$num_row,4,$row2['units']);
            cell_data_format(&$sheet,&$styleN,$num_row,5,$row2['count_units'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleN,$num_row,6,$row2['price'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleN,$num_row,7,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
            if(calc) {
            cell_data_format(&$sheet,&$styleN,$num_row,8,'='.CH_cell(5).$num_row.'*'.CH_cell(6).$num_row,'',ROUND($row2['subtotal'],2)); 
            cell_data_format(&$sheet,&$styleN,$num_row,10,'='.CH_cell(8).$num_row.'+'.CH_cell(9).$num_row,'',ROUND($row2['subtotal'],2));
                    
            } else {
            cell_data_format(&$sheet,&$styleN,$num_row,8,$row2['subtotal'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleN,$num_row,10,$row2['subtotal'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
            }
            cell_data_format(&$sheet,&$styleN,$num_row,9,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleN,$num_row,11,$row2['summa_r2_realiz'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleN,$num_row,12,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleN,$num_row,13,$row2['count_r2_realiz'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleN,$num_row,14,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
            
            cell_data_format(&$sheet,&$styleN,$num_row,15,$row2['date0']);
            cell_data_format(&$sheet,&$styleN,$num_row,16,$row2['date1']);
            
            $sql3='select * from i_material where id_razdel2="'.$row2['id'].'" order by displayOrder';
            //echo '<p/>'.$sql3;
            $result3=$mysqli->query($sql3);
            while( $row3 = $result3->fetch_assoc() ){     //Материалы
                Next_row(&$sheet,++$num_row);
                //--------------------писать строку материалы
                cell_data_format(&$sheet,&$styleW,$num_row,1,'');
                cell_data_format(&$sheet,&$styleM,$num_row,2,$row3['material']);
                cell_data_format(&$sheet,&$styleWN,$num_row,3,Get_implementer($mysqli,$row3['id_implementer'])); //!!!!!!!!!!!!!!!!!!1
                cell_data_format(&$sheet,&$styleWN,$num_row,4,$row3['units']);
                cell_data_format(&$sheet,&$styleN,$num_row,5,$row3['count_units'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
                cell_data_format(&$sheet,&$styleN,$num_row,6,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
                cell_data_format(&$sheet,&$styleN,$num_row,7,$row3['price'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
                if(calc) {
                    
                cell_data_format(&$sheet,&$styleN,$num_row,9,'='.CH_cell(5).$num_row.'*'.CH_cell(7).$num_row,'',ROUND($row3['subtotal'],2)); 
                cell_data_format(&$sheet,&$styleN,$num_row,10,'='.CH_cell(8).$num_row.'+'.CH_cell(9).$num_row,'',ROUND($row3['subtotal'],2));
                
                } else {
                    
                cell_data_format(&$sheet,&$styleN,$num_row,9,$row3['subtotal'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
                cell_data_format(&$sheet,&$styleN,$num_row,10,$row3['subtotal'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
                }
                cell_data_format(&$sheet,&$styleN,$num_row,8,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
                cell_data_format(&$sheet,&$styleN,$num_row,11,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
                cell_data_format(&$sheet,&$styleN,$num_row,12,$row3['summa_realiz'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
                cell_data_format(&$sheet,&$styleN,$num_row,13,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
                cell_data_format(&$sheet,&$styleN,$num_row,14,$row3['count_realiz'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
                cell_data_format(&$sheet,&$styleN,$num_row,15,'');
                cell_data_format(&$sheet,&$styleN,$num_row,16,'');

            }  //material  
        } //work
        //-------------------------ИТОГО
        Next_row(&$sheet,++$num_row);
        cell_data_format(&$sheet,&$styleW,$num_row,1,'');
        cell_data_format(&$sheet,&$styleI,$num_row,2,'ИТОГО по разделу:');
        cell_data_format(&$sheet,&$styleIText,$num_row,3,$row['razdel1'].'. '.$row['name1']);
        cell_data_format(&$sheet,&$styleIText,$num_row,4,'');
        cell_data_format(&$sheet,&$styleIText,$num_row,5,'');
        cell_data_format(&$sheet,&$styleIText,$num_row,6,'');
        cell_data_format(&$sheet,&$styleIText,$num_row,7,'');
        $sheet->mergeCells(CH_cell(3).$num_row.':'.CH_cell(7).$num_row);
        if (calc) {
            
            cell_summ_format(&$sheet,&$styleNItogo,$num_row,8,$num_rowR,ROUND($row['summa_r1'],2));
            cell_summ_format(&$sheet,&$styleNItogo,$num_row,9,$num_rowR,ROUND($row['summa_m1'],2));
            cell_summ_format(&$sheet,&$styleNItogo,$num_row,10,$num_rowR,ROUND(($row['summa_r1']+$row['summa_m1']),2));
            cell_summ_format(&$sheet,&$styleNItogo,$num_row,11,$num_rowR,ROUND($row['summa_r1_realiz'],2));
            cell_summ_format(&$sheet,&$styleNItogo,$num_row,12,$num_rowR,ROUND($row['summa_m1_realiz'],2)); 
        } else {
            cell_data_format(&$sheet,&$styleNItogo,$num_row,8,$row['summa_r1'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleNItogo,$num_row,9,$row['summa_m1'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleNItogo,$num_row,10,($row['summa_r1']+$row['summa_m1']),PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleNItogo,$num_row,11,$row['summa_r1_realiz'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
            cell_data_format(&$sheet,&$styleNItogo,$num_row,12,$row['summa_m1_realiz'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
            
        }
        cell_data_format(&$sheet,&$styleNItogo,$num_row,13,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
        cell_data_format(&$sheet,&$styleNItogo,$num_row,14,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
        cell_data_format(&$sheet,&$styleNItogo,$num_row,15,'');
        cell_data_format(&$sheet,&$styleNItogo,$num_row,16,'');
        $num_row++;
        NDS(&$sheet,&$styleIText,&$styleI,&$styleNItogo,$num_row,$row['summa_r1']+$row['summa_m1']);
        
    } //razdel1  
    //--------------------------------------ВСЕГО
    
    $all_row=++$num_row;
        cell_data_format(&$sheet,&$styleW,$num_row,1,'');
        cell_data_format(&$sheet,&$styleAS,$num_row,2,'ВСЕГО ПО СМЕТЕ');
        cell_data_format(&$sheet,&$styleAText,$num_row,3,'');
        cell_data_format(&$sheet,&$styleAText,$num_row,4,'');
        cell_data_format(&$sheet,&$styleAText,$num_row,5,'');
        cell_data_format(&$sheet,&$styleAText,$num_row,6,'');
        cell_data_format(&$sheet,&$styleAText,$num_row,7,'');
        $sheet->mergeCells(CH_cell(3).$num_row.':'.CH_cell(7).$num_row);
    if (calc) {
        cell_itog_format(&$sheet,&$styleA,$num_row,8,$num_rowA,ROUND($rowO['total_r0'],2));
        cell_itog_format(&$sheet,&$styleA,$num_row,9,$num_rowA,ROUND($rowO['total_m0'],2));
        cell_itog_format(&$sheet,&$styleA,$num_row,10,$num_rowA,ROUND(($rowO['total_r0']+$rowO['total_m0']),2));
        cell_itog_format(&$sheet,&$styleA,$num_row,11,$num_rowA,ROUND($rowO['total_r0_realiz'],2));
        cell_itog_format(&$sheet,&$styleA,$num_row,12,$num_rowA,ROUND($rowO['total_m0_realiz'],2));
    } else {
        cell_data_format(&$sheet,&$styleA,$num_row,8,$rowO['total_r0'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
        cell_data_format(&$sheet,&$styleA,$num_row,9,$rowO['total_m0'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
        cell_data_format(&$sheet,&$styleA,$num_row,10,($rowO['total_r0']+$rowO['total_m0']),PHPExcel_Cell_DataType::TYPE_NUMERIC);
        cell_data_format(&$sheet,&$styleA,$num_row,11,$rowO['total_r0_realiz'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
        cell_data_format(&$sheet,&$styleA,$num_row,12,$rowO['total_m0_realiz'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
    }
    $xls->addNamedRange(new PHPExcel_NamedRange('AllSumma', $sheet, CH_cell(10).$num_row)); 

    cell_data_format(&$sheet,&$styleAText,$num_row,13,'',PHPExcel_Cell_DataType::TYPE_NUMERIC);
    cell_data_format(&$sheet,&$styleAText,$num_row,14,'',PHPExcel_Cell_DataType::TYPE_NUMERIC); 
    cell_data_format(&$sheet,&$styleAText,$num_row,15,'');
    cell_data_format(&$sheet,&$styleAText,$num_row,16,'');
        $num_row++;
        NDS(&$sheet,&$styleIText,&$styleI,&$styleNItogo,$num_row,$rowO['total_r0']+$rowO['total_m0']);
        $xls->addNamedRange(new PHPExcel_NamedRange('NDS', $sheet, CH_cell(10).$num_row)); 
        ramka(&$sheet,&$style_r2,1,$begin_row,16,$num_row);
    
   $sheet->setAutoFilter(CH_cell(1).($num_rowA-1).':'.CH_cell(14).($num_rowA-1));
   //---------------------------------Заголовки
    merge_cellHi(&$sheet,&$styleHi1,$head_row+1,1,14,'СМЕТА');
    merge_cellHi(&$sheet,&$styleHiR,$head_row+2,2,2,'Объект:');
    merge_cellHi(&$sheet,&$styleHiL,$head_row+2,3,14,$rowO['object_name']);
    merge_cellHi(&$sheet,&$styleHiR,$head_row+3,2,2,'Общая продаваемая площадь (м2):',false);
    merge_cellHi(&$sheet,&$styleHiRN,$head_row+3,3,4,$rowO['m2']);
    merge_cellHi(&$sheet,&$styleHiR,$head_row+4,2,2,'квартир:',false);
    merge_cellHi(&$sheet,&$styleHiRN,$head_row+4,3,4,$rowO['apartments']);
    merge_cellHi(&$sheet,&$styleHiR,$head_row+5,2,2,'Сметная стоимость:',false);
    merge_cellHi(&$sheet,&$styleHiRN,$head_row+5,3,4,'=AllSumma');
    merge_cellHi(&$sheet,&$styleHiR,$head_row+6,2,2,'В том числе НДС 20%:',false);
    merge_cellHi(&$sheet,&$styleHiRN,$head_row+6,3,4,'=NDS');
    merge_cellHi(&$sheet,&$styleHiR,$head_row+7,2,2,'Стоимость 1 м2:',false);
    merge_cellHi(&$sheet,&$styleHiRN,$head_row+7,3,4,'=ROUND(AllSumma / '.CH_cell(3).'3,2)');

   
   //--------------------------------------Печать
    $sheet->getPageSetup()
          ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
          ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE) 
          ->setPrintArea('A1:'.CH_cell(16) . $num_row)
          ->setFitToWidth(1)
          ->setFitToHeight(0)  
          ->setRowsToRepeatAtTopByStartAndEnd($num_rowH1,$num_rowH1+2);
    // Поля документа
    $sheet->getPageMargins()->setTop(1);
    $sheet->getPageMargins()->setRight(0.75);
    $sheet->getPageMargins()->setLeft(0.75);
    $sheet->getPageMargins()->setBottom(1);
    // Шапка и футер (при печати)
    $sheet->getHeaderFooter()
          ->setOddHeader('&L&B'.$rowO['object_name'])
          ->setOddFooter('&L&B'.$sheet->getTitle().'&RСтр. &P : &N');
    } //object
    $mysqli->close();
    //=============================Вывод в файл
    $objWriter = PHPExcel_IOFactory::createWriter($xls, "Excel2007");
    $objWriter->save($_SERVER['DOCUMENT_ROOT'].'/for_load_excel/make/object_'.$id_object.'.xlsx');
    //$objWriter->save('php://output');
  }  
    
}

function ramka(&$sheet,&$style,$c1,$n1,$c2,$n2) {
    $sheet->getStyle(CH_cell($c1).$n1.':'.CH_cell($c2).$n2)
            ->applyFromArray($style);    
}
function Get_implementer($mysqli,$id) {
    $imp='';
    if($id>0) {
      $sql='select * from i_implementer where id="'.$id.'"';
            //echo '<p/>'.$sql3;
        if( $result=$mysqli->query($sql)) {
            if( $row = $result->fetch_assoc() ){
                $imp=$row['implementer'];
            } 
        } 
    }
    return $imp;
}
function Next_row(&$sheet,$num_row) {
  $sheet->getRowDimension($num_row)->setRowHeight(-1);
}