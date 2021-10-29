<html xmlns="http://www.w3.org/1999/xhtml">

<script language="JavaScript" type="text/javascript">
	function visiE(item,type) {
          var stat = document.getElementById(item).style.display;  
          if (stat!==type) {
             // alert (type+': '+item+' stat: '+stat);
	     document.getElementById(item).style.display = type;
             //if(type==='none') {
             //  alert (type+' на '+item);
             //   document.getElementById(item+'_').textContent=".";
             //}
          }
	}
        function show_button() {
            document.getElementById('panel_button').style.display = 'block'
        }
</script>
<style>
.text-typing
{
    width: 40em;
    color: white;
    padding:3px;
    font-size: 12px;
    /*font-family: 'Marck Script', cursive;*/
    white-space:nowrap;
    overflow:hidden;
    -webkit-animation: type 3s steps(50, end);
    animation: type 3s steps(50, end);
}
@keyframes type{
    from { width: 0; }
}
 
@-webkit-keyframes type{
    from { width: 0; }
}
</style>
<?php
    define ('OPT', 0, true);         //0-слева 1-справа


//==============================Форма таблицы по _TREE и _FORM       S Y S
// 	row_tree-<_TREE  запись заголовка формы

function FORM_table(&$row_TREE,&$ROW_role=0)
{
  //echo_dd(&$row_TREE,$row_TREE['NAME']);    ///
          $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));
          $base=new Thost2;
          $findM = new find_mask($user);
          $findM->Get_FIND(&$row_TREE);   // Заполнить массив фильтрами _FIND
          $tDATA=$findM->Get_FIND_TEK($row_TREE["PARAGRAF"]);
//        echo_pp(&$row_TREE,'user='.$user);
          if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          } else { $styleH=''; $styleF=''; }
?>
<div id="main">

<?php
   //UL();
  //echo_dd(&$row_TREE,'id='. GET_REF_ID('id') );
  $ID_REF=GET_REF_ID('id');                     //&id параметр предыдущего окна

//======================Формирование заголовка таблицы
//Взять дополнительный заголовок
  $Source=array();
  GET_SOURCE(&$row_TREE,&$Source);     //Прочитать фильтры


  if (FIND_SYS(&$row_TREE)===false) $bgcolor='bgcolor=white';
  else $bgcolor='bgcolor=#FFFFCC';                                // class="theform"
//---------------------------------------------Проверка наличия производных форм
  $sql_ET = new Tsql('select * from _TREE where PARAGRAF="'.$row_TREE["PARAGRAF"].'.edit"');
  if ( $sql_ET->num>0) $sql_ET->NEXT();
  $sql_DT = new Tsql('select * from _TREE where PARAGRAF="'.$row_TREE["PARAGRAF"].'.delete"');
  if ( $sql_DT->num>0) $sql_DT->NEXT();

//================================================================================<div class="text-typing"
?>
<form action="<?= MODUL.dTREE().dFORM.$row_TREE["PARAGRAF"]?>" method="post" class="theform" enctype="multipart/form-data">
<input type="hidden" name="do" value="<?= $row_TREE["PARAGRAF"]?>" />

<table cellspacing="0" <?=$bgcolor ?> class="theform" align="left" border="1" >
<caption <?=$styleH?>><div  style="padding:3px;"><?=$row_TREE["PARAGRAF"].' '.$row_TREE["NAME"].SCOBA($Source[0]).$findM->Get_FIND_HEAD()?></div></caption>
<tr>
<?php
     //=========================получить информацию о форме
  //выбрать форму
  $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" order by displayOrder';
  $result_FORM=mysql_query($sql_FORM);
  $num_results_FORM = mysql_num_rows($result_FORM);
  //echo_dd(&$row_TREE,$sql_FORM);    ///

  if (OPT==0)  TH_OPT();
  for($i=0; $i<$num_results_FORM; $i++)
  {
    $row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме
        if ($row_FORM["VISIBLE"]==0)continue;
              $F_column[]  =$row_FORM["COLUMN_FIELD"];
        //$F_visible[$i]=$row_FORM["VISIBLE"];
             $F_NONEDIT[]  =$row_FORM["NONEDIT"];
        //echo 'COLUMN_FIELD='.$F_column[$i];  //////
           $F_COLUMN_ID[]  =$row_FORM["id"];
         $F_COLUMN_NAME[]  =$row_FORM["COLUMN_NAME"];
         $F_COLUMN_SIZE[]  =$row_FORM["COLUMN_SIZE"];
      $F_COLUMN_DEFAULT[]  =$row_FORM["COLUMN_DEFAULT"];
           $F_kind_FIND[]  =$row_FORM["kind_FIND"];
                $F_bold[]  =$row_FORM["kind_bold"];
          $F_TYPE_FIELD[]  =$row_FORM["TYPE_FIELD"];
        $F_SOURCE_FIELD[]  =$row_FORM["SOURCE_FIELD"];
        $F_SOURCE_TABLE[]  =$row_FORM["SOURCE_TABLE"];
           $F_SOURCE_ID[]  =$row_FORM["SOURCE_ID"];
            $F_FILE_DIR[]  =$row_FORM["FILE_DIR"];
       $F_SOURCE_FILTER[]  =$row_FORM["SOURCE_FILTER"];
               $F_CHILD[]  =$row_FORM["CHILD"];
     //  echo "\n" .$row_FORM["COLUMN_FIELD"].'='.$row_FORM["CHILD"];  //

               //заголовок
        $w =$row_FORM["COLUMN_SIZE"];
        if ($w>0) $width='WIDTH="'.$w.'" NOWRAP'; else $width='';
	    echo '<th '.$width.'>';  //Ширина колонки
        echo GET_NAME(&$row_FORM);         //Имя поля или название самого поля
        echo '</th>';
  } //for                      //class="optionlinks"
  if (OPT==1)  TH_OPT();

?>
</tr>
<?php
//----------------------------------------------Вывод строки поиска
$COUNT_FIELD_FIND=0;
$MASK='';
$uNAME=''; 
$uPARENT=''; 


if ($row_TREE["kind_FIND"])
{   echo '<tr>';
        if (count($findM->ArrFIND)>0 and $findM->ArrFIND[0][0]==0) {         
            $FINDD=explode(':',$findM->ArrFIND[0][4]);     //FIELD_FND:DATA 
            //echo "<p/>".$findM->ArrFIND[0][4].':'.$findM->ArrFIND[0][3];
            $MASK=$findM->ArrFIND[0][3];
            $uNAME=$findM->ArrFIND[0][2]; 
            $uPARENT=$findM->ArrFIND[0][1]; 
        }    
        if (OPT==0)echo '<th>';
?>
           <style type="text/css">
           .filter { background-color: yellow; }
           </style>
<?php
        for($j=0; $j<count($F_COLUMN_SIZE); $j++)     // построение полей поиска $F_COLUMN_SIZE-любое поле, просто длина массива
        {  echo '<th>';
           if ($F_kind_FIND[$j]<>'')                  //надо рисовать поле
           {  $COUNT_FIELD_FIND++;
              $FLD=$F_column[$j].'_FND';
              //------------------------------------получить предустановленное значение
              $MASK_FIELD='';
              if (count($FINDD)>0)
              { $keyF=array_search($FLD, $FINDD);
                if( $keyF===false);                  //Нет предустановленного значения
                else
                 $MASK_FIELD=$FINDD[$keyF+1];
              }

              if ($MASK_FIELD<>'')        //Цветовой блок
                   $class='filter';
              else $class='text';

              if ($F_kind_FIND[$j]=='text')
                  echo '<input class="'.$class.'"  name="'.$FLD.'" size="'.($F_COLUMN_SIZE[$j]/7).'" value="'.$MASK_FIELD.'"/>';
              else  //default
              {   switch ($F_TYPE_FIELD[$j])
                  {   case 'bool':
                            if ($MASK_FIELD==1) $CHK='checked';
                            else                $CHK='';
                            echo'<input class="'.$class.'" type="checkbox" name="'.$FLD.'" value="'.$MASK_FIELD.'" '.$CHK.'/>';
                                  break;
                      case 'date':
?>
                           <input class="'.$class.'"  name="<? echo($FLD); ?>"  value="<? echo($MASK_FIELD); ?>"/>
   	                       <input name="imageField" type="image" id="trigger1" src="/PLUGIN/calendar/calendar2.gif" alt="Выбрать дату" style=" width:21px; height:21px; " border="0"></input>
                           <script type="text/javascript">
                           Calendar.setup({inputField: "<? echo($FLD); ?>", ifFormat: "%Y-%m-%d", button: "trigger1"});
                           </script>
<?php                                 break;
                      case 'cbox':
                           echo'<select name="'.$FLD.'" class="'.$class.'" >';
                           echo'<option value = "'.'">'.'пусто'.'</option>';
                           $CBOX=explode(",",$F_SOURCE_FILTER[$j]);
                           for($k=0; $k<count($CBOX); $k++)
                           { if($CBOX[$k]==$MASK_FIELD)    //Значение поля совпадает
                             echo'<option selected="selected" value = "'.$CBOX[$k].'">'.$CBOX[$k].'</option>';
	                         else
	                         echo'<option value = "'.$CBOX[$k].'">'.$CBOX[$k].'</option>';
                           }
                           echo'</select>';
                                   break;
                      default:
                            if ($F_SOURCE_TABLE[$j]<>"")     //Это производное поле из связанной таблицы
                            {
                              echo'<select name="'.$FLD.'" class="'.$class.'" >';
                              echo'<option value = "">пусто</option>';
                              if ($F_SOURCE_FILTER[$j]<>'')           //Дополнительный фильтр на выбор поля из связанной таблицы
					          { $Where=' where '.$F_SOURCE_FILTER[$j];
					          } else $Where='';

                                 $sql_P = new Tsql('select * from '.$F_SOURCE_TABLE[$j].$Where
                                              .' order by '.$F_SOURCE_FIELD[$j]);  //.' order by '.$F_SOURCE_FIELD[$j]   //$F_SOURCE_ID[$j]
						         for($k=0; $k<$sql_P->num; $k++)
						         { $sql_P->NEXT();
						           if($sql_P->row[ $F_SOURCE_ID[$j] ]==$MASK_FIELD)
    					           echo'<option selected="selected" value = "'.$sql_P->row[ $F_SOURCE_ID[$j] ].'">'.$sql_P->row[ $F_SOURCE_FIELD[$j] ].'</option>';
	                               else
						           echo'<option value = "'.$sql_P->row[ $F_SOURCE_ID[$j] ].'">'.$sql_P->row[ $F_SOURCE_FIELD[$j] ].'</option>';
						         }
						         echo'</select>';

                            }
                            else       //простое поле
                              echo '<input class="'.$class.'"  name="'.$FLD.'" size="'.($F_COLUMN_SIZE[$j]/7).'" value="'.$MASK_FIELD.'"/>';
                  } //swith
              }
           }
           echo '</th>';
        }

        //---------------------КНОПКА ПОИСК

        if (OPT==1)echo '<th>';

        echo '</th>';
    echo '</tr>';
}
//---------------------------------------------Вывод строки кнопок
 if($row_TREE['kind_ADD'] or $row_TREE["kind_FIND"])
 {  echo '<tr><td '.$styleF.' class="arr" COLSPAN='.(count($F_COLUMN_SIZE)+1).'>';   //class="arr"

   if (array_key_exists('in', $_GET))
   if ($Source[6]<>'')                         //Это child вызов     .'&mr='.$_GET['in']
   { BUTTON("button",'','/images/tree_S/home_green.png'
             ,'location.href=\''.MODUL.dTREE().dFORM.$Source[7].'&mr='.$_GET['in'].'#YK\''     //#op
             ,'cursive');
   }
   else
   BUTTON("button",'','/images/tree_S/home_green.png'
             ,'location.href=\''.MODUL.dTREE().dFORM.$row_TREE['PARENT'].'#YK\''
             ,'cursive');

//---------------------------------------------Вывод кнопки добавить
   if($row_TREE['kind_ADD']>0)            //Кнопка добавления kind_ADD<-формы добавления
   {                                      //получить информацию оформе добавления
     $PARAGRAF_ADD=$row_TREE["PARAGRAF"].".add";
     $sql='select * from _TREE where PARAGRAF="'.$PARAGRAF_ADD.'"';
     echo_dd(&$row_TREE,$sql);      ///
     //echo "\n".$sql;   ///
     $result=mysql_query($sql);
     $num_results = mysql_num_rows($result);
     if($num_results>0)
     {
       $row_ADD = mysql_fetch_array($result);

       BUTTON("button",$row_ADD["NAME"],'/images/tree_S/attach.png'
             ,'location.href=\''.MODUL.dTREE().dFORM.$PARAGRAF_ADD.'&atr=add'.GET_PARENT(&$row_TREE).$Source[6].'#YK\''
             ,'cursive');
       if($row_TREE['kind_PHOTO']>0)            //Кнопка добавления фотогаллереи
	   {   BUTTON("button",'','/images/tree_S/photo.png'
	             ,'location.href=\''.MODUL.dTREE().dFORM.$PARAGRAF_ADD.'&atr=photo'.GET_PARENT(&$row_TREE).$Source[6].'#YK\''
	             ,'');
	   }


     }  // $PARAGRAF_ADD
   }    // if


   if($row_TREE["kind_FIND"])   //Кнопка Фильтр
   {
                         //---------------Это фильтровая таблица
      if ($COUNT_FIELD_FIND>0 and $uPARENT=='')
      {
        if ($MASK<>'')
        BUTTON("submit","РеФильтр",'/images/tree_S/application_windows_locked.png','','cursive');
        else                                                //Кнопка FIND
        BUTTON("submit","Фильтр",'/images/tree_S/application_windows_shrink.png','','cursive');
      }

      if ($uPARENT<>'')     //Вывести название фильтра
      {
      	 echo '<a><font size="+1" face="cursive"><b>  '.$uNAME
      	      .'</b></font></a>';
      }

   }
   echo '</td></tr>';

 } //Строка кнопок
//----------------------------------------------Вывод таблицы
//  mysql_data_seek($result_FORM,0);   //в начало
     //получить даные из реальной таблицы
  $Where=' where';
  $sql_data=' from '.GET_TN($row_TREE["ID_TABLE"]); //'" where id="'.$_GET["id"].'"';

  $aMASK= $findM->Get_FIND_MASK();
  if ($aMASK>'') {
     $sql_data.=$Where.' '.$aMASK;
     $Where=' and'; 
  }
  if ($Source[4]<>"")         //маска выбора     //$row_TREE["parent_TABLE"]
  {   $sql_data.=$Where.' '.$Source[2].' = "'.$_GET["in"].'"';       //$row_TREE["ID_COLUMN"]
      $Where=' and';
  }
  if ($Source[1]<>"")                   //Фильтер дополнительный в _TREE
  {  $sql_data.=$Where.' '.$Source[1];             //$row_TREE["FILTER"]
     $Where=' and';
  }
  if ($MASK<>'')                                 //Фильтр пользователя
  {  $sql_data.=$Where.' '.$MASK;
     $Where=' and';
  }
  
  //---------------!!!!!!!-------------------Переменная установлена - OBJ - настройка на объект
              //$OBJ_MASK='';
              if (array_key_exists('OBJ', $_GET)==true)
	  	      { $OBJ=explode(':',$_GET["OBJ"]);   //id:paragraf
	  	        $sql_O= new Tsql('select * from _TREE where PARAGRAF="'.$OBJ[1].'"');
	  	        if($sql_O->num>0)
	  	        { $sql_O->NEXT();
	  	          // sys_BUTTON содержит название поля для маски (id_poddomen_all)
	  	          //-----делаем проверку наличия такого поля в обрабатываемом объекте
	  	          //echo_pp(&$row_TREE,'select '.$sql_O->row['sys_BUTTON'].' from '.$row_TREE['ID_TABLE'].' where 0');////
	  	          $sql_FLD='select '.$sql_O->row['sys_BUTTON'].' from '.$row_TREE['ID_TABLE'].' where 0';
	  	          echo_pp(&$row_TREE,'sql_FLD->sql='.$sql_FLD);
	  	          $r= mysql_query($sql_FLD);
                  if($r) //Поле существует
	  	          { $sql_data.=$Where.' '.$sql_O->row['sys_BUTTON'].'="'.$OBJ[0].'"';
	  	          }
	  	        }
              }
  //---------------------------------            

  if($row_TREE["kind_moved"]==true)
        $sql_data.=' order by displayOrder';
  else  if($row_TREE["ID_ORDER"]<>'')
           $sql_data.=' order by '.$row_TREE["ID_ORDER"];

  //===================================================================Постраничный вывод
  $LIMIT=PAGE( $sql_data,50,12 );
  //-------------------------------------------------------------------
  /*
  $LIMIT='';
  if (array_key_exists('page', $_GET) )                                //Уже страница определена в запросе
  {
    $numP = $_GET['page'];
  }
  else //Это первый запрос на страницу
  {
    $numP=1;
  }

  $str_date=mysql_query('select count(id) as CS '.$sql_data);         //предварительное количество строк по запросу Постраничный вывод
  $num_str_date = mysql_num_rows($str_date);
  if ($num_str_date>0)
  {  $row_CS = mysql_fetch_array($str_date);
     $CS=$row_CS['CS'];
     //echo "<p>количество строк запроса: $CS</p>";
     $page=30;                                                        //Количество строк на странице
     //Получить количество строк на странице
     //$sqlSP=new Tsql ("select value from config where id_vendor='".htmlspecialchars(trim($_SESSION['user_id']))."' and name='page'");
     //if ( $sqlSP->num>0) { $sqlSP->NEXT(); $page=$sqlSP->row['value']; }

     if ($CS>$page and $SyS==false) //-------------------------------------------------Нужно делить на страницы
     {  echo '<p>';
     	for ($v=0,$s=1; $v<$CS; $v+=$page,$s++)
     	{ //$Bpage=$v;
     	  $Epage=$v+$page;
     	  if ($Epage>=$CS) $Epage=$CS-1;
     	  if ($s==$numP)
     	  { $LIMIT=' LIMIT '.($numP-1)*$page.','.$page;
     	    $PNG='form.png';           //Оранжевая
     	  }
     	  else { $PNG='form_.png';       //Белая

     	  }
     	  echo '<a class="page" href="'.$_SERVER['REQUEST_URI']
     	                               .'&page='.$s.'" title="стр.'.$s.' c '.($v+1).'-'.$Epage.'"><img src="/images/tree_S/'
     	                               .$PNG.'" /></a>';
     	}
     	echo '</p>';
     	//$LIMIT=' LIMIT 0,'.$page;
     }
  }
  */
  //=================================================Конец вставки - постраничный ввод
  $sql='select * '.$sql_data.$sql_ord.$LIMIT;
  echo_pp(&$row_TREE,$sql);  ///
  $result_data=mysql_query($sql);
  $num_results_data = mysql_num_rows($result_data);
  
  echo_pp(&$row_TREE,"DOCUMENT_ROOT=".$_SERVER["DOCUMENT_ROOT"]);
     //получить информацию о производной форме (для возможной ссылке)
  $PARAGRAF_NEXT=$row_TREE["PARAGRAF"].".add";

  $sql_N='select * from _TREE where PARENT="'.$row_TREE["PARAGRAF"].'" and TYPE_FORM="TABLE"';
  echo_dd(&$row_TREE,$sql_N);   ///
  //echo "\n".$sql_N;   ///
  $result_N=mysql_query($sql_N);
  $num_results_N = mysql_num_rows($result_N);
  if($num_results_N>0)
  {   $row_N = mysql_fetch_array($result_N);
      $PARAGRAF_NEXT=$row_N["PARAGRAF"];
  }
  else
    $PARAGRAF_NEXT="";

  for($i=0; $i<$num_results_data; $i++)
  {
    $row = mysql_fetch_array($result_data);    //Строка данных
    //====================================================================Закладка - ЯКОРЬ
    if  (array_key_exists('mr', $_GET)
    and $_GET['mr']===$row['id'] )
    {  $OP='<a name="OP"></a>';
       $bg_tr='bgcolor=linen';          //Цвет строки возврата
    }
    else
    if ($ID_REF>0 and $ID_REF===$row['id'])
    {  $OP='<a name="OP"></a>';
       $bg_tr='bgcolor=linen';          //Цвет строки возврата
    }
    else { $OP=''; $bg_tr=$bgcolor; }

    if ($i>=0)
    {   //$bgcolor.
	  //echo '<tr valign="top" class="alt1" >';
	  echo '<tr valign="top"'.$bg_tr
                  .' onMouseOver="visiE(\'opt'.$row['id'].'\',\'inline-block \')"
	             onMouseOut ="visiE(\'opt'.$row['id'].'\',\'none\')">';
	}
    //=================================================================================



    if (OPT==0)  TR_OPT(&$row_TREE, &$row, &$sql_ET, &$sql_DT, &$Source);   //Опции в начале

    for($j=0; $j<count($F_COLUMN_SIZE); $j++)           //Обход по полям
    { //if ($F_visible)==false)continue;
      if($F_bold[$j]==true) { $FB='<b>';$FBe='</b>'; }
      else                  { $FB='';   $FBe=''; }
      //---------------------------------------------Разбор типов полей
     if ($F_COLUMN_SIZE[$j]>0) $width=' width="'.$F_COLUMN_SIZE[$j].'px" ';
     else  $width='';   
      //echo '<td width="'.$F_COLUMN_SIZE[$j].'px">';
     
     switch ($F_TYPE_FIELD[$j])  //================================td
     {
      case 'money':
          echo '<td ALIGN="right"'.$width.'>'.$FB;
          break;
     case 'bool':               //ComboBox
         echo '<td ALIGN="center"'.$width.'>'.$FB;
         break;
      default :   
         echo '<td'.$width.'>'.$FB;
     }
     
     //OPT_display($row['id']);      //Скрытые опции
     //echo '<div>';
     
     switch ($F_TYPE_FIELD[$j]) //data
     {
      case 'money':
          $money=number_format(0.0+$row[$F_column[$j]], 2, '.', '');
          echo $money;
          break;
      case 'bool':               //ComboBox
        if($row[$F_column[$j]]==1) $CHK='checked';
        else $CHK='';                                                             //$row_data  !!!
        if ($F_NONEDIT[$j]==1) $DSL='disabled';
        else $DSL='';
        echo'<input class="checkbox" type="checkbox"'
                .' name="'.$row_TREE['PARAGRAF'].$F_column[$j].$row['id']
                .'"  value="'.$row[$F_column[$j]].'" '.$CHK.' '.$DSL
                .' onChange="show_button()"'
                .'/>';
        break;
      case 'file':
        break;

      case 'jpg':
      case 'point':  //графический, поле это производный номер файла  ПОЛЕ COLUMN_FIELD указывает по какому полю составлять название
      case 'image':       // /img/photo/s_,[FILE_NAME]_postpref,jpg;W=168;H=252;Q=100;auto
                          // 0-0                       0-1      0-2 1     2     3     4
                          //               значение поля по имени
                          //                                     none - не надо расширения


        $iPAR=explode(';',$F_FILE_DIR[$j]);
        $pPREF=explode(',',$iPAR[0]);             //0-конструктор имени файла    0 1 2
        $pEXT=GET_EXT($pPREF[2]);                 //получить расширение

        if ($iPAR[1]=='')$iW=''; else $iW="width='$iPAR[1]'";
        if ($iPAR[2]=='')$iH=''; else $iH="height='$iPAR[2]'";
        if ($F_TYPE_FIELD[$j]=='jpg') $Namef='id';
        else                          $Namef=$F_column[$j];

        $FN='http://'.$base->H[$_GET['DB']][5].$pPREF[0].$row[$Namef].$pPREF[1].$pEXT;
        echo '<a href='.$FN.' title="'.$FN.'"><img src="'.$FN.'" '.$iW.' '.$iH.' alt="'.$FN.'"/></a>';   //
        break;
      case 'flash':
        $Namef='id';
        $FN0='http://'.$base->H[$_GET['DB']][5].$F_FILE_DIR[$j].$row[$Namef];
        $FNR=$FN0.'.swf';
        $FN =  array_pop(explode("/",$FN0));   //Имя без расширения
        echo_dd(&$row_TREE,$FNR.'='.$FN);     //\'http://www.ulyanovskmenu.ru/i/FLASH/top_'.$row_x["id"].'.swf

        echo '<script type="text/javascript"> writeFlash('.$row["weight"].','.$row["height"].',"'.$FNR.'","'.$FN.'"); </script>';
        break;
      case 'Fpoint':
        $Namef=$F_column[$j];
        $FN0='http://'.$base->H[$_GET['DB']][5].$F_FILE_DIR[$j].$row[$Namef];
        $FNR=$FN0.'.swf';                                                             //Полное имя файла
        $FN=  array_pop(explode("/",$FN0));   //Имя без расширения
        echo_dd(&$row_TREE,$FNR.'=='.$FN);     //\'http://www.ulyanovskmenu.ru/i/FLASH/top_'.$row_x["id"].'.swf

        //получить ссылочную "weight" "height"
        $sql_P= new Tsql('select weight,height from '.$F_SOURCE_TABLE[$j].' where '.$F_SOURCE_ID[$j].'="'.$row[$Namef].'"' );
        if ($sql_P->num>0)
        {
          $sql_P->NEXT();
          echo '<script type="text/javascript"> writeFlash('.$sql_P->row["weight"].','.$sql_P->row["height"].',"'.$FNR.'","'.$FN.'"); </script>';
        }
        break;
      case 'child':    //Поле для запуска таблицы расширения
        //echo "\n".   $F_TYPE_FIELD[$j].  '='.$F_column[$j].  '='.$F_CHILD[$j];     ///
        if ($F_CHILD[$j]<>'') 
             $url='href='.MODUL.'?DB='.$_GET['DB'].'&TREE='.$F_CHILD[$j].dFORM.$F_CHILD[$j].'&atr=open'.'&in='.$row['id'].'&child='.$row_TREE["PARAGRAF"].';'.$F_COLUMN_ID[$j];  
        else $url='';
        if ($F_SOURCE_TABLE[$j]=='')   {    //Простая ссылка
            if ($url<>'') {
                echo '<a'.$url.' ><u>'
                .$FB.$F_COLUMN_NAME[$j].$FBe
                .'</u></a>';
            } else {
               echo $FB.$F_COLUMN_NAME[$j].$FBe;   //Без ссылки 
            }
        } else {                              //Количественная ссылка
           $sql_P='select count(*) from '.$F_SOURCE_TABLE[$j].' where '.$F_SOURCE_ID[$j].'="'.$row[$F_column[$j]].'"';
           if ($F_SOURCE_FILTER[$j]<>'')
              $sql_P.=' and '.$F_SOURCE_FILTER[$j];
           //echo_dd(&$row_TREE,$sql_P); ///
           $result_P=mysql_query($sql_P);
           $num_results_P = mysql_num_rows($result_P);
           $CNT=0;
           $FNb=''; $FNe=''; $FCb=''; $FCe=''; 
           $class=''; 
           if($num_results_P>0)
           { $row_P = mysql_fetch_array($result_P);
             $CNT=$row_P[0];
             if ( ($CNT==0 and $F_bold[$j]==0) or ($CNT>0 and $F_bold[$j]==1))
             { /*$FNb='<div style="background-color:yellow;">';
               $FNe='</div';
               $FCb='<font color="red"><b>';
               $FCe='</font></b>';*/
               $class=' class="object0"';  
             }  
           }
           if ($F_COLUMN_DEFAULT[$j]>'') $CH_NAME=$F_COLUMN_DEFAULT[$j]; 
           else  $CH_NAME=$F_COLUMN_NAME[$j];
           
           echo '<nobr><a class="obj0"></a>';
           echo  '<a '.$url.' '.$class.'" >'
                //.$FNb.$CH_NAME.' '.$FCb. $CNT .$FCe .' '.$FNe
                   .$CH_NAME.':'.$CNT
                .'</a></nobr>';
        }
        break;
      case 'obj':
        if ( $row_TREE["TYPE_FORM"]=='TABLE_OBJ')           //Установить маску?
              $OBJ_MASK='&OBJ='.$row[$row_TREE["ID_COLUMN"]]
                .':'.$row_TREE["PARAGRAF"]
                .':'.$row_TREE["ID_TABLE"].':'.$F_column[$j];      //-------2017.02.07 Добавление (фильтр)
                //.':'.htmlspecialchars(trim($row[$F_column[$j]]));          //&OBJ=id:PARENT:  table:COLUMN_show
        else $OBJ_MASK='';

        $color='red';
        $URL= MODUL.'?DB='.$_GET['DB'].'&TREE='.$F_CHILD[$j].$OBJ_MASK.dFORM.$F_CHILD[$j].'&atr=open'.'&in='.$row['id'];
        /*
        ?>
              <td><u>
              <input type="submit" formmethod="post" formenctype="multipart/form-data" value="set"> 
              <input type="button" value="<?=$row[$F_column[$j]] ?>" formmethod="post" onClick='location.href="<?=$URL ?>"'>'
              </u></td>
        <?php
        */
        if ($tDATA==$row[$F_column[$j]] ) $class='star1';
        else  $class='star0';
      	echo  '<a class="'.$class.'" href='.$URL.'#YK />'
        . '<u><a href='.$URL.'#YK'
      	     .' style="color: '.$color.'">'
      	     .$row[$F_column[$j]]
      	     .'</a></u>';
               
        break;
      case 'edit':            //ограничение по количеству символов
      case 'editwin':
       $SIZE=explode(";",$F_COLUMN_SIZE[$j]);
       if (count($SIZE)==1) $SIZE_H=4;
       else $SIZE_H=$SIZE[1];

       echo '<div style="width: '.($SIZE[0]*5).'px;
                          height: '.($SIZE_H*10).'px;
                          padding: 1px;
                          overflow: auto;
                          ">';
       /*
        if ($F_COLUMN_DEFAULT[$j]>0) {  //количество символов
             if ( strlen($row[$F_column[$j]]) > $F_COLUMN_DEFAULT[$j] )
                  $STR=substr($row[$F_column[$j]],0,$F_COLUMN_DEFAULT[$j]).'...';
             else $STR=$row[$F_column[$j]];

        } else $STR=$row[$F_column[$j]];
        */
        echo
             $FB
             .'<a href='.MAKE_URL('FORM',$_GET['FORM']).'&idform='.$F_COLUMN_ID[$j].'&atr=edit&id='.$row['id'].' title="редактировать"
                style="text-decoration: none;"
               >'
	         .$row[$F_column[$j]]
	         .'<img src="/images/tree_S/edit.gif" alt="редактировать" />'
	         .'</a>'
             .$FBe;
        echo $OP.'</div>'; //Якорь
        $OP='';
        break;
      case 'area':            //ограничение по количеству символов
        if ($F_COLUMN_DEFAULT[$j]>0) $RWS=$F_COLUMN_DEFAULT[$j];   //количество строк
        else $RWS=2;
        //echo "<td>AREA=".$RWS;     //cols=".$row_FORM["COLUMN_SIZE"]."
        echo "<textarea cols=".$F_COLUMN_SIZE[$j]." rows=".$RWS." readonly style='border: none;'>".$row[$F_column[$j]]."</textarea>";
        echo $OP; //Якорь
        $OP='';
        break;
      default:                  //---------------------------текстовое поле или цифровое
       //if($F_TYPE_FIELD[$j]=='obj') $color='red'; else $color='blue';
       $color='default';
       if ($F_SOURCE_TABLE[$j]<>"")     //Это производное поле из связанной таблицы
       { $sql_P='select '.$F_SOURCE_FIELD[$j].' from '.$F_SOURCE_TABLE[$j]
                       .' where '.$F_SOURCE_ID[$j].'="'.$row[$F_column[$j]].'"'
                       ;
         //echo_dd(&$row_TREE,$sql_P); ///
         $result_P=mysql_query($sql_P);
         $num_results_P = mysql_num_rows($result_P);
         if($num_results_P>0)
         { $row_P = mysql_fetch_array($result_P);
           echo $row_P[$F_SOURCE_FIELD[$j]];
         }
         else echo 'пусто '.$row[$F_column[$j]];
       }
       else          //простое не связанное поле
       {

       	if ($PARAGRAF_NEXT<>"") {      //простое текстовое поле или цифровое со ссылкой
//      	echo '<a href='.MODUL.dTREE().$OBJ_MASK.dFORM.$PARAGRAF_NEXT.'&atr=open'.'&in='.$row['id'].' style="color: blue">'.'<td><u>'.$FB.$row[$F_column[$j]].$FBe. '</u></td>';
      	echo '<u><a href='.MODUL.dTREE().dFORM.$PARAGRAF_NEXT.'&atr=open'.'&in='.$row['id']
      	     .' style="color: '.$color.'">'
      	     .$row[$F_column[$j]]
      	     .'</a></u>';
        } else  { //-----------------Простые данные      
                echo $row[$F_column[$j]];
        }
        echo $OP; //Якорь
        $OP='';
       }

     } //switch
     echo '</div>'.$FBe.'</td>';
    }   //for FORM
    if (OPT==1)  TR_OPT(&$row_TREE, &$row, &$sql_ET, &$sql_DT, &$Source);   //опции в конце
    //echo '</div>';
    echo '</tr>';
  } //for data         //class="arr"
  //-------------------------------панель для редактирования panel_button
  //         ($COLSPAN,$B1,$B2,$B3,$tfoot="tfoot")
  SHOW_tfoot((count($F_COLUMN_SIZE)+1),1,1,0,"tfoot","none");
  
  echo '<tr><td COLSPAN='.(count($F_COLUMN_SIZE)+1).'>';
  PAGE( $sql_data,30,12 );

?>
</table>
<script language=javascript>location.hash='OP';</script>
</form>
</div>
<?php


} //end
  function OPT_display($id) {
    echo'<div  id="opt'.$id.'_"  class="optiondiv" 
                    onMouseOver="visiE(\'opt'.$id.'\',\'inline-block \')"
	            onMouseOut ="visiE(\'opt'.$id.'\',\'none\')"
         >&nbsp';     //&nbsp;
  }    

  function TR_OPT(&$row_TREE, &$row, &$sql_ET, &$sql_DT, &$Source) {
    echo'<td class="optionlinks">';     //none width="100px" inline-block 
    //OPT_display($row['id']);
    echo'<div style="display:none;" id="opt'.$row['id'].'" class="optiondiv">'; //none
    
   

    if($row_TREE["kind_moved"]==true)
    {
     echo '<a href='.MAKE_URL('FORM',$_GET['FORM'])
	                   .'&atr=up'.'&id='.$row['id'].' title="вверх"><img src="/images/tree_S/up.gif" alt="вверх" /></a>';
	 echo '<a href='.MAKE_URL('FORM',$_GET['FORM'])
	                   .'&atr=down'.'&id='.$row['id'].' title="вниз"><img src="/images/tree_S/down.gif" alt="вниз" /></a>';
	/*
    echo '<a href='.MODUL.dTREE().dFORM.$row_TREE['PARAGRAF']
                   .'&atr=up'  .'&id='.$row['id'].GET_PARENT(&$row_TREE).' title="вверх"><img src="/images/tree_S/up.gif" alt="вверх" /></a>';
    echo '<a href='.MODUL.dTREE().dFORM.$row_TREE['PARAGRAF']
                   .'&atr=down'.'&id='.$row['id'].GET_PARENT(&$row_TREE).' title="вниз"><img src="/images/tree_S/down.gif" alt="вниз" /></a>';
    */
    }

    $EDT=READ_FILTER_KIND($row_TREE["kind_EDIT"],&$sql_ET,&$row);
    if ($EDT)
    echo '<a href='.MAKE_URL('FORM',$_GET['FORM'].'.edit')
	                   .'&atr=edit'.'&id='.$row['id'].' title="правка"><img src="/images/tree_S/edit.gif" alt="правка" /></a>';
    /*
    echo '<a href='.MODUL.dTREE().dFORM.$row_TREE['PARAGRAF'].'.edit'
                       .'&atr=edit'.'&id='.$row['id'].GET_PARENT(&$row_TREE).$Source[6]
                   //.'&mr='.$row['id'].'#op'
                   .' title="правка"><img src="/images/tree_S/edit.gif" alt="правка" /></a>';
    */
    $DLT=READ_FILTER_KIND($row_TREE["kind_delete"],&$sql_DT,&$row);
    if ($DLT)
    echo '<a href='.MAKE_URL('FORM',$_GET['FORM'].'.delete')
	                   .'&atr=delete'.'&id='.$row["id"].' title="Удалить"><img src="/images/tree_S/delete.gif" alt="Удалить" /></a>';
    /*
    echo '<a href='.MODUL.dTREE().dFORM.$row_TREE['PARAGRAF'].'.delete'
                       .'&atr=delete'.'&id='.$row["id"].GET_PARENT(&$row_TREE).$Source[6].' title="Удалить"><img src="/images/tree_S/delete.gif" alt="Удалить" /></a>';
    */
    //echo '</div>';
    echo '</div></td>';
    
  }
//---------------------------------Из адреса страницы, с которой пришли на данную страницу получить параметр &id
//   делать доп проверку - если этот параграф является параграфом Prev текущего параграфа????
function GET_REF_ID($key)
{
  $id=0;
  $PAR=explode ('?',$_SERVER['HTTP_REFERER']);
  if (count($PAR)>1)
  { $VAR=explode ('&',$PAR[1]);
    for ($i=0; $i<count($VAR); $i++)  //Разбор параметров
    {
      $TEK=explode ('=',$VAR[$i]);
      if ($key===$TEK[0])            //параметр найден
      {
        $id=$TEK[1];
      	//echo "<p>key=$key: $VAR[$i]</p>";
      	break;
      }
    }
  }
  return $id;
}

function READ_FILTER_KIND($kind,&$sql_DT,&$row)
{   $RFK=false;
    if($kind==true)
    { if ( $sql_DT->num>0)
      { if ($sql_DT->row['FILTER']>'')         //Фильтер на удаление установлен
        {        //Взять массив полей со значениями и проверить на равенство в текущей записи
          $RFK=true;                          //Предустановка на фильтр
          $aFLT=explode(',',$sql_DT->row['FILTER']);    //разбор на аргументы
          for ($n=0; $n<count($aFLT); $n++)
          {  $FLT=explode('=',$aFLT[$n]);
             if (count($FLT)==2)         //Фильтр только одного поля через равно
             {
               if ($row[$FLT[0]]<>$FLT[1])
               { $RFK=false;
                 break;
               }
             }
          }
        }
        else
        $RFK=true;
      }
    }
    return $RFK;
}

function FORM_table_post(&$row_TREE)
{
  //пока только FINDER
  $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));

  echo_pp(&$row_TREE,"FINDER ($user)");

  $FINDER='';
  $FIELD_DATA='';
  $AND='';
  //-------------------------------Выбор только полей фильтра из формы
  $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" and kind_FIND<>"" order by displayOrder';
  $result_FORM=mysql_query($sql_FORM);
  $num_results_FORM = mysql_num_rows($result_FORM);
  echo_pp(&$row_TREE,'POST_TABLE='.$sql_FORM);          ///

  for($i=0; $i<$num_results_FORM; $i++)
  {
    $row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме
    $FLD=$row_FORM["COLUMN_FIELD"].'_FND';
    $DATA=$_POST[$FLD];
    echo_pp(&$row_TREE,'$FLD='.$FLD.' $DATA='.$DATA);
    if ($DATA<>'')                           //Есть заполнение поля фильтра
    { //if $row_FORM["TYPE_FIELD"]
      //поиск символов масок в запросе
      if ( strpos( $DATA,'%')===false
      and  strpos( $DATA,'*')===false)
        $LIKE='=';
        else $LIKE=' like ';

      $FINDER.=$AND . $row_FORM["COLUMN_FIELD"]. $LIKE .'"'.$DATA.'"';
      $FIELD_DATA.=$FLD.':'.$DATA.':';
      $AND=' and ';
    }
  } //for
  echo_pp(&$row_TREE,'$FINDER='.$FINDER);
  //---------------------Выбор записи Фильтра
  $sql_FND=new Tsql('select * from _FIND where USER="'.$user.'" and PARAGRAF="'.$row_TREE["PARAGRAF"].'" and LEVEL="0"');
  echo_pp(&$row_TREE,'sql_FIND->sql='.$sql_FND->sql);
  if ($FINDER<>'')       //Фильтр непустой
  { if ($sql_FND->num>0)  //Есть запись и фильтр заполнен
    {  $sql_FND->NEXT();
       if ($sql_FND->row["FINDER"]==$FINDER)   //это повторное нажатие -> снять фильтр
          $sql_INS=new Tsql('delete from _FIND where USER="'.$user.'" and PARAGRAF="'.$row_TREE["PARAGRAF"].'" and LEVEL="0"',1);
       else  //Новый фильтр - корректировать старый
          $sql_INS=new Tsql('update _FIND set FINDER=\''.$FINDER.'\', FIELD_DATA=\''.$FIELD_DATA.'\' '
                           .'where USER="'.$user.'" and PARAGRAF="'.$row_TREE["PARAGRAF"].'" and LEVEL="0"',1);
       echo_pp(&$row_TREE,'sql_INS->sql(1)='.$sql_INS->sql);
    }
    else  //Нет записи, но фильтр заполнен  -> УСТАНОВИТЬ НОВЫЙ ФИЛЬТР
    { $sql_INS=new Tsql('insert into _FIND (USER,PARAGRAF,LEVEL,FINDER,FIELD_DATA) VALUES ('
                       .'"'.$user.'",'
                       .'"'.$row_TREE["PARAGRAF"].'",'
                       .'"0",'
                       .'\''.$FINDER.'\','
                       .'"'.$FIELD_DATA.'")' ,1);
      echo_pp(&$row_TREE,'sql_INS->sql(2)='.$sql_INS->sql);
    }

  }
  else    //Фильтр пустой
  { if ($sql_FND->num>0)    //Запись есть, но фильтр пустой -> снять фильтр
    {    $sql_INS=new Tsql('delete from _FIND where USER="'.$user.'" and PARAGRAF="'.$row_TREE["PARAGRAF"].'" and LEVEL="0"',1);
         echo_pp(&$row_TREE,'sql_INS->sql(3)='.$sql_INS->sql);
    }
    else;    //нет записей и фильтр пустой  ->НИЧЕГО НЕ ДЕЛАТЬ
  }
} //end

  function TH_OPT() {
    echo	'<th width="60" ALIGN="center">Опции</th>';
  }
  
  
?>
</html>
