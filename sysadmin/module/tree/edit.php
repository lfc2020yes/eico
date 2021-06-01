<html xmlns="http://www.w3.org/1999/xhtml">
   
    
<?php

//==============================Форма редактирования по _TREE и _FORM
// 	row_tree-<_TREE  запись заголовка формы
//      использует $_GET["id"]


function FORM_edit(&$row_TREE,&$ROW_role=0)
{
          $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));
          $findM = new find_mask($user);
          $findM->Get_FIND(&$row_TREE);   // Заполнить массив фильтрами _FIND
          $maska_select=$findM->Get_FIND_MASK();
          if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url(); white-space:nowrap;"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          } else { $styleH=''; $styleF=''; }
          
  $Jfields=array();  
  $Source=array();                      //Для сохранения &child
  GET_SOURCE(&$row_TREE,&$Source);     //Прочитать фильтры

 if (FIND_SYS(&$row_TREE)===false) $SyS=false;
 else                              $SyS=true;    //системной формы
  //выбрать форму
 $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" order by displayOrder';
 $result_FORM=mysql_query($sql_FORM);
 $num_results_FORM = mysql_num_rows($result_FORM);
 echo_pp(&$row_TREE,$sql_FORM);
  //выбрать даные по текущей строке
 $sql_data='select * from '.$row_TREE["ID_TABLE"];
 if (array_key_exists('id', $_GET))
     $sql_data.=' where id='.$_GET["id"];        //для FORM_MENU где нет ID
 else
 if (array_key_exists('in', $_GET))        //Альтернативный запуск
     $sql_data.=' where '.$row_TREE['ID_COLUMN'].'='.$_GET["in"];
 /*
 else  //вызвана без id
 { if ( $SyS and $row_TREE["parent_TABLE"]<>"")         //маска выбора
   {   $sql_data.=' where '.$row_TREE["ID_COLUMN"].' = "'.$_GET["in"].'"';
   }
 }
 */
 $result_data=mysql_query($sql_data);
 $num_results_data = mysql_num_rows($result_data);
 echo_pp(&$row_TREE,$sql_data);
 //if($num_results_data>0)
 {
  $row_data = mysql_fetch_array($result_data);
// показать форму
 if ($row_TREE["TYPE_FORM"]=='FORM_MENU') $PARENT_FORM=$row_TREE["PARAGRAF"];
                                     else $PARENT_FORM=$row_TREE["PARENT"];
       //Определение цвета системной формы
 if ($SyS)   { $bgcolor='bgcolor=#FFFFCC';   $IDD='&id='.$_GET['id']; }
 else        { $bgcolor='bgcolor=white';     $IDD=''; }
                                  //echo    '<p/>'.MAKE_URL('FORM',$PARENT_FORM,array('atr','id') );
                                  //MODUL.dTREE().$PARENT_FORM.GET_PARENT(&$row_TREE).$IDD.$Source[6]
   //echo    '<p/>$Source='.$Source[6]
   if (array_key_exists('idform', $_GET))
       if (strpos( strtolower($row_TREE['PARAGRAF']),'edit')>0)                       //Это вызов из .edit
           $back_URL=MAKE_URL('FORM',$row_TREE["PARAGRAF"],array('idform','atr'));
       else $back_URL=MAKE_URL('FORM',$row_TREE["PARAGRAF"],array('idform','atr','id'));
   else
       $back_URL=MAKE_URL('FORM',$PARENT_FORM,array('atr','id'));
?>
<div id="main">
    
<form method="post" action="" id="form_jfields">
    <input type="hidden" name="field" id="field" value="" />
    <input type="hidden" name="data" id="data" value="" />
    <input type="hidden" name="table" id="table" value="" />
    <input type="hidden" name="order" id="order" value="" />
    <input type="hidden" name="db" id="db" value="<?=$_GET['DB']?>" />
    
</form>    

<form enctype="multipart/form-data" action=<? echo($back_URL);  ?> name="theform" method="post" class="theform" id="form_<?=$row_TREE['id']?>" >
<input type="hidden" name="do" value="<? echo($row_TREE["PARAGRAF"]); ?>" />
<?php
  //if (array_key_exists('id', $_GET))
  //echo '<input type="hidden" name="id" value="'.$_GET['id'].'" />';
  if (array_key_exists('idform', $_GET))
  echo '<input type="hidden" name="idform" value="'.$_GET['idform'].'" />';
?>
  <table cellspacing="0" <?=$bgcolor ?> class="theform" align="left">       <!--Цвет для SYS таблицы-->
  <caption <?=$styleH?>><div style="padding:3px;"><?=$row_TREE["NAME"].SCOBA($Source[0]).$findM->Get_FIND_HEAD()?></div></caption>

<?php    //   FIELD_EDIT(&$result_FORM, &$row_data, $PARENT_FORM, $IDD)
  SHOW_tfoot(2,1,1,$back_URL,'thead');
  for($i=0; $i<$num_results_FORM; $i++)
  {
    $row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме
    if ($row_FORM['VISIBLE'])
        FIELD_EDIT(&$row_FORM,
                   &$row_TREE,
                   htmlspecialchars(trim($row_data[$row_FORM["COLUMN_FIELD"]])),
                   &$row_data, dFORM.$PARENT_FORM, $IDD,'', '','','',$SyS,'',&$Jfields);
  } //for

//-------------------------------Конец формы
  SHOW_tfoot(2,1,1,$back_URL);
?>
	</table>
</form>

</div>


<?php
 }  //if data
 return true;
}
//------------------------------------------------------------------------------------$PARAM=''
 function FIELD_EDIT(&$row_FORM, &$row_TREE, $data_FLD,&$row_data, $PARENT_FORM, $IDD,$onChange,$FLT='',$MST='',$SLV='',$SyS=0,$maska_select='',&$Jfields=0)
 {
    $IDf=$row_FORM["id"];
    $idform=0;
    $TYPE_FIELD=$row_FORM["TYPE_FIELD"];
    if (array_key_exists('idform', $_GET))
    {
     $idform=$_GET["idform"];
     $show=false;
     if ($IDf==$idform) {
     	$show=true;
     	$TYPE_FIELD='edit';
     }
    } else $show=true;
    $FLD=$row_FORM["COLUMN_FIELD"];
    if ($FLD=='id')$show=true;

  if ($show) {
    $data_FLD=html_entity_decode($data_FLD,ENT_QUOTES,"UTF-8");     //2016.07.24  одиночные и двойные ковычки cp1251

    $DR='../images/tree_S/';
    $base=new Thost2;

    //echo_dd(&$row_TREE,$FLD);
    if ($row_FORM["NONEDIT"]==1)
         $DSL='disabled';
    else $DSL='';
   if (strpos( $FLD,'sys_T')===false   //выполнять такие поля только в системной области
   or !(strpos( $_GET['TREE'],'sys')===false))
   {
    switch ($TYPE_FIELD)
//---------------------------------------------------------------------------
    { case 'bool':                     //поле галка (checkbox)
?>
    <tr>
    <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?></td>
    <td>
<?php
    if($data_FLD==1)
      $CHK='checked'; else $CHK='';
    echo '<input class="checkbox" type="checkbox" name="'.$FLD.'"  value="'.$data_FLD.'" '.$CHK.' '.$DSL.'/>';
?>
	<div id="theform_visible_error" class="error" style="display:none"></div>
    </td>
    </tr>
<?php
                   break;
//---------------------------------------------------------------------------
      case 'file':
      ?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?php
      echo'<input class="text" type="file" size="'.$row_FORM["COLUMN_SIZE"].'" name="'.$FLD.'" />';
      //echo'<label><input class="text" type="file" name="'.$FLD.'" /></label>';
?>
	<div id="theform_visible_error" class="error" style="display:none"></div>
    </td>
    </tr>
<?php
                   break;
      case 'jpg':         //одиночный jpg
      case 'image':       //Имя записано в поле  $row_FORM['COLUMN_FIELD']
   	     $iPAR=explode(';',$row_FORM["FILE_DIR"]);   //Чтение параметров
   	     if (count($iPAR)>4) $HOR_def=$iPAR[4]; else $HOR_def=2;
         if (count($iPAR)>5) $VER_def=$iPAR[5]; else $VER_def=2;
         if (count($iPAR)>6) $INN_def=$iPAR[6]; else $INN_def=0;

                          // /img/photo/s_,[FILE_NAME]_postpref,jpg;W=168;H=252;Q=100;2;2;0;
                          // 0-0                   0-1          0-2 1     2     3     4 5 6
                          //               значение поля по имени
                          //                                     none - не надо расширения
        $pPREF=explode(',',$iPAR[0]);             //0-конструктор имени файла
        $pEXT=GET_EXT($pPREF[2]);                 //получить расширение
        if ($TYPE_FIELD=='jpg')
        { $Name_ID=$row_data['id'];
          $FN='http://'.$base->H[$_GET['DB']][5].$pPREF[0].$Name_ID.$pPREF[1].$pEXT;
        }
        else
        {
           //$Name_IDf=explode('.',$row_data [$row_FORM['COLUMN_FIELD']]);
           //$Name_ID=$Name_IDf[0];
           $Name_ID=$row_data [$row_FORM['COLUMN_FIELD']];
           if (! $Name_ID>'') $Name_ID=$row_data['id'];
           $FN='http://'.$base->H[$_GET['DB']][5].$pPREF[0].$Name_ID;
        }

?>
    <tr> <td bgcolor='black' style="padding-right: 10px" colspan=2><font color='white'><?=GET_NAME(&$row_FORM).' ['.$row_FORM["FILE_DIR"].']'?>:</font>
    <!-- <tr> <td colspan=2 align="left"><?=$FN?>  -->
    <tr> <td colspan=2 align="left"><a href="<?=$FN?>" title="<?=$FN?>"><img src="<?=$FN?>"  alt="<?=$FN?>" /></a>
    <input type="hidden" name="<?=$FLD.'_'.$IDf?>_image" value="<?=$Name_ID?>">
    <tr style="background-color: #F3F3F3;">        <!--Для перегрузки фотки-->
		<td style="padding-right: 10px">Выбрать Фото.
		<td><input class="text" type="file"  name="<? echo($FLD);?>" size="<?=$row_FORM["COLUMN_SIZE"]?>" value="" />
		<div id="theform_meta_keywords_error" class="error" style="display:none"></div>
	<tr style="background-color: #F3F3F3;">
	    <td style="padding-right: 10px">Поз.горизонтально:
	    <td><select name="<?=$FLD.'_'.$IDf?>_horizont" class="text">
	<?
	        $opt_horizont=array("Left","Left Midle","Center","Right Midle","Right");
	        for ($p=0; $p<count($opt_horizont); $p++)
	        {
	        	if ($p==$HOR_def) $SEL='selected="selected"';
	        	else $SEL='';
	        	echo "<option value = '$p' $SEL>$opt_horizont[$p]</option>";
	        }
	?>
	        </select>
	<tr style="background-color: #F3F3F3;">
	    <td style="padding-right: 10px">Поз.вертикально:
	    <td><select name="<?=$FLD.'_'.$IDf?>_vertical" class="text">
	<?
	        $opt_vertical=array("Top","Top Midle","Center","Bottom Midle","Bottom");
	        for ($p=0; $p<count($opt_vertical); $p++)
	        {
	        	if ($p==$VER_def) $SEL='selected="selected"';
	        	else $SEL='';
	        	echo "<option value = '$p' $SEL>$opt_vertical[$p]</option>";
	        }
	?>
	        </select>
	<tr style="background-color: #F3F3F3;">
	    <td style="padding-right: 10px">Вписать:
	    <?
	       if ($INN_def>0) $CHK='checked';
	       else            $CHK='';
	    ?>
	    <td><input class="checkbox" type="checkbox" <?=$CHK?> name="<?=$FLD.'_'.$IDf?>_inner" size="70" value="<?=$INN_def?>" />
<?php
              break;
//---------------------------------------------------------------------------
       case 'point':   //Это производное поле графического файла из связанной таблицы  (выбор по названию из списка)
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM).' ['.$row_FORM["FILE_DIR"].']'?>:</td>
      <td>
<?php
         $pPREF=explode(',',$row_FORM["FILE_DIR"]);
         $pEXT=GET_EXT($row_FORM['CHILD']);
         $pFILE='http://'.$base->H[$_GET['DB']][5].$pPREF[0].$row_data[$row_FORM['COLUMN_FIELD']].$pPREF[1].$pEXT;

         echo '<img src="'.$pFILE.'"  alt="'.$pFILE.'" />';   //добавил ..перед\
         echo '</td></tr><tr><td></td><td>';

         echo'<select name="'.$FLD.'" class="text" >';
         echo'<option value = "0">пусто</option>';
         if ($row_FORM['SOURCE_FILTER']<>'')           //Дополнительный фильтр на выбор поля из связанной таблицы
         { $Where=' where '.$row_FORM['SOURCE_FILTER'];
         } else $Where='';

         $sql_P = new Tsql('select * from '.$row_FORM['SOURCE_TABLE'].$Where.' order by '.$row_FORM['SOURCE_ID']);
         for($k=0; $k<$sql_P->num; $k++)
         { $sql_P->NEXT();
           if($sql_P->row[$row_FORM['SOURCE_ID']]==$data_FLD)
	       echo'<option selected="selected" value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$sql_P->row[$row_FORM['SOURCE_FIELD']].'</option>';
	       else
           echo'<option value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$sql_P->row[$row_FORM['SOURCE_FIELD']].'</option>';
         }
         echo'</select>';
		 echo'<div id="theform_title_error" class="error" style="display:none"></div>';
	     echo'</td>';
         echo'</tr>';
   	          break;
//---------------------------------------------------------------------------
   	  case 'image9':                                    //Имя записано в поле  $row_FORM['COLUMN_FIELD']
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM).' ['.$row_FORM["FILE_DIR"].']'?>:</td>
      <td>
<?php
        //echo '<img src="'.$data_FLD.'" />';

        // /img/photo/s_,[FILE_NAME]_postpref,jpg;W=168;H=252;Q=100
                          // 0-0                       0-1      0-2 1     2     3     4
                          //               значение поля по имени
                          //                                     none - не надо расширения
        $iPAR=explode(';',$row_FORM["FILE_DIR"]);
        $pPREF=explode(',',$iPAR[0]);             //0-конструктор имени файла
        $pEXT=GET_EXT($pPREF[2]);                 //получить расширение
        $FN='http://'.$base->H[$_GET['DB']][5].$pPREF[0].$data_FLD.$pPREF[1].$pEXT;

        //$FN='../'.$row[$F_column[$j]];       width="350" height="250"
        if ($iPAR[1]=='')$iW=''; else $iW="width='$iPAR[1]'";
        if ($iPAR[2]=='')$iH=''; else $iH="height='$iPAR[2]'";
        if ($iPAR[4]=='')$CHK=''; else $CHK='checked';
        echo '<img src="'.$FN.'" '.$iW.' '.$iH.' alt="'.$FN.'"/>';
?>
    <!--
    <tr><td></td><td>
    		<input disabled class="text" type="text"  name="<? echo($FLD.'_image');?>" size="70" value="<?=$FN?>" />
    -->
    <tr style="background-color: #F3F3F3;"> <!--Дополнительное свойствообрезки при загрузке -->
		<td style="padding-right: 10px">Использовать авто преобразование в миниатюры (обрезка фото)</td>
		<td>
		<input class="checkbox" type="checkbox"  name="<? echo($FLD.'_auto'); ?>" size="70" value="1" <?=$CHK?> />
		<div id="theform_meta_keywords_error" class="error" style="display:none"></div>
    <tr style="background-color: #F3F3F3;">        <!--Для перегрузки фотки-->
		<td style="padding-right: 10px">Изменить Фото. </td>
		<td>
		<input class="text" type="file"  name="<? echo($FLD);?>" size="70" value="" />
		<div id="theform_meta_keywords_error" class="error" style="display:none"></div>
<?php
              break;
//---------------------------------------------------------------------------
   	  case 'edit':
?>
    <tr>
<?php
    echo '<td style="padding-right: 10px">'.GET_NAME(&$row_FORM).' ['.$row_FORM["FILE_DIR"].']'.':</td>';

      if ($idform>0)  //Вывод одного поля editwin
          echo '<tr>';
      echo '<td>';
      if ($idform==0)
      echo '<div style="width: '.($row_FORM["COLUMN_SIZE"]*5).'px;">';
?>
      <textarea id="editor_kama" name="<? echo($FLD); ?>"  cols="<?=$row_FORM["COLUMN_SIZE"]?>">
      <?php 
        echo(htmlspecialchars(trim(preg_replace('/<!--(.*?)-->/', '', $data_FLD)))); 
        //preg_replace('/<!--(.*?)-->/', '', $data_FLD);
        ?>
      </textarea>
        

      <script type="text/javascript">
      var ckeditor = CKEDITOR.replace('editor_kama',{ skin : 'kama' });

	    AjexFileManager.init({
	    returnTo: 'ckeditor',
	    editor: ckeditor,
	    skin: 'dark'
	    });
      </script>

<!--
      <textarea id="editor_kama" name="<? echo($FLD); ?>"  cols="<?=$row_FORM["COLUMN_SIZE"]?>">
      <? echo($data_FLD); ?></textarea>
      <script type="text/javascript">
      var editor = CKEDITOR.replace('editor_kama',{ skin : 'kama' });
      CKFinder.SetupCKEditor( editor, '/PLUGIN/ckfinder/' ) ;
      </script>
-->

      <!--</div>-->
<?php
   	          break;
//---------------------------------------------------------------------------
   	  case 'date':
   	        //echo "<p> ".$row_FORM['TYPE_FIELD'];
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?php
/*      if ($onChange<>'')
      echo '<input '.$DSL.' class="text"  name="'.$FLD.'" size="'.$row_FORM["COLUMN_SIZE"].'"  value="'.$data_FLD.'" onChange="'.$onChange.'(\''.$FLT.'\',\''.$FLD.'\');  return false;"/>';
      else
      echo '<input '.$DSL.' class="text"  name="'.$FLD.'" size="'.$row_FORM["COLUMN_SIZE"].'"  value="'.$data_FLD.'" />';
*/
      if ($onChange<>'')
      echo '<input class="object date" style="width:70px;" type="text"
             value="'.$data_FLD.'" id="'.$FLD.'" name="'.$FLD.'" onChange="'.$onChange.'(\''.$FLT.'\',\''.$FLD.'\');  return false;">';
      else
      echo '<input class="object date" style="width:70px;" type="text"
             value="'.$data_FLD.'" id="'.$FLD.'" name="'.$FLD.'" >';

?>
<input  type="button" style=" padding:0; margin:0; border:0; padding-right:5px;
              background-image:url(../image/search_top/calendar1.gif);
              background-repeat:no-repeat; width:21px; height:21px;" border="0"
              alt="Выбрать дату" src="/image/search_top/calendar1.gif"
              id="<?=$FLD.'__'?>" name="<?=$FLD.'_'?>">

		<script>//<![CDATA[
		                   var cal = Calendar.setup({
		        onSelect: function(cal) { cal.hide() }
		    });
		cal.manageFields("<?=$FLD.'__'?>", "<?=$FLD?>",  "%Y-%m-%d");
		//]]></script>

<!--
   	  <input name="imageField" type="image" id="trigger1" src="<?=$DR.'calendar.png'?>" alt="Выбрать дату" style=" width:21px; height:21px; " border="0"></input>

      <script type="text/javascript">
      Calendar.setup({inputField: "<?=$FLD?>", ifFormat: "%Y-%m-%d", button: "trigger1"});
      </script>
-->
	  <div id="theform_visible_error" class="error" style="display:none"></div>
      </td>
    </tr>
<?php
   	          break;
//---------------------------------------------------------------------------

      case 'flash':
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:
      <td>
<?php
        $Namef='id';
        $FN0='http://'.$base->H[$_GET['DB']][5].$row_FORM['FILE_DIR'].$row_data[$Namef];
        $FNR=$FN0.'.swf';
        $FN =  array_pop(explode("/",$FN0));   //Имя без расширения

        //$DR='http://www.ulyanovskmenu.ru'; //$_SERVER["DOCUMENT_ROOT"]
        /*
        $FNR=$row_FORM['FILE_DIR'].$row_data['id'].'.swf';                     //Полное имя файла
        $FN=  array_pop(explode("/",$row_FORM['FILE_DIR'].$row_data['id']));   //Имя без расширения
        */
        echo_pp(&$row_TREE,$FNR.'=='.$FN);     //\'http://www.ulyanovskmenu.ru/i/FLASH/top_'.$row_x["id"].'.swf

        echo '<script type="text/javascript"> writeFlash('.$row_data["weight"].','.$row_data["height"].',"'.$FNR.'","'.$FN.'"); </script>';

?>
    <tr style="background-color: #F3F3F3;">        <!--Для перегрузки фотки-->
		<td>
		<td>
		<input class="text" type="file"  name="<? echo($FLD);?>" size="70" value="" />
		<div id="theform_meta_keywords_error" class="error" style="display:none"></div>
	  <div id="theform_visible_error" class="error" style="display:none"></div>
<?php
             break;
      //case 'xml':
      case 'password':
?>    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?php
      echo IDDIV($FLD,$SyS,true);
?>
        <input <? echo($DSL); ?> class="text"  
            name="<? echo($FLD); ?>" 
            size="<? echo($row_FORM["COLUMN_SIZE"]); ?>" 
            value="<? echo('*****'); ?>" />                 
<?php                                                      //подмена данных при выводе
        echo IDDIV($FLD,$SyS,false);
        break;
      case 'cbox':          //Выбор фиксированных значений
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?php
         echo'<select '.$DSL.' name="'.$FLD.'" class="text" >';
         echo'<option value = "'.'">'.'пусто'.'</option>';
         $CBOX=explode(",",$row_FORM["SOURCE_FILTER"]);
         sort($CBOX);  reset($CBOX);
         for($k=0; $k<count($CBOX); $k++)
         { echo_dd(&$row_TREE,$CBOX[$k].'=='.$data_FLD);
           if($CBOX[$k]==$data_FLD)    //Значение поля совпадает
	       echo'<option selected="selected" value = "'.$CBOX[$k].'">'.$CBOX[$k].'</option>';
	       else  { if ($DSL=='')
	               echo'<option value = "'.$CBOX[$k].'">'.$CBOX[$k].'</option>';
           }
         }
         echo'</select>';
             break;
      case 'Stable':          //Выбор таблиц из текущей базы
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?php
         echo'<select '.$DSL.' name="'.$FLD.'" class="text" onChange="selChange_TST(this.form.'.$FLD.',COLUMN_FIELD)">';
         echo'<option value = "'.'">'.'пусто'.'</option>';
         $sql_P = new Tsql('show tables');
         for($k=0; $k<$sql_P->num; $k++)
         { $sql_P->NEXT();
           if($sql_P->row[0]==$data_FLD)
	       echo'<option selected="selected" value = "'.$sql_P->row[0].'">'.$sql_P->row[0].'</option>';
	       else
           echo'<option value = "'.$sql_P->row[0].'">'.$sql_P->row[0].'</option>';
         }
         echo'</select>';
             break;
      case 'Sfield':          //Выбор полей из таблицы $row_FORM["SOURCE_ID"]
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?php       
        //echo_dd(&$row_TREE,'->'.$row_FORM["SOURCE_ID"].'->'.$row_data[$row_FORM["SOURCE_ID"]]);
         //echo_dd(&$row_TREE,'TABLE_NAME='.$row_data['TABLE_NAME']);   //
         //$sql_P = new Tsql('select * from '.$row_data['TABLE_NAME'].' limit 0,1');   //выбрать одну запись как пример для чтения полей
         //echo_dd(&$row_TREE,'$sql_P->num='.$sql_P->num.'='.$sql_P->sql); //

         echo'<input '.$DSL.' class="text"  name="'.$FLD.'_T" size="'.$row_FORM["COLUMN_SIZE"].'" value="'.$data_FLD.'" />  ';
         echo'<select '.$DSL.' name="'.$FLD.'" class="text" >';
         //echo'size="'.$row_FORM["COLUMN_SIZE"].'"';
         echo'<option value = "'.'">'.'пусто'.'</option>';

         if ($row_data[$row_FORM["SOURCE_ID"]]<>'')
         { $sql_P = new Tsql('select * from '.$row_data[$row_FORM["SOURCE_ID"]].' limit 0,1');   //выбрать одну запись как пример для чтения полей
           echo_dd(&$row_TREE,'$sql_P->num='.$sql_P->num.'='.$sql_P->sql); //
           //if ($sql_P->num>0)
           {
             $NUM_FIELD=mysql_num_fields($sql_P->result);  //количество полей в селекте
             for ($n=0; $n<$NUM_FIELD; $n++)
             {
               $field_name=mysql_field_name($sql_P->result,$n);
               if ($field_name==$data_FLD)
	           echo'<option selected="selected" value = "'.$field_name.'">'.$field_name.'</option>';
	           else
               echo'<option value = "'.$field_name.'">'.$field_name.'</option>';
             }
           }
         }
         echo'</select>';
             break;
      case 'area':    //поле  TEXTAREA
      //echo_dd(&$row_TREE,'area='.$FLD);
       $SIZE=explode(";",$row_FORM["COLUMN_SIZE"]);
       if (count($SIZE)==1) $SIZE_H=4;
       else $SIZE_H=$SIZE[1];               //$row_FORM["COLUMN_SIZE"]

?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
        <textarea <?=$DSL?>  name="<?=$FLD?>" cols="<?=$SIZE[0]?>" rows="<?=$SIZE_H?>"><?=$data_FLD?></textarea>
        <div id="theform_name_error" class="error" style="display:none"></div>

      </td>
   </tr>

<?php
             break;
      //-------------------------------------2016/06/26 поле editform

      case 'editwin':    //поле  TEXTAREA
      //echo_dd(&$row_TREE,'area='.$FLD);
       $SIZE=explode(";",$row_FORM["COLUMN_SIZE"]);
       if (count($SIZE)==1) $SIZE_H=4;
       else $SIZE_H=$SIZE[1];               //$row_FORM["COLUMN_SIZE"]

       echo '<tr>
             <td style="padding-right: 10px">
             <a href='.MAKE_URL('FORM',$_GET['FORM'])
	                   .'&idform='.$IDf.' title="изменить">
	           '.GET_NAME(&$row_FORM).'
	           <img src="/images/tree_S/edit.gif" alt="изменить" />

	         </a></td>';
       echo '<td>
              <div style="width: '.($SIZE[0]*5).'px;
                          height: '.($SIZE_H*10).'px;
                          overflow: auto;
                          padding: 3px;
                          border: 1px solid gray;
                          " >';

?>        <a><?=$data_FLD?>

          </a>
        </div>
        <!--
        <textarea <?=$DSL?> readonly name="<?=$FLD?>" cols="<?=$SIZE[0]?>" rows="<?=$SIZE_H?>"><?=$data_FLD?></textarea>
        -->


        <div id="theform_name_error" class="error" style="display:none"></div>
      </td>
   </tr>

<?php
             break;

      case 'map':     //сложное поле по таблице SOURCE_TABLE
      /*
         $sss=                     ////////////////////
         'SELECT g.'.$row_FORM['SOURCE_ID'].',g.'.$row_FORM['SOURCE_FIELD'].',v.'.$row_FORM['SOURCE_FILTER']   //$_GET['in']
           .' FROM '.$row_FORM['SOURCE_TABLE'].' g LEFT JOIN'
           .' ('
           .' SELECT a.'.$row_FORM['SOURCE_ID'].',b.'.$row_FORM['SOURCE_FILTER']
           .' FROM '.$row_FORM['SOURCE_TABLE'].' a, '.$row_FORM['TABLE_NAME'].' b'
           .' WHERE b.'.$row_TREE['ID_COLUMN'].'="'.$_GET['in'].'" '
           .' AND a.'.$row_FORM['SOURCE_ID'].'=b.'.$row_FORM['COLUMN_FIELD']
           .' )'
           .' v ON (g.'.$row_FORM['SOURCE_ID'].'=v.'.$row_FORM['SOURCE_ID'].' )';
       */
      //   echo_dd(&$row_TREE,'ID_COLUMN='.$row_TREE['ID_COLUMN']);
      //   echo_dd(&$row_TREE,$sss);     /////////////////
         $SQL_map = new Tsql (
            'SELECT g.'.$row_FORM['SOURCE_ID'].',g.'.$row_FORM['SOURCE_FIELD'].',v.'.$row_FORM['SOURCE_FILTER']   //$_GET['in']
           .' FROM '.$row_FORM['SOURCE_TABLE'].' g LEFT JOIN'
           .' ('
           .' SELECT a.'.$row_FORM['SOURCE_ID'].',b.'.$row_FORM['SOURCE_FILTER']
           .' FROM '.$row_FORM['SOURCE_TABLE'].' a, '.$row_FORM['TABLE_NAME'].' b'
           .' WHERE b.'.$row_TREE['ID_COLUMN'].'="'.$_GET['in'].'" '
           .' AND a.'.$row_FORM['SOURCE_ID'].'=b.'.$row_FORM['COLUMN_FIELD']
           .' )'
           .' v ON (g.'.$row_FORM['SOURCE_ID'].'=v.'.$row_FORM['SOURCE_ID'].' )'
           .' order by g.'.$row_FORM['SOURCE_FIELD']
                              );
         echo_dd(&$row_TREE,$SQL_map->sql);        //

         echo '<input type="hidden" name="total_'.$FLD.'" value="'.$SQL_map->num.'" />';

         for($k=0; $k<$SQL_map->num; $k++)     //Раскрыть все поля
         { $SQL_map->NEXT();
           echo '<tr height="0px">';
           //--------------------Подготовка поля SELECTOR
           if($SQL_map->row[$row_TREE['ID_COLUMN']]>0)  //Связь совпала
                  { $CHK='checked'; $CH=1;}
             else { $CHK='';        $CH=0;}
           echo '<td><input class="checkbox" type="checkbox" style="padding:0; margin:0;" name="'.$FLD.'_'.$k.'"  value="'.$SQL_map->row[$row_FORM['SOURCE_ID']].'" '.$CHK.' '.$DSL.'/></td>';
           echo '<td>'.$SQL_map->row[$row_FORM['SOURCE_FIELD']].'</td>';
           echo '</tr>';
         }

             break;
   
//---------------------------------------------------------------------------
      default:  //поле int иFcbox

      //echo_dd(&$row_TREE,'text='.$FLD);
     //echo '<p/>'.$FLD.'|'.$SyS;

?>
    <tr>
          <td style="padding-right: 10px">
      <?php
          echo IDDIV($FLD,$SyS,true);
          echo GET_NAME(&$row_FORM).':';
          echo IDDIV($FLD,$SyS,false);
      ?> </td>
      <td>
<?php
      if ($row_FORM['SOURCE_TABLE']<>"")     //Это производное поле из связанной таблицы
      { 

//          $MASK='';          //$MASK[1]-значение
//          $MASK_FIELD='';
//          $uPARENT='';
//          GET_mask(&$row_TREE,&$MASK,&$MASK_FIELD,&$uPARENT);    //Получить инфу по маске
          
        if($TYPE_FIELD=='Jfield') { //============================================
           echo_dd(&$row_TREE,'$001');
           if ($Jfields>0)
               $Jfields[$FLD]=$data_FLD;                 //массив selected для обеспечения фильтров последующих jfields
               $STABLE='';
               $SORDER='';
               $STYPE='';
               $sCHILD='';
               $sCOLUMN_FIELD='';
               if($row_FORM['FILE_DIR']<>'') {
                   $SJ=new Tsql("SELECT PARAGRAF,COLUMN_FIELD,TYPE_FIELD,SOURCE_TABLE,SOURCE_FIELD,FILE_DIR  
                           FROM _FORM WHERE PARAGRAF='".$row_FORM['PARAGRAF']."' 
                           AND COLUMN_FIELD='".$row_FORM['FILE_DIR']."'");
                   if($SJ->num>0) {
                      $SJ->NEXT();
                      $STABLE=$SJ->row['SOURCE_TABLE'];
                      $SORDER=$SJ->row['SOURCE_FIELD'];
                      $sTYPE=$SJ->row['TYPE_FIELD'];
                      $sPARAGRAF=$SJ->row['PARAGRAF'];
                      $sCOLUMN_FIELD=$SJ->row['FILE_DIR'];
                   }
                   $COMA='';
                   while ($sTYPE=='Jfield' and $sCOLUMN_FIELD<>'') { //это цепочка полей JField, <select> которых нужно обнулить 
                       
                      $SN=new Tsql("SELECT PARAGRAF,COLUMN_FIELD,TYPE_FIELD,SOURCE_TABLE,SOURCE_FIELD,FILE_DIR  
                           FROM _FORM WHERE PARAGRAF='".$sPARAGRAF."' 
                           AND COLUMN_FIELD='".$sCOLUMN_FIELD."'");
                      if ($SN->num>0) {
                          $SN->NEXT();
                          $sCHILD.=$COMA.$SN->row['COLUMN_FIELD'];
                          $COMA=';';
                          $sPARAGRAF=$SN->row['PARAGRAF'];
                          $sCOLUMN_FIELD=$SN->row['FILE_DIR'];
                          $sTYPE=$SN->row['TYPE_FIELD'];
                          
                      } else break;
                      $SN->FREE();
                      unset($SN);
                   }
                   $SJ->FREE();
                   unset($SJ);
                   
               }
               
           echo'<div id="' .$FLD. '_error"></div>';         //result_id,                       url,                  sel_name,  table/order  
           echo'<select '.$DSL.' name="'.$FLD.'" id="'.$FLD.'" class="text" '
                   . 'onChange="AjaxFormRequestE(\''.$FLD.'_error\', \'/sysadmin/ajax_jfield.php\''
                   . ',this.form.'.$FLD
                   . ',this.form.'.$row_FORM['FILE_DIR']
                   . ',\''.$STABLE.'\''
                   . ',\''.$SORDER.'\''
                   . ',\''.$sCHILD.'\''
                   . ')" >';
           
           //echo'</div>';  
        } else {
          echo_dd(&$row_TREE,'$00');   
         //echo'<div id="' .$FLD. '">';
         if ($onChange<>'')
         {
           echo'<select '.$DSL.' id="personForm.'.$FLD.'" name="'.$FLD.'" class="text" onChange="'.$onChange.'(\''.$FLT.'\',\''.$FLD.'\');  return false;" >';
         }
         else
         echo'<select '.$DSL.' name="'.$FLD.'" id="'.$FLD.'" class="text"  >';     //$OnC=onChange
         //echo'</div>';
        }
        //echo'<div id="' .$FLD. '">';        
         echo'<option value = "0">пусто</option>';

////======================================================Дополнительный фильтр на выбор поля из связанной таблицы
         $AND=' where '; $Where='';
         if ($row_FORM['SOURCE_FILTER']<>'')           
         {
           if ($row_FORM['SOURCE_FILTER']=='$$')       //Дополнительно ограничить выбор маской
           {
                 if ($maska_select<>'')          //Установлена маска на ветку
                     
		         { $Where.=$AND.$maska_select;

		         }
           }
           else                                            //Просто фильтр
           { $sfilter=explode('=',$row_FORM['SOURCE_FILTER']);   //Если есть равно = -> это точное значение фильтра
             //echo_dd(&$row_TREE,'count='.count($sfilter));
             if (count($sfilter)>1) {
                 $Where.=$AND.$row_FORM['SOURCE_FILTER'];
                 $AND=' AND ';
             } else { // это значение div id= для получения маски
                //echo_dd(&$row_TREE,'фильтр значения предыдущего поля '.$row_FORM['SOURCE_FILTER'].'->'.$_POST[$sfilter[0]]);
                 if ($Jfields>0) {
                    $Where.=$AND.$sfilter[0].'="'.$Jfields[$sfilter[0]].'"';
                    $AND=' AND '; 
                 }
             }    
           }
         }

         $sql_P = new Tsql('select * from '.$row_FORM['SOURCE_TABLE'].$Where.' order by '.$row_FORM['SOURCE_FIELD']);
         for($k=0; $k<$sql_P->num; $k++)
         { $sql_P->NEXT();
           if  ($row_FORM['COLUMN_SIZE']>0)
                $STR=substr($sql_P->row[$row_FORM['SOURCE_FIELD']],0,$row_FORM['COLUMN_SIZE']).'...';
           else $STR=$sql_P->row[$row_FORM['SOURCE_FIELD']];

           if($sql_P->row[$row_FORM['SOURCE_ID']]==$data_FLD) {
	       echo'<option selected="selected" value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$STR.'</option>';
           }   else { if ($DSL=='')
                     echo'<option value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$STR.'</option>';
           }
         }
         //echo'</div>';
         echo'</select>';
         echo_pp(&$row_TREE,'-->'.$row_FORM['SOURCE_FILTER'].' maska_select='.$maska_select.' ->'.$Where);
         //var_dump ($_POST);
/*
?>         
<script type="text/javascript">
         alert("select");
         var $select = $('<?=$row_FORM['SOURCE_FILTER']?>_').selectize(options); 
         alert("select_");
         var selectize = $select[0].selectize; 
         alert("select="+selectize);
</script>
<?php
 * 
 */         
      }
      else
      {              //Простое поле text
        echo IDDIV($FLD,$SyS,true);
?>
        <input <? echo($DSL); ?> class="text"  name="<? echo($FLD); ?>" size="<? echo($row_FORM["COLUMN_SIZE"]); ?>" value="<? echo($data_FLD); ?>" />
<?php      
        echo IDDIV($FLD,$SyS,false);

       //===========================================дополнительные кнопки SYS
         if ($_GET['FORM']=='sys' and $row_FORM['COLUMN_FIELD']=='id')   //$SyS
         {                   //=MODUL.dTREE().$PARENT_FORM.GET_PARENT(&$row_TREE).$IDD
             
             
             
            $DR='../images/tree_S/';
            //echo '<td>';
            echo '<a href='.MODUL.dTREE().$PARENT_FORM.GET_PARENT(&$row_TREE).'.add'.'&atr=add'.'#YK'         //.$IDD не надо              //align="left"
                    .' style="padding: 0px 0px 0px 4px"'       
                    .' title="Добавить строку"><img src="'.$DR.'add_small.png" alt="Добавить строку" hspace="5" /></a>';
//            if (strpos( $_GET['TREE'],'sys')===false)   //не выполнять в системной области
          {
            echo '<a href='.MODUL.dTREE().$PARENT_FORM.GET_PARENT(&$row_TREE).'.make.1'.'&atr=make'.$IDD.'#YK'         //.$IDD не надо              //align="left"
                    .' style="padding: 0px 0px 0px 4px"'       
                    .' title="Создать черновую форму"><img src="'.$DR.'form_new.png" alt="Создать черновую форму" hspace="2" /></a>';
          }
            //echo '       ';
            echo '<a href='.MODUL.dTREE().$PARENT_FORM.GET_PARENT(&$row_TREE).'.copy.1'.'&atr=copy'.$IDD.'#YK'
                    .' style="padding: 0px 0px 0px 4px"'      
                    .' title="Размножить форму по свойствам"><img src="'.$DR.'doc_add.png" alt="Размножить форму по свойствам" hspace="2" /></a>';
            //-------------------------------------------------------------------------------------------------tree
            echo '<a href='.MODUL.dTREE().$PARENT_FORM.GET_PARENT(&$row_TREE).'.tree.move'.'&atr=tmove'.$IDD.'#YK'
                    .' style="padding: 0px 0px 0px 10px"'
                          .' title="Перенести ветку"><img src="'.$DR.'tree0.png" alt="tmove" hspace="2" /></a>';
            echo '<a href='.MODUL.dTREE().$PARENT_FORM.GET_PARENT(&$row_TREE).'.tree.copy'.'&atr=tcopy'.$IDD.'#YK'
                    .' style="padding: 0px 0px 0px 4px"'
                          .' title="Копировать ветку"><img src="'.$DR.'tree1.png" alt="tcopy" hspace="2" /></a>';
            echo '<a href='.MODUL.dTREE().$PARENT_FORM.GET_PARENT(&$row_TREE).'.tree.delete'.'&atr=tdelete'.$IDD.'#YK'
                    .' style="padding: 0px 0px 0px 4px"'
                          .' title="Удалить ветку"><img src="'.$DR.'tree2.png" alt="tdelete" hspace="2" /></a>';
            /*
            echo '<a href='.MODUL.dTREE().$PARENT_FORM.GET_PARENT(&$row_TREE).$IDD
                           .' title="Скопировать ветку"><img src="'.$DR.'docs_add.png" alt="Скопировать ветку" hspace="2" /></a>';
            echo '<a href='.MODUL.dTREE().$PARENT_FORM.GET_PARENT(&$row_TREE).$IDD
                           .' title="Удалить"><img src="'.$DR.'remove_outline.png" alt="Удалить" hspace="20" /></a>';
           */
            //echo '</td>';
         }
      }
?>
        <div id="theform_name_error" class="error" style="display:none"></div>
      </td>
   </tr>
<?php
    }  //switch
   } //sys поля и системная область
  } //idform
 }




//========================================POST Формы редактирования по _TREE и _FORM
//========================================Изменить запись по кнопке "отправить"
// 	row_tree-<_TREE  запись заголовка формы
//      использует $_POST["id"]
//      Ключевое поле в таблице должно называться id


function FORM_edit_post(&$row_TREE)
{
   $base=new Thost2;
 if (array_key_exists('idform', $_POST)) //Писать только одно поле
      $idform=$_POST['idform'];
 else $idform=0;
 if (FIND_SYS(&$row_TREE)===false) $SyS=false;
 else                              $SyS=true;    //системной формы

 $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" order by displayOrder';
 $result_FORM=mysql_query($sql_FORM);
 $num_results_FORM = mysql_num_rows($result_FORM);
 echo_pp(&$row_TREE,'POST_EDIT='.$sql_FORM);

  $STR='update '.$row_TREE["ID_TABLE"].' set';
  $SMC=' ';
  $status=0;                             //1-map не делать update
  $login='';
  for($i=0; $i<$num_results_FORM; $i++)
  {
    $row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме
    $WriteField=true;                               //Писать поле по умолчанию false - не писать
    $FLD=$row_FORM["COLUMN_FIELD"];
    $IDf=$row_FORM["id"];
    if ($FLD=='login') $login=$_POST[$FLD];   //Сохранить значение login для password
        
    if (($idform>0) and ($idform<>$IDf)) continue;
    echo_pp(&$row_TREE,$idform.'::'.$IDf);
    if ($row_FORM["NONEDIT"]==1) continue;
    //if ($FLD=='id') continue;
    //echo_pp(&$row_TREE,$FLD.' '.$row_FORM["TYPE_FIELD"]);
    switch ($row_FORM["TYPE_FIELD"])       //Разбор полей
    { case 'bool':            //ComboBOX
            $CHK=GET_CHECK($FLD);
            break;
      case 'Sfield':
            if($_POST[$FLD.'_T']<>'')      //дополнительное Поле редактирования
            $CHK='"'.$_POST[$FLD.'_T'].'"';
            else $CHK='"'.$_POST[$FLD].'"';
            break;
    /*
      case 'in':
            if($_POST[$FLD]>0)  $CHK='"'.$_POST[$FLD].'"';     //дополнительное Поле редактирования
            else $CHK='"'.$_GET['in'].'"';
            echo_dd(&$row_TREE,'field_in-->'$CHK);
            break;
    */
      case 'map':                          //Edit и Add работают одинаково
                  //---Удалить все что есть по данному полю в базе (сторонняя база)
                  //---добавить по закрыжинным полям

            $sql_MAP= new Tsql('delete from '.$row_TREE["ID_TABLE"]
                             .' where '.$row_FORM["SOURCE_FILTER"].'="'.$_POST[ $row_FORM["SOURCE_FILTER"] ].'"',1);
            echo_dd(&$row_TREE,$sql_MAP->sql);
            unset($sql_MAP);

            echo_pp(&$row_TREE,'map='.$FLD);

            $in=$_POST[$row_FORM["SOURCE_FILTER"]];
            if($in==0) $in=$_GET['in'];

            for($n=0;$n<$_POST['total_'.$FLD];$n++)   //Проход по закрыженным полям
            { if (GET_CHECK($FLD.'_'.$n))
              { echo_pp(&$row_TREE,$row_FORM["SOURCE_FILTER"].'->'.$_POST[$FLD.'_'.$n].'->'.$_POST[$row_FORM["SOURCE_FILTER"]]);
                $SQ='insert into '.$row_TREE["ID_TABLE"].' ('.$row_FORM["SOURCE_FILTER"].','.$FLD
                                .') value ("'.$in.'","'.$_POST[$FLD.'_'.$n].'")';
                echo_pp(&$row_TREE,$SQ);
                $sql_MAP= new Tsql($SQ,1);
                unset($sql_MAP);
              }
            }
            $status=1;         //map поле записано
            break;
//-----------------------------------------------------------------------------
      case 'file':

      		if(isset($_FILES[$FLD]))
            {
			  $error_flag = $_FILES[$FLD]["error"];
              if($_FILES[$FLD]["error"] == 0) $isCorrectAddInstr = "false";
              else                            $isCorrectAddInstr = "true";
            }
            else  $isCorrectAddInstr = "true";

		    if($isCorrectAddInstr == "false")
		    {
              $phpPath=$_SERVER["DOCUMENT_ROOT"].$row_FORM["FILE_DIR"];
	          copy($_FILES[$FLD]["tmp_name"],$phpPath. $_POST[ $row_FORM["SOURCE_FIELD"] ].".php");
              unset($_FILES[$FLD]);
              echo_dd(&$row_TREE,'Перезагрузка файла='.$phpPath. $_POST[ $row_FORM["SOURCE_FIELD"] ].".php");   ///
           //Проверить код возврата
		    }
            break;
//-----------------------------------------------------------------------------
      case 'image':
      case 'jpg':              //Заменить файл по ID
        $option =  GET_opt_jpg($FLD,$IDf);
        $opt=explode(';',$option);

        $isCorrectLOAD = 0;
        if(isset($_FILES[$FLD]))
        {
			$error_flag = $_FILES[$FLD]["error"];
            if($_FILES[$FLD]["error"] == 0) $isCorrectLOAD = 1;
        }
        echo_pp(&$row_TREE,'----->'.$row_FORM["FILE_DIR"].' isCorrectLOAD='.$isCorrectLOAD);    ////
		if($isCorrectLOAD == 1)
		{
		   $HBS=$_GET['DB'];
           if ($base->F[$HBS][0]==false)                 //ТОлько для HTTP
           {
             //$iPAR=explode(';',$row_FORM["FILE_DIR"]);
             //$pPREF=explode(',',$iPAR[0]);             //0-конструктор имени файла
             //$pEXT=GET_EXT($pPREF[2]);                 //получить расширение
              if ($row_FORM["TYPE_FIELD"]=='jpg') $Namef=$_POST['id'];
              else
              { //Получить имя файла из поля    $row[  $row_FORM['COLUMN_FIELD']  ]

                //$Namef=$_FILES[$FLD]['name']; //$row_FORM['COLUMN_FIELD'];
                $Namef=$_POST[$FLD.'_'.$IDf.'_image'];

              }
              //$FN='http://'.$base->H[$_GET['DB']][5].$pPREF[0].$row_data[$Namef].$pPREF[1].$pEXT;

             $Fname='';      //Полное имя файла
             $CHK="";
             $err=IMAGE_MAP(&$row_TREE, &$base, $FLD, $row_FORM["FILE_DIR"], &$Fname , &$Namef, $opt[0], $opt[1] ,$opt[2],$row_FORM["TYPE_FIELD"]);
             if (!$err=='')
             {       echo "<p>$err</p>";
                     $isCorrectLOAD=0;
             }
             echo_pp(&$row_TREE,"Fname=$Fname ".$row_FORM['FILE_DIR']." ".$_POST['id']);

             $CHK='"'.$Namef.'"';                        //для записи имени файла
             echo_pp(&$row_TREE,'Namef='.$Namef.' POST=' .$FLD.'_'.$IDf.'_image');
           }
		}
		break;
      case 'flash':
            switch ($row_FORM["TYPE_FIELD"])
            {  case 'jpg':   $EXP=GET_EXT($row_FORM['CHILD']); break;   //Замена расширения
               case 'flash': $EXP='.swf'; break;
            }
		      echo_pp(&$row_TREE,'---->'.$EXP." [$FLD] isset (".$_FILES[$FLD].")=".isset($_FILES[$FLD]));
        $isCorrectAddInstr = false;
        if(isset($_FILES[$FLD]))
        {
			$error_flag = $_FILES[$FLD]["error"];
            if($_FILES[$FLD]["error"] == 0) $isCorrectAddInstr = true;
        }
        echo_pp(&$row_TREE,'----->'.$row_FORM["FILE_DIR"].' isCorrectAddInstr='.$isCorrectAddInstr);    ////
		if($isCorrectAddInstr == true)
		{
              //Храним как /i/JPG/left_

           $pPREF=explode(',',$row_FORM["FILE_DIR"]);       //Разделение имя на 2 части префикс и постпрефикс
           echo_pp(&$row_TREE,'-----_>'.$pPREF);        ///
           $FN=$_POST['id'].$pPREF[1].$EXP;
           //------------------------------------------------------выбор способа загрузки файла
           $HBS=$_GET['DB'];
           if ($base->F[$HBS][0]==true)   // загрузка по FTP
           {
             $Tunel='';
             $file=$_FILES[$FLD]["tmp_name"];
             $remote_file=$base->F[$HBS][3].$pPREF[0].$FN;
             echo_pp(&$row_TREE,"FTP file=$file remote_file=$remote_file");
             if (FTPconnect(&$Tunel,$HBS))
             {
               //echo_pp(&$row_TREE,'pwd='.ftp_pwd ($Tunel));      ////   читать текущую директорию
               //echo_pp(&$row_TREE,var_dump(ftp_nlist($Tunel,ftp_pwd($Tunel))));   //Ычитать файлы текущей директории

               if (ftp_put($Tunel, $remote_file, $file, FTP_BINARY))
                   $NE=''; else $NE='НЕ ';
               echo_pp(&$row_TREE,"FTP: $NE УДАЛОСЬ загрузить $file на $remote_file");
              }
              ftp_close($Tunel);
           }
           else //----------------------------------------------------загрузка в каталог по определенному пути (с корректировкой пути)
           {
	           //$site='http://'.$base->H[$HBS][5];
	           $site=$base->F[$HBS][3];
	           $phpPath=$site.$pPREF[0];

	           echo_pp(&$row_TREE,"Подготовка файла site=$site phpPath=$phpPath $FN");

	           //$sh = fopen($phpPath.$FN, "w") or die("File ($phpPath.$FN) не открывается почему-то!");

		       if(! copy($_FILES[$FLD]["tmp_name"],$phpPath.$FN))    //Фиксированное расширение  (Может произойти замена расширения)
               echo "\n Ошибка загрузки файла:".   $phpPath.$FN;

	           echo_pp(&$row_TREE,'Перезагрузка файла='.$phpPath.$FN);   ///
	           //Проверить код возврата
           }
		}
            break;
//-----------------------------------------------------------------------------
      case 'image5':   //Загрузка графического файла (2 переменные - FLD и FLD_auto
                      //Если пусто - ничего не грузить
                      //файл настроек
       $CHK="";
       if(isset($_FILES[$FLD]))
        {   echo_pp(&$row_TREE, "111 CHK=".$CHK);   ///
			$error_flag = $_FILES[$FLD]["error"];
            if($_FILES[$FLD]["error"] == 0) $isCorrectAddInstr = "false";
        }
        else  $isCorrectAddInstr = "true";
		if($isCorrectAddInstr == "false")  //Заполнено поле файла
		{
          if ($row_FORM["FILE_DIR"]<>'')
          {
            include  ('..'.$row_FORM["FILE_DIR"]);       //файл настроек
            $imgPath=$_SERVER["DOCUMENT_ROOT"].$data_ulmenu['document_photo'].basename($_FILES[$FLD]['name']);
            echo_pp(&$row_TREE,'файл='.$imgPath);            ///

            if(isset($_POST[$FLD.'_auto']))      //Преобразовывать?
            { echo_pp(&$row_TREE, "333");   ///
		      $Twidth=$data_ulmenu['report_thumb_width'];
		      $Theight=$data_ulmenu['report_thumb_height'];
              echo_dd(&$row_TREE,' w='.$Twidth.' h='.$Theight);           ////
        //function create_thumbnail($srcpath, $destpath, $maxw = false, $maxh = false, $quality = false)
		      if (!create_thumbnail($_FILES[$FLD]['tmp_name'], $imgPath, $Twidth, $Theight,100))
			       echo'не удалось создать миниатюру';
            }
            else
            { echo_pp(&$row_TREE, "555");   ///
              if (!copy($_FILES[$FLD]["tmp_name"],$imgPath)) //Просто откопировать
                   echo'не удалось создать файл';
            }
            $CHK='"'.$data_ulmenu["document_photo"].basename($_FILES[$FLD]["name"]).'"';
            echo_pp(&$row_TREE, "777 CHK=".$CHK);   ///
            //Проверить код возврата
          }  //FILE_DIR
		} //$isCorrectAddInstr
                   break;
//-----------------------------------------------------------------------------
      //case 'flash':
      //             break;
//-----------------------------------------------------------------------------
      case 'md5':
            $CHK='"'.md5($_POST[$FLD]).'"';
            break;
      case 'password':
            if ($_POST[$FLD]=='*****') {
                $WriteField=false;               //не писать
            } else {
               if ($login=='') $WriteField=false;   //не было поля login 
               else {
               $CHK='"'.password_crypt_id($_POST['id'],$_POST[$FLD],$login).'"';   //($id_user,$pas,$login) 
               }        
            }
            break;
      case 'edit':
            //$CHK='"'.htmlspecialchars(trim($_POST[$FLD])).'"';
      default:                         //поле int или test - не checkbox
            //----------------------выходное поле заключается в одиночные ковычки. Поэтому одиночных ковычек в данных $CHK быть не должно
            //$CHK="'".htmlentities($_POST[$FLD],ENT_QUOTES,"cp1251")."'";      //2016.07.24
            //$CHK=str_replace("'", '&#039' , $_POST[$FLD]);
            $CHK="'".$_POST[$FLD]."'";
            if ($SyS and $FLD=='PARAGRAF' and $row_TREE["ID_TABLE"]=='_TREE')  //Может это изменение параграфа?
            {  //Найти запись которую надо изменить
               $sql_TT= new Tsql('select '.$FLD.' from _TREE where id = "'.$_POST['id'].'"');
               //echo_pp(&$row_TREE,$sql_TT->sql);
               if ($sql_TT->num>0)
               { $sql_TT->NEXT();
                 if ($sql_TT->row[0]<>$_POST[$FLD])       //Нужно изменение параграфа в форме
                 {
                    //$sqll='update _FORM set '.$FLD.'="'.$CHK.'" where '.$FLD.'="'.$sql_TT->row[0].'"';
                 	$sql_FF= new Tsql('update _FORM set '.$FLD.'='.$CHK.' where '.$FLD.'="'.$sql_TT->row[0].'"',1);
                 	//echo_pp(&$row_TREE,$sql_FF->sql);
                 }
               }
            }

    } //switch
    if ($WriteField) {        
        if ($row_FORM["TYPE_FIELD"]<>'file'
        and $row_FORM["TYPE_FIELD"]<>'jpg'
        and $row_FORM["TYPE_FIELD"]<>'flash'
        and !($row_FORM["TYPE_FIELD"]=='editwin' and $idform==0)
        and !($row_FORM["TYPE_FIELD"]=='image' and $isCorrectLOAD==0)
        and $FLD<>'id'
        )
        {
            $STR.=$SMC. $FLD . '=' . $CHK;
            $SMC=',';
        }
    }
  } //for
  echo_pp(&$row_TREE,'id='.$_POST['id']);
  echo_pp(&$row_TREE,'idform='.$_POST['idform']);
  if (array_key_exists('id', $_POST))          //нет ID ->FORM_MENU
       $STR.=' where id = "'.$_POST['id'].'"';
  else $STR.=' where id = "0"';
  if ($status==0)
  {
    echo_pp(&$row_TREE,'str='.$STR);                   ///
    if(!mysql_query($STR))
        echo "\n Ошибка UPDATE: ".$STR;
  }
}

function IDDIV($FLD,$SyS,$open)
     {
	     if (($FLD=='id') and (!$SyS==1)) {
	       //echo ' yes!';
	       if ($open)
	            $htm='<div style="display:none;">';          //Закрыть ID
	       else $htm='</div>';
	     }
	     return $htm;
     }

?>

<script language ="JavaScript">
<!--
function selChange(seln)
{
  selNum = seln.selectedIndex;
  Isel = seln.options[selNum].text;
  alert("Выбрано: "+Isel);
}
//-->
</script>

<script language ="JavaScript">
<!--
function selChange_TST(seln,child_field)
{
  selNum = seln.selectedIndex;
  Isel = seln.options[selNum].text;
  //child_field.value = "id";
  alert("Выбрано: "+Isel+ " "+child_field.name+"="+child_field.value);
}
//-->
</script>
          
<script type="text/javascript">

           /**
             * Функция для отправки формы средствами Ajax
          
             **/
        function AjaxFormRequestE(error_id, url, select_name, select_target, table,order,child) {
         if (typeof select_name !== 'undefined' ) {
             selNum = select_name.selectedIndex;           //Номер выбранного
             Isel = select_name.options[selNum].text;      //значение выбранного   
             //alert ('child='+child);
             //alert("Выбрано: "+Isel+" num="+selNum+" select="+select_name.name+'\n'+' tagret='+select_target.name+':'+select_target.options.length);
             //select_target.options.length=0;  //Обнуление Ok
             //$(select_target).empty();          //Обнуление Ok    
             document.getElementById('field').value = select_name.name;
             document.getElementById('data').value = select_name.value;
            
             document.getElementById('table').value = table;
             document.getElementById('order').value = order;
             if (child != '') { 
                var cl = child.split(';');               //select;select которые надо обнулить
                for (var i=0; i<cl.length; i++) {
                   $('#'+cl[i]).empty(); 
                   $('#'+cl[i]).append( $('<option value="0">нет данных</option>'));
                }
             }
            //var $select = $('<?=$row_FORM['SOURCE_FILTER']?>_').selectize(options); 
            //var selectize = $select[0].selectize; 
             
         }
             jQuery.ajax({
                    url:     url, //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных
                    data: jQuery("#"+'form_jfields').serialize(), 
                    success: function(response) { //Если все нормально
                    //document.getElementById(error_id).innerHTML = response;
                    //alert(response);
                    var opt = response.split(';');
                    $(select_target).empty();
                    for (var i=0; i<opt.length; i++) {
                        //alert (i+'opt='+opt[i]);
                      $(select_target).append( $(opt[i]));  
                    }
                },
                error: function(response) { //Если ошибка
                  document.getElementById(error_id).innerHTML = "Ошибка при отправке формы";
                }
             });
        }

   </script> 




</html>




