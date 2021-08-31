<html xmlns="http://www.w3.org/1999/xhtml">
<?php


//==============================Форма добавления по _TREE и _FORM
// 	row_tree-<_TREE  запись заголовка формы
function FORM_add(&$row_TREE,&$ROW_role=0)
{
 $DR='../images/tree_S/';
          $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));
          $findM = new find_mask($user);
          $findM->Get_FIND(&$row_TREE);   // Заполнить массив фильтрами _FIND
          if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url(); white-space:nowrap;"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          } else { $styleH=''; $styleF=''; }
 
 $Jfields=array();          
 $Source=array();                      //Для сохранения &child
 GET_SOURCE(&$row_TREE,&$Source);     //Прочитать фильтры

 if (FIND_SYS(&$row_TREE)===false) $SyS=false;
 else                              $SyS=true;    //системной формы
 if ($SyS)   { $bgcolor='bgcolor=#FFFFCC';   }
 else        { $bgcolor='bgcolor=white';     }
  //выбрать форму
 $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" order by displayOrder';
 $result_FORM=mysql_query($sql_FORM);
 $num_results_FORM = mysql_num_rows($result_FORM);
 echo_dd(&$row_TREE,$sql_FORM); ///
 //echo "\n".$sql_FORM;              ///
 $back_URL=MAKE_URL('FORM',$row_TREE["PARENT"],array('atr'));

?>
<div id="main">
<? echo_dd(&$row_TREE,MODUL.dTREE().dFORM.$row_TREE["PARENT"].GET_PARENT(&$row_TREE)); ////
   //MODUL.dTREE().dFORM.$row_TREE["PARENT"].GET_PARENT(&$row_TREE).$Source[6]
?>
<form method="post" action="" id="form_jfields">
    <input type="hidden" name="field" id="field" value="" />
    <input type="hidden" name="data" id="data" value="" />
    <input type="hidden" name="table" id="table" value="" />
    <input type="hidden" name="order" id="order" value="" />
    <input type="hidden" name="db" id="db" value="<?=$_GET['DB']?>" />
    
</form>    


 <form enctype="multipart/form-data" action=<? echo ($back_URL); ?> name="theform" method="post" class="theform" >
   <input type="hidden" name="do"      value="<? echo($row_TREE["PARAGRAF"]); ?>" />
   <table cellspacing="0" <?=$bgcolor ?> class="theform" align="left">
    <caption <?=$styleH?>><div style="padding:3px;"><?=$row_TREE["NAME"].SCOBA($Source[0]).$findM->Get_FIND_HEAD()?></div></caption>
<?php
if (array_key_exists('id', $_GET))
{
  $sql_TEK=new Tsql ('select * from '.$row_TREE["ID_TABLE"].' where id='.$_GET['id']);
  if ($sql_TEK->num>0)   $sql_TEK->NEXT();
}

        //$MASK='';          //$MASK[1]-значение
        //$MASK_FIELD='';
        //$uPARENT='';
        //GET_mask(&$row_TREE,&$MASK,&$MASK_FIELD,&$uPARENT);    //Получить инфу по маске  !!!<<<


for($i=0; $i<$num_results_FORM; $i++)
 {
  $row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме
  $FLD=$row_FORM["COLUMN_FIELD"];
  $IDf=$row_FORM["id"];
  if (strpos( $FLD,'sys_T')===false   //выполнять такие поля только в системной области
  or !(strpos( $_GET['TREE'],'sys')===false))
  {
   if($row_FORM["VISIBLE"]==1)
   {
     /*
     if ($row_FORM["NONEDIT"]==1)
         $DSL=' readonly ';
     else $DSL='';
     */
     if ($row_FORM["NONEDIT"]==1)
             $DSL='disabled';
        else $DSL='';

    //===============================================Умолчание
    //                                         формат: ;country=/country/:$in:/; news=/news/:$in:/; specials=/specials/:$in:/; tours=/tours/:$in:/
    $VOL='';
    if($row_FORM["COLUMN_DEFAULT"]<>'')
    { $volA=explode(';',$row_FORM["COLUMN_DEFAULT"]);  //разные умолчания для разных вызовов по таблицам
                                                       //[0] - без Родительского вызова $Source[4] или если совпадений не найдено
      for ($a=1; $a<count($volA); $a++)
      {
        $volI=explode('=',$volA[$a]);
        if (count($volI)==2)
        {
          if($Source[4]==trim($volI[0]))      //Название таблиц для вызвавшего процесса и умолчания совпадают
          {
          	//echo_dd(&$row_TREE,'Default: S[4]:'.$Source[4].' S[0]'.$Source[0].' '.$a.':'.$volI[1]);
          	$VOL=GET_DEFAULT( trim($volI[1]) ,&$Source ,&$row_TREE, &$sql_TEK);
          	break;
          }
        }
      }
      if ($VOL=='')  //Умолчание умолчания
            $VOL=GET_DEFAULT( trim($volA[0]) ,&$Source ,&$row_TREE, &$sql_TEK);
   	}

   	//===============================================Вывод самих полей


   	switch ($row_FORM["TYPE_FIELD"])
   	{ case 'bool':                                              //поле галка (checkbox)
?>
    <tr>
    <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?></td>
    <td>
<?php    if($VOL==1)
             $CHK='checked';
      else { $CHK=''; $VOL=0; }
      echo'<input '.$DSL.'class="checkbox" type="checkbox" name="'.$FLD.'" value="'.$VOL.'" '.$CHK.'/>';
?>
	<div id="theform_visible_error" class="error" style="display:none"></div>
    </td>
    </tr>
<?php            break;
      case 'file': //===========================
      case 'flash':

?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM).' ['.$row_FORM["FILE_DIR"].']'?>:</td>
      <td>
<?php
      echo'<input class="text" type="file" '.$DSL.'name="'.$FLD.'" size="70" />';
      //echo'<label><input class="text" type="file" name="'.$FLD.'" /></label>';
?>
	<div id="theform_visible_error" class="error" style="display:none"></div>
    </td>
    </tr>
<?php
   	          break;
    case 'point':   //Это производное поле графического файла из связанной таблицы
                    //Указатель на уже загруженное поле
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM).' ['.$row_FORM["FILE_DIR"].']'?>:</td>
      <td>
<?php       echo'<select name="'.$FLD.'" class="text" >';
         echo'<option value = "0">пусто</option>';
         if ($row_FORM['SOURCE_FILTER']<>'')           //Дополнительный фильтр на выбор поля из связанной таблицы
         { $Where=' where '.$row_FORM['SOURCE_FILTER'];
         } else $Where='';

         $sql_P = new Tsql('select * from '.$row_FORM['SOURCE_TABLE'].$Where.' order by '.$row_FORM['SOURCE_ID']);
         for($k=0; $k<$sql_P->num; $k++)
         { $sql_P->NEXT();
           echo'<option value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$sql_P->row[$row_FORM['SOURCE_FIELD']].'</option>';
         }
         echo'</select>';
		 echo'<div id="theform_title_error" class="error" style="display:none"></div>';
	     echo'</td>';
         echo'</tr>';
   	          break;
   	         /*                          $format
                            /img/photo/s_,[FILE_NAME]_postpref,jpg;W=168;H=252;Q=100;0-4 hor;0-4 ver;0-1 inner
                             0-0                       0-1      0-2 1     2     3     4      5       6
                                           значение поля по имени                                    вписать
                                                                 none - не надо расширения
             */
      case 'jpa':         //JPG array
      case 'jpg':         //одиночный jpg
   	  case 'image':              //Новый вариант      частично или полностью название храниться в поле этого типа
   	     $iPAR=explode(';',$row_FORM["FILE_DIR"]);   //Чтение параметров
   	     if (count($iPAR)>4) $HOR_def=$iPAR[4]; else $HOR_def=2;
         if (count($iPAR)>5) $VER_def=$iPAR[5]; else $VER_def=2;
         if (count($iPAR)>6) $INN_def=$iPAR[6]; else $INN_def=0;
?>
    <tr> <td bgcolor='black' style="padding-right: 10px" colspan=2><font color='white'><?=GET_NAME(&$row_FORM).' ['.$row_FORM["FILE_DIR"].']'?>:</font>
    <tr style="background-color: #F3F3F3;">        <!--Для перегрузки фотки-->
		<td style="padding-right: 10px">Выбрать Фото.
		<td><input class="text" type="file"  name="<? echo($FLD);?>" size="70" value="" />
		<div id="theform_meta_keywords_error" class="error" style="display:none"></div>
	<tr style="background-color: #F3F3F3;">
	    <td style="padding-right: 10px">Поз.горизонтально:
	    <td><select name="<?=$FLD.'_'.$IDf?>_horizont" class="text">
<?php
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
<?php
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
<?php
	       if ($INN_def>0) $CHK='checked';
	       else            $CHK='';
	    ?>
	    <td><input class="checkbox" type="checkbox" <?=$CHK?> name="<?=$FLD.'_'.$IDf?>_inner" size="70" value="<?=$INN_def?>" />
<?php
        if ($row_FORM["TYPE_FIELD"]=='jpa')
        {
        	echo '<tr style="background-color: #F3F3F3;">
	              <td style="padding-right: 10px">Настройки по умолчанию:
	              <td><input class="checkbox" type="checkbox" name="'.$FLD.'_'.$IDf.'_load"  value="0" />';
        }
              break;
   	  case 'image9':   //Старый вариант
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM).' ['.$row_FORM["FILE_DIR"].']'?>:</td>
    </tr>
    <tr style="background-color: #F3F3F3;"> <!--Дополнительное свойствообрезки при загрузки -->
		<td style="padding-right: 10px">Использовать авто преобразование в миниатюры (обрезка фото)</td>
		<td>
		<input class="checkbox" type="checkbox"  name="<? echo($FLD.'_auto'); ?>" size="70" value="1" />
		<div id="theform_meta_keywords_error" class="error" style="display:none"></div>
	    </td>
    </tr>
    <tr style="background-color: #F3F3F3;">        <!--Для перегрузки фотки-->
		<td style="padding-right: 10px">Выбрать Фото. </td>
		<td>
		<input class="text" type="file"  name="<? echo($FLD);?>" size="70" value="" />
		<div id="theform_meta_keywords_error" class="error" style="display:none"></div>
	</td>
</tr>
<?php
              break;
      case 'date':
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?php
      echo '<input class="object date" '.$DSL.'style="width:70px;" type="text"
             value="'.$VOL.'" id="'.$FLD.'" name="'.$FLD.'" >';

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

	  <div id="theform_visible_error" class="error" style="display:none"></div>

      </td>
    </tr>
<?php
   	          break;
      case 'cbox':          //Выбор фиксированных значений
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?php
         echo'<select name="'.$FLD.'" class="text" >';
         echo'<option value = "'.'">'.'пусто'.'</option>';
         $CBOX=explode(",",$row_FORM["SOURCE_FILTER"]);
         for($k=0; $k<count($CBOX); $k++)
         { echo_dd(&$row_TREE,$CBOX[$k].'=='.$row_data[$FLD]);
           if($CBOX[$k]==$VOL)    //Значение поля совпадает
	       echo'<option selected="selected" value = "'.$CBOX[$k].'">'.$CBOX[$k].'</option>';
	       else {
	              if ($DSL=='');
	              echo'<option value = "'.$CBOX[$k].'">'.$CBOX[$k].'</option>';
	       }
         }
         echo'</select>';
             break;
         	  case 'edit':
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM).' ['.$row_FORM["FILE_DIR"].']'?>:</td>
      <td>
       <div style="width: <?=($row_FORM["COLUMN_SIZE"])*5?>px;">

      <textarea id="editor_kama" name="<? echo($FLD); ?>"  cols="<?=$row_FORM["COLUMN_SIZE"]?>">
      </textarea>

      <script type="text/javascript">
      var ckeditor = CKEDITOR.replace('editor_kama',{ skin : 'kama' });
	    AjexFileManager.init({
	    returnTo: 'ckeditor',
	    editor: ckeditor,
	    skin: 'dark'
	    });
      </script>

      </div>
<?php
   	          break;

      case 'Stable':          //Выбор таблиц из текущей базы
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?php    echo'<select '.$DSL.' name="'.$FLD.'" class="text" >';
         echo'<option value = "'.'">'.'пусто'.'</option>';
         $sql_P = new Tsql('show tables');
         for($k=0; $k<$sql_P->num; $k++)
         { $sql_P->NEXT();
           //if($sql_P->row[0]==$row_data[$FLD])
	       //echo'<option selected="selected" value = "'.$sql_P->row[0].'">'.$sql_P->row[0].'</option>';
	       //else
	       if($sql_P->row[0]==$VOL) $SLT='selected ';
           else $SLT='';


           echo'<option '.$SLT.' value = "'.$sql_P->row[0].'">'.$sql_P->row[0].'</option>';
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
        <textarea name="<?=$FLD?>" <?=$DSL?>cols="<?=$SIZE[0]?>" rows="<?=$SIZE_H?>"><?=$VOL?></textarea>
        <div id="theform_name_error" class="error" style="display:none"></div>
      </td>
   </tr>
<?php
             break;
       case 'password':
?>    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
      <input class="text"  
              name="<?=$FLD?>" 
              <?=$DSL?>
              size="<?=$row_FORM['COLUMN_SIZE']?>" 
              value="<?=$VOL?>" />
<?php                                                      //$VOL - ***** или пусто
        break;      

   	  default:     //--------------------------поле int или test - не checkbox
?>
    <tr>
      <td style="padding-right: 10px"><?=GET_NAME(&$row_FORM)?>:</td>
      <td>
<?php
      if ($row_FORM['SOURCE_TABLE']<>"")     //Это производное поле из связанной таблицы
      {
         //$sss='select * from '.$row_FORM['SOURCE_TABLE'].' order by '.$row_FORM['SOURCE_ID'];
        echo_dd($row_TREE,'$00 '.$row_FORM["TYPE_FIELD"]);
        if($row_FORM["TYPE_FIELD"]=='Jfield') { //============================================
           echo_dd($row_TREE,'$001');
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
         echo'<select name="'.$FLD.'" id="'.$FLD.'" class="text"  >';    
        }
         echo'<option value = "0">пусто</option>';

         $AND=' where '; $Where='';
         if ($row_FORM['SOURCE_FILTER']<>'')           //Дополнительный фильтр на выбор поля из связанной таблицы
         {
           if ($row_FORM['SOURCE_FILTER']=='$$')       //Дополнительно ограничить выбор маской
           {
                 $maska_select=$findM->Get_FIND_MASK();
               echo "<p> maska_select = $maska_select </p>";

               if ($maska_select<>'')          //Установлена маска на ветку
		         { $Where.=$AND.$maska_select;
                           //echo "<p/>Where=$Where";
		         }
           }
           else
           {	                                      //Просто фильтр
             $sfilter=explode('=',$row_FORM['SOURCE_FILTER']);   //Если есть равно = -> это точное значение фильтра
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
//echo "<p> $Where </p>";


         $sql_P = new Tsql('select * from '.$row_FORM['SOURCE_TABLE'].$Where
                          .' order by '.$row_FORM['SOURCE_FIELD']);
//         $sql_P->OPEN('select * from '.$row_FORM['SOURCE_TABLE'].' order by '.$row_FORM['SOURCE_ID']);
         //$sql_P->OPEN($sss);
         for($k=0; $k<$sql_P->num; $k++)
         { $sql_P->NEXT();
           if ($row_FORM['COLUMN_SIZE']>0)
                $STR=substr($sql_P->row[$row_FORM['SOURCE_FIELD']],0,$row_FORM['COLUMN_SIZE']).'...';
           else $STR=$sql_P->row[$row_FORM['SOURCE_FIELD']];
           if($sql_P->row[$row_FORM['SOURCE_ID']]==$VOL)
                echo'<option selected value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$STR.'</option>';
           else { if ($DSL=='')
                  echo'<option value = "'.$sql_P->row[$row_FORM['SOURCE_ID']].'">'.$STR.'</option>';
           }
         }
         echo'</select>';
		 echo'<div id="theform_title_error" class="error" style="display:none"></div>';
	     echo'</td>';
         echo'</tr>';

         //echo "\n".$sql_P->sql
         //.' num='.$sql_P->num
         //.' SOURCE_ID='.$row_FORM["SOURCE_ID"]
         //.' 1->'.$sql_P->row[$row_FORM["SOURCE_ID"]]
         //.' 2->'.$sql_P->row[$row_FORM["SOURCE_FIELD"]] ;    ///////
      }
      else
      {              //Простое поле text
        if ($SyS)
        { switch($FLD)                    //Умолчания
          {
          	case 'PARENT':   $VOL= $_GET["TREE"];
          	                 break;
            case 'PARAGRAF':
                             $VOL= $_GET["TREE"].'.';
          	                 break;
            default:         $VOL='';
          }
        }
        //echo_pp(&$row_TREE,'VOL='.$VOL.' FLD='.$FLD);
?>
        <input class="text"  name="<?=$FLD?>" <?=$DSL?>size="<?=$row_FORM['COLUMN_SIZE']?>" value="<?=$VOL?>" />
<?php
        echo '<div id="theform_name_error" class="error" style="display:none"></div>';
?>
      </td>
   </tr>
<?php
      }
    } //switch

   }   //visible
  } //sys поля
 } //for
 SHOW_tfoot(2,1,1,$back_URL);

?>
	</table>
</form>

</div>
<?php
}




//========================================POST Формы добавления по _TREE и _FORM
//========================================Добавить запись по кнопке "отправить"
// 	row_tree-<_TREE  запись заголовка формы
function FORM_add_post(&$row_TREE)
 {
	   $base=new Thost2;
           $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));
           $findM = new find_mask($user);
           $findM->Get_FIND(&$row_TREE);   // Заполнить массив фильтрами _FIND
           $mask=$findM->Get_ADD_MASK();
           $maska_select=$findM->Get_FIND_MASK();
           echo_pp(&$row_TREE,'$maska_select='.$maska_select.':'.$mask[0].':'.$mask[1]);

                  $Source=array();
	          GET_SOURCE(&$row_TREE,&$Source);     //Прочитать фильтры

	   $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" order by displayOrder';
	   $result_FORM=mysql_query($sql_FORM);
	   $num_results_FORM = mysql_num_rows($result_FORM);
	 //echo "\n",$sql_FORM;     ///
       //$MASK='';          //$MASK[1]-значение
      //$MASK_FIELD='';
       //$uPARENT='';
       //GET_mask(&$row_TREE,&$MASK,&$MASK_FIELD,&$uPARENT);    //Получить инфу по маске


//------------------------------------------------------------
	  $STR='insert into '.$row_TREE["ID_TABLE"].' (';
	  $DAT='value (';
	  $SMC=' ';       //это в дальнейшем запятая
	  if ($mask[0]<>'')          //Установлена маска на ветку
	  {
	    $STR.=$mask[0];
	    $DAT.=$mask[1];
	    $SMC=',';
	  }
  $login=''; 
  $password=array('','');
  for($i=0; $i<$num_results_FORM; $i++)        //формирование запроса
  {
   $row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме
   $WriteField=true;                               //Писать поле по умолчанию false - не писать             
    //Если поле автоинкрементное - пропустить id
   $FLD=$row_FORM["COLUMN_FIELD"];
   $IDf=$row_FORM["id"];
   if ($FLD=='login') $login=$_POST[$FLD];   //Сохранить значение login для password
   //echo_pp(&$row_TREE,'FLD='.$FLD.' POST='.$_POST[$FLD]. 'FILES='.$_FILES[$FLD]);  //
   if (($_POST[$FLD]<>'' or $_FILES[$FLD]<>'' )      //по любому из условий делаем post
   or $FLD=='displayOrder' )
   {
     if ($FLD=='id')  continue;                   //ID  (проверить по таблице - атоинкрементное поле или нет

	     switch ($row_FORM["TYPE_FIELD"])
	     { case 'bool':                 //ComboBOX
	                   $CHK=GET_CHECK($FLD);
	                   break;
	/*
	       case 'in':
	            if($_POST[$FLD]>0)  $CHK='"'.$_POST[$FLD].'"';     //дополнительное Поле редактирования
	            else $CHK='"'.$_GET['in'].'"';
	            //echo_dd(&$row_TREE,'field_in-->'$CHK);
	            break;
	*/
	      case 'file':                               //Этозагрузка файла
			           $EXP[]='.php';
			           $DEPOSIT[]=$row_FORM["TYPE_FIELD"];      //Отложить операцию
	                   $D_FLD[]=$FLD;
	                   $phpPath[]=$_SERVER["DOCUMENT_ROOT"].$row_FORM["FILE_DIR"];
	                   $name_ID[]=$_POST[ $row_FORM["SOURCE_FIELD"] ];
	                   //echo_dd(&$row_TREE,'$name_ID[]='.$_POST[ $row_FORM["SOURCE_FIELD"] ]);///
	                   break;
	      case 'jpg1':              //Загрузить файл по ID
	                  $EXP[]=GET_EXT($row_FORM['CHILD']);
	      case 'flash':                         //Продолжение jpg
	                  if ($row_FORM["TYPE_FIELD"]=='flash')
	                      $EXP[]='.swf';
	                  echo_pp(&$row_TREE,'--->'.$row_FORM["TYPE_FIELD"]);
	                               //Добавлять сразу нельзя - неизвестен новый ID
	                  $DEPOSIT[]=$row_FORM["TYPE_FIELD"];      //Отложить операцию
	                  $D_FLD[]=$FLD;
	                  $POSTPREF=explode(',',$row_FORM["FILE_DIR"]);
	                  //$phpPath[]=$_SERVER["DOCUMENT_ROOT"].$POSTPREF[0];
	                  $pPREF1[]=$POSTPREF[0];
	                  $pPREF2[]  =$POSTPREF[1];
	                  $name_ID[]='';
	                  break;
	      case 'jpa':
	                   //=====================================JPG array в  $row_FORM["FILE_DIR"] через ;
	                  //echo_pp(&$row_TREE,$row_FORM["TYPE_FIELD"]);
	                  $aJPG=explode(';',$row_FORM["FILE_DIR"]);
	                  $Sf=''; $aCOMA='';
	                  for ($y=0; $y<count($aJPG); $y++)         //перечисления COLUMN_FIELD (
	                  {  $Sf.=$aCOMA.'"'.$aJPG[$y].'"';
	                     $aCOMA=',';
	                  }
	                  if ($Sf<>'')
	                  {

	                  	if(isset($_POST[$FLD.'_'.$IDf.'_load']))$load=1;   //Грузить параметры по умолчанию, для каждого поля
	                    else $load=0;

	                  	$Sq2='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"]
	                                      .'" and COLUMN_FIELD in ('.$Sf.') order by displayOrder';
	                    //echo_pp(&$row_TREE,"$FLD - $SQL");
	                    $sql_ARR= new Tsql($Sq2);
					    for($y=0; $y<$sql_ARR->num; $y++)    //Обход по полям для чтения настроек по подгружаемому файлу
					    { $sql_ARR->NEXT();
                          if ($sql_ARR->row["TYPE_FIELD"]<>'jpg')continue;      //Проверяем только поля jpg
                          //-----------------------------$sql_ARR->row имеем запись о форматировании jpg
                            $DEPOSIT[]=$sql_ARR->row["TYPE_FIELD"];      //Отложить операцию jpg
	                        $D_FLD[]  =$FLD;
	                        $pPREF1[]= $sql_ARR->row["FILE_DIR"];     //$Format
	                        if($load==0)
	                             $pPREF2[]  =GET_opt_jpg($FLD,$IDf);      //parametры    ОДИНАКОВЫЕ ДЛЯ ВСЕЙ ГРУППЫ
	                        else $pPREF2[]  =GET_opt_fld($sql_ARR->row["FILE_DIR"]);                   //2;2;1  // Через точку с запятой
	                        $name_ID[]='';          //Значит заполнить последним IDом
                            echo_pp(&$row_TREE,"$y: ".$sql_ARR->row["TYPE_FIELD"]." $FLD ".$sql_ARR->row["FILE_DIR"]." IDf=$IDf");
					    }
	                  }
	                  break;

	      case 'jpg': //--------------------------------------новый вариант (по FTP загрузка не производиться)
	      case 'image':
	                  // В названии файла записывается новый id_записи
	                    /*                          $format
	                            /img/photo/s_,[FILE_NAME]_postpref,jpg;W=168;H=252;Q=100;0-4 hor;0-4 ver;0-1 inner
	                             0-0                       0-1      0-2 1     2     3     4      5       6
	                                           значение поля по имени                                    вписать
	                                                                 none - не надо расширения
	                    */
	             //echo_pp(&$row_TREE,$FLD.'_'.$IDf.'_horizont');

                 $DEPOSIT[]=$row_FORM["TYPE_FIELD"];      //Отложить операцию jpg
	             $D_FLD[]  =$row_FORM["COLUMN_FIELD"];
	             $pPREF1[] =$row_FORM["FILE_DIR"];     //$Format
	             $pPREF2[]  =GET_opt_jpg($FLD,$IDf);      //parametры


                 if ($row_FORM["TYPE_FIELD"]=='image')
	             {  if(isset($_FILES[$FLD]))
			        {
						$error_flag = $_FILES[$FLD]["error"];
			            if($_FILES[$FLD]["error"] == 0) $isCorrectLOAD = 1;
			        }
		            else  $isCorrectLOAD =  0;

				    if($isCorrectLOAD == 1)
				    { $name_ID[]=basename($_FILES[$FLD]["name"]);
                      $CHK='"'.basename($_FILES[$FLD]["name"]).'"';
				    }
                 }
                 else
                 $name_ID[]='';          //Значит заполнить последним IDом

	             //IMAGE_MAP($row_FORM["FILE_DIR"], &$Fname ,$IDf,$horizont, $vertical ,$inner);
	             //IMAGE_MAP($pPREF1[], &$Fname ,$IDf,$horizont, $vertical ,$inner);
	             break;
          /*
	      case 'image5':            //post разбор поля          в названии файла фигурирует новый id записи и значение самого поля


	                      //Загрузка графического файла (3 переменные - FLD и FLD_ID_horizont FLD_ID_vertical FLD_ID_inner
	                      //Если пусто - ничего не грузить      $FLD.'_'.$IDf?>"_vertical  - название переменных
	       if( isset ( $_FILES[$FLD] ) )
	        {
	            if($_FILES[$FLD]["error"] == 0) $isCorrectAddInstr = true;
	        }
	        else  $isCorrectAddInstr = false;
			if($isCorrectAddInstr == true)  //Заполнено поле файла
			{
	          $horizont=$_POST[$FLD.'_'.$IDf.'_horizont'];
	          $vertical=$_POST[$FLD.'_'.$IDf.'_vertical'];
	          $inner=$_POST[$FLD.'_'.$IDf.'_inner'];
			  //$Fname='';
	          //if (!($err=IMAGE_MAP($row_FORM["FILE_DIR"],&$Fname,$IDf,$horizont,$VER_def,$inner)))   //без FTP
	              echo_pp(&$row_TREE,$err);

	            $imgPath=$Fname;
	            echo_pp(&$row_TREE,'файл='.$imgPath);            ///


	            {
	              if (!copy($_FILES[$FLD]["tmp_name"],$imgPath)) //Просто откопировать
	                   echo 'не удалось создать файл';
	            }
	            $CHK='"'.$data_ulmenu["document_photo"].basename($_FILES[$FLD]["name"]).'"';
			} //$isCorrectAddInstr
	                   break;
           */

	      case 'image9':   //Загрузка графического файла (2 переменные - FLD и FLD_auto
	                      //Если пусто - ничего не грузить
	                      //файл настроек
	       if(isset($_FILES[$FLD]))
	        {
				$error_flag = $_FILES[$FLD]["error"];
	            if($_FILES[$FLD]["error"] == 0) $isCorrectLOAD = 1;
	        }
	        else  $isCorrectLOAD =  0;

			if($isCorrectLOAD == 1)  //Заполнено поле файла
			{
	          if ($row_FORM["FILE_DIR"]<>'')
	          {
	            include  ('..'.$row_FORM["FILE_DIR"]);       //файл настроек
	            $imgPath=$_SERVER["DOCUMENT_ROOT"].$data_ulmenu['document_photo'].basename($_FILES[$FLD]['name']);
	            echo_pp(&$row_TREE,'файл='.$imgPath);            ///

	            if(isset($_POST[$FLD.'_auto']))      //Преобразовывать?
	            { //echo "\n 333";   ///
			      $Twidth=$data_ulmenu['report_thumb_width'];
			      $Theight=$data_ulmenu['report_thumb_height'];
	              echo_dd(&$row_TREE,' w='.$Twidth.' h='.$Theight);           ////
	        //function create_thumbnail($srcpath, $destpath, $maxw = false, $maxh = false, $quality = false)
			      if (!create_thumbnail($_FILES[$FLD]['tmp_name'], $imgPath, $Twidth, $Theight,100))
				       echo'не удалось создать миниатюру';
	            }
	            else
	            { //echo "\n 555";   ///
	              if (!copy($_FILES[$FLD]["tmp_name"],$imgPath)) //Просто откопировать
	                   echo'не удалось создать файл';
	            }
	            $CHK='"'.$data_ulmenu["document_photo"].basename($_FILES[$FLD]["name"]).'"';
	           //echo "\n 999";
	            //Проверить код возврата
	          }  //FILE_DIR
			} //$isCorrectAddInstr
	        break;
                
        case 'password':
            if (($_POST[$FLD]=='*****') || ($_POST[$FLD]=='')) {
                $WriteField=false;               //не писать
            } else {
               if ($login=='') $WriteField=false;   //не было поля login 
               else {
                   $password[0]=$FLD;
                   $password[1]=$_POST[$FLD];
               //$CHK='"'.password_crypt_id($_POST['id'],$password,$login).'"';   //($id_user,$pas,$login) 
               }        
            }
            break;        
	//-----------------------------------------------------------------------------
	      case 'point':
	      case 'Fpoint':
	      default:                                   //поле int или test - не checkbox
	       //echo "\n ".$FLD;
	       if ($FLD=='displayOrder')   //-----------------------------------displayOrder
	       { echo_pp(&$row_TREE,$FLD);
	         //------------------------------------------


	          $Where=' where ';
	          $Where_MAX='';
	          if ($Source[4]<>"")         //маска выбора     //$row_TREE["parent_TABLE"]
			  {   $Where_MAX.=$Where.$Source[2].' = "'.$_GET["in"].'"';       //$row_TREE["ID_COLUMN"]
			      $Where=' and ';
			  }
			  if ($Source[1]<>"")                   //Фильтер дополнительный в _TREE
			  {   $Where_MAX.=$Where.$Source[1];             //$row_TREE["FILTER"]
			      $Where=' and ';
			  }
	          if ($maska_select<>'')          //Установлена маска на ветку
	          {   $Where_MAX.=$Where.' '.$maska_select;
	              $Where=' and ';
	            
	          }

	        $sqll='SELECT MAX(displayOrder) as maxx FROM '.$row_TREE["ID_TABLE"].$Where_MAX;
	        echo_pp(&$row_TREE,'$Where_MAX='.$sqll);
	        $result_M = mysql_query($sqll);

			$row_M = mysql_fetch_array($result_M);
			if ($_POST[$FLD]>'') $CHK='"'.$_POST[$FLD].'"';
			else                 $CHK=$row_M["maxx"]+1;
	        echo_pp(&$row_TREE,$row_M["maxx"].' '.$sqll);

			//echo "\n maxx=".$CHK;       //
			//if ($_POST[$FLD]) $CHK=$maxx;
			//                 else $CHK=$_POST[$FLD];
	       }
	       else {
	       	//----------------------выходное поле заключается в одиночные ковычки. Поэтому одиночных ковычек в данных $CHK быть не должно
            //$CHK="'".htmlentities($_POST[$FLD],ENT_QUOTES,"cp1251")."'";      //2016.07.24
	        $CHK="'".$_POST[$FLD]."'";
	       }
	     }    // switch

	    if ($row_FORM["TYPE_FIELD"]<>'file'
	    and $row_FORM["TYPE_FIELD"]<>'jpg'
	    and $row_FORM["TYPE_FIELD"]<>'jpa'
	    and $row_FORM["TYPE_FIELD"]<>'flash'
            and $row_FORM["TYPE_FIELD"]<>'password'        
	    and (!( $row_FORM["TYPE_FIELD"]=='image'  and $isCorrectLOAD == 0))
	    )    //Пропустить
	    { $STR.=$SMC.$FLD;
	      $DAT.=$SMC.$CHK;
	      $SMC=',';
	    }
   } //<>''
  }  //for
  // ---------------------дописать связанное поле со значением
  if   ($row_TREE['parent_TABLE']<>''
        and (array_key_exists('in', $_GET))
        and ($_GET['in']>0))
        {   if ($findM->isField($row_TREE['ID_COLUMN'])==false) {
                $STR.=$SMC.$row_TREE['ID_COLUMN'];
                $DAT.=$SMC.'"'.$_GET['in'].'"';
            }    
        }
  //---------------------дописать фильтр [type="left"]
  if  ($row_TREE['FILTER']<>'')
  { $aFLT=explode(',',$row_TREE['FILTER']);    //разбор на аргументы
    for ($n=0; $n<count($aFLT); $n++)
    {  $FLT=explode('=',$aFLT[$n]);
       if (count($FLT)==2)         //Фильтр только одного поля через равно
       {
     	$STR.=$SMC.$FLT[0];
     	$DAT.=$SMC.$FLT[1];
       }
    }
  }

  $STR.=') '.$DAT.')';
  echo_pp(&$row_TREE,$STR);
  if(!mysql_query($STR))          //Выполнить INSERT
     echo "\n <p> Ошибка INSERT</p>";


//------------------------------------------------------------------------------
  $last_ID=mysql_insert_id();           
// дописать пароль в запись по ID
  if ($login<>'' && $password<>'') {
      $STR='update '.$row_TREE["ID_TABLE"]
              .' set '.$password[0].'="'.password_crypt_id($last_ID,$password[1],$login)
              .'" where id="'.$last_ID.'"';
      echo_pp(&$row_TREE,$STR);
      if(!mysql_query($STR))
          echo "\n Ошибка UPDATE: ".$STR;
  }


//дозагрузка отложенных файлов по ID  и просто
        echo_pp(&$row_TREE,'count($DEPOSIT)='.count($DEPOSIT). 'last_ID='.$last_ID);   ////

        for ($i=0; $i<count($DEPOSIT); $i++)
        {
	         $isCorrectLOAD = 0;
	         if(isset($_FILES[ $D_FLD[$i] ]))
	         {
				$error_flag = $_FILES[ $D_FLD[$i] ]["error"];
	            if($_FILES[ $D_FLD[$i] ]["error"] == 0) $isCorrectLOAD = 1;
	         }

         //---------------------------------------------------
         if($isCorrectLOAD == 1)
         {      // надо грузить графический файл, а не хочется
		   //Получить номер последнего записанного ID (по его номеру строиться имя файла)
		   echo_pp(&$row_TREE,'$name_ID[]='.$name_ID[$i]);///

		   if ($name_ID[$i]=='')
		       $name_ID[$i]=$last_ID;
           /*
		   if ($DEPOSIT[$i]=='image')   //Создать имя файла с расширением (none) и IDом
		   {
		   }
		   */
		   echo_pp(&$row_TREE,'$name_ID[]='.$name_ID[$i]);///
           $HBS=$_GET['DB'];

           if ($DEPOSIT[$i]=='jpg' or $DEPOSIT[$i]=='image')
           {  if ($base->F[$HBS][0]==false)    //занрузка по HTTP только для  файлов с маштабированием
              {
                $Fname='';
                $opt=explode(';',$pPREF2[$i]);
                $err=IMAGE_MAP(&$row_TREE, &$base, $D_FLD[$i], $pPREF1[$i], &$Fname , &$name_ID[$i], $opt[0], $opt[1] ,$opt[2]);
                if (!$err=='')
                    echo "<p>$err</p>";
               echo_pp(&$row_TREE,"Fname=$Fname $pPREF1[$i] $name_ID[$i] $pPREF1[$i] $pPREF2[$i]");
              }
           }
          else
          {
               //Храним как /i/JPG/left_
           //========================================================================
           $FN=$name_ID[$i]. $pPREF2[$i]. $EXP[$i];
           //------------------------------------------------------выбор способа загрузки файла
           if ($base->F[$HBS][0]==true)   // ---------------------загрузка по FTP
           {
             $Tunel='';
             $file=$_FILES[ $D_FLD[$i] ] ["tmp_name"];
             $remote_file=$base->F[$HBS][3].$pPREF1[0].$FN;
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
           else //------------------------HTTP---------------------загрузка в каталог по определенному пути (с корректировкой пути)
           {
	           $site=$base->F[$HBS][3];
	           $phpPath=$site.$pPREF1[$i];

	           echo_pp(&$row_TREE,"Подготовка файла site=$site phpPath=$phpPath $FN");

		       if(!copy($_FILES[ $D_FLD[$i] ] ["tmp_name"],$phpPath.$FN))    //Фиксированное расширение  (Может произойти замена расширения)
	           echo "\n Ошибка загрузки файла:".           $phpPath.$FN;
	           echo_pp(&$row_TREE,'Перезагрузка файла='.   $phpPath.$FN);   ///
	           //Проверить код возврата
           }
          } //не jpg
		 }
        }   //for

 }


function GET_DEFAULT($STR, &$Source, &$row_TREE, &$sql_TEK)
 {
      $volM=explode(':',$STR);
      for($m=0; $m<count($volM);$m++)
      {  switch ($volM[$m])
         { case '$in':
                 if (array_key_exists('in', $_GET))
                     $volM[$m]=$_GET['in'];
                 else $volM[$m]='';
                 break;
           case '$TITLE':
                 //echo_dd(&$row_TREE,'title:'.$volM.'|'.$volM[$m].'|'.$Source[0]);
                 $volM[$m]= trim($Source[0]);
                 break;
           case '$ID_FIELD':     //заполнить значениями полей по этой же таблице $ID_FIELD:object
                 $status=0;
                 if (array_key_exists('id', $_GET))
                 {  $volM[$m]=$sql_TEK->row[$volM[($m+1)]];            //=$sql_TEK->row
                 }
                 $m++;
                 $volM[$m]='';
                 break;
           case '$FIELD':        //это значение поля родительской таблицы
                 //$m++;
                 $status=0;
                 $PAR_2=$row_TREE["PARENT"];  //тот кто вызвал add         //$row_TREE
                 for ($z=0; $z<2; $z++)
                 {
                   $sql_PAR=new Tsql ('select PARENT,ID_TABLE from _TREE where PARAGRAF="'.$PAR_2.'"');
                   if ($sql_PAR->num==0)
                   { $status=-1; break; }
                   $sql_PAR->NEXT();
                   echo_pp(&$row_TREE,"PAR_2=$PAR_2 ID_TABLE=".$sql_PAR->row['ID_TABLE']);
                   $PAR_2=$sql_PAR->row['PARENT'];
                   //unset ($sql_PAR);
                 }
                 echo_pp(&$row_TREE,$volM[$m].'->'.$volM[($m+1)] );
                 if ($status==0)
                 {    $sql_FLD=new Tsql ('select '.$volM[($m+1)].' from '.$sql_PAR->row['ID_TABLE'].' where id='.$_GET['in']);
                      echo_pp(&$row_TREE,$sql_FLD->sql);
                      if ($sql_FLD->num>0)
                      {  $sql_FLD->NEXT();
                         $volM[$m]=$sql_FLD->row[$volM[($m+1)]];
                      }  else $volM[$m]='';
                 }
                 else $volM[$m]='';
                 $m++;
                 $volM[$m]='';
                 break;
           case '$OPERATOR':
                 $volM[$m]=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));
                 break;
           case '$PD':      //Наименование поддомена - подставить
                 $uNAME='';
                 $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));
                 $sql_FND=new Tsql('select * from _FIND where USER="'.$user.'" and PARAGRAF="'.$row_TREE["PARAGRAF"].'"');
                 if ($sql_FND->num>0)   //Есть запись о фильтре
                 {
                   $sql_FND->NEXT();
                   $uNAME=$sql_FND->row['NAME'];
                 }

                 $volM[$m]=$uNAME;
                 break;
           case '$TODAY':
                 $volM[$m]=date("Y-m-d");
                 break;
           case '$TODAY_TIME':
                 $volM[$m]=date("Y-m-d H:m:s");
                 break;
           case '$MKTIME':
                 $volM[$m]=time(void);
                 break;
         } //switch
      } //for по разбору переменных
      return implode('',$volM);
 }

// Получить значения POST формы для масштабирования JPG
function GET_opt_jpg($FLD,$IDf)
{
	             $opt[0]=$_POST[$FLD.'_'.$IDf.'_horizont'];
	             $opt[1]=$_POST[$FLD.'_'.$IDf.'_vertical'];
	             if(isset($_POST[$FLD.'_'.$IDf.'_inner']))$opt[2]=1;
	             else $opt[2]=0;
                 return implode (';',$opt);
}

function GET_opt_fld($Fnm)
{        $iPAR=explode(';',$Fnm);
         if (count($iPAR)>4) $H_def=$iPAR[4]; else $H_def=2;
         if (count($iPAR)>5) $V_def=$iPAR[5]; else $V_def=2;
         if (count($iPAR)>6) $I_def=$iPAR[6]; else $I_def=0;
         return $H_def.';'.$V_def.';'.$I_def;
}

?>
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
                var cl = child.split(';');
                for (var i=0; i<cl.length; i++) {
                   $('#'+cl[i]).empty(); 
                   $('#'+cl[i]).append( $('<option value="0">нет данных</option>'));
                }
             }
            ///*var $select = $('<?//=$row_FORM['SOURCE_FILTER']?>//_').selectize(options); */
            // var selectize = $select[0].selectize;
             
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