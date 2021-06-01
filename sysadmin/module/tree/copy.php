<html xmlns="http://www.w3.org/1999/xhtml">
<?php

//===================COPY===========Форма выполнения вспомогательных программ SYS по _TREE и _FORM
// 	row_tree-<_TREE  запись заголовка формы
//  использует $_GET["id"]
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

function FORM_copy(&$row_TREE)
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
    function FORM_copy_post(&$row_TREE)
{        //echo "<p> ID_TABLE=".$_POST["ID_TABLE"];   //
         if ($_POST["ID_TABLE"]<>'')
         {
          $m=0;  //поправка номера поля
          $status=0;
           //Выбрать по параграфу _TREE запись
          $sql_T = new Tsql('select * from _TREE where PARAGRAF="'.$_POST["PARAGRAF"].'"');
          if ($sql_T->num>0)
          {           $sql_T->NEXT();  //_TREE параграфа
           if ($sql_T->row["TYPE_FORM"]=='TABLE'              //Ограничение по типу
           or  $sql_T->row["TYPE_FORM"]=='TABLE_KIND'
           or  $sql_T->row["TYPE_FORM"]=='TABLE_OBJ')
           {//---------------------------------------------------------------------
             $M_kind=array('kind_ADD','kind_EDIT','kind_delete');      //поля для проверки
             $M_pref=array('ADD','EDIT','DELETE');           //FORM+_+ PAAGRAF+.+
             $M_and=array('and COLUMN_FIELD<>"id"'
                          ,''
                          ,'and displayOrder IN (0,1,2,3)');
             $M_name=array('Добавить','Изменить','Удалить');

             for ($n=0; $n<count($M_kind); $n++)
             {
                //-------------------------------проверка требования создания формы
                if ( $sql_T->row[ $M_kind[$n] ] )
                {  echo "<p>".$M_kind[$n].'=true';
                //-------------------------------проверка наличия формы
                   $N_PRF=$_POST["PARAGRAF"].'.'.$M_pref[$n];
                   $N_FORM='FORM_'.$M_pref[$n];
                   $N_NAME=$M_name[$n].' '.$sql_T->row["NAME"];

             	   $sql_FND = new Tsql('select * from _TREE where PARAGRAF="'.$N_PRF.'"');
             	   if ($sql_FND->num==0)
             	   {   echo "<p> форма ".$N_PRF.' not found';
             	       $sql_N = 'INSERT INTO _TREE'
                               .' (PARAGRAF,PARENT,NAME,TYPE_FORM,kind_ADD,kind_EDIT,kind_moved,kind_delete,kind_FIND,parent_TABLE,parent_COLUMN,ID_TABLE,ID_COLUMN,FILTER)'
                               .' SELECT "'.$N_PRF.'",  "'.$_POST["PARAGRAF"].'" ,"'.$N_NAME.'","'.$N_FORM.'",0,0,0,0,0,parent_TABLE,parent_COLUMN,ID_TABLE,ID_COLUMN,FILTER'
                               .' FROM _TREE WHERE PARAGRAF="'.$_POST["PARAGRAF"].'"';
                       //echo "<p>".$sql_N;
             	       if (!mysql_query($sql_N))
                       {   echo "<p> Ошибка INSERT - ".$sql_N; $status=-2; break;}
                       //-------------------------Добавить сами поля в новую форму
                       $sql_N = 'INSERT INTO _FORM'
                               .' (PARAGRAF,          displayOrder,  TABLE_NAME,VISIBLE,NONEDIT,COLUMN_FIELD,COLUMN_SIZE,COLUMN_NAME,COLUMN_DEFAULT,TYPE_FIELD,kind_bold,SOURCE_FIELD,SOURCE_TABLE,SOURCE_ID,SOURCE_FILTER,FILE_DIR,CHILD,MASTER)'
                               .' SELECT "'.$N_PRF.'",displayOrder,  TABLE_NAME,VISIBLE,NONEDIT,COLUMN_FIELD,COLUMN_SIZE,COLUMN_NAME,COLUMN_DEFAULT,TYPE_FIELD,kind_bold,SOURCE_FIELD,SOURCE_TABLE,SOURCE_ID,SOURCE_FILTER,FILE_DIR,CHILD,MASTER'
                               .' FROM _FORM WHERE PARAGRAF="'.$_POST["PARAGRAF"].'"'
                               .' '.$M_and[$n]
                               .' ORDER BY displayOrder';
                       //echo "<p>".$sql_N;
                       if (!mysql_query($sql_N))
                       {   echo "<p> Ошибка INSERT - ".$sql_N; $status=-3; break;}             	   }	//формы еще не создана?                }	//kind true
             }   //for $n
           }    // Ограничение
          }
         }
}


?>
</html>
