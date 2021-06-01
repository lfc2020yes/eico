
<style>
#dropZone {
  width: 600px;
  /*height: 100%;  */
  min-height: 200px;
  margin: 10px;
  border: dotted black 1px;
}
#dropZone.hover {
    background: #ddd;
    border-color: #aaa;
}

#dropZone.error {
    background: #faa;
    border-color: #f00;
}

#dropZone.drop {
    background: #afa;
    border-color: #0f0;
}

</style>

<script type="text/javascript">
  var atr = "<?= htmlspecialchars($_GET['atr']) ?>";      //для отслеживания onload
</script>

<script type="text/javascript" src="js/selectingFiles.js"></script>
<script type="text/javascript" src="js/dragFiles.js"></script>


<?php


//==============================Форма добавления по _TREE и _FORM
// 	row_tree-<_TREE  запись заголовка формы
function FORM_photo(&$row_TREE)
{
 $DR='../images/tree_S/';

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


?>
<div id="main">
<? echo_dd(&$row_TREE,MODUL.dTREE().dFORM.$row_TREE["PARENT"].GET_PARENT(&$row_TREE)); ////
   //echo "\n".MODUL.dTREE().dFORM.$row_TREE["PARENT"].GET_PARENT(&$row_TREE).$Source[6];
   $back_URL=MAKE_URL('FORM',$row_TREE["PARENT"],array('atr'));
?>
 <form enctype="multipart/form-data" action=<? echo ($back_URL); ?> name="theform" method="post" class="theform" >
   <input type="hidden" name="do"      value="<? echo($row_TREE["PARAGRAF"]); ?>" />
   <input type="hidden" name="atr"     value="photo" />
   <table cellspacing="0" <?=$bgcolor ?> class="theform" align="left">
    <caption><div style="padding:3px; vertical-align:middle">
             <img style="padding-right:10px;" src="http://<?  echo($_SERVER["HTTP_HOST"]); ?>/images/tree_S/photo.png">
             <? echo($row_TREE["NAME"].SCOBA($Source[0])); ?></div></caption>
   <tr><td>
             <input type="hidden" name="MAX_FILE_SIZE" value="128000">
             <input  type="file" id="file" name="file[]"
                                 multiple="true" style="padding:10px;"
                                 onchange="onFilesSelect(this);"/>
       	     <div id="theform_visible_error" class="error" style="display:none"></div>
   <tr><td>
      	     <div id="dropZone">
      	         <div id="output" style="padding:3px;
      	                                 text-align: center;">для загрузки перетащи файлы в эту область</div>
      	     </div>
      	     <ul id="filelist"></ul>
<?php
if (array_key_exists('id', $_GET))
{
  $sql_TEK=new Tsql ('select * from '.$row_TREE["ID_TABLE"].' where id='.$_GET['id']);
  if ($sql_TEK->num>0)   $sql_TEK->NEXT();
}

        $MASK='';          //$MASK[1]-значение
        $MASK_FIELD='';
        $uPARENT='';
        GET_mask(&$row_TREE,&$MASK,&$MASK_FIELD,&$uPARENT);    //Получить инфу по маске


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
     if ($row_FORM["NONEDIT"]==1)
         $DSL=' readonly ';
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
        {          if($Source[4]==trim($volI[0]))      //Название таблиц для вызвавшего процесса и умолчания совпадают
          {          	//echo_dd(&$row_TREE,'Default: S[4]:'.$Source[4].' S[0]'.$Source[0].' '.$a.':'.$volI[1]);
          	$VOL=GET_DEFAULT( trim($volI[1]) ,&$Source ,&$row_TREE, &$sql_TEK);
          	break;          }        }      }
      if ($VOL=='')  //Умолчание умолчания
            $VOL=GET_DEFAULT( trim($volA[0]) ,&$Source ,&$row_TREE, &$sql_TEK);
   	}

   	//===============================================Вывод самих полей


   }   //visible
  } //sys поля
 } //for
 SHOW_tfoot(2,1,1,$back_URL);

?>
	</table>
</form>

</div>
<?
}




//========================================POST Формы добавления по _TREE и _FORM
//========================================Добавить запись по кнопке "отправить"
// 	row_tree-<_TREE  запись заголовка формы
function FORM_add_gallery_post(&$row_TREE)
 {
	   $base=new Thost2;

	          $Source=array();
	          GET_SOURCE(&$row_TREE,&$Source);     //Прочитать фильтры

	   $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" order by displayOrder';
	   $result_FORM=mysql_query($sql_FORM);
	   $num_results_FORM = mysql_num_rows($result_FORM);
	 //echo "\n",$sql_FORM;     ///
       $MASK='';          //$MASK[1]-значение
       $MASK_FIELD='';
       $uPARENT='';
       GET_mask(&$row_TREE,&$MASK,&$MASK_FIELD,&$uPARENT);    //Получить инфу по маске
       /*
       $cnt=count($_FILES['file']['name']);
       echo('<br/>POST PHOTO:'.$cnt );

       if ($cnt>0)
       for ($i=0; $i<$cnt; $i++) {
        if ($_FILES['file']['size'][$i]>0) {          echo ('<p/>'.$_FILES['file']['name'][$i]
                  .'|'.$_FILES['file']['tmp_name'][$i]
                  .'|'.$_FILES['file']['size'][$i]
                  .'|'.$_FILES['file']['type'][$i]
                  );
        }
       }
       */

       if (array_key_exists('count_file', $_POST)) {           $count_file=$_POST['count_file'];
           echo '<p/>$count_file='.$count_file;
           for ($i=0; $i<$count_file; $i++) {
           }
       }


 }

 function FFF(&$row_TREE)
 {
//------------------------------------------------------------
	  $STR='insert into '.$row_TREE["ID_TABLE"].' (';
	  $DAT='value (';
	  $SMC=' ';       //это в дальнейшем запятая
	  if ($MASK_FIELD<>'')          //Установлена маска на ветку
	  {
	    $STR.=$MASK_FIELD;
	    $DAT.='"'.$MASK[1].'"';
	    $SMC=',';
	  }

  for($i=0; $i<$num_results_FORM; $i++)        //формирование запроса
  {
   $row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме

    //Если поле автоинкрементное - пропустить id
   $FLD=$row_FORM["COLUMN_FIELD"];
   $IDf=$row_FORM["id"];
   //echo_pp(&$row_TREE,'FLD='.$FLD.' POST='.$_POST[$FLD]. 'FILES='.$_FILES[$FLD]);  //
   if (($_POST[$FLD]<>'' or $_FILES[$FLD]<>'' )      //по любому из условий делаем post
   or $FLD=='displayOrder' )
   {
     if ($FLD=='id')  continue;                   //ID  (проверить по таблице - атоинкрементное поле или нет



	    if ($row_FORM["TYPE_FIELD"]<>'file'
	    and $row_FORM["TYPE_FIELD"]<>'jpg'
	    and $row_FORM["TYPE_FIELD"]<>'jpa'
	    and $row_FORM["TYPE_FIELD"]<>'flash'
	    and (!( $row_FORM["TYPE_FIELD"]=='image'  and $isCorrectLOAD == 0))
	    )    //Пропустить
	    { $STR.=$SMC.$FLD;
	      $DAT.=$SMC.$CHK;
	      $SMC=',';
	    }
   } //<>''
  }  //for
  // ---------------------дописать связанное поле со значением
  if  ($row_TREE['parent_TABLE']<>''
        and (array_key_exists('in', $_GET))
        and ($_GET['in']>0))
  {   $STR.=$SMC.$row_TREE['ID_COLUMN'];
      $DAT.=$SMC.'"'.$_GET['in'].'"';
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
       }    }
  }

  $STR.=') '.$DAT.')';
  echo_pp(&$row_TREE,$STR);
  if(!mysql_query($STR))          //Выполнить INSERT
     echo "\n <p> Ошибка INSERT</p>";


//------------------------------------------------------------------------------
//дозагрузка отложенных файлов по ID  и просто
        echo_pp(&$row_TREE,'count($DEPOSIT)='.count($DEPOSIT). 'last_ID='.mysql_insert_id());   ////

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
		       $name_ID[$i]=mysql_insert_id();
           /*
		   if ($DEPOSIT[$i]=='image')   //Создать имя файла с расширением (none) и IDом		   {
		   }
		   */
		   echo_pp(&$row_TREE,'$name_ID[]='.$name_ID[$i]);///
           $HBS=$_GET['DB'];

           if ($DEPOSIT[$i]=='jpg' or $DEPOSIT[$i]=='image')
           {  if ($base->F[$HBS][0]==false)    //занрузка по HTTP только для  файлов с маштабированием
              {                $Fname='';
                $opt=explode(';',$pPREF2[$i]);
                $err=IMAGE_MAP(&$row_TREE, &$base, $D_FLD[$i], $pPREF1[$i], &$Fname , &$name_ID[$i], $opt[0], $opt[1] ,$opt[2]);
                if (!$err=='')
                    echo "<p>$err</p>";
               echo_pp(&$row_TREE,"Fname=$Fname $pPREF1[$i] $name_ID[$i] $pPREF1[$i] $pPREF2[$i]");
              }           }
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




?>
</html>
