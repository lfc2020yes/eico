<html xmlns="http://www.w3.org/1999/xhtml">
<?php

//===================MAKE===========Форма выполнения вспомогательных программ SYS по _TREE и _FORM
// 	row_tree-<_TREE  запись заголовка формы
//      ???использует $_GET["id"]
//  $_GET['id']==id записи в _TREE c информацией:  (дляпредустановленных значений)
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

function FORM_make(&$row_TREE)
{
 if (FIND_SYS(&$row_TREE)===false) $SyS=false;
 else                              $SyS=true;    //системной формы
 if ($SyS)   { $bgcolor='bgcolor=#FFFFCC';   }
 else        { $bgcolor='bgcolor=white';     }

 //Выбрать данные из _TREE по id
 $sql_MT=new Tsql('select * from '.$row_TREE["ID_TABLE"].' where id='.$_GET["id"]);
 if ($sql_MT->num>0)
 { $sql_MT->NEXT();


// показать форму
?>
<div id="main">

<form enctype="multipart/form-data" action=<? echo (MODUL.dTREE().dFORM.'sys.table&in='.$sql_MT->row["PARAGRAF"]); ?> name="theform" method="post" class="theform" >
<input type="hidden" name="do"      value="<? echo($row_TREE["PARAGRAF"]); ?>" />

  <input type="hidden" name="PARAGRAF"      value="<? echo($sql_MT->row["PARAGRAF"]); ?>" />
  <input type="hidden" name="TYPE_FORM"     value="<? echo($sql_MT->row["TYPE_FORM"]); ?>" />
  <input type="hidden" name="ID_TABLE"      value="<? echo($sql_MT->row["ID_TABLE"]); ?>" />

  <table cellspacing="0" <?=$bgcolor ?> class="theform" align="left" border="1">
  <caption><div style="padding:3px;"><?=$row_TREE["NAME"]?></div></caption>

  <tr>
    <td style="padding-right: 10px"><?=$sql_MT->row["PARAGRAF"]?></td>
    <td style="padding-right: 10px"><?=$row_TREE["TYPE_FORM"]?></td>
  </tr>
  <tr>
    <td style="padding-right: 10px"><?=$row_TREE["sys_TEXT"].' ['.$sql_MT->row["NAME"].'='.$sql_MT->row["ID_TABLE"].']'?></td>
  </tr>
  <?
  SHOW_tfoot(2,1,0,1);
  ?>
	</table>
</form>
</div>
<?
 } //-->num
 return true;
}

//=======================================  Запуск MAKE
/*                         $_POST
                           PARAGRAF
                           TYPE_FORM
                           ID_TABLE
 читать поля из ID_TABLE
 и писать в _FORM
 $row_TREE - указывает на форму [FORM_MAKE]
*/
    function FORM_make_post(&$row_TREE)
{        //echo "<p> ID_TABLE=".$_POST["ID_TABLE"];   //
         if ($_POST["ID_TABLE"]<>'')
         {
          $m=0;  //поправка номера поля
          $status=0;
           //Выбрать по параграфу _TREE запись
          $sql_T = new Tsql('select * from _TREE where PARAGRAF="'.$_POST["PARAGRAF"].'"');
          if ($sql_T->num>0)
          {           $sql_T->NEXT();  //_TREE параграфа
           if ($sql_T->row["TYPE_FORM"]=='FORM_MASTER')   //дабавить поле sel
            {             	$sql_I='INSERT INTO _FORM SET'
                     .' PARAGRAF="'.$_POST["PARAGRAF"].'",'
                     .' displayOrder="'.$m++.'",'
                     .' TABLE_NAME="'.$_POST["ID_TABLE"].'",'
                     .' VISIBLE="1",'
                     .' NONEDIT="0",'
//                     .' COLUMN_FIELD="",'
                     .' COLUMN_NAME="Выбор",'
                     .' COLUMN_SIZE="5",'
                     .' MASTER="SLAVE",'
                     .' TYPE_FIELD="sel"';
                echo '<p> sql_I='.$sql_I;           ///
                if (!mysql_query($sql_I))
                {    echo "<p> Ошибка INSERT - field [sel]"; $status=-1; }           }
           if ($status==0)
           {
             $sql_P = new Tsql('select * from '.$_POST["ID_TABLE"].' limit 0,1');   //выбрать одну запись как пример для чтения полей
             echo "<p> ID_TABLE=".$_POST["ID_TABLE"];   //
             echo "<p> sql_P=".$sql_P->num.'='.$sql_P->sql;   //
             $NUM_FIELD=mysql_num_fields($sql_P->result);  //количество полей в селекте
             for ($n=0; $n<$NUM_FIELD; $n++)
             {
               $field_name=mysql_field_name($sql_P->result,$n);
               $sql_I='INSERT INTO _FORM SET'
                     .' PARAGRAF="'.$_POST["PARAGRAF"].'",'
                     .' displayOrder="'.($n+$m).'",'
                     .' TABLE_NAME="'.$_POST["ID_TABLE"].'",'
                     .' VISIBLE="1",'
                     .' NONEDIT="0",'
                     .' COLUMN_FIELD="'.$field_name.'"';
                //     .' (PARAGRAF,displayOrder,TABLE_NAME,VISIBLE,NONEDIT,COLUMN_FIELD) VALUES (' // ,COLUMN_SIZE,COLUMN_NAME,TYPE_FIELD,kind_bold,SOURCE_FIELD,SOURCE_TABLE,SOURCE_ID,SOURCE_FILTER,FILE_DIR)
                //     .'"'.$_POST["PARAGRAF"].'",'.$n.',"'.$_POST["ID_TABLE"].'",1,0,"'.$field_name.'")';
               echo '<p> sql_I='.$sql_I;
               if (!mysql_query($sql_I))
               {   echo "<p> Ошибка INSERT field"; $status=-2; break; }
             }
            } //status
            //---------------------------field DEL
            if ($status==0
            and $sql_T->row["TYPE_FORM"]=='FORM_MASTER')  //добавить поле del
            //and $row_TREE["kind_delete"]==true)
            {
              $sql_I='INSERT INTO _FORM SET'
                     .' PARAGRAF="'.$_POST["PARAGRAF"].'",'
                     .' displayOrder="'.($n +$m).'",'
                     .' TABLE_NAME="'.$_POST["ID_TABLE"].'",'
                     .' VISIBLE="1",'
                     .' NONEDIT="0",'
//                     .' COLUMN_FIELD="",'
                     .' COLUMN_NAME="Del",'
                     .' COLUMN_SIZE="3",'
                     .' MASTER="SLAVE",'
                     .' TYPE_FIELD="del"';
                echo '<p> sql_I='.$sql_I;
                if (!mysql_query($sql_I))
               {   echo "<p> Ошибка INSERT - field [del]"; $status=-3; }            }
          } //sql_T
         }
}


?>
</html>
