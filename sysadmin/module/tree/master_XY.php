<html xmlns="http://www.w3.org/1999/xhtml">
<?php
//define ("DirR","http://www.ulyanovskmenu.ru");
//===================MASTER===========
// 	row_tree-<_TREE  запись заголовка формы
/*
--------------------------------------------------------------------------------
выбор полей из _FORM where PARAGRAF=$row_TREE['PARAGRAF'] order by MASTER,displayOrder ;
обойти все поля:
 MASTER='' - отражать как edit
 MASTER='FILTER' заполнить массив $FILTER   -> ['id_film']=''   - рисовать поля on_change
 MASTER='MASTER' заполнить массив $MASTER   -> ['id_cinema']=''
 MASTER='SLAVE' заполнить массив $SLAVE -> ['time']=''

разрешение на заполнение SLAVE получается по событию on_change по заполнению всего $FILTER
   Обход по $MASTER если count>0
     Вызов рекурсивно
     Строить поля $SLAVE
--------------------------------------------------------------------------------
*/
//      ???использует $_GET["id"]
//  $_GET['id']==id записи в _TREE c информацией:  (для предустановленных значений)
/*
                           PARAGRAF
                           NAME
                           TYPE_FORM
                           ID_TABLE
*/
//  parent_TITLE - текст в форме (edit)            -> sys_TEXT
//  parent_COLUMN - название кнопки подтверждения  -> sys_BUTTON
//  приоритеты:
//  1.FILTER - программа выполнения этой формы по подтверждению ->sys_URL
//  2.ID_ORDER - основной SELECT исполнения                     ->sys_SQL
//  _FORM - возможно не использует

function FORM_master_XY(&$row_TREE)
{
  $user='';
  $MASK='';
  $uNAME='';
  $uPARENT='';
  $FINDD='';
  GET_MASK_USER(&$user,&$row_TREE,&$MASK,&$uNAME,&$uPARENT,&$FINDD,&$FD);

 if (FIND_SYS(&$row_TREE)===false) $SyS=false;
 else                              $SyS=true;    //системной формы
 if ($SyS)   { $bgcolor='bgcolor=#FFFFCC';   }
 else        { $bgcolor='bgcolor=white';     }

  //выбрать форму
 $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" order by MASTER,displayOrder';
 $result_FORM=mysql_query($sql_FORM);
 $num_results_FORM = mysql_num_rows($result_FORM);
 echo_pp(&$row_TREE,$sql_FORM);

 //=================выбрать даные по текущей строке
 $where='';
 $and=' where ';


 if (array_key_exists('id', $_GET))
 {    $where.=$and.' id='.$_GET["id"];        //для FORM_MENU где нет ID
      $and=' and ';
 }
 else
 if (array_key_exists('in', $_GET))        //Альтернативный запуск
 {    $where.=$and.$row_TREE['ID_COLUMN'].'='.$_GET["in"];
      $and=' and ';
 }
 //------------ Проверка на маску в _FIND
 if ($MASK<>'')                                 //Фильтр пользователя
 {  if (isFIELD($FD, $row_FORM["SOURCE_TABLE"])==true)
          {           $where.=$and.$MASK;
                      $and=' and ';
          }
 }
 //------------Фильтр формы
 if ($row_TREE["FILTER"]>'')            //Дополнительный простой фильтр на выбор
 { $where.=$and.$row_TREE["FILTER"];
 }

 $sql_data='select * from '.$row_TREE["ID_TABLE"].$where;

 //------------
 $result_data=mysql_query($sql_data);
 $num_results_data = mysql_num_rows($result_data);
 echo_pp(&$row_TREE,$sql_data);

// показать форму                                                                                         //onsubmit="return false;"
?>
<div id="main">

<form id="MS" enctype="multipart/form-data" action="<? echo (MODUL.dTREE().dFORM.$row_TREE["PARAGRAF"]); ?>" name="MS"  method="post" class="theform" >
<input type="hidden" name="do" value="<? echo($row_TREE["PARAGRAF"]); ?>" />

  <table id="mtt" cellspacing="0" <?=$bgcolor ?> class="theform" align="left" >
  <caption><div style="padding:3px;"><?=$row_TREE["PARAGRAF"].': '.$row_TREE["NAME"]?></div></caption>
<!--  <hr align="center" width="600"; -->
<!--
  <tr>
    <td style="padding-right: 10px"><?=$row_TREE["PARAGRAF"]?></td>
    <td style="padding-right: 10px"><?=$row_TREE["TYPE_FORM"]?></td>
  </tr>
-->
  <tr>
    <td COLSPAN=2 style="padding-right: 10px"><?=$row_TREE["sys_URL"]?></td>
  </tr>
<?


 if($num_results_data>0)      // Зачем нужны данные????? - не работает если таблица вообще пуста
 {
  $row_data = mysql_fetch_array($result_data);
  $data_FLD=$row_data[$row_FORM["COLUMN_FIELD"]];
 }
 else
 {  $row_data =0;	 $data_FLD=''; }

  $FILTER=''; $SPR1='';
  $XXX='';    $SPR2='';
  $YYY='';    $SPR3='';
  $ZZZ='';    $SPR4='';
  for($i=0; $i<$num_results_FORM; $i++)     //по полям формы
  {
    $row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме
    if ($row_FORM["VISIBLE"]==false)continue;
    switch ($row_FORM["MASTER"])
    {
      case '':
               FIELD_EDIT(&$row_FORM, &$row_TREE, $data_FLD, &$row_data, dFORM.$row_TREE["PARENT"],'','');
               break;
      case 'FILTER':
               $FILTER.=$SPR1.$row_FORM["COLUMN_FIELD"].':'.$row_FORM["id"];
               $SPR1=':';
               break;
      case 'X':
               $XXX.=$SPR2.$row_FORM["COLUMN_FIELD"].':'.$row_FORM["id"];
               $SPR2=':';
               break;
      case 'Y':
               $YYY.=$SPR3.$row_FORM["COLUMN_FIELD"].':'.$row_FORM["id"];
               $SPR3=':';
               break;
      case 'Z':
               $ZZZ.=$SPR4.$row_FORM["COLUMN_FIELD"].':'.$row_FORM["id"];
               $SPR4=':';
               break;    } //switch
  } //Обход первый раз формы и заполнение массивов
  //-----------------------------Установить onChange на фильтр
  $FLT=explode(':',$FILTER);
  echo_pp(&$row_TREE,'$FILTER->'.$FILTER);  //
  echo_pp(&$row_TREE,'$XXX->'.$XXX);  //
  echo_pp(&$row_TREE,'$YYY->'.$YYY);    //
  echo_pp(&$row_TREE,'$ZZZ->'.$ZZZ);    //
  //------------Формирование блока фильтер
  //$DR='.';                               //$DR='http://www.ulyanovskmenu.ru';
  for ($i=1;$i<count($FLT);$i+=2)
  {
    $SQL_FLD=new TSQL('select * from _FORM where id="'.$FLT[$i].'"');
    $SQL_FLD->NEXT();
    if($num_results_data>0) $data_FLD=$row_data[$SQL_FLD->row["COLUMN_FIELD"]];

    FIELD_EDIT(&$SQL_FLD->row, &$row_TREE,  $data_FLD ,&$row_data, dFORM.$row_TREE["PARENT"],'',
      $row_TREE["sys_URL"],$FILTER.'|'.$XXX.'|'.$YYY.'|'.$ZZZ.'|'.$user.'|'.$_GET['DB']         //$FILTER.'|'.$MASTER.'|'.$SLAVE
    );    //$i++;
  }
  if ($row_TREE["kind_ADD"])
  {                 //WIDTH="60px" NOWRAP
    echo '<td  NOWRAP><input type="radio" name="ADD" value="ADD" >  Добавить   ';
    echo '<input type="radio" name="ADD" value="EDIT" checked>  Редактировать';
    echo   '<td>';
  }
  else  echo   '<td COLSPAN=2>';

    BUTTON("button",'Запрос','/images/tree_S/application_windows_okay.png'
       ,$row_TREE["sys_URL"].'(\''.$FILTER.'|'.$XXX.'|'.$YYY.'|'.$ZZZ.'|'.$user.'|'.$_GET['DB'].'\',\'BTN\');  return false;'
       ,'cursive');

    echo   '</td></tr>';

  echo '<tr><td COLSPAN=2>';              //width="700"  class="theform"
  echo '<table id="mt" cellspacing="0"  align="left" cellpadding="0" rules="cols" border="1">';   //align="left"
  //echo '<tr><td  style="padding-right: 10px"> --XY---XY---XY--';          //Область для размещения данных

  echo '</table>';
  echo '</td></tr>';


 SHOW_tfoot(2,1,1,1);
?>
	</table>
</form>
</div>
<?
  return true;
}




/*
Построение имен формы:
total_row - количество строк данных
total_col - количество столбцов данных

id_$row - id строки данных
field $col $row - поле столбца данных
поле $col $row - поле sel для выбора строки для редактирования   0.$row
*/
    function FORM_master_XY_post(&$row_TREE)
{


 $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" and MASTER="SLAVE" order by displayOrder';
 $result_FORM=mysql_query($sql_FORM);
 $num_results_FORM = mysql_num_rows($result_FORM);
 echo "\n ".$sql_FORM;
 for($i=0; $i<$num_results_FORM; $i++)    //Прочитать информацию по SLAVE полям
 {
    $row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме
    if ($row_FORM["VISIBLE"]==false)continue;
    $M_MET['TYPE_FIELD'][]  =$row_FORM["TYPE_FIELD"];
    $M_MET['COLUMN_FIELD'][]=$row_FORM["COLUMN_FIELD"];
 }
 //Выбор способа изменение ADD/UPDATE
switch  ($_POST["ADD"])
{  case "ADD":        //------------------------- Добавить записи
 for ( $i=0; $i<$_POST['total_row'];$i++)  //обход по строкам формы
 {
   if (GET_CHECK('0'.$i)>0) //поле sel для выбора строки для добавления
   {
     $STR='insert into '.$row_TREE["ID_TABLE"].' (';
     $DAT='value (';                    //значения собираем в  $EXP[]
     $ZP=' ';
     $status=0;
     for ($j=1; $j<$_POST['total_col'];$j++)  //Обход по полям строки  (первой пропускаем
     {
        $FLD=$M_MET["COLUMN_FIELD"][$j].$j.$i;
        if ($M_MET["COLUMN_FIELD"]=='id')  continue;
        if ($M_MET["TYPE_FIELD"][$j]=="del") continue;
        if ($M_MET["TYPE_FIELD"][$j]=="sel") continue;
        if ($_POST[$FLD]=='')continue;                //Незаолненные поляпропускаем
        switch ($M_MET["TYPE_FIELD"][$j])
        {
          case 'bool':            //ComboBOX
                      $CHK=GET_CHECK($FLD);
                      break;
           default:                         //поле int или test - не checkbox
                      $CHK='"'.$_POST[$FLD].'"';
        } //swith TYPE_FIELD
        $STR.=$ZP.$M_MET["COLUMN_FIELD"][$j];
        $DAT.=$ZP.$CHK;
        $ZP=',';
     } //total col
     // ---------------------дописать значения полей всех фильтров
     GET_MASTER('FILTER',&$row_TREE,&$STR,&$DAT,&$ZP);

     // ---------------------дописать значения полей всех мастеров строки мастеров
     GET_MASTER('MASTER',&$row_TREE,&$STR,&$DAT,&$ZP,$i,1);      //с PREF и key=1
     // ---------------------дописать связанное поле со значением  (вроде не используется
	  if  ($row_TREE['parent_TABLE']<>''
	        and (array_key_exists('in', $_GET))
	        and ($_GET['in']>0))
	  {   $STR.=$SMC.$row_TREE['ID_COLUMN'];
	      $DAT.=$SMC.'"'.$_GET['in'].'"';
	  }
     //---------------------дописать фильтр [type="left"]
	  if  ($row_TREE['FILTER']<>'')
	  {  $FLT=explode('=',$row_TREE['FILTER']);
	     if (count($FLT)==2)         //Фильтр только одного поля через равно
	     {
	     	$STR.=$ZP.$FLT[0];
	     	$DAT.=$ZP.$FLT[1];
	     }
	  }
	  $STR.=') '.$DAT.')';
      echo_pp(&$row_TREE,$STR);
      if(!mysql_query($STR))          //Выполнить INSERT
         echo "\n <p> Ошибка INSERT master</p>";
   } //CHECK
 } //for

                break;
   case "EDIT":       //------------------------- UPDATE
   default:


 for ( $i=0; $i<$_POST['total_row'];$i++)    //обход по строкам формы
 {
   if (GET_CHECK('0'.$i)>0) //поле sel для выбора строки для редактирования
   {
     $SQL='update '.$row_TREE["ID_TABLE"].' set';
     $ZP=' ';
     $status=0;
     for ($j=1; $j<$_POST['total_col'];$j++)  //Обход по полям строки
     {
      $FLD=$M_MET["COLUMN_FIELD"][$j].$j.$i;
      if ($M_MET["TYPE_FIELD"][$j]=="del")              //Специальное поле - пропустить если 0
      { $CHK=GET_CHECK($FLD);
        if ($CHK==0) continue;
        else
        { $SQL='delete FROM '.$row_TREE["ID_TABLE"].' where id="'.$_POST['id_'.$i].'"';
          echo_pp(&$row_TREE,'DELETE!='.$SQL); //
          if(!mysql_query($SQL))
             echo "\n Ошибка DELETE";
          $status=-1;      //производилось удаление записи
          break;        }
      }
      else 	// Редактирование
      {

        switch ($M_MET["TYPE_FIELD"][$j])
        {          case 'bool':            //ComboBOX
                      $CHK=GET_CHECK($FLD);
                      break;
           default:                         //поле int или test - не checkbox
                      $CHK='"'.$_POST[$FLD].'"';        }
        $SQL.=$ZP. $M_MET["COLUMN_FIELD"][$j] . '=' . $CHK;
        $ZP=',';
      }
     } //col
     if ($status==0)
     { $SQL.=' where id="'.$_POST['id_'.$i].'"';
       echo_pp(&$row_TREE,$SQL);                   ///
       if(!mysql_query($SQL))
           echo "\n Ошибка UPDATE master";
     }
   } //check }	//row
}  //swith

}


?>
</html>
