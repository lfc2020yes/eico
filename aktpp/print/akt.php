<?php


function ITOGO_PAGE($count_page,$summa_page) {
?>    
<tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=10 height=20 class=xl1301011 style='height:15.0pt'>Итого</td>
  <td colspan=4 class=xl1431011>
  <?=MONEY($count_page,'.','');?>
  </td>
  <td colspan=3 class=xl1441011 style='border-left:none'>Х</td>
  <td colspan=2 class=xl1431011 style='border-left:none'>
  <?=MONEY($summa_page);?>
  </td>
 </tr>
<?php
}
 function NEW_PAGE() {   //   Перевод страницы
 ?>
 <tr height=18 style='page-break-before:always;mso-height-source:userset;height:14.25pt'>
  <td colspan=19 height=18 class=xl1281011 style='height:14.25pt'>&nbsp;</td>
 </tr></table>
 <?php
   MAKE_TABLE();
 }
 //-------------------Шапка таблицы постранично------------------->
 //--<thead style="display: table-header-group">-->
 function HEAD_TABLE() {
 ?>    
 
 <tr height=19 style='height:14.4pt'>
  <td colspan=19 height=19 class=xl1281011 style='height:14.4pt'>&nbsp;</td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:8.25pt'>
  <td height=10 class=xl721011 style='height:8.25pt;border-top:none'>&nbsp;</td>
  <td class=xl731011 style='border-top:none'>&nbsp;</td>
  <td colspan=2 rowspan=2 class=xl741011 width=175 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;'>Товарно-материальные<br>   
    ценности</td> <!--width:132pt-->
  <td rowspan=3 class=xl761011 width=94 style='border-top:none;width:71pt'>Характеристика</td>
  <td colspan=5 rowspan=2 class=xl741011 width=134 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:99pt'>Единица измерения</td>
  <td colspan=4 rowspan=3 class=xl741011 width=66 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:49pt'>Количество (масса)</td>
  <td colspan=5 rowspan=2 class=xl741011 width=133 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:99pt'>Оценка</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=2 rowspan=2 height=82 class=xl781011 width=37 style='border-right:
  .5pt solid black;border-bottom:.5pt solid black;height:61.5pt;width:27pt'>Но-<br>
    мер<br>
    по по-рядку</td>
 </tr>
 <tr height=62 style='mso-height-source:userset;height:46.5pt'>
  <td height=62 class=xl891011 width=129 style='height:46.5pt;border-top:none;
  '>наименование,<br> 
    вид упаковки</td>  <!--width:97pt-->
  <td class=xl761011 width=46 style='border-top:none;border-left:none;
  width:35pt'>код</td>
  <td colspan=2 class=xl831011 width=90 style='border-right:.5pt solid black;
  width:67pt'>наименование</td>
  <td colspan=3 class=xl901011 width=44 style='border-right:.5pt solid black;
  border-left:none;width:32pt'>код по ОКЕИ</td>
  <td colspan=3 class=xl911011 width=70 style='border-right:.5pt solid black;
  width:52pt'>цена,<br>
    руб. коп.</td>
  <td colspan=2 class=xl901011 width=63 style='border-right:.5pt solid black;
  border-left:none;width:47pt'>стоимость, руб. коп.</td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=2 height=17 class=xl671011 style='height:12.75pt'>1</td>
  <td class=xl681011 style='border-top:none;border-left:none'>2</td>
  <td class=xl691011 style='border-bottom:1.5pt solid black;'>3</td>
  <td class=xl691011 style='border-left:none;border-bottom:1.5pt solid black;'>4</td>
  <td colspan=2 class=xl701011>5</td>
  <td colspan=3 class=xl691011 style='border-left:none;border-bottom:1.5pt solid black;'>6</td>
  <td colspan=4 class=xl691011 style='border-left:none;border-bottom:1.5pt solid black;'>7</td>
  <td colspan=3 class=xl691011 style='border-left:none;border-bottom:1.5pt solid black;'>8</td>
  <td colspan=2 class=xl691011 style='border-left:none;border-bottom:1.5pt solid black;'>9</td>
 </tr>
 <!--</thead>-->
 <?php
 }
 
//* { -webkit-print-color-adjust: exact; } 
function MAKE_TABLE() {
?>

<!--<div id="LAW26072_0_20170927_131849_1011" align=center x:publishsource="Excel">-->

<table border=0 cellpadding=0 cellspacing=0 width=100% class=xl921011
 style='border-collapse:collapse;'>
 <col class=xl921011 width=18 style='mso-width-source:userset;mso-width-alt:
 625;width:13pt'>
 <col class=xl921011 width=19 style='mso-width-source:userset;mso-width-alt:
 682;width:14pt'>
 <col class=xl921011 width=129 style='mso-width-source:userset;mso-width-alt:
 4579;width:97pt'>
 <col class=xl921011 width=46 style='mso-width-source:userset;mso-width-alt:
 1649;width:35pt'>
 <col class=xl921011 width=94 style='mso-width-source:userset;mso-width-alt:
 3356;width:71pt'>
 <col class=xl921011 width=46 style='mso-width-source:userset;mso-width-alt:
 1621;width:34pt'>
 <col class=xl921011 width=44 style='mso-width-source:userset;mso-width-alt:
 1564;width:33pt'>
 <col class=xl921011 width=18 style='mso-width-source:userset;mso-width-alt:
 625;width:13pt'>
 <col class=xl921011 width=14 style='mso-width-source:userset;mso-width-alt:
 483;width:10pt'>
 <col class=xl921011 width=12 style='mso-width-source:userset;mso-width-alt:
 426;width:9pt'>
 <col class=xl921011 width=11 style='mso-width-source:userset;mso-width-alt:
 398;width:8pt'>
 <col class=xl921011 width=14 style='mso-width-source:userset;mso-width-alt:
 512;width:11pt'>
 <col class=xl921011 width=7 style='mso-width-source:userset;mso-width-alt:
 256;width:5pt'>
 <col class=xl921011 width=34 style='mso-width-source:userset;mso-width-alt:
 1194;width:25pt'>
 <col class=xl921011 width=10 style='mso-width-source:userset;mso-width-alt:
 341;width:7pt'>
 <col class=xl921011 width=48 style='mso-width-source:userset;mso-width-alt:
 1706;width:36pt'>
 <col class=xl921011 width=12 style='mso-width-source:userset;mso-width-alt:
 426;width:9pt'>
 <col class=xl921011 width=19 style='mso-width-source:userset;mso-width-alt:
 682;width:14pt'>
 <col class=xl921011 width=44 style='mso-width-source:userset;mso-width-alt:
 1564;width:33pt'>
 <?php
 }
 
 MAKE_TABLE();
 ?>
 
 <tr height=14 style='mso-height-source:userset;height:10.5pt'>
  <td colspan=7 height=14 class=xl1491011 width=396 style='height:10.5pt;
  width:297pt'><a name="RANGE!A1:S45"></a></td>
  <td colspan=12 class=xl631011 width=243 style='width:180pt'>Унифицированная
  форма № МХ-1</td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:10.5pt'>
  <td colspan=7 height=14 class=xl1491011 style='height:10.5pt'></td>
  <td colspan=12 class=xl631011>Утверждена постановлением Госкомстата России от
  09.08.99 № 66</td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:7.2pt'>
  <td colspan=19 height=10 class=xl1491011 style='height:7.2pt'></td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.5pt'>
  <td colspan=15 height=22 class=xl1491011 style='border-right:.5pt solid black;
  height:16.5pt'></td>
  <td colspan=4 class=xl941011 style='border-right:.5pt solid black;border-left:
  none'>Код</td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl921011 style='height:16.5pt'></td>
  <td colspan=14 class=xl931011>Форма по ОКУД<span
  style='mso-spacerun:yes'> </span></td>
  <td colspan=4 class=xl971011 style='border-right:1.5pt solid black'>0335001</td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl921011 style='height:16.5pt'></td>
  <td colspan=10 class=xl1001011>
  <?=$row_list1['name_company'];?>
  </td>
  <td colspan=4 class=xl931011>по ОКПО<span style='mso-spacerun:yes'> </span></td>
  <td colspan=4 class=xl1011011 style='border-right:1.5pt solid black'>&nbsp;</td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:8.25pt'>
  <td height=10 class=xl1041011 style='height:8.25pt'></td>
  <td colspan=10 class=xl651011>(организация-хранитель, адрес, телефон, факс)</td>
  <td colspan=4 class=xl1511011 style='border-right:1.5pt solid black'></td>
  <td colspan=4 rowspan=2 class=xl1051011 style='border-right:1.5pt solid black;
  border-bottom:.5pt solid black'>&nbsp;</td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl1041011 style='height:11.1pt'></td>
  <td colspan=14 class=xl1081011>&nbsp;</td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:10.8pt'>
  <td height=14 class=xl1041011 style='height:10.8pt'></td>
  <td colspan=10 class=xl661011>(структурное подразделение)</td>
  <td colspan=4 class=xl1531011 style='border-right:1.5pt solid black'>&nbsp;</td>
  <td colspan=4 rowspan=2 class=xl1051011 style='border-right:1.5pt solid black;
  border-bottom:.5pt solid black'>&nbsp;</td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:10.8pt'>
  <td height=14 class=xl921011 style='height:10.8pt'></td>
  <td colspan=14 class=xl931011>Вид деятельности по ОКДП<span
  style='mso-spacerun:yes'> </span></td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl921011 style='height:16.5pt'></td>
  <td colspan=10 class=xl1001011>
  <?=$row_list[name0];?>    
  </td>
  <td colspan=4 class=xl931011>по ОКПО<span style='mso-spacerun:yes'> </span></td>
  <td colspan=4 class=xl1011011 style='border-right:1.5pt solid black'>&nbsp;</td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:8.25pt'>
  <td height=10 class=xl1041011 style='height:8.25pt'></td>
  <td colspan=10 class=xl651011>(поклажедатель (наименование, адрес, телефон,
  факс</td>
  <td colspan=4 class=xl1511011 style='border-right:1.5pt solid black'></td>
  <td colspan=4 rowspan=2 class=xl1051011 style='border-right:1.5pt solid black;
  border-bottom:.5pt solid black'>&nbsp;</td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl1041011 style='height:11.1pt'></td>
  <td colspan=14 class=xl1081011>
  &nbsp;
  </td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl921011 style='height:16.5pt'></td>
  <td class=xl921011></td>
  <td class=xl921011></td>
  <td class=xl641011 colspan=2>фамилия, имя, отчество))</td>
  <td colspan=7 class=xl1121011 style='border-right:.5pt solid black'>Договор<span
  style='mso-spacerun:yes'> </span></td>
  <td colspan=3 class=xl1141011 style='border-left:none'>номер<span
  style='mso-spacerun:yes'> </span></td>
  <td colspan=4 class=xl1011011 style='border-right:1.5pt solid black'>&nbsp;</td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.5pt'>
  <td colspan=12 height=22 class=xl1491011 style='border-right:.5pt solid black;
  height:16.5pt'></td>
  <td colspan=3 class=xl1161011 style='border-left:none'>дата<span
  style='mso-spacerun:yes'> </span></td>
  <td colspan=4 class=xl1011011 style='border-right:1.5pt solid black'>&nbsp;</td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl921011 style='height:16.5pt'></td>
  <td colspan=14 class=xl931011>Вид операции<span
  style='mso-spacerun:yes'> </span></td>
  <td colspan=4 class=xl1181011 style='border-right:1.5pt solid black'>&nbsp;</td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td colspan=19 height=19 class=xl1491011 style='height:14.4pt'></td>
 </tr>
 <tr height=28 style='mso-height-source:userset;height:21.0pt'>
  <td colspan=6 height=28 class=xl1491011 style='border-right:.5pt solid black;
  height:21.0pt'></td>
  <td colspan=7 class=xl1211011 width=120 style='border-right:.5pt solid black;
  border-left:none;width:89pt'>Номер<span
  style='mso-spacerun:yes'>                 </span>документа</td>
  <td colspan=3 class=xl1211011 width=92 style='border-right:.5pt solid black;
  border-left:none;width:68pt'>Дата<span
  style='mso-spacerun:yes'>               </span>составления</td>
  <td colspan=3 class=xl1551011 style='border-left:none'>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.6pt'>
  <td colspan=5 height=21 class=xl1491011 style='height:15.6pt'></td>
  <td class=xl1471011>АКТ<span style='mso-spacerun:yes'> </span></td>
  <td colspan=7 class=xl1241011 style='border-right:1.5pt solid black'>
  <?=$row_list['number'];?>
  </td>
  <td colspan=3 class=xl1241011 style='border-right:1.5pt solid black;
  border-left:none'>
  <?=$row_list['date'];?>
  </td>
  <td colspan=3 class=xl1561011 style='border-left:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=19 height=20 class=xl1481011 style='height:15.0pt'>О
  ПРИЕМЕ-ПЕРЕДАЧЕ ТОВАРНО-МАТЕРИАЛЬНЫХ ЦЕННОСТЕЙ НА ХРАНЕНИЕ</td>
 </tr>
 <tr height=38 style='mso-height-source:userset;height:28.5pt'>
  <td colspan=2 height=38 class=xl1491011 style='height:28.5pt'></td>
  <td class=xl1271011 colspan=4>Акт составлен о том, что приняты на хранение</td>
  <td colspan=13 class=xl1491011></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td colspan=8 height=19 class=xl1101011 style='height:14.4pt'>объкт №7</td>
  <td class=xl921011></td>
  <td colspan=9 class=xl1281011>&nbsp;</td>
  <td class=xl1271011>дней</td>
 </tr>
 <tr height=13 style='mso-height-source:userset;height:9.6pt'>
  <td colspan=8 height=13 class=xl661011 style='height:9.6pt'>(наименование,
  номер места хранения)</td>
  <td class=xl1291011></td>
  <td colspan=9 class=xl661011>(срок хранения)</td>
  <td class=xl921011></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1271011 colspan=5 style='height:14.4pt'>следующие
  товарно-материальные ценности:</td>
  <td colspan=14 class=xl1491011></td>
 </tr>
 <?=HEAD_TABLE();?>
 <!--<tbody>-->
 <!-------------------------содержание акта ---------->
 <?php
    $count_page=0;
    $count=0;
    $summa=0;
    $summa_page=0;
    $row_page=0;
    $number_page=0;
    $sql_MAT='select * from z_act_material m, z_stock s 
                 where m.id_act="'.htmlspecialchars(trim($_GET["id"])).'"
                 and m.id_stock=s.id
                 order by s.name 
                ';
    $result_MAT=mysql_time_query($link,$sql_MAT);
    if ($result_MAT->num_rows>0) {
        for ($m=0;$m<$result_MAT->num_rows;$m++) {
                $row_MAT= mysqli_fetch_assoc($result_MAT);
    //---------------------конкретная позиция            
 ?>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=2 height=20 class=xl1341011 style='height:15.0pt'>
  <?=($m+1);?>
  </td>
  <td class=xl1351011 width=129 style='border-top:none;border-left:none;'>    <!--width:97pt-->
  <?=$row_MAT['name'];?>
  </td>
  <td class=xl1361011 style='border-top:none;'>&nbsp;</td>
  <td class=xl1371011 width=94 style='border-left:none;border-top:none;width:71pt'>&nbsp;</td>
  <td colspan=2 class=xl1381011>
  <?=$row_MAT['units'];?>
  </td>
  <td colspan=3 class=xl1361011 style='border-top:none;'>&nbsp;</td>
  <td colspan=4 class=xl1411011 style='border-left:none;border-top:none;border-bottom:1.0pt solid black;'>
  <?=MONEY($row_MAT['count_units'],'.','');?>
  </td>
  <td colspan=3 class=xl1411011 style='border-left:none;border-top:none;border-bottom:1.0pt solid black;'>
  <?=MONEY($row_MAT['price_nds']);?>
  </td>
  <td colspan=2 class=xl1411011 style='border-right:1.5pt solid black;border-left:none;border-top:none;border-bottom:1.0pt solid black;'>
  <?=MONEY($row_MAT['subtotal']);?>
  </td>
 </tr>
 <?php
        $count_page+=$row_MAT['count_units'];
        $count+=$row_MAT['count_units'];
        $summa_page+=$row_MAT['subtotal'];
        $summa+=$row_MAT['subtotal'];
        $row_page++;
         
        if ($number_page==0) {  //первая страница
        if ($row_page==$size_page[$type_page][1] && $m<($result_MAT->num_rows)-1)  {
            ITOGO_PAGE($count_page,$summa_page);
            NEW_PAGE();
            HEAD_TABLE();
            $number_page++;
            $row_page=0;
            $count_page=0;
            $summa_page=0;
        }} else {
        if ($row_page==$size_page[$type_page][2])  {
            ITOGO_PAGE($count_page,$summa_page);
            NEW_PAGE();
            HEAD_TABLE();
            $number_page++;
            $row_page=0;
            $count_page=0;
            $summa_page=0;
        }    
        }
      } //for
    }
 if ($number_page>0)   
 ITOGO_PAGE($count_page,$summa_page);   
 ?>
 
 
 <!-------------------------Итого в документе---------------->
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=10 height=20 class=xl1311011 style='height:15.0pt'>Всего по акту</td>
  <td colspan=4 class=xl1431011>
  <?=MONEY($count,'.','');?>
  </td>
  <td colspan=3 class=xl1441011 style='border-left:none'>Х</td>
  <td colspan=2 class=xl1431011 style='border-left:none'>
  <?=MONEY($summa);?>
  </td>
 </tr>
 
 <?php
 if ($number_page==0) {  //только одна страница
 if ($row_page>$size_page[$type_page][0])      NEW_PAGE(); 
 } else {
 if ($row_page>$size_page[$type_page][3])      NEW_PAGE(); 
 }    
 ?>
 
 <tr height=18 style='mso-height-source:userset;height:13.8pt'>
  <td height=18 class=xl1271011 colspan=3 style='height:13.8pt'>Условия
  хранения</td>
  <td colspan=16 class=xl1281011>&nbsp;</td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:14.25pt'>
  <td colspan=19 height=18 class=xl1281011 style='height:14.25pt'>&nbsp;</td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:14.25pt'>
  <td colspan=19 height=18 class=xl1281011 style='height:14.25pt'>&nbsp;</td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1271011 colspan=3 style='height:14.4pt'>Особые отметки</td>
  <td colspan=16 class=xl1321011>&nbsp;</td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:14.25pt'>
  <td colspan=19 height=18 class=xl1281011 style='height:14.25pt'>&nbsp;</td>
 </tr>
 <!--   Перевод страницы
 <tr height=18 style='page-break-before:always;mso-height-source:userset;height:14.25pt'>
  <td colspan=19 height=18 class=xl1281011 style='height:14.25pt'>&nbsp;</td>
 </tr>
 -->
 <tr height=30 style='mso-height-source:userset;height:23.25pt'>
  <td colspan=19 height=30 class=xl1571011 style='height:23.25pt'>Товарно-материальные ценности
      <span style='mso-spacerun:yes'> </span></td>
 </tr>
 <tr height=30 style='mso-height-source:userset;height:22.5pt'>
  <td height=30 class=xl921011 style='height:22.5pt'></td>
  <td class=xl921011></td>
  <td class=xl1461011><span style='mso-spacerun:yes'> </span>Сдал</td>
  <td colspan=4 class=xl1451011>
  <?=name_role($link,$row_list['id_role0']);?>
  </td>
  <td class=xl921011></td>
  <td colspan=5 class=xl1281011>&nbsp;</td>
  <td class=xl921011></td>
  <td colspan=5 class=xl1281011>
  <?=$row_list['name0'];?>
  </td>
 </tr>
 <tr height=18 style='height:13.8pt'>
  <td colspan=3 height=18 class=xl1491011 style='height:13.8pt'></td>
  <td colspan=4 class=xl661011>(должность)</td>
  <td class=xl1331011></td>
  <td colspan=5 class=xl661011>(подпись)</td>
  <td class=xl921011></td>
  <td colspan=5 class=xl661011>(расшифровка подписи)</td>
 </tr>
 <tr height=18 style='height:13.8pt'>
  <td colspan=3 height=18 class=xl1491011 style='height:13.8pt'></td>
  <td class=xl931011>М.П.</td>
  <td colspan=15 class=xl1491011></td>
 </tr>
 <tr height=29 style='mso-height-source:userset;height:21.75pt'>
  <td height=29 class=xl921011 style='height:21.75pt'></td>
  <td class=xl921011></td>
  <td class=xl1461011><span style='mso-spacerun:yes'> </span>Принял</td>
  <td colspan=4 class=xl1451011>
  <?=name_role($link,$row_list['id_role1']);?>
  </td>
  <td class=xl921011></td>
  <td colspan=5 class=xl1281011>&nbsp;</td>
  <td class=xl921011></td>
  <td colspan=5 class=xl1281011>
  <?=$row_list['name1'];?>
  </td>
 </tr>
 <tr height=18 style='height:13.8pt'>
  <td colspan=3 height=18 class=xl1491011 style='height:13.8pt'></td>
  <td colspan=4 class=xl661011>(должность)</td>
  <td class=xl1331011></td>
  <td colspan=5 class=xl661011>(подпись)</td>
  <td class=xl921011></td>
  <td colspan=5 class=xl661011>(расшифровка подписи)</td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td colspan=3 height=20 class=xl1491011 style='height:15.0pt'></td>
  <td class=xl931011>М.П.</td>
  <td colspan=15 class=xl1491011></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=18 style='width:13pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=129 style='width:97pt'></td>
  <td width=46 style='width:35pt'></td>
  <td width=94 style='width:71pt'></td>
  <td width=46 style='width:34pt'></td>
  <td width=44 style='width:33pt'></td>
  <td width=18 style='width:13pt'></td>
  <td width=14 style='width:10pt'></td>
  <td width=12 style='width:9pt'></td>
  <td width=11 style='width:8pt'></td>
  <td width=14 style='width:11pt'></td>
  <td width=7 style='width:5pt'></td>
  <td width=34 style='width:25pt'></td>
  <td width=10 style='width:7pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=12 style='width:9pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=44 style='width:33pt'></td>
 </tr>
 <![endif]>
 <!--</tbody>-->
</table>

</div>


