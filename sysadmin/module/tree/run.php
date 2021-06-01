<html xmlns="http://www.w3.org/1999/xhtml">
<?php

//===================RUN===========
// 	row_tree-<_TREE  запись заголовка формы


function FORM_run(&$row_TREE,&$ROW_role)
{
// показать форму                                                                                         //onsubmit="return false;"
?>
<!--
  <hr align="center" width="600";
  <tr>
    <td style="padding-right: 10px"><?=$row_TREE["PARAGRAF"]?></td>
    <td style="padding-right: 10px"><?=$row_TREE["TYPE_FORM"]?></td>
  </tr>

  <tr>
    <td style="padding-right: 10px"><?=$row_TREE["sys_TEXT"]?></td>
  </tr>
-->
<?php
//  $RUN=$_SERVER["DOCUMENT_ROOT"].'/sysadmin/run/'.$row_TREE["FILTER"].'.php';
// Разбор строки запуска
  //echo "<p>PARRAM=$PARRAM HBS=$HBS</p>";

  $PROG=explode('?',$row_TREE["FILTER"]);
  $PARAM='';
  $DB='?';
  //echo '<p>'.count($PROG).'</p>';
  if (count($PROG)>1) // Заданы переменные запуска GET - нужно читать фильтр или взять из переменной $_GET['in']
  {
       // $MASK=0;          //->> устарело $MASK[1]-значение
       // $uPARENT='';
    //echo '<pre>'.print_r($_GET,true).'</pre>';
    if (array_key_exists('in',$_GET))      //из переменной
    { $PARAM='&'.$PROG[1].'='.$_GET['in'];
    }
    else
    {
        $user=htmlspecialchars(trim($_SERVER['PHP_AUTH_USER']));
        $findM = new find_mask($user);
        $findM->Get_FIND(&$row_TREE);   // Заполнить массив фильтрами _FIND
        $MASK=$findM->Get_FIND_MASK();
        //echo "<p/>MASK=$MASK";
        //echo '<pre>PROG[1]='.print_r($PROG[1],true).'</pre>';
        //echo '<pre>findM='.print_r($findM,true).'</pre>';
        $DATA=$findM->getFieldData($PROG[1]);
        $NAME=$findM->Get_FIND_HEAD();
        /*
        $sql_FND=new Tsql('select * from _FIND where USER="'.$user.'" and PARAGRAF="'.$row_TREE["PARAGRAF"].'"');
        //echo '<p>'.'sql_FND->sql='.$sql_FND->sql.' num='.$sql_FND->num.'</p>';  ///
        if ($sql_FND->num>0)   //Есть запись о фильтре
        {
           $sql_FND->NEXT();
           $uPARENT=$sql_FND->row['PARENT'];    //Если пусто - это главная таблица
           //-----------------------проверяет - если это МАСКА -  PARENT фильтр (одного поля) и наличие поля
           //echo '<p> uPARENT='.$uPARENT.'</p>';   ////
           if ($uPARENT<>'')
           {
               //$MASK=explode('"',$sql_FND->row['FINDER']);              // значение $MASK[1] Это выражение - через = и ""
               $MASK=$sql_FND->row['FINDER'];
               //echo '<p> FINDER='.$sql_FND->row['FINDER'].'</p>';
           }
        }
         * 
         */
        if ($DATA<>'')
            $PARAM='&DB='.$_GET['DB'].'&'.$PROG[1].'='.$DATA.'&name='.$NAME;
     } // из фильтра
     if ($PARAM=='')$PARAM='&'.$_SERVER['QUERY_STRING'];
  }
  if ($PARAM=='')$DB='?DB='.$_GET['DB'];

   //echo '<p>'.'http://'.$_SERVER['HTTP_HOST'].' | '.$_SERVER['REQUEST_URI'].'</p>';
  //$RUN='http://'.$_SERVER['HTTP_HOST'].'/sysadmin/run/'.$PROG[0].'.php'.$DB.$PARAM;           //помещать параметры в глобальную переменную - уйти от http
  $RUN='run/'.$PROG[0].'.php';
  echo_pp(&$row_TREE,$RUN);
  include_once ($RUN);


  //echo '<p>'.$RUN.'</p>';
  if ( $PARAM=='')
  {  
          if ($ROW_role!=0) {
              $styleH='style="background-color:'.$ROW_role['color1'].'; background-image:url();"';
              $styleF='style="background-color:'.$ROW_role['color2'].'; background-image:url();"';
          }
          else { $styleH=''; $styleF=''; }
?>
<div id="main">
<form id="MS" enctype="multipart/form-data" action=<? echo (MODUL.dTREE().dFORM.$row_TREE["PARAGRAF"]); ?> name="RUN"  method="post" class="theform" >
<input type="hidden" name="do" value="<? echo($row_TREE["PARAGRAF"]); ?>" />

  <table id="tbl" cellspacing="0" <?=$bgcolor ?> class="theform" align="left" border="1">
  <caption <?=$style?>><div style="padding:3px;"><?=$row_TREE["PARAGRAF"].' '.$row_TREE["NAME"]?></div></caption>
<?

  echo '<caption>'.$row_TREE["sys_TEXT"].'</caption>';
  echo '<caption>'.$RUN.'</caption>';

  //echo '<tr><td>'.$RUN;
  //echo_pp(&$row_TREE,$RUN);
  RUN_($PARAM,&$row_TREE,&$ROW_role);
  SHOW_tfoot(7,0,0,1);
?>
	</table>
</form>
</div>
<?php
  }
  else
  {
    //echo_pp(&$row_TREE,$RUN);    ///
    RUN_($PARAM,&$row_TREE,&$ROW_role);
?>
<!--
  <SCRIPT>
  someTimeout = 000;  редирект через 1 секунды   1000
  window.open("document.location = '<?=$RUN?>';",'test2',
  '');
  </SCRIPT>
  -->
<?php
  //exit();
  }
  return true;
}


?>
</html>
