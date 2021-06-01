<html xmlns="http://www.w3.org/1999/xhtml">
<?php

//==============================Форма удаления по _TREE и _FORM
// 	row_tree-<_TREE  запись заголовка формы
//      использует $_GET["id"]


function FORM_delete(&$row_TREE)
{
 $Source=array();                      //Для сохранения &child
 GET_SOURCE(&$row_TREE,&$Source);     //Прочитать фильтры

  //выбрать форму
 $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" order by displayOrder';
 echo "\n".$sql_FORM;
 $result_FORM=mysql_query($sql_FORM);
 $num_results_FORM = mysql_num_rows($result_FORM);

  //выбрать даные по текущей строке
 $sql_data='select * from '.$row_TREE["ID_TABLE"].' where id='.$_GET["id"];
 echo "\n".$sql_data;
 $result_data=mysql_query($sql_data);
 $num_results_data = mysql_num_rows($result_data);

 if($num_results_data>0)
 {
  $row_data = mysql_fetch_array($result_data);
  $back_URL=MAKE_URL('FORM',$row_TREE["PARENT"],array('atr','id'));
                                              //MODUL.dTREE().dFORM.$row_TREE["PARENT"].GET_PARENT(&$row_TREE).$Source[6]
// показать форму
?>
<div id="main">

<form enctype="multipart/form-data" action=<? echo ($back_URL); ?> name="theform" method="post" class="theform" >
  <input type="hidden" name="do"      value="<? echo($row_TREE["PARAGRAF"]); ?>" />
<!--  <input type="hidden" name="oldname" value="" /> -->

  <table cellspacing="0" class="theform" align="left" border="1">
  <caption><div style="padding:3px;"><? echo($row_TREE["NAME"].SCOBA($Source[0])); ?></div></caption>

<?
  for($i=0; $i<$num_results_FORM; $i++)
  {
    $row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме
    $FLD=$row_FORM["COLUMN_FIELD"];
    if ($row_FORM["NONEDIT"]==1)
         $DSL='disabled';
    else $DSL='';
    switch ($row_FORM["TYPE_FIELD"])
    { case 'bool':   //===========================//поле галка (checkbox)
?>
    <tr>
    <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
    <td>
<?
    if($row_data[$FLD]==1)
      $CHK='checked'; else $CHK='';
    echo '<input class="checkbox" type="checkbox" name="'.$FLD.'"  value="'.$row_data[$FLD].'" '.$CHK.' '.$DSL.'/>';
    ?>
	<div id="theform_visible_error" class="error" style="display:none"></div>
    </td>
    </tr>
<?
                   break;
      case 'file':     //===========================
                   break;
      case 'jpg':     //===========================
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?
      $EXP=GET_EXT($row_FORM['CHILD']);
      echo '<img src="..'.$row_FORM['FILE_DIR'].$row_data['id'].$EXP.'" />';   //добавил ..перед\
?>
	<div id="theform_visible_error" class="error" style="display:none"></div>
    </td>
    </tr>
<?
                   break;
      case 'flash':
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?
        $DR='http://www.ulyanovskmenu.ru'; //$_SERVER["DOCUMENT_ROOT"]
        $FNR=$DR.$row_FORM['FILE_DIR'].$row_data['id'].'.swf';                     //Полное имя файла
        $FN=  array_pop(explode("/",$DR.$row_FORM['FILE_DIR'].$row_data['id']));   //Имя без расширения
        //echo_dd(&$row_TREE,$FNR.'=='.$FN);     //\'http://www.ulyanovskmenu.ru/i/FLASH/top_'.$row_x["id"].'.swf
        echo '<script type="text/javascript"> writeFlash('.$row_data["weight"].','.$row_data["height"].',"'.$FNR.'","'.$FN.'"); </script>';
?>
    <div id="theform_visible_error" class="error" style="display:none"></div>
    </td>
    </tr>
<?
                   break;
       case 'point':   //Это производное поле графического файла из связанной таблицы
?>
    <tr>
      <td style="padding-right: 10px"><? echo GET_NAME(&$row_FORM).' ['.$row_FORM["FILE_DIR"].']';?>:</td>
      <td>
<?
         echo '<img src="..'.$row_FORM['FILE_DIR'].$row_data[$FLD].'.jpg" />';   //добавил ..перед\
         //echo '</td></tr><tr><td></td><td>';
      /*
         echo'<select name="'.$FLD.'" class="text" >';
         echo'<option value = "0">пусто</option>';
         if ($row_FORM['SOURCE_FILTER']<>'')           //Дополнительный фильтр на выбор поля из связанной таблицы
         { $Where=' where '.$row_FORM['SOURCE_FILTER'];
         } else $Where='';

         $sql_P = new Tsql('select * from '.$row_FORM['SOURCE_TABLE'].$Where.' order by '.$row_FORM['SOURCE_ID']);
         for($k=0; $k<$sql_P->num; $k++)
         { $sql_P->NEXT();
           if($sql_P->row[$row_FORM['SOURCE_ID']]==$row_data[$FLD])
	       echo'<option selected="selected" value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$sql_P->row[$row_FORM['SOURCE_FIELD']].'</option>';
	       else
           echo'<option value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$sql_P->row[$row_FORM['SOURCE_FIELD']].'</option>';
         }
         echo'</select>';
		 echo'<div id="theform_title_error" class="error" style="display:none"></div>';
		*/
?>
	<div id="theform_visible_error" class="error" style="display:none"></div>
    </td>
    </tr>
<?
      default:         //=========================== //поле int или test - не checkbox
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?
      if ($row_FORM['SOURCE_TABLE']<>"")     //Это производное поле из связанной таблицы
      {
         echo'<select '.$DSL.' name="'.$FLD.'" class="text" >';
         echo'<option value = "0">пусто</option>';

         $sql_P = new Tsql('select * from '.$row_FORM['SOURCE_TABLE'].' order by '.$row_FORM['SOURCE_ID']);
         for($k=0; $k<$sql_P->num; $k++)
         { $sql_P->NEXT();
           if($sql_P->row[$row_FORM['SOURCE_ID']]==$row_data[$FLD])
	       echo'<option selected="selected" value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$sql_P->row[$row_FORM['SOURCE_FIELD']].'</option>';
	       else
           echo'<option value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$sql_P->row[$row_FORM['SOURCE_FIELD']].'</option>';
         }
         echo'</select>';
      }
      else
      {              //Простое поле text

?>
        <input <? echo($DSL); ?> class="text"  name="<? echo($FLD); ?>" size="<? echo($row_FORM["COLUMN_SIZE"]); ?>" value="<? echo($row_data[$FLD]); ?>" />
<?    }    ?>
        <div id="theform_name_error" class="error" style="display:none"></div>
      </td>
   </tr>
<?
    } //switch

  } //for

//-------------------------------Конец формы  DELETE
SHOW_tfoot(2,1,0,$back_URL);
?>
<!--
		<tfoot>
		<tr>
		<td colspan="2">
			<input type="submit" class="button"  value="Удалить" />
            <input type="button" class="button"  value="Отменить" onclick="history.back(-1)"/>
		</td>
		</tr>
		</tfoot>
-->
	</table>
</form>
</div>
<?
 }  //if data
 return true;
}

// Удаление записи
    function FORM_delete_post($TABLE)
{
  $sql_d='delete FROM '.$TABLE.' where id="'.$_POST['id'].'"';
  echo "\n ".$sql_d;      ///
  mysql_query($sql_d);
}


?>
</html>
