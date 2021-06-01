<html xmlns="http://www.w3.org/1999/xhtml">
<?php

//==============================Форма таблицы по _TREE и _FORM       S Y S
// 	row_tree-<_TREE  запись заголовка формы

function FORM_table_XYi(&$row_TREE)
{
  //echo_dd(&$row_TREE,$row_TREE['NAME']);    ///
//          echo_pp(&$row_TREE,'user='.$user);
?>
<div id="main">

<?
   //UL();



//======================Формирование заголовка таблицы
//Взять дополнительный заголовок
  $TITLE=''; $act='';
  if ($row_TREE["parent_TABLE"]<>""
  and (array_key_exists('in', $_GET))
  and ($_GET['in']>0))
  { $act='&atr=open&in='.$_GET['in'];
  	$sql_T = new Tsql('select '.$row_TREE["parent_TITLE"].' from '.GET_TN($row_TREE["parent_TABLE"]).' where '.$row_TREE["parent_COLUMN"].'="'.$_GET['in'].'"');
  	echo_dd(&$row_TREE,$sql_T->sql); ///
  	//echo "\n".$sql_T->sql;   /////
  	if ($sql_T->num>0)
  	{  $sql_T->NEXT();
  	   $TITLE=' ['.$sql_T->row[$row_TREE["parent_TITLE"]].']';
  	}
  }

  if (FIND_SYS(&$row_TREE)===false) $bgcolor='bgcolor=white';
  else $bgcolor='bgcolor=#FFFFCC';                                // class="theform"
//---------------------------------------------Проверка наличия производных форм
/*
  $sql_ET = new Tsql('select * from _TREE where PARAGRAF="'.$row_TREE["PARAGRAF"].'.edit"');
  if ( $sql_ET->num>0) $sql_ET->NEXT();
  $sql_DT = new Tsql('select * from _TREE where PARAGRAF="'.$row_TREE["PARAGRAF"].'.delete"');
  if ( $sql_DT->num>0) $sql_DT->NEXT();
*/

  $user='';
  $MASK='';
  $uNAME='';
  $uPARENT='';
  $FINDD='';
  $FD='';
  GET_MASK_USER(&$user,&$row_TREE,&$MASK,&$uNAME,&$uPARENT,&$FINDD,&$FD);

?>
<form action=<? echo (MODUL.dTREE().dFORM.$row_TREE["PARAGRAF"].$act); ?> method="post" class="theform">
<input type="hidden" name="do" value=<? echo($row_TREE["PARAGRAF"]); ?> />

<table class="theform" align="left" border="1" <?=$bgcolor?> rules="cols">
<caption><div style="padding:3px;"><? echo($row_TREE["PARAGRAF"].': '.$row_TREE["NAME"].$TITLE); ?></div></caption>
<tr>
<?
   //=========================получить информацию о форме  XYZ
  //------------------------------выбрать форму  c полем X   (через id достать дату)
  $status=0;
  $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" and MASTER in ("Xi") and VISIBLE=1 order by displayOrder';
  $result_FORM=mysql_query($sql_FORM);
  $num_results_FORM = mysql_num_rows($result_FORM);
  echo_pp(&$row_TREE,'$sql_FORM='.$sql_FORM);    ///
  if ($num_results_FORM>0)
  {  	$row_FORM = mysql_fetch_array($result_FORM);    //Строка описания поля в форме
  	//------Сформировать заголовок таблицы
  	$where='';
  	$and=' where ';
    if ($MASK<>'')                                 //Фильтр пользователя
    {  if (isFIELD($FD, $row_FORM["SOURCE_TABLE"])==true)      //???????
             {           $where.=$and.$MASK;
                         $and=' and ';
             }
    }
    if ($row_FORM["SOURCE_FILTER"]>'')            //Дополнительный простой фильтр на выбор
    { $where.=$and.$row_FORM["SOURCE_FILTER"];
    }

    $sql_X='select * from '.$row_FORM["SOURCE_TABLE"].$where   //с ограничением по маске
                         .' order by '.$row_FORM["SOURCE_FIELD"];
    $result_X=mysql_query($sql_X);
    $num_results_X = mysql_num_rows($result_X);
    echo_pp(&$row_TREE,'$sql_X='.$sql_X);    ///

        $w =$row_FORM["COLUMN_SIZE"];            //ширина колонок
        if ($w>0) $width='WIDTH="'.$w.'" NOWRAP';
        else      $width='';
        echo '<tr><th '.$width.'>';  //Первая колонка
        echo GET_NAME(&$row_FORM);         //Имя поля или название самого поля
        echo '</th>';

    for($i=0; $i<$num_results_X; $i++)
    {
        $row_X = mysql_fetch_array($result_X);    //данные X по шапке таблицы

        $X_SOURCE_DATA[]   =$row_X[$row_FORM["SOURCE_FIELD"]];    //это дата по шапке таблицы
        $X_SOURCE_ID[]     =$row_FORM["SOURCE_ID"];
        $X_COLUMN_FIELD[]  =$row_FORM["COLUMN_FIELD"];
        $X_SOURCE_ID_DATA[]=$row_X[$row_FORM["SOURCE_ID"]];    //это дата по шапке таблицы
	    echo '<th '.$width.'>';
        echo '<font size="-3">'.$X_SOURCE_DATA[$i].'</font>';         //значение
        echo '</th>';

    }  } else $status=-1; //Нет X
  //------------------------------рисовать форму  по полю X
 if ($status==0)
 {
?>
            <style type="text/css">
           .fil1
           {
             background-color: #CCFFCC; /* Цвет фона */
             text-align: center;
             border-style: none;
             font-size: 80%;
             /* color: black;  Цвет текста */

           }
           .fil2
           {
             background-color: white; /* Цвет фона */
             text-align: center;
             border-style: none;
             font-size: 80%;
             /* color: black;  Цвет текста */

           }
           </style>
<?  $sql_FORM='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" and MASTER in ("Y") and VISIBLE=1 order by displayOrder';
  $result_FORM=mysql_query($sql_FORM);
  $num_results_FORM = mysql_num_rows($result_FORM);
  echo_pp(&$row_TREE,'$sql_FORM='.$sql_FORM);    ///
  if ($num_results_FORM>0)                 //   YYYYYYYYYYY
  {
  	$row_FORM = mysql_fetch_array($result_FORM);    //выбрана инфа по полю Y
  	$Y_TABLE=$row_FORM["SOURCE_TABLE"];
    $where=' where visible=1';
  	$and=' and ';
    if ($MASK<>'')                                 //Фильтр пользователя
    {  if (isFIELD($FD, $row_FORM["SOURCE_TABLE"])==true)
             {           $where.=$and.$MASK;
                         $and=' and ';
             }
    }
    if ($row_FORM["SOURCE_FILTER"]>'')            //Дополнительный простой фильтр на выбор
			{            $where.=$and.$row_FORM["SOURCE_FILTER"];
					     $and=' and ';
		    }
	/*
    if ($sql_T->num>0)             //Зависимая форма
		    {		                 $where.=$and.$row_TREE["ID_COLUMN"].'="'.$_GET['in'].'"';
		    }
    */

    $sql_Y='select * from '.$row_FORM["SOURCE_TABLE"].$where   //с ограничением по маске
          .' order by displayOrder'; //'.$row_FORM["SOURCE_ID"];         //by displayOrder ????????????????? Вроде надо
    echo_pp(&$row_TREE,'$sql_Y='.$sql_Y);    ///
    $result_Y=mysql_query($sql_Y);
    $num_results_Y = mysql_num_rows($result_Y);


        $w1 =$row_FORM["COLUMN_SIZE"];            //ширина колонок
        if ($w>0) $width_Y='WIDTH="'.$w1.'" NOWRAP';
        else      $width_Y='';
    //---------------------------------------------Читать данные за один раз


    $sql_FD='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" and MASTER in ("Z") and VISIBLE=1 order by displayOrder';
    $result_FD=mysql_query($sql_FD);
    $num_results_FD = mysql_num_rows($result_FD);
    echo_pp(&$row_TREE,'$sql_FD='.$sql_FD);    ///
    if($num_results_FD>0)                        //ТОлько одно поле читается
    { $row_FD = mysql_fetch_array($result_FD);      //Описание поля Z - может быть теxt bool cbox
      /*
      $Where=' and ';
      $sql_data='select *
                 FROM '
                 .GET_TN($row_TREE["ID_TABLE"].' c, '
                 .$Y_TABLE.' f'
                 .' WHERE c.id_fond=f.id'
                );


      if ($row_TREE["parent_TABLE"]<>"")         //маска выбора
      {   $sql_data.=$Where.'c.'.$row_TREE["ID_COLUMN"].' = "'.$_GET["in"].'"';
          $Where=' and ';
      }
      if ($row_TREE["FILTER"]<>"")                   //Фильтер дополнительный в _TREE
      {  $sql_data.=$Where.'c.'.$row_TREE["FILTER"];
         $Where=' and ';
      }
      if ($MASK<>'')                                 //Фильтр пользователя
      {  $sql_data.=$Where.'c.'.$MASK;
         $Where=' and ';
      }

     //if($row_TREE["ID_ORDER"]<>'')
     //   $sql_data.=' order by '.$row_TREE["ID_ORDER"];
      $sql_data.=' order by f.displayOrder, c.'.$X_COLUMN_FIELD[0];   //$row_FORM["COLUMN_FIELD"]

      $result_data=mysql_query($sql_data);
      $num_results_data = mysql_num_rows($result_data);
      echo_pp(&$row_TREE,$sql_data);    ///
      if ($num_results_data>0)
      {  $z=0;      	 $row_data = mysql_fetch_array($result_data);   //Взять первую запись данных
      	 echo_pp(&$row_TREE,'row_data 2='.$row_data['id_fond'].' 3='.$row_data['date_begin'].' 5='.$row_data['cost'] ); //     	 echo_pp(&$row_TREE,'row_data 2='.$row_data[2].' 3='.$row_data[3].' 5='.$row_data[5] );
      }
      */
    }


    //-----------------------------------------------------------ЗАПОЛНЕНИЕ построчно
            if ($sql_T->num>0)             //Зависимая форма                        ////2010 12 09 Ввод особых условий расселения
		         $where_in.=' and '.$row_TREE["ID_COLUMN"].'="'.$_GET['in'].'"';
            else $where_in=' and '.$row_TREE["ID_COLUMN"].' IS NULL';

    for ($j=0; $j<$num_results_Y; $j++) //---------по Y
    {   if ($j%2==1) { $bgcolor='bgcolor="#CCFFCC"';  $class='fil1'; }
        else         { $bgcolor='bgcolor="white"';   $class='fil2'; }

        $row_Y = mysql_fetch_array($result_Y);
        echo '<tr><td '.$width_Y.' '.$bgcolor.'>';  //Первая колонка
        echo $row_Y[$row_FORM["SOURCE_FIELD"]];         //Имя поля или название самого поля

        for ($i=0; $i<count($X_SOURCE_DATA); $i++) //---------по X
        {
            echo '<td '.$width.' '.$bgcolor.' align="center">';

            $sql_new=new Tsql ('select * from '.$row_TREE['ID_TABLE']
                             .' where '.$row_FORM['COLUMN_FIELD'].'="'.$row_Y[$row_FORM['SOURCE_ID']].'"'
                             .' and '.$X_COLUMN_FIELD[$i].'="'.$X_SOURCE_ID_DATA[$i].'"'.$where_in
                              );
            //echo_pp(&$row_TREE,'$sql_new='.$sql_new->sql);      ////
            if ( $sql_new->num=1)
            {  $sql_new->NEXT();
               $data=$sql_new->row[$row_FD["COLUMN_FIELD"]];
            }
            else  $data='';
/*
            echo_pp(&$row_TREE,                                ///////
                    "num=$num_results_data"
                   ." row_FORM['SOURCE_ID']=".$row_FORM['SOURCE_ID']
                   ." row_Y[row_FORM['SOURCE_ID']]=".$row_Y[$row_FORM['SOURCE_ID']]
                   ." row_FORM['COLUMN_FIELD']=".$row_FORM['COLUMN_FIELD']
                   ." row_data[row_FORM['COLUMN_FIELD']]=".$row_data[$row_FORM['COLUMN_FIELD']]
                   ." X_SOURCE_DATA[i]=".$X_SOURCE_DATA[$i]
                   ." X_COLUMN_FIELD[i]=".$X_COLUMN_FIELD[$i]
                   ." row_data[X_COLUMN_FIELD[i]]=".$row_data[$X_COLUMN_FIELD[$i]]
                    );
*/
/*
            //--------------взять данные
            if ($num_results_data>0
            and $row_Y[$row_FORM["SOURCE_ID"]]==$row_data[$row_FORM["COLUMN_FIELD"]]  //Y
            and $X_SOURCE_DATA[$i]==$row_data[$X_COLUMN_FIELD[$i]])      //X
            {
              $data=$row_data[$row_FD["COLUMN_FIELD"]];
              $z++;
              if($z<$num_results_data)
                 $row_data = mysql_fetch_array($result_data);            }
            else $data='';
*/
            switch ($row_FD["TYPE_FIELD"])
            { case 'bool':
                           break;
              case 'date':
                           break;
              case 'cbox':
                            echo'<select   class="'.$class.'"'
                            .' name="'.$row_FD["COLUMN_FIELD"].':'.$X_SOURCE_DATA[$i].':'.$row_Y[$row_FORM["SOURCE_ID"]].'"'
                            .'>';
					        echo'<option value = "">'.''.'</option>';
					         $CBOX=explode(",",$row_FD["SOURCE_FILTER"]);
					         sort($CBOX);  reset($CBOX);
					         for($k=0; $k<count($CBOX); $k++)
					         {
					           if($CBOX[$k]==$data)    //Значение поля совпадает
						       echo'<option selected="selected" value = "'.$CBOX[$k].'">'.$CBOX[$k].'</option>';
						       else
						       echo'<option value = "'.$CBOX[$k].'">'.$CBOX[$k].'</option>';
					         }
					         echo'</select>';
                           break;                                 //$X_SOURCE_ID_DATA    -< $X_SOURCE_DATA
              default:                                            // 0-   1-date  2-
                           echo '<input class="'.$class.'"'
                                .' name="'.$row_FD["COLUMN_FIELD"].':'.$X_SOURCE_ID_DATA[$i].':'.$row_Y[$row_FORM["SOURCE_ID"]].'"'
                                .' size="'.$w.'" value="'.$data.'"'
                                .' align="middle"'      //right
                                //.'border=0'
                                .' alt="'.$row_Y[$row_FORM["SOURCE_FIELD"]].' '.$X_SOURCE_DATA[$i].'"'
                                .' />';

                           break;            } //switch        } //for X    } //for Y
  } //if Y
 } //status
 SHOW_tfoot(count($X_COLUMN_FIELD)+1,1,1,1);
 ?>
</table>
</form>
</div>
<?
} //end


function FORM_table_XYi_post(&$row_TREE)
{
//--------------------------------------Получить инфу по маске
        $MASK='';          //$MASK[1]-значение
        $MASK_DEL='';      //выражение
        $MASK_FIELD='';    //поле
        $uPARENT='';
        $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));

        $sql_FND=new Tsql('select * from _FIND where USER="'.$user.'" and PARAGRAF="'.$row_TREE["PARAGRAF"].'"');
        echo_pp(&$row_TREE,'sql_FND->sql='.$sql_FND->sql);  ///
        if ($sql_FND->num>0)   //Есть запись о фильтре
        {
           $sql_FND->NEXT();
           $uPARENT=$sql_FND->row['PARENT'];    //Если пусто - это главная таблица
           //-----------------------проверяет - если это МАСКА -  PARENT фильтр (одного поля) и наличие поля
           if ($uPARENT<>'')
           { if (isFIELD($sql_FND->row['FIELD_DATA'], $row_TREE['ID_TABLE'])==true)
             {
               $MASK_DEL=$sql_FND->row['FINDER'];
               $MASK=explode('"',$sql_FND->row['FINDER']);              // значение $MASK[1] Это выражение - через = и ""
               $MASK_FIELD=$sql_FND->row['FIELD_DATA'];    //это название одиночного поля
                      //   echo_pp(&$row_TREE,'MASK0='.$MASK);

             }
           }
        }
        //===============================================================   МАСКА дополнительных полей выбора
        $STR_FLT=''; $AND=' '; $COMA=','; $F1='';  $F2='';
        $sql_FILTER='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" and MASTER in ("FILTER") and VISIBLE=1 order by displayOrder';
        $sql_FLT=new Tsql($sql_FILTER);
        for ($i=0; $i<$sql_FLT->num; $i++)          //Есть запись о фильтре
        {   $sql_FLT->NEXT();        	if ($i==0) continue;
        	$Fname=$sql_FLT->row["COLUMN_FIELD"];
        	$Fdata=$_POST[$Fname];
            $STR_FLT.=$AND.$Fname.'="'.$Fdata.'"';          //для DELETE
            $F1.=$COMA.$Fname;                              //Для INSERT
            $F2.=$COMA.'"'.$Fdata.'"';
            $AND=' AND ';
        }
        echo_pp(&$row_TREE,"STR_FLT=$STR_FLT");
      //-------------------------------------------------------------
    $status=0;
//------------------------------------------------------------------------XXX
    $sql_FX='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" and MASTER in ("Xi") and VISIBLE=1 order by displayOrder';
    $result_FX=mysql_query($sql_FX);
    $num_results_FX = mysql_num_rows($result_FX);
    echo_pp(&$row_TREE,'$sql_FX='.sql_FX);    ///
    if($num_results_FX>0)                            //row_FX  row_FY
    { $row_FX = mysql_fetch_array($result_FX);
    }
    else $status=-1;
//------------------------------------------------------------------------YYY
 if ($status==0)
 {
    $sql_FY='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" and MASTER in ("Y") and VISIBLE=1 order by displayOrder';
    $result_FY=mysql_query($sql_FY);
    $num_results_FY = mysql_num_rows($result_FY);
    echo_pp(&$row_TREE,'$sql_FY='.$sql_FY);    ///
    if($num_results_FY>0)                            //row_FX  row_FY
    { $row_FY = mysql_fetch_array($result_FY);
    }
    else $status=-2;
 }
//------------------------------------------------------------------------ZZZ
 if ($status==0)
 {
  $sql_FD='select * from _FORM where PARAGRAF="'.$row_TREE["PARAGRAF"].'" and MASTER in ("Z") and VISIBLE=1 order by displayOrder';
  $result_FD=mysql_query($sql_FD);
  $num_results_FD = mysql_num_rows($result_FD);
  echo_pp(&$row_TREE,'$sql_FD='.$sql_FD);    ///
  if($num_results_FD>0)                            //row_FX  row_FY
  {   $row_FD = mysql_fetch_array($result_FD);      //Описание поля Z - может быть теxt bool cbox
      //----------------удалить старые значения
      $Where='';
      $and=' where ';
      if ($row_TREE["parent_TABLE"]<>"")         //маска выбора
      {   $Where.=$and.$row_TREE["ID_COLUMN"].' = "'.$_GET["in"].'"';
          $and=' and ';
      }
      if ($row_TREE["FILTER"]<>"")                   //Фильтер дополнительный в _TREE
      {  $Where.=$and.$row_TREE["FILTER"];
         $and=' and ';
      }
          echo_pp(&$row_TREE,'$MASK_DEL='.$MASK_DEL); //
          if ($MASK_DEL>'')
          { $Where.=$and.$MASK_DEL;              //Фильтр пользователя
            $and=' and ';
          }
          if ($STR_FLT>'')
          { $Where.=$and.$STR_FLT;              //Фильтр пользователя
            $and=' and ';
          }
          if($row_TREE["kind_FIND"] and $MASK_DEL=='')    //Только в разрезе маски
          $status=-10;
   if ($status==0)
   {
//------------------------------- Если поле по X дате -> удалять промежуток  из базы значений

	     if (array_key_exists('MIN_DATE', $_POST)
	     and array_key_exists('MAX_DATE', $_POST))
	     {	     	 $Where.=$and.$row_FX['COLUMN_FIELD'].'>="'.$_POST['MIN_DATE']
	     	    .'" and '.$row_FX['COLUMN_FIELD'].'<="'.$_POST['MAX_DATE'].'"';	     }
//-------------------------------

         $SQL='delete FROM '.$row_TREE["ID_TABLE"].$Where;
         //echo_pp(&$row_TREE,"sql_FND->row['FINDER']=".$sql_FND->row['FINDER']);
         echo_pp(&$row_TREE,'DELETE='.$SQL); //

         if(!mysql_query($SQL))
         {   echo "\n Ошибка DELETE";
             $status=-3;      //производилось удаление записи
         }

      //----------------дописать новые значения
     if ($status==0)
     {
      for ( $i=0; $i<count($_POST);$i++)        //Обход по полям формы
      {  $pst=each($_POST);
         if($pst[1]>'')              //value
         { $name=explode(':',$pst[0]);               //$name[1]-X $name[2]-Y
           if($name[0]==$row_FD["COLUMN_FIELD"])
           { echo_pp(&$row_TREE,$pst[0].'='.$pst[1].'->'.$name[1].':'.$name[2]);

             $STR='insert into '.$row_TREE["ID_TABLE"].' (';
             $DAT='value (';
             $SMC=' ';       //это в дальнейшем запятая

             //-----------------------Фильтер дополнительный в _TREE
             if  ($row_TREE['FILTER']<>'')
			 { $aFLT=explode(',',$row_TREE['FILTER']);    //разбор на аргументы
			    for ($n=0; $n<count($aFLT); $n++)
			    {  $FLT=explode('=',$aFLT[$n]);
			       if (count($FLT)==2)         //Фильтр только одного поля через равно
			       {
			     	$STR.=$SMC.$FLT[0];
			     	$DAT.=$SMC.'"'.$FLT[1].'"';
			     	$SMC=',';
			       }
			    }
			 }
             //-----------------------маска объекта
             if ($MASK_FIELD<>'')          //Установлена маска на ветку
             {
               $STR.=$SMC.$MASK_FIELD;
               $DAT.=$SMC.'"'.$MASK[1].'"';
               $SMC=',';
             }
             //-----------------------in на таблицу
             if  ($row_TREE['parent_TABLE']<>''
             and (array_key_exists('in', $_GET))
             and ($_GET['in']>0))
             {   $STR.=$SMC.$row_TREE['ID_COLUMN'];
                 $DAT.=$SMC.'"'.$_GET['in'].'"';
                 $SMC=',';
             }

             //------------------------X
             $STR.=$SMC.$row_FX["COLUMN_FIELD"];
             $DAT.=$SMC.'"'.$name[1].'"';
             $SMC=',';
             //------------------------Y
             $STR.=$SMC.$row_FY["COLUMN_FIELD"];
             $DAT.=$SMC.'"'.$name[2].'"';
             //------------------------Z
             $STR.=$SMC.$row_FD["COLUMN_FIELD"];
             $DAT.=$SMC.'"'.$pst[1].'"';
             //=====================================================
             $STR.=$F1.') '.$DAT.$F2.')';
             echo_dd(&$row_TREE,$STR);
             if(!mysql_query($STR))          //Выполнить INSERT
                 echo "\n <p> Ошибка INSERT</p>";

           }    //name
         }  //value
      } //for
     } // $status==0  после удаления
   } //row Z
  } // $status==0 маска
 }  // $status==0
} //end


?>
</html>
